<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-100 leading-tight flex items-center gap-2">
            <i class="bi bi-briefcase-fill text-emerald-400"></i>
            {{ __('Detail Lowongan') }}
        </h2>
    </x-slot>

    <div class="bg-gray-900 min-h-screen py-10">
        <div class="max-w-5xl mx-auto bg-gray-800 rounded-xl shadow-lg overflow-hidden text-gray-100 p-8">

            {{-- Header Perusahaan --}}
            <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8">
                <div class="flex items-center gap-4">
                    @if($job->logo)
                        <img src="{{ asset('storage/' . $job->logo) }}"
                             alt="{{ $job->company }}"
                             class="h-20 w-20 rounded-md object-contain border border-gray-700 bg-gray-700 p-2">
                    @else
                        <div class="h-20 w-20 flex items-center justify-center bg-gray-700 text-gray-400 text-sm rounded-md border border-gray-600">
                            No Logo
                        </div>
                    @endif
                    <div>
                        <h1 class="text-2xl font-bold text-emerald-400 mb-1">{{ strtoupper($job->title) }}</h1>
                        <p class="text-gray-300 flex items-center gap-2 mb-1">
                            <i class="bi bi-building"></i> {{ $job->company }}
                        </p>
                        <p class="text-gray-400 flex items-center gap-2">
                            <i class="bi bi-geo-alt"></i> {{ $job->location }}
                        </p>
                    </div>
                </div>

                <div class="mt-4 md:mt-0 text-right">
                    <p class="text-emerald-400 text-lg font-semibold mb-1">
                        <i class="bi bi-cash-stack"></i>
                        Rp {{ number_format($job->salary ?? 0, 0, ',', '.') }}
                    </p>
                    <p class="text-gray-400">
                        <i class="bi bi-briefcase"></i> {{ $job->type }}
                    </p>
                </div>
            </div>

            {{-- Garis pemisah --}}
            <div class="border-t border-gray-700 my-6"></div>

            {{-- Deskripsi Pekerjaan --}}
            <div class="leading-relaxed text-gray-300 mb-10">
                <h3 class="text-lg font-semibold text-emerald-400 mb-3">
                    <i class="bi bi-info-circle"></i> Deskripsi Pekerjaan
                </h3>
                <p class="whitespace-pre-line">{{ $job->description }}</p>
            </div>

            {{-- Tombol Upload CV --}}
            @if(auth()->check() && auth()->user()->role === 'user')
                <div class="border-t border-gray-700 pt-6">
                    <h3 class="text-lg font-semibold text-emerald-400 mb-4 flex items-center gap-2">
                        <i class="bi bi-file-earmark-arrow-up"></i> Lamar Pekerjaan Ini
                    </h3>
                    <form action="{{ route('apply.store', $job->id) }}" method="POST" enctype="multipart/form-data"
                          class="flex flex-col sm:flex-row gap-4 items-start sm:items-center">
                        @csrf
                        <div class="flex flex-col gap-1">
                            <label class="text-sm text-gray-400">Unggah CV (PDF, maks 2MB)</label>
                            <input type="file" name="cv" accept=".pdf" required
                                   class="text-sm text-gray-200 bg-gray-700 border border-gray-600 rounded-md px-3 py-2 cursor-pointer focus:ring-emerald-400 focus:outline-none">
                        </div>
                        <button type="submit"
                                class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-500 text-white px-5 py-2.5 rounded-md text-sm font-medium transition">
                            <i class="bi bi-send-fill"></i> Kirim Lamaran
                        </button>
                    </form>
                </div>
            @else
                <div class="border-t border-gray-700 pt-6 text-gray-400 text-sm">
                    <i class="bi bi-lock-fill"></i> Login sebagai <span class="text-emerald-400">Pelamar</span> untuk melamar pekerjaan ini.
                </div>
            @endif

            {{-- Tombol Kembali --}}
            <div class="mt-10">
                <a href="{{ route('jobs.index') }}"
                   class="inline-flex items-center gap-2 text-sm text-gray-300 hover:text-emerald-400 transition">
                    <i class="bi bi-arrow-left"></i> Kembali ke daftar lowongan
                </a>

                {{-- Tombol Edit Lowongan (hanya untuk admin) (Kanan) --}}
                <div class="float-right">

                    @if(auth()->check() && auth()->user()->role === 'admin')
                        <a href="{{ route('admin.jobs.edit', $job->id) }}"
                        class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-500 text-white px-4 py-2 rounded-lg text-sm font-medium transition">
                            <i class="bi bi-pencil-square"></i> Edit Lowongan
                        </a>
                    @endif

            </div>
        </div>
    </div>
</x-app-layout>
