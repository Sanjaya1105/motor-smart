<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #eef3ff, #ffffff);
        }

        .login-page {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 40px 20px;
        }

        .login-form {
            width: 100%;
            max-width: 430px;
            box-sizing: border-box;
            padding: 34px;
            border-top: 6px solid #FF823B;
            border-radius: 18px;
            background: #fff;
            box-shadow: 0 18px 45px rgba(36, 103, 255, 0.16);
        }

        .login-logo {
            display: block;
            max-width: 220px;
            margin: 0 auto 24px;
        }

        .login-title {
            margin: 0 0 8px;
            color: #2467FF;
            text-align: center;
            font-size: 30px;
        }

        .login-subtitle {
            margin: 0 0 28px;
            color: #666;
            text-align: center;
        }

        .error-message {
            padding: 12px;
            margin-bottom: 18px;
            border-radius: 8px;
            background: #ffe9e9;
            color: #dc3545;
            font-weight: 600;
        }

        .form-group {
            margin-bottom: 18px;
        }

        .form-label {
            display: block;
            margin-bottom: 8px;
            color: #222;
            font-weight: 700;
        }

        .form-input {
            width: 100%;
            box-sizing: border-box;
            padding: 13px 14px;
            border: 1px solid #d5dcff;
            border-radius: 8px;
            font-size: 15px;
        }

        .form-input:focus {
            border-color: #2467FF;
            outline: none;
            box-shadow: 0 0 0 3px rgba(36, 103, 255, 0.12);
        }

        .login-button {
            width: 100%;
            padding: 13px;
            border: none;
            border-radius: 8px;
            background: #2467FF;
            color: #fff;
            font-weight: 700;
            cursor: pointer;
            transition: background 0.2s ease;
        }

        .login-button:hover {
            background: #FF823B;
        }

        @media (max-width: 480px) {
            .login-page {
                padding: 28px 12px;
            }

            .login-form {
                padding: 22px;
            }

            .login-logo {
                max-width: 180px;
            }
        }
    </style>
</head>
<body>
    <main class="login-page">
        <form method="POST" action="{{ route('login.submit') }}" class="login-form">
            @csrf

            <img src="{{ asset('img/logo_motorSmart.png') }}" alt="Motor Smart logo" class="login-logo">
            <h1 class="login-title">Login</h1>
            <p class="login-subtitle">Welcome back to Motor Smart</p>

            @if ($errors->any())
                <p class="error-message">{{ $errors->first() }}</p>
            @endif

            @if (session('error'))
                <p class="error-message">{{ session('error') }}</p>
            @endif

            <div class="form-group">
                <label for="username" class="form-label">User Name</label>
                <input
                    type="text"
                    id="username"
                    name="username"
                    value="{{ old('username') }}"
                    class="form-input"
                    required
                >
            </div>

            <div class="form-group">
                <label for="password" class="form-label">Password</label>
                <input
                    type="text"
                    id="password"
                    name="password"
                    class="form-input"
                    required
                >
            </div>

            <button
                type="submit"
                class="login-button"
            >
                Login
            </button>
        </form>
    </main>
</body>
</html>
