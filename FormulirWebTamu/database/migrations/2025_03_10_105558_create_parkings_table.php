<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParkingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parkings', function (Blueprint $table) {
            $table->id();
            $table->string('vehicle_name');
            $table->string('license_number');
            $table->string('status')->default('available');
            $table->string('borrower_name')->nullable();
            $table->integer('slot')->unique()->nullable(); // Ganti dari parking_location ke slot (integer, unique, nullable)
            $table->string('borrower_position')->nullable();
            $table->string('purpose')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('parkings');
    }
}
