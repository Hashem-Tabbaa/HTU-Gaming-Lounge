<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class User extends Authenticatable{

    use HasFactory;
    protected $table = 'users';
    protected $primaryKey = 'email';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'uni_id',
        'fname',
        'lname',
        'email',
    ];
    protected $hidden = [
        'password',
        'remember_token',
    ];
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

}
