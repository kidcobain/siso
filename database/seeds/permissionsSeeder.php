<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use Illuminate\Database\Eloquent\Model;

class permissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     *php artisan db:seed --class=UsersTableSeeder
     *
     * @return void
     */
    public function run()
    {
        //
        app()['cache']->forget('spatie.permission.cache');

        // create permissions
        Permission::create(['name' => 'agregar_lotes']);
        Permission::create(['name' => 'editar_lotes']);
        Permission::create(['name' => 'eliminar_lotes']);

        Permission::create(['name' => 'agregar_usuarios']);
        Permission::create(['name' => 'editar_usuarios']);
        Permission::create(['name' => 'eliminar_usuarios']);

        Permission::create(['name' => 'lectura']);

        // create roles and assign existing permissions
        $role = Role::create(['name' => 'avanzado']);
        $role->givePermissionTo('agregar_lotes');
        $role->givePermissionTo('editar_lotes');
        $role->givePermissionTo('eliminar_lotes');

        $role = Role::create(['name' => 'admin']);
        $role->givePermissionTo('agregar_lotes');
        $role->givePermissionTo('editar_lotes');
        $role->givePermissionTo('eliminar_lotes');
        $role->givePermissionTo('agregar_usuarios');
        $role->givePermissionTo('editar_usuarios');
        $role->givePermissionTo('eliminar_usuarios');



        $user = \App\User::create([
            'name' => 'administrador',
            'email' => 'administrador@admin.com',
            'password' => bcrypt('Lacontraseñaincreiblementesecretadeladministrador1'),
        ]);

        $user->assignRole('admin');
        
        $role = Role::create(['name' => 'usuario']);
        $role->givePermissionTo('lectura');
    }
}



