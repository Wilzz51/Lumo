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
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full ">
<head>
    {{-- ... --}}
    <title>@yield('title') {{ translated_setting('seo_site_title') }}</title>
    @yield('styles')
    @vite('resources/themes/default/css/app.scss')
    @vite('resources/themes/default/js/app.js')
    {!! app('seo')->head('front', $meta_append ?? null) !!}
    {!! app('seo')->favicon('front') !!}
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
</head>
<body class="{{is_darkmode() ? 'dark' : '' }} flex flex-col h-full">
    {!! app('seo')->header() !!}

<div class="dark:bg-gray-900 h-full">
    <main id="content" role="main" class="shrink-0">
        @php($hd = request()->is('/') && is_darkmode())
        <div class="relative">
            <header class="relative flex flex-wrap sm:justify-start sm:flex-nowrap z-50 w-full py-2.5 sm:py-4 border-b text-sm py-3 sm:py-0 print:hidden transition-colors duration-300 {{ $hd ? 'hero-header' : 'bg-white/95 backdrop-blur-sm border-gray-200 dark:bg-gray-800/95 dark:border-gray-700' }}">
                <nav class="max-w-7xl flex basis-full items-center mx-auto px-4 sm:px-6 lg:px-8" aria-label="Global">
                    <div class="me-5 md:me-8">
                        @if (setting('theme_header_logo', false))
                            <a class="flex-none" href="/" aria-label="{{ setting('app_name') }}">
                                <img class="mx-auto h-10 w-auto {{ $hd ? 'brightness-0 invert' : '' }}" src="{{ setting('app_logo_text', asset('images/logo.png')) }}" alt="{{ setting('app_name') }}">
                            </a>
                        @else
                            <a class="flex-none text-xl font-bold tracking-tight {{ $hd ? 'text-white' : 'text-gray-900 dark:text-white' }}" href="/" aria-label="{{ setting('app_name') }}">{{ setting('app_name') }}</a>
                        @endif
                    </div>

                    <div class="hs-overlay hs-overlay-open:translate-x-0 -translate-x-full fixed top-0 start-0 transition-all duration-300 transform h-full max-w-xs w-full z-[60] {{ $hd ? 'hero-header-overlay' : 'bg-white dark:bg-gray-800' }} border-e basis-full grow sm:order-2 sm:static sm:block sm:h-auto sm:max-w-none sm:w-auto sm:border-r-transparent sm:transition-none sm:translate-x-0 sm:z-40 sm:basis-auto" tabindex="-1">
                        <div class="flex flex-col gap-y-1 gap-x-0 mt-5 sm:flex-row sm:items-center sm:justify-end sm:gap-y-0 sm:mt-0 sm:ps-7">
                            @foreach (app('theme')->getFrontLinks() as $link)
                                @if ($link->link_type === 'dropdown')
                                    @php($ddi = 'dd-'.rand(1000,9999))
                                    <div class="hs-dropdown [--strategy:static] sm:[--strategy:fixed] [--adaptive:none] [--is-collapse:true] sm:[--is-collapse:false] relative">
                                        <button id="{{ $ddi }}" type="button"
                                            class="hs-dropdown-toggle w-full flex items-center gap-1.5 font-medium sm:px-2 mr-3 py-2 sm:py-0 transition-colors duration-200 {{ is_subroute($link->children->pluck('url')) ? 'text-violet-400' : ($hd ? 'text-gray-300 hover:text-white' : 'text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200') }}"
                                            aria-haspopup="menu" aria-expanded="false">
                                            {!! $link->getHtmlIcon() !!}
                                            {{ $link->trans('name') }}
                                            <svg class="hs-dropdown-open:-rotate-180 sm:hs-dropdown-open:rotate-0 duration-200 shrink-0 size-3.5 ms-auto sm:ms-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="m6 9 6 6 6-6"/></svg>
                                        </button>
                                        <div class="hs-dropdown-menu transition-[opacity,margin] duration-[0.1ms] sm:duration-[150ms] hs-dropdown-open:opacity-100 opacity-0 relative sm:min-w-[220px] hidden z-10 before:absolute before:-top-4 before:start-0 before:w-full before:h-5
                                            sm:rounded-2xl sm:overflow-hidden
                                            {{ $hd
                                                ? 'sm:bg-gray-900/90 sm:backdrop-blur-xl sm:border sm:border-white/10 sm:shadow-[0_8px_32px_rgba(109,40,217,0.35)]'
                                                : 'sm:bg-white sm:border sm:border-violet-100 sm:shadow-[0_8px_32px_rgba(109,40,217,0.12)] dark:sm:bg-gray-900 dark:sm:border-violet-900/40 dark:sm:shadow-[0_8px_32px_rgba(109,40,217,0.3)]' }}"
                                            role="menu" aria-orientation="vertical" aria-labelledby="{{ $ddi }}">
                                            {{-- barre accent violet en haut --}}
                                            <div class="hidden sm:block h-0.5 w-full" style="background:linear-gradient(90deg,#7c3aed,#c026d3)"></div>
                                            <div class="p-1.5">
                                                @foreach ($link->getShowableChildrens() as $child)
                                                    <a href="{{ $child->trans('url') }}" {{ $child->link_type === 'new_tab' ? 'target="_blank" rel="noopener"' : '' }}
                                                        class="group flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-150
                                                        {{ $hd
                                                            ? 'hover:bg-white/8 text-gray-300 hover:text-white'
                                                            : 'hover:bg-gradient-to-r hover:from-violet-50 hover:to-fuchsia-50 dark:hover:from-violet-900/20 dark:hover:to-fuchsia-900/10 text-gray-700 dark:text-gray-200' }}">
                                                        @if ($child->getHtmlIcon())
                                                            <span class="shrink-0 flex items-center justify-center w-8 h-8 rounded-lg text-white text-sm"
                                                                style="background:linear-gradient(135deg,#7c3aed,#c026d3)">
                                                                {!! $child->getHtmlIcon() !!}
                                                            </span>
                                                        @endif
                                                        <div class="min-w-0">
                                                            <span class="block text-sm font-semibold truncate {{ $hd ? 'text-white' : 'text-gray-800 dark:text-white' }}">
                                                                {{ $child->trans('name') }}
                                                                @if (isset($child->badge))
                                                                    <span class="inline ms-1 text-xs font-medium text-white py-0.5 px-2 rounded-full" style="background:linear-gradient(135deg,#7c3aed,#c026d3)">{{ $child->trans('badge') }}</span>
                                                                @endif
                                                            </span>
                                                            @if ($child->description)
                                                                <span class="block text-xs truncate {{ $hd ? 'text-gray-400' : 'text-gray-400 dark:text-gray-500' }}">{{ $child->trans('description') }}</span>
                                                            @endif
                                                        </div>
                                                        @if ($child->link_type === 'new_tab')
                                                            <svg class="shrink-0 size-3 opacity-40 ms-auto" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 13v6a2 2 0 01-2 2H5a2 2 0 01-2-2V8a2 2 0 012-2h6M15 3h6v6M10 14L21 3"/></svg>
                                                        @endif
                                                    </a>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <a class="font-medium sm:px-2 mr-3 py-2 sm:py-0 transition-colors duration-200 {{ is_subroute($link->trans('url')) ? 'text-violet-400 hover:text-violet-300' : ($hd ? 'text-gray-300 hover:text-white' : 'text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200') }}"
                                       href="{{ $link->trans('url') }}" {{ $link->link_type === 'new_tab' ? 'target="_blank" rel="noopener"' : '' }}>
                                        {!! $link->getHtmlIcon() !!} {{ $link->trans('name') }}
                                        @if (isset($link->badge))
                                            <span class="inline ms-1 font-medium text-xs bg-violet-600 text-white py-1 px-2 rounded-full">{{ $link->trans('badge') }}</span>
                                        @endif
                                    </a>
                                @endif
                            @endforeach
                        </div>
                    </div>

                    <div class="flex items-center justify-end ms-auto sm:justify-between sm:gap-x-3 sm:order-3">
                        <div class="flex flex-row items-center justify-end gap-2 {{ $hd ? '[&_.btn-icon2]:text-gray-300 [&_.btn-icon2:hover]:bg-white/8 [&_.btn-icon2]:border-white/10' : '' }}">
                            @include('shared.layouts.iconright')
                        </div>
                        <div class="sm:hidden">
                            <button type="button" class="hs-collapse-toggle size-9 flex justify-center items-center text-sm font-semibold rounded-lg {{ $hd ? 'text-gray-300 hover:bg-white/10' : 'text-gray-800 hover:bg-gray-100 dark:text-white dark:hover:bg-neutral-700' }} disabled:opacity-50 disabled:pointer-events-none p-1" data-hs-collapse="#navbar-menu" aria-controls="navbar-menu" aria-label="Toggle navigation">
                                <svg class="hs-collapse-open:hidden flex-shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="3" x2="21" y1="6" y2="6"/><line x1="3" x2="21" y1="12" y2="12"/><line x1="3" x2="21" y1="18" y2="18"/></svg>
                                <svg class="hs-collapse-open:block hidden flex-shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
                            </button>
                        </div>
                    </div>
                </nav>
            </header>

            <div id="navbar-menu" class="{{ $hd ? 'hero-nav-menu' : 'dark:bg-gray-800 dark:border-gray-700' }} hs-collapse hidden overflow-hidden transition-all duration-300 basis-full grow" tabindex="-1">
                <div class="mx-auto flex flex-col gap-y-1 gap-x-0 my-4 px-4 sm:hidden">
                    @foreach (app('theme')->getFrontLinks() as $link)
                        @if ($link->link_type === 'dropdown')
                            <div>
                                <p class="px-3 py-1.5 text-xs font-semibold uppercase tracking-widest {{ $hd ? 'text-gray-400' : 'text-gray-400 dark:text-gray-500' }}">
                                    {!! $link->getHtmlIcon() !!} {{ $link->trans('name') }}
                                </p>
                                @foreach ($link->getShowableChildrens() as $child)
                                    <a href="{{ $child->trans('url') }}" {{ $child->link_type === 'new_tab' ? 'target="_blank" rel="noopener"' : '' }}
                                        class="flex items-center gap-2 px-4 py-2 text-sm font-medium rounded-lg transition-colors duration-150 {{ $hd ? 'text-gray-300 hover:bg-white/10' : 'text-gray-600 hover:bg-violet-50 dark:text-gray-300 dark:hover:bg-violet-900/20' }}">
                                        @if ($child->getHtmlIcon())
                                            <span class="text-violet-500">{!! $child->getHtmlIcon() !!}</span>
                                        @endif
                                        {{ $child->trans('name') }}
                                        @if (isset($child->badge))
                                            <span class="inline ms-1 text-xs font-medium bg-violet-600 text-white py-0.5 px-2 rounded-full">{{ $child->trans('badge') }}</span>
                                        @endif
                                    </a>
                                @endforeach
                            </div>
                        @else
                            <a class="flex items-center gap-2 px-3 py-2 text-sm font-medium rounded-lg transition-colors duration-150 {{ is_subroute($link->trans('url')) ? 'text-violet-500 bg-violet-50 dark:bg-violet-900/20' : ($hd ? 'text-gray-300 hover:bg-white/10' : 'text-gray-600 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700') }}"
                               href="{{ $link->trans('url') }}" {{ $link->link_type === 'new_tab' ? 'target="_blank" rel="noopener"' : '' }}>
                                <i class="{{ $link->icon }} mr-1"></i> {{ $link->trans('name') }}
                                @if (isset($link->badge))
                                    <span class="inline ms-1 font-medium text-xs bg-violet-600 text-white py-1 px-2 rounded-full">{{ $link->trans('badge') }}</span>
                                @endif
                            </a>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
        @yield('content')

    </main>
    @include('layouts.footer')
