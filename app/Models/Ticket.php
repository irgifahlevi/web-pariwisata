<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;
    protected $fillable = [
        'destination_id',
        'transaction_code',
        'name',
        'email',
        'capacity',
        'row_status'
    ];


    public function destinationTicket()
    {
        return $this->belongsTo(Destination::class, 'destination_id', 'id');
    }
}
