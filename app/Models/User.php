<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class User extends Authenticatable implements MustVerifyEmail{

    use HasFactory;
    protected $table = 'users';
    protected $primaryKey = 'uni_id';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'uni_id',
        'fname',
        'lname',
        'email',
        'password',
    ];
}
