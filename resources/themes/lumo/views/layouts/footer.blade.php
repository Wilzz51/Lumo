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

@php($footerDark = is_darkmode() && theme_config('theme_footer_style', 'dark') !== 'light')

<footer class="print:hidden mt-auto {{ $footerDark ? 'bg-gray-950 border-t border-white/5' : 'bg-white border-t border-gray-200 dark:bg-gray-900 dark:border-gray-700' }}">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 lg:py-16">

        {{-- Top row: logo + description + tophébergeur --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 lg:gap-12 pb-10 {{ $footerDark ? 'border-b border-white/5' : 'border-b border-gray-200 dark:border-gray-700' }}">
            <div class="md:col-span-1">
                @if (setting('app_logo_text'))
                    <img src="{{ setting('app_logo_text') }}"
                         class="h-10 w-auto mb-4 {{ $footerDark ? 'brightness-0 invert' : '' }}"
                         alt="{{ setting('app_name') }}">
                @else
                    <span class="text-xl font-bold {{ $footerDark ? 'text-white' : 'text-gray-900 dark:text-white' }} mb-4 block">
                        {{ setting('app_name') }}
                    </span>
                @endif
                <p class="text-sm leading-relaxed {{ $footerDark ? 'text-gray-500' : 'text-gray-500 dark:text-gray-400' }}">
                    {!! translated_setting('theme_footer_description') !!}
                </p>
            </div>

            <div class="md:col-span-2 flex justify-start md:justify-end items-start">
                {!! setting('theme_footer_topheberg') !!}
            </div>
        </div>

        {{-- Bottom row: copyright + links + socials --}}
        <div class="pt-8 flex flex-col md:flex-row items-center justify-between gap-6">

            {{-- Copyright --}}
            <p class="text-sm {{ $footerDark ? 'text-gray-600' : 'text-gray-400 dark:text-gray-500' }} order-last md:order-first">
                &copy; {{ date('Y') }} {{ setting('app_name') }}. All rights reserved.
            </p>

            {{-- Footer links --}}
            <nav class="flex flex-wrap justify-center gap-x-6 gap-y-2">
                @foreach (app('theme')->getBottomLinks() as $link)
                    <a href="{{ $link->trans('url') }}"
                       class="text-sm transition-colors duration-200 {{ $footerDark ? 'text-gray-500 hover:text-violet-400' : 'text-gray-500 hover:text-violet-600 dark:text-gray-400 dark:hover:text-violet-400' }}"
                       {{ $link->link_type == 'new_tab' ? ' target="_blank"' : '' }}>
                        @if ($link->icon)
                            <i class="{{ $link->icon }} mr-1 text-xs"></i>
                        @endif
                        {{ $link->trans('name') }}
                    </a>
                @endforeach
            </nav>

            {{-- Social icons --}}
            <div class="flex items-center gap-2">
                @foreach (app('theme')->getSocialsNetworks() as $network)
                    <a href="{{ $network->url }}"
                       class="w-8 h-8 flex items-center justify-center rounded-lg transition-all duration-200 {{ $footerDark ? 'text-gray-600 hover:text-violet-400 hover:bg-white/5' : 'text-gray-400 hover:text-violet-600 hover:bg-violet-50 dark:hover:text-violet-400 dark:hover:bg-violet-900/20' }}">
                        <i class="{{ $network->icon }} text-sm"></i>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</footer>

@if (!is_gdpr_compliment() && setting('gdrp_cookies_privacy_link') != null)
    @include('shared/gdpr')
@endif
