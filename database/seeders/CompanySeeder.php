<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $company = [
            'name' => 'Example Company',
            'short_name' => 'ExCo',
            'phone' => '123-456-7890',
            'email' => 'example@example.com',
            'logo' => 'path/to/logo.png',
            'favicon' => 'path/to/favicon.ico',
            'address' => '123 Main Street, City, Country',
            'sorting' => 1,
        ];

        \DB::table('companies')->insert($company);

    }
}
