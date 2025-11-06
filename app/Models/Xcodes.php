<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Xcodes extends Model
{
    protected $table = 'xcodes';

    protected $fillable = [
        'type',
        'xcode',
        'description',
        'seqn',
    ];
}
