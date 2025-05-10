<?php

namespace App\Livewire;

use App\Models\Airline;
use Livewire\Component;

class AirlinesProgramsIndex extends Component
{
    public function render()
    {
        return view('livewire.airlines-programs-index', [
            'airlines' => Airline::with('programs')->get(),
        ])->layout('layouts.app');
    }
}