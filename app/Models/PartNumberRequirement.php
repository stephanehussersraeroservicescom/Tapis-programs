<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PartNumberRequirement extends Model
{
    public function partNumber() { return $this->belongsTo(PartNumber::class); }
    public function documents() { return $this->morphMany(Document::class, 'documentable'); }
}
