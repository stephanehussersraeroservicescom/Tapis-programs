<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel as ExcelFacade;
use Illuminate\Support\Collection;
use App\Models\Project;
use App\Models\Mill;
use App\Models\Person;
use App\Models\Airline;
use App\Models\DesignFirm;
use App\Models\PartNumber;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use App\Imports\ProjectsSheetImport;

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

        $import = new ProjectsSheetImport();
        ExcelFacade::import($import, $this->file->getRealPath());

        $this->previewRows = $import->rows->take(100);
        $this->hasPreview = true;
    }

    public function import()
    {
        $this->importProjects();
        $this->importPartNumbers();

        $this->reset(['file', 'previewRows', 'hasPreview']);
        session()->flash('message', 'Import completed.');
    }

    private function importProjects()
    {
        $defaultSameAsAirline = DesignFirm::firstOrCreate(['name' => 'Same as Airline']);

        foreach ($this->previewRows as $row) {
            $row = collect($row)->keyBy(fn($v, $k) => strtolower(trim(preg_replace('/\s+/', '_', $k))));

            $date = is_numeric($row['date']) ? Date::excelToDateTimeObject($row['date'])->format('Y-m-d') : null;
            $eta = is_numeric($row['eta']) ? Date::excelToDateTimeObject($row['eta'])->format('Y-m-d') : null;
            $received_from_mill = is_numeric($row['received_from_mill']) ? Date::excelToDateTimeObject($row['received_from_mill'])->format('Y-m-d') : null;
            $ship_date = is_numeric($row['ship_date']) ? Date::excelToDateTimeObject($row['ship_date'])->format('Y-m-d') : null;
            $approval_date = is_numeric($row['approval_date']) ? Date::excelToDateTimeObject($row['approval_date'])->format('Y-m-d') : null;

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

            $existing = Project::where('tapis_ref', $row['tapis_ref'])->first();

            if ($existing) {
                $changed = false;
                foreach ([
                    'status', 'style', 'project_reference', 'application_notes',
                    'tapis_part_number', 'color_name', 'notes'
                ] as $field) {
                    if ($existing->$field !== ($row[$field] ?? null)) {
                        $existing->$field = $row[$field] ?? null;
                        $changed = true;
                    }
                }

                if ($changed) {
                    $existing->save();
                }
            } else {
                Project::create([
                    'date' => $date,
                    'mill_ref' => $row['mill_ref'] ?? null,
                    'tapis_ref' => $row['tapis_ref'] ?? null,
                    'type' => $row['type'] ?? null,
                    'status' => $row['status'] ?? null,
                    'rep_id' => $rep->id,
                    'mill_id' => $mill->id,
                    'airline_id' => $airline?->id,
                    'design_firm_id' => $designFirmId ?? null,
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
        }
    }

    private function importPartNumbers()
    {
        foreach ($this->previewRows as $row) {
            $row = collect($row)->keyBy(fn($v, $k) => strtolower(trim(preg_replace('/\s+/', '_', $k))));

            if (strtolower(trim($row['status'] ?? '')) !== 'approved') {
                continue;
            }

            $tapisPartNumber = $row['tapis_part_number'] ?? null;
            if (empty($tapisPartNumber)) {
                continue;
            }

            $rep = Person::firstOrCreate(['name' => $row['rep'] ?? 'Unknown'], ['is_internal' => true]);
            $airline = !empty($row['airline']) ? Airline::firstOrCreate(['name' => trim($row['airline'])]) : null;

            PartNumber::updateOrCreate(
                ['tapis_part_number' => $tapisPartNumber],
                [
                    'tapis_ref'   => $row['tapis_ref'] ?? null,
                    'rep_id'      => $rep->id,
                    'airline_id'  => $airline?->id,
                    'application' => $row['application_notes'] ?? null,
                    'color_name'  => $row['color_name'] ?? null,
                ]
            );
        }
    }

    public function render()
    {
        return view('livewire.import-projects-component')
            ->layout('layouts.app'); 
    }
}
