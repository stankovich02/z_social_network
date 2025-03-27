<?php

use App\Controllers\Client\CommentController;
use App\Controllers\Client\PostController;
use App\Controllers\Client\UserController;
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

    Router::controller(CommentController::class)->group(function (){
        Router::post("/posts/{postId}/comment/{commentId}/like", 'like')->name('comments.like');
    });

    Router::controller(CommentController::class)->group(function () {
        Router::post('/posts/{id}/comment', 'store')->name('comment.store');
        Router::delete('/posts/{id}/comment', 'destroy')->name('comment.destroy');
    });



    Router::controller(UserController::class)->group(function (){
        Router::post('/users/block', 'blockUser')->name('block-user');
        Router::patch('/users/{id}/update', 'update')->name('users.update');
        Router::post('/upload-user-image', 'uploadProfileImage')->name('upload-user-image');
        Router::delete('/delete-user-image', 'deleteProfileImage')->name('delete-user-image');
        Router::post('/upload-cover-image', 'uploadCoverImage')->name('upload-cover-image');
        Router::delete('/delete-cover-image', 'deleteCoverImage')->name('delete-cover-image');
        Router::post('/users/biography', 'addBiography')->name('add-biography');
    });
});









