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

@extends('layouts/front')
@section('title', $product->name)
@section('styles')
<style>
    /* ===== Billing option cards ===== */
    .billing-card {
        cursor: pointer;
        border-radius: 16px;
        border: 2px solid #e5e7eb;
        background: #f9fafb;
        padding: 18px;
        display: flex;
        flex-direction: column;
        transition: border-color 0.18s ease, background 0.18s ease, box-shadow 0.18s ease;
        position: relative;
    }
    .dark .billing-card {
        background: rgba(255,255,255,0.04);
        border-color: rgba(255,255,255,0.08);
    }
    .billing-card:hover {
        border-color: rgba(124,58,237,0.4);
        background: rgba(124,58,237,0.03);
    }
    .dark .billing-card:hover {
        background: rgba(124,58,237,0.07);
        border-color: rgba(124,58,237,0.4);
    }
    .billing-card:has(input[type="radio"]:checked) {
        border-color: #7c3aed;
        background: rgba(124,58,237,0.06);
        box-shadow: 0 0 0 3px rgba(124,58,237,0.12);
    }
    .dark .billing-card:has(input[type="radio"]:checked) {
        background: rgba(124,58,237,0.18);
        border-color: #7c3aed;
        box-shadow: 0 0 0 3px rgba(124,58,237,0.25);
    }
    .bc-radio {
        width: 20px; height: 20px;
        border-radius: 50%;
        border: 2px solid #d1d5db;
        display: flex; align-items: center; justify-content: center;
        transition: border-color 0.18s, background 0.18s;
        flex-shrink: 0;
    }
    .dark .bc-radio { border-color: rgba(255,255,255,0.2); }
    .billing-card:has(input:checked) .bc-radio {
        border-color: #7c3aed;
        background: #7c3aed;
    }
    .bc-dot {
        width: 8px; height: 8px;
        border-radius: 50%;
        background: white;
        transform: scale(0);
        transition: transform 0.18s ease;
    }
    .billing-card:has(input:checked) .bc-dot { transform: scale(1); }
    .bc-period { transition: color 0.18s; }
    .billing-card:has(input:checked) .bc-period { color: #7c3aed; }
    .dark .billing-card:has(input:checked) .bc-period { color: #c4b5fd; }
</style>
@endsection
@section('scripts')
    <script src="{{ Vite::asset('resources/themes/default/js/basket.js') }}" type="module"></script>
@endsection
@section('content')

@php($dm = is_darkmode())

{{-- Product header bar --}}
<div style="border-bottom:1px solid {{ $dm ? 'rgba(255,255,255,0.07)' : 'rgba(124,58,237,0.1)' }};
    {{ $dm ? 'background:linear-gradient(135deg,#0f0527,#1a0a3e,#130630)' : 'background:linear-gradient(135deg,#faf7ff,#f5f0ff,#fff)' }}">
    <div class="{{ theme_metadata('layout_classes', 'max-w-[85rem] px-4 py-5 sm:px-6 lg:px-8 mx-auto') }}">
        <div class="flex items-center gap-4">
            <div class="flex-shrink-0 w-11 h-11 rounded-xl flex items-center justify-center"
                 style="background:linear-gradient(135deg,#7c3aed,#c026d3)">
                @if($product->image)
                    <img src="{{ Storage::url($product->image) }}" alt="{{ $product->trans('name') }}" class="w-7 h-7 object-cover rounded-lg">
                @else
                    <svg class="w-5 h-5 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="20" height="8" rx="2"/><rect x="2" y="14" width="20" height="8" rx="2"/></svg>
                @endif
            </div>
            <div>
                <div style="font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:0.1em;margin-bottom:2px;color:{{ $dm ? 'rgba(196,181,253,0.5)' : '#9ca3af' }}">{{ __('store.config.title') }}</div>
                <h1 style="font-size:1.15rem;font-weight:800;color:{{ $dm ? '#fff' : '#111827' }}">{{ $product->trans('name') }}</h1>
            </div>
        </div>
    </div>
</div>

<div class="{{ theme_metadata('layout_classes', 'max-w-[85rem] px-4 py-10 sm:px-6 lg:px-8 lg:py-12 mx-auto') }}">

    <form id="basket-config-form"
          data-pricing-endpoint="{{ route('front.store.basket.config.preview', ['product' => $product]) }}"
          method="POST"
          action="{{ route('front.store.basket.config', ['product' => $product]) }}{{(request()->getQueryString() != null ? '?' . request()->getQueryString() : '')}}">

        <input type="hidden" name="currency" value="{{ $row->currency }}" id="currency">
        @csrf
        @include("shared.alerts")

        <div class="grid grid-cols-3 gap-6">

            {{-- ===== LEFT: Configuration ===== --}}
            <div class="col-span-3 md:col-span-2 space-y-5">

                {{-- Billing section --}}
                <div id="basket-billing-section" class="rounded-2xl p-6"
                     style="{{ $dm ? 'background:rgba(255,255,255,0.03);border:1px solid rgba(255,255,255,0.07)' : 'background:#fff;border:1px solid rgba(124,58,237,0.1);box-shadow:0 4px 24px rgba(124,58,237,0.06)' }}">
                    <h2 class="text-sm font-bold uppercase tracking-widest mb-5"
                        style="color:{{ $dm ? '#c4b5fd' : '#7c3aed' }}">
                        {{ __('store.config.billing') }}
                    </h2>
                    @php($pricings = $product->pricingAvailable(currency()))
                    <div class="grid sm:grid-cols-3 gap-3">
                        @foreach ($pricings as $pricing)
                        <label class="billing-card" for="billing-{{ $pricing->recurring }}-{{ $pricing->currency }}">

                            {{-- Top: radio + discount badge --}}
                            <div class="flex items-center justify-between mb-4">
                                <div class="bc-radio"><div class="bc-dot"></div></div>
                                @if ($pricing->hasDiscountOnRecurring($product->getFirstPrice()))
                                <span style="font-size:11px;font-weight:700;padding:3px 8px;border-radius:8px;background:rgba(16,185,129,0.15);color:#059669">
                                    -{{ $pricing->getDiscountOnRecurring($product->getFirstPrice()) }}%
                                </span>
                                @endif
                            </div>

                            {{-- Price --}}
                            <div style="font-size:1.5rem;font-weight:900;line-height:1;margin-bottom:4px;color:{{ $dm ? '#fff' : '#111827' }}">
                                @if ($pricing->isFree())
                                    {{ __('global.free') }}
                                @else
                                    {{ $pricing->getPriceByDisplayMode() }}<span style="font-size:0.9rem;font-weight:600;color:{{ $dm ? 'rgba(255,255,255,0.35)' : '#9ca3af' }}"> {{ $pricing->getSymbol() }}</span>
                                @endif
                            </div>

                            {{-- Period --}}
                            <div class="bc-period text-sm font-semibold"
                                 style="color:{{ $dm ? 'rgba(255,255,255,0.45)' : '#6b7280' }}">
                                {{ $pricing->recurring()['translate'] }}
                            </div>

                            {{-- Pricing message --}}
                            @if($pricing->pricingMessage())
                            <div style="font-size:11px;margin-top:4px;color:{{ $dm ? 'rgba(255,255,255,0.25)' : '#9ca3af' }}">
                                {{ $pricing->pricingMessage() }}
                            </div>
                            @endif

                            {{-- Hidden radio — all original attributes preserved --}}
                            <input type="radio"
                                   name="billing"
                                   value="{{ $pricing->recurring }}"
                                   {{ ($billing == $pricing->recurring) || $loop->first ? 'checked' : '' }}
                                   data-pricing="{{ $pricing->toJson() }}"
                                   class="sr-only"
                                   id="billing-{{ $pricing->recurring }}-{{ $pricing->currency }}">
                        </label>
                        @endforeach
                    </div>
                </div>

                {{-- Options --}}
                @if (!empty($options_html))
                <div class="rounded-2xl p-6"
                     style="{{ $dm ? 'background:rgba(255,255,255,0.03);border:1px solid rgba(255,255,255,0.07)' : 'background:#fff;border:1px solid rgba(124,58,237,0.1);box-shadow:0 4px 24px rgba(124,58,237,0.06)' }}">
                    <h2 class="text-sm font-bold uppercase tracking-widest mb-5"
                        style="color:{{ $dm ? '#c4b5fd' : '#7c3aed' }}">{{ __('store.config.options') }}</h2>
                    {!! $options_html !!}
                </div>
                @endif

                {{-- Data --}}
                @if (!empty($data_html))
                <div class="rounded-2xl p-6"
                     style="{{ $dm ? 'background:rgba(255,255,255,0.03);border:1px solid rgba(255,255,255,0.07)' : 'background:#fff;border:1px solid rgba(124,58,237,0.1);box-shadow:0 4px 24px rgba(124,58,237,0.06)' }}">
                    {!! $data_html !!}
                </div>
                @endif

                @if (app('extension')->extensionIsEnabled('free_trial'))
                    @include('free_trial::config_card', ['product' => $product])
                @endif

                @if (app('extension')->extensionIsEnabled('faq'))
                    @include('faq::widget', [
                        'product'     => $product ?? null,
                        'title'       => __('faq::messages.client.product_title', ['name' => $product->name]),
                        'description' => __('faq::messages.client.product_description', ['name' => $product->name]),
                    ])
                @endif
            </div>

            {{-- ===== RIGHT: Summary panel ===== --}}
            <div class="col-span-3 md:col-span-1">
                <div class="sticky top-6">
                    <div class="rounded-2xl overflow-hidden"
                         style="{{ $dm ? 'background:rgba(255,255,255,0.03);border:1px solid rgba(255,255,255,0.08)' : 'background:#fff;box-shadow:0 8px 40px rgba(124,58,237,0.12);border:1px solid rgba(124,58,237,0.1)' }}">

                        {{-- Gradient header with big total --}}
                        <div style="background:linear-gradient(135deg,#6d28d9 0%,#c026d3 100%);padding:24px 24px 20px">
                            <div style="font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:0.12em;color:rgba(255,255,255,0.5);margin-bottom:8px">
                                {{ __('store.config.summary') }}
                            </div>
                            <div style="font-size:2.6rem;font-weight:900;color:#fff;line-height:1" id="total">0</div>
                            <div style="font-size:11px;color:rgba(255,255,255,0.38);margin-top:5px">Toutes taxes comprises</div>
                        </div>

                        {{-- Error --}}
                        <div id="basket-config-error" class="hidden text-sm text-red-500 px-6 pt-4"></div>

                        {{-- Line items --}}
                        <div style="padding:20px 24px;display:flex;flex-direction:column;gap:9px">

                            <div style="display:flex;justify-content:space-between;align-items:center;font-size:13px">
                                <span style="color:{{ $dm ? 'rgba(255,255,255,0.38)' : '#9ca3af' }}">{{ __('global.product') }}</span>
                                <span style="font-weight:600;color:{{ $dm ? '#fff' : '#111827' }};text-align:right;max-width:60%">{{ $row->product->name }}</span>
                            </div>

                            @if ($options->isNotEmpty())
                                <div style="height:1px;background:{{ $dm ? 'rgba(255,255,255,0.06)' : '#f3f4f6' }}"></div>
                                @foreach ($options as $option)
                                <div style="display:flex;justify-content:space-between;align-items:center;font-size:13px">
                                    <span id="options_name[{{ $option->key }}]" data-name="{{ $option->name }}"
                                          style="color:{{ $dm ? 'rgba(255,255,255,0.38)' : '#9ca3af' }}">{{ $option->name }}</span>
                                    <span id="options_price[{{ $option->key }}]"
                                          style="font-weight:600;color:{{ $dm ? '#e9d5ff' : '#6d28d9' }}">0</span>
                                </div>
                                @endforeach
                                <div style="height:1px;background:{{ $dm ? 'rgba(255,255,255,0.06)' : '#f3f4f6' }}"></div>
                            @endif

                            <div style="display:flex;justify-content:space-between;font-size:13px">
                                <span style="color:{{ $dm ? 'rgba(255,255,255,0.38)' : '#9ca3af' }}">{{ __('store.config.recurring_payment') }}</span>
                                <span id="recurring" style="font-weight:600;color:{{ $dm ? '#e9d5ff' : '#6d28d9' }}">0</span>
                            </div>
                            <div style="display:flex;justify-content:space-between;font-size:13px">
                                <span style="color:{{ $dm ? 'rgba(255,255,255,0.38)' : '#9ca3af' }}">{{ __('store.config.onetime_payment') }}</span>
                                <span id="onetime" style="font-weight:600;color:{{ $dm ? '#e9d5ff' : '#6d28d9' }}">0</span>
                            </div>
                            <div style="display:flex;justify-content:space-between;font-size:13px">
                                <span style="color:{{ $dm ? 'rgba(255,255,255,0.38)' : '#9ca3af' }}">{{ __('store.fees') }}</span>
                                <span id="fees" style="color:{{ $dm ? 'rgba(255,255,255,0.5)' : '#6b7280' }}">0</span>
                            </div>
                            <div style="display:flex;justify-content:space-between;font-size:13px">
                                <span style="color:{{ $dm ? 'rgba(255,255,255,0.38)' : '#9ca3af' }}">{{ __('store.subtotal') }}</span>
                                <span id="subtotal" style="color:{{ $dm ? 'rgba(255,255,255,0.5)' : '#6b7280' }}">0</span>
                            </div>
                            <div style="display:flex;justify-content:space-between;font-size:13px">
                                <span style="color:{{ $dm ? 'rgba(255,255,255,0.38)' : '#9ca3af' }}">{{ __('store.vat') }}</span>
                                <span id="taxes" style="color:{{ $dm ? 'rgba(255,255,255,0.5)' : '#6b7280' }}">0</span>
                            </div>

                        </div>

                        {{-- Submit --}}
                        <div style="padding:0 24px 24px">
                            <button type="submit"
                                    class="w-full py-3.5 rounded-xl text-sm font-bold text-white flex items-center justify-center gap-2 transition-all duration-200 hover:-translate-y-0.5"
                                    style="background:linear-gradient(135deg,#7c3aed,#c026d3);box-shadow:0 6px 24px rgba(124,58,237,0.35)">
                                {{ __('store.basket.addtocart') }}
                                <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                            </button>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </form>
</div>

@endsection
