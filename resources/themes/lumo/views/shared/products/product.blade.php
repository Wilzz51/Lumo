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
$pricing   = $product->getPriceByCurrency(currency(), $billing ?? null);
$showSetup = $pricing->hasSetup() && (isset($showSetup) ? $showSetup : true);
?>
<div class="group flex flex-col rounded-2xl overflow-hidden shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700/60">

    {{-- ===== HEADER coloré ===== --}}
    <div class="relative flex flex-col items-center justify-center pt-8 pb-6 px-6"
         style="background:linear-gradient(135deg,#4c1d95 0%,#6d28d9 50%,#7e22ce 100%)">

        {{-- Motif discret --}}
        <div class="absolute inset-0 opacity-10" style="background-image:radial-gradient(circle at 20% 50%,#fff 1px,transparent 1px),radial-gradient(circle at 80% 20%,#fff 1px,transparent 1px);background-size:24px 24px"></div>

        {{-- Icon --}}
        <div class="relative w-14 h-14 rounded-2xl flex items-center justify-center mb-4 shadow-lg"
             style="background:rgba(255,255,255,0.15);border:1px solid rgba(255,255,255,0.25);backdrop-filter:blur(4px)">
            @if ($product->image)
                <img src="{{ Storage::url($product->image) }}" alt="{{ $product->trans('name') }}" class="w-10 h-10 object-cover rounded-xl">
            @else
                <svg class="w-7 h-7 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="20" height="8" rx="2"/><rect x="2" y="14" width="20" height="8" rx="2"/><line x1="6" y1="6" x2="6.01" y2="6"/><line x1="6" y1="18" x2="6.01" y2="18"/></svg>
            @endif
        </div>

        {{-- Name --}}
        <h4 class="font-bold text-lg text-white text-center leading-tight">{{ $product->trans('name') }}</h4>

        {{-- Price --}}
        <div class="mt-3 text-center">
            @if ($pricing->isFree())
                <span class="text-4xl font-extrabold text-white">{{ __('global.free') }}</span>
            @elseif ($product->isPersonalized())
                <span class="text-2xl font-bold text-white/90">{{ __('store.product.personalized') }}</span>
            @else
                <div class="flex items-baseline justify-center gap-1">
                    <span class="text-4xl font-extrabold text-white">{{ $pricing->getPriceByDisplayMode() }}</span>
                    <span class="text-base font-medium text-white/60">{{ $pricing->getSymbol() }}</span>
                </div>
                <p class="text-xs text-white/50 mt-0.5">{{ $pricing->taxTitle() }}</p>
                @if ($showSetup)
                    <p class="text-xs text-white/50 mt-0.5">{{ $pricing->pricingMessage() }}</p>
                @endif
            @endif
        </div>
    </div>

    {{-- ===== CONTENU ===== --}}
    <div class="flex flex-col flex-1 p-5">

        @includeWhen(app('extension')->extensionIsEnabled('customers_reviews'), 'customers_reviews::partials.product_widgets', ['product' => $product])

        {{-- Features --}}
        <div class="flex-1 text-sm text-gray-600 dark:text-gray-400 [&_ul]:space-y-2 [&_li]:flex [&_li]:items-start [&_li]:gap-2 [&_li:before]:content-['✓'] [&_li:before]:font-bold [&_li:before]:shrink-0 [&_li:before]:mt-0.5" style="[&_li:before]{color:#7c3aed}">
            {!! $product->trans('description') !!}
        </div>

        {{-- CTA --}}
        <div class="mt-5 pt-4 border-t border-gray-100 dark:border-gray-700">
            @if ($product->isOutOfStock())
                <button disabled class="w-full py-3 px-4 rounded-xl text-sm font-semibold text-gray-400 bg-gray-100 dark:bg-gray-700 cursor-not-allowed flex items-center justify-center gap-2">
                    @include("shared.icons.slash")
                    {{ __('store.product.outofstock') }}
                </button>
            @else
                <a href="{{ $basket_url ?? $product->basket_url() }}"
                   class="group/btn w-full py-3 px-4 rounded-xl text-sm font-semibold text-white flex items-center justify-center gap-2 transition-all duration-200 hover:-translate-y-0.5"
                   style="background:linear-gradient(135deg,#6d28d9,#a855f7);box-shadow:0 4px 14px rgba(109,40,217,0.3)">
                    {{ $basket_title ?? $product->basket_title() }}
                    <svg class="w-4 h-4 transition-transform duration-200 group-hover/btn:translate-x-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                </a>
            @endif
        </div>
    </div>
</div>
