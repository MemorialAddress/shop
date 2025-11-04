<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RetryPurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('purchases', function (Blueprint $table) {
            $table->string('purchase_post_code')->nullable()->after('payment_method');
            $table->string('purchase_address')->nullable()->after('purchase_post_code');
            $table->string('purchase_building')->nullable()->after('purchase_address');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('purchases', function (Blueprint $table) {

            $table->dropColumn([
                'purchase_post_code',
                'purchase_address',
                'purchase_building',
            ]);
        });
    }
}
