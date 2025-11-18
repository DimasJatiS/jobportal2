<x-admin-layout>
    <div class="bg-gray-800 text-gray-100 rounded-xl shadow-lg p-8">
        <h2 class="text-2xl font-bold text-emerald-400 mb-6">
            <i class="bi bi-plus-circle"></i> Tambah Lowongan Baru
        </h2>

        <form action="{{ route('admin.jobs.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf

            <div>
                <label class="block text-sm font-semibold text-gray-300 mb-1">Judul Lowongan</label>
                <input type="text" name="title" required
                       class="w-full rounded-md bg-gray-700 border-gray-600 text-gray-100 focus:ring-emerald-400 focus:border-emerald-400">
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-300 mb-1">Deskripsi</label>
                <textarea name="description" rows="4" required
                          class="w-full rounded-md bg-gray-700 border-gray-600 text-gray-100 focus:ring-emerald-400 focus:border-emerald-400"></textarea>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-semibold text-gray-300 mb-1">Lokasi</label>
                    <input type="text" name="location" required
                           class="w-full rounded-md bg-gray-700 border-gray-600 text-gray-100 focus:ring-emerald-400">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-300 mb-1">Perusahaan</label>
                    <input type="text" name="company" required
                           class="w-full rounded-md bg-gray-700 border-gray-600 text-gray-100 focus:ring-emerald-400">
                </div>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-300 mb-1">Tipe Pekerjaan</label>
                <select name="type" required
                        class="w-full rounded-md bg-gray-700 border-gray-600 text-gray-100 focus:ring-emerald-400">
                    <option value="">-- Pilih Tipe --</option>
                    <option value="Full-Time">Full-Time</option>
                    <option value="Part-Time">Part-Time</option>
                    <option value="Internship">Internship</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-300 mb-1">Gaji</label>
                <input type="number" name="salary" required
                       class="w-full rounded-md bg-gray-700 border-gray-600 text-gray-100 focus:ring-emerald-400">
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-300 mb-1">Logo Perusahaan</label>
                <input type="file" name="logo"
                       class="w-full text-gray-100 file:bg-emerald-600 file:text-white file:rounded-md file:px-3 file:py-2 hover:file:bg-emerald-500">
            </div>

            <div class="flex justify-end space-x-3">
                <a href="{{ route('admin.jobs.index') }}"
                   class="px-4 py-2 rounded-md border border-gray-500 text-gray-300 hover:text-white hover:border-emerald-500">
                    Batal
                </a>
                <button type="submit"
                        class="px-4 py-2 bg-emerald-600 rounded-md text-white hover:bg-emerald-500">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</x-admin-layout>
