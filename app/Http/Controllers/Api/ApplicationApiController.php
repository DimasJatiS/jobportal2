<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\JobVacancy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ApplicationApiController extends Controller
{
    /**
     * @OA\Get(
     *   path="/api/applications",
     *   tags={"Applications"},
     *   summary="List applications",
     *   security={{"bearerAuth":{}}},
     *   @OA\Response(response=200, description="Applications list")
     * )
     */
    public function index(Request $request)
    {
        if ($request->user()->role !== 'admin') {
            return response()->json([
                'message' => 'Unauthorized'
            ], 403);
        } 
        $apps = Application::with('job', 'user')
            ->latest()
            ->paginate($request->get('per_page', 10));

            return response()->json($apps);
    }
    /**
     * @OA\Post(
     *   path="/api/jobs/{job}/apply",
     *   tags={"Applications"},
     *   summary="Apply to a job",
     *   security={{"bearerAuth":{}}},
     *   @OA\Parameter(name="job", in="path", required=true, @OA\Schema(type="integer")),
     *   @OA\RequestBody(required=true, @OA\JsonContent()),
     *   @OA\Response(response=201, description="Application created")
     * )
     */
    public function store(Request $request, JobVacancy $job)
    {
        // Job Seeker apply (upload CV optional via API multipart)
        $data = $request->validate([
            'cv'=> 'required|file|mimes:pdf|max:2048'
        ]);

        $cvPath = $request->file('cv')->store('cvs', 'public');

        $application = Application::create(
            [
                'user_id' => $request->user()->id,
                'job_id' => $job->id,
                'cv' => $cvPath,
                'status' => 'Pending',
            ]
        );

        return response()->json([
            'message' => 'Application submitted successfully',
            'application' => $application,
        ], 201);
    }

    /**
     * @OA\Patch(
     *   path="/api/applications/{id}/status",
     *   tags={"Applications"},
     *   summary="Update application status",
     *   security={{"bearerAuth":{}}},
     *   @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *   @OA\RequestBody(required=true, @OA\JsonContent()),
     *   @OA\Response(response=200, description="Status updated")
     * )
     */
    public function updateStatus(Request $request, $id)
    {
        // Admin update application status
        if ($request->user()->role !== 'admin') {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $data = $request->validate([
            'status' => 'required|in:Pending,Reviewed,Accepted,Rejected',
        ]);

        $application = Application::findOrFail($id);
        $application->status = $data['status'];
        $application->save();

        return response()->json([
            'message' => 'Application status updated successfully',
            'application' => $application,
        ]);
    }
}
