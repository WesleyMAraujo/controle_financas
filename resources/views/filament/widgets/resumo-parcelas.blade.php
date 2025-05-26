@php
    use App\Models\Cartao;

@endphp
<div  class="fi-wi-stats-overview-stats-ctn grid gap-6 md:grid-cols-1">
    <div class="fi-wi-stats-overview-stat relative rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
        <div class="grid gap-y-2">
            <div class="flex items-center gap-x-2">
                <svg class="di-wi-stats-overview-stat-icon h-5 w-5 text-gray-400 dark:text-gray-500"
                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" className="size-6">
                    <path strokeLinecap="round" strokeLinejoin="round"
                        d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                </svg>

                <span class="fi-wi-stats-overview-stat-label text-sm font-medium text-gray-500 dark:text-gray-400">
                    Resumo Por Status
                </span>
            </div>

            <div>
                <div class="items-center gap-x-2">
                    @foreach ($resumoPorStatus as $resumo)
                        <span
                            class="fi-wi-stats-overview-stat-description text-sm fi-color-custom text-custom-600 dark:text-custom-400" style=" display: flex; color: {{ $resumo->status->color }};">
                            {{ $resumo->status->nome }} ({{ $resumo->total_parcelas }}): R$ {{ $resumo->soma_valor_parcelas }}
                        </span>
                    @endforeach
                </div>
            </div>


        </div>
    </div>
</div>
