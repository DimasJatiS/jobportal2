<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-200 leading-tight">
            Dashboard Admin
        </h2>
    </x-slot>

    <div class="py-10 bg-gray-900 min-h-screen">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <div class="bg-gray-800 p-6 rounded-xl shadow text-gray-200">
                    <h3 class="text-lg font-semibold text-emerald-400">Total Lowongan</h3>
                    <p class="text-3xl font-bold mt-2">{{ $stats['total_jobs'] }}</p>
                </div>

                <div class="bg-gray-800 p-6 rounded-xl shadow text-gray-200">
                    <h3 class="text-lg font-semibold text-emerald-400">Total Lamaran</h3>
                    <p class="text-3xl font-bold mt-2">{{ $stats['total_applications'] }}</p>
                </div>

                <div class="bg-gray-800 p-6 rounded-xl shadow text-gray-200">
                    <h3 class="text-lg font-semibold text-yellow-400">Pending</h3>
                    <p class="text-3xl font-bold mt-2">{{ $stats['pending'] }}</p>
                </div>

                <div class="bg-gray-800 p-6 rounded-xl shadow text-gray-200">
                    <h3 class="text-lg font-semibold text-green-400">Diterima</h3>
                    <p class="text-3xl font-bold mt-2">{{ $stats['accepted'] }}</p>
                </div>

            </div>

        </div>
    </div>
</x-app-layout>
