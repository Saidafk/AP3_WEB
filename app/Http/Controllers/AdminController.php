<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Utils\SessionHelpers;

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
    $administrateur = SessionHelpers::AdmingetConnected();

    $google2fa = new Google2FA();
    $secretKey = $google2fa->generateSecretKey();

    
    $administrateur->cleA2F = $secretKey;
    $administrateur->active_a2f = true;
    $administrateur->save();

    
    $google2faUrl = "otpauth://totp/{$administrateur->email}?secret={$secretKey}&issuer=AdminApp";
    $QR_Image = QrCode::size(200)->generate($google2faUrl);
    

    //dd($administrateur);

    return view('doc.QR-code-admin', [
        'QR_Image' => $QR_Image,
        'secretKey' => $secretKey,
        'administrateur' => $administrateur
    ])->with('success', 'L\'authentification à deux facteurs a été activée.');
}

public function desactiverA2F()
{
    $administrateur = SessionHelpers::AdmingetConnected();
    
    $administrateur->cleA2F = null;
    $administrateur->active_a2f = false;
    $administrateur->save();

    //dd($administrateur);
    return redirect()->route('voirAdmin', ['administrateur' => $administrateur])->with('success', 'L\'authentification à deux facteurs a été désactivée.');
}
}