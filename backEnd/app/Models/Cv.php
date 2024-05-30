<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cv extends Model
{
    use HasFactory;

    protected $fillable = [
        'ecole',
        'diplome',
        'domaine',
        'dateDebut',
        'dateFin',
        'activite',
        'description',
        'competences',
        'cvMedia',
    ];
}
