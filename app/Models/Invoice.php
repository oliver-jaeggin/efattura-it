<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Invoice extends Model
{
    public $timestamps = FALSE;
    protected $fillable = ['number', 'date', 'currency', 'client_id', 'subtotal', 'stamp', 'provision', 'discount', 'total', 'total_rounded', 'exchange_rate', 'total_eur', 'paid', 'upload_xml'];

    // Create relation to the connected client
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    // Get the items for a specific invoice.
    public function items()
    {
        return $this->hasMany(Item::class);
    }
    

    // Clear invoices cache upon modifying an invoice
    protected static function boot()
    {
        parent::boot();

        static::saving(function() {
            Cache::forget('invoices');
        });
    }
}
