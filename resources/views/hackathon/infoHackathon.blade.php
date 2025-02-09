@extends('layouts.app')

@section('title', 'Détails du Hackathon')

@section('custom-css')
<link href="{{ asset('css/defaut.css') }}" rel="stylesheet"/>
@endsection

@section('content')
<div class="d-flex flex-column justify-content-center align-items-center bannerHome">



    <h1>Détails du Hackathon : {{ $hackathon->thematique }}</h1>

    <p><strong>Lieu :</strong> {{ $hackathon->lieu }}</p>
    <p><strong>Ville :</strong> {{ $hackathon->ville }}</p>
    <p><strong>Date et Heure de Début :</strong> {{ $hackathon->dateheuredebuth }}</p>
    <p><strong>Date et Heure de Fin :</strong> {{ $hackathon->dateheurefinh }}</p>
    <p><strong>Conditions de Participation :</strong> {{ $hackathon->conditions }}</p>
    <p><strong>Thématique :</strong> {{ $hackathon->thematique }}</p>
    <p><strong>Objectifs :</strong> {{ $hackathon->objectifs }}</p>
    <p><strong>Nombre d'Équipes Maximum :</strong> {{ $hackathon->nbEquipe }}</p>
    
    @if (now() < $hackathon->dateheurefinh) 
        <p><strong>Nombre de places restantes :</strong> {{ $nbPlaceRestante }}</p>
    @endif

    <p><strong>Date Butoir d'Inscription :</strong> {{ $hackathon->dateButoir }}</p>

    <!-- Bouton de retour à la liste des hackathons -->
    <a href="{{ route('voirLesHackathons') }}" class="btn btn-primary">Retour aux hackathons</a>
</div>
@endsection