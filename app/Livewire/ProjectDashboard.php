<?php

namespace App\Livewire;

use App\Models\Project;
use App\Models\Person;
use App\Models\Mill;
use App\Models\Airline;
use Livewire\Component;
use Livewire\WithPagination;

class ProjectDashboard extends Component
{
    use WithPagination;

    public $search = '';
    public $status = '';
    public $rep = '';
    public $airline = '';
    public $mill = '';

    public function updating($field)
    {
        $this->resetPage();
    }

    public function render()
    {
        $projects = Project::query()
            ->with(['airline', 'mill', 'rep'])
            ->when($this->search, fn ($q) =>
                $q->where('tapis_ref', 'like', "%{$this->search}%")
                  ->orWhere('style', 'like', "%{$this->search}%")
                  ->orWhere('project_reference', 'like', "%{$this->search}%")
            )
            ->when($this->status, fn ($q) => $q->where('status', $this->status))
            ->when($this->rep, fn ($q) => $q->whereHas('rep', fn ($qr) => $qr->where('name', $this->rep)))
            ->when($this->airline, fn ($q) => $q->whereHas('airline', fn ($qa) => $qa->where('name', $this->airline)))
            ->when($this->mill, fn ($q) => $q->whereHas('mill', fn ($qm) => $qm->where('name', $this->mill)))
            ->latest('date')
            ->paginate(25);

        // Collect unique values for filters
        $statuses = Project::distinct()->pluck('status')->filter()->sort()->values();
        $reps = Person::pluck('name')->filter()->sort()->values();
        $airlines = Airline::pluck('name')->filter()->sort()->values();
        $mills = Mill::pluck('name')->filter()->sort()->values();

        return view('livewire.project-dashboard', [
            'statuses' => $statuses,
            'reps' => $reps,
            'airlines' => $airlines,
            'mills' => $mills,
            'projects' => $projects,
        ])->layout('layouts.app');
    }
}