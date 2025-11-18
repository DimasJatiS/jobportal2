<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-100 leading-tight flex items-center gap-2">
            <i class="bi bi-briefcase-fill text-emerald-400"></i>
            {{ __('Daftar Lowongan') }}
        </h2>
    </x-slot>

    <div class="py-10 bg-gray-900 min-h-screen">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            @if($jobs->count())
                <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach($jobs as $job)
                        <div class="group bg-gray-800 rounded-xl shadow-md border border-gray-700 hover:shadow-lg transition duration-300 hover:-translate-y-1">
                            <!-- Logo -->
                            <div class="relative h-48 bg-gray-700 overflow-hidden rounded-t-xl">
                                @if($job->logo)
                                    <img src="{{ asset('storage/' . $job->logo) }}" alt="{{ $job->company }}"
                                        class="object-contain w-full h-full transition-transform duration-300 group-hover:scale-105">
                                @else
                                    <div class="flex items-center justify-center h-full text-gray-400 text-sm">
                                        Tidak ada logo
                                    </div>
                                @endif
                            </div>

                            <!-- Body -->
                            <div class="p-5 text-gray-200">
                                <h3 class="text-lg font-semibold mb-1 group-hover:text-emerald-400 transition">
                                    {{ strtoupper($job->title) }}
                                </h3>
                                <p class="text-sm flex items-center gap-2 text-gray-400 mb-1">
                                    <i class="bi bi-building"></i> {{ $job->company }}
                                </p>
                                <p class="text-sm flex items-center gap-2 text-gray-400 mb-1">
                                    <i class="bi bi-geo-alt"></i> {{ $job->location }}
                                </p>
                                <p class="text-sm flex items-center gap-2 text-emerald-400 font-semibold mb-1">
                                    <i class="bi bi-cash-stack"></i>
                                    Rp {{ number_format($job->salary ?? 0, 0, ',', '.') }}
                                </p>
                                <p class="text-sm flex items-center gap-2 text-gray-400">
                                    <i class="bi bi-briefcase"></i> {{ $job->type }}
                                </p>
                            </div>

                            <!-- Footer -->
                            <div class="px-5 pb-4 pt-2 border-t border-gray-700 flex justify-between items-center">
                                <a href="{{ route('jobs.show', $job->id) }}"
                                   class="inline-flex items-center gap-1 text-sm font-medium text-emerald-400 hover:text-emerald-300 transition">
                                    <i class="bi bi-eye"></i> Lihat
                                    
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-8 text-center">
                    {{ $jobs->links() }}
                </div>
            @else
                <div class="bg-gray-800 text-gray-300 p-8 rounded-xl text-center shadow-md">
                    <i class="bi bi-emoji-frown text-3xl text-gray-400 mb-2"></i>
                    <p>Belum ada lowongan yang tersedia saat ini.</p>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
