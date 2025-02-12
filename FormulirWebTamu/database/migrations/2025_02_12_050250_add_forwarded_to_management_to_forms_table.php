<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForwardedToManagementToFormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('forms', function (Blueprint $table) {
            // Adding a boolean column to indicate if the form is forwarded to management
            $table->boolean('forwarded_to_management')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('forms', function (Blueprint $table) {
            // Dropping the forwarded_to_management column when rolling back the migration
            $table->dropColumn('forwarded_to_management');
        });
    }
}
