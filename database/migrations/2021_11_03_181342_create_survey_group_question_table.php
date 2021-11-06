<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSurveyGroupQuestionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('survey_group_question', function (Blueprint $table) {
            $table->id();        

            $table->enum('dimensi',['commitment', 'leadership', 'responsibility', 'engagement', 'risk', 'competence', 'informationcommunication', 'organizationallearning']);
            $table->unsignedBigInteger('category_id');
            $table->integer('no_question');
            $table->string('keyword');
            $table->text('text_question');
            $table->string('option_1');
            $table->string('option_2');
            $table->string('option_3');
            $table->string('option_4');
            $table->string('option_5');
            
            $table->unsignedBigInteger('institution_id');
            $table->unsignedBigInteger('survey_question_id')->nullable();
            $table->timestamps();

            $table->foreign('institution_id')->references('id')->on('institution');
            $table->foreign('category_id')->references('id')->on('survey_category');
            $table->foreign('survey_question_id')->references('id')->on('survey_question');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('survey_group_question');
    }
}
