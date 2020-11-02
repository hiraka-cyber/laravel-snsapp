<?php

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

Route::get('/', function () {
    return view('tweets.index');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['middleware' => 'auth'],function(){
    Route::resource('users', App\Http\Controllers\UsersController::class, ['only' =>['index', 'show', 'edit', 'update']]);

    // フォロー/フォロー解除を追加
    Route::post('users/{user}/follow', 'App\Http\Controllers\UsersController@follow')->name('follow');
    Route::delete('users/{user}/unfollow', 'App\Http\Controllers\UsersController@unfollow')->name('unfollow');
    // ツイート関連
    Route::resource('tweets', App\Http\Controllers\TweetsController::class, ['only' => ['index', 'create', 'store', 'show', 'edit', 'update', 'destroy']]);

    // コメント関連
    Route::resource('comments', App\Http\Controllers\CommentsController::class, ['only' => ['store']]);

    // いいね関連
    Route::resource('favorites', App\Http\Controllers\FavoritesController::class, ['only' => ['store', 'destroy']]);
});

