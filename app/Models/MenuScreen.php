<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MenuScreen extends Model
{
    protected $fillable = [
        'menu_id',
        'screen_id',
        'business_id',
        'alternate_title',
        'seqn',
    ];

    public function menu()
    {
        return $this->belongsTo(Menu::class, 'menu_id', 'id');
    }

    public function screen()
    {
        return $this->belongsTo(Screen::class, 'screen_id', 'id');
    }
}
