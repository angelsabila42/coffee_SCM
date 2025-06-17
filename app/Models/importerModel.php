<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class importerModel extends Model
{
      protected $fillable = [
          'name',
        'email',
        'password',
         'country',
        'phone_number',
        'address',
        'confirm password',
     ];
}
