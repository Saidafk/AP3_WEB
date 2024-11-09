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
        'duree_minutes'
    ];
    

    public function conferenciers()
    {
        return $this->belongsToMany(Conferencier::class, 'atelier_conferencier', 'id_atelier', 'id_conferencier');
    }

}