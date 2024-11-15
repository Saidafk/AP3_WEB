@extends('layouts.app')

@section('title', ' - Atelier')

@section('custom-css')
<link href="{{ asset('css/afficherMembres.css') }}" rel="stylesheet"/>
@endsection

@section('content')
<div class="d-flex flex-column justify-content-center align-items-center min-vh-100 bg fullContainer">


<table>
<h1>Voici les atelier du hackathon {{$hackathon->thematique}} </h1>
    @foreach($ateliers as $atelier)
        <tr>
        
        <td>{{$atelier->titre}} 
        <a class="btn btn-sm btn-primary" href="/planning-hackathon/info/{{$atelier->id_atelier}}"> Voir les infos de l'atelier </a>
        </td>
        </tr>
    @endforeach
</table>
                        
@endsection