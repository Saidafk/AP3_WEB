@extends('layouts.app')

@section('title', 'Hackathons')

@section('custom-css')
<link href="{{ asset('css/defaut.css') }}" rel="stylesheet"/>
@endsection

@section('content')

    <div class="d-flex flex-column justify-content-center align-items-center bannerHome">
        <form action="{{ route('voirLesHackathons') }}" method="GET" class="mb-4" style="margin-top: 100px; width: 100%; max-width: 400px;">
            <div class="form-group">
                <label for="villeSelect">Ville :</label>
                <input type="text" id="villeSelect" name="ville" class="form-control" placeholder="Ville" value="{{ request('ville') }}">
            </div>

            <div class="form-group">
                <label for="lieuSelect">Lieu :</label>
                <input type="text" id="lieuSelect" name="lieu" class="form-control" placeholder="Lieu" value="{{ request('lieu') }}">
            </div>

            <div class="form-group">
                <label for="dateDebut">Date de Début :</label>
                <input type="date" id="dateDebut" name="date_debut" class="form-control" value="{{ request('date_debut') }}">
            </div>

            <button type="submit" class="btn btn-primary mt-3">Rechercher</button>
        </form>

        <h1>Hackathons à venir</h1>
        <ul>
            @if ($hackathonsfuturs->isEmpty())
                <li>Aucun hackathon à venir ne correspond à vos critères.</li>
            @else
                @foreach ($hackathonsfuturs as $hackathon)
                    <li>
                        <strong>{{ $hackathon->thematique }}</strong> 
                        - du {{ $hackathon->dateheuredebuth }} au {{ $hackathon->dateheurefinh }} 
                        à {{ $hackathon->ville }} {{ $hackathon->lieu }}
                        <a href="{{ route('voirLesInfoHackathon', ['idhackathon' => $hackathon->idhackathon]) }}" class="btn btn-primary">Info sur le Hackathon</a>
                    </li>
                @endforeach
            @endif
        </ul>

        <h1>Hackathons passés</h1>
        <ul>
            @if ($hackathonspasses->isEmpty())
                <li>Aucun hackathon passé ne correspond à vos critères.</li>
            @else
                @foreach ($hackathonspasses as $hackathon)
                    <li>
                        <strong>{{ $hackathon->thematique }}</strong> 
                        - du {{ $hackathon->dateheuredebuth }} au {{ $hackathon->dateheurefinh }} 
                        à {{ $hackathon->ville }} {{ $hackathon->lieu }}
                        <a href="{{ route('voirLesInfoHackathon', ['idhackathon' => $hackathon->idhackathon]) }}" class="btn btn-primary">Info sur le Hackathon</a>
                    </li>
                @endforeach
            @endif
        </ul>

        <!-- Vérification si l'équipe est connectée -->
        @if(!$equipe)
            <p>Aucune équipe connectée. Veuillez vous connecter pour voir vos participations.</p>
        @else
            <!-- Hackathons à venir auxquels l'équipe est inscrite -->
            <h1>Hackathons à venir auxquels vous êtes inscrit</h1>
            @if ($hackathonsFutursEquipe->isEmpty())
                <p>Aucun hackathon futur auquel vous êtes inscrit.</p>
            @else
                <ul>
                    @foreach ($hackathonsFutursEquipe as $inscription)
                        <li>
                            <strong>{{ $inscription->hackathon->thematique }} </strong>
                            - du {{ $inscription->hackathon->dateheuredebuth }} 
                            au {{ $inscription->hackathon->dateheurefinh }} 
                            à {{ $inscription->hackathon->ville }} {{ $inscription->hackathon->lieu }}
                            <a href="{{ route('voirLesInfoHackathon', ['idhackathon' => $inscription->hackathon->idhackathon]) }}" class="btn btn-primary">Info sur le Hackathon</a>
                        </li>
                    @endforeach
                </ul>
            @endif

            <!-- Hackathons passés auxquels l'équipe est inscrite -->
            <h1>Hackathons passés auxquels vous êtes inscrit</h1>
            @if ($hackathonsPassesEquipe->isEmpty())
                <p>Aucun hackathon passé auquel vous êtes inscrit.</p>
            @else
                <ul>
                    @foreach ($hackathonsPassesEquipe as $inscription)
                        <li>
                            <strong>{{ $inscription->hackathon->thematique }} </strong>
                            - du {{ $inscription->hackathon->dateheuredebuth }} 
                            au {{ $inscription->hackathon->dateheurefinh }} 
                            à {{ $inscription->hackathon->ville }} {{ $inscription->hackathon->lieu }}
                            <a href="{{ route('voirLesInfoHackathon', ['idhackathon' => $inscription->hackathon->idhackathon]) }}" class="btn btn-primary">Info sur le Hackathon</a>
                            <a href="{{ route('commentaireHackathon', ['idhackathon' => $inscription->hackathon->idhackathon]) }}" class="btn btn-primary">Voir les Commentaires</a>
                        </li>
                    @endforeach
                </ul>
            @endif
        @endif
    </div>

@endsection
