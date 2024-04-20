<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    use HasFactory;
    protected $fillable = [
        'destination_id',
        'title',
        'descriptions',
        'image_gallery',
        'row_status'
    ];

    public function destinationGallery()
    {
        return $this->belongsTo(Destination::class, 'destination_id', 'id');
    }
}
