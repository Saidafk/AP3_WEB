<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conferencier extends Model
{
    use HasFactory;

    protected $table = 'CONFERENCIER';
    protected $primaryKey = 'id_conferencier';
    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'telephone',
        'specialite'
    ]; 

    public function ateliers()
    {
        return $this->belongsToMany(Atelier::class, 'atelier_conferencier', 'id_conferencier', 'id_atelier');
    }
}
