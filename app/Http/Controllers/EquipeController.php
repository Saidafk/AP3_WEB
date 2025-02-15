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

class EquipeController extends Controller
{
    /**
     * Affiche la page de connexion.
     *
     * L'équipe se connecte avec son email et son mot de passe.
     * Le formulaire soumet les données à la route connect (POST).
     */
    public function login()
    {
        return view('equipe.login');
    }

    public function loginAdmin()
    {
        return view('doc.loginAdmin');
    }

    /**
     * Méthode de connexion de l'équipe.
     * Vérifie les informations de connexion et connecte l'équipe.
     */
    public function connect(Request $request)
    {
        $validated = $request->validate(
            [
                'email' => 'required|email',
                'password' => 'required',
            ],
            [
                'required' => 'Le champ :attribute est obligatoire.',
                'email' => 'Le champ :attribute doit être une adresse email valide.',
            ],
            [
                'email' => 'email',
                'password' => 'mot de passe',
            ]
        );

        // Récupération de l'équipe avec l'email fourni
        $equipe = Equipe::where('login', $validated['email'])->first();

        // Si l'équipe n'existe pas, on redirige vers la page de connexion avec un message d'erreur
        if (!$equipe) {
            return redirect("/login")->withErrors(['errors' => "Aucune équipe n'a été trouvée avec cet email."]);
        }

        // Si le mot de passe est incorrect, on redirige vers la page de connexion avec un message d'erreur
        // Le message d'erreur est volontairement vague pour des raisons de sécurité
        // En cas d'erreur, on ne doit pas donner d'informations sur l'existence ou non de l'email
        if (!password_verify($validated['password'], $equipe->password)) {
            return redirect("/login")->withErrors(['errors' => "Aucune équipe n'a été trouvée avec cet email."]);
        }

        // Connexion de l'équipe
        SessionHelpers::login($equipe);

        // Redirection vers la page de profil de l'équipe
        return redirect("/me");
    }

    public function connectAdmin(Request $request)
    {
        
        $validated = $request->validate(
            [
                'email' => 'required',
                'motpasse' => 'required',
            ],
            [
                'required' => 'Le champ :attribute est obligatoire.',
                //'email' => 'Le champ :attribute doit être une adresse email valide.',
            ],
            [
                'email' => 'email',
                'motpasse' => 'mot de passe',
            ]
        );

        

        // Récupération de l'équipe avec l'email fourni
        $admin = Admin::where('email', $validated['email'])->first();

        

        // Si l'équipe n'existe pas, on redirige vers la page de connexion avec un message d'erreur
        if (!$admin) {
            return redirect("/loginAdmin")->withErrors(['errors' => "Aucun admin n'a été trouvée avec cet email."]);
        }

        // Si le mot de passe est incorrect, on redirige vers la page de connexion avec un message d'erreur
        // Le message d'erreur est volontairement vague pour des raisons de sécurité
        // En cas d'erreur, on ne doit pas donner d'informations sur l'existence ou non de l'email
        if (!password_verify($validated['motpasse'], $admin->motpasse)) {
            return redirect("/loginAdmin")->withErrors(['errors' => "Aucun admin n'a été trouvée avec cet email."]);
        }
        
        SessionHelpers::loginAdmin($admin);

        //dd($administrateur);
        if($admin->active_a2f){
        //dd($admin->code2fa);
        $code2FA = Str::random(6);

        EmailHelpers::sendEmail($admin->email, 'Code de vérification 2FA', 'email.code2fa', ['code' => $admin->code2fa]);
            return redirect()->route('pageVerificationA2F')->with('success', 'Un code vous a été envoyé par mail pour vous authentifier.');

        }

        
        // Connexion de l'équipe
        SessionHelpers::loginAdmin($admin);

        // Redirection vers la page de profil de l'équipe
        return redirect("/doc-api");
    }


