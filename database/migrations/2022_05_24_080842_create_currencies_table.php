<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up()
    {
        Schema::create('currencies', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code');
            $table->decimal('unit');
            $table->float('forex_buy', 15, 5)->default(0);
            $table->float('forex_sell', 15, 5)->default(0);
            $table->float('banknote_buy', 15, 5)->default(0);
            $table->float('banknote_sell', 15, 5)->default(0);
            $table->boolean('primary')->default(false);
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('currencies');
    }
};
