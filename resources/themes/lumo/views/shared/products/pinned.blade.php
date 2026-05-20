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
$pricing   = $product->getPriceByCurrency(currency());
$showSetup = $pricing->hasSetup() && (isset($showSetup) ? $showSetup : true);
?>
<div class="group flex flex-col rounded-2xl overflow-hidden transition-all duration-300 hover:-translate-y-1"
     style="box-shadow:0 0 0 2px #7c3aed, 0 8px 32px rgba(109,40,217,0.25)">

    {{-- ===== HEADER premium ===== --}}
    <div class="relative flex flex-col items-center justify-center pt-8 pb-6 px-6"
         style="background:linear-gradient(135deg,#3b0764 0%,#6d28d9 45%,#c026d3 100%)">

        {{-- Orbes décoratifs --}}
        <div class="absolute top-0 left-0 w-32 h-32 rounded-full opacity-20 blur-2xl" style="background:#fff"></div>
        <div class="absolute bottom-0 right-0 w-24 h-24 rounded-full opacity-15 blur-2xl" style="background:#f0abfc"></div>

        {{-- Badge populaire --}}
        <div class="absolute top-4 right-4">
            <span class="inline-flex items-center gap-1 py-1 px-2.5 rounded-full text-xs font-bold text-white" style="background:rgba(255,255,255,0.2);border:1px solid rgba(255,255,255,0.3)">
                <svg class="w-3 h-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z"/></svg>
                {{ $product->hasMetadata('pinned_label') ? $product->getMetadata('pinned_label') : __('store.mustpopular') }}
            </span>
        </div>

        {{-- Icon --}}
        <div class="relative w-16 h-16 rounded-2xl flex items-center justify-center mb-4 shadow-xl"
             style="background:rgba(255,255,255,0.2);border:1px solid rgba(255,255,255,0.3)">
            @if ($product->image)
                <img src="{{ Storage::url($product->image) }}" alt="{{ $product->trans('name') }}" class="w-11 h-11 object-cover rounded-xl">
            @else
                <svg class="w-8 h-8 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="20" height="8" rx="2"/><rect x="2" y="14" width="20" height="8" rx="2"/><line x1="6" y1="6" x2="6.01" y2="6"/><line x1="6" y1="18" x2="6.01" y2="18"/></svg>
            @endif
        </div>

        {{-- Name --}}
        <h4 class="font-bold text-xl text-white text-center leading-tight">{{ $product->trans('name') }}</h4>

        {{-- Price --}}
        <div class="mt-3 text-center">
            @if ($pricing->isFree())
                <span class="text-5xl font-extrabold text-white">{{ __('global.free') }}</span>
            @elseif ($product->isPersonalized())
                <span class="text-2xl font-bold text-white/90">{{ __('store.product.personalized') }}</span>
            @else
                <div class="flex items-baseline justify-center gap-1">
                    <span class="text-5xl font-extrabold text-white">{{ $pricing->getPriceByDisplayMode() }}</span>
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
    <div class="flex flex-col flex-1 p-5 bg-white dark:bg-gray-800">

        @includeWhen(app('extension')->extensionIsEnabled('customers_reviews'), 'customers_reviews::partials.product_widgets', ['product' => $product])

        {{-- Features --}}
        <div class="flex-1 text-sm text-gray-600 dark:text-gray-400 [&_ul]:space-y-2 [&_li]:flex [&_li]:items-start [&_li]:gap-2 [&_li:before]:content-['✓'] [&_li:before]:font-bold [&_li:before]:shrink-0 [&_li:before]:mt-0.5 [&_li:before]:text-violet-500">
            {!! $product->trans('description') !!}
        </div>

        {{-- CTA --}}
        <div class="mt-5 pt-4 border-t border-gray-100 dark:border-gray-700">
            @if ($product->isOutOfStock())
                <button disabled class="w-full py-3.5 px-4 rounded-xl text-sm font-semibold text-gray-400 bg-gray-100 dark:bg-gray-700 cursor-not-allowed flex items-center justify-center gap-2">
                    @include("shared.icons.slash")
                    {{ __('store.product.outofstock') }}
                </button>
            @else
                <a href="{{ $basket_url ?? $product->basket_url() }}"
                   class="group/btn w-full py-3.5 px-4 rounded-xl text-sm font-semibold text-white flex items-center justify-center gap-2 transition-all duration-200 hover:-translate-y-0.5"
                   style="background:linear-gradient(135deg,#6d28d9,#c026d3);box-shadow:0 4px 18px rgba(109,40,217,0.4)">
                    {{ $basket_title ?? $product->basket_title() }}
                    <svg class="w-4 h-4 transition-transform duration-200 group-hover/btn:translate-x-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                </a>
            @endif
        </div>
    </div>
</div>
