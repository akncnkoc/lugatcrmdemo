<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up()
    {
        Schema::create('supplier_payments', function (Blueprint $table) {
            $table->id();
            $table->decimal('price', 15)->default(0);
            $table->boolean('payable')->default(false);
            $table->dateTime('date')->default(now())->nullable();
            $table->text('description')->nullable();
            $table->foreignId('supplier_id');
            $table->foreignId('safe_id');
            $table->foreignId('safe_log_id')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
    public function down()
    {
        Schema::dropIfExists('supplier_payments');
    }
};
