<?php

namespace App\Http\Controllers;

use App\Models\Salle;
use App\Models\Equipe;
use App\Models\Membre;
use App\Models\Hackathon;
use App\Models\Conferencier;
use App\Models\Atelier;
use App\Models\AtelierConferencierSalle;
use Illuminate\Http\Request;
use App\Utils\SessionHelpers;

class ApiDocController extends Controller
{
    /**
     * Documentation de l'API
     * Retourne la page d'accueil de la documentation de l'API
     */
    function liste()
    {
        
        return view('doc.list');
    }

    /**
     * Retourne la documentation de la partie API concernant les hackathons
     *
     */
    function listeHackathons()
    {

        // Récupération de tous les hackathons
        $data = Hackathon::all();

        // Affichage de la vue, avec les données récupérées
        return view('doc.hackathons', ['data' => $data]);
    }

    /**
     * Retourne la documentation de la partie API concernant les équipes
     * Si passé en paramètre, retourne les équipes inscrites à un hackathon spécifique (idh)
     */
    function listeEquipes(Request $request)
    {

        // Récupération de toutes les équipes
        $data = Equipe::all();

        // Initialisation de la variable hackathon
        $hackathon = null;

        /**
         * Si un hackathon est spécifié, on récupère les équipes inscrites à ce hackathon
         */
        if ($request->has('idh')) {
            // Récupération du hackathon spécifié
            $hackathon = Hackathon::find($request->input('idh'));

            // Récupération des équipes inscrites au hackathon
            $data = Equipe::getEquipesInHackhon($hackathon->idhackathon);
        }

        return view('doc.equipes', ['data' => $data, 'hackathon' => $hackathon]);
    }

    /**
     * Retourne la documentation de la partie API concernant les membres
     * Si passé en paramètre, retourne les membres d'une équipe spécifique (ide)
     */
    function listeMembres(Request $request)
    {
        // Récupération de tous les membres
        $data = Membre::all();

        // Initialisation de la variable lequipe
        $lequipe = null;

        if($request->has('ide')) {
            // Récupération de l'équipe spécifiée
            $lequipe = Equipe::find($request->input('ide'));

            // Récupération des membres de l'équipe spécifiée
            $data = Membre::where('idequipe', $request->input('ide'))->get();
        }

        return view('doc.membres', ['data' => $data, 'lequipe' => $lequipe]);
    }
       

    /*function gererLesAtelier(){

        $hackathonactif = Hackathon::getActiveHackathon();

        return view('doc.gererLesAteliers',['$hackathonactif' => $hackathonactif]);
    }

    function pageCreation(){

        $conferencier = Conferencier::all();
        $salle = Salle::all();
        $Atelier = Atelier::all();

        

        //dd($conferencier,$salle,$sessionAtelier);

    
        return view('doc.ajouterAtelier', ['conferencier' => $conferencier, 'salle' => $salle]);

    }

    public function creeAtelier(Request $request)
    {
        
        $salle = Salle::all();
        $conferencier = Conferencier::all();
        $Atelier = Atelier::all();

    
        $atelier = new Atelier();
        
        $atelier->titre = $request->input('titre');
        $atelier->description = $request->input('description');
        $atelier->duree_minutes = $request->input('duree_minutes');
        $atelier->save();


        $idconferencier = $request->input('id_conferencier');  
        $idsalle = $request->input('id_salle');  

        $atelierData = [];

        foreach ($idconferencier as $idconferencier) {
        $atelierData[] = [
        'id_atelier' => $atelier->id_atelier,
        'id_conferencier' => $idconferencier,
        'id_salle' => $idsalle,
        ];
        }

        AtelierConferencierSalle::insert($atelierData);

        
        return redirect()->route('pageCreation')
            ->with('success', 'Événement créé avec succès!');
    }
    


    function pageSelectionAtelier(Request $request){

        $salle = Salle::all();
        $conferencier = Conferencier::all();
        $atelier = Atelier::all();

        return view('doc.selectionnerAtelier', ['conferencier' => $conferencier, 'salle' => $salle, 'atelier' => $atelier]);
    }

    public function traiterSelectionAtelier(Request $request){

        $idatelier = $request->input('id_atelier');

        $atelier = Atelier::find($idatelier);

        $conferencier = Conferencier::all(); 
        $salle = Salle::all();
        $acs = AtelierConferencierSalle::all();

        

        return view('doc.modifierAtelier', ['atelier' => $atelier, 'conferencier' => $conferencier, 'salle' => $salle]);
    }

    public function mettreAJourAtelier(Request $request)
{
    $idatelier = $request->input('id_atelier');

    $atelier = Atelier::find($idatelier);


    $request->validate([
        'titre' => 'required|string|max:255',
        'description' => 'required|string',
        'duree_minutes' => 'required|integer',
    ]);

    $atelier->titre = $request->input('titre');
    $atelier->description = $request->input('description');
    $atelier->duree_minutes = $request->input('duree_minutes');
    $atelier->save();

    

    //dd($atelier);


    return redirect()->route('pageSelectionAtelier')->with('success', 'Atelier mis à jour avec succès.');
}*/


    
}
