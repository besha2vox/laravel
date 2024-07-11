<?php

namespace Database\Seeders;

use App\Enums\Permissions\Account;
use App\Enums\Permissions\Category;
use App\Enums\Permissions\Order;
use App\Enums\Permissions\Product;
use App\Enums\Permissions\User;
use App\Enums\Role as RoleEnum;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionsAndRolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            ...Account::values(),
            ...User::values(),
            ...Category::values(),
            ...Product::values(),
            ...Order::values(),
        ];

        foreach ($permissions as $permission) {
            Permission::findOrCreate($permission);
        }

        if (!Role::where('name', RoleEnum::CUSTOMER)->exists()) {
            (Role::create(['name' => RoleEnum::CUSTOMER->value]))
            ->givePermissionTo(Account::values());
        }

        if (!Role::where('name', RoleEnum::MODERATOR)->exists()) {
            (Role::create(['name' => RoleEnum::MODERATOR->value]))
                ->givePermissionTo([...Category::values(), ...Product::values()]);
        }

        if (!Role::where('name', RoleEnum::ADMIN)->exists()) {
            (Role::create(['name' => RoleEnum::ADMIN->value]))
                ->givePermissionTo(Permission::all());
        }
    }
}
