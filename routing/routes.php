<?php

use NovaLite\Routing\Router;
Router::view('/profile', 'pages.client.profile');

Router::middleware([\App\Middlewares\IsNotLoggedIn::class])->group(function () {
    Router::get('/', [\App\Controllers\AuthController::class, 'index'])->name('start');
    Router::post('/register', [\App\Controllers\AuthController::class, 'register'])->name('register');
    Router::post('/login', [\App\Controllers\AuthController::class, 'login'])->name('login');
});

Router::middleware([\App\Middlewares\IsLoggedIn::class])->group(function () {
    Router::get('/home', [\App\Controllers\Client\HomeController::class, 'index'])->name('home');
    Router::get('/explore', [\App\Controllers\Client\ExploreController::class, 'index']);
    Router::get('/messages', [\App\Controllers\Client\MessageController::class, 'index']);
    Router::get('/notifications', [\App\Controllers\Client\NotificationController::class, 'index']);
    Router::get('/logout', [\App\Controllers\AuthController::class, 'logout'])->name('logout');
});






