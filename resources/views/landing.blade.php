<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" {{ app()->getLocale() === 'ar' ? 'dir="rtl"' : '' }}>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('messages.landing_meta_title') }}</title>
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

        /* ─── Background glow blobs ─── */
        body::before {
            content: '';
            position: fixed; inset: 0; z-index: 0; pointer-events: none;
            background:
                radial-gradient(ellipse 600px 400px at 10% 30%,  rgba(59,130,246,.12) 0%, transparent 70%),
                radial-gradient(ellipse 500px 350px at 90% 60%,  rgba(6,182,212,.10) 0%, transparent 70%),
                radial-gradient(ellipse 400px 300px at 50% 100%, rgba(168,85,247,.08) 0%, transparent 70%);
        }

        /* ─── NAV ─── */
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

        body.light-mode .nav-logo {
            color: #003d7a;
            font-weight: 800;
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

        .btn-ghost {
            background: none; border: none; cursor: pointer;
            color: var(--text-muted); font-family: inherit; font-size: .93rem;
            font-weight: 500; transition: color .2s; padding: .4rem .6rem;
        }
        .btn-ghost:hover { color: var(--text-primary); }

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

        /* ─── HERO SECTION ─── */
        .hero {
            position: relative; z-index: 1;
            display: grid; grid-template-columns: 1fr 1fr;
            gap: 2rem; align-items: center;
            max-width: 1200px; margin: 0 auto;
            padding: 5rem 2.5rem 4rem;
        }

        .hero-badge {
            display: inline-flex; align-items: center; gap: .45rem;
            background: rgba(59,130,246,.12); border: 1px solid var(--border);
            border-radius: 50px; padding: .35rem .9rem;
            font-size: .8rem; font-weight: 500; color: var(--accent2);
            margin-bottom: 1.5rem;
        }

        .hero-title {
            font-family: 'Syne', sans-serif;
            font-size: clamp(2.4rem, 4.5vw, 3.4rem);
            font-weight: 800; line-height: 1.12;
            margin-bottom: 1.2rem;
        }

        .hero-title .highlight { color: var(--accent2); }

        .hero-desc {
            color: var(--text-muted); font-size: 1rem; line-height: 1.7;
            max-width: 420px; margin-bottom: 2rem;
        }

        .hero-cta { display: flex; gap: 1rem; align-items: center; flex-wrap: wrap; }

        .btn-secondary {
            display: inline-flex; align-items: center; gap: .5rem;
            background: rgba(255,255,255,.06); border: 1px solid var(--border);
            color: var(--text-primary); border-radius: 8px; cursor: pointer;
            font-family: inherit; font-size: .93rem; font-weight: 500;
            padding: .6rem 1.3rem; transition: background .2s;
            text-decoration: none;
        }
        .btn-secondary:hover { background: rgba(255,255,255,.1); }

        /* ─── HERO TRUST ─── */
        .hero-trust {
            display: flex;
            align-items: center;
            gap: .75rem;
            margin-top: 2rem;
        }

        /* Avatar stack — each item is a clipped circle showing the real photo */
        .avatar-stack {
            display: flex;
            align-items: center;
        }

        .avatar-stack-item {
            position: relative;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            border: 2px solid var(--bg-deep);
            overflow: hidden;
            margin-left: -10px;
            flex-shrink: 0;
            background: var(--bg-card2); /* fallback while image loads */
            transition: transform .2s, z-index 0s;
        }

        .avatar-stack-item:first-child {
            margin-left: 0;
        }

        .avatar-stack-item:hover {
            transform: translateY(-3px) scale(1.08);
            z-index: 10;
        }

        .avatar-stack-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center top; /* faces are usually in the upper half */
            display: block;
        }

        .trust-text { font-size: .82rem; color: var(--text-muted); }
        .trust-text .stars { color: var(--yellow); letter-spacing: .05em; }

        /* ─── HERO RIGHT — screenshot ─── */
        .hero-right {
            position: relative;
            width: 100%;
            display: flex;
            justify-content: flex-end;
        }

        /*
         * Subtle glow halo behind the image so it feels embedded
         * in the page rather than pasted on top of it.
         */
        .hero-right::before {
            content: '';
            position: absolute;
            inset: -40px;
            background: radial-gradient(
                ellipse 80% 60% at 60% 50%,
                rgba(59,130,246,.18) 0%,
                transparent 70%
            );
            pointer-events: none;
            z-index: 0;
        }

        .hero-right-image {
            position: relative;
            z-index: 1;
            display: block;
            width: 100%;
            max-width: 680px;
            height: auto;
            border-radius: 20px;
            box-shadow:
                0 0 0 1px rgba(59,130,246,.18),
                0 24px 64px rgba(0,0,0,.55),
                0 8px 24px rgba(59,130,246,.12);
            /* Gentle perpetual float — paused on hover so users can inspect */
            animation: floatHero 6s ease-in-out infinite;
        }

        .hero-right-image:hover {
            animation-play-state: paused;
        }

        @keyframes floatHero {
            0%, 100% { transform: translateY(0px); }
            50%       { transform: translateY(-10px); }
        }

        /* ─── STATS STRIP ─── */
        .stats-strip {
            position: relative; z-index: 1;
            background: var(--bg-card);
            border-top: 1px solid var(--border);
            border-bottom: 1px solid var(--border);
        }
        .stats-strip-inner {
            max-width: 1200px; margin: 0 auto;
            display: grid; grid-template-columns: repeat(3, 1fr);
            gap: 0;
        }
        .strip-item {
            display: flex; align-items: center; gap: 1.2rem;
            padding: 2.2rem 2.5rem;
            border-right: 1px solid var(--border);
        }
        .strip-item:last-child { border-right: none; }
        .strip-icon {
            width: 56px; height: 56px; border-radius: 50%;
            background: rgba(59,130,246,.12); border: 1px solid var(--border);
            display: flex; align-items: center; justify-content: center;
            font-size: 1.4rem; flex-shrink: 0;
        }
        .strip-val {
            font-family: 'Syne', sans-serif; font-size: 1.9rem;
            font-weight: 800; line-height: 1;
        }
        .strip-label { font-weight: 600; font-size: .88rem; margin-top: .2rem; }
        .strip-desc  { font-size: .78rem; color: var(--text-muted); }

        /* ─── RESPONSIVE ─── */
        @media (max-width: 900px) {
            .hero {
                grid-template-columns: 1fr;
                padding: 3rem 1.5rem;
            }
            /* Stack: image goes above the text on mobile */
            .hero-right {
                order: -1;
                justify-content: center;
            }
            .hero-right-image {
                max-width: 100%;
                animation: none;
            }
            .stats-strip-inner { grid-template-columns: 1fr; }
            .strip-item { border-right: none; border-bottom: 1px solid var(--border); }
            nav { padding: 0 1.2rem; }
            .nav-links { display: none; }
        }
    </style>
