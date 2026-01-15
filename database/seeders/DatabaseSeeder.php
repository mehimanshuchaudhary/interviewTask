<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\PermissionRegistrar;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $this->call([
            PermissionSeeder::class,
        ]);

        $user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
        ]);

        // Assign permissions (team-aware)
        $permissions = json_decode(
            file_get_contents(base_path('database/seeders/permissions.json'))
        );

        foreach ($permissions as $permission) {
            if (! $user->hasPermissionTo($permission->name)) {
                $user->givePermissionTo($permission->name);
            }
        }
    }
}
