<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: url('{{ asset('img/background.jpg') }}') no-repeat center center;
            background-size: cover;
        }
        .login-card {
            background-color: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(5px);
            padding: 2rem;
            border-radius: 12px;
            width: 100%;
            max-width: 400px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.2);
        }
        .login-card img {
            width: 80px;
            display: block;
            margin: 0 auto 20px;
        }
        @media (max-width: 576px) {
            .login-card {
                padding: 1.5rem;
                margin: 0 1rem;
            }
        }
    </style>
</head>
<body>
    <div class="login-card">
        <img src="{{ asset('img/logo.png') }}" alt="Logo Perusahaan">
        <h4 class="text-center mb-4">Silakan Masuk</h4>

        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="mb-3">
                <input type="email" class="form-control" name="email" placeholder="Email" value="{{ old('email') }}" required>
                @error('email')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <input type="password" class="form-control" name="password" placeholder="Password" required>
                @error('password')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3 text-end">
                <a href="#">Lupa Password?</a>
            </div>
            <button type="submit" class="btn btn-primary w-100">Login</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
