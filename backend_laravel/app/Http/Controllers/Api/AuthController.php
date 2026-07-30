<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Throwable;

class AuthController extends Controller
{
    /**
     * Créer un compte parent depuis l'application publique.
     */
    public function register(Request $request): JsonResponse
    {
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
         * L'inscription publique ne doit jamais accepter un rôle
         * envoyé par Flutter ou par un autre client HTTP.
         */
        $parentRole = Role::where('name', 'parent')->first();

        if (!$parentRole) {
            return response()->json([
                'message' => 'Le rôle parent n’est pas configuré sur le serveur.',
            ], 500);
        }

        try {
            $user = DB::transaction(function () use (
                $validated,
                $parentRole
            ): User {
                return User::create([
                    'role_id' => $parentRole->id,
                    'name' => trim($validated['name']),
                    'email' => Str::lower(trim($validated['email'])),
                    'password' => Hash::make($validated['password']),
                ]);
            });

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
                'message' => 'Impossible de créer le compte pour le moment.',
            ], 500);
        }
    }

    /**
     * Connecter un utilisateur.
     */
    public function login(Request $request): JsonResponse
    {
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

        $email = Str::lower(trim($validated['email']));

        $user = User::with('role')
            ->where('email', $email)
            ->first();

        if (
            !$user ||
            !Hash::check($validated['password'], $user->password)
        ) {
            throw ValidationException::withMessages([
                'email' => [
                    'Adresse e-mail ou mot de passe incorrect.',
                ],
            ]);
        }

        /*
         * Création d'un nouveau token Sanctum pour cette connexion.
         */
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
     * Retourner le profil de l'utilisateur connecté.
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
