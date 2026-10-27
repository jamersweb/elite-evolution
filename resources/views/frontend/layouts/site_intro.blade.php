<style>
    .ee-intro {
        position: fixed;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        height: 100dvh;
        z-index: 2147483000;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0;
        padding: env(safe-area-inset-top) env(safe-area-inset-right) env(safe-area-inset-bottom) env(safe-area-inset-left);
        background:
            linear-gradient(160deg, rgba(8, 8, 8, 0.94) 0%, rgba(18, 16, 12, 0.9) 45%, rgba(10, 10, 10, 0.96) 100%),
            url('{{ asset('frontend/img/banner_update.jpg') }}') center / cover no-repeat;
        color: #fff;
        opacity: 1;
        visibility: visible;
        transition: opacity 0.45s ease, visibility 0.45s ease;
        isolation: isolate;
        -webkit-overflow-scrolling: touch;
        overflow: auto;
    }
    html.ee-intro-seen .ee-intro,
    .ee-intro.is-hidden {
        display: none !important;
    }
    .ee-intro.is-leaving {
        opacity: 0;
        visibility: hidden;
        pointer-events: none;
    }
    html.ee-intro-open,
    html.ee-intro-open body {
        overflow: hidden !important;
        height: 100%;
    }
    html.ee-intro-open .navbar,
    html.ee-intro-open .nav-banner,
    html.ee-intro-open .concierge-floating-btn,
    html.ee-intro-open .concierge-modal,
    html.ee-intro-open .whatsapp-btn,
    html.ee-intro-open .mobile-sticky-bar {
        visibility: hidden !important;
        pointer-events: none !important;
    }
    .ee-intro__inner {
        text-align: center;
        max-width: 560px;
        width: min(100%, 560px);
        padding: 32px 24px;
        transform: translateY(18px);
        opacity: 0;
        animation: eeIntroIn 0.7s ease 0.1s forwards;
    }
    .ee-intro__logo {
        height: 56px;
        width: auto;
        max-width: 240px;
        object-fit: contain;
        margin: 0 auto 28px;
        display: block;
        filter: brightness(0) invert(1);
        animation: eeIntroPulse 2.4s ease-in-out infinite;
    }
    .ee-intro__eyebrow {
        display: block;
        color: #b38b47;
        font-size: 12px;
        font-weight: 700;
        letter-spacing: 3px;
        text-transform: uppercase;
        margin-bottom: 14px;
    }
    .ee-intro__title {
        font-family: Georgia, 'Times New Roman', serif;
        font-size: clamp(28px, 5vw, 42px);
        font-weight: 400;
        line-height: 1.2;
        margin: 0 0 14px;
        letter-spacing: 0.5px;
        color: #fff;
    }
    .ee-intro__lead {
        color: rgba(255, 255, 255, 0.78);
        font-size: 15px;
        line-height: 1.6;
        margin: 0 auto 28px;
        max-width: 420px;
    }
    .ee-intro__actions {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
        justify-content: center;
        align-items: center;
    }
    .ee-intro__btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 13px 26px;
        border-radius: 6px;
        font-weight: 700;
        font-size: 13px;
        letter-spacing: 1px;
        text-transform: uppercase;
        text-decoration: none;
        border: 2px solid transparent;
        cursor: pointer;
        transition: transform 0.2s ease, background 0.2s ease, color 0.2s ease, border-color 0.2s ease;
    }
    .ee-intro__btn:hover {
        transform: translateY(-2px);
        color: #fff;
        text-decoration: none;
    }
    .ee-intro__btn--gold {
        background: #b38b47;
        color: #fff;
        border-color: #b38b47;
    }
    .ee-intro__btn--gold:hover {
        background: #9a7538;
        color: #fff;
        border-color: #9a7538;
    }
    .ee-intro__btn--ghost {
        background: transparent;
        color: #fff;
        border-color: rgba(255, 255, 255, 0.45);
    }
    .ee-intro__btn--ghost:hover {
        background: #fff;
        color: #111;
        border-color: #fff;
    }
    .ee-intro__skip {
        display: inline-block;
        margin: 22px auto 0;
        background: none;
        border: 0;
        color: rgba(255, 255, 255, 0.55);
        font-size: 12px;
        letter-spacing: 1px;
        text-transform: uppercase;
        cursor: pointer;
        text-decoration: underline;
        text-underline-offset: 3px;
        text-align: center;
    }
    .ee-intro__skip:hover {
        color: #b38b47;
    }
    @keyframes eeIntroIn {
        to { opacity: 1; transform: translateY(0); }
    }
    @keyframes eeIntroPulse {
        0%, 100% { opacity: 0.92; transform: scale(1); }
        50% { opacity: 1; transform: scale(1.03); }
    }
    @media (prefers-reduced-motion: reduce) {
        .ee-intro,
        .ee-intro__inner,
        .ee-intro__logo,
        .ee-intro__btn {
            animation: none !important;
            transition: none !important;
        }
        .ee-intro__inner {
            opacity: 1;
            transform: none;
        }
    }
