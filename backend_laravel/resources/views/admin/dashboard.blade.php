@php
    $locale = session('admin_locale', 'fr');
    $theme = session('admin_theme', 'light');

    $texts = [
        'fr' => [
            'page_title' => 'Tableau de bord - Administration',
            'dashboard' => 'Tableau de bord',
            'subtitle' => 'Vue générale de la plateforme d’éducation familiale.',
            'connected' => 'Connecté',
            'user' => 'Utilisateur',

            'users' => 'Utilisateurs',
            'modules' => 'Modules éducatifs',
            'conseils' => 'Conseils',
            'quiz' => 'Quiz',
            'scores' => 'Scores enregistrés',
            'progressions' => 'Progressions',

            'quick_actions' => 'Actions rapides',
            'manage_modules' => 'Gérer les modules éducatifs',
            'manage_conseils' => 'Gérer les conseils',
            'manage_quizzes' => 'Gérer les quiz',
            'manage_users' => 'Gérer les utilisateurs',

            'summary' => 'Résumé',
            'summary_text_1' => 'Cette interface permet aux administrateurs et experts de gérer les contenus éducatifs.',
            'summary_text_2' => 'Les parents consultent ensuite les modules, conseils et quiz depuis l’application mobile.',
        ],
        'mg' => [
            'page_title' => 'Tabilao fitantanana - Administration',
            'dashboard' => 'Tabilao fitantanana',
            'subtitle' => 'Topimaso ankapobeny momba ny sehatra fanabeazana ara-pianakaviana.',
            'connected' => 'Miditra',
            'user' => 'Mpampiasa',

            'users' => 'Mpampiasa',
            'modules' => 'Modules fanabeazana',
            'conseils' => 'Torohevitra',
            'quiz' => 'Quiz',
            'scores' => 'Naoty voatahiry',
            'progressions' => 'Fandrosoana',

            'quick_actions' => 'Asa haingana',
            'manage_modules' => 'Hitantana modules fanabeazana',
            'manage_conseils' => 'Hitantana torohevitra',
            'manage_quizzes' => 'Hitantana quiz',
            'manage_users' => 'Hitantana mpampiasa',

            'summary' => 'Famintinana',
            'summary_text_1' => 'Ity interface ity dia natao ho an’ny admin sy expert hitantanana ny votoaty fanabeazana.',
            'summary_text_2' => 'Ny ray aman-dreny kosa mijery modules, torohevitra ary quiz ao amin’ny application mobile.',
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

        .dashboard-header {
            background: linear-gradient(135deg, #2563EB, #1D4ED8);
            border-radius: 22px;
            padding: 28px;
            color: white;
            margin-bottom: 28px;
            box-shadow: 0 12px 28px rgba(37, 99, 235, 0.22);
        }

        .dashboard-title {
            font-size: 28px;
            font-weight: 800;
            margin-bottom: 6px;
        }

        .dashboard-subtitle {
            color: rgba(255, 255, 255, 0.82);
            margin-bottom: 0;
        }

        .role-pill {
            background: rgba(255, 255, 255, 0.18);
            color: white;
            border-radius: 999px;
            padding: 7px 13px;
            font-size: 13px;
            font-weight: 600;
            display: inline-block;
        }

        .stat-card {
            border: 0;
            border-radius: 20px;
            box-shadow: 0 10px 24px rgba(15, 23, 42, 0.08);
            transition: all 0.2s ease;
            height: 100%;
        }

        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 14px 30px rgba(15, 23, 42, 0.12);
        }

        .stat-icon {
            width: 50px;
            height: 50px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            margin-bottom: 16px;
        }

        .stat-label {
            color: #64748B;
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 6px;
        }

        .stat-value {
            color: #0F172A;
            font-size: 32px;
            font-weight: 800;
            margin-bottom: 0;
        }

        .quick-card {
            border: 0;
            border-radius: 20px;
            box-shadow: 0 10px 24px rgba(15, 23, 42, 0.08);
            padding: 22px;
            background: white;
        }

        .quick-link {
            display: block;
            padding: 13px 15px;
            border-radius: 14px;
            text-decoration: none;
            color: #1E293B;
            font-weight: 600;
            background: #F8FAFC;
            margin-bottom: 10px;
            transition: 0.2s ease;
        }

        .quick-link:hover {
            background: #2563EB;
            color: white;
        }

        @if($theme === 'dark')
            body,
            .admin-main {
                background: #0F172A !important;
                color: #F8FAFC !important;
            }

            .stat-card,
            .quick-card {
                background: #1E293B !important;
                color: #F8FAFC !important;
                box-shadow: none !important;
            }

            .stat-label {
                color: #CBD5E1 !important;
            }

            .stat-value {
                color: #F8FAFC !important;
            }

            .quick-link {
                background: #0F172A !important;
                color: #E2E8F0 !important;
            }

            .quick-link:hover {
                background: #2563EB !important;
                color: white !important;
            }

            .text-muted {
                color: #CBD5E1 !important;
            }
        @endif

        @media (max-width: 767px) {
            .dashboard-header {
                padding: 22px;
                border-radius: 18px;
            }

            .dashboard-title {
                font-size: 23px;
            }

            .stat-value {
                font-size: 28px;
            }
        }
    </style>
</head>

<body>

<div class="container-fluid">
    <div class="row">

        @include('admin.partials.sidebar')

        <main class="col-md-10 p-4 admin-main">

            <div class="dashboard-header">
                <div class="d-flex flex-column flex-md-row justify-content-between gap-3">
                    <div>
                        <h1 class="dashboard-title">
                            {{ $t['dashboard'] }}
                        </h1>

                        <p class="dashboard-subtitle">
                            {{ $t['subtitle'] }}
                        </p>
                    </div>

                    <div class="align-self-md-start">
                        <span class="role-pill">
                            {{ $t['connected'] }} :
                            {{ ucfirst(auth()->user()->role?->name ?? $t['user']) }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="row g-4">

                @if(auth()->user()->role?->name === 'admin')
                    <div class="col-12 col-sm-6 col-xl-3">
                        <div class="card stat-card">
                            <div class="card-body">
                                <div class="stat-icon" style="background:#DBEAFE;color:#2563EB;">
                                    👥
                                </div>
                                <div class="stat-label">{{ $t['users'] }}</div>
                                <h3 class="stat-value">{{ $totalUsers }}</h3>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="col-12 col-sm-6 col-xl-3">
                    <div class="card stat-card">
                        <div class="card-body">
                            <div class="stat-icon" style="background:#DBEAFE;color:#2563EB;">
                                📘
                            </div>
                            <div class="stat-label">{{ $t['modules'] }}</div>
                            <h3 class="stat-value">{{ $totalModules }}</h3>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-xl-3">
                    <div class="card stat-card">
                        <div class="card-body">
                            <div class="stat-icon" style="background:#FEF3C7;color:#F59E0B;">
                                💡
                            </div>
                            <div class="stat-label">{{ $t['conseils'] }}</div>
                            <h3 class="stat-value">{{ $totalConseils }}</h3>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-xl-3">
                    <div class="card stat-card">
                        <div class="card-body">
                            <div class="stat-icon" style="background:#F3E8FF;color:#9333EA;">
                                📝
                            </div>
                            <div class="stat-label">{{ $t['quiz'] }}</div>
                            <h3 class="stat-value">{{ $totalQuizzes }}</h3>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-xl-3">
                    <div class="card stat-card">
                        <div class="card-body">
                            <div class="stat-icon" style="background:#FFEDD5;color:#EA580C;">
                                🏆
                            </div>
                            <div class="stat-label">{{ $t['scores'] }}</div>
                            <h3 class="stat-value">{{ $totalScores }}</h3>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-xl-3">
                    <div class="card stat-card">
                        <div class="card-body">
                            <div class="stat-icon" style="background:#DCFCE7;color:#16A34A;">
                                📈
                            </div>
                            <div class="stat-label">{{ $t['progressions'] }}</div>
                            <h3 class="stat-value">{{ $totalProgressions }}</h3>
                        </div>
                    </div>
                </div>

            </div>

            <div class="row g-4 mt-2">
                <div class="col-12 col-lg-6">
                    <div class="quick-card">
                        <h5 class="fw-bold mb-3">{{ $t['quick_actions'] }}</h5>

                        <a href="{{ route('admin.modules.index') }}" class="quick-link">
                            📘 {{ $t['manage_modules'] }}
                        </a>

                        <a href="{{ route('admin.conseils.index') }}" class="quick-link">
                            💡 {{ $t['manage_conseils'] }}
                        </a>

                        <a href="{{ route('admin.quizzes.index') }}" class="quick-link">
                            📝 {{ $t['manage_quizzes'] }}
                        </a>

                        @if(auth()->user()->role?->name === 'admin')
                            <a href="{{ route('admin.users.index') }}" class="quick-link">
                                👥 {{ $t['manage_users'] }}
                            </a>
                        @endif
                    </div>
                </div>

                <div class="col-12 col-lg-6">
                    <div class="quick-card">
                        <h5 class="fw-bold mb-3">{{ $t['summary'] }}</h5>

                        <p class="text-muted mb-2">
                            {{ $t['summary_text_1'] }}
                        </p>

                        <p class="text-muted mb-0">
                            {{ $t['summary_text_2'] }}
                        </p>
                    </div>
                </div>
            </div>

        </main>

    </div>
</div>

</body>
</html>
