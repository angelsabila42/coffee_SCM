<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class vendor extends Model
{

    protected $table = 'vendor';

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone_number',
        'street',
        'city',
        'confirm password',
    ];

    

}
