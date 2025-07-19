<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\WorkAssignment;
use Livewire\WithPagination;


class WorkAssignmentModel extends Component
{
    use WithPagination;

    public $search = '';
    public $role = '';
    public $work_center = '';
    public $showFilter = false;

    public function render()
    {
        $query = WorkAssignment::query();

        if ($this->search) {
            $query->where(function($q) {
                $q->whereHas('staff', function($sq) {
                    $sq->where('full_name', 'like', '%' . $this->search . '%');
                })
                ->orWhereHas('workCenter', function($wq) {
                    $wq->where('centerName', 'like', '%' . $this->search . '%');
                })
                ->orWhere('role', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->role) {
            $query->where('role', $this->role);
        }

        if ($this->work_center) {
            $query->where('work_center_id', $this->work_center);
        }

        // Get all roles and work centers for filter dropdowns
        $roles = WorkAssignment::distinct()->pluck('role');
        $workCenters = \App\Models\WorkCenter::all();

        return view('livewire.filters.work-assignment', [
            'workAssignments' => $query->paginate(10),
            'roles' => $roles,
            'workCenters' => $workCenters,
            'search' => $this->search,
            'role' => $this->role,
            'work_center' => $this->work_center,
        ]);
    }

    public function clearFilter()
    {
        $this->reset(['search', 'role', 'work_center']);
    }

    public function toggle()
    {
        $this->showFilter = !$this->showFilter;
    }
}
