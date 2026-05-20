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
            <h2 class="text-base font-semibold text-gray-800 dark:text-white">{{ __('client.services.index') }}</h2>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">{{ __('client.services.index_description') }}</p>
        </div>
        <div class="flex items-center gap-2">
            @if(isset($count) && $count > 3)
                <a class="inline-flex items-center gap-1 py-1.5 px-3 text-xs font-semibold rounded-lg text-violet-600 dark:text-violet-400 hover:bg-violet-50 dark:hover:bg-violet-900/20 transition-colors" href="{{ route('front.services.index') }}">
                    {{ __('global.seemore') }}
                    <svg class="w-3.5 h-3.5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
                </a>
            @endif
            <div class="hs-dropdown relative inline-block [--placement:bottom-right]" data-hs-dropdown-auto-close="inside">
                <button type="button" class="inline-flex items-center gap-1.5 py-1.5 px-2.5 text-xs font-medium rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                    <svg class="w-3 h-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 6h18"/><path d="M7 12h10"/><path d="M10 18h4"/></svg>
                    {{ __('global.filter') }}
                    @if ($filter)
                        <span class="pl-1.5 text-xs font-semibold text-violet-600 dark:text-violet-400 border-l border-gray-200 dark:border-gray-700">{{ count($services) }}</span>
                    @endif
                </button>
                <div class="hs-dropdown-menu transition-[opacity,margin] duration hs-dropdown-open:opacity-100 opacity-0 hidden mt-2 min-w-[12rem] z-[9999] bg-white dark:bg-gray-800 shadow-md rounded-lg border border-gray-100 dark:border-gray-700">
                    @foreach ($filters as $current => $value)
                        <label for="filter-service-{{ $current }}" class="flex py-2.5 px-3 cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                            <input id="filter-service-{{ $current }}" value="{{ $current }}" type="checkbox" data-redirect="{{ route('front.services.index') }}" class="filter-checkbox shrink-0 mt-0.5 border-gray-300 rounded text-violet-600 focus:ring-violet-500 dark:bg-gray-700 dark:border-gray-600 dark:checked:bg-violet-500 dark:checked:border-violet-500 dark:focus:ring-offset-gray-800" @if ($current == $filter) checked @endif>
                            <span class="ms-3 text-sm text-gray-800 dark:text-gray-200">{{ in_array($value, array_keys(__('global.states'))) ? __('global.states.' . $value) : $value }}</span>
                        </label>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    {{-- List --}}
    @if(count($services) == 0)
        <div class="flex flex-col items-center justify-center py-12 px-6">
            @include("shared.icons.shopping-cart")
            <p class="mt-4 text-sm text-gray-500 dark:text-gray-400">{{ __('client.services.noservices') }}</p>
            <a href="{{ route('front.store.index') }}" class="mt-3 inline-flex items-center gap-1 text-sm font-semibold text-violet-600 hover:text-violet-800 dark:text-violet-400 transition-colors">
                {{ __('client.services.startorder') }}
                <svg class="w-3.5 h-3.5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
            </a>
        </div>
    @endif

    @foreach($services as $i => $service)
        <div class="flex items-center gap-4 px-5 py-3.5 {{ !$loop->last ? 'border-b border-gray-50 dark:border-violet-900/10' : '' }} hover:bg-violet-50/30 dark:hover:bg-violet-900/10 transition-colors">

            {{-- Status dot --}}
            <div class="flex-shrink-0 w-9 h-9 rounded-xl flex items-center justify-center
                {{ $service->status === 'active' ? 'bg-emerald-50 dark:bg-emerald-900/20' : ($service->status === 'suspended' ? 'bg-amber-50 dark:bg-amber-900/20' : 'bg-gray-50 dark:bg-gray-800/50') }}">
                <span class="w-2.5 h-2.5 rounded-full {{ $service->status === 'active' ? 'animate-pulse' : '' }}"
                      style="background:{{ $service->status === 'active' ? '#10b981' : ($service->status === 'suspended' ? '#f59e0b' : '#9ca3af') }};
                             {{ $service->status === 'active' ? 'box-shadow:0 0 6px rgba(16,185,129,0.6)' : '' }}"></span>
            </div>

            {{-- Name + price --}}
            <div class="flex-1 min-w-0">
                <p class="text-sm font-semibold text-gray-800 dark:text-gray-100 truncate">{{ $service->excerptName() }}</p>
                <p class="text-xs text-gray-500 dark:text-gray-400">{{ formatted_price($service->getBillingPrice()->displayPrice(), $service->currency) }}</p>
            </div>

            {{-- Status badge --}}
            <div class="hidden sm:block flex-shrink-0">
                <x-badge-state state="{{ $service->status }}"></x-badge-state>
            </div>

            {{-- Expiry --}}
            <div class="hidden md:block flex-shrink-0">
                <x-service-days-remaining expires_at="{{ $service->expires_at }}" state="{{ $service->status }}"></x-service-days-remaining>
            </div>

            {{-- Actions --}}
            <div class="flex items-center gap-1.5 flex-shrink-0">
                @if ($service->canManage())
                    <a href="{{ route('front.services.show', ['service' => $service]) }}"
                       class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold text-white transition-all duration-200 hover:-translate-y-px"
                       style="background:linear-gradient(135deg,#7c3aed,#a855f7);box-shadow:0 2px 8px rgba(124,58,237,0.25)">
                        <svg class="w-3 h-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="4" y1="21" x2="4" y2="14"/><line x1="4" y1="10" x2="4" y2="3"/><line x1="12" y1="21" x2="12" y2="12"/><line x1="12" y1="8" x2="12" y2="3"/><line x1="20" y1="21" x2="20" y2="16"/><line x1="20" y1="12" x2="20" y2="3"/><line x1="1" y1="14" x2="7" y2="14"/><line x1="9" y1="8" x2="15" y2="8"/><line x1="17" y1="16" x2="23" y2="16"/></svg>
                        {{ __('client.services.managebtn') }}
                    </a>
                @endif
                @if ($service->canRenew() && !isset($count))
                    <div class="hs-dropdown relative inline-flex" style="z-index:{{ 9999 - $i }}">
                        <button class="hs-dropdown-toggle inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg text-xs font-medium border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                            <svg class="w-3 h-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21.5 2v6h-6M2.5 22v-6h6M2 11.5a10 10 0 0 1 18.8-4.3M22 12.5a10 10 0 0 1-18.8 4.2"/></svg>
                            {{ __('client.services.renewbtn') }}
                            <svg class="hs-dropdown-open:rotate-180 w-3 h-3 transition-transform" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m6 9 6 6 6-6"/></svg>
                        </button>
                        <div class="hs-dropdown-menu transition-[opacity,margin] duration hs-dropdown-open:opacity-100 opacity-0 hidden min-w-[12rem] bg-white dark:bg-gray-800 shadow-md rounded-lg border border-gray-100 dark:border-gray-700">
                            @foreach ($gateways as $gateway)
                                <a class="flex items-center gap-3 py-2 px-3 rounded-lg text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors" href="{{ route('front.services.renew', ['service' => $service, 'gateway' => $gateway->uuid]) }}">
                                    {{ $gateway->name }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
    @endforeach

    @if (!isset($count) && count($services) > 0)
        <div class="px-5 py-3 border-t border-gray-100 dark:border-violet-900/20">
            {{ $services->links('shared.layouts.pagination') }}
        </div>
    @endif
</div>
