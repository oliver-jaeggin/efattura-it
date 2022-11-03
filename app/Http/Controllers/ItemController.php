<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class ItemController extends Controller
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
        $items = Item::orderBy('invoice_id', 'ASC')->paginate(10);

        return view('items.index')
            ->with('items', $items);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('items.create');
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
            'invoice_id' => 'required|exists:invoices,id',
            'description' => 'required|string',
            'qty' => 'required|numeric',
            'price' => 'required|numeric',
            'tax' => 'required|numeric',
            'total_item' => 'required|numeric',
        ]);

        Item::create($request->all());
        
        $invoice_id = $request->invoice_id;

        return redirect()->route('invoices.edit', [$invoice_id])
            ->with('success', 'Item created.');
        //return redirect()->route('items.index')
        //    ->with('success', 'Item created.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function show(Item $item)
    {
        return view('items.show')
            ->with('item', $item);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function edit(Item $item)
    {
        return view('items.edit')
            ->with('item', $item);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Item $item)
    {
        $this->validate($request, [
            'invoice_id' => 'required|exists:invoices,id',
            'description' => 'required|string',
            'qty' => 'required|numeric',
            'price' => 'required|numeric',
            'tax' => 'required|numeric',
            'total_item' => 'required|numeric',
        ]);

        $invoice_id = $request->invoice_id;

        $updateItem = $request->all();
        $item->update($updateItem);

        return redirect()->route('invoices.edit', [$invoice_id])
            ->with('success', 'Item created.');


        //return redirect()->route('items.show', [$item->id])
        //    ->with('success', 'Item updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function destroy(Item $item)
    {
        
        $item->delete();
        Artisan::call('cache:clear');

        $invoice_id = $item->invoice_id;

        return redirect()->route('invoices.edit', [$invoice_id])
            ->with('success', 'Item deleted.');


        //return redirect()->route('items.index')
        //    ->with('success', 'Item deleted.');
    }
}
