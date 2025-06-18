<?php

namespace App\Livewire;

use App\Models\SalesReport;
use Livewire\Component;
use Livewire\WithPagination;

class SalesReportTable extends Component
{
    use WithPagination;
   // public $perPage = 5;

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
