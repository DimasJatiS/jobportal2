<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\JobVacancy;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ApplicationsExport;

class ApplicationController extends Controller
{
    // USER MELAMAR PEKERJAAN
    public function store(Request $request, $jobId)
    {
        $request->validate([
            'cv' => 'required|mimes:pdf|max:2048',
        ]);

        $cvPath = $request->file('cv')->store('cvs', 'public');

        Application::create([
            'user_id' => auth()->id(),
            'job_id'  => $jobId,
            'cv'      => $cvPath,
            'status'  => 'Pending',
        ]);

        return back()->with('success', 'Lamaran berhasil dikirim!');
    }

    // ADMIN MELIHAT PELAMAR PEKERJAAN
    public function index($jobId = null)
    {
        $applications = Application::with('user', 'job')
            ->when($jobId, fn($q) => $q->where('job_id', $jobId))
            ->latest()
            ->get();

        $jobs = JobVacancy::all();

        return view('applications.index', compact('applications', 'jobs', 'jobId'));
    }

    // ADMIN MELIHAT PELAMAR PEKERJAAN (DENGAN FILTER)
    public function adminIndex(Request $request)
    {
        $jobId = $request->query('job');

        $jobs = JobVacancy::orderBy('title')->get();

        $applications = Application::with('user', 'job')
            ->when($jobId, fn($q) => $q->where('job_id', $jobId))
            ->latest()
            ->get();

        return view('applications.index-admin', [
            'applications' => $applications,
            'jobs' => $jobs,
            'selectedJob' => $jobId,
        ]);
    }


    // ADMIN MENGUBAH STATUS
    public function update(Request $request, Application $application)
    {
        $application->update(['status' => $request->status]);

        return back()->with('success', 'Status pelamar diperbarui.');
    }

    // EXPORT KE EXCEL
    public function export(Request $request)
    {
        $jobId = $request->query('job');

        return Excel::download(new ApplicationsExport($jobId), 'applications.xlsx');
    }
}
