@extends('layouts.app')

@section('title', 'Hackathons')

@section('custom-css')


<link href="{{ asset('css/tableau.css') }}" rel="stylesheet"/>
<link href="{{ asset('css/afficherHackathon.css') }}" rel="stylesheet"/>
@endsection


@section('content')
    <h1>Liste des ateliers</h1>
    @if ($ateliers->isEmpty())
        <p>Aucun atelier trouvé.</p>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Titre</th>
                    <th>Description</th>
                    <th>Niveau</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($ateliers as $atelier)
                    <tr>
                        <td>{{ $atelier->titre }}</td>
                        <td>{{ $atelier->description }}</td>
                        <td>{{ $atelier->niveau()->first()->description }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
@endsection