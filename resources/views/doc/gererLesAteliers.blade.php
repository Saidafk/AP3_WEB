@extends('layouts.app')

@section('title', ' - API admin')

@section('content')
    <div class="d-flex flex-column justify-content-center min-vh-100 align-items-center">
        <div class="card col-xl-7  col-lg-9 col-md-10 col-12">
            <div class="card-body">
                <h5 class="card-title">
                gerer les ateliers

Vous etes etes sur la page qui vous informe des atelier et activité du prochaine hackathon

<a class="btn btn-primary mx-3" href="/doc-api/administrateur/creation-atelier">Creer un ateliers</a> 

<a class="btn btn-primary mx-3" href="/doc-api/administrateur/modifier-atelier">Modifier les ateliers</a> 

faire formulaire creation d'un atelier assigner une salle et des conferencier 

@endsection