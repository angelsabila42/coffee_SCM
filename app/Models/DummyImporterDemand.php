<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DummyImporterDemand extends Model
{
    protected $table = 'dummy_importer_demands';
     protected $fillable=['importer_model_id','robusta_(60kg_bags)',
                          'arabica_(60kg_bags)','yearsAsCustomer',
                          'orderFreqPerYear','total_(60kg_bags)',
                          'arabica_pct','avgOrderSize'];


    public function importerModel(){
        return $this->belongsTo(ImporterModel::class, 'importer_model_id');
    }
}
