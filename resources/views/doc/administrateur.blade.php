@extends('layouts.app')

@section('title', ' - API admin')

@section('content')
    <div class="d-flex flex-column justify-content-center min-vh-100 align-items-center">
        <div class="card col-xl-7  col-lg-9 col-md-10 col-12">
            <div class="card-body">
                <h5 class="card-title">
                    Bienvenue sur la page administrateur 

                    Voulez vous activer l'a2f
                    <a class="btn btn-primary mx-3" href="{{ route('activerA2F') }}">Activer</a>




@endsection