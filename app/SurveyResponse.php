<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SurveyResponse extends Model
{
    protected $table = 'survey_response';

    protected $fillable = [
        'user_id', 'question_id', 'institution_id', 'answer'
    ];
}
