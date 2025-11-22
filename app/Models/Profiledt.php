<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profiledt extends Model
{
    protected $fillable = [
        'profile_id',
        'menu_screen_id',
        'business_id',
    ];

    public function profile()
    {
        return $this->belongsTo(Profile::class);
    }

    public function menuScreen()
    {
        return $this->belongsTo(MenuScreen::class);
    }

    public function business()
    {
        return $this->belongsTo(Business::class);
    }
}
