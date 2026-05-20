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

@php($container = $container ?? 'max-w-md')

    <!doctype html>
<html class="{{is_darkmode() ? 'dark' : '' }}" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    {{-- ... --}}
    <title>@yield('title') {{ setting('seo_site_title') }}</title>
    @yield('styles')
    @vite('resources/themes/default/js/app.js')
    @vite('resources/themes/default/css/app.scss')
    {!! app('seo')->head('auth', $meta_append ?? null) !!}
    {!! app('seo')->favicon('auth') !!}
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
</head>
<body class="dark:bg-slate-900 bg-gray-50 min-h-screen">

<div class="min-h-screen flex">
    {{-- Left gradient panel (hidden on mobile) --}}
    <div class="hidden lg:flex lg:w-1/2 xl:w-2/5 bg-gradient-to-br from-violet-700 via-violet-600 to-fuchsia-600 flex-col justify-between p-12 relative overflow-hidden">
        {{-- Background decorative circles --}}
        <div class="absolute top-0 right-0 w-64 h-64 bg-white/5 rounded-full -translate-y-1/2 translate-x-1/4"></div>
        <div class="absolute bottom-0 left-0 w-80 h-80 bg-white/5 rounded-full translate-y-1/3 -translate-x-1/4"></div>
        <div class="absolute top-1/2 left-1/2 w-48 h-48 bg-white/5 rounded-full -translate-x-1/2 -translate-y-1/2"></div>

        {{-- Logo --}}
        <div class="relative z-10">
            <a href="/" class="flex items-center gap-3">
                <img src="{{ setting('app_logo_text') }}" alt="{{ setting('app_name') }}" class="h-10 w-auto brightness-0 invert">
            </a>
        </div>

        {{-- Center content --}}
        <div class="relative z-10">
            <h2 class="text-3xl font-bold text-white leading-tight">
                {{ translated_setting('seo_site_title', setting('app_name')) }}
            </h2>
            <p class="mt-4 text-violet-200 text-base leading-relaxed">
                {!! translated_setting('theme_footer_description', __('global.clientarea')) !!}
            </p>
        </div>

        {{-- Bottom links --}}
        <div class="relative z-10 flex flex-wrap gap-x-6 gap-y-2">
            @foreach (app('theme')->getBottomLinks() as $link)
                <a href="{{ $link->trans('url') }}" class="text-sm text-violet-200 hover:text-white transition-colors duration-200">
                    {{ $link->trans('name') }}
                </a>
            @endforeach
        </div>
    </div>

    {{-- Right form panel --}}
    <div class="flex-1 flex flex-col justify-center items-center px-6 py-12 lg:px-16">
        {{-- Mobile logo --}}
        <div class="lg:hidden mb-8">
            <img src="{{ setting('app_logo_text') }}" alt="{{ setting('app_name') }}" class="h-12 w-auto mx-auto">
        </div>

        <div class="w-full {{ $container }}">
            <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-2xl shadow-sm">
                @yield('content')
            </div>
        </div>

        <p class="mt-6 text-xs text-gray-400 dark:text-gray-500 text-center">
            &copy; {{ date('Y') }} {{ setting('app_name') }}. All rights reserved.
        </p>
    </div>
</div>

@yield('scripts')

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.querySelectorAll('.confirmation-popup').forEach(function (element) {
        element.addEventListener('submit', function (event) {
            event.preventDefault();
            confirmation(element).then((result) => {
                if (result.isConfirmed) { element.submit(); }
            });
        });
    })
    function confirmation(element) {
        const text = element.getAttribute('data-text') ?? '{{ __('admin.doyouwantreally') }}';
        const icon = element.getAttribute('data-icon') ?? 'warning';
        const confirmButtonText = element.getAttribute('data-confirm-button-text') ?? '{{ __('global.delete') }}';
        const showCancelButton = element.getAttribute('data-show-cancel-button') ?? true;
        const cancelButtonText = element.getAttribute('data-cancel-button-text') ?? '{{ __('global.cancel') }}';
        return Swal.fire({
            text, icon, confirmButtonText, showCancelButton, cancelButtonText,
            confirmButtonColor: '#7c3aed',
            cancelButtonColor: '#6b7280',
        })
    }
</script>
</body>
</html>
