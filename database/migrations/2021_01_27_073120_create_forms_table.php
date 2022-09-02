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
            $table->id();
            $table->string('name')->nullable();
            $table->integer('user_id')->nullable();
            $table->string('uuid')->nullable();
            $table->string('headline')->nullable();
            $table->mediumText('introduction')->nullable();
            $table->boolean('is_required_role');
            $table->boolean('is_displayed_role');
            $table->boolean('is_required_first_name');
            $table->boolean('is_displayed_first_name');
            $table->boolean('is_required_last_name');
            $table->boolean('is_displayed_last_name');
            $table->boolean('is_required_email');
            $table->boolean('is_displayed_email');
            $table->boolean('is_required_telephone');
            $table->boolean('is_displayed_telephone');
            $table->boolean('is_required_website');
            $table->boolean('is_displayed_website');
            $table->boolean('is_required_company');
            $table->boolean('is_displayed_company');
            $table->boolean('is_required_cvr_number');
            $table->boolean('is_displayed_cvr_number');
            $table->boolean('is_required_address');
            $table->boolean('is_displayed_address');
            $table->boolean('is_required_company_telephone');
            $table->boolean('is_displayed_company_telephone');
            $table->boolean('is_required_company_email');
            $table->boolean('is_displayed_company_email');
            $table->boolean('is_required_profile_image');
            $table->boolean('is_displayed_profile_image');
            $table->boolean('is_required_logo');
            $table->boolean('is_displayed_logo');
            $table->boolean('status');
            $table->timestamps();
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
