<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateForeignKeyForTblSlideTableVer2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tbl_slide', function (Blueprint $table) {
            $table->foreign('poster_id')->references('id')->on('tbl_poster')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('media_id')->references('id')->on('tbl_media')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('genre_id')->references('id')->on('tbl_genre')->onDelete('cascade')->onUpdate('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tbl_slide', function (Blueprint $table) {
            $table->dropForeign('poster_id');
            $table->dropForeign('media_id');
            $table->dropForeign('genre_id');

        });
    }
}
