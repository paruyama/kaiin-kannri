<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function welcome() {
        return view('welcome');
        }

        public function index()
        {
            $users = User::all(); // ★ User モデルのデータを取得
    return view('users.index', compact('users')); // ★ users.index ビューを返す
        }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:15',
            'phone' => 'required|string|max:15',
            'email' => 'required|email|max:254',
        ]);
        User::create($validatedData);
        return redirect()->route('users.index');
    }

    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
       // バリデーションルールを定義
    $validatedData = $request->validate([
        'name' => 'required|string|max:15',
        'phone' => 'required|string|max:15',
        'email' => 'required|email|max:254',
    ]);

       // ★ 修正箇所: User モデルのインスタンスを確実に取得
       $user = User::findOrFail($user->id); // または $user = User::find($user->id);

       try {
           $user->update($validatedData); // 更新処理
       } catch (\Exception $e) {
           // ★ 修正箇所: エラー処理を追加
           Log::error($e); // ログにエラー内容を記録
           return back()->with('error', '更新処理に失敗しました。'); // エラーメッセージを返す
       }

       // ★ 修正箇所: リダイレクト時にメッセージを渡す
       return redirect()->route('users.index')->with('success', '更新しました。');
   
    }

    public function destroy(User $user)
    {
        try {
            $user->delete(); // ★ 修正: $user->delete() で削除
        } catch (\Exception $e) {
            Log::error($e);
            return back()->with('error', '削除処理に失敗しました。');
        }

        return redirect()->route('users.index')->with('success', '会員情報を削除しました。');
    }
}