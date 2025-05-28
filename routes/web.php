<?php

use App\Models\Equipe;
use App\Utils\SessionHelpers;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Middleware\IsAdminConnected;
use App\Http\Controllers\ApiDocController;
use App\Http\Controllers\EquipeController;
use App\Http\Middleware\IsEquipeConnected;
use App\Http\Middleware\Check2FA;
use App\Http\Controllers\HackathonController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AtelierController;


include('inc/api.php');

// Routes de base
Route::get('/', [MainController::class, 'home'])->name('home');


Route::get('/about', [MainController::class, 'about'])->name('about');

// Routes d'authentification et de gestion d'équipe
Route::get('/login', [EquipeController::class, 'login'])->name('login');
Route::post('/login', [EquipeController::class, 'connect'])->name('connect');

Route::get('/loginAdmin', [EquipeController::class, 'loginAdmin'])->name('loginAdmin');
Route::post('/loginAdmin', [EquipeController::class, 'connectAdmin'])->name('connect');

Route::get('/join', [HackathonController::class, 'join'])->name('join');
Route::any('/create-team', [EquipeController::class, 'create'])->name('create-team'); // Any pour gérer les GET et POST

Route::middleware(IsAdminConnected::class)->group(function () {

    Route::get('/doc-api/administrateur', [AdminController::class, 'voirAdmin'])->name('voirAdmin');
    Route::get('/doc-api/administrateur/a2f/activer', [AdminController::class, 'activerA2F'])->name('activerA2F');
    Route::get('/doc-api/administrateur/a2f/desactiver', [AdminController::class, 'desactiverA2F'])->name('desactiverA2F');

Route::get('/admin/renvoyer-code-2fa', [AdminController::class, 'renvoyerCode2FA'])->name('renvoyerCode2FA');

Route::get('/doc-api/administrateur', [AdminController::class, 'voirAdmin'])->name('voirAdmin');

Route::get('/admin/a2f/activer', [AdminController::class, 'activerA2F'])->name('activerA2F');

Route::get('/admin/a2f/verifier', [AdminController::class, 'pageVerificationA2F'])->name('pageVerificationA2F');

Route::post('/admin/a2f/verifier', [AdminController::class, 'verifierA2F'])->name('verifierA2F');



    //Route::get('/a2f/verification', [AdminController::class, 'showVerificationForm'])->name('verificationA2F');
    //Route::post('/a2f/verification', [AdminController::class, 'verifyA2F'])->name('verifyA2F');


    Route::get('/logoutAdmin', [EquipeController::class, 'logoutAdmin'])->name('logoutAdmin');

    Route::get('/telechargement', [EquipeController::class, 'telechargerLesDonnees'])->name('telechargerLesDonnees');

    Route::post('/telechargement', [EquipeController::class, 'confirmationTelechargerLesDonnees'])->name('confirmationTelechargerLesDonnees');


Route::get('/doc-api', [ApiDocController::class, 'liste'])->name('doc-api');

Route::get('/doc-api/administrateur/creation-atelier', [ApiDocController::class, 'pageCreation'])->name('pageCreation');

Route::post('/doc-api/administrateur/creation-atelier', [ApiDocController::class, 'creeAtelier'])->name('creeAtelier');

Route::get('/doc-api/administrateur/selection-atelier', [ApiDocController::class, 'pageSelectionAtelier'])->name('pageSelectionAtelier');

Route::post('/doc-api/administrateur/selection-atelier', [ApiDocController::class, 'traiterSelectionAtelier'])->name('traiterSelectionAtelier');

Route::post('/doc-api/administrateur/mettre-a-jour-atelier', [ApiDocController::class, 'mettreAJourAtelier'])->name('mettreAJourAtelier');

Route::get('/doc-api/administrateur/atelier', [ApiDocController::class, 'gererLesAtelier'])->name('gererLesAtelier');

//Route::get('/doc-api/administrateur/info', [ApiDocController::class, 'activerA2F'])->name('activerA2F');

Route::get('/doc-api/hackathons', [ApiDocController::class, 'listeHackathons'])->name('doc-api-hackathons');
Route::get('/doc-api/membres', [ApiDocController::class, 'listeMembres'])->name('doc-api-membres');
Route::get('/doc-api/equipes', [ApiDocController::class, 'listeEquipes'])->name('doc-api-equipes');});

// Routes protégées nécessitant une session active, pour les équipes.
// Proctection par le middleware IsEquipeConnected (voir app/Http/Middleware/IsEquipeConnected.php)
Route::middleware(isEquipeConnected::class)->group(function () {

    Route::get('/planning-hackathon/info/{id}', [EquipeController::class, 'infoAtelier'])->name('infoAtelier');

    Route::get('/planning-hackathon', [EquipeController::class, 'pagePlanning'])->name('pagePlanning');


    Route::get('/logout', [EquipeController::class, 'logout'])->name('logout');

    Route::get('/quitterHackathon', [EquipeController::class, 'quitterHackathon'])->name('quitterHackathon');
    
    Route::get('/me', [EquipeController::class, 'me'])->name('me');
    Route::post('/membre/add', [EquipeController::class, 'addMembre'])->name('membre-add');

Route::get('/afficherMembres/{id}', [EquipeController::class, 'afficherMembres'])->name('afficherMembres');




Route::get('/supressionMembre/{membre}', [EquipeController::class, 'supprimerMembre'])->name('supprimerMembre');
Route::delete('/confirmationSupression/{membre}', [EquipeController::class, 'confirmationSupression'])->name('confirmationSupression');

Route::get('/desinscription', [EquipeController::class, 'desinscription'])->name('desinscription');
Route::post('/confirmation-desinscription', [EquipeController::class, 'confirmationDesinscription'])->name('confirmationDesinscription');

Route::get('/modifierProfile', [EquipeController::class, 'modifierProfile'])->name('modifierProfile');
Route::post('/modifierProfile', [EquipeController::class, 'miseAjourProfile'])->name('miseAjourProfile');

Route::get('/me', [EquipeController::class, 'me'])->name('me');



});

Route::get('/hackathons/atelier', [AtelierController::class, 'voirLesAteliers'])->name('voirLesAteliers');

Route::get('/hackathons/{idhackathon}', [HackathonController::class, 'voirLesInfoHackathon'])->name('voirLesInfoHackathon');

Route::get('/hackathons', [HackathonController::class, 'voirLesHackathons'])->name('voirLesHackathons');






Route::get('/commentaire/{idhackathon}', [HackathonController::class, 'commentaireHackathon'])->name('commentaireHackathon');

Route::post('/commentaire/{idhackathon}', [HackathonController::class, 'ajoutCommentaire'])->name('ajoutCommentaire');



//Route::post('/hackathon/commentaire/{idhackathon}/{idequipe}', [HackathonController::class, 'ajoutCommentaire'])->name('ajoutCommentaire');


