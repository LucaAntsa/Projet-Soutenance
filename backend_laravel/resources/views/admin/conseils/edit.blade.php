@php
    $locale = session('admin_locale', 'fr');
    $theme = session('admin_theme', 'light');

    $texts = [
        'fr' => [
            'page_title' => 'Modifier un conseil - Administration',
            'header_title' => 'Modifier le conseil',
            'header_subtitle' => 'Mettez à jour les informations du conseil pratique.',

            'conseil_title' => 'Titre du conseil',

            'theme' => 'Thème',
            'theme_placeholder' => 'Exemple : Communication familiale',
            'theme_help' => 'Le thème permet de classer le conseil dans l’application parent.',

            'content' => 'Contenu du conseil',

            'publish_conseil' => 'Publier le conseil',
            'publish_help' => 'Si cette option est cochée, le conseil sera visible dans l’application parent.',

            'update' => 'Mettre à jour',
            'back' => 'Retour',
        ],
        'mg' => [
            'page_title' => 'Hanova torohevitra - Administration',
            'header_title' => 'Hanova torohevitra',
            'header_subtitle' => 'Havaozy ny mombamomba ny torohevitra.',

            'conseil_title' => 'Lohatenin’ny torohevitra',

            'theme' => 'Lohahevitra',
            'theme_placeholder' => 'Ohatra : Fifandraisana ao an-tokantrano',
            'theme_help' => 'Ny lohahevitra dia manampy amin’ny fanasokajiana ny torohevitra ao amin’ny application parent.',

            'content' => 'Votoatin’ny torohevitra',

            'publish_conseil' => 'Hamoaka ny torohevitra',
            'publish_help' => 'Raha voatsindry ity safidy ity dia ho hita ao amin’ny application parent ilay torohevitra.',

            'update' => 'Havaozy',
            'back' => 'Hiverina',
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
            font-family: Arial, sans-serif;
        }

        .admin-main {
            background: #F3F6FB;
            min-height: 100vh;
        }

        .page-header {
            background: linear-gradient(135deg, #F59E0B, #D97706);
            border-radius: 22px;
            padding: 26px;
            color: white;
            margin-bottom: 24px;
            box-shadow: 0 12px 28px rgba(245, 158, 11, 0.22);
        }

        .page-title {
            font-size: 27px;
            font-weight: 800;
            margin-bottom: 6px;
        }

        .page-subtitle {
            color: rgba(255, 255, 255, 0.85);
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

        .form-control {
            border-radius: 14px;
            padding: 13px 15px;
            border: 1px solid #CBD5E1;
        }

        .form-control:focus {
            border-color: #F59E0B;
            box-shadow: 0 0 0 0.18rem rgba(245, 158, 11, 0.15);
        }

        .form-help {
            font-size: 13px;
            color: #64748B;
        }

        .btn-save {
            background: #F59E0B;
            border: 0;
            border-radius: 14px;
            padding: 12px 18px;
            font-weight: 700;
        }

        .btn-save:hover {
            background: #D97706;
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

        .publish-box {
            background: #F8FAFC;
            border: 1px solid #E2E8F0;
            border-radius: 16px;
            padding: 14px 16px;
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
            textarea {
                background: #0F172A !important;
                color: #F8FAFC !important;
                border-color: #334155 !important;
            }

            .form-control::placeholder,
            textarea::placeholder {
                color: #94A3B8 !important;
            }

            .publish-box {
                background: #0F172A !important;
                border-color: #334155 !important;
                color: #F8FAFC !important;
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
                <div class="col-12 col-lg-9 col-xl-8">

                    <div class="card form-card">
                        <div class="card-body p-4">

                            <form action="{{ route('admin.conseils.update', $conseil->id) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label">
            Titre du conseil - Français
        </label>

        <input
            type="text"
            name="title_fr"
            class="form-control"
            value="{{ old('title_fr', $conseil->title_fr ?? $conseil->title) }}"
            required
        >
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">
            Titre du conseil - Malagasy
        </label>

        <input
            type="text"
            name="title_mg"
            class="form-control"
            value="{{ old('title_mg', $conseil->title_mg) }}"
        >
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label">
            Thème - Français
        </label>

        <input
            type="text"
            name="theme_fr"
            class="form-control"
            value="{{ old('theme_fr', $conseil->theme_fr ?? $conseil->theme) }}"
            placeholder="Exemple : Communication familiale"
        >

        <div class="form-help mt-1">
            Thème affiché quand l’application est en français.
        </div>
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">
            Thème - Malagasy
        </label>

        <input
            type="text"
            name="theme_mg"
            class="form-control"
            value="{{ old('theme_mg', $conseil->theme_mg) }}"
            placeholder="Ohatra : Fifandraisana ao an-tokantrano"
        >

        <div class="form-help mt-1">
            Lohahevitra aseho rehefa amin’ny teny Malagasy ny application.
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label">
            Contenu du conseil - Français
        </label>

        <textarea
            name="content_fr"
            class="form-control"
            rows="9"
            required
        >{{ old('content_fr', $conseil->content_fr ?? $conseil->content) }}</textarea>
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">
            Contenu du conseil - Malagasy
        </label>

        <textarea
            name="content_mg"
            class="form-control"
            rows="9"
        >{{ old('content_mg', $conseil->content_mg) }}</textarea>
    </div>
</div>

                                <div class="publish-box mb-4">
                                    <div class="form-check">
                                        <input
                                            type="checkbox"
                                            name="is_published"
                                            value="1"
                                            class="form-check-input"
                                            id="is_published"
                                            {{ old('is_published', $conseil->is_published) ? 'checked' : '' }}
                                        >

                                        <label class="form-check-label fw-semibold" for="is_published">
                                            {{ $t['publish_conseil'] }}
                                        </label>
                                    </div>

                                    <div class="form-help mt-1">
                                        {{ $t['publish_help'] }}
                                    </div>
                                </div>

                                <div class="d-flex gap-2 action-buttons">
                                    <button type="submit" class="btn btn-primary btn-save">
                                        {{ $t['update'] }}
                                    </button>

                                    <a href="{{ route('admin.conseils.index') }}" class="btn-back text-center">
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
