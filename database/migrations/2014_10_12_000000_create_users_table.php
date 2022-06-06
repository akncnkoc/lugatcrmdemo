<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up()
  {
    Schema::create('users', function (Blueprint $table) {
      $table->id();
      $table->string('name');
      $table->string('surname')->nullable();
      $table->string('email')->unique();
      $table->string('phone')->nullable();
      $table->string('company_name')->nullable();
      $table->string('username')->nullable();
      $table->string('password');
      $table->timestamps();
      $table->softDeletes();
    });
  }

  public function down()
  {
    Schema::dropIfExists('users');
  }
};
