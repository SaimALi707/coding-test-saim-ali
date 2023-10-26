<?php

use App\Http\Controllers\PhaseController;
use App\Http\Controllers\PriorityController;
use App\Http\Controllers\TaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//Route::middleware('auth:sanctum')->get('/tasks', [App\Http\Controllers\TaskController::class, 'index']);
//Route::middleware('auth:sanctum')->get('/tasks/{task}', [App\Http\Controllers\TaskController::class, 'show']);
//Route::middleware('auth:sanctum')->put('/tasks/{task}', [App\Http\Controllers\TaskController::class, 'update']);
//Route::middleware('auth:sanctum')->post('/tasks', [App\Http\Controllers\TaskController::class, 'store']);
//Route::middleware('auth:sanctum')->delete('/tasks/{task}', [App\Http\Controllers\TaskController::class, 'destroy']);

//Route::middleware('auth:sanctum')->get('/users', [App\Http\Controllers\TaskController::class, 'users']);

//Route::middleware('auth:sanctum')->get('/phases/{phase}', [App\Http\Controllers\PhaseController::class, 'show']);
//Route::middleware('auth:sanctum')->patch('/phases/{phase}', [App\Http\Controllers\PhaseController::class, 'update']);
//Route::middleware('auth:sanctum')->delete('/phases/{phase}', [App\Http\Controllers\PhaseController::class, 'destroy']);

//Route::middleware('auth:sanctum')->get('/priorities', [App\Http\Controllers\PriorityController::class, 'index']);


/*
 * ***************************************************************
 * ******** Simplify the routes using api resource. **************
 * ***************************************************************
 */
Route::middleware('auth:sanctum')->group(function () {

    Route::get('/users', [TaskController::class, 'users']);

    Route::apiResource('/tasks', TaskController::class)->except(['edit', 'create']);
    Route::apiResource('/phases', PhaseController::class)->only(['show', 'update', 'destroy']);
    Route::apiResource('/priorities', PriorityController::class)->only(['index']);
});
