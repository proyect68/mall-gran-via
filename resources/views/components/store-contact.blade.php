@props(['facebook' => null, 'instagram' => null, 'whatsapp' => null, 'email' => null, 'telefono' => null, 'tiktok' => null])

@php
    $contacts = collect([
        ['label' => 'Facebook', 'icon' => 'bi-facebook', 'url' => $facebook, 'class' => 'contact-facebook'],
        ['label' => 'Instagram', 'icon' => 'bi-instagram', 'url' => $instagram, 'class' => 'contact-instagram'],
        ['label' => 'WhatsApp', 'icon' => 'bi-whatsapp', 'url' => $whatsapp ? 'https://wa.me/' . preg_replace('/[^0-9]/', '', $whatsapp) : null, 'class' => 'contact-whatsapp'],
        ['label' => 'E-Mail', 'icon' => 'bi-envelope-fill', 'url' => $email ? 'mailto:' . $email : null, 'class' => 'contact-email'],
        ['label' => 'Teléfono', 'icon' => 'bi-telephone-fill', 'url' => $telefono ? 'tel:' . $telefono : null, 'class' => 'contact-phone'],
        ['label' => 'TikTok', 'icon' => 'bi-tiktok', 'url' => $tiktok, 'class' => 'contact-tiktok'],
    ])->filter(fn ($item) => ! empty($item['url']));
@endphp

@if($contacts->isNotEmpty())
    <div class="store-contact-list">
        @foreach($contacts as $contact)
            <a href="{{ $contact['url'] }}" target="_blank" rel="noopener noreferrer" class="store-contact-pill {{ $contact['class'] }}">
                <i class="bi {{ $contact['icon'] }}"></i>
                <span>{{ $contact['label'] }}</span>
            </a>
        @endforeach
    </div>
@else
    <p class="empty-muted">No hay medios de contacto registrados.</p>
@endif

<style>
    .store-contact-list { display: flex; flex-wrap: wrap; gap: 12px; }
    .store-contact-pill { display: inline-flex; align-items: center; gap: 8px; border-radius: 999px; padding: 9px 14px; color: #fff; font-weight: 700; text-decoration: none; }
    .store-contact-pill:hover { color: #fff; filter: brightness(.94); }
    .contact-facebook { background: #1877f2; }
    .contact-instagram { background: #c13584; }
    .contact-whatsapp { background: #1f9d55; }
    .contact-email { background: #d94841; }
    .contact-phone { background: #3735af; }
    .contact-tiktok { background: #111827; }
    .empty-muted { color: #8a8fa8; font-style: italic; margin: 0; }
</style>
