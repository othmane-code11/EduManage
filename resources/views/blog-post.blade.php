@extends('layouts.app')

@section('title', $post->title)
@section('page-title', $post->title)

@push('styles')
<style>
    .blog-post-shell {
        max-width: 860px;
        margin: 0 auto;
        padding: 1rem 1rem 2rem;
    }
    
    .blog-post-header {
        margin-bottom: 2rem;
        overflow: hidden;
    }
    
    .blog-post-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 1rem;
        color: var(--muted);
        font-size: 0.9rem;
        align-items: center;
    }
    
    .blog-post-cover {
        width: 100%;
        min-height: 360px;
        object-fit: cover;
        border-radius: 24px;
        border: 1px solid var(--border);
        background-size: cover;
        background-position: center;
        margin-bottom: 1.8rem;
        transition: transform 0.3s ease;
        position: relative;
        overflow: hidden;
    }
    
    .blog-post-cover:hover {
        transform: scale(1.02);
    }
    
    .blog-post-body {
        line-height: 1.85;
        color: var(--white);
        font-size: 1.05rem;
        background: var(--surface);
        border-radius: 24px;
        padding: 2rem !important;
    }
    
    .blog-post-body p {
        margin-bottom: 1.25rem;
    }
    
    .blog-post-body h2, 
    .blog-post-body h3, 
    .blog-post-body h4 {
        margin-top: 1.5rem;
        margin-bottom: 1rem;
        font-family: 'Syne', sans-serif;
    }
    
    .blog-post-body img {
        max-width: 100%;
        border-radius: 16px;
        margin: 1rem 0;
    }
    
    .blog-post-body blockquote {
        border-left: 4px solid rgba(56, 189, 248, 0.6);
        padding-left: 1.5rem;
        margin: 1.5rem 0;
        font-style: italic;
        color: var(--muted);
    }
    
    .blog-post-body pre {
        background: rgba(0, 0, 0, 0.3);
        padding: 1rem;
        border-radius: 12px;
        overflow-x: auto;
        margin: 1rem 0;
    }
    
    .blog-post-body code {
        background: rgba(56, 189, 248, 0.1);
        padding: 0.2rem 0.4rem;
        border-radius: 6px;
        font-size: 0.9em;
    }
    
    .blog-comments {
        margin-top: 3rem;
    }
    
    .blog-comments h2 {
        font-family: 'Syne', sans-serif;
        font-size: 1.5rem;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .comment-card {
        border: 1px solid var(--border);
        border-radius: 20px;
        padding: 1.25rem 1.5rem;
        background: var(--surface);
        margin-bottom: 1rem;
        transition: all 0.3s ease;
    }
    
    .comment-card:hover {
        transform: translateX(4px);
        border-color: rgba(56, 189, 248, 0.3);
    }
    
    .comment-author {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 1rem;
        margin-bottom: 0.75rem;
        color: var(--white);
        font-weight: 700;
        flex-wrap: wrap;
    }
    
    .comment-author span:first-child {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .comment-author span:first-child::before {
        content: '👤';
        font-size: 1rem;
    }
    
    .comment-author time {
        color: var(--muted);
        font-weight: normal;
        font-size: 0.8rem;
    }
    
    .comment-body {
        color: var(--muted);
        white-space: pre-line;
        line-height: 1.6;
    }
    
    .comment-form textarea {
        min-height: 140px;
        resize: vertical;
    }
    
    .comment-form textarea:focus {
        outline: none;
        border-color: rgba(56, 189, 248, 0.6);
        box-shadow: 0 0 0 3px rgba(56, 189, 248, 0.1);
    }
    
    /* Action buttons group */
    .blog-post-actions {
        margin-top: 2rem;
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
        align-items: center;
        padding-top: 1rem;
        border-top: 1px solid var(--border);
    }
    
    /* Button styles */
    .btn {
        padding: 0.7rem 1.5rem;
        border-radius: 40px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        cursor: pointer;
        border: none;
        font-size: 0.9rem;
    }
    
    .btn-secondary {
        background: transparent;
        border: 2px solid var(--border);
        color: var(--white);
    }
    
    .btn-secondary:hover {
        background: rgba(255, 255, 255, 0.05);
        border-color: var(--white);
        transform: translateY(-2px);
    }
    
    .btn-create-post {
        background: linear-gradient(135deg, #3b82c4, #1e4f8f);
        color: white;
        padding: 0.7rem 1.5rem;
        border: none;
        font-weight: 600;
        border-radius: 40px;
        cursor: pointer;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        text-decoration: none;
        font-size: 0.9rem;
    }
    
    .btn-create-post:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(59, 130, 196, 0.4);
        background: linear-gradient(135deg, #60a5fa, #2563eb);
    }
    
    .btn-create-post.btn-sm {
        padding: 0.5rem 1.2rem;
        font-size: 0.85rem;
    }
    
    .btn-delete {
        background: linear-gradient(135deg, #dc2626, #991b1b);
    }
    
    .btn-delete:hover {
        box-shadow: 0 4px 12px rgba(220, 38, 38, 0.4);
    }
    
    /* Comment count badge */
    .comment-count {
        background: rgba(56, 189, 248, 0.15);
        padding: 0.2rem 0.6rem;
        border-radius: 20px;
        font-size: 0.8rem;
        color: #7dd3fc;
    }
    
    /* Empty state */
    .comments-empty {
        text-align: center;
        padding: 2rem;
        background: var(--surface);
        border-radius: 20px;
        border: 1px solid var(--border);
        color: var(--muted);
    }
    
    /* Share buttons */
    .blog-share {
        margin-top: 1rem;
        display: flex;
        gap: 0.5rem;
        align-items: center;
        flex-wrap: wrap;
    }
    
    .share-btn {
        padding: 0.4rem 0.8rem;
        border-radius: 20px;
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid var(--border);
        color: var(--muted);
        cursor: pointer;
        transition: all 0.2s ease;
        font-size: 0.8rem;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
    }
    
    .share-btn:hover {
        background: rgba(255, 255, 255, 0.1);
        transform: translateY(-1px);
    }
    
    /* Animations */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .blog-post-header,
    .blog-post-body,
    .blog-comments {
        animation: fadeInUp 0.5s ease-out forwards;
    }
    
    .blog-post-body {
        animation-delay: 0.1s;
        opacity: 0;
        animation-fill-mode: forwards;
    }
    
    .blog-comments {
        animation-delay: 0.2s;
        opacity: 0;
        animation-fill-mode: forwards;
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .blog-post-shell {
            padding: 0.5rem;
        }
        
        .blog-post-cover {
            min-height: 220px;
        }
        
        .blog-post-body {
            padding: 1.25rem !important;
            font-size: 0.95rem;
        }
        
        .comment-card {
            padding: 1rem;
        }
        
        .comment-author {
            flex-direction: column;
            align-items: flex-start;
            gap: 0.3rem;
        }
        
        .blog-post-actions {
            flex-wrap: wrap;
        }
        
        .btn,
        .btn-create-post {
            width: 100%;
            justify-content: center;
        }
    }
    
    /* Reading progress bar */
    .reading-progress {
        position: fixed;
        top: 0;
        left: 0;
        width: 0%;
        height: 3px;
        background: linear-gradient(90deg, #3b82c4, #60a5fa, #3b82c4);
        z-index: 1000;
        transition: width 0.1s ease;
    }
    
    /* Toast notification */
    .toast-notification {
        position: fixed;
        bottom: 20px;
        right: 20px;
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: 12px;
        padding: 0.75rem 1.25rem;
        color: var(--white);
        transform: translateX(400px);
        transition: transform 0.3s ease;
        z-index: 1100;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
    }
    
    .toast-notification.show {
        transform: translateX(0);
    }
</style>
@endpush

@section('content')
<div class="blog-post-shell">
    <!-- Reading progress bar -->
    <div id="readingProgress" class="reading-progress"></div>
    
    <div class="blog-post-header card anim">
        @if($post->cover_image_path)
            <div class="blog-post-cover" style="background-image: url('{{ asset('storage/' . $post->cover_image_path) }}');"></div>
        @endif
        
        <div class="blog-post-meta">
            <span class="pill pill-blue">📂 {{ ucfirst($post->category ?? 'Publication') }}</span>
            <span>✍️ {{ $post->author->name }}</span>
            <span>📅 {{ $post->published_at ? $post->published_at->format('d M Y') : $post->created_at->format('d M Y') }}</span>
            <span class="comment-count">💬 {{ $post->comments->count() }} commentaire{{ $post->comments->count() > 1 ? 's' : '' }}</span>
        </div>
        
        <h1 style="margin-top: 1.5rem; font-size: clamp(1.8rem, 4vw, 2.5rem);">{{ $post->title }}</h1>
        
        @if($post->excerpt)
            <p class="blog-hero__desc" style="margin-top: 1rem; font-size: 1.1rem; color: var(--muted);">
                {{ $post->excerpt }}
            </p>
        @endif

        <div class="blog-post-actions">
            <a href="{{ route('dashboard.blog.index') }}" class="btn btn-secondary">
                ← Retour au blog
            </a>
            
            @can('update', $post)
                <a href="{{ route('dashboard.blog.edit', $post) }}" class="btn-create-post btn-sm">
                    ✏️ Modifier
                </a>
            @endcan
            
            @can('delete', $post)
                <form action="{{ route('dashboard.blog.destroy', $post) }}" method="post" style="display:inline;" id="deleteForm">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="btn-create-post btn-sm btn-delete" id="deleteBtn">
                        🗑️ Supprimer
                    </button>
                </form>
            @endcan
        </div>
        
        <!-- Share section -->
        <div class="blog-share">
            <span style="font-size: 0.8rem; color: var(--muted);">Partager :</span>
            <button class="share-btn" onclick="shareArticle('twitter')">
                🐦 Twitter
            </button>
            <button class="share-btn" onclick="shareArticle('linkedin')">
                🔗 LinkedIn
            </button>
            <button class="share-btn" onclick="copyToClipboard()">
                📋 Copier le lien
            </button>
        </div>
    </div>

    <article class="blog-post-body card" style="padding: 1.75rem;">
        {!! nl2br(e($post->body)) !!}
    </article>

    <section class="blog-comments">
        <h2>
            💬 Commentaires 
            <span class="comment-count">{{ $post->comments->count() }}</span>
        </h2>

        @forelse($post->comments as $comment)
            <div class="comment-card">
                <div class="comment-author">
                    <span>{{ $comment->author->name }}</span>
                    <time datetime="{{ $comment->created_at->toDateString() }}">
                        📅 {{ $comment->created_at->format('d M Y H:i') }}
                    </time>
                </div>
                <div class="comment-body">{{ $comment->body }}</div>
            </div>
        @empty
            <div class="comments-empty">
                💭 Aucun commentaire pour le moment. Soyez le premier à commenter !
            </div>
        @endforelse

        @if(auth()->user()->role !== 'student' || $post->status === 'published')
            <form action="{{ route('dashboard.blog.comments.store', $post) }}" method="post" class="comment-form card anim" style="padding: 1.5rem; margin-top: 1.5rem;"> 
                @csrf
                <label for="body" style="font-weight:700; margin-bottom:0.75rem; display:flex; align-items:center; gap:0.5rem;">
                    ✍️ Ajouter un commentaire
                </label>
                <textarea 
                    id="body" 
                    name="body" 
                    required 
                    placeholder="Partagez votre avis sur cet article..."
                    style="min-height: 120px; resize: vertical; width: 100%; border-radius: 16px; padding: 1rem; background: var(--surface); border: 1px solid var(--border); color: var(--white);"
                >{{ old('body') }}</textarea>
                <button type="submit" class="btn-create-post" style="margin-top: 1.25rem;">
                    📤 Publier le commentaire
                </button>
            </form>
        @else
            <div class="comments-empty" style="margin-top: 1rem; background: rgba(220, 38, 38, 0.1); border-color: rgba(220, 38, 38, 0.3);">
                🔒 Les commentaires ne sont disponibles que sur les articles publiés.
            </div>
        @endif
    </section>
</div>

<!-- Toast notification -->
<div id="toast" class="toast-notification">
    🔗 Lien copié dans le presse-papier !
</div>

@push('scripts')
<script>
    // Reading progress bar
    const readingProgress = document.getElementById('readingProgress');
    
    window.addEventListener('scroll', () => {
        const windowHeight = window.innerHeight;
        const documentHeight = document.documentElement.scrollHeight;
        const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
        const scrollPercent = (scrollTop / (documentHeight - windowHeight)) * 100;
        readingProgress.style.width = scrollPercent + '%';
    });
    
    // Share functionality
    window.shareArticle = (platform) => {
        const url = encodeURIComponent(window.location.href);
        const title = encodeURIComponent("{{ $post->title }}");
        
        let shareUrl = '';
        switch(platform) {
            case 'twitter':
                shareUrl = `https://twitter.com/intent/tweet?url=${url}&text=${title}`;
                break;
            case 'linkedin':
                shareUrl = `https://www.linkedin.com/sharing/share-offsite/?url=${url}`;
                break;
        }
        
        if (shareUrl) {
            window.open(shareUrl, '_blank', 'width=600,height=400');
        }
    };
    
    // Copy to clipboard
    window.copyToClipboard = () => {
        const url = window.location.href;
        navigator.clipboard.writeText(url).then(() => {
            const toast = document.getElementById('toast');
            toast.classList.add('show');
            setTimeout(() => {
                toast.classList.remove('show');
            }, 2000);
        }).catch(() => {
            alert('Impossible de copier le lien');
        });
    };
    
    // Delete confirmation
    const deleteBtn = document.getElementById('deleteBtn');
    if (deleteBtn) {
        deleteBtn.addEventListener('click', (e) => {
            if (confirm('⚠️ Êtes-vous sûr de vouloir supprimer cet article ? Cette action est irréversible.')) {
                document.getElementById('deleteForm').submit();
            }
        });
    }
    
    // Smooth scroll for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                e.preventDefault();
                target.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        });
    });
    
    // Add CSS class for light mode detection
    if (document.body.classList.contains('light-mode')) {
        const style = document.createElement('style');
        style.textContent = `
            .blog-post-body {
                color: #1a202c;
            }
            .comment-card {
                background: #f7fafc;
            }
        `;
        document.head.appendChild(style);
    }
</script>
@endpush
@endsection