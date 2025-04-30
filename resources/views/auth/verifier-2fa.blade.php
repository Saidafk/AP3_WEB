@extends('layouts.app')

@section('title', 'Vérification 2FA')

@section('custom-css')
<link href="{{ asset('css/defaut.css') }}" rel="stylesheet"/>
@endsection

@section('content')
<div class="container">
    <h2>Vérification de l'authentification à deux facteurs</h2>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('verifierA2F') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="code_2fa">Entrez le code 2FA envoyé par email</label>
            <input type="text" name="code_2fa" id="code_2fa" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary mt-3">Vérifier</button>

        <a href="{{ route('renvoyerCode2FA') }}" class="btn btn-secondary mt-3">Renvoyer le Code 2FA</a>
        
    </form>
</div>
@endsection
