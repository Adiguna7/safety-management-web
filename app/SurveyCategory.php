<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SurveyCategory extends Model
{
    protected $table = 'survey_category';

    protected $fillable = [
        'nama'        
    ];

    protected $casts = [
        'nama' => 'string'
    ];
}
