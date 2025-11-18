<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-100 leading-tight">
            Riwayat Lamaran Saya
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-gray-800 shadow-md rounded-2xl p-8">

                <h3 class="text-emerald-400 text-lg font-semibold mb-6">
                    Lamaran yang Saya Ajukan
                </h3>

                @if ($applications->count())
                    <div class="space-y-5">
                        @foreach ($applications as $app)
                            <div class="bg-gray-700 p-6 rounded-xl flex justify-between items-start shadow-sm border border-gray-600">

                                {{-- Kiri --}}
                                <div class="flex flex-col gap-1">
                                    <p class="text-lg font-semibold text-gray-100">
                                        {{ $app->job->title }}
                                    </p>

                                    <p class="text-sm text-gray-300">
                                        {{ $app->created_at->translatedFormat('d M Y') }}
                                    </p>

                                    <span class="
                                        inline-flex items-center px-3 py-1 text-xs font-medium rounded-md mt-2
                                        {{ $app->status == 'Pending' ? 'bg-yellow-400/20 text-yellow-300 border border-yellow-400/30' : '' }}
                                        {{ $app->status == 'Accepted' ? 'bg-green-400/20 text-green-300 border border-green-400/30' : '' }}
                                        {{ $app->status == 'Rejected' ? 'bg-red-400/20 text-red-300 border border-red-400/30' : '' }}
                                    ">
                                        ● {{ $app->status }}
                                    </span>
                                </div>

                                {{-- Kanan --}}
                                <a href="{{ asset('storage/' . $app->cv) }}"
                                   target="_blank"
                                   class="text-emerald-400 hover:text-emerald-300 text-sm font-medium mt-1">
                                   Lihat CV →
                                </a>

                            </div>
                        @endforeach
                    </div>

                @else
                    <p class="text-gray-300 text-sm italic">Belum ada lamaran yang diajukan.</p>
                @endif

            </div>

        </div>
    </div>
</x-app-layout>
