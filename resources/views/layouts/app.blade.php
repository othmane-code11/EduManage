{{-- resources/views/layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" {{ app()->getLocale() === 'ar' ? 'dir="rtl"' : '' }}>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', __('dashboard.app_name')) — {{ __('dashboard.app_name') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;500;600;700;800&family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;1,9..40,300&display=swap" rel="stylesheet">
<style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        :root {
            --blue-950: #012244;
            --blue-900: #042c53;
            --blue-800: #0c447c;
            --blue-700: #185fa5;
            --blue-600: #2478c8;
            --blue-500: #378add;
            --blue-400: #6aaee8;
            --blue-300: #b5d4f4;
            --blue-100: #deedfb;
            --blue-50:  #f0f7ff;
            --accent:   #38bdf8;
            --gold:     #f59e0b;
            --surface:    rgba(255,255,255,0.03);
            --border:     rgba(55,138,221,0.14);
            --white:      #ffffff;
            --muted:      #9ca3af;
            --sidebar-w:  260px;
        }

        /* ── Light Mode CSS Variables ── */
        :root.light-mode {
            --blue-950: #f8fafc;
            --blue-900: #f1f5f9;
            --blue-800: #e2e8f0;
            --blue-700: #cbd5e1;
            --blue-600: #94a3b8;
            --blue-500: #64748b;
            --blue-400: #475569;
            --blue-300: #1e293b;
            --blue-100: #0f172a;
            --blue-50:  #1e293b;
            --accent:   #0284c7;
            --gold:     #f59e0b;
            --surface:    rgba(0,0,0,0.04);
            --border:     rgba(2,132,199,0.14);
            --white:      #1e293b;
            --muted:      #64748b;
        }

        body.light-mode {
            background: #f8fafc;
            color: #1e293b;
        }

        body.light-mode .bg-fixed {
            background:
                radial-gradient(ellipse 55% 40% at 0% 0%, rgba(2,132,199,0.1) 0%, transparent 60%),
                radial-gradient(ellipse 45% 35% at 100% 100%, rgba(15,23,42,0.1) 0%, transparent 60%),
                #f8fafc;
        }

        body.light-mode .sidebar {
            background: rgba(248,250,252,0.95);
            border-right: 1px solid rgba(2,132,199,0.14);
        }

        body.light-mode .topbar {
            background: rgba(248,250,252,0.8);
            border-bottom: 1px solid rgba(2,132,199,0.14);
        }

        body.light-mode .card {
            background: rgba(0,0,0,0.02);
            border: 1px solid rgba(2,132,199,0.14);
        }

        body.light-mode .nav-item {
            color: #64748b;
        }

        body.light-mode .nav-item:hover {
            background: rgba(2,132,199,0.08);
            color: #0284c7;
        }

        body.light-mode .nav-item.active {
            background: rgba(2,132,199,0.15);
            color: #0c4a6e;
            border: 1px solid rgba(2,132,199,0.2);
        }

        body.light-mode .topbar-btn {
            background: rgba(0,0,0,0.03);
            border: 1px solid rgba(2,132,199,0.14);
            color: #64748b;
        }

        body.light-mode .topbar-btn:hover {
            background: rgba(2,132,199,0.1);
            color: #0284c7;
            border-color: rgba(2,132,199,0.3);
        }

        html { scroll-behavior: smooth; }
        body {
            font-family: 'DM Sans', sans-serif;
            background: #011a38;
            color: var(--white);
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* ── Fixed background ── */
        .bg-fixed {
            position: fixed; inset: 0; z-index: 0; pointer-events: none;
            background:
                radial-gradient(ellipse 55% 40% at 0% 0%, rgba(12,68,124,0.35) 0%, transparent 60%),
                radial-gradient(ellipse 45% 35% at 100% 100%, rgba(1,34,68,0.4) 0%, transparent 60%),
                #011a38;
        }
        .bg-fixed::after {
            content: '';
            position: absolute; inset: 0;
            background-image:
                linear-gradient(rgba(55,138,221,0.04) 1px, transparent 1px),
                linear-gradient(90deg, rgba(55,138,221,0.04) 1px, transparent 1px);
            background-size: 56px 56px;
        }

        /* ── Sidebar ── */
        .sidebar {
            position: fixed; top: 0; left: 0; bottom: 0;
            width: var(--sidebar-w);
            background: rgba(1,34,68,0.9);
            backdrop-filter: blur(20px);
            border-right: 1px solid var(--border);
            z-index: 100;
            display: flex; flex-direction: column;
            transition: transform 0.35s cubic-bezier(0.22,1,0.36,1);
        }
        .sidebar-brand {
            padding: 1.6rem 1.5rem 1.2rem;
            border-bottom: 1px solid var(--border);
            display: flex; align-items: center; gap: 0.75rem;
        }

        body.light-mode .sidebar-brand {
            border-bottom: 1px solid rgba(2,132,199,0.14);
        }
        .brand-icon {
            width: 40px; height: 40px; border-radius: 11px;
            background: linear-gradient(135deg, var(--blue-600), var(--accent));
            display: flex; align-items: center; justify-content: center;
            font-size: 18px; flex-shrink: 0;
            box-shadow: 0 6px 18px rgba(55,138,221,0.35);
        }

        body.light-mode .brand-icon {
            box-shadow: 0 6px 18px rgba(2,132,199,0.2);
        }
        .brand-name {
            font-family: 'Syne', sans-serif;
            font-size: 1.25rem; font-weight: 700; letter-spacing: -0.03em;
            background: linear-gradient(135deg, #fff 30%, var(--blue-300));
            -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;
        }

        body.light-mode .brand-name {
            background: none;
            -webkit-background-clip: unset;
            -webkit-text-fill-color: unset;
            background-clip: unset;
            color: #003d7a;
            font-weight: 700;
        }

        .sidebar-nav { flex: 1; padding: 1.25rem 0.75rem; overflow-y: auto; }
        .nav-section-label {
            font-size: 0.65rem; font-weight: 600; letter-spacing: 0.12em;
            text-transform: uppercase; color: rgba(55,138,221,0.5);
            padding: 0.75rem 0.75rem 0.4rem;
        }
        .nav-item {
            display: flex; align-items: center; gap: 0.75rem;
            padding: 0.65rem 0.75rem;
            border-radius: 10px;
            color: var(--muted);
            text-decoration: none;
            font-size: 0.9rem; font-weight: 500;
            transition: background 0.2s, color 0.2s;
            margin-bottom: 2px;
            position: relative;
        }
        .nav-item svg { flex-shrink: 0; opacity: 0.7; transition: opacity 0.2s; }
        .nav-item:hover { background: rgba(55,138,221,0.08); color: var(--blue-300); }
        .nav-item:hover svg { opacity: 1; }
        .nav-item.active {
            background: linear-gradient(135deg, rgba(55,138,221,0.2), rgba(24,95,165,0.12));
            color: var(--blue-300); border: 1px solid rgba(55,138,221,0.2);
        }
        .nav-item.active svg { opacity: 1; }
        .nav-item.active::before {
            content: '';
            position: absolute; left: 0; top: 25%; bottom: 25%;
            width: 3px; border-radius: 99px;
            background: linear-gradient(var(--blue-500), var(--accent));
        }
        .nav-badge {
            margin-left: auto;
            background: linear-gradient(135deg, var(--blue-600), var(--blue-800));
            color: white; font-size: 0.65rem; font-weight: 700;
            padding: 2px 7px; border-radius: 99px;
        }

        .sidebar-user {
            padding: 1rem 1.25rem;
            border-top: 1px solid var(--border);
            display: flex; align-items: center; gap: 0.75rem;
        }
        .user-avatar {
            width: 36px; height: 36px; border-radius: 50%;
            background: linear-gradient(135deg, var(--blue-600), var(--accent));
            display: flex; align-items: center; justify-content: center;
            overflow: hidden;
            font-size: 0.8rem; font-weight: 700; flex-shrink: 0;
            border: 2px solid rgba(55,138,221,0.3);
        }
        .user-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .user-info { flex: 1; min-width: 0; }
        .user-name { font-size: 0.85rem; font-weight: 600; color: var(--white); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .user-role { font-size: 0.72rem; color: var(--muted); }
        .logout-btn {
            background: none; border: none; color: var(--muted);
            cursor: pointer; padding: 4px; border-radius: 6px;
            transition: color 0.2s, background 0.2s;
            display: flex;
        }
        .logout-btn:hover { color: #f87171; background: rgba(248,113,113,0.1); }

        /* ── Topbar ── */
        .topbar {
            position: fixed; top: 0; left: var(--sidebar-w); right: 0; height: 64px;
            background: rgba(1,34,68,0.8); backdrop-filter: blur(16px);
            border-bottom: 1px solid var(--border);
            z-index: 90;
            display: flex; align-items: center; justify-content: space-between;
            padding: 0 2rem;
        }
        .topbar-left { display: flex; align-items: center; gap: 0.75rem; }
        .hamburger {
            display: none; background: none; border: none; color: var(--white);
            cursor: pointer; padding: 6px; border-radius: 8px;
        }
        .topbar-title {
            font-family: 'Syne', sans-serif;
            font-size: 1rem; font-weight: 700; color: var(--white);
        }
        .topbar-right { display: flex; align-items: center; gap: 0.75rem; }
        .topbar-btn {
            width: 36px; height: 36px; border-radius: 10px;
            background: var(--surface); border: 1px solid var(--border);
            color: var(--muted); cursor: pointer;
            display: flex; align-items: center; justify-content: center;
            transition: background 0.2s, color 0.2s, border-color 0.2s;
        }
        .topbar-btn:hover { background: rgba(55,138,221,0.1); color: var(--blue-300); border-color: rgba(55,138,221,0.3); }
        .notif-dot { position: relative; }
        .notif-dot::after {
            content: ''; position: absolute; top: 6px; right: 6px;
            width: 8px; height: 8px; border-radius: 50%;
            background: var(--accent); border: 2px solid #011a38;
        }

        /* ── Main content ── */
        .main {
            position: relative; z-index: 1;
            margin-left: var(--sidebar-w);
            padding-top: 64px;
            min-height: 100vh;
        }
        .content { padding: 2rem 2.5rem; }

        /* ── Overlay for mobile ── */
        .overlay {
            display: none; position: fixed; inset: 0; z-index: 99;
            background: rgba(0,0,0,0.6); backdrop-filter: blur(4px);
        }
        .overlay.open { display: block; }

        /* ── Responsive ── */
        @media (max-width: 900px) {
            :root { --sidebar-w: 260px; }
            .sidebar { transform: translateX(-100%); }
            .sidebar.open { transform: translateX(0); }
            .topbar { left: 0; }
            .main { margin-left: 0; }
            .hamburger { display: flex; }
            .content { padding: 1.5rem 1.25rem; }
        }
        @media (max-width: 480px) {
            .content { padding: 1.25rem 1rem; }
            .topbar { padding: 0 1rem; }
        }

        /* ── Shared component styles ── */
        .card {
            background: rgba(255,255,255,0.03);
            border: 1px solid var(--border);
            border-radius: 18px;
            transition: border-color 0.25s, transform 0.25s, box-shadow 0.25s;
        }
        .card:hover { border-color: rgba(55,138,221,0.28); }
        .pill {
            display: inline-flex; align-items: center; gap: 0.35rem;
            padding: 3px 10px; border-radius: 99px; font-size: 0.72rem; font-weight: 600;
        }
        .pill-purple { background: rgba(55,138,221,0.15); color: var(--blue-300); border: 1px solid rgba(55,138,221,0.2); }
        .pill-green  { background: rgba(34,197,94,0.12); color: #4ade80; border: 1px solid rgba(34,197,94,0.2); }
        .pill-amber  { background: rgba(245,158,11,0.12); color: #fbbf24; border: 1px solid rgba(245,158,11,0.2); }
        .pill-blue   { background: rgba(59,130,246,0.12); color: #93c5fd; border: 1px solid rgba(59,130,246,0.2); }
        .pill-pink   { background: rgba(56,189,248,0.12); color: var(--blue-300); border: 1px solid rgba(56,189,248,0.2); }

        @keyframes fadeUp { from { opacity:0; transform: translateY(20px); } to { opacity:1; transform: translateY(0); } }
        .anim { animation: fadeUp 0.5s cubic-bezier(0.22,1,0.36,1) both; }
        .anim-d1 { animation-delay: 0.05s; }
        .anim-d2 { animation-delay: 0.10s; }
        .anim-d3 { animation-delay: 0.15s; }
        .anim-d4 { animation-delay: 0.20s; }
        .anim-d5 { animation-delay: 0.25s; }
        .anim-d6 { animation-delay: 0.30s; }

        /* Language Menu Styles */
        .language-menu {
            position: absolute;
            top: 100%;
            right: 0;
            margin-top: 0.5rem;
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 10px;
            min-width: 140px;
            z-index: 1000;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
        }

        body.light-mode .language-menu {
            background: rgba(248,250,252,0.95);
            border: 1px solid rgba(2,132,199,0.14);
        }

        .lang-option {
            display: block;
            padding: 0.75rem 1rem;
            color: var(--text-primary);
            text-decoration: none;
            transition: background 0.2s;
            font-size: 0.9rem;
        }

        .lang-option:hover {
            background: var(--surface);
        }

        .lang-option:first-child {
            border-radius: 10px 10px 0 0;
        }

        .lang-option:last-child {
            border-radius: 0 0 10px 10px;
        }

        body.light-mode .lang-option {
            color: #1e293b;
        }

        body.light-mode .lang-option:hover {
            background: rgba(2,132,199,0.08);
        }

        /* RTL support */
        [dir="rtl"] .sidebar {
            left: auto;
            right: 0;
            border-right: none;
            border-left: 1px solid var(--border);
        }
        [dir="rtl"] .topbar {
            left: 0;
            right: var(--sidebar-w);
        }
        [dir="rtl"] .main {
            margin-left: 0;
            margin-right: var(--sidebar-w);
        }
        [dir="rtl"] .nav-item.active::before {
            left: auto;
            right: 0;
        }
        @media (max-width: 900px) {
            [dir="rtl"] .sidebar { transform: translateX(100%); }
            [dir="rtl"] .sidebar.open { transform: translateX(0); }
            [dir="rtl"] .main { margin-right: 0; }
            [dir="rtl"] .topbar { right: 0; }
        }
    </style>
    @stack('styles')
</head>
<body>
<div class="bg-fixed"></div>

<!-- Overlay (mobile) -->
<div class="overlay" id="overlay" onclick="closeSidebar()"></div>

<!-- Sidebar -->
<aside class="sidebar" id="sidebar">
    <div class="sidebar-brand">
        <div class="brand-icon">🎓</div>
        <span class="brand-name">EduManage</span>
    </div>

    <nav class="sidebar-nav">
        <div class="nav-section-label">{{ __('navigation.main') }}</div>
        @if(auth()->user()->role === 'admin')
            <a href="{{ route('dashboard') }}" class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg>
                {{ __('navigation.dashboard') }}
            </a>
        @endif

        @if(in_array(auth()->user()->role, ['admin', 'formateur', 'student'], true))
            <!-- "Trainings" → "Emploi" with a briefcase/job icon -->
            <a href="{{ route('schedule') }}" class="nav-item {{ request()->routeIs('schedule', 'schedules.*') ? 'active' : '' }}">
                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <rect x="2" y="7" width="20" height="14" rx="2"/>
                    <path d="M16 7V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2"/>
                    <line x1="12" y1="12" x2="12" y2="12"/>
                    <path d="M2 13h20"/>
                </svg>
                {{ __('navigation.schedule') }}
            </a>

        @endif

        @if(in_array(auth()->user()->role, ['admin', 'formateur', 'student'], true))
            <!-- "Sessions" → "Absence" with a user-x / absence icon -->
            <a href="{{ route('absence') }}" class="nav-item {{ request()->routeIs('absence') ? 'active' : '' }}">
                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                    <circle cx="9" cy="7" r="4"/>
                    <line x1="17" y1="8" x2="23" y2="14"/>
                    <line x1="23" y1="8" x2="17" y2="14"/>
                </svg>
                {{ __('navigation.absence') }}
                @if(isset($students))<span class="nav-badge">{{ $students->count() }}</span>@endif
            </a>
        @endif

        <a href="{{ route('dashboard.blog.index') }}" class="nav-item {{ request()->routeIs('dashboard.blog.*') ? 'active' : '' }}">
            <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
            {{ __('navigation.blog') }}
        </a>

        <div class="nav-section-label" style="margin-top:0.5rem;">{{ __('navigation.account') }}</div>
        <a href="{{ route('profile') }}" class="nav-item">
            <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
            {{ __('navigation.my_profile') }}
        </a>
        <a href="{{ route('settings') }}" class="nav-item">
            <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="3"/><path d="M19.07 4.93a10 10 0 0 1 0 14.14M4.93 4.93a10 10 0 0 0 0 14.14"/></svg>
            {{ __('navigation.settings') }}
        </a>
    </nav>

    <div class="sidebar-user">
        <div class="user-avatar">
            @if(auth()->user()->profile_photo_url)
                <img src="{{ auth()->user()->profile_photo_url }}" alt="{{ auth()->user()->name }} avatar">
            @else
                {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
            @endif
        </div>
        <div class="user-info">
            <div class="user-name">{{ auth()->user()->name}}</div>
            <div class="user-role">{{ auth()->user()->role }}</div>
        </div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
                <button type="submit" class="logout-btn" title="{{ __('sidebar.logout') }}">
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
            </button>
        </form>
    </div>
</aside>

<!-- Topbar -->
<header class="topbar">
    <div class="topbar-left">
        <button class="hamburger" onclick="toggleSidebar()">
            <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
        </button>
        <span class="topbar-title">@yield('page-title', __('sidebar.dashboard'))</span>
    </div>
    <div class="topbar-right">
        <!-- Language Switcher -->
        <div class="topbar-dropdown" style="position: relative;">
            <button class="topbar-btn" title="{{ __('sidebar.language') }}" onclick="toggleLanguageMenu()" style="font-weight: 600;">
                @if($currentLocale === 'fr')
                    FR
                @elseif($currentLocale === 'ar')
                    AR
                @else
                    EN
                @endif
            </button>
            <div id="languageMenu" class="language-menu" style="display: none;">
                @foreach($localeOptions as $option)
                    <a href="{{ route('lang.switch', ['locale' => $option['code']]) }}" class="lang-option" onclick="persistLocale('{{ $option['code'] }}')">
                        {{ $option['flag'] }} {{ $option['label'] }}
                    </a>
                @endforeach
            </div>
        </div>

        <!-- Theme Switcher -->
        <button class="topbar-btn" id="themeToggle" title="{{ __('sidebar.toggle_theme') }}" onclick="toggleTheme()">
            <svg id="sunIcon" width="16" height="16" fill="currentColor" viewBox="0 0 24 24" style="display: none;">
                <circle cx="12" cy="12" r="5"/>
                <line x1="12" y1="1" x2="12" y2="3"/>
                <line x1="12" y1="21" x2="12" y2="23"/>
                <line x1="4.22" y1="4.22" x2="5.64" y2="5.64"/>
                <line x1="18.36" y1="18.36" x2="19.78" y2="19.78"/>
                <line x1="1" y1="12" x2="3" y2="12"/>
                <line x1="21" y1="12" x2="23" y2="12"/>
                <line x1="4.22" y1="19.78" x2="5.64" y2="18.36"/>
                <line x1="18.36" y1="5.64" x2="19.78" y2="4.22"/>
            </svg>
            <svg id="moonIcon" width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
                <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/>
            </svg>
        </button>

        <button class="topbar-btn notif-dot" title="{{ __('sidebar.notifications') }}">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
        </button>
        <button class="topbar-btn" title="{{ __('sidebar.search') }}">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
        </button>
    </div>
</header>

<!-- Main -->
<main class="main">
    <div class="content">
        @yield('content')
    </div>
</main>

<script>
function toggleSidebar() {
    document.getElementById('sidebar').classList.toggle('open');
    document.getElementById('overlay').classList.toggle('open');
}
function closeSidebar() {
    document.getElementById('sidebar').classList.remove('open');
    document.getElementById('overlay').classList.remove('open');
}

// Theme Switching
function toggleTheme() {
    const html = document.documentElement;
    const body = document.body;
    const sunIcon = document.getElementById('sunIcon');
    const moonIcon = document.getElementById('moonIcon');

    if (html.classList.contains('light-mode')) {
        html.classList.remove('light-mode');
        body.classList.remove('light-mode');
        localStorage.setItem('theme', 'dark');
        sunIcon.style.display = 'none';
        moonIcon.style.display = 'block';
    } else {
        html.classList.add('light-mode');
        body.classList.add('light-mode');
        localStorage.setItem('theme', 'light');
        sunIcon.style.display = 'block';
        moonIcon.style.display = 'none';
    }
}

// Initialize theme on page load
document.addEventListener('DOMContentLoaded', function() {
    const savedTheme = localStorage.getItem('theme') || 'dark';
    const html = document.documentElement;
    const body = document.body;
    const sunIcon = document.getElementById('sunIcon');
    const moonIcon = document.getElementById('moonIcon');

    if (savedTheme === 'light') {
        html.classList.add('light-mode');
        body.classList.add('light-mode');
        sunIcon.style.display = 'block';
        moonIcon.style.display = 'none';
    } else {
        html.classList.remove('light-mode');
        body.classList.remove('light-mode');
        sunIcon.style.display = 'none';
        moonIcon.style.display = 'block';
    }
});

// Language Menu Toggle
function toggleLanguageMenu() {
    const menu = document.getElementById('languageMenu');
    if (menu.style.display === 'none') {
        menu.style.display = 'block';
    } else {
        menu.style.display = 'none';
    }
}

function persistLocale(locale) {
    localStorage.setItem('locale', locale);
}

// Close language menu when clicking outside
document.addEventListener('click', function(event) {
    const menu = document.getElementById('languageMenu');
    const btn = event.target.closest('.topbar-dropdown');
    if (!btn && menu) {
        menu.style.display = 'none';
    }
});
</script>
@stack('scripts')
</body>
</html>