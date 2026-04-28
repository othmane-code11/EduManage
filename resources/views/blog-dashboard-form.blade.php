@extends('layouts.app')

@section('title', isset($post->id) ? __('blog.edit_article') : __('blog.new_article'))
@section('page-title', isset($post->id) ? __('blog.edit_article') : __('blog.new_article'))

@push('styles')
<style>
    .blog-form-shell {
        max-width: 900px;
        margin: 0 auto;
        padding: 2rem 1rem;
    }
    
    .blog-form-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: 24px;
        padding: 2rem;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    
    .blog-form-card:hover {
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
    }
    
    .blog-form-card h1 {
        font-size: 1.75rem;
        margin-bottom: 1.5rem;
        font-weight: 700;
        background: linear-gradient(135deg, var(--white) 0%, var(--muted) 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
    
    .blog-form-group {
        margin-bottom: 1.5rem;
    }
    
    .blog-form-group label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: 600;
        color: var(--white);
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .blog-form-group label::after {
        content: '';
        display: inline-block;
        width: 4px;
        height: 4px;
        background: #ff6b6b;
        border-radius: 50%;
        margin-left: 4px;
        vertical-align: middle;
        opacity: 0;
    }
    
    .blog-form-group label.required::after {
        opacity: 1;
    }
    
    .blog-form-group input,
    .blog-form-group textarea,
    .blog-form-group select {
        width: 100%;
        border: 2px solid var(--border);
        border-radius: 16px;
        padding: 0.9rem 1rem;
        background: var(--surface);
        color: var(--white);
        font-size: 0.95rem;
        transition: all 0.2s ease;
        font-family: inherit;
    }
    
    .blog-form-group input:focus,
    .blog-form-group textarea:focus,
    .blog-form-group select:focus {
        outline: none;
        border-color: #4a9eff;
        box-shadow: 0 0 0 3px rgba(74, 158, 255, 0.1);
    }
    
    .blog-form-group input:hover,
    .blog-form-group textarea:hover,
    .blog-form-group select:hover {
        border-color: #6c757d;
    }
    
    .blog-form-group textarea {
        resize: vertical;
        min-height: 200px;
    }
    
    .blog-form-group input[type="file"] {
        padding: 0.7rem;
        cursor: pointer;
    }
    
    .blog-form-group input[type="file"]:hover {
        background: rgba(255, 255, 255, 0.05);
    }
    
    .blog-form-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 1rem;
        justify-content: flex-end;
        align-items: center;
        margin-top: 2rem;
        padding-top: 1rem;
        border-top: 1px solid var(--border);
    }
    
    .blog-form-note {
        color: var(--muted);
        font-size: 0.85rem;
        margin-top: 0.5rem;
        line-height: 1.4;
    }
    
    .blog-form-cover {
        width: 100%;
        max-height: 280px;
        object-fit: cover;
        border-radius: 16px;
        border: 2px solid var(--border);
        margin-top: 1rem;
        transition: transform 0.2s ease;
    }
    
    .blog-form-cover:hover {
        transform: scale(1.02);
    }
    
    .alert-danger {
        background: rgba(220, 53, 69, 0.1);
        border: 1px solid rgba(220, 53, 69, 0.3);
        border-radius: 16px;
        padding: 1rem;
        margin-bottom: 1.5rem;
    }
    
    .alert-danger ul {
        margin: 0;
        padding-left: 1.2rem;
        color: #ff6b6b;
    }
    
    .btn {
        padding: 0.8rem 1.5rem;
        border-radius: 40px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.2s ease;
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
        background: linear-gradient(135deg, #4a9eff 0%, #6c5ce7 100%);
        color: white;
        padding: 0.8rem 2rem;
        border: none;
    }
    
    .btn-create-post:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(74, 158, 255, 0.3);
    }
    
    @media (max-width: 768px) {
        .blog-form-shell {
            padding: 1rem;
        }
        
        .blog-form-card {
            padding: 1.5rem;
        }
        
        .blog-form-card h1 {
            font-size: 1.5rem;
        }
        
        .blog-form-actions {
            flex-direction: column-reverse;
        }
        
        .blog-form-actions .btn,
        .blog-form-actions button {
            width: 100%;
            justify-content: center;
        }
    }
    
    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .anim {
        animation: slideIn 0.4s ease-out;
    }
    
    /* Custom select styling */
    select {
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%23ffffff' d='M6 8L1 3h10z'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 1rem center;
        padding-right: 2.5rem !important;
    }
    
    /* File input styling */
    input[type="file"]::file-selector-button {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: 12px;
        padding: 0.5rem 1rem;
        color: var(--white);
        cursor: pointer;
        transition: all 0.2s ease;
    }
    
    input[type="file"]::file-selector-button:hover {
        background: rgba(255, 255, 255, 0.1);
    }
</style>
@endpush

@section('content')
<div class="blog-form-shell">
    <div class="blog-form-card card anim">
        <h1>{{ isset($post->id) ? '✏️ Modifier l’article' : '✨ Nouvel article' }}</h1>

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
                <label for="title" class="required">📝 Titre</label>
                <input id="title" type="text" name="title" value="{{ old('title', $post->title) }}" placeholder="Titre accrocheur pour votre article" required>
            </div>

            <div class="blog-form-group">
                <label for="excerpt" class="required">📌 Accroche</label>
                <input id="excerpt" type="text" name="excerpt" value="{{ old('excerpt', $post->excerpt) }}" placeholder="Un court résumé qui donne envie de lire la suite" required>
            </div>

            <div class="blog-form-group">
                <label for="category" class="required">📂 Catégorie</label>
                <select id="category" name="category" required>
                    @foreach($categories as $key => $label)
                        <option value="{{ $key }}"{{ old('category', $post->category) === $key ? ' selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
            </div>

            <div class="blog-form-group">
                <label for="body" class="required">📄 Contenu</label>
                <textarea id="body" name="body" rows="10" placeholder="Rédigez votre article ici..." required>{{ old('body', $post->body) }}</textarea>
            </div>

            <div class="blog-form-group">
                <label for="cover_image">🖼️ Image de couverture</label>
                <input id="cover_image" type="file" name="cover_image" accept="image/*">
                <p class="blog-form-note">Formats acceptés : JPG, PNG, GIF. Taille max : 2MB</p>
                @if($post->cover_image_path)
                    <img src="{{ asset('storage/' . $post->cover_image_path) }}" alt="Cover image" class="blog-form-cover">
                @endif
            </div>

            <div class="blog-form-group">
                <label for="status" class="required">🔘 Statut</label>
                <select id="status" name="status" required>
                    <option value="draft"{{ old('status', $post->status) === 'draft' ? ' selected' : '' }}>📝 Brouillon</option>
                    <option value="published"{{ old('status', $post->status) === 'published' ? ' selected' : '' }}>🌍 Publié</option>
                </select>
                <p class="blog-form-note">💡 Les articles publiés seront visibles depuis le tableau de bord et la page de blog.</p>
            </div>

            <div class="blog-form-actions">
                <a href="{{ route('dashboard.blog.index') }}" class="btn btn-secondary">
                    ← Retour au blog
                </a>
                <button type="submit" class="btn btn-create-post">
                    {{ $post->exists ? '💾 Enregistrer les modifications' : '🚀 Publier l’article' }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection