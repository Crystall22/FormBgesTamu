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
            $table->string('guest_name'); // name of the guest
            $table->string('guest_phone'); // guest's phone number
            $table->string('guest_address'); // guest's address
            $table->string('institution'); // institution
            $table->date('date'); // form submission date
            $table->text('purpose'); // purpose of the visit
            $table->string('pdf_file'); // uploaded PDF file
            $table->string('category'); // category (Business, Government, Enterprise)
            $table->string('invoice_number'); // unique invoice number
            $table->timestamps(); // created_at and updated_at
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
