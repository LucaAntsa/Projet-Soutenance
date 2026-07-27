<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthWebController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ModuleEducatifController;
use App\Http\Controllers\Admin\ConseilController;
use App\Http\Controllers\Admin\QuizAdminController;
use App\Http\Controllers\Admin\UserAdminController;

Route::get('/', function () {
    return redirect()->route('admin.login');
});

Route::get('/login', function () {
    return redirect()->route('admin.login');
})->name('login');

Route::get('/admin/login', [AuthWebController::class, 'showLoginForm'])
    ->name('admin.login');

Route::post('/admin/login', [AuthWebController::class, 'login'])
    ->name('admin.login.submit');

Route::get('/admin/register', [AuthWebController::class, 'showRegisterForm'])
    ->name('admin.register');

Route::post('/admin/register', [AuthWebController::class, 'register'])
    ->name('admin.register.submit');

/*
|--------------------------------------------------------------------------
| Mot de passe oublié admin
|--------------------------------------------------------------------------
*/
Route::get('/admin/forgot-password', [AuthWebController::class, 'showForgotPasswordForm'])
    ->name('admin.password.forgot');

Route::post('/admin/forgot-password', [AuthWebController::class, 'sendResetLink'])
    ->name('admin.password.email');

Route::get('/admin/reset-password/{token}', [AuthWebController::class, 'showResetPasswordForm'])
    ->name('admin.password.reset.form');

Route::post('/admin/reset-password', [AuthWebController::class, 'resetPassword'])
    ->name('admin.password.reset');

/*
|--------------------------------------------------------------------------
| Vérification 2FA admin
|--------------------------------------------------------------------------
*/
Route::get('/admin/2fa', [AuthWebController::class, 'showTwoFactorForm'])
    ->name('admin.2fa.form');

Route::post('/admin/2fa', [AuthWebController::class, 'verifyTwoFactor'])
    ->name('admin.2fa.verify');

Route::post('/admin/2fa/resend', [AuthWebController::class, 'resendTwoFactorCode'])
    ->name('admin.2fa.resend');

/*
|--------------------------------------------------------------------------
| Langue et thème admin
|--------------------------------------------------------------------------
*/
Route::get('/admin/lang/{locale}', function ($locale) {
    if (in_array($locale, ['fr', 'mg'])) {
        session(['admin_locale' => $locale]);
    }

    return back();
})->name('admin.lang');

Route::get('/admin/theme/{theme}', function ($theme) {
    if (in_array($theme, ['light', 'dark'])) {
        session(['admin_theme' => $theme]);
    }

    return back();
})->name('admin.theme');

/*
|--------------------------------------------------------------------------
| Déconnexion
|--------------------------------------------------------------------------
*/
Route::post('/admin/logout', [AuthWebController::class, 'logout'])
    ->name('admin.logout');

Route::prefix('admin')
    ->middleware(['auth', 'role:admin,expert'])
    ->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'index'])
            ->name('admin.dashboard');

        Route::get('/modules', [ModuleEducatifController::class, 'index'])
            ->name('admin.modules.index');

        Route::get('/modules/create', [ModuleEducatifController::class, 'create'])
            ->name('admin.modules.create');

        Route::post('/modules', [ModuleEducatifController::class, 'store'])
            ->name('admin.modules.store');

        Route::get('/modules/{id}/edit', [ModuleEducatifController::class, 'edit'])
            ->name('admin.modules.edit');

        Route::put('/modules/{id}', [ModuleEducatifController::class, 'update'])
            ->name('admin.modules.update');

        Route::delete('/modules/{id}', [ModuleEducatifController::class, 'destroy'])
            ->name('admin.modules.destroy');

        Route::get('/conseils', [ConseilController::class, 'index'])
            ->name('admin.conseils.index');

        Route::get('/conseils/create', [ConseilController::class, 'create'])
            ->name('admin.conseils.create');

        Route::post('/conseils', [ConseilController::class, 'store'])
            ->name('admin.conseils.store');

        Route::get('/conseils/{id}/edit', [ConseilController::class, 'edit'])
            ->name('admin.conseils.edit');

        Route::put('/conseils/{id}', [ConseilController::class, 'update'])
            ->name('admin.conseils.update');

        Route::delete('/conseils/{id}', [ConseilController::class, 'destroy'])
            ->name('admin.conseils.destroy');

        Route::get('/quizzes', [QuizAdminController::class, 'index'])
            ->name('admin.quizzes.index');

        Route::get('/quizzes/create', [QuizAdminController::class, 'create'])
            ->name('admin.quizzes.create');

        Route::post('/quizzes', [QuizAdminController::class, 'store'])
            ->name('admin.quizzes.store');

        Route::get('/quizzes/{id}', [QuizAdminController::class, 'show'])
            ->name('admin.quizzes.show');

        Route::post('/quizzes/{id}/questions', [QuizAdminController::class, 'addQuestion'])
            ->name('admin.quizzes.questions.store');

        Route::delete('/quizzes/{id}', [QuizAdminController::class, 'destroy'])
            ->name('admin.quizzes.destroy');
    });

Route::prefix('admin')
    ->middleware(['auth', 'role:admin'])
    ->group(function () {

        Route::get('/users', [UserAdminController::class, 'index'])
            ->name('admin.users.index');

        Route::get('/users/{id}/edit', [UserAdminController::class, 'edit'])
            ->name('admin.users.edit');

        Route::put('/users/{id}', [UserAdminController::class, 'update'])
            ->name('admin.users.update');

        Route::delete('/users/{id}', [UserAdminController::class, 'destroy'])
            ->name('admin.users.destroy');
    });
