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
@section('title', $ticket->subject)
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
            <div class="min-w-0 flex-1">
                <p class="text-violet-200 text-xs font-medium uppercase tracking-widest mb-0.5">{{ __('helpdesk.support.index') }}</p>
                <h1 class="text-xl font-bold text-white truncate">{{ $ticket->subject }}</h1>
            </div>
            <div class="flex-shrink-0">
                <x-badge-state state="{{ $ticket->status }}"></x-badge-state>
            </div>
        </div>
    </div>

    <div class="max-w-[85rem] py-6 lg:py-8 mx-auto px-4 sm:px-6 lg:px-8">
        @include('shared/alerts')
        <div class="flex flex-col lg:flex-row gap-6 items-start">

            {{-- Main: messages + reply --}}
            <div class="min-w-0 flex-1">
                <div class="card">
                    <div class="card-heading mb-4">
                        <div>
                            <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">{{ $ticket->subject }}</h2>
                            <p class="text-sm text-gray-600 dark:text-gray-400">{{ __('helpdesk.support.show.index_description') }}</p>
                        </div>
                    </div>

                    {{-- Messages timeline --}}
                    <div class="space-y-1">
                        @foreach ($ticket->messages->groupBy(fn($msg) => $msg->created_at->translatedFormat('d M, Y')) as $date => $messages)
                            <div class="ps-2 my-3 first:mt-0">
                                <h3 class="text-xs font-semibold uppercase tracking-wide text-gray-400 dark:text-gray-500">{{ $date }}</h3>
                            </div>

                            @foreach ($messages as $i => $message)
                            <div class="flex gap-x-3 relative group rounded-xl hover:bg-gray-50 dark:hover:bg-gray-700/30 px-2 py-1 transition-colors duration-150">
                                {{-- Avatar --}}
                                <div class="relative last:after:hidden after:absolute after:top-10 after:bottom-0 after:start-5 after:w-px after:-translate-x-[0.5px] after:bg-gray-200 dark:after:bg-gray-700">
                                    <div class="relative z-10 size-10 flex justify-center items-center">
                                        <span class="flex shrink-0 justify-center items-center size-10 rounded-full border border-gray-200 dark:border-gray-700 text-sm font-semibold
                                            {{ $message->isStaff() ? 'bg-violet-100 dark:bg-violet-900/30 text-violet-600 dark:text-violet-400' : 'bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400' }}">
                                            <i class="bi bi-{{ $message->isStaff() ? 'person-badge' : 'person' }} text-base"></i>
                                        </span>
                                    </div>
                                </div>

                                {{-- Content --}}
                                <div class="grow py-2 pb-3">
                                    <div class="flex justify-between items-start gap-2">
                                        <h3 class="font-semibold text-gray-800 dark:text-white text-sm">
                                            {!! $message->replyText($i, 'customer') !!}
                                        </h3>
                                        @if($message->isCustomer() && $message->canEdit())
                                            <button class="hs-collapse-toggle text-gray-400 hover:text-violet-600 dark:hover:text-violet-400 transition-colors p-1 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 flex-shrink-0" data-hs-collapse="#edit-message-{{ $message->id }}">
                                                <i class="bi bi-pen text-sm"></i>
                                            </button>
                                        @endif
                                    </div>
                                    <div class="mt-1 break-words">
                                        <div class="text-sm text-gray-600 dark:text-gray-400 prose dark:prose-invert prose-sm max-w-none">
                                            {!! $message->formattedMessage() !!}
                                        </div>
                                    </div>

                                    @if ($message->hasAttachments($ticket->attachments))
                                        <div class="mt-2 flex flex-wrap gap-2">
                                            @foreach ($message->getAttachments($ticket->attachments) as $attachment)
                                                <a href="{{ route('front.support.download', ['ticket' => $ticket, 'attachment' => $attachment]) }}" class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-violet-50 dark:bg-violet-900/20 text-violet-700 dark:text-violet-300 text-xs font-medium hover:bg-violet-100 dark:hover:bg-violet-900/40 transition-colors">
                                                    <i class="bi bi-file-earmark"></i>
                                                    {{ Str::limit($attachment->filename, 25) }}
                                                </a>
                                            @endforeach
                                        </div>
                                    @endif

                                    <div class="mt-1.5 flex items-center gap-x-2 text-xs text-gray-400 dark:text-gray-500">
                                        @if ($message->isStaff())
                                            <span class="inline-flex items-center gap-x-1">
                                                <i class="bi bi-person-circle"></i> {{ $message->staffUsername() }}
                                            </span>
                                        @elseif($message->isCustomer())
                                            <span class="inline-flex items-center gap-x-1">
                                                <i class="bi bi-person"></i> {{ $message->customer->excerptFullName() }}
                                            </span>
                                        @endif
                                        <span>· {{ $message->edited_at ? __('helpdesk.support.show.edited_at', ['date' => $message->edited_at->format('H:i')]) : $message->created_at->format('H:i') }}</span>
                                    </div>
                                </div>
                            </div>

                            @if($message->isCustomer() && $message->canEdit())
                                <div class="hs-collapse hidden pl-12" id="edit-message-{{ $message->id }}">
                                    <div class="p-3 bg-gray-50 dark:bg-gray-700/30 rounded-xl border border-gray-200 dark:border-gray-700 mb-2">
                                        <form method="POST" action="{{ route('front.support.messages.update', ['ticket' => $ticket, 'message' => $message]) }}">
                                            @csrf
                                            <textarea class="editor" name="content">{{ $message->message }}</textarea>
                                            <button class="btn-primary mt-2 text-sm py-1.5">{{ __('global.save') }}</button>
                                        </form>
                                        <form method="POST" action="{{ route('front.support.messages.destroy', ['ticket' => $ticket, 'message' => $message]) }}" class="mt-1">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn-danger text-sm py-1.5">{{ __('global.delete') }}</button>
                                        </form>
                                    </div>
                                </div>
                            @endif
                            @endforeach
                        @endforeach
                    </div>

                    {{-- Reply or closed notice --}}
                    @if ($ticket->isOpen())
                        <div class="mt-6 pt-6 border-t border-gray-100 dark:border-gray-700">
                            <h3 class="text-base font-semibold text-gray-800 dark:text-gray-200 mb-3">{{ __('helpdesk.support.show.replyinticket') }}</h3>
                            <form method="POST" action="{{ route('front.support.reply', ['ticket' => $ticket]) }}" enctype="multipart/form-data">
                                @csrf
                                <textarea class="editor" name="content">{{ old('content') }}</textarea>
                                @if ($errors->has('content'))
                                    @foreach ($errors->get('content') as $error)
                                        <p class="text-red-500 text-sm mt-1">{{ $error }}</p>
                                    @endforeach
                                @endif
                                @if (setting('helpdesk_allow_attachments'))
                                    <div class="mt-3">
                                        @include('shared/file2', ['name' => 'attachments', 'label' => __('helpdesk.support.attachments'), 'help' => __('helpdesk.support.attachments_help', ['size' => setting('helpdesk_attachments_max_size'), 'types' => formatted_extension_list(setting('helpdesk_attachments_allowed_types'))])])
                                    </div>
                                @endif
                                <div class="flex gap-2 mt-3">
                                    <button class="btn-primary">{{ __('helpdesk.support.show.reply') }}</button>
                                    <button class="btn-secondary" name="close">{{ __('helpdesk.support.show.replyandclose') }}</button>
                                </div>
                            </form>
                        </div>
                    @else
                        <div class="mt-6 flex items-start gap-3 p-4 bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800 rounded-xl">
                            <svg class="w-5 h-5 text-amber-500 flex-shrink-0 mt-0.5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                            <p class="text-sm text-amber-800 dark:text-amber-200">
                                {{ $ticket->close_reason ? __('helpdesk.support.show.closed2', ['reason' => $ticket->close_reason]) : __('helpdesk.support.show.closed3') }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Sidebar --}}
            <div class="w-full lg:w-72 flex-shrink-0 flex flex-col gap-3">

                {{-- Users involved --}}
                @if (!empty($ticket->attachedUsers()))
                <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm p-4">
                    <p class="text-xs font-semibold uppercase tracking-wider text-gray-400 dark:text-gray-500 mb-3">Participants</p>
                    <div class="flex -space-x-2">
                        @foreach ($ticket->attachedUsers() as $initials => $username)
                        <div class="hs-tooltip inline-block">
                            <span class="hs-tooltip-toggle relative inline-flex items-center justify-center h-9 w-9 rounded-full bg-gradient-to-br from-violet-500 to-fuchsia-600 text-white text-sm font-semibold border-2 border-white dark:border-gray-800 shadow-sm">
                                {{ $initials }}
                            </span>
                            <span class="hs-tooltip-content hs-tooltip-shown:opacity-100 hs-tooltip-shown:visible opacity-0 hidden absolute z-20 py-1.5 px-2.5 bg-gray-900 text-xs text-white rounded-lg dark:bg-gray-700" role="tooltip">
                                {{ $username }}
                            </span>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                {{-- Ticket info --}}
                <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm overflow-hidden">
                    <div class="px-4 py-3 border-b border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-700/50">
                        <p class="text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">Informations</p>
                    </div>
                    <div class="divide-y divide-gray-100 dark:divide-gray-700">
                        <div class="flex items-center gap-3 px-4 py-3">
                            <i class="bi bi-buildings text-gray-400 dark:text-gray-500 w-4 text-center"></i>
                            <div>
                                <p class="text-xs text-gray-400 dark:text-gray-500">{{ __('helpdesk.department') }}</p>
                                <p class="text-sm font-medium text-gray-800 dark:text-gray-200">{{ $ticket->department->name }}</p>
                            </div>
                        </div>
                        @if ($ticket->isValidRelated())
                        <div class="flex items-center gap-3 px-4 py-3">
                            <i class="bi bi-box text-gray-400 dark:text-gray-500 w-4 text-center"></i>
                            <div>
                                <p class="text-xs text-gray-400 dark:text-gray-500">Service</p>
                                <p class="text-sm font-medium text-gray-800 dark:text-gray-200">{{ $ticket->related->relatedName() }}</p>
                            </div>
                        </div>
                        @endif
                        <div class="flex items-center gap-3 px-4 py-3">
                            <i class="bi bi-flag text-gray-400 dark:text-gray-500 w-4 text-center"></i>
                            <div>
                                <p class="text-xs text-gray-400 dark:text-gray-500">{{ __('helpdesk.priority') }}</p>
                                <x-badge-state state="{{ $ticket->priority }}"></x-badge-state>
                            </div>
                        </div>
                        <div class="flex items-center gap-3 px-4 py-3">
                            <i class="bi bi-calendar-date text-gray-400 dark:text-gray-500 w-4 text-center"></i>
                            <div>
                                <p class="text-xs text-gray-400 dark:text-gray-500">{{ __('global.created') }}</p>
                                <p class="text-sm font-medium text-gray-800 dark:text-gray-200">{{ $ticket->created_at->format('d/m/y H:i') }}</p>
                            </div>
                        </div>
                        @if ($ticket->closed_at)
                        <div class="flex items-center gap-3 px-4 py-3">
                            <i class="bi bi-x-square text-gray-400 dark:text-gray-500 w-4 text-center"></i>
                            <div>
                                <p class="text-xs text-gray-400 dark:text-gray-500">{{ __('helpdesk.support.show.closed_on', ['date' => '']) }}</p>
                                <p class="text-sm font-medium text-gray-800 dark:text-gray-200">{{ $ticket->closed_at->format('d/m/y H:i') }}</p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                {{-- Attachments --}}
                @if ($ticket->attachments->isNotEmpty())
                <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm overflow-hidden">
                    <div class="px-4 py-3 border-b border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-700/50">
                        <p class="text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">{{ __('helpdesk.support.attachments') }}</p>
                    </div>
                    <div class="divide-y divide-gray-100 dark:divide-gray-700">
                        @foreach ($ticket->attachments as $attachment)
                        <div class="flex items-center justify-between px-4 py-2.5 gap-2">
                            <span class="text-sm text-gray-700 dark:text-gray-300 truncate flex-1">{{ Str::limit($attachment->filename, 22) }}</span>
                            <a href="{{ route('front.support.download', ['ticket' => $ticket, 'attachment' => $attachment]) }}" class="text-violet-600 dark:text-violet-400 hover:text-violet-800 dark:hover:text-violet-300 flex-shrink-0 transition-colors">
                                <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" x2="12" y1="15" y2="3"/></svg>
                            </a>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                {{-- Close / Reopen --}}
                @if ($ticket->isOpen())
                <form method="POST" action="{{ route('front.support.close', ['ticket' => $ticket]) }}">
                    @csrf
                    @method('DELETE')
                    <button class="btn-secondary w-full" type="submit">{{ __('helpdesk.support.show.close') }}</button>
                </form>
                @else
                <form method="POST" action="{{ route('front.support.reopen', ['ticket' => $ticket]) }}">
                    @csrf
                    <button class="btn-primary w-full" type="submit">{{ __('helpdesk.support.show.reopen') }}</button>
                </form>
                @endif

            </div>
        </div>
    </div>
@endsection
