<?php

namespace App\Livewire;
use App\Models\ImporterRecentActivities;
use App\Models\ImporterModel;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Auth;

class ImporterRecentLogs extends Component
{
    use WithPagination;

    public $showAll = false;
    public $filterType = '';
    
    public function toggleShowAll()
    {
        $this->showAll = !$this->showAll;
    }

    public function setFilter($type)
    {
        $this->filterType = $type;
        $this->resetPage();
    }

    public function clearFilter()
    {
        $this->filterType = '';
        $this->resetPage();
    }

    #[On('activity-logged')]
    public function refreshLogs()
    {
        // This will refresh the component when new activity is logged
        $this->render();
    }

    public function render()
    {
        $user = Auth::user();
        $importer = ImporterModel::where('email', $user->email)->first();
        
        $query = ImporterRecentActivities::where('user_id', Auth::id())
                    ->when($this->filterType, fn($q) => $q->where('type', $this->filterType))
                    ->latest();

        $logs = $this->showAll ? $query->paginate(15) : $query->take(10)->get();
        
        // Get activity type counts for filtering
        $activityCounts = ImporterRecentActivities::where('user_id', Auth::id())
            ->selectRaw('type, count(*) as count')
            ->groupBy('type')
            ->pluck('count', 'type');

        return view('livewire.importer-recent-logs', [
            'logs' => $logs,
            'activityCounts' => $activityCounts,
            'importer' => $importer
        ]);
    }
}
