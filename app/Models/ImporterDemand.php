<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ImporterDemand extends Model
{
    protected $fillable=['importer_model_id','robusta_(60kg_bags)',
                          'arabica_(60kg_bags)','yearsAsCustomer',
                          'orderFreqPerYear','total_(60kg_bags)',
                          'arabica_pct','avgOrderSize'];


    public function importerModel(){
        return $this->belongsTo(importerModel::class, 'importer_model_id');
    }
}
