

@extends('layouts.app')

@section('title', ' - Suppression d\'un membre')

@section('custom-css')
<link href="{{ asset('css/confirmationSuppression.css') }}" rel="stylesheet"/>
@endsection

@section('content')
<div class="bannerHome">
<div class="d-flex flex-column justify-content-center align-items-center bannerHome">
    <h1>Suppression d'un membre</h1>
    <h1>Êtes-vous sûr de vouloir supprimer le membre {{ $membre->nom }} {{ $membre->prenom }} ?</h1>
    <form method="POST" action="{{ route('confirmationSupression', $membre->idmembre) }}" style="display: inline-block;">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger btn-small">Supprimer le membre</button>
    </form>
</div>
@endsection