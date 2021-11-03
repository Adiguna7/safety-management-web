<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Solutions extends Model
{
    protected $table = 'solutions';

    protected $fillable = [
        'dimensi', 'solution', 'article', 'tahun', 'author', 'link_doi', 'company_background', 'keterangan'
    ];
}
