<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up()
  {
    Schema::create('outgoing_waybills', function (Blueprint $table) {
      $table->id();
      $table->foreignId('customer_id');
      $table->timestamp('waybill_date')->default(now());
      $table->timestamps();
    });
  }

  public function down()
  {
    Schema::dropIfExists('outgoing_waybills');
  }
};
