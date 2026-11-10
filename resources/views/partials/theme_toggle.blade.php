@props([
    'class' => '',
    'id' => 'themeToggleBtn',
    'title' => 'Beralih Mode Siang / Malam'
])

<button type="button" 
        class="sipeter-theme-toggle-btn icon-only {{ $class }}" 
        id="{{ $id }}" 
        data-theme-toggle 
        aria-label="Ganti Mode Tampilan (Siang/Malam)" 
        title="{{ $title }}">
    <i class="theme-icon bi bi-moon-stars-fill"></i>
</button>
