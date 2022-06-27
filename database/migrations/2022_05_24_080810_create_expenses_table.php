<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up()
    {
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->decimal('price', 15)->default(0);
            $table->text('comment')->nullable();
            $table->dateTime('date')->default(now());
            $table->foreignId('expense_type_id')->nullable();
            $table->foreignId('safe_id')->nullable();
            $table->foreignId('safe_log_id')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('expenses');
    }
};
