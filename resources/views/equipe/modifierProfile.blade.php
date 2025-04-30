@extends('layouts.app')

@section('title', ' - Mon Profile')

@section('custom-css')
<link href="{{ asset('css/modifierProfile.css') }}" rel="stylesheet"/>
@endsection

@section('content')
<div class="d-flex flex-column justify-content-center align-items-center bannerHome">
    <h1>Modifier votre profil</h1>


    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('miseAjourProfile') }}"> 
            @csrf
            <div class="mb-3">
                <label for="nomequipe" class="form-label">Nom de l'équipe</label>
                <input type="text" class="form-control" id="nomequipe" name="nomequipe" value="{{$equipe->nomequipe }}" required>
            </div>

            <div class="mb-3">
                <label for="lienprototype" class="form-label">Lien de votre prototype</label>
                <input type="text" class="form-control" id="lienprototype" name="lienprototype" value="{{$equipe->lienprototype }}" required>
            </div>

            <div class="mb-3">
                <label for="login" class="form-label">Email</label>
                <input type="login" class="form-control" id="login" name="login" value="{{$equipe->login }}" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Mot de passe (laisser vide pour ne pas changer)</label>
                <input type="password" class="form-control" id="password" name="password">
            </div>

            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Confirmer le mot de passe</label>
                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
            </div>

            <button type="submit" class="btn btn-primary">Mettre à jour</button>
        </form>
</div>
@endsection