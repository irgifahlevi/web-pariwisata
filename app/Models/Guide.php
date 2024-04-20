<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guide extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'guide_name',
        'descriptions',
        'image_guide',
        'url_instagram',
        'url_facebook',
        'url_whatsapp',
        'row_status'
    ];
}
