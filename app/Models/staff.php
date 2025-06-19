<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class staff extends Model
{
    

    protected $fillable = [

        'name',
        'email',
        'phone_number',
        'role',
        'status',
        'password',
        'confirm password',

    ];
}
