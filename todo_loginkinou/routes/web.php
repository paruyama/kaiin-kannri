<?php
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/users/create'); // 会員登録ページへリダイレクト
});

// ユーザー管理関連のルーティング
Route::controller(UserController::class)->group(function () {
    Route::get('/users', 'index')->name('users.index'); // 会員一覧
    Route::get('/users/create', 'create')->name('users.create'); // 会員登録画面
    Route::post('/users', 'store')->name('users.store'); // 会員登録処理
    Route::get('/users/{user}/edit', 'edit')->name('users.edit'); // 会員編集画面
    Route::put('/users/{user}', 'update')->name('users.update'); // 会員更新処理
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy'); // 会員削除処理
});
