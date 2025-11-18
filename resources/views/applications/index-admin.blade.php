<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-100 leading-tight">
            Daftar Pelamar
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-gray-800 p-8 rounded-2xl shadow-lg">

                {{-- FILTER & EXPORT --}}
                <div class="flex items-center justify-between mb-6">
                    {{-- FILTER LOWONGAN --}}
                    <form method="GET" action="{{ route('admin.applications.index') }}"
                        class="flex items-center gap-3">

                        <label class="text-gray-300 font-medium">Filter:</label>

                        <select name="job"
                                onchange="this.form.submit()"
                                class="h-11 px-4 bg-gray-700 text-gray-200 rounded-lg border border-gray-600
                                    focus:outline-none focus:ring-2 focus:ring-emerald-400">
                            <option value="">— Semua Lowongan —</option>
                            @foreach ($jobs as $job)
                                <option value="{{ $job->id }}" {{ $selectedJob == $job->id ? 'selected' : '' }}>
                                    {{ $job->title }}
                                </option>
                            @endforeach
                        </select>
                    </form>

                    {{-- EXPORT BUTTON --}}
                    <a href="{{ route('admin.applications.export', ['job' => $selectedJob]) }}"
                    class="h-11 px-5 flex items-center justify-center bg-blue-600 hover:bg-blue-500
                            text-white rounded-lg text-sm font-medium shadow">
                        📤 Export Excel
                    </a>
                </div>


                {{-- TABEL --}}
                <div class="mt-8 overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-700">
                        <thead class="bg-gray-700">
                            <tr class="text-gray-300 text-sm uppercase tracking-wide">
                                <th class="px-4 py-3 text-left">Nama Pelamar</th>
                                <th class="px-4 py-3 text-left">Lowongan</th>
                                <th class="px-4 py-3 text-left">CV</th>
                                <th class="px-4 py-3 text-left">Status</th>
                                <th class="px-4 py-3 text-left">Aksi</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-800 text-gray-100">
                            @foreach ($applications as $app)
                                <tr>
                                    <td class="px-4 py-3">{{ $app->user->name }}</td>
                                    <td class="px-4 py-3">{{ $app->job->title }}</td>

                                    <td class="px-4 py-3 flex gap-2">
                                        <a href="{{ asset('storage/'.$app->cv) }}" target="_blank"
                                           class="text-emerald-400 hover:text-emerald-300">
                                            Lihat
                                        </a>
                                        <a href="{{ asset('storage/'.$app->cv) }}" download
                                           class="text-blue-400 hover:text-blue-300">
                                            Download
                                        </a>
                                    </td>

                                    <td class="px-4 py-3">
                                        <span class="px-3 py-1 rounded-md text-xs font-semibold
                                            {{ $app->status == 'Pending' ? 'bg-yellow-500/20 text-yellow-300' : '' }}
                                            {{ $app->status == 'Accepted' ? 'bg-green-500/20 text-green-300' : '' }}
                                            {{ $app->status == 'Rejected' ? 'bg-red-500/20 text-red-300' : '' }}
                                        ">
                                            {{ $app->status }}
                                        </span>
                                    </td>

                                    <td class="px-4 py-3 flex gap-2">
                                        <form action="{{ route('admin.applications.update', $app->id) }}" method="POST">
                                            @csrf @method('PUT')
                                            <input type="hidden" name="status" value="Accepted">
                                            <button class="bg-green-600 hover:bg-green-500 px-3 py-1 rounded text-xs text-white">
                                                Terima
                                            </button>
                                        </form>

                                        <form action="{{ route('admin.applications.update', $app->id) }}" method="POST">
                                            @csrf @method('PUT')
                                            <input type="hidden" name="status" value="Rejected">
                                            <button class="bg-red-600 hover:bg-red-500 px-3 py-1 rounded text-xs text-white">
                                                Tolak
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- Download Template -->
                <div>
                    <a href="{{ route('admin.jobs.import.template') }}"
                        class="px-4 py-2 bg-indigo-600 hover:bg-indigo-500 text-white rounded-md text-sm">
                        📥 Download Template
                    </a>
                </div>
                <!-- Import Jobs -->
                <div class="mt-4">
                    <form action="{{ route('admin.jobs.import') }}" method="POST" enctype="multipart/form-data"
                        class="flex items-center gap-3">
                        @csrf
                        <input type="file" name="file" accept=".xlsx"
                            class="text-gray-200 bg-gray-700 rounded-lg border border-gray-600
                                focus:outline-none focus:ring-2 focus:ring-emerald-400">
                        <button type="submit"
                            class="px-4 py-2 bg-green-600 hover:bg-green-500 text-white rounded-md text-sm">
                            📥 Import Jobs
                        </button>
                    </form>
                </div>
            </div>
        </div>
</x-app-layout>
