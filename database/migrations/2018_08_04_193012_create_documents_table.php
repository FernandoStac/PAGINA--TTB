<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();;
            $table->string('uuid')->nullable();;
            $table->string('folio')->nullable();;
            $table->string('serie')->nullable();;
            $table->string('document');
            $table->string('url');
            $table->boolean('status')->default(true);
            $table->boolean('notification')->default(false);
            $table->date('date');
            $table->text('about')->nullable();
            $table->text('tipo')->nullable();
            $table->unsignedInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedInteger('parent_Document')->nullable();
            
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
        Schema::dropIfExists('documents');
    }
}
