<?php

namespace App\Livewire;

use App\Helpers\Helper;
use App\Models\SalesReport;
use Livewire\Component;
use Livewire\WithPagination;

class SalesReportTable extends Component
{
    use WithPagination;
   // public $perPage = 5;

    public $reportID, $start_period, $end_period;

   public function mount(){
    $this->reportID = Helper::generateID(SalesReport::class,'reportID','SR',5 );
   }

   public function save(){
    SalesReport::create([
        'reportID'=> $this->reportID,
        'start_period'=>$this->start_period,
        'end_period' => $this->end_period
    ]);
   }
   public function delete(SalesReport $salesReport){
    $salesReport->delete();
   }

  /* public function sortby($sortByColumn){

    if($this->sortBy === $sortByColumn){
        $this->sortDir = ($this->sortDir== ''
        )
    }

    $this->sortBy = $sortByColumn;
   }*/
    public function render()

    {

        return view('livewire.sales-report-table',
        
        ['sales' => SalesReport::paginate(10)
        ]
        );
    }
}
