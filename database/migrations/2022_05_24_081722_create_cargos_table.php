<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up()
    {
        Schema::create('cargos', function (Blueprint $table) {
            $table->id();
            $table->text('tracking_number')->nullable();
            $table->double('amount')->default(0);
            $table->text('description')->nullable();
            $table->decimal('price', 15)->default(0);
            $table->boolean('paided')->default(false);
            $table->dateTime('date_of_paid')->nullable();
            $table->dateTime('due_date')->nullable();
            $table->dateTime('future_shipping_date')->nullable();
            $table->foreignId('invoice_id')->nullable();
            $table->foreignId('cargo_company_id');
            $table->foreignId('cargo_type_id');
            $table->foreignId('safe_id');
            $table->foreignId('safe_log_id')->nullable();
            $table->foreignId('amount_type_id');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('cargos');
    }
};
