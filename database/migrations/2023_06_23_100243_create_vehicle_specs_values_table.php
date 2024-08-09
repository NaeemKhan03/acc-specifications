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
        Schema::create('vehicle_specs_values', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('spec_category_id')->unsigned()->nullable();
            $table->unsignedBigInteger('vehicle_id')->unsigned()->nullable();
            $table->unsignedBigInteger('scrapped_spec_id')->unsigned()->nullable();
            $table->string('specs_value')->nullable();
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
        Schema::dropIfExists('vehicle_specs_values');
    }
};
