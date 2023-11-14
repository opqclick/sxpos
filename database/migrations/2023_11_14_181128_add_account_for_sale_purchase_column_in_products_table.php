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
        Schema::table('products', function (Blueprint $table) {
            $table->unsignedBigInteger('account_for_sale')->nullable()->after('is_service');
            $table->unsignedBigInteger('account_for_purchase')->nullable()->after('account_for_sale');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            if (Schema::hasColumn('products', 'account_for_sale')) {
                $table->dropColumn('account_for_sale');
            }
            if (Schema::hasColumn('products', 'account_for_purchase')) {
                $table->dropColumn('account_for_purchase');
            }
        });
    }
};
