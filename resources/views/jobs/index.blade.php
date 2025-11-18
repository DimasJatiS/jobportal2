<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-100 leading-tight flex items-center gap-2">
            <i class="bi bi-briefcase-fill text-emerald-400"></i>
            {{ __('Daftar Lowongan') }}
        </h2>
    </x-slot>

    <div class="py-10 bg-gray-900 min-h-screen">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">

            {{-- Header dan tombol tambah --}}
            <div class="flex justify-between items-center mb-6">
                <h4 class="text-lg font-semibold text-emerald-400 flex items-center gap-2">
                    <i class="bi bi-list-task"></i> Kelola Lowongan
                </h4>

                @if(auth()->check() && auth()->user()->role === 'admin')
                    <a href="{{ route('admin.jobs.create') }}"
                       class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-500 text-white font-semibold px-4 py-2 rounded-md transition">
                        <i class="bi bi-plus-lg"></i> Tambah Lowongan
                    </a>
                @endif
            </div>

            {{-- Daftar lowongan --}}
            @if($jobs->count())
                <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach($jobs as $job)
                        <div class="bg-gray-800 rounded-xl shadow-md border border-gray-700 hover:shadow-lg hover:-translate-y-1 transition duration-300">

                            {{-- Logo perusahaan --}}
                            <div class="relative h-44 bg-gray-700 overflow-hidden rounded-t-xl">
                                @if($job->logo)
                                    <img src="{{ asset('storage/' . $job->logo) }}"
                                         alt="{{ $job->company }}"
                                         class="object-contain w-full h-full transition-transform duration-300 hover:scale-105">
                                @else
                                    <div class="flex items-center justify-center h-full text-gray-400 text-sm">
                                        No Logo
                                    </div>
                                @endif
                            </div>

                            {{-- Informasi lowongan --}}
                            <div class="p-5 text-gray-200">
                                <h3 class="text-lg font-semibold mb-1 text-emerald-400">{{ $job->title }}</h3>
                                <p class="text-sm flex items-center gap-2 text-gray-400 mb-1">
                                    <i class="bi bi-building"></i> {{ $job->company }}
                                </p>
                                <p class="text-sm flex items-center gap-2 text-gray-400 mb-1">
                                    <i class="bi bi-geo-alt"></i> {{ $job->location }}
                                </p>
                                <p class="text-sm flex items-center gap-2 text-emerald-400 font-semibold mb-1">
                                    <i class="bi bi-cash-stack"></i> Rp {{ number_format($job->salary ?? 0, 0, ',', '.') }}
                                </p>
                                <p class="text-sm flex items-center gap-2 text-gray-400">
                                    <i class="bi bi-briefcase"></i> {{ $job->type }}
                                </p>
                            </div>

                            {{-- Tombol Aksi --}}
                            <div class="px-5 pb-4 pt-2 border-t border-gray-700 flex justify-between items-center">
                                <a href="{{ route('jobs.show', $job->id) }}"
                                   class="inline-flex items-center gap-1 text-sm font-medium text-emerald-400 hover:text-emerald-300 transition">
                                    <i class="bi bi-eye"></i> Lihat
                                </a>

                                @if(auth()->check() && auth()->user()->role === 'admin')
                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('admin.jobs.edit', $job->id) }}"
                                           class="text-yellow-400 hover:text-yellow-300 text-sm">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <form action="{{ route('admin.jobs.destroy', $job->id) }}"
                                              method="POST"
                                              onsubmit="return confirm('Yakin ingin menghapus lowongan ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:text-red-400 text-sm">
                                                <i class="bi bi-trash3"></i>
                                            </button>
                                        </form>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Pagination --}}
                <div class="mt-8 text-center text-gray-400">
                    {{ $jobs->links() }}
                </div>
            @else
                <div class="bg-gray-800 text-gray-300 p-8 rounded-xl text-center shadow-md">
                    <i class="bi bi-emoji-frown text-3xl text-gray-400 mb-2"></i>
                    <p>Belum ada lowongan yang tersedia.</p>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
