<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Treatment extends Model
{
    protected $fillable = ['name', 'description', 'cert_status'];

    public function materials(): BelongsToMany
    {
        return $this->belongsToMany(Material::class);
    }

    public function documents()
    {
        return $this->morphMany(Document::class, 'documentable');
    }
}
