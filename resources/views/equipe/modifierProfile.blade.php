@extends('layouts.app')

@section('title', ' - Modification du profile')

@section('custom-css')
<link href="{{ asset('css/modifierProfile.css') }}" rel="stylesheet"/>
@endsection


@section('content')
<div class="d-flex flex-column justify-content-center align-items-center bannerHome">
    <h1>Equipe {{$nomEquipe}} </h1>

    <form action="{{ route('modifierProfile') }}" method="POST">
                    @csrf
                    <div class="col">
                        <input required type="text" placeholder="Nom de votre équipe" name="nomequipe" class="form-control"/>
                    </div>
                    <div class="col">
                        <input required type="text" placeholder="Email de votre equipe" name="login" class="form-control"/>
                    </div>
                    <div class="col">
                        <input type="text" placeholder="Portefolio de votre équipe" name="portfolio" class="form-control"/>
                    </div>
                    <div class="col">
                        <input required type="text" placeholder="Nouveau mot de passe" name="password" class="form-control"/>
                    </div>
                    <div class="col">
                        <input required type="text" placeholder="Veuillez le confirmer" name="confirmpassword" class="form-control"/>
                    </div>
                    <button type="submit" class="btn btn-primary">Modifier</button>

                </form>

    

@endsection