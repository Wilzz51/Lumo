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
@section('title', __('global.clientarea'))
@section('scripts')
    <script src="{{ Vite::asset('resources/themes/lumo/js/filter.js') }}"></script>
@endsection
@section('content')

@php
    $homepageStyle = theme_config('homepage_style', '1');
    $statCards = [
        [
            'label'    => __('global.invoices'),
            'value'    => $invoicesCount,
            'link'     => route('front.invoices.index'),
            'gradient' => 'linear-gradient(135deg,#f59e0b,#f97316)',
            'glow'     => 'rgba(245,158,11,0.25)',
            'accent'   => '#f59e0b',
            'icon'     => '<path d="M14 2H6a2 2 0 0 0-2 2v16c0 1.1.9 2 2 2h12a2 2 0 0 0 2-2V8l-6-6z"/><path d="M14 3v5h5M16 13H8M16 17H8M10 9H8"/>',
            'badge'    => $pending != 0 ? $pending : null,
        ],
        [
            'label'    => __('global.services'),
            'value'    => $servicesCount,
            'link'     => route('front.services.index'),
            'gradient' => 'linear-gradient(135deg,#7c3aed,#c026d3)',
            'glow'     => 'rgba(124,58,237,0.25)',
            'accent'   => '#9333ea',
            'icon'     => '<rect x="2" y="2" width="20" height="8" rx="2" ry="2"/><rect x="2" y="14" width="20" height="8" rx="2" ry="2"/><line x1="6" y1="6" x2="6.01" y2="6"/><line x1="6" y1="18" x2="6.01" y2="18"/>',
            'badge'    => null,
        ],
        [
            'label'    => __('global.balance'),
            'value'    => formatted_price(auth()->user()->balance),
            'link'     => route('front.payment-methods.index'),
            'gradient' => 'linear-gradient(135deg,#10b981,#0d9488)',
            'glow'     => 'rgba(16,185,129,0.25)',
            'accent'   => '#10b981',
            'icon'     => '<line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>',
            'badge'    => null,
        ],
        [
            'label'    => __('global.tickets'),
            'value'    => $ticketsCount,
            'link'     => route('front.support.index'),
            'gradient' => 'linear-gradient(135deg,#3b82f6,#6366f1)',
            'glow'     => 'rgba(59,130,246,0.25)',
            'accent'   => '#3b82f6',
            'icon'     => '<path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>',
            'badge'    => null,
        ],
    ];
@endphp

