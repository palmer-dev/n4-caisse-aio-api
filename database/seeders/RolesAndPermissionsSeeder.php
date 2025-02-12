<?php

namespace Database\Seeders;

use App\Enums\PermissionsEnum;
use App\Enums\RolesEnum;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->getOutput()->progressStart( count( PermissionsEnum::cases() ) + 3 );
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        foreach (PermissionsEnum::cases() as $case) {
            Permission::findOrcreate( $case->value );
            $this->command->getOutput()->progressAdvance();
        }

        // Create admin role with permissions
        $role = Role::findOrcreate( RolesEnum::ADMIN->value );
        $role->syncPermissions( Permission::all() );
        $this->command->getOutput()->progressAdvance();

        $role = Role::findOrcreate( RolesEnum::MANAGER->value );
        $role->syncPermissions( Permission::whereIn( "name", PermissionsEnum::managers() )->get() );
        $this->command->getOutput()->progressAdvance();

        $role = Role::findOrcreate( RolesEnum::EMPLOYEE->value );
        $role->syncPermissions( Permission::whereNotIn( "name", [...PermissionsEnum::features(), ...PermissionsEnum::managers()] )->get() );

        $this->command->getOutput()->progressFinish();
    }
}
