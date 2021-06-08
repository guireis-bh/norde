<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public static $roles = [
        'superuser' => '*',
        'admin' => '*',
        'supervisor' => '*',
        'teacher' => null,
        'relative' => null,
        'studant' => null,
    ];

    public static $permissions = [
        'list employees',
        'list admins',
        'list supervisors',
        'list teachers',
        'list relatives',
        'list studants',
        'list schedules',
        'view employees',
        'view admins',
        'view supervisors',
        'view teachers',
        'view relatives',
        'view studants',
        'view schedules',
        'add employee',
        'add admin',
        'add supervisor',
        'add teacher',
        'add relative',
        'add studant',
        'add schedule',
        'update employee',
        'update admin',
        'update supervisor',
        'update teacher',
        'update relative',
        'update studant',
        'update schedule',
        'delete employee',
        'delete admin',
        'delete supervisor',
        'delete teacher',
        'delete relative',
        'delete studant',
        'delete schedule',
    ];


    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        foreach(self::$permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        foreach(self::$roles as $role => $permission) {
            $role = Role::firstOrCreate(['name' => $role]);
            if(!is_null($permission)) {
                $role->givePermissionTo(
                    $permission === '*' ? 
                    Permission::all() :
                    $permission
                );
            }
        }
    }
}
