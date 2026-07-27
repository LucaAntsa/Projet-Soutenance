@php
    $locale = session('admin_locale', 'fr');
    $theme = session('admin_theme', 'light');

    $texts = [
        'fr' => [
            'page_title' => 'Ajouter un quiz - Administration',
            'header_title' => 'Ajouter un quiz',
            'header_subtitle' => 'Créez un quiz associé à un module éducatif.',

            'module' => 'Module éducatif',
            'choose_module' => 'Choisir un module',
            'module_help' => 'Le quiz sera rattaché au module sélectionné.',

            'quiz_title' => 'Titre du quiz',
            'quiz_title_placeholder' => 'Exemple : Quiz sur la communication familiale',

            'description' => 'Description',
            'description_placeholder' => 'Décrivez brièvement l’objectif du quiz...',

            'save' => 'Enregistrer le quiz',
            'back' => 'Retour',
        ],
        'mg' => [
            'page_title' => 'Hampiditra quiz - Administration',
            'header_title' => 'Hampiditra quiz',
            'header_subtitle' => 'Mamoròna quiz mifandray amin’ny module fanabeazana.',

            'module' => 'Module fanabeazana',
            'choose_module' => 'Misafidiana module',
            'module_help' => 'Hifandray amin’ilay module voafidy ity quiz ity.',

            'quiz_title' => 'Lohatenin’ny quiz',
            'quiz_title_placeholder' => 'Ohatra : Quiz momba ny fifandraisana ao an-tokantrano',

            'description' => 'Fanazavana',
            'description_placeholder' => 'Hazavao fohy ny tanjon’ilay quiz...',

            'save' => 'Hitahiry ny quiz',
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
            background: linear-gradient(135deg, #7E22CE, #9333EA);
            border-radius: 22px;
            padding: 26px;
            color: white;
            margin-bottom: 24px;
            box-shadow: 0 12px 28px rgba(147, 51, 234, 0.22);
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

        .form-control,
        .form-select {
            border-radius: 14px;
            padding: 13px 15px;
            border: 1px solid #CBD5E1;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #9333EA;
            box-shadow: 0 0 0 0.18rem rgba(147, 51, 234, 0.15);
        }

        .form-help {
            font-size: 13px;
            color: #64748B;
        }

        .btn-save {
            background: #9333EA;
            border: 0;
            border-radius: 14px;
            padding: 12px 18px;
            font-weight: 700;
        }

        .btn-save:hover {
            background: #7E22CE;
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
            .form-select,
            textarea {
                background: #0F172A !important;
                color: #F8FAFC !important;
                border-color: #334155 !important;
            }

            .form-control::placeholder,
            textarea::placeholder {
                color: #94A3B8 !important;
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

                            <form action="{{ route('admin.quizzes.store') }}" method="POST">
                                @csrf

                                <div class="mb-3">
                                    <label class="form-label">
                                        {{ $t['module'] }}
                                    </label>

                                    <select name="module_educatif_id" class="form-select" required>
                                        <option value="">
                                            {{ $t['choose_module'] }}
                                        </option>

                                        @foreach($modules as $module)
                                            <option value="{{ $module->id }}" {{ old('module_educatif_id') == $module->id ? 'selected' : '' }}>
                                                {{ $module->title }}
                                            </option>
                                        @endforeach
                                    </select>

                                    <div class="form-help mt-1">
                                        {{ $t['module_help'] }}
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">
                                        {{ $t['quiz_title'] }}
                                    </label>

                                    <input
                                        type="text"
                                        name="title"
                                        class="form-control"
                                        value="{{ old('title') }}"
                                        placeholder="{{ $t['quiz_title_placeholder'] }}"
                                        required
                                    >
                                </div>

                                <div class="mb-4">
                                    <label class="form-label">
                                        {{ $t['description'] }}
                                    </label>

                                    <textarea
                                        name="description"
                                        class="form-control"
                                        rows="4"
                                        placeholder="{{ $t['description_placeholder'] }}"
                                    >{{ old('description') }}</textarea>
                                </div>

                                <div class="d-flex gap-2 action-buttons">
                                    <button type="submit" class="btn btn-primary btn-save">
                                        {{ $t['save'] }}
                                    </button>

                                    <a href="{{ route('admin.quizzes.index') }}" class="btn-back text-center">
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

