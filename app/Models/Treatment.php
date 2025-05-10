<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Treatment extends Model
{
    protected $fillable = ['name', 'description', 'cert_status'];

    public function programs()
    {
        return $this->belongsToMany(Program::class);
    }

    public function documents()
    {
        return $this->morphMany(Document::class, 'documentable');
    }
    public function partNumbers() { return $this->belongsToMany(PartNumber::class); }
}
