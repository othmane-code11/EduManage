<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog – EduLearn</title>
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

        /* Blog grid */
        .blog-grid {
            display: grid; grid-template-columns: repeat(auto-fill, minmax(340px, 1fr));
            gap: 2.5rem; margin-top: 3rem;
        }

        .blog-card {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 16px; overflow: hidden;
            transition: transform .3s, border-color .3s, box-shadow .3s;
        }
        .blog-card:hover {
            transform: translateY(-8px);
            border-color: var(--accent);
            box-shadow: 0 20px 60px rgba(59,130,246,.15);
        }

        .blog-image {
            width: 100%; height: 200px;
            background: linear-gradient(135deg, rgba(59,130,246,.2), rgba(6,182,212,.1));
            display: flex; align-items: center; justify-content: center;
            font-size: 3rem;
            border-bottom: 1px solid var(--border);
        }

        .blog-content {
            padding: 2rem;
        }

        .blog-category {
            display: inline-block;
            background: rgba(59,130,246,.15);
            color: var(--accent2);
            font-size: .75rem;
            font-weight: 600;
            padding: .3rem .7rem;
            border-radius: 4px;
            margin-bottom: .8rem;
        }

        .blog-title {
            font-family: 'Syne', sans-serif;
            font-size: 1.2rem; font-weight: 700;
            margin-bottom: .8rem;
            line-height: 1.4;
        }

        .blog-excerpt {
            color: var(--text-muted);
            font-size: .9rem;
            line-height: 1.6;
            margin-bottom: 1.5rem;
        }

        .blog-meta {
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: .8rem;
            color: var(--text-muted);
            padding-top: 1rem;
            border-top: 1px solid rgba(59,130,246,.1);
        }

        .blog-author {
            display: flex;
            align-items: center;
            gap: .5rem;
        }

        .blog-avatar {
            width: 24px;
            height: 24px;
            border-radius: 50%;
            background: linear-gradient(135deg, #3b82f6, #06b6d4);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: .65rem;
            font-weight: 700;
        }

        .blog-date {
            color: var(--text-muted);
        }

        /* Responsive */
        @media (max-width: 900px) {
            nav { padding: 0 1.2rem; }
            .nav-links { display: none; }
            .section { padding: 3rem 1.5rem; }
            .blog-grid { grid-template-columns: 1fr; }
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
        <li><a href="{{ route('pricing') }}">Pricing</a></li>
        <li><a href="{{ route('about') }}">About</a></li>
        <li><a href="{{ route('blog') }}" class="active">Blog</a></li>
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
    {{-- ═══════════════ BLOG HEADER ═══════════════ --}}
    <section class="section">
        <div class="section-header">
            <div class="section-badge">📝 Insights & Updates</div>
            <h1 class="section-title">EduLearn Blog</h1>
            <p class="section-desc">
                Stay updated with the latest trends in online education and learning tips from our experts
            </p>
        </div>
    </section>

    {{-- ═══════════════ BLOG ARTICLES ═══════════════ --}}
    <section class="section">
        <div class="blog-grid">
            {{-- Article 1 --}}
            <div class="blog-card">
                <div class="blog-image">📚</div>
                <div class="blog-content">
                    <div class="blog-category">Learning Tips</div>
                    <div class="blog-title">10 Ways to Maximize Your Online Learning</div>
                    <div class="blog-excerpt">
                        Discover proven strategies to get the most out of your online courses and improve your learning outcomes.
                    </div>
                    <div class="blog-meta">
                        <div class="blog-author">
                            <div class="blog-avatar">AJ</div>
                            <span>Alex Johnson</span>
                        </div>
                        <div class="blog-date">Apr 18, 2024</div>
                    </div>
                </div>
            </div>

            {{-- Article 2 --}}
            <div class="blog-card">
                <div class="blog-image">🚀</div>
                <div class="blog-content">
                    <div class="blog-category">Career Growth</div>
                    <div class="blog-title">Tech Skills That Will Transform Your Career in 2024</div>
                    <div class="blog-excerpt">
                        Explore the most in-demand technical skills employers are looking for and how to develop them.
                    </div>
                    <div class="blog-meta">
                        <div class="blog-author">
                            <div class="blog-avatar">SK</div>
                            <span>Sarah Kim</span>
                        </div>
                        <div class="blog-date">Apr 15, 2024</div>
                    </div>
                </div>
            </div>

            {{-- Article 3 --}}
            <div class="blog-card">
                <div class="blog-image">🎯</div>
                <div class="blog-content">
                    <div class="blog-category">Success Stories</div>
                    <div class="blog-title">From Bootcamp to Senior Developer: Success Stories</div>
                    <div class="blog-excerpt">
                        Read inspiring stories from learners who transformed their careers through online education.
                    </div>
                    <div class="blog-meta">
                        <div class="blog-author">
                            <div class="blog-avatar">ML</div>
                            <span>Mike Lewis</span>
                        </div>
                        <div class="blog-date">Apr 12, 2024</div>
                    </div>
                </div>
            </div>

            {{-- Article 4 --}}
            <div class="blog-card">
                <div class="blog-image">💡</div>
                <div class="blog-content">
                    <div class="blog-category">Industry News</div>
                    <div class="blog-title">The Future of Online Education: Trends to Watch</div>
                    <div class="blog-excerpt">
                        Explore the emerging trends shaping the future of online learning and what they mean for students.
                    </div>
                    <div class="blog-meta">
                        <div class="blog-author">
                            <div class="blog-avatar">RD</div>
                            <span>Rachel Davis</span>
                        </div>
                        <div class="blog-date">Apr 10, 2024</div>
                    </div>
                </div>
            </div>

            {{-- Article 5 --}}
            <div class="blog-card">
                <div class="blog-image">🏆</div>
                <div class="blog-content">
                    <div class="blog-category">Certification</div>
                    <div class="blog-title">Why Certifications Matter: Boost Your Resume</div>
                    <div class="blog-excerpt">
                        Learn how professional certifications can significantly impact your job prospects and earning potential.
                    </div>
                    <div class="blog-meta">
                        <div class="blog-author">
                            <div class="blog-avatar">JT</div>
                            <span>James Taylor</span>
                        </div>
                        <div class="blog-date">Apr 8, 2024</div>
                    </div>
                </div>
            </div>

            {{-- Article 6 --}}
            <div class="blog-card">
                <div class="blog-image">🎨</div>
                <div class="blog-content">
                    <div class="blog-category">Creative Skills</div>
                    <div class="blog-title">Mastering UI/UX Design: A Complete Guide</div>
                    <div class="blog-excerpt">
                        Comprehensive guide to becoming a proficient UI/UX designer and creating engaging digital experiences.
                    </div>
                    <div class="blog-meta">
                        <div class="blog-author">
                            <div class="blog-avatar">EP</div>
                            <span>Emma Parker</span>
                        </div>
                        <div class="blog-date">Apr 5, 2024</div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

</body>
</html>
