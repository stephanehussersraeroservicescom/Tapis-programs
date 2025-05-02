<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Certification extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'type',
        'status',
        'due_date',
        'completed_at',
        'document_path',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}