@extends('layouts.app')

@section('title', 'QR Code de l\'Authentification à Deux Facteurs')

@section('content')
<div class="container">
    <h2>Activation de l'authentification à deux facteurs</h2>
    
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <p>Scannez ce QR Code avec votre application Google Authenticator ou une application d'authentification compatible :</p>

    <div>{!! $QR_Image !!}</div>

    <p>Ou utilisez ce code secret pour configurer l'application : <strong>{{ $secretKey }}</strong></p>

    <a href="{{ route('voirAdmin', ['administrateur' => $administrateur]) }}" class="btn btn-success">Terminer</a>
</div>
@endsection
