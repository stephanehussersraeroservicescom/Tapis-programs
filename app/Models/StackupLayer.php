<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StackupLayer extends Model
{
    use HasFactory;

    protected $fillable = [
        'stackup_id',
        'material_id',
        'position',
        'notes',
    ];

    public function stackup()
    {
        return $this->belongsTo(Stackup::class);
    }

}