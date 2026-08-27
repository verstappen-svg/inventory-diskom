<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login - Inventory IT Assets</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, Helvetica, sans-serif;
        }

        body {
            min-height: 100vh;
            overflow: hidden;
        }

        .login-page {
            min-height: 100vh;
            width: 100%;
            background-image:
                linear-gradient(
                    rgba(255, 255, 255, 0.08),
                    rgba(255, 255, 255, 0.08)
                ),
                url('{{ asset("images/bekasiBGlogin.png") }}');

            background-size: cover;
            background-position: center;
            display: flex;
            align-items: center;
            justify-content: flex-end;
            padding-right: 8%;
        }

        .login-card {
            width: 420px;
            padding: 45px 40px;
            border-radius: 18px;

            background: rgba(255, 255, 255, 0.72);
            backdrop-filter: blur(0,50px);
            -webkit-backdrop-filter: blur(0,50px);

            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.12);
        }

        .logos {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 20px;
            margin-bottom: 20px;
        }

        .logos img {
            width: 65px;
            height: 65px;
            object-fit: contain;
        }

        .title {
            text-align: center;
            color: #050567;
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 8px;
        }

        .subtitle {
            text-align: center;
            color: #555;
            font-size: 13px;
            line-height: 1.5;
            margin-bottom: 28px;
        }

        .form-group {
            margin-bottom: 18px;
        }

        .form-group label {
            display: block;
            font-size: 13px;
            color: #555;
            margin-bottom: 7px;
        }

        .input-wrapper {
            position: relative;
        }

        .input-wrapper input {
            width: 100%;
            height: 45px;
            padding: 0 15px 0 42px;

            border: 1px solid rgba(0, 0, 0, 0.12);
            border-radius: 8px;

            background: rgba(255, 255, 255, 0.9);

            outline: none;
            font-size: 14px;
        }

        .input-wrapper input:focus {
            border-color: #050567;
            box-shadow: 0 0 0 2px rgba(5, 5, 103, 0.08);
        }

        .input-icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #999;
            font-size: 14px;
        }

        .remember {
            display: flex;
            align-items: center;
            gap: 7px;
            font-size: 12px;
            color: #666;
            margin: 5px 0 22px;
        }

        .remember input {
            accent-color: #050567;
        }

        .login-button {
            width: 100%;
            height: 45px;
            border: none;
            border-radius: 8px;

            background: #050567;
            color: white;

            font-size: 14px;
            font-weight: 600;

            cursor: pointer;
            transition: 0.2s;
        }

        .login-button:hover {
            background: #08089a;
        }

        .error {
            color: #d32f2f;
            font-size: 12px;
            margin-top: 5px;
        }

        @media (max-width: 768px) {
            .login-page {
                justify-content: center;
                padding: 20px;
            }

            .login-card {
                width: 100%;
                max-width: 420px;
            }
        }
    </style>
</head>

<body>

<div class="login-page">

    <div class="login-card">

        {{-- Logo --}}
        <div class="logos">
            <img src="{{ asset('images/logo-diskominfo.png') }}"
                 alt="Logo Diskominfo">

            <img src="{{ asset('images/logo-pemkot.png') }}"
                 alt="Logo Pemerintah Kota">
        </div>

        {{-- Title --}}
        <h1 class="title">
            Selamat Datang
        </h1>

        <p class="subtitle">
            Silakan masuk untuk mengelola dan memantau
            data inventori IT aset secara terintegrasi.
        </p>

        {{-- Login Form --}}
        <form method="POST" action="{{ route('login') }}">
            @csrf

            {{-- Username --}}
<div class="form-group">
    <label for="username">
        Username
    </label>

    <div class="input-wrapper">
        <span class="input-icon">✉</span>

        <input
            type="text"
            id="username"
            name="username"
            value="{{ old('username') }}"
            placeholder="Username"
            required
            autofocus
        >
    </div>

    @error('username')
        <div class="error">{{ $message }}</div>
    @enderror
</div>

            {{-- Password --}}
            <div class="form-group">
                <label for="password">
                    Password
                </label>

                <div class="input-wrapper">
                    <span class="input-icon">🔑</span>

                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="Password"
                        required
                    >
                </div>

                @error('password')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>
            {{-- Button --}}
            <button type="submit" class="login-button">
                Masuk
            </button>

        </form>

    </div>

</div>

</body>
</html>