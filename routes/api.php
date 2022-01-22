<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get(
    '/quiz{quiz}', [\App\Http\Controllers\QuizController::class, 'show']
);


Route::group([
    "prefix" => "quiz"
], function($router){
    Route::post('/', [\App\Http\Controllers\QuizController::class, 'store']);
    Route::get('/', [\App\Http\Controllers\QuizController::class, 'index']);
    Route::put('/{quiz}', [\App\Http\Controllers\QuizController::class, 'update']);
    Route::get('/{quiz}', [\App\Http\Controllers\QuizController::class, 'show']);
    Route::get('/{quiz}/questions', [\App\Http\Controllers\QuizController::class, 'questions']);
    Route::post('/{quiz}/unpublish', [\App\Http\Controllers\QuizController::class, 'unpublish']);
    Route::post('/{quiz}/publish', [\App\Http\Controllers\QuizController::class, 'publish']);
    Route::delete('/{quiz}', [\App\Http\Controllers\QuizController::class, 'destroy']);

});


Route::get('/question/{id}/choices', [\App\Http\Controllers\QuestionController::class, 'show']);


Route::group([
    "prefix" => "score"
], function($router){
    Route::get('/', [\App\Http\Controllers\ScoreController::class, 'index']);
    Route::get('/{score}', [\App\Http\Controllers\ScoreController::class, 'show']);
    Route::post('/', [\App\Http\Controllers\ScoreController::class, 'create']);
});


Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/user-profile', [AuthController::class, 'userProfile']);

});
