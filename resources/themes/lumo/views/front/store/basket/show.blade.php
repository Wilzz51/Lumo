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
@section('title', __('store.basket.title'))
@section('scripts')
    <script src="{{ Vite::asset('resources/themes/default/js/basket.js') }}" type="module"></script>
@endsection
@section('content')

@php($dm = is_darkmode())

{{-- Page header --}}
<div style="border-bottom:1px solid {{ $dm ? 'rgba(255,255,255,0.07)' : 'rgba(124,58,237,0.1)' }};{{ $dm ? 'background:linear-gradient(135deg,#0f0527,#1a0a3e,#130630)' : 'background:linear-gradient(135deg,#faf7ff,#f5f0ff,#fff)' }}">
    <div class="{{ theme_metadata('layout_classes', 'max-w-[85rem] px-4 py-5 sm:px-6 lg:px-8 mx-auto') }}">
        <div class="flex items-center gap-4">
            <div class="flex-shrink-0 w-11 h-11 rounded-xl flex items-center justify-center"
                 style="background:linear-gradient(135deg,#7c3aed,#c026d3)">
                <svg class="w-5 h-5 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="10" cy="20.5" r="1"/><circle cx="18" cy="20.5" r="1"/><path d="M2.5 2.5h3l2.7 12.4a2 2 0 0 0 2 1.6h7.7a2 2 0 0 0 2-1.6l1.6-8.4H7.1"/></svg>
            </div>
            <div>
                <div style="font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:0.1em;margin-bottom:2px;color:{{ $dm ? 'rgba(196,181,253,0.5)' : '#9ca3af' }}">{{ __('store.store') }}</div>
                <h1 style="font-size:1.15rem;font-weight:800;color:{{ $dm ? '#fff' : '#111827' }}">{{ __('store.basket.title') }}</h1>
            </div>
        </div>
    </div>
</div>

