<?php

namespace App\Http\Controllers;

use App\Models\profile;
use App\Http\Controllers\controller;
use Illuminate\Http\Request;
<<<<<<< HEAD
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\helpers;
use Validator;
=======
>>>>>>> ed30af3091e2c22f989fc419b1d6f56ce9483b97


class ProfileController extends Controller
{
<<<<<<< HEAD
    public function index()
    {
        $user = Auth::user();
        $profile = $user->profile;

        if(!$profile){
            $profile = new Profile();
        }

        return view('profile.index', compact('user', 'profile'));
=======
    public function index(profile $profile)
    {
        
        return view('profile.index', compact('profile'));
>>>>>>> ed30af3091e2c22f989fc419b1d6f56ce9483b97
    }

    public function edit()
    {
<<<<<<< HEAD
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
=======
        return view('profile.edit');
>>>>>>> ed30af3091e2c22f989fc419b1d6f56ce9483b97
    }

}
