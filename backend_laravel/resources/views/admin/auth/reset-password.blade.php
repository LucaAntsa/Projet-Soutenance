@php
    $locale = session('admin_locale', 'fr');
    $theme = session('admin_theme', 'light');

    $texts = [
        'fr' => [
            'page_title' => 'Réinitialiser le mot de passe - Administration',
            'title' => 'Nouveau mot de passe',
            'subtitle' => 'Créez un nouveau mot de passe sécurisé.',
            'email' => 'Adresse email',
            'new_password' => 'Nouveau mot de passe',
            'confirm_password' => 'Confirmer le mot de passe',
            'reset_button' => 'Réinitialiser le mot de passe',
            'back_login' => 'Retour à la connexion',
            'light' => 'Clair',
            'dark' => 'Sombre',

            'badge' => 'Sécurité du compte',
            'info_title' => 'Créer un accès sécurisé',
            'info_text' => 'Choisissez un mot de passe fort pour protéger votre compte administrateur ou expert.',
            'rule_1' => 'Mot de passe confidentiel',
            'rule_2' => 'Accès protégé',
            'rule_3' => 'Compte sécurisé',
        ],
        'mg' => [
            'page_title' => 'Hanova tenimiafina - Administration',
            'title' => 'Tenimiafina vaovao',
            'subtitle' => 'Mamoròna tenimiafina vaovao azo antoka.',
            'email' => 'Adiresy email',
            'new_password' => 'Tenimiafina vaovao',
            'confirm_password' => 'Hamarino ny tenimiafina',
            'reset_button' => 'Hanova ny tenimiafina',
            'back_login' => 'Hiverina amin’ny fidirana',
            'light' => 'Mazava',
            'dark' => 'Maizina',

            'badge' => 'Fiarovana kaonty',
            'info_title' => 'Mamorona fidirana voaaro',
            'info_text' => 'Misafidiana tenimiafina matanjaka hiarovana ny kaonty admin na expert.',
            'rule_1' => 'Tenimiafina miafina',
            'rule_2' => 'Fidirana voaaro',
            'rule_3' => 'Kaonty azo antoka',
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
        :root {
            --app-primary: #2563EB;
            --app-primary-dark: #1E40AF;
            --app-secondary: #14B8A6;
            --app-accent: #F59E0B;
            --app-success: #22C55E;
            --app-danger: #EF4444;
            --app-dark: #0F172A;
            --app-card-dark: #1E293B;
            --app-muted: #64748B;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: Arial, sans-serif;
            background:
                linear-gradient(rgba(15, 23, 42, 0.66), rgba(15, 23, 42, 0.78)),
                url('/images/auth-family-bg.png');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            overflow-x: hidden;
        }

        .reset-wrapper {
            min-height: 100vh;
            padding: 72px 20px 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        .reset-wrapper::before {
            content: "";
            position: absolute;
            inset: 0;
            background:
                radial-gradient(circle at 15% 20%, rgba(37, 99, 235, 0.35), transparent 28%),
                radial-gradient(circle at 85% 75%, rgba(20, 184, 166, 0.30), transparent 30%);
            pointer-events: none;
        }

        .top-switch {
            position: absolute;
            top: 14px;
            right: 18px;
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            justify-content: flex-end;
            z-index: 5;
        }

        .switch-group {
            background: rgba(255, 255, 255, 0.92);
            border-radius: 999px;
            padding: 5px;
            box-shadow: 0 10px 26px rgba(15, 23, 42, 0.16);
            display: flex;
            gap: 4px;
            backdrop-filter: blur(10px);
        }

        .switch-btn {
            text-decoration: none;
            border-radius: 999px;
            padding: 6px 10px;
            font-size: 11px;
            font-weight: 800;
            color: var(--app-muted);
            transition: all 0.22s ease;
        }

        .switch-btn:hover {
            color:800;
            color: var(--app-muted);
            transition: all 0.22s ease;
        }

        .switch-btn:hover {
            color: var(--app-primary);
            background: #EFF6FF;
        }

        .switch-btn.active {
            background: var(--app-primary);
            color: #FFFFFF;
        }

        .reset-container {
            width: 100%;
            max-width: 920px;
            display: grid;
            grid-template-columns: 0.9fr 0.82fr;
            gap: 20px;
            position: relative;
            z-index: 2;
        }

        .security-panel,
        .reset-card {
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 22px 55px rgba(15, 23, 42, 0.28);
            animation: fadeUp 0.7s ease both;
        }

        .security-panel {
            background: rgba(255, 255, 255, 0.92);
            padding: 24px;
            backdrop-filter: blur(12px);
        }

        .security-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: #DBEAFE;
            color: var(--app-primary);
            padding: 7px 13px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 800;
            margin-bottom: 14px;
        }

        .security-panel h1 {
            color: #0F172A;
            font-size: 26px;
            line-height: 1.15;
            font-weight: 900;
            margin-bottom: 10px;
        }

        .security-panel p {
            color: var(--app-muted);
            font-size: 13px;
            line-height: 1.5;
            margin-bottom: 18px;
        }

        .security-animation {
            height: 190px;
            border-radius: 20px;
            background: linear-gradient(135deg, var(--app-primary), var(--app-secondary));
            position: relative;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .security-animation::before {
            content: "";
            position: absolute;
            width: 210px;
            height: 210px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.15);
            top: -80px;
            right: -70px;
            animation: floatCircle 5s ease-in-out infinite;
        }

        .security-animation::after {
            content: "";
            position: absolute;
            width: 150px;
            height: 150px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.12);
            bottom: -55px;
            left: -45px;
            animation: floatCircle 6s ease-in-out infinite reverse;
        }

        .lock-circle {
            width: 92px;
            height: 92px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.95);
            color: var(--app-primary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 42px;
            position: relative;
            z-index: 2;
            animation: pulseLock 1.9s ease-in-out infinite;
            box-shadow: 0 18px 35px rgba(15, 23, 42, 0.22);
        }

        .security-step {
            position: absolute;
            z-index: 3;
            background: rgba(255, 255, 255, 0.22);
            border: 1px solid rgba(255, 255, 255, 0.28);
            color: white;
            border-radius: 999px;
            padding: 7px 11px;
            font-size: 11px;
            font-weight: 800;
            backdrop-filter: blur(8px);
        }

        .step-one {
            top: 18px;
            left: 18px;
            animation: slideSoft 3s ease-in-out infinite;
        }

        .step-two {
            right: 18px;
            top: 74px;
            animation: slideSoft 3.4s ease-in-out infinite reverse;
        }

        .step-three {
            left: 28px;
            bottom: 18px;
            animation: slideSoft 3.8s ease-in-out infinite;
        }

        .reset-card {
            border: 0;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(12px);
            animation-delay: 0.12s;
        }

        .reset-header {
            background: linear-gradient(135deg, var(--app-primary), var(--app-secondary));
            color: white;
            padding: 24px 22px;
            text-align: center;
        }

        .reset-icon {
            width: 62px;
            height: 62px;
            border-radius: 20px;
            background: white;
            color: var(--app-primary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 31px;
            margin: 0 auto 12px;
            box-shadow: 0 12px 26px rgba(15, 23, 42, 0.15);
        }

        .reset-title {
            font-size: 22px;
            font-weight: 900;
            margin-bottom: 5px;
        }

        .reset-subtitle {
            color: rgba(255, 255, 255, 0.86);
            margin-bottom: 0;
            font-size: 12px;
            line-height: 1.4;
        }

        .reset-body {
            padding: 22px 24px;
        }

        .form-label {
            font-size: 13px;
            margin-bottom: 6px;
        }

        .form-control {
            border-radius: 14px;
            padding: 11px 13px;
            border: 1px solid #CBD5E1;
            font-size: 14px;
            transition: all 0.22s ease;
        }

        .form-control:focus {
            border-color: var(--app-primary);
            box-shadow: 0 0 0 0.18rem rgba(37, 99, 235, 0.15);
        }

        .form-control:disabled {
            background: #F8FAFC;
            color: #64748B;
        }

        .btn-reset {
            background: linear-gradient(135deg, var(--app-primary), var(--app-secondary));
            border: 0;
            border-radius: 14px;
            padding: 12px;
            font-size: 14px;
            font-weight: 800;
            transition: 0.24s ease;
        }

        .btn-reset:hover {
            transform: translateY(-2px);
            box-shadow: 0 14px 26px rgba(37, 99, 235, 0.22);
        }

        .back-link {
            color: var(--app-primary);
            text-decoration: none;
            font-size: 13px;
            font-weight: 800;
        }

        .back-link:hover {
            text-decoration: underline;
        }

        .alert {
            font-size: 13px;
            padding: 10px 12px;
            margin-bottom: 12px;
        }

        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(22px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes floatCircle {
            0%, 100% {
                transform: translateY(0) scale(1);
            }

            50% {
                transform: translateY(16px) scale(1.04);
            }
        }

        @keyframes pulseLock {
            0%, 100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.08);
            }
        }

        @keyframes slideSoft {
            0%, 100% {
                transform: translateX(0);
                opacity: 0.88;
            }

            50% {
                transform: translateX(-8px);
                opacity: 1;
            }
        }

        @if($theme === 'dark')
            body {
                background:
                    linear-gradient(rgba(15, 23, 42, 0.80), rgba(15, 23, 42, 0.90)),
                    url('/images/auth-family-bg.png') !important;
                background-size: cover !important;
                background-position: center !important;
                background-repeat: no-repeat !important;
                color: #F8FAFC !important;
            }

            .security-panel,
            .reset-card {
                background: rgba(30, 41, 59, 0.94) !important;
                color: #F8FAFC !important;
                box-shadow: none !important;
            }

            .security-panel h1 {
                color: #F8FAFC !important;
            }

            .security-panel p,
            .text-muted {
                color: #CBD5E1 !important;
            }

            .top-switch .switch-group {
                background: rgba(30, 41, 59, 0.94) !important;
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
                background: var(--app-primary) !important;
                color: #FFFFFF !important;
            }

            .reset-body {
                color: #F8FAFC !important;
            }

            .form-control {
                background: #0F172A !important;
                color: #F8FAFC !important;
                border-color: #334155 !important;
            }

            .form-control:disabled {
                background: #111827 !important;
                color: #CBD5E1 !important;
            }

            .form-control::placeholder {
                color: #94A3B8 !important;
            }

            .security-badge {
                background: rgba(37, 99, 235, 0.18) !important;
                color: #93C5FD !important;
            }
        @endif

        @media (max-width: 900px) {
            .reset-container {
                grid-template-columns: 1fr;
                max-width: 500px;
            }

            .security-animation {
                height: 170px;
            }
        }

        @media (max-width: 576px) {
            .reset-wrapper {
                padding: 86px 12px 16px;
            }

            .top-switch {
                top: 14px;
                right: 14px;
                left: 14px;
                justify-content: center;
            }

            .security-panel {
                display: none;
            }

            .reset-container {
                max-width: 410px;
            }

            .reset-header {
                padding: 22px 20px;
            }

            .reset-body {
                padding: 20px;
            }

            .reset-title {
                font-size: 20px;
            }
        }
    </style>
</head>

<body>

<div class="reset-wrapper">

    <div class="top-switch">
        <div class="switch-group">
            <a href="{{ route('admin.lang', 'fr') }}"
               class="switch-btn {{ $locale === 'fr' ? 'active' : '' }}">
                🇫🇷 FR
            </a>

            <a href="{{ route('admin.lang', 'mg') }}"
               class="switch-btn {{ $locale === 'mg' ? 'active' : '' }}">
                🇲🇬 MG
            </a>
        </div>

        <div class="switch-group">
            <a href="{{ route('admin.theme', 'light') }}"
               class="switch-btn {{ $theme === 'light' ? 'active' : '' }}">
                ☀️ {{ $t['light'] }}
            </a>

            <a href="{{ route('admin.theme', 'dark') }}"
               class="switch-btn {{ $theme === 'dark' ? 'active' : '' }}">
                🌙 {{ $t['dark'] }}
            </a>
        </div>
    </div>

    <div class="reset-container">

        <div class="security-panel">
            <div class="security-badge">
                🔐 {{ $t['badge'] }}
            </div>

            <h1>{{ $t['info_title'] }}</h1>

            <p>
                {{ $t['info_text'] }}
            </p>

            <div class="security-animation">
                <div class="security-step step-one">🔑 {{ $t['rule_1'] }}</div>
                <div class="security-step step-two">🛡️ {{ $t['rule_2'] }}</div>
                <div class="security-step step-three">✅ {{ $t['rule_3'] }}</div>

                <div class="lock-circle">
                    🔐
                </div>
            </div>
        </div>

        <div class="card reset-card">

            <div class="reset-header">
                <div class="reset-icon">
                    🔑
                </div>

                <h1 class="reset-title">
                    {{ $t['title'] }}
                </h1>

                <p class="reset-subtitle">
                    {{ $t['subtitle'] }}
                </p>
            </div>

            <div class="reset-body">

                @if($errors->any())
                    <div class="alert alert-danger border-0 rounded-4">
                        @foreach($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                @endif

                <form action="{{ route('admin.password.reset') }}" method="POST">
                    @csrf

                    <input type="hidden" name="token" value="{{ $token }}">
                    <input type="hidden" name="email" value="{{ $email }}">

                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            {{ $t['email'] }}
                        </label>

                        <input
                            type="email"
                            class="form-control"
                            value="{{ $email }}"
                            disabled
                        >
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            {{ $t['new_password'] }}
                        </label>

                        <input
                            type="password"
                            name="password"
                            class="form-control"
                            required
                        >
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">
                            {{ $t['confirm_password'] }}
                        </label>

                        <input
                            type="password"
                            name="password_confirmation"
                            class="form-control"
                            required
                        >
                    </div>

                    <button type="submit" class="btn btn-primary btn-reset w-100">
                        {{ $t['reset_button'] }}
                    </button>
                </form>

                <div class="text-center mt-3">
                    <a href="{{ route('admin.login') }}" class="back-link">
                        ← {{ $t['back_login'] }}
                    </a>
                </div>

            </div>
        </div>

    </div>
</div>

</body>
</html>
