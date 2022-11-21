<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ClientController extends Controller
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
        $clients = Client::orderBy('display_name', 'ASC')->paginate(10);

        return view('clients.index')
            ->with('clients', $clients);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('clients.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // get countries to validate input
        $json_countries = file_get_contents('inc/list-countries.json');
        $arr_countries = json_decode($json_countries, true);
        $countries = array_keys($arr_countries['countries']);

        Validator::make($request->all(), [
            'country_code' => [
                'required',
                'string',
                'min:2',
                'max:2',
                Rule::in($countries),
            ],
            'country' => 'required|string',
            'state' => [
                'required_if:country_code,IT',
            ],
            'cap' => 'required|string',
            'city' => 'required|string',
            'street' => 'required|string',
            'street_nr' => 'required|string',
            'vat_nr' => 'string|nullable',
            'cf' => 'string|nullable|min:16|max:16',
            'destination_code' => 'string|nullable|max:7',
            'company_name' => 'string|nullable',
            'name' => 'string|nullable',
            'surname' => 'string|nullable',
            'display_name' => 'string|nullable',
            'email' => 'email:rfc,dns|nullable',
            'pec' => 'email:rfc,dns|nullable',
            'template' => 'string|nullable',
        ])->validate();
    
        Client::create($request->all());
    
        return redirect()->route('clients.index')
            ->with('success', 'Client created.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function show(Client $client)
    {
        $invoices = Invoice::orderBy('date', 'ASC')->orderBy('number', 'ASC')->paginate(5);


        return view('clients.show')
            ->with('client', $client)
            ->with('invoices', $invoices);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function edit(Client $client)
    {
        return view('clients.edit')
            ->with('client', $client);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Client $client)
    {
        // get countries to validate input
        $json_countries = file_get_contents('inc/list-countries.json');
        $arr_countries = json_decode($json_countries, true);
        $countries = array_keys($arr_countries['countries']);

        Validator::make($request->all(), [
            'country_code' => [
                'required',
                'string',
                'min:2',
                'max:2',
                Rule::in($countries),
            ],
            'country' => 'required|string',
            'state' => [
                'required_if:country_code,IT',
            ],
            'cap' => 'required|string',
            'city' => 'required|string',
            'street' => 'required|string',
            'street_nr' => 'required|string',
            'vat_nr' => 'string|nullable',
            'cf' => 'string|nullable|min:16|max:16',
            'destination_code' => 'string|nullable|max:7',
            'company_name' => 'string|nullable',
            'name' => 'string|nullable',
            'surname' => 'string|nullable',
            'display_name' => 'string|nullable',
            'email' => 'email:rfc,dns|nullable',
            'pec' => 'email:rfc,dns|nullable',
            'template' => 'string|nullable',
        ])->validate();

        $updatedClient = $request->all(); 
        $client->update($updatedClient);

        return redirect()->route('clients.show', [$client->id])
            ->with('success', 'Client updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function destroy(Client $client)
    {
        $client->delete();
        Artisan::call('cache:clear');


        return redirect()->route('clients.index')
            ->with('success', 'Client deleted.');
    }
}
