<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Вход — BestProf Admin</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        * { font-family: 'Plus Jakarta Sans', sans-serif; }

        body {
            background: #00074B;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-card {
            width: 100%;
            max-width: 420px;
            border-radius: 16px;
            border: none;
            box-shadow: 0 8px 32px rgba(0,0,0,.25);
        }

        .login-logo {
            font-size: 1.5rem;
            font-weight: 700;
            color: #00074B;
            text-align: center;
            margin-bottom: 1.5rem;
        }

        .login-logo span {
            color: #193EEA;
            background: rgba(25,62,234,.1);
            padding: 2px 10px;
            border-radius: 6px;
            margin-right: 4px;
            font-weight: 800;
        }

        .btn-login {
            background: #193EEA;
            border-color: #193EEA;
            font-weight: 600;
            padding: .6rem;
        }
        .btn-login:hover {
            background: #1232c4;
            border-color: #1232c4;
        }
    </style>
</head>
<body>

    <div class="card login-card">
        <div class="card-body p-4 p-md-5">
            <div class="login-logo">
                <span>BP</span> BestProf Admin
            </div>

            @if($errors->any())
                <div class="alert alert-danger py-2">
                    @foreach($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('admin.login') }}">
                @csrf

                <div class="mb-3">
                    <label for="email" class="form-label fw-semibold">Email</label>
                    <input type="email"
                           id="email"
                           name="email"
                           class="form-control @error('email') is-invalid @enderror"
                           value="{{ old('email') }}"
                           placeholder="admin@bestprof.ru"
                           required
                           autofocus>
                </div>

                <div class="mb-4">
                    <label for="password" class="form-label fw-semibold">Пароль</label>
                    <input type="password"
                           id="password"
                           name="password"
                           class="form-control @error('password') is-invalid @enderror"
                           placeholder="••••••••"
                           required>
                </div>

                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="remember" name="remember">
                    <label class="form-check-label" for="remember">Запомнить меня</label>
                </div>

                <button type="submit" class="btn btn-login btn-primary w-100">
                    Войти
                </button>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