    /**
     * Méthode de création d'une équipe.
     * Affiche le formulaire de création d'équipe.
     */
    public function create(Request $request)
    {
        
        if (SessionHelpers::isConnected()) {
            return redirect("/me");
        }

        
        if (!$request->isMethod('post')) {
            return view('equipe.create', []);
        }

        // Sinon, on traite les données du formulaire
        // Validation des données, on vérifie que les champs sont corrects.
        $request->validate(
            [
                'nom' => 'required|string|max:255',
                'lien' => 'required|string|max:255',
                'email' => 'required|email|max:255|unique:EQUIPE,login',
                'password' => 'required|string|min:8',
            ],
            [
                'required' => 'Le champ :attribute est obligatoire.',
                'string' => 'Le champ :attribute doit être une chaîne de caractères.',
                'max' => 'Le champ :attribute ne peut pas dépasser :max caractères.',
                'email' => 'Le champ :attribute doit être une adresse email valide.',
                'unique' => 'Cette adresse :attribute est déjà utilisée.',
                'min' => 'Le champ :attribute doit contenir au moins :min caractères.',
            ],
            [
                'nom' => 'nom',
                'lien' => 'lien',
                'email' => 'email',
                'password' => 'mot de passe',
            ]
        );

        // Récupération du hackathon actif
        $hackathon = Hackathon::getActiveHackathon();

        

        // Si aucun hackathon n'est actif, on redirige vers la page de création d'équipe avec un message d'erreur
        if (!$hackathon) {
            return redirect("/create-team")->withErrors(['errors' => "Aucun hackathon n'est actif pour le moment. Veuillez réessayer plus tard."]);
        }

        try {
            // Création de l'équipe
            $equipe = new Equipe();
            $equipe->nomequipe = $request->input('nom');
            $equipe->lienprototype = $request->input('lien');
            $equipe->login = $request->input('email');
            $equipe->password = bcrypt($request->input('password'));
            $equipe->save();

            // Envoi d'un email permettant de confirmer l'inscription
            EmailHelpers::sendEmail($equipe->login, "Inscription de votre équipe", "email.confirmationInscription", ['equipe' => $equipe, 'hackathon' => $hackathon]);
            
            
            

            // Connexion de l'équipe
            SessionHelpers::login($equipe);

            // L'équipe rejoindra le hackathon actif.
            // On crée une inscription pour l'équipe (table INSCRIRE)
            Inscrire::create([
                'idequipe' => $equipe->idequipe,
                'idhackathon' => $hackathon->idhackathon,
                'dateinscription' => date('Y-m-d H:i:s'),
            ]);

            // Redirection vers la page de profil de l'équipe avec un message de succès
            return redirect("/me")->with('success', "Votre équipe a bien été créée. Vérifiez votre boîte mail pour confirmer votre inscription.");
        } catch (\Exception $e) {
            // Redirection vers la page de création d'équipe avec un message d'erreur
            return redirect("/create-team?idh=" . $request->idh)->withErrors(['errors' => "Une erreur est survenue lors de la création de votre équipe."]);
        }

    }

    /**
     * Méthode de déconnexion, vide la session et redirige vers la page d'accueil.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout()
    {
        SessionHelpers::logout();
        return redirect()->route('home')->with('success', 'Vous vous êtes déconnecté avec succès.');
        
    }

    public function logoutAdmin()
    {
        SessionHelpers::logoutAdmin();
        return redirect()->route('home')->with('success', 'Vous vous êtes déconnecté en tant qu\'administrateur.');
    }

    public function quitterHackathon()
    {
        $hackathon = Hackathon::getActiveHackathon();
        return redirect()->route('home');
    }

    /**
     * Méthode de visualisation de la page de profil de l'équipe.
     * Permet de voir les informations de l'équipe, les membres, et d'ajouter des membres.
     */
    public function me()
    {
        // Si l'équipe n'est pas connectée, on la redirige vers la page de connexion
        if (!SessionHelpers::isConnected()) {
            return redirect("/login");
        }

        

        // Récupération de l'équipe connectée
        $equipe = SessionHelpers::getConnected();

        // Récupération des membres de l'équipe
        $membres = $equipe->membres;

        // Récupération du hackathon ou l'équipe est inscrite
        $hackathon = $equipe->hackathons()->first();

        if($hackathon == null){
            return redirect("/")->withErrors(['errors' => "Vous devez d'abord rejoindre un hackathon."]); 
        }

        // Membre de l'équipe,
        // Membre::where('idequipe', $equipe->idequipe)->get(); // Ancienne méthode
        // Voir la méthode membres() dans le modèle Equipe équivalente à la ligne précédente.
        $membres = $equipe->membres()->get();

        return view('equipe.me', ['connected' => $equipe, 'membres' => $membres, 'hackathon' => $hackathon]);
    }