<div class="{{ theme_metadata('layout_classes', 'max-w-[85rem] px-4 py-10 sm:px-6 lg:px-8 lg:py-12 mx-auto') }}">
    @include("shared.alerts")

    <div class="flex flex-col md:flex-row gap-6">

        {{-- ===== LEFT: Items + Coupon ===== --}}
        <div class="min-w-0 flex-1 space-y-5">

            {{-- Items table --}}
            <div class="rounded-2xl overflow-hidden"
                 style="{{ $dm ? 'background:rgba(255,255,255,0.03);border:1px solid rgba(255,255,255,0.07)' : 'background:#fff;border:1px solid rgba(124,58,237,0.1);box-shadow:0 4px 24px rgba(124,58,237,0.06)' }}">

                {{-- Table head --}}
                <div style="padding:14px 24px;border-bottom:1px solid {{ $dm ? 'rgba(255,255,255,0.06)' : '#f3f4f6' }};background:{{ $dm ? 'rgba(255,255,255,0.03)' : '#fafafa' }}">
                    <div style="display:grid;grid-template-columns:1fr 120px 120px 100px;gap:12px;font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;color:{{ $dm ? 'rgba(255,255,255,0.3)' : '#9ca3af' }}">
                        <div>{{ __('global.product') }}</div>
                        <div>{{ __('store.price') }}</div>
                        <div>{{ __('store.qty') }}</div>
                        <div style="text-align:right">{{ __('store.total') }}</div>
                    </div>
                </div>

                @if ($basket->items()->count() == 0)
                    <div class="flex flex-col items-center justify-center py-16 px-4">
                        <div class="w-16 h-16 rounded-2xl flex items-center justify-center mb-4"
                             style="background:{{ $dm ? 'rgba(124,58,237,0.1)' : 'rgba(124,58,237,0.06)' }}">
                            @include("shared.icons.shopping-cart")
                        </div>
                        <p class="text-sm mb-3" style="color:{{ $dm ? 'rgba(255,255,255,0.4)' : '#9ca3af' }}">{{ __('store.basket.empty') }}</p>
                        <a href="{{ route('front.store.index') }}"
                           class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-semibold text-white transition-all duration-200 hover:-translate-y-0.5"
                           style="background:linear-gradient(135deg,#7c3aed,#c026d3);box-shadow:0 4px 14px rgba(124,58,237,0.3)">
                            {{ __('store.basket.continue') }}
                        </a>
                    </div>
                @endif

                @foreach($basket->items()->get() as $row)
                    @php($pricing = $row->product->getPriceByCurrency($row->currency, $row->billing))
                    <div style="padding:16px 24px;border-bottom:1px solid {{ $dm ? 'rgba(255,255,255,0.04)' : '#f9fafb' }};display:grid;grid-template-columns:1fr 120px 120px 100px;gap:12px;align-items:center">

                        {{-- Product name + actions --}}
                        <div>
                            <div class="flex items-center gap-2">
                                <form method="POST" action="{{ route('front.store.basket.remove', ['product' => $row->product]) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" title="{{ __('store.basket.remove') }}"
                                            class="w-7 h-7 rounded-lg flex items-center justify-center transition-colors"
                                            style="{{ $dm ? 'background:rgba(239,68,68,0.12);color:#f87171' : 'background:rgba(239,68,68,0.07);color:#dc2626' }}">
                                        <svg class="w-3.5 h-3.5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                                    </button>
                                </form>
                                <a href="{{ $row->product->data_url() }}" title="{{ __('store.config.title') }}"
                                   class="w-7 h-7 rounded-lg flex items-center justify-center transition-colors"
                                   style="{{ $dm ? 'background:rgba(255,255,255,0.05);color:rgba(255,255,255,0.5)' : 'background:#f5f0ff;color:#7c3aed' }}">
                                    @include('shared/icons/edit')
                                </a>
                                <span style="font-size:14px;font-weight:600;color:{{ $dm ? '#fff' : '#111827' }}">{{ $row->product->trans('name') }}</span>
                                @if ($row->primary() != null)
                                    <span style="font-size:12px;color:#7c3aed">{{ $row->primary() }}</span>
                                @endif
                            </div>
                            @if (!empty($row->optionsFormattedName()))
                                <div style="font-size:12px;margin-top:4px;color:{{ $dm ? 'rgba(255,255,255,0.35)' : '#9ca3af' }}">
                                    @foreach ($row->optionsFormattedName(false) as $name)
                                        {{ $name }}<br/>
                                    @endforeach
                                </div>
                            @endif
                        </div>

                        {{-- Price --}}
                        <div style="font-size:13px;color:{{ $dm ? 'rgba(255,255,255,0.55)' : '#6b7280' }}">
                            {{ formatted_price($pricing->firstPayment(), $pricing->currency) }}
                        </div>

                        {{-- Quantity --}}
                        <div>
                            @if ($row->canChangeQuantity())
                                <form class="flex items-center gap-1" action="{{ route('front.store.basket.quantity', ['product' => $row->product]) }}" method="POST">
                                    @csrf
                                    <button class="w-7 h-7 rounded-lg flex items-center justify-center border transition-colors text-sm font-bold"
                                            style="{{ $dm ? 'border-color:rgba(255,255,255,0.1);color:rgba(255,255,255,0.5)' : 'border-color:#e5e7eb;color:#6b7280' }}"
                                            name="minus">−</button>
                                    <span class="text-center w-8 text-sm font-semibold" style="color:{{ $dm ? '#fff' : '#111827' }}">{{ $row->quantity }}</span>
                                    <button class="w-7 h-7 rounded-lg flex items-center justify-center border transition-colors text-sm font-bold"
                                            style="{{ $dm ? 'border-color:rgba(255,255,255,0.1);color:rgba(255,255,255,0.5)' : 'border-color:#e5e7eb;color:#6b7280' }}"
                                            name="plus">+</button>
                                </form>
                            @else
                                <span class="text-sm" style="color:{{ $dm ? 'rgba(255,255,255,0.55)' : '#6b7280' }}">{{ $row->quantity }}</span>
                            @endif
                        </div>

                        {{-- Row total --}}
                        <div style="text-align:right;font-size:14px;font-weight:700;color:{{ $dm ? '#e9d5ff' : '#6d28d9' }}">
                            {{ formatted_price($row->total(), $row->currency) }}
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Coupon --}}
            <div class="rounded-2xl p-6"
                 style="{{ $dm ? 'background:rgba(255,255,255,0.03);border:1px solid rgba(255,255,255,0.07)' : 'background:#fff;border:1px solid rgba(124,58,237,0.1);box-shadow:0 4px 24px rgba(124,58,237,0.06)' }}">
                <h2 class="text-sm font-bold uppercase tracking-widest mb-4"
                    style="color:{{ $dm ? '#c4b5fd' : '#7c3aed' }}">{{ __('coupon.add_coupon_title') }}</h2>
                <form method="POST" action="{{ route('front.store.basket.coupon') }}">
                    @csrf
                    @if ($basket->coupon)
                        @method('DELETE')
                    @endif
                    <div class="flex gap-3">
                        <div class="flex-1">
                            @include('shared/input', ['name' => 'coupon', 'attributes' => ['placeholder' => __('coupon.coupon_placeholder')], 'value' => old('coupon', $basket->coupon ? $basket->coupon->code : null)])
                        </div>
                        @if ($basket->coupon)
                            <button type="submit" class="btn-danger py-3 px-5 flex-shrink-0 rounded-xl text-sm font-semibold">
                                <i class="bi bi-x-circle mr-2"></i>{{ __('coupon.remove_coupon') }}
                            </button>
                        @else
                            <button type="submit" class="flex-shrink-0 py-3 px-5 rounded-xl text-sm font-semibold text-white transition-all duration-200 hover:-translate-y-0.5"
                                    style="background:linear-gradient(135deg,#7c3aed,#c026d3);box-shadow:0 4px 14px rgba(124,58,237,0.3)">
                                <i class="bi bi-ticket-perforated mr-2"></i>{{ __('coupon.add_coupon') }}
                            </button>
                        @endif
                    </div>
                </form>
            </div>
        </div>

        {{-- ===== RIGHT: Summary ===== --}}
        <div class="w-full md:w-72 flex-shrink-0">
            <div class="sticky top-6">
                <div class="rounded-2xl overflow-hidden"
                     style="{{ $dm ? 'background:rgba(255,255,255,0.03);border:1px solid rgba(255,255,255,0.08)' : 'background:#fff;box-shadow:0 8px 40px rgba(124,58,237,0.12);border:1px solid rgba(124,58,237,0.1)' }}">

                    {{-- Gradient header --}}
                    <div style="background:linear-gradient(135deg,#6d28d9 0%,#c026d3 100%);padding:24px">
                        <div style="font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:0.12em;color:rgba(255,255,255,0.5);margin-bottom:6px">
                            {{ __('store.basket.paytoday') }}
                        </div>
                        <span style="font-size:2.4rem;font-weight:900;color:#fff;line-height:1" id="total">{{ formatted_price($basket->total(), $basket->currency()) }}</span>
                    </div>

                    {{-- Items list --}}
                    <div style="padding:16px 20px">
                        <div class="flex justify-between items-center mb-3">
                            <span style="font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;color:{{ $dm ? 'rgba(255,255,255,0.3)' : '#9ca3af' }}">{{ __('store.config.summary') }}</span>
                            <button type="button"
                                    class="hs-collapse-toggle inline-flex items-center text-xs font-medium transition-colors"
                                    style="color:{{ $dm ? 'rgba(196,181,253,0.7)' : '#7c3aed' }}"
                                    id="checkout-collapse"
                                    data-hs-collapse="#hs-checkout-collapse">
                                <svg class="hs-collapse-open:rotate-180 w-4 h-4 transition-transform" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m6 9 6 6 6-6"/></svg>
                            </button>
                        </div>

                        @foreach($basket->items as $row)
                            @php($pricing = $row->product->getPriceByCurrency($row->currency, $row->billing))
                            <div class="flex justify-between mb-2 text-sm">
                                <span style="color:{{ $dm ? 'rgba(255,255,255,0.55)' : '#6b7280' }}">{{ $row->product->trans('name') }}</span>
                                <span style="font-weight:600;color:{{ $dm ? '#fff' : '#111827' }}">{{ formatted_price($row->subtotalWithoutCoupon(), $row->currency) }}</span>
                            </div>
                            @if (!empty($row->getOptions()))
                                @foreach ($row->getOptions() as $option)
                                    <div class="flex justify-between mb-2 text-xs">
                                        <span style="color:{{ $dm ? 'rgba(255,255,255,0.35)' : '#9ca3af' }}">{{ $option->formattedName() }}</span>
                                        <span style="color:{{ $dm ? 'rgba(255,255,255,0.55)' : '#6b7280' }}">{{ formatted_price($option->subtotal($row->currency, $row->billing), $row->currency) }}</span>
                                    </div>
                                @endforeach
                            @endif
                        @endforeach

                        @if ($basket->coupon)
                            <div class="flex justify-between mb-2 text-sm hs-collapse-open:hidden">
                                <span style="color:{{ $dm ? 'rgba(255,255,255,0.4)' : '#9ca3af' }}">{{ __('coupon.coupon') }}</span>
                                <span id="coupon" style="color:#7c3aed;font-weight:600">{{ $basket->coupon->code }}</span>
                            </div>
                        @endif

                        {{-- Collapsible detail --}}
                        <div id="hs-checkout-collapse" class="hs-collapse w-full overflow-hidden transition-[height] duration-300" aria-labelledby="hs-show-hide-collapse">
                            <div style="height:1px;background:{{ $dm ? 'rgba(255,255,255,0.06)' : '#f3f4f6' }};margin:8px 0"></div>
                            @if ($basket->coupon)
                                <div style="height:1px;background:{{ $dm ? 'rgba(255,255,255,0.06)' : '#f3f4f6' }};margin:8px 0"></div>
                                @if ($basket->discount(\App\Models\Store\Basket\BasketRow::PRICE))
                                    <div class="flex justify-between mb-2 text-sm">
                                        <span style="color:{{ $dm ? 'rgba(255,255,255,0.4)' : '#9ca3af' }}">{{ __('coupon.discount_price') }}</span>
                                        <span id="discount" style="color:#7c3aed;font-weight:600">-{{ formatted_price($basket->discount(\App\Models\Store\Basket\BasketRow::PRICE), $basket->currency()) }}</span>
                                    </div>
                                @endif
                                @if ($basket->coupon->free_setup == 0 && $basket->discount(\App\Models\Store\Basket\BasketRow::SETUP_FEES) > 0)
                                    <div class="flex justify-between mb-2 text-sm">
                                        <span style="color:{{ $dm ? 'rgba(255,255,255,0.4)' : '#9ca3af' }}">{{ __('coupon.discount_setup') }}</span>
                                        <span id="discount" style="color:#7c3aed;font-weight:600">-{{ formatted_price($basket->discount(\App\Models\Store\Basket\BasketRow::SETUP_FEES), $basket->currency()) }}</span>
                                    </div>
                                @endif
                                @if ($basket->coupon->free_setup == 1 && $basket->discount(\App\Models\Store\Basket\BasketRow::SETUP_FEES) > 0)
                                    <div class="flex justify-between mb-2 text-sm">
                                        <span style="color:{{ $dm ? 'rgba(255,255,255,0.4)' : '#9ca3af' }}">{{ __('coupon.free_setup') }}</span>
                                        <span id="free_setup" style="color:#7c3aed;font-weight:600">-{{ formatted_price($basket->discount(\App\Models\Store\Basket\BasketRow::SETUP_FEES), $basket->currency()) }}</span>
                                    </div>
                                @endif
                                <div class="flex justify-between mb-2 text-sm">
                                    <span style="color:{{ $dm ? 'rgba(255,255,255,0.4)' : '#9ca3af' }}">{{ __('coupon.subtotal_with_coupon') }}</span>
                                    <span id="subtotal" style="font-weight:600;color:{{ $dm ? '#fff' : '#111827' }}">{{ formatted_price($basket->subtotal(), $basket->currency()) }}</span>
                                </div>
                            @endif
                        </div>

                        <div style="height:1px;background:{{ $dm ? 'rgba(255,255,255,0.06)' : '#f3f4f6' }};margin:8px 0"></div>

                        <div class="flex justify-between mb-2 text-sm">
                            <span style="color:{{ $dm ? 'rgba(255,255,255,0.4)' : '#9ca3af' }}">{{ __('store.config.recurring_payment') }}</span>
                            <span id="recurring" style="font-weight:600;color:{{ $dm ? '#e9d5ff' : '#6d28d9' }}">{{ formatted_price($basket->recurringPayment(), $basket->currency()) }}</span>
                        </div>
                        <div class="flex justify-between mb-2 text-sm">
                            <span style="color:{{ $dm ? 'rgba(255,255,255,0.4)' : '#9ca3af' }}">{{ __('store.config.onetime_payment') }}</span>
                            <span id="onetime" style="font-weight:600;color:{{ $dm ? '#e9d5ff' : '#6d28d9' }}">{{ formatted_price($basket->onetimePayment(), $basket->currency()) }}</span>
                        </div>
                        <div class="flex justify-between mb-2 text-sm">
                            <span style="color:{{ $dm ? 'rgba(255,255,255,0.4)' : '#9ca3af' }}">{{ __('store.fees') }}</span>
                            <span id="fees" style="color:{{ $dm ? 'rgba(255,255,255,0.5)' : '#6b7280' }}">{{ formatted_price($basket->setup(), $basket->currency()) }}</span>
                        </div>
                        <div class="flex justify-between mb-2 text-sm">
                            <span style="color:{{ $dm ? 'rgba(255,255,255,0.4)' : '#9ca3af' }}">{{ __('store.vat') }}</span>
                            <span id="taxes" style="color:{{ $dm ? 'rgba(255,255,255,0.5)' : '#6b7280' }}">{{ formatted_price($basket->tax(), $basket->currency()) }}</span>
                        </div>
                        <div class="flex justify-between mb-1 text-sm">
                            <span style="color:{{ $dm ? 'rgba(255,255,255,0.4)' : '#9ca3af' }}">{{ $basket->coupon ? __('coupon.subtotal_without_coupon') : __('store.subtotal') }}</span>
                            <span id="subtotal" style="color:{{ $dm ? 'rgba(255,255,255,0.5)' : '#6b7280' }}">{{ formatted_price($basket->subtotalWithoutCoupon(), $basket->currency()) }}</span>
                        </div>
                    </div>

                    {{-- Checkout button --}}
                    <div style="padding:0 20px 20px">
                        <a href="{{ route('front.store.basket.checkout') }}"
                           class="w-full py-3.5 rounded-xl text-sm font-bold text-white flex items-center justify-center gap-2 transition-all duration-200 hover:-translate-y-0.5"
                           style="background:linear-gradient(135deg,#7c3aed,#c026d3);box-shadow:0 6px 24px rgba(124,58,237,0.35)">
                            {{ __('store.basket.finish') }}
                            <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>

    </div>
    {!! render_theme_sections() !!}
</div>

@endsection
