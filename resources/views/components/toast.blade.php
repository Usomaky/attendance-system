<div x-data="{ show: false }" x-show="show" x-init="@this.on('error', () => { show = true;
    setTimeout(() => show = false, 3000); })" x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 transform scale-90" x-transition:enter-end="opacity-100 transform scale-100"
    x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100 transform scale-100"
    x-transition:leave-end="opacity-0 transform scale-90"
    class="fixed top-0 right-0 mt-4 mr-4 bg-red-500 text-white p-3 rounded shadow-lg" style="display: none;"
    role="alert">
    <div class="flex items-center">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
            xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M18.364 5.636l-12.728 12.728M5.636 5.636l12.728 12.728"></path>
        </svg>
        <span>{{ $message }}</span>
    </div>
</div>
