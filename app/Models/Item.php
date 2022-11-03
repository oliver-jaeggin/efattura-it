<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Item extends Model
{
    public $timestamps = FALSE;
    protected $fillable = ['invoice_id', 'description', 'qty', 'price', 'tax', 'total_item'];

    // Create relation to the connected invoice
    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    // Clear items cache upon modifying a item entry
    protected static function boot()
    {
        parent::boot();

        static::saving(function() {
            Cache::forget('items');
        });
    }
}
