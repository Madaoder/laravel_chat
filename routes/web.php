<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\ChatController;
use App\Models\Chatroom;

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

Route::get('/', function () {
    return Inertia::render('Auth/Login', [
        'canResetPassword' => Route::has('password.request'),
        'status' => session('status'),
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/chat', function () {
    return Inertia::render('Chat/Container');
})->middleware(['auth', 'verified'])->name('chat');

Route::get('/newRoom', function () {
    return Inertia::render('Chat/RoomContainer');
})->middleware(['auth', 'verified'])->name('newRoom');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/chat/rooms', [ChatController::class, 'rooms']);
    Route::get('/chat/room/{roomId}/messages', [ChatController::class, 'messages']);
    Route::post('/chat/room/{roomId}/talk', [ChatController::class, 'talk']);
    Route::post('/chat/room/new', [ChatController::class, 'createRoom']);
    Route::get('/chat/room/{roomId}/hasP', [ChatController::class, 'hasPassword']);
    Route::post('/chat/room/{roomId}/check', [ChatController::class, 'checkRoom']);
});

require __DIR__ . '/auth.php';
