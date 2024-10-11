@extends('layouts.app')

@section('title', ' - Desinscription d'un Hackathon')

@section('custom-css')
<link href="{{ asset('css/confirmationSuppression.css') }}" rel="stylesheet"/>
@endsection

@section('content')
<div class="bannerHome">
<div class="d-flex flex-column justify-content-center align-items-center bannerHome">


    <h1>Quittez le hackathon</h1>
    <h1>Êtes-vous sûr de vouloir vous desinscrire de l'évenement ?</h1>
    <form method="POST" action="{{ route('confirmationDesinscription', $equipe->idequipe) }}" style="display: inline-block;">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger btn-small">Quitter le hackathon</button>
    </form>
</div>

@endsection