@php
    $locale = session('admin_locale', 'fr');
    $theme = session('admin_theme', 'light');

    $texts = [
        'fr' => [
            'light' => 'Clair',
            'dark' => 'Sombre',
            'back' => 'Retour',
            'logout' => 'Déconnexion',
        ],
        'mg' => [
            'light' => 'Mazava',
            'dark' => 'Maizina',
            'back' => 'Hiverina',
            'logout' => 'Hivoaka',
        ],
    ];

    $t = $texts[$locale] ?? $texts['fr'];
@endphp

<div class="admin-header-actions">

    <div class="admin-toggle-group">
        <a href="{{ route('admin.lang', 'fr') }}"
           class="admin-toggle-btn {{ $locale === 'fr' ? 'active' : '' }}"
           title="Français">
            <span class="admin-btn-icon">🇫🇷</span>
            <span>FR</span>
        </a>

        <a href="{{ route('admin.lang', 'mg') }}"
           class="admin-toggle-btn {{ $locale === 'mg' ? 'active' : '' }}"
           title="Malagasy">
            <span class="admin-btn-icon">🇲🇬</span>
            <span>MG</span>
        </a>
    </div>

    <div class="admin-toggle-group">
        <a href="{{ route('admin.theme', 'light') }}"
           class="admin-toggle-btn {{ $theme === 'light' ? 'active' : '' }}"
           title="{{ $t['light'] }}">
            <span class="admin-btn-icon">☀️</span>
            <span>{{ $t['light'] }}</span>
        </a>

        <a href="{{ route('admin.theme', 'dark') }}"
           class="admin-toggle-btn {{ $theme === 'dark' ? 'active' : '' }}"
           title="{{ $t['dark'] }}">
            <span class="admin-btn-icon">🌙</span>
            <span>{{ $t['dark'] }}</span>
        </a>
    </div>

    @isset($backUrl)
        <a href="{{ $backUrl }}" class="admin-back-btn">
            <span class="admin-btn-icon">↩️</span>
            <span>{{ $backText ?? $t['back'] }}</span>
        </a>
    @endisset

    <form action="{{ route('admin.logout') }}" method="POST" class="admin-logout-top-form">
        @csrf

        <button type="submit" class="admin-logout-top-btn">
            <span class="admin-btn-icon">🚪</span>
            <span>{{ $t['logout'] }}</span>
        </button>
    </form>

</div>
