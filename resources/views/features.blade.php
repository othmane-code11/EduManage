<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" {{ app()->getLocale() === 'ar' ? 'dir="rtl"' : '' }}>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('messages.features_meta_title') }}</title>
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

        /* Main content */
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

        /* Features grid */
        .features-grid {
            display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem; margin-top: 3rem;
        }

        .feature-card {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 16px; padding: 2rem;
            transition: transform .3s, border-color .3s;
        }
        .feature-card:hover {
            transform: translateY(-8px);
            border-color: var(--accent);
        }

        .feature-icon {
            width: 56px; height: 56px; border-radius: 12px;
            background: rgba(59,130,246,.15); border: 1px solid var(--border);
            display: flex; align-items: center; justify-content: center;
            font-size: 1.8rem; margin-bottom: 1.2rem;
        }

        .feature-title {
            font-family: 'Syne', sans-serif; font-size: 1.1rem;
            font-weight: 700; margin-bottom: .6rem;
        }

        .feature-desc {
            color: var(--text-muted); font-size: .93rem; line-height: 1.6;
        }

        /* Responsive */
        @media (max-width: 900px) {
            nav { padding: 0 1.2rem; }
            .nav-links { display: none; }
            .section { padding: 3rem 1.5rem; }
            .features-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

@include('partials.public-navbar', ['active' => 'features'])

<div class="main-content">
    {{-- ═══════════════ FEATURES SECTION ═══════════════ --}}
    <section class="section">
        <div class="section-header">
            <div class="section-badge">✨ {{ __('messages.features_badge') }}</div>
            <h1 class="section-title">{{ __('messages.features_title') }}</h1>
            <p class="section-desc">
                {{ __('messages.features_description') }}
            </p>
        </div>

        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon">🎓</div>
                <div class="feature-title">{{ __('messages.feature_1_title') }}</div>
                <div class="feature-desc">
                    {{ __('messages.feature_1_desc') }}
                </div>
            </div>

            <div class="feature-card">
                <div class="feature-icon">🚀</div>
                <div class="feature-title">{{ __('messages.feature_2_title') }}</div>
                <div class="feature-desc">
                    {{ __('messages.feature_2_desc') }}
                </div>
            </div>

            <div class="feature-card">
                <div class="feature-icon">📊</div>
                <div class="feature-title">{{ __('messages.feature_3_title') }}</div>
                <div class="feature-desc">
                    {{ __('messages.feature_3_desc') }}
                </div>
            </div>

            <div class="feature-card">
                <div class="feature-icon">👥</div>
                <div class="feature-title">{{ __('messages.feature_4_title') }}</div>
                <div class="feature-desc">
                    {{ __('messages.feature_4_desc') }}
                </div>
            </div>

            <div class="feature-card">
                <div class="feature-icon">🎯</div>
                <div class="feature-title">{{ __('messages.feature_5_title') }}</div>
                <div class="feature-desc">
                    {{ __('messages.feature_5_desc') }}
                </div>
            </div>

            <div class="feature-card">
                <div class="feature-icon">🏆</div>
                <div class="feature-title">{{ __('messages.feature_6_title') }}</div>
                <div class="feature-desc">
                    {{ __('messages.feature_6_desc') }}
                </div>
            </div>

            <div class="feature-card">
                <div class="feature-icon">📱</div>
                <div class="feature-title">{{ __('messages.feature_7_title') }}</div>
                <div class="feature-desc">
                    {{ __('messages.feature_7_desc') }}
                </div>
            </div>

            <div class="feature-card">
                <div class="feature-icon">🔔</div>
                <div class="feature-title">{{ __('messages.feature_8_title') }}</div>
                <div class="feature-desc">
                    {{ __('messages.feature_8_desc') }}
                </div>
            </div>

            <div class="feature-card">
                <div class="feature-icon">🌐</div>
                <div class="feature-title">{{ __('messages.feature_9_title') }}</div>
                <div class="feature-desc">
                    {{ __('messages.feature_9_desc') }}
                </div>
            </div>
        </div>
    </section>
</div>

</body>
</html>
