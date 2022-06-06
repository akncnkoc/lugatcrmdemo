<?php

namespace Database\Seeders;

use App\Models\ExpenseType;
use Illuminate\Database\Seeder;

class ExpenseTypeSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $expense_types = [
      'Fatura Elektrik',
      'Fatura İnternet',
      'Fatura Telefon',
      'Fatura Su',
      'Hamal',
      'Muhasebe',
      'Bağkur Ödemesi',
      'SSK Ödemesi',
      'Stopaj Ödemesi',
      'Vergi Ödemesi',
      'Mutfak Market',
      'Mutfak Çay Kahve',
      'Müşteri Rehber',
      'Müşteri Yemek',
      'Ofis Kırtasiye',
      'Temizlik Malzemesi',
      'Yemek Personel',
    ];
    foreach ($expense_types as $expense_type) {
      ExpenseType::create([
        'name' => $expense_type
      ]);
    }
  }
}
