<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Designer extends Model
{
    public function designFirm() { return $this->belongsTo(DesignFirm::class); }
    public function programs() { return $this->belongsToMany(Program::class); }
}
