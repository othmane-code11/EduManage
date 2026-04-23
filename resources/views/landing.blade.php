<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EduLearn – Upgrade Your Skills. Advance Your Future.</title>
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

        .hero-trust {
            display: flex; align-items: center; gap: .75rem;
            margin-top: 2rem;
        }

        .hero-right {
            width: 100%;
            
            display: flex;
            justify-content: flex-end;
        }

        .hero-right-image {
            display: block;
            width: 100%;
            max-width: 680px;
            height: auto;
            border-radius: 20px;
            box-shadow: 0 24px 64px rgba(0,0,0,.45);
            border: 1px solid var(--border);
        }

        .avatar-stack { display: flex; }
        .avatar-stack img, .avatar-stack .av {
            width: 36px; height: 36px; border-radius: 50%;
            border: 2px solid var(--bg-deep);
            margin-left: -10px; object-fit: cover;
        }
        .avatar-stack .av:first-child { margin-left: 0; }
        .av {
            background: linear-gradient(135deg,#3b82f6,#06b6d4);
            display: inline-flex; align-items: center; justify-content: center;
            font-size: .65rem; font-weight: 700;
        }

        .trust-text { font-size: .82rem; color: var(--text-muted); }
        .trust-text .stars { color: var(--yellow); letter-spacing: .05em; }

        /* ─── DASHBOARD CARD ─── */
        .dashboard-card {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 20px;
            padding: 1.5rem;
            box-shadow: 0 24px 64px rgba(0,0,0,.45), 0 0 0 1px rgba(59,130,246,.08);
            animation: floatCard 5s ease-in-out infinite;
        }

        @keyframes floatCard {
            0%,100% { transform: translateY(0); }
            50%      { transform: translateY(-8px); }
        }

        .card-header {
            display: flex; align-items: center; justify-content: space-between;
            margin-bottom: 1.2rem;
        }

        .card-header-left h3 { font-size: 1rem; font-weight: 600; }
        .card-header-left p  { font-size: .78rem; color: var(--text-muted); margin-top: .15rem; }

        .card-header-right { display: flex; align-items: center; gap: .6rem; }

        .notif-btn {
            position: relative; background: none; border: none; cursor: pointer;
            color: var(--text-muted);
        }
        .notif-btn .badge {
            position: absolute; top: -4px; right: -4px;
            background: var(--accent); color: #fff;
            font-size: .6rem; font-weight: 700;
            width: 14px; height: 14px; border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
        }

        .avatar-btn {
            display: flex; align-items: center; gap: .4rem;
            background: rgba(255,255,255,.06); border: 1px solid var(--border);
            border-radius: 50px; padding: .25rem .55rem .25rem .25rem;
            cursor: pointer;
        }
        .avatar-btn img, .avatar-btn .av-sm {
            width: 28px; height: 28px; border-radius: 50%; object-fit: cover;
        }
        .av-sm {
            background: linear-gradient(135deg,#3b82f6,#a855f7);
            display: inline-flex; align-items: center; justify-content: center;
            font-size: .6rem; font-weight: 700; color: #fff;
        }

        .card-body { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1.2rem; }

        /* Progress ring panel */
        .progress-panel {
            background: var(--bg-card2); border-radius: 14px; padding: 1rem;
        }
        .progress-panel-head {
            display: flex; justify-content: space-between; align-items: center;
            margin-bottom: .85rem;
        }
        .progress-panel-head span { font-size: .8rem; font-weight: 600; }
        .week-select {
            font-size: .72rem; color: var(--text-muted);
            background: rgba(255,255,255,.06); border: 1px solid var(--border);
            border-radius: 6px; padding: .2rem .5rem; cursor: pointer; color: var(--text-muted);
        }

        .progress-inner { display: flex; gap: 1rem; align-items: center; }

        .ring-wrap { position: relative; width: 86px; height: 86px; flex-shrink: 0; }
        .ring-wrap svg { transform: rotate(-90deg); }
        .ring-label {
            position: absolute; inset: 0;
            display: flex; flex-direction: column; align-items: center; justify-content: center;
        }
        .ring-label .pct  { font-family: 'Syne', sans-serif; font-size: 1.15rem; font-weight: 800; }
        .ring-label .sub  { font-size: .6rem; color: var(--text-muted); }

        .progress-stats { display: flex; flex-direction: column; gap: .55rem; }
        .pstat { display: flex; align-items: center; gap: .45rem; font-size: .78rem; }
        .pstat-icon { font-size: .9rem; }
        .pstat-val   { font-weight: 700; }
        .pstat-label { color: var(--text-muted); font-size: .7rem; }

        /* Overall stats panel */
        .stats-panel {
            background: var(--bg-card2); border-radius: 14px; padding: 1rem;
        }
        .stats-panel h4 { font-size: .8rem; font-weight: 600; margin-bottom: .85rem; }

        .stat-row {
            display: flex; align-items: center; gap: .7rem;
            padding: .45rem .6rem; border-radius: 10px;
            margin-bottom: .4rem; background: rgba(255,255,255,.03);
        }
        .stat-icon {
            width: 32px; height: 32px; border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
            font-size: .85rem; flex-shrink: 0;
        }
        .stat-icon.blue   { background: rgba(59,130,246,.18); }
        .stat-icon.purple { background: rgba(168,85,247,.18); }
        .stat-icon.green  { background: rgba(34,197,94,.18); }
        .stat-val   { font-family: 'Syne', sans-serif; font-size: 1rem; font-weight: 700; }
        .stat-desc  { font-size: .68rem; color: var(--text-muted); }

        /* Continue learning */
        .continue-header {
            display: flex; justify-content: space-between; align-items: center;
            margin-bottom: .85rem;
        }
        .continue-header span { font-size: .82rem; font-weight: 600; }
        .view-all { font-size: .75rem; color: var(--accent2); text-decoration: none; }

        .course-scroll { display: flex; gap: .75rem; overflow-x: auto; padding-bottom: .25rem; }
        .course-scroll::-webkit-scrollbar { display: none; }

        .course-item {
            background: var(--bg-card2); border-radius: 12px;
            padding: .85rem; min-width: 140px; flex-shrink: 0;
        }
        .course-badge {
            font-size: .6rem; font-weight: 700; letter-spacing: .04em;
            padding: .2rem .5rem; border-radius: 4px; margin-bottom: .55rem;
            display: inline-block;
        }
        .badge-progress { background: rgba(59,130,246,.25); color: var(--accent2); }
        .badge-new      { background: rgba(168,85,247,.25); color: #c084fc; }

        .course-icon { font-size: 1.3rem; float: right; margin-top: -1.6rem; }

        .course-name {
            font-family: 'Syne', sans-serif; font-size: .85rem;
            font-weight: 700; margin-bottom: .1rem;
        }
        .course-sub  { font-size: .65rem; color: var(--text-muted); }

        .course-progress-label {
            font-size: .68rem; color: var(--text-muted); margin: .5rem 0 .25rem;
        }
        .progress-bar {
            height: 4px; background: rgba(255,255,255,.1); border-radius: 99px; overflow: hidden;
        }
        .progress-fill {
            height: 100%; border-radius: 99px;
            background: linear-gradient(90deg, var(--accent), var(--accent2));
            transition: width .6s ease;
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
            .hero { grid-template-columns: 1fr; padding: 3rem 1.5rem; }
            .dashboard-card { animation: none; }
            .stats-strip-inner { grid-template-columns: 1fr; }
            .strip-item { border-right: none; border-bottom: 1px solid var(--border); }
            nav { padding: 0 1.2rem; }
            .nav-links { display: none; }
        }
    </style>
</head>
<body>

{{-- ═══════════════ NAVBAR ═══════════════ --}}
<nav>
    <a href="{{ route('landing') }}" class="nav-logo">
        <svg viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
            <rect width="32" height="32" rx="8" fill="#3b82f6"/>
            <path d="M7 12l9-5 9 5-9 5-9-5z" fill="#fff" opacity=".9"/>
            <path d="M7 18l9 5 9-5" stroke="#fff" stroke-width="2" stroke-linecap="round" fill="none" opacity=".7"/>
        </svg>
        EduLearn
    </a>

    <ul class="nav-links">
        <li><a href="{{ route('landing') }}" class="active">{{ __('messages.home') }}</a></li>
        <li><a href="{{ route('features') }}">{{ __('messages.features') }}</a></li>
        <li><a href="{{ route('pricing') }}">{{ __('messages.pricing') }}</a></li>
        <li><a href="{{ route('about') }}">{{ __('messages.about') }}</a></li>
        <li><a href="{{ route('blog') }}">{{ __('messages.blog') }}</a></li>
        <li><a href="{{ route('contact') }}">{{ __('messages.contact') }}</a></li>
    </ul>

    <div class="nav-actions">
        @auth
            <a href="{{ route('dashboard') }}" class="btn-ghost">{{ __('messages.dashboard') }}</a>
        @else
            <a href="{{ route('login') }}" class="btn-ghost">{{ __('messages.log_in') }}</a>
            <a href="{{ route('register') }}" class="btn-primary">
                {{ __('messages.get_started') }}
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
            </a>
        @endauth
    </div>
</nav>

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
                <div class="av">AJ</div>
                <div class="av" style="background:linear-gradient(135deg,#a855f7,#ec4899)">SK</div>
                <div class="av" style="background:linear-gradient(135deg,#22c55e,#06b6d4)">ML</div>
                <div class="av" style="background:linear-gradient(135deg,#f97316,#eab308)">RD</div>
            </div>
            <div class="trust-text">
                <div class="stars">★★★★★</div>
                {{ __('messages.trusted_learners') }}
            </div>
        </div>
    </div>

    {{-- Right column – Screenshot preview image --}}
    <div class="hero-right">
        <img
            src="{{ asset('images/Screenshot 2026-04-23 203012.png') }}"
            alt="EduLearn landing page screenshot preview"
            class="hero-right-image"
            loading="eager"
            decoding="async"
            onerror="this.onerror=null;this.src='{{ asset('images/Screenshot 2026-04-23 203012.png') }}';"
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
    // Animate progress bars on page load
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