<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('clients')->insert([
            'country_code' => 'CH',
            'country' => 'Svizzera',
            'cap' => '4052',
            'city' => 'Basel',
            'street' => 'Brunngässlein',
            'street_nr' => '12',
            'vat_nr' => 'CHE-121.122.12',
            'company_name' => 'cyon GmbH',
            'display_name' => 'cyon GmbH',
        ]);
        DB::table('clients')->insert([
            'country_code' => 'IT',
            'country' => 'Italia',
            'state' => 'VI',
            'cap' => '36100',
            'city' => 'Vicenza',
            'street' => 'via Raffaele Cadorna',
            'street_nr' => '15',
            'vat_nr' => '04313230247',
            'cf' => 'JGGLRD83M27Z133C',
            'name' => 'Oliver',
            'surname' => 'Jaeggin',
            'display_name' => 'Oliver Jaeggin',
        ]);
    }
}
