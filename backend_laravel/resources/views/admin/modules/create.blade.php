@php
    $locale = session('admin_locale', 'fr');
    $theme = session('admin_theme', 'light');

    $texts = [
        'fr' => [
            'page_title' => 'Ajouter un module - Administration',
            'header_title' => 'Ajouter un module éducatif',
            'header_subtitle' => 'Créez un nouveau contenu éducatif destiné aux parents.',

            'category' => 'Catégorie',
            'choose_category' => 'Choisir une catégorie',
            'category_help' => 'Classez le module dans une catégorie adaptée.',

            'module_title' => 'Titre du module',
            'module_title_placeholder' => 'Exemple : Communication parent-enfant',

            'short_description' => 'Description courte',
            'short_description_placeholder' => 'Résumé court visible dans l’application parent...',

            'full_content' => 'Contenu complet',
            'full_content_placeholder' => 'Rédigez ici le contenu complet du module...',

            'publish_module' => 'Publier le module',
            'publish_help' => 'Si cette option est cochée, le module sera visible dans l’application parent.',

            'save' => 'Enregistrer le module',
            'back' => 'Retour',
        ],
        'mg' => [
            'page_title' => 'Hampiditra module - Administration',
            'header_title' => 'Hampiditra module fanabeazana',
            'header_subtitle' => 'Mamoròna votoaty fanabeazana vaovao ho an’ny ray aman-dreny.',

            'category' => 'Sokajy',
            'choose_category' => 'Misafidiana sokajy',
            'category_help' => 'Ampidiro amin’ny sokajy mifanaraka aminy ny module.',

            'module_title' => 'Lohatenin’ny module',
            'module_title_placeholder' => 'Ohatra : Fifandraisana ray aman-dreny sy zanaka',

            'short_description' => 'Fanazavana fohy',
            'short_description_placeholder' => 'Famintinana fohy hita ao amin’ny application parent...',

            'full_content' => 'Votoaty feno',
            'full_content_placeholder' => 'Soraty eto ny votoaty feno an’ilay module...',

            'publish_module' => 'Hamoaka ny module',
            'publish_help' => 'Raha voatsindry ity safidy ity dia ho hita ao amin’ny application parent ilay module.',

            'save' => 'Hitahiry ny module',
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
            background: linear-gradient(135deg, #2563EB, #1D4ED8);
            border-radius: 22px;
            padding: 26px;
            color: white;
            margin-bottom: 24px;
            box-shadow: 0 12px 28px rgba(37, 99, 235, 0.22);
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

                            <form action="{{ route('admin.modules.store') }}" method="POST">
                                @csrf

                                <div class="mb-3">
                                    <label class="form-label">
                                        {{ $t['category'] }}
                                    </label>

                                    <select name="category_id" class="form-select">
                                        <option value="">
                                            {{ $t['choose_category'] }}
                                        </option>

                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>

                                    <div class="form-help mt-1">
                                        {{ $t['category_help'] }}
                                    </div>
                                </div>

                                <div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label">
            Titre du module - Français
        </label>

        <input
            type="text"
            name="title_fr"
            class="form-control"
            value="{{ old('title_fr') }}"
            placeholder="Exemple : Communication parent-enfant"
            required
        >
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">
            Titre du module - Malagasy
        </label>

        <input
            type="text"
            name="title_mg"
            class="form-control"
            value="{{ old('title_mg') }}"
            placeholder="Ohatra : Fifandraisana ray aman-dreny sy zanaka"
        >
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label">
            Description courte - Français
        </label>

        <textarea
            name="description_fr"
            class="form-control"
            rows="3"
            placeholder="Résumé court visible dans l’application parent..."
        >{{ old('description_fr') }}</textarea>
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">
            Description courte - Malagasy
        </label>

        <textarea
            name="description_mg"
            class="form-control"
            rows="3"
            placeholder="Famintinana fohy hita ao amin’ny application parent..."
        >{{ old('description_mg') }}</textarea>
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label">
            Contenu complet - Français
        </label>

        <textarea
            name="content_fr"
            class="form-control"
            rows="9"
            placeholder="Rédigez ici le contenu complet du module..."
            required
        >{{ old('content_fr') }}</textarea>
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">
            Contenu complet - Malagasy
        </label>

        <textarea
            name="content_mg"
            class="form-control"
            rows="9"
            placeholder="Soraty eto ny votoaty feno an’ilay module..."
        >{{ old('content_mg') }}</textarea>
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
                                            {{ old('is_published', 1) ? 'checked' : '' }}
                                        >

                                        <label class="form-check-label fw-semibold" for="is_published">
                                            {{ $t['publish_module'] }}
                                        </label>
                                    </div>

                                    <div class="form-help mt-1">
                                        {{ $t['publish_help'] }}
                                    </div>
                                </div>

                                <div class="d-flex gap-2 action-buttons">
                                    <button type="submit" class="btn btn-primary btn-save">
                                        {{ $t['save'] }}
                                    </button>

                                    <a href="{{ route('admin.modules.index') }}" class="btn-back text-center">
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
