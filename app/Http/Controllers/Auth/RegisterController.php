<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Carbon;
use Auth;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        // Validation
        $this->validate($request, [
            'firstName' => 'required|string|max:255',
            'lastName' => 'required|string|max:255',
            'userName' => 'required|string|max:255',
            'birthDate' => 'required|date|before_or_equal:'.Carbon::now()->subYears(16)->format('Y-m-d'),

            'gender' => 'required|string',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        // Check if email exists
        if (User::where('email', $request->email)->exists()) {
            return redirect()->back()->with('error', 'Email already exists');
        }

        // Create new user
        $user = User::create([
                    'firstName' => $request->firstName,
                    'lastName' => $request->lastName,
                    'userName' => $request->userName,
                    'birthDate' => $request->birthDate,
                    'gender' => $request->gender,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                ]);

        $profile = Profile::create([
            'user_id' => $user->id
        ]);

        // Redirect to login page with success message
        if($user){
            Auth::login($user);
            return redirect()->route('posts.index');
        }
    }

}
