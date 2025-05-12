@php
    use App\Models\Cartao;

@endphp
<div  class="fi-wi-stats-overview-stats-ctn grid gap-6 md:grid-cols-1">
    @foreach ($pessoas as $pessoa)
        @if ($pessoa->dividaTotalMes() > 0)
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
                            {{ $pessoa->nome }}
                        </span>
                    </div>


                    <div style="display: flex; justify-content: space-between;">
                        <div class="items-center gap-x-2">
                            <h3>Por Status</h3>
                            <span class="fi-wi-stats-overview-stat-description text-sm fi-color-custom text-custom-600 dark:text-custom-400 fi-color-danger "
                                style="--c-400:var(--danger-400);--c-600:var(--danger-600); display: flex;">
                                Total: R$ {{ $pessoa->dividaTotalMes() }}
                            </span>
                            <span class="fi-wi-stats-overview-stat-description text-sm fi-color-custom text-custom-600 dark:text-custom-400 fi-color-success "
                                style="--c-400:var(--success-400);--c-600:var(--success-600); display: flex;">
                                Pago: R$ {{ $pessoa->dividaTotalMesPago() }}
                            </span>
                            <span
                                class="fi-wi-stats-overview-stat-description text-sm fi-color-custom text-custom-600 dark:text-custom-400 fi-color-warning "
                                style="--c-400:var(--warning-400);--c-600:var(--warning-600); display: flex;"
                            >
                                Reservado: R$ {{ $pessoa->dividaTotalMesReservado() }}
                            </span>
                            <span
                                class="fi-wi-stats-overview-stat-description text-sm fi-color-custom text-custom-600 dark:text-custom-400 fi-color-info "
                                style="--c-400:var(--info-400);--c-600:var(--info-600); display: flex;"
                            >
                                Restante: R$ {{ $pessoa->dividaTotalMesRestante() }}
                            </span>
                        </div>
                        <div class="items-center gap-x-2">
                            <h3>Por Cartão</h3>
                            @foreach ($pessoa->dividaTotalCartoes() as $key => $toral)
                                <span class="fi-wi-stats-overview-stat-description text-sm fi-color-custom text-custom-600 dark:text-custom-400 fi-color-danger "
                                    style="--c-400:var(--danger-400);--c-600:var(--danger-600); display: flex;">
                                    {{ Cartao::findOrFail($key)->nome }}: R$ {{ $toral }}
                                </span>
                            @endforeach
                        </div>
                    </div>


                </div>
            </div>
        @endif
    @endforeach
</div>
