<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\StoryController;
use App\Http\Controllers\NotificationController;

Route::get('/', [PostController::class, 'index'])
    // ->middleware('auth')
        ->name('home');

Route::get('/home', function () {
    return redirect('/'); // Redirect to your main feed
})->name('home');

Auth::routes();

//Post routes
Route::get('/posts', [PostController::class, 'index'])
    ->name('posts.index');
Route::get('/posts/create', [PostController::class, 'create'])
    ->name('posts.create');
Route::post('/posts', [PostController::class, 'store'])
    ->name('posts.store');
Route::get('/posts/{post}', [PostController::class, 'show'])
    ->name('posts.show');
Route::get('/posts/{post}/edit', [PostController::class, 'edit'])
    ->name('posts.edit');
Route::patch('/posts/{post}', [PostController::class, 'update'])
    ->name('posts.update');
Route::delete('/posts/{post}', [PostController::class, 'destroy'])
    ->name('posts.destroy');
//Profile routes
Route::get('/profile/{user:username}', [ProfileController::class, 'index'])
    ->name('profile.show');
Route::get('/profile/{user:username}/edit', [ProfileController::class, 'edit'])
    ->name('profile.edit');
Route::patch('/profile/{user:username}', [ProfileController::class, 'update'])
    ->name('profile.update');
//Like routes
Route::post('/posts/{post}/like', [LikeController::class, 'store'])
    ->name('likes.store')
    ->middleware('auth');
Route::delete('/posts/{post}/like', [LikeController::class, 'destroy'])
    ->name('likes.destroy');
//Comment routes
Route::post('/posts/{post}/comments', [CommentController::class, 'store'])
    ->name('comments.store');
Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])
    ->name('comments.destroy');
//Follow routes
Route::post('/follow/{user}', [FollowController::class, 'store'])->name('follow');
Route::delete('/unfollow/{user}', [FollowController::class, 'destroy'])->name('unfollow');
//User search route
Route::get('/search', [UserController::class, 'search'])->name('search');

//Story route

Route::middleware('auth')->group(function () {
    Route::get('/stories/{id}', [StoryController::class, 'show'])->name('stories.show');
    Route::post('/stories', [StoryController::class, 'store'])->name('stories.store');
});

//Noti route
Route::middleware(['auth'])->group(function () {
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
});