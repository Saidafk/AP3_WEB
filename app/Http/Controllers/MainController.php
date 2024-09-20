<?php

namespace App\Http\Controllers;

use DateTime;
use App\Models\Hackathon;
use Illuminate\Http\Request;

class MainController extends Controller
{
    /**
     * Retourne la page d'accueil
     */
    public function home()
    {
        // Récuération du hackathon actif (celui en cours)
        $hackathon = Hackathon::getActiveHackathon();

        $finDuhackathon = $hackathon->dateheurefinh; // recupere dans la bdd la date et l'heure de fin du hackathon
        $nbEquipe = $hackathon->nbEquipe; // recupere dans la bsae de donnée le nombre d'équipe max
        $dateact = date('Y-m-d H:i:s'); // date actuellement 

        
        $hackathonEndDateTime = new \DateTime($finDuhackathon); 
        $dateact = new \DateTime($dateact);

        // Vérifier si la date actuelle est avant ou égale à la date butoir
        $rejoindre = $dateact <= $hackathonEndDateTime;

        // Vérifier si le nombre maximum d'équipes est atteint
        $nbequipes = $hackathon->equipes()->count();
        $equipesmaxatteinte = $nbequipes >= $nbEquipe;

        

       

        
        // Affichage de la vue, avec les données récupérées
        return view('main.home', [
            'hackathon' => $hackathon,
            'organisateur' => $hackathon->organisateur,
            'rejoindre' => $rejoindre,
            'equipesmaxatteinte' => $equipesmaxatteinte,

        /**$laDate = now();
        $rejoindre = $Datelimite -> $hackathon->registration_deadline;
        $maxTeamsReached = $hackathon->equipes()->count() >= $hackathon->equipemax; */
        

        
        ]);
    
    }

    /**
     * Retourne la page "À propos"
     */
    public function about()
    {
        return view('main.about');
    }
}
