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
        Schema::table('selled_items', function (Blueprint $table) {
            $table->unsignedTinyInteger('is_service')->default(0)->after('tax');
            $table->string('ref_id')->nullable()->after('is_service');
            $table->double('input_price')->default(0)->after('ref_id');
            $table->double('cost_price')->default(0)->after('input_price');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('selled_items', function (Blueprint $table) {
            $table->dropColumn('is_service');
            $table->dropColumn('ref_id');
            $table->dropColumn('input_price');
            $table->dropColumn('cost_price');
        });
    }
};
