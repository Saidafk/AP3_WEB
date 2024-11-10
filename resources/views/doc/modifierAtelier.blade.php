@extends('layouts.app')

@section('title', 'Modifier Atelier')

@section('content')
<div class="d-flex flex-column justify-content-center min-vh-100 align-items-center">
    <div class="card col-xl-7 col-lg-9 col-md-10 col-12">
        <div class="card-body">
            <h5 class="card-title">
                Modifier Atelier
            </h5>

            <form method="POST" action="{{ route('mettreAJourAtelier') }}">
                @csrf

                <input type="hidden" name="id_atelier" value="{{ $atelier->id_atelier }}">

                <div class="mb-3">
                    <label for="titre">Titre de l'atelier</label>
                    <input type="text" class="form-control" id="titre" name="titre" value="{{ $atelier->titre }}" required>
                </div>

                <div class="mb-3">
                    <label for="description">Description de l'atelier</label>
                    <textarea class="form-control" id="description" name="description" required>{{ $atelier->description }}</textarea>
                </div>

                <div class="mb-3">
                    <label for="duree_minutes">Durée (minutes)</label>
                    <input type="number" class="form-control" id="duree_minutes" name="duree_minutes" value="{{ $atelier->duree_minutes }}" required>
                </div>

                

                <button type="submit" class="btn btn-primary">Mettre à jour</button>
            </form>
        </div>
    </div>
</div>
@endsection
