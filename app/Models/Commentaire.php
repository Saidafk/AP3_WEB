<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commentaire extends Model
{
    use HasFactory;
    protected $table = 'COMMENTAIRE';
    protected $fillable = ['contenu', 'idmembre', 'idhackathon']; 

    public function hackathon()
    {
        return $this->belongsTo(Hackathon::class, 'idhackathon');
    }

    public function membre()
    {
        return $this->belongsTo(Membre::class, 'idmembre');
    }

    public function equipes()
    {
        return $this->belongsToMany(Equipe::class, 'INSCRIRE', 'idhackathon', 'idequipe')->withPivot('dateinscription','datedesinscription');
    }
}
