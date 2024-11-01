@extends('layouts.app')

@section('title', ' - Téléchargement des données')

@section('custom-css')
<link href="{{ asset('css/about.css') }}" rel="stylesheet"/>
@endsection

@section('content')
<div class="d-flex flex-column justify-content-center align-items-center bannerHome">
    <h3 class="text-center mb-4">Confirmation de Téléchargement des Données</h3>
    <p>Vous êtes sur le point de télécharger toutes les données de l'équipe <strong>{{ $equipe->nomequipe }}</strong>.</p>
    <p>Cela inclut les informations personnelles des membres, l'historique de connexion, et les détails de participation.</p>
        
    <p class="text-danger"><strong>Attention :</strong> Assurez-vous d'avoir l'autorisation nécessaire pour télécharger ces données sensibles.</p>

    <form method="POST" action="{{ route('confirmationTelechargerLesDonnees') }}">
    @csrf
    <button type="submit" class="btn btn-primary">Confirmer et Télécharger</button>
</form>
        <a href="{{ route('me') }}" class="btn btn-secondary">Non, revenir au profil</a>
</div>


    
        

    

@endsection