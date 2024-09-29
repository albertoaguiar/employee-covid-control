<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'cpf_prefix',
        'cpf_hash',
        'name',
        'birth_date',
        'date_first_dose',
        'date_second_dose',
        'date_third_dose',
        'vaccine_id',
        'comorbidity',
        'comorbidity_desc',
        'is_active',
    ];

    public function vaccine()
    {
        return $this->belongsTo(Vaccine::class);
    }
}
