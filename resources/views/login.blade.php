<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" {{ app()->getLocale() === 'ar' ? 'dir="rtl"' : '' }}>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('auth.login') }} — EduManage</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;500;600;700;800&family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;1,9..40,300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ url('CSS/login.css') }}">
</head>
<body>
<div class="bg-scene">
    <div class="bg-orb bg-orb-1"></div>
    <div class="bg-orb bg-orb-2"></div>
    <div class="bg-orb bg-orb-3"></div>
    <div class="grid-overlay"></div>
</div>

<div class="page">
    <div class="split">

        <!-- LEFT PANEL -->
        <div class="panel-left">
            <div class="brand">
                <div class="brand-icon">🎓</div>
                <div class="brand-name">EduManage</div>
                <div class="brand-tag">{{ __('dashboard.learning_reimagined') }}</div>
            </div>

            <div class="panel-copy">
                <h2>{{ __('auth.unlock_potential_title') }}</h2>
                <p>{{ __('auth.unlock_potential_desc') }}</p>
            </div>

            <div class="stats">
                <div class="stat-item">
                    <div class="stat-num"></div>
                    <div class="stat-label">{{ __('sidebar.courses') }}</div>
                </div>
                <div class="stat-item">
                    <div class="stat-num"></div>
                    <div class="stat-label">{{ __('sidebar.students') }}</div>
                </div>
                <div class="stat-item">
                    <div class="stat-num"></div>
                    <div class="stat-label"></div>
                </div>
            </div>
        </div>

        <!-- RIGHT PANEL -->
        <div class="panel-right">
            <div class="form-header">
                <h1>{{ __('auth.welcome_back') }}</h1>
                <p>{{ __('auth.dont_have_account') }} <a href="{{ route('register') }}">{{ __('auth.sign_up') }}</a></p>
            </div>

            <form method="POST" action="{{ route('login.post') }}" novalidate>
                @csrf

                <!-- Email -->
                <div class="field">
                    <label for="email">{{ __('auth.email') }}</label>
                    <div class="input-wrap">
                        <span class="icon">
                            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                        </span>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            value="{{ old('email') }}"
                            placeholder="{{ __('forms.email_placeholder') }}"
                            autocomplete="email"
                            required
                        >
                    </div>
                    @error('email')
                        <span style="color:#f87171;font-size:0.8rem;margin-top:0.35rem;display:block;">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Password -->
                <div class="field">
                    <label for="password">{{ __('auth.password') }}</label>
                    <div class="input-wrap">
                        <span class="icon">
                            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                        </span>
                        <input
                            type="password"
                            id="password"
                            name="password"
                            placeholder="{{ __('auth.enter_password') }}"
                            autocomplete="current-password"
                            required
                        >
                    </div>
                    @error('password')
                        <span style="color:#f87171;font-size:0.8rem;margin-top:0.35rem;display:block;">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Remember & Forgot -->
                <div class="field-row">
                    <label class="checkbox-wrap">
                        <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                        <span>{{ __('auth.remember_me') }}</span>
                    </label>
                        <a class="forgot-link">{{ __('auth.forgot_password') }}</a>
                </div>

                <!-- Submit -->
               <button type="submit" class="btn-submit">{{ __('auth.sign_in') }}</button>

<div class="auth-links">
    <a class="btn-create-account" href="{{ route('register') }}">{{ __('auth.create_account') }}</a>
    <a class="btn-back-home" href="{{ route('landing') }}">{{ __('messages.back') }}</a>
</div>
            </form>

          

    </div>
</div>
</body>
</html>



























