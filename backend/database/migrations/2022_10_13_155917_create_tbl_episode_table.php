<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblEpisodeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_episode', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('season_id')->nullable();
            $table->unsignedBigInteger('media_id')->nullable();
            $table->string('title');
            $table->longText('description')->nullable();
            $table->string('duration')->nullable();
            $table->boolean('enabled');
            $table->integer('position');
            $table->integer('views');
            $table->string('slug');
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
        Schema::dropIfExists('tbl_episode');
    }
}
