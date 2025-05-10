<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'airline_id',
        'name', 
        'final_customer_id', 
        'design_agency_id',
    ];

    public function airline()
    {
        return $this->belongsTo(Airline::class);
    }

    public function partNumbers()
    {
        return $this->belongsToMany(PartNumber::class, 'part_number_program');
    }

    public function finalCustomer(): BelongsTo
    {
        return $this->belongsTo(FinalCustomer::class);
    }

    public function designAgency(): BelongsTo
    {
        return $this->belongsTo(DesignAgency::class);
    }

    public function designers(): BelongsToMany
    {
        return $this->belongsToMany(Designer::class);
    }

    public function materials(): BelongsToMany
    {
        return $this->belongsToMany(Material::class);
    }

    public function subcontractors(): BelongsToMany
    {
        return $this->belongsToMany(Subcontractor::class);
    }

    public function stages(): HasMany
    {
        return $this->hasMany(ProgramStage::class);
    }
}