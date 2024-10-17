@extends('layouts.app')

@section('title', 'Confirmation de désinscription')

@section('content')
<div class="d-flex flex-column justify-content-center align-items-center min-vh-100 bg fullContainer">
    <div class="card cardRadius">
        <div class="card-body">
            <h3>Êtes-vous sûr de vouloir quitter le hackathon "{{ $hackathon->thematique }}" ?</h3>
            <p>Cette action ne peut pas être annulée.</p>
            <form method="POST" action="{{ route('confirmationDesinscription') }}">
                @csrf
                <input type="hidden" name="hackathon_id" value="{{ $hackathon->idhackathon }}">
                <button type="submit" class="btn btn-danger">Oui, quitter le hackathon</button>
                <a href="{{ route('me') }}" class="btn btn-secondary">Non, revenir à mon profil</a>
            </form>
        </div>
    </div>
</div>
@endsection