{{-- ============================================================ --}}
{{-- STYLE 1 — Dashboard (défaut) --}}
{{-- ============================================================ --}}
@if($homepageStyle === '1')

    {{-- Banner --}}
    <div class="relative overflow-hidden bg-gradient-to-br from-violet-700 via-violet-600 to-fuchsia-700 py-10 lg:py-12">
        <div class="absolute top-0 right-0 w-80 h-80 bg-white/5 rounded-full -translate-y-1/2 translate-x-1/4 pointer-events-none"></div>
        <div class="absolute bottom-0 left-0 w-64 h-64 bg-white/5 rounded-full translate-y-1/3 -translate-x-1/4 pointer-events-none"></div>
        <div class="absolute inset-0 bg-[linear-gradient(to_right,rgba(255,255,255,0.04)_1px,transparent_1px),linear-gradient(to_bottom,rgba(255,255,255,0.04)_1px,transparent_1px)] bg-[size:32px_32px] pointer-events-none"></div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-between gap-4">
            <div>
                <p class="text-violet-200 text-sm font-medium mb-1">{{ __('global.clientarea') }}</p>
                <h1 class="text-2xl md:text-3xl font-extrabold text-white tracking-tight">
                    Bonjour, {{ auth()->user()->firstname ?? auth()->user()->email }} !
                </h1>
                <p class="text-violet-200/80 text-sm mt-1.5">Bienvenue dans votre espace client.</p>
            </div>
            <a href="{{ route('front.store.index') }}"
               class="hidden sm:inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-white/10 hover:bg-white/20 border border-white/20 text-white text-sm font-semibold transition-all duration-200 hover:-translate-y-0.5 flex-shrink-0">
                <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
                Commander
            </a>
        </div>
    </div>

    <div class="{{ theme_metadata('layout_classes', 'max-w-[85rem] px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto') }}">
        @include("shared.alerts")

        {{-- Stat cards --}}
        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-4">
            @foreach($statCards as $card)
            <a href="{{ $card['link'] }}"
               class="group relative flex flex-col rounded-xl border overflow-hidden shadow-sm hover:shadow-lg transition-all duration-200 hover:-translate-y-0.5"
               style="{{ is_darkmode() ? 'background:rgba(15,5,39,0.85);border-color:rgba(109,40,217,0.2)' : 'background:#ffffff;border-color:#f3f4f6' }}">

                {{-- Ligne accent en haut --}}
                <div class="h-[3px]" style="background:{{ $card['gradient'] }}"></div>

                <div class="p-5 flex items-center gap-4">
                    {{-- Icône --}}
                    <div class="flex-shrink-0 w-12 h-12 rounded-xl flex items-center justify-center"
                         style="background:{{ $card['gradient'] }};box-shadow:0 4px 14px {{ $card['glow'] }}">
                        <svg class="w-5 h-5 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">{!! $card['icon'] !!}</svg>
                    </div>

                    {{-- Valeur --}}
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-2 mb-1">
                            <p class="text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400 truncate">{{ $card['label'] }}</p>
                            @if($card['badge'])
                                <span class="inline-flex items-center justify-center w-5 h-5 rounded-full text-[10px] font-bold text-white" style="background:#ef4444">{{ $card['badge'] }}</span>
                            @endif
                        </div>
                        <p class="text-2xl font-extrabold {{ is_darkmode() ? 'text-white' : 'text-gray-900' }} truncate">{{ $card['value'] }}</p>
                    </div>
                </div>

                {{-- Footer --}}
                <div class="px-5 py-2.5 border-t flex items-center justify-between"
                     style="{{ is_darkmode() ? 'border-color:rgba(109,40,217,0.15);background:rgba(109,40,217,0.05)' : 'border-color:#f9fafb;background:#fafafa' }}">
                    <span class="text-xs font-medium transition-colors duration-200"
                          style="color:{{ $card['accent'] }}">
                        Voir les détails
                    </span>
                    <svg class="w-3.5 h-3.5 transition-transform duration-200 group-hover:translate-x-0.5" style="color:{{ $card['accent'] }}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
                </div>
            </a>
            @endforeach
        </div>

        <div class="flex flex-col md:flex-row gap-4 mt-6 items-start">
            <div class="min-w-0 flex-1 flex flex-col gap-4">
                @include('front/provisioning/services/card', ['services' => $services, 'count' => $servicesCount, 'filters' => $serviceFilters, 'filter' => null])
                @include('front/billing/invoices/card', ['invoices' => $invoices, 'count' => $invoicesCount, 'filters' => $serviceFilters, 'filter' => null])
                @include('front/helpdesk/support/card', ['tickets' => $tickets, 'count' => $ticketsCount, 'filters' => $serviceFilters, 'filter' => null])
            </div>
            @if (app('extension')->extensionIsEnabled('discordlink') || app('extension')->extensionIsEnabled('supportid') || app('extension')->extensionIsEnabled('discordgift'))
            <div class="w-full md:w-72 flex-shrink-0 flex flex-col gap-4">
                @if (app('extension')->extensionIsEnabled('discordlink'))
                    @include('discordlink::front/client/discord')
                @endif
                @if (app('extension')->extensionIsEnabled('supportid'))
                    @include('supportid::card')
                @endif
                @if (app('extension')->extensionIsEnabled('discordgift'))
                    @include('discordgift::card')
                @endif
            </div>
            @endif
        </div>
    </div>

