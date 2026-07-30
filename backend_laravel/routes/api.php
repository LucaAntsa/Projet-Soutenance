<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ConseilController;
use App\Http\Controllers\Api\DeviceTokenController;
use App\Http\Controllers\Api\ModuleEducatifController;
use App\Http\Controllers\Api\ProgressionController;
use App\Http\Controllers\Api\QuizController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Routes publiques d’authentification
|--------------------------------------------------------------------------
*/

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

/*
|--------------------------------------------------------------------------
| Réinitialisation du mot de passe
|--------------------------------------------------------------------------
|
| Limitation à 5 requêtes par minute pour éviter les abus.
|
*/

Route::middleware('throttle:5,1')->group(function (): void {
    Route::post('/forgot-password', [
        AuthController::class,
        'forgotPassword',
    ]);

    Route::post('/reset-password', [
        AuthController::class,
        'resetPassword',
    ]);
});

/*
|--------------------------------------------------------------------------
| Routes protégées par Laravel Sanctum
|--------------------------------------------------------------------------
*/

Route::middleware('auth:sanctum')->group(function (): void {
    /*
    |--------------------------------------------------------------------------
    | Profil et déconnexion
    |--------------------------------------------------------------------------
    */

    Route::get('/profile', [
        AuthController::class,
        'profile',
    ]);

    Route::post('/logout', [
        AuthController::class,
        'logout',
    ]);

    /*
    |--------------------------------------------------------------------------
    | Modules éducatifs
    |--------------------------------------------------------------------------
    */

    Route::get('/modules', [
        ModuleEducatifController::class,
        'index',
    ]);

    Route::get('/modules/{id}', [
        ModuleEducatifController::class,
        'show',
    ]);

    Route::post('/modules', [
        ModuleEducatifController::class,
        'store',
    ]);

    Route::put('/modules/{id}', [
        ModuleEducatifController::class,
        'update',
    ]);

    Route::delete('/modules/{id}', [
        ModuleEducatifController::class,
        'destroy',
    ]);

    /*
    |--------------------------------------------------------------------------
    | Conseils
    |--------------------------------------------------------------------------
    */

    Route::get('/conseils', [
        ConseilController::class,
        'index',
    ]);

    Route::get('/conseils/{id}', [
        ConseilController::class,
        'show',
    ]);

    Route::post('/conseils', [
        ConseilController::class,
        'store',
    ]);

    Route::put('/conseils/{id}', [
        ConseilController::class,
        'update',
    ]);

    Route::delete('/conseils/{id}', [
        ConseilController::class,
        'destroy',
    ]);

    /*
    |--------------------------------------------------------------------------
    | Quiz
    |--------------------------------------------------------------------------
    */

    Route::get('/quizzes', [
        QuizController::class,
        'index',
    ]);

    Route::get('/modules/{moduleId}/quizzes', [
        QuizController::class,
        'getByModule',
    ]);

    Route::get('/quizzes/{id}', [
        QuizController::class,
        'show',
    ]);

    Route::post('/quizzes', [
        QuizController::class,
        'store',
    ]);

    /*
    |--------------------------------------------------------------------------
    | Questions et réponses
    |--------------------------------------------------------------------------
    */

    Route::post('/questions', [
        QuizController::class,
        'addQuestion',
    ]);

    Route::post('/answers', [
        QuizController::class,
        'addAnswer',
    ]);

    /*
    |--------------------------------------------------------------------------
    | Soumission des quiz et scores
    |--------------------------------------------------------------------------
    */

    Route::post('/quizzes/{id}/submit', [
        QuizController::class,
        'submit',
    ]);

    Route::get('/my-scores', [
        QuizController::class,
        'myScores',
    ]);

    /*
    |--------------------------------------------------------------------------
    | Progression
    |--------------------------------------------------------------------------
    */

    Route::get('/progressions', [
        ProgressionController::class,
        'index',
    ]);

    Route::post('/progressions', [
        ProgressionController::class,
        'storeOrUpdate',
    ]);

    Route::post('/modules/{id}/complete', [
        ProgressionController::class,
        'completeModule',
    ]);

    /*
    |--------------------------------------------------------------------------
    | Notifications
    |--------------------------------------------------------------------------
    */

    Route::post('/device-token', [
        DeviceTokenController::class,
        'store',
    ]);
});
