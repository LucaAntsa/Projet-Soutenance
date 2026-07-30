@php
    $locale = session('admin_locale', 'fr');
    $theme = session('admin_theme', 'light');

    $texts = [
        'fr' => [
            'page_title' => 'Connexion - Administration',
            'app_name' => 'Éducation Familiale',
            'subtitle' => 'Plateforme web et mobile d’éducation familiale',
            'login' => 'Connexion',
            'login_text' => 'Accédez à votre espace administrateur ou expert.',
            'email' => 'Adresse email',
            'password' => 'Mot de passe',
            'forgot_password' => 'Mot de passe oublié ?',
            'login_button' => 'Se connecter',
            'qr_text' => 'Scanner pour accéder à l’inscription',
            'no_account' => 'Vous n’avez pas encore de compte ?',
            'create_account' => 'Créer un compte',
            'light' => 'Clair',
            'dark' => 'Sombre',

            'video_badge' => 'Éducation familiale à Madagascar',
            'video_title' => 'Apprendre, accompagner et progresser ensemble',
            'video_text' => 'Une solution conçue pour renforcer les compétences parentales à travers des modules, conseils, quiz et suivis éducatifs.',
            'video_label' => 'Présentation du projet',
            'video_module' => 'Modules',
            'video_quiz' => 'Quiz',
            'video_follow' => 'Suivi',
            'login_link' => 'Connexion',
            'register_link' => 'Inscription',
        ],
        'mg' => [
            'page_title' => 'Hiditra - Administration',
            'app_name' => 'Fanabeazana ara-pianakaviana',
            'subtitle' => 'Sehatra web sy mobile ho an’ny fanabeazana ara-pianakaviana',
            'login' => 'Hiditra',
            'login_text' => 'Midira amin’ny sehatra admin na expert.',
            'email' => 'Adiresy email',
            'password' => 'Tenimiafina',
            'forgot_password' => 'Adino ny tenimiafina ?',
            'login_button' => 'Hiditra',
            'qr_text' => 'Scan-na raha hiditra amin’ny fisoratana anarana',
            'no_account' => 'Mbola tsy manana kaonty ?',
            'create_account' => 'Hamorona kaonty',
            'light' => 'Mazava',
            'dark' => 'Maizina',

            'video_badge' => 'Fanabeazana ara-pianakaviana eto Madagasikara',
            'video_title' => 'Mianatra, manampy ary mandroso miaraka',
            'video_text' => 'Vahaolana natao hanamafisana ny fahaiza-manaon’ny ray aman-dreny amin’ny alalan’ny modules, torohevitra, quiz ary fanaraha-maso.',
            'video_label' => 'Fampahafantarana ny tetikasa',
            'video_module' => 'Modules',
            'video_quiz' => 'Quiz',
            'video_follow' => 'Fanaraha-maso',
            'login_link' => 'Hiditra',
            'register_link' => 'Hisoratra',
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
            --app-orange: #F97316;
            --app-success: #22C55E;
            --app-danger: #EF4444;
            --app-purple: #9333EA;
            --app-bg: #F8FAFC;
            --app-dark: #0F172A;
            --app-card: #FFFFFF;
            --app-dark-card: #1E293B;
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
                linear-gradient(rgba(15, 23, 42, 0.64), rgba(15, 23, 42, 0.76)),
                url('/images/auth-family-bg.png');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            overflow-x: hidden;
        }

        .auth-wrapper {
            min-height: 100vh;
            padding: 28px;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        .auth-wrapper::before {
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
            top: 18px;
            right: 22px;
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
            padding: 7px 12px;
            font-size: 12px;
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

        .auth-container {
            width: 100%;
            max-width: 1120px;
            display: grid;
            grid-template-columns: 1.05fr 0.95fr;
            gap: 26px;
            position: relative;
            z-index: 2;
        }

        .auth-showcase,
        .login-card {
            border-radius: 28px;
            overflow: hidden;
            box-shadow: 0 24px 60px rgba(15, 23, 42, 0.30);
            animation: fadeUp 0.7s ease both;
        }

        .auth-showcase {
            background: rgba(255, 255, 255, 0.92);
            padding: 28px;
            backdrop-filter: blur(12px);
        }

        .showcase-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: #DBEAFE;
            color: var(--app-primary);
            padding: 8px 14px;
            border-radius: 999px;
            font-size: 13px;
            font-weight: 800;
            margin-bottom: 16px;
        }

        .auth-showcase h1 {
            color: #0F172A;
            font-size: 31px;
            line-height: 1.15;
            font-weight: 900;
            margin-bottom: 12px;
        }

        .auth-showcase p {
            color: var(--app-muted);
            font-size: 15px;
            line-height: 1.6;
            margin-bottom: 20px;
        }

        .project-video {
            height: 270px;
            border-radius: 24px;
            background: linear-gradient(135deg, var(--app-primary), var(--app-secondary));
            position: relative;
            overflow: hidden;
            box-shadow: inset 0 0 0 1px rgba(255,255,255,0.22);
        }

        .project-video::before {
            content: "";
            position: absolute;
            width: 230px;
            height: 230px;
            border-radius: 50%;
            background: rgba(255,255,255,0.16);
            top: -75px;
            right: -75px;
            animation: floatCircle 5s ease-in-out infinite;
        }

        .project-video::after {
            content: "";
            position: absolute;
            width: 170px;
            height: 170px;
            border-radius: 50%;
            background: rgba(255,255,255,0.12);
            bottom: -60px;
            left: -50px;
            animation: floatCircle 6s ease-in-out infinite reverse;
        }

        .video-content {
            position: relative;
            z-index: 2;
            height: 100%;
            padding: 24px;
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .video-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .video-title {
            font-size: 18px;
            font-weight: 900;
        }

        .video-play {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            background: #FFFFFF;
            color: var(--app-primary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 19px;
            box-shadow: 0 10px 24px rgba(15, 23, 42, 0.18);
            animation: pulsePlay 1.8s ease-in-out infinite;
        }

        .video-family {
            display: flex;
            align-items: end;
            justify-content: center;
            gap: 18px;
            padding-top: 18px;
        }

        .person {
            width: 56px;
            height: 92px;
            border-radius: 30px 30px 14px 14px;
            background: rgba(255,255,255,0.94);
            position: relative;
            animation: floatPerson 2.7s ease-in-out infinite;
        }

        .person::before {
            content: "";
            width: 35px;
            height: 35px;
            border-radius: 50%;
            background: var(--app-accent);
            position: absolute;
            top: -25px;
            left: 10px;
        }

        .person.small {
            width: 42px;
            height: 68px;
            animation-delay: 0.25s;
        }

        .person.small::before {
            width: 28px;
            height: 28px;
            top: -20px;
            left: 7px;
            background: var(--app-orange);
        }

        .person.green::before {
            background: var(--app-success);
        }

        .video-bottom {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 10px;
        }

        .video-stat {
            background: rgba(255,255,255,0.18);
            border: 1px solid rgba(255,255,255,0.22);
            padding: 10px;
            border-radius: 16px;
            backdrop-filter: blur(8px);
        }

        .video-stat strong {
            display: block;
            font-size: 15px;
            font-weight: 900;
        }

        .video-stat span {
            font-size: 11px;
            opacity: 0.92;
        }

        .auth-switch-buttons {
            display: flex;
            gap: 12px;
            margin-top: 18px;
        }

        .auth-switch-btn {
            flex: 1;
            text-align: center;
            text-decoration: none;
            padding: 13px 16px;
            border-radius: 16px;
            font-weight: 900;
            transition: 0.25s ease;
        }

        .auth-switch-btn.login {
            background: var(--app-primary);
            color: white;
        }

        .auth-switch-btn.register {
            background: var(--app-accent);
            color: white;
        }

        .auth-switch-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 14px 26px rgba(15, 23, 42, 0.18);
        }

        .login-card {
            border: 0;
            background: rgba(255, 255, 255, 0.95);
            animation-delay: 0.12s;
            backdrop-filter: blur(12px);
        }

        .login-header {
            background: linear-gradient(135deg, var(--app-primary), var(--app-secondary));
            color: white;
            padding: 30px 26px;
            text-align: center;
        }

        .login-icon {
            width: 72px;
            height: 72px;
            border-radius: 23px;
            background: white;
            color: var(--app-primary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 35px;
            margin: 0 auto 15px;
            box-shadow: 0 12px 26px rgba(15, 23, 42, 0.15);
        }

        .login-title {
            font-size: 25px;
            font-weight: 900;
            margin-bottom: 7px;
        }

        .login-subtitle {
            color: rgba(255, 255, 255, 0.86);
            margin-bottom: 0;
            font-size: 14px;
        }

        .login-body {
            padding: 28px 30px;
        }

        .form-control {
            border-radius: 14px;
            padding: 13px 15px;
            border: 1px solid #CBD5E1;
        }

        .form-control:focus {
            border-color: var(--app-primary);
            box-shadow: 0 0 0 0.18rem rgba(37, 99, 235, 0.15);
        }

        .btn-login {
            background: linear-gradient(135deg, var(--app-primary), var(--app-secondary));
            border: 0;
            border-radius: 14px;
            padding: 13px;
            font-weight: 800;
            transition: 0.24s ease;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 14px 26px rgba(37, 99, 235, 0.22);
        }

        .qr-box {
            background: #F8FAFC;
            border-radius: 18px;
            padding: 16px;
            text-align: center;
            margin-top: 20px;
        }

        .qr-box img {
            max-width: 118px;
            border-radius: 12px;
            background: white;
            padding: 8px;
            border: 1px solid #E2E8F0;
        }

        .register-link {
            color: var(--app-primary);
            font-weight: 800;
            text-decoration: none;
        }

        .register-link:hover {
            text-decoration: underline;
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
                transform: translateY(0);
            }

            50% {
                transform: translateY(18px);
            }
        }

        @keyframes pulsePlay {
            0%, 100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.10);
            }
        }

        @keyframes floatPerson {
            0%, 100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-8px);
            }
        }

        @if($theme === 'dark')
            body {
                background:
                    linear-gradient(rgba(15, 23, 42, 0.78), rgba(15, 23, 42, 0.88)),
                    url('/images/auth-family-bg.png') !important;
                background-size: cover !important;
                background-position: center !important;
                background-repeat: no-repeat !important;
                color: #F8FAFC !important;
            }

            .auth-showcase,
            .login-card {
                background: rgba(30, 41, 59, 0.94) !important;
                color: #F8FAFC !important;
                box-shadow: none !important;
            }

            .auth-showcase h1,
            .login-body h3 {
                color: #F8FAFC !important;
            }

            .auth-showcase p,
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

            .form-control {
                background: #0F172A !important;
                color: #F8FAFC !important;
                border-color: #334155 !important;
            }

            .qr-box {
                background: #0F172A !important;
                border: 1px solid #334155;
            }

            .qr-box img {
                border-color: #334155 !important;
            }

            .showcase-badge {
                background: rgba(37, 99, 235, 0.18) !important;
                color: #93C5FD !important;
            }
        @endif

        @media (max-width: 992px) {
            .auth-container {
                grid-template-columns: 1fr;
                max-width: 620px;
            }

            .project-video {
                height: 240px;
            }
        }

        @media (max-width: 576px) {
            .auth-wrapper {
                padding: 88px 14px 18px;
            }

            .top-switch {
                top: 14px;
                right: 14px;
                left: 14px;
                justify-content: center;
            }

            .auth-showcase,
            .login-body {
                padding: 22px;
            }

            .auth-showcase h1 {
                font-size: 25px;
            }

            .login-header {
                padding: 26px 20px;
            }

            .login-title {
                font-size: 23px;
            }

            .auth-switch-buttons {
                flex-direction: column;
            }

            .video-bottom {
                grid-template-columns: 1fr;
            }

            .project-video {
                height: 310px;
            }
        }
    /* Ajustement compact spécial LOGIN */

