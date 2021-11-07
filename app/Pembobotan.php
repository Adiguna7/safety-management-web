<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pembobotan extends Model
{
    protected $table = 'pembobotan';

    protected $fillable = [
        'nilai_expert', 'nilai_users', 'institution_id'
    ];

    protected $casts = [
        'nilai_expert' => 'integer',
        'nilai_users' => 'integer',
    ];
}
