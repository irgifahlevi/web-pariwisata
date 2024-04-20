<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    use HasFactory;
    protected $fillable = [
        'province_name',
        'title',
        'descriptions',
        'image_province',
        'row_status'
    ];

    public function destination()
    {
        return $this->hasMany(Destination::class, 'province_id', 'id');
    }
}
