<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-100 leading-tight flex items-center gap-2">
            <i class="bi bi-briefcase-fill text-emerald-400"></i>
            {{ __('Admin - Job Portal') }}
        </h2>
    </x-slot>

    <div class="py-10 bg-gray-900 min-h-screen">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            {{ $slot }}
        </div>
    </div>
</x-app-layout>
