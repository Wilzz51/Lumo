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

<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full {{ is_darkmode() ? 'dark' : '' }}">
<head>
    <title>{{ __('maintenance.in_maintenance_title') }} - {{ config('app.name') }}</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite('resources/themes/lumo/css/app.scss')
    {!! app('seo')->favicon() !!}
</head>
<body class="min-h-screen flex items-center justify-center bg-gradient-to-br from-violet-700 via-violet-600 to-fuchsia-600 relative overflow-hidden">

    {{-- Cercles décoratifs (même style que le layout auth) --}}
    <div class="absolute top-0 right-0 w-96 h-96 bg-white/5 rounded-full -translate-y-1/2 translate-x-1/4 pointer-events-none"></div>
    <div class="absolute bottom-0 left-0 w-96 h-96 bg-white/5 rounded-full translate-y-1/3 -translate-x-1/4 pointer-events-none"></div>
    <div class="absolute top-1/2 left-1/4 w-64 h-64 bg-white/5 rounded-full -translate-x-1/2 -translate-y-1/2 pointer-events-none"></div>
    <div class="absolute inset-0 bg-[linear-gradient(to_right,rgba(255,255,255,0.04)_1px,transparent_1px),linear-gradient(to_bottom,rgba(255,255,255,0.04)_1px,transparent_1px)] bg-[size:32px_32px] pointer-events-none"></div>

    {{-- Card centrale --}}
    <div class="relative z-10 w-full max-w-md mx-4">
        <div class="bg-white dark:bg-gray-800 border border-white/20 rounded-2xl shadow-2xl overflow-hidden">

            {{-- Header violet (logo + badge) --}}
            <div class="bg-gradient-to-br from-violet-700 via-violet-600 to-fuchsia-600 px-8 pt-8 pb-10 text-center relative overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-white/5 rounded-full -translate-y-1/2 translate-x-1/4"></div>
                <div class="absolute bottom-0 left-0 w-24 h-24 bg-white/5 rounded-full translate-y-1/2 -translate-x-1/4"></div>
                @if(setting('app_logo_text'))
                    <img src="{{ setting('app_logo_text') }}" alt="{{ config('app.name') }}"
                         class="h-10 w-auto mx-auto mb-5 brightness-0 invert relative z-10">
                @endif
                {{-- Icône engrenage --}}
                <div class="relative z-10 mx-auto w-16 h-16 rounded-2xl bg-white/15 border border-white/25 flex items-center justify-center shadow-lg">
                    <svg style="width:1.75rem;height:1.75rem;color:#fff;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="3"/>
                        <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83-2.83l.06-.06A1.65 1.65 0 0 0 4.68 15a1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 2.83-2.83l.06.06A1.65 1.65 0 0 0 9 4.68a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 2.83l-.06.06A1.65 1.65 0 0 0 19.4 9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"/>
                    </svg>
                </div>
            </div>

            {{-- Contenu --}}
            <div class="px-8 py-7 text-center">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-violet-50 dark:bg-violet-900/30 text-violet-700 dark:text-violet-300 border border-violet-200 dark:border-violet-700/50 mb-4">
                    <span class="w-1.5 h-1.5 rounded-full bg-violet-500 animate-pulse inline-block"></span>
                    {{ __('maintenance.in_maintenance_title') }}
                </span>

                <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-3">
                    {{ config('app.name') }}
                </h1>

                <p class="text-sm text-gray-500 dark:text-gray-400 leading-relaxed mb-6">
                    {{ setting('maintenance_message') ?: __('maintenance.in_maintenance_title') }}
                </p>

                @if(setting('maintenance_button_url'))
                    <a href="{{ setting('maintenance_button_url') }}"
                       class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm font-semibold text-white transition-all hover:-translate-y-px"
                       style="background:linear-gradient(135deg,#7c3aed,#a855f7);box-shadow:0 4px 16px rgba(124,58,237,0.35);">
                        @if(setting('maintenance_button_icon'))
                            <i class="{{ setting('maintenance_button_icon') }}"></i>
                        @endif
                        {{ setting('maintenance_button_text') }}
                    </a>
                @endif
            </div>

            {{-- Footer --}}
            <div class="px-8 py-4 border-t border-gray-100 dark:border-gray-700 text-center">
                <p class="text-xs text-gray-400 dark:text-gray-500">
                    &copy; {{ date('Y') }} {{ setting('app_name') }}. All rights reserved.
                </p>
            </div>

        </div>
    </div>

</body>
</html>