    /**
     * Méthode d'ajout d'un membre à l'équipe.
     */
    public function addMembre(Request $request)
    {
        // Ajout d'un membre à l'équipe
        $equipe = SessionHelpers::getConnected();

        $hackathon = Hackathon::getActiveHackathon();

        // Validation des données, pour l'instant nous n'avons que NOM et PRENOM.
        // TODO : À l'avenir ajouter l'ensemble des champs nécessaires prévus dans la base de données.

        $request->validate(
            [
                'nom' => 'required|string|max:255',
                'prenom' => 'required|string|max:255',
                'email' => 'required|string|max:255|email',
                'telephone' => 'required|string|max:10|min:10',
                //'datenaissance' => 'required|string|max:255',
            ],
            [
                'required' => 'Le champ :attribute est obligatoire.',
                'string' => 'Le champ :attribute doit être une chaîne de caractères.',
                'max' => 'Le champ :attribute ne peut pas dépasser :max caractères.',
            ],
            [
                'nom' => 'nom',
                'prenom' => 'prénom',
                'email' => 'email',
                'telephone' => 'telephone',
                'datenaissance' => 'datenaissance',
            ]
        );

        try {

            $dateNaissance = new \DateTime($request->input('datenaissance'));
            $aujourdhui = new \DateTime();
            $age = $aujourdhui->diff($dateNaissance)->y; 

            

        
        if ($age < 16 || $age > 80) {
            return redirect("/me")->withErrors(['errors' => "L'âge doit être compris entre 18 et 50 ans."]);
        }


            // Création du membre
            $membre = new Membre();
            $membre->nom = $request->input('nom');
            $membre->prenom = $request->input('prenom');
            $membre->email = $request->input('email');
            $membre->telephone = $request->input('telephone');
            $membre->datenaissance = $request->input('datenaissance');
            $membre->idequipe = $equipe->idequipe;

            
            
            $membre->save();
            EmailHelpers::sendEmail($membre->email, "Inscription de votre équipe", "email.ajoutMembre", ['membre' => $membre, 'equipe' => $equipe, 'hackathon' => $hackathon]);
            
            // TODO : envoyer un email de confirmation au membre en s'inspirant de la méthode create de EquipeController (emailHelpers::sendEmail)

            // Redirection vers la page de l'équipe
            return redirect("/me")->with('success', "Le membre a bien été ajouté à votre équipe. Un email lui a été envoyé pour l'informer de son inscription.");
            
        } catch (\Exception $e) {
            // Redirection vers la page de l'équipe avec un message d'erreur
            
            return redirect("/me")->withErrors(['errors' => "Une erreur est survenue lors de l'ajout du membre à votre équipe."]);
        }
        EmailHelpers::sendEmail($membre->email, "Bienvenue dans l'équipe.", "email.ajoutMembre", [ 'equipe' => $equipe]);
        
        
        
    }

    public function supprimerMembre (Membre $membre){

        if (!SessionHelpers::isConnected()) {
            return response()->json(['error' => 'Vous devez être connecté pour effectuer cette action.'], 403);
        }
        

        return view('equipe.confirmationSupression', ['membre' => $membre]);
                             
    }


    public function desinscription()
{
    
    if (!SessionHelpers::isConnected()) {
        return redirect("/login")->withErrors(['errors' => "Vous devez être connecté pour effectuer cette action."]);
    }

    $equipe = SessionHelpers::getConnected();
    $hackathon = $equipe->hackathons()->first();

    if (!$hackathon) {
        return redirect("/me")->withErrors(['errors' => "Votre équipe n'est pas inscrite à un hackathon."]);
    }

    return view('equipe.confirmationDesinscription', ['equipe' => $equipe, 'hackathon' => $hackathon]);
}

    
public function confirmationDesinscription(Request $request)
{
    if (!SessionHelpers::isConnected()) {
        return response()->json(['errors' => 'Vous devez être connecté pour effectuer cette action.'], 403);
    }

    $equipe = SessionHelpers::getConnected();
    $hackathon = $equipe->hackathons()->first();

    if ($hackathon) {
        
            Inscrire::where('idequipe', $equipe->idequipe)
            ->where('idhackathon', $hackathon->idhackathon)
            ->update(['datedesinscription' => now()]);      

        return redirect("/")->with(['success' => 'Vous avez quitté le hackathon avec succès.']);
        
    }

    
    return redirect()->back()->withErrors(['errors' => "Erreur lors de la désinscription."]);
}

    public function confirmationSupression (Membre $membre){

        if (!SessionHelpers::isConnected()) {
            return response()->json(['error' => 'Vous devez être connecté pour effectuer cette action.'], 403);
        }

        $membre->delete();

        return redirect()->route('me')->with('success', 'Membre supprimé avec succès.');
    }


