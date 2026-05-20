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
@section('title', __('client.services.renewals.index'))
@section('content')

    {{-- Banner --}}
    <div class="relative overflow-hidden bg-gradient-to-br from-violet-700 via-violet-600 to-fuchsia-700 py-8">
        <div class="absolute top-0 right-0 w-72 h-72 bg-white/5 rounded-full -translate-y-1/2 translate-x-1/4 pointer-events-none"></div>
        <div class="absolute inset-0 bg-[linear-gradient(to_right,rgba(255,255,255,0.04)_1px,transparent_1px),linear-gradient(to_bottom,rgba(255,255,255,0.04)_1px,transparent_1px)] bg-[size:32px_32px] pointer-events-none"></div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center gap-4">
            <div class="flex-shrink-0 w-11 h-11 rounded-xl flex items-center justify-center bg-white/15 border border-white/20">
                <svg class="w-5 h-5 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21.5 2v6h-6M2.5 22v-6h6M2 11.5a10 10 0 0 1 18.8-4.3M22 12.5a10 10 0 0 1-18.8 4.2"/></svg>
            </div>
            <div>
                <p class="text-violet-200 text-xs font-medium uppercase tracking-widest mb-0.5">{{ $service->name }}</p>
                <h1 class="text-2xl font-bold text-white">{{ __('client.services.renewals.index') }}</h1>
            </div>
        </div>
    </div>

    <div class="max-w-[85rem] py-6 lg:py-8 mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row gap-6 items-start">

            {{-- Main content --}}
            <div class="min-w-0 flex-1">
                @include('shared/alerts')

                {{-- Renewals history --}}
                <div class="card">
                    <div class="card-heading">
                        <div>
                            <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">{{ __('client.services.renewals.index') }}</h2>
                            <p class="text-sm text-gray-600 dark:text-gray-400">{{ __('client.services.renewals.manage') }}</p>
                        </div>
                    </div>
                    <div class="border rounded-xl overflow-hidden dark:border-gray-700">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700/50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-start">
                                    <span class="text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">{{ __('client.services.renewals.period') }}</span>
                                </th>
                                <th scope="col" class="px-6 py-3 text-start">
                                    <span class="text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">{{ __('global.invoice') }}</span>
                                </th>
                                <th scope="col" class="px-6 py-3 text-start">
                                    <span class="text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">{{ __('store.price') }}</span>
                                </th>
                                <th scope="col" class="px-6 py-3 text-start">
                                    <span class="text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">{{ __('client.services.renewals.date') }}</span>
                                </th>
                                <th scope="col" class="px-6 py-3 text-end"></th>
                            </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @if ($renewals->isEmpty())
                                <tr class="bg-white dark:bg-gray-800">
                                    <td colspan="5" class="px-6 py-8 text-center">
                                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ __('global.no_results') }}</p>
                                    </td>
                                </tr>
                            @endif
                            @foreach($renewals as $renewal)
                                @if ($renewal->invoice == null) @continue @endif
                                <tr class="bg-white hover:bg-gray-50/70 dark:bg-gray-800 dark:hover:bg-gray-700/40 transition-colors duration-150">
                                    <td class="px-6 py-3 whitespace-nowrap">
                                        <span class="text-sm text-gray-600 dark:text-gray-400">#{{ $renewal->period }}</span>
                                    </td>
                                    <td class="px-6 py-3 whitespace-nowrap">
                                        <a href="{{ route('front.invoices.show', ['invoice' => $renewal->invoice]) }}" class="font-mono text-sm font-semibold text-violet-600 dark:text-violet-400 hover:text-violet-800 dark:hover:text-violet-300 transition-colors">{{ $renewal->invoice->identifier() }}</a>
                                    </td>
                                    <td class="px-6 py-3 whitespace-nowrap">
                                        <span class="text-sm text-gray-600 dark:text-gray-400">{{ formatted_price($renewal->invoice->subtotal, $renewal->invoice->currency) }}</span>
                                    </td>
                                    <td class="px-6 py-3 whitespace-nowrap">
                                        <span class="text-sm text-gray-600 dark:text-gray-400">{{ $renewal->start_date->format('d/m/y') }} – {{ $renewal->end_date ? $renewal->end_date->format('d/m/y') : 'Undefined' }}</span>
                                    </td>
                                    <td class="px-6 py-3 whitespace-nowrap text-end">
                                        <a href="{{ route('front.invoices.show', ['invoice' => $renewal->invoice]) }}" class="btn-action-with-icon">
                                            <i class="bi bi-eye-fill"></i>
                                            {{ __('global.view') }}
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- Subscription management --}}
                    @if ($service->canSubscribe())
                    <div class="mt-6 pt-6 border-t border-gray-100 dark:border-gray-700">
                        <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-1">{{ __('client.services.subscription.index') }}</h2>
                        @if ($service->getSubscription()->isActive())
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-3">{{ __('client.services.subscription.enabled', ['date' => $service->getSubscription()->getNextPaymentDate()]) }}</p>
                        @endif
                        <form method="POST" action="{{ route('front.services.subscription', ['service' => $service]) }}">
                            @csrf
                            @if ($customer->getPaymentMethodsArray()->isNotEmpty())
                                <div class="grid grid-cols-2 gap-3">
                                    <div>
                                        @include('admin/shared/select', ['name' => 'paymentmethod', 'options' => $customer->getPaymentMethodsArray(), 'label' => __('client.payment-methods.paymentmethod'), 'value' => $service->getSubscription()->paymentmethod_id])
                                    </div>
                                    <div>
                                        @include('admin/shared/input', ['type' => 'number', 'name' => 'billing_day', 'label' => __('client.services.subscription.billing_day'), 'help' => __('client.services.subscription.billing_day_help'), 'attributes' => ['min' => 1, 'max' => 28], 'value' => $service->getSubscription()->billing_day ?? 5])
                                    </div>
                                </div>
                                <div class="flex gap-2 mt-3">
                                    <button class="btn-primary">{{ __('global.save') }}</button>
                                    @if ($service->getSubscription()->isActive())
                                        <button class="btn-danger" name="cancel">{{ __('client.services.subscription.cancel') }}</button>
                                    @endif
                                </div>
                            @else
                                <div class="flex items-start gap-3 p-4 bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800 rounded-xl mt-2">
                                    <svg class="w-5 h-5 text-amber-500 flex-shrink-0 mt-0.5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                                    <p class="text-sm text-amber-800 dark:text-amber-200">{!! __('client.services.subscription.add_payments_method', ['url' => route('front.payment-methods.index')]) !!}</p>
                                </div>
                            @endif
                        </form>
                    </div>
                    @endif

                    {{-- Billing cycle --}}
                    @if (collect($service->pricingAvailable())->count() > 1)
                    <div class="mt-6 pt-6 border-t border-gray-100 dark:border-gray-700">
                        <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-3">{{ __('client.services.managerenew') }}</h2>
                        <form method="POST" action="{{ route('front.services.billing', ['service' => $service]) }}">
                            @csrf
                            <div class="grid sm:grid-cols-2 gap-2 mb-4">
                                @foreach(collect($service->pricingAvailable()) as $pricing)
                                    <label class="billing-card">
                                        <input type="radio" name="billing" value="{{ $pricing->recurring }}" class="sr-only" id="months-{{ $pricing->recurring }}" @if($service->billing == $pricing->recurring) checked @endif>
                                        <div class="flex items-center gap-3">
                                            <div class="bc-radio">
                                                <div class="bc-dot"></div>
                                            </div>
                                            <span class="bc-period text-sm font-medium text-gray-700 dark:text-gray-200">
                                                {{ $pricing->recurring()['months'] == 0.5 ? 1 : $pricing->recurring()['months'] }}
                                                {{ $pricing->recurring()['months'] == 0.5 ? __('global.week') : __('global.month') }}
                                                &mdash; {{ $pricing->pricingMessage(false) }}
                                            </span>
                                        </div>
                                    </label>
                                @endforeach
                            </div>

                            <div class="space-y-2 mb-4">
                                @foreach ($gateways as $gateway)
                                <label class="flex items-center gap-3 px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 cursor-pointer hover:border-violet-300 dark:hover:border-violet-600 transition-colors duration-150">
                                    <input type="radio" {{ $loop->first ? 'checked' : '' }} name="gateway" value="{{ $gateway->uuid }}" id="gateway-{{ $gateway->uuid }}" class="shrink-0 border-gray-300 rounded-full text-violet-600 focus:ring-violet-500 dark:bg-gray-700 dark:border-gray-600 dark:checked:bg-violet-500 dark:checked:border-violet-500 dark:focus:ring-offset-gray-800">
                                    <label for="gateway-{{ $gateway->uuid }}" class="text-sm text-gray-700 dark:text-gray-300 cursor-pointer">{{ $gateway->name }}</label>
                                </label>
                                @endforeach
                            </div>
                            <div class="flex gap-2">
                                <button class="btn-primary">{{ __('global.save') }}</button>
                                <button class="btn-secondary" name="pay">{{ __('client.services.renewals.saveandrenew') }}</button>
                            </div>
                        </form>
                    </div>
                    @else
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-4">{{ __('client.services.renewals.not_authorized_to_change_billing') }}</p>
                    @endif
                </div>
            </div>

            {{-- Sidebar --}}
            <div class="w-full md:w-64 flex-shrink-0 flex flex-col gap-3">

                <a href="{{ route('front.services.show', ['service' => $service]) }}" class="w-full inline-flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold text-white border border-transparent transition-all duration-200 hover:opacity-90"
                    style="background:linear-gradient(135deg,#7c3aed,#a855f7);box-shadow:0 2px 10px rgba(124,58,237,.25)">
                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="4" y1="21" x2="4" y2="14"/><line x1="4" y1="10" x2="4" y2="3"/><line x1="12" y1="21" x2="12" y2="12"/><line x1="12" y1="8" x2="12" y2="3"/><line x1="20" y1="21" x2="20" y2="16"/><line x1="20" y1="12" x2="20" y2="3"/><line x1="1" y1="14" x2="7" y2="14"/><line x1="9" y1="8" x2="15" y2="8"/><line x1="17" y1="16" x2="23" y2="16"/></svg>
                    {{ __('client.services.managebtn') }}
                </a>

                @if ($service->canUpgrade())
                <a href="{{ route('front.services.upgrade', ['service' => $service]) }}" class="w-full inline-flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold border bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-200 border-gray-200 dark:border-gray-600 hover:border-violet-300 dark:hover:border-violet-600 hover:text-violet-700 dark:hover:text-violet-300 hover:bg-violet-50 dark:hover:bg-violet-900/20 transition-all duration-200">
                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="17 11 21 7 17 3"/><line x1="21" y1="7" x2="9" y2="7"/><polyline points="7 21 3 17 7 13"/><line x1="15" y1="17" x2="3" y2="17"/></svg>
                    {{ __('client.services.upgradeservice') }}
                </a>
                @endif

                @if ($service->configoptions->isNotEmpty())
                <a class="w-full inline-flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold border bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-200 border-gray-200 dark:border-gray-600 hover:border-violet-300 dark:hover:border-violet-600 hover:text-violet-700 dark:hover:text-violet-300 hover:bg-violet-50 dark:hover:bg-violet-900/20 transition-all duration-200" href="{{ route('front.services.options', ['service' => $service]) }}">
                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>
                    {{ __('client.services.manageoptions') }}
                </a>
                @endif

                @if (auth('admin')->check())
                <a href="{{ route('admin.services.show', ['service' => $service]) }}" class="w-full inline-flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold border text-violet-600 dark:text-violet-400 border-violet-200 dark:border-violet-700 bg-violet-50 dark:bg-violet-900/20 hover:bg-violet-100 dark:hover:bg-violet-900/40 hover:text-violet-700 dark:hover:text-violet-300 hover:border-violet-300 transition-all duration-200">
                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s-8-4.5-8-11.8A8 8 0 0 1 12 2a8 8 0 0 1 8 8.2c0 7.3-8 11.8-8 11.8z"/></svg>
                    {{ __('client.services.manageserviceonadmin') }}
                </a>
                @endif

                {{-- Service info card --}}
                <div class="flex items-center gap-4 p-4 bg-white dark:bg-gray-800 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm">
                    <div class="flex-shrink-0 w-11 h-11 rounded-xl flex items-center justify-center shadow-sm" style="background:linear-gradient(135deg,#7c3aed,#a855f7)">
                        <svg class="w-5 h-5 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="20" height="8" rx="2"/><rect x="2" y="14" width="20" height="8" rx="2"/><line x1="6" y1="6" x2="6.01" y2="6"/><line x1="6" y1="18" x2="6.01" y2="18"/></svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-xs font-semibold uppercase tracking-wider text-gray-400 dark:text-gray-500 mb-1">{{ __('client.services.show') }}</p>
                        <p class="font-semibold text-gray-900 dark:text-white truncate">{{ $service->name }}</p>
                        <x-badge-state state="{{ $service->status }}" class="mt-1"></x-badge-state>
                    </div>
                </div>

                @if ($service->server_id != null)
                <div class="flex items-center gap-4 p-4 bg-white dark:bg-gray-800 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm">
                    <div class="flex-shrink-0 w-11 h-11 rounded-xl flex items-center justify-center shadow-sm" style="background:linear-gradient(135deg,#0ea5e9,#2563eb)">
                        <svg class="w-5 h-5 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s-8-4.5-8-11.8A8 8 0 0 1 12 2a8 8 0 0 1 8 8.2c0 7.3-8 11.8-8 11.8z"/><circle cx="12" cy="10" r="3"/></svg>
                    </div>
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-gray-400 dark:text-gray-500 mb-1">{{ __('global.server') }}</p>
                        <p class="font-semibold text-gray-900 dark:text-white">{{ $service->server->name }}</p>
                    </div>
                </div>
                @endif

                @if ($service->expires_at != null)
                <div class="flex items-center gap-4 p-4 bg-white dark:bg-gray-800 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm">
                    <div class="flex-shrink-0 w-11 h-11 rounded-xl flex items-center justify-center shadow-sm" style="background:linear-gradient(135deg,#f59e0b,#ef4444)">
                        <svg class="w-5 h-5 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    </div>
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-gray-400 dark:text-gray-500 mb-1">{{ __('client.services.expire_date') }}</p>
                        <p class="font-semibold text-gray-900 dark:text-white">
                            <x-service-days-remaining expires_at="{{ $service->expires_at }}" state="{{ $service->status }}" date_at="{{ $service->status == 'expired' ? $service->expires_at->format('d/m/y') : ($service->suspended_at ? $service->suspended_at->format('d/m/y') : '') }}"></x-service-days-remaining>
                        </p>
                    </div>
                </div>
                @endif

                <div class="flex items-center gap-4 p-4 bg-white dark:bg-gray-800 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm">
                    <div class="flex-shrink-0 w-11 h-11 rounded-xl flex items-center justify-center shadow-sm" style="background:linear-gradient(135deg,#10b981,#059669)">
                        <svg class="w-5 h-5 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                    </div>
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-gray-400 dark:text-gray-500 mb-1">{{ __('store.price') }}</p>
                        <p class="font-semibold text-gray-900 dark:text-white">
                            {{ formatted_price($service->getBillingPrice()->displayPrice(), $service->currency) }}
                            <span class="text-gray-400 dark:text-gray-500 font-normal text-sm">/{{ $service->recurring()['unit'] }}</span>
                        </p>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
