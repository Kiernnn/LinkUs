<?php

namespace App\Http\Controllers;

use App\Models\profile;
use App\Http\Controllers\controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\helpers;
use Validator;


class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $profile = $user->profile;

        if(!$profile){
            $profile = new Profile();
        }

        return view('profile.index', compact('user', 'profile'));
    }

    public function edit()
    {
        $user = auth()->user();
        $profile = $user->profile ?: new Profile(['user_id' => $user->id]);

        return view('profile.edit', compact('user', 'profile'));
    }

    public function update(Request $request, Profile $profile)
    {
        $validator = Validator::make($request->all(), [
            'image' => 'nullable|image|max:2048',
            'about' => 'nullable|string|max:255',
        ]);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator->errors());
        }

        $profile->about = $request->input('about');
        $profile->save();

        try{
            $profile->update([
                'image' => $request->image,
                'about' => $request->about,
            ]);

            if($request->hasFile('image')){
                $file = $request->file('image');
                $image = uploadImage($file, 'profile');
                $profile->update(['image' => $image]);
            }

            return redirect()->route('profile.index')->with('success', 'Profile updated successfully');
        } catch(\Exception $e){
            dd($e);
            return redirect()->back()->with('error', 'Profile update failed');
        }
    }

}
