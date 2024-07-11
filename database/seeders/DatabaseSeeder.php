<?php

namespace Database\Seeders;

use App\Enums\Permissions\Account;
use App\Enums\Permissions\Category;
use App\Enums\Permissions\Order;
use App\Enums\Permissions\Product;
use App\Enums\Permissions\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
//        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
//
//        $permissions = [
//            ...Account::values(),
//            ...User::values(),
//            ...Order::values(),
//            ...Product::values(),
//            ...Category::values(),
//        ];

        $this->call(PermissionsAndRolesSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(CategoryProductsSeeder::class);
    }
}
