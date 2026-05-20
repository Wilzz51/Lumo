<?php
/*
 * This file is part of the CLIENTXCMS project.
 * It is the property of the CLIENTXCMS association.
 *
 * Personal and non-commercial use of this source code is permitted.
 * However, any use in a project that generates profit (directly or indirectly),
 * or any reuse for commercial purposes, requires prior authorization from CLIENTXCMS.
 *
 * To request permission or for more information, please contact our support:
 * https://clientxcms.com/client/support
 *
 * Learn more about CLIENTXCMS License at:
 * https://clientxcms.com/eula
 *
 * Year: 2025
 */
?>

<div class="mb-4 rounded-xl border overflow-hidden shadow-sm bg-white dark:bg-[#0f0527] border-gray-100 dark:border-violet-900/20">

    {{-- Header --}}
    <div class="px-5 py-4 flex items-center justify-between border-b border-gray-100 dark:border-violet-900/20">
        <div>
            <h2 class="text-base font-semibold text-gray-800 dark:text-white">{{ __('client.invoices.index') }}</h2>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">{{ __('client.invoices.index_description') }}</p>
        </div>
        <div class="flex items-center gap-2">
            @if(isset($count) && $count > 3)
                <a class="inline-flex items-center gap-1 py-1.5 px-3 text-xs font-semibold rounded-lg text-violet-600 dark:text-violet-400 hover:bg-violet-50 dark:hover:bg-violet-900/20 transition-colors" href="{{ route('front.invoices.index') }}">
                    {{ __('global.seemore') }}
                    <svg class="w-3.5 h-3.5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
                </a>
            @endif
            <div class="hs-dropdown relative inline-block [--placement:bottom-right]" data-hs-dropdown-auto-close="inside">
                <button type="button" class="inline-flex items-center gap-1.5 py-1.5 px-2.5 text-xs font-medium rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                    <svg class="w-3 h-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 6h18"/><path d="M7 12h10"/><path d="M10 18h4"/></svg>
                    {{ __('global.filter') }}
                    @if ($filter)
                        <span class="pl-1.5 text-xs font-semibold text-violet-600 dark:text-violet-400 border-l border-gray-200 dark:border-gray-700">{{ count($invoices) }}</span>
                    @endif
                </button>
                <div class="hs-dropdown-menu transition-[opacity,margin] duration hs-dropdown-open:opacity-100 opacity-0 hidden mt-2 min-w-[12rem] z-[9999] bg-white dark:bg-gray-800 shadow-md rounded-lg border border-gray-100 dark:border-gray-700">
                    @foreach ($filters as $current)
                        <label for="filter-invoice-{{ $current }}" class="flex py-2.5 px-3 cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                            <input id="filter-invoice-{{ $current }}" value="{{ $current }}" data-redirect="{{ route('front.invoices.index') }}" type="checkbox" class="filter-checkbox shrink-0 mt-0.5 border-gray-300 rounded text-violet-600 focus:ring-violet-500 dark:bg-gray-700 dark:border-gray-600 dark:checked:bg-violet-500 dark:checked:border-violet-500 dark:focus:ring-offset-gray-800" @if ($current == $filter) checked @endif>
                            <span class="ms-3 text-sm text-gray-800 dark:text-gray-200">{{ __('global.states.' . $current) }}</span>
                        </label>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    {{-- List --}}
    @if(count($invoices) == 0)
        <div class="flex flex-col items-center justify-center py-12 px-6">
            <svg class="w-10 h-10 text-gray-300 dark:text-gray-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16c0 1.1.9 2 2 2h12a2 2 0 0 0 2-2V8l-6-6z"/><path d="M14 3v5h5M16 13H8M16 17H8M10 9H8"/></svg>
            <p class="mt-4 text-sm text-gray-500 dark:text-gray-400">{{ __('global.no_results') }}</p>
        </div>
    @endif

    @foreach($invoices as $invoice)
        <div class="flex items-center gap-4 px-5 py-3.5 {{ !$loop->last ? 'border-b border-gray-50 dark:border-violet-900/10' : '' }} hover:bg-violet-50/30 dark:hover:bg-violet-900/10 transition-colors">

            {{-- Icon --}}
            <div class="flex-shrink-0 w-9 h-9 rounded-xl flex items-center justify-center
                {{ $invoice->status === 'paid' ? 'bg-emerald-50 dark:bg-emerald-900/20' : ($invoice->status === 'pending' ? 'bg-amber-50 dark:bg-amber-900/20' : 'bg-red-50 dark:bg-red-900/20') }}">
                <svg class="w-4 h-4 {{ $invoice->status === 'paid' ? 'text-emerald-500' : ($invoice->status === 'pending' ? 'text-amber-500' : 'text-red-500') }}"
                     xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16c0 1.1.9 2 2 2h12a2 2 0 0 0 2-2V8l-6-6z"/>
                    <path d="M14 3v5h5M16 13H8M16 17H8M10 9H8"/>
                </svg>
            </div>

            {{-- ID + date --}}
            <div class="flex-1 min-w-0">
                <p class="text-sm font-mono font-semibold text-violet-600 dark:text-violet-400">{{ $invoice->identifier() }}</p>
                <p class="text-xs text-gray-500 dark:text-gray-400">{{ $invoice->created_at->format('d/m/Y') }}</p>
            </div>

            {{-- Amount --}}
            <div class="hidden sm:block flex-shrink-0 text-right">
                <p class="text-sm font-bold text-gray-800 dark:text-white">{{ formatted_price($invoice->total, $invoice->currency) }}</p>
                <p class="text-xs text-gray-400 dark:text-gray-500">Échéance {{ $invoice->due_date->format('d/m/Y') }}</p>
            </div>

            {{-- Status --}}
            <div class="flex-shrink-0">
                <x-badge-state state="{{ $invoice->status }}"></x-badge-state>
            </div>

            {{-- View button --}}
            <a href="{{ route('front.invoices.show', ['invoice' => $invoice]) }}"
               class="flex-shrink-0 inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold text-white transition-all duration-200 hover:-translate-y-px"
               style="background:linear-gradient(135deg,#7c3aed,#a855f7);box-shadow:0 2px 8px rgba(124,58,237,0.25)">
                <i class="bi bi-eye-fill"></i>
                {{ __('global.view') }}
            </a>
        </div>
    @endforeach

    <div class="px-5 py-3 border-t border-gray-100 dark:border-violet-900/20">
        {{ $invoices->links('shared.layouts.pagination') }}
    </div>
</div>
