<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Diagnosis extends Model
{
    protected $table = 'ref_diagnosis';
    protected $fillable = [
        'diagcode',
        'diagdesc',
        'diagcategory',
        'diagsubcat',
        'diagpriority',
        'diagmaincat',
        'updated_at',
        'created_at',
        'void'
    ];
}
