@extends('layouts.app')

@section('title', 'My Profile')
@section('page-title', 'My Profile')

@section('content')
<style>
    .profile-header {
        background: linear-gradient(135deg, rgba(55,138,221,0.15), rgba(56,189,248,0.1));
        border: 1px solid rgba(55,138,221,0.2);
        border-radius: 18px;
        padding: 2.5rem;
        margin-bottom: 2rem;
        display: grid; grid-template-columns: auto 1fr auto;
        gap: 2rem; align-items: center;
    }

    .profile-avatar {
        width: 120px; height: 120px;
        border-radius: 50%;
        background: linear-gradient(135deg, #2478c8, #38bdf8);
        display: flex; align-items: center; justify-content: center;
        font-size: 3rem; font-weight: 700;
        border: 4px solid rgba(55,138,221,0.3);
        flex-shrink: 0;
    }

    .profile-info h1 {
        font-family: 'Syne', sans-serif;
        font-size: 1.8rem; font-weight: 700;
        margin-bottom: 0.5rem;
    }

    .profile-info p {
        color: #9ca3af;
        font-size: 0.95rem;
        margin-bottom: 0.3rem;
    }

    .profile-actions {
        display: flex; gap: 1rem;
    }

    .btn {
        padding: 0.75rem 1.5rem;
        border-radius: 10px;
        border: none;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
        font-family: inherit;
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
        display: grid; grid-template-columns: 1fr 1fr;
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
        font-size: 1.1rem; font-weight: 700;
        margin-bottom: 1.5rem;
        color: #ffffff;
    }

    .info-row {
        display: flex; justify-content: space-between;
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

    @media (max-width: 900px) {
        .profile-header {
            grid-template-columns: 1fr;
            text-align: center;
        }
        .profile-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<!-- Profile Header -->
<div class="profile-header anim">
    <div class="profile-avatar">{{ strtoupper(substr(auth()->user()->first_name ?? 'U', 0, 1)) }}</div>

    <div class="profile-info">
        <h1>{{ auth()->user()->name }}</h1>
        <p>{{ auth()->user()->email }}</p>
        <p style="font-size: 0.85rem; margin-top: 0.5rem;">
            <span class="pill">{{ ucfirst(auth()->user()->role) }}</span>
        </p>
    </div>

    <div class="profile-actions">
        <button class="btn btn-primary">Edit Profile</button>
        <button class="btn btn-secondary">Change Password</button>
    </div>
</div>

<!-- Profile Content Grid -->
<div class="profile-grid">
    <!-- Personal Information -->
    <div class="profile-section anim anim-d1">
        <div class="section-title">Personal Information</div>

        <div class="info-row">
            <span class="info-label">Full Name</span>
            <span class="info-value">{{ auth()->user()->name }}</span>
        </div>

        <div class="info-row">
            <span class="info-label">Email</span>
            <span class="info-value">{{ auth()->user()->email }}</span>
        </div>

        <div class="info-row">
            <span class="info-label">Role</span>
            <span class="info-value">{{ ucfirst(auth()->user()->role) }}</span>
        </div>

        <div class="info-row">
            <span class="info-label">Member Since</span>
            <span class="info-value">{{ auth()->user()->created_at->format('M d, Y') }}</span>
        </div>

        <div class="info-row">
            <span class="info-label">Status</span>
            <span class="pill">Active</span>
        </div>
    </div>

    <!-- Statistics -->
    <div class="profile-section anim anim-d2">
        <div class="section-title">Statistics</div>

        <div class="info-row">
            <span class="info-label">Total Courses</span>
            <span class="info-value">12</span>
        </div>

        <div class="info-row">
            <span class="info-label">Completed</span>
            <span class="info-value">8</span>
        </div>

        <div class="info-row">
            <span class="info-label">In Progress</span>
            <span class="info-value">4</span>
        </div>

        <div class="info-row">
            <span class="info-label">Certificates</span>
            <span class="info-value">6</span>
        </div>

        <div class="info-row">
            <span class="info-label">Learning Streak</span>
            <span class="info-value">15 days 🔥</span>
        </div>
    </div>

    <!-- Account Preferences -->
    <div class="profile-section anim anim-d3">
        <div class="section-title">Preferences</div>

        <div class="info-row">
            <span class="info-label">Email Notifications</span>
            <span class="pill secondary">Enabled</span>
        </div>

        <div class="info-row">
            <span class="info-label">Dark Mode</span>
            <span class="pill secondary">Enabled</span>
        </div>

        <div class="info-row">
            <span class="info-label">Two-Factor Auth</span>
            <span class="pill secondary">Disabled</span>
        </div>

        <div class="info-row">
            <span class="info-label">Marketing Emails</span>
            <span class="pill secondary">Disabled</span>
        </div>

        <div style="margin-top: 1.5rem;">
            <button class="btn btn-secondary" style="width: 100%;">Manage Preferences</button>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="profile-section anim anim-d4">
        <div class="section-title">Recent Activity</div>

        <div class="activity-item">
            <div class="activity-icon">📚</div>
            <div class="activity-content">
                <div class="activity-title">Completed a course</div>
                <div class="activity-time">2 days ago</div>
            </div>
        </div>

        <div class="activity-item">
            <div class="activity-icon">🏆</div>
            <div class="activity-content">
                <div class="activity-title">Earned a certificate</div>
                <div class="activity-time">1 week ago</div>
            </div>
        </div>

        <div class="activity-item">
            <div class="activity-icon">💬</div>
            <div class="activity-content">
                <div class="activity-title">Commented on a discussion</div>
                <div class="activity-time">2 weeks ago</div>
            </div>
        </div>

        <div class="activity-item">
            <div class="activity-icon">✅</div>
            <div class="activity-content">
                <div class="activity-title">Started a new course</div>
                <div class="activity-time">3 weeks ago</div>
            </div>
        </div>
    </div>
</div>

@endsection
