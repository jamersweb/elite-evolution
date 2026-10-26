<style>
    .ee-intro {
        position: fixed;
        inset: 0;
        z-index: 20000;
        display: flex;
        align-items: center;
        justify-content: center;
        background:
            linear-gradient(160deg, rgba(10, 10, 10, 0.92) 0%, rgba(20, 18, 14, 0.88) 45%, rgba(12, 12, 12, 0.94) 100%),
            url('{{ asset('frontend/img/banner_update.jpg') }}') center / cover no-repeat;
        color: #fff;
        opacity: 1;
        transition: opacity 0.55s ease, visibility 0.55s ease;
        visibility: visible;
    }
    .ee-intro.is-leaving {
        opacity: 0;
        visibility: hidden;
        pointer-events: none;
    }
    .ee-intro.is-hidden {
        display: none;
    }
    .ee-intro__inner {
        text-align: center;
        max-width: 560px;
        padding: 32px 24px;
        transform: translateY(18px);
        opacity: 0;
        animation: eeIntroIn 0.7s ease 0.15s forwards;
    }
    .ee-intro__logo {
        height: 56px;
        width: auto;
        max-width: 240px;
        object-fit: contain;
        margin-bottom: 28px;
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
    }
    .ee-intro__btn--gold {
        background: #b38b47;
        color: #fff;
        border-color: #b38b47;
    }
    .ee-intro__btn--gold:hover {
        background: #9a7538;
        color: #fff;
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
        display: block;
        margin-top: 22px;
        background: none;
        border: 0;
        color: rgba(255, 255, 255, 0.55);
        font-size: 12px;
        letter-spacing: 1px;
        text-transform: uppercase;
        cursor: pointer;
        text-decoration: underline;
        text-underline-offset: 3px;
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

<div class="ee-intro is-hidden" id="eeSiteIntro" role="dialog" aria-modal="true" aria-labelledby="eeIntroTitle" hidden>
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

    function dismissIntro() {
        try { localStorage.setItem(KEY, '1'); } catch (e) {}
        intro.classList.add('is-leaving');
        document.documentElement.style.overflow = '';
        setTimeout(function () {
            intro.classList.add('is-hidden');
            intro.setAttribute('hidden', '');
            intro.classList.remove('is-leaving');
        }, 560);
    }

    try {
        if (localStorage.getItem(KEY) === '1') return;
    } catch (e) {}

    intro.removeAttribute('hidden');
    intro.classList.remove('is-hidden');
    document.documentElement.style.overflow = 'hidden';

    var enterBtn = document.getElementById('eeIntroEnter');
    var skipBtn = document.getElementById('eeIntroSkip');
    var waBtn = document.getElementById('eeIntroWhatsApp');

    if (enterBtn) enterBtn.addEventListener('click', dismissIntro);
    if (skipBtn) skipBtn.addEventListener('click', dismissIntro);
    if (waBtn) {
        waBtn.addEventListener('click', function () {
            try { localStorage.setItem(KEY, '1'); } catch (e) {}
        });
    }

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && !intro.classList.contains('is-hidden')) {
            dismissIntro();
        }
    });
})();
</script>
