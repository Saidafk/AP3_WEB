@extends('layouts.app')

@section('title', 'Hackathons')

@section('custom-css')
<link href="{{ asset('css/about.css') }}" rel="stylesheet"/>
@endsection

@section('content')
<div class="d-flex flex-column justify-content-center align-items-center bannerHome">
    <form action="{{ route('voirLesHackathons') }}" method="GET" class="mb-4" style="margin-top: 100px; width: 100%; max-width: 400px;">

        <div class="form-group">
            <label for="villeSelect">Ville :</label>
            <input type="text" id="villeSelect" name="ville" class="form-control" placeholder="Ville" value="{{ request('ville') }}">
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
                    à {{ $hackathon->ville }}
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
                    à {{ $hackathon->ville }}
                    <a href="{{ route('voirLesInfoHackathon', ['idhackathon' => $hackathon->idhackathon]) }}" class="btn btn-primary">Info sur le Hackathon</a>
                </li>
            @endforeach
        @endif
    </ul>

    @if($equipe)
        <h1>Votre équipe {{ $inscrire->first()->equipe->nomequipe }} est inscrite au hackathon :</h1>
        <ul>
            @foreach ($inscrire as $inscription)
                <li>
                    <strong>{{ $inscription->hackathon->thematique }} </strong> 
                    - du {{ $inscription->hackathon->dateheuredebuth }} 
                    au {{ $inscription->hackathon->dateheurefinh}} 
                    à {{ $inscription->hackathon->ville }}
                    <a href="{{ route('voirLesInfoHackathon', ['idhackathon' => $inscription->hackathon->idhackathon]) }}" class="btn btn-primary">Info sur le Hackathon</a>
                    <a href="{{ route('commentaireHackathon', ['idhackathon' => $inscription->hackathon->idhackathon]) }}" class="btn btn-primary">Message</a>
                </li>
            @endforeach
        </ul>
    @else
        <p>Aucune équipe connectée. Veuillez vous connecter pour voir vos participations.</p>
    @endif
</div>
@endsection
