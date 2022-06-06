<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up()
  {
    Schema::create('products', function (Blueprint $table) {
      $table->id();
      $table->string('uuid')->nullable();
      $table->string('name');
      $table->string('model_code')->nullable();
      $table->decimal('buy_price')->default(0);
      $table->decimal('sale_price')->default(0);
      $table->integer('real_stock')->default(0);
      $table->boolean('critical_stock_alert')->default(false);
      $table->foreignId('buy_price_safe_id')->nullable();
      $table->foreignId('sale_price_safe_id')->nullable();
      $table->foreignId('product_type_id');
      $table->timestamps();
      $table->softDeletes();
    });
  }

  public function down()
  {
    Schema::dropIfExists('products');
  }
};
