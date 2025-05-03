<?php

namespace App\Livewire;

use App\Models\Project;
use App\Models\Person;
use Livewire\Component;
use Livewire\WithPagination;

class ProjectDashboard extends Component
{
    use WithPagination;

    public $rep = '';

    public function updating($field)
    {
        $this->resetPage();
    }

    public function render()
    {
        $projects = Project::query()
            ->with(['rep'])
            ->when($this->rep, fn ($q) => $q->whereHas('rep', fn ($qr) => $qr->where('name', $this->rep)))
            ->latest('date')
            ->paginate(25);

        $reps = Person::pluck('name')->filter()->sort()->values();

        return view('livewire.project-dashboard', [
            'reps' => $reps,
            'projects' => $projects,
        ])->layout('layouts.app');
    }
}