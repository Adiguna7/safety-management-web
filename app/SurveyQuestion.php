<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SurveyQuestion extends Model
{
    protected $table = 'survey_question';

    protected $fillable = [
        'dimensi', 'category_id', 'no_question', 'keyword', 'text_question', 'option_1', 'option_2', 'option_3', 'option_4', 'option_5'
    ];

    protected $casts = [
        'id' => 'integer',
        'dimensi' => 'string',
        'category_id' => 'integer',
        'no_question' => 'integer',
        'keyword' => 'string',
        'text_question' => 'string',
        'option_1' => 'string',
        'option_2' => 'string',
        'option_3' => 'string',
        'option_4' => 'string',
        'option_5' => 'string',        
        'survey_question_id' => 'integer'
    ];
}
