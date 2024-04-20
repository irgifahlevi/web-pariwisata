<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Destination extends Model
{
    use HasFactory;
    protected $fillable = [
        'province_id',
        'title',
        'destination_name',
        'image_destination',
        'rating',
        'row_status'
    ];

    public function province()
    {
        return $this->belongsTo(Province::class, 'province_id', 'id');
    }

    public function detail()
    {
        return $this->hasOne(Detail::class, 'destination_id', 'id');
    }

    public function gallery()
    {
        return $this->hasMany(Gallery::class, 'destination_id', 'id');
    }
}
