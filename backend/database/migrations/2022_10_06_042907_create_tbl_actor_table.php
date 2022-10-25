<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblActorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_actor', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('media_id')->nullable();
            $table->string('name');
            $table->string('born');
            $table->string('height');
            $table->string('type');
            $table->longText('bio');
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
        Schema::dropIfExists('tbl_actor');
    }
}
