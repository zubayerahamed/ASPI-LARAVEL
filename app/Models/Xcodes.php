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
        'symbol',
        'seqn',
        'is_active',
        'business_id',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function business()
    {
        return $this->belongsTo(Business::class, 'business_id');
    }
}
