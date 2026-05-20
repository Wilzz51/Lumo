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
@section('title', __('errors.404.title'))
@section('header_dark')@endsection
@section('content')
@php($dm = is_darkmode())

<section class="relative overflow-hidden flex items-center justify-center" style="min-height:calc(100vh - 80px);{{ $dm ? 'background:linear-gradient(135deg,#07001a 0%,#0f0527 45%,#0a0120 100%)' : 'background:linear-gradient(155deg,#faf7ff 0%,#f0ebff 45%,#ffffff 100%)' }}">

    {{-- Blobs décoratifs --}}
    <div class="absolute inset-0 pointer-events-none overflow-hidden" aria-hidden="true">
        @if($dm)
            <div class="absolute" style="width:600px;height:600px;top:-150px;right:-100px;border-radius:50%;background:radial-gradient(circle,rgba(109,40,217,0.35),transparent 70%);filter:blur(100px)"></div>
            <div class="absolute" style="width:400px;height:400px;bottom:-100px;left:-80px;border-radius:50%;background:radial-gradient(circle,rgba(192,38,211,0.2),transparent 70%);filter:blur(100px)"></div>
            <div class="absolute inset-0" style="background-image:radial-gradient(circle,rgba(255,255,255,0.07) 1px,transparent 1px);background-size:32px 32px"></div>
        @else
            <div class="absolute" style="width:700px;height:500px;top:-200px;right:-150px;border-radius:50%;background:radial-gradient(circle,rgba(167,139,250,0.2),transparent 65%);filter:blur(90px)"></div>
            <div class="absolute" style="width:450px;height:450px;bottom:-100px;left:-100px;border-radius:50%;background:radial-gradient(circle,rgba(232,121,249,0.12),transparent 65%);filter:blur(90px)"></div>
            <div class="absolute inset-0" style="background-image:radial-gradient(circle,rgba(109,40,217,0.07) 1px,transparent 1px);background-size:32px 32px"></div>
        @endif
    </div>

    <div class="relative text-center px-4">

        {{-- Numéro 404 --}}
        <div class="relative inline-block mb-6">
            <span class="text-[160px] sm:text-[220px] font-black leading-none select-none"
                  style="background:linear-gradient(135deg,#7c3aed,#a855f7,#c026d3);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;filter:drop-shadow(0 0 60px rgba(124,58,237,0.4))">
                404
            </span>
            {{-- Glow derrière le chiffre --}}
            <div class="absolute inset-0 pointer-events-none" style="background:radial-gradient(circle,rgba(124,58,237,0.15) 0%,transparent 70%);filter:blur(30px)"></div>
        </div>

        {{-- Titre --}}
        <h1 class="text-2xl sm:text-3xl font-bold mb-3 {{ $dm ? 'text-white' : 'text-gray-900' }}">
            {{ __('errors.404.title') }}
        </h1>

        {{-- Description --}}
        <p class="text-base mb-10 max-w-md mx-auto {{ $dm ? 'text-gray-400' : 'text-gray-500' }}">
            {{ __('errors.404.description') }}
        </p>

        {{-- Boutons --}}
        <div class="flex flex-wrap items-center justify-center gap-3">
            <a href="{{ route('home') }}"
               class="inline-flex items-center gap-2 px-6 py-3 rounded-xl text-sm font-semibold text-white transition-all duration-200 hover:-translate-y-0.5"
               style="background:linear-gradient(135deg,#6d28d9,#9333ea,#c026d3);box-shadow:0 4px 20px rgba(109,40,217,0.4)">
                <i class="bi bi-house-door"></i>
                {{ __('errors.404.home') }}
            </a>
            <a href="{{ URL::previous() }}"
               class="inline-flex items-center gap-2 px-6 py-3 rounded-xl text-sm font-semibold transition-all duration-200 hover:-translate-y-0.5 {{ $dm ? 'bg-white/10 text-white border border-white/20 hover:bg-white/15' : 'bg-white text-gray-700 border border-gray-200 hover:border-violet-300 hover:text-violet-700 shadow-sm' }}">
                <i class="bi bi-arrow-left"></i>
                {{ __('errors.404.back') }}
            </a>
        </div>
    </div>
</section>

@endsection
