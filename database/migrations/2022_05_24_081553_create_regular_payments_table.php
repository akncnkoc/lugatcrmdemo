<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up()
    {
        Schema::create('regular_payments', function (Blueprint $table) {
            $table->id();
            $table->text('name');
            $table->text('comment')->nullable();
            $table->foreignId('regular_payment_type_id');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('regular_payments');
    }
};
