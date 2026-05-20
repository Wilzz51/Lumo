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
@section('title', __('helpdesk.support.create.newticket'))
@section('styles')
    <link rel="stylesheet" href="{{ Vite::asset('resources/global/css/simplemde.min.css') }}">
@endsection
@section('scripts')
    <script src="{{ Vite::asset('resources/global/js/mdeditor.js') }}" type="module"></script>
@endsection
@section('content')

    {{-- Banner --}}
    <div class="relative overflow-hidden bg-gradient-to-br from-violet-700 via-violet-600 to-fuchsia-700 py-8">
        <div class="absolute top-0 right-0 w-72 h-72 bg-white/5 rounded-full -translate-y-1/2 translate-x-1/4 pointer-events-none"></div>
        <div class="absolute inset-0 bg-[linear-gradient(to_right,rgba(255,255,255,0.04)_1px,transparent_1px),linear-gradient(to_bottom,rgba(255,255,255,0.04)_1px,transparent_1px)] bg-[size:32px_32px] pointer-events-none"></div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center gap-4">
            <div class="flex-shrink-0 w-11 h-11 rounded-xl flex items-center justify-center bg-white/15 border border-white/20">
                <svg class="w-5 h-5 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
            </div>
            <div>
                <p class="text-violet-200 text-xs font-medium uppercase tracking-widest mb-0.5">{{ __('helpdesk.support.index') }}</p>
                <h1 class="text-2xl font-bold text-white">{{ __('helpdesk.support.create.newticket') }}</h1>
            </div>
        </div>
    </div>

    <div class="max-w-[85rem] px-4 py-8 sm:px-6 lg:px-8 mx-auto">
        @include('shared/alerts')
        <div class="max-w-3xl mx-auto">
            <div class="rounded-xl border overflow-hidden shadow-sm bg-white dark:bg-[#0f0527] border-gray-100 dark:border-violet-900/20">
                <div class="px-5 py-4 border-b border-gray-100 dark:border-violet-900/20 flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center bg-violet-100 dark:bg-violet-900/30">
                        <svg class="w-4 h-4 text-violet-600 dark:text-violet-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                    </div>
                    <div>
                        <h2 class="text-sm font-semibold text-gray-800 dark:text-white">{{ __('helpdesk.support.create.newticket') }}</h2>
                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ __('helpdesk.support.create.index_description') }}</p>
                    </div>
                </div>
                <div class="p-6">
                <form action="{{ route('front.support.create') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="grid gap-5 sm:grid-cols-2">
                        <div class="sm:col-span-1">
                            @include("shared/input", ["name" => "subject", "label" => __("helpdesk.subject"), 'value' => old('subject', $subject)])
                        </div>
                        <div class="sm:col-span-1">
                            @include("shared/select", ["name" => "priority", "label" => __("helpdesk.priority"), "options" => $priorities, 'value' => old('priority', $priority)])
                        </div>
                        <div class="sm:col-span-1">
                            @include("shared/select", ["name" => "related_id", "label" => __("helpdesk.support.create.relatedto"), "options" => $related, 'value' => old('related_id', $related)])
                        </div>
                        <div class="sm:col-span-1">
                            <label for="department_id" class="block text-sm font-medium leading-6 text-gray-900 dark:text-gray-400 mt-2">{{ __('helpdesk.department') }}</label>
                            <div class="relative mt-2">
                                <select data-hs-select='{
                                    "toggleTag": "<button type=\"button\"><span class=\"me-2\" data-icon></span><span class=\"text-gray-800 dark:text-gray-200\" data-title></span></button>",
                                    "toggleClasses": "hs-select-disabled:pointer-events-none hs-select-disabled:opacity-50 relative py-3 px-4 pe-9 flex items-center text-nowrap w-full cursor-pointer bg-white border border-gray-200 rounded-lg text-start text-sm transition-colors duration-200 focus:border-violet-500 focus:ring-violet-500 before:absolute before:inset-0 before:z-[1] dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-violet-500",
                                    "dropdownClasses": "mt-2 z-50 w-full max-h-[300px] p-1 space-y-0.5 bg-white border border-gray-200 rounded-lg overflow-hidden overflow-y-auto dark:bg-gray-800 dark:border-gray-700",
                                    "optionClasses": "py-2 px-4 w-full text-sm text-gray-800 cursor-pointer hover:bg-violet-50 dark:hover:bg-violet-900/20 hover:text-violet-700 rounded-lg focus:outline-none focus:bg-gray-100 dark:bg-gray-800 dark:text-gray-300 dark:focus:bg-gray-700",
                                    "optionTemplate": "<div><div class=\"flex items-center\"><div class=\"me-2\" data-icon></div><div class=\"font-semibold text-gray-800 dark:text-gray-200\" data-title></div></div><div class=\"mt-1.5 text-sm text-gray-500\" data-description></div></div>"
                                }' class="hidden" name="department_id">
                                    <option value="">Choose</option>
                                    @foreach($departments as $department)
                                        <option value="{{ $department->id }}" {{ old('department_id', $currentdepartment) == $department->id ? 'selected' : '' }} data-hs-select-option='{
                                            "description": "{{ $department->trans('description') }}",
                                            "icon": "<i class=\"{{ $department->icon }}\"></i>"
                                        }'>{{ $department->trans('name') }}</option>
                                    @endforeach
                                </select>
                                <div class="absolute top-1/2 end-3 -translate-y-1/2">
                                    <svg class="w-3.5 h-3.5 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m7 15 5 5 5-5"/><path d="m7 9 5-5 5 5"/></svg>
                                </div>
                            </div>
                        </div>

                        <div class="col-span-2">
                            <label for="editor" class="block text-sm font-medium leading-6 text-gray-900 dark:text-gray-400 mt-2">{{ __('global.content') }}</label>
                            <textarea class="editor" name="content">{{ old('content', $content) }}</textarea>
                            @if ($errors->has('content'))
                                @foreach ($errors->get('content') as $error)
                                    <p class="text-red-500 text-sm mt-1">{{ $error }}</p>
                                @endforeach
                            @endif
                        </div>

                        @if (setting('helpdesk_allow_attachments'))
                        <div class="col-span-2">
                            @include('shared/file2', ['name' => 'attachments', 'multiple' => true, 'label' => __('helpdesk.support.attachments'), 'help' => __('helpdesk.support.attachments_help', ['size' => setting('helpdesk_attachments_max_size'), 'types' => formatted_extension_list(setting('helpdesk_attachments_allowed_types'))])])
                        </div>
                        @endif
                    </div>
                    <button type="submit" class="mt-5 inline-flex items-center gap-2 px-5 py-2.5 rounded-lg text-sm font-semibold text-white transition-all hover:-translate-y-px"
                            style="background:linear-gradient(135deg,#7c3aed,#a855f7);box-shadow:0 2px 10px rgba(124,58,237,0.3)">
                        <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
                        {{ __('helpdesk.support.create.send') }}
                    </button>
                </form>
                </div>
            </div>
        </div>
    </div>
@endsection
