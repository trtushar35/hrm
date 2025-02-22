<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->datas() as $key => $value) {
            Role::create($value);
        }
    }

    private function datas()
    {
        return [
            [
                'name' => 'Owner',
                'guard_name' => 'admin',
                'created_at' => now(),
            ],
            [
                'name' => 'Admin',
                'guard_name' => 'admin',
                'created_at' => now(),
            ],
          
        ];
    }
}
