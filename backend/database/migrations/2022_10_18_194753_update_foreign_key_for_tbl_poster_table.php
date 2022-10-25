<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateForeignKeyForTblPosterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tbl_poster', function (Blueprint $table) {
            $table->foreign('poster_id')->references('id')->on('tbl_media')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('cover_id')->references('id')->on('tbl_media')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('trailer_id')->references('id')->on('tbl_media')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tbl_poster', function (Blueprint $table) {
            $table->dropForeign('poster_id');
            $table->dropForeign('cover_id');
            $table->dropForeign('trailer_id');
        });
    }
}
