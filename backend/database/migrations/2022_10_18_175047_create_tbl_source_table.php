<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblSourceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_source', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('media_id')->nullable();
            $table->unsignedBigInteger('poster_id')->nullable();
            $table->unsignedBigInteger('episode_id')->nullable();
            $table->string('type')->nullable();
            $table->longText('url');
            $table->string('quality')->nullable();
            $table->string('title')->nullable();
            $table->string('kind')->nullable();
            $table->boolean('external')->nullable();
            $table->string('premium')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('tbl_source');
    }
}
