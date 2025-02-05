<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientMealPlanning extends Model
{
    use HasFactory;

    protected $table = 'patient_meal_planning';

    protected $fillable = [
        'patient_id',
        'planned_date',
        'total_calories',
        'total_fats',
        'total_carbs',
        'total_proteins',
        'is_active',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at'
    ];
}
