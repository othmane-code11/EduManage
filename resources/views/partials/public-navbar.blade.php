<style>
    .lang-switcher {
        position: relative;
    }

    .lang-trigger {
        background: rgba(255,255,255,.06);
        border: 1px solid rgba(59,130,246,.25);
        color: var(--text-primary);
        border-radius: 8px;
        font-family: inherit;
        font-size: .85rem;
        font-weight: 600;
        cursor: pointer;
        padding: .45rem .7rem;
    }

    .lang-menu {
        position: absolute;
        top: calc(100% + .45rem);
        right: 0;
        min-width: 165px;
        background: var(--bg-card);
        border: 1px solid var(--border);
        border-radius: 10px;
        overflow: hidden;
        z-index: 120;
        display: none;
        box-shadow: 0 14px 35px rgba(0,0,0,.3);
    }

    .lang-menu.open {
        display: block;
    }

    .lang-menu a {
        display: block;
        text-decoration: none;
        color: var(--text-primary);
        font-size: .86rem;
        padding: .65rem .85rem;
        transition: background .2s;
    }

    .lang-menu a:hover {
        background: rgba(59,130,246,.12);
    }

    [dir="rtl"] .nav-logo,
    [dir="rtl"] .nav-links,
    [dir="rtl"] .nav-actions {
        flex-direction: row-reverse;
    }

    [dir="rtl"] .lang-menu {
        right: auto;
        left: 0;
    }
</style>

<nav>
    <a href="{{ route('landing') }}" class="nav-logo">
        <svg viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
            <rect width="32" height="32" rx="8" fill="#3b82f6"/>
            <path d="M7 12l9-5 9 5-9 5-9-5z" fill="#fff" opacity=".9"/>
            <path d="M7 18l9 5 9-5" stroke="#fff" stroke-width="2" stroke-linecap="round" fill="none" opacity=".7"/>
        </svg>
        EduLearn
    </a>

    <ul class="nav-links">
        <li><a href="{{ route('landing') }}" class="{{ ($active ?? '') === 'landing' ? 'active' : '' }}">{{ __('messages.home') }}</a></li>
        <li><a href="{{ route('features') }}" class="{{ ($active ?? '') === 'features' ? 'active' : '' }}">{{ __('messages.features') }}</a></li>
        <li><a href="{{ route('pricing') }}" class="{{ ($active ?? '') === 'pricing' ? 'active' : '' }}">{{ __('messages.pricing') }}</a></li>
        <li><a href="{{ route('about') }}" class="{{ ($active ?? '') === 'about' ? 'active' : '' }}">{{ __('messages.about') }}</a></li>
        <li><a href="{{ route('blog') }}" class="{{ ($active ?? '') === 'blog' ? 'active' : '' }}">{{ __('messages.blog') }}</a></li>
        <li><a href="{{ route('contact') }}" class="{{ ($active ?? '') === 'contact' ? 'active' : '' }}">{{ __('messages.contact') }}</a></li>
    </ul>

    <div class="nav-actions">
        <div class="lang-switcher" id="publicLangSwitcher">
            <button class="lang-trigger" type="button" onclick="togglePublicLangMenu()">
                @if($currentLocale === 'fr')
                    🇫🇷 FR
                @elseif($currentLocale === 'ar')
                    🇲🇦 AR
                @else
                    🇬🇧 EN
                @endif
            </button>
            <div class="lang-menu" id="publicLangMenu">
                @foreach($localeOptions as $option)
                    <a href="{{ route('lang.switch', ['locale' => $option['code']]) }}" onclick="localStorage.setItem('locale', '{{ $option['code'] }}')">
                        {{ $option['flag'] }} {{ $option['label'] }}
                    </a>
                @endforeach
            </div>
        </div>

        @auth
            <a href="{{ route('dashboard') }}" class="btn-ghost">{{ __('messages.dashboard') }}</a>
        @else
            <a href="{{ route('login') }}" class="btn-ghost">{{ __('messages.log_in') }}</a>
            <a href="{{ route('register') }}" class="btn-primary">{{ __('messages.get_started') }}</a>
        @endauth
    </div>
</nav>

<script>
    function togglePublicLangMenu() {
        const menu = document.getElementById('publicLangMenu');
        if (menu) {
            menu.classList.toggle('open');
        }
    }

    document.addEventListener('click', function (event) {
        const switcher = document.getElementById('publicLangSwitcher');
        const menu = document.getElementById('publicLangMenu');
        if (!switcher || !menu) {
            return;
        }
        if (!switcher.contains(event.target)) {
            menu.classList.remove('open');
        }
    });
</script>
