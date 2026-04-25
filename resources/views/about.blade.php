<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" {{ app()->getLocale() === 'ar' ? 'dir="rtl"' : '' }}>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('messages.about_meta_title') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --bg-deep:    #040d21;
            --bg-card:    #0b1735;
            --bg-card2:   #0e1f42;
            --accent:     #3b82f6;
            --accent2:    #06b6d4;
            --accent-glow: rgba(59,130,246,.35);
            --text-primary: #f0f6ff;
            --text-muted:   #8ca3c8;
            --border:       rgba(59,130,246,.18);
            --green:  #22c55e;
            --purple: #a855f7;
            --yellow: #eab308;
        }

        html { scroll-behavior: smooth; }

        body {
            background: var(--bg-deep);
            color: var(--text-primary);
            font-family: 'DM Sans', sans-serif;
            min-height: 100vh;
            overflow-x: hidden;
        }

        body::before {
            content: '';
            position: fixed; inset: 0; z-index: 0; pointer-events: none;
            background:
                radial-gradient(ellipse 600px 400px at 10% 30%,  rgba(59,130,246,.12) 0%, transparent 70%),
                radial-gradient(ellipse 500px 350px at 90% 60%,  rgba(6,182,212,.10) 0%, transparent 70%),
                radial-gradient(ellipse 400px 300px at 50% 100%, rgba(168,85,247,.08) 0%, transparent 70%);
        }

        nav {
            position: sticky; top: 0; z-index: 100;
            display: flex; align-items: center; justify-content: space-between;
            padding: 0 2.5rem;
            height: 68px;
            background: rgba(4,13,33,.82);
            backdrop-filter: blur(18px);
            border-bottom: 1px solid var(--border);
        }

        .nav-logo {
            display: flex; align-items: center; gap: .55rem;
            font-family: 'Syne', sans-serif; font-weight: 800; font-size: 1.25rem;
            color: var(--text-primary); text-decoration: none;
        }

        .nav-logo svg { width: 32px; height: 32px; }

        .nav-links {
            display: flex; gap: 2rem; list-style: none;
        }

        .nav-links a {
            color: var(--text-muted); font-size: .93rem; font-weight: 500;
            text-decoration: none; transition: color .2s;
        }
        .nav-links a:hover, .nav-links a.active { color: var(--text-primary); }

        .nav-actions { display: flex; align-items: center; gap: 1rem; }

        .btn-primary {
            display: inline-flex; align-items: center; gap: .45rem;
            background: var(--accent); color: #fff;
            border: none; border-radius: 8px; cursor: pointer;
            font-family: inherit; font-size: .93rem; font-weight: 600;
            padding: .6rem 1.3rem;
            box-shadow: 0 0 22px var(--accent-glow);
            transition: opacity .2s, box-shadow .2s;
            text-decoration: none;
        }
        .btn-primary:hover { opacity: .88; box-shadow: 0 0 32px var(--accent-glow); }

        .btn-ghost {
            background: none; border: none; cursor: pointer;
            color: var(--text-muted); font-family: inherit; font-size: .93rem;
            font-weight: 500; transition: color .2s; padding: .4rem .6rem;
        }
        .btn-ghost:hover { color: var(--text-primary); }

        .main-content {
            position: relative; z-index: 1;
        }

        .section {
            max-width: 1200px; margin: 0 auto;
            padding: 5rem 2.5rem;
        }

        .section-header {
            text-align: center;
            margin-bottom: 3rem;
        }

        .section-badge {
            display: inline-flex; align-items: center; gap: .45rem;
            background: rgba(59,130,246,.12); border: 1px solid var(--border);
            border-radius: 50px; padding: .35rem .9rem;
            font-size: .8rem; font-weight: 500; color: var(--accent2);
            margin-bottom: 1rem;
        }

        .section-title {
            font-family: 'Syne', sans-serif;
            font-size: clamp(2rem, 4vw, 3rem);
            font-weight: 800; line-height: 1.2;
            margin-bottom: 1rem;
        }

        .section-desc {
            color: var(--text-muted); font-size: 1rem; line-height: 1.7;
            max-width: 600px; margin: 0 auto;
        }

        /* Two column layout */
        .content-grid {
            display: grid; grid-template-columns: 1fr 1fr;
            gap: 4rem; align-items: center;
            margin: 3rem 0;
        }

        .content-text h2 {
            font-family: 'Syne', sans-serif;
            font-size: 2rem; font-weight: 700;
            margin-bottom: 1.2rem;
        }

        .content-text p {
            color: var(--text-muted);
            font-size: .95rem;
            line-height: 1.8;
            margin-bottom: 1.2rem;
        }

        .content-text strong {
            color: var(--accent2);
        }

        /* Stats section */
        .stats-grid {
            display: grid; grid-template-columns: repeat(3, 1fr);
            gap: 2rem; margin-top: 3rem;
        }

        .stat-item {
            text-align: center;
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 2rem;
        }

        .stat-value {
            font-family: 'Syne', sans-serif;
            font-size: 2.5rem; font-weight: 800;
            color: var(--accent);
            margin-bottom: .5rem;
        }

        .stat-label {
            color: var(--text-muted);
            font-size: .9rem;
        }

        /* Values section */
        .values-grid {
            display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 2rem; margin-top: 3rem;
        }

        .value-card {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 16px; padding: 2rem;
            text-align: center;
        }

        .value-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
        }

        .value-title {
            font-family: 'Syne', sans-serif;
            font-size: 1.1rem; font-weight: 700;
            margin-bottom: .6rem;
        }

        .value-desc {
            color: var(--text-muted);
            font-size: .9rem;
            line-height: 1.6;
        }

        /* Responsive */
        @media (max-width: 900px) {
            nav { padding: 0 1.2rem; }
            .nav-links { display: none; }
            .section { padding: 3rem 1.5rem; }
            .content-grid { grid-template-columns: 1fr; gap: 2rem; }
            .stats-grid { grid-template-columns: 1fr; }
            .values-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

@include('partials.public-navbar', ['active' => 'about'])

<div class="main-content">
    {{-- ═══════════════ HERO SECTION ═══════════════ --}}
    <section class="section">
        <div class="section-header">
            <div class="section-badge">📖 {{ __('messages.about_badge') }}</div>
            <h1 class="section-title">{{ __('messages.about_title') }}</h1>
            <p class="section-desc">
                {{ __('messages.about_description') }}
            </p>
        </div>
    </section>

    {{-- ═══════════════ ABOUT CONTENT ═══════════════ --}}
    <section class="section">
        <div class="content-grid">
            <div class="content-text">
                <h2>{{ __('messages.about_mission_title') }}</h2>
                <p>
                    {!! __('messages.about_mission_p1') !!}
                </p>
                <p>
                    {{ __('messages.about_mission_p2') }}
                </p>
            </div>
            <div>
                <img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 400 400'%3E%3Crect width='400' height='400' fill='%230b1735'/%3E%3Ccircle cx='200' cy='200' r='80' fill='%233b82f6' opacity='0.2'/%3E%3Crect x='150' y='120' width='100' height='160' rx='10' fill='%233b82f6' opacity='0.3'/%3E%3C/svg%3E" alt="{{ __('messages.about_mission_alt') }}" style="width: 100%; border-radius: 16px; border: 1px solid rgba(59,130,246,.18);">
            </div>
        </div>
    </section>

    {{-- ═══════════════ STATS ═══════════════ --}}
    <section class="section">
        <div class="stats-grid">
            <div class="stat-item">
                <div class="stat-value">50K+</div>
                <div class="stat-label">{{ __('messages.about_stat_1') }}</div>
            </div>
            <div class="stat-item">
                <div class="stat-value">1,200+</div>
                <div class="stat-label">{{ __('messages.about_stat_2') }}</div>
            </div>
            <div class="stat-item">
                <div class="stat-value">92%</div>
                <div class="stat-label">{{ __('messages.about_stat_3') }}</div>
            </div>
        </div>
    </section>

    {{-- ═══════════════ VALUES ═══════════════ --}}
    <section class="section">
        <div class="section-header">
            <h2 class="section-title">{{ __('messages.about_values_title') }}</h2>
            <p class="section-desc">
                {{ __('messages.about_values_desc') }}
            </p>
        </div>

        <div class="values-grid">
            <div class="value-card">
                <div class="value-icon">🎯</div>
                <div class="value-title">{{ __('messages.about_value_1_title') }}</div>
                <div class="value-desc">
                    {{ __('messages.about_value_1_desc') }}
                </div>
            </div>

            <div class="value-card">
                <div class="value-icon">🤝</div>
                <div class="value-title">{{ __('messages.about_value_2_title') }}</div>
                <div class="value-desc">
                    {{ __('messages.about_value_2_desc') }}
                </div>
            </div>

            <div class="value-card">
                <div class="value-icon">🚀</div>
                <div class="value-title">{{ __('messages.about_value_3_title') }}</div>
                <div class="value-desc">
                    {{ __('messages.about_value_3_desc') }}
                </div>
            </div>

            <div class="value-card">
                <div class="value-icon">💚</div>
                <div class="value-title">{{ __('messages.about_value_4_title') }}</div>
                <div class="value-desc">
                    {{ __('messages.about_value_4_desc') }}
                </div>
            </div>

            <div class="value-card">
                <div class="value-icon">🔍</div>
                <div class="value-title">{{ __('messages.about_value_5_title') }}</div>
                <div class="value-desc">
                    {{ __('messages.about_value_5_desc') }}
                </div>
            </div>

            <div class="value-card">
                <div class="value-icon">⭐</div>
                <div class="value-title">{{ __('messages.about_value_6_title') }}</div>
                <div class="value-desc">
                    {{ __('messages.about_value_6_desc') }}
                </div>
            </div>
        </div>
    </section>

    {{-- ═══════════════ CALL TO ACTION ═══════════════ --}}
    <section class="section" style="text-align: center; padding: 5rem 2.5rem 7rem;">
        <h2 class="section-title">{{ __('messages.about_cta_title') }}</h2>
        <p class="section-desc">
            {{ __('messages.about_cta_desc') }}
        </p>
        <a href="{{ route('register') }}" class="btn-primary" style="display: inline-flex; margin-top: 2rem;">
            {{ __('messages.about_cta_button') }}
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
        </a>
    </section>
</div>

</body>
</html>
