<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
      ['name' => 'Yönetici', 'slug' => 'admin'],
      ['name' => 'Moderatör', 'slug' => 'moderator'],
      ['name' => 'Ziyaretçi', 'slug' => 'visitor']
    ];
        if (Role::all()->isEmpty()) {
            foreach ($roles as $role) {
                Role::create([
          'name' => $role['name'],
          'slug' => $role['slug']
        ]);
            }
        }
    }
}
