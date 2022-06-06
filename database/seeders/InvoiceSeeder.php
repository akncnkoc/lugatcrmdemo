<?php

namespace Database\Seeders;

use App\Models\Cargo;
use App\Models\CargoCompany;
use App\Models\CargoType;
use App\Models\CashRegister;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\InvoiceProduct;
use App\Models\InvoiceStaff;
use App\Models\Safe;
use App\Models\Staff;
use App\Models\SubProduct;
use Faker\Factory;
use Illuminate\Database\Seeder;

class InvoiceSeeder extends Seeder
{
  public function run()
  {
    $faker = Factory::create();
    foreach (range(1, 20) as $item) {
      $isCargo = $faker->boolean;
      $invoice = Invoice::create([
        'description' => $faker->sentence,
        'customer_id' => Customer::inRandomOrder()->first()->id,
        'invoice_date' => $faker->dateTimeBetween("-1 years", "+1 years", "Europe/Istanbul"),
        'invoice_contract_number' => $faker->numberBetween(1, 1500000),
        'has_cargo' => $isCargo
      ]);
      $totaledPrices = [];
      $cargo = null;
      foreach (range(1, 2) as $invoiceStaff) {
        $invoice->invoice_staffs()->create([
          'invoice_id' => $invoice->id,
          'staff_id' => Staff::inRandomOrder()->first()->id,
          'staff_share' => $faker->randomElement([12.5, 15, 20, 25])
        ]);
      }
      if ($isCargo) {
        $paided = $faker->boolean;
        $cargoArray = [
          'price' => $faker->numberBetween(100, 500),
          'due_date' => $faker->dateTimeBetween('-1 years', '+1 years'),
          'cargo_type_id' => CargoType::inRandomOrder()->first()->id,
          'cargo_company_id' => CargoCompany::inRandomOrder()->first()->id,
          'tracking_number' => $faker->numberBetween(1, 555555555),
          'amount' => $faker->numberBetween(1, 10),
          'amount_type_id' => CargoType::inRandomOrder()->first()->id,
          'description' => $faker->sentence,
          'safe_id' => Safe::inRandomOrder()->first()->id,
          'invoice_id' => $invoice->id,
          'paided' => $paided,
          'date_of_paid' => $paided ? $faker->dateTimeBetween('-1 years', '+1 years') : null
        ];
        $cargo = Cargo::create($cargoArray);
      }
      foreach (range(1, 1) as $invoiceProduct) {
        $sub_product = SubProduct::where('sold', false)->where('rebate', false)->inRandomOrder()->first();
        $invoice_product = $invoice->invoice_products()->create([
          'invoice_id' => $invoice->id,
          'product_code' => $sub_product->product_code,
          'product_id' => $sub_product->product->id,
          'safe_id' => $sub_product->product->sale_price_safe_id,
          'tax' => $faker->randomElement([0, 1, 8, 18]),
          'cash_register_id' => CashRegister::inRandomOrder()->first()->id,
          'price' => $sub_product->product->sale_price,
          'cargo_id' => $isCargo ? $cargo->id : null
        ]);
      }
      $invoice->invoice_products()->each(function (InvoiceProduct $invoiceProduct) use ($invoice) {

        $invoice->invoice_staffs()->each(function (InvoiceStaff $invoiceStaff) use (&$invoice, &$invoiceProduct) {
          $share_price = ($invoiceProduct->price / 100) * $invoiceStaff->staff_share;
          $invoice->invoice_staff_payments()->create([
            'invoice_id' => $invoice->id,
            'staff_id' => $invoiceStaff->staff_id,
            'staff_share' => $invoiceStaff->staff_share,
            'share_safe_id' => $invoiceProduct->safe->id,
            'share_price' => $share_price,
            'product_code' => $invoiceProduct->product_code
          ]);
        });
      });
    }
  }
}
