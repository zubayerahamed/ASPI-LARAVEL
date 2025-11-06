<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Screen extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'xscreen',
        'title',
        'icon',
        'keywords',
        'type',
        'xnum',
        'seqn',
    ];

}
