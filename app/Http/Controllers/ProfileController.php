<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProfileController extends Controller
{
    public function profile(Request $request)
    {
        return response()->json($request->user(), 200);
    }

    public function changeEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:users,email,' . $request->user()->id,
        ]);

        $request->user()->update(['email' => $request->email]);

        return response()->json(['message' => 'Email updated successfully.']);
    }

    public function changePassword(Request $request)
    {

        $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if (!Hash::check($request->current_password, $request->user()->password)) {
            return response()->json(['message' => 'Current password is incorrect'], 403);
        }

        $request->user()->update([
            'password' => Hash::make($request->password),
        ]);

        return response()->json(['message' => 'Password changed successfully.']);
    }

    public function changeProfilePicture(Request $request){
        $request->validate([
            'profile_picture' => 'required|image|mimes:jpeg,png,jpg,gif|max:10240',
        ]);

        $user = $request->user();

        if ($user->profile_picture && Storage::disk('public')->exists($user->profile_picture)) {
            Storage::disk('public')->delete($user->profile_picture);
        }

        $nameSlug = Str::slug($user->name);
        $timestamp = now()->format('YmdHis');

        $picExtension = $request->file('profile_picture')->getClientOriginalExtension();
        $picName = $nameSlug . '_' . $timestamp . '.' . $picExtension;

        $profilePicturePath = $request->file('profile_picture')->storeAs('profile_pictures', $picName, 'public');

        $user->update(['profile_picture' => $profilePicturePath]);

        return response()->json(['message' => 'Profile picture updated successfully.'], 200);
    }

}
