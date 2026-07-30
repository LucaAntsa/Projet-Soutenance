@php
    $locale = session('admin_locale', 'fr');
    $theme = session('admin_theme', 'light');

    $texts = [
        'fr' => [
            'page_title' => 'Vérification 2FA - Administration',
            'title' => 'Vérification 2FA',
            'subtitle' => 'Un code à 6 chiffres a été envoyé à votre adresse email.',
            'code_label' => 'Code de vérification',
            'verify_button' => 'Vérifier le code',
            'resend_button' => 'Renvoyer un nouveau code',
            'back_login' => 'Retour à la connexion',
            'light' => 'Clair',
            'dark' => 'Sombre',
            'badge' => 'Sécurité du compte',
            'info_title' => 'Protection renforcée',
            'info_text' => 'Cette étape permet de confirmer votre identité avant d’accéder à l’interface d’administration.',
            'step_1' => 'Email envoyé',
            'step_2' => 'Code à saisir',
            'step_3' => 'Accès sécurisé',
        ],
        'mg' => [
            'page_title' => 'Fanamarinana 2FA - Administration',
            'title' => 'Fanamarinana 2FA',
            'subtitle' => 'Kaody 6 isa no nalefa tany amin’ny adiresy email-nao.',
            'code_label' => 'Kaody fanamarinana',
            'verify_button' => 'Hanamarina ny kaody',
            'resend_button' => 'Handefa kaody vaovao',
            'back_login' => 'Hiverina amin’ny fidirana',
            'light' => 'Mazava',
            'dark' => 'Maizina',
            'badge' => 'Fiarovana kaonty',
            'info_title' => 'Fiarovana nohamafisina',
            'info_text' => 'Ity dingana ity dia manamarina ny maha ianao anao alohan’ny hidirana amin’ny interface fitantanana.',
            'step_1' => 'Email nalefa',
            'step_2' => 'Ampidiro ny kaody',
            'step_3' => 'Fidirana voaaro',
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

        .twofa-wrapper {
            min-height: 100vh;
            padding: 72px 20px 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        .twofa-wrapper::before {
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
            color: var(--app-primary);
            background: #EFF6FF;
        }

        .switch-btn.active {
            background: var(--app-primary);
            color: #FFFFFF;
        }

        .twofa-container {
            width: 100%;
            max-width: 900px;
            display: grid;
            grid-template-columns: 0.9fr 0.8fr;
            gap: 20px;
            position: relative;
            z-index: 2;
        }

        .security-panel,
        .twofa-card {
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

        .twofa-card {
            border: 0;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(12px);
            animation-delay: 0.12s;
        }

        .twofa-header {
            background: linear-gradient(135deg, var(--app-primary), var(--app-secondary));
            color: white;
            padding: 24px 22px;
            text-align: center;
        }

        .twofa-icon {
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

        .twofa-title {
            font-size: 22px;
            font-weight: 900;
            margin-bottom: 5px;
        }

        .twofa-subtitle {
            color: rgba(255, 255, 255, 0.86);
            margin-bottom: 0;
            font-size: 12px;
            line-height: 1.4;
        }

        .twofa-body {
            padding: 22px 24px;
        }

        .form-label {
            font-size: 13px;
            margin-bottom: 6px;
        }

        .form-control {
            border-radius: 14px;
            padding: 12px 15px;
            border: 1px solid #CBD5E1;
            text-align: center;
            letter-spacing: 7px;
            font-size: 24px;
            font-weight: 900;
            color: #0F172A;
            transition: all 0.22s ease;
        }

        .form-control:focus {
            border-color: var(--app-primary);
            box-shadow: 0 0 0 0.18rem rgba(37, 99, 235, 0.15);
        }

        .btn-verify {
            background: linear-gradient(135deg, var(--app-primary), var(--app-secondary));
            border: 0;
            border-radius: 14px;
            padding: 12px;
            font-size: 14px;
            font-weight: 800;
            transition: 0.24s ease;
        }

        .btn-verify:hover {
            transform: translateY(-2px);
            box-shadow: 0 14px 26px rgba(37, 99, 235, 0.22);
        }

        .btn-resend {
            color: var(--app-primary);
            font-weight: 800;
            font-size: 13px;
            text-decoration: none;
            background: transparent;
            border: 0;
        }

        .btn-resend:hover {
            text-decoration: underline;
        }

        .back-link {
            color: var(--app-muted);
            text-decoration: none;
            font-size: 13px;
            font-weight: 700;
        }

        .back-link:hover {
            color: var(--app-primary);
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
            .twofa-card {
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

            .twofa-body {
                color: #F8FAFC !important;
            }

            .form-control {
                background: #0F172A !important;
                color: #F8FAFC !important;
                border-color: #334155 !important;
            }

            .form-control::placeholder {
                color: #94A3B8 !important;
            }

            .back-link {
                color: #CBD5E1 !important;
            }

            .back-link:hover {
                color: #FFFFFF !important;
            }

            .security-badge {
                background: rgba(37, 99, 235, 0.18) !important;
                color: #93C5FD !important;
            }
        @endif

        @media (max-width: 900px) {
            .twofa-container {
                grid-template-columns: 1fr;
                max-width: 500px;
            }

            .security-animation {
                height: 170px;
            }
        }

        @media (max-width: 576px) {
            .twofa-wrapper {
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

            .twofa-container {
                max-width: 410px;
            }

            .twofa-header {
                padding: 22px 20px;
            }

            .twofa-body {
                padding: 20px;
            }

            .twofa-title {
                font-size: 20px;
            }
        }
    </style>
</head>

<body>

<div class="twofa-wrapper">

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

    <div class="twofa-container">

        <div class="security-panel">
            <div class="security-badge">
                🔐 {{ $t['badge'] }}
            </div>

            <h1>{{ $t['info_title'] }}</h1>

            <p>
                {{ $t['info_text'] }}
            </p>

            <div class="security-animation">
                <div class="security-step step-one">📩 {{ $t['step_1'] }}</div>
                <div class="security-step step-two">🔢 {{ $t['step_2'] }}</div>
                <div class="security-step step-three">✅ {{ $t['step_3'] }}</div>

                <div class="lock-circle">
                    🔐
                </div>
            </div>
        </div>

        <div class="card twofa-card">

            <div class="twofa-header">
                <div class="twofa-icon">
                    🔐
                </div>

                <h1 class="twofa-title">
                    {{ $t['title'] }}
                </h1>

                <p class="twofa-subtitle">
                    {{ $t['subtitle'] }}
                </p>
            </div>

            <div class="twofa-body">

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

                <form action="{{ route('admin.2fa.verify') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            {{ $t['code_label'] }}
                        </label>

                        <input
                            type="text"
                            name="code"
                            class="form-control"
                            maxlength="6"
                            inputmode="numeric"
                            pattern="[0-9]{6}"
                            placeholder="------"
                            required
                            autofocus
                        >
                    </div>

                    <button type="submit" class="btn btn-primary btn-verify w-100">
                        {{ $t['verify_button'] }}
                    </button>
                </form>

                <form action="{{ route('admin.2fa.resend') }}" method="POST" class="text-center mt-3">
                    @csrf

                    <button type="submit" class="btn-resend">
                        {{ $t['resend_button'] }}
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
