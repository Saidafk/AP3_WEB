<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inscrire extends Model
{
    use HasFactory;

    protected $table = 'INSCRIRE';
    protected $primaryKey = ['idhackathon', 'idequipe'];

    // Vu que la clé primaire est composée de deux colonnes, on doit spécifier que la clé primaire n'est pas auto-incrémentée
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = ['idhackathon', 'idequipe', 'dateinscription','datedesinscription'];

    public function getParticipations()
{
    $inscrire = Inscrire::with(['equipe', 'hackathon'])->get();

    return view('hackathon.afficherHackathon', [
        'inscrire' => $inscrire,
    ]);
}

    public function hackathon()
    {
    return $this->belongsTo(Hackathon::class, 'idhackathon', 'idhackathon'); // Correction du nom de la colonne
    }

    public function equipe()
    {
    return $this->belongsTo(Equipe::class, 'idequipe', 'idequipe'); // Correction du nom de la colonne
    }


}
