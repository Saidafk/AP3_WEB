@extends('layouts.app')

@section('title', ' - Détail Atelier')

@section('custom-css')
    <link href="{{ asset('css/afficherMembres.css') }}" rel="stylesheet"/>
@endsection

@section('content')
<div class="d-flex flex-column justify-content-center align-items-center min-vh-100 bg fullContainer">
    
    <h1>Detail de l'atelier {{$titre}}</h1>


    <table>
    
    <p><strong>Description :</strong> {{ $description }}</p>
                
                <p><strong>Début :</strong> {{ $debuta }}</p>
                <p><strong>Fin :</strong> {{ $fina }}</p>
                <p><strong>Durée (en minute) : </strong>{{ $duree_minutes_arrondie }}</p>
                
                @if ($ATS)
            
            @foreach($ATS as $current)
        <p><strong>Nom et prénom conférencier : </strong> {{ $current->confName }} {{ $current->confFirstName }}</p>
        
        @endforeach
        <p><strong>Salle de l'atelier : </strong> {{ $current->salleName }}</p>
        
        @else
            <p><strong>Aucune information disponible :</strong> Il n'y a pas de conférencier ni de salle attribués pour cet atelier pour le moment.</p>
        @endif
    </div>
    </table>

@endsection
