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
    public function join(Request $request)
{
    if (!SessionHelpers::isConnected()) {
        return redirect("/login")->withErrors(['errors' => "Vous devez être connecté pour accéder à cette page."]);
    }



    $equipe = SessionHelpers::getConnected();
    $idh = $request->get('idh');

    $idequipe = $equipe->idequipe;

    $hackathon = Hackathon::find($idh);
    if ($hackathon == null) {
        return redirect("/")->withErrors(['errors' => "Hackathon inexistant."]);
    }

    $dateact = new \DateTime();
    $hackathonEndDateTime = new \DateTime($hackathon->dateheurefinh);
    $nbequipes = $hackathon->equipes()->count();
    $equipesmaxatteinte = $nbequipes >= $hackathon->equipesmax;

    $inscription = $equipe->inscrire()->where('idhackathon', $request->idh)->first();

    $dateInscription = $inscription?->dateinscription; 
    $dateDesInscription = $inscription?->datedesinscription; 

    try {

        if($dateInscription != null && $dateDesInscription == null ){

            return redirect("/")->withErrors(['errors' => "Vous êtes déjà inscrit."]);
        }


        if ($dateInscription == null) {

            $inscription = new Inscrire();
            $inscription->idhackathon = $idh;
            $inscription->idequipe = $idequipe;
            $inscription->dateinscription = now();
            $inscription->datedesinscription = null;
            
            $inscription->save();

            return redirect("/")->with(['success' => "Bienvenue."]);
        }

        if ($dateDesInscription !== null) {

            
            Inscrire::where('idequipe', $equipe->idequipe)
            ->where('idhackathon', $hackathon->idhackathon)
            ->update([
            'dateinscription' => now(),
            'datedesinscription' => null,
            ]);
            

        return redirect("/")->with(['success' => "Votre inscription a été mise à jour."]);
    }
} catch (\Exception $e) {
    return redirect("/")->withErrors(['errors' => "Une erreur s'est produite : " . $e->getMessage()]);
}
}


public function voirLesHackathons(Request $request)
{

    // Initialisation des requêtes pour hackathons futurs et passés
    $queryFuturs = Hackathon::query();
    $queryPasses = Hackathon::query();

    // Filtrage par ville, si spécifiée
    if ($request->filled('ville')) {
        $queryFuturs->where('ville', 'like', '%' . $request->input('ville') . '%');
        $queryPasses->where('ville', 'like', '%' . $request->input('ville') . '%');
    }

    if ($request->filled('lieu')) {
        $queryFuturs->where('lieu', 'like', '%' . $request->input('lieu') . '%');
        $queryPasses->where('lieu', 'like', '%' . $request->input('lieu') . '%');
    }

    // Filtrage par date de début, si spécifiée
    if ($request->filled('date_debut')) {
        $dateDebut = $request->input('date_debut');
        $queryFuturs->whereDate('dateheuredebuth', '=', $dateDebut);
        $queryPasses->whereDate('dateheuredebuth', '=', $dateDebut);
    }

    // Récupération des hackathons futurs et passés
    $hackathonsfuturs = $queryFuturs->where('dateButoir', '>', now())
                                     ->orderBy('dateheuredebuth')
                                     ->get();

    $hackathonspasses = $queryPasses->where('dateButoir', '<', now())
                                    ->orderBy('dateheurefinh')
                                    ->get();

    // Récupération des inscriptions de l'équipe connectée
    $inscrire = [];
    $equipe = null;

    if (SessionHelpers::isConnected()) {
        $equipe = SessionHelpers::getConnected();

        // Récupérer les hackathons auxquels l'équipe est inscrite
        $inscrire = Inscrire::where('idequipe', $equipe->idequipe)
                            ->with('hackathon')
                            ->get();
    

    
    $hackathonsFutursEquipe = $inscrire->filter(function ($inscription) use ($hackathonsfuturs) {
        return $hackathonsfuturs->contains('idhackathon', $inscription->idhackathon);
    });

    $hackathonsPassesEquipe = $inscrire->filter(function ($inscription) use ($hackathonspasses) {
        return $hackathonspasses->contains('idhackathon', $inscription->idhackathon);
    });

    return view('hackathon.afficherHackathon', [
        'hackathonsfuturs' => $hackathonsfuturs,
        'hackathonspasses' => $hackathonspasses,
        'inscrire' => $inscrire,
        'equipe' => $equipe,
        'hackathonsFutursEquipe' => $hackathonsFutursEquipe,
        'hackathonsPassesEquipe' => $hackathonsPassesEquipe,
    ]);
}

    // Retourner la vue avec toutes les données
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
    // Récupération du hackathon
    $hackathon = Hackathon::find($idhackathon);

    // Récupérer l'équipe actuellement connectée
    $administrateur = SessionHelpers::AdmingetConnected();

    $equipe = SessionHelpers::getConnected();

    // Vérifier si l'équipe a participé à ce hackathon (inscrite et non désinscrite)
    $participation = $equipe->inscrire()->where('idhackathon', $idhackathon)->whereNull('datedesinscription')->first();

    //dd($participation);

    // Vérifier si le hackathon est passé (date de fin est dans le passé)
    $dateFin = new \DateTime($hackathon->dateheurefinh);
    $dateActuelle = new \DateTime();

    // Si l'équipe n'a pas participé ou si le hackathon est futur, rediriger
    if (!$participation || $dateFin > $dateActuelle) {
        return redirect("/")->withErrors(['errors' => 'Vous ne pouvez pas acceder aux commentaire de ce hackathon.']);
      
    }

    // Récupération des commentaires du hackathon avec les équipes associées
    $commentaires = $hackathon->commentaire()->with('equipe')->get();

    // Retourner la vue avec les commentaires
    return view('hackathon.commentaireHackathon', [
        'hackathon' => $hackathon, 
        'commentaires' => $commentaires,
        
    ]);
}




public function ajoutCommentaire(Request $request, $idhackathon)
{
    $equipe = SessionHelpers::getConnected();

    // Récupération du hackathon
    $hackathon = Hackathon::find($idhackathon);

    $request->validate([
        'contenu' => 'required|string|max:255',
    ]);

    
    $commentaire = new Commentaire();
    $commentaire->contenu = $request->input('contenu');
    $commentaire->idequipe = $equipe->idequipe; 
    $commentaire->idhackathon = $idhackathon;
    $commentaire->save(); 

    $commentaires = Commentaire::where('idhackathon', $idhackathon)->get();

    return redirect()->route('commentaireHackathon', ['idhackathon' => $idhackathon])
    ->with('success', 'Commentaire ajouté avec succès.');
                 
}

}