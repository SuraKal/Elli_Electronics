@props(['on', 'message' => 'Action Completed', 'timeout' => '2000', 'type' => 'success'])

<div x-data="{ shown: false, timeout: null }" @click.stop x-init="@this.on('{{ $on }}', () => { 
         clearTimeout(timeout); 
         shown = true; 
         timeout = setTimeout(() => { shown = false }, {{ $timeout }}); 
     })" x-show="shown" x-transition:enter="transition ease-out duration-500 transform"
    x-transition:enter-start="translate-x-full opacity-0" x-transition:enter-end="translate-x-0 opacity-100"
    x-transition:leave="transition ease-in duration-500 transform" x-transition:leave-start="translate-x-0 opacity-100"
    x-transition:leave-end="translate-x-full opacity-0" style="display: none;"
    {{ $attributes->merge(['class' => 'rounded-xl border border-gray-100 bg-white p-4 shadow-md']) }}>

    <div class="flex items-start gap-4">
        @if($type == 'success')
        <span class="text-green-600">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </span>
        @elseif($type == 'failure')
            <span class="text-red-600">
<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
    stroke="red" class="size-6">
    <circle cx="12" cy="12" r="10" stroke="red" stroke-width="2" fill="none" />
    <path stroke-linecap="round" stroke-linejoin="round"
        d="M6 18L18 6M6 6l12 12" />
</svg>


            </span>
        @endif

        <div class="flex-1">
            <strong class="block font-medium text-gray-900"> {{ $message }} </strong>
        </div>

        <button class="text-gray-500 transition hover:text-gray-600" @click="shown = false">
            <span class="sr-only">Dismiss popup</span>
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>
</div>
