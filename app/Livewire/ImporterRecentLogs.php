<?php

namespace App\Livewire;
use App\Models\ImporterRecentActivities;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
class ImporterRecentLogs extends Component
{
    public function render()
    {
        
        return view('livewire.importer-recent-logs',[
            'logs'=> ImporterRecentActivities::where('user_id', Auth::id())
                  ->latest()
                  ->take(10)
                  ->get(),
        ]);

    }
}
