@extends('layouts.app')

@section('title', 'Settings')
@section('page-title', 'Settings')

@section('content')
<style>
    .settings-container {
        max-width: 900px;
    }

    .settings-header {
        margin-bottom: 2rem;
    }

    .settings-header h1 {
        font-family: 'Syne', sans-serif;
        font-size: 1.8rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }

    .settings-header p {
        color: #9ca3af;
        font-size: 0.95rem;
    }

    .settings-grid {
        display: grid;
        grid-template-columns: 260px 1fr;
        gap: 2rem;
        margin-top: 2rem;
    }

    .settings-sidebar {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
    }

    .settings-nav-item {
        padding: 0.75rem 1rem;
        border-radius: 10px;
        color: #9ca3af;
        text-decoration: none;
        font-weight: 500;
        transition: all 0.2s;
        border-left: 3px solid transparent;
        cursor: pointer;
    }

    .settings-nav-item:hover {
        background: rgba(55,138,221,0.08);
        color: #b5d4f4;
    }

    .settings-nav-item.active {
        background: rgba(55,138,221,0.15);
        color: #ffffff;
        border-left-color: #38bdf8;
    }

    .settings-content {
        display: none;
    }

    .settings-content.active {
        display: block;
    }

    .settings-section {
        background: rgba(255,255,255,0.03);
        border: 1px solid rgba(55,138,221,0.14);
        border-radius: 18px;
        padding: 2rem;
        margin-bottom: 2rem;
    }

    .settings-section-title {
        font-family: 'Syne', sans-serif;
        font-size: 1.1rem;
        font-weight: 700;
        margin-bottom: 1.5rem;
        color: #ffffff;
    }

    .settings-section-desc {
        color: #9ca3af;
        font-size: 0.9rem;
        margin-bottom: 1.5rem;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-label {
        display: block;
        color: #ffffff;
        font-weight: 600;
        margin-bottom: 0.5rem;
        font-size: 0.9rem;
    }

    .form-input,
    .form-select {
        width: 100%;
        padding: 0.75rem 1rem;
        background: rgba(1,34,68,0.8);
        border: 1px solid rgba(55,138,221,0.2);
        border-radius: 10px;
        color: #ffffff;
        font-family: inherit;
        font-size: 0.9rem;
        transition: border-color 0.2s;
    }

    .form-input:focus,
    .form-select:focus {
        outline: none;
        border-color: #38bdf8;
        box-shadow: 0 0 0 3px rgba(56,189,248,0.1);
    }

    .form-desc {
        color: #9ca3af;
        font-size: 0.8rem;
        margin-top: 0.4rem;
    }

    .toggle-switch {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .switch {
        position: relative;
        display: inline-block;
        width: 50px;
        height: 28px;
    }

    .switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: rgba(55,138,221,0.2);
        transition: 0.3s;
        border-radius: 34px;
        border: 1px solid rgba(55,138,221,0.3);
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 20px;
        width: 20px;
        left: 4px;
        bottom: 4px;
        background-color: #ffffff;
        transition: 0.3s;
        border-radius: 50%;
    }

    input:checked + .slider {
        background-color: #38bdf8;
        border-color: #38bdf8;
    }

    input:checked + .slider:before {
        transform: translateX(22px);
    }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
    }

    .btn {
        padding: 0.75rem 1.5rem;
        border-radius: 10px;
        border: none;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
        font-family: inherit;
        font-size: 0.9rem;
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

    .btn-danger {
        background: rgba(248,113,113,0.15);
        color: #f87171;
        border: 1px solid rgba(248,113,113,0.3);
    }

    .btn-danger:hover {
        background: rgba(248,113,113,0.25);
        border-color: rgba(248,113,113,0.5);
    }

    .button-group {
        display: flex;
        gap: 1rem;
    }

    .divider {
        height: 1px;
        background: rgba(55,138,221,0.1);
        margin: 2rem 0;
    }

    .danger-zone {
        background: rgba(248,113,113,0.08);
        border: 1px solid rgba(248,113,113,0.2);
        border-radius: 18px;
        padding: 2rem;
        margin-top: 2rem;
    }

    .danger-zone-title {
        font-family: 'Syne', sans-serif;
        font-size: 1.1rem;
        font-weight: 700;
        color: #f87171;
        margin-bottom: 0.5rem;
    }

    .danger-zone-desc {
        color: #9ca3af;
        font-size: 0.9rem;
        margin-bottom: 1.5rem;
    }

    @media (max-width: 900px) {
        .settings-grid {
            grid-template-columns: 1fr;
        }
        .settings-sidebar {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
            gap: 0.5rem;
            margin-bottom: 1rem;
        }
        .form-row {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="settings-container">
    <!-- Settings Header -->
    <div class="settings-header anim">
        <h1>Settings</h1>
        <p>Manage your account preferences and application settings</p>
    </div>

    <!-- Settings Layout -->
    <div class="settings-grid">
        <!-- Sidebar Navigation -->
        <div class="settings-sidebar anim anim-d1">
            <button class="settings-nav-item active" onclick="switchTab('general')">⚙️ General</button>
            <button class="settings-nav-item" onclick="switchTab('account')">👤 Account</button>
            <button class="settings-nav-item" onclick="switchTab('notifications')">🔔 Notifications</button>
            <button class="settings-nav-item" onclick="switchTab('privacy')">🔒 Privacy</button>
            <button class="settings-nav-item" onclick="switchTab('security')">🛡️ Security</button>
        </div>

        <!-- Content Area -->
        <div>
            <!-- General Settings -->
            <div id="general" class="settings-content active anim anim-d2">
                <div class="settings-section">
                    <div class="settings-section-title">Display Preferences</div>

                    <div class="form-group">
                        <label class="form-label">Theme</label>
                        <select class="form-select">
                            <option>Dark Mode (Current)</option>
                            <option>Light Mode</option>
                            <option>System Default</option>
                        </select>
                        <div class="form-desc">Choose your preferred appearance</div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Language</label>
                        <select class="form-select">
                            <option>English (US)</option>
                            <option>French (FR)</option>
                            <option>Spanish (ES)</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Timezone</label>
                        <select class="form-select">
                            <option>UTC-8 (Pacific Time)</option>
                            <option>UTC-5 (Eastern Time)</option>
                            <option>UTC (GMT)</option>
                        </select>
                    </div>
                </div>

                <div class="settings-section">
                    <div class="settings-section-title">Sidebar Behavior</div>

                    <div class="form-group">
                        <div class="toggle-switch">
                            <label class="switch">
                                <input type="checkbox" checked>
                                <span class="slider"></span>
                            </label>
                            <span>Auto-collapse sidebar on smaller screens</span>
                        </div>
                        <div class="form-desc" style="margin-top: 0.75rem;">Automatically collapse the sidebar on mobile devices</div>
                    </div>

                    <div class="divider"></div>

                    <button class="btn btn-primary">Save Changes</button>
                </div>
            </div>

            <!-- Account Settings -->
            <div id="account" class="settings-content anim anim-d2">
                <div class="settings-section">
                    <div class="settings-section-title">Profile Information</div>
                    <div class="settings-section-desc">Update your personal details</div>

                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">First Name</label>
                            <input type="text" class="form-input" value="{{ auth()->user()->first_name ?? '' }}" placeholder="First name">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Last Name</label>
                            <input type="text" class="form-input" value="{{ explode(' ', auth()->user()->name)[1] ?? '' }}" placeholder="Last name">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Email Address</label>
                        <input type="email" class="form-input" value="{{ auth()->user()->email }}" placeholder="your@email.com">
                    </div>

                    <div class="divider"></div>
                    <button class="btn btn-primary">Update Profile</button>
                </div>

                <div class="settings-section">
                    <div class="settings-section-title">Email Preferences</div>

                    <div class="form-group">
                        <div class="toggle-switch">
                            <label class="switch">
                                <input type="checkbox" checked>
                                <span class="slider"></span>
                            </label>
                            <span>Receive course updates</span>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="toggle-switch">
                            <label class="switch">
                                <input type="checkbox" checked>
                                <span class="slider"></span>
                            </label>
                            <span>Receive weekly digest</span>
                        </div>
                    </div>

                    <div class="divider"></div>
                    <button class="btn btn-primary">Save Preferences</button>
                </div>
            </div>

            <!-- Notifications -->
            <div id="notifications" class="settings-content anim anim-d2">
                <div class="settings-section">
                    <div class="settings-section-title">Notification Channels</div>

                    <div class="form-group">
                        <div class="toggle-switch">
                            <label class="switch">
                                <input type="checkbox" checked>
                                <span class="slider"></span>
                            </label>
                            <span>Email Notifications</span>
                        </div>
                        <div class="form-desc" style="margin-top: 0.75rem;">Receive important updates via email</div>
                    </div>

                    <div class="form-group">
                        <div class="toggle-switch">
                            <label class="switch">
                                <input type="checkbox" checked>
                                <span class="slider"></span>
                            </label>
                            <span>In-app Notifications</span>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="toggle-switch">
                            <label class="switch">
                                <input type="checkbox">
                                <span class="slider"></span>
                            </label>
                            <span>Push Notifications</span>
                        </div>
                    </div>
                </div>

                <div class="settings-section">
                    <div class="settings-section-title">Notification Types</div>

                    <div class="form-group">
                        <div class="toggle-switch">
                            <label class="switch">
                                <input type="checkbox" checked>
                                <span class="slider"></span>
                            </label>
                            <span>Course Reminders</span>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="toggle-switch">
                            <label class="switch">
                                <input type="checkbox" checked>
                                <span class="slider"></span>
                            </label>
                            <span>New Messages</span>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="toggle-switch">
                            <label class="switch">
                                <input type="checkbox">
                                <span class="slider"></span>
                            </label>
                            <span>Marketing Updates</span>
                        </div>
                    </div>

                    <div class="divider"></div>
                    <button class="btn btn-primary">Save Notification Settings</button>
                </div>
            </div>

            <!-- Privacy Settings -->
            <div id="privacy" class="settings-content anim anim-d2">
                <div class="settings-section">
                    <div class="settings-section-title">Profile Privacy</div>

                    <div class="form-group">
                        <label class="form-label">Profile Visibility</label>
                        <select class="form-select">
                            <option>Public</option>
                            <option>Private</option>
                            <option>Friends Only</option>
                        </select>
                        <div class="form-desc">Control who can see your profile</div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Show My Courses</label>
                        <select class="form-select">
                            <option>Everyone</option>
                            <option>Logged in users</option>
                            <option>Nobody</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <div class="toggle-switch">
                            <label class="switch">
                                <input type="checkbox" checked>
                                <span class="slider"></span>
                            </label>
                            <span>Allow others to message me</span>
                        </div>
                    </div>

                    <div class="divider"></div>
                    <button class="btn btn-primary">Update Privacy Settings</button>
                </div>

                <div class="settings-section">
                    <div class="settings-section-title">Data & Cookies</div>

                    <div class="form-group">
                        <div class="toggle-switch">
                            <label class="switch">
                                <input type="checkbox">
                                <span class="slider"></span>
                            </label>
                            <span>Allow analytics tracking</span>
                        </div>
                        <div class="form-desc" style="margin-top: 0.75rem;">Help us improve by sharing anonymous usage data</div>
                    </div>

                    <div class="divider"></div>
                    <button class="btn btn-secondary">Download My Data</button>
                </div>
            </div>

            <!-- Security Settings -->
            <div id="security" class="settings-content anim anim-d2">
                <div class="settings-section">
                    <div class="settings-section-title">Password & Security</div>

                    <div class="form-group">
                        <label class="form-label">Current Password</label>
                        <input type="password" class="form-input" placeholder="Enter current password">
                    </div>

                    <div class="form-group">
                        <label class="form-label">New Password</label>
                        <input type="password" class="form-input" placeholder="Enter new password">
                    </div>

                    <div class="form-group">
                        <label class="form-label">Confirm Password</label>
                        <input type="password" class="form-input" placeholder="Confirm new password">
                    </div>

                    <div class="divider"></div>
                    <button class="btn btn-primary">Change Password</button>
                </div>

                <div class="settings-section">
                    <div class="settings-section-title">Two-Factor Authentication</div>
                    <div class="settings-section-desc">Add an extra layer of security to your account</div>

                    <div class="form-group">
                        <div class="toggle-switch">
                            <label class="switch">
                                <input type="checkbox">
                                <span class="slider"></span>
                            </label>
                            <span>Enable 2FA</span>
                        </div>
                        <div class="form-desc" style="margin-top: 0.75rem;">Requires authentication via authenticator app</div>
                    </div>

                    <div class="divider"></div>
                    <button class="btn btn-secondary">Setup 2FA</button>
                </div>

                <div class="settings-section">
                    <div class="settings-section-title">Active Sessions</div>

                    <div class="form-group">
                        <p style="color: #9ca3af; margin-bottom: 1rem;">You are currently logged in on 1 device</p>
                        <button class="btn btn-secondary">Logout from other devices</button>
                    </div>
                </div>

                <div class="danger-zone">
                    <div class="danger-zone-title">Danger Zone</div>
                    <div class="danger-zone-desc">These actions cannot be undone. Please proceed with caution.</div>
                    <button class="btn btn-danger">Delete My Account</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function switchTab(tabId) {
    // Hide all content
    const allContent = document.querySelectorAll('.settings-content');
    allContent.forEach(content => content.classList.remove('active'));

    // Remove active class from all nav items
    const allNavItems = document.querySelectorAll('.settings-nav-item');
    allNavItems.forEach(item => item.classList.remove('active'));

    // Show selected content
    document.getElementById(tabId).classList.add('active');

    // Add active class to clicked nav item
    event.target.classList.add('active');
}
</script>

@endsection
