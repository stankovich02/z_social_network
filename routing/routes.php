<?php

use NovaLite\Routing\Router;
/*Router::view('/profile', 'pages.client.profile');*/

Router::middleware([\App\Middlewares\IsNotLoggedIn::class])->group(function () {
    Router::get('/', [\App\Controllers\AuthController::class, 'index'])->name('start');
    Router::post('/register', [\App\Controllers\AuthController::class, 'register'])->name('register');
    Router::post('/login', [\App\Controllers\AuthController::class, 'login'])->name('login');
    Router::get('/verification/{token}', [\App\Controllers\AuthController::class, 'verification'])->name('verification');
});

Router::middleware([\App\Middlewares\IsLoggedIn::class])->group(function () {
    Router::get('/home', [\App\Controllers\Client\HomeController::class, 'index'])->name('home');
    Router::get('/explore', [\App\Controllers\Client\ExploreController::class, 'index']);
    Router::get('/messages', [\App\Controllers\Client\MessageController::class, 'index']);
    Router::get('/notifications', [\App\Controllers\Client\NotificationController::class, 'index']);
    Router::get('/logout', [\App\Controllers\AuthController::class, 'logout'])->name('logout');
    Router::get('/profile/{username}', [\App\Controllers\Client\ProfileController::class, 'index'])->name('profile');
    Router::get('/search', [\App\Controllers\Client\ExploreController::class, 'search'])->name('search');
    Router::post('/upload-post-image', [\App\Controllers\Client\ImageController::class, 'uploadPostImage'])->name('upload-post-image');
    Router::post('/delete-post-image', [\App\Controllers\Client\ImageController::class, 'deletePostImage'])->name('delete-post-image');
    Router::resource('/posts', \App\Controllers\Client\PostController::class);
    Router::post('/register-view', [\App\Controllers\Client\PostController::class, 'registerView'])->name('register-view');
});






