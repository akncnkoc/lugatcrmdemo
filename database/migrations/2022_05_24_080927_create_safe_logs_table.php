<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up()
    {
        Schema::create('safe_logs', function (Blueprint $table) {
            $table->id();
            $table->text('content')->nullable();
            $table->decimal('price', 15)->default(0);
            $table->decimal('normal_price', 15)->default(0);
            $table->integer('process_type');
            $table->decimal('commission', 15)->default(0);
            $table->dateTime('date')->default(now())->nullable();
            $table->foreignId('safe_id');
            $table->foreignId('cash_register_id')->nullable();
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('safe_logs');
    }
};
