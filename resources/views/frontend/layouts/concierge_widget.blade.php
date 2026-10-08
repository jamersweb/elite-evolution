<style>
    .concierge-floating-btn {
        position: fixed;
        bottom: 30px;
        right: 30px;
        z-index: 9999;
        background: linear-gradient(135deg, #111111, #25221b);
        color: #b38b47;
        border: 2px solid #b38b47;
        border-radius: 50px;
        padding: 12px 22px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.3);
        display: flex;
        align-items: center;
        gap: 10px;
        font-weight: 700;
        font-size: 14px;
        letter-spacing: 0.5px;
        cursor: pointer;
        transition: transform 0.25s ease, box-shadow 0.25s ease;
    }
    .concierge-floating-btn:hover {
        transform: translateY(-3px) scale(1.02);
        box-shadow: 0 15px 35px rgba(179, 139, 71, 0.35);
        color: #fff;
    }
    .concierge-floating-btn .pulse-dot {
        width: 10px;
        height: 10px;
        background-color: #25D366;
        border-radius: 50%;
        display: inline-block;
        box-shadow: 0 0 0 0 rgba(37, 211, 102, 0.7);
        animation: pulse-green 2s infinite;
    }
    @keyframes pulse-green {
        0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(37, 211, 102, 0.7); }
        70% { transform: scale(1); box-shadow: 0 0 0 10px rgba(37, 211, 102, 0); }
        100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(37, 211, 102, 0); }
    }
    .concierge-modal {
        display: none;
        position: fixed;
        bottom: 95px;
        right: 30px;
        width: 380px;
        max-width: calc(100vw - 40px);
        height: 540px;
        max-height: calc(100vh - 120px);
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 20px 50px rgba(0,0,0,0.3);
        border: 1px solid #e0d0b8;
        z-index: 10000;
        overflow: hidden;
        flex-direction: column;
    }
    .concierge-header {
        background: #111;
        color: #fff;
        padding: 16px 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 2px solid #b38b47;
    }
    .concierge-body {
        flex: 1;
        padding: 15px;
        overflow-y: auto;
        background: #fbfbfb;
        display: flex;
        flex-direction: column;
        gap: 12px;
    }
    .concierge-msg {
        max-width: 85%;
        padding: 10px 14px;
        border-radius: 10px;
        font-size: 13px;
        line-height: 1.45;
    }
    .concierge-msg-bot {
        align-self: flex-start;
        background: #f1ede4;
        color: #1a1a1a;
        border-bottom-left-radius: 2px;
    }
    .concierge-msg-user {
        align-self: flex-end;
        background: #111;
        color: #fff;
        border-bottom-right-radius: 2px;
    }
    .concierge-footer {
        padding: 12px;
        background: #fff;
        border-top: 1px solid #eee;
    }
    .concierge-input-group {
        display: flex;
        gap: 8px;
    }
    .concierge-chip {
        display: inline-block;
        background: #fff;
        border: 1px solid #b38b47;
        color: #111;
        font-size: 11px;
        padding: 4px 10px;
        border-radius: 14px;
        margin-right: 5px;
        margin-bottom: 5px;
        cursor: pointer;
        transition: all 0.2s;
    }
    .concierge-chip:hover {
        background: #b38b47;
        color: #fff;
    }
</style>

<!-- Concierge Floating Trigger Button -->
<button class="concierge-floating-btn" id="conciergeToggleBtn" aria-label="Open AI Concierge">
    <span class="pulse-dot"></span>
    <i class="fa-solid fa-headset"></i>
    <span>AI Concierge</span>
</button>

