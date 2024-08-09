<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScrappedSpecsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('scrapped_specs', function (Blueprint $table) {
            $table->id();
            $table->text('label');
            $table->unsignedBigInteger('category_id')->default(0)->index();
            $table->enum('status', ['active', 'new', 'pending', 'delete'])->default('new')->nullable();
            $table->unsignedBigInteger('user_id')->nullable()->index();
            $table->string('unit', 80)->nullable()->index();
            $table->timestamp('last_used')->nullable();
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
        Schema::dropIfExists('scrapped_specs');
    }
}
