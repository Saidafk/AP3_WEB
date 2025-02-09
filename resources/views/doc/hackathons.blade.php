@extends('layouts.app')

@section('title', ' - API Hackathons')

@section('custom-css')
<link href="{{ asset('css/team.css') }}" rel="stylesheet"/>
@endsection


@section('content')
<div v-scope v-cloak class="d-flex flex-column justify-content-center align-items-center bannerHome"> 
<div class="d-flex flex-column justify-content-center align-items-center main-content">
        <div class="card col-xl-7  col-lg-9 col-md-10 col-12">
            <div class="card-body">
                <h5 class="card-title">Liste des Hackathons</h5>
                <table class="table card-text">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Thématique</th>
                        <th scope="col">Lieu</th>
                        <th scope="col">Début</th>
                        <th scope="col">Fin</th>
                        <th scope="col"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($data as $hackaton)
                        <tr>
                            <th><?= $hackaton->idhackathon ?></th>
                            <td><?= $hackaton->thematique ?></td>
                            <td><?= $hackaton->lieu ?></td>
                            <td><?= $hackaton->dateheuredebuth ?></td>
                            <td><?= $hackaton->dateheurefinh ?></td>
                            <td>
                                <a class="btn btn-sm btn-primary" href="/doc-api/equipes?idh={{$hackaton->idhackathon}}">
                                    Les équipes
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card col-xl-7  col-lg-9 col-md-10 col-12 mt-5">
            <div class="card-body">
                <h5 class="card-title">API JSON</h5>

                <div class="card-text">
                    <div>
                        Les Hackathons :
                        <code>
                            GET /api/hackathon/all
                        </code>
                    </div>
                    <div>
                        Hackathons actuellement actif :
                        <code>
                            GET /api/hackathon/active
                        </code>
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
