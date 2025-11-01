<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Screen extends Model
{
    protected $fillable = [
        'xscreen',
        'title',
        'icon',
        'keywords',
        'type',
        'xnum',
        'seqn',
        'business_id',
    ];

    public function business()
    {
        return $this->belongsTo(Business::class, 'business_id', 'id');
    }

    // unique
    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $exists = Screen::where('xscreen', $model->xscreen)
                ->where('business_id', $model->business_id)
                ->exists();

            if ($exists) {
                throw new \Exception('The screen code must be unique per business.');
            }
        });
    }
}
