<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AtelierConferencierSalle extends Model
{
    use HasFactory;
    
    protected $table = 'ATELIER_CONFERENCIER_SALLE';

    protected $fillable = [
        'id_atelier',
        'id_conferencier',
        'id_salle',
    ];

    // Les relations vers les autres modèles
    public function atelier()
    {
        return $this->belongsTo(Atelier::class, 'id_atelier');
    }

    public function conferencier()
    {
        return $this->belongsTo(Conferencier::class, 'id_conferencier');
    }

    public function salle()
    {
        return $this->belongsTo(Salle::class, 'id_salle');
    }
}