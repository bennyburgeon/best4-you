<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        $permissions = [
            'view roles', 'create roles', 'edit roles', 'delete roles',
            'view categories', 'create categories', 'edit categories', 'delete categories',
            'view clients', 'create clients', 'edit clients', 'delete clients',
            'view jobs', 'create jobs', 'edit jobs', 'delete jobs',
            'view applications', 'delete applications',
            'view skills', 'create skills', 'edit skills', 'delete skills',
            'view currencies', 'create currencies', 'edit currencies', 'delete currencies',
            'view industry-types', 'create industry-types', 'edit industry-types', 'delete industry-types',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // create admin role and assign all permissions
        $adminRole = Role::firstOrCreate(['name' => 'super-admin']);
        $adminRole->givePermissionTo(Permission::all());

        // Create a basic super admin user if not exists
        $admin = User::firstOrCreate(
            ['email' => 'admin@b4u.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('password')
            ]
        );
        $admin->assignRole('super-admin');
        
        $hrRole = Role::firstOrCreate(['name' => 'hr']);
        $hrRole->givePermissionTo([
            'view jobs', 'create jobs', 'edit jobs', 'delete jobs',
            'view applications',
            'view clients'
        ]);
    }
}