{{-- ============================================================ --}}
{{-- STYLE 2 — Minimal / Sidebar stats --}}
{{-- ============================================================ --}}
@elseif($homepageStyle === '2')

    {{-- Slim banner with status pills --}}
    <div class="relative overflow-hidden bg-gradient-to-br from-violet-700 via-violet-600 to-fuchsia-700 py-8">
        <div class="absolute inset-0 bg-[linear-gradient(to_right,rgba(255,255,255,0.04)_1px,transparent_1px),linear-gradient(to_bottom,rgba(255,255,255,0.04)_1px,transparent_1px)] bg-[size:32px_32px] pointer-events-none"></div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-extrabold text-white tracking-tight">
                        Bonjour, {{ auth()->user()->firstname ?? auth()->user()->email }} !
                    </h1>
                    <p class="text-violet-200/80 text-sm mt-1">Bienvenue dans votre espace client.</p>
                </div>
                <div class="flex flex-wrap items-center gap-2">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-white/10 border border-white/20 text-white text-xs font-semibold backdrop-blur-sm">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                        Uptime {{ theme_config('hero_stat1_value', '99.9%') }}
                    </span>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-white/10 border border-white/20 text-white text-xs font-semibold backdrop-blur-sm">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                        Support {{ theme_config('hero_stat2_value', '24/7') }}
                    </span>
                    @if(theme_config('hero_stat3_value', ''))
                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-white/10 border border-white/20 text-white text-xs font-semibold backdrop-blur-sm">
                        <span class="w-1.5 h-1.5 rounded-full bg-violet-300"></span>
                        {{ theme_config('hero_stat3_value', '') }} {{ theme_config('hero_stat3_label', '') }}
                    </span>
                    @endif
                    <a href="{{ route('front.store.index') }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-white text-violet-700 text-xs font-bold hover:bg-violet-50 transition-colors">
                        <svg class="w-3.5 h-3.5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
                        Commander
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="{{ theme_metadata('layout_classes', 'max-w-[85rem] px-4 py-8 sm:px-6 lg:px-8 mx-auto') }}">
        @include("shared.alerts")

        <div class="flex flex-col lg:flex-row gap-6 items-start">

            {{-- Main content --}}
            <div class="min-w-0 flex-1 flex flex-col gap-4">
                @include('front/provisioning/services/card', ['services' => $services, 'count' => $servicesCount, 'filters' => $serviceFilters, 'filter' => null])
                @include('front/billing/invoices/card', ['invoices' => $invoices, 'count' => $invoicesCount, 'filters' => $serviceFilters, 'filter' => null])
                @include('front/helpdesk/support/card', ['tickets' => $tickets, 'count' => $ticketsCount, 'filters' => $serviceFilters, 'filter' => null])
            </div>

            {{-- Sidebar --}}
            <div class="w-full lg:w-64 flex-shrink-0 flex flex-col gap-3">

                {{-- Stats vertical --}}
                <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm overflow-hidden">
                    <div class="px-4 py-3 border-b border-gray-100 dark:border-gray-700">
                        <p class="text-xs font-semibold uppercase tracking-wider text-gray-400 dark:text-gray-500">Vue d'ensemble</p>
                    </div>
                    <div class="divide-y divide-gray-50 dark:divide-gray-700/50">
                        <div class="flex items-center justify-between px-4 py-3">
                            <div class="flex items-center gap-2.5">
                                <div class="w-8 h-8 rounded-lg bg-amber-50 dark:bg-amber-900/20 flex items-center justify-center">
                                    <svg class="w-4 h-4 text-amber-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16c0 1.1.9 2 2 2h12a2 2 0 0 0 2-2V8l-6-6z"/></svg>
                                </div>
                                <span class="text-sm text-gray-600 dark:text-gray-400">{{ __('global.invoices') }}</span>
                            </div>
                            <div class="flex items-center gap-1.5">
                                <span class="text-sm font-bold text-gray-800 dark:text-white">{{ $invoicesCount }}</span>
                                @if($pending != 0)<span class="w-2 h-2 rounded-full bg-red-500"></span>@endif
                            </div>
                        </div>
                        <div class="flex items-center justify-between px-4 py-3">
                            <div class="flex items-center gap-2.5">
                                <div class="w-8 h-8 rounded-lg bg-violet-50 dark:bg-violet-900/20 flex items-center justify-center">
                                    <svg class="w-4 h-4 text-violet-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="20" height="8" rx="2"/><rect x="2" y="14" width="20" height="8" rx="2"/></svg>
                                </div>
                                <span class="text-sm text-gray-600 dark:text-gray-400">{{ __('global.services') }}</span>
                            </div>
                            <span class="text-sm font-bold text-gray-800 dark:text-white">{{ $servicesCount }}</span>
                        </div>
                        <div class="flex items-center justify-between px-4 py-3">
                            <div class="flex items-center gap-2.5">
                                <div class="w-8 h-8 rounded-lg bg-emerald-50 dark:bg-emerald-900/20 flex items-center justify-center">
                                    <svg class="w-4 h-4 text-emerald-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                                </div>
                                <span class="text-sm text-gray-600 dark:text-gray-400">{{ __('global.balance') }}</span>
                            </div>
                            <span class="text-sm font-bold text-gray-800 dark:text-white">{{ formatted_price(auth()->user()->balance) }}</span>
                        </div>
                        <div class="flex items-center justify-between px-4 py-3">
                            <div class="flex items-center gap-2.5">
                                <div class="w-8 h-8 rounded-lg bg-sky-50 dark:bg-sky-900/20 flex items-center justify-center">
                                    <svg class="w-4 h-4 text-sky-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                                </div>
                                <span class="text-sm text-gray-600 dark:text-gray-400">{{ __('global.tickets') }}</span>
                            </div>
                            <span class="text-sm font-bold text-gray-800 dark:text-white">{{ $ticketsCount }}</span>
                        </div>
                    </div>
                </div>

                {{-- Active services list --}}
                @if($services->where('status', 'active')->isNotEmpty())
                <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm overflow-hidden">
                    <div class="px-4 py-3 border-b border-gray-100 dark:border-gray-700 flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                            <p class="text-xs font-semibold uppercase tracking-wider text-gray-400 dark:text-gray-500">{{ theme_config('active_services_label', 'Services actifs') }}</p>
                        </div>
                        <span class="text-xs font-bold text-emerald-600 dark:text-emerald-400">{{ $services->where('status', 'active')->count() }}</span>
                    </div>
                    <div class="divide-y divide-gray-50 dark:divide-gray-700/50">
                        @foreach($services->where('status', 'active')->take(6) as $s)
                        <a href="{{ route('front.services.show', $s) }}" class="flex items-center justify-between px-4 py-2.5 hover:bg-violet-50 dark:hover:bg-violet-900/10 transition-colors group">
                            <span class="text-sm text-gray-700 dark:text-gray-300 truncate group-hover:text-violet-700 dark:group-hover:text-violet-400 font-medium">{{ $s->name }}</span>
                            <svg class="flex-shrink-0 w-3 h-3 text-gray-300 group-hover:text-violet-400 ml-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
                        </a>
                        @endforeach
                    </div>
                    @if($services->where('status', 'active')->count() > 6)
                    <div class="px-4 py-2.5 border-t border-gray-50 dark:border-gray-700/50">
                        <a href="{{ route('front.services.index') }}" class="text-xs text-violet-600 dark:text-violet-400 font-medium hover:text-violet-800 transition-colors">Voir tout →</a>
                    </div>
                    @endif
                </div>
                @endif

                @if (app('extension')->extensionIsEnabled('discordlink'))
                    @include('discordlink::front/client/discord')
                @endif
                @if (app('extension')->extensionIsEnabled('supportid'))
                    @include('supportid::card')
                @endif
            </div>
        </div>
    </div>

