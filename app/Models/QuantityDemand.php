<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuantityDemand extends Model
{
    protected $fillable = ['importer_model_id','year','quantity_(60kg_bags)','yearsAsCustomer','orderFreqPerYear','avgOrderSize_kg'];

    public function importerModel(){
        return $this->belongsTo(importerModel::class, 'importer_model_id');
    }
}
