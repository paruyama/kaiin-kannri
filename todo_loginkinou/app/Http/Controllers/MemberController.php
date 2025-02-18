<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MemberController extends Controller
{
    public function index()
    {
        // 会員一覧表示処理

        // 1. 会員データを取得する
        $members = Member::all(); // 全ての会員データを取得する場合
        // または、特定の条件で絞り込む場合
        // $members = Member::where('条件', '値')->get();

        // 2. ビューにデータを渡して表示する
        return view('users.index', compact('members'));

        // resources/views/index.blade.php (ビューファイル) の例:
        // <h1>会員一覧</h1>
        // <ul>
        //     @foreach ($members as $member)
        //         <li>{{ $member->name }}</li>
        //     @endforeach
        // </ul>
    }


    public function edit(Request $request, $id)
{
    $user = User::find($id);

    if (!$user) {
        abort(404);
    }

    // 認証済みユーザーと編集対象ユーザーが一致するか確認 (必要に応じて)
    if (Auth::id() !== $user->id) {
        abort(403, 'Unauthorized action.');
    }

    $member = $user->member; // User モデルのリレーションで Member モデルを取得

    if (!$member) {
        $member = new Member();
        $member->user_id = $user->id; // user_id を設定
    }

    return view('members.edit', compact('user', 'member'));
}

public function update(Request $request, $id)
{
    $user = User::find($id);
    if (!$user) {
        abort(404);
    }

    $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        'phone' => 'required|string|max:20',
        'email' => 'required|email|max:255',
    ]);

    DB::beginTransaction();

    try {
        $member = Member::where('user_id', $user->id)->first(); // user_id で Member を検索

        if ($member) {
            $member->update([
                'name' => $validatedData['name'],
                'phone' => $validatedData['phone'],
                'email' => $validatedData['email'],
            ]);
        } else {
            $member = new Member();
            $member->user_id = $user->id; // user_id を設定
            $member->fill($validatedData);
            $member->save();
        }

        $user->update([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
        ]);

        DB::commit();

    } catch (\Exception $e) {
        DB::rollBack();
        Log::error($e);
        return back()->with('error', '更新処理に失敗しました。');
    }

    return redirect()->route('members.index') ->with('success', '更新しました。');
}

public function destroy($id)
{
    $user = User::find($id);
    if (!$user) {
        abort(404);
    }

    try {
        $member = Member::where('user_id', $user->id)->first(); // user_id で Member を検索

        $user->delete();
        if ($member) {
            $member->delete();
        }

    } catch (\Exception $e) {
        Log::error($e);
        return back()->with('error', '削除処理に失敗しました。');
    }

    return redirect()->route('members.index')->with('success', '会員情報を削除しました。');
}
}