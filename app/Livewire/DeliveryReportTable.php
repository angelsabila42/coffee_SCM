<?php

namespace App\Livewire;

use App\Helpers\Helper;
use App\Models\DeliveryReport;
use Livewire\Component;
use Livewire\WithPagination;

class DeliveryReportTable extends Component
{
    use WithPagination;
   // public $perPage = 5;
   public $reportID, $start_period, $end_period;

   public function mount(){
    $this->reportID = Helper::generateID(DeliveryReport::class,'reportID','DR',5);
   }

   public function save(){
    DeliveryReport::create([
        'reportID'=> $this->reportID,
        'start_period'=>$this->start_period,
        'end_period' => $this->end_period
    ]);
   }

   public function delete(DeliveryReport $deliveryReport){
    $deliveryReport->delete();
   }

    public function render()
    { 
     return view('livewire.delivery-report-table',
     ['deliveries'=>DeliveryReport::paginate(10)]);
    }
}
