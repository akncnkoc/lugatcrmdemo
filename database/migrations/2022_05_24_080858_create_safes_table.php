<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up()
  {
    Schema::create('safes', function (Blueprint $table) {
      $table->id();
      $table->string('name');
      $table->decimal('total', 15)->default(0);
      $table->foreignId('currency_id');
      $table->timestamps();
      $table->softDeletes();
    });
  }
  public function down()
  {
    Schema::dropIfExists('safes');
  }
};
