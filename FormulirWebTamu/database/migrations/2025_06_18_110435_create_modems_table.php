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
        Schema::create('modems', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal_terima');
            $table->date('tanggal_keluar')->nullable();
            $table->string('id_pelanggan');
            $table->string('serial_number_modem');
            $table->string('provider_modem')->default('other'); // Default to 'other' if not specified
            $table->string('stb_id');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('modems');
    }
};
