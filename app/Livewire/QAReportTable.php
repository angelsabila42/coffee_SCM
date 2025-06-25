<?php

namespace App\Livewire;

use App\Helpers\Helper;
use Livewire\Component;
use App\Models\QA;
use Livewire\WithPagination;

class QAReportTable extends Component
{
    use WithPagination;
     public $reportID, $start_period, $end_period;

   public function mount(){
    $this->reportID = Helper::generateID(QA::class,'reportID','QR',5);
   }

   public function save(){
    QA::create([
        'reportID'=> $this->reportID,
        'start_period'=>$this->start_period,
        'end_period' => $this->end_period
    ]);
   }
    public function render()
    {
        return view('livewire.q-a-report-table',[
            'report'=> QA::paginate(10)
        ]);
    }
}
