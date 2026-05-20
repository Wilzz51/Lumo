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

@extends('layouts/client')
@section('title', __('client.services.show'))
@section('content')

    {{-- ===== BANNER ===== --}}
    @if(is_darkmode())
        <div class="page-banner-dark py-8 border-b" style="border-color:rgba(255,255,255,0.05)">
            <div class="absolute left-1/4 top-0 w-56 h-56 bg-violet-500/15 rounded-full blur-3xl pointer-events-none"></div>
            <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center gap-4">
                <div class="flex-shrink-0 w-12 h-12 rounded-xl flex items-center justify-center shadow-lg"
                     style="background:linear-gradient(135deg,#7c3aed,#c026d3);box-shadow:0 4px 16px rgba(124,58,237,0.4)">
                    <svg class="w-6 h-6 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="20" height="8" rx="2"/><rect x="2" y="14" width="20" height="8" rx="2"/><line x1="6" y1="6" x2="6.01" y2="6"/><line x1="6" y1="18" x2="6.01" y2="18"/></svg>
                </div>
                <div>
                    <p class="text-violet-300/70 text-xs font-medium uppercase tracking-wider mb-0.5">{{ __('client.services.show') }}</p>
                    <h1 class="text-xl font-bold text-white">{{ $service->name }}</h1>
                </div>
                <div class="ml-auto">
                    <x-badge-state state="{{ $service->status }}"></x-badge-state>
                </div>
            </div>
        </div>
    @else
        <div class="py-8 bg-white border-b border-gray-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center gap-4">
                <div class="flex-shrink-0 w-12 h-12 rounded-xl flex items-center justify-center shadow-sm"
                     style="background:linear-gradient(135deg,#7c3aed,#c026d3)">
                    <svg class="w-6 h-6 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="20" height="8" rx="2"/><rect x="2" y="14" width="20" height="8" rx="2"/><line x1="6" y1="6" x2="6.01" y2="6"/><line x1="6" y1="18" x2="6.01" y2="18"/></svg>
                </div>
                <div>
                    <p class="text-gray-400 text-xs font-medium uppercase tracking-wider mb-0.5">{{ __('client.services.show') }}</p>
                    <h1 class="text-xl font-bold text-gray-900">{{ $service->name }}</h1>
                </div>
                <div class="ml-auto">
                    <x-badge-state state="{{ $service->status }}"></x-badge-state>
                </div>
            </div>
        </div>
    @endif

    {{-- ===== CONTENT ===== --}}
    <div class="max-w-[85rem] py-6 lg:py-8 mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row gap-6">

            {{-- ===== MAIN PANEL ===== --}}
            <div class="md:w-3/4">
                @include('shared/alerts')
                {!! $panel_html !!}
                @if (app('extension')->extensionIsEnabled('free_trial'))
                    @include('free_trial::service_card', ['service' => $service])
                @endif
            </div>

            {{-- ===== SIDEBAR ===== --}}
            <div class="md:w-1/4 flex flex-col gap-3">

                {{-- Action buttons --}}
                @if ($service->canRenew())
                    @if ($service->isFree())
                        <a style="background:linear-gradient(135deg,#7c3aed,#a855f7);box-shadow:0 2px 10px rgba(124,58,237,.25)" class="w-full inline-flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold text-white border border-transparent transition-all duration-200 hover:opacity-90" href="{{ route('front.services.renew', ['service' => $service, 'gateway' => 'balance']) }}">
                            <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="4" width="22" height="16" rx="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
                            {{ __('client.services.renewbtn') }}
                        </a>
                    @else
                        <a style="background:linear-gradient(135deg,#7c3aed,#a855f7);box-shadow:0 2px 10px rgba(124,58,237,.25)" class="w-full inline-flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold text-white border border-transparent transition-all duration-200 hover:opacity-90" href="{{ route('front.services.renewal', ['service' => $service]) }}">
                            <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="4" width="22" height="16" rx="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
                            {{ __('client.services.managerenew') }}
                        </a>

                        <div class="hs-dropdown relative">
                            <button class="w-full inline-flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold border bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-200 border-gray-200 dark:border-gray-600 hover:border-violet-300 dark:hover:border-violet-600 hover:text-violet-700 dark:hover:text-violet-300 hover:bg-violet-50 dark:hover:bg-violet-900/20 transition-all duration-200" id="hs-renew-dropdown">
                                <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21.5 2v6h-6M2.5 22v-6h6M2 11.5a10 10 0 0 1 18.8-4.3M22 12.5a10 10 0 0 1-18.8 4.2"/></svg>
                                {{ __('client.services.renewbtn') }}
                                <svg class="hs-dropdown-open:rotate-180 w-4 h-4 ml-auto transition-transform" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m6 9 6 6 6-6"/></svg>
                            </button>
                            <div class="hs-dropdown-menu transition-[opacity,margin] hs-dropdown-open:opacity-100 opacity-0 hidden min-w-full bg-white dark:bg-gray-800 shadow-lg rounded-xl border border-gray-100 dark:border-gray-700 mt-1 z-20" aria-labelledby="hs-renew-dropdown">
                                @foreach ($gateways as $gateway)
                                    <a class="flex items-center gap-2 py-2.5 px-4 text-sm text-gray-700 dark:text-gray-300 hover:bg-violet-50 dark:hover:bg-violet-900/20 hover:text-violet-700 dark:hover:text-violet-300 first:rounded-t-xl last:rounded-b-xl transition-colors" href="{{ route('front.services.renew', ['service' => $service, 'gateway' => $gateway->uuid]) }}">
                                        {{ $gateway->name }}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif
                @endif

                @if ($service->canUpgrade())
                    <a href="{{ route('front.services.upgrade', ['service' => $service]) }}" class="w-full inline-flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold border bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-200 border-gray-200 dark:border-gray-600 hover:border-violet-300 dark:hover:border-violet-600 hover:text-violet-700 dark:hover:text-violet-300 hover:bg-violet-50 dark:hover:bg-violet-900/20 transition-all duration-200">
                        <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="17 11 21 7 17 3"/><line x1="21" y1="7" x2="9" y2="7"/><polyline points="7 21 3 17 7 13"/><line x1="15" y1="17" x2="3" y2="17"/></svg>
                        {{ __('client.services.upgradeservice') }}
                    </a>
                @endif

                @if ($service->configoptions->isNotEmpty())
                    <a class="w-full inline-flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold border bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-200 border-gray-200 dark:border-gray-600 hover:border-violet-300 dark:hover:border-violet-600 hover:text-violet-700 dark:hover:text-violet-300 hover:bg-violet-50 dark:hover:bg-violet-900/20 transition-all duration-200" href="{{ route('front.services.options', ['service' => $service]) }}">
                        <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>
                        {{ __('client.services.manageoptions') }}
                    </a>
                @endif

                @if (app('extension')->extensionIsEnabled('customers_reviews'))
                    @include('customers_reviews::service_button', ['service' => $service])
                @endif

                @if (auth('admin')->check())
                    <a href="{{ route('admin.services.show', ['service' => $service]) }}" class="w-full inline-flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold border text-violet-600 dark:text-violet-400 border-violet-200 dark:border-violet-700 bg-violet-50 dark:bg-violet-900/20 hover:bg-violet-100 dark:hover:bg-violet-900/40 hover:text-violet-700 dark:hover:text-violet-300 hover:border-violet-300 transition-all duration-200">
                        <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s-8-4.5-8-11.8A8 8 0 0 1 12 2a8 8 0 0 1 8 8.2c0 7.3-8 11.8-8 11.8z"/></svg>
                        {{ __('client.services.manageserviceonadmin') }}
                    </a>
                @endif

                @if ($service->canCancel())
                    <button type="button" data-hs-overlay="#hs-cancel" class="w-full inline-flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold border text-red-600 dark:text-red-400 border-red-200 dark:border-red-800/50 bg-red-50 dark:bg-red-900/10 hover:bg-red-100 dark:hover:bg-red-900/20 hover:border-red-300 hover:text-red-700 transition-all duration-200">
                        <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
                        {{ __('client.services.cancel.index') }}
                    </button>
                @endif

                @if ($service->canUncancel())
                    <form action="{{ route('front.services.cancel', ['service' => $service]) }}" method="post">
                        @csrf
                        <button type="submit" style="background:linear-gradient(135deg,#7c3aed,#a855f7);box-shadow:0 2px 10px rgba(124,58,237,.25)" class="w-full inline-flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold text-white border border-transparent transition-all duration-200 hover:opacity-90">
                            <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                            {{ __('client.services.cancel.uncancel') }}
                        </button>
                    </form>
                @endif

                {{-- ===== INFO CARDS ===== --}}

                {{-- Service name card --}}
                <div class="flex items-center gap-4 p-4 bg-white dark:bg-gray-800 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm">
                    <div class="flex-shrink-0 w-11 h-11 rounded-xl flex items-center justify-center shadow-sm" style="background:linear-gradient(135deg,#7c3aed,#a855f7)">
                        <svg class="w-5 h-5 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="20" height="8" rx="2"/><rect x="2" y="14" width="20" height="8" rx="2"/><line x1="6" y1="6" x2="6.01" y2="6"/><line x1="6" y1="18" x2="6.01" y2="18"/></svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-xs font-semibold uppercase tracking-wider text-gray-400 dark:text-gray-500 mb-1">{{ __('client.services.show') }}</p>
                        <div class="flex items-center gap-2">
                            <p class="font-semibold text-gray-900 dark:text-white truncate">{{ $service->name }}</p>
                            <a data-hs-overlay="#changename-modal" href="#" class="text-gray-400 hover:text-violet-600 dark:hover:text-violet-400 transition-colors flex-shrink-0">
                                <svg class="w-3.5 h-3.5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                            </a>
                        </div>
                        <x-badge-state state="{{ $service->status }}" class="mt-1.5"></x-badge-state>
                    </div>
                </div>

                @if (!empty($service->description))
                    <div class="px-4 py-3 bg-gray-50 dark:bg-gray-800/50 rounded-xl border border-gray-100 dark:border-gray-700">
                        <p class="text-xs text-gray-500 dark:text-gray-400 leading-relaxed">{!! nl2br($service->description) !!}</p>
                    </div>
                @endif

                {{-- Server card --}}
                @if ($service->server_id != null)
                    <div class="flex items-center gap-4 p-4 bg-white dark:bg-gray-800 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm">
                        <div class="flex-shrink-0 w-11 h-11 rounded-xl flex items-center justify-center shadow-sm" style="background:linear-gradient(135deg,#0ea5e9,#2563eb)">
                            <svg class="w-5 h-5 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s-8-4.5-8-11.8A8 8 0 0 1 12 2a8 8 0 0 1 8 8.2c0 7.3-8 11.8-8 11.8z"/><circle cx="12" cy="10" r="3"/></svg>
                        </div>
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-wider text-gray-400 dark:text-gray-500 mb-1">{{ __('global.server') }}</p>
                            <p class="font-semibold text-gray-900 dark:text-white">{{ $service->server->name }}</p>
                        </div>
                    </div>
                @endif

                {{-- Expiration card --}}
                @if ($service->expires_at != null)
                    <div class="flex items-center gap-4 p-4 bg-white dark:bg-gray-800 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm">
                        <div class="flex-shrink-0 w-11 h-11 rounded-xl flex items-center justify-center shadow-sm" style="background:linear-gradient(135deg,#f59e0b,#ef4444)">
                            <svg class="w-5 h-5 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                        </div>
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-wider text-gray-400 dark:text-gray-500 mb-1">{{ __('client.services.expire_date') }}</p>
                            <p class="font-semibold text-gray-900 dark:text-white">
                                <x-service-days-remaining
                                    expires_at="{{ $service->expires_at }}"
                                    state="{{ $service->status }}"
                                    date_at="{{ $service->status == 'expired' && $service->expire_at != null ? $service->expires_at : ($service->suspended_at != null ? $service->suspended_at : $service->cancelled_at) }}">
                                </x-service-days-remaining>
                            </p>
                        </div>
                    </div>
                @endif

                {{-- Price card --}}
                <div class="flex items-center gap-4 p-4 bg-white dark:bg-gray-800 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm">
                    <div class="flex-shrink-0 w-11 h-11 rounded-xl flex items-center justify-center shadow-sm" style="background:linear-gradient(135deg,#10b981,#059669)">
                        <svg class="w-5 h-5 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                    </div>
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-gray-400 dark:text-gray-500 mb-1">{{ __('store.price') }}</p>
                        <p class="font-semibold text-gray-900 dark:text-white">
                            {{ formatted_price($service->getBillingPrice()->displayPrice(), $service->currency) }}
                            <span class="text-gray-400 dark:text-gray-500 font-normal text-sm">/{{ $service->recurring()['unit'] }}</span>
                        </p>
                    </div>
                </div>

                {{-- Tabs navigation --}}
                <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm overflow-hidden">
                    <div class="flex flex-col divide-y divide-gray-100 dark:divide-gray-700">
                        @foreach ($tabs as $tab)
                            <a
                                {{ !$tab->active ? 'disabled="true"' : '' }}
                                href="{{ $tab->active ? $tab->route($service->id) : '' }}"
                                {!! $tab->popup ? 'is="popup-window"' : '' !!}
                                {!! $tab->newwindow ? 'target="_blank"' : '' !!}
                                class="flex items-center gap-3 px-4 py-3 text-sm font-medium transition-all duration-150
                                    {{ !$tab->active
                                        ? 'text-gray-300 dark:text-gray-600 cursor-not-allowed'
                                        : (($current_tab && $current_tab->uuid == $tab->uuid)
                                            ? 'text-violet-600 dark:text-violet-400 bg-violet-50 dark:bg-violet-900/20 border-l-2 border-violet-500'
                                            : 'text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700/50 hover:text-violet-600 dark:hover:text-violet-400 border-l-2 border-transparent') }}">
                                <svg class="flex-shrink-0 w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">{!! $tab->icon !!}</svg>
                                <span>{{ $tab->title }}</span>
                                @if ($tab->active && (!$current_tab || $current_tab->uuid != $tab->uuid))
                                    <svg class="w-3 h-3 ml-auto text-gray-300 dark:text-gray-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M9 18l6-6-6-6"/></svg>
                                @endif
                            </a>
                        @endforeach
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- ===== CANCEL DRAWER ===== --}}
    @if ($service->canCancel())
    <div id="hs-cancel" class="hs-overlay hs-overlay-open:translate-x-0 hidden translate-x-full fixed top-0 end-0 transition-all duration-300 transform h-full max-w-lg w-full z-[80] bg-white dark:bg-gray-800 border-s border-gray-200 dark:border-gray-700 shadow-2xl" tabindex="-1">
        <div class="flex justify-between items-center py-4 px-5 border-b border-gray-100 dark:border-gray-700">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg flex items-center justify-center bg-red-100 dark:bg-red-900/30">
                    <svg class="w-4 h-4 text-red-600 dark:text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
                </div>
                <h3 class="font-bold text-gray-800 dark:text-white">{{ __('client.services.cancel.index') }}</h3>
            </div>
            <button type="button" class="w-8 h-8 flex items-center justify-center rounded-lg text-gray-400 hover:text-gray-600 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors" data-hs-overlay="#hs-cancel">
                <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
            </button>
        </div>
        <div class="p-5">
            <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">{{ __('client.services.cancel.subtitle') }}</p>
            <form action="{{ route('front.services.cancel', ['service' => $service]) }}" method="post" class="space-y-4">
                @csrf
                <p class="text-sm text-gray-500 dark:text-gray-400">{{ __('client.services.cancel.index_description') }}</p>
                @include('shared/select', ['name' => 'reason', 'label' => __('client.services.cancel.reason'), 'options' => \App\Models\Provisioning\CancellationReason::getReasons(), 'value' => old('reason')])
                @include('shared/textarea', ['name' => 'message', 'label' => __('client.services.cancel.message'), 'value' => old('message')])
                @if (!$service->isOnetime())
                    @include('shared/select', ['name' => 'expiration', 'label' => __('client.services.cancel.expiration'), 'options' => \App\Models\Provisioning\CancellationReason::getCancellationMode($service), 'value' => old('expiration')])
                @endif
                <div class="flex gap-3 pt-2">
                    <button type="button" data-hs-overlay="#hs-cancel" class="flex-1 py-2.5 px-4 rounded-xl border border-gray-200 dark:border-gray-600 text-sm font-medium text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                        {{ __('client.services.cancel.back') }}
                    </button>
                    <button type="submit" class="flex-1 py-2.5 px-4 rounded-xl bg-red-600 hover:bg-red-700 text-sm font-semibold text-white transition-colors shadow-sm">
                        {{ __('client.services.cancel.index') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif

    {{-- ===== CHANGE NAME DRAWER ===== --}}
    <div id="changename-modal" class="hs-overlay hs-overlay-open:translate-x-0 hidden translate-x-full fixed top-0 end-0 transition-all duration-300 transform h-full max-w-xs w-full z-[80] bg-white dark:bg-gray-800 border-s border-gray-200 dark:border-gray-700 shadow-2xl" tabindex="-1">
        <div class="flex justify-between items-center py-4 px-5 border-b border-gray-100 dark:border-gray-700">
            <h3 class="font-bold text-gray-800 dark:text-white">{{ __('client.services.changename') }}</h3>
            <button type="button" class="w-8 h-8 flex items-center justify-center rounded-lg text-gray-400 hover:text-gray-600 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors" data-hs-overlay="#changename-modal">
                <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
            </button>
        </div>
        <div class="p-5">
            <form method="POST" action="{{ route('front.services.name', ['service' => $service]) }}">
                @csrf
                @include('shared/input', ['name' => 'name', 'value' => $service->name, 'placeholder' => __('global.name')])
                <button type="submit" class="btn-primary w-full mt-3">{{ __('global.save') }}</button>
            </form>
        </div>
    </div>

@endsection
