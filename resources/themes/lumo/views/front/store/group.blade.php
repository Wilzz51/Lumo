<?php
/*
 * This file is part of the CLIENTXCMS project.
 * It is the property of the CLIENTXCMS association.
 *
 * Personal and non-commercial use of this source code is permitted.
 * However, any use in a project that generates profit (directly or indirectly),
 * or any reuse for commercial purposes, requires prior authorization from CLIENTXCMS.
 *
 * To request permission or for more information, please contact any support:
 * https://clientxcms.com/client/support
 *
 * Learn more about CLIENTXCMS License at:
 * https://clientxcms.com/eula
 *
 * Year: 2025
 */
?>

@extends('layouts/front')
@section('title', $title)
@section('content')

    @if(is_darkmode())
        <div class="page-banner-dark py-14 lg:py-20">
            <div class="absolute top-0 left-1/3 w-72 h-72 bg-violet-400/15 rounded-full blur-3xl pointer-events-none"></div>
            <div class="absolute bottom-0 right-1/3 w-64 h-64 bg-fuchsia-400/10 rounded-full blur-3xl pointer-events-none"></div>
            <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-white/10 border border-white/20 text-white/80 text-xs font-medium mb-5">
                    <svg class="w-3 h-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
                    {{ __('store.store') ?? 'Boutique' }}
                </div>
                <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-white tracking-tight mb-3">{{ $title }}</h1>
                @if($subtitle)
                    <p class="text-base text-violet-200/70 max-w-xl mx-auto">{{ $subtitle }}</p>
                @endif
            </div>
            <div class="absolute bottom-0 left-0 right-0 h-16 bg-gradient-to-t from-gray-900 to-transparent pointer-events-none"></div>
        </div>
    @else
        <div class="py-12 lg:py-16 bg-white border-b border-gray-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-violet-50 border border-violet-200 text-violet-700 text-xs font-medium mb-4">
                    <svg class="w-3 h-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
                    {{ __('store.store') ?? 'Boutique' }}
                </div>
                <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-gray-900 tracking-tight mb-3">{{ $title }}</h1>
                @if($subtitle)
                    <p class="text-base text-gray-500 max-w-xl mx-auto">{{ $subtitle }}</p>
                @endif
            </div>
        </div>
    @endif

    <div class="{{ theme_metadata('layout_classes', 'max-w-[85rem] px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto') }}">
        @include("shared.alerts")

        {{-- Sub-groups --}}
        @foreach($groups->chunk(3) as $row)
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
                @foreach($row as $group)
                    @php($startPrice = $group->startPrice())
                    <div class="group flex flex-col h-full bg-white border border-gray-100 shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1 rounded-2xl dark:bg-gray-800 dark:border-gray-700/50">
                        @if ($group->image)
                            <div class="h-48 flex flex-col justify-center items-center bg-gradient-to-br from-violet-600 via-violet-500 to-fuchsia-600 rounded-t-2xl overflow-hidden relative">
                                <div class="absolute inset-0 bg-[linear-gradient(to_right,rgba(255,255,255,0.05)_1px,transparent_1px),linear-gradient(to_bottom,rgba(255,255,255,0.05)_1px,transparent_1px)] bg-[size:32px_32px]"></div>
                                <img src="{{ Storage::url($group->image) }}" class="{{ $group->useImageAsBackground() ? 'h-full w-full object-cover' : 'h-28 w-28 drop-shadow-xl relative z-10' }}" alt="{{ $group->trans('name') }}">
                            </div>
                        @else
                            <div class="h-1.5 bg-gradient-to-r from-violet-500 to-fuchsia-500 rounded-t-2xl"></div>
                        @endif
                        <div class="p-6 flex-1">
                            @if ($group->pinned)
                                <span class="inline-flex items-center mb-2 text-xs font-bold uppercase tracking-wider text-violet-600 dark:text-violet-400">
                                    <span class="w-1.5 h-1.5 rounded-full bg-violet-500 mr-1.5"></span>
                                    {{ $group->getMetadata('pinned_label', __('store.pinned')) }}
                                </span>
                            @endif
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white group-hover:text-violet-600 dark:group-hover:text-violet-400 transition-colors duration-200">
                                {{ $group->trans('name') }}
                            </h3>
                            <p class="mt-3 text-sm text-gray-500 dark:text-gray-400 leading-relaxed">{{ $group->trans('description') }}</p>
                        </div>
                        <div class="px-6 pb-6 mt-auto">
                            <a href="{{ $group->route() }}" class="group/btn w-full py-2.5 px-4 inline-flex justify-between items-center text-sm font-semibold rounded-xl bg-gray-50 hover:bg-violet-50 text-gray-700 hover:text-violet-700 border border-gray-200 hover:border-violet-300 dark:bg-gray-700/50 dark:hover:bg-violet-900/30 dark:text-gray-300 dark:hover:text-violet-300 dark:border-gray-600 dark:hover:border-violet-700 transition-all duration-200">
                                <span>
                                    @if ($startPrice->isFree()) {{ __('global.free') }}
                                    @else {{ __('store.from_price', ['price' => $startPrice->price, 'currency' => $startPrice->currency]) }}
                                    @endif
                                </span>
                                <span class="flex items-center gap-1 text-violet-600 dark:text-violet-400">
                                    {{ __('global.seemore') }}
                                    <svg class="w-4 h-4 transition-transform duration-200 group-hover/btn:translate-x-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                                </span>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endforeach

        {{-- Products grid --}}
        @foreach($products->chunk(3) as $row)
            <div class="mt-8 grid sm:grid-cols-2 lg:grid-cols-3 gap-6 lg:items-stretch">
                @foreach($row as $product)
                    @if($product->pinned)
                        @include('shared.products.pinned')
                    @else
                        @include('shared.products.product')
                    @endif
                @endforeach
            </div>
        @endforeach
    </div>

    @if (app('extension')->extensionIsEnabled('faq'))
        @include('faq::widget', ['group' => $group ?? null])
    @endif
    {!! render_theme_sections() !!}
@endsection
