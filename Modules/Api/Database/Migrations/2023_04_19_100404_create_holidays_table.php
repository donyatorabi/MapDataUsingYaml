<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('holidays', function (Blueprint $table) {
            $table->id();
            $table->date('date_holiday')->nullable();
            $table->string('local_name')->nullable();
            $table->string('name_holiday')->nullable();
            $table->string('country_code')->nullable();
            $table->boolean('fixed')->nullable();
            $table->boolean('global')->nullable();
            $table->integer('launch_year')->nullable();
            $table->string('type_holiday')->nullable();

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
        Schema::dropIfExists('holidays');
    }
};
