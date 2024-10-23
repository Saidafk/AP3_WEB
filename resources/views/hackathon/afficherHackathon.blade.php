@extends('layouts.app')

@section('title', 'Hackathons')

@section('custom-css')
<link href="{{ asset('css/about.css') }}" rel="stylesheet"/>
@endsection

@section('content')
<div class="d-flex flex-column justify-content-center align-items-center bannerHome">

    <h1>Hackathons à venir</h1>
    <ul>
        @foreach ($hackathonsfuturs as $hackathon)
            <li>
                <strong>{{ $hackathon->thematique }}</strong> 
                - du {{ $hackathon->dateheuredebuth }} au {{ $hackathon->dateheurefinh }} 
                à {{ $hackathon->ville }}
            </li>
        @endforeach
    </ul>

    <h1>Hackathons passés</h1>
    <ul>
        @foreach ($hackathonspasses as $hackathon)
            <li>
                <strong>{{ $hackathon->thematique }}</strong> 
                - du {{ $hackathon->dateheuredebuth }} au {{ $hackathon->dateheurefinh }} 
                à {{ $hackathon->ville }}
            </li>
        @endforeach
    </ul>

    @if($equipe) <!-- Vérifiez que l'équipe existe -->

    <ul>

    <h1>Votre équipe {{ $inscrire->first()->equipe->nomequipe }} est inscrite au hackathon :</h1>
    
    @foreach ($inscrire as $inscription)
        
        <li>
           <strong>{{ $inscription->hackathon->thematique }} </strong> 
           - du {{ $inscription->hackathon->dateheuredebuth }} 
            au {{ $inscription->hackathon->dateheurefinh}} 
            à {{ $inscription->hackathon->ville }}
        </li>
    @endforeach
</ul>
    @else
        <p>Aucune équipe connectée. Veuillez vous connecter pour voir vos participations.</p>
    @endif

</div>
@endsection