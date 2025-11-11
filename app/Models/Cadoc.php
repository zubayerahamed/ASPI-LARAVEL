<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cadoc extends Model
{
    protected $fillable = [
        'file_name',
        'original_file_name',
        'file_extension',
        'media_type',
        'file_size',
        'compressed_file_size',
        'original_file_size_bytes',
        'compressed_file_size_bytes',
        'compression_ratio',
        'file_path',
        'file_path_compressed',
        'alternative_name',
        'caption',
        'description',
        'use_for_global',
        'temp',
    ];
}
