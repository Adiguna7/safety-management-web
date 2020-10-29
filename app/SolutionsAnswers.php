<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SolutionsAnswers extends Model
{
    protected $table = 'solutions_answers';

    protected $fillable = [
        'user_id', 'solution_id', 'institution_id', 'is_done'
    ];
}
