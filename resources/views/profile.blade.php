@extends('layouts.app')

@section('title', __('sidebar.my_profile'))
@section('page-title', __('sidebar.my_profile'))

@section('content')
@php
    $nameParts = preg_split('/\s+/', trim(auth()->user()->name ?? ''), 2);
    $firstName = old('first_name', $nameParts[0] ?? '');
    $lastName = old('last_name', $nameParts[1] ?? '');
    $initial = strtoupper(substr($firstName ?: 'U', 0, 1));
    $user = auth()->user();
@endphp

<style>
    .profile-header {
        background: linear-gradient(135deg, rgba(55,138,221,0.15), rgba(56,189,248,0.1));
        border: 1px solid rgba(55,138,221,0.2);
        border-radius: 18px;
        padding: 2.5rem;
        margin-bottom: 2rem;
        display: grid; 
        grid-template-columns: auto 1fr auto;
        gap: 2rem; 
        align-items: center;
    }

    .profile-avatar {
        width: 120px; 
        height: 120px;
        border-radius: 50%;
        background: linear-gradient(135deg, #2478c8, #38bdf8);
        display: flex; 
        align-items: center; 
        justify-content: center;
        overflow: hidden;
        border: 4px solid rgba(55,138,221,0.3);
        flex-shrink: 0;
    }

    .profile-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .avatar-placeholder {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #2478c8, #38bdf8);
        color: white;
        font-size: 48px;
        font-weight: bold;
    }

    .profile-info h1 {
        font-family: 'Syne', sans-serif;
        font-size: 1.8rem; 
        font-weight: 700;
        margin-bottom: 0.5rem;
    }

    .profile-info p {
        color: #9ca3af;
        font-size: 0.95rem;
        margin-bottom: 0.3rem;
    }

    .profile-actions {
        display: flex; 
        gap: 1rem;
        flex-wrap: wrap;
    }

    .alert {
        border-radius: 10px;
        padding: 0.75rem 1rem;
        margin-bottom: 1rem;
        font-size: 0.9rem;
    }

    .alert-success {
        background: rgba(34,197,94,0.12);
        color: #4ade80;
        border: 1px solid rgba(34,197,94,0.22);
    }

    .alert-danger {
        background: rgba(248,113,113,0.12);
        color: #fca5a5;
        border: 1px solid rgba(248,113,113,0.22);
    }

    .btn {
        padding: 0.75rem 1.5rem;
        border-radius: 10px;
        border: none;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
        font-family: inherit;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-primary {
        background: linear-gradient(135deg, #2478c8, #378add);
        color: white;
        box-shadow: 0 6px 18px rgba(55,138,221,0.35);
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 28px rgba(55,138,221,0.4);
    }

    .btn-secondary {
        background: rgba(255,255,255,0.08);
        color: #b5d4f4;
        border: 1px solid rgba(55,138,221,0.2);
    }

    .btn-secondary:hover {
        background: rgba(55,138,221,0.15);
        border-color: rgba(55,138,221,0.3);
    }

    .profile-grid {
        display: grid; 
        grid-template-columns: 1fr 1fr;
        gap: 2rem;
    }

    .profile-section {
        background: rgba(255,255,255,0.03);
        border: 1px solid rgba(55,138,221,0.14);
        border-radius: 18px;
        padding: 2rem;
    }

    .section-title {
        font-family: 'Syne', sans-serif;
        font-size: 1.1rem; 
        font-weight: 700;
        margin-bottom: 1.5rem;
        color: #ffffff;
    }

    .info-row {
        display: flex; 
        justify-content: space-between;
        padding: 1rem 0;
        border-bottom: 1px solid rgba(55,138,221,0.1);
    }

    .info-row:last-child {
        border-bottom: none;
    }

    .info-label {
        color: #9ca3af;
        font-size: 0.9rem;
    }

    .info-value {
        color: #ffffff;
        font-weight: 600;
        font-size: 0.9rem;
    }

    .pill {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 1rem;
        border-radius: 99px;
        font-size: 0.85rem;
        font-weight: 600;
        background: rgba(34,197,94,0.12);
        color: #4ade80;
        border: 1px solid rgba(34,197,94,0.2);
    }

    .pill.secondary {
        background: rgba(55,138,221,0.15);
        color: #93c5fd;
        border: 1px solid rgba(55,138,221,0.2);
    }

    .edit-profile-card {
        background: rgba(255,255,255,0.03);
        border: 1px solid rgba(55,138,221,0.14);
        border-radius: 18px;
        padding: 2rem;
        margin-bottom: 2rem;
        display: none;
    }

    .edit-profile-card.open {
        display: block;
    }

    .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
    }

    .form-group {
        margin-bottom: 1rem;
    }

    .form-group label {
        display: block;
        margin-bottom: 0.45rem;
        color: #ffffff;
        font-weight: 600;
        font-size: 0.9rem;
    }

    .form-input {
        width: 100%;
        padding: 0.75rem 1rem;
        background: rgba(1,34,68,0.8);
        border: 1px solid rgba(55,138,221,0.2);
        border-radius: 10px;
        color: #ffffff;
        font-family: inherit;
        font-size: 0.9rem;
        transition: all 0.2s;
    }

    .form-input:focus {
        outline: none;
        border-color: #38bdf8;
        box-shadow: 0 0 0 3px rgba(56,189,248,0.1);
    }

    .field-error {
        color: #fca5a5;
        font-size: 0.82rem;
        margin-top: 0.35rem;
        display: block;
    }

    .input-help {
        color: #9ca3af;
        font-size: 0.8rem;
        margin-top: 0.4rem;
    }

    .activity-item {
        display: flex;
        gap: 1rem;
        padding: 1rem 0;
        border-bottom: 1px solid rgba(55,138,221,0.1);
    }

    .activity-item:last-child {
        border-bottom: none;
    }

    .activity-icon {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        background: rgba(55,138,221,0.15);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        flex-shrink: 0;
    }

    .activity-content {
        flex: 1;
    }

    .activity-title {
        color: #ffffff;
        font-weight: 600;
        font-size: 0.9rem;
        margin-bottom: 0.2rem;
    }

    .activity-time {
        color: #9ca3af;
        font-size: 0.8rem;
    }

    .current-photo-preview {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-top: 0.5rem;
        padding: 0.75rem;
        background: rgba(255,255,255,0.05);
        border-radius: 10px;
    }

    .current-photo-preview img {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        object-fit: cover;
    }

    .current-photo-preview span {
        color: var(--muted);
        font-size: 0.85rem;
    }

    @keyframes slideInUp {
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
        animation: slideInUp 0.4s ease-out forwards;
    }

    .anim-d1 { animation-delay: 0.1s; opacity: 0; animation-fill-mode: forwards; }
    .anim-d2 { animation-delay: 0.2s; opacity: 0; animation-fill-mode: forwards; }
    .anim-d3 { animation-delay: 0.3s; opacity: 0; animation-fill-mode: forwards; }
    .anim-d4 { animation-delay: 0.4s; opacity: 0; animation-fill-mode: forwards; }

    @media (max-width: 900px) {
        .profile-header {
            grid-template-columns: 1fr;
            text-align: center;
        }
        .profile-grid {
            grid-template-columns: 1fr;
        }
        .form-grid {
            grid-template-columns: 1fr;
        }
        .profile-actions {
            justify-content: center;
        }
    }
</style>

@if(session('success'))
    <div class="alert alert-success anim">{{ session('success') }}</div>
@endif

@if($errors->any())
    <div class="alert alert-danger anim">Please review the highlighted fields.</div>
@endif

<!-- Profile Header -->
<div class="profile-header anim">
    <div class="profile-avatar">
        @php $user = auth()->user(); @endphp

        <img src="{{ $user->profile_photo_url_with_fallback }}" alt="{{ $user->name }} profile photo">
    </div>

    <div class="profile-info">
        <h1>{{ auth()->user()->name }}</h1>
        <p>{{ auth()->user()->email }}</p>
        <p style="font-size: 0.85rem; margin-top: 0.5rem;">
            <span class="pill">{{ ucfirst(auth()->user()->role) }}</span>
        </p>
    </div>

    <div class="profile-actions">
        <button type="button" class="btn btn-primary" onclick="toggleProfileEdit()">✏️ {{ __('messages.edit_profile') }}</button>
        <a href="{{ route('settings', ['tab' => 'security']) }}" class="btn btn-secondary" style="text-decoration: none; display: inline-flex; align-items: center;">🔒 {{ __('messages.change_password') }}</a>
    </div>
</div>

<div id="editProfileCard" class="edit-profile-card anim anim-d1 {{ $errors->has('first_name') || $errors->has('last_name') || $errors->has('email') || $errors->has('profile_photo') || $errors->any() ? 'open' : '' }}">
    <div class="section-title">✏️ {{ __('messages.edit_profile') }}</div>
    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <input type="hidden" name="source" value="profile">

        <div class="form-group">
            <label for="profile_photo">🖼️ Profile Photo</label>
            <input id="profile_photo" name="profile_photo" type="file" class="form-input" accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp" onchange="previewPhoto(this)">
            <div class="input-help">Allowed formats: JPG, PNG, WEBP. Max size: 2MB.</div>
            @error('profile_photo')<span class="field-error">{{ $message }}</span>@enderror
            
            @if(!empty(auth()->user()->profile_photo_path))
            @if($user->profile_photo_url)
                <div class="current-photo-preview" id="currentPhotoPreview">
                    <img src="{{ asset('storage/' . auth()->user()->profile_photo_path) }}" alt="Current profile photo">
                    <img src="{{ $user->profile_photo_url }}" alt="Current profile photo">
                    <span>Current photo</span>
                </div>
            @endif
            <div id="newPhotoPreview" style="display: none; margin-top: 0.5rem;"></div>
            @endif
        </div>

        <div class="form-grid">
            <div class="form-group">
                <label for="first_name">{{ __('forms.first_name') }}</label>
                <input id="first_name" name="first_name" type="text" class="form-input" value="{{ $firstName }}" required>
                <input id="first_name" name="first_name" type="text" class="form-input" value="{{ old('first_name', explode(' ', $user->name)[0] ?? '') }}" required>
                @error('first_name')<span class="field-error">{{ $message }}</span>@enderror
            </div>

            <div class="form-group">
                <label for="last_name">{{ __('forms.last_name') }}</label>
                <input id="last_name" name="last_name" type="text" class="form-input" value="{{ $lastName }}" required>
                <input id="last_name" name="last_name" type="text" class="form-input" value="{{ old('last_name', explode(' ', $user->name, 2)[1] ?? '') }}" required>
                @error('last_name')<span class="field-error">{{ $message }}</span>@enderror
            </div>
        </div>

        <div class="form-group">
            <label for="email">{{ __('forms.email') }}</label>
            <input id="email" name="email" type="email" class="form-input" value="{{ old('email', auth()->user()->email) }}" required>
            @error('email')<span class="field-error">{{ $message }}</span>@enderror
        </div>

        <div class="profile-actions" style="margin-top: 1rem;">
            <button type="submit" class="btn btn-primary">💾 {{ __('messages.update_profile') }}</button>
            <button type="button" class="btn btn-secondary" onclick="toggleProfileEdit(false)">❌ {{ __('messages.cancel') }}</button>
        </div>
    </form>
</div>

<!-- Profile Content Grid -->
<div class="profile-grid">
    <!-- Personal Information -->
    <div class="profile-section anim anim-d1">
        <div class="section-title">📋 {{ __('dashboard.personal_information') }}</div>

        <div class="info-row">
            <span class="info-label">{{ __('dashboard.full_name') }}</span>
            <span class="info-value">{{ auth()->user()->name }}</span>
        </div>

        <div class="info-row">
            <span class="info-label">{{ __('dashboard.email') }}</span>
            <span class="info-value">{{ auth()->user()->email }}</span>
        </div>

        <div class="info-row">
            <span class="info-label">{{ __('dashboard.role') }}</span>
            <span class="info-value">{{ ucfirst(auth()->user()->role) }}</span>
        </div>

        <div class="info-row">
            <span class="info-label">{{ __('dashboard.member_since') }}</span>
            <span class="info-value">{{ auth()->user()->created_at->format('M d, Y') }}</span>
        </div>

        <div class="info-row">
            <span class="info-label">{{ __('dashboard.status') }}</span>
            <span class="pill">✅ {{ __('sidebar.active') }}</span>
        </div>
    </div>

    <!-- Statistics -->
    <div class="profile-section anim anim-d2">
        <div class="section-title">📊 {{ __('dashboard.statistics') }}</div>

        <div class="info-row">
            <span class="info-label">{{ __('dashboard.total_courses') }}</span>
            <span class="info-value">12</span>
        </div>

        <div class="info-row">
            <span class="info-label">{{ __('dashboard.completed') }}</span>
            <span class="info-value">8</span>
        </div>

        <div class="info-row">
            <span class="info-label">{{ __('dashboard.in_progress') }}</span>
            <span class="info-value">4</span>
        </div>

        <div class="info-row">
            <span class="info-label">{{ __('dashboard.certificates') }}</span>
            <span class="info-value">6</span>
        </div>

        <div class="info-row">
            <span class="info-label">{{ __('dashboard.learning_streak') }}</span>
            <span class="info-value">15 days 🔥</span>
        </div>
    </div>

    <!-- Account Preferences -->
    <div class="profile-section anim anim-d3">
        <div class="section-title">⚙️ {{ __('dashboard.preferences') }}</div>

        <div class="info-row">
            <span class="info-label">{{ __('dashboard.email_notifications') }}</span>
            <span class="pill secondary">✅ {{ __('dashboard.enabled') }}</span>
        </div>

        <div class="info-row">
            <span class="info-label">{{ __('dashboard.dark_mode') }}</span>
            <span class="pill secondary">🌙 {{ __('dashboard.enabled') }}</span>
        </div>

        <div class="info-row">
            <span class="info-label">{{ __('dashboard.two_factor_auth') }}</span>
            <span class="pill secondary">❌ {{ __('dashboard.disabled') }}</span>
        </div>

        <div class="info-row">
            <span class="info-label">{{ __('dashboard.marketing_emails') }}</span>
            <span class="pill secondary">❌ {{ __('dashboard.disabled') }}</span>
        </div>

        <div style="margin-top: 1.5rem;">
            <button class="btn btn-secondary" style="width: 100%;">⚙️ {{ __('dashboard.manage_preferences') }}</button>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="profile-section anim anim-d4">
        <div class="section-title">🔄 {{ __('dashboard.recent_activity') }}</div>

        <div class="activity-item">
            <div class="activity-icon">📚</div>
            <div class="activity-content">
                <div class="activity-title">{{ __('dashboard.completed_course') }}</div>
                <div class="activity-time">2 {{ __('dashboard.days_ago') }}</div>
            </div>
        </div>

        <div class="activity-item">
            <div class="activity-icon">🏆</div>
            <div class="activity-content">
                <div class="activity-title">{{ __('dashboard.earned_certificate') }}</div>
                <div class="activity-time">1 {{ __('dashboard.week_ago') }}</div>
            </div>
        </div>

        <div class="activity-item">
            <div class="activity-icon">💬</div>
            <div class="activity-content">
                <div class="activity-title">{{ __('dashboard.commented') }}</div>
                <div class="activity-time">2 {{ __('dashboard.weeks_ago') }}</div>
            </div>
        </div>

        <div class="activity-item">
            <div class="activity-icon">✅</div>
            <div class="activity-content">
                <div class="activity-title">{{ __('dashboard.started_course') }}</div>
                <div class="activity-time">3 {{ __('dashboard.weeks_ago') }}</div>
            </div>
        </div>
    </div>
</div>

<script>
function toggleProfileEdit(forceOpen) {
    const card = document.getElementById('editProfileCard');
    if (typeof forceOpen === 'boolean') {
        if (forceOpen) {
            card.classList.add('open');
        } else {
            card.classList.remove('open');
        }
        return;
    }
    card.classList.toggle('open');
}

function previewPhoto(input) {
    const previewDiv = document.getElementById('newPhotoPreview');
    const currentPreview = document.getElementById('currentPhotoPreview');
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            previewDiv.innerHTML = `
                <div class="current-photo-preview">
                    <img src="${e.target.result}" alt="New photo preview">
                    <span>New photo preview</span>
                </div>
            `;
            previewDiv.style.display = 'block';
            if (currentPreview) currentPreview.style.opacity = '0.5';
        }
        
        reader.readAsDataURL(input.files[0]);
    } else {
        previewDiv.style.display = 'none';
        if (currentPreview) currentPreview.style.opacity = '1';
    }
}

// Keep the edit card open if there are validation errors
@if($errors->any())
    document.addEventListener('DOMContentLoaded', function() {
        const editCard = document.getElementById('editProfileCard');
        if (editCard && !editCard.classList.contains('open')) {
            editCard.classList.add('open');
        }
    });
    @endif
</script>

@endsection