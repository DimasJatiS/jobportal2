<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JobVacancy extends Model
{
    use HasFactory;

    protected $table = 'job_vacancies';
    protected $fillable = [
        'title',
        'description',
        'location',
        'company',
        'type',
        'logo',
        'salary',
    ];
}
