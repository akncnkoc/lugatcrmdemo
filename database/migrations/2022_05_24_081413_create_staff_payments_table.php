<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up()
    {
        Schema::create('staff_payments', function (Blueprint $table) {
            $table->id();
            $table->decimal('price', 15);
            $table->dateTime('date')->default(now())->nullable();
            $table->longText('description')->nullable();
            $table->foreignId('safe_id');
            $table->foreignId('staff_id');
            $table->foreignId('staff_payment_type_id');
            $table->foreignId('safe_log_id')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
    public function down()
    {
        Schema::dropIfExists('staff_payments');
    }
};
