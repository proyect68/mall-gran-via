@props(['stores', 'carousel' => false])

@once
    <style>
        .store-grid-unified { display: grid; grid-template-columns: repeat(auto-fill, minmax(275px, 1fr)); gap: 22px; }
        .store-carousel-unified { display: flex; gap: 18px; overflow-x: auto; scroll-behavior: smooth; padding: 4px 2px 16px; }
        .store-carousel-unified > * { flex: 0 0 300px; }
        .store-carousel-unified::-webkit-scrollbar { height: 8px; }
        .store-carousel-unified::-webkit-scrollbar-track { background: rgba(255,255,255,.25); border-radius: 10px; }
        .store-carousel-unified::-webkit-scrollbar-thumb { background: rgba(55,53,175,.35); border-radius: 10px; }
    </style>
@endonce

<div {{ $attributes->merge(['class' => $carousel ? 'store-carousel-unified' : 'store-grid-unified']) }}>
    @foreach($stores as $store)
        <x-store-card :store="$store" />
    @endforeach
</div>
