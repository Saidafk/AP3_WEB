<?php

namespace App\Http\Controllers;

use App\Models\Equipe;
use App\Models\Hackathon;
use App\Models\Inscrire;
use App\Models\Commentaire; 

use Illuminate\Http\Request;
use App\Utils\SessionHelpers;
use Termwind\Components\Hr;

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

    public function voirLesHackathons(Request $request)
    {
        
        $queryFuturs = Hackathon::query();
        $queryPasses = Hackathon::query();
    
        // Filtrage par ville
        if ($request->filled('ville')) {
            $queryFuturs->where('ville', $request->input('ville'));
            $queryPasses->where('ville', $request->input('ville'));
        }
    
        // Filtrage par date de début
        if ($request->filled('date_debut')) {
            $dateDebut = $request->input('date_debut');
            
            // Pour les hackathons à venir
            $queryFuturs->whereDate('dateheuredebuth', '=', $dateDebut);
            
            // Pour les hackathons passés
            $queryPasses->whereDate('dateheuredebuth', '=', $dateDebut);
        }
    
        // Récupération des hackathons futurs
        $hackathonsfuturs = $queryFuturs->where('dateButoir', '>', now())->orderBy('dateheuredebuth')->get();
        
        // Récupération des hackathons passés
        $hackathonspasses = $queryPasses->where('dateButoir', '<', now())->orderBy('dateheurefinh')->get();
    
        // Récupération des inscriptions pour l'équipe connectée
        $inscrire = [];
        $equipe = null;
    
        if (SessionHelpers::isConnected()) {
            $equipe = SessionHelpers::getConnected(); 
            $inscrire = Inscrire::where('idequipe', $equipe->idequipe)
                ->with('hackathon') 
                ->get();
        }
    
        return view('hackathon.afficherHackathon', [
            'hackathonsfuturs' => $hackathonsfuturs,
            'hackathonspasses' => $hackathonspasses,
            'inscrire' => $inscrire,
            'equipe' => $equipe,
        ]);
    }

    public function voirLesInfoHackathon($idhackathon)
{
    $hackathon = Hackathon::find($idhackathon);

    $nbequipes = $hackathon->equipes()->count();
    $nbEquipe = $hackathon->nbEquipe; 

    $equipesmaxatteinte = $nbequipes >= $nbEquipe;
    $nbPlaceRestante = $nbEquipe - $nbequipes;

    return view('hackathon.infoHackathon', [
        'hackathon' => $hackathon,
        'nbPlaceRestante' => $nbPlaceRestante,
        'equipesmaxatteinte' => $equipesmaxatteinte,
    ]);
}


public function commentaireHackathon($idhackathon)
{
    $hackathon = Hackathon::find($idhackathon);


    $commentaires = $hackathon->commentaire()->with('equipe')->get();

    
return view('hackathon.commentaireHackathon', [
'hackathon' => $hackathon, 
'commentaires' => $commentaires,
]);

}


public function ajoutCommentaire(Request $request, $idhackathon)
{
    $equipe = SessionHelpers::getConnected();

    // Récupération du hackathon
    $hackathon = Hackathon::findOrFail($idhackathon);

    $request->validate([
        'contenu' => 'required|string|max:255',
    ]);

    // Création d'un nouveau commentaire
    $commentaire = new Commentaire();
    $commentaire->contenu = $request->input('contenu');
    $commentaire->idequipe = $equipe->idequipe; 
    $commentaire->idhackathon = $idhackathon;
    $commentaire->save(); // Save the comment

    // Récupérer tous les commentaires après l'ajout
    $commentaires = Commentaire::where('idhackathon', $idhackathon)->get();

    

    return redirect()->route('commentaireHackathon', ['idhackathon' => $idhackathon])
    ->with('success', 'Commentaire ajouté avec succès.');


                 
}

}