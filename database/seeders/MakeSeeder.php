<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MakeSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('makes')->insert([
            ['name' => 'Toyota'],
            ['name' => 'Honda'],
            ['name' => 'Suzuki'],
        ]);
    }
}