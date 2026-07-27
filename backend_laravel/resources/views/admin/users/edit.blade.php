@php
    $locale = session('admin_locale', 'fr');
    $theme = session('admin_theme', 'light');

    $texts = [
        'fr' => [
            'page_title' => 'Modifier utilisateur - Administration',
            'header_title' => 'Modifier l’utilisateur',
            'header_subtitle' => 'Mettez à jour les informations, le rôle et le mot de passe de l’utilisateur.',

            'full_name' => 'Nom complet',
            'email' => 'Adresse email',
            'role' => 'Rôle',
            'role_help' => 'Le rôle définit les droits d’accès de l’utilisateur.',

            'new_password' => 'Nouveau mot de passe',
            'password_placeholder' => 'Laisser vide pour conserver l’ancien mot de passe',
            'password_help' => 'Laissez ce champ vide si vous ne souhaitez pas modifier le mot de passe.',

            'registered_at' => 'Utilisateur inscrit le',
            'update' => 'Mettre à jour',
            'back' => 'Retour',

            'admin' => 'Admin',
            'expert' => 'Expert',
            'parent' => 'Parent',
        ],
        'mg' => [
            'page_title' => 'Hanova mpampiasa - Administration',
            'header_title' => 'Hanova mpampiasa',
            'header_subtitle' => 'Havaozy ny mombamomba, andraikitra ary tenimiafin’ny mpampiasa.',

            'full_name' => 'Anarana feno',
            'email' => 'Adiresy email',
            'role' => 'Andraikitra',
            'role_help' => 'Ny andraikitra no mamaritra ny zo fidiran’ny mpampiasa.',

            'new_password' => 'Tenimiafina vaovao',
            'password_placeholder' => 'Avelao ho foana raha tsy hanova tenimiafina',
            'password_help' => 'Avelao ho foana ity saha ity raha tsy tianao hovaina ny tenimiafina.',

            'registered_at' => 'Nisoratra tamin’ny',
            'update' => 'Havaozy',
            'back' => 'Hiverina',

            'admin' => 'Admin',
            'expert' => 'Expert',
            'parent' => 'Parent',
        ],
    ];

    $t = $texts[$locale] ?? $texts['fr'];

    $roleLabels = [
        'admin' => $t['admin'],
        'expert' => $t['expert'],
        'parent' => $t['parent'],
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
            font-family: Arial, sans-serif;
        }

        .admin-main {
            background: #F3F6FB;
            min-height: 100vh;
        }

        .page-header {
            background: linear-gradient(135deg, #0F172A, #1E293B);
            border-radius: 22px;
            padding: 26px;
            color: white;
            margin-bottom: 24px;
            box-shadow: 0 12px 28px rgba(15, 23, 42, 0.22);
        }

        .page-title {
            font-size: 27px;
            font-weight: 800;
            margin-bottom: 6px;
        }

        .page-subtitle {
            color: rgba(255, 255, 255, 0.82);
            margin-bottom: 0;
        }

        .form-card {
            border: 0;
            border-radius: 22px;
            box-shadow: 0 10px 24px rgba(15, 23, 42, 0.08);
            overflow: hidden;
        }

        .form-label {
            font-weight: 700;
            color: #1E293B;
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

        .form-help {
            font-size: 13px;
            color: #64748B;
        }

        .btn-save {
            background: #2563EB;
            border: 0;
            border-radius: 14px;
            padding: 12px 18px;
            font-weight: 700;
        }

        .btn-save:hover {
            background: #1D4ED8;
        }

        .btn-back {
            background: #E2E8F0;
            color: #334155;
            border: 0;
            border-radius: 14px;
            padding: 12px 18px;
            font-weight: 700;
            text-decoration: none;
        }

        .btn-back:hover {
            background: #CBD5E1;
            color: #0F172A;
        }

        .info-box {
            background: #F8FAFC;
            border: 1px solid #E2E8F0;
            border-radius: 16px;
            padding: 14px 16px;
            color: #64748B;
            font-size: 14px;
        }

        @if($theme === 'dark')
            body,
            .admin-main {
                background: #0F172A !important;
                color: #F8FAFC !important;
            }

            .form-card {
                background: #1E293B !important;
                color: #F8FAFC !important;
                box-shadow: none !important;
            }

            .form-label {
                color: #F8FAFC !important;
            }

            .form-help,
            .text-muted {
                color: #CBD5E1 !important;
            }

            .form-control,
            .form-select {
                background: #0F172A !important;
                color: #F8FAFC !important;
                border-color: #334155 !important;
            }

            .form-control::placeholder {
                color: #94A3B8 !important;
            }

            .info-box {
                background: #0F172A !important;
                border-color: #334155 !important;
                color: #CBD5E1 !important;
            }

            .btn-back {
                background: #334155 !important;
                color: #F8FAFC !important;
            }

            .btn-back:hover {
                background: #475569 !important;
                color: #ffffff !important;
            }

            .page-header {
                box-shadow: none !important;
            }
        @endif

        @media (max-width: 767px) {
            .page-header {
                padding: 22px;
                border-radius: 18px;
            }

            .page-title {
                font-size: 23px;
            }

            .action-buttons {
                flex-direction: column;
            }

            .action-buttons .btn,
            .action-buttons a {
                width: 100%;
            }
        }
    </style>
</head>

<body>

<div class="container-fluid">
    <div class="row">

        @include('admin.partials.sidebar')

        <main class="col-md-10 p-4 admin-main">

            <div class="page-header">
                <h1 class="page-title">
                    {{ $t['header_title'] }}
                </h1>

                <p class="page-subtitle">
                    {{ $t['header_subtitle'] }}
                </p>
            </div>

            @if($errors->any())
                <div class="alert alert-danger border-0 shadow-sm rounded-4">
                    <ul class="mb-0 ps-3">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="row justify-content-center">
                <div class="col-12 col-lg-8 col-xl-7">

                    <div class="card form-card">
                        <div class="card-body p-4">

                            <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="mb-3">
                                    <label class="form-label">
                                        {{ $t['full_name'] }}
                                    </label>

                                    <input
                                        type="text"
                                        name="name"
                                        class="form-control"
                                        value="{{ old('name', $user->name) }}"
                                        required
                                    >
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">
                                        {{ $t['email'] }}
                                    </label>

                                    <input
                                        type="email"
                                        name="email"
                                        class="form-control"
                                        value="{{ old('email', $user->email) }}"
                                        required
                                    >
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">
                                        {{ $t['role'] }}
                                    </label>

                                    <select name="role_id" class="form-select" required>
                                        @foreach($roles as $role)
                                            <option value="{{ $role->id }}" {{ old('role_id', $user->role_id) == $role->id ? 'selected' : '' }}>
                                                {{ $roleLabels[$role->name] ?? ucfirst($role->name) }}
                                            </option>
                                        @endforeach
                                    </select>

                                    <div class="form-help mt-1">
                                        {{ $t['role_help'] }}
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label">
                                        {{ $t['new_password'] }}
                                    </label>

                                    <input
                                        type="password"
                                        name="password"
                                        class="form-control"
                                        placeholder="{{ $t['password_placeholder'] }}"
                                    >

                                    <div class="form-help mt-1">
                                        {{ $t['password_help'] }}
                                    </div>
                                </div>

                                <div class="info-box mb-4">
                                    {{ $t['registered_at'] }} :
                                    <strong>{{ $user->created_at->format('d/m/Y') }}</strong>
                                </div>

                                <div class="d-flex gap-2 action-buttons">
                                    <button type="submit" class="btn btn-primary btn-save">
                                        {{ $t['update'] }}
                                    </button>

                                    <a href="{{ route('admin.users.index') }}" class="btn-back text-center">
                                        {{ $t['back'] }}
                                    </a>
                                </div>

                            </form>

                        </div>
                    </div>

                </div>
            </div>

        </main>

    </div>
</div>

</body>
</html>
