<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateForeignKeyForTblRoleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tbl_role', function (Blueprint $table) {
            $table->foreign('actor_id')->references('id')->on('tbl_actor')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::table('tbl_role', function (Blueprint $table) {
            $table->dropForeign('actor_id');
            $table->dropForeign('poster_id');
        });
    }
}
