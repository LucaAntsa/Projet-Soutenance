@php
    $locale = session('admin_locale', 'fr');
    $theme = session('admin_theme', 'light');

    $texts = [
        'fr' => [
            'page_title' => 'Inscription - Administration',
            'app_name' => 'Éducation Familiale',
            'create_account' => 'Créer un compte',
            'subtitle' => 'Inscription administrateur ou expert',

            'admin_exists' => 'Un administrateur existe déjà. Les nouveaux comptes peuvent être créés uniquement avec le rôle expert.',
            'no_admin' => 'Aucun administrateur n’existe encore. Vous pouvez créer le premier compte administrateur.',

            'full_name' => 'Nom complet',
            'email' => 'Adresse email',
            'role' => 'Rôle',
            'choose_role' => 'Choisir un rôle',
            'password' => 'Mot de passe',
            'password_confirmation' => 'Confirmer le mot de passe',
            'register_button' => 'S’inscrire',

            'already_account' => 'Vous avez déjà un compte ?',
            'login' => 'Se connecter',

            'light' => 'Clair',
            'dark' => 'Sombre',
            'admin' => 'Admin',
            'expert' => 'Expert',

            'video_badge' => 'Éducation familiale à Madagascar',
            'video_title' => 'Créer un accès pour gérer l’éducation familiale',
            'video_text' => 'Cette plateforme permet aux administrateurs et experts de gérer les modules, conseils, quiz et suivis destinés aux parents.',
            'video_label' => 'Présentation du projet',
            'video_module' => 'Modules',
            'video_conseil' => 'Conseils',
            'video_quiz' => 'Quiz',
            'login_link' => 'Connexion',
            'register_link' => 'Inscription',
        ],
        'mg' => [
            'page_title' => 'Fisoratana anarana - Administration',
            'app_name' => 'Fanabeazana ara-pianakaviana',
            'create_account' => 'Hamorona kaonty',
            'subtitle' => 'Fisoratana anarana ho an’ny admin na expert',

            'admin_exists' => 'Efa misy administrateur. Ny kaonty vaovao dia azo foronina amin’ny rôle expert ihany.',
            'no_admin' => 'Mbola tsy misy administrateur. Afaka mamorona ny kaonty admin voalohany ianao.',

            'full_name' => 'Anarana feno',
            'email' => 'Adiresy email',
            'role' => 'Andraikitra',
            'choose_role' => 'Misafidiana andraikitra',
            'password' => 'Tenimiafina',
            'password_confirmation' => 'Hamarino ny tenimiafina',
            'register_button' => 'Hisoratra anarana',

            'already_account' => 'Efa manana kaonty ?',
            'login' => 'Hiditra',

            'light' => 'Mazava',
            'dark' => 'Maizina',
            'admin' => 'Admin',
            'expert' => 'Expert',

            'video_badge' => 'Fanabeazana ara-pianakaviana eto Madagasikara',
            'video_title' => 'Mamorona kaonty hitantanana ny fanabeazana',
            'video_text' => 'Ity sehatra ity dia manampy ny admin sy expert hitantana modules, torohevitra, quiz ary fanaraha-maso ho an’ny ray aman-dreny.',
            'video_label' => 'Fampahafantarana ny tetikasa',
            'video_module' => 'Modules',
            'video_conseil' => 'Torohevitra',
            'video_quiz' => 'Quiz',
            'login_link' => 'Hiditra',
            'register_link' => 'Hisoratra',
        ],
    ];

    $t = $texts[$locale] ?? $texts['fr'];

    $roleLabels = [
        'admin' => $t['admin'],
        'expert' => $t['expert'],
    ];
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
        .register-card {
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

        .register-card {
            border: 0;
            background: rgba(255, 255, 255, 0.95);
            animation-delay: 0.12s;
            backdrop-filter: blur(12px);
        }

        .register-header {
            background: linear-gradient(135deg, var(--app-primary), var(--app-secondary));
            color: white;
            padding: 26px 24px;
            text-align: center;
        }

        .register-icon {
            width: 68px;
            height: 68px;
            border-radius: 22px;
            background: white;
            color: var(--app-primary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 34px;
            margin: 0 auto 14px;
            box-shadow: 0 12px 26px rgba(15, 23, 42, 0.15);
        }

        .register-title {
            font-size: 24px;
            font-weight: 900;
            margin-bottom: 7px;
        }

        .register-subtitle {
            color: rgba(255, 255, 255, 0.86);
            margin-bottom: 0;
            font-size: 14px;
        }

        .register-body {
            padding: 24px 28px;
        }

        .form-control,
        .form-select {
            border-radius: 14px;
            padding: 12px 14px;
            border: 1px solid #CBD5E1;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--app-primary);
            box-shadow: 0 0 0 0.18rem rgba(37, 99, 235, 0.15);
        }

        .btn-register {
            background: linear-gradient(135deg, var(--app-primary), var(--app-secondary));
            border: 0;
            border-radius: 14px;
            padding: 13px;
            font-weight: 800;
            transition: 0.24s ease;
        }

        .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 14px 26px rgba(37, 99, 235, 0.22);
        }

        .login-link {
            color: var(--app-primary);
            font-weight: 800;
            text-decoration: none;
        }

        .login-link:hover {
            text-decoration: underline;
        }

        .info-box {
            background: #EFF6FF;
            color: var(--app-primary-dark);
            border-radius: 16px;
            padding: 12px 14px;
            font-size: 13px;
            margin-bottom: 16px;
            border: 1px solid #DBEAFE;
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
            .register-card {
                background: rgba(30, 41, 59, 0.94) !important;
                color: #F8FAFC !important;
                box-shadow: none !important;
            }

            .auth-showcase h1 {
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

            .register-body {
                color: #F8FAFC !important;
            }

            .form-control,
            .form-select {
                background: #0F172A !important;
                color: #F8FAFC !important;
                border-color: #334155 !important;
            }

            .info-box {
                background: #0F172A !important;
                color: #BFDBFE !important;
                border: 1px solid #334155;
            }

            .showcase-badge {
                background: rgba(37, 99, 235, 0.18) !important;
                color: #93C5FD !important;
            }
        @endif

       @media (max-width: 992px) {
    .auth-container {
        grid-template-columns: 1fr !important;
        max-width: 560px !important;
    }

    .project-video {
        height: 200px !important;
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
        max-width: 430px !important;
    }

    .login-body,
    .register-body {
        padding: 20px !important;
    }

    .login-title,
    .register-title {
        font-size: 20px !important;
    }
}
    /* Ajustement très compact pour la page inscription */

.auth-wrapper {
    padding: 70px 18px 16px !important;
}

.auth-container {
    max-width: 1040px !important;
    gap: 18px !important;
    grid-template-columns: 0.9fr 0.82fr !important;
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

.register-card {
    max-width: 470px !important;
    border-radius: 22px !important;
}

.register-header {
    padding: 18px 20px !important;
}

.register-icon {
    width: 52px !important;
    height: 52px !important;
    border-radius: 16px !important;
    font-size: 26px !important;
    margin-bottom: 8px !important;
}

.register-title {
    font-size: 20px !important;
    margin-bottom: 4px !important;
}

.register-subtitle {
    font-size: 12px !important;
}

.register-body {
    padding: 16px 20px !important;
}

.info-box {
    padding: 8px 10px !important;
    font-size: 11.5px !important;
    margin-bottom: 10px !important;
    border-radius: 12px !important;
}

.form-label {
    font-size: 12px !important;
    margin-bottom: 4px !important;
}

.form-control,
.form-select {
    padding: 8px 10px !important;
    border-radius: 10px !important;
    font-size: 13px !important;
}

.register-body .mb-3 {
    margin-bottom: 8px !important;
}

.register-body .mb-4 {
    margin-bottom: 10px !important;
}

.btn-register {
    padding: 10px !important;
    font-size: 13px !important;
    border-radius: 11px !important;
}

.register-body .text-center {
    font-size: 12.5px !important;
}

.alert {
    padding: 9px 11px !important;
    font-size: 12px !important;
    margin-bottom: 10px !important;
}

.top-switch {
    top: 12px !important;
    right: 16px !important;
}

.switch-btn {
    padding: 5px 9px !important;
    font-size: 10.5px !important;
}

/*Vrai Video*/
.project-video.real-video-box {
    height: 210px !important;
    border-radius: 18px !important;
    position: relative !important;
    overflow: hidden !important;
    background: #0F172A !important;
    box-shadow: 0 12px 26px rgba(15, 23, 42, 0.22) !important;
}

/* Pour ne pas trop zoomer la vidéo */
.project-real-video {
    width: 100% !important;
    height: 100% !important;
    object-fit: contain !important;
    object-position: center !important;
    background: #0F172A !important;
    display: block !important;
}


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
                <a href="{{ route('admin.login') }}" class="auth-switch-btn login">
                    {{ $t['login_link'] }}
                </a>

                <a href="{{ url()->current() }}" class="auth-switch-btn register">
                    {{ $t['register_link'] }}
                </a>
            </div>
        </div>

        <div class="card register-card">

            <div class="register-header">
                <div class="register-icon">
                    👤
                </div>

                <h1 class="register-title">
                    {{ $t['create_account'] }}
                </h1>

                <p class="register-subtitle">
                    {{ $t['subtitle'] }}
                </p>
            </div>

            <div class="register-body">

                @if($errors->any())
                    <div class="alert alert-danger border-0 rounded-4">
                        <ul class="mb-0 ps-3">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if($hasAdmin)
                    <div class="info-box">
                        {{ $t['admin_exists'] }}
                    </div>
                @else
                    <div class="info-box">
                        {{ $t['no_admin'] }}
                    </div>
                @endif

                <form action="{{ route('admin.register.submit') }}" method="POST">
                    @csrf

                    <div class="row g-2">
    <div class="col-md-6">
        <label class="form-label fw-semibold">
            {{ $t['full_name'] }}
        </label>

        <input
            type="text"
            name="name"
            class="form-control"
            value="{{ old('name') }}"
            required
        >
    </div>

    <div class="col-md-6">
        <label class="form-label fw-semibold">
            {{ $t['email'] }}
        </label>

        <input
            type="email"
            name="email"
            class="form-control"
            value="{{ old('email') }}"
            required
        >
    </div>

    <div class="col-12">
        <label class="form-label fw-semibold">
            {{ $t['role'] }}
        </label>

        <select name="role_id" class="form-select" required>
            <option value="">
                {{ $t['choose_role'] }}
            </option>

            @foreach($roles as $role)
                @if($role->name !== 'parent' && !($hasAdmin && $role->name === 'admin'))
                    <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>
                        {{ $roleLabels[$role->name] ?? ucfirst($role->name) }}
                    </option>
                @endif
            @endforeach
        </select>
    </div>

    <div class="col-md-6">
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

    <div class="col-md-6">
        <label class="form-label fw-semibold">
            {{ $t['password_confirmation'] }}
        </label>

        <input
            type="password"
            name="password_confirmation"
            class="form-control"
            required
        >
    </div>
</div>

<button type="submit" class="btn btn-primary btn-register w-100 mt-3">
    {{ $t['register_button'] }}
</button>
                </form>

                <div class="text-center mt-3">
                    <span class="text-muted">
                        {{ $t['already_account'] }}
                    </span>

                    <a href="{{ route('admin.login') }}" class="login-link">
                        {{ $t['login'] }}
                    </a>
                </div>

            </div>
        </div>

    </div>
</div>

</body>
</html>
