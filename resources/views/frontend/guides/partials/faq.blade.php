@php $faqId = 'gdFaq'.md5($faqs[0]['q'] ?? 'faq'); @endphp
<section class="gd-section gd-faq">
    <div class="gd-wrap">
        <div class="gd-section-head">
            <div>
                <p class="gd-kicker">Questions</p>
                <h2>FAQ</h2>
            </div>
            <a class="gd-link" href="{{ url('contact-us') }}">Ask your question</a>
        </div>
        <div class="accordion" id="{{ $faqId }}">
            @foreach($faqs as $faq)
                <div class="accordion-item">
                    <h3 class="accordion-header" id="{{ $faqId }}h{{ $loop->index }}">
                        <button class="accordion-button {{ $loop->first ? '' : 'collapsed' }}" type="button" data-bs-toggle="collapse" data-bs-target="#{{ $faqId }}c{{ $loop->index }}" aria-expanded="{{ $loop->first ? 'true' : 'false' }}">
                            {{ $faq['q'] }}
                        </button>
                    </h3>
                    <div id="{{ $faqId }}c{{ $loop->index }}" class="accordion-collapse collapse {{ $loop->first ? 'show' : '' }}" data-bs-parent="#{{ $faqId }}">
                        <div class="accordion-body">{{ $faq['a'] }}</div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