</div>
@yield('scripts')
{!! app('seo')->foot('front') !!}
<form method="POST" action="{{ route('logout') }}" id="logout-form">
    @csrf
</form>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>

    document.querySelectorAll('.confirmation-popup').forEach(
        function (element) {
            element.addEventListener('submit', function (event) {
                event.preventDefault();
                confirmation(element).then((result) => {
                    if (result.isConfirmed) {
                        element.submit();
                    }
                });
            });
        }
    )
    function confirmation(element) {
        const text = element.getAttribute('data-text') ?? '{{ __('admin.doyouwantreally') }}';
        const icon = element.getAttribute('data-icon') ?? 'warning';
        const confirmButtonText = element.getAttribute('data-confirm-button-text') ?? '{{ __('global.delete') }}';
        const showCancelButton = element.getAttribute('data-show-cancel-button') ?? true;
        const cancelButtonText = element.getAttribute('data-cancel-button-text') ?? '{{ __('global.cancel') }}';
        return Swal.fire({
            text: text,
            icon: icon,
            confirmButtonText: confirmButtonText,
            showCancelButton: showCancelButton,
            cancelButtonText: cancelButtonText,
            confirmButtonColor: '#7c3aed',
            cancelButtonColor: '#6b7280',
        })
    }
</script>

</body>
</html>
