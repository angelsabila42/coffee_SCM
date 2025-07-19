<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\LeaveHistory as LeaveHistoryModel;


class LeaveHistory extends Component
{
    use WithPagination;

    #[Url] public $search = '';
    #[Url] public $leave_type = '';
    #[Url] public $status = '';
    #[Url] public $startDate = '';
    #[Url] public $endDate = '';

    protected function filter()
    {
        return LeaveHistoryModel::query()
            ->when($this->search !== '', function($query) {
                $query->whereHas('staff', function($q) {
                    $q->where('full_name', 'like', '%' . $this->search . '%');
                })
                ->orWhere('leave_type', 'like', '%' . $this->search . '%');
            })
            ->when($this->leave_type !== '', fn($q) => $q->where('leave_type', '=', $this->leave_type))
            ->when($this->status !== '', fn($q) => $q->where('status', '=', $this->status))
            ->when($this->startDate !== '', fn($q) => $q->where('start_date', '>=', $this->startDate))
            ->when($this->endDate !== '', fn($q) => $q->where('end_date', '<=', $this->endDate))
            ->orderBy('created_at', 'desc')
            ->paginate(10);
    }

    public function render()
    {
        $leaveHistory = $this->filter();
        $leaveTypes = LeaveHistoryModel::distinct()->pluck('leave_type');
        $statuses = LeaveHistoryModel::distinct()->pluck('status');
        return view('livewire.filters.leave-history', [
            'leaveHistory' => $leaveHistory,
            'leaveTypes' => $leaveTypes,
            'statuses' => $statuses,
            'search' => $this->search,
            'leave_type' => $this->leave_type,
            'status' => $this->status,
        ]);
    }

    public function clearFilter()
    {
        $this->reset(['search', 'leave_type', 'status', 'startDate', 'endDate']);
    }

    public function updateStatus($id, $status)
    {
        $leave = LeaveHistoryModel::find($id);
        if ($leave) {
            $leave->status = $status;
            $leave->save();
            $this->dispatch('alert', [
                'type' => 'success',
                'message' => 'Leave status updated successfully!'
            ]);
        }
    }
}
