<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVehicleGeneralSpecsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicle_general_specs', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('spec_category_id')->unsigned()->nullable();
            $table->bigInteger('vehicle_id')->unsigned()->nullable();
            $table->bigInteger('scrapped_spec_id')->unsigned()->nullable();
            $table->string('value', 190)->nullable();
            $table->enum('status', ['active', 'new', 'pending', 'delete'])->default('new');
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
        Schema::dropIfExists('vehicle_general_specs');
    }
}
