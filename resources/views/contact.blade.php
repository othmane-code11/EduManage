<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" {{ app()->getLocale() === 'ar' ? 'dir="rtl"' : '' }}>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('messages.contact_meta_title') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --bg-deep:    #040d21;
            --bg-card:    #0b1735;
            --bg-card2:   #0e1f42;
            --accent:     #3b82f6;
            --accent2:    #06b6d4;
            --accent-glow: rgba(59,130,246,.35);
            --text-primary: #f0f6ff;
            --text-muted:   #8ca3c8;
            --border:       rgba(59,130,246,.18);
            --green:  #22c55e;
            --purple: #a855f7;
            --yellow: #eab308;
        }

        html { scroll-behavior: smooth; }

        body {
            background: var(--bg-deep);
            color: var(--text-primary);
            font-family: 'DM Sans', sans-serif;
            min-height: 100vh;
            overflow-x: hidden;
        }

        body::before {
            content: '';
            position: fixed; inset: 0; z-index: 0; pointer-events: none;
            background:
                radial-gradient(ellipse 600px 400px at 10% 30%,  rgba(59,130,246,.12) 0%, transparent 70%),
                radial-gradient(ellipse 500px 350px at 90% 60%,  rgba(6,182,212,.10) 0%, transparent 70%),
                radial-gradient(ellipse 400px 300px at 50% 100%, rgba(168,85,247,.08) 0%, transparent 70%);
        }

        nav {
            position: sticky; top: 0; z-index: 100;
            display: flex; align-items: center; justify-content: space-between;
            padding: 0 2.5rem;
            height: 68px;
            background: rgba(4,13,33,.82);
            backdrop-filter: blur(18px);
            border-bottom: 1px solid var(--border);
        }

        .nav-logo {
            display: flex; align-items: center; gap: .55rem;
            font-family: 'Syne', sans-serif; font-weight: 800; font-size: 1.25rem;
            color: var(--text-primary); text-decoration: none;
        }

        .nav-logo svg { width: 32px; height: 32px; }

        .nav-links {
            display: flex; gap: 2rem; list-style: none;
        }

        .nav-links a {
            color: var(--text-muted); font-size: .93rem; font-weight: 500;
            text-decoration: none; transition: color .2s;
        }
        .nav-links a:hover, .nav-links a.active { color: var(--text-primary); }

        .nav-actions { display: flex; align-items: center; gap: 1rem; }

        .btn-primary {
            display: inline-flex; align-items: center; gap: .45rem;
            background: var(--accent); color: #fff;
            border: none; border-radius: 8px; cursor: pointer;
            font-family: inherit; font-size: .93rem; font-weight: 600;
            padding: .6rem 1.3rem;
            box-shadow: 0 0 22px var(--accent-glow);
            transition: opacity .2s, box-shadow .2s;
            text-decoration: none;
        }
        .btn-primary:hover { opacity: .88; box-shadow: 0 0 32px var(--accent-glow); }

        .btn-ghost {
            background: none; border: none; cursor: pointer;
            color: var(--text-muted); font-family: inherit; font-size: .93rem;
            font-weight: 500; transition: color .2s; padding: .4rem .6rem;
        }
        .btn-ghost:hover { color: var(--text-primary); }

        .main-content {
            position: relative; z-index: 1;
        }

        .section {
            max-width: 1200px; margin: 0 auto;
            padding: 5rem 2.5rem;
        }

        .section-header {
            text-align: center;
            margin-bottom: 3rem;
        }

        .section-badge {
            display: inline-flex; align-items: center; gap: .45rem;
            background: rgba(59,130,246,.12); border: 1px solid var(--border);
            border-radius: 50px; padding: .35rem .9rem;
            font-size: .8rem; font-weight: 500; color: var(--accent2);
            margin-bottom: 1rem;
        }

        .section-title {
            font-family: 'Syne', sans-serif;
            font-size: clamp(2rem, 4vw, 3rem);
            font-weight: 800; line-height: 1.2;
            margin-bottom: 1rem;
        }

        .section-desc {
            color: var(--text-muted); font-size: 1rem; line-height: 1.7;
            max-width: 600px; margin: 0 auto;
        }

        /* Contact layout */
        .contact-grid {
            display: grid; grid-template-columns: 1fr 1fr;
            gap: 4rem; margin-top: 3rem;
        }

        /* Contact info */
        .contact-info {
            display: flex; flex-direction: column; gap: 2rem;
        }

        .info-card {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 2rem;
        }

        .info-icon {
            font-size: 2rem;
            margin-bottom: .8rem;
        }

        .info-title {
            font-family: 'Syne', sans-serif;
            font-size: 1.1rem;
            font-weight: 700;
            margin-bottom: .5rem;
        }

        .info-details {
            color: var(--text-muted);
            font-size: .9rem;
            line-height: 1.6;
        }

        .info-details a {
            color: var(--accent2);
            text-decoration: none;
            transition: color .2s;
        }

        .info-details a:hover {
            color: var(--accent);
        }

        /* Contact form */
        .contact-form {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 2.5rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            margin-bottom: .5rem;
            font-weight: 600;
            font-size: .9rem;
        }

        .form-group input,
        .form-group textarea {
            width: 100%;
            background: var(--bg-deep);
            border: 1px solid var(--border);
            border-radius: 8px;
            padding: .75rem 1rem;
            color: var(--text-primary);
            font-family: inherit;
            font-size: .9rem;
            transition: border-color .2s;
        }

        .form-group input::placeholder,
        .form-group textarea::placeholder {
            color: var(--text-muted);
        }

        .form-group input:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(59,130,246,.1);
        }

        .form-group textarea {
            resize: vertical;
            min-height: 150px;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }

        .submit-btn {
            width: 100%;
            background: var(--accent);
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: .75rem 1.5rem;
            font-family: inherit;
            font-size: .9rem;
            font-weight: 600;
            cursor: pointer;
            transition: opacity .2s, box-shadow .2s;
            box-shadow: 0 0 22px var(--accent-glow);
        }

        .submit-btn:hover {
            opacity: .88;
            box-shadow: 0 0 32px var(--accent-glow);
        }

        /* Responsive */
        @media (max-width: 900px) {
            nav { padding: 0 1.2rem; }
            .nav-links { display: none; }
            .section { padding: 3rem 1.5rem; }
            .contact-grid { grid-template-columns: 1fr; gap: 2rem; }
            .form-row { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

@include('partials.public-navbar', ['active' => 'contact'])

<div class="main-content">
    {{-- ═══════════════ CONTACT HEADER ═══════════════ --}}
    <section class="section">
        <div class="section-header">
            <div class="section-badge">💬 {{ __('messages.contact_badge') }}</div>
            <h1 class="section-title">{{ __('messages.contact_title') }}</h1>
            <p class="section-desc">
                {{ __('messages.contact_description') }}
            </p>
        </div>
    </section>

    {{-- ═══════════════ CONTACT CONTENT ═══════════════ --}}
    <section class="section">
        <div class="contact-grid">
            {{-- Contact Info --}}
            <div class="contact-info">
                <div class="info-card">
                    <div class="info-icon">📧</div>
                    <div class="info-title">{{ __('messages.contact_info_email') }}</div>
                    <div class="info-details">
                        <p>support@edulearn.com</p>
                        <p>business@edulearn.com</p>
                    </div>
                </div>

                <div class="info-card">
                    <div class="info-icon">📞</div>
                    <div class="info-title">{{ __('messages.contact_info_phone') }}</div>
                    <div class="info-details">
                        <p>+1 (555) 123-4567</p>
                        <p>{{ __('messages.contact_hours') }}</p>
                    </div>
                </div>

                <div class="info-card">
                    <div class="info-icon">📍</div>
                    <div class="info-title">{{ __('messages.contact_info_office') }}</div>
                    <div class="info-details">
                        <p>123 Education Street</p>
                        <p>San Francisco, CA 94105</p>
                        <p>{{ __('messages.contact_country') }}</p>
                    </div>
                </div>

                <div class="info-card">
                    <div class="info-icon">🔗</div>
                    <div class="info-title">{{ __('messages.contact_follow') }}</div>
                    <div class="info-details">
                        <p>
                            <a href="#">{{ __('messages.contact_social_twitter') }}</a> •
                            <a href="#">LinkedIn</a> •
                            <a href="#">{{ __('messages.contact_social_facebook') }}</a> •
                            <a href="#">{{ __('messages.contact_social_instagram') }}</a>
                        </p>
                    </div>
                </div>
            </div>

            {{-- Contact Form --}}
            <div class="contact-form">
                <form method="POST" action="#">
                    @csrf

                    <div class="form-row">
                        <div class="form-group">
                            <label for="name">{{ __('messages.contact_first_name') }}</label>
                            <input type="text" id="name" name="name" placeholder="{{ __('messages.contact_first_name_placeholder') }}" required>
                        </div>
                        <div class="form-group">
                            <label for="last_name">{{ __('messages.contact_last_name') }}</label>
                            <input type="text" id="last_name" name="last_name" placeholder="{{ __('messages.contact_last_name_placeholder') }}" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="email">{{ __('messages.contact_email') }}</label>
                        <input type="email" id="email" name="email" placeholder="{{ __('messages.contact_email_placeholder') }}" required>
                    </div>

                    <div class="form-group">
                        <label for="phone">{{ __('messages.contact_phone_optional') }}</label>
                        <input type="tel" id="phone" name="phone" placeholder="{{ __('messages.contact_phone_placeholder') }}">
                    </div>

                    <div class="form-group">
                        <label for="subject">{{ __('messages.contact_subject') }}</label>
                        <input type="text" id="subject" name="subject" placeholder="{{ __('messages.contact_subject_placeholder') }}" required>
                    </div>

                    <div class="form-group">
                        <label for="message">{{ __('messages.contact_message') }}</label>
                        <textarea id="message" name="message" placeholder="{{ __('messages.contact_message_placeholder') }}" required></textarea>
                    </div>

                    <button type="submit" class="submit-btn">{{ __('messages.send_message') }}</button>
                </form>
            </div>
        </div>
    </section>

    {{-- ═══════════════ FAQ SECTION ═══════════════ --}}
    <section class="section" style="text-align: center;">
        <div class="section-header">
            <h2 class="section-title">{{ __('messages.contact_faq_title') }}</h2>
            <p class="section-desc">
                {{ __('messages.contact_faq_desc') }}
            </p>
        </div>
    </section>
</div>

</body>
</html>
