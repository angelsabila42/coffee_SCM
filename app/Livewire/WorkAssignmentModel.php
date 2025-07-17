<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\WorkAssignment;
use Livewire\WithPagination;

class WorkAssignmentModel extends Component
{
    use WithPagination;

    public $search = '';
    public $showFilter = false;

    public function render()
    {
        $query = WorkAssignment::query();

        if ($this->search) {
            $query->where(function($q) {
                $q->where('staff_id', 'like', '%' . $this->search . '%')
                  ->orWhere('work_center', 'like', '%' . $this->search . '%');
            });
        }

        return view('livewire.filters.work-assignment', [
            'assignments' => $query->paginate(10)
        ]);
    }

    public function clearFilter()
    {
        $this->reset(['search']);
    }

    public function toggle()
    {
        $this->showFilter = !$this->showFilter;
    }
}
