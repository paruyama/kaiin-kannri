<h1>会員登録</h1>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('users.store') }}" method="POST">
    @csrf
    <ul class="list-group">
        <li class="list-group-item">
            <label for="name" class="form-label">名前</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}">
        </li>
        <li class="list-group-item">
            <label for="phone" class="form-label">電話番号</label>
            <input type="text" name="phone" id="phone" class="form-control" value="{{ old('phone') }}">
        </li>
        <li class="list-group-item">
            <label for="email" class="form-label">メールアドレス</label>
            <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}">
        </li>
    </ul>
    <button type="submit" class="btn btn-primary mt-3">登録</button>
</form>

<a href="{{ route('users.index') }}" class="btn btn-secondary mt-3">会員一覧へ戻る</a>