.auth-wrapper {
    padding: 70px 18px 16px !important;
}

.auth-container {
    max-width: 1000px !important;
    gap: 18px !important;
    grid-template-columns: 0.9fr 0.78fr !important;
}

.auth-showcase {
    padding: 20px !important;
}

.auth-showcase h1 {
    font-size: 23px !important;
    line-height: 1.15 !important;
    margin-bottom: 8px !important;
}

.auth-showcase p {
    font-size: 12.5px !important;
    line-height: 1.42 !important;
    margin-bottom: 12px !important;
}

.showcase-badge {
    font-size: 11px !important;
    padding: 6px 11px !important;
    margin-bottom: 10px !important;
}

.project-video {
    height: 185px !important;
    border-radius: 18px !important;
}

.video-content {
    padding: 15px !important;
}

.video-title {
    font-size: 14px !important;
}

.video-play {
    width: 36px !important;
    height: 36px !important;
    font-size: 14px !important;
}

.video-family {
    gap: 12px !important;
    padding-top: 4px !important;
}

.person {
    width: 40px !important;
    height: 62px !important;
}

.person::before {
    width: 25px !important;
    height: 25px !important;
    top: -18px !important;
    left: 7px !important;
}

.person.small {
    width: 31px !important;
    height: 48px !important;
}

