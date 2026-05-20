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
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 rounded-lg flex items-center justify-center bg-violet-100 dark:bg-violet-900/30">
                <svg class="w-4 h-4 text-violet-600 dark:text-violet-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
            </div>
            <div>
                <h2 class="text-base font-semibold text-gray-800 dark:text-white">{{ __('client.payment-methods.index') }}</h2>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">{{ __('client.payment-methods.index_description') }}</p>
            </div>
        </div>
        @if(isset($count) && $count > 3)
            <a class="inline-flex items-center gap-1 py-1.5 px-3 text-xs font-semibold rounded-lg text-violet-600 dark:text-violet-400 hover:bg-violet-50 dark:hover:bg-violet-900/20 transition-colors" href="{{ route('front.payment-methods.index') }}">
                {{ __('global.seemore') }}
                <svg class="w-3.5 h-3.5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
            </a>
        @endif
    </div>

    {{-- Liste des moyens de paiement --}}
    @if(count($sources) == 0)
        <div class="flex flex-col items-center justify-center py-12 px-6">
            <div class="w-12 h-12 rounded-xl bg-gray-100 dark:bg-gray-800/50 flex items-center justify-center mb-3">
                <svg class="w-6 h-6 text-gray-400 dark:text-gray-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
            </div>
            <p class="text-sm text-gray-500 dark:text-gray-400">{{ __('global.no_results') }}</p>
        </div>
    @else
        @foreach($sources as $i => $source)
            <div class="flex items-center gap-4 px-5 py-4 {{ !$loop->last ? 'border-b border-gray-50 dark:border-violet-900/10' : '' }} hover:bg-violet-50/30 dark:hover:bg-violet-900/10 transition-colors">

                {{-- Icône carte --}}
                <div class="flex-shrink-0 w-10 h-10 rounded-xl flex items-center justify-center bg-violet-50 dark:bg-violet-900/20">
                    @if($source->gateway_uuid == 'paypal_express_checkout')
                        <i class="bi bi-paypal text-blue-500 text-lg"></i>
                    @else
                        <svg class="w-5 h-5 text-violet-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
                    @endif
                </div>

                {{-- Infos --}}
                <div class="flex-1 min-w-0">
                    @if($source->gateway_uuid == 'paypal_express_checkout')
                        <p class="text-sm font-semibold text-gray-800 dark:text-gray-100">PayPal</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ $source->email }}</p>
                    @else
                        <p class="text-sm font-semibold text-gray-800 dark:text-gray-100 font-mono">•••• •••• •••• {{ $source->last4 ?? '----' }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Expire {{ $source->exp_month }}/{{ $source->exp_year }}</p>
                    @endif
                </div>

                {{-- Badge défaut --}}
                @if($source->isDefault())
                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-100 dark:bg-emerald-900/20 text-emerald-700 dark:text-emerald-400">
                        <svg class="w-3 h-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6 9 17l-5-5"/></svg>
                        {{ __('client.payment-methods.default') }}
                    </span>
                @endif

                {{-- Actions --}}
                <div class="flex items-center gap-2 flex-shrink-0">
                    @if(!$source->isDefault())
                        <form action="{{ route('front.payment-methods.default', ['paymentMethod' => $source->id]) }}" method="POST">
                            @csrf
                            <button type="submit" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-medium border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-600 dark:text-gray-300 hover:bg-violet-50 dark:hover:bg-violet-900/20 hover:text-violet-700 dark:hover:text-violet-300 hover:border-violet-300 dark:hover:border-violet-700 transition-colors">
                                <i class="bi bi-sliders2-vertical"></i>
                                {{ __('client.payment-methods.set_default') }}
                            </button>
                        </form>
                    @endif
                    <form action="{{ route('front.payment-methods.delete', ['paymentMethod' => $source->id]) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-medium bg-red-50 dark:bg-red-900/20 text-red-600 dark:text-red-400 border border-red-200 dark:border-red-800/50 hover:bg-red-100 dark:hover:bg-red-900/30 transition-colors">
                            <i class="bi bi-trash"></i>
                            {{ __('global.delete') }}
                        </button>
                    </form>
                </div>
            </div>
        @endforeach
    @endif
</div>
