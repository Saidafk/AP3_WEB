@extends('layouts.app')

@section('title', ' - API admin')

@section('content')
    <div class="d-flex flex-column justify-content-center min-vh-100 align-items-center">
        <div class="card col-xl-7  col-lg-9 col-md-10 col-12">
            <div class="card-body">
                <h5 class="card-title">
                Vous pouvez ajouter un atelier ici

                <form action="/doc-api/administrateur/creation-atelier" method="post">
    @csrf

    <div>
        <label for="nomAtelier">nom de l'atelier</label>
        <input type="text" name="nomAtelier" id="nomAtelier">
    </div>

    <div>
        <label for="datedebut">date du debut de l'atelier</label>
        <input type="date" name="datedebut" id="datedebut">
    </div>

    <div>
        <label for="datefin">date de fin de l'atelier</label>
        <input type="date" name="datefin" id="datefin">
    </div>

    <div>
        <label for="idConferencier">id du conferencier</label>
        <select name="idConferencier" id="idConferencier">
            @foreach($conferencier as $conferenciers)
                <option value="{{$conferencier->idConferencier}}">{{$conferencier->nomConferencier}} {{$conferencier->prenomConferencier}}</option>
            @endforeach
        </select>
    </div>

    <div>
        <label for="idSalle">id de la salle</label>
        <select name="idSalle" id="idSalle">
            @foreach($salle as $salles)
                <option value="{{$salle->idsalle}}">{{$salle->nomSalle}}</option>
            @endforeach
        </select>
    </div>


    <div>
        <input type="submit" value="Créer l'atelier">
    </div>
</form>




                @endsection