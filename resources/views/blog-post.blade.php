@extends('layouts.app')

@section('title', $post->title)
@section('page-title', $post->title)

@push('styles')
<style>
    .blog-post-shell {
        max-width: 860px;
        margin: 0 auto;
        padding-bottom: 2rem;
    }
    .blog-post-header {
        margin-bottom: 1.5rem;
    }
    .blog-post-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 1rem;
        color: var(--muted);
        font-size: 0.95rem;
    }
    .blog-post-cover {
        width: 100%;
        min-height: 280px;
        object-fit: cover;
        border-radius: 22px;
        border: 1px solid var(--border);
        background-size: cover;
        background-position: center;
        margin-bottom: 1.6rem;
    }
    .blog-post-body {
        line-height: 1.85;
        color: var(--white);
        font-size: 1rem;
    }
    .blog-post-body p {
        margin-bottom: 1rem;
    }
    .blog-comments {
        margin-top: 2rem;
    }
    .comment-card {
        border: 1px solid var(--border);
        border-radius: 18px;
        padding: 1rem 1.1rem;
        background: var(--surface);
        margin-bottom: 1rem;
    }
    .comment-author {
        display: flex;
        justify-content: space-between;
        gap: 1rem;
        margin-bottom: 0.6rem;
        color: var(--white);
        font-weight: 700;
    }
    .comment-body {
        color: var(--muted);
        white-space: pre-line;
    }
    .comment-form textarea {
        min-height: 140px;
    }
</style>
@endpush

@section('content')
<div class="blog-post-shell">
    <div class="blog-post-header card anim">
        @if($post->cover_image_path)
            <div class="blog-post-cover" style="background-image: url('{{ asset('storage/' . $post->cover_image_path) }}');"></div>
        @endif
        <div class="blog-post-meta">
            <span class="pill pill-blue">{{ ucfirst($post->category ?? 'Publication') }}</span>
            <span>{{ $post->author->name }}</span>
            <span>{{ $post->published_at ? $post->published_at->format('M d, Y') : $post->created_at->format('M d, Y') }}</span>
            <span>{{ $post->comments->count() }} commentaire{{ $post->comments->count() > 1 ? 's' : '' }}</span>
        </div>
        <h1 class="blog-hero__title" style="margin-top: 1rem;">{{ $post->title }}</h1>
        <p class="blog-hero__desc" style="margin-top: 0.75rem;">{{ $post->excerpt }}</p>

        <div style="margin-top: 1.5rem; display:flex; gap:0.75rem; flex-wrap:wrap;">
            <a href="{{ route('dashboard.blog.index') }}" class="btn btn-secondary">Retour au blog</a>
            @can('update', $post)
                <a href="{{ route('dashboard.blog.edit', $post) }}" class="btn-create-post btn-sm">Modifier</a>
            @endcan
            @can('delete', $post)
                <form action="{{ route('dashboard.blog.destroy', $post) }}" method="post" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-create-post btn-sm" style="background:#dc2626;">Supprimer</button>
                </form>
            @endcan
        </div>
    </div>

    <article class="blog-post-body card anim" style="padding: 1.75rem;">
        {!! nl2br(e($post->body)) !!}
    </article>

    <section class="blog-comments">
        <h2 style="margin-bottom: 1rem;">Commentaires</h2>

        @forelse($post->comments as $comment)
            <div class="comment-card">
                <div class="comment-author">
                    <span>{{ $comment->author->name }}</span>
                    <time>{{ $comment->created_at->format('M d, Y H:i') }}</time>
                </div>
                <div class="comment-body">{{ $comment->body }}</div>
            </div>
        @empty
            <p>Aucun commentaire pour le moment.</p>
        @endforelse

        @if(auth()->user()->role !== 'student' || $post->status === 'published')
            <form action="{{ route('dashboard.blog.comments.store', $post) }}" method="post" class="comment-form card anim" style="padding: 1.5rem; margin-top: 1.5rem;"> 
                @csrf
                <label for="body" style="font-weight:700; margin-bottom:0.5rem; display:block;">Ajouter un commentaire</label>
                <textarea id="body" name="body" required>{{ old('body') }}</textarea>
                <button type="submit" class="btn-create-post" style="margin-top: 1rem;">Publier le commentaire</button>
            </form>
        @else
            <p class="blog-form-note" style="margin-top:1rem;">Les commentaires ne sont disponibles que sur les articles publi\u00e9s.</p>
        @endif
    </section>
</div>
@endsection
