<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Daftar Pelamar') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <div class="flex items-center justify-between mb-6">
                        <p class="text-lg font-medium text-gray-700">
                            Kelola daftar pelamar yang tersedia.
                        </p>
                        <form action="{{ route('admin.applications.export') }}" method="GET" class="flex items-center gap-3">
    
                            <select name="job" class="bg-gray-700 text-gray-200 rounded-lg px-3 py-2 border border-gray-600">
                                <option value="">Semua Lowongan</option>

                                @foreach ($jobs as $job)
                                    <option value="{{ $job->id }}" {{ request('job') == $job->id ? 'selected' : '' }}>
                                        {{ $job->title }}
                                    </option>
                                @endforeach
                            </select>

                            <button class="inline-flex items-center bg-blue-600 px-4 py-2 rounded-md text-white text-sm hover:bg-blue-700">
                                📤 Export Excel
                            </button>

                        </form>
                    </div>

                    @if (session('success'))
                        <div class="mb-4 rounded-md bg-green-50 p-4 text-green-700">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-medium uppercase text-gray-500">Nama Pelamar</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium uppercase text-gray-500">Lowongan</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium uppercase text-gray-500">CV</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium uppercase text-gray-500">Status</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium uppercase text-gray-500">Aksi</th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-gray-200">
                                @forelse($applications as $app)
                                    <tr>
                                        <td class="px-4 py-3 text-sm text-gray-700">{{ $app->user->name }}</td>
                                        <td class="px-4 py-3 text-sm text-gray-700">{{ $app->job->title }}</td>
                                        <td class="px-4 py-3 text-sm text-gray-700">
                                            {{-- Tombol Lihat --}}
                                            <a href="{{ asset('storage/' . $app->cv) }}" target="_blank"
                                            class="inline-flex items-center rounded-md bg-indigo-600 px-3 py-1 
                                                    text-xs font-semibold text-white hover:bg-indigo-700">
                                            Lihat CV
                                            </a>

                                            {{-- Tombol Download --}}
                                            <a href="{{ asset('storage/' . $app->cv) }}" download
                                            class="inline-flex items-center rounded-md bg-emerald-600 px-3 py-1 
                                                    text-xs font-semibold text-white hover:bg-emerald-700">
                                                Download
                                            </a>
                                        </td>
                                        <td class="px-4 py-3 text-sm">
                                            <span class="
                                                inline-flex items-center rounded-md px-2 py-1 text-xs font-medium
                                                {{ $app->status == 'Pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                                {{ $app->status == 'Accepted' ? 'bg-green-100 text-green-800' : '' }}
                                                {{ $app->status == 'Rejected' ? 'bg-red-100 text-red-800' : '' }}
                                            ">
                                                {{ $app->status }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3 text-sm">
                                            <div class="flex items-center gap-2">
                                                <form action="{{ route('admin.applications.update', $app->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="status" value="Accepted">
                                                    <button type="submit"
                                                            class="rounded-md bg-green-600 px-3 py-1 text-xs font-semibold text-white hover:bg-green-700">
                                                        Terima
                                                    </button>
                                                </form>
                                                <form action="{{ route('admin.applications.update', $app->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="status" value="Rejected">
                                                    <button type="submit"
                                                            class="rounded-md bg-red-600 px-3 py-1 text-xs font-semibold text-white hover:bg-red-700">
                                                        Tolak
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-4 py-3 text-center text-sm text-gray-500">
                                            Belum ada pelamar untuk lowongan ini.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
