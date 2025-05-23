@extends('layouts.app')

@section('title', ' - Liste des API')

@section('custom-css')
<link href="{{ asset('css/defaut.css') }}" rel="stylesheet"/>

@section('content')

<div v-scope v-cloak class="d-flex flex-column justify-content-center align-items-center bannerHome">  

    <div class="documentation">

    <div class="card mt-5">
            <div class="card-body">
                <h2 class="text-center">Vous êtes connecté en tant que administrateur</h2>
                <div class="d-flex justify-content-center align-items-center">
                <a class="btn btn-primary mx-3" href="/doc-api/administrateur">Admin info</a>
                <!--  <a class="btn btn-primary mx-3" href="/doc-api/administrateur/atelier">Gerer les ateliers</a> -->     
                <a href="/logoutAdmin" class="btn btn-danger btn-small">Déconnexion</a>
                </div>
            </div>
        </div>

        <div class="card w-200">
            <div class="card-body">
                <h2 class="text-center">Documentation API (HTML)</h2>
                <div class="d-flex justify-content-center align-items-center">
                    <a class="btn btn-primary mx-3" href="/doc-api/hackathons">Les hackathons</a>
                    <a class="btn btn-primary mx-3" href="/doc-api/equipes">Les équipes</a>
                    <a class="btn btn-primary mx-3" href="/doc-api/membres">Les membres</a>
                </div>
            </div>
        </div>

        <div class="card mt-5">
            <div class="card-body">
                <h2 class="text-center">Documentation API (OpenAPI)</h2>
                <div class="d-flex justify-content-center align-items-center">
                    <a class="btn btn-primary mx-3" href="/documentation.yaml" target="_blank">1. Copier la documentation YAML</a>
                    <a class="btn btn-primary mx-3" href="https://editor.swagger.io" target="_blank">2. Coller dans Swagger Editor</a>
                </div>
            </div>
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