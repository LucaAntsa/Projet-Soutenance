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

            'design_title' => 'Espace de pilotage',
            'design_subtitle' => 'Suivi global de la plateforme éducative.',
            'design_box_1_title' => 'Contenus éducatifs',
            'design_box_1_text' => 'Les modules, conseils et quiz aident les parents à apprendre progressivement.',
            'design_box_2_title' => 'Suivi des parents',
            'design_box_2_text' => 'Les scores et progressions permettent de mieux observer l’évolution des utilisateurs.',
            'design_box_3_title' => 'Administration simple',
            'design_box_3_text' => 'L’interface facilite la gestion rapide des contenus et des comptes.',
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
        .dashboard-page {
    overflow-x: hidden;
}

.dashboard-compact-header {
    padding: 18px 22px !important;
    margin-bottom: 16px !important;
    border-radius: 20px !important;
}

.dashboard-compact-header h1 {
    font-size: 24px !important;
}

.dashboard-compact-header p {
    font-size: 13px !important;
    margin-top: 4px !important;
}

.role-pill {
    background: rgba(255, 255, 255, 0.20);
    color: white;
    border-radius: 999px;
    padding: 5px 11px;
    font-size: 11px;
    font-weight: 700;
    display: inline-block;
}

.mini-stat-card {
    background: white;
    border-radius: 16px;
    padding: 13px 14px;
    min-height: 118px;
    box-shadow: 0 8px 20px rgba(15, 23, 42, 0.07);
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}

.mini-icon {
    width: 34px;
    height: 34px;
    border-radius: 12px;
    background: #eef2ff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 17px;
    margin-bottom: 8px;
}

.mini-stat-card span {
    color: #64748b;
    font-size: 12px;
    font-weight: 700;
    line-height: 1.2;
}

.mini-stat-card h3 {
    color: #0f172a;
    font-size: 24px;
    font-weight: 800;
    margin: 5px 0 0;
}

.chart-card {
    background: white;
    border-radius: 18px;
    padding: 16px 18px;
    box-shadow: 0 8px 20px rgba(15, 23, 42, 0.07);
    height: 100%;
}

.chart-title {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 8px;
}

.chart-title h5 {
    font-size: 15px;
    font-weight: 800;
    margin: 0;
    color: #0f172a;
}

.chart-title span {
    font-size: 11px;
    font-weight: 700;
    color: #64748b;
}

.chart-wrapper {
    height: 245px;
}

.small-chart {
    height: 245px;
}

@if($theme === 'dark')
    .mini-stat-card,
    .chart-card {
        background: #1e293b !important;
        color: #f8fafc !important;
    }

    .mini-stat-card h3,
    .chart-title h5 {
        color: #f8fafc !important;
    }

    .mini-stat-card span,
    .chart-title span {
        color: #cbd5e1 !important;
    }

    .mini-icon {
        background: #0f172a !important;
    }
@endif
    </style>
</head>

<body>

<div class="container-fluid">
    <div class="row">

        @include('admin.partials.sidebar')

        <main class="col-md-10 p-3 admin-main dashboard-page">

    <div class="admin-page-header dashboard-compact-header">
        <div>
            <h1>{{ $t['dashboard'] }}</h1>
            <p>{{ $t['subtitle'] }}</p>

            <span class="role-pill mt-2">
                {{ $t['connected'] }} :
                {{ ucfirst(auth()->user()->role?->name ?? $t['user']) }}
            </span>
        </div>

        @include('admin.partials.header-actions')
    </div>

    <div class="row g-3 mb-3">

        @if(auth()->user()->role?->name === 'admin')
            <div class="col-6 col-xl-2">
                <div class="mini-stat-card">
                    <div class="mini-icon">👥</div>
                    <span>{{ $t['users'] }}</span>
                    <h3>{{ $totalUsers }}</h3>
                </div>
            </div>
        @endif

        <div class="col-6 col-xl-2">
            <div class="mini-stat-card">
                <div class="mini-icon">📘</div>
                <span>{{ $t['modules'] }}</span>
                <h3>{{ $totalModules }}</h3>
            </div>
        </div>

        <div class="col-6 col-xl-2">
            <div class="mini-stat-card">
                <div class="mini-icon">💡</div>
                <span>{{ $t['conseils'] }}</span>
                <h3>{{ $totalConseils }}</h3>
            </div>
        </div>

        <div class="col-6 col-xl-2">
            <div class="mini-stat-card">
                <div class="mini-icon">📝</div>
                <span>{{ $t['quiz'] }}</span>
                <h3>{{ $totalQuizzes }}</h3>
            </div>
        </div>

        <div class="col-6 col-xl-2">
            <div class="mini-stat-card">
                <div class="mini-icon">🏆</div>
                <span>{{ $t['scores'] }}</span>
                <h3>{{ $totalScores }}</h3>
            </div>
        </div>

        <div class="col-6 col-xl-2">
            <div class="mini-stat-card">
                <div class="mini-icon">📈</div>
                <span>{{ $t['progressions'] }}</span>
                <h3>{{ $totalProgressions }}</h3>
            </div>
        </div>

    </div>

    <div class="row g-3">

        <div class="col-12 col-lg-8">
            <div class="chart-card">
                <div class="chart-title">
                    <h5>Vue statistique</h5>
                    <span>Activités principales</span>
                </div>

                <div class="chart-wrapper">
                    <canvas id="dashboardBarChart"></canvas>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-4">
            <div class="chart-card">
                <div class="chart-title">
                    <h5>Répartition</h5>
                    <span>Contenus éducatifs</span>
                </div>

                <div class="chart-wrapper small-chart">
                    <canvas id="dashboardDoughnutChart"></canvas>
                </div>
            </div>
        </div>

    </div>

</main>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const barCtx = document.getElementById('dashboardBarChart');
    const doughnutCtx = document.getElementById('dashboardDoughnutChart');

    const statLabels = [
        '{{ $t['modules'] }}',
        '{{ $t['conseils'] }}',
        '{{ $t['quiz'] }}',
        '{{ $t['scores'] }}',
        '{{ $t['progressions'] }}'
    ];

    const statValues = [
        {{ $totalModules ?? 0 }},
        {{ $totalConseils ?? 0 }},
        {{ $totalQuizzes ?? 0 }},
        {{ $totalScores ?? 0 }},
        {{ $totalProgressions ?? 0 }}
    ];

    new Chart(barCtx, {
        type: 'bar',
        data: {
            labels: statLabels,
            datasets: [{
                label: 'Total',
                data: statValues,
                borderRadius: 10,
                backgroundColor: ['#2563EB', '#F59E0B', '#9333EA', '#F97316', '#22C55E']
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        precision: 0
                    }
                }
            }
        }
    });

    new Chart(doughnutCtx, {
        type: 'doughnut',
        data: {
            labels: [
                '{{ $t['modules'] }}',
                '{{ $t['conseils'] }}',
                '{{ $t['quiz'] }}'
            ],
            datasets: [{
                data: [
                    {{ $totalModules ?? 0 }},
                    {{ $totalConseils ?? 0 }},
                    {{ $totalQuizzes ?? 0 }}
                ],
                backgroundColor: ['#2563EB', '#F59E0B', '#9333EA'],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '68%',
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        boxWidth: 10,
                        font: {
                            size: 11
                        }
                    }
                }
            }
        }
    });
</script>

</body>
</html>
