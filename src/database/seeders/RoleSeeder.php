<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

     //役割と権限の作成ーーーーーーーーーー
    public function run()
    {
        //役割の作成
        Role::create(['name'=>'admin']);
        Role::create(['name'=>'store_manager']);
        Role::create(['name'=>'user']);

        // 権限の作成
        Permission::create(['name' => 'create_store_manager']);
        Permission::create(['name' => 'create_store']);
        Permission::create(['name' => 'update_store']);
        Permission::create(['name' => 'view_reservations']);
        Permission::create(['name' => 'import_store']);

        // 役割に権限を付与
        $storeManagerRole = Role::findByName('store_manager');
        $storeManagerRole -> givePermissionTo(['create_store','update_store','view_reservations']);

        $adminRole = Role::findByName('admin');
        $adminRole -> givePermissionTo('create_store_manager', 'import_store');
    }
}
