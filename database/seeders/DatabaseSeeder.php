<?php

namespace Database\Seeders;

use App\Http\Controllers\CurrencyController;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Artisan::call('migrate:fresh');
        $this->command->info("Migrated");
        $currency = new CurrencyController();
        $currency->currency();
        $this->call([
      CargoTypeSeeder::class,
      CargoCompanySeeder::class,
      AmountTypeSeeder::class,
      RoleSeeder::class,
      PermissionSeeder::class,
      UserSeeder::class,
      CustomerRoleSeeder::class,
      ExpenseTypeSeeder::class,
      StaffRoleSeeder::class,
      VariantSeeder::class,
      SafeSeeder::class,
      SupplierSeeder::class,
      ProductTypeSeeder::class,
      ProductSeeder::class,
      CustomerSeeder::class,
      StaffSeeder::class,
      IncomingWaybillSeeder::class,
      CashRegisterSeeder::class,
      StaffPaymentTypeSeeder::class,
      ExpenseSeeder::class,
      InvoiceSeeder::class
    ]);
    }
}
