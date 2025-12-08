<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Acsub extends Model
{
    protected $fillable = [
        'name',
        'description',
        'type',
        'group',
        'business_id',
    ];

    public function business()
    {
        return $this->belongsTo(Business::class);
    }
}
