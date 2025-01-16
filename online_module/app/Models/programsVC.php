<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class programsVC extends Model
{
    protected $table = 'tbl_programs_vc';

    public function program(): BelongsTo
    {
        return $this->belongsTo(TrainingPrograms::class, 'program_id','id');
    }
}
