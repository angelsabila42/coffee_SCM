<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Staff;
use Livewire\WithPagination;

class StaffModel extends Component
{
    use WithPagination;

    public $search = '';
    public $role = '';
    public $status = '';
    public $showFilter = false;
    
    protected $queryString = [
        'search' => ['except' => ''],
        'role' => ['except' => ''],
        'status' => ['except' => '']
    ];    public function render()
    {
        $query = Staff::query();

        if ($this->search) {
            $query->where(function($q) {
                $q->where('full_name', 'like', '%' . $this->search . '%')
                  ->orWhere('email', 'like', '%' . $this->search . '%')
                  ->orWhere('phone_number', 'like', '%' . $this->search . '%');
            });
        }
        
        if ($this->role) {
            $query->where('role', $this->role);
        }
        
        if ($this->status) {
            $query->where('status', $this->status);
        }
        
        // Get unique roles and statuses for filter dropdowns
        $roles = Staff::distinct()->pluck('role')->toArray();
        $statuses = Staff::distinct()->pluck('status')->toArray();
        
        // Get staff data
        $staffs = $query->get();
        
        // Store the filtered staff data in the session
        session(['filtered_staff' => $staffs]);
        
        // This will be used by the JavaScript to update the table
        $this->dispatch('staff-filtered', [
            'filteredStaffIds' => $staffs->pluck('id')->toArray()
        ]);
        
        return view('livewire.filters.staff-model', [
            'staff' => $staffs,
            'roles' => $roles,
            'statuses' => $statuses
        ]);
    }    public function clearFilter()
    {
        $this->reset(['search', 'role', 'status']);
    }
    
    // Using Alpine.js for toggle now
    
    // These methods are automatically triggered when the respective properties change
    public function updatedSearch()
    {
        // The render() method will be called automatically
    }
    
    public function updatedRole()
    {
        // The render() method will be called automatically
    }
    
    public function updatedStatus()
    {
        // The render() method will be called automatically
    }
}
