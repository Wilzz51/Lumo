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
@section('title', __('client.profile.index'))
@section('scripts')
    <script src="{{ Vite::asset('resources/themes/default/js/filter.js') }}"></script>
@endsection
@section('content')

    {{-- Banner --}}
    <div class="relative overflow-hidden bg-gradient-to-br from-violet-700 via-violet-600 to-fuchsia-700 py-8">
        <div class="absolute top-0 right-0 w-72 h-72 bg-white/5 rounded-full -translate-y-1/2 translate-x-1/4 pointer-events-none"></div>
        <div class="absolute inset-0 bg-[linear-gradient(to_right,rgba(255,255,255,0.04)_1px,transparent_1px),linear-gradient(to_bottom,rgba(255,255,255,0.04)_1px,transparent_1px)] bg-[size:32px_32px] pointer-events-none"></div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center gap-4">
            <div class="flex-shrink-0 w-11 h-11 rounded-xl flex items-center justify-center bg-white/15 border border-white/20">
                <svg class="w-5 h-5 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
            </div>
            <div>
                <p class="text-violet-200 text-xs font-medium uppercase tracking-widest mb-0.5">{{ __('global.clientarea') }}</p>
                <h1 class="text-2xl font-bold text-white">{{ __('client.profile.index') }}</h1>
            </div>
        </div>
    </div>

    <div class="max-w-[85rem] px-4 py-8 sm:px-6 lg:px-8 mx-auto">
        @include('shared/alerts')

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">

            {{-- Colonne principale --}}
            <div class="lg:col-span-2 flex flex-col gap-4">

                {{-- Informations personnelles --}}
                <div class="rounded-xl border overflow-hidden shadow-sm bg-white dark:bg-[#0f0527] border-gray-100 dark:border-violet-900/20">
                    <div class="px-5 py-4 border-b border-gray-100 dark:border-violet-900/20 flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg flex items-center justify-center bg-violet-100 dark:bg-violet-900/30">
                            <svg class="w-4 h-4 text-violet-600 dark:text-violet-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                        </div>
                        <div>
                            <h2 class="text-sm font-semibold text-gray-800 dark:text-white">{{ __('client.profile.index') }}</h2>
                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ __('client.profile.index_description') }}</p>
                        </div>
                    </div>
                    <div class="p-6">
                        <form method="POST" action="{{ route('front.profile.update') }}">
                            @csrf
                            <div class="grid grid-cols-1 gap-x-6 gap-y-4 sm:grid-cols-6">
                                <div class="sm:col-span-2">@include('shared.input', ['name' => 'firstname', 'label' => __('global.firstname'), 'value' => auth('web')->user()->firstname ?? old('firstname')])</div>
                                <div class="sm:col-span-2">@include('shared.input', ['name' => 'lastname', 'label' => __('global.lastname'), 'value' => auth('web')->user()->lastname ?? old('lastname')])</div>
                                <div class="sm:col-span-2">@include('shared/input', ['name' => 'company_name', 'label' => __('global.company_name') . ' (' . __('global.optional') . ')', 'value' => auth('web')->user()->company_name ?? old('company_name')])</div>
                                <div class="sm:col-span-3">@include('shared.input', ['name' => 'address', 'label' => __('global.address'), 'value' => auth('web')->user()->address ?? old('address')])</div>
                                <div class="sm:col-span-2">@include('shared.input', ['name' => 'address2', 'label' => __('global.address2'), 'value' => auth('web')->user()->address2 ?? old('address2')])</div>
                                <div class="sm:col-span-1">@include('shared.input', ['name' => 'zipcode', 'label' => __('global.zip'), 'value' => auth('web')->user()->zipcode ?? old('zipcode')])</div>
                                <div class="sm:col-span-3">@include('shared.input', ['name' => 'email', 'label' => __('global.email'), 'type' => 'email', 'value' => auth('web')->user()->email ?? old('email'), 'disabled' => true])</div>
                                <div class="sm:col-span-3">@include('shared.input', ['name' => 'phone', 'label' => __('global.phone'), 'value' => auth('web')->user()->phone ?? old('phone')])</div>
                                <div class="sm:col-span-2">@include('shared.select', ['name' => 'country', 'label' => __('global.country'), 'options' => $countries, 'value' => auth('web')->user()->country ?? old('country')])</div>
                                <div class="sm:col-span-2">@include('shared.input', ['name' => 'city', 'label' => __('global.city'), 'value' => auth('web')->user()->city ?? old('city')])</div>
                                <div class="sm:col-span-2">@include('shared.input', ['name' => 'region', 'label' => __('global.region'), 'value' => auth('web')->user()->region ?? old('region')])</div>
                                <div class="sm:col-span-2">@include('shared/select', ['name' => 'locale', 'label' => __('global.locale'), 'options' => $locales, 'value' => auth('web')->user()->locale ?? old('locale')])</div>
                                <div class="sm:col-span-4">@include('shared/textarea', ['name' => 'billing_details', 'label' => __('global.billing_details'), 'value' => auth('web')->user()->billing_details ?? old('billing_details'), 'help' => __('global.billing_details_help')])</div>
                            </div>
                            <button class="mt-5 inline-flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-semibold text-white transition-all hover:-translate-y-px"
                                    style="background:linear-gradient(135deg,#7c3aed,#a855f7);box-shadow:0 2px 10px rgba(124,58,237,0.3)">
                                {{ __('global.save') }}
                            </button>
                        </form>
                    </div>
                </div>

                {{-- Question de sécurité --}}
                @if (!$user->hasSecurityQuestion())
                <div class="rounded-xl border overflow-hidden shadow-sm bg-white dark:bg-[#0f0527] border-gray-100 dark:border-violet-900/20">
                    <div class="px-5 py-4 border-b border-gray-100 dark:border-violet-900/20 flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg flex items-center justify-center bg-amber-100 dark:bg-amber-900/20">
                            <svg class="w-4 h-4 text-amber-600 dark:text-amber-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                        </div>
                        <div>
                            <h2 class="text-sm font-semibold text-gray-800 dark:text-white">{{ __('client.profile.security_question.title') }}</h2>
                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ __('client.profile.security_question.description') }}</p>
                        </div>
                    </div>
                    <div class="p-6">
                        <form method="POST" action="{{ route('front.profile.security_question') }}">
                            @csrf
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>@include('shared/select', ['name' => 'security_question_id', 'label' => __('client.profile.security_question.select'), 'options' => \App\Models\Admin\SecurityQuestion::active()->ordered()->pluck('question', 'id')->toArray(), 'value' => old('security_question_id', $user->security_question_id), 'required' => true, 'placeholder' => __('client.profile.security_question.choose')])</div>
                                <div>@include('shared/input', ['name' => 'security_answer', 'label' => __('client.profile.security_question.answer'), 'type' => 'text', 'placeholder' => __('client.profile.security_question.answer_placeholder'), 'required' => true])</div>
                            </div>
                            <div class="mt-4">@include('shared/password', ['name' => 'currentpassword_sq', 'label' => __('client.profile.security.currentpassword')])</div>
                            <button type="submit" class="mt-4 inline-flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-semibold text-white transition-all hover:-translate-y-px"
                                    style="background:linear-gradient(135deg,#7c3aed,#a855f7);box-shadow:0 2px 10px rgba(124,58,237,0.3)">
                                {{ __('admin.updatedetails') }}
                            </button>
                        </form>
                    </div>
                </div>
                @endif
            </div>

            {{-- Colonne latérale --}}
            <div class="flex flex-col gap-4">

                {{-- Sécurité / Mot de passe --}}
                <div class="rounded-xl border overflow-hidden shadow-sm bg-white dark:bg-[#0f0527] border-gray-100 dark:border-violet-900/20">
                    <div class="px-5 py-4 border-b border-gray-100 dark:border-violet-900/20 flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg flex items-center justify-center bg-emerald-100 dark:bg-emerald-900/20">
                            <svg class="w-4 h-4 text-emerald-600 dark:text-emerald-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                        </div>
                        <div>
                            <h2 class="text-sm font-semibold text-gray-800 dark:text-white">{{ __('client.profile.security.index') }}</h2>
                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ __('client.profile.security.index_description') }}</p>
                        </div>
                    </div>
                    <div class="p-5">
                        <form method="POST" action="{{ route('front.profile.password') }}">
                            @csrf
                            <div class="flex flex-col gap-3">
                                @include('shared/password', ['name' => 'currentpassword', 'label' => __('client.profile.security.currentpassword')])
                                @include('shared/password', ['name' => 'password', 'label' => __('client.profile.security.newpassword')])
                                @include('shared/password', ['name' => 'password_confirmation', 'label' => __('global.password_confirmation')])
                                @if (auth('web')->user()->twoFactorEnabled())
                                    @include('shared/input', ['name' => '2fa', 'label' => __('client.profile.2fa.code')])
                                @endif
                                @if ($user->hasSecurityQuestion())
                                    @include('shared/input', ['name' => 'security_answer', 'label' => $user->securityQuestion->question])
                                @endif
                            </div>
                            <button class="mt-4 inline-flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-semibold text-white transition-all hover:-translate-y-px"
                                    style="background:linear-gradient(135deg,#7c3aed,#a855f7);box-shadow:0 2px 10px rgba(124,58,237,0.3)">
                                {{ __('global.save') }}
                            </button>
                        </form>

                        {{-- 2FA --}}
                        <div class="mt-5 pt-5 border-t border-gray-100 dark:border-violet-900/20">
                            <h3 class="text-sm font-semibold text-gray-800 dark:text-white mb-1">{{ __('client.profile.2fa.title') }}</h3>
                            @if (!auth('web')->user()->twoFactorEnabled())
                                <p class="text-xs text-gray-500 dark:text-gray-400 mb-3">{{ __('client.profile.2fa.info') }}</p>
                            @else
                                <p class="text-xs text-gray-500 dark:text-gray-400 mb-3">{!! __('client.profile.2fa.download_codes', ['url' => route('front.profile.2fa_codes')]) !!}</p>
                            @endif
                            <form method="POST" action="{{ route('front.profile.2fa') }}">
                                @csrf
                                @if (!auth('web')->user()->twoFactorEnabled())
                                    {!! $qrcode !!}
                                    @include('shared/input', ['name' => '2fa', 'label' => __('client.profile.2fa.code'), 'help' => $code])
                                @else
                                    @include('shared/input', ['name' => '2fa', 'label' => __('client.profile.2fa.code')])
                                @endif
                                <button class="{{ auth('web')->user()->twoFactorEnabled() ? 'btn-danger' : 'inline-flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-semibold text-white transition-all hover:-translate-y-px' }} mt-3"
                                        @if (!auth('web')->user()->twoFactorEnabled()) style="background:linear-gradient(135deg,#7c3aed,#a855f7);box-shadow:0 2px 10px rgba(124,58,237,0.3)" @endif>
                                    {{ __(auth('web')->user()->twoFactorEnabled() ? 'global.delete' : 'global.save') }}
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                {{-- Connexions sociales --}}
                @if (!empty($providers))
                <div class="rounded-xl border overflow-hidden shadow-sm bg-white dark:bg-[#0f0527] border-gray-100 dark:border-violet-900/20">
                    <div class="px-5 py-4 border-b border-gray-100 dark:border-violet-900/20">
                        <h2 class="text-sm font-semibold text-gray-800 dark:text-white">Connexions sociales</h2>
                    </div>
                    <div class="p-4 flex flex-col gap-2">
                        @foreach ($providers ?? [] as $provider)
                            <a href="{{ $provider->isSynced() ? route('socialauth.unlink', $provider->name) : route('socialauth.authorize', $provider->name) }}"
                               class="w-full py-2.5 px-4 inline-flex items-center gap-3 text-sm font-medium rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-200 hover:bg-violet-50 dark:hover:bg-violet-900/20 hover:border-violet-300 dark:hover:border-violet-700 transition-colors">
                                <img src="{{ $provider->provider()->logo() }}" alt="{{ $provider->provider()->title() }}" class="w-5 h-5">
                                {{ $provider->isSynced() ? __('socialauth::messages.unlink', ['provider' => $provider->provider()->title()]) : __('socialauth::messages.sync_with', ['provider' => $provider->provider()->title()]) }}
                            </a>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
        </div>

        {{-- Zone de danger --}}
        @php
            $deletionService = new \App\Services\Account\AccountDeletionService();
            $canDelete = $deletionService->canDelete($user);
            $blockingReasons = $deletionService->getBlockingReasons($user);
        @endphp
        <div class="mt-4 rounded-xl border border-red-200 dark:border-red-800/50 bg-red-50 dark:bg-red-900/10 p-6">
            <div class="flex items-start gap-4">
                <div class="flex-shrink-0 w-10 h-10 rounded-xl bg-red-100 dark:bg-red-900/30 flex items-center justify-center">
                    <svg class="w-5 h-5 text-red-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/></svg>
                </div>
                <div class="flex-1">
                    <h3 class="text-base font-bold text-red-700 dark:text-red-400">{{ __('client.profile.delete.danger_zone') }}</h3>
                    <p class="mt-1 text-sm text-red-600 dark:text-red-300">{{ __('client.profile.delete.warning_message') }}</p>
                    @if (!$canDelete)
                        <div class="mt-3 bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800/50 rounded-lg p-3">
                            <p class="text-sm font-semibold text-amber-800 dark:text-amber-200 mb-1">{{ __('client.profile.delete.cannot_delete') }}</p>
                            @if (isset($blockingReasons['active_services']))
                                <p class="text-xs text-amber-700 dark:text-amber-300">{{ __('client.profile.delete.has_active_services', ['count' => $blockingReasons['active_services']['count']]) }}</p>
                            @endif
                            @if (isset($blockingReasons['pending_invoices']))
                                <p class="text-xs text-amber-700 dark:text-amber-300 mt-1">{{ __('client.profile.delete.has_pending_invoices', ['count' => $blockingReasons['pending_invoices']['count']]) }}</p>
                            @endif
                        </div>
                    @else
                        <form action="{{ route('front.profile.delete.confirm') }}" method="POST" class="mt-4" onsubmit="return confirm('{{ __('client.profile.delete.final_confirm') }}')">
                            @csrf
                            @method('DELETE')
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                @include('shared/input', ['name' => 'password', 'type' => 'password', 'label' => __('client.profile.delete.password_label')])
                                @if ($user->twoFactorEnabled())
                                    @include('shared/input', ['name' => '2fa_code', 'type' => 'text', 'label' => __('client.profile.delete.2fa_label')])
                                @endif
                            </div>
                            <div class="mt-3">@include('shared/checkbox', ['name' => 'confirm_deletion', 'label' => __('client.profile.delete.confirm_checkbox'), 'checked' => false])</div>
                            <button type="submit" class="mt-4 btn-danger">{{ __('client.profile.delete.submit_button') }}</button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
