<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;

Route::middleware('auth:sanctum')->group(function () {
  Route::apiResource('posts', PostController::class);
  Route::post('post-update/{id}', [PostController::class, 'update']);
  Route::get('export', [PostController::class, 'export'])->name('post.export');
  Route::post('import', [PostController::class, 'import'])->name('post.import');
  Route::get('import/file', [PostController::class, 'import_file']);
  
  
  Route::apiResource('users', UserController::class)->middleware('is.admin');
  Route::get('/user', function(Request $request){
    return $request->user();
  });

  Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');
  Route::post('user-update/{id}', [UserController::class, 'update']);
  Route::post('logout', [UserController::class, 'logout']);
  Route::get('user_id', function() {
    return Auth::user()->id;
  });
});

Route::post('login', [UserController::class, 'login']);

