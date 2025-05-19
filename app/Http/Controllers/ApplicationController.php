<?php

namespace App\Http\Controllers;

use App\Http\Requests\ApplicationRequest;
use App\Models\Application;
use App\Models\JobPost;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ApplicationController extends Controller
{
    public function create(ApplicationRequest $request) {
        $data = $request->validated();

        $nameSlug = Str::slug($request->name);
        
        if($request->hasFile('cv')){
            $picExtension = $request->file('cv')->getClientOriginalExtension();
            $picName = $nameSlug . '_' . $request->user()->id . 'cv' . '.' . $picExtension;
            $cvPath = $request->file('cv')->storeAs('cv', $picName, 'public');
            $data['cv'] = $cvPath;
        }

        $application = Application::create($data);

        return response()->json([
            'message' => 'Application submitted successfully.',
            'application' => $application,
        ], 201);
    }
    public function list(Request $request, $id){
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

        $applications = Application::where('job_post_id',$id)->paginate(10);
        return response()->json([
            'message' => 'success',
            'applications' => $applications
        ],200);
    }

    public function retrieve(Request $request, $id){
        $application = Application::with('job')->find($id);
        if (!$application || !$application->job) {
            return response()->json(['message' => 'Application or related job not found.'], 400);
        }

        if ($application->job->employer_id !== $request->user()->id) {
            return response()->json(['message' => 'Unauthorized request'], 403);
        }

        return response()->json($application,200);
    }
}
