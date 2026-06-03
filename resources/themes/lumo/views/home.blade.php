@extends('layouts/front')
@section('title', setting('app_name'))
@section('header_dark')@endsection

@section('content')
@php
    $dm          = is_darkmode();
    $badge       = theme_config('hero_badge', 'Hébergement nouvelle génération');
    $title       = theme_config('hero_title') ?: setting('app_name');
    $subtitle    = theme_config('hero_subtitle', 'Des solutions d\'hébergement haute performance, disponibles 24h/24, avec un support réactif.');
    $ctaPrimText = theme_config('hero_cta_primary_text', 'Voir nos offres');
    $ctaPrimUrl  = theme_config('hero_cta_primary_url') ?: route('front.store.index');
    $ctaSecText  = theme_config('hero_cta_secondary_text', 'Espace client');
    $ctaSecUrl   = theme_config('hero_cta_secondary_url') ?: (auth()->check() ? route('front.client.index') : route('login'));
    $stats = [
        ['value' => theme_config('hero_stat1_value', '99.9%'),    'label' => theme_config('hero_stat1_label', 'Disponibilité')],
        ['value' => theme_config('hero_stat2_value', '24/7'),     'label' => theme_config('hero_stat2_label', 'Support')],
        ['value' => theme_config('hero_stat3_value', 'NVMe'),     'label' => theme_config('hero_stat3_label', 'Stockage')],
        ['value' => theme_config('hero_stat4_value', 'Anti-DDoS'),'label' => theme_config('hero_stat4_label', 'Protection')],
    ];
    $heroImageDb = \App\Models\Admin\Setting::where('name', 'theme_home_image')->value('value');
    $heroImage   = $heroImageDb ? setting('theme_home_image', '') : '';
    $heroBg = $dm
        ? 'background:linear-gradient(135deg,#07001a 0%,#0f0527 45%,#0a0120 100%)'
        : 'background:linear-gradient(155deg,#faf7ff 0%,#f0ebff 45%,#ffffff 100%)';
@endphp

