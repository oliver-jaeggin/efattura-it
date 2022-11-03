<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('items')->insert([
            'invoice_id' => '1',
            'description' => 'Test',
            'qty' => '10',
            'price' => '200',
            'tax' => '0',
            'total_item' => '2000',
        ]);
        DB::table('items')->insert([
            'invoice_id' => '1',
            'description' => 'Test 2',
            'qty' => '1',
            'price' => '500',
            'tax' => '22',
            'total_item' => '5000',
        ]);
        DB::table('items')->insert([
            'invoice_id' => '2',
            'description' => 'Test',
            'qty' => '10',
            'price' => '200',
            'tax' => '0',
            'total_item' => '2000',
        ]);
        DB::table('items')->insert([
            'invoice_id' => '3',
            'description' => 'Test',
            'qty' => '10',
            'price' => '200',
            'tax' => '0',
            'total_item' => '2000',
        ]);
        DB::table('items')->insert([
            'invoice_id' => '4',
            'description' => 'Test',
            'qty' => '10',
            'price' => '200',
            'tax' => '0',
            'total_item' => '2000',
        ]);
    }
}
