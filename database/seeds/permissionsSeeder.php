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
        Permission::create(['name' => 'editar_usuarios']);
        Permission::create(['name' => 'eliminar_usuarios']);

        // create roles and assign existing permissions
        $role = Role::create(['name' => 'avanzado']);
        $role->givePermissionTo('agregar_lotes');
        $role->givePermissionTo('editar_lotes');
        $role->givePermissionTo('eliminar_lotes');

        $role = Role::create(['name' => 'admin']);
		$role->givePermissionTo('agregar_lotes');
        $role->givePermissionTo('editar_lotes');
        $role->givePermissionTo('eliminar_lotes');
        $role->givePermissionTo('publish articles');
        $role->givePermissionTo('unpublish articles');


        DB::table('users')->insert([
        	'name' => 'administrador',
        	'email' => 'administrador@admin.com',
        	'password' => bcrypt('1!lacontraseñaincreiblementesecretadeladministrador'),
        ]);
    }
}



