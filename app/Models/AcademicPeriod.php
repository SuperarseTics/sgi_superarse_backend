<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AcademicPeriod extends Model {
    protected $table = "academic_periods";

    protected $fillable = [
        'type',
        'start_month',
        'start_year',
        'end_month',
        'end_year',
        'enabled'
    ];
}