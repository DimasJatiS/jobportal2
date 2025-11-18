<x-app-layout>
    <x-slot name="header">
        {{ $header ?? '' }}
    </x-slot>

    <div class="py-10 bg-gray-900 min-h-screen">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            {{ $slot }}
        </div>
    </div>
</x-app-layout>
