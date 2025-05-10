<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PartNumber extends Model
{
    use HasFactory;

    protected $fillable = [
        'tapis_ref',
        'rep_id',
        'airline_id',
        'application',
        'tapis_part_number',
        'color_name',
    ];
    
    public function programs()
    {
        return $this->belongsToMany(Program::class, 'part_number_program');
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function airline()
    {
        return $this->belongsTo(Airline::class);
    }

    public function requirements() 
    { return $this->hasMany(PartNumberRequirement::class);
    }
}