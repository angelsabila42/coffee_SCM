<?php

namespace App\Livewire;

use App\Models\OutgoingOrder;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\OrderStatusLogger as OrderStatusLoggerModel;

class OrderStatusLogger extends Component
{
    use WithPagination;
    public $order;
    protected $paginationTheme = 'bootstrap';
    public function mount($order){
        $this->order= $order;
    }

      public function updatePagination(){
        $this->resetPage();
    }


    public function render()
    {
        $logs = OrderStatusLoggerModel::where('loggable_id', $this->order->id)
              ->where('loggable_type', get_class($this->order))
              ->latest()
              ->paginate(5);

        return view('livewire.order-status-logger', [
            'logs' => $logs,
        ]);
    }
}
