<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up()
  {
    Schema::create('supplier_regular_payment_periods', function (Blueprint $table) {
      $table->id();
      $table->dateTime('date')->default(now());
      $table->decimal('price', 15)->default(0);
      $table->boolean('completed')->default(false);
      $table->foreignId('supplier_regular_payment_id');
      $table->foreignId('safe_id');
      $table->foreignId('safe_log_id')->nullable();
      $table->timestamps();
    });
  }

  public function down()
  {
    Schema::dropIfExists('supplier_regular_payment_periods');
  }
};
