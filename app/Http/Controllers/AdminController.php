<?php

namespace App\Http\Controllers;

use App\Models\JobPost;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function pendingJobs(){
        $today = Carbon::today();

        $jobs = JobPost::whereDate('deadline', '>=', $today)
            ->where('is_approved',false)
            ->orderBy('deadline', 'asc')
            ->paginate(10); 

        return response()->json($jobs, 200);
    }

    public function approveJob($id){
        $job = JobPost::find($id);
        if(!$job){
            return response()->json(['message' => 'Job post is not found'], 400);
        }
        $job->is_approved = true;
        $job->save();
        return response()->json([
            'message' => 'Job post is approve',
            'data' => $job
        ],200);
    }
}
