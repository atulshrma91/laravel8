<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToUserExtensionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_extensions', function (Blueprint $table) {
            $table->boolean('on_trial')->after('extension_payment_id')->default(true);
            $table->integer('trial_expiry_days')->after('on_trial');
            $table->dateTime('extension_expiry')->after('trial_expiry_days')->default(NOW());
            $table->boolean('is_expired')->after('extension_expiry')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_extensions', function (Blueprint $table) {
            $table->dropColumn('on_trial');
            $table->dropColumn('trial_expiry_days');
            $table->dropColumn('extension_expiry');
        });
    }
}
