@extends('layouts.app')

@section('title', __('navigation.blog'))
@section('page-title', __('navigation.blog'))

@push('styles')
<style>
    /* ─── Design Tokens ─────────────────────────────────────────────── */
    :root {
        --blog-radius-card:   18px;
        --blog-radius-tag:    999px;
        --blog-radius-input:  12px;
        --blog-cover-height:  158px;
        --blog-sky-primary:   56, 189, 248;   /* sky-400 */
        --blog-sky-secondary: 59, 130, 246;   /* blue-500 */
        --blog-accent-text:   #7dd3fc;
        --blog-transition:    200ms ease;
        --blog-max-width:     1200px;
    }

    /* ─── Shell ─────────────────────────────────────────────────────── */
    .blog-shell {
        max-width: var(--blog-max-width);
        margin: 0 auto;
    }

    /* ─── Hero ───────────────────────────────────────────────────────── */
    .blog-hero {
        padding: 1.75rem;
        background:
            radial-gradient(circle at 15% 20%, rgba(var(--blog-sky-primary),  0.20), transparent 48%),
            radial-gradient(circle at 80% 15%, rgba(var(--blog-sky-secondary), 0.22), transparent 42%),
            linear-gradient(135deg, rgba(4, 44, 83, 0.9), rgba(1, 34, 68, 0.9));
        border: 1px solid var(--border);
        border-radius: var(--blog-radius-card);
        margin-bottom: 1.5rem;
    }

    .blog-hero__title {
        font-family: 'Syne', sans-serif;
        font-size: clamp(1.4rem, 3vw, 2rem);
        letter-spacing: -0.02em;
        margin-bottom: 0.4rem;
    }

    .blog-hero__desc {
        color: var(--text-muted, var(--muted));
        max-width: 720px;
        line-height: 1.7;
        font-size: 0.95rem;
        margin: 0;
    }

    /* ─── Toolbar ────────────────────────────────────────────────────── */
    .blog-toolbar {
        display: grid;
        grid-template-columns: 1fr auto auto;
        gap: 0.8rem;
        margin-bottom: 1.25rem;
    }

    .blog-toolbar__search,
    .blog-toolbar__filter {
        border: 1px solid var(--border);
        border-radius: var(--blog-radius-input);
        background: var(--surface);
        color: var(--white);
        padding: 0.72rem 0.9rem;
        font-family: inherit;
        font-size: 0.9rem;
        outline: none;
        transition: border-color var(--blog-transition), box-shadow var(--blog-transition);
    }

    .blog-toolbar__search { width: 100%; }

    .blog-toolbar__search::placeholder { color: var(--muted); }

    .blog-toolbar__search:focus-visible,
    .blog-toolbar__filter:focus-visible {
        border-color: rgba(var(--blog-sky-primary), 0.6);
        box-shadow: 0 0 0 3px rgba(var(--blog-sky-primary), 0.15);
    }

    /* ─── Grid ───────────────────────────────────────────────────────── */
    .blog-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 1rem;
    }

    /* ─── Card ───────────────────────────────────────────────────────── */
    .blog-post {
        overflow: hidden;
        text-decoration: none;
        color: inherit;
        display: flex;
        flex-direction: column;
        transition: transform var(--blog-transition), box-shadow var(--blog-transition);
    }

    .blog-post:hover,
    .blog-post:focus-visible {
        transform: translateY(-3px);
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.25);
        outline: none;
    }

    .blog-post:focus-visible {
        box-shadow:
            0 8px 24px rgba(0, 0, 0, 0.25),
            0 0 0 3px rgba(var(--blog-sky-primary), 0.5);
    }

    /* Cover */
    .blog-post__cover {
        height: var(--blog-cover-height);
        flex-shrink: 0;
        border-bottom: 1px solid var(--border);
        background:
            radial-gradient(circle at 25% 20%, rgba(var(--blog-sky-primary),  0.25), transparent 45%),
            radial-gradient(circle at 80% 80%, rgba(var(--blog-sky-secondary), 0.20), transparent 50%),
            #08244b;
    }

    /* Body */
    .blog-post__body {
        padding: 1rem;
        display: flex;
        flex-direction: column;
        flex: 1;
    }

    /* Tag */
    .blog-post__tag {
        display: inline-flex;
        align-self: flex-start;
        font-size: 0.72rem;
        font-weight: 600;
        padding: 0.25rem 0.55rem;
        border-radius: var(--blog-radius-tag);
        border: 1px solid rgba(var(--blog-sky-primary), 0.35);
        background: rgba(var(--blog-sky-primary), 0.12);
        color: var(--blog-accent-text);
        margin-bottom: 0.65rem;
    }

    /* Title */
    .blog-post__title {
        font-family: 'Syne', sans-serif;
        font-size: 1.02rem;
        line-height: 1.35;
        margin-bottom: 0.45rem;
    }

    /* Excerpt */
    .blog-post__excerpt {
        color: var(--muted);
        font-size: 0.88rem;
        line-height: 1.65;
        margin-bottom: 0.85rem;
        flex: 1;
    }

    /* Meta */
    .blog-post__meta {
        display: flex;
        justify-content: space-between;
        align-items: center;
        color: var(--muted);
        font-size: 0.78rem;
        border-top: 1px solid var(--border);
        padding-top: 0.7rem;
        margin-top: auto;
    }

    /* ─── Light-mode overrides ───────────────────────────────────────── */
    body.light-mode .blog-toolbar__search,
    body.light-mode .blog-toolbar__filter {
        color: #1e293b;
        background: rgba(0, 0, 0, 0.03);
    }

    body.light-mode .blog-post__cover {
        background:
            radial-gradient(circle at 25% 20%, rgba(2, 132, 199, 0.20),  transparent 45%),
            radial-gradient(circle at 80% 80%, rgba(15, 23, 42,  0.13),  transparent 50%),
            #dbeafe;
    }

    /* ─── Reduced motion ─────────────────────────────────────────────── */
    @media (prefers-reduced-motion: reduce) {
        .blog-post { transition: none; }
    }

    /* ─── Responsive ─────────────────────────────────────────────────── */
    @media (max-width: 1100px) {
        .blog-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
    }

    @media (max-width: 720px) {
        .blog-toolbar        { grid-template-columns: 1fr; }
        .blog-grid           { grid-template-columns: 1fr; }
        .blog-toolbar__filter { width: 100%; }
    }

    /* ─── Metrics / Top KPIs ───────────────────────────────────────── */
    .blog-metrics {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 0.9rem;
        margin-bottom: 1rem;
    }
    .metric-card {
        padding: 0.9rem;
        border-radius: 12px;
        border: 1px solid var(--border);
        background: linear-gradient(180deg, rgba(255,255,255,0.02), rgba(255,255,255,0.01));
    }
    .metric-label { font-size: 0.72rem; color: var(--muted); font-weight: 700; text-transform: uppercase; }
    .metric-value { font-family: 'Syne', sans-serif; font-size: 1.25rem; font-weight: 900; color: var(--white); }

    @media (max-width: 900px) {
        .blog-metrics { grid-template-columns: repeat(2, minmax(0, 1fr)); }
    }

    /* ─── Coming Soon Modal ───────────────────────────────────────────── */
    .cs-backdrop {
        position: fixed; inset: 0; background: rgba(2,6,23,0.6); display: none; align-items: center; justify-content: center; z-index: 1200;
    }
    .cs-modal {
        width: 520px; max-width: calc(100% - 32px); border-radius: 14px; padding: 1.1rem 1.2rem; background: linear-gradient(180deg, #06203a, #041427); border: 1px solid rgba(255,255,255,0.04); box-shadow: 0 20px 60px rgba(1,12,30,0.6);
        transform: translateY(8px); opacity: 0; transition: all 180ms ease; color: var(--white);
    }
    .cs-backdrop.show { display:flex; }
    .cs-modal.show { transform: translateY(0); opacity: 1; }
    .cs-title { font-family: 'Syne', sans-serif; font-size: 1.08rem; font-weight: 800; margin: 0 0 0.35rem; }
    .cs-desc { color: var(--muted); margin: 0 0 0.8rem; }
    .cs-actions { display:flex; gap:0.6rem; justify-content:flex-end; }

    /* ─── Create Post Button (senior front-end design) ────────────────── */
    .btn-create-post {
        --grad-start: #3b82c4;
        --grad-end: #1e4f8f;
        --grad-hover-start: #60a5fa;
        --grad-hover-end: #2563eb;
        --shadow-outer: 0 8px 24px rgba(13, 42, 77, 0.35);
        --shadow-outer-hover: 0 18px 44px rgba(13, 42, 77, 0.45);
        --shadow-inner: inset 0 1px 0 rgba(255,255,255,0.06);

        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        padding: 0.64rem 1rem;
        border-radius: 12px;
        border: none;
        cursor: pointer;
        color: white;
        font-weight: 700;
        font-family: Inter, system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', Arial;
        font-size: 0.95rem;
        line-height: 1;
        background-image: linear-gradient(135deg, var(--grad-start), var(--grad-end));
        box-shadow: var(--shadow-outer), var(--shadow-inner);
        transition: transform 220ms cubic-bezier(.2,.9,.2,1), box-shadow 220ms ease, filter 220ms ease, background-image 220ms ease;
        -webkit-tap-highlight-color: transparent;
    }

    .btn-create-post:focus {
        outline: none;
        box-shadow: 0 6px 30px rgba(37,99,235,0.18), 0 2px 8px rgba(2,6,23,0.12);
        filter: brightness(1.02);
    }

    .btn-create-post:hover {
        transform: translateY(-4px);
        box-shadow: var(--shadow-outer-hover), var(--shadow-inner);
        background-image: linear-gradient(135deg, var(--grad-hover-start), var(--grad-hover-end));
    }

    .btn-create-post:active {
        transform: translateY(1px);
        box-shadow: 0 6px 14px rgba(13, 42, 77, 0.28), inset 0 1px 0 rgba(255,255,255,0.03);
        transition: transform 120ms ease, box-shadow 120ms ease;
    }

    /* Small variant for modal actions */
    .btn-create-post.btn-sm { padding: 0.44rem 0.72rem; font-size: 0.88rem; border-radius: 10px; }
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
            <div class="metric-label">Posts</div>
            <div class="metric-value">12</div>
        </div>
        <div class="metric-card">
            <div class="metric-label">Drafts</div>
            <div class="metric-value">3</div>
        </div>
        <div class="metric-card">
            <div class="metric-label">Total views</div>
            <div class="metric-value">8.3k</div>
        </div>
        <div class="metric-card">
            <div class="metric-label">Contributors</div>
            <div class="metric-value">5</div>
        </div>
    </section>

    {{-- Toolbar --}}
    @php $canCreate = in_array(auth()->user()->role ?? '', ['admin','formateur'], true); @endphp
    <section class="blog-toolbar anim anim-d1" aria-label="{{ $t('blog.toolbar_label', 'Filter blog posts') }}">
        <input
            class="blog-toolbar__search"
            type="search"
            name="q"
            placeholder="{{ $t('blog.search_placeholder', 'Search articles...') }}"
            aria-label="{{ $t('blog.search_label', 'Search blog posts') }}"
            autocomplete="off"
        >
        <select
            class="blog-toolbar__filter"
            aria-label="{{ $t('blog.filter_label', 'Filter by topic') }}"
        >
            <option value="">{{ $t('blog.filter_all', 'All Topics') }}</option>
            <option value="education">{{ $t('blog.filter_education', 'Education') }}</option>
            <option value="product">{{ $t('blog.filter_product', 'Product Updates') }}</option>
            <option value="campus">{{ $t('blog.filter_campus', 'Student Life') }}</option>
        </select>
        @if($canCreate)
            <button class="btn-create-post" id="createPostBtn">Create Post</button>
        @endif
    </section>

    {{-- Post grid --}}
    <main class="blog-grid" aria-label="{{ $t('blog.grid_label', 'Blog posts') }}">

        <a href="#" class="card blog-post anim anim-d2" data-topic="education" aria-labelledby="post-title-1">
            <div class="blog-post__cover" role="img" aria-hidden="true"></div>
            <div class="blog-post__body">
                <span class="blog-post__tag">Education</span>
                <h2 id="post-title-1" class="blog-post__title">
                    How to Build Better Study Routines in 30 Days
                </h2>
                <p class="blog-post__excerpt">
                    Practical routines you can apply this week to improve consistency and reduce exam stress.
                </p>
                <footer class="blog-post__meta">
                    <span>By EduManage Team</span>
                    <time datetime="2026-04-25">Apr 25, 2026</time>
                </footer>
            </div>
        </a>

        <a href="#" class="card blog-post anim anim-d3" data-topic="product" aria-labelledby="post-title-2">
            <div class="blog-post__cover" role="img" aria-hidden="true"></div>
            <div class="blog-post__body">
                <span class="blog-post__tag">Product</span>
                <h2 id="post-title-2" class="blog-post__title">
                    New Attendance Insights Released
                </h2>
                <p class="blog-post__excerpt">
                    Discover what changed in the latest analytics panel and how instructors can act faster.
                </p>
                <footer class="blog-post__meta">
                    <span>By Admin Desk</span>
                    <time datetime="2026-04-22">Apr 22, 2026</time>
                </footer>
            </div>
        </a>

        <a href="#" class="card blog-post anim anim-d4" data-topic="campus" aria-labelledby="post-title-3">
            <div class="blog-post__cover" role="img" aria-hidden="true"></div>
            <div class="blog-post__body">
                <span class="blog-post__tag">Campus</span>
                <h2 id="post-title-3" class="blog-post__title">
                    Student Stories: Time Management That Works
                </h2>
                <p class="blog-post__excerpt">
                    Three student playbooks that improved assignment completion rates without burnout.
                </p>
                <footer class="blog-post__meta">
                    <span>By Student Council</span>
                    <time datetime="2026-04-18">Apr 18, 2026</time>
                </footer>
            </div>
        </a>

    </main>

</div>

    <!-- Coming Soon Modal -->
    <div id="csBackdrop" class="cs-backdrop" aria-hidden="true">
        <div id="csModal" class="cs-modal" role="dialog" aria-modal="true" aria-labelledby="csTitle">
            <h3 id="csTitle" class="cs-title">Feature coming soon</h3>
            <p class="cs-desc">We're working on a full editor and publishing flow for creating blog posts inside the dashboard. This feature will arrive soon—stay tuned.</p>
            <div class="cs-actions">
                <button class="btn-create-post btn-sm" id="csClose" type="button">Close</button>
                <button class="btn-create-post btn-sm" id="csNotify" type="button">Notify me</button>
            </div>
        </div>
    </div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const searchInput = document.querySelector('.blog-toolbar__search');
        const topicFilter = document.querySelector('.blog-toolbar__filter');
        const posts = Array.from(document.querySelectorAll('.blog-post'));
        const createBtn = document.getElementById('createPostBtn');

        if (!searchInput || !topicFilter || posts.length === 0) {
            return;
        }

        const applyFilters = () => {
            const query = searchInput.value.trim().toLowerCase();
            const topic = topicFilter.value;

            posts.forEach((post) => {
                const text = post.textContent.toLowerCase();
                const postTopic = post.dataset.topic || '';
                const matchesQuery = query === '' || text.includes(query);
                const matchesTopic = topic === '' || postTopic === topic;

                post.style.display = matchesQuery && matchesTopic ? '' : 'none';
            });
        };

        searchInput.addEventListener('input', applyFilters);
        topicFilter.addEventListener('change', applyFilters);

        if (createBtn) {
                createBtn.addEventListener('click', (e) => {
                    e.preventDefault();
                    // Show polished Coming Soon modal
                    const bd = document.getElementById('csBackdrop');
                    const m = document.getElementById('csModal');
                    if (bd && m) {
                        bd.classList.add('show');
                        m.classList.add('show');
                    } else {
                        alert('Feature coming soon.');
                    }
                });
        }

            // Modal actions
            const csBackdrop = document.getElementById('csBackdrop');
            const csClose = document.getElementById('csClose');
            const csNotify = document.getElementById('csNotify');
            if (csClose && csBackdrop) {
                csClose.addEventListener('click', () => { csBackdrop.classList.remove('show'); document.getElementById('csModal').classList.remove('show'); });
            }
            if (csBackdrop) {
                csBackdrop.addEventListener('click', (e) => { if (e.target === csBackdrop) { csBackdrop.classList.remove('show'); document.getElementById('csModal').classList.remove('show'); } });
            }
            if (csNotify) {
                csNotify.addEventListener('click', () => { csBackdrop.classList.remove('show'); document.getElementById('csModal').classList.remove('show'); alert('We will notify you when this feature is available.'); });
            }
    });
</script>
@endpush
@endsection