.person.small::before {
    width: 20px !important;
    height: 20px !important;
    top: -15px !important;
    left: 5px !important;
}

.video-stat {
    padding: 6px !important;
    border-radius: 11px !important;
}

.video-stat strong {
    font-size: 12px !important;
}

.video-stat span {
    font-size: 9.5px !important;
}

.auth-switch-buttons {
    margin-top: 12px !important;
    gap: 8px !important;
}

.auth-switch-btn {
    padding: 9px 12px !important;
    font-size: 12px !important;
    border-radius: 12px !important;
}

.login-card {
    max-width: 430px !important;
    border-radius: 22px !important;
}

.login-header {
    padding: 18px 20px !important;
}

.login-icon {
    width: 52px !important;
    height: 52px !important;
    border-radius: 16px !important;
    font-size: 26px !important;
    margin-bottom: 8px !important;
}

.login-title {
    font-size: 20px !important;
    margin-bottom: 4px !important;
}

.login-subtitle {
    font-size: 12px !important;
}

.login-body {
    padding: 18px 20px !important;
}

.login-body h3 {
    font-size: 20px !important;
}

.login-body p,
.text-muted {
    font-size: 12.5px !important;
}

.form-label {
    font-size: 12px !important;
    margin-bottom: 4px !important;
}

