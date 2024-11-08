<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conferencier extends Model
{
    use HasFactory;

    protected $table = 'CONFERENCIER';
    protected $fillable = ['idConferencier','nomConferencier', 'prenomConferencier']; 
}
