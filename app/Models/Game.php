<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;
    protected $primaryKey = 'name';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'name',
        'start_time',
        'end_time',
        'session_duration',
        'sessions_capacity',
        'max_number_of_reservations'
    ];
}
