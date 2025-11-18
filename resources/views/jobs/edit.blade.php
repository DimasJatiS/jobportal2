<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-100 leading-tight flex items-center gap-2">
            <i class="bi bi-pencil-square text-yellow-400"></i>
            Edit Lowongan
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-800 shadow-lg rounded-xl p-8 text-gray-100">

                {{-- FORM UPDATE (HANYA UNTUK UPDATE) --}}
            <form action="{{ route('admin.jobs.update', $job->id) }}" 
                method="POST" 
                enctype="multipart/form-data"
                id="updateForm">
                    @csrf
                    @method('PUT')

                    {{-- Judul --}}
                    <div class="mb-5">
                        <label class="block text-sm font-semibold mb-2">Judul Lowongan</label>
                        <input type="text" 
                               name="title" 
                               value="{{ $job->title }}" 
                               required
                               class="w-full px-4 py-2 bg-gray-700 border border-gray-600 rounded-lg text-gray-200">
                    </div>

                    {{-- Deskripsi --}}
                    <div class="mb-5">
                        <label class="block text-sm font-semibold mb-2">Deskripsi</label>
                        <textarea name="description" rows="4" required
                                  class="w-full px-4 py-2 bg-gray-700 border border-gray-600 rounded-lg text-gray-200">{{ $job->description }}</textarea>
                    </div>

                    {{-- Lokasi & Perusahaan --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-sm font-semibold mb-2">Lokasi</label>
                            <input type="text" name="location" value="{{ $job->location }}"
                                   required class="w-full px-4 py-2 bg-gray-700 border border-gray-600 rounded-lg text-gray-200">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold mb-2">Perusahaan</label>
                            <input type="text" name="company" value="{{ $job->company }}"
                                   required class="w-full px-4 py-2 bg-gray-700 border border-gray-600 rounded-lg text-gray-200">
                        </div>
                    </div>

                    {{-- Tipe --}}
                    <div class="mt-5">
                        <label class="block text-sm font-semibold mb-2">Tipe Pekerjaan</label>
                        <select name="type"
                                required
                                class="w-full px-4 py-2 bg-gray-700 border border-gray-600 rounded-lg text-gray-200">
                            <option value="">-- Pilih Tipe --</option>
                            <option value="Full-time" {{ $job->type == 'Full-time' ? 'selected' : '' }}>Full-Time</option>
                            <option value="Part-time" {{ $job->type == 'Part-time' ? 'selected' : '' }}>Part-Time</option>
                            <option value="Internship" {{ $job->type == 'Internship' ? 'selected' : '' }}>Internship</option>
                        </select>
                    </div>

                    {{-- Gaji --}}
                    <div class="mt-5">
                        <label class="block text-sm font-semibold mb-2">Gaji</label>
                        <input type="number" name="salary" value="{{ $job->salary }}"
                               required class="w-full px-4 py-2 bg-gray-700 border border-gray-600 rounded-lg text-gray-200">
                    </div>

                    {{-- Logo --}}
                    <div class="mt-5">
                        <label class="block text-sm font-semibold mb-2">Logo Perusahaan</label>
                        <input type="file" name="logo"
                               class="w-full px-4 py-2 bg-gray-700 border border-gray-600 rounded-lg text-gray-200">

                        @if($job->logo)
                            <img src="{{ asset('storage/' . $job->logo) }}" 
                                 class="mt-4 rounded-lg shadow-md w-32 h-32 object-contain border border-gray-700 bg-gray-700 p-2">
                        @endif
                    </div>

                </form>

                {{-- BUTTONS WRAPPER --}}
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mt-10">

                    {{-- FORM DELETE (BENAR-BENAR TERPISAH) --}}
                    <form action="{{ route('admin.jobs.destroy', $job->id) }}"
                          method="POST"
                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus lowongan ini?');"
                          id="deleteForm"
                          class="w-fit">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="px-4 py-2 text-sm bg-red-600 hover:bg-red-500 text-white rounded-lg">
                            Hapus Lowongan
                        </button>
                    </form>

                    {{-- TOMBOL UPDATE + BATAL --}}
                    <div class="flex gap-3">
                        <a href="{{ route('admin.jobs.index') }}"
                           class="px-4 py-2 text-sm bg-gray-700 hover:bg-gray-600 text-gray-200 rounded-lg">
                            Batal
                        </a>

                        {{-- TOMBOL PERBARUI (HANYA SUBMIT FORM UPDATE) --}}
                        <button type="submit" form="updateForm"
                                class="px-4 py-2 text-sm bg-yellow-500 hover:bg-yellow-400 text-gray-900 font-semibold rounded-lg">
                            Perbarui
                        </button>
                    </div>

                </div>

            </div>
        </div>
    </div>
</x-app-layout>
