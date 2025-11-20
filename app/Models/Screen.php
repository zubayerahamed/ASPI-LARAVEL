<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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
    ];

    public function menus()
    {
        return $this->belongsToMany(Menu::class, 'menu_screens', 'screen_id', 'menu_id');
    }

}
