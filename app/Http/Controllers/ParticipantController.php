<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use app\Models\Equipe;

class ParticipantController extends Controller
{
    //Objectif voir la liste des participants

    public function listeParticipant()
    {
        $equipes = Equipe::with('membres')->get();

        return view('equipe.listeParticipant', compact('equipes'));

    }
}
