<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Suggestion extends Model
{
    use HasFactory;
    protected $fillable = [
        'destination_id',
        'name',
        'email',
        'descriptions',
        'row_status'
    ];

    public function destinationSuggestion()
    {
        return $this->belongsTo(Destination::class, 'destination_id', 'id');
    }
}
