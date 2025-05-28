@extends('layouts.app')

@section('title', 'Hackathons')

@section('custom-css')


<link href="{{ asset('css/tableau.css') }}" rel="stylesheet"/>
<link href="{{ asset('css/afficherHackathon.css') }}" rel="stylesheet"/>
@endsection

@section('content')
<div class="container-fluid py-4 bannerHome">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            
            <!-- Formulaire de recherche -->

            <a class="btn bg-green m-2 button-home" href="{{ route('Ateliers') }}">Voir les ateliers</a>
            
                <h4 class="section-title">Rechercher un hackathon</h4>
                <form action="{{ route('voirLesHackathons') }}" method="GET" class="row g-3">
                    <div class="col-md-4">
                        <label for="villeSelect" class="form-label">Ville</label>
                        <input type="text" id="villeSelect" name="ville" class="form-control" placeholder="Saisissez une ville" value="{{ request('ville') }}">
                    </div>
                    <div class="col-md-4">
                        <label for="lieuSelect" class="form-label">Lieu</label>
                        <input type="text" id="lieuSelect" name="lieu" class="form-control" placeholder="Saisissez un lieu" value="{{ request('lieu') }}">
                    </div>
                    <div class="col-md-4">
                        <label for="dateDebut" class="form-label">Date de début</label>
                        <input type="date" id="dateDebut" name="date_debut" class="form-control" value="{{ request('date_debut') }}">
                    </div>
                    <div class="col-12 text-end">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search"></i> Rechercher
                        </button>
                    </div>
                </form>


            
            <!-- Hackathons à venir -->
            <h2 class="section-title">Hackathons à venir</h2>
            @if ($hackathonsfuturs->isEmpty())
                <div class="no-data">
                    <i class="fas fa-calendar-times fa-2x mb-3"></i>
                    <p>Aucun hackathon à venir ne correspond à vos critères.</p>
                </div>
            @else
                <div class="table-responsive hackathon-table">
                    <table class="table table-hover mb-0">
                        <thead class="table-header">
                            <tr>
                                <th>Thématique</th>
                                <th>Date de début</th>
                                <th>Date de fin</th>
                                <th>Lieu</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($hackathonsfuturs as $hackathon)
                                <tr class="hackathon-card">
                                    <td><strong>{{ $hackathon->thematique }}</strong></td>
                                    <td>{{ $hackathon->dateheuredebuth }}</td>
                                    <td>{{ $hackathon->dateheurefinh }}</td>
                                    <td>{{ $hackathon->ville }} ({{ $hackathon->lieu }})</td>
                                    <td>
                                        <a href="{{ route('voirLesInfoHackathon', ['idhackathon' => $hackathon->idhackathon]) }}" 
                                           class="btn btn-primary btn-sm">
                                           <i class="fas fa-info-circle"></i> Détails
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif

            <!-- Hackathons passés -->
            <h2 class="section-title">Hackathons passés</h2>
            @if ($hackathonspasses->isEmpty())
                <div class="no-data">
                    <i class="fas fa-history fa-2x mb-3"></i>
                    <p>Aucun hackathon passé ne correspond à vos critères.</p>
                </div>
            @else
                <div class="table-responsive hackathon-table">
                    <table class="table table-hover mb-0">
                        <thead class="table-header">
                            <tr>
                                <th>Thématique</th>
                                <th>Date de début</th>
                                <th>Date de fin</th>
                                <th>Lieu</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($hackathonspasses as $hackathon)
                                <tr class="hackathon-card">
                                    <td><strong>{{ $hackathon->thematique }}</strong></td>
                                    <td>{{ $hackathon->dateheuredebuth }}</td>
                                    <td>{{ $hackathon->dateheurefinh }}</td>
                                    <td>{{ $hackathon->ville }} ({{ $hackathon->lieu }})</td>
                                    <td>
                                        <a href="{{ route('voirLesInfoHackathon', ['idhackathon' => $hackathon->idhackathon]) }}" 
                                           class="btn btn-primary btn-sm">
                                           <i class="fas fa-info-circle"></i> Détails
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif

            <!-- Vérification si l'équipe est connectée -->
            @if(!$equipe)
                <div class="alert alert-info mt-4" role="alert">
                    <i class="fas fa-user-lock mr-2"></i>
                    Aucune équipe connectée. Veuillez vous connecter pour voir vos participations.
                </div>
            @else
                <!-- Hackathons à venir auxquels l'équipe est inscrite -->
                <h2 class="section-title">Hackathons à venir auxquels vous êtes inscrit</h2>
                @if ($hackathonsFutursEquipe->isEmpty())
                    <div class="no-data">
                        <i class="fas fa-calendar-check fa-2x mb-3"></i>
                        <p>Aucun hackathon futur auquel vous êtes inscrit.</p>
                    </div>
                @else
                    <div class="table-responsive hackathon-table">
                        <table class="table table-hover mb-0">
                            <thead class="table-header">
                                <tr>
                                    <th>Thématique</th>
                                    <th>Date de début</th>
                                    <th>Date de fin</th>
                                    <th>Lieu</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($hackathonsFutursEquipe as $inscription)
                                    <tr class="hackathon-card">
                                        <td><strong>{{ $inscription->hackathon->thematique }}</strong></td>
                                        <td>{{ $inscription->hackathon->dateheuredebuth }}</td>
                                        <td>{{ $inscription->hackathon->dateheurefinh }}</td>
                                        <td>{{ $inscription->hackathon->ville }} ({{ $inscription->hackathon->lieu }})</td>
                                        <td>
                                            <a href="{{ route('voirLesInfoHackathon', ['idhackathon' => $inscription->hackathon->idhackathon]) }}" 
                                               class="btn btn-primary btn-sm btn-action">
                                               <i class="fas fa-info-circle"></i> Détails
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif

                <!-- Hackathons passés auxquels l'équipe est inscrite -->
                <h2 class="section-title">Hackathons passés auxquels vous êtes inscrit</h2>
                @if ($hackathonsPassesEquipe->isEmpty())
                    <div class="no-data">
                        <i class="fas fa-trophy fa-2x mb-3"></i>
                        <p>Aucun hackathon passé auquel vous êtes inscrit.</p>
                    </div>
                @else
                    <div class="table-responsive hackathon-table">
                        <table class="table table-hover mb-0">
                            <thead class="table-header">
                                <tr>
                                    <th>Thématique</th>
                                    <th>Date de début</th>
                                    <th>Date de fin</th>
                                    <th>Lieu</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($hackathonsPassesEquipe as $inscription)
                                    <tr class="hackathon-card">
                                        <td><strong>{{ $inscription->hackathon->thematique }}</strong></td>
                                        <td>{{ $inscription->hackathon->dateheuredebuth }}</td>
                                        <td>{{ $inscription->hackathon->dateheurefinh }}</td>
                                        <td>{{ $inscription->hackathon->ville }} ({{ $inscription->hackathon->lieu }})</td>
                                        <td>
                                            <a href="{{ route('voirLesInfoHackathon', ['idhackathon' => $inscription->hackathon->idhackathon]) }}" 
                                               class="btn btn-primary btn-sm btn-action">
                                               <i class="fas fa-info-circle"></i> Détails
                                            </a>
                                            <a href="{{ route('commentaireHackathon', ['idhackathon' => $inscription->hackathon->idhackathon]) }}" 
                                               class="btn btn-success btn-sm btn-action">
                                               <i class="fas fa-comments"></i> Commentaires
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            @endif
        </div>
    </div>
</div>
@endsection