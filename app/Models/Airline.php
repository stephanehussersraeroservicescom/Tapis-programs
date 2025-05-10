<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Airline extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function projects() {
        return $this->hasMany(Project::class);
    }
    public function partNumbers() {
        return $this->hasMany(PartNumber::class);
    }
    public function programs() {
        return $this->hasMany(Program::class);
    }
}
