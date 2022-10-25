<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblPosterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_poster', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cover_id')->nullable();
            $table->unsignedBigInteger('poster_id')->nullable();
            $table->unsignedBigInteger('trailer_id')->nullable();
            $table->string('title');
            $table->string('duration')->nullable();
            $table->string('type');
            $table->longText('tags');
            $table->double('rating');
            $table->double('imdb')->nullable();
            $table->integer('year')->nullable();
            $table->longText('description');
            $table->integer('views');
            $table->boolean('enable');
            $table->boolean('comment');
            $table->string('slug');
            $table->string('label')->nullable();
            $table->string('subLabel')->nullable();
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
        Schema::dropIfExists('tbl_poster');
    }
}
