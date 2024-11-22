@extends('layouts.app')

@section('title', ' - API admin')

@section('custom-css')
<link href="{{ asset('css/defaut.css') }}" rel="stylesheet"/>
@endsection

@section('content')
    <div class="d-flex flex-column justify-content-center min-vh-100 align-items-center">
        <div class="card col-xl-7  col-lg-9 col-md-10 col-12">
            <div class="card-body">
                <h5 class="card-title">Bienvenue sur la page administrateur</h5>

                @if ($administrateur->active_a2f)
                    <p>L'authentification à deux facteurs est actuellement activée.</p>
                    <a class="btn btn-danger mx-3" href="{{ route('desactiverA2F') }}">Désactiver</a>
                @else
                    <p>L'authentification à deux facteurs est actuellement désactivée.</p>
                    <a class="btn btn-primary mx-3" href="{{ route('activerA2F') }}">Activer</a>
                @endif
            </div>
        </div>
    </div>
@endsection