<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::create(['name'=>'Crear usuario']);
        Permission::create(['name'=>'Listar usuario']);
        Permission::create(['name'=>'Modificar usuario']);
        Permission::create(['name'=>'Eliminar usuario']);
        Permission::create(['name'=>'Ver detalle de usuario']);

        $role_admin = Role::create(['name' => 'admin']);
        $role_admin->givePermissionTo('Crear usuario');
        $role_admin->givePermissionTo('Listar usuario');
        $role_admin->givePermissionTo('Modificar usuario');
        $role_admin->givePermissionTo('Eliminar usuario');
        $role_admin->givePermissionTo('Ver detalle de usuario');

        $user = User::factory()->create([
            'name' => 'Example User',
            'password' => bcrypt('password'),
            'email' => 'tester@example.com',
            "age" => 30, 
            "birthdate" => "1990-01-01", 
            "gender" => "M", 
            "dni" => "11212121", 
            "address" => "123 Main St", 
            "country" => "USA", 
            "phone" => "1234567890"
        ]);
        $user->assignRole($role_admin);
    }
}
