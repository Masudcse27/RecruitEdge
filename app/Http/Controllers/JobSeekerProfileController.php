<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Profiler\Profile;

class JobSeekerProfileController extends Controller
{
    public function profile(Request $request){
        return response()->json($request->user(),200);
    }

    public function changeEmail(Request $request){
        $request->validate([
            'email' => 'required|email|unique:users,email,' . $request->user()->id,
        ]);

        $request->user()->update(['email' => $request->email]);

        return response()->json(['message' => 'Email updated successfully.']);
    }

}
