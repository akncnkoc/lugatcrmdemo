<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up()
  {
    Schema::create('supplier_regular_payments', function (Blueprint $table) {
      $table->id();
      $table->text('name');
      $table->text('comment')->nullable();
      $table->foreignId('supplier_id');
      $table->timestamps();
      $table->softDeletes();
    });
  }

  public function down()
  {
    Schema::dropIfExists('supplier_regular_payments');
  }
};
