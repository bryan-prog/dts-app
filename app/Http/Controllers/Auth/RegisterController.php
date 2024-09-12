<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

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
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'middle_name' => ['nullable', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'suffix' => ['nullable', 'string', 'max:255'],
            'office_dept' => ['required', 'string', 'max:255'],
            'designation' => ['nullable', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'user_level' => ['required', 'string', 'max:255'],
            'contact' => ['nullable', 'string', 'max:255'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
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
            'middle_name' => $data['middle_name'],
            'last_name' => $data['last_name'],
            'suffix' => $data['suffix'],
            'office_dept' => $data['office_dept'],
            'designation' => $data['designation'],
            'username' => $data['username'],
            'user_level' => $data['user_level'],
            'contact' => $data['contact'],
            'password' => Hash::make($data['password']),
            'active' => "1",
        ]);

        return Redirect::action('HomeController@index')->with("message", "SUCCESSFULLY SAVED USER DATA!");
    }

    public function edit_user(Request $request)
    {
        User::where('id', $request->user_id)
            ->update([
                'name' => $request->name,
                'middle_name' => $request->middle_name,
                'last_name' => $request->last_name,
                'suffix' => $request->suffix,
                'office_dept' => $request->office_dept,
                'designation' => $request->designation,
                'username' => $request->username,
                'user_level' => $request->user_level,
                'contact' => $request->contact,
                'active' => $request->user_status,
            ]);

        return back()->with('message', 'Successfully updated user information!');
    }

    public function change_password(Request $request)
    {
        User::where('id', $request->user_id)
            ->update([
                'password'=> Hash::make($request->change_pass),
            ]);

        return back()->with('message', 'Successfully updated password!');
    }
}
