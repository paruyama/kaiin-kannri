<h1>会員一覧</h1>

<div style="text-align: right;">
    <a href="{{ route('users.create') }}" class="btn btn-primary">会員登録</a>
</div>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>名前</th>
            <th>電話番号</th>
            <th>メールアドレス</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($users as $user)
            <tr>
                <td>{{ $user->name }}</td>
                <td>{{ $user->phone }}</td>
                <td>{{ $user->email }}</td>
                <td>
                    <a href="{{ route('users.edit', $user) }}" class="btn btn-warning">編集</a>
                    <form action="{{ route('users.destroy', $user) }}" method="POST" style="display: inline;">
                        @csrf
                        <!-- @method('DELETE')
                        <button type="submit" class="btn btn-danger">削除</button> -->
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

<a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
    ログアウト
</a>

<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form>