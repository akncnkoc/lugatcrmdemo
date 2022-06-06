<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoiceProductsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('invoice_products', function (Blueprint $table) {
      $table->id();
      $table->foreignId('invoice_id')
        ->nullable();
      $table->foreignId('product_id');
      $table->text('product_code')
        ->nullable();
      $table->decimal('price', 15)
        ->nullable();
      $table->foreignId('cash_register_id')
        ->nullable();
      $table->foreignId('safe_id')
        ->nullable();
      $table->foreignId('safe_log_id')
        ->nullable();
      $table->integer('tax')
        ->default(0)
        ->nullable();
      $table->foreignId('cargo_id')->nullable();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('invoice_products');
  }
}
