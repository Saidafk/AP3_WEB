@extends('layouts.app')

@section('title', 'Messagerie Hackathons')

@section('custom-css')
<link href="{{ asset('css/chat.css') }}" rel="stylesheet"/>
@endsection

@section('content')
<div class="d-flex flex-column justify-content-center align-items-center bannerHome">

    <h1>Commentaires pour le Hackathon : {{ $hackathon->thematique }}</h1>

    <div>
        @foreach($commentaires as $commentaire) 
            <div class="comment mb-3">
                <p><strong>{{ $commentaire->contenu }}</strong></p>
                <p><em>Posté le {{ $commentaire->created_at->format('d/m/Y H:i') }} par l'équipe : {{ $commentaire->equipe ? $commentaire->equipe->nomequipe : 'Équipe inconnue' }}</em></p>
            </div>
        @endforeach        
    </div> 

    <h3>Ajouter un commentaire :</h3>
    <form action="{{ route('ajoutCommentaire', ['idhackathon' => $hackathon->idhackathon]) }}" method="POST">
        @csrf
        <div class="form-group">
            <textarea name="contenu" class="form-control" rows="3" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Ajouter un commentaire</button>
    </form>
</div>
@endsection

