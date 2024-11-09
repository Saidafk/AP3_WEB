<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Salle extends Model
{
    use HasFactory;
    
    protected $table = 'SALLE';
    protected $primaryKey = 'id_salle';
    
    protected $fillable = [
        'nom',
        'capacite',
        'localisation'
    ];

    
}