<!-- Concierge Chat Window -->
<div class="concierge-modal" id="conciergeModal">
    <div class="concierge-header">
        <div>
            <h6 class="mb-0 fw-bold" style="font-family: serif; color: #b38b47;"><i class="fa-solid fa-shield-halved me-1"></i> Elite Evolution Concierge</h6>
            <small class="text-white-50" style="font-size: 11px;">Live Inventory & DLD Advisory</small>
        </div>
        <button class="btn btn-sm btn-link text-white-50 p-0 text-decoration-none" id="conciergeCloseBtn" style="font-size: 18px;">
            <i class="fa-solid fa-xmark"></i>
        </button>
    </div>

    <div class="concierge-body" id="conciergeMessages">
        <div class="concierge-msg concierge-msg-bot">
            Hello! I am the automated AI Concierge for Elite Evolution Real Estate. How can I assist with your Dubai luxury property search today?
        </div>
        <div class="concierge-quick-chips">
            <span class="concierge-chip" onclick="sendQuickPrompt('Show me villas in Palm Jumeirah')">Palm Jumeirah Villas</span>
            <span class="concierge-chip" onclick="sendQuickPrompt('Show me luxury rentals in Dubai')">Luxury Rentals</span>
            <span class="concierge-chip" onclick="sendQuickPrompt('What are UAE Golden Visa requirements?')">Golden Visa Criteria</span>
            <span class="concierge-chip" onclick="sendQuickPrompt('Are all listings verified with DLD permit?')">DLD Madmoun Permits</span>
        </div>
    </div>

    <div class="concierge-footer">
        <form id="conciergeForm" onsubmit="handleConciergeSubmit(event)">
            <div class="concierge-input-group">
                <input type="text" id="conciergeInput" class="form-control form-control-sm" placeholder="Ask about villas, off-plan, rentals..." autocomplete="off" required>
                <button type="submit" class="btn btn-sm btn-dark px-3" style="background: #111; border-color: #b38b47; color: #b38b47;">
                    <i class="fa-solid fa-paper-plane"></i>
                </button>
            </div>
            <div class="d-flex justify-content-between align-items-center mt-2 px-1">
                <small class="text-muted" style="font-size: 10px;">Automated Assistant</small>
                <a href="https://wa.me/971501234567?text=Hello%20Elite%20Evolution,%20I%20would%20like%20to%20speak%20with%20a%20licensed%20advisor." target="_blank" class="text-decoration-none text-success fw-bold" style="font-size: 11px;">
                    <i class="fa-brands fa-whatsapp me-1"></i> WhatsApp Broker
                </a>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        var toggleBtn = document.getElementById('conciergeToggleBtn');
        var closeBtn = document.getElementById('conciergeCloseBtn');
        var modal = document.getElementById('conciergeModal');

        if (toggleBtn && modal) {
            toggleBtn.addEventListener('click', function () {
                modal.style.display = modal.style.display === 'flex' ? 'none' : 'flex';
                if (modal.style.display === 'flex') {
                    document.getElementById('conciergeInput').focus();
                }
            });
        }

        if (closeBtn && modal) {
            closeBtn.addEventListener('click', function () {
                modal.style.display = 'none';
            });
        }
    });

    function appendMessage(text, isUser) {
        var container = document.getElementById('conciergeMessages');
        var msgDiv = document.createElement('div');
        msgDiv.className = 'concierge-msg ' + (isUser ? 'concierge-msg-user' : 'concierge-msg-bot');
        msgDiv.innerHTML = text.replace(/\n/g, '<br>');
        container.appendChild(msgDiv);
        container.scrollTop = container.scrollHeight;
    }

    function sendQuickPrompt(promptText) {
        document.getElementById('conciergeInput').value = promptText;
        document.getElementById('conciergeForm').dispatchEvent(new Event('submit', { cancelable: true, bubbles: true }));
    }

    function handleConciergeSubmit(e) {
        e.preventDefault();
        var input = document.getElementById('conciergeInput');
        var text = input.value.trim();
        if (!text) return;

        appendMessage(text, true);
        input.value = '';

        var container = document.getElementById('conciergeMessages');
        var typingIndicator = document.createElement('div');
        typingIndicator.className = 'concierge-msg concierge-msg-bot text-muted';
        typingIndicator.id = 'typingIndicator';
        typingIndicator.innerHTML = '<i class="fa-solid fa-spinner fa-spin me-1"></i> Reviewing luxury inventory...';
        container.appendChild(typingIndicator);
        container.scrollTop = container.scrollHeight;

        fetch('{{ url("/api/concierge/chat") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ message: text })
        })
        .then(function (res) { return res.json(); })
        .then(function (data) {
            var indicator = document.getElementById('typingIndicator');
            if (indicator) indicator.remove();
            appendMessage(data.reply || 'Thank you for reaching out. A licensed broker is available on WhatsApp for immediate support.', false);
        })
        .catch(function (err) {
            var indicator = document.getElementById('typingIndicator');
            if (indicator) indicator.remove();
            appendMessage('Unable to connect to live inventory right now. Please connect directly via WhatsApp: +971 50 123 4567', false);
        });
    }
</script>
