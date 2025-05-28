<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Atelier extends Model
{
    use HasFactory;

    protected $table = 'ATELIER';
    protected $primaryKey = 'id_atelier';
    public $timestamps = false;
    
    protected $fillable = [
        'titre',
        'description',
    ];
    

    public function conferenciers()
    {
        return $this->belongsToMany(Conferencier::class, 'atelier_conferencier', 'id_atelier', 'id_conferencier', 'idHackathon');
    }

    public function hackathon()
    {
        return $this->belongsTo(Hackathon::class, 'idHackathon', 'idHackathon');
    }

    public function niveau()
    {
        return $this->belongsTo(Niveau::class, 'NIVEAU', 'id');
    }

}