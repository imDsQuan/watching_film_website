<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateForeignKeyForTblMediaGallerysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tbl_media_gallerys', function (Blueprint $table) {
            $table->foreign('media_id')->references('id')->on('tbl_media')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('gallery_id')->references('id')->on('tbl_gallery')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tbl_media_gallerys', function (Blueprint $table) {
            $table->dropForeign('media_id');
            $table->dropForeign('gallery_id');
        });
    }
}
