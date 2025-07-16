<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnnualCoffeeSale extends Model
{
    protected $table= 'annual_coffee_sales';
    protected $fillable = [
        'year',
        'value_usd',
        'bags_60kg',
        'metric_tonnes',
        'unit_value_usd_per_kg'
    ];
}