    public function afficherMembres($id)
    {
        if (!SessionHelpers::isConnected()) {
            return redirect("/login")->withErrors(['errors' => "Vous devez être connecté pour accéder à cette page."]);
        }
    
        $equipe = Equipe::find($id);

        $membres = $equipe->membres;
        $nomEquipe = $equipe -> nomequipe;

        return view("equipe.afficherMembres", ['equipes' => $membres, 'nomEquipe' => $nomEquipe]);
    }

           

    public function modifierProfile()
    {
        if (!SessionHelpers::isConnected()) {
            return redirect("/login")->withErrors(['errors' => "Vous devez être connecté pour accéder à cette page."]);
        }

        $equipe = SessionHelpers::getConnected();

        return view('equipe.modifierProfile',['equipe' => $equipe ]);
    }

    public function miseAjourProfile(Request $request)
{
    if (!SessionHelpers::isConnected()) {
        return redirect("/login")->withErrors(['errors' => "Vous devez être connecté pour accéder à cette page."]);
    }

    $equipe = SessionHelpers::getConnected();

    // Validation de la requête
    $request->validate([
        'nomequipe' => 'required|string|max:255|regex:/^[a-zA-Z0-9\s]*$/|unique:EQUIPE,nomequipe,' . $equipe->idequipe . ',idequipe',
        'lienprototype' => 'required|string|max:255|unique:EQUIPE,lienprototype,' . $equipe->idequipe . ',idequipe',
        'login' => 'required|string|max:255|email|unique:EQUIPE,login,' . $equipe->idequipe . ',idequipe',
        'password' => 'nullable|string|min:8|confirmed',
    ], [
        
        'password.min' => 'Le mot de passe doit faire au moins 8 caractères.',
        'nomequipe.unique' => 'Le nom de cette équipe existe déja.',
        'nomequipe.regex' => 'Le nom de l\'équipe ne doit pas comporter de caractères spéciaux.',
        'lienprototype.unique' => 'Le lien prototype existe déja.',
        'login.unique' => 'Cette email est déja utilisé.',
    ]);

    // Mise à jour des informations de l'équipe
    $equipe->nomequipe = $request->input('nomequipe');
    $equipe->lienprototype = $request->input('lienprototype');
    $equipe->login = $request->input('login');

    // Vérification et mise à jour du mot de passe
    if ($request->filled('password')) {
        // Si un mot de passe est fourni, on vérifie s'il fait bien 6 caractères minimum
        $equipe->password = bcrypt($request->password);
    }

    // Sauvegarde des informations
    $equipe->save();

    // Retourner la vue avec un message de succès
    return view('equipe.modifierProfile', ['equipe' => $equipe])->with('success', 'Profile mis à jour.');
}




    public function telechargerLesDonnees()
    {
        if (!SessionHelpers::AdminisConnected()) {
            return redirect("/loginAdmin")->withErrors(['errors' => "Vous devez être connecté en tant qu'admin pour accéder à cette page."]);
        }

        $equipe = SessionHelpers::getConnected(); 
            
        $membres = $equipe->membres; 

        return view('equipe.telechargement', ['equipe' => $equipe, 'membres' => $membres ]);

    }

    public function confirmationTelechargerLesDonnees( Request $request)
        {
           
            if (!SessionHelpers::AdminisConnected()) {
                return redirect("/loginAdmin")->withErrors(['errors' => "Vous devez être connecté en tant qu'admin pour accéder à cette page."]);
            }
         
        
            $equipe = SessionHelpers::getConnected(); 
        
            $administrateur = SessionHelpers::AdmingetConnected();

            $idequipe = $equipe->idequipe;
    
            $adminEmail = $administrateur->email; 
     
            $membres = Membre::where('idequipe', $idequipe)->get();

            $donneesEquipe = [
                'equipe' => $equipe,
                         
            ];

            $jsonData = json_encode($donneesEquipe, JSON_PRETTY_PRINT);

            // Sauvegarder le fichier JSON dans un répertoire temporaire
            $fileName = "donnees_equipe_{$equipe->nomequipe}.json";
            $filePath = storage_path("app/public/{$fileName}");
            file_put_contents($filePath, $jsonData);


            $subject = "Confirmation de téléchargement des données de l'équipe";
    $view = "email.confirmationTelechargement";

        EmailHelpers::sendEmailJson(
            $adminEmail,  
            $subject,
            $view,
            ['equipe' => $equipe, 'membres' => $membres],
            $filePath 
        );

        return redirect("/me")->with(['success' => 'Données télechargées.']);
    }

