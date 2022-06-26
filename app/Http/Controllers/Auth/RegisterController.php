<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
Use App\Rules\SecurePasswordRule;

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

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * 
     *  Old password validator
     * 
     * 
     */


    // protected function validator(array $data)
    // {
    //     return Validator::make($data, [
    //         'name' => ['required', 'string', 'max:255'],
    //         'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
    //         'password' => ['required', 'confirmed', Password::min(8) 
    //         ->letters()
    //         ->mixedCase()
    //         ->numbers()
    //         ->symbols()
    //         ->uncompromised()],
    //     ]);
    // }
 /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|not_regex:/[0-9]/|max:255|not_regex:/[@$!%*#?&_]/',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|string|regex:/[0-9]/|regex:/[A-Z]/|regex:/[a-z]/|regex:/[@$!%*#?&_]/',
        ], [
            'name.required' => 'Full name',
            'password.required' => 'The password must contain one upper and lowercase letter, one symbol and one number',
            'password.regex' => 'Your password is missing requirments',
            'password.min' => 'Your passwords do not match',
            'email.email'=> 'The email adress must be valid',
            'name.not_regex' => 'Use only letters for this field',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }
}
