<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Client;
use App\Models\Item;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class InvoiceController extends Controller
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
        $invoices = Invoice::orderBy('date', 'DESC')->orderBy('number', 'DESC')->paginate(10);

        return view('invoices.index')
            ->with('invoices', $invoices);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $clients = Client::all();

        return view('invoices.create')
            ->with('clients', $clients);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // get currencies to validate form
        $json_currencies = file_get_contents('inc/list-currencies.json');
        $currencies = json_decode($json_currencies, true);

        Validator::make($request->all(), [
            'doc_type' => 'required|string|min:4|max:4',
            'date' => 'required|date_format:Y-m-d',
            'number' => 'required|string',
            'client_id' => 'required|exists:clients,id',
            'currency' => [
                'required',
                'string',
                Rule::in($currencies['currencies']),
            ],
        ])->validate();

        $createInvoice = Invoice::create($request->all());

        $invoice_id = $createInvoice->id;

        return redirect()->route('invoices.edit', [$invoice_id])
            ->with('success', 'Invoice created.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function show(Invoice $invoice)
    {
        $user = User::orderBy('id', 'desc')->first();

        return view('invoices.show')
            ->with('invoice', $invoice)
            ->with('user', $user);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function edit(Invoice $invoice)
    {
        $clients = Client::all();
        $items = Item::all();

        return view('invoices.edit', compact('invoice', 'clients', 'items'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Invoice $invoice)
    {
        // get currencies to validate form
        $json_currencies = file_get_contents('inc/list-currencies.json');
        $currencies = json_decode($json_currencies, true);
        
        Validator::make($request->all(), [
            'doc_type' => 'required|string|min:4|max:4',
            'date' => 'required|date_format:Y-m-d',
            'number' => 'required|string',
            'client_id' => 'required|exists:clients,id',
            'currency' => [
                'required',
                'string',
                'max:3',
                Rule::in($currencies['currencies']),
            ],
            'subtotal' => 'numeric|nullable',
            'stamp' => 'numeric|nullable',
            'provision' => 'numeric|nullable',
            'discount' => 'numeric|nullable',
            'total' => 'numeric|nullable',
            'total_rounded' => 'numeric|nullable',
            'exchange_rate' => 'numeric|nullable',
            'total_eur' => 'numeric|nullable',
            'paid' => 'integer|nullable',
            'upload_xml' => 'integer|nullable',
        ])->validate();


        $updatedInvoice = $request->all(); 
        $invoice->update($updatedInvoice);

        return redirect()->route('invoices.edit', [$invoice->id])
            ->with('success', 'Invoice updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function destroy(Invoice $invoice)
    {
        $invoice->delete();
        Artisan::call('cache:clear');

        return redirect()->route('invoices.index')
            ->with('success', 'Invoice deleted.');
    }
}