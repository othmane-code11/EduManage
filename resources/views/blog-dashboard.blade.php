@extends('layouts.app')

@section('title', __('navigation.blog'))
@section('page-title', __('navigation.blog'))

@push('styles')
<style>
    /* ─── Design Tokens ─────────────────────────────────────────────── */
    :root {
        --blog-radius-card:   20px;
        --blog-radius-tag:    999px;
        --blog-radius-input:  14px;
        --blog-cover-height:  220px;
        --blog-sky-primary:   56, 189, 248;
        --blog-sky-secondary: 59, 130, 246;
        --blog-accent-text:   #7dd3fc;
        --blog-transition:    300ms cubic-bezier(0.4, 0, 0.2, 1);
        --blog-max-width:     1280px;
        --blog-gap:           1.5rem;
    }

    /* ─── Shell ─────────────────────────────────────────────────────── */
    .blog-shell {
        max-width: var(--blog-max-width);
        margin: 0 auto;
        padding: 0 1rem;
    }

    /* ─── Hero ───────────────────────────────────────────────────────── */
    .blog-hero {
        padding: 2rem 2rem;
        background:
            radial-gradient(circle at 15% 20%, rgba(var(--blog-sky-primary),  0.25), transparent 50%),
            radial-gradient(circle at 80% 15%, rgba(var(--blog-sky-secondary), 0.28), transparent 45%),
            linear-gradient(135deg, rgba(4, 44, 83, 0.95), rgba(1, 34, 68, 0.95));
        border: 1px solid rgba(var(--blog-sky-primary), 0.2);
        border-radius: var(--blog-radius-card);
        margin-bottom: 2rem;
        position: relative;
        overflow: hidden;
    }

    .blog-hero::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(var(--blog-sky-primary), 0.1) 0%, transparent 70%);
        animation: rotate 20s linear infinite;
    }

    @keyframes rotate {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }

    .blog-hero > * {
        position: relative;
        z-index: 1;
    }

    .blog-hero__title {
        font-family: 'Syne', sans-serif;
        font-size: clamp(1.8rem, 4vw, 2.5rem);
        font-weight: 800;
        letter-spacing: -0.02em;
        margin-bottom: 0.75rem;
        background: linear-gradient(135deg, #fff 0%, var(--blog-accent-text) 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .blog-hero__desc {
        color: rgba(255, 255, 255, 0.8);
        max-width: 720px;
        line-height: 1.6;
        font-size: 1rem;
        margin: 0;
    }

    /* ─── Toolbar ────────────────────────────────────────────────────── */
    .blog-toolbar {
        display: flex;
        gap: 1rem;
        margin-bottom: 2rem;
        flex-wrap: wrap;
        align-items: center;
    }

    .blog-toolbar__search-wrapper {
        flex: 1;
        min-width: 200px;
        position: relative;
    }

    .blog-toolbar__search {
        width: 100%;
        border: 2px solid var(--border);
        border-radius: var(--blog-radius-input);
        background: var(--surface);
        color: var(--white);
        padding: 0.85rem 1rem 0.85rem 2.75rem;
        font-family: inherit;
        font-size: 0.95rem;
        outline: none;
        transition: all var(--blog-transition);
    }

    .blog-toolbar__search::placeholder {
        color: var(--muted);
        font-size: 0.9rem;
    }

    .blog-toolbar__search:focus {
        border-color: rgba(var(--blog-sky-primary), 0.8);
        box-shadow: 0 0 0 4px rgba(var(--blog-sky-primary), 0.1);
    }

    .search-icon {
        position: absolute;
        left: 1rem;
        top: 50%;
        transform: translateY(-50%);
        color: var(--muted);
        pointer-events: none;
        font-size: 1.1rem;
    }

    .blog-toolbar__filter {
        border: 2px solid var(--border);
        border-radius: var(--blog-radius-input);
        background: var(--surface);
        color: var(--white);
        padding: 0.85rem 2rem 0.85rem 1rem;
        font-family: inherit;
        font-size: 0.95rem;
        outline: none;
        cursor: pointer;
        transition: all var(--blog-transition);
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%23ffffff' d='M6 8L1 3h10z'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 1rem center;
    }

    .blog-toolbar__filter:focus {
        border-color: rgba(var(--blog-sky-primary), 0.8);
        box-shadow: 0 0 0 4px rgba(var(--blog-sky-primary), 0.1);
    }

    /* ─── Grid ───────────────────────────────────────────────────────── */
    .blog-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: var(--blog-gap);
        margin-bottom: 2rem;
    }

    /* ─── Card ───────────────────────────────────────────────────────── */
    .blog-post {
        overflow: hidden;
        text-decoration: none;
        color: inherit;
        display: flex;
        flex-direction: column;
        transition: all var(--blog-transition);
        position: relative;
    }

    .blog-post:hover {
        transform: translateY(-6px);
        box-shadow: 0 12px 32px rgba(0, 0, 0, 0.3);
    }

    .blog-post:focus-visible {
        outline: none;
        transform: translateY(-6px);
        box-shadow: 0 12px 32px rgba(0, 0, 0, 0.3), 0 0 0 3px rgba(var(--blog-sky-primary), 0.5);
    }

    /* Cover */
    .blog-post__cover {
        height: var(--blog-cover-height);
        flex-shrink: 0;
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        transition: transform var(--blog-transition);
        position: relative;
        overflow: hidden;
    }

    .blog-post:hover .blog-post__cover {
        transform: scale(1.05);
    }

    .blog-post__cover::after {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(to bottom, transparent 0%, rgba(0,0,0,0.3) 100%);
    }

    /* Body */
    .blog-post__body {
        padding: 1.25rem;
        display: flex;
        flex-direction: column;
        flex: 1;
        background: var(--surface);
    }

    /* Tag */
    .blog-post__tag {
        display: inline-flex;
        align-self: flex-start;
        font-size: 0.7rem;
        font-weight: 700;
        padding: 0.3rem 0.7rem;
        border-radius: var(--blog-radius-tag);
        border: 1px solid rgba(var(--blog-sky-primary), 0.4);
        background: rgba(var(--blog-sky-primary), 0.15);
        color: var(--blog-accent-text);
        margin-bottom: 0.85rem;
        letter-spacing: 0.5px;
        text-transform: uppercase;
        backdrop-filter: blur(4px);
    }

    /* Title */
    .blog-post__title {
        font-family: 'Syne', sans-serif;
        font-size: 1.15rem;
        font-weight: 700;
        line-height: 1.4;
        margin-bottom: 0.65rem;
        transition: color var(--blog-transition);
    }

    .blog-post:hover .blog-post__title {
        color: var(--blog-accent-text);
    }

    /* Excerpt */
    .blog-post__excerpt {
        color: var(--muted);
        font-size: 0.9rem;
        line-height: 1.6;
        margin-bottom: 1rem;
        flex: 1;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    /* Meta */
    .blog-post__meta {
        display: flex;
        justify-content: space-between;
        align-items: center;
        color: var(--muted);
        font-size: 0.75rem;
        border-top: 1px solid var(--border);
        padding-top: 0.85rem;
        margin-top: auto;
    }

    /* ─── Metrics / Top KPIs ───────────────────────────────────────── */
    .blog-metrics {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1rem;
        margin-bottom: 2rem;
    }

    .metric-card {
        padding: 1.25rem;
        border-radius: 16px;
        border: 1px solid var(--border);
        background: linear-gradient(135deg, rgba(255,255,255,0.03) 0%, rgba(255,255,255,0.01) 100%);
        transition: all var(--blog-transition);
        position: relative;
        overflow: hidden;
    }

    .metric-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 2px;
        background: linear-gradient(90deg, rgba(var(--blog-sky-primary), 0.8), rgba(var(--blog-sky-secondary), 0.8));
        transform: scaleX(0);
        transition: transform var(--blog-transition);
    }

    .metric-card:hover::before {
        transform: scaleX(1);
    }

    .metric-card:hover {
        transform: translateY(-2px);
        border-color: rgba(var(--blog-sky-primary), 0.3);
    }

    .metric-label {
        font-size: 0.7rem;
        color: var(--muted);
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 0.5rem;
    }

    .metric-value {
        font-family: 'Syne', sans-serif;
        font-size: 1.75rem;
        font-weight: 800;
        color: var(--white);
        line-height: 1;
    }

    /* ─── Empty state ──────────────────────────────────────────────────── */
    .blog-empty {
        grid-column: 1 / -1;
        text-align: center;
        padding: 4rem 2rem;
    }

    .blog-empty p {
        font-size: 1.1rem;
        color: var(--muted);
        margin-bottom: 1.5rem;
    }

    /* ─── Light-mode overrides ───────────────────────────────────────── */
    body.light-mode .blog-toolbar__search,
    body.light-mode .blog-toolbar__filter {
        color: #1e293b;
        background: #ffffff;
        border-color: #e2e8f0;
    }

    body.light-mode .blog-post__body {
        background: #ffffff;
    }

    body.light-mode .metric-value {
        color: #1e293b;
    }

    body.light-mode .blog-hero {
        background: linear-gradient(135deg, #e0f2fe 0%, #bae6fd 100%);
    }

    body.light-mode .blog-hero__title {
        background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    /* ─── Animations ──────────────────────────────────────────────────── */
    @keyframes slideInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .anim {
        animation: slideInUp 0.5s ease-out forwards;
    }

    .anim-d1 {
        animation-delay: 0.1s;
        opacity: 0;
        animation-fill-mode: forwards;
    }

    /* ─── Reduced motion ─────────────────────────────────────────────── */
    @media (prefers-reduced-motion: reduce) {
        *,
        *::before,
        *::after {
            animation-duration: 0.01ms !important;
            animation-iteration-count: 1 !important;
            transition-duration: 0.01ms !important;
        }
    }

    /* ─── Responsive ─────────────────────────────────────────────────── */
    @media (max-width: 768px) {
        .blog-toolbar {
            flex-direction: column;
            align-items: stretch;
        }
        
        .blog-toolbar__filter {
            width: 100%;
        }
        
        .blog-metrics {
            grid-template-columns: repeat(2, 1fr);
            gap: 0.75rem;
        }
        
        .blog-grid {
            gap: 1rem;
        }
        
        .metric-card {
            padding: 1rem;
        }
        
        .metric-value {
            font-size: 1.5rem;
        }
        
        .blog-hero {
            padding: 1.5rem;
        }
    }

    @media (max-width: 480px) {
        .blog-metrics {
            grid-template-columns: 1fr;
        }
        
        .blog-grid {
            grid-template-columns: 1fr;
        }
    }

    /* ─── Create Post Button (enhanced) ────────────────────────────────── */
    .btn-create-post {
        --grad-start: #3b82c4;
        --grad-end: #1e4f8f;
        --grad-hover-start: #60a5fa;
        --grad-hover-end: #2563eb;

        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.6rem;
        padding: 0.85rem 1.5rem;
        border-radius: 40px;
        border: none;
        cursor: pointer;
        color: white;
        font-weight: 700;
        font-size: 0.95rem;
        background-image: linear-gradient(135deg, var(--grad-start), var(--grad-end));
        transition: all 300ms cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
    }

    .btn-create-post::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 0;
        height: 0;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.3);
        transform: translate(-50%, -50%);
        transition: width 0.6s, height 0.6s;
    }

    .btn-create-post:hover::before {
        width: 300px;
        height: 300px;
    }

    .btn-create-post:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(37, 99, 235, 0.3);
        background-image: linear-gradient(135deg, var(--grad-hover-start), var(--grad-hover-end));
    }

    .btn-create-post:active {
        transform: translateY(1px);
    }

    /* Small variant */
    .btn-create-post.btn-sm {
        padding: 0.6rem 1.2rem;
        font-size: 0.85rem;
    }

    /* ─── Coming Soon Modal (enhanced) ───────────────────────────────────── */
    .cs-backdrop {
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, 0.8);
        backdrop-filter: blur(8px);
        display: none;
        align-items: center;
        justify-content: center;
        z-index: 1200;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .cs-backdrop.show {
        display: flex;
        opacity: 1;
    }

    .cs-modal {
        max-width: 500px;
        width: 90%;
        border-radius: 24px;
        padding: 2rem;
        background: linear-gradient(135deg, #0a2a44 0%, #051a30 100%);
        border: 1px solid rgba(255, 255, 255, 0.1);
        box-shadow: 0 25px 50px rgba(0, 0, 0, 0.5);
        transform: scale(0.9);
        opacity: 0;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .cs-modal.show {
        transform: scale(1);
        opacity: 1;
    }

    .cs-title {
        font-family: 'Syne', sans-serif;
        font-size: 1.5rem;
        font-weight: 800;
        margin: 0 0 0.5rem;
        background: linear-gradient(135deg, #fff, var(--blog-accent-text));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .cs-desc {
        color: rgba(255, 255, 255, 0.7);
        margin: 0 0 1.5rem;
        line-height: 1.6;
    }

    .cs-actions {
        display: flex;
        gap: 1rem;
        justify-content: flex-end;
    }

    /* Loading skeleton animation */
    @keyframes shimmer {
        0% { background-position: -1000px 0; }
        100% { background-position: 1000px 0; }
    }

    .skeleton {
        background: linear-gradient(90deg, var(--border) 25%, rgba(255,255,255,0.1) 50%, var(--border) 75%);
        background-size: 1000px 100%;
        animation: shimmer 1.5s infinite;
    }
</style>
@endpush

@section('content')
<div class="blog-shell">

    @php
        $t = static fn (string $key, string $fallback): string => __($key) === $key ? $fallback : __($key);
    @endphp

    {{-- Hero --}}
    <header class="blog-hero card anim" role="banner">
        <span class="pill pill-blue">{{ __('navigation.blog') }}</span>
        <h1 class="blog-hero__title">{{ __('navigation.blog') }} Hub</h1>
        <p class="blog-hero__desc">
            Catch up with platform updates, learning tips, and campus stories — all in the same dashboard experience.
        </p>
    </header>

    {{-- Metrics --}}
    <section class="blog-metrics anim">
        <div class="metric-card">
            <div class="metric-label">📄 Articles</div>
            <div class="metric-value">{{ $metrics['posts'] ?? 0 }}</div>
        </div>
        <div class="metric-card">
            <div class="metric-label">✏️ Brouillons</div>
            <div class="metric-value">{{ $metrics['drafts'] ?? 0 }}</div>
        </div>
        <div class="metric-card">
            <div class="metric-label">🌍 Publiés</div>
            <div class="metric-value">{{ $metrics['published'] ?? 0 }}</div>
        </div>
        <div class="metric-card">
            <div class="metric-label">💬 Commentaires</div>
            <div class="metric-value">{{ $metrics['comments'] ?? 0 }}</div>
        </div>
    </section>

    {{-- Toolbar --}}
    @php $canCreate = in_array(auth()->user()->role ?? '', ['admin','formateur'], true); @endphp
    <section class="blog-toolbar anim anim-d1" aria-label="{{ $t('blog.toolbar_label', 'Filter blog posts') }}">
        <div class="blog-toolbar__search-wrapper">
            <span class="search-icon">🔍</span>
            <input
                class="blog-toolbar__search"
                type="search"
                name="q"
                value="{{ old('q', $query ?? '') }}"
                placeholder="{{ $t('blog.search_placeholder', 'Rechercher un article...') }}"
                aria-label="{{ $t('blog.search_label', 'Search blog posts') }}"
                autocomplete="off"
            >
        </div>
        <select
            class="blog-toolbar__filter"
            aria-label="{{ $t('blog.filter_label', 'Filter by topic') }}"
        >
            <option value=""{{ empty($selectedCategory) ? ' selected' : '' }}>{{ $t('blog.filter_all', '📚 Tous les sujets') }}</option>
            <option value="education"{{ ($selectedCategory ?? '') === 'education' ? ' selected' : '' }}>{{ $t('blog.filter_education', '🎓 Éducation') }}</option>
            <option value="product"{{ ($selectedCategory ?? '') === 'product' ? ' selected' : '' }}>{{ $t('blog.filter_product', '🚀 Mises à jour') }}</option>
            <option value="campus"{{ ($selectedCategory ?? '') === 'campus' ? ' selected' : '' }}>{{ $t('blog.filter_campus', '🏆 Vie étudiante') }}</option>
        </select>
        @if($canCreate)
            <a href="{{ route('dashboard.blog.create') }}" class="btn-create-post">
                ✨ Créer un article
            </a>
        @endif
    </section>

    {{-- Post grid --}}
    <main class="blog-grid" aria-label="{{ $t('blog.grid_label', 'Blog posts') }}">
        @forelse($posts as $post)
            <a href="{{ route('dashboard.blog.show', $post) }}" class="card blog-post anim" data-topic="{{ $post->category }}" aria-labelledby="post-title-{{ $post->id }}">
                <div class="blog-post__cover" role="img" aria-label="Cover image for {{ $post->title }}" style="background-image: url('{{ $post->cover_image_path ? asset('storage/' . $post->cover_image_path) : '' }}');"></div>
                <div class="blog-post__body">
                    <span class="blog-post__tag">{{ ucfirst($post->category ?: 'Publication') }}</span>
                    <h2 id="post-title-{{ $post->id }}" class="blog-post__title">
                        {{ $post->title }}
                    </h2>
                    <p class="blog-post__excerpt">
                        {{ Str::limit($post->excerpt, 120) }}
                    </p>
                    <footer class="blog-post__meta">
                        <span>👤 {{ $post->author->name ?? 'Admin' }} · 💬 {{ $post->comments->count() }} commentaire{{ $post->comments->count() > 1 ? 's' : '' }}</span>
                        <time datetime="{{ $post->published_at ? $post->published_at->toDateString() : $post->created_at->toDateString() }}">
                            📅 {{ $post->published_at ? $post->published_at->format('d M Y') : $post->created_at->format('d M Y') }}
                        </time>
                    </footer>
                </div>
            </a>
        @empty
            <div class="blog-empty">
                <div class="card" style="padding: 3rem;">
                    <p>📭 Aucun article disponible pour le moment.</p>
                    @if($canCreate)
                        <a href="{{ route('dashboard.blog.create') }}" class="btn-create-post">
                            🚀 Publier le premier article
                        </a>
                    @endif
                </div>
            </div>
        @endforelse
    </main>

</div>

<!-- Coming Soon Modal -->
<div id="csBackdrop" class="cs-backdrop" aria-hidden="true">
    <div id="csModal" class="cs-modal" role="dialog" aria-modal="true" aria-labelledby="csTitle">
        <h3 id="csTitle" class="cs-title">🚀 Bientôt disponible</h3>
        <p class="cs-desc">
            Nous travaillons sur un éditeur complet pour créer des articles directement depuis le tableau de bord. 
            Cette fonctionnalité arrivera très prochainement — restez à l'écoute !
        </p>
        <div class="cs-actions">
            <button class="btn-create-post btn-sm" id="csClose" type="button">Fermer</button>
            <button class="btn-create-post btn-sm" id="csNotify" type="button">Me notifier</button>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const searchInput = document.querySelector('.blog-toolbar__search');
        const topicFilter = document.querySelector('.blog-toolbar__filter');
        const posts = Array.from(document.querySelectorAll('.blog-post:not(.blog-empty)'));
        const createBtn = document.getElementById('createPostBtn');

        // Debounce function for better performance
        const debounce = (func, delay) => {
            let timeoutId;
            return (...args) => {
                clearTimeout(timeoutId);
                timeoutId = setTimeout(() => func.apply(null, args), delay);
            };
        };

        if (searchInput && topicFilter && posts.length > 0) {
            const applyFilters = () => {
                const query = searchInput.value.trim().toLowerCase();
                const topic = topicFilter.value;
                let visibleCount = 0;

                posts.forEach((post) => {
                    const text = `${post.querySelector('.blog-post__title')?.innerText || ''} ${post.querySelector('.blog-post__excerpt')?.innerText || ''}`.toLowerCase();
                    const postTopic = post.dataset.topic || '';
                    const matchesQuery = query === '' || text.includes(query);
                    const matchesTopic = topic === '' || postTopic === topic;

                    if (matchesQuery && matchesTopic) {
                        post.style.display = '';
                        post.style.animation = 'slideInUp 0.3s ease-out';
                        visibleCount++;
                    } else {
                        post.style.display = 'none';
                    }
                });

                // Show/hide empty message
                const emptyMessage = document.querySelector('.blog-empty');
                if (emptyMessage) {
                    emptyMessage.style.display = visibleCount === 0 ? 'block' : 'none';
                }
            };

            const debouncedApply = debounce(applyFilters, 300);
            searchInput.addEventListener('input', debouncedApply);
            topicFilter.addEventListener('change', applyFilters);
        }

        // Modal handling
        const csBackdrop = document.getElementById('csBackdrop');
        const csModal = document.getElementById('csModal');
        const csClose = document.getElementById('csClose');
        const csNotify = document.getElementById('csNotify');

        const closeModal = () => {
            if (csBackdrop && csModal) {
                csBackdrop.classList.remove('show');
                csModal.classList.remove('show');
                setTimeout(() => {
                    csBackdrop.style.display = 'none';
                }, 300);
            }
        };

        const openModal = () => {
            if (csBackdrop && csModal) {
                csBackdrop.style.display = 'flex';
                setTimeout(() => {
                    csBackdrop.classList.add('show');
                    csModal.classList.add('show');
                }, 10);
            }
        };

        if (csClose) csClose.addEventListener('click', closeModal);
        if (csBackdrop) {
            csBackdrop.addEventListener('click', (e) => {
                if (e.target === csBackdrop) closeModal();
            });
        }
        if (csNotify) {
            csNotify.addEventListener('click', () => {
                alert('✅ Merci ! Nous vous informerons dès que cette fonctionnalité sera disponible.');
                closeModal();
            });
        }

        // Keyboard accessibility
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && csBackdrop?.classList.contains('show')) {
                closeModal();
            }
        });
    });
</script>
@endpush
@endsection