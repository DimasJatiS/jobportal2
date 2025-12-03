<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\JobVacancy;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // DASHBOARD USER
        if ($user->role === 'user') {

            $applications = Application::with('job')
                ->where('user_id', $user->id)
                ->latest()
                ->get();

            return view('dashboard-user', compact('applications'));
        }

        // DASHBOARD ADMIN
        if ($user->role === 'admin') {
            
            $notifications = auth()->user()->unreadNotifications()->latest()->take(5)->get();
            
            $stats = [
                'total_jobs' => JobVacancy::count(),
                'total_applications' => Application::count(),
                'pending' => Application::where('status', 'Pending')->count(),
                'accepted' => Application::where('status', 'Accepted')->count(),
            ];

            return view('dashboard-admin', compact('stats'));
        }
    }
}
