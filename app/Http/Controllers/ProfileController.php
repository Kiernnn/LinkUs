<?php

namespace App\Http\Controllers;

use App\Models\profile;
use App\Http\Controllers\controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\helpers;
use Validator;
use Exception;

class ProfileController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $profile = $user->profile;

        // Create a default profile if it doesn't exist
        if(!$profile) {
            $profile = Profile::create(['user_id' => $user->id]);
        }

        return view('profile.index', compact('user', 'profile'));
    }

    public function edit()
    {
        $user = auth()->user();
        $profile = $user->profile;

        if(!$profile) {
            $profile = Profile::create(['user_id' => $user->id]);
        }

        return view('profile.edit', compact('user', 'profile'));
    }
          
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'image' => 'nullable|image|max:2048',
            'about' => 'nullable|string|max:255',
            'delete_image' => 'nullable|boolean',
        ]);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator->errors());
        }

        $user = auth()->user();
        $profile = $user->profile;

        try{
            $profile->update([
                'about' => $request->about,
            ]);

            if($request->hasFile('image')) {
                $file = $request->file('image');
                if($profile->image) {
                    deleteFile($profile->image, 'profiles');
                }
                $image = uploadFile($file, 'profiles');

                $profile->image = $image ?? null;
                $profile->save();
            }

            return redirect()->route('profile.index')->with('success', 'Profile updated successfully');
        } catch(\Exception $e){
            dd($e);
            return redirect()->back()->with('error', 'Profile update failed');
        }
    }
}
