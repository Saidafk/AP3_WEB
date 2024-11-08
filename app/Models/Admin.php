<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    use HasFactory;

    protected $table = 'ADMINISTRATEUR';
    protected $primaryKey = 'idadministrateur';
    public $timestamps = false;

    protected $fillable = ['nom', 'prenom', 'motpasse', 'email', 'cleA2F'];

    /**
     * Retourne les équipes inscrites à un hackathon.
     * @param $idHackathon
     * @return mixed
     */
}
