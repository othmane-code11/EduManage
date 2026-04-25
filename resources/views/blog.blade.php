<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" {{ app()->getLocale() === 'ar' ? 'dir="rtl"' : '' }}>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('messages.blog_meta_title') }}</title>
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

        body.light-mode .nav-logo {
            color: #003d7a;
            font-weight: 800;
        }

        .nav-logo svg {
            width: 32px;
            height: 32px;
            flex-shrink: 0;
        }

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

@include('partials.public-navbar', ['active' => 'blog'])

<div class="main-content">
    {{-- ═══════════════ BLOG HEADER ═══════════════ --}}
    <section class="section">
        <div class="section-header">
            <div class="section-badge">📝 {{ __('messages.blog_badge') }}</div>
            <h1 class="section-title">{{ __('messages.blog_title') }}</h1>
            <p class="section-desc">
                {{ __('messages.blog_description') }}
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
                    <div class="blog-category">{{ __('messages.blog_article_1_category') }}</div>
                    <div class="blog-title">{{ __('messages.blog_article_1_title') }}</div>
                    <div class="blog-excerpt">
                        {{ __('messages.blog_article_1_excerpt') }}
                    </div>
                    <div class="blog-meta">
                        <div class="blog-author">
                            <div class="blog-avatar">AJ</div>
                            <span>{{ __('messages.blog_article_1_author') }}</span>
                        </div>
                        <div class="blog-date">{{ __('messages.blog_article_1_date') }}</div>
                    </div>
                </div>
            </div>

            {{-- Article 2 --}}
            <div class="blog-card">
                <div class="blog-image">🚀</div>
                <div class="blog-content">
                    <div class="blog-category">{{ __('messages.blog_article_2_category') }}</div>
                    <div class="blog-title">{{ __('messages.blog_article_2_title') }}</div>
                    <div class="blog-excerpt">
                        {{ __('messages.blog_article_2_excerpt') }}
                    </div>
                    <div class="blog-meta">
                        <div class="blog-author">
                            <div class="blog-avatar">SK</div>
                            <span>{{ __('messages.blog_article_2_author') }}</span>
                        </div>
                        <div class="blog-date">{{ __('messages.blog_article_2_date') }}</div>
                    </div>
                </div>
            </div>

            {{-- Article 3 --}}
            <div class="blog-card">
                <div class="blog-image">🎯</div>
                <div class="blog-content">
                    <div class="blog-category">{{ __('messages.blog_article_3_category') }}</div>
                    <div class="blog-title">{{ __('messages.blog_article_3_title') }}</div>
                    <div class="blog-excerpt">
                        {{ __('messages.blog_article_3_excerpt') }}
                    </div>
                    <div class="blog-meta">
                        <div class="blog-author">
                            <div class="blog-avatar">ML</div>
                            <span>{{ __('messages.blog_article_3_author') }}</span>
                        </div>
                        <div class="blog-date">{{ __('messages.blog_article_3_date') }}</div>
                    </div>
                </div>
            </div>

            {{-- Article 4 --}}
            <div class="blog-card">
                <div class="blog-image">💡</div>
                <div class="blog-content">
                    <div class="blog-category">{{ __('messages.blog_article_4_category') }}</div>
                    <div class="blog-title">{{ __('messages.blog_article_4_title') }}</div>
                    <div class="blog-excerpt">
                        {{ __('messages.blog_article_4_excerpt') }}
                    </div>
                    <div class="blog-meta">
                        <div class="blog-author">
                            <div class="blog-avatar">RD</div>
                            <span>{{ __('messages.blog_article_4_author') }}</span>
                        </div>
                        <div class="blog-date">{{ __('messages.blog_article_4_date') }}</div>
                    </div>
                </div>
            </div>

            {{-- Article 5 --}}
            <div class="blog-card">
                <div class="blog-image">🏆</div>
                <div class="blog-content">
                    <div class="blog-category">{{ __('messages.blog_article_5_category') }}</div>
                    <div class="blog-title">{{ __('messages.blog_article_5_title') }}</div>
                    <div class="blog-excerpt">
                        {{ __('messages.blog_article_5_excerpt') }}
                    </div>
                    <div class="blog-meta">
                        <div class="blog-author">
                            <div class="blog-avatar">JT</div>
                            <span>{{ __('messages.blog_article_5_author') }}</span>
                        </div>
                        <div class="blog-date">{{ __('messages.blog_article_5_date') }}</div>
                    </div>
                </div>
            </div>

            {{-- Article 6 --}}
            <div class="blog-card">
                <div class="blog-image">🎨</div>
                <div class="blog-content">
                    <div class="blog-category">{{ __('messages.blog_article_6_category') }}</div>
                    <div class="blog-title">{{ __('messages.blog_article_6_title') }}</div>
                    <div class="blog-excerpt">
                        {{ __('messages.blog_article_6_excerpt') }}
                    </div>
                    <div class="blog-meta">
                        <div class="blog-author">
                            <div class="blog-avatar">EP</div>
                            <span>{{ __('messages.blog_article_6_author') }}</span>
                        </div>
                        <div class="blog-date">{{ __('messages.blog_article_6_date') }}</div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

</body>
</html>