{{-- ============================================================ --}}
{{-- SECTION 1 : HÉRO                                             --}}
{{-- ============================================================ --}}
<section class="relative overflow-hidden" style="min-height:100vh;display:flex;align-items:center;{{ $heroBg }}">

    {{-- Blobs décoratifs --}}
    <div class="absolute inset-0 pointer-events-none overflow-hidden" aria-hidden="true">
        @if($dm)
            <div class="absolute" style="width:650px;height:650px;top:-130px;right:-110px;border-radius:50%;background:radial-gradient(circle,rgba(109,40,217,0.4),transparent 70%);filter:blur(100px)"></div>
            <div class="absolute" style="width:450px;height:450px;bottom:-80px;left:-80px;border-radius:50%;background:radial-gradient(circle,rgba(192,38,211,0.25),transparent 70%);filter:blur(100px)"></div>
            <div class="absolute inset-0" style="background-image:radial-gradient(circle,rgba(255,255,255,0.07) 1px,transparent 1px);background-size:32px 32px"></div>
        @else
            <div class="absolute" style="width:750px;height:550px;top:-200px;right:-180px;border-radius:50%;background:radial-gradient(circle,rgba(167,139,250,0.22),transparent 65%);filter:blur(90px)"></div>
            <div class="absolute" style="width:500px;height:500px;bottom:-100px;left:-100px;border-radius:50%;background:radial-gradient(circle,rgba(232,121,249,0.14),transparent 65%);filter:blur(90px)"></div>
            <div class="absolute inset-0" style="background-image:radial-gradient(circle,rgba(109,40,217,0.08) 1px,transparent 1px);background-size:32px 32px"></div>
        @endif
    </div>

    <div class="relative w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24">
        <div class="grid lg:grid-cols-2 gap-14 lg:gap-20 items-center">

            {{-- GAUCHE --}}
            <div>
                @if($badge)
                <div class="inline-flex items-center gap-2.5 px-4 py-1.5 rounded-full text-sm font-semibold mb-7"
                     style="{{ $dm
                         ? 'background:rgba(139,92,246,0.15);border:1px solid rgba(139,92,246,0.3);color:#c4b5fd'
                         : 'background:rgba(124,58,237,0.08);border:1px solid rgba(124,58,237,0.22);color:#5b21b6' }}">
                    <span class="w-2 h-2 rounded-full flex-shrink-0"
                          style="background:#7c3aed;box-shadow:0 0 8px rgba(124,58,237,0.7)"></span>
                    {{ $badge }}
                </div>
                @endif

                <h1 class="font-black tracking-tight leading-[1.06] mb-6"
                    style="font-size:clamp(2.4rem,5vw,4rem);color:{{ $dm ? '#f8f4ff' : '#0f0a1e' }}">
                    {{ $title }}<br>
                    <span style="background:linear-gradient(130deg,#7c3aed 0%,#a855f7 50%,#c026d3 100%);
                                 -webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text">
                        {{ theme_config('hero_gradient_text', 'Haute Performance') }}
                    </span>
                </h1>

                <p class="leading-relaxed mb-10"
                   style="font-size:1.1rem;max-width:490px;color:{{ $dm ? 'rgba(255,255,255,0.52)' : '#64748b' }}">
                    {{ $subtitle }}
                </p>

                <div class="flex flex-wrap gap-3 mb-12">
                    <a href="{{ $ctaPrimUrl }}"
                       class="group inline-flex items-center gap-2 px-7 py-3.5 rounded-xl font-bold text-sm text-white transition-all duration-200 hover:-translate-y-0.5 hover:shadow-2xl"
                       style="background:linear-gradient(135deg,#7c3aed,#c026d3);box-shadow:0 6px 24px rgba(124,58,237,0.45)">
                        {{ $ctaPrimText }}
                        <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path d="M5 12h14M12 5l7 7-7 7"/>
                        </svg>
                    </a>
                    <a href="{{ $ctaSecUrl }}"
                       class="inline-flex items-center gap-2 px-7 py-3.5 rounded-xl font-bold text-sm transition-all duration-200 hover:-translate-y-0.5"
                       style="{{ $dm
                           ? 'background:rgba(255,255,255,0.06);border:1px solid rgba(255,255,255,0.11);color:#e9d5ff'
                           : 'background:#ffffff;border:1px solid rgba(124,58,237,0.18);color:#374151;box-shadow:0 2px 10px rgba(0,0,0,0.07)' }}">
                        {{ $ctaSecText }}
                    </a>
                </div>

                {{-- Stats --}}
                <div class="flex flex-wrap gap-x-8 gap-y-4 pt-8"
                     style="border-top:1px solid {{ $dm ? 'rgba(255,255,255,0.08)' : '#ede9fe' }}">
                    @foreach($stats as $stat)
                        @if($stat['value'])
                        <div>
                            <div class="text-2xl font-extrabold" style="color:{{ $dm ? '#fff' : '#111827' }}">{{ $stat['value'] }}</div>
                            <div class="text-xs uppercase tracking-widest mt-0.5" style="color:{{ $dm ? 'rgba(255,255,255,0.32)' : '#9ca3af' }}">{{ $stat['label'] }}</div>
                        </div>
                        @endif
                    @endforeach
                </div>
            </div>

            {{-- DROITE : image ou cartes géométriques --}}
            <div class="hidden lg:flex justify-center items-center">
                @if($heroImage)
                <div class="relative w-full max-w-lg">
                    <div class="absolute inset-0" style="border-radius:32px;background:radial-gradient(circle,{{ $dm ? 'rgba(139,92,246,0.3)' : 'rgba(167,139,250,0.18)' }},transparent 70%);filter:blur(40px);transform:scale(1.1)"></div>
                    <img src="{{ $heroImage }}"
                         alt="Hero illustration"
                         class="relative w-full h-auto rounded-3xl object-cover"
                         style="max-height:460px;box-shadow:0 24px 64px rgba(109,40,217,{{ $dm ? '0.45' : '0.22' }})">
                </div>
                @else
                <div class="relative" style="width:420px;height:420px">

                    {{-- Lueur centrale --}}
                    <div class="absolute" style="width:320px;height:320px;top:50%;left:50%;transform:translate(-50%,-50%);background:radial-gradient(circle,{{ $dm ? 'rgba(139,92,246,0.35)' : 'rgba(167,139,250,0.22)' }},transparent 70%);filter:blur(50px)"></div>

                    {{-- Carte 1 — grande, arrière, violet foncé --}}
                    <div class="absolute" style="width:290px;height:190px;top:20px;left:10px;transform:rotate(-7deg);border-radius:28px;background:linear-gradient(135deg,#5b21b6,#7c3aed);box-shadow:0 24px 60px rgba(91,33,182,{{ $dm ? '0.6' : '0.35' }})">
                        <div class="absolute inset-0" style="border-radius:28px;background-image:radial-gradient(rgba(255,255,255,0.07) 1px,transparent 1px);background-size:22px 22px"></div>
                        <div class="absolute" style="width:100px;height:100px;top:-30px;right:-30px;border-radius:50%;background:rgba(255,255,255,0.07)"></div>
                    </div>

                    {{-- Carte 2 — milieu, fuchsia --}}
                    <div class="absolute" style="width:260px;height:170px;top:140px;right:10px;transform:rotate(5deg);border-radius:24px;background:linear-gradient(135deg,#9333ea,#c026d3);box-shadow:0 24px 60px rgba(192,38,211,{{ $dm ? '0.5' : '0.28' }})">
                        <div class="absolute inset-0" style="border-radius:24px;overflow:hidden">
                            <div class="absolute" style="width:140px;height:140px;bottom:-50px;right:-50px;border-radius:50%;background:rgba(255,255,255,0.07)"></div>
                            <div class="absolute" style="width:80px;height:80px;top:-20px;left:-20px;border-radius:50%;background:rgba(255,255,255,0.05)"></div>
                        </div>
                    </div>

                    {{-- Carte 3 — avant, claire --}}
                    <div class="absolute" style="width:190px;height:120px;bottom:50px;left:30px;transform:rotate(-2deg);border-radius:20px;background:{{ $dm ? 'rgba(255,255,255,0.07)' : 'rgba(255,255,255,0.95)' }};border:1px solid {{ $dm ? 'rgba(255,255,255,0.12)' : 'rgba(124,58,237,0.12)' }};box-shadow:0 16px 40px rgba(0,0,0,{{ $dm ? '0.4' : '0.08' }})">
                        <div class="absolute inset-0 p-4 flex flex-col justify-between" style="border-radius:20px">
                            <div style="width:36px;height:36px;border-radius:12px;background:linear-gradient(135deg,#7c3aed,#c026d3)"></div>
                            <div>
                                <div style="width:55%;height:7px;border-radius:4px;background:{{ $dm ? 'rgba(255,255,255,0.18)' : '#e5e7eb' }};margin-bottom:7px"></div>
                                <div style="width:35%;height:7px;border-radius:4px;background:{{ $dm ? 'rgba(255,255,255,0.09)' : '#f3f4f6' }}"></div>
                            </div>
                        </div>
                    </div>

                    {{-- Accents petits --}}
                    <div class="absolute" style="width:52px;height:52px;top:0;right:50px;border-radius:16px;background:linear-gradient(135deg,#c026d3,#e879f9);box-shadow:0 8px 24px rgba(192,38,211,0.45)"></div>
                    <div class="absolute" style="width:36px;height:36px;bottom:70px;right:20px;border-radius:12px;background:linear-gradient(135deg,#7c3aed,#a855f7);box-shadow:0 6px 18px rgba(124,58,237,0.45)"></div>
                    <div class="absolute" style="width:22px;height:22px;top:210px;left:5px;border-radius:8px;background:linear-gradient(135deg,#a855f7,#c026d3);opacity:0.75"></div>
                    <div class="absolute" style="width:14px;height:14px;top:60px;right:20px;border-radius:5px;background:#e879f9;opacity:0.6"></div>

                </div>
                @endif
            </div>

        </div>
    </div>
