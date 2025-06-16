<?php

namespace App\Livewire;

use App\Models\SalesReport;
use Livewire\Component;

class SalesReportTable extends Component
{
    public function render()
    {
        return view('livewire.sales-report-table',
        
        ['sales' => SalesReportTable::all()
        ]
        );
    }
}
