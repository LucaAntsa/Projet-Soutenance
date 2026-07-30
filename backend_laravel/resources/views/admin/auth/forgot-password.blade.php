@php
    $locale = session('admin_locale', 'fr');
    $theme = session('admin_theme', 'light');

    $texts = [
        'fr' => [
            'page_title' => 'Mot de passe oublié - Administration',
            'title' => 'Mot de passe oublié',
            'subtitle' => 'Entrez votre email administrateur ou expert.',
            'email' => 'Adresse email',
            'send_link' => 'Envoyer le lien',
            'back_login' => 'Retour à la connexion',
            'light' => 'Clair',
            'dark' => 'Sombre',

            'badge' => 'Récupération du compte',
            'info_title' => 'Récupérer votre accès',
            'info_text' => 'Un lien sécurisé sera envoyé à votre adresse email pour créer un nouveau mot de passe.',
            'step_1' => 'Saisir email',
            'step_2' => 'Recevoir le lien',
            'step_3' => 'Créer mot de passe',
        ],
        'mg' => [
            'page_title' => 'Tenimiafina adino - Administration',
            'title' => 'Adino ny tenimiafina',
            'subtitle' => 'Ampidiro ny email admin na expert.',
            'email' => 'Adiresy email',
            'send_link' => 'Handefa rohy',
            'back_login' => 'Hiverina amin’ny fidirana',
            'light' => 'Mazava',
            'dark' => 'Maizina',

            'badge' => 'Famerenana kaonty',
            'info_title' => 'Avereno ny fidiranao',
            'info_text' => 'Rohy azo antoka no halefa amin’ny email-nao mba hamoronana tenimiafina vaovao.',
            'step_1' => 'Ampidiro email',
            'step_2' => 'Raiso ny rohy',
            'step_3' => 'Ovay tenimiafina',
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

        .forgot-wrapper {
            min-height: 100vh;
            padding: 72px 20px 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        .forgot-wrapper::before {
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

        .forgot-container {
            width: 100%;
            max-width: 900px;
            display: grid;
            grid-template-columns: 0.9fr 0.78fr;
            gap: 20px;
            position: relative;
            z-index: 2;
        }

        .recovery-panel,
        .forgot-card {
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 22px 55px rgba(15, 23, 42, 0.28);
            animation: fadeUp 0.7s ease both;
        }

        .recovery-panel {
            background: rgba(255, 255, 255, 0.92);
            padding: 24px;
            backdrop-filter: blur(12px);
        }

        .recovery-badge {
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

        .recovery-panel h1 {
            color: #0F172A;
            font-size: 26px;
            line-height: 1.15;
            font-weight: 900;
            margin-bottom: 10px;
        }

        .recovery-panel p {
            color: var(--app-muted);
            font-size: 13px;
            line-height: 1.5;
            margin-bottom: 18px;
        }

        .recovery-animation {
            height: 190px;
            border-radius: 20px;
            background: linear-gradient(135deg, var(--app-primary), var(--app-secondary));
            position: relative;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .recovery-animation::before {
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

        .recovery-animation::after {
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

        .mail-circle {
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
            animation: pulseMail 1.9s ease-in-out infinite;
            box-shadow: 0 18px 35px rgba(15, 23, 42, 0.22);
        }

        .recovery-step {
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

        .forgot-card {
            border: 0;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(12px);
            animation-delay: 0.12s;
        }

        .forgot-header {
            background: linear-gradient(135deg, var(--app-primary), var(--app-secondary));
            color: white;
            padding: 24px 22px;
            text-align: center;
        }

        .forgot-icon {
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

        .forgot-title {
            font-size: 22px;
            font-weight: 900;
            margin-bottom: 5px;
        }

        .forgot-subtitle {
            color: rgba(255, 255, 255, 0.86);
            margin-bottom: 0;
            font-size: 12px;
            line-height: 1.4;
        }

        .forgot-body {
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

        .btn-send {
            background: linear-gradient(135deg, var(--app-primary), var(--app-secondary));
            border: 0;
            border-radius: 14px;
            padding: 12px;
            font-size: 14px;
            font-weight: 800;
            transition: 0.24s ease;
        }

        .btn-send:hover {
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

        @keyframes pulseMail {
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

            .recovery-panel,
            .forgot-card {
                background: rgba(30, 41, 59, 0.94) !important;
                color: #F8FAFC !important;
                box-shadow: none !important;
            }

            .recovery-panel h1 {
                color: #F8FAFC !important;
            }

            .recovery-panel p,
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

            .forgot-body {
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

            .recovery-badge {
                background: rgba(37, 99, 235, 0.18) !important;
                color: #93C5FD !important;
            }
        @endif

        @media (max-width: 900px) {
            .forgot-container {
                grid-template-columns: 1fr;
                max-width: 500px;
            }

            .recovery-animation {
                height: 170px;
            }
        }

        @media (max-width: 576px) {
            .forgot-wrapper {
                padding: 86px 12px 16px;
            }

            .top-switch {
                top: 14px;
                right: 14px;
                left: 14px;
                justify-content: center;
            }

            .recovery-panel {
                display: none;
            }

            .forgot-container {
                max-width: 410px;
            }

            .forgot-header {
                padding: 22px 20px;
            }

            .forgot-body {
                padding: 20px;
            }

            .forgot-title {
                font-size: 20px;
            }
        }
    </style>
</head>

<body>

<div class="forgot-wrapper">

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

    <div class="forgot-container">

        <div class="recovery-panel">
            <div class="recovery-badge">
                🔑 {{ $t['badge'] }}
            </div>

            <h1>{{ $t['info_title'] }}</h1>

            <p>
                {{ $t['info_text'] }}
            </p>

            <div class="recovery-animation">
                <div class="recovery-step step-one">📧 {{ $t['step_1'] }}</div>
                <div class="recovery-step step-two">🔗 {{ $t['step_2'] }}</div>
                <div class="recovery-step step-three">🔐 {{ $t['step_3'] }}</div>

                <div class="mail-circle">
                    📩
                </div>
            </div>
        </div>

        <div class="card forgot-card">

            <div class="forgot-header">
                <div class="forgot-icon">
                    🔑
                </div>

                <h1 class="forgot-title">
                    {{ $t['title'] }}
                </h1>

                <p class="forgot-subtitle">
                    {{ $t['subtitle'] }}
                </p>
            </div>

            <div class="forgot-body">

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

                <form action="{{ route('admin.password.email') }}" method="POST">
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

                    <button type="submit" class="btn btn-primary btn-send w-100">
                        {{ $t['send_link'] }}
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
