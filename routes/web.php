<?php

use App\Models\Equipe;
use App\Utils\SessionHelpers;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\MainController;
use App\Http\Middleware\IsAdminConnected;
use App\Http\Controllers\ApiDocController;
use App\Http\Controllers\EquipeController;
use App\Http\Middleware\IsEquipeConnected;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HackathonController;
use App\Http\Controllers\ParticipantController;

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
    Route::get('/logoutAdmin', [EquipeController::class, 'logoutAdmin'])->name('logoutAdmin');

    Route::post('/telechargement', [EquipeController::class, 'telechargerLesDonnees'])->name('telechargerLesDonnees');

Route::get('/doc-api', [ApiDocController::class, 'liste'])->name('doc-api');
//Route::get('/doc-api/admin', [ApiDocController::class, 'adminAcces'])->name('adminAcces');
Route::get('/doc-api/hackathons', [ApiDocController::class, 'listeHackathons'])->name('doc-api-hackathons');
Route::get('/doc-api/membres', [ApiDocController::class, 'listeMembres'])->name('doc-api-membres');
Route::get('/doc-api/equipes', [ApiDocController::class, 'listeEquipes'])->name('doc-api-equipes');});

// Routes protégées nécessitant une session active, pour les équipes.
// Proctection par le middleware IsEquipeConnected (voir app/Http/Middleware/IsEquipeConnected.php)
Route::middleware(isEquipeConnected::class)->group(function () {
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

Route::get('/hackathons', [HackathonController::class, 'voirLesHackathons'])->name('voirLesHackathons');

//Route::get('/mesParticipation/{idequipe}/{idhackathon}', [HackathonController::class, 'afficherParticipation'])->name('afficherParticipation');


//Route::get('/hackathons/{idequipe}/{idhackathon}', [HackathonController::class, 'afficherParticipation'])->name('afficherParticipation');