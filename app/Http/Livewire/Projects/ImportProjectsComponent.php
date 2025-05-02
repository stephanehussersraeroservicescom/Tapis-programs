<?php

namespace App\Http\Livewire\Projects;

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


class ImportProjectsComponent extends Component
{
    use WithFileUploads;
    // use Maatwebsite\Excel\HeadingRowImport;

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
    
        $this->previewRows = $import->rows->take(10);
        $this->hasPreview = true;
    }

public function import()
{
    // foreach ($this->previewRows as $row) {
    //     // Normalize keys just in case (e.g. if header cleanup missed one)
    //     $row = collect($row)->keyBy(fn($v, $k) => strtolower(trim(preg_replace('/\s+/', '_', $k))));

    //     $rep = Person::firstOrCreate([
    //         'name' => $row['rep'] ?? 'Unknown'
    //     ], ['is_internal' => true]);

    //     $mill = Mill::firstOrCreate([
    //         'name' => $row['mill'] ?? 'Unknown'
    //     ]);

    //     // You can later do the same for airline and design firm
    //     Project::create([
    //         'date' => is_numeric($row['date'] ?? null) 
    //             ? \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['date'])->format('Y-m-d')
    //             : null,
    //         'mill_ref' => $row['mill_ref'] ?? null,
    //         'tapis_ref' => $row['tapis_ref'] ?? null,
    //         'type' => $row['type'] ?? null,
    //         'status' => $row['status'] ?? null,
    //         'rep_id' => $rep->id,
    //         'mill_id' => $mill->id,
    //         'style' => $row['style'] ?? null,
    //         'sample_matching' => $row['sample_matching'] ?? null,
    //         'project_reference' => $row['project_reference'] ?? null,
    //         'application_notes' => $row['application_notes'] ?? null,
    //         'eta' => is_numeric($row['eta'] ?? null) 
    //         ? \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['eta'])->format('Y-m-d')
    //         : null,
    //         'mill_to_ny_tracking' => $row['mill_to_ny_tracking'] ?? null,
    //         'received_from_mill' => is_numeric($row['received_from_mill'] ?? null) 
    //         ? \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['received_from_mill'])->format('Y-m-d')
    //         : null,
    //         'ship_date' => is_numeric($row['ship_date'] ?? null) 
    //         ? \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['ship_date'])->format('Y-m-d')
    //         : null,
    //         'samples_sent_to' => $row['samples_sent_to'] ?? null,
    //         'outgoing_tracking' => $row['outgoing_tracking'] ?? null,
    //         'approval_date' => is_numeric($row['approval_date'] ?? null) 
    //         ? \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['approval_date'])->format('Y-m-d')
    //         : null,
    //         'tapis_part_number' => $row['tapis_part_number'] ?? null,
    //         'color_name' => $row['color_name'] ?? null,
    //         'color_group' => $row['color_group'] ?? null,
    //         'notes' => $row['notes'] ?? null,
    //     ]);
    // }
    foreach ($this->previewRows as $row) {
        $row = collect($row)->keyBy(fn($v, $k) => strtolower(trim(preg_replace('/\s+/', '_', $k))));
    
        // Excel date fix
        $date = is_numeric($row['date']) 
            ? ExcelDate::excelToDateTimeObject($row['date'])->format('Y-m-d')
            : null;
    
        $rep = Person::firstOrCreate(['name' => $row['rep'] ?? 'Unknown'], ['is_internal' => true]);
        $mill = Mill::firstOrCreate(['name' => $row['mill'] ?? 'Unknown']);
    
        // Resolve airline
        $airlineName = $row['airline'] ?? null;
        $airline = $airlineName ? Airline::firstOrCreate(['name' => trim($airlineName)]) : null;
    
        // Check if design firm = airline
        $designFirmName = $row['design_firm'] ?? null;
        if (
            $designFirmName &&
            $airline &&
            strtolower(trim($designFirmName)) === strtolower($airline->name)
        ) {
            $designFirmId = $airline->id;
            $designerIsAirline = true;
        } else {
            $designFirm = $designFirmName
                ? DesignFirm::firstOrCreate(['name' => trim($designFirmName)])
                : null;
            $designFirmId = $designFirm?->id;
            $designerIsAirline = false;
        }
    
        // Final notes
        $notes = $row['notes'] ?? '';
        if ($designerIsAirline) {
            $notes .= ($notes ? ' — ' : '') . '[Designer is the airline]';
        }
    
        Project::create([
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
            'eta' => $row['eta'] ?? null,
            'mill_to_ny_tracking' => $row['mill_to_ny_tracking'] ?? null,
            'received_from_mill' => $row['received_from_mill'] ?? null,
            'ship_date' => $row['ship_date'] ?? null,
            'samples_sent_to' => $row['samples_sent_to'] ?? null,
            'outgoing_tracking' => $row['outgoing_tracking'] ?? null,
            'approval_date' => $row['approval_date'] ?? null,
            'tapis_part_number' => $row['tapis_part_number'] ?? null,
            'color_name' => $row['color_name'] ?? null,
            'color_group' => $row['color_group'] ?? null,
            'notes' => $notes,
        ]);
    }

    $this->reset(['file', 'previewRows', 'hasPreview']);
    session()->flash('message', 'Import completed.');
}


    public function render()
    {
        return view('livewire.projects.import-projects-component')
            ->layout('layouts.app'); // Jetstream's layout
    }
    
}
