<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Http\Controllers\Controller;
use App\Models\Post;
use App\helpers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Validator;
use Exception;

class ProfileController extends Controller
{
    public function index(Request $request)
    {
        if(!auth()->user()->profile) {
            Profile::create([
                'user_id' => $user->id
            ]);
        }

        $posts = auth()->user()->posts()->orderBy('created_at', 'desc')->get();
        
        return view('profile.index', compact('posts'));
    }

    public function edit()
    {
        return view('profile.edit');
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'image' => 'nullable|image|max:2048',
            'about' => 'nullable|string|max:255',
        ]);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator->errors());
        }

        $profile = auth()->user()->profile;

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

            return redirect()->route('profile.index')->with('success', 'Profile Updated Successfully');
        } catch(\Exception $e){
            return redirect()->back()->with('error', 'Profile Update Failed !');
        }
    }
}
