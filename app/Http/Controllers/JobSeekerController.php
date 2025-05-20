<?php

namespace App\Http\Controllers;

use App\Models\JobPost;
use Illuminate\Http\Request;

class JobSeekerController extends Controller
{
    public function appliedJobs(Request $request){
        $user = $request->user();
        $applied_job = JobPost::whereHas('applications', function($query) use ($user){
            $query->where('job_seeker_id', $user->id);
        })->paginate(10);

        return response()->json($applied_job,200);
    }
}
