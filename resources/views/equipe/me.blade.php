@extends('layouts.app')

@section('title', ' - Mon équipe')

@section('custom-css')
<link href="{{ asset('css/about.css') }}" rel="stylesheet"/>
@endsection

@section('content')
    <div class="d-flex flex-column justify-content-center align-items-center min-vh-100 bg fullContainer">


        <div class="card cardRadius">
            <div class="card-body">
                <!-- Affichage message flash de type "success" -->
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- Affichage message flash de type "error" -->
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="list-unstyled text-start m-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <h3>Bienvenue "{{ $connected->nomequipe }}"</h3>

                @if ($hackathon != null && $hackathon->pivot->datedesinscription == null)
                    <h5>Votre équipe est inscrite au Hackathon <br><br> « {{ $hackathon->thematique }} »</h5>
                    
                    <br/>
                    <img src="{{ $hackathon->affiche }}" alt="Affiche de l'évènement." class="w-50"/>
                @else
                    <p>
                        Vous ne participez à aucun évènement.
                    </p>
                @endif
                
                


            </div>

            <div class="card-actions">
                <a href="/modifierProfile" class="btn btn-primary">Modifier votre profile</a>
                <a href="/logout" class="btn btn-danger btn-small">Déconnexion</a>
                @if($hackathon->pivot->datedesinscription == null)
                <a href="/desinscription" class="btn btn-danger btn-small">Quitter le hackathon</a>
                @endif
            </div>
        </div>

        <div class="card cardRadius mt-3">
            <div class="card-body">


                <h3 class="text-start">Membres de votre équipe</h3>

                <ul class="p-0 m-0 mb-2">
                    @foreach ($membres as $m)
                        <li class="member">🧑‍💻 {{ "{$m->nom} {$m->prenom}" }}</li>
                        <div class="card-actions">
                        
                        
                        
                                <a href="{{ route('supprimerMembre', ['membre' => $m->idmembre]) }}" class="btn btn-danger btn-small">supprimer le membre</a>
           
                            
            </div>
                    @endforeach
                    
                </ul>

                <form method="post" class="col-12" action="{{ route("membre-add") }}">
                    @csrf
                    <div class="col-12">
                        <input required type="text" placeholder="Nom" name="nom" class="form-control"/>
                    </div>
                    <div class="col-12">
                        <input required type="text" placeholder="Prénom" name="prenom" class="form-control"/>
                    </div>
                    <div class="col-12">
                        <input required type="text" placeholder="Email" name="email" class="form-control"/>
                    </div>
                    <div class="col-12">
                        <input required type="text" placeholder="Numéro de téléphone" name="telephone" class="form-control"/>
                    </div>
                    <div class="col-12">
                        <input required type="datetime-local" placeholder="Date de Naissance" name="datenaissance" class="form-control"/>
                    </div>
                    
                    <div class="col-12">
                        <input type="submit" value="Ajouter" class="btn btn-success d-block w-100"/>
                    </div>

                </form>
            </div>
        </div>

    </div>
@endsection
