<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $adminRole = Role::where('name','admin')->first();

        User::create([
            'name' => 'admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('00000000')
        ])->assignRole($adminRole);

    }
}