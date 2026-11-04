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
        background: #111 url('{{ asset('frontend/video/property-welcome.jpg') }}') center / cover no-repeat;
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
    .ee-intro__video {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        pointer-events: none;
        z-index: -2;
    }
    .ee-intro::before {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(160deg, rgba(8, 8, 8, .65), rgba(18, 16, 12, .58) 45%, rgba(10, 10, 10, .75));
        pointer-events: none;
        z-index: -1;
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
        .ee-intro__logo {
            animation: none !important;
            transition: none !important;
        }
        .ee-intro__inner {
            opacity: 1;
            transform: none;
        }
    }
</style>

<div class="ee-intro" id="eeSiteIntro" role="dialog" aria-modal="true" aria-label="Elite Evolution introduction">
    <video class="ee-intro__video" id="eeIntroVideo" muted loop playsinline preload="none" poster="{{ asset('frontend/video/property-welcome.jpg') }}" data-src="{{ asset('frontend/video/property-welcome.mp4') }}" aria-hidden="true" tabindex="-1"></video>
    <div class="ee-intro__inner">
        <img
            class="ee-intro__logo"
            src="{{ asset('management/images/elite-evolution-real-estate-in-white.png') }}"
            onerror="this.onerror=null;this.src='{{ asset('frontend/img/logo.png') }}';"
            alt="Elite Evolution Real Estate"
        >
        <span class="ee-intro__eyebrow">Dubai Luxury Real Estate</span>
        <button type="button" class="ee-intro__skip" id="eeIntroSkip">Skip intro</button>
    </div>
</div>

<script>
(function () {
    var KEY = 'ee_intro_seen_v1';
    var intro = document.getElementById('eeSiteIntro');
    if (!intro) return;
    var video = document.getElementById('eeIntroVideo');

    // Escape footer stacking context so the overlay covers the navbar
    if (intro.parentNode !== document.body) {
        document.body.appendChild(intro);
    }

    function markSeen() {
        if (video) video.pause();
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
    // Load the video only for visitors who see the intro and allow motion.
    if (video && !window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
        video.muted = true;
        video.src = video.dataset.src;
        var playback = video.play();
        if (playback) playback.catch(function () { /* Keep the poster if autoplay is blocked. */ });
    }

    var skipBtn = document.getElementById('eeIntroSkip');

    if (skipBtn) skipBtn.addEventListener('click', dismissIntro);


    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && !intro.classList.contains('is-hidden')) {
            dismissIntro();
        }
    });
})();
</script>
