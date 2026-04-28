@extends('layouts.app')

@section('title', isset($post->id) ? __('blog.edit_article') : __('blog.new_article'))
@section('page-title', isset($post->id) ? __('blog.edit_article') : __('blog.new_article'))

@push('styles')
<style>
    .blog-form-shell {
        max-width: 900px;
        margin: 0 auto;
        padding-bottom: 2rem;
    }
    .blog-form-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: 20px;
        padding: 2rem;
    }
    .blog-form-group {
        margin-bottom: 1.2rem;
    }
    .blog-form-group label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: 700;
        color: var(--white);
    }
    .blog-form-group input,
    .blog-form-group textarea,
    .blog-form-group select {
        width: 100%;
        border: 1px solid var(--border);
        border-radius: 14px;
        padding: 0.9rem 1rem;
        background: var(--surface);
        color: var(--white);
        font-size: 0.95rem;
    }
    .blog-form-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 1rem;
        justify-content: flex-end;
        align-items: center;
        margin-top: 1.4rem;
    }
    .blog-form-note {
        color: var(--muted);
        font-size: 0.92rem;
    }
    .blog-form-cover {
        width: 100%;
        max-height: 260px;
        object-fit: cover;
        border-radius: 16px;
        border: 1px solid var(--border);
        margin-top: 0.8rem;
    }
</style>
@endpush

@section('content')
<div class="blog-form-shell">
    <div class="blog-form-card card anim">
        <h1>{{ isset($post->id) ? 'Modifier l’article' : 'Nouvel article' }}</h1>

        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ $post->exists ? route('dashboard.blog.update', $post) : route('dashboard.blog.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            @if($post->exists)
                @method('PUT')
            @endif

            <div class="blog-form-group">
                <label for="title">Titre</label>
                <input id="title" type="text" name="title" value="{{ old('title', $post->title) }}" required>
            </div>

            <div class="blog-form-group">
                <label for="excerpt">Accroche</label>
                <input id="excerpt" type="text" name="excerpt" value="{{ old('excerpt', $post->excerpt) }}" required>
            </div>

            <div class="blog-form-group">
                <label for="category">Catégorie</label>
                <select id="category" name="category" required>
                    @foreach($categories as $key => $label)
                        <option value="{{ $key }}"{{ old('category', $post->category) === $key ? ' selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
            </div>

            <div class="blog-form-group">
                <label for="body">Contenu</label>
                <textarea id="body" name="body" rows="10" required>{{ old('body', $post->body) }}</textarea>
            </div>

            <div class="blog-form-group">
                <label for="cover_image">Image de couverture</label>
                <input id="cover_image" type="file" name="cover_image" accept="image/*">
                @if($post->cover_image_path)
                    <img src="{{ asset('storage/' . $post->cover_image_path) }}" alt="Cover image" class="blog-form-cover">
                @endif
            </div>

            <div class="blog-form-group">
                <label for="status">Statut</label>
                <select id="status" name="status" required>
                    <option value="draft"{{ old('status', $post->status) === 'draft' ? ' selected' : '' }}>Brouillon</option>
                    <option value="published"{{ old('status', $post->status) === 'published' ? ' selected' : '' }}>Publié</option>
                </select>
                <p class="blog-form-note">Les articles publiés seront visibles depuis le tableau de bord et la page de blog.</p>
            </div>

            <div class="blog-form-actions">
                <a href="{{ route('dashboard.blog.index') }}" class="btn btn-secondary">Retour au blog</a>
                <button type="submit" class="btn-create-post">{{ $post->exists ? 'Enregistrer les modifications' : 'Publier l’article' }}</button>
            </div>
        </form>
    </div>
</div>
@endsection
