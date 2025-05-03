<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PartNumber extends Model
{
    use HasFactory;

    protected $fillable = [
        'tapis_ref',
        'rep_id',
        'airline_id',
        'application',
        'tapis_part_number',
        'color_name',
    ];
}