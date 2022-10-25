<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblRoleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_role', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('poster_id')->nullable();
            $table->unsignedBigInteger('actor_id')->nullable();
            $table->string('role');
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
        Schema::dropIfExists('tbl_role');
    }
}
