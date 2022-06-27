<?php

namespace Database\Seeders;

use App\Models\StaffRole;
use Illuminate\Database\Seeder;

class StaffRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = ['Hanutçu', 'Tezgahtar', 'Yancı'];
        if (StaffRole::all()->isEmpty()) {
            foreach ($roles as $role) {
                StaffRole::create([
          'name' => $role,
        ]);
            }
        }
    }
}
