@extends('layouts.app')

@section('title', 'À propos')

@section('custom-css')
<link href="{{ asset('css/about.css') }}" rel="stylesheet"/>


@section('content')
<div class="container my-5">
    <div class="card p-4 shadow-sm">
        <h1 class="text-center mb-4">À propos de Hackat’Innov</h1>
        <p class="lead">
            Bienvenue sur la plateforme Hackat’Innov ! Nous sommes une start-up innovante dédiée à simplifier la gestion des hackathons. 
            Depuis notre création, nous avons travaillé pour offrir des outils modernes permettant aux participants, organisateurs et partenaires de collaborer efficacement.
        </p>
        
        <h2 class="mt-5">Conditions Générales d'Utilisation</h2>
        <p>
            L'utilisation de Hackat’Innov implique l'acceptation des conditions suivantes :
        </p>
        <ul>
            <li><strong>Inscription :</strong> Les participants doivent fournir des informations exactes et à jour lors de l'inscription.</li>
            <li><strong>Respect des règles :</strong> Toute tentative de fraude ou non-respect des règlements des hackathons entraînera l'exclusion de la plateforme.</li>
            <li><strong>Confidentialité :</strong> Les informations partagées sur la plateforme ne doivent pas être divulguées sans autorisation explicite.</li>
        </ul>

        <h3 class="mt-5">Engagements en matière de RGPD (Règlement Général sur la Protection des Données)</h3>
        <p>
            En tant qu'utilisateur inscrit sur notre plateforme, voici vos droits et les mesures que nous prenons pour garantir votre conformité au RGPD :
        </p>
        <ul>
            <li><strong>Collecte des données :</strong> Nous collectons uniquement les données nécessaires à l'organisation des hackathons. 
                Ces données incluent, entre autres : votre nom, prénom, adresse e-mail, informations sur vos projets, et vos préférences de participation.</li>
            <li><strong>Consentement :</strong> Avant de vous inscrire ou de participer, vous devez accepter notre politique de confidentialité et nos conditions d'utilisation. 
                Vous pouvez retirer ce consentement à tout moment via votre espace utilisateur.</li>
            <li><strong>Droit à l'accès :</strong> Vous avez le droit de consulter les données personnelles que nous détenons à votre sujet.</li>
            <li><strong>Modification et suppression :</strong> Vous pouvez corriger ou supprimer vos informations directement via votre profil ou en contactant notre support à <a href="mailto:support@hackatinnov.com">support@hackatinnov.com</a>.</li>
            <li><strong>Sécurité :</strong> Nous utilisons des protocoles de cryptage avancés et des pare-feux pour protéger vos données contre tout accès non autorisé.</li>
            <li><strong>Partage limité :</strong> Vos données personnelles ne seront jamais partagées avec des tiers sans votre consentement explicite, sauf si cela est nécessaire pour l'organisation d'un hackathon (par exemple, partage avec un organisateur).</li>
        </ul>

        <h3 class="mt-5">Utilisation des Cookies</h3>
        <p>
            Hackat’Innov utilise des cookies pour vous offrir une expérience utilisateur optimale. Voici comment nous utilisons ces cookies :
        </p>
        <ul>
            <li><strong>Cookies fonctionnels :</strong> Ces cookies sont essentiels pour le fonctionnement de la plateforme. Ils permettent de mémoriser vos choix de session, comme la langue sélectionnée ou votre connexion.</li>
            <li><strong>Cookies analytiques :</strong> Nous utilisons des outils comme Google Analytics pour comprendre comment vous interagissez avec notre site et améliorer nos services.</li>
            <li><strong>Cookies publicitaires :</strong> Bien que nous n'affichions pas de publicités, nous utilisons des cookies pour personnaliser votre expérience en fonction de vos préférences.</li>
        </ul>

        <h2 class="mt-5">Vos Droits et Notre Responsabilité</h2>
        <p>
            Nous sommes pleinement engagés à respecter vos droits. En cas de problème ou si vous souhaitez signaler une violation de la confidentialité, 
            vous pouvez contacter notre délégué à la protection des données (DPO) à l'adresse suivante : <a href="mailto:dpo@hackatinnov.com">dpo@hackatinnov.com</a>.
        </p>
        <p>
            Si vous estimez que vos droits n'ont pas été respectés, vous pouvez également contacter la CNIL (Commission Nationale de l'Informatique et des Libertés) via leur site officiel : <a href="https://www.cnil.fr">www.cnil.fr</a>.
        </p>

        <h2 class="mt-5">Contact</h2>
        <p>
            Pour toute question ou demande, n'hésitez pas à nous contacter : <a href="mailto:support@hackatinnov.com">support@hackatinnov.com</a>.
        </p>
    </div>
</div>
@endsection
@endsection