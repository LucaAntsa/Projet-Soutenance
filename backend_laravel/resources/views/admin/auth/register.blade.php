@php
    $locale = session('admin_locale', 'fr');
    $theme = session('admin_theme', 'light');

    $texts = [
        'fr' => [
            'page_title' => 'Inscription - Administration',
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
        ],
        'mg' => [
            'page_title' => 'Fisoratana anarana - Administration',
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
        body {
            background: #F3F6FB;
            min-height: 100vh;
            font-family: Arial, sans-serif;
        }

        .register-wrapper {
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

        .register-card {
            width: 100%;
            max-width: 540px;
            border: 0;
            border-radius: 26px;
            box-shadow: 0 18px 40px rgba(15, 23, 42, 0.12);
            overflow: hidden;
        }

        .register-header {
            background: linear-gradient(135deg, #2563EB, #1D4ED8);
            color: white;
            padding: 34px 26px;
            text-align: center;
        }

        .register-icon {
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

        .register-title {
            font-size: 26px;
            font-weight: 800;
            margin-bottom: 8px;
        }

        .register-subtitle {
            color: rgba(255, 255, 255, 0.82);
            margin-bottom: 0;
            font-size: 14px;
        }

        .register-body {
            background: white;
            padding: 30px;
        }

        .form-control,
        .form-select {
            border-radius: 14px;
            padding: 13px 15px;
            border: 1px solid #CBD5E1;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #2563EB;
            box-shadow: 0 0 0 0.18rem rgba(37, 99, 235, 0.15);
        }

        .btn-register {
            background: #2563EB;
            border: 0;
            border-radius: 14px;
            padding: 13px;
            font-weight: 700;
        }

        .btn-register:hover {
            background: #1D4ED8;
        }

        .login-link {
            color: #2563EB;
            font-weight: 700;
            text-decoration: none;
        }

        .login-link:hover {
            text-decoration: underline;
        }

        .info-box {
            background: #EFF6FF;
            color: #1D4ED8;
            border-radius: 16px;
            padding: 13px 15px;
            font-size: 14px;
            margin-bottom: 18px;
        }

        @if($theme === 'dark')
            body {
                background: #0F172A !important;
                color: #F8FAFC !important;
            }

            .register-body {
                background: #1E293B !important;
                color: #F8FAFC !important;
            }

            .register-card {
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

            .form-control,
            .form-select {
                background: #0F172A !important;
                color: #F8FAFC !important;
                border-color: #334155 !important;
            }

            .text-muted {
                color: #CBD5E1 !important;
            }

            .info-box {
                background: #0F172A !important;
                color: #BFDBFE !important;
                border: 1px solid #334155;
            }
        @endif

        @media (max-width: 576px) {
            .register-wrapper {
                padding: 78px 14px 14px;
            }

            .top-switch {
                top: 14px;
                right: 14px;
                left: 14px;
                justify-content: center;
            }

            .register-header {
                padding: 28px 20px;
            }

            .register-body {
                padding: 24px 20px;
            }

            .register-title {
                font-size: 23px;
            }
        }
    </style>
</head>

<body>

<div class="register-wrapper">

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

                <div class="mb-3">
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
                    >
                </div>

                <div class="mb-3">
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

                <div class="mb-4">
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

                <button type="submit" class="btn btn-primary btn-register w-100">
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

</body>
</html>
