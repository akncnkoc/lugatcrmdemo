<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    if (User::all()->isEmpty()) {
      $user = User::create([
        'name' => 'Akın Can',
        'surname' => 'Koç',
        'email' => 'demo@mail.com',
        'password' => bcrypt('demo'),
      ]);
      $admin_role = Role::where('slug','admin')->first();
      $user->roles()->attach($admin_role);
      $permissions = Permission::get(['slug'])->toArray();
      foreach ($permissions as $permission) {
        $user->givePermissionsTo($permission["slug"]);
      }
    }
  }
}
