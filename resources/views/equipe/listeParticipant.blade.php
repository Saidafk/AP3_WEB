@extends('layouts.app')

@section('title', ' - Liste des Participants')

@section('custom-css')
    <link href="/css/participant.css" rel="stylesheet"/>
@endsection

@section('content')
    <div class="container">
    
        <h1>Liste des Participants</h1>
        
        @if($equipes->isEmpty())
            <p>Aucun participant inscrit pour le moment.</p>
        @else
            <ul class="list-unstyled">
                @foreach($equipes as $equipe)
                    <li>
                        <h2>{{ $equipe->nom }}</h2>
                        <ul>
                            @foreach($equipe->membres as $membre)
                                <li>{{ $membre->nom }} {{ $membre->prenom }}</li>
                            @endforeach
                        </ul>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
@endsection