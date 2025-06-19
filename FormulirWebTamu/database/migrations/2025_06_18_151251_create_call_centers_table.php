<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('call_centers', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('phone_number', 15);
            $table->string('connection_type', 15);
            $table->string('category', 50);
            $table->text('purpose');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('call_centers');
    }
};
