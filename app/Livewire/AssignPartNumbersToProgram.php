<?php 

namespace App\Livewire;

use Livewire\Component;
use App\Models\Program;
use App\Models\PartNumber;

class AssignPartNumbersToProgram extends Component
{
    public $programId;
    public $selected = [];

    public function assign()
    {
        $program = Program::find($this->programId);
        if (!$program || empty($this->selected)) {
            session()->flash('message', 'Select a program and at least one part number.');
            return;
        }

        $partNumbers = PartNumber::whereIn('id', $this->selected)->get();
        foreach ($partNumbers as $pn) {
            $pn->programs()->syncWithoutDetaching([$program->id]);
        }

        session()->flash('message', 'Assigned successfully.');
        $this->selected = [];
    }

    public function render()
    {
        return view('livewire.assign-part-numbers-to-program', [
            'programs' => Program::with('airline')->get(),
            'partNumbers' => PartNumber::with('airline')->orderBy('created_at', 'desc')->get()
        ])->layout('layouts.app'); 
    }
}

