<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePembobotanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pembobotan', function (Blueprint $table) {
            $table->id();
            $table->string('nilai_expert')->default('50');
            $table->string('nilai_users')->default('50');
            $table->unsignedBigInteger('institution_id');

            $table->foreign('institution_id')->references('id')->on('institution');

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
        Schema::dropIfExists('pembobotan');
    }
}
