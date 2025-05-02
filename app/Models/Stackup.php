<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Stackup extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'description',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function layers()
    {
        return $this->hasMany(StackupLayer::class);
    }
}