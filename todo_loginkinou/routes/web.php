<?php
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MemberController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    if (Auth::check()) { // ログイン済みの場合
        return redirect()->route('users.create'); // 会員登録画面へリダイレクト
    } else { // 未ログインの場合
        return view('auth.login'); // ログイン画面を表示
    }
});

// ユーザー管理関連のルーティング
Route::middleware(['auth'])->group(function () {
    Route::controller(UserController::class)->group(function () {
        Route::get('/users', 'index')->name('users.index'); // 会員一覧 ★ ログイン認証が必要
        Route::get('/users/create', 'create')->name('users.create'); // 会員登録画面
        Route::post('/members',  'store')->name('members.store'); // 会員登録処理
        Route::get('/users/{user}/edit', 'edit')->name('users.edit'); // 会員編集画面
        Route::put('/users/{user}', 'update')->name('users.update'); // 会員更新処理
        Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy'); // 会員削除処理
    });

    // MemberController のルーティングを追加
    Route::controller(MemberController::class)->prefix('members')->group(function () {
        
        Route::get('/members', [MemberController::class, 'index'])->name('members.index');
        Route::get('/{id}/edit', 'edit')->name('members.edit');
        Route::put('/{id}', 'update')->name('members.update');
        Route::delete('/{id}', 'destroy')->name('members.destroy');
    });
});

Auth::routes();
Route::get('/home', [HomeController::class, 'index'])->name('home'); 

//認証済みユーザーのみアクセス可能なルーティングをグループ化
Route::middleware(['auth'])->group(function () {
    // ここに認証が必要なルーティングを追加
    Route::get('/dashboard', function () {
        return view('dashboard'); // 例: ダッシュボード画面
    });
});
