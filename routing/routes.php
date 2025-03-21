<?php

use App\Controllers\Client\PostController;
use NovaLite\Routing\Router;

Router::middleware([\App\Middlewares\IsNotLoggedIn::class])->group(function () {
    Router::get('/', [\App\Controllers\AuthController::class, 'index'])->name('start');
    Router::post('/register', [\App\Controllers\AuthController::class, 'register'])->name('register');
    Router::post('/login', [\App\Controllers\AuthController::class, 'login'])->name('login');
    Router::get('/verification/{token}', [\App\Controllers\AuthController::class, 'verification'])->name('verification');
});


Router::middleware([\App\Middlewares\IsLoggedIn::class])->group(function () {
    Router::get('/home', [\App\Controllers\Client\HomeController::class, 'index'])->name('home');
    Router::get('/explore', [\App\Controllers\Client\ExploreController::class, 'index'])->name('explore');
    Router::get('/messages', [\App\Controllers\Client\MessageController::class, 'index'])->name('messages');

    Router::get('/notifications', [\App\Controllers\Client\NotificationController::class, 'index'])->name('notifications');
    Router::post('/notifications/{id}/read', [\App\Controllers\Client\NotificationController::class, 'read'])->name('notifications.read');

    Router::get('/logout', [\App\Controllers\AuthController::class, 'logout'])->name('logout');
    Router::get('/search', [\App\Controllers\Client\ExploreController::class, 'search'])->name('search');
    Router::get('/{username}', [\App\Controllers\Client\ProfileController::class, 'index'])->name('profile');


    Router::post('/upload-post-image', [\App\Controllers\Client\ImageController::class, 'uploadPostImage'])->name('upload-post-image');
    Router::delete('/delete-post-image', [\App\Controllers\Client\ImageController::class, 'deletePostImage'])->name('delete-post-image');


    Router::controller(PostController::class)->group(function () {
        Router::resource('/posts');
        Router::get('/{username}/status/{id}', 'show')->name('post');
        Router::post('/register-view', 'registerView')->name('register-view');
        Router::get('/posts/navigate/{id}', 'navigateToPost')->name('posts.navigate');
        Router::post("/posts/{id}/like", 'likePost')->name('posts.like');
        Router::post("/posts/{id}/repost", 'repostPost')->name('posts.repost');
    });


    Router::post('/users/block', [\App\Controllers\Client\UserController::class, 'blockUser'])->name('block-user');
});









