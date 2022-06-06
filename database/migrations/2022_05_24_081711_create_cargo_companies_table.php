<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up()
  {
    Schema::create('cargo_companies', function (Blueprint $table) {
      $table->id();
      $table->text('name');
      $table->text('photo_path');
    });
  }

  public function down()
  {
    Schema::dropIfExists('cargo_companies');
  }
};
