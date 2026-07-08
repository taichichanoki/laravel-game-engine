<?php

use App\Http\Controllers\GameController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SaveController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\AdminSceneController;
use App\Http\Controllers\AssetController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AuthController::class, 'showTitle']);

Route::middleware(['guest', 'nocache'])->group(function () {

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::middleware(['auth', 'nocache'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::delete('/account', [AuthController::class, 'deleteAccount'])->name('account.delete');

    Route::get('/game', [GameController::class, 'index']);
    Route::get('/api/scenes/{id}', [GameController::class, 'getScene']);

    Route::post('/game/save', [SaveController::class, 'save'])->name('game.save');

    Route::get('/game/load/{slot}', [SaveController::class, 'load']);

    Route::middleware('admin')->group(function () {
        Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');

        Route::resource('admin/users', AdminUserController::class)->names('admin.users');

        Route::resource('admin/scenes', AdminSceneController::class)->names('admin.scenes');

        Route::get('scene/{scene}/steps/create', [AdminSceneController::class, 'createStep'])->name('admin.scenes.createStep');
        Route::post('scene/{scene}/steps', [AdminSceneController::class, 'storeStep'])->name('admin.scenes.storeStep');

        Route::get('scene/{scene}/steps/{step}/edit', [AdminSceneController::class, 'editStep'])->name('admin.scenes.editStep');
        Route::put('scene/{scene}/steps/{step}', [AdminSceneController::class, 'updateStep'])->name('admin.scenes.updateStep');

        Route::delete('scene/{scene}/steps/{step}', [AdminSceneController::class, 'destroyStep'])->name('admin.scenes.destroyStep');

        Route::get('scene/{scene}/choices/create', [AdminSceneController::class, 'createChoice'])->name('admin.scenes.createChoice');
        Route::post('scene/{scene}/choices', [AdminSceneController::class, 'storeChoice'])->name('admin.scenes.storeChoice');

        Route::get('scene/{scene}/choices/{choice}/edit', [AdminSceneController::class, 'editChoice'])->name('admin.scenes.editChoice');
        Route::put('scene/{scene}/choices/{choice}', [AdminSceneController::class, 'updateChoice'])->name('admin.scenes.updateChoice');

        Route::delete('scene/{scene}/choices/{choice}', [AdminSceneController::class, 'destroyChoice'])->name('admin.scenes.destroyChoice');

        Route::resource('admin/assets', AssetController::class)->names('admin.assets');

        Route::get('admin/export-seeder', [AdminController::class, 'exportSeeder'])->name('admin.exportSeeder');
    });
});
