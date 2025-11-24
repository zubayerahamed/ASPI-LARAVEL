<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BusinessUnit extends Model
{
    protected $fillable = [
        'name',
        'description',
        'seqn',
        'business_id',
    ];

    public function business()
    {
        return $this->belongsTo(Business::class);
    }
}
