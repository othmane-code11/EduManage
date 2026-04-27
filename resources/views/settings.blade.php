@extends('layouts.app')

@section('title', __('sidebar.settings'))
@section('page-title', __('sidebar.settings'))

@section('content')
@php
    $settingsNameParts = preg_split('/\s+/', trim(auth()->user()->name ?? ''), 2);
    $settingsFirstName = old('first_name', $settingsNameParts[0] ?? '');
    $settingsLastName = old('last_name', $settingsNameParts[1] ?? '');
@endphp
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

    .field-error {
        color: #fca5a5;
        font-size: 0.82rem;
        margin-top: 0.35rem;
        display: block;
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
    @if(session('success'))
        <div class="alert alert-success anim">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger anim">Please review the highlighted fields.</div>
    @endif

    <!-- Settings Header -->
    <div class="settings-header anim">
        <h1>{{ __('sidebar.settings') }}</h1>
        <p>{{ __('forms.manage_settings_desc') }}</p>
    </div>

    <!-- Settings Layout -->
    <div class="settings-grid">
        <!-- Sidebar Navigation -->
        <div class="settings-sidebar anim anim-d1">
            <button type="button" class="settings-nav-item active" onclick="switchTab('general', this)">⚙️ {{ __('forms.general') }}</button>
            <button type="button" class="settings-nav-item" onclick="switchTab('account', this)">👤 {{ __('sidebar.account') }}</button>
            <button type="button" class="settings-nav-item" onclick="switchTab('notifications', this)">🔔 {{ __('sidebar.notifications') }}</button>
            <button type="button" class="settings-nav-item" onclick="switchTab('privacy', this)">🔒 {{ __('forms.privacy') }}</button>
            <button type="button" class="settings-nav-item" onclick="switchTab('security', this)">🛡️ {{ __('forms.security') }}</button>
        </div>

        <!-- Content Area -->
        <div>
            <!-- General Settings -->
            <div id="general" class="settings-content active anim anim-d2">
                <div class="settings-section">
                    <div class="settings-section-title">{{ __('forms.display_preferences') }}</div>

                    <div class="form-group">
                        <label class="form-label">{{ __('forms.theme') }}</label>
                        <select class="form-select">
                            <option>{{ __('forms.dark_mode_current') }}</option>
                            <option>{{ __('forms.light_mode') }}</option>
                            <option>{{ __('forms.system_default') }}</option>
                        </select>
                        <div class="form-desc">{{ __('forms.choose_appearance') }}</div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">{{ __('forms.language') }}</label>
                        <select class="form-select">
                            <option>{{ __('forms.lang_en') }}</option>
                            <option>{{ __('forms.lang_fr') }}</option>
                            <option>{{ __('forms.lang_ar') }}</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label">{{ __('forms.timezone') }}</label>
                        <select class="form-select">
                            <option>UTC-8 (Pacific Time)</option>
                            <option>UTC-5 (Eastern Time)</option>
                            <option>UTC (GMT)</option>
                        </select>
                    </div>
                </div>

                <div class="settings-section">
                    <div class="settings-section-title">{{ __('forms.sidebar_behavior') }}</div>

                    <div class="form-group">
                        <div class="toggle-switch">
                            <label class="switch">
                                <input type="checkbox" checked>
                                <span class="slider"></span>
                            </label>
                            <span>{{ __('forms.auto_collapse_sidebar') }}</span>
                        </div>
                        <div class="form-desc" style="margin-top: 0.75rem;">{{ __('forms.auto_collapse_sidebar_desc') }}</div>
                    </div>

                    <div class="divider"></div>

                    <button class="btn btn-primary">{{ __('messages.save_changes') }}</button>
                </div>
            </div>

            <!-- Account Settings -->
            <div id="account" class="settings-content anim anim-d2">
                <div class="settings-section">
                    <div class="settings-section-title">{{ __('dashboard.personal_information') }}</div>
                    <div class="settings-section-desc">{{ __('forms.update_personal_details') }}</div>
                    <form method="POST" action="{{ route('profile.update') }}">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="source" value="settings">

                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label" for="settings_first_name">{{ __('forms.first_name') }}</label>
                                <input id="settings_first_name" name="first_name" type="text" class="form-input" value="{{ $settingsFirstName }}" placeholder="First name" required>
                                @error('first_name')<span class="field-error">{{ $message }}</span>@enderror
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="settings_last_name">{{ __('forms.last_name') }}</label>
                                <input id="settings_last_name" name="last_name" type="text" class="form-input" value="{{ $settingsLastName }}" placeholder="Last name" required>
                                @error('last_name')<span class="field-error">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="settings_email">{{ __('forms.email') }}</label>
                            <input id="settings_email" name="email" type="email" class="form-input" value="{{ old('email', auth()->user()->email) }}" placeholder="your@email.com" required>
                            @error('email')<span class="field-error">{{ $message }}</span>@enderror
                        </div>

                        <div class="divider"></div>
                        <button type="submit" class="btn btn-primary">{{ __('messages.update_profile') }}</button>
                    </form>
                </div>

                <div class="settings-section">
                    <div class="settings-section-title">{{ __('dashboard.email_notifications') }}</div>

                    <div class="form-group">
                        <div class="toggle-switch">
                            <label class="switch">
                                <input type="checkbox" checked>
                                <span class="slider"></span>
                            </label>
                            <span>{{ __('forms.receive_course_updates') }}</span>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="toggle-switch">
                            <label class="switch">
                                <input type="checkbox" checked>
                                <span class="slider"></span>
                            </label>
                            <span>{{ __('forms.receive_weekly_digest') }}</span>
                        </div>
                    </div>

                    <div class="divider"></div>
                    <button class="btn btn-primary">{{ __('messages.save_changes') }}</button>
                </div>
            </div>

            <!-- Notifications -->
            <div id="notifications" class="settings-content anim anim-d2">
                <div class="settings-section">
                    <div class="settings-section-title">{{ __('forms.notification_channels') }}</div>

                    <div class="form-group">
                        <div class="toggle-switch">
                            <label class="switch">
                                <input type="checkbox" checked>
                                <span class="slider"></span>
                            </label>
                            <span>{{ __('dashboard.email_notifications') }}</span>
                        </div>
                        <div class="form-desc" style="margin-top: 0.75rem;">{{ __('forms.receive_updates_email') }}</div>
                    </div>

                    <div class="form-group">
                        <div class="toggle-switch">
                            <label class="switch">
                                <input type="checkbox" checked>
                                <span class="slider"></span>
                            </label>
                            <span>{{ __('forms.in_app_notifications') }}</span>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="toggle-switch">
                            <label class="switch">
                                <input type="checkbox">
                                <span class="slider"></span>
                            </label>
                            <span>{{ __('forms.push_notifications') }}</span>
                        </div>
                    </div>
                </div>

                <div class="settings-section">
                    <div class="settings-section-title">{{ __('forms.notification_types') }}</div>

                    <div class="form-group">
                        <div class="toggle-switch">
                            <label class="switch">
                                <input type="checkbox" checked>
                                <span class="slider"></span>
                            </label>
                            <span>{{ __('forms.course_reminders') }}</span>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="toggle-switch">
                            <label class="switch">
                                <input type="checkbox" checked>
                                <span class="slider"></span>
                            </label>
                            <span>{{ __('forms.new_messages') }}</span>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="toggle-switch">
                            <label class="switch">
                                <input type="checkbox">
                                <span class="slider"></span>
                            </label>
                            <span>{{ __('forms.marketing_updates') }}</span>
                        </div>
                    </div>

                    <div class="divider"></div>
                    <button class="btn btn-primary">{{ __('forms.save_notification_settings') }}</button>
                </div>
            </div>

            <!-- Privacy Settings -->
            <div id="privacy" class="settings-content anim anim-d2">
                <div class="settings-section">
                    <div class="settings-section-title">{{ __('forms.profile_privacy') }}</div>

                    <div class="form-group">
                        <label class="form-label">{{ __('forms.profile_visibility') }}</label>
                        <select class="form-select">
                            <option>{{ __('forms.public') }}</option>
                            <option>{{ __('forms.private') }}</option>
                            <option>{{ __('forms.friends_only') }}</option>
                        </select>
                        <div class="form-desc">{{ __('forms.profile_visibility_desc') }}</div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">{{ __('forms.show_my_courses') }}</label>
                        <select class="form-select">
                            <option>{{ __('forms.everyone') }}</option>
                            <option>{{ __('forms.logged_users') }}</option>
                            <option>{{ __('forms.nobody') }}</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <div class="toggle-switch">
                            <label class="switch">
                                <input type="checkbox" checked>
                                <span class="slider"></span>
                            </label>
                            <span>{{ __('forms.allow_messages') }}</span>
                        </div>
                    </div>

                    <div class="divider"></div>
                    <button class="btn btn-primary">{{ __('forms.update_privacy_settings') }}</button>
                </div>

                <div class="settings-section">
                    <div class="settings-section-title">{{ __('forms.data_cookies') }}</div>

                    <div class="form-group">
                        <div class="toggle-switch">
                            <label class="switch">
                                <input type="checkbox">
                                <span class="slider"></span>
                            </label>
                            <span>{{ __('forms.allow_analytics') }}</span>
                        </div>
                        <div class="form-desc" style="margin-top: 0.75rem;">{{ __('forms.analytics_desc') }}</div>
                    </div>

                    <div class="divider"></div>
                    <button class="btn btn-secondary">{{ __('forms.download_my_data') }}</button>
                </div>
            </div>

            <!-- Security Settings -->
            <div id="security" class="settings-content anim anim-d2">
                <div class="settings-section">
                    <div class="settings-section-title">{{ __('forms.password_security') }}</div>

                    <form method="POST" action="{{ route('settings.password.update') }}">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label class="form-label" for="current_password">{{ __('forms.current_password') }}</label>
                            <input id="current_password" name="current_password" type="password" class="form-input" placeholder="Enter current password" required>
                            @error('current_password')<span class="field-error">{{ $message }}</span>@enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="new_password">{{ __('forms.new_password') }}</label>
                            <input id="new_password" name="password" type="password" class="form-input" placeholder="Enter new password" required>
                            @error('password')<span class="field-error">{{ $message }}</span>@enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="password_confirmation">{{ __('forms.confirm_password') }}</label>
                            <input id="password_confirmation" name="password_confirmation" type="password" class="form-input" placeholder="Confirm new password" required>
                        </div>

                        <div class="divider"></div>
                        <button type="submit" class="btn btn-primary">{{ __('messages.change_password') }}</button>
                    </form>
                </div>

                <div class="settings-section">
                    <div class="settings-section-title">{{ __('dashboard.two_factor_auth') }}</div>
                    <div class="settings-section-desc">{{ __('forms.two_factor_desc') }}</div>

                    <div class="form-group">
                        <div class="toggle-switch">
                            <label class="switch">
                                <input type="checkbox">
                                <span class="slider"></span>
                            </label>
                            <span>{{ __('forms.enable_2fa') }}</span>
                        </div>
                        <div class="form-desc" style="margin-top: 0.75rem;">{{ __('forms.enable_2fa_desc') }}</div>
                    </div>

                    <div class="divider"></div>
                    <button class="btn btn-secondary">{{ __('forms.setup_2fa') }}</button>
                </div>

                <div class="settings-section">
                    <div class="settings-section-title">{{ __('forms.active_sessions') }}</div>

                    <div class="form-group">
                        <p style="color: #9ca3af; margin-bottom: 1rem;">{{ __('forms.logged_in_devices') }}</p>

                        <form method="POST" action="{{ route('settings.logout-other-devices') }}">
                            @csrf
                            <div class="form-group">
                                <label class="form-label" for="devices_password">{{ __('forms.current_password') }}</label>
                                <input id="devices_password" name="devices_password" type="password" class="form-input" placeholder="Enter current password" required>
                                @error('devices_password')<span class="field-error">{{ $message }}</span>@enderror
                            </div>
                            <button type="submit" class="btn btn-secondary">{{ __('forms.logout_other_devices') }}</button>
                        </form>
                    </div>
                </div>

                <div class="danger-zone">
                    <div class="danger-zone-title">{{ __('forms.danger_zone') }}</div>
                    <div class="danger-zone-desc">{{ __('forms.danger_zone_desc') }}</div>

                    <form method="POST" action="{{ route('settings.account.delete') }}" onsubmit="return confirm('Are you sure you want to delete your account? This action cannot be undone.');">
                        @csrf
                        @method('DELETE')
                        <div class="form-group">
                            <label class="form-label" for="delete_account_password">{{ __('forms.current_password') }}</label>
                            <input id="delete_account_password" name="delete_account_password" type="password" class="form-input" placeholder="Enter current password" required>
                            @error('delete_account_password')<span class="field-error">{{ $message }}</span>@enderror
                        </div>
                        <button type="submit" class="btn btn-danger">{{ __('forms.delete_my_account') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function switchTab(tabId, clickedElement) {
    // Hide all content
    const allContent = document.querySelectorAll('.settings-content');
    allContent.forEach(content => content.classList.remove('active'));

    // Remove active class from all nav items
    const allNavItems = document.querySelectorAll('.settings-nav-item');
    allNavItems.forEach(item => item.classList.remove('active'));

    // Show selected content
    document.getElementById(tabId).classList.add('active');

    // Add active class to clicked nav item
    if (clickedElement) {
        clickedElement.classList.add('active');
    }

    // Persist selected tab in URL query
    const url = new URL(window.location.href);
    url.searchParams.set('tab', tabId);
    window.history.replaceState({}, '', url);
}

document.addEventListener('DOMContentLoaded', function () {
    const params = new URLSearchParams(window.location.search);
    const urlTab = params.get('tab');
    const hasPasswordErrors = {{ ($errors->has('current_password') || $errors->has('password') || $errors->has('devices_password') || $errors->has('delete_account_password')) ? 'true' : 'false' }};
    const hasProfileErrors = {{ ($errors->has('first_name') || $errors->has('last_name') || $errors->has('email')) ? 'true' : 'false' }};

    let tabToOpen = urlTab || 'general';
    if (hasPasswordErrors) {
        tabToOpen = 'security';
    } else if (hasProfileErrors) {
        tabToOpen = 'account';
    }

    const navButton = Array.from(document.querySelectorAll('.settings-nav-item')).find(function (button) {
        return button.getAttribute('onclick') && button.getAttribute('onclick').indexOf("'" + tabToOpen + "'") !== -1;
    });

    if (document.getElementById(tabToOpen)) {
        switchTab(tabToOpen, navButton || null);
    }
});
</script>

@endsection
