<?php

namespace Database\Seeders;

use App\GlobalHelper;
use App\AppHelper;
use App\Models\BulkWaybill;
use App\Models\CashRegister;
use App\Models\CurrencyType;
use App\Models\Customer;
use App\Models\Expense;
use App\Models\ExpenseType;
use App\Models\Product;
use App\Models\ProductLog;
use App\Models\Safe;
use App\Models\SafeLog;
use App\Models\Staff;
use App\Models\StaffPayment;
use App\Models\StaffPaymentType;
use App\Models\SubProduct;
use App\Models\Supplier;
use Bezhanov\Faker\Provider\Commerce;
use Faker\Factory;
use Faker\Provider\Barcode;
use Illuminate\Database\Seeder;

class TestSeeder extends Seeder
{
  public function run()
  {
    $products = 20;
    $suppliers = 5;
    $customer = 10;
    $staffs = 10;
    $expenses = 15;
    $waybills = 100;
    $faker = Factory::create();
    $faker->addProvider(new Commerce($faker));
    $barcode = new Barcode($faker);




  }
}
