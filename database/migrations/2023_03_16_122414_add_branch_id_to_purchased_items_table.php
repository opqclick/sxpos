<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('purchased_items', function (Blueprint $table) {
            $table->integer('branch_id')->default(0)->after('id');
            $table->integer('cash_register_id')->default(0)->after('branch_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('purchased_items', function (Blueprint $table) {
            //
        });
    }
};
