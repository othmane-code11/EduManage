<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pricing – EduLearn</title>
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

        .btn-secondary {
            display: inline-flex; align-items: center; gap: .5rem;
            background: rgba(255,255,255,.06); border: 1px solid var(--border);
            color: var(--text-primary); border-radius: 8px; cursor: pointer;
            font-family: inherit; font-size: .93rem; font-weight: 500;
            padding: .6rem 1.3rem; transition: background .2s;
            text-decoration: none;
        }
        .btn-secondary:hover { background: rgba(255,255,255,.1); }

        .main-content {
            position: relative; z-index: 1;
        }

        .section {
            max-width: 1200px; margin: 0 auto;
            padding: 5rem 2.5rem;
        }

        .section-header {
            text-align: center;
            margin-bottom: 4rem;
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

        /* Pricing grid */
        .pricing-grid {
            display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 2rem; margin-top: 3rem;
        }

        .pricing-card {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 16px; padding: 2.5rem;
            transition: transform .3s, border-color .3s, box-shadow .3s;
            position: relative;
        }
        .pricing-card:hover {
            transform: translateY(-12px);
            border-color: var(--accent);
            box-shadow: 0 20px 60px rgba(59,130,246,.2);
        }

        .pricing-card.featured {
            border: 2px solid var(--accent);
            background: rgba(59,130,246,.05);
            transform: scale(1.05);
        }
        .pricing-card.featured:hover {
            transform: translateY(-12px) scale(1.05);
        }

        .pricing-badge {
            display: inline-block;
            background: var(--accent);
            color: #fff;
            font-size: .7rem;
            font-weight: 700;
            padding: .3rem .7rem;
            border-radius: 4px;
            margin-bottom: 1rem;
        }

        .pricing-name {
            font-family: 'Syne', sans-serif;
            font-size: 1.3rem; font-weight: 700;
            margin-bottom: .5rem;
        }

        .pricing-desc {
            color: var(--text-muted);
            font-size: .85rem;
            margin-bottom: 1.5rem;
            line-height: 1.5;
        }

        .pricing-price {
            font-family: 'Syne', sans-serif;
            font-size: 2.5rem; font-weight: 800;
            margin-bottom: .3rem;
        }

        .pricing-period {
            color: var(--text-muted);
            font-size: .9rem;
            margin-bottom: 2rem;
        }

        .pricing-features {
            list-style: none;
            margin-bottom: 2rem;
        }

        .pricing-features li {
            display: flex;
            align-items: center;
            gap: .6rem;
            padding: .5rem 0;
            color: var(--text-muted);
            font-size: .9rem;
        }

        .pricing-features li::before {
            content: '✓';
            color: var(--green);
            font-weight: 700;
            font-size: 1.1rem;
        }

        .pricing-features li.disabled {
            color: rgba(140, 163, 200, .5);
            text-decoration: line-through;
        }

        .pricing-features li.disabled::before {
            content: '✗';
            color: rgba(140, 163, 200, .5);
        }

        .pricing-cta {
            width: 100%;
        }

        /* Responsive */
        @media (max-width: 900px) {
            nav { padding: 0 1.2rem; }
            .nav-links { display: none; }
            .section { padding: 3rem 1.5rem; }
            .pricing-grid { grid-template-columns: 1fr; }
            .pricing-card.featured { transform: scale(1); }
            .pricing-card.featured:hover { transform: translateY(-12px); }
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
        <li><a href="{{ route('landing') }}">Home</a></li>
        <li><a href="{{ route('features') }}">Features</a></li>
        <li><a href="{{ route('pricing') }}" class="active">Pricing</a></li>
        <li><a href="{{ route('about') }}">About</a></li>
        <li><a href="{{ route('blog') }}">Blog</a></li>
        <li><a href="{{ route('contact') }}">Contact</a></li>
    </ul>

    <div class="nav-actions">
        @auth
            <a href="{{ route('dashboard') }}" class="btn-ghost">Dashboard</a>
        @else
            <a href="{{ route('login') }}" class="btn-ghost">Log in</a>
            <a href="{{ route('register') }}" class="btn-primary">Get Started</a>
        @endauth
    </div>
</nav>

<div class="main-content">
    {{-- ═══════════════ PRICING SECTION ═══════════════ --}}
    <section class="section">
        <div class="section-header">
            <div class="section-badge">💰 Flexible Plans</div>
            <h1 class="section-title">Simple, Transparent Pricing</h1>
            <p class="section-desc">
                Choose the plan that fits your learning goals. Upgrade or downgrade anytime.
            </p>
        </div>

        <div class="pricing-grid">
            {{-- Starter Plan --}}
            <div class="pricing-card">
                <div class="pricing-name">Starter</div>
                <p class="pricing-desc">Perfect for exploring new skills</p>
                <div class="pricing-price">$0</div>
                <div class="pricing-period">Free forever</div>
                <a href="{{ route('register') }}" class="btn-secondary pricing-cta">Get Started</a>
                <ul class="pricing-features">
                    <li>Access to 50+ courses</li>
                    <li>Basic progress tracking</li>
                    <li>Community support</li>
                    <li class="disabled">Advanced analytics</li>
                    <li class="disabled">Certificates</li>
                    <li class="disabled">Priority support</li>
                </ul>
            </div>

            {{-- Pro Plan (Featured) --}}
            <div class="pricing-card featured">
                <div class="pricing-badge">MOST POPULAR</div>
                <div class="pricing-name">Pro</div>
                <p class="pricing-desc">For serious learners</p>
                <div class="pricing-price">$9.99</div>
                <div class="pricing-period">per month</div>
                <a href="{{ route('register') }}" class="btn-primary pricing-cta">Start Free Trial</a>
                <ul class="pricing-features">
                    <li>Access to 500+ courses</li>
                    <li>Advanced analytics</li>
                    <li>Personalized learning paths</li>
                    <li>Certificates of completion</li>
                    <li>Priority support</li>
                    <li class="disabled">Custom mentoring</li>
                </ul>
            </div>

            {{-- Business Plan --}}
            <div class="pricing-card">
                <div class="pricing-name">Business</div>
                <p class="pricing-desc">For teams and organizations</p>
                <div class="pricing-price">$29.99</div>
                <div class="pricing-period">per month</div>
                <a href="#" class="btn-secondary pricing-cta">Contact Sales</a>
                <ul class="pricing-features">
                    <li>Unlimited courses</li>
                    <li>Advanced analytics</li>
                    <li>Team management</li>
                    <li>Certificates & badges</li>
                    <li>24/7 priority support</li>
                    <li>Custom mentoring</li>
                </ul>
            </div>
        </div>
    </section>
</div>

</body>
</html>
