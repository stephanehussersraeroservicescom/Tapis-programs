<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProjectsSheetImport implements ToCollection, WithHeadingRow
{
    public Collection $rows;

    public function collection(Collection $collection)
{
    $this->rows = $collection->map(function ($row) {
        return collect($row)->only([
            'date',
            'mill_ref',
            'tapis_ref',
            'type',
            'status',
            'rep',
            'mill',
            'style',
            'sample_matching',
            'project_reference',
            'application_notes',
            'airline',
            'design_firm',
            'contact_person',
            'eta',
            'mill_to_ny_tracking',
            'received_from_mill',
            'ship_date',
            'samples_sent_to',
            'outgoing_tracking',
            'approval_date',
            'tapis_part_number',
            'color_name',
            'color_group',
            'notes',
        ]);
    });
}
}