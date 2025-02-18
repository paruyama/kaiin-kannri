<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Member; // Member モデルを読み込む
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash; // パスワードハッシュ用

class UserController extends Controller
{
    private $rules = [
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        'password' => ['required', 'string', 'min:8', 'confirmed'],
    ];

    public function index()
    {
        $users = User::paginate(10);

        // 各ユーザーに対応する member 情報を取得
        foreach ($users as $user) {
            $user->member = Member::where('user_id', $user->id)->first();
                if (!$user->member) { // usersテーブルに紐づくデータがない場合
                    $user->member = $user; // usersテーブルの情報を利用する場合
                }
        }

        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate($this->rules);

        // パスワードをハッシュ化
        $validatedData['password'] = Hash::make($validatedData['password']);

        $user = User::create($validatedData);

        // member テーブルにも情報を保存
        $member = new Member();
        $member->user_id = $user->id;
        $member->name = $user->name; // 例: ユーザー名を引き継ぐ
        $member->email = $user->email; // emailも保存
        // 他の member 情報を設定
        $member->save();

        return redirect()->route('users.index')->with('success', '登録しました。');
    }

    public function show(User $user)
    {
        // 必要であれば実装
    }

    public function edit(User $user)
    {
        return view('users.edit', compact('user')); // users.edit では $member は不要
    }

    public function update(Request $request, User $user)
    {
        // バリデーションルールを調整 (email は unique 制約を外す場合がある)
         $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'], // unique 制約を外す例
            'password' => ['nullable', 'string', 'min:8', 'confirmed'], // password は変更する場合のみ
        ];

        $validatedData = $request->validate($rules);

        $user = User::findOrFail($user->id);

        try {

            $user->update([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                 // パスワードが変更された場合のみハッシュ化して更新
                'password' => $validatedData['password'] ? Hash::make($validatedData['password']) : $user->password,
            ]);

        } catch (\Exception $e) {
            Log::error($e);
            return back()->with('error', '更新処理に失敗しました。');
        }

        return redirect()->route('users.index')->with('success', '更新しました。');
    }

    public function destroy(User $user)
    {
        try {
            $member = Member::where('user_id', $user->id)->first();
            $user->delete();
            if($member){
                $member->delete();
            }

        } catch (\Exception $e) {
            Log::error($e);
            return back()->with('error', '削除処理に失敗しました。');
        }

        return redirect()->route('users.index')->with('success', '会員情報を削除しました。');
    }
}