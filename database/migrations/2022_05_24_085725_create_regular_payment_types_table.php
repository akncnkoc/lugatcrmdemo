<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up()
  {
    Schema::create('regular_payment_types', function (Blueprint $table) {
      $table->id();
      $table->text('name');
    });
  }

  public function down()
  {
    Schema::dropIfExists('regular_payment_types');
  }
};
