<?php

namespace App\Http\Controllers;

use App\Http\Requests\JobPostRequest;
use App\Models\JobPost;
use Carbon\Carbon;
use Illuminate\Http\Request;

class JobPostController extends Controller
{
    public function create(JobPostRequest $request){
       try {
            $data = $request->validated();
            $data['employer_id'] = $request->user()->id;

            $post = JobPost::create($data);

            return response()->json([
                'message' => 'Job post created successfully.',
                'data' => $post
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to create job post.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function list(){
        $today = Carbon::today();

        $jobs = JobPost::whereDate('deadline', '>=', $today)
            ->orderBy('deadline', 'asc')
            ->paginate(10); 

        return response()->json($jobs, 200);
    }

    public function retrieve($id)  {
        $job = JobPost::find($id);

        if(!$job){
            return response()->json(['message'=>'Job not found'],400);
        }

        return response()->json($job,200);
    }

    public function update(JobPostRequest $request, $id){
        $data = $request->validated();

        $job = JobPost::find($id);
        if(!$job){
            return response()->json([
                'message' => 'Job is not found'
            ], 400);
        }

        if($job->employer_id !== $request->user()->id){
            return response()->json([
                'message' => 'Unauthorize request'
            ], 403);
        }

        $job->update($data);
        return response()->json([
            'message' => 'Update successful',
            'data' => $job
        ],200);
    }

    public function delete(Request $request, $id){
        $job = JobPost::find($id);

        if(!$job){
            return response()->json([
                'message' => 'Job is not found'
            ], 400);
        }

        if($job->employer_id !== $request->user()->id && $request->user()->role !== 'admin'){
            return response()->json([
                'message' => 'Unauthorize request'
            ], 403);
        }

        $job->delete();

        return response()->json([
            'message' => 'Job is deleted'
        ],200);
    }
}
