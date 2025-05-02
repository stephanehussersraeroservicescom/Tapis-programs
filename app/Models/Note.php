<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Note extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'author_id',
        'content',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function author()
    {
        return $this->belongsTo(Person::class, 'author_id');
    }
}