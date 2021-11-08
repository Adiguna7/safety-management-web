<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Score extends Model
{
    protected $table = 'score';

    protected $fillable = [
        'dimensi', 'score_angka', 'institution_id', 'user_id'
    ];

    protected $casts = [
        'score_angka' => 'float',        
    ];
}
