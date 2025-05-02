<?php

namespace App\Http\Livewire\Projects;

use App\Models\Project;
use Livewire\Component;
use Livewire\WithPagination;

class ProjectDashboardComponent extends Component
{
    use WithPagination;

    public $search = '';
    public $status = '';
    public $rep = '';
    public $airline = '';

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
            ->latest('date')
            ->paginate(25);

        return view('livewire.projects.project-dashboard-component', [
            'projects' => $projects
        ])->layout('layouts.app');
    }
}
