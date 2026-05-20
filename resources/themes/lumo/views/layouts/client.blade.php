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
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    {{-- ... --}}
    <title>@yield('title') {{ translated_setting('seo_site_title') }}</title>
    @yield('styles')
    @vite('resources/themes/default/js/app.js')
    @vite('resources/themes/default/css/app.scss')
    {!! app('seo')->head('client', $meta_append ?? null) !!}
    {!! app('seo')->favicon('client') !!}
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
</head>

<body class="bg-[#f5f3ff] {{is_darkmode() ? 'dark' : '' }}">
    {!! method_exists(app('seo'), 'header') ? app('seo')->header() : '' !!}
<div class="dark:bg-[#07001a] min-h-screen">
    <main id="content" role="main">
        <div class="relative">
            <header class="relative flex flex-wrap sm:justify-start sm:flex-nowrap z-50 w-full bg-white/95 backdrop-blur-sm border-b border-violet-200/60 text-sm py-3 sm:py-5 dark:bg-[#0f0527]/95 dark:border-violet-900/40 print:hidden">
                <div class="absolute bottom-0 left-0 right-0 h-[2px] pointer-events-none" style="background:linear-gradient(90deg,transparent 0%,rgba(124,58,237,0.5) 30%,rgba(192,38,211,0.5) 70%,transparent 100%)"></div>
                <nav class="max-w-7xl flex basis-full items-center mx-auto px-4 sm:px-6 lg:px-8" aria-label="Global">
                    <div class="me-5 md:me-8">
                        @if (setting('theme_header_logo', false))
                            <a class="flex-none text-xl font-semibold dark:text-white dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600" href="/" aria-label="{{ setting('app_name') }}">
                                <img class="mx-auto h-10 w-auto" src="{{ setting('app_logo_text', asset('images/logo.png')) }}" alt="{{ setting('app_name') }}">
                            </a>
                        @else
                            <a class="flex-none text-xl font-bold tracking-tight text-gray-900 dark:text-white dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600" href="/" aria-label="{{ setting('app_name') }}">{{ setting('app_name') }}</a>
                        @endif
                    </div>
                    <div class="hs-overlay hs-overlay-open:translate-x-0 -translate-x-full fixed top-0 start-0 transition-all duration-300 transform h-full max-w-xs w-full z-[60] bg-white border-e basis-full grow sm:order-2 sm:static sm:block sm:h-auto sm:max-w-none sm:w-auto sm:border-r-transparent sm:transition-none sm:translate-x-0 sm:z-40 sm:basis-auto dark:bg-gray-800 dark:border-r-gray-700 sm:dark:border-r-transparent sm:block" tabindex="-1">
                        <div class="flex flex-col gap-y-4 gap-x-0 mt-5 sm:flex-row sm:items-center sm:justify-end sm:gap-y-0 sm:mt-0 sm:ps-7">
                            @foreach (app('theme')->getFrontLinks() as $link)
                                <a class="font-medium sm:px-2 mr-3 transition-colors duration-200 {{ is_subroute($link) ? 'text-violet-600 hover:text-violet-500 dark:text-violet-400 dark:hover:text-violet-300' : 'text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200' }}" href="{{ $link->trans('url') }}">
                                    <i class="{{ $link->trans('icon') }}  mr-1"></i> {{ $link->trans('name') }}
                                    @if (isset($link->badge))
                                        <span class="inline ms-1 font-medium text-xs bg-violet-600 text-white py-1 px-2 rounded-full">{{ $link->trans('badge') }}</span>
                                    @endif
                                </a>
                            @endforeach
                        </div>
                    </div>

                    <div class="flex items-center justify-end ms-auto sm:justify-between sm:gap-x-3 sm:order-3">
                        <div class="sm:hidden">
                            <button type="button" class="hs-collapse-toggle size-9 flex justify-center items-center text-sm font-semibold rounded-lg border border-gray-200 text-gray-800 hover:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:text-white dark:border-neutral-700 dark:hover:bg-neutral-700" data-hs-collapse="#navbar-menu" aria-controls="navbar-menu" aria-label="Toggle navigation">
                                <svg class="hs-collapse-open:hidden flex-shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="3" x2="21" y1="6" y2="6"/><line x1="3" x2="21" y1="12" y2="12"/><line x1="3" x2="21" y1="18" y2="18"/></svg>
                                <svg class="hs-collapse-open:block hidden flex-shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
                            </button>
                        </div>

                        <div class="flex flex-row items-center justify-end gap-2">
                            @include('shared.layouts.iconright')
                        </div>
                    </div>
                </nav>
            </header>

        </div>
<!-- ========== END HEADER ========== -->

<!-- ========== MAIN CONTENT ========== -->
    <!-- Nav -->
    <nav class="print:hidden bg-white/80 backdrop-blur-sm border-b border-violet-100 text-sm font-medium dark:bg-[#0a0120]/80 dark:border-violet-900/30" aria-label="Jump links">
        <div class="max-w-7xl w-full flex items-center overflow-x-auto px-4 sm:px-6 lg:px-8 mx-auto gap-1
            [&::-webkit-scrollbar]:h-1.5 [&::-webkit-scrollbar-thumb]:rounded-full
            [&::-webkit-scrollbar-track]:bg-transparent [&::-webkit-scrollbar-thumb]:bg-gray-300
            dark:[&::-webkit-scrollbar-thumb]:bg-gray-600">
            @foreach(\App\Http\Navigation\ClientNavigationMenu::getItems() as $item)
                @php($active = is_subroute(route($item['route'])) && $item['route'] != 'front.client.index')
                <a class="flex items-center gap-x-2 py-2 px-4 my-2 whitespace-nowrap rounded-lg text-sm transition-all duration-200 shrink-0 font-medium
                    {{ $active
                        ? 'bg-violet-600 text-white shadow-sm'
                        : 'text-gray-500 dark:text-gray-400 hover:bg-violet-50 dark:hover:bg-violet-900/20 hover:text-violet-700 dark:hover:text-violet-300' }}"
                   href="{{ route($item['route']) }}">
                    <i class="{{ $item['icon'] }} text-[13px]"></i>
                    {{ $item['name'] }}
                </a>
            @endforeach
        </div>
    </nav>

        <div id="navbar-menu" class="dark:bg-gray-800 dark:border-gray-700 hs-collapse hidden overflow-hidden transition-all duration-300 basis-full grow" tabindex="-1">
            <div class="mx-auto flex flex-col gap-y-4 gap-x-0 my-5 ml-3 sm:flex-row sm:items-center sm:gap-y-0 sm:gap-x-7 sm:mt-0 sm:ps-7">
                @foreach (app('theme')->getFrontLinks() as $link => $data)
                    <a class="font-medium sm:px-2 mr-3 transition-colors duration-200 {{ is_subroute($link) ? 'text-violet-600 hover:text-violet-500 dark:text-violet-400 dark:hover:text-violet-300' : 'text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200' }}" href="{{ $link }}">
                        <i class="{{ $data['icon'] }} mr-1"></i> {{ $data['name'] }}
                    </a>
                @endforeach
            </div>
        </div>
    <!-- End Nav -->
        @yield('content')
</main>
@include('layouts.footer')
</div>
@yield('scripts')
{!! app('seo')->foot('client') !!}

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
