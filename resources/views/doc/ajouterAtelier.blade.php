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
        <label for="titre">nom de l'atelier</label>
        <input type="text" name="titre" id="titre">
    </div>

    <div>
        <label for="description">Description de l'atelier</label>
        <input type="text" name="description" id="description">
    </div>

    <div>
        <label for="duree_minutes">Durée de l'évenement (en minute)</label>
        <input type="text" name="duree_minutes" id="duree_minutes">
    </div>

    <div>
        <label for="id_conferencier">Sélectionner un conférencier</label>
        <select name="id_conferencier" id="id_conferencier" required>
        <option value="">-- Choisir un conférencier --</option>
        @foreach($conferencier as $conferencier)
        <option value="{{ $conferencier->id_conferencier }}">{{ $conferencier->nom }} {{ $conferencier->prenom }}</option>
        @endforeach
        </select>
    </div>

    <div>
        <label for="id_salle">Sélectionner une salle</label>
        <select name="id_salle" id="id_salle" required>
        <option value="">-- Choisir une salle --</option>
        @foreach($salle as $salle)
        <option value="{{ $salle->id_salle }}">{{ $salle->nom }} </option>
        @endforeach
        </select>
    </div>

    <div>
        <input type="submit" value="Créer l'atelier">
    </div>
</form>


@endsection