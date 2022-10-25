<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateForeignKeyForTblEpisodeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tbl_episode', function (Blueprint $table) {
            $table->unsignedBigInteger('thumbnail_id')->nullable();
            $table->foreign('media_id')->references('id')->on('tbl_media')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('thumbnail_id')->references('id')->on('tbl_media')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('season_id')->references('id')->on('tbl_season')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tbl_episode', function (Blueprint $table) {
            $table->dropColumn('thumbnail_id');
            $table->dropForeign(['media_id', 'thumbnail_id', 'season_id']);
        });
    }
}
