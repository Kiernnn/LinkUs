<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash; 
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    //...

    public function store(Request $request)
    {
        $request->validate([
         'firstName' => ['required', 'string', 'max:255'],
         'lastName' => ['required', 'string', 'max:255'],
         'userName' => ['required', 'string', 'max:255', 'unique:users'],
         'birthDate' => ['required', 'date'],
         'gender' => ['required', 'in:male,female,other'],
         'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
         'firstName' => $request['firstName'],
         'lastName' => $request['lastName'],
         'userName' => $request['userName'],
         'birthDate' => $request['birthDate'],
         'gender' => $request['gender'],
         'email' => $request['email'],
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        return redirect()->route('login');

      //   Auth::login($user);

      //   return redirect(RouteServiceProvider::HOME);
    }

    //...
}
