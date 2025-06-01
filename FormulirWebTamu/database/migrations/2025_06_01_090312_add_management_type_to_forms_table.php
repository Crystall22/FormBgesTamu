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
        Schema::table('forms', function (Blueprint $table) {
            $table->string('forwarded_to_management_type')->nullable()->after('forwarded_to_management');
        });
    }
    public function down()
    {
        Schema::table('forms', function (Blueprint $table) {
            $table->dropColumn('forwarded_to_management_type');
        });
    }

};
