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
@section('styles')
<style>
    /* ═══ LUMO — Payment methods page overrides (no build needed) ═══ */

    /* Tous les boutons du fund/giftcard → dégradé violet */
    .lumo-ext-card button,
    .lumo-ext-card input[type="submit"],
    .lumo-ext-card a[role="button"] {
        background: linear-gradient(135deg, #7c3aed, #a855f7) !important;
        border-color: transparent !important;
        box-shadow: 0 2px 10px rgba(124,58,237,0.35) !important;
        color: #fff !important;
        border-radius: 0.5rem !important;
        font-weight: 600 !important;
        transition: transform 0.15s, box-shadow 0.15s;
    }
    .lumo-ext-card button:hover { transform: translateY(-1px) !important; }

    /* Garder les boutons danger en rouge */
    .lumo-ext-card button[class*="red"],
    .lumo-ext-card button[class*="danger"] {
        background: linear-gradient(135deg, #dc2626, #ef4444) !important;
        box-shadow: 0 2px 8px rgba(220,38,38,0.3) !important;
    }

    /* Tous les boutons de la section "Ajouter un moyen de paiement" → violet */
    .gateway-form-wrapper button,
    .gateway-form-wrapper input[type="submit"],
    .gateway-form-wrapper a[role="button"] {
        background: linear-gradient(135deg, #7c3aed, #a855f7) !important;
        border-color: transparent !important;
        box-shadow: 0 2px 10px rgba(124,58,237,0.35) !important;
        color: #fff !important;
        border-radius: 0.5rem !important;
        font-weight: 600 !important;
        width: 100% !important;
        display: block !important;
        text-align: center !important;
        padding: 0.625rem 1rem !important;
    }
    .gateway-form-wrapper button:hover { transform: translateY(-1px) !important; }
</style>
@endsection
@section('scripts')
    <script>
        function showBillingDayForm(serviceId, currentDay) {
            document.getElementById('billing-day-display-' + serviceId).style.display = 'none';
            var container = document.getElementById('billing-day-form-' + serviceId);
            container.classList.remove('hidden');
            container.querySelector('input[name="billing_day"]').focus();
        }
        function hideBillingDayForm(serviceId) {
            document.getElementById('billing-day-display-' + serviceId).style.display = '';
            document.getElementById('billing-day-form-' + serviceId).classList.add('hidden');
        }
    </script>
@endsection
@section('title', __('client.payment-methods.index'))
@section('content')

    {{-- Banner --}}
    <div class="relative overflow-hidden bg-gradient-to-br from-violet-700 via-violet-600 to-fuchsia-700 py-8">
        <div class="absolute top-0 right-0 w-72 h-72 bg-white/5 rounded-full -translate-y-1/2 translate-x-1/4 pointer-events-none"></div>
        <div class="absolute inset-0 bg-[linear-gradient(to_right,rgba(255,255,255,0.04)_1px,transparent_1px),linear-gradient(to_bottom,rgba(255,255,255,0.04)_1px,transparent_1px)] bg-[size:32px_32px] pointer-events-none"></div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center gap-4">
            <div class="flex-shrink-0 w-11 h-11 rounded-xl flex items-center justify-center bg-white/15 border border-white/20">
                <svg class="w-5 h-5 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
            </div>
            <div>
                <p class="text-violet-200 text-xs font-medium uppercase tracking-widest mb-0.5">{{ __('global.clientarea') }}</p>
                <h1 class="text-2xl font-bold text-white">{{ __('client.payment-methods.index') }}</h1>
            </div>
        </div>
    </div>

    <div class="max-w-[85rem] px-4 py-8 sm:px-6 lg:px-8 mx-auto">
        @include('shared/alerts')
        <div class="flex flex-col gap-4">
            @include('front/billing/payment-methods/card', ['sources' => $sources])

            {{-- Historique factures --}}
            <div class="rounded-xl border overflow-hidden shadow-sm bg-white dark:bg-[#0f0527] border-gray-100 dark:border-violet-900/20">
                <div class="px-5 py-4 flex items-center justify-between border-b border-gray-100 dark:border-violet-900/20">
                    <div>
                        <h2 class="text-base font-semibold text-gray-800 dark:text-white">{{ __('client.payment-methods.invoices') }}</h2>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">{{ __('client.payment-methods.invoices_description') }}</p>
                    </div>
                    <a class="inline-flex items-center gap-1 py-1.5 px-3 text-xs font-semibold rounded-lg text-violet-600 dark:text-violet-400 hover:bg-violet-50 dark:hover:bg-violet-900/20 transition-colors" href="{{ route('front.invoices.index') }}">
                        {{ __('global.seemore') }}
                        <svg class="w-3.5 h-3.5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
                    </a>
                </div>
                @if($paidInvoicesWithPaymentMethod->isEmpty())
                    <div class="flex flex-col items-center justify-center py-10">
                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ __('global.no_results') }}</p>
                    </div>
                @else
                    @foreach($paidInvoicesWithPaymentMethod as $invoice)
                        <div class="flex items-center gap-4 px-5 py-3.5 {{ !$loop->last ? 'border-b border-gray-50 dark:border-violet-900/10' : '' }} hover:bg-violet-50/30 dark:hover:bg-violet-900/10 transition-colors">
                            <div class="flex-1 min-w-0">
                                <a href="{{ route('front.invoices.show', ['invoice' => $invoice]) }}" class="text-sm font-mono font-semibold text-violet-600 dark:text-violet-400">{{ $invoice->identifier() }}</a>
                                <p class="text-xs text-gray-500 dark:text-gray-400">{{ $invoice->created_at->format('d/m/Y H:i') }}</p>
                            </div>
                            <span class="text-sm font-bold text-gray-800 dark:text-white">{{ formatted_price($invoice->subtotal, $invoice->currency) }}</span>
                            <span class="text-xs text-gray-500 dark:text-gray-400 hidden sm:block">{{ $invoice->gateway->name ?? __('global.unknown') }}</span>
                        </div>
                    @endforeach
                @endif
            </div>
            {{-- Abonnements --}}
            <div class="rounded-xl border overflow-hidden shadow-sm bg-white dark:bg-[#0f0527] border-gray-100 dark:border-violet-900/20">
                <div class="px-5 py-4 border-b border-gray-100 dark:border-violet-900/20">
                    <h2 class="text-base font-semibold text-gray-800 dark:text-white">{{ __('client.services.subscription.manage_subscriptions.index') }}</h2>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">{{ __('client.services.subscription.manage_subscriptions.index_description') }}</p>
                </div>
                @if($subscribableServices->isEmpty())
                    <div class="flex flex-col items-center justify-center py-10">
                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ __('global.no_results') }}</p>
                    </div>
                @else
                    @foreach($subscribableServices as $service)
                        <div class="px-5 py-4 {{ !$loop->last ? 'border-b border-gray-50 dark:border-violet-900/10' : '' }} hover:bg-violet-50/30 dark:hover:bg-violet-900/10 transition-colors">
                            <form method="POST" action="{{ route('front.services.subscription', ['service' => $service]) }}">
                                @csrf
                                <div class="flex flex-wrap items-center gap-4">
                                    <div class="flex-1 min-w-0">
                                        <a href="{{ route('front.services.show', $service) }}" class="text-sm font-semibold text-gray-800 dark:text-gray-100 hover:text-violet-600 dark:hover:text-violet-400 transition-colors">{{ $service->name }}</a>
                                    </div>
                                    <x-badge-state state="{{ $service->getSubscription()->state }}"></x-badge-state>
                                    <div class="text-sm text-gray-500 dark:text-gray-400 billing-day-display" id="billing-day-display-{{ $service->id }}">
                                        {{ $service->getSubscription()->isActive() ? $service->getSubscription()->getNextPaymentDate() : '--' }}
                                        @if($service->getSubscription()->isActive())
                                            <button type="button" onclick="showBillingDayForm({{ $service->id }}, {{ $service->getSubscription()->billing_days ?? 5 }})"
                                                    class="ml-2 inline-flex items-center gap-1 px-2 py-1 rounded text-xs font-medium border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                                <i class="bi bi-pencil-square"></i>{{ __('global.edit') }}
                                            </button>
                                        @endif
                                    </div>
                                    <div class="hidden billing-day-form" id="billing-day-form-{{ $service->id }}">
                                        @include('shared/input', ['type' => 'number', 'name' => 'billing_day', 'attributes' => ['min' => 1, 'max' => 28], 'id' => "billing-day-input-{$service->id}", 'value' => $service->getSubscription()->billing_day ?? 5, 'required' => true])
                                    </div>
                                    @if(auth('web')->user()->getPaymentMethodsArray()->isNotEmpty())
                                        <div class="w-40">
                                            @include('shared/select', ['name' => 'paymentmethod', 'options' => auth('web')->user()->getPaymentMethodsArray(), 'value' => $service->getSubscription()->paymentmethod_id])
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <button type="submit" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold text-white transition-all hover:-translate-y-px" style="background:linear-gradient(135deg,#7c3aed,#a855f7);box-shadow:0 2px 8px rgba(124,58,237,0.25)">
                                                <i class="bi bi-check-circle"></i>{{ __('global.save') }}
                                            </button>
                                            @if($service->getSubscription()->isActive())
                                                <button type="submit" name="cancel" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold bg-red-50 dark:bg-red-900/20 text-red-600 dark:text-red-400 border border-red-200 dark:border-red-800/50 hover:bg-red-100 transition-colors">
                                                    <i class="bi bi-x-circle"></i>{{ __('global.cancel') }}
                                                </button>
                                            @endif
                                        </div>
                                    @else
                                        <div class="text-xs text-amber-600 dark:text-amber-400 bg-amber-50 dark:bg-amber-900/20 px-3 py-2 rounded-lg border border-amber-200 dark:border-amber-800/50">
                                            {!! __('client.services.subscription.add_payments_method', ['url' => route('front.payment-methods.index')]) !!}
                                        </div>
                                    @endif
                                </div>
                            </form>
                        </div>
                    @endforeach
                @endif
            </div>

            {{-- Ajouter un moyen de paiement + Créditer --}}
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 items-start">

                {{-- Ajouter un moyen de paiement --}}
                <div class="rounded-xl border overflow-hidden shadow-sm bg-white dark:bg-[#0f0527] border-gray-100 dark:border-violet-900/20 self-start">
                    <div class="px-5 py-3.5 flex items-center gap-3 border-b border-gray-100 dark:border-violet-900/20">
                        <div class="w-8 h-8 rounded-lg flex items-center justify-center bg-violet-100 dark:bg-violet-900/30 flex-shrink-0">
                            <svg class="w-4 h-4 text-violet-600 dark:text-violet-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
                        </div>
                        <div>
                            <h2 class="text-sm font-semibold text-gray-800 dark:text-white">{{ __('client.payment-methods.add') }}</h2>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">{{ __('client.payment-methods.add_description') }}</p>
                        </div>
                    </div>
                    @if(count($gateways) === 0)
                        <div class="flex flex-col items-center justify-center py-8 px-5">
                            <div class="w-10 h-10 rounded-xl bg-gray-100 dark:bg-gray-800/50 flex items-center justify-center mb-3">
                                <svg class="w-5 h-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
                            </div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ __('global.no_results') }}</p>
                        </div>
                    @else
                        <div class="p-4 flex flex-col gap-3">
                            @foreach ($gateways as $gateway)
                                <div class="gateway-form-wrapper rounded-lg border border-gray-100 dark:border-violet-900/20 bg-gray-50/50 dark:bg-violet-900/5 p-3">
                                    <form method="POST" action="{{ route('front.payment-methods.add', $gateway->id) }}" id="payment-form-{{ $gateway->uuid }}">
                                        @csrf
                                        {!! $gateway->paymentType()->sourceForm() !!}
                                    </form>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                @if(app('extension')->extensionIsEnabled('fund'))
                    <div class="lumo-ext-card">
                        @include('fund::card')
                    </div>
                @endif
                @if(app('extension')->extensionIsEnabled('giftcard'))
                    <div class="lumo-ext-card">
                        @include('giftcard::card')
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
