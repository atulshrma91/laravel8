<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contacts', function (Blueprint $table) {
          $table->dropColumn('role_id');
          $table->string('uuid')->nullable()->after('id');
          $table->string('role')->nullable()->after('account_id');
          $table->string('cvr_number')->nullable()->after('company');
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
          $table->dropColumn('uuid');
          $table->dropColumn('role');
          $table->dropColumn('cvr_number');
        });
    }
}
