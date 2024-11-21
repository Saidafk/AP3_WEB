<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Utils\SessionHelpers;
use App\Utils\EmailHelpers;


use PragmaRX\Google2FA\Google2FA;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class AdminController extends Controller
{

    
    function voirAdmin(){

        $administrateur = SessionHelpers::AdmingetConnected();

        return view('doc.administrateur',['administrateur' => $administrateur]);
    }
   

    public function activerA2F()
    {
        // Récupérer l'administrateur connecté
        $administrateur = SessionHelpers::AdmingetConnected();

        //dd($administrateur);
        // Vérifier si l'administrateur est connecté
        if (!$administrateur) {
            return redirect('/loginAdmin')->withErrors(['errors' => 'Vous devez être connecté en tant qu\'administrateur.']);
        }

        //dd($administrateur);
        // Générer un code 2FA aléatoire
        $code2FA = Str::random(6); // Code à 6 caractères

        // Enregistrer le code dans la base de données pour cet administrateur
        $administrateur->code2fa = $code2FA;
        $administrateur->active_a2f = true;  // Marquer le 2FA comme activé
        $administrateur->save();

        //dd($administrateur->code2fa);

        // Envoyer un email avec le code 2FA à l'administrateur
        EmailHelpers::sendEmail($administrateur->email, 'Code de vérification 2FA', 'email.code2fa', ['code' => $code2FA]);

        // Retourner une vue avec succès
        return redirect()->route('pageVerificationA2F')->with('success', 'L\'authentification à deux facteurs a été activée. Le code a été envoyé par email.');
    }


    public function pageVerificationA2F()
    {
        $administrateur = SessionHelpers::AdmingetConnected();
    
        if (!$administrateur) {
            return redirect("/loginAdmin")->withErrors(['errors' => 'Vous devez être connecté pour vérifier la 2FA.']);
        }
    
        // Vérifier si 2FA est activée
        if ($administrateur->active_a2f) {
            return view('auth.verifier-2fa', ['administrateur' => $administrateur]);
        }
    
        // Si 2FA n'est pas activée, rediriger vers l'administration
        return redirect()->route('voirAdmin');
    }
    


public function desactiverA2F()
{
    $administrateur = SessionHelpers::AdmingetConnected();
    
    $administrateur->code2fa = null;
    $administrateur->active_a2f = false;
    $administrateur->save();

    //dd($administrateur);
    return redirect()->route('voirAdmin', ['administrateur' => $administrateur])->with('success', 'L\'authentification à deux facteurs a été désactivée.');
}

public function envoyerCode2FA()
    {
        $administrateur = session('admin'); // Récupérer l'admin connecté

        if (!$administrateur) {
            return redirect('/loginAdmin')->withErrors(['errors' => 'L\'administrateur doit être connecté.']);
        }

        // Générer un code aléatoire
        $code2FA = Str::random(6); // Un code de 6 caractères

        // Sauvegarder ce code dans la base de données ou la session
        $administrateur->code2fa = $code2FA;
        $administrateur->save();

        // Envoyer le code par email
        Mail::send('emails.code2fa', ['code' => $code2FA], function ($message) use ($administrateur) {
            $message->to($administrateur->email)
                    ->subject('Votre code de vérification 2FA');
        });

        // Afficher un message de succès ou rediriger vers la page de vérification
        return redirect()->route('verifierA2F')->with('success', 'Le code 2FA a été envoyé par email.');
    }

    public function verifierA2F(Request $request)
{
     // Récupérer l'administrateur depuis la session
     $administrateur = SessionHelpers::AdmingetConnected();
     
    if (!$administrateur) {
        return redirect("/loginAdmin")->withErrors(['errors' => 'L\'administrateur doit être connecté pour vérifier la 2FA.']);
    }

    // Vérifier si le code saisi est correct
    if ($administrateur->code2fa == $request->input('code_2fa')) {
        // Code correct, connecter l'administrateur et rediriger
        SessionHelpers::loginAdmin($administrateur);

        return redirect()->route('voirAdmin')->with('success', 'Vous êtes connecté avec succès.');
    } else {
        // Code incorrect, redemander à l'utilisateur de saisir un code valide
        return redirect()->back()->withErrors(['errors' => 'Le code 2FA est incorrect. Veuillez réessayer.']);
    }
}

public function renvoyerCode2FA()
{
    $administrateur = SessionHelpers::AdmingetConnected();

    if (!$administrateur) {
        return redirect('/loginAdmin')->withErrors(['errors' => 'Vous devez être connecté pour recevoir un code.']);
    }

    if ($administrateur->active_a2f) {
        // Générer un nouveau code 2FA
        $code2FA = Str::random(6);
        $administrateur->code2fa = $code2FA;
        $administrateur->save();

        // Envoyer l'email avec le code
        EmailHelpers::sendEmail($administrateur->email, 'Code de vérification 2FA', 'email.code2fa', ['code' => $code2FA]);

        return redirect()->back()->with('success', 'Un nouveau code 2FA a été envoyé à votre adresse email.');
    }

    return redirect()->back()->withErrors(['errors' => 'L\'authentification à deux facteurs n\'est pas activée.']);
}


}