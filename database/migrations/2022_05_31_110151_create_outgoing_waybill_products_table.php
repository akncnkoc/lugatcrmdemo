<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up()
    {
        Schema::create('outgoing_waybill_products', function (Blueprint $table) {
            $table->id();
            $table->decimal('sale_price', 15)->default(0);
            $table->boolean('rebate')->default(false);
            $table->dateTime('rebate_date')->nullable();
            $table->text('rebate_note')->nullable();
            $table->foreignId('product_id');
            $table->foreignId('waybill_id');
            $table->foreignId('sale_price_safe_id');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('outgoing_waybill_products');
    }
};
