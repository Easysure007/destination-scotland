<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\DestinationCommentController;
use App\Http\Controllers\DestinationController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [PublicController::class, 'index'])->name('landing');
Route::get('/all-destinations', [PublicController::class, 'destinations'])->name('destinations.list');
Route::get('/view/{destination}', [PublicController::class, 'destination'])->name('destination.view');
Route::post('/view/{destination}/comment', [PublicController::class, 'comment'])->name('destination.comment');

Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::resource('destinations', DestinationController::class);
    Route::get('destinations/{destination}/delete', [DestinationController::class, 'destroy'])->name('destinations.destroy');
    Route::get('destinations/{destination}/delete-file/{file}', [DestinationController::class, 'deleteFile'])->name('destinations.delete-file');

    Route::resource('users', UserController::class);
    Route::get('users/{user}/delete', [UserController::class, 'destroy'])->name('users.destroy');

    Route::resource('admins', AdminController::class);
    Route::get('admins/{admin}/delete', [AdminController::class, 'destroy'])->name('admins.destroy');

    Route::resource('comments', DestinationCommentController::class)
        ->only(['index', 'show']);
    Route::get('comments/{comment}/delete', [DestinationCommentController::class, 'destroy'])->name('comments.destroy');
    Route::post('comments/{comment}/reply', [DestinationCommentController::class, 'reply'])->name('comments.reply');
});
