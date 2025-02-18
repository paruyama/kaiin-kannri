<h1>会員編集</h1>

@if ($errors->any())  
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if ($user)
<form action="{{ route('members.update',$users->id) }}" method="POST">
    @csrf
    @method('PUT')
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>名前</th>
                <th>電話番号</th>
                <th>メールアドレス</th>
            </tr>
        </thead>
        <tbody>
            <tr>
            <td><input type="text" name="name" id="name" class="form-control" value="{{ old('name', $user->name) }}"></td>
                <td><input type="text" name="phone" id="phone" class="form-control" value="{{ old('phone', $user->phone) }}"></td>
                <td><input type="email" name="email" id="email" class="form-control" value="{{ old('email', $user->email) }}"></td>
            </tr>
        </tbody>
    </table>
    <button type="submit" class="btn btn-primary">更新</button>
</form>

<form action="{{ route('members.destroy', $user->id) }}" method="POST" onsubmit="return confirm('本当に削除しますか？');">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-danger">削除</button>
</form>

@else
    <p>会員情報が見つかりません。</p>
@endif

<a href="{{ route('users.index') }}" class="btn btn-secondary">会員一覧へ戻る</a>

@if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif
<a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
    ログアウト
</a>

<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form>