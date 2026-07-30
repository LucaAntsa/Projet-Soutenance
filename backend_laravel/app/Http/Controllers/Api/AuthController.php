<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Throwable;

class AuthController extends Controller
{
    /**
     * Créer un compte parent depuis l’application publique.
     */
    public function register(Request $request): JsonResponse
    {
        /*
         * Normaliser les données avant la validation.
         */
        $request->merge([
            'name' => trim((string) $request->input('name')),
            'email' => Str::lower(
                trim((string) $request->input('email'))
            ),
        ]);

        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:100',
            ],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                'unique:users,email',
            ],
            'password' => [
                'required',
                'string',
                'min:6',
                'confirmed',
            ],
        ]);

        /*
         * L’inscription publique doit toujours créer un parent.
         * Un client ne peut pas choisir admin ou expert.
         */
        $parentRole = Role::where('name', 'parent')->first();

        if (!$parentRole) {
            return response()->json([
                'message' =>
                    'Le rôle parent n’est pas configuré sur le serveur.',
            ], 500);
        }

        try {
            $user = DB::transaction(
                function () use ($validated, $parentRole): User {
                    return User::create([
                        'role_id' => $parentRole->id,
                        'name' => $validated['name'],
                        'email' => $validated['email'],
                        'password' => Hash::make(
                            $validated['password']
                        ),
                    ]);
                }
            );

            $token = $user
                ->createToken('mobile_token')
                ->plainTextToken;

            return response()->json([
                'message' => 'Compte créé avec succès.',
                'user' => $user->load('role'),
                'token' => $token,
            ], 201);
        } catch (Throwable $exception) {
            report($exception);

            return response()->json([
                'message' =>
                    'Impossible de créer le compte pour le moment.',
            ], 500);
        }
    }

    /**
     * Connecter un utilisateur.
     */
    public function login(Request $request): JsonResponse
    {
        $request->merge([
            'email' => Str::lower(
                trim((string) $request->input('email'))
            ),
        ]);

        $validated = $request->validate([
            'email' => [
                'required',
                'string',
                'email',
            ],
            'password' => [
                'required',
                'string',
            ],
        ]);

        $user = User::with('role')
            ->where('email', $validated['email'])
            ->first();

        if (
            !$user ||
            !Hash::check(
                $validated['password'],
                $user->password
            )
        ) {
            throw ValidationException::withMessages([
                'email' => [
                    'Adresse e-mail ou mot de passe incorrect.',
                ],
            ]);
        }

        $token = $user
            ->createToken('mobile_token')
            ->plainTextToken;

        return response()->json([
            'message' => 'Connexion réussie.',
            'user' => $user,
            'token' => $token,
        ]);
    }

    /**
     * Envoyer un code de réinitialisation par e-mail.
     */
    public function forgotPassword(Request $request): JsonResponse
    {
        $request->merge([
            'email' => Str::lower(
                trim((string) $request->input('email'))
            ),
        ]);

        $validated = $request->validate([
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
            ],
        ]);

        $email = $validated['email'];

        $genericMessage =
            'Si cette adresse existe, un code de réinitialisation a été envoyé.';

        $user = User::where('email', $email)->first();

        /*
         * Ne pas révéler si une adresse existe ou non.
         */
        if (!$user) {
            return response()->json([
                'message' => $genericMessage,
            ]);
        }

        /*
         * Générer un code numérique à six chiffres.
         */
        $code = (string) random_int(100000, 999999);

        /*
         * Enregistrer uniquement la version hachée du code.
         */
        DB::table('password_reset_tokens')->updateOrInsert(
            [
                'email' => $email,
            ],
            [
                'token' => Hash::make($code),
                'created_at' => now(),
            ],
        );

        try {
            Mail::raw(
                implode("\n", [
                    "Bonjour {$user->name},",
                    '',
                    'Vous avez demandé la réinitialisation de votre mot de passe.',
                    '',
                    "Votre code de vérification est : {$code}",
                    '',
                    'Ce code est valable pendant 10 minutes.',
                    '',
                    'Si vous n’êtes pas à l’origine de cette demande, ignorez ce message.',
                    '',
                    'Éducation Familiale',
                ]),
                function ($message) use ($user): void {
                    $message
                        ->to($user->email)
                        ->subject(
                            'Code de réinitialisation du mot de passe'
                        );
                },
            );

            Log::info(
                'Code de réinitialisation envoyé.',
                [
                    'user_id' => $user->id,
                    'email' => $user->email,
                ]
            );
        } catch (Throwable $exception) {
            /*
             * Supprimer le code si l’e-mail n’a pas été envoyé.
             */
            DB::table('password_reset_tokens')
                ->where('email', $email)
                ->delete();

            Log::error(
                'Échec de l’envoi du code de réinitialisation.',
                [
                    'user_id' => $user->id,
                    'exception' => get_class($exception),
                    'message' => $exception->getMessage(),
                ]
            );

            report($exception);

            return response()->json([
                'message' =>
                    'Impossible d’envoyer le code pour le moment.',
            ], 500);
        }

        return response()->json([
            'message' =>
                'Un code de réinitialisation a été envoyé à votre adresse e-mail.',
        ]);
    }

    /**
     * Vérifier le code et modifier le mot de passe.
     */
    public function resetPassword(Request $request): JsonResponse
    {
        $request->merge([
            'email' => Str::lower(
                trim((string) $request->input('email'))
            ),
            'code' => trim(
                (string) $request->input('code')
            ),
        ]);

        $validated = $request->validate([
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
            ],
            'code' => [
                'required',
                'digits:6',
            ],
            'password' => [
                'required',
                'string',
                'min:6',
                'confirmed',
            ],
        ]);

        $email = $validated['email'];

        $resetRequest = DB::table('password_reset_tokens')
            ->where('email', $email)
            ->first();

        if (!$resetRequest) {
            return response()->json([
                'message' => 'Code invalide ou expiré.',
            ], 422);
        }

        /*
         * Vérifier que le code n’a pas dépassé 10 minutes.
         */
        if (
            empty($resetRequest->created_at) ||
            Carbon::parse($resetRequest->created_at)
                ->addMinutes(10)
                ->isPast()
        ) {
            DB::table('password_reset_tokens')
                ->where('email', $email)
                ->delete();

            return response()->json([
                'message' =>
                    'Le code a expiré. Demandez un nouveau code.',
            ], 422);
        }

        /*
         * Comparer le code saisi avec le code haché.
         */
        if (
            !Hash::check(
                $validated['code'],
                $resetRequest->token
            )
        ) {
            return response()->json([
                'message' => 'Le code saisi est incorrect.',
            ], 422);
        }

        $user = User::where('email', $email)->first();

        if (!$user) {
            DB::table('password_reset_tokens')
                ->where('email', $email)
                ->delete();

            return response()->json([
                'message' => 'Utilisateur introuvable.',
            ], 404);
        }

        try {
            DB::transaction(
                function () use (
                    $user,
                    $validated,
                    $email
                ): void {
                    $user->update([
                        'password' => Hash::make(
                            $validated['password']
                        ),
                    ]);

                    /*
                     * Révoquer toutes les anciennes sessions mobiles.
                     */
                    $user->tokens()->delete();

                    /*
                     * Le code devient inutilisable après la réussite.
                     */
                    DB::table('password_reset_tokens')
                        ->where('email', $email)
                        ->delete();
                }
            );
        } catch (Throwable $exception) {
            report($exception);

            return response()->json([
                'message' =>
                    'Impossible de modifier le mot de passe pour le moment.',
            ], 500);
        }

        return response()->json([
            'message' =>
                'Mot de passe modifié avec succès. Vous pouvez maintenant vous connecter.',
        ]);
    }

    /**
     * Retourner le profil de l’utilisateur connecté.
     */
    public function profile(Request $request): JsonResponse
    {
        $user = $request->user();

        if (!$user) {
            return response()->json([
                'message' => 'Utilisateur non authentifié.',
            ], 401);
        }

        return response()->json([
            'user' => $user->load('role'),
        ]);
    }

    /**
     * Déconnecter uniquement la session actuelle.
     */
    public function logout(Request $request): JsonResponse
    {
        $user = $request->user();

        if (!$user) {
            return response()->json([
                'message' => 'Utilisateur non authentifié.',
            ], 401);
        }

        $currentToken = $user->currentAccessToken();

        if ($currentToken) {
            $currentToken->delete();
        }

        return response()->json([
            'message' => 'Déconnexion réussie.',
        ]);
    }
}
