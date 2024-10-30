@extends('layouts.app')

@section('title', 'Messagerie Hackathons')

@section('custom-css')
<link href="{{ asset('css/about.css') }}" rel="stylesheet"/>
@endsection

@section('content')
<div class="d-flex flex-column justify-content-center align-items-center bannerHome">

    <div class="comments">
        @foreach($commentaire as $commentaire)
            <div class="comment">
            
                <p>{{ $commentaire->contenu }}</p> 
                
            </div>
        @endforeach
    </div>

    <form action="{{ route('ajoutCommentaire', $hackathon->idhackathon) }}" method="POST">
    @csrf
    <textarea name="message" rows="4" placeholder="Ajouter un commentaire..." required></textarea>
    <button type="submit">Envoyer</button>
</form>

    
    @if(session('success'))
        <div class="alert alert-success mt-3">
            {{ session('success') }}
        </div>
    @endif

</div>
@endsection