<?php

namespace App\Http\Controllers;

use App\Models\profile;
use App\Http\Controllers\controller;
use Illuminate\Http\Request;


class ProfileController extends Controller
{
    public function index(profile $profile)
    {
        
        return view('profile.index', compact('profile'));
    }

    public function edit()
    {
        return view('profile.edit');
    }

}