{{-- ============================================================ --}}
{{-- STYLE 3 — Infra / Services en vedette --}}
{{-- ============================================================ --}}
@elseif($homepageStyle === '3')

    {{-- Banner avec grands chiffres --}}
    <div class="relative overflow-hidden bg-gradient-to-br from-gray-900 via-violet-950 to-gray-900 py-12">
        <div class="absolute inset-0 bg-[linear-gradient(to_right,rgba(124,58,237,0.08)_1px,transparent_1px),linear-gradient(to_bottom,rgba(124,58,237,0.08)_1px,transparent_1px)] bg-[size:40px_40px] pointer-events-none"></div>
        <div class="absolute top-0 right-0 w-96 h-96 bg-violet-600/10 rounded-full -translate-y-1/2 translate-x-1/3 blur-3xl pointer-events-none"></div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between gap-8">
                <div>
                    <p class="text-violet-400 text-xs font-semibold uppercase tracking-widest mb-2">{{ __('global.clientarea') }}</p>
                    <h1 class="text-3xl md:text-4xl font-extrabold text-white tracking-tight">
                        Bonjour, {{ auth()->user()->firstname ?? auth()->user()->email }} !
                    </h1>
                    <p class="text-gray-400 text-sm mt-2">Tableau de bord de votre infrastructure.</p>
                </div>
                {{-- Infra stats --}}
                <div class="flex flex-wrap gap-4 lg:gap-6">
                    <div class="text-center">
                        <p class="text-3xl font-extrabold text-white">{{ theme_config('hero_stat1_value', '99.9%') }}</p>
                        <p class="text-[11px] font-semibold uppercase tracking-widest text-violet-400 mt-0.5">Uptime</p>
                    </div>
                    <div class="w-px bg-white/10 hidden sm:block"></div>
                    <div class="text-center">
                        <p class="text-3xl font-extrabold text-white">{{ $services->where('status', 'active')->count() }}</p>
                        <p class="text-[11px] font-semibold uppercase tracking-widest text-violet-400 mt-0.5">Actifs</p>
                    </div>
                    <div class="w-px bg-white/10 hidden sm:block"></div>
                    <div class="text-center">
                        <div class="flex items-center justify-center gap-1.5">
                            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                            <p class="text-3xl font-extrabold text-white">{{ theme_config('hero_stat2_value', '24/7') }}</p>
                        </div>
                        <p class="text-[11px] font-semibold uppercase tracking-widest text-violet-400 mt-0.5">Support</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="{{ theme_metadata('layout_classes', 'max-w-[85rem] px-4 py-8 sm:px-6 lg:px-8 mx-auto') }}">
        @include("shared.alerts")

        {{-- Summary strip --}}
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 mb-6">
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-100 dark:border-gray-700 p-4 flex items-center gap-3">
                <div class="w-9 h-9 rounded-lg flex items-center justify-center bg-amber-50 dark:bg-amber-900/20 flex-shrink-0">
                    <svg class="w-4 h-4 text-amber-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16c0 1.1.9 2 2 2h12a2 2 0 0 0 2-2V8l-6-6z"/></svg>
                </div>
                <div>
                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ __('global.invoices') }}</p>
                    <p class="text-xl font-extrabold text-gray-800 dark:text-white leading-none mt-0.5">{{ $invoicesCount }}</p>
                </div>
            </div>
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-100 dark:border-gray-700 p-4 flex items-center gap-3">
                <div class="w-9 h-9 rounded-lg flex items-center justify-center bg-violet-50 dark:bg-violet-900/20 flex-shrink-0">
                    <svg class="w-4 h-4 text-violet-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="20" height="8" rx="2"/><rect x="2" y="14" width="20" height="8" rx="2"/></svg>
                </div>
                <div>
                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ __('global.services') }}</p>
                    <p class="text-xl font-extrabold text-gray-800 dark:text-white leading-none mt-0.5">{{ $servicesCount }}</p>
                </div>
            </div>
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-100 dark:border-gray-700 p-4 flex items-center gap-3">
                <div class="w-9 h-9 rounded-lg flex items-center justify-center bg-emerald-50 dark:bg-emerald-900/20 flex-shrink-0">
                    <svg class="w-4 h-4 text-emerald-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                </div>
                <div>
                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ __('global.balance') }}</p>
                    <p class="text-xl font-extrabold text-gray-800 dark:text-white leading-none mt-0.5">{{ formatted_price(auth()->user()->balance) }}</p>
                </div>
            </div>
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-100 dark:border-gray-700 p-4 flex items-center gap-3">
                <div class="w-9 h-9 rounded-lg flex items-center justify-center bg-sky-50 dark:bg-sky-900/20 flex-shrink-0">
                    <svg class="w-4 h-4 text-sky-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                </div>
                <div>
                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ __('global.tickets') }}</p>
                    <p class="text-xl font-extrabold text-gray-800 dark:text-white leading-none mt-0.5">{{ $ticketsCount }}</p>
                </div>
            </div>
        </div>

        {{-- Services grid en vedette --}}
        @if($services->isNotEmpty())
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm mb-6 overflow-hidden">
            <div class="px-5 py-4 border-b border-gray-100 dark:border-gray-700 flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse" style="box-shadow:0 0 6px rgba(16,185,129,.6)"></span>
                    <h2 class="text-sm font-semibold text-gray-700 dark:text-gray-200 uppercase tracking-wider">{{ setting('active_services_label', theme_config('active_services_label')) ?: 'Infrastructure' }}</h2>
                </div>
                <a href="{{ route('front.services.index') }}" class="text-xs text-violet-600 dark:text-violet-400 font-medium hover:text-violet-800 transition-colors">Voir tout →</a>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 divide-y sm:divide-y-0 sm:divide-x divide-gray-50 dark:divide-gray-700/50">
                @foreach($services->take(6) as $s)
                <a href="{{ route('front.services.show', $s) }}"
                   class="group flex items-center gap-4 px-5 py-4 hover:bg-violet-50/50 dark:hover:bg-violet-900/10 transition-colors {{ $loop->index >= 3 ? 'border-t border-gray-50 dark:border-gray-700/50' : '' }}">
                    <div class="flex-shrink-0 w-8 h-8 rounded-lg flex items-center justify-center
                        {{ $s->status === 'active' ? 'bg-emerald-50 dark:bg-emerald-900/20' : ($s->status === 'suspended' ? 'bg-amber-50 dark:bg-amber-900/20' : 'bg-gray-50 dark:bg-gray-700') }}">
                        <span class="w-2.5 h-2.5 rounded-full
                            {{ $s->status === 'active' ? 'bg-emerald-500' : ($s->status === 'suspended' ? 'bg-amber-500' : 'bg-gray-400') }}
                            {{ $s->status === 'active' ? 'animate-pulse' : '' }}"></span>
                    </div>
                    <div class="min-w-0 flex-1">
                        <p class="text-sm font-semibold text-gray-800 dark:text-gray-200 truncate group-hover:text-violet-700 dark:group-hover:text-violet-400 transition-colors">{{ $s->name }}</p>
                        <p class="text-[11px] text-gray-400 dark:text-gray-500 capitalize">{{ $s->status }}</p>
                    </div>
                    <svg class="flex-shrink-0 w-3.5 h-3.5 text-gray-300 dark:text-gray-600 group-hover:text-violet-400 transition-colors" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
                </a>
                @endforeach
            </div>
        </div>
        @endif

        <div class="flex flex-col md:flex-row gap-4 items-start">
            <div class="min-w-0 flex-1 flex flex-col gap-4">
                @include('front/billing/invoices/card', ['invoices' => $invoices, 'count' => $invoicesCount, 'filters' => $serviceFilters, 'filter' => null])
                @include('front/helpdesk/support/card', ['tickets' => $tickets, 'count' => $ticketsCount, 'filters' => $serviceFilters, 'filter' => null])
            </div>
            @if (app('extension')->extensionIsEnabled('discordlink') || app('extension')->extensionIsEnabled('supportid') || app('extension')->extensionIsEnabled('discordgift'))
            <div class="w-full md:w-72 flex-shrink-0 flex flex-col gap-4">
                @if (app('extension')->extensionIsEnabled('discordlink'))
                    @include('discordlink::front/client/discord')
                @endif
                @if (app('extension')->extensionIsEnabled('supportid'))
                    @include('supportid::card')
                @endif
                @if (app('extension')->extensionIsEnabled('discordgift'))
                    @include('discordgift::card')
                @endif
            </div>
            @endif
        </div>
    </div>

@endif

@endsection
