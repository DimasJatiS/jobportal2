<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\JobVacancy;
use Illuminate\Http\Request;

class JobApiController extends Controller
{
    /**
     * @OA\Get(
     *   path="/api/jobs",
     *   tags={"Jobs"},
     *   summary="List jobs",
     *   security={{"bearerAuth":{}}},
     *   @OA\Response(response=200, description="Jobs list")
     * )
     */
    public function index(Request $request)
    {
        $query = JobVacancy::query();

        if ($request->filled('keyword')) {
            $keyword = $request->input('keyword');
            $query->where(function ($s) use ($keyword) {
                $s->where('title', 'like', "%{$keyword}%")
                  ->orWhere('company_name', 'like', "%{$keyword}%")
                  ->orWhere('location', 'like', "%{$keyword}%");
            });
        }

        if ($request->filled('location')) {
            $location = $request->input('location');
            $query->where('location', 'like', "%{$location}%");
        }

        if ($request->filled('company')) {
            $company = $request->input('company');
            $query->where('company_name', 'like', "%{$company}%");
        }

        $jobs = $query->orderBy('created_at', 'desc')
                      ->paginate($request->get('per_page', 10));

        return response()->json($jobs);
    }

    /**
     * @OA\Post(
     *   path="/api/jobs",
     *   summary="Create a new job listing",
     *   tags={"Jobs"},
     *   security={{"bearerAuth":{}}},
     *
     *   @OA\RequestBody(
     *     required=true,
     *     @OA\JsonContent(
     *       required={"title","company","location","description"},
     *       @OA\Property(property="title", type="string", example="Software Engineer"),
     *       @OA\Property(property="company", type="string", example="Tech Corp"),
     *       @OA\Property(property="location", type="string", example="New York, NY"),
     *       @OA\Property(property="description", type="string", example="Full job description"),
     *       @OA\Property(property="salary", type="integer", example=80000)
     *     )
     *   ),
     *
     *   @OA\Response(
     *     response=201,
     *     description="Job created successfully",
     *     @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Job created successfully"),
     *       @OA\Property(
     *         property="job",
     *         type="object",
     *         @OA\Property(property="id", type="integer", example=1),
     *         @OA\Property(property="title", type="string", example="Software Engineer"),
     *         @OA\Property(property="company", type="string", example="Tech Corp"),
     *         @OA\Property(property="location", type="string", example="New York, NY"),
     *         @OA\Property(property="description", type="string", example="Job description"),
     *         @OA\Property(property="salary", type="integer", example=80000),
     *         @OA\Property(property="created_at", type="string", example="2024-01-01T00:00:00Z"),
     *         @OA\Property(property="updated_at", type="string", example="2024-01-01T00:00:00Z")
     *       )
     *     )
     *   ),
     *
     *   @OA\Response(response=400, description="Bad Request"),
     *   @OA\Response(response=401, description="Unauthorized")
     * )
     */

    public function store(Request $request)
    {
        //cek role admin
        if ($request->user()->role !== 'admin') {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'company' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'description' => 'required|string',
            'salary' => 'nullable|integer|max:100000000',
        ]);

        $job = JobVacancy::create($data);

        return response()->json(
            ['message' => 'Job created successfully', 'job' => $job],
            201
        );
    }

    /**
     * @OA\Get(
     *   path="/api/jobs/{job}",
     *   tags={"Jobs"},
     *   summary="Show job",
     *   security={{"bearerAuth":{}}},
     *   @OA\Parameter(name="job", in="path", required=true, @OA\Schema(type="integer")),
     *   @OA\Response(response=200, description="Job detail"),
     *   @OA\Response(response=404, description="Not found")
     * )
     */
    public function show(JobVacancy $job)
    {
        return response()->json($job);
    }

    /**
     * @OA\Put(
     *   path="/api/jobs/{job}",
     *   tags={"Jobs"},
     *   summary="Update job",
     *   security={{"bearerAuth":{}}},
     *   @OA\Parameter(name="job", in="path", required=true, @OA\Schema(type="integer")),
     *   @OA\RequestBody(required=true, @OA\JsonContent()),
     *   @OA\Response(response=200, description="Updated")
     * )
     */
    public function update(Request $request, string $id)
    {
        //cek role admin
        if ($request->user()->role !== 'admin') {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $job = JobVacancy::findOrFail($id);

        $data = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'company' => 'sometimes|required|string|max:255',
            'location' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|required|string',
            'salary' => 'nullable|integer|max:255',
        ]);

        $job->update($data);

        return response()->json(
            ['message' => 'Job updated successfully', 'job' => $job],
            200
        );
    }

    /**
     * @OA\Delete(
     *   path="/api/jobs/{job}",
     *   tags={"Jobs"},
     *   summary="Delete job",
     *   security={{"bearerAuth":{}}},
     *   @OA\Parameter(name="job", in="path", required=true, @OA\Schema(type="integer")),
     *   @OA\Response(response=204, description="Deleted")
     * )
     */
    public function destroy(string $id)
    {
        //cek role admin
        if (auth()->user()->role !== 'admin') {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $job = JobVacancy::findOrFail($id);
        $job->delete();

        return response()->json(['message' => 'Job deleted successfully'], 200);
    }

    /**
     * @OA\Get(
     *   path="/api/public/jobs",
     *   tags={"Jobs"},
     *   summary="Public list jobs",
     *   @OA\Response(response=200, description="Jobs list")
     * )
     */
    public function publicIndex(Request $request)
    {
        // Public job listings without authentication

        $query = JobVacancy::query();

        if ($request->filled('keyword')) {
            $keyword = $request->input('keyword');
            $query->where(function ($s) use ($keyword) {
                $s->where('title', 'like', "%{$keyword}%")
                  ->orWhere('company_name', 'like', "%{$keyword}%")
                  ->orWhere('location', 'like', "%{$keyword}%");
            });
        }

        if ($request->filled('location')) {
            $location = $request->input('location');
            $query->where('location', 'like', "%{$location}%");
        }

        if ($request->filled('company')) {
            $company = $request->input('company');
            $query->where('company_name', 'like', "%{$company}%");
        }

        $jobs = $query->orderBy('created_at', 'desc')
                      ->paginate($request->get('per_page', 10));

        return response()->json($jobs);
    }
}
