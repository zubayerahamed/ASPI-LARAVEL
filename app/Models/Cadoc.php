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

    /**
     * Get the compressed file URL
     */
    public function getCompressedFileAttribute()
    {
        if (self::isImageFile()) {
            return "/storage" . $this->file_path_compressed . $this->file_name;
        }

        // For non-image files, return the original file
        return $this->file;
    }

    /**
     * Get the original file URL
     */
    public function getOriginalFileAttribute()
    {
        if (self::isImageFile()) {
            return "/storage" . $this->file_path . $this->file_name;
        }

        return $this->file;
    }

    public function isImageFile()
    {
        $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'ico'];
        return in_array(strtolower($this->file_extension), $imageExtensions);
    }
}
