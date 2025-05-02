<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Person extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'email', 'role', 'is_internal'];

    public function projectsAsRep() {
        return $this->hasMany(Project::class, 'rep_id');
    }

    public function projects() {
        return $this->belongsToMany(Project::class);
    }
}