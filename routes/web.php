<?php

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\FeedController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
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

Auth::routes();

Route::get('/password/forgot', [ForgotPasswordController::class, 'showLinkRequestForm'])
    ->name('password.request');

Route::get('/password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])
    ->name('password.reset');

Route::get('/', [HomeController::class, 'index'])
    ->name('home');

Route::get('/feed', [FeedController::class, 'index'])
    ->name('feed');

Route::get('/users', [UserController::class, 'index'])
    ->name('user.list');

Route::get('/users/{user_id}', [UserController::class, 'view'])
    ->name('user.profile');

Route::get('/users/{user_id}/subscribe', [SubscriptionController::class, 'subscribe'])
    ->name('user.subscribe');

Route::get('/users/{user_id}/unsubscribe', [SubscriptionController::class, 'unsubscribe'])
    ->name('user.unsubscribe');

Route::get('/posts/new', [PostController::class, 'showCreateForm'])
    ->name('posts.new.form');

Route::post('/posts/new', [PostController::class, 'create'])
    ->name('posts.new');

Route::get('/posts/{post_id}', [PostController::class, 'showEditForm'])
    ->name('posts.edit.form');

Route::post('/posts/{post_id}', [PostController::class, 'update'])
    ->name('posts.edit');

Route::get('/posts/{post_id}/remove', [PostController::class, 'destroy'])
    ->name('posts.remove');

Route::get('/posts/{post_id}/view', [PostController::class, 'view'])
    ->name('posts.view');

Route::post('/posts/{post_id}/comment/new', [CommentController::class, 'create'])
    ->name('posts.comment.new');
