<?php

namespace Database\Seeders;

use App\Models\Cargo;
use App\Models\CargoCompany;
use App\Models\CargoType;
use App\Models\CashRegister;
use App\Models\Customer;
use App\Models\IncomingWaybillProduct;
use App\Models\Invoice;
use App\Models\Safe;
use Faker\Factory;
use Illuminate\Database\Seeder;

class InvoiceSeeder extends Seeder
{
  public function run()
  {
    $faker = Factory::create();
    foreach (range(1, 50) as $item) {
      $isCargo = $faker->boolean;
      $invoice = Invoice::create([
        'description' => $faker->sentence,
        'customer_id' => Customer::inRandomOrder()
          ->first()->id,
        'invoice_date' => $faker->dateTimeBetween("-1 years", "+1 years", "Europe/Istanbul"),
        'invoice_contract_number' => $faker->numberBetween(1, 1500000),
        'has_cargo' => $isCargo
      ]);
      $totaledPrices = [];
      $cargo = null;
      if ($isCargo) {
        $paided = $faker->boolean;
        $cargoArray = [
          'price' => $faker->numberBetween(100, 500),
          'due_date' => $faker->dateTimeBetween('-1 years', '+1 years'),
          'cargo_type_id' => CargoType::inRandomOrder()
            ->first()->id,
          'cargo_company_id' => CargoCompany::inRandomOrder()
            ->first()->id,
          'tracking_number' => $faker->numberBetween(1, 555555555),
          'amount' => $faker->numberBetween(1, 10),
          'amount_type_id' => CargoType::inRandomOrder()
            ->first()->id,
          'description' => $faker->sentence,
          'safe_id' => Safe::inRandomOrder()
            ->first()->id,
          'invoice_id' => $invoice->id,
          'paided' => $paided,
          'date_of_paid' => $paided ? $faker->dateTimeBetween('-1 years', '+1 years') : null
        ];
        $cargo = Cargo::create($cargoArray);
      }
      foreach (range(1, 4) as $invoiceProduct) {
        $incoming_waybill_product = IncomingWaybillProduct::where('sold', false)
          ->where('rebate', false)
          ->inRandomOrder()
          ->first();
        $invoice->invoice_products()
          ->create([
            'invoice_id' => $invoice->id,
            'product_code' => $incoming_waybill_product->product_code,
            'product_id' => $incoming_waybill_product->product->id,
            'safe_id' => $incoming_waybill_product->product->sale_price_safe_id,
            'tax' => $faker->randomElement([0, 1, 8, 18]),
            'cash_register_id' => CashRegister::inRandomOrder()
              ->first()->id,
            'price' => mt_rand(100 * pow(10, 2), rand(500, $incoming_waybill_product->product->sale_price) * pow(10,
                  2)) /
              pow(10, 2),
            'cargo_id' => $isCargo ? $cargo->id : null
          ]);
      }
    }
  }
}
