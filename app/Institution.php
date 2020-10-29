<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Institution extends Model
{
    protected $table = 'institution';

    protected $fillable = [
        'institution_name', 'institution_code', 'max_response', 'response'
    ];
}
