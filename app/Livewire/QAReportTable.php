<?php

namespace App\Livewire;

use App\Helpers\Helper;
use Livewire\Component;
use App\Models\QA;
use Livewire\WithPagination;

class QAReportTable extends Component
{
    use WithPagination;
    
    protected $paginationTheme = 'bootstrap';
    public $search = '';
    public $perPage = 10;
    public $status = '';

    protected $listeners = ['refreshTable' => '$refresh'];

    public function mount()
    {
        $this->reportID = Helper::generateID(QA::class, 'reportID', 'QR', 5);
    }

    // Form submission is handled by the form component, this component only displays the table

    public function deleteDraft($id)
    {
        $report = QA::find($id);
        if ($report && $report->status === 'draft') {
            $report->delete();
            session()->flash('success', 'Draft report deleted successfully.');
        }
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $reports = QA::query()
            ->when($this->search, function($query) {
                $query->where('reportID', 'like', '%' . $this->search . '%')
                    ->orWhere('date', 'like', '%' . $this->search . '%');
            })
            ->orderByDesc('created_at')
            ->paginate($this->perPage);

        return view('livewire.q-a-report-table', [
            'reports' => $reports
        ]);
    }
}
