<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up()
    {
        Schema::create('product_types', function (Blueprint $table) {
            $table->id();
            $table->text('name');
            $table->text('initial_code');
        });
    }

    public function down()
    {
        Schema::dropIfExists('product_types');
    }
};
