@extends('layouts.app')

@section('title', 'Messagerie Hackathons')

@section('custom-css')
<link href="{{ asset('css/about.css') }}" rel="stylesheet"/>
@endsection

@section('content')
<div class="d-flex flex-column justify-content-center align-items-center bannerHome">

<h1>Commentaires pour le Hackathon : {{ $hackathon->thematique }}</h1>

    <div class="comments">
        @if($commentaire->isEmpty())
            <p>Aucun commentaire trouvé pour ce hackathon.</p>
        @else
            @foreach($commentaire as $commentaire)
                <div class="comment mb-3">
                    <p><strong>{{ $commentaire->contenu }}</strong></p>
                    <p><em>Posté le {{ $commentaire->created_at->format('d/m/Y H:i') }} par l'équipe : {{ $commentaire->equipe ? $commentaire->equipe->nomequipe : 'Équipe inconnue' }}</em></p>
                </div>
            @endforeach
        @endif
    </div>    
</div>



@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

    

    @if(session('success'))
        <div class="alert alert-success mt-3">
            {{ session('success') }}
        </div>
    @endif

</div>
@endsection