</section>

{{-- ===== SECTIONS ADMIN (entre hero et contenu fixe) ===== --}}
{!! render_theme_sections() !!}

{{-- ============================================================ --}}
{{-- SECTION 3 : CTA                                              --}}
{{-- ============================================================ --}}
<section class="py-20" style="{{ $dm ? 'background:#06000f' : 'background:#f9fafb' }}">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="relative overflow-hidden rounded-3xl px-8 py-14 lg:px-16 lg:py-20 text-center"
             style="background:linear-gradient(135deg,#6d28d9 0%,#9333ea 50%,#c026d3 100%);
                    box-shadow:0 24px 60px rgba(109,40,217,0.5)">

            {{-- Fond déco --}}
            <div class="absolute inset-0 pointer-events-none" aria-hidden="true">
                <div class="absolute" style="width:400px;height:400px;top:-100px;right:-100px;border-radius:50%;background:rgba(255,255,255,0.06)"></div>
                <div class="absolute" style="width:300px;height:300px;bottom:-80px;left:-60px;border-radius:50%;background:rgba(255,255,255,0.04)"></div>
            </div>

            <div class="relative">
                <h2 class="font-black text-white tracking-tight mb-4"
                    style="font-size:clamp(1.7rem,3.5vw,2.6rem)">
                    Prêt à lancer votre projet ?
                </h2>
                <p class="mb-8 max-w-md mx-auto" style="color:rgba(255,255,255,0.72);font-size:1.05rem">
                    Rejoignez des milliers de clients qui nous font confiance pour leur hébergement.
                </p>
                <div class="flex flex-wrap justify-center gap-3">
                    <a href="{{ $ctaPrimUrl }}"
                       class="group inline-flex items-center gap-2 px-8 py-3.5 rounded-xl font-bold text-sm transition-all duration-200 hover:-translate-y-0.5 hover:shadow-xl"
                       style="background:#ffffff;color:#6d28d9">
                        {{ $ctaPrimText }}
                        <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path d="M5 12h14M12 5l7 7-7 7"/>
                        </svg>
                    </a>
                    <a href="{{ $ctaSecUrl }}"
                       class="inline-flex items-center gap-2 px-8 py-3.5 rounded-xl font-bold text-sm transition-all duration-200 hover:-translate-y-0.5"
                       style="background:rgba(255,255,255,0.12);border:1px solid rgba(255,255,255,0.2);color:#ffffff">
                        {{ $ctaSecText }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
