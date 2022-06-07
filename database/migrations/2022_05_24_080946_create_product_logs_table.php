<?php

use App\AppHelper;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up()
  {
    Schema::create('product_logs', function (Blueprint $table) {
      $table->id();
      $table->text('content')->default('');
      $table->dateTime('date')->default(now())->nullable();
      $table->enum('process_type', [AppHelper::PRODUCT_IN, AppHelper::PRODUCT_OUT, AppHelper::PRODUCT_REBATE, AppHelper::PRODUCT_SOLD]);
      $table->foreignId('product_id');
      $table->foreignId('waybill_id');
      $table->timestamps();
      $table->softDeletes();
    });
  }

  public function down()
  {
    Schema::dropIfExists('product_logs');
  }
};
