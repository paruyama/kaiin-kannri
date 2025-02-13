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

<form action="{{ route('users.update', $user) }}" method="POST">
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

<form action="{{ route('users.destroy', $user) }}" method="POST" onsubmit="return confirm('本当に削除しますか？');">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-danger">削除</button>
</form>

<a href="{{ route('users.index') }}" class="btn btn-secondary">会員一覧へ戻る</a>

@if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif