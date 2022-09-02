<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormCustomizedFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('form_customized_fields', function (Blueprint $table) {
            $table->id();
            $table->integer('form_id')->nullable();
            $table->string('name')->nullable();
            $table->string('type')->nullable();
            $table->boolean('is_required')->nullable();
            $table->boolean('is_displayed')->nullable();
            $table->text('option_name')->nullable();
            $table->string('options_selection')->nullable();
            $table->string('options_selection_choice')->nullable();
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
        Schema::dropIfExists('form_customized_fields');
    }
}
