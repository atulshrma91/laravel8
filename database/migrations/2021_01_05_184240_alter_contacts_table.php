<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contacts', function (Blueprint $table) {
            $table->dropColumn(['uuid']);
            $table->integer('account_id')->nullable()->after('user_id');
            $table->integer('role_id')->nullable()->after('account_id');
            $table->string('first_name')->nullable()->after('role_id');
            $table->string('last_name')->nullable()->after('first_name');
            $table->string('email')->nullable()->after('last_name');
            $table->string('telephone')->nullable()->after('email');
            $table->string('website')->nullable()->after('telephone');
            $table->string('company')->nullable()->after('website');
            $table->string('address')->nullable()->after('company');
            $table->string('company_telephone')->nullable()->after('address');
            $table->string('company_email')->nullable()->after('company_telephone');
            $table->string('profile_image')->nullable()->after('company_email');
            $table->string('logo')->nullable()->after('profile_image');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('contacts', function (Blueprint $table) {
            $table->dropColumn('account_id');
            $table->dropColumn('role_id');
            $table->dropColumn('first_name');
            $table->dropColumn('last_name');
            $table->dropColumn('email');
            $table->dropColumn('telephone');
            $table->dropColumn('website');
            $table->dropColumn('company');
            $table->dropColumn('address');
            $table->dropColumn('company_telephone');
            $table->dropColumn('company_email');
            $table->dropColumn('profile_image');
            $table->dropColumn('logo');
        });
    }
}
