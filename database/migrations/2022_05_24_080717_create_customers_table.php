<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up()
  {
    Schema::create('customers', function (Blueprint $table) {
      $table->id();
      $table->string('name');
      $table->string('surname')->nullable();
      $table->string('email')->nullable();
      $table->string('phone')->nullable();
      $table->string('comment')->nullable();
      $table->longText('address')->nullable();
      $table->string('post_code')->nullable();
      $table->integer('gender')->default(1);
      $table->foreignId('customer_role_id')->nullable();
      $table->foreignId('country_id')->nullable();
      $table->foreignId('county_id')->nullable();
      $table->foreignId('district_id')->nullable();
      $table->timestamps();
      $table->softDeletes();
    });
  }

  public function down()
  {
    Schema::dropIfExists('customers');
  }
};
