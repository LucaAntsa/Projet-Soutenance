@php
    $locale = session('admin_locale', 'fr');
    $theme = session('admin_theme', 'light');

    $texts = [
        'fr' => [
            'page_title' => 'Connexion - Administration',
            'app_name' => 'Éducation Familiale',
            'subtitle' => 'Espace administrateur et expert',
            'login' => 'Connexion',
            'login_text' => 'Accédez à votre interface d’administration.',
            'email' => 'Adresse email',
            'password' => 'Mot de passe',
            'forgot_password' => 'Mot de passe oublié ?',
            'login_button' => 'Se connecter',
            'qr_text' => 'Scanner pour accéder à l’inscription',
            'no_account' => 'Vous n’avez pas encore de compte ?',
            'create_account' => 'Créer un compte',
            'light' => 'Clair',
            'dark' => 'Sombre',
        ],
        'mg' => [
            'page_title' => 'Hiditra - Administration',
            'app_name' => 'Fanabeazana ara-pianakaviana',
            'subtitle' => 'Sehatra admin sy expert',
            'login' => 'Hiditra',
            'login_text' => 'Midira amin’ny interface fitantanana.',
            'email' => 'Adiresy email',
            'password' => 'Tenimiafina',
            'forgot_password' => 'Adino ny tenimiafina ?',
            'login_button' => 'Hiditra',
            'qr_text' => 'Scan-na raha hiditra amin’ny fisoratana anarana',
            'no_account' => 'Mbola tsy manana kaonty ?',
            'create_account' => 'Hamorona kaonty',
            'light' => 'Mazava',
            'dark' => 'Maizina',
        ],
    ];

    $t = $texts[$locale] ?? $texts['fr'];
@endphp

