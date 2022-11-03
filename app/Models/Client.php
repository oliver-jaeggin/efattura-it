<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Client extends Model
{
    public $timestamps = FALSE;
    protected $fillable = ['country_code', 'country', 'state', 'cap', 'city', 'street', 'street_nr', 'vat_nr', 'cf', 'destination_code', 'company_name', 'name', 'surname', 'display_name', 'email', 'pec', 'template'];

    // Get the invoices for a specific client.
    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    // Clear clients cache upon modifying a client entry
    protected static function boot()
    {
        parent::boot();

        static::saving(function() {
            Cache::forget('clients');
        });
    }
}
