<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Equipe;
use App\Models\Membre;
use App\Models\Atelier;
use App\Models\Inscrire;
use App\Models\Hackathon;
use App\Utils\EmailHelpers;
use App\Models\Conferencier;
use Illuminate\Http\Request;
use App\Utils\SessionHelpers;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use App\Models\AtelierConferencierSalle;

class AtelierController extends Controller
{
    public function voirLesAteliers(Request $request)
    {
        // Récupérer tous les ateliers
        $ateliers = Atelier::all();


    
        // Retourner la vue avec les ateliers
        return view('atelier.atelier', ['ateliers' => $ateliers]);
    }
}
