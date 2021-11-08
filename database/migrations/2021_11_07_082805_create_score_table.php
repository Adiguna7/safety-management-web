<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScoreTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('score', function (Blueprint $table) {
            $table->id();
            $table->enum('dimensi',['commitment', 'leadership', 'responsibility', 'engagement', 'risk', 'competence', 'informationcommunication', 'organizationallearning']);
            $table->string('score_angka')->default('0');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('institution_id');            
            
            $table->timestamps();            
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('institution_id')->references('id')->on('institution');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('score');
    }
}
