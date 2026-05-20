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
@section('title', __('client.invoices.details'))
@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const paymentMethodSelect = document.querySelector('select[name="paymentmethod"]');
            const paymentMethodBtn1 = document.querySelector('.paymentmethod-btn1');
            const paymentMethodBtn2 = document.querySelector('.paymentmethod-btn2');
            const onPaymentMethodChange = () => {
                if (paymentMethodSelect.value === 'none') {
                    paymentMethodBtn1.classList.add('hidden');
                    paymentMethodBtn2.classList.remove('hidden');
                } else {
                    paymentMethodBtn1.classList.remove('hidden');
                    paymentMethodBtn2.classList.add('hidden');
                }
            };
            if (paymentMethodSelect) {
                paymentMethodSelect.addEventListener('change', onPaymentMethodChange);
                onPaymentMethodChange();
            }
        });
    </script>
@endsection
@section('content')

    {{-- Banner --}}
    <div class="relative overflow-hidden bg-gradient-to-br from-violet-700 via-violet-600 to-fuchsia-700 py-8 print:hidden">
        <div class="absolute top-0 right-0 w-72 h-72 bg-white/5 rounded-full -translate-y-1/2 translate-x-1/4 pointer-events-none"></div>
        <div class="absolute inset-0 bg-[linear-gradient(to_right,rgba(255,255,255,0.04)_1px,transparent_1px),linear-gradient(to_bottom,rgba(255,255,255,0.04)_1px,transparent_1px)] bg-[size:32px_32px] pointer-events-none"></div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-between gap-4">
            <div>
                <p class="text-violet-200 text-xs font-medium uppercase tracking-widest mb-1">{{ __('client.invoices.details') }}</p>
                <h1 class="text-2xl font-bold text-white font-mono">{{ $invoice->identifier() }}</h1>
            </div>
            <x-badge-state state="{{ $invoice->status }}"></x-badge-state>
        </div>
    </div>

    <div class="max-w-[85rem] py-5 lg:py-7 mx-auto px-4 sm:px-6 lg:px-8">
        <div class="sm:w-11/12 lg:w-3/4 mx-auto">
            @include('shared/alerts')

            <div class="card">
                <div class="flex justify-between items-start">
                    <div>
                        <img class="h-12 w-auto mt-4" src="{{ setting('app_logo_text') }}" alt="{{ setting('app_name') }}">
                    </div>
                    <div class="text-end">
                        <h2 class="text-2xl md:text-3xl font-semibold text-gray-800 dark:text-gray-200">{{ __('global.invoice') }} #</h2>
                        <span class="mt-1 block text-gray-500 font-mono">{{ $invoice->identifier() }}</span>
                        <address class="mt-4 not-italic text-gray-800 dark:text-gray-200">
                            {!! nl2br(setting('app_address')) !!}
                        </address>
                    </div>
                </div>

                <div class="mt-8 grid sm:grid-cols-2 gap-3">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">{{ __('client.invoices.billto', ['name' => $address[0]]) }}</h3>
                        <address class="mt-2 not-italic text-gray-500">
                            @foreach ($address as $i => $line)
                                @if ($i == 0) @continue @endif
                                {{ $line }}<br/>
                            @endforeach
                        </address>
                    </div>
                    <div class="space-y-2">
                        <div class="grid grid-cols-2 sm:grid-cols-1 gap-3 sm:gap-2">
                            <dl class="grid sm:grid-cols-5 gap-x-3">
                                <dt class="col-span-3 font-semibold text-gray-800 dark:text-gray-200">{{ __('client.invoices.invoice_date') }}:</dt>
                                <dd class="col-span-2 text-gray-500">{{ $invoice->created_at->format('d/m/y H:i') }}</dd>
                            </dl>
                            <dl class="grid sm:grid-cols-5 gap-x-3">
                                <dt class="col-span-3 font-semibold text-gray-800 dark:text-gray-200">{{ __('client.invoices.due_date') }}:</dt>
                                <dd class="col-span-2 text-gray-500">{{ $invoice->due_date->format('d/m/y H:i') }}</dd>
                            </dl>
                            <dl class="grid sm:grid-cols-5 gap-x-3">
                                <dt class="col-span-3 font-semibold text-gray-800 dark:text-gray-200">{{ __('global.status') }}:</dt>
                                <dd class="col-span-2"><x-badge-state state="{{ $invoice->status }}"></x-badge-state></dd>
                            </dl>
                        </div>
                    </div>
                </div>

                {{-- Items table --}}
                <div class="mt-6">
                    <div class="border border-gray-200 dark:border-gray-700 rounded-xl overflow-hidden">
                        <div class="hidden sm:grid sm:grid-cols-6 bg-gray-50 dark:bg-gray-700/50 px-4 py-3">
                            <div class="sm:col-span-2 text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">{{ __('client.invoices.itemname') }}</div>
                            <div class="text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">{{ __('client.invoices.qty') }}</div>
                            <div class="text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">{{ __('store.unit_price') }}</div>
                            <div class="text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">{{ __('store.setup_price') }}</div>
                            <div class="text-end text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">{{ __('store.price') }}</div>
                        </div>
                        <div class="divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach ($invoice->items as $item)
                            <div class="grid grid-cols-1 sm:grid-cols-6 gap-2 px-4 py-3">
                                <div class="sm:col-span-2">
                                    <h5 class="sm:hidden text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400 mb-1">{{ __('client.invoices.itemname') }}</h5>
                                    <p class="font-medium text-gray-800 dark:text-gray-200">{{ $item->name }}</p>
                                    @if ($item->canDisplayDescription())
                                        <p class="text-sm text-gray-400">{!! nl2br($item->description) !!}</p>
                                    @endif
                                    @if ($item->getDiscount(false) != null)
                                        <p class="text-sm text-violet-500">{{ $item->getDiscountLabel() }}</p>
                                    @endif
                                </div>
                                <div>
                                    <h5 class="sm:hidden text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400 mb-1">{{ __('client.invoices.qty') }}</h5>
                                    <p class="text-gray-800 dark:text-gray-200">{{ $item->quantity }}</p>
                                </div>
                                <div>
                                    <h5 class="sm:hidden text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400 mb-1">{{ __('store.unit_price') }}</h5>
                                    <p class="text-gray-800 dark:text-gray-200">{{ formatted_price($item->unit_price_ht, $invoice->currency) }}</p>
                                    @if ($item->getDiscount() != null && $item->getDiscount(true)->sub_price != 0)
                                        <p class="text-sm text-gray-400">-{{ formatted_price($item->getDiscount()->sub_price, $invoice->currency) }}</p>
                                    @endif
                                </div>
                                <div>
                                    <h5 class="sm:hidden text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400 mb-1">{{ __('store.setup_price') }}</h5>
                                    <p class="text-gray-800 dark:text-gray-200">{{ formatted_price($item->unit_setup_ht, $invoice->currency) }}</p>
                                    @if ($item->getDiscount() != null && $item->getDiscount(true)->sub_setup != 0)
                                        <p class="text-sm text-gray-400">-{{ formatted_price($item->getDiscount()->sub_setup, $invoice->currency) }}</p>
                                    @endif
                                </div>
                                <div>
                                    <h5 class="sm:hidden text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400 mb-1">{{ __('store.price') }}</h5>
                                    <p class="text-gray-800 dark:text-gray-200 md:text-end">{{ formatted_price($item->price(), $invoice->currency) }}</p>
                                    @if ($item->getDiscount() != null && ($item->getDiscount(true)->sub_setup != 0 || $item->getDiscount()->sub_price != 0))
                                        <p class="text-sm text-gray-400 md:text-end">-{{ formatted_price($item->getDiscount()->sub_price + $item->getDiscount()->sub_setup, $invoice->currency) }}</p>
                                    @endif
                                </div>
                            </div>
                            @endforeach
                        </div>

                        {{-- Totals --}}
                        <div class="border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700/30 divide-y divide-gray-100 dark:divide-gray-700">
                            <div class="grid grid-cols-1 sm:grid-cols-6 px-4 py-2.5">
                                <div class="sm:col-span-5 hidden sm:flex justify-end">
                                    <p class="font-medium text-gray-700 dark:text-gray-300">{{ __('store.subtotal') }}</p>
                                </div>
                                <div>
                                    <h5 class="sm:hidden text-xs font-semibold uppercase text-gray-500 dark:text-gray-400 mb-1">{{ __('store.subtotal') }}</h5>
                                    <p class="text-gray-800 dark:text-gray-200 sm:text-end">{{ formatted_price($invoice->subtotal, $invoice->currency) }}</p>
                                </div>
                            </div>
                            @if ($invoice->balance > 0)
                            <div class="grid grid-cols-1 sm:grid-cols-6 px-4 py-2.5">
                                <div class="sm:col-span-5 hidden sm:flex justify-end">
                                    <p class="font-medium text-gray-700 dark:text-gray-300">{{ __('client.invoices.balance.title') }}</p>
                                </div>
                                <div>
                                    <h5 class="sm:hidden text-xs font-semibold uppercase text-gray-500 dark:text-gray-400 mb-1">{{ __('client.invoices.balance.title') }}</h5>
                                    <p class="text-gray-800 dark:text-gray-200 sm:text-end">{{ formatted_price($invoice->balance, $invoice->currency) }}</p>
                                </div>
                            </div>
                            @endif
                            <div class="grid grid-cols-1 sm:grid-cols-6 px-4 py-2.5">
                                <div class="sm:col-span-5 hidden sm:flex justify-end">
                                    <p class="font-medium text-gray-700 dark:text-gray-300">{{ __('store.vat') }}</p>
                                </div>
                                <div>
                                    <h5 class="sm:hidden text-xs font-semibold uppercase text-gray-500 dark:text-gray-400 mb-1">{{ __('store.vat') }}</h5>
                                    <p class="text-gray-800 dark:text-gray-200 sm:text-end">{{ formatted_price($invoice->tax, $invoice->currency) }}</p>
                                </div>
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-6 px-4 py-3">
                                <div class="sm:col-span-5 hidden sm:flex justify-end">
                                    <p class="font-bold text-gray-900 dark:text-white text-base">{{ __('store.total') }}</p>
                                </div>
                                <div>
                                    <h5 class="sm:hidden text-xs font-semibold uppercase text-gray-500 dark:text-gray-400 mb-1">{{ __('store.total') }}</h5>
                                    <p class="font-bold text-gray-900 dark:text-white sm:text-end text-base">{{ formatted_price($invoice->total, $invoice->currency) }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Payment info table (if paid) --}}
                @if ($invoice->external_id != null)
                <div class="mt-4 border border-gray-200 dark:border-gray-700 rounded-xl overflow-hidden">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700/50">
                        <tr>
                            <th class="px-6 py-3 text-start text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">{{ __('client.invoices.paymethod') }}</th>
                            <th class="px-6 py-3 text-start text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">{{ __('client.invoices.paid_date') }}</th>
                            <th class="px-6 py-3 text-start text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">{{ __('admin.invoices.show.external_id') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr class="bg-white dark:bg-gray-800">
                            <td class="px-6 py-4 text-sm text-gray-800 dark:text-gray-200">{{ $invoice->gateway != null ? $invoice->gateway->name : $invoice->paymethod }}</td>
                            <td class="px-6 py-4 text-sm text-gray-800 dark:text-gray-200">{{ $invoice->paid_at ? $invoice->paid_at->format('d/m/y H:i') : 'N/A' }}</td>
                            <td class="px-6 py-4 text-sm text-gray-800 dark:text-gray-200">{{ $invoice->external_id }}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                @endif

                {{-- Payment actions --}}
                @if ($invoice->canPay())
                <div class="mt-6 flex sm:justify-end">
                    <div class="w-full max-w-md space-y-3">
                        @if ($invoice->total == 0)
                            <a class="paymentmethod-btn2 btn-primary inline-flex items-center gap-x-2 w-full justify-center" href="{{ route('front.invoices.pay', ['invoice' => $invoice, 'gateway' => 'none']) }}">
                                <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="M7 15h0M2 9.5h20"/></svg>
                                {{ __('client.invoices.pay') }}
                            </a>
                        @else
                            @if (auth('web')->user()->balance > 0 && setting('allow_add_balance_to_invoices'))
                                <form method="POST" action="{{ route('front.invoices.balance', ['invoice' => $invoice]) }}" class="p-4 bg-gray-50 dark:bg-gray-700/30 rounded-xl border border-gray-200 dark:border-gray-700">
                                    <p class="font-semibold mb-2 text-gray-800 dark:text-white text-sm">{{ __('client.invoices.pay_with_balance') }}</p>
                                    @csrf
                                    <div class="flex gap-2">
                                        <div class="flex-1">
                                            @include('shared/input', ['name' => 'amount', 'value' => auth('web')->user()->balance > $invoice->total ? $invoice->total : auth('web')->user()->balance])
                                        </div>
                                        <button type="submit" class="btn-primary mt-[1.625rem] inline-flex items-center gap-x-1">
                                            <i class="bi bi-plus"></i>{{ __('global.add') }}
                                        </button>
                                    </div>
                                </form>
                            @endif

                            @if (auth('web')->user()->paymentMethods()->isNotEmpty())
                                <form method="POST" action="{{ route('front.payment-methods.pay', ['invoice' => $invoice]) }}" class="p-4 bg-gray-50 dark:bg-gray-700/30 rounded-xl border border-gray-200 dark:border-gray-700">
                                    @csrf
                                    <h3 class="font-semibold mb-2 text-gray-800 dark:text-white text-sm">{{ __('store.checkout.choose_payment_method') }}</h3>
                                    @include('shared/select', [
                                        'name' => 'paymentmethod',
                                        'options' => auth('web')->user()->getPaymentMethodsArray()->merge(['none' => __('store.checkout.not_use_payment_method')]),
                                        'value' => 'none'
                                    ])
                                    <button type="submit" class="paymentmethod-btn1 btn-primary mt-3 inline-flex items-center gap-x-2 w-full justify-center">
                                        <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="M7 15h0M2 9.5h20"/></svg>
                                        {{ __('client.invoices.pay') }}
                                    </button>
                                </form>
                            @endif

                            <div class="hs-dropdown relative inline-flex w-full">
                                <button class="paymentmethod-btn2 btn-primary inline-flex items-center gap-x-2 w-full justify-center">
                                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="M7 15h0M2 9.5h20"/></svg>
                                    {{ __('client.invoices.pay') }}
                                    <svg class="hs-dropdown-open:rotate-180 w-4 h-4 transition-transform duration-200" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m6 9 6 6 6-6"/></svg>
                                </button>
                                <div class="hs-dropdown-menu transition-[opacity,margin] hs-dropdown-open:opacity-100 opacity-0 hidden min-w-full bg-white dark:bg-gray-800 shadow-lg rounded-xl border border-gray-100 dark:border-gray-700 mt-1 z-[9999] p-1">
                                    @foreach ($gateways as $gateway)
                                    <a class="flex items-center gap-x-3 py-2.5 px-3 rounded-lg text-sm text-gray-800 hover:bg-violet-50 dark:text-gray-300 dark:hover:bg-violet-900/20 hover:text-violet-700 dark:hover:text-violet-300 transition-colors" href="{{ route('front.invoices.pay', ['invoice' => $invoice, 'gateway' => $gateway->uuid]) }}">
                                        {{ $gateway->getGatewayName() }}
                                    </a>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                @endif

                {{-- Footer notes --}}
                <div class="mt-8 sm:mt-10 pt-6 border-t border-gray-100 dark:border-gray-700">
                    @if (!empty(setting("invoice_terms")))
                        <h6 class="text-sm font-semibold text-gray-800 dark:text-gray-200 mb-1">{{ __('client.invoices.terms') }}</h6>
                        <p class="text-sm text-gray-500 mb-4">{!! nl2br(setting("invoice_terms", "You can change this details in Invoice configuration.")) !!}</p>
                    @endif
                    @if ($invoice->paymethod == 'bank_transfert' && $invoice->status != 'paid')
                        <h4 class="text-base font-semibold text-gray-800 dark:text-gray-200 mb-1">{{ __('client.invoices.banktransfer.title') }}</h4>
                        <p class="text-sm text-gray-500">{!! nl2br(setting("bank_transfert_details", "You can change this details in Bank transfer configuration.")) !!}</p>
                    @elseif ($invoice->status == 'paid')
                        <h4 class="text-base font-semibold text-gray-800 dark:text-gray-200 mb-1">{{ __('client.invoices.thank') }}</h4>
                        <p class="text-sm text-gray-500">{{ __('client.invoices.thankmessage') }}</p>
                    @endif
                    <p class="mt-4 text-xs text-gray-400">© {{ date('Y') }} {{ config('app.name') }}.</p>
                </div>
            </div>

            {{-- Action buttons --}}
            <div class="mt-4 flex justify-end gap-x-3 print:hidden">
                <a class="btn-action-with-icon gap-2" href="{{ route('front.invoices.download', ['invoice' => $invoice]) }}">
                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" x2="12" y1="15" y2="3"/></svg>
                    {{ __('client.invoices.download') }}
                </a>
                <a target="_blank" href="{{ route('front.invoices.pdf', ['invoice' => $invoice]) }}" class="btn-primary inline-flex items-center gap-x-2">
                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 6 2 18 2 18 9"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect width="12" height="8" x="6" y="14"/></svg>
                    {{ __('client.invoices.print') }}
                </a>
            </div>
        </div>
    </div>
@endsection
