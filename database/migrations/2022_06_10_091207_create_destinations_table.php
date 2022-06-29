<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDestinationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('destinations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->double('longtitude');
            $table->double('latitude');
            $table->string('name_location');
            $table->string('note')->nullable();
            $table->integer('category_id');
            $table->string('number_contact')->nullable();
            $table->string('location')->nullable();
            $table->string('image_url');
            $table->boolean('is_favourite');
            $table->boolean('is_schedule');
            $table->integer('user_id');
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
        Schema::dropIfExists('destinations');
    }
}
