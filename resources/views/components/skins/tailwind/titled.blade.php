<div role="alert">
    <div class="bg-{{ $type ?? null }} text-white font-bold rounded-t px-4 py-2">
        {{ $title ?? null }}
    </div>
    <div class="border border-t-0 border-{{ $type ?? null }}-light rounded-b bg-{{ $type ?? null }}-lightest px-4 py-3 text-{{ $type ?? null }}-dark">
        <p>{{ $content ?? null }}</p>
    </div>
</div>