.form-control {
    padding: 8px 10px !important;
    border-radius: 10px !important;
    font-size: 13px !important;
}

.login-body .mb-3 {
    margin-bottom: 9px !important;
}

.btn-login {
    padding: 10px !important;
    font-size: 13px !important;
    border-radius: 11px !important;
}

.qr-box {
    margin-top: 12px !important;
    padding: 10px !important;
    border-radius: 13px !important;
}

.qr-box img {
    max-width: 80px !important;
    padding: 5px !important;
}

.register-link {
    font-size: 12.5px !important;
}

.top-switch {
    top: 12px !important;
    right: 16px !important;
}

.switch-btn {
    padding: 5px 9px !important;
    font-size: 10.5px !important;
}

@media (max-width: 992px) {
    .auth-container {
        grid-template-columns: 1fr !important;
        max-width: 520px !important;
    }

    .project-video {
        height: 190px !important;
    }
}

@media (max-width: 576px) {
    .auth-wrapper {
        padding: 86px 12px 16px !important;
    }

    .auth-showcase {
        display: none !important;
    }

    .auth-container {
        max-width: 410px !important;
    }

    .login-body {
        padding: 18px !important;
    }

    .login-title {
        font-size: 20px !important;
    }
}
/* Ajustement propre de la vraie vidéo */

.project-video.real-video-box {
    height: 210px !important;
    border-radius: 18px !important;
    position: relative !important;
    overflow: hidden !important;
    background: #0F172A !important;
    box-shadow: 0 12px 26px rgba(15, 23, 42, 0.22) !important;
}

/*-shadow: 0 12px  Pour ne pas trop zoomer la vidéo */
.project-real-video {
    width: 100% !important;
    height: 100% !important;
    object-fit: contain !important;
    object-position: center !important;
    background: #0F172A !important;
    display: block !important;
}

/* On désactive les anciens cercles animés du faux design */
.real-video-box::before,
.real-video-box::after {
    display: none !important;
}

/* Overlay lisible */
.real-video-overlay {
    position: absolute !important;
    inset: 0 !important;
    padding: 14px !important;
    color: #ffffff !important;
    background:
        linear-gradient(
            180deg,
            rgba(15, 23, 42, 0.55),
            rgba(15, 23, 42, 0.06),
            rgba(15, 23, 42, 0.72)
        ) !important;
    display: flex !important;
    flex-direction: column !important;
    justify-content: space-between !important;
    pointer-events: none !important;
}

.real-video-top {
    display: flex !important;
    align-items: center !important;
    justify-content: space-between !important;
}

.video-title {
    font-size: 13px !important;
    font-weight: 900 !important;
}

.video-mini-text {
    font-size: 10px !important;
    opacity: 0.88 !important;
    margin-top: 2px !important;
}

.video-play {
    width: 34px !important;
    height: 34px !important;
    border-radius: 50% !important;
    background: rgba(255, 255, 255, 0.95) !important;
    color: #2563EB !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    font-size: 13px !important;
    box-shadow: 0 8px 18px rgba(15, 23, 42, 0.22) !important;
    animation: pulsePlay 1.8s ease-in-out infinite !important;
}

.real-video-bottom {
    display: flex !important;
    gap: 7px !important;
    flex-wrap: wrap !important;
}

.real-video-bottom span {
    background: rgba(255, 255, 255, 0.20) !important;
    border: 1px solid rgba(255, 255, 255, 0.25) !important;
    backdrop-filter: blur(8px) !important;
    padding: 5px 9px !important;
    border-radius: 999px !important;
    font-size: 10px !important;
    font-weight: 800 !important;
}

@keyframes pulsePlay {
    0%, 100% {
        transform: scale(1);
    }

    50% {
        transform: scale(1.08);
    }
}

    </style>
</head>

<body>

<div class="auth-wrapper">

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

    <div class="auth-container">

        <div class="auth-showcase">
            <div class="showcase-badge">
                🇲🇬 {{ $t['video_badge'] }}
            </div>

            <h1>{{ $t['video_title'] }}</h1>

            <p>
                {{ $t['video_text'] }}
            </p>

            @include('admin.auth.partials.project-video')

            <div class="auth-switch-buttons">
                <a href="{{ url()->current() }}" class="auth-switch-btn login">
                    {{ $t['login_link'] }}
                </a>

                <a href="{{ route('admin.register') }}" class="auth-switch-btn register">
                    {{ $t['register_link'] }}
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
</div>

</body>
</html>
