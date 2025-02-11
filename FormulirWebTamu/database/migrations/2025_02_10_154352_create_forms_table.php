<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('forms', function (Blueprint $table) {
            $table->id(); // primary key
            $table->string('guest_name'); // nama tamu
            $table->string('guest_phone'); // nomor telepon tamu
            $table->string('guest_address'); // alamat tamu
            $table->string('institution'); // institusi asal tamu
            $table->date('date'); // tanggal pengisian form
            $table->text('purpose'); // tujuan kunjungan
            $table->string('pdf_file'); // file PDF yang diunggah
            $table->string('category'); // kategori form (Business, Government, Enterprise)
            $table->string('invoice_number'); // nomor invoice yang unik
            $table->text('note')->nullable(); // catatan untuk secretary, nullable karena bisa kosong
            $table->timestamps(); // waktu pembuatan dan update
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('forms');
    }
}
