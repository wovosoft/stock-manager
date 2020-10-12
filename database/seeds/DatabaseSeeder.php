<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Wovosoft\LaravelPermissions\Models\Permissions;
use Wovosoft\LaravelPermissions\Models\Roles;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            SettingsSeeder::class,
            LanguageSeeder::class
        ]);
        $permissions = config("laravel-permissions.default_permissions");
        $roles = config("laravel-permissions.default_roles");


        foreach ($permissions as $permission) {
            Permissions::query()->firstOrCreate(
                [
                    "name" => $permission["name"]
                ],
                [
                    "description" => $permission["description"]
                ]
            );
        }

        $this->command->info('Default Permissions added.');

        foreach ($roles as $role) {
            $role = Roles::query()->firstOrCreate($role);

            if ($role->name == 'Super Admin') {
                // assign all permissions
                $role->syncPermissions(Permissions::all());
                $this->command->info('Super Admin granted all the permissions');
            } else {
                // for others by default only read access
                $role->syncPermissions(Permissions::query()->where('name', 'LIKE', 'view_%')->get());
            }

            // create one user for each role
            $this->createUser($role);
        }

        // Reset cached roles and permissions
        $this->command->info("\nWe are flushing the new records from database to the cache.\n");
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $this->command->warn('All done Role & Permissions created :)');
        \Database\Factories\CategoryFactory::new()->count(20)->create();
        \Database\Factories\SupplierFactory::new()->count(20)->create();
        \Database\Factories\CustomerFactory::new()->count(20)->create();
        \Database\Factories\EmployeeFactory::new()->count(20)->create();
        \Database\Factories\BrandFactory::new()->count(20)->create();
//        \Database\Factories\SubcategoryFactory::new()->count(20)->create();
        $units = [
            'kg' => 'kilogram',
            'cm' => 'centimeter',
            'gm' => 'gram',
            'qty' => 'Quantity'
        ];
        foreach ($units as $key => $value) {
            \Database\Factories\UnitFactory::new()->create(['name' => $key, 'description' => $value]);
        }

        \Database\Factories\ProductFactory::new()->count(20)->create();
        \Database\Factories\ExpenseCategoryFactory::new()->count(5)->create();

//        factory(\App\Models\CheckIn::class, 20)
//            ->create()
//            ->each(function ($checkIn) {
//                for ($x = 0; $x <= random_int(1, 3); $x++) {
//                    $checkIn
//                        ->items()
//                        ->create([
//                            "product_id" => random_int(1, 20),
//                            "quantity" => random_int(1, 5)
//                        ]);
//                }
//            });
//        factory(\App\Models\CheckOut::class, 20)
//            ->create()
//            ->each(function ($checkOut) {
//                for ($x = 0; $x <= random_int(1, 3); $x++) {
//                    $checkOut
//                        ->items()
//                        ->create([
//                            "product_id" => random_int(1, 20),
//                            "quantity" => random_int(1, 5)
//                        ]);
//                }
//            });

        refreshLanguages();
        refreshCachedSettings();
    }

    private function createUser($role)
    {
        if ($role->name == 'Super Admin') {
            $user = \Database\Factories\UserFactory::new()->create([
                "name" => "Super Admin",
                "email" => "superadmin@gmail.com",
                "password" => Hash::make("superadmin123456789")
            ]);
            $user->assignRole($role->name);
        } else {
            $user = \Database\Factories\UserFactory::new()->create();
            $user->assignRole($role->name);
        }
    }
}
