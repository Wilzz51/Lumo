{{-- ===== TEXTES DU HÉRO ===== --}}
<div>
    <p class="text-xs font-semibold uppercase tracking-widest text-gray-500 dark:text-gray-400 mb-3">Textes du héro</p>
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div>@include('admin/shared/input', ['name' => 'hero_badge', 'label' => 'Badge', 'type' => 'text', 'value' => theme_config('hero_badge', ''), 'placeholder' => 'Hébergement nouvelle génération'])</div>
        <div>@include('admin/shared/input', ['name' => 'hero_title', 'label' => 'Titre', 'type' => 'text', 'value' => theme_config('hero_title', ''), 'placeholder' => setting('app_name')])</div>
        <div style="grid-column:span 2">@include('admin/shared/input', ['name' => 'hero_subtitle', 'label' => 'Sous-titre', 'type' => 'text', 'value' => theme_config('hero_subtitle', ''), 'placeholder' => 'Des solutions d\'hébergement haute performance...'])</div>
    </div>
</div>

{{-- ===== BOUTONS D'ACTION ===== --}}
<div class="mt-6 border-t border-gray-200 dark:border-gray-700 pt-4">
    <p class="text-xs font-semibold uppercase tracking-widest text-gray-500 dark:text-gray-400 mb-3">Boutons d'action</p>
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div>@include('admin/shared/input', ['name' => 'hero_cta_primary_text', 'label' => 'Bouton principal — texte', 'type' => 'text', 'value' => theme_config('hero_cta_primary_text', ''), 'placeholder' => 'Voir nos offres'])</div>
        <div>@include('admin/shared/input', ['name' => 'hero_cta_primary_url', 'label' => 'Bouton principal — URL', 'type' => 'text', 'value' => theme_config('hero_cta_primary_url', ''), 'placeholder' => '/store'])</div>
        <div>@include('admin/shared/input', ['name' => 'hero_cta_secondary_text', 'label' => 'Bouton secondaire — texte', 'type' => 'text', 'value' => theme_config('hero_cta_secondary_text', ''), 'placeholder' => 'Espace client'])</div>
        <div>@include('admin/shared/input', ['name' => 'hero_cta_secondary_url', 'label' => 'Bouton secondaire — URL', 'type' => 'text', 'value' => theme_config('hero_cta_secondary_url', ''), 'placeholder' => '/client'])</div>
    </div>
</div>

{{-- ===== STATISTIQUES ===== --}}
<div class="mt-6 border-t border-gray-200 dark:border-gray-700 pt-4">
    <p class="text-xs font-semibold uppercase tracking-widest text-gray-500 dark:text-gray-400 mb-3">Statistiques</p>
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
        <div>@include('admin/shared/input', ['name' => 'hero_stat1_value', 'label' => 'Valeur 1', 'type' => 'text', 'value' => theme_config('hero_stat1_value', '99.9%')])</div>
        <div>@include('admin/shared/input', ['name' => 'hero_stat1_label', 'label' => 'Label 1',  'type' => 'text', 'value' => theme_config('hero_stat1_label', 'Disponibilité')])</div>
        <div>@include('admin/shared/input', ['name' => 'hero_stat2_value', 'label' => 'Valeur 2', 'type' => 'text', 'value' => theme_config('hero_stat2_value', '24/7')])</div>
        <div>@include('admin/shared/input', ['name' => 'hero_stat2_label', 'label' => 'Label 2',  'type' => 'text', 'value' => theme_config('hero_stat2_label', 'Support')])</div>
        <div>@include('admin/shared/input', ['name' => 'hero_stat3_value', 'label' => 'Valeur 3', 'type' => 'text', 'value' => theme_config('hero_stat3_value', 'NVMe')])</div>
        <div>@include('admin/shared/input', ['name' => 'hero_stat3_label', 'label' => 'Label 3',  'type' => 'text', 'value' => theme_config('hero_stat3_label', 'Stockage')])</div>
        <div>@include('admin/shared/input', ['name' => 'hero_stat4_value', 'label' => 'Valeur 4', 'type' => 'text', 'value' => theme_config('hero_stat4_value', 'Anti-DDoS')])</div>
        <div>@include('admin/shared/input', ['name' => 'hero_stat4_label', 'label' => 'Label 4',  'type' => 'text', 'value' => theme_config('hero_stat4_label', 'Protection')])</div>
    </div>
</div>
