<div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
    {{-- @foreach($pessoas as $pessoa)
        <div class="p-4 dark:bg-gray-900 dark:ring-white/10 border rounded-lg shadow-md antialiased">
            <h3 class="font-semibold text-lg mb-2">{{ $pessoa->nome }}</h3>
            <div><strong>Valor Total:</strong> R$ {{ number_format($divida->valor_total, 2, ',', '.') }}</div>
            <div><strong>Parcelas Restantes:</strong> {{ $divida->parcelas_restantes }}</div>
            <div><strong>Status:</strong> {{ isset($divida->status->nome) ? $divida->status->nome : null }}</div>
        </div>
    @endforeach --}}
</div>
