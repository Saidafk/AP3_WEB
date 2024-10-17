<?php

namespace App\Http\Controllers;

use App\Models\Equipe;
use App\Models\Hackathon;
use App\Models\Inscrire;
use Illuminate\Http\Request;
use App\Utils\SessionHelpers;

class HackathonController extends Controller
{
    public function join(Request $request){
        // Si l'équipe n'est pas connectée, on redirige vers la page de connexion
        if (!SessionHelpers::isConnected()) {
            return redirect("/login")->withErrors(['errors' => "Vous devez être connecté pour accéder à cette page."]);
        }

        // Récupération de l'équipe connectée
        $equipe = SessionHelpers::getConnected();


        // Vérifier si la date butoir est dépassée ou le nombre maximum d'équipes est atteint
       

        // Le hackathon actif est en paramètre de la requête (idh en GET).
        // À prévoir : récupérer l'id du hackathon actif depuis la base de données pour éviter les erreurs.

        // Récupération de l'id du hackathon actif
        $idh = $request->get('idh');
        
        if(Hackathon::find($idh) == null){

            return redirect("/")->withErrors(['errors' => "Hackathon inexistant."]);

            $dateact = new \DateTime();
            $hackathonEndDateTime = new \DateTime($hackathon->dateheurefinh);
            $nbequipes = $hackathon->equipes()->count();
            $equipesmaxatteinte = $nbequipes >= $hackathon->equipesmax;
    
            if ($dateact > $hackathonEndDateTime || $equipesmaxatteinte) {
                return redirect("/")->withErrors(['errors' => "Inscription impossible : la date butoir est dépassée ou le nombre maximum d'équipes est atteint."]);
            }

           

            
        }

        try{
            // Inscription de l'équipe au hackathon
            $inscription = new Inscrire();
            $inscription->idh = $idh;
            $inscription->ide = $equipe->idequipe;
            $inscription->save();

            // TODO : envoyer un email de confirmation à l'équipe en utilisant la classe EmailHelpers, et la méthode sendEmail (exemple présent dans le contrôleur EquipeController)

            // Redirection vers la page de l'équipe
            return redirect("/me")->with('success', "Inscription réussie, vous faites maintenant partie du hackathon.");
        } catch (\Exception $e) {
            // Redirection vers la page d'accueil avec un message d'erreur
            
            
            
                return redirect("/")->withErrors(['errors' => "Equipe déjà inscrite."]); 
            
            
        }
    }

    public function voirLesHackathons()
{
    
    $hackathonspasses = Hackathon::where('dateheurefinh', '<', now())->orderBy('dateheurefinh', 'desc')->get();
    $hackathonsfuturs = Hackathon::where('dateheuredebuth', '>', now())->orderBy('dateheuredebuth', 'asc')->get();

    return view('hackathon.afficherHackathon', compact('hackathonspasses', 'hackathonsfuturs'));
}
}
