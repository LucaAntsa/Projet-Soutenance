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
    @if($theme === 'dark')
        body,
        .bg-light,
        .admin-main,
        main {
            background: #0f172a !important;
            color: #f8fafc !important;
        }

        .card,
        .admin-card {
            background: #1e293b !important;
            color: #f8fafc !important;
            border-color: #334155 !important;
        }

        .text-muted {
            color: #cbd5e1 !important;
        }

        .table,
        .table td,
        .table th {
            background: #1e293b !important;
            color: #f8fafc !important;
            border-color: #334155 !important;
        }

        .table-light th {
            background: #334155 !important;
            color: #f8fafc !important;
        }

        .form-control,
        .form-select,
        textarea {
            background: #0f172a !important;
            color: #f8fafc !important;
            border-color: #334155 !important;
        }
    @endif

    .admin-sidebar {
        background: linear-gradient(180deg, #0f172a 0%, #111827 45%, #1e1b4b 100%);
        min-height: 100vh;
        padding: 18px 14px;
        box-shadow: 8px 0 30px rgba(15, 23, 42, 0.18);
    }

    .admin-logo {
        background: linear-gradient(135deg, rgba(255,255,255,0.13), rgba(255,255,255,0.05));
        border: 1px solid rgba(255,255,255,0.10);
        border-radius: 22px;
        padding: 18px 14px;
        margin-bottom: 24px;
    }

    .admin-logo-icon {
        width: 48px;
        height: 48px;
        border-radius: 16px;
        background: linear-gradient(135deg, #8b5cf6, #2563eb);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 23px;
        margin-bottom: 12px;
        box-shadow: 0 10px 25px rgba(37, 99, 235, 0.35);
    }

    .admin-logo-title {
        color: #ffffff;
        font-weight: 800;
        font-size: 16px;
        line-height: 1.35;
        margin-bottom: 5px;
    }

    .admin-logo-subtitle {
        color: #cbd5e1;
        font-size: 12px;
    }

    .admin-role-badge {
        background: rgba(245, 158, 11, 0.18);
        color: #fbbf24;
        border: 1px solid rgba(245, 158, 11, 0.25);
        border-radius: 999px;
        padding: 5px 12px;
        font-size: 12px;
        font-weight: 700;
        display: inline-block;
        margin-top: 12px;
    }

    .admin-nav-title {
        color: #64748b;
        font-size: 11px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin: 0 0 10px 10px;
    }

    .admin-nav-link {
        color: #cbd5e1;
        border-radius: 16px;
        padding: 12px 14px;
        margin-bottom: 8px;
        font-weight: 600;
        transition: all 0.22s ease;
        display: flex;
        align-items: center;
        gap: 12px;
        text-decoration: none;
    }

    .admin-nav-link span:first-child {
        width: 28px;
        height: 28px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(255,255,255,0.08);
    }

    .admin-nav-link:hover {
        background: rgba(37, 99, 235, 0.18);
        color: #ffffff;
        transform: translateX(4px);
    }

    .admin-nav-link.active {
        background: linear-gradient(135deg, #2563eb, #7c3aed);
        color: #ffffff;
        box-shadow: 0 10px 24px rgba(37, 99, 235, 0.35);
    }

    .admin-logout-btn {
        border: none;
        border-radius: 16px;
        padding: 12px;
        font-weight: 700;
        background: linear-gradient(135deg, #ef4444, #dc2626);
        box-shadow: 0 10px 20px rgba(220, 38, 38, 0.25);
    }

    .admin-logout-btn:hover {
        background: linear-gradient(135deg, #dc2626, #b91c1c);
    }

    .admin-page-header {
        background: linear-gradient(135deg, #8b1ee8, #a334f3);
        color: #ffffff;
        border-radius: 26px;
        padding: 30px 34px;
        margin-bottom: 28px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        box-shadow: 0 18px 40px rgba(124, 58, 237, 0.25);
    }

    .admin-page-header h1 {
        margin: 0;
        font-size: 32px;
        font-weight: 800;
        color: #ffffff;
    }

    .admin-page-header p {
        margin: 8px 0 0;
        color: rgba(255,255,255,0.92);
        font-size: 16px;
    }

    .admin-header-actions {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
        justify-content: flex-end;
    }

    .admin-toggle-group {
        display: flex;
        gap: 6px;
        padding: 5px;
        border-radius: 999px;
        background: rgba(255, 255, 255, 0.18);
        backdrop-filter: blur(8px);
    }

    .admin-toggle-btn {
        text-decoration: none;
        border-radius: 999px;
        padding: 8px 16px;
        font-size: 12px;
        font-weight: 800;
        color: #ffffff;
        transition: all 0.2s ease;
    }

    .admin-toggle-btn:hover {
        background: rgba(255, 255, 255, 0.18);
        color: #ffffff;
    }

    .admin-toggle-btn.active {
        background: #ffffff;
        color: #2563eb;
        box-shadow: 0 6px 18px rgba(15, 23, 42, 0.18);
    }

    .admin-back-btn {
        text-decoration: none;
        background: #ffffff;
        color: #1f2937;
        padding: 14px 22px;
        border-radius: 16px;
        font-weight: 800;
        box-shadow: 0 10px 24px rgba(15, 23, 42, 0.16);
    }

    .admin-back-btn:hover {
        color: #111827;
        background: #f8fafc;
    }

    @media (max-width: 767px) {
        .admin-sidebar {
            min-height: auto;
            border-radius: 0 0 24px 24px;
        }

        .admin-page-header {
            flex-direction: column;
            align-items: flex-start;
            padding: 24px;
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

    <form action="{{ route('admin.logout') }}" method="POST" class="mt-4">
        @csrf

        <button type="submit" class="btn btn-danger w-100 admin-logout-btn">
            {{ $t['logout'] }}
        </button>
    </form>

</div>
