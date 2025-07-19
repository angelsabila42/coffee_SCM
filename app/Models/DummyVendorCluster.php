<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DummyVendorCluster extends Model
{
    protected  $fillable =[
        'vendor_id',
        'robusta_(60kg_bags)',
        'arabica_(60kg_bags)',
        'avgPricePerKg_UGX',
        'yearsActive',
        'organicCertified',
        'arabica_pct',
        'total_(60kg_bags)',
        'marketShare_pct',
    ];
    public function vendor(){
        return $this->belongsTo(Vendor::class,'vendor_id');
    }
}
