<?php

namespace App\Http\Controllers;

use App\Models\JobVacancy as Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use App\Imports\JobsImport;
use Maatwebsite\Excel\Facades\Excel;

class JobController extends Controller
{
    /**
     * Tampilkan semua lowongan.
     */
    // public function adminIndex()
    // {
    //     $jobs = Job::latest()->paginate(10);
    //     return view('admin.jobs.index', compact('jobs')); // khusus admin
    // }

    public function index()
    {
        $jobs = Job::latest()->paginate(6);
        return view('jobs.index', compact('jobs')); // publik
    }

    /**
     * Tampilkan form tambah lowongan.
     */
    public function create()
    {
        return view('jobs.create');
    }

    /**
     * Simpan lowongan baru ke database.
     */
    public function store(Request $request)
    {

        $typeOptions = ['Full-Time', 'Part-Time', 'Internship'];
        
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string|max:255',
            'company' => 'required|string|max:255',
            'salary' => 'nullable|numeric',
            'logo' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
            'type' => 'nullable|string|in:' . implode(',', $typeOptions),
        ]);

        if ($request->hasFile('logo')) {
            $validated['logo'] = $request->file('logo')->store('logos', 'public');
        }

        Job::create($validated);

        return redirect()->route('jobs.index')->with('success', 'Lowongan berhasil ditambahkan!');
    }

    /**
     * Tampilkan detail lowongan.
     */
    public function show($id)
    {
        $job = Job::findOrFail($id);
        return view('jobs.show', compact('job'));
    }

    /**
     * Tampilkan form edit lowongan.
     */
    public function edit(string $id)
    {
        $job = Job::findOrFail($id);
        return view('jobs.edit', compact('job'));
    }

    /**
     * Update data lowongan.
     */
    public function update(Request $request, string $id)
    {
        $typeOptions = ['Full-time', 'Part-time', 'Internship'];
        $job = Job::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string|max:255',
            'company' => 'required|string|max:255',
            'salary' => 'nullable|numeric',
            'logo' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
            'type' => 'nullable|string|in:' . implode(',', $typeOptions),
        ]);

        if ($request->hasFile('logo')) {
            // Hapus logo lama jika ada
            if ($job->logo && Storage::disk('public')->exists($job->logo)) {
                Storage::disk('public')->delete($job->logo);
            }
            $validated['logo'] = $request->file('logo')->store('logos', 'public');
        }

        $job->update($validated);

        return redirect()->route('jobs.index')->with('success', 'Lowongan berhasil diperbarui!');
    }

    /**
     * Impor data lowongan dari file Excel.
     */
    public function import(Request $request)
    {
        $request->validate(['file' => 'required|mimes:xlsx,csv']);
        Excel::import(new JobsImport, $request->file('file'));
        return back()->with('success', 'Data lowongan berhasil diimport');
    }

    /**
     * Hapus lowongan.
     */
    public function destroy(string $id)
    {
        $job = Job::findOrFail($id);

        // Hapus logo dari storage
        if ($job->logo && Storage::disk('public')->exists($job->logo)) {
            Storage::disk('public')->delete($job->logo);
        }

        $job->delete();

        return redirect()->route('jobs.index')->with('success', 'Lowongan berhasil dihapus!');
    }
}
