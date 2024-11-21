<h1>Confirmation d'inscription</h1>

<p>Bonjour,</p>

<p>Votre équipe {{ $equipe->nomequipe }} est maintenant inscrite au hackathon {{ $hackathon->thematique }}.</p>

<h2>Détails de l'événement :</h2>
<p>Date : {{ $hackathon->dateheuredebuth }} au {{ $hackathon->dateheurefinh }}</p>
<p>Ville : {{ $hackathon->ville }}
<p>Lieu : {{ $hackathon->lieu }}</p>
<p>Thématique : {{ $hackathon->thematique }}</p>
<p>Objectif : {{ $hackathon->objectif }}</p>


<h2>Contact :</h2>
<p>Pour toute question, contactez les organisateurs.</p>

<p>Cordialement,</p>
<p>L'équipe organisatrice</p>
