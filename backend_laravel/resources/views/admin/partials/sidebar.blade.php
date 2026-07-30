@php
    $locale = session('admin_locale', 'fr');
    $theme = session('admin_theme', 'light');

    $texts = [
        'fr' => [
            'platform' => 'Plateforme Éducation Familiale',
            'subtitle' => 'Interface administration',
            'user' => 'Utilisateur',
            'dashboard' => 'Tableau de bord',
            'modules' => 'Modules éducatifs',
            'conseils' => 'Conseils',
            'quiz' => 'Quiz',
            'users' => 'Utilisateurs',
            'logout' => 'Déconnexion',
        ],
        'mg' => [
            'platform' => 'Fanabeazana ara-pianakaviana',
            'subtitle' => 'Interface fitantanana',
            'user' => 'Mpampiasa',
            'dashboard' => 'Tabilao fitantanana',
            'modules' => 'Modules fanabeazana',
            'conseils' => 'Torohevitra',
            'quiz' => 'Quiz',
            'users' => 'Mpampiasa',
            'logout' => 'Hivoaka',
        ],
    ];

    $t = $texts[$locale] ?? $texts['fr'];
@endphp

<style>
    :root {
        --app-primary: #2563EB;
        --app-primary-dark: #1E40AF;
        --app-secondary: #14B8A6;
        --app-accent: #F59E0B;
        --app-success: #22C55E;
        --app-danger: #EF4444;
        --app-info: #0EA5E9;
        --app-purple: #9333EA;
        --app-purple-dark: #7C3AED;
        --app-orange: #F97316;

        --app-bg: #F8FAFC;
        --app-dark-bg: #0F172A;
        --app-card: #FFFFFF;
        --app-dark-card: #1E293B;
        --app-text: #0F172A;
        --app-muted: #64748B;
        --app-muted-dark: #CBD5E1;
        --app-border: #E2E8F0;
        --app-border-dark: #334155;
    }

    body {
        font-size: 15px;
        background: var(--app-bg);
    }

    .admin-main,
    main {
        min-height: 100vh;
        background: var(--app-bg);
    }

    @keyframes fadeUp {
        from {
            opacity: 0;
            transform: translateY(12px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes softPulse {
        0% {
            box-shadow: 0 0 0 rgba(37, 99, 235, 0.0);
        }

        50% {
            box-shadow: 0 0 22px rgba(37, 99, 235, 0.24);
        }

        100% {
            box-shadow: 0 0 0 rgba(37, 99, 235, 0.0);
        }
    }

    @if($theme === 'dark')
        body,
        .bg-light,
        .admin-main,
        main {
            background: var(--app-dark-bg) !important;
            color: #F8FAFC !important;
        }

        .card,
        .admin-card,
        .content-card,
        .mini-stat-card,
        .chart-card,
        .quick-card {
            background: var(--app-dark-card) !important;
            color: #F8FAFC !important;
            border-color: var(--app-border-dark) !important;
        }

        .text-muted {
            color: var(--app-muted-dark) !important;
        }

        .table,
        .table td,
        .table th {
            background: var(--app-dark-card) !important;
            color: #F8FAFC !important;
            border-color: var(--app-border-dark) !important;
        }

        .table-light th {
            background: var(--app-border-dark) !important;
            color: #F8FAFC !important;
        }

        .form-control,
        .form-select,
        textarea {
            background: var(--app-dark-bg) !important;
            color: #F8FAFC !important;
            border-color: var(--app-border-dark) !important;
        }
    @endif

    .admin-sidebar {
        background: linear-gradient(
            180deg,
            var(--app-dark-bg) 0%,
            #111827 48%,
            var(--app-primary-dark) 100%
        );
        min-height: 100vh;
        padding: 16px 12px;
        box-shadow: 8px 0 26px rgba(15, 23, 42, 0.16);
    }

    .admin-logo {
        background: linear-gradient(
            135deg,
            rgba(37, 99, 235, 0.18),
            rgba(20, 184, 166, 0.12)
        );
        border: 1px solid rgba(255,255,255,0.12);
        border-radius: 18px;
        padding: 14px 12px;
        margin-bottom: 20px;
        animation: fadeUp 0.45s ease both;
    }

    .admin-logo-icon {
        width: 42px;
        height: 42px;
        border-radius: 14px;
        background: linear-gradient(135deg, var(--app-primary), var(--app-secondary));
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        margin-bottom: 10px;
        box-shadow: 0 8px 20px rgba(37, 99, 235, 0.32);
    }

    .admin-logo-title {
        color: #ffffff;
        font-weight: 800;
        font-size: 15px;
        line-height: 1.35;
        margin-bottom: 4px;
    }

    .admin-logo-subtitle {
        color: var(--app-muted-dark);
        font-size: 12px;
    }

    .admin-role-badge {
        background: rgba(245, 158, 11, 0.18);
        color: #FBBF24;
        border: 1px solid rgba(245, 158, 11, 0.25);
        border-radius: 999px;
        padding: 4px 10px;
        font-size: 11px;
        font-weight: 700;
        display: inline-block;
        margin-top: 10px;
    }

    .admin-nav-title {
        color: #94A3B8;
        font-size: 10px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin: 0 0 8px 8px;
    }

    .admin-nav-link {
        color: var(--app-muted-dark);
        border-radius: 14px;
        padding: 10px 12px;
        margin-bottom: 7px;
        font-size: 15px;
        font-weight: 600;
        transition: all 0.22s ease;
        display: flex;
        align-items: center;
        gap: 10px;
        text-decoration: none;
        animation: fadeUp 0.42s ease both;
    }

    .admin-nav-link span:first-child {
        width: 26px;
        height: 26px;
        border-radius: 9px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 15px;
        transition: all 0.22s ease;
    }

    .admin-nav-link:hover {
        color: #ffffff;
        transform: translateX(4px);
        background: rgba(255, 255, 255, 0.08);
    }

    .admin-nav-link.active {
        color: #ffffff;
        animation: softPulse 2.2s ease infinite;
    }

    .admin-sidebar .nav-item:nth-child(1) .admin-nav-link span:first-child {
        background: rgba(37, 99, 235, 0.18);
        color: #60A5FA;
    }

    .admin-sidebar .nav-item:nth-child(2) .admin-nav-link span:first-child {
        background: rgba(37, 99, 235, 0.18);
        color: #93C5FD;
    }

    .admin-sidebar .nav-item:nth-child(3) .admin-nav-link span:first-child {
        background: rgba(245, 158, 11, 0.18);
        color: #FBBF24;
    }

    .admin-sidebar .nav-item:nth-child(4) .admin-nav-link span:first-child {
        background: rgba(147, 51, 234, 0.18);
        color: #C084FC;
    }

    .admin-sidebar .nav-item:nth-child(5) .admin-nav-link span:first-child {
        background: rgba(34, 197, 94, 0.18);
        color: #4ADE80;
    }

    .admin-sidebar .nav-item:nth-child(1) .admin-nav-link.active {
        background: linear-gradient(135deg, var(--app-primary), var(--app-secondary));
    }

    .admin-sidebar .nav-item:nth-child(2) .admin-nav-link.active {
        background: linear-gradient(135deg, var(--app-primary), #1D4ED8);
    }

    .admin-sidebar .nav-item:nth-child(3) .admin-nav-link.active {
        background: linear-gradient(135deg, var(--app-accent), var(--app-orange));
    }

    .admin-sidebar .nav-item:nth-child(4) .admin-nav-link.active {
        background: linear-gradient(135deg, var(--app-purple-dark), var(--app-purple));
    }

    .admin-sidebar .nav-item:nth-child(5) .admin-nav-link.active {
        background: linear-gradient(135deg, var(--app-success), var(--app-secondary));
    }

    .admin-page-header {
        background: linear-gradient(135deg, var(--app-primary), var(--app-secondary));
        color: #ffffff;
        border-radius: 24px;
        padding: 22px 26px;
        margin-bottom: 22px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 18px;
        box-shadow: 0 14px 34px rgba(37, 99, 235, 0.20);
        animation: fadeUp 0.5s ease both;
    }

    .admin-page-header h1 {
        margin: 0;
        font-size: 26px;
        font-weight: 800;
        color: #ffffff;
    }

    .admin-page-header p {
        margin: 5px 0 0;
        color: rgba(255,255,255,0.90);
        font-size: 14px;
    }

    .admin-header-actions {
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
        justify-content: flex-end;
    }

    .admin-toggle-group {
        display: flex;
        align-items: center;
        gap: 5px;
        padding: 4px;
        border-radius: 999px;
        background: rgba(255, 255, 255, 0.18);
        backdrop-filter: blur(8px);
    }

    .admin-toggle-btn,
    .admin-back-btn,
    .admin-logout-top-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        white-space: nowrap;
        text-decoration: none;
    }

    .admin-btn-icon {
        font-size: 14px;
        line-height: 1;
    }

    .admin-toggle-btn {
        border-radius: 999px;
        padding: 7px 12px;
        font-size: 12px;
        font-weight: 800;
        color: #ffffff;
        transition: all 0.2s ease;
    }

    .admin-toggle-btn:hover {
        background: rgba(255, 255, 255, 0.18);
        color: #ffffff;
        transform: translateY(-1px);
    }

    .admin-toggle-btn.active {
        background: #ffffff;
        color: var(--app-primary);
        box-shadow: 0 5px 16px rgba(15, 23, 42, 0.16);
    }

    .admin-back-btn {
        background: #ffffff;
        color: var(--app-text);
        padding: 11px 16px;
        border-radius: 14px;
        font-size: 14px;
        font-weight: 800;
        box-shadow: 0 8px 20px rgba(15, 23, 42, 0.14);
        transition: all 0.2s ease;
    }

    .admin-back-btn:hover {
        color: var(--app-primary);
        background: #F8FAFC;
        transform: translateY(-1px);
    }

    .admin-logout-top-form {
        margin: 0;
    }

    .admin-logout-top-btn {
        border: none;
        background: linear-gradient(135deg, var(--app-danger), #DC2626);
        color: #ffffff;
        padding: 11px 16px;
        border-radius: 14px;
        font-size: 14px;
        font-weight: 800;
        box-shadow: 0 8px 20px rgba(239, 68, 68, 0.22);
        transition: all 0.2s ease;
    }

    .admin-logout-top-btn:hover {
        background: linear-gradient(135deg, #DC2626, #B91C1C);
        color: #ffffff;
        transform: translateY(-1px);
    }

    @media (max-width: 767px) {
        .admin-sidebar {
            min-height: auto;
            border-radius: 0 0 24px 24px;
        }

        .admin-page-header {
            flex-direction: column;
            align-items: flex-start;
            padding: 20px;
        }

        .admin-page-header h1 {
            font-size: 23px;
        }

        .admin-header-actions {
            justify-content: flex-start;
        }
    }
</style>

<div class="col-md-2 admin-sidebar d-flex flex-column">

    <div class="admin-logo">
        <div class="admin-logo-icon">👨‍👩‍👧</div>

        <div class="admin-logo-title">
            {{ $t['platform'] }}
        </div>

        <div class="admin-logo-subtitle">
            {{ $t['subtitle'] }}
        </div>

        <span class="admin-role-badge">
            {{ ucfirst(auth()->user()->role?->name ?? $t['user']) }}
        </span>
    </div>

    <div class="admin-nav-title">
        Menu
    </div>

    <ul class="nav flex-column flex-grow-1">

        <li class="nav-item">
            <a href="{{ route('admin.dashboard') }}"
               class="admin-nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <span>📊</span>
                <span>{{ $t['dashboard'] }}</span>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('admin.modules.index') }}"
               class="admin-nav-link {{ request()->routeIs('admin.modules.*') ? 'active' : '' }}">
                <span>📘</span>
                <span>{{ $t['modules'] }}</span>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('admin.conseils.index') }}"
               class="admin-nav-link {{ request()->routeIs('admin.conseils.*') ? 'active' : '' }}">
                <span>💡</span>
                <span>{{ $t['conseils'] }}</span>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('admin.quizzes.index') }}"
               class="admin-nav-link {{ request()->routeIs('admin.quizzes.*') ? 'active' : '' }}">
                <span>📝</span>
                <span>{{ $t['quiz'] }}</span>
            </a>
        </li>

        @if(auth()->user()->role?->name === 'admin')
            <li class="nav-item">
                <a href="{{ route('admin.users.index') }}"
                   class="admin-nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                    <span>👥</span>
                    <span>{{ $t['users'] }}</span>
                </a>
            </li>
        @endif

    </ul>

</div>
