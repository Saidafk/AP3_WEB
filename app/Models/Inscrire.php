<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inscrire extends Model
{
    use HasFactory;

    protected $table = 'INSCRIRE';
    protected $primaryKey = ['idequipe', 'idhackathon']; // Clé primaire composite

    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = ['idhackathon', 'idequipe', 'dateinscription', 'datedesinscription'];

    public function hackathon()
    {
        return $this->belongsTo(Hackathon::class, 'idhackathon', 'idhackathon');
    }

    public function equipe()
    {
        return $this->belongsTo(Equipe::class, 'idequipe', 'idequipe');
    }

    public function getKeyName()
    {
        return $this->primaryKey;
    }

    public function getKeyForSaveQuery()
    {
        $query = $this->newQueryWithoutScopes();

        foreach ($this->getKeyName() as $key) {
            $query->where($key, '=', $this->original[$key] ?? $this->getAttribute($key));
        }

        return $query;
    }
}
