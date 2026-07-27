@php
    $locale = session('admin_locale', 'fr');
    $theme = session('admin_theme', 'light');

    $texts = [
        'fr' => [
            'page_title' => 'Modules éducatifs - Administration',
            'modules_title' => 'Modules éducatifs',
            'modules_subtitle' => 'Gestion des contenus éducatifs disponibles sur l’application parent.',
            'add_module' => '+ Ajouter un module',

            'id' => '#',
            'title' => 'Titre',
            'category' => 'Catégorie',
            'status' => 'Statut',
            'date' => 'Date',
            'actions' => 'Actions',

            'no_description' => 'Aucune description',
            'no_category' => 'Non classé',
            'published' => 'Publié',
            'hidden' => 'Masqué',
            'edit' => 'Modifier',
            'delete' => 'Supprimer',

            'delete_confirm' => 'Voulez-vous vraiment supprimer ce module ?',
            'empty_title' => 'Aucun module éducatif trouvé',
            'empty_text' => 'Ajoutez un premier module pour commencer.',
        ],
        'mg' => [
            'page_title' => 'Modules fanabeazana - Administration',
            'modules_title' => 'Modules fanabeazana',
            'modules_subtitle' => 'Fitantanana ireo votoaty fanabeazana hita ao amin’ny application parent.',
            'add_module' => '+ Hampiditra module',

            'id' => '#',
            'title' => 'Lohateny',
            'category' => 'Sokajy',
            'status' => 'Statut',
            'date' => 'Daty',
            'actions' => 'Asa atao',

            'no_description' => 'Tsy misy fanazavana',
            'no_category' => 'Tsy voasokajy',
            'published' => 'Navoaka',
            'hidden' => 'Nafenina',
            'edit' => 'Hanova',
            'delete' => 'Hamafa',

            'delete_confirm' => 'Tena tianao hofafana ve ity module ity ?',
            'empty_title' => 'Tsy misy module fanabeazana hita',
            'empty_text' => 'Ampidiro ny module voalohany hanombohana.',
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

        .btn-add {
            background: white;
            color: #2563EB;
            border: 0;
            border-radius: 14px;
            padding: 11px 18px;
            font-weight: 700;
        }

        .btn-add:hover {
            background: #EFF6FF;
            color: #1D4ED8;
        }

        .content-card {
            border: 0;
            border-radius: 22px;
            box-shadow: 0 10px 24px rgba(15, 23, 42, 0.08);
            overflow: hidden;
        }

        .table thead th {
            background: #F8FAFC;
            color: #475569;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.03em;
            border-bottom: 1px solid #E2E8F0;
        }

        .table td {
            vertical-align: middle;
            color: #1E293B;
        }

        .badge-published {
            background: #DCFCE7;
            color: #16A34A;
            border-radius: 999px;
            padding: 7px 11px;
            font-weight: 700;
            font-size: 12px;
        }

        .badge-hidden {
            background: #E2E8F0;
            color: #475569;
            border-radius: 999px;
            padding: 7px 11px;
            font-weight: 700;
            font-size: 12px;
        }

        .btn-edit {
            background: #FEF3C7;
            color: #B45309;
            border: 0;
            border-radius: 10px;
            font-weight: 600;
        }

        .btn-edit:hover {
            background: #FDE68A;
            color: #92400E;
        }

        .btn-delete {
            background: #FEE2E2;
            color: #DC2626;
            border: 0;
            border-radius: 10px;
            font-weight: 600;
        }

        .btn-delete:hover {
            background: #FECACA;
            color: #B91C1C;
        }

        .empty-box {
            padding: 45px 20px;
            text-align: center;
            color: #64748B;
        }

        .empty-icon {
            font-size: 46px;
            margin-bottom: 10px;
        }

        @if($theme === 'dark')
            body,
            .admin-main {
                background: #0F172A !important;
                color: #F8FAFC !important;
            }

            .content-card {
                background: #1E293B !important;
                color: #F8FAFC !important;
                box-shadow: none !important;
            }

            .table {
                background: #1E293B !important;
                color: #F8FAFC !important;
            }

            .table thead th {
                background: #334155 !important;
                color: #F8FAFC !important;
                border-color: #475569 !important;
            }

            .table td {
                background: #1E293B !important;
                color: #F8FAFC !important;
                border-color: #334155 !important;
            }

            .text-muted {
                color: #CBD5E1 !important;
            }

            .empty-box {
                color: #CBD5E1 !important;
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

            .btn-add {
                width: 100%;
                margin-top: 14px;
            }

            .table-responsive {
                border-radius: 18px;
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
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                    <div>
                        <h1 class="page-title">
                            {{ $t['modules_title'] }}
                        </h1>

                        <p class="page-subtitle">
                            {{ $t['modules_subtitle'] }}
                        </p>
                    </div>

                    <a href="{{ route('admin.modules.create') }}" class="btn btn-add">
                        {{ $t['add_module'] }}
                    </a>
                </div>
            </div>

            @if(session('success'))
                <div class="alert alert-success border-0 shadow-sm rounded-4">
                    {{ session('success') }}
                </div>
            @endif

            <div class="card content-card">
                <div class="card-body p-0">

                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead>
                                <tr>
                                    <th class="ps-4">{{ $t['id'] }}</th>
                                    <th>{{ $t['title'] }}</th>
                                    <th>{{ $t['category'] }}</th>
                                    <th>{{ $t['status'] }}</th>
                                    <th>{{ $t['date'] }}</th>
                                    <th class="text-end pe-4">{{ $t['actions'] }}</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse($modules as $module)
                                    <tr>
                                        <td class="ps-4 fw-bold text-muted">
                                            {{ $module->id }}
                                        </td>

                                        <td>
                                            <div class="fw-bold">
                                                {{ $module->title }}
                                            </div>

                                            <div class="text-muted small">
                                                {{ Str::limit($module->description ?? $t['no_description'], 70) }}
                                            </div>
                                        </td>

                                        <td>
                                            <span class="text-muted">
                                                {{ $module->category->name ?? $t['no_category'] }}
                                            </span>
                                        </td>

                                        <td>
                                            @if($module->is_published)
                                                <span class="badge-published">{{ $t['published'] }}</span>
                                            @else
                                                <span class="badge-hidden">{{ $t['hidden'] }}</span>
                                            @endif
                                        </td>

                                        <td class="text-muted">
                                            {{ $module->created_at->format('d/m/Y') }}
                                        </td>

                                        <td class="text-end pe-4">
                                            <a href="{{ route('admin.modules.edit', $module->id) }}"
                                               class="btn btn-sm btn-edit me-1">
                                                {{ $t['edit'] }}
                                            </a>

                                            <form action="{{ route('admin.modules.destroy', $module->id) }}"
                                                  method="POST"
                                                  class="d-inline">
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit"
                                                        class="btn btn-sm btn-delete"
                                                        onclick="return confirm('{{ $t['delete_confirm'] }}')">
                                                    {{ $t['delete'] }}
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6">
                                            <div class="empty-box">
                                                <div class="empty-icon">📘</div>
                                                <h5 class="fw-bold">
                                                    {{ $t['empty_title'] }}
                                                </h5>
                                                <p class="mb-0">
                                                    {{ $t['empty_text'] }}
                                                </p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>

        </main>

    </div>
</div>

</body>
</html>
