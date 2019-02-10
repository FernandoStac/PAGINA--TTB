<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddToDocuments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('documents', function (Blueprint $table) {
            $table->integer('id_v1')->nullable();
            $table->boolean('v_1')->nullable();
            $table->string('observ_1')->nullable();
            $table->integer('id_v2')->nullable();
            $table->boolean('v_2')->nullable();
            $table->string('observ_2')->nullable();
            $table->integer('id_v3')->nullable();
            $table->boolean('v_3')->nullable();
            $table->string('observ_3')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('documents', function (Blueprint $table) {
            //
        });
    }
}
