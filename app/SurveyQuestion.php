<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SurveyQuestion extends Model
{
    protected $table = 'survey_question';

    protected $fillable = [
        'category', 'no_question', 'keyword', 'text_question', 'option1', 'option2', 'option3', 'option4', 'option5'
    ];
}
