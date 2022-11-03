<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UserController extends Controller
{

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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = Auth::user();

        return view('users.index')
            ->with('users', $users);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|string|email:rfc,dns',
            'password' => 'string',
          ]);
    
          User::create($request->all());
    
          return redirect()->route('users.index')
            ->with('success', 'User created.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return view('users.show')
            ->with('user', $user);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('users.edit')
            ->with('user', $user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        // get countries to validate input
        $json_countries = file_get_contents('inc/list-countries.json');
        $arr_countries = json_decode($json_countries, true);
        $countries = array_keys($arr_countries['countries']);

        // get states to validate input
        $json_states = file_get_contents('inc/list-states.json');
        $arr_states = json_decode($json_states, true);
        define('STATES', array_keys($arr_states['states']));

        Validator::make($request->all(), [
            'email' => 'required|string|email:rfc,dns',
            'password' => 'string',
            'country_code' => [
                'required',
                'string',
                'min:2',
                'max:2',
                Rule::in($countries),
            ],
            'country' => 'required|string',
            'state' => [
                'string',
                'min:2',
                'max:2',
                Rule::in(STATES),
            ],
            'cap' => 'required|string',
            'city' => 'required|string',
            'street' => 'required|string',
            'street_nr' => 'required|string',
            'vat_nr' => 'required|string|min:11|max:11',
            'cf' => 'required|string|min:16|max:16',
            'destination_code' => 'string|nullable|max:7',
            'company_name' => 'string|nullable',
            'name' => 'string|nullable',
            'surname' => 'string|nullable',
            'pec' => 'email:rfc,dns|nullable',
            'tel' => 'string|nullable',
            'web' => 'url|nullable',
            'bank_iban' => 'required|string|min:27|max:33',
            'bank_bic' => 'required|string|min:11|max:11',
            'bank_name' => 'required|string',
        ])->validate();

        $updatedUser = $request->all(); 
        $user->update($updatedUser);

        return redirect('/');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
        Artisan::call('cache:clear');


        return redirect()->route('/')
            ->with('success', 'User deleted.');
    }
}
