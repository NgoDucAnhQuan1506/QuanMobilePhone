<!DOCTYPE html>
<html>
<head>
    <title>Đăng ký Admin</title>
</head>
<body>

@if(session('success'))
    <p>{{ session('success') }}</p>
@endif

<form method="post" action="{{ route('dangky.post') }}">
    @csrf
    <label for="username">Tài khoản:</label>
    <input type="text" id="username" name="username" value="{{ old('username') }}"><br><br>
    @error('username')
        <p>{{ $message }}</p>
    @enderror

    <label for="password">Mật khẩu:</label>
    <input type="password" id="password" name="password"><br><br>
    @error('password')
        <p>{{ $message }}</p>
    @enderror

    <label for="password_confirmation">Xác nhận mật khẩu:</label>
    <input type="password" id="password_confirmation" name="password_confirmation"><br><br>

    <label for="name">Tên:</label>
    <input type="text" id="name" name="name" value="{{ old('name') }}"><br><br>
    @error('name')
        <p>{{ $message }}</p>
    @enderror

    <input type="submit" name="submit" value="Đăng ký">
</form>

</body>
</html>
