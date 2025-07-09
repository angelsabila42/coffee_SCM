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

   public function generateReport()
    {
        // Redirect to the delivery CSV export route
        return redirect()->to(route('reports.delivery.csv'));
    }
    public function generateSalesReport()
    {
        // Redirect to the sales CSV export route
        return redirect()->to(route('reports.sales.csv'));
    }

   public function generateQAReport()
    {
        // Redirect to the QA CSV export route
        return redirect()->to(route('reports.qa.csv'));
    }

   public function render()
    {
        // Fetch all deliveries from the deliveries table, paginated
        $deliveries = \App\Models\Delivery::orderByDesc('created_at')->paginate(10);
        return view('livewire.delivery-report-table', [
            'deliveries' => $deliveries
        ]);
    }
}
