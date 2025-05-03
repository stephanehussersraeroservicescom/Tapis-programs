<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Excel;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use App\Models\Project;
use App\Models\Mill;
use App\Models\Person;
use Maatwebsite\Excel\Facades\Excel as ExcelFacade;
use App\Imports\ProjectsSheetImport;
use PhpOffice\PhpSpreadsheet\Shared\Date as ExcelDate;
use App\Models\Airline;
use App\Models\DesignFirm;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use App\Models\PartNumber; 


class ImportProjects extends Component
{
    use WithFileUploads;
    

    public $file;
    public Collection $previewRows;
    public $hasPreview = false;



    public function updatedFile()
    {
        $this->validate([
            'file' => 'required|file|mimes:xlsx,xls,csv',
        ]);
    
        $import = new \App\Imports\ProjectsSheetImport();
        ExcelFacade::import($import, $this->file->getRealPath());
    
        $this->previewRows = $import->rows->take(100);
        $this->hasPreview = true;
    }

    public function import()
    {
        $defaultSameAsAirline = DesignFirm::firstOrCreate(['name' => 'Same as Airline']);
    
        foreach ($this->previewRows as $row) {
            $row = collect($row)->keyBy(fn($v, $k) => strtolower(trim(preg_replace('/\s+/', '_', $k))));
    
            $date = is_numeric($row['date'] ?? null) ? Date::excelToDateTimeObject($row['date'])->format('Y-m-d') : null;
            $eta = is_numeric($row['eta'] ?? null) ? Date::excelToDateTimeObject($row['eta'])->format('Y-m-d') : null;
            $received_from_mill = is_numeric($row['received_from_mill'] ?? null) ? Date::excelToDateTimeObject($row['received_from_mill'])->format('Y-m-d') : null;
            $ship_date = is_numeric($row['ship_date'] ?? null) ? Date::excelToDateTimeObject($row['ship_date'])->format('Y-m-d') : null;
            $approval_date = is_numeric($row['approval_date'] ?? null) ? Date::excelToDateTimeObject($row['approval_date'])->format('Y-m-d') : null;
    
            $rep = Person::firstOrCreate(['name' => $row['rep'] ?? 'Unknown'], ['is_internal' => true]);
            $mill = Mill::firstOrCreate(['name' => $row['mill'] ?? 'Unknown']);
            $airline = !empty($row['airline']) ? Airline::firstOrCreate(['name' => trim($row['airline'])]) : null;
    
            $designFirmName = $row['design_firm'] ?? null;
            $airlineName = trim($row['airline'] ?? '');
            $designerIsAirline = $designFirmName && $airlineName && trim($designFirmName) === $airlineName;
    
            $designFirmId = null;
            if ($designerIsAirline) {
                $designFirmId = $defaultSameAsAirline->id;
            } elseif ($designFirmName) {
                $designFirm = DesignFirm::firstOrCreate(['name' => trim($designFirmName)]);
                $designFirmId = $designFirm->id;
            }
    
            $existingProject = Project::where('tapis_ref', $row['tapis_ref'])->first();
    
            if ($existingProject) {
                $changed = false;
                foreach (['status', 'style', 'project_reference', 'application_notes', 'tapis_part_number', 'color_name'] as $field) {
                    if ($existingProject->$field !== ($row[$field] ?? null)) {
                        $existingProject->$field = $row[$field] ?? null;
                        $changed = true;
                    }
                }
    
                if ($changed) $existingProject->save();
                $project = $existingProject;
            } else {
                $project = Project::create([
                    'date' => $date,
                    'mill_ref' => $row['mill_ref'] ?? null,
                    'tapis_ref' => $row['tapis_ref'] ?? null,
                    'type' => $row['type'] ?? null,
                    'status' => $row['status'] ?? null,
                    'rep_id' => $rep->id,
                    'mill_id' => $mill->id,
                    'airline_id' => $airline?->id,
                    'design_firm_id' => $designFirmId,
                    'style' => $row['style'] ?? null,
                    'sample_matching' => $row['sample_matching'] ?? null,
                    'project_reference' => $row['project_reference'] ?? null,
                    'application_notes' => $row['application_notes'] ?? null,
                    'eta' => $eta,
                    'mill_to_ny_tracking' => $row['mill_to_ny_tracking'] ?? null,
                    'received_from_mill' => $received_from_mill,
                    'ship_date' => $ship_date,
                    'samples_sent_to' => $row['samples_sent_to'] ?? null,
                    'outgoing_tracking' => $row['outgoing_tracking'] ?? null,
                    'approval_date' => $approval_date,
                    'tapis_part_number' => $row['tapis_part_number'] ?? null,
                    'color_name' => $row['color_name'] ?? null,
                    'color_group' => $row['color_group'] ?? null,
                    'notes' => $row['notes'] ?? null,
                ]);
            }
    
            // ✅ Save to part_numbers table if status is Approved
            if (strtolower($project->status) === 'approved') {
                PartNumber::updateOrCreate(
                    ['tapis_part_number' => $project->tapis_part_number],
                    [
                        'rep_id' => $project->rep_id,
                        'airline_id' => $project->airline_id,
                        'application' => $project->application_notes,
                        'color_name' => $project->color_name,
                    ]
                );
            }
        }
    
        $this->reset(['file', 'previewRows', 'hasPreview']);
        session()->flash('message', 'Import completed.');
    }


    public function render()
    {
        return view('livewire.import-projects-component')
            ->layout('layouts.app'); 
    }
    
}