<!DOCTYPE html>
<html lang="{{ $locale }}">
<head>
    <meta charset="UTF-8">
    <title>{{ $t['page_title'] }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #F3F6FB;
            min-height: 100vh;
            font-family: Arial, sans-serif;
        }

        .login-wrapper {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
            position: relative;
        }

        .top-switch {
            position: absolute;
            top: 18px;
            right: 22px;
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            justify-content: flex-end;
        }

        .switch-group {
            background: #FFFFFF;
            border-radius: 999px;
            padding: 5px;
            box-shadow: 0 8px 22px rgba(15, 23, 42, 0.10);
            display: flex;
            gap: 4px;
        }

        .switch-btn {
            text-decoration: none;
            border-radius: 999px;
            padding: 7px 12px;
            font-size: 12px;
            font-weight: 800;
            color: #64748B;
            transition: all 0.2s ease;
        }

        .switch-btn:hover {
            color: #2563EB;
            background: #EFF6FF;
        }

        .switch-btn.active {
            background: #2563EB;
            color: #FFFFFF;
        }

        .login-card {
            width: 100%;
            max-width: 480px;
            border: 0;
            border-radius: 26px;
            box-shadow: 0 18px 40px rgba(15, 23, 42, 0.12);
            overflow: hidden;
        }

        .login-header {
            background: linear-gradient(135deg, #2563EB, #1D4ED8);
            color: white;
            padding: 34px 26px;
            text-align: center;
        }

        .login-icon {
            width: 78px;
            height: 78px;
            border-radius: 24px;
            background: white;
            color: #2563EB;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 38px;
            margin: 0 auto 18px;
        }

        .login-title {
            font-size: 26px;
            font-weight: 800;
            margin-bottom: 8px;
        }

        .login-subtitle {
            color: rgba(255, 255, 255, 0.82);
            margin-bottom: 0;
            font-size: 14px;
        }

        .login-body {
            background: white;
            padding: 30px;
        }

        .form-control {
            border-radius: 14px;
            padding: 13px 15px;
            border: 1px solid #CBD5E1;
        }

        .form-control:focus {
            border-color: #2563EB;
            box-shadow: 0 0 0 0.18rem rgba(37, 99, 235, 0.15);
        }

        .btn-login {
            background: #2563EB;
            border: 0;
            border-radius: 14px;
            padding: 13px;
            font-weight: 700;
        }

        .btn-login:hover {
            background: #1D4ED8;
        }

        .qr-box {
            background: #F8FAFC;
            border-radius: 18px;
            padding: 18px;
            text-align: center;
            margin-top: 22px;
        }

        .qr-box img {
            max-width: 135px;
            border-radius: 12px;
            background: white;
            padding: 8px;
            border: 1px solid #E2E8F0;
        }

        .register-link {
            color: #2563EB;
            font-weight: 700;
            text-decoration: none;
        }

        .register-link:hover {
            text-decoration: underline;
        }

        @if($theme === 'dark')
            body {
                background: #0F172A !important;
                color: #F8FAFC !important;
            }

            .login-body {
                background: #1E293B !important;
                color: #F8FAFC !important;
            }

            .login-card {
                box-shadow: none !important;
            }

            .top-switch .switch-group {
                background: #1E293B !important;
                box-shadow: none !important;
            }

            .switch-btn {
                color: #CBD5E1 !important;
            }

            .switch-btn:hover {
                background: #334155 !important;
                color: #FFFFFF !important;
            }

            .switch-btn.active {
                background: #2563EB !important;
                color: #FFFFFF !important;
            }

            .form-control {
                background: #0F172A !important;
                color: #F8FAFC !important;
                border-color: #334155 !important;
            }

            .text-muted {
                color: #CBD5E1 !important;
            }

            .qr-box {
                background: #0F172A !important;
                border: 1px solid #334155;
            }

            .qr-box img {
                border-color: #334155 !important;
            }
        @endif

        @media (max-width: 576px) {
            .login-wrapper {
                padding: 78px 14px 14px;
            }

            .top-switch {
                top: 14px;
                right: 14px;
                left: 14px;
                justify-content: center;
            }

            .login-header {
                padding: 28px 20px;
            }

            .login-body {
                padding: 24px 20px;
            }

            .login-title {
                font-size: 23px;
            }
        }
    </style>
</head>

<body>

<div class="login-wrapper">

    <div class="top-switch">
        <div class="switch-group">
            <a href="{{ route('admin.lang', 'fr') }}"
               class="switch-btn {{ $locale === 'fr' ? 'active' : '' }}">
                FR
            </a>

            <a href="{{ route('admin.lang', 'mg') }}"
               class="switch-btn {{ $locale === 'mg' ? 'active' : '' }}">
                MG
            </a>
        </div>

        <div class="switch-group">
            <a href="{{ route('admin.theme', 'light') }}"
               class="switch-btn {{ $theme === 'light' ? 'active' : '' }}">
                {{ $t['light'] }}
            </a>

            <a href="{{ route('admin.theme', 'dark') }}"
               class="switch-btn {{ $theme === 'dark' ? 'active' : '' }}">
                {{ $t['dark'] }}
            </a>
        </div>
    </div>

    <div class="card login-card">

        <div class="login-header">
            <div class="login-icon">
                👨‍👩‍👧
            </div>

            <h1 class="login-title">
                {{ $t['app_name'] }}
            </h1>

            <p class="login-subtitle">
                {{ $t['subtitle'] }}
            </p>
        </div>

        <div class="login-body">

            <h3 class="fw-bold text-center mb-2">
                {{ $t['login'] }}
            </h3>

            <p class="text-muted text-center mb-4">
                {{ $t['login_text'] }}
            </p>

            @if(session('success'))
                <div class="alert alert-success border-0 rounded-4">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger border-0 rounded-4">
                    @foreach($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('admin.login.submit') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label fw-semibold">
                        {{ $t['email'] }}
                    </label>

                    <input
                        type="email"
                        name="email"
                        class="form-control"
                        value="{{ old('email') }}"
                        required
                        autofocus
                    >
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">
                        {{ $t['password'] }}
                    </label>

                    <input
                        type="password"
                        name="password"
                        class="form-control"
                        required
                    >
                </div>

                <div class="text-start mb-3">
                    <a href="{{ route('admin.password.forgot') }}" class="text-decoration-none register-link">
                        {{ $t['forgot_password'] }}
                    </a>
                </div>

                <button type="submit" class="btn btn-primary btn-login w-100">
                    {{ $t['login_button'] }}
                </button>

                <div class="qr-box">
                    <p class="text-muted small mb-2">
                        {{ $t['qr_text'] }}
                    </p>

                    <img
                        src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data={{ urlencode(route('admin.register')) }}"
                        alt="QR Code inscription"
                    >
                </div>
            </form>

            <div class="text-center mt-3">
                <span class="text-muted">
                    {{ $t['no_account'] }}
                </span>

                <a href="{{ route('admin.register') }}" class="register-link">
                    {{ $t['create_account'] }}
                </a>
            </div>

        </div>
    </div>
</div>

</body>
</html>
