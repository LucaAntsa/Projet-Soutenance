@php
    $locale = session('admin_locale', 'fr');
    $theme = session('admin_theme', 'light');

    $texts = [
        'fr' => [
            'page_title' => 'Utilisateurs - Administration',
            'users_title' => 'Utilisateurs',
            'users_subtitle' => 'Gestion des comptes administrateurs, experts et parents.',

            'id' => '#',
            'name' => 'Nom',
            'email' => 'Email',
            'role' => 'Rôle',
            'registration_date' => 'Date d’inscription',
            'actions' => 'Actions',

            'admin' => 'Admin',
            'expert' => 'Expert',
            'parent' => 'Parent',
            'no_role' => 'Aucun rôle',

            'edit' => 'Modifier',
            'delete' => 'Supprimer',
            'delete_confirm' => 'Voulez-vous vraiment supprimer cet utilisateur ?',

            'empty_title' => 'Aucun utilisateur trouvé',
            'empty_text' => 'Aucun compte n’est disponible pour le moment.',
        ],
        'mg' => [
            'page_title' => 'Mpampiasa - Administration',
            'users_title' => 'Mpampiasa',
            'users_subtitle' => 'Fitantanana ny kaonty admin, expert ary parent.',

            'id' => '#',
            'name' => 'Anarana',
            'email' => 'Email',
            'role' => 'Andraikitra',
            'registration_date' => 'Daty nisoratana',
            'actions' => 'Asa atao',

            'admin' => 'Admin',
            'expert' => 'Expert',
            'parent' => 'Parent',
            'no_role' => 'Tsy misy andraikitra',

            'edit' => 'Hanova',
            'delete' => 'Hamafa',
            'delete_confirm' => 'Tena tianao hofafana ve ity mpampiasa ity ?',

            'empty_title' => 'Tsy misy mpampiasa hita',
            'empty_text' => 'Tsy mbola misy kaonty amin’izao fotoana izao.',
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

        .role-admin {
            background: #DBEAFE;
            color: #2563EB;
            border-radius: 999px;
            padding: 7px 11px;
            font-weight: 700;
            font-size: 12px;
        }

        .role-expert {
            background: #FEF3C7;
            color: #B45309;
            border-radius: 999px;
            padding: 7px 11px;
            font-weight: 700;
            font-size: 12px;
        }

        .role-parent {
            background: #DCFCE7;
            color: #16A34A;
            border-radius: 999px;
            padding: 7px 11px;
            font-weight: 700;
            font-size: 12px;
        }

        .role-none {
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
        }
    </style>
</head>

<body>

<div class="container-fluid">
    <div class="row">

        @include('admin.partials.sidebar')

        <main class="col-md-10 p-4 admin-main">

            <div class="admin-page-header">
                <div>
                    <h1>{{ $t['users_title'] ?? 'Utilisateurs' }}</h1>
                    <p>{{ $t['users_subtitle'] ?? 'Gestion des comptes utilisateurs de la plateforme.' }}</p>
                </div>

                @include('admin.partials.header-actions')
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
                                    <th>{{ $t['name'] }}</th>
                                    <th>{{ $t['email'] }}</th>
                                    <th>{{ $t['role'] }}</th>
                                    <th>{{ $t['registration_date'] }}</th>
                                    <th class="text-end pe-4">{{ $t['actions'] }}</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse($users as $user)
                                    <tr>
                                        <td class="ps-4 fw-bold text-muted">
                                            {{ $user->id }}
                                        </td>

                                        <td>
                                            <div class="fw-bold">
                                                {{ $user->name }}
                                            </div>
                                        </td>

                                        <td class="text-muted">
                                            {{ $user->email }}
                                        </td>

                                        <td>
                                            @if($user->role?->name === 'admin')
                                                <span class="role-admin">{{ $t['admin'] }}</span>
                                            @elseif($user->role?->name === 'expert')
                                                <span class="role-expert">{{ $t['expert'] }}</span>
                                            @elseif($user->role?->name === 'parent')
                                                <span class="role-parent">{{ $t['parent'] }}</span>
                                            @else
                                                <span class="role-none">{{ $t['no_role'] }}</span>
                                            @endif
                                        </td>

                                        <td class="text-muted">
                                            {{ $user->created_at->format('d/m/Y') }}
                                        </td>

                                        <td class="text-end pe-4">
                                            <a href="{{ route('admin.users.edit', $user->id) }}"
                                               class="btn btn-sm btn-edit me-1">
                                                {{ $t['edit'] }}
                                            </a>

                                            <form action="{{ route('admin.users.destroy', $user->id) }}"
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
                                                <div class="empty-icon">👥</div>

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
