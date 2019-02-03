<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDescriptionAccessesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('description_accesses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('main_route')->nullable();
            $table->string('route')->nullable();
            $table->string('description')->nullable();
            $table->boolean('enabled')->default(1);
            $table->boolean('module')->default(1);
            $table->integer('menu_id')->nullable();
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
        Schema::dropIfExists('description_accesses');
    }
}
