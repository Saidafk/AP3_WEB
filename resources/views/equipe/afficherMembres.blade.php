@extends('layouts.app')

@section('title', ' - Liste des membres')

@section('custom-css')
<link href="{{ asset('css/afficherMembres.css') }}" rel="stylesheet"/>
@endsection

@section('content')
<div class="d-flex flex-column justify-content-center align-items-center min-vh-100 bg fullContainer">


<table>
<h1>Voici les membre de l'équipe {{$nomEquipe}} </h1>
    @foreach($equipes as $membre)
        <tr>
        <td>Nom Prénom : {{$membre->nom}} {{$membre->prenom}}</td>
        </tr>
    @endforeach
</table>
                        
@endsection

   