    public function pagePlanning()
{
    // Vérification de la connexion
    if (!SessionHelpers::isConnected()) {
        return redirect("/login")->withErrors(['errors' => "Vous devez être connecté pour accéder à cette page."]);
    }

    $equipe = SessionHelpers::getConnected(); // Récupérer l'équipe connectée
    $hackathon = Hackathon::getActiveHackathon(); // Récupérer le hackathon actif

    // Vérification s'il y a des ateliers associés au hackathon
    if ($hackathon && $hackathon->ateliers()->count() > 0) {
        // Récupérer les ateliers du hackathon actif
        $ateliers = $hackathon->ateliers;
        //dd($ateliers);
    } else {
        $ateliers = []; // Aucun atelier trouvé
    }

    // Préparer les événements pour FullCalendar
    $events = [];
    foreach ($ateliers as $atelier) {
        // Convertir les dates en objets Carbon si elles sont sous forme de string
        $startDate = Carbon::parse($atelier->dateheuredebuta); // Date de début
        $endDate = Carbon::parse($atelier->dateheurefina); // Date de fin

        // Formater les dates pour FullCalendar (YYYY-MM-DD HH:mm:ss)
        $events[] = [
            'title' => $atelier->titre,
            'start' => $startDate->format('Y-m-d H:i:s'),  // Date de début
            'end' => $endDate->format('Y-m-d H:i:s'),  // Date de fin
            'description' => $atelier->description,
            'url' => route('infoAtelier', ['id' => $atelier->id_atelier]), // Lien vers la page de détails de l'atelier
        ];
        
    }
    
    return view('equipe.planning-hackathon', [
        'events' => $events,
        'hackathon' => $hackathon
    ]);
}

    
    function infoAtelier($id){

        $atelier = Atelier::find($id);

        if (!$atelier) {
            return redirect('/planning-hackathon')->withErrors(['errors' => 'L\'atelier demandé n\'existe pas.']);
        }

        $hackathon = Hackathon::getActiveHackathon();

            $titre = $atelier->titre;

            $description = $atelier->description;

            $idatelier = $atelier->id_atelier;

            
            $debut = $atelier ->dateheuredebuta;
            $fin = $atelier ->dateheurefina;

            $debuta= Carbon::parse($debut)->addMonths(12);
            $fina = Carbon::parse($fin)->addMonths(12);
            
            $duree_minutes = $debuta->diffInMinutes($fina); 
            
            $duree_minutes_arrondie = round($duree_minutes);

            $ATS = AtelierConferencierSalle::where('id_atelier', $id)->get();


            
            if ($ATS->isEmpty()) {
                $ATS = []; // Cela évite le `count()` sur null
            }

            $events = [
                [
                    'title' => $titre,
                    'start' => $debuta->format('Y-m-d H:i:s'), // Assurez-vous que le format des dates est valide
                    'end' => $fina->format('Y-m-d H:i:s'),
                    'description' => $description,
                    'url' => route('infoAtelier', ['id' => $idatelier]), // URL vers les détails de l'atelier
                ]
            ];


            if(count($ATS) > 0){
                foreach ($ATS as $current) {
                    $current->confName = $current->conferencier->nom;
                    $current->confFirstName = $current->conferencier->prenom;
                    $current->salleName = $current->salle->nom;
                }
            

                
                return view('equipe.detail-atelier', [
                    'atelier' => $atelier,
                    'titre' => $titre,
                    'description' => $description,
                    'debuta' => $debuta,
                    'fina' => $fina,
                    'duree_minutes_arrondie' => $duree_minutes_arrondie,
                    'ATS' => $ATS,
                    'events' => $events, // Passer les événements à la vue
                ]);

            } else if (count($ATS) === 0) {
                // Aucun conférencier ou salle, on passe un message à la vue
                return view('equipe.detail-atelier', [
                    'hackathon' => $hackathon,
                    'atelier' => $atelier,
                    'titre' => $titre,
                    'description' => $description,
                    'debuta' => $debuta,
                    'fina' => $fina,
                    'duree_minutes_arrondie' => $duree_minutes_arrondie,
                    'ATS' => null, 
                ])->with('success', "Nous n'avons pas encore toutes les informations concernant l'atelier, veuillez nous excuser.");
            }
    }
}


