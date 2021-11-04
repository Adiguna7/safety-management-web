<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SurveyQuestion extends Model
{
    protected $table = 'survey_question';

    protected $fillable = [
        'category_id', 'no_question', 'keyword', 'text_question', 'option_1', 'option_2', 'option_3', 'option_4', 'option_5'
    ];
}
