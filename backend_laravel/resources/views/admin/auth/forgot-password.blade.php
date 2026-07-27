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

        .forgot-wrapper {
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

        .forgot-card {
            width: 100%;
            max-width: 480px;
            border: 0;
            border-radius: 26px;
            box-shadow: 0 18px 40px rgba(15, 23, 42, 0.12);
            overflow: hidden;
        }

        .forgot-header {
            background: linear-gradient(135deg, #2563EB, #1D4ED8);
            color: white;
            padding: 34px 26px;
            text-align: center;
        }

        .forgot-icon {
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

        .forgot-title {
            font-size: 26px;
            font-weight: 800;
            margin-bottom: 8px;
        }

        .forgot-subtitle {
            color: rgba(255, 255, 255, 0.82);
            margin-bottom: 0;
            font-size: 14px;
        }

        .forgot-body {
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

        .btn-send {
            background: #2563EB;
            border: 0;
            border-radius: 14px;
            padding: 13px;
            font-weight: 700;
        }

        .btn-send:hover {
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

            .forgot-body {
                background: #1E293B !important;
                color: #F8FAFC !important;
            }

            .forgot-card {
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
        @endif

        @media (max-width: 576px) {
            .forgot-wrapper {
                padding: 78px 14px 14px;
            }

            .top-switch {
                top: 14px;
                right: 14px;
                left: 14px;
                justify-content: center;
            }

            .forgot-header {
                padding: 28px 20px;
            }

            .forgot-body {
                padding: 24px 20px;
            }

            .forgot-title {
                font-size: 23px;
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
                    {{ $t['back_login'] }}
                </a>
            </div>

        </div>
    </div>
</div>

</body>
</html>
