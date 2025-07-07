<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\RecentActivityLog;


class RecentActivity extends Component
{
    public function render()
    {
        return view('livewire.recent-activity',[
            'logs'=> RecentActivityLog::where('user_id', Auth::id())
                  ->latest()
                  ->take(10)
                  ->get(),
        ]);
    }
}
