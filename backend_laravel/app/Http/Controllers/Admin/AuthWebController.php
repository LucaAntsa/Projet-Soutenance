<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AuthWebController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    public function showRegisterForm()
    {
        $hasAdmin = User::whereHas('role', function ($query) {
            $query->where('name', 'admin');
        })->exists();

        if ($hasAdmin) {
            $roles = Role::where('name', 'expert')->get();
        } else {
            $roles = Role::whereIn('name', ['admin', 'expert'])->get();
        }

        return view('admin.auth.register', compact('roles', 'hasAdmin'));
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'role_id' => 'required|exists:roles,id',
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $selectedRole = Role::findOrFail($validated['role_id']);

        if (!in_array($selectedRole->name, ['admin', 'expert'])) {
            return back()
                ->withErrors([
                    'role_id' => 'Le rôle parent doit être créé depuis l’application mobile.',
                ])
                ->withInput();
        }

        $hasAdmin = User::whereHas('role', function ($query) {
            $query->where('name', 'admin');
        })->exists();

        if ($selectedRole->name === 'admin' && $hasAdmin) {
            return back()
                ->withErrors([
                    'role_id' => 'Un compte administrateur existe déjà. Vous ne pouvez plus créer un autre administrateur.',
                ])
                ->withInput();
        }

        User::create([
            'role_id' => $validated['role_id'],
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()
            ->route('admin.login')
            ->with('success', 'Compte créé avec succès. Vous pouvez maintenant vous connecter.');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if (!Auth::attempt($credentials)) {
            return back()
                ->withErrors([
                    'email' => 'Email ou mot de passe incorrect.',
                ])
                ->onlyInput('email');
        }

        $request->session()->regenerate();

        $user = User::with('role')->find(Auth::id());

        if (!$user || !$user->role || !in_array($user->role->name, ['admin', 'expert'])) {
            Auth::logout();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()
                ->route('admin.login')
                ->withErrors([
                    'email' => 'Vous n’êtes pas autorisé à accéder à l’interface web.',
                ]);
        }

        $this->sendTwoFactorCode($user);

        session([
            '2fa_user_id' => $user->id,
        ]);

        Auth::logout();

        return redirect()->route('admin.2fa.form');
    }

    public function showTwoFactorForm()
    {
        if (!session()->has('2fa_user_id')) {
            return redirect()->route('admin.login');
        }

        return view('admin.auth.two-factor');
    }

    public function verifyTwoFactor(Request $request)
    {
        $request->validate([
            'code' => 'required|digits:6',
        ]);

        $user = User::with('role')->find(session('2fa_user_id'));

        if (!$user) {
            return redirect()
                ->route('admin.login')
                ->withErrors([
                    'email' => 'Session expirée. Veuillez vous reconnecter.',
                ]);
        }

        if (!$user->role || !in_array($user->role->name, ['admin', 'expert'])) {
            session()->forget('2fa_user_id');

            return redirect()
                ->route('admin.login')
                ->withErrors([
                    'email' => 'Vous n’êtes pas autorisé à accéder à l’interface web.',
                ]);
        }

        if (
            !$user->two_factor_code ||
            !$user->two_factor_expires_at ||
            now()->greaterThan($user->two_factor_expires_at)
        ) {
            return back()
                ->withErrors([
                    'code' => 'Le code a expiré. Veuillez demander un nouveau code.',
                ]);
        }

        if ($request->code !== $user->two_factor_code) {
            return back()
                ->withErrors([
                    'code' => 'Code de vérification incorrect.',
                ]);
        }
        
            $user->two_factor_code = null;
            $user->two_factor_expires_at = null;
            $user->save();

        Auth::login($user);

        session()->forget('2fa_user_id');
        $request->session()->regenerate();

        return redirect()->route('admin.dashboard');
    }

    public function resendTwoFactorCode()
    {
        $user = User::find(session('2fa_user_id'));

        if (!$user) {
            return redirect()->route('admin.login');
        }

        $this->sendTwoFactorCode($user);

        return back()->with('success', 'Un nouveau code de vérification a été envoyé.');
    }

    private function sendTwoFactorCode(User $user): void
    {
        $code = (string) random_int(100000, 999999);

        $user->two_factor_code = $code;
        $user->two_factor_expires_at = now()->addMinutes(30);
        $user->save();

        Mail::raw(
            "Votre code de vérification est : {$code}\n\nCe code expire dans 30 minutes.",
            function ($message) use ($user) {
                $message->to($user->email)
                    ->subject('Code de vérification - Éducation Familiale');
            }
        );
    }

    public function showForgotPasswordForm()
    {
        return view('admin.auth.forgot-password');
    }

    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $user = User::with('role')
            ->where('email', $request->email)
            ->first();

        if (!$user || !$user->role || !in_array($user->role->name, ['admin', 'expert'])) {
            return back()->with('success', 'Si cette adresse existe, un lien de réinitialisation a été envoyé.');
        }

        $token = Str::random(64);

        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $user->email],
            [
                'token' => Hash::make($token),
                'created_at' => now(),
            ]
        );

        $resetUrl = route('admin.password.reset.form', [
            'token' => $token,
            'email' => $user->email,
        ]);

        Mail::raw(
            "Bonjour {$user->name},\n\nCliquez sur ce lien pour réinitialiser votre mot de passe :\n{$resetUrl}\n\nCe lien expire dans 60 minutes.",
            function ($message) use ($user) {
                $message->to($user->email)
                    ->subject('Réinitialisation du mot de passe - Éducation Familiale');
            }
        );

        return back()->with('success', 'Si cette adresse existe, un lien de réinitialisation a été envoyé.');
    }

    public function showResetPasswordForm(Request $request, string $token)
    {
        return view('admin.auth.reset-password', [
            'token' => $token,
            'email' => $request->email,
        ]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'token' => 'required|string',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $resetRecord = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->first();

        if (!$resetRecord) {
            return back()->withErrors([
                'email' => 'Lien de réinitialisation invalide.',
            ]);
        }

        $createdAt = Carbon::parse($resetRecord->created_at);

        if ($createdAt->addMinutes(60)->isPast()) {
            DB::table('password_reset_tokens')
                ->where('email', $request->email)
                ->delete();

            return back()->withErrors([
                'email' => 'Le lien de réinitialisation a expiré.',
            ]);
        }

        if (!Hash::check($request->token, $resetRecord->token)) {
            return back()->withErrors([
                'email' => 'Lien de réinitialisation invalide.',
            ]);
        }

        $user = User::with('role')
            ->where('email', $request->email)
            ->first();

        if (!$user || !$user->role || !in_array($user->role->name, ['admin', 'expert'])) {
            return redirect()
                ->route('admin.login')
                ->withErrors([
                    'email' => 'Vous n’êtes pas autorisé à accéder à l’interface web.',
                ]);
        }

        $user->update([
            'password' => Hash::make($request->password),
            'two_factor_code' => null,
            'two_factor_expires_at' => null,
        ]);

        DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->delete();

        return redirect()
            ->route('admin.login')
            ->with('success', 'Mot de passe réinitialisé avec succès. Vous pouvez maintenant vous connecter.');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        session()->forget('2fa_user_id');

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
}
