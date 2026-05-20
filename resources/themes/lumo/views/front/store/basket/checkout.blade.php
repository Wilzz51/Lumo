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
@section('title', __('store.checkout.title'))
@section('styles')
<style>
    .gateway-label {
        cursor: pointer;
        border-radius: 16px;
        border: 2px solid #e5e7eb;
        background: #f9fafb;
        padding: 16px;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 10px;
        transition: border-color 0.18s ease, background 0.18s ease, box-shadow 0.18s ease;
    }
    .dark .gateway-label {
        background: rgba(255,255,255,0.04);
        border-color: rgba(255,255,255,0.08);
    }
    .gateway-label.gateway-selected,
    .gateway-label:has(input:checked) {
        border-color: #7c3aed;
        background: rgba(124,58,237,0.06);
        box-shadow: 0 0 0 3px rgba(124,58,237,0.12);
    }
    .dark .gateway-label.gateway-selected,
    .dark .gateway-label:has(input:checked) {
        background: rgba(124,58,237,0.18);
    }
</style>
@endsection
@section('scripts')
    <script src="{{ Vite::asset('resources/themes/default/js/checkout.js') }}" type="module" defer></script>
@endsection
@section('content')

@php($dm = is_darkmode())

{{-- Page header --}}
<div style="border-bottom:1px solid {{ $dm ? 'rgba(255,255,255,0.07)' : 'rgba(124,58,237,0.1)' }};{{ $dm ? 'background:linear-gradient(135deg,#0f0527,#1a0a3e,#130630)' : 'background:linear-gradient(135deg,#faf7ff,#f5f0ff,#fff)' }}">
    <div class="{{ theme_metadata('layout_classes', 'max-w-[85rem] px-4 py-5 sm:px-6 lg:px-8 mx-auto') }}">
        <div class="flex items-center gap-4">
            <div class="flex-shrink-0 w-11 h-11 rounded-xl flex items-center justify-center"
                 style="background:linear-gradient(135deg,#7c3aed,#c026d3)">
                <svg class="w-5 h-5 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
            </div>
            <div>
                <div style="font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:0.1em;margin-bottom:2px;color:{{ $dm ? 'rgba(196,181,253,0.5)' : '#9ca3af' }}">{{ __('store.store') }}</div>
                <h1 style="font-size:1.15rem;font-weight:800;color:{{ $dm ? '#fff' : '#111827' }}">{{ __('store.checkout.title') }}</h1>
            </div>
        </div>
    </div>
</div>

