<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateForeignKeyForTblPosterGenresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tbl_poster_genres', function (Blueprint $table) {
            $table->foreign('genre_id')->references('id')->on('tbl_genre')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('poster_id')->references('id')->on('tbl_poster')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tbl_poster_genres', function (Blueprint $table) {
            $table->dropForeign('genre_id');
            $table->dropForeign('poster_id');
        });
    }
}
