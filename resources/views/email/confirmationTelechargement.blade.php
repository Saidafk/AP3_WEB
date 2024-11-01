


<h1>Confirmation de Téléchargement des Données</h1>
        <p>Bonjour voici les données de l'équipe {{ $equipe->nomequipe }},</p>
        <p>Voici les détails :</p>
        <ul>
            <li><strong>Nom de l'équipe :</strong> {{ $equipe->nomequipe }}</li>
            <li><strong>Email :</strong> {{ $equipe->login }}</li>
            <li><strong>lienprototype :</strong> {{ $equipe->lienprototype }}</li>
        </ul>
        
        <h3>Membres de l'équipe :</h3>
        <ul>
            @foreach ($membres as $membre)
                <li>
                    <p>-----------------------------------------------------------------</p>
                    <strong>Nom et prenom:</strong> {{ $membre->nom }} {{ $membre->prenom }} <br>
                    <strong>Email :</strong> {{ $membre->email }}
                    <strong>Numéro de téléphone :</strong> {{ $membre->telephone }}
                    <strong>Date de naissance :</strong> {{ $membre->datenaissance }}
                </li>
            @endforeach
        </ul>

       
    </div>