<div class="{{ theme_metadata('layout_classes', 'max-w-[85rem] px-4 py-10 sm:px-6 lg:px-8 lg:py-12 mx-auto') }}">
    @include("shared.alerts")

    <div class="flex flex-col md:flex-row gap-6">

        {{-- ===== LEFT: Form ===== --}}
        <div class="min-w-0 flex-1 space-y-5">

            {{-- Auth / Identity card --}}
            <div class="rounded-2xl p-6" id="checkout-form"
                 style="{{ $dm ? 'background:rgba(255,255,255,0.03);border:1px solid rgba(255,255,255,0.07)' : 'background:#fff;border:1px solid rgba(124,58,237,0.1);box-shadow:0 4px 24px rgba(124,58,237,0.06)' }}">

                @if (Auth::check())
                    <div class="flex items-center gap-3 mb-4 pb-4"
                         style="border-bottom:1px solid {{ $dm ? 'rgba(255,255,255,0.06)' : '#f3f4f6' }}">
                        <div class="w-9 h-9 rounded-xl flex items-center justify-center font-bold text-white text-sm"
                             style="background:linear-gradient(135deg,#7c3aed,#c026d3)">
                            {{ strtoupper(Auth::user()->firstname[0] . Auth::user()->lastname[0]) }}
                        </div>
                        <div>
                            <div style="font-size:12px;color:{{ $dm ? 'rgba(255,255,255,0.35)' : '#9ca3af' }}">{{ __('auth.signed_in_as') }}</div>
                            <div style="font-size:13px;font-weight:600;color:{{ $dm ? '#fff' : '#111827' }}">{{ Auth::user()->FullName }} ({{ Auth::user()->email }})</div>
                        </div>
                    </div>

                    @if (!Auth::user()->hasVerifiedEmail() && setting('checkout.customermustbeconfirmed', false))
                        <div class="rounded-xl p-4 mb-4 flex items-start gap-3 text-sm"
                             style="{{ $dm ? 'background:rgba(245,158,11,0.1);border:1px solid rgba(245,158,11,0.2);color:rgba(255,255,255,0.6)' : 'background:#fffbeb;border:1px solid #fde68a;color:#92400e' }}">
                            <svg class="w-4 h-4 flex-shrink-0 mt-0.5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M12 16v-4"/><path d="M12 8h.01"/></svg>
                            {{ __('store.checkout.email_must_be_verified') }}
                        </div>
                    @endif
                @else
                    <h2 class="text-sm font-bold uppercase tracking-widest mb-4"
                        style="color:{{ $dm ? '#c4b5fd' : '#7c3aed' }}">{{ __('auth.login.btn') }} / {{ __('auth.register.btn') }}</h2>
                    <div class="flex gap-3 mb-4">
                        <button type="button"
                                class="hs-collapse-toggle flex-1 py-2.5 px-4 rounded-xl text-sm font-semibold text-white transition-all duration-200"
                                style="background:linear-gradient(135deg,#7c3aed,#c026d3);box-shadow:0 4px 14px rgba(124,58,237,0.3)"
                                id="login-collapse-collapse" data-hs-collapse="#login-collapse-heading">
                            {{ __('auth.login.btn') }}
                        </button>
                        <button type="button"
                                class="hs-collapse-toggle flex-1 py-2.5 px-4 rounded-xl text-sm font-semibold transition-all duration-200"
                                style="{{ $dm ? 'background:rgba(124,58,237,0.15);border:1px solid rgba(124,58,237,0.3);color:#c4b5fd' : 'background:rgba(124,58,237,0.06);border:1px solid rgba(124,58,237,0.15);color:#6d28d9' }}"
                                id="register-collapse-collapse" data-hs-collapse="#register-collapse-heading">
                            {{ __('auth.register.btn') }}
                        </button>
                    </div>

                    <div id="login-collapse-heading" class="hs-collapse hidden w-full overflow-hidden transition-[height] duration-300" aria-labelledby="login-collapse">
                        <div class="pt-2">
                            @if ($providers->isNotEmpty())
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mb-4">
                                    @foreach ($providers as $provider)
                                        <a href="{{ route('socialauth.authorize', $provider->name) }}"
                                           class="w-full py-2.5 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-medium rounded-xl border transition-colors"
                                           style="{{ $dm ? 'background:rgba(255,255,255,0.04);border-color:rgba(255,255,255,0.1);color:#fff' : 'background:#fff;border-color:#e5e7eb;color:#374151' }}">
                                            <img src="{{ $provider->provider()->logo() }}" alt="{{ $provider->provider()->title() }}" class="w-5 h-5" />
                                            {{ __('socialauth::messages.login_with', ['provider' => $provider->provider()->title()]) }}
                                        </a>
                                    @endforeach
                                </div>
                                <div class="py-3 flex items-center text-xs text-gray-400 uppercase before:flex-[1_1_0%] before:border-t before:border-gray-200 before:me-6 after:flex-[1_1_0%] after:border-t after:border-gray-200 after:ms-6 dark:text-gray-500 dark:before:border-gray-600 dark:after:border-gray-600">{{ trans("global.or") }}</div>
                            @endif
                            <form method="POST" action="{{ route('login') }}">
                                @include('shared.auth.login', ['redirect' => route('front.store.basket.checkout') .'#login', 'captcha' => true])
                            </form>
                        </div>
                    </div>

                    <div id="register-collapse-heading" class="hs-collapse hidden w-full overflow-hidden transition-[height] duration-300" aria-labelledby="register-collapse">
                        <div class="pt-2">
                            @if ($providers->isNotEmpty())
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mb-4">
                                    @foreach ($providers as $provider)
                                        <a href="{{ route('socialauth.authorize', $provider->name) }}"
                                           class="w-full py-2.5 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-medium rounded-xl border transition-colors"
                                           style="{{ $dm ? 'background:rgba(255,255,255,0.04);border-color:rgba(255,255,255,0.1);color:#fff' : 'background:#fff;border-color:#e5e7eb;color:#374151' }}">
                                            <img src="{{ $provider->provider()->logo() }}" alt="{{ $provider->provider()->title() }}" class="w-5 h-5" />
                                            {{ __('socialauth::messages.register_with', ['provider' => $provider->provider()->title()]) }}
                                        </a>
                                    @endforeach
                                </div>
                                <div class="py-3 flex items-center text-xs text-gray-400 uppercase before:flex-[1_1_0%] before:border-t before:border-gray-200 before:me-6 after:flex-[1_1_0%] after:border-t after:border-gray-200 after:ms-6 dark:text-gray-500 dark:before:border-gray-600 dark:after:border-gray-600">{{ trans("global.or") }}</div>
                            @endif
                            @include('shared.auth.register', ['countries' => $countries, 'redirect' => route('front.store.basket.checkout') . '#register'])
                        </div>
                    </div>
                @endif

                {{-- Billing form --}}
                @if (Auth::check())
                    <form method="POST" action="{{ route('front.store.basket.checkout') }}" id="checkoutForm">
                        @csrf

                        <div class="mt-2 grid grid-cols-1 gap-x-6 gap-y-4 sm:grid-cols-6">
                            <div class="sm:col-span-2">
                                @include("shared.input", ["name" => "firstname", "label" => __('global.firstname'), "value" => auth('web')->user()->firstname ?? old("firstname")])
                            </div>
                            <div class="sm:col-span-2">
                                @include("shared.input", ["name" => "lastname", "label" => __('global.lastname'), "value" => auth('web')->user()->lastname ?? old("lastname")])
                            </div>
                            <div class="sm:col-span-2">
                                @include("shared.input", ["name" => "company_name", "label" => __('global.company_name'), "value" => auth('web')->user()->company_name ?? old("company_name")])
                            </div>
                            <div class="sm:col-span-3">
                                @include("shared.input", ["name" => "address", "label" => __('global.address'), "value" => auth('web')->user()->address ?? old("address")])
                            </div>
                            <div class="sm:col-span-2">
                                @include("shared.input", ["name" => "address2", "label" => __('global.address2'), "value" => auth('web')->user()->address2 ?? old("address2")])
                            </div>
                            <div class="sm:col-span-1">
                                @include("shared.input", ["name" => "zipcode", "label" => __('global.zip'), "value" => auth('web')->user()->zipcode ?? old("zipcode")])
                            </div>
                            <div class="sm:col-span-3">
                                @include("shared.input", ["name" => "email", "label" => __('global.email'), "type" => "email", "value" => auth('web')->user()->email ?? old("email"), "disabled" => true])
                            </div>
                            <div class="sm:col-span-3">
                                @include("shared.input", ["name" => "phone", "label" => __('global.phone'), "value" => auth('web')->user()->phone ?? old("phone")])
                            </div>
                            <div class="sm:col-span-2">
                                @include("shared.select", ["name" => "country", "label" => __('global.country'), "options" => $countries, "value" => auth('web')->user()->country ?? old("country")])
                            </div>
                            <div class="sm:col-span-2">
                                @include("shared.input", ["name" => "city", "label" => __('global.city'), "value" => auth('web')->user()->city ?? old("city")])
                            </div>
                            <div class="sm:col-span-2">
                                @include("shared.input", ["name" => "region", "label" => __('global.region'), "value" => auth('web')->user()->region ?? old("region")])
                            </div>
                            <div class="sm:col-span-6">
                                @include("shared/textarea", ["name" => "billing_details", "label" => __('global.billing_details'), "value" => auth('web')->user()->billing_details ?? old("billing_details"), "help" => __('global.billing_details_help')])
                            </div>
                        </div>

                        @if (setting('checkout.toslink'))
                            <div class="flex gap-x-4 mt-4">
                                <input id="accept_tos" name="accept_tos" type="checkbox"
                                       class="h-4 w-4 mt-0.5 rounded border-gray-300 @error('accept_tos') border-red-300 @enderror text-violet-600 focus:ring-violet-500">
                                <label for="accept_tos" class="text-sm @error('accept_tos') text-red-500 @else dark:text-gray-300 @enderror">
                                    {{ __('auth.register.accept') }}
                                    <a href="{{ setting('checkout.toslink') }}" class="text-violet-600 hover:text-violet-700 underline">{{ __('store.checkout.terms') }}</a>
                                </label>
                            </div>
                        @endif

                        @include('shared/captcha', ['center' => false])

                        @if ($basket->total() != 0)
                            <div class="mt-6">
                                <h2 class="text-sm font-bold uppercase tracking-widest mb-4"
                                    style="color:{{ $dm ? '#c4b5fd' : '#7c3aed' }}">{{ __('store.checkout.choose_payment') }}</h2>

                                @if (auth('web')->user()->paymentMethods()->isNotEmpty())
                                    <div class="mb-4">
                                        <h3 class="text-sm font-semibold mb-1 dark:text-white">{{ __('store.checkout.choose_payment_method') }}</h3>
                                        <p class="text-xs mb-2" style="color:{{ $dm ? 'rgba(255,255,255,0.4)' : '#9ca3af' }}">{{ __('store.checkout.choose_payment_method_description') }}</p>
                                        @include('shared/select', [
                                            'name'    => 'paymentmethod',
                                            'options' => auth('web')->user()->getPaymentMethodsArray()->merge(['none' => __('store.checkout.not_use_payment_method')]),
                                            'value'   => 'none',
                                        ])
                                    </div>
                                @endif

                                <div class="grid grid-cols-2 sm:grid-cols-3 gap-3 gateway-container">
                                    @foreach ($gateways as $gateway)
                                        <label for="gateway-{{ $gateway->uuid }}"
                                               class="gateway-label {{ $loop->last ? 'gateway-selected' : '' }}">
                                            <input type="radio"
                                                   name="gateway"
                                                   value="{{ $gateway->uuid }}"
                                                   {{ $loop->last ? 'checked' : '' }}
                                                   class="gateway-input sr-only"
                                                   id="gateway-{{ $gateway->uuid }}">
                                            <img class="mx-auto rounded-lg" src="{{ $gateway->paymentType()->image() }}" alt="{{ $gateway->name }}" height="64" width="64">
                                            <span class="text-sm font-semibold text-center dark:text-white" style="color:{{ $dm ? '#fff' : '#111827' }}">{{ $gateway->getGatewayName() }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                    </form>
                @endif
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

                    {{-- Items --}}
                    <div style="padding:16px 20px">
                        <div class="flex justify-between items-center mb-3">
                            <span style="font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;color:{{ $dm ? 'rgba(255,255,255,0.3)' : '#9ca3af' }}">{{ __('store.config.summary') }}</span>
                            <button type="button"
                                    class="hs-collapse-toggle inline-flex items-center text-xs font-medium"
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

                                <div class="flex justify-between mb-2 text-sm">
                                    <span style="color:{{ $dm ? 'rgba(255,255,255,0.4)' : '#9ca3af' }}">{{ __('store.config.recurring_payment') }}</span>
                                    <span id="recurring" style="font-weight:600;color:{{ $dm ? '#e9d5ff' : '#6d28d9' }}">{{ formatted_price($basket->recurringPayment(), $basket->currency()) }}</span>
                                </div>
                                <div class="flex justify-between mb-2 text-sm">
                                    <span style="color:{{ $dm ? 'rgba(255,255,255,0.4)' : '#9ca3af' }}">{{ __('store.fees') }}</span>
                                    <span id="fees" style="color:{{ $dm ? 'rgba(255,255,255,0.5)' : '#6b7280' }}">{{ formatted_price($basket->setup(), $basket->currency()) }}</span>
                                </div>
                                @if ($basket->coupon->free_setup == 1 && $basket->discount(\App\Models\Store\Basket\BasketRow::SETUP_FEES) > 0)
                                    <div class="flex justify-between mb-2 text-sm">
                                        <span style="color:{{ $dm ? 'rgba(255,255,255,0.4)' : '#9ca3af' }}">{{ __('coupon.free_setup') }}</span>
                                        <span id="free_setup" style="color:#7c3aed;font-weight:600">-{{ formatted_price($basket->discount(\App\Models\Store\Basket\BasketRow::SETUP_FEES), $basket->currency()) }}</span>
                                    </div>
                                @endif
                                <div class="flex justify-between mb-2 text-sm">
                                    <span style="color:{{ $dm ? 'rgba(255,255,255,0.4)' : '#9ca3af' }}">{{ $basket->coupon ? __('coupon.subtotal_without_coupon') : __('store.subtotal') }}</span>
                                    <span id="subtotal" style="color:{{ $dm ? 'rgba(255,255,255,0.5)' : '#6b7280' }}">{{ formatted_price($basket->subtotalWithoutCoupon(), $basket->currency()) }}</span>
                                </div>
                                <div class="flex justify-between mb-2 text-sm">
                                    <span style="color:{{ $dm ? 'rgba(255,255,255,0.4)' : '#9ca3af' }}">{{ __('store.vat') }}</span>
                                    <span id="taxes" style="color:{{ $dm ? 'rgba(255,255,255,0.5)' : '#6b7280' }}">{{ formatted_price($basket->tax(), $basket->currency()) }}</span>
                                </div>
                            @endif

                            <div style="height:1px;background:{{ $dm ? 'rgba(255,255,255,0.06)' : '#f3f4f6' }};margin:8px 0"></div>

                            @if ($basket->coupon)
                                <div class="flex justify-between mb-2 text-sm">
                                    <span style="color:{{ $dm ? 'rgba(255,255,255,0.4)' : '#9ca3af' }}">{{ __('coupon.subtotal_with_coupon') }}</span>
                                    <span id="subtotal" style="font-weight:600;color:{{ $dm ? '#fff' : '#111827' }}">{{ formatted_price($basket->subtotal(), $basket->currency()) }}</span>
                                </div>
                            @endif

                            <div class="flex justify-between mb-2 text-sm">
                                <span style="color:{{ $dm ? 'rgba(255,255,255,0.4)' : '#9ca3af' }}">{{ __('store.config.recurring_payment') }}</span>
                                <span id="recurring" style="font-weight:600;color:{{ $dm ? '#e9d5ff' : '#6d28d9' }}">{{ formatted_price($basket->recurringPayment(), $basket->currency()) }}</span>
                            </div>
                            <div class="flex justify-between mb-2 text-sm">
                                <span style="color:{{ $dm ? 'rgba(255,255,255,0.4)' : '#9ca3af' }}">{{ __('store.vat') }}</span>
                                <span id="taxes" style="color:{{ $dm ? 'rgba(255,255,255,0.5)' : '#6b7280' }}">{{ formatted_price($basket->tax(), $basket->currency()) }}</span>
                            </div>
                            <div class="flex justify-between mb-2 text-sm">
                                <span style="color:{{ $dm ? 'rgba(255,255,255,0.4)' : '#9ca3af' }}">{{ __('store.fees') }}</span>
                                <span id="fees" style="color:{{ $dm ? 'rgba(255,255,255,0.5)' : '#6b7280' }}">{{ formatted_price($basket->setup(), $basket->currency()) }}</span>
                            </div>
                        </div>{{-- /hs-checkout-collapse --}}

                    </div>{{-- /padding panel --}}

                    {{-- Submit --}}
                    <div style="padding:0 20px 20px">
                        <button type="submit"
                                form="checkoutForm"
                                @guest disabled @endguest
                                id="btnCheckout"
                                class="w-full py-3.5 rounded-xl text-sm font-bold text-white flex items-center justify-center gap-2 transition-all duration-200 hover:-translate-y-0.5 disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none"
                                style="background:linear-gradient(135deg,#7c3aed,#c026d3);box-shadow:0 6px 24px rgba(124,58,237,0.35)">
                            {{ __('store.checkout.title') }}
                            <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </div>
    {!! render_theme_sections() !!}
</div>

@endsection