</style>

<div class="ee-intro" id="eeSiteIntro" role="dialog" aria-modal="true" aria-labelledby="eeIntroTitle">
    <div class="ee-intro__inner">
        <img
            class="ee-intro__logo"
            src="{{ asset('management/images/elite-evolution-real-estate-in-white.png') }}"
            onerror="this.onerror=null;this.src='{{ asset('frontend/img/logo.png') }}';"
            alt="Elite Evolution Real Estate"
        >
        <span class="ee-intro__eyebrow">Dubai Luxury Real Estate</span>
        <h2 class="ee-intro__title" id="eeIntroTitle">Welcome to Elite Evolution</h2>
        <p class="ee-intro__lead">
            Private advisory for prime Dubai residences — licensed brokers, verified inventory, and discreet client care.
        </p>
        <div class="ee-intro__actions">
            <button type="button" class="ee-intro__btn ee-intro__btn--gold" id="eeIntroEnter">
                Enter Site
            </button>
            <a href="https://wa.me/971569700771?text=Hello%20Elite%20Evolution%2C%20I%20would%20like%20to%20speak%20with%20a%20licensed%20advisor." target="_blank" rel="noopener" class="ee-intro__btn ee-intro__btn--ghost" id="eeIntroWhatsApp">
                <i class="fa-brands fa-whatsapp"></i> Speak to an Advisor
            </a>
        </div>
        <button type="button" class="ee-intro__skip" id="eeIntroSkip">Skip intro</button>
    </div>
</div>

<script>
(function () {
    var KEY = 'ee_intro_seen_v1';
    var intro = document.getElementById('eeSiteIntro');
    if (!intro) return;

    // Escape footer stacking context so the overlay covers the navbar
    if (intro.parentNode !== document.body) {
        document.body.appendChild(intro);
    }

    function markSeen() {
        try { localStorage.setItem(KEY, '1'); } catch (e) {}
        document.documentElement.classList.add('ee-intro-seen');
        document.documentElement.classList.remove('ee-intro-open');
    }

    function dismissIntro() {
        markSeen();
        intro.classList.add('is-leaving');
        setTimeout(function () {
            intro.classList.add('is-hidden');
            intro.setAttribute('hidden', '');
            intro.classList.remove('is-leaving');
        }, 450);
    }

    if (document.documentElement.classList.contains('ee-intro-seen')) {
        intro.classList.add('is-hidden');
        intro.setAttribute('hidden', '');
        return;
    }

    document.documentElement.classList.add('ee-intro-open');
    intro.removeAttribute('hidden');

    var enterBtn = document.getElementById('eeIntroEnter');
    var skipBtn = document.getElementById('eeIntroSkip');
    var waBtn = document.getElementById('eeIntroWhatsApp');

    if (enterBtn) enterBtn.addEventListener('click', dismissIntro);
    if (skipBtn) skipBtn.addEventListener('click', dismissIntro);
    if (waBtn) {
        waBtn.addEventListener('click', function () {
            markSeen();
        });
    }

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && !intro.classList.contains('is-hidden')) {
            dismissIntro();
        }
    });
})();
</script>
