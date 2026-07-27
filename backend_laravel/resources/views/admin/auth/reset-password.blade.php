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

        .reset-wrapper {
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

        .reset-card {
            width: 100%;
            max-width: 480px;
            border: 0;
            border-radius: 26px;
            box-shadow: 0 18px 40px rgba(15, 23, 42, 0.12);
            overflow: hidden;
        }

        .reset-header {
            background: linear-gradient(135deg, #2563EB, #1D4ED8);
            color: white;
            padding: 34px 26px;
            text-align: center;
        }

        .reset-icon {
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

        .reset-title {
            font-size: 26px;
            font-weight: 800;
            margin-bottom: 8px;
        }

        .reset-subtitle {
            color: rgba(255, 255, 255, 0.82);
            margin-bottom: 0;
            font-size: 14px;
        }

        .reset-body {
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

        .form-control:disabled {
            background: #F8FAFC;
            color: #64748B;
        }

        .btn-reset {
            background: #2563EB;
            border: 0;
            border-radius: 14px;
            padding: 13px;
            font-weight: 700;
        }

        .btn-reset:hover {
            background: #1D4ED8;
        }

        .back-link {
            color: #2563EB;
            font-weight: 700;
            text-decoration: none;
        }

        .back-link:hover {
            text-decoration: underline;
        }

        @if($theme === 'dark')
            body {
                background: #0F172A !important;
                color: #F8FAFC !important;
            }

            .reset-body {
                background: #1E293B !important;
                color: #F8FAFC !important;
            }

            .reset-card {
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

            .form-control:disabled {
                background: #111827 !important;
                color: #CBD5E1 !important;
            }

            .text-muted {
                color: #CBD5E1 !important;
            }
        @endif

        @media (max-width: 576px) {
            .reset-wrapper {
                padding: 78px 14px 14px;
            }

            .top-switch {
                top: 14px;
                right: 14px;
                left: 14px;
                justify-content: center;
            }

            .reset-header {
                padding: 28px 20px;
            }

            .reset-body {
                padding: 24px 20px;
            }

            .reset-title {
                font-size: 23px;
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

    <div class="card reset-card">

        <div class="reset-header">
            <div class="reset-icon">
                🔐
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
                    {{ $t['back_login'] }}
                </a>
            </div>

        </div>
    </div>
</div>

</body>
</html>
