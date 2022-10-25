<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblSlideTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_slide', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('poster_id');
            $table->unsignedBigInteger('genre_id');
            $table->unsignedBigInteger('media_id');
            $table->string('title');
            $table->string('url')->nullable();
            $table->string('type');
            $table->integer('position');
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
        Schema::dropIfExists('tbl_slide');
    }
}
