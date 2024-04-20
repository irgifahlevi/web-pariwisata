<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Detail extends Model
{
    use HasFactory;
    protected $fillable = [
        'destination_id',
        'title',
        'descriptions',
        'url_locations',
        'row_status',
    ];

    public function destination()
    {
        return $this->belongsTo(Destination::class, 'destination_id', 'id');
    }
}
