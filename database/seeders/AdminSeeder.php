<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = Admin::create([

            'first_name' => 'RDTL ',
            'last_name' => 'Developer ',
            'email' => 'admin@oms.com',
            'phone' => '01612423280',
            'password' =>'asdasd',
            'role_id' => 1,
            'photo' => null,
            'address' => 'RDTL Head Office',
            'status' => 'Active',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
       
        $admin->assignRole(Role::find(1)->id);

        $admin->assignRole(Role::find(2)->id);
    }

    protected function previousDatas()
    {

        DB::table('Admins')->insert([
            'company_id' => 1,
            'first_name' => 'Admin',
            'last_name' => 'Admin',
            'email' => 'admin@gmail.com',
            'phone' => '1234567890',
            'password' => bcrypt('asdasd'),
            'role_id' => null,
            'photo' => 'default.jpg',
            'address' => 'Address ',
            'sorting' => 1,
            'status' =>  'Active',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $AdminCount = 10;

        for ($i = 1; $i <= $AdminCount; $i++) {
            DB::table('admins')->insert([
                'company_id' => 1,
                'first_name' => 'admin' . $i,
                'last_name' => 'Member' . $i,
                'email' => 'admin' . $i . '@example.com',
                'phone' => '1234567890',
                'password' => bcrypt('asdasd'),
                'role_id' => null,
                'photo' => 'default.jpg',
                'address' => 'Address ' . $i,
                'sorting' => $i,
                'status' =>  'Active',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
