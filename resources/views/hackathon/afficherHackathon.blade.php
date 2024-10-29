@extends('layouts.app')

@section('title', 'Hackathons')

@section('custom-css')
<link href="{{ asset('css/about.css') }}" rel="stylesheet"/>
@endsection

@section('content')
<div class="d-flex flex-column justify-content-center align-items-center bannerHome">

    <form action="{{ route('voirLesHackathons') }}" method="GET" class="mb-4">
        <div class="form-group">
            <label for="thematique">Thématique</label>
            <input type="text" class="form-control" id="thematique" name="thematique" placeholder="Rechercher par thématique">
        </div>
        
        <div class="form-group">
            <label for="ville">Ville</label>
            <input type="text" class="form-control" id="ville" name="ville" placeholder="Rechercher par ville">
        </div>
        
        <div class="form-group">
            <label for="date">Date de Début</label>
            <input type="date" class="form-control" id="date" name="date">
        </div>

        <button type="submit" class="btn btn-primary" >Rechercher</button>
    </form>

    <h1>Hackathons à venir</h1>
    <ul>
        @foreach ($hackathonsfuturs as $hackathon)
            <li>
                <strong>{{ $hackathon->thematique }}</strong> 
                - du {{ $hackathon->dateheuredebuth }} au {{ $hackathon->dateheurefinh }} 
                à {{ $hackathon->ville }}
                <a href="{{ route('voirLesInfoHackathon', ['idhackathon' => $hackathon->idhackathon]) }}" class="btn btn-primary">Info sur le Hackathon</a>
            </li>
        @endforeach
    </ul>

    <h1>Hackathons passés</h1>
    <ul>
        @foreach ($hackathonspasses as $hackathon)
            <li>
                <strong>{{ $hackathon->thematique }}</strong> 
                - du {{ $hackathon->dateheuredebuth }} au {{ $hackathon->dateheurefinh }} 
                à {{ $hackathon->ville }}
                <a href="{{ route('voirLesInfoHackathon', ['idhackathon' => $hackathon->idhackathon]) }}" class="btn btn-primary">Info sur le Hackathon</a>
            </li>
        @endforeach
    </ul>

    @if($equipe)
    <ul>
        <h1>Votre équipe {{ $inscrire->first()->equipe->nomequipe }} est inscrite au hackathon :</h1>
        @foreach ($inscrire as $inscription)
            <li>
                <strong>{{ $inscription->hackathon->thematique }} </strong> 
                - du {{ $inscription->hackathon->dateheuredebuth }} 
                au {{ $inscription->hackathon->dateheurefinh}} 
                à {{ $inscription->hackathon->ville }}
                <a href="{{ route('voirLesInfoHackathon', ['idhackathon' => $hackathon->idhackathon]) }}" class="btn btn-primary">Info sur le Hackathon</a>
            </li>
        @endforeach
    </ul>
    @else
        <p>Aucune équipe connectée. Veuillez vous connecter pour voir vos participations.</p>
    @endif

</div>
@endsection