@extends('layouts.app')

@section('title', ' - About')

@section('custom-css')
<link href="{{ asset('css/about.css') }}" rel="stylesheet"/>
@endsection

@section('content')
<div class="d-flex flex-column justify-content-center align-items-center bannerHome">
    <h1>À propos de Hackat’Innov</h1>
    <p>
        Bienvenue sur la plateforme Hackat’Innov ! Nous sommes une start-up innovante dédiée à simplifier la gestion des hackathons.
        Depuis notre création, nous avons travaillé pour fournir des outils qui facilitent l'organisation d'événements créatifs et collaboratifs.
    </p>

    <h2>Conditions Générales</h2>
    <p>
        En utilisant notre plateforme, vous acceptez nos conditions générales. Nous vous encourageons à lire attentivement ces règles.
    </p>
    
    <h3>RGPD (Règlement Général sur la Protection des Données)</h3>
    <p>
        Conformément au RGPD, nous garantissons la protection de vos données personnelles. Vous avez le droit d'accéder, de modifier et de supprimer vos données.
    </p>
    
    <h3>Cookies</h3>
    <p>
        Nous utilisons des cookies pour améliorer votre expérience sur notre site. En continuant à utiliser notre site, vous acceptez notre politique en matière de cookies.
    </p>
    
    <h2>Contact</h2>
    <p>
        Pour toute question concernant nos conditions générales ou notre politique de confidentialité, veuillez nous contacter : support@hackatinnov.com</a>.
    </p>
</div>
@endsection

