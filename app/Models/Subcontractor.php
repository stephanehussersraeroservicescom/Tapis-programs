<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subcontractor extends Model
{   
    protected $fillable = ['name', 'location', 'contact'];
    public function programs()
    {return $this->belongsToMany(Program::class);}
}