</head>
<body>

@include('partials.public-navbar', ['active' => 'landing'])

{{-- ═══════════════ HERO ═══════════════ --}}
<section class="hero">

    {{-- Left column --}}
    <div class="hero-left">
        <div class="hero-badge">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/></svg>
            {{ __('messages.learn_smarter') }}
        </div>

        <h1 class="hero-title">
            {{ __('messages.upgrade_skills') }}<br>
            {{ __('messages.advance_future') }} <span class="highlight"></span>
        </h1>

        <p class="hero-desc">
            {{ __('messages.edulearn_description') }}
        </p>

        <div class="hero-cta">
            <a href="{{ route('register') }}" class="btn-primary">
                {{ __('messages.start_learning') }}
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
            </a>
            <a href="#" class="btn-secondary">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M5 3l14 9-14 9V3z"/></svg>
                {{ __('messages.watch_demo') }}
            </a>
        </div>

        <div class="hero-trust">
            <div class="avatar-stack">
                <div class="avatar-stack-item">
                    <img
                        src="{{ asset('images/homme-souriant-bras-croises_1187-2903.avif') }}"
                        alt="Learner"
                        loading="eager"
                        decoding="async"
                    >
                </div>
                <div class="avatar-stack-item">
                    <img
                        src="{{ asset('images/portrait-jeune-homme-souriant-se-frottant-mains_171337-10297.avif') }}"
                        alt="Learner"
                        loading="eager"
                        decoding="async"
                    >
                </div>
                <div class="avatar-stack-item">
                    <img
                        src="{{ asset('images/jeune-belle-femme-pull-chaud-rose-aspect-naturel-souriant-portrait-isole-cheveux-longs_285396-896.avif') }}"
                        alt="Learner"
                        loading="eager"
                        decoding="async"
                    >
                </div>
                <div class="avatar-stack-item">
                    <img
                        src="{{ asset('images/jeune-etudiante-armenienne-determinee-aux-cheveux-boucles-ecoutez-attentivement-assignation-regardez-confiant-pret-faire-tache-croisez-mains-poitrine-souriant-confiant-debout-fond-blanc_176420-56066.avif') }}"
                        alt="Learner"
                        loading="eager"
                        decoding="async"
                    >
                </div>
            </div>
            <div class="trust-text">
                <div class="stars">★★★★★</div>
                {{ __('messages.trusted_learners') }}
            </div>
        </div>
    </div>

    {{-- Right column — app screenshot --}}
    <div class="hero-right">
        <img
            src="{{ asset('images/unnamed (1).png') }}"
            alt="{{ __('messages.landing_preview_alt') }}"
            class="hero-right-image"
            loading="eager"
            decoding="async"
        >
    </div>

</section>

{{-- ═══════════════ STATS STRIP ═══════════════ --}}
<div class="stats-strip">
    <div class="stats-strip-inner">

        <div class="strip-item">
            <div class="strip-icon">👥</div>
            <div>
                <div class="strip-val">50,000+</div>
                <div class="strip-label">{{ __('messages.active_students') }}</div>
                <div class="strip-desc">{{ __('messages.growing_community') }}</div>
            </div>
        </div>

        <div class="strip-item">
            <div class="strip-icon">📚</div>
            <div>
                <div class="strip-val">1,200+</div>
                <div class="strip-label">{{ __('messages.expert_courses') }}</div>
                <div class="strip-desc">{{ __('messages.high_quality_courses') }}</div>
            </div>
        </div>

        <div class="strip-item">
            <div class="strip-icon">📈</div>
            <div>
                <div class="strip-val">92%</div>
                <div class="strip-label">{{ __('messages.completion_rate') }}</div>
                <div class="strip-desc">{{ __('messages.achieve_goals') }}</div>
            </div>
        </div>

    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('.progress-fill').forEach(el => {
            const target = el.style.width;
            el.style.width = '0%';
            setTimeout(() => { el.style.width = target; }, 300);
        });
    });
</script>
@endpush

</body>
</html>