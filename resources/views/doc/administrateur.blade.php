@extends('layouts.app')

@section('title', ' - API admin')

@section('custom-css')
<link href="{{ asset('css/team.css') }}" rel="stylesheet"/>
@endsection

@section('content')
<div v-scope v-cloak class="d-flex flex-column justify-content-center align-items-center bannerHome">  
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

    <script type="module">
    import { createApp } from 'https://unpkg.com/petite-vue?module';

    createApp({
        message: "Hello from Petite Vue!"
    }).mount();
</script>

@endsection