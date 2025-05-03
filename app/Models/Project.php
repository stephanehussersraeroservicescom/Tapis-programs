<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'mill_ref',
        'tapis_ref',
        'type',
        'status',
        'rep_id',
        'mill_id',
        'airline_id',
        'design_firm_id',
        'style',
        'sample_matching',
        'project_reference',
        'application_notes',
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
    ];

    public function rep()     { return $this->belongsTo(Person::class, 'rep_id'); }
    public function mill()    { return $this->belongsTo(Mill::class); }
    public function airline() { return $this->belongsTo(Airline::class); }
    public function people()  { return $this->belongsToMany(Person::class); }
    public function notes()   { return $this->hasMany(Note::class); }
    public function stackups() { return $this->hasMany(Stackup::class); }
    public function certifications() { return $this->hasMany(Certification::class); }
    public function designFirm() {return $this->belongsTo(DesignFirm::class);}
}
