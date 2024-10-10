<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Utils\SessionHelpers;

class ProfileController extends Controller
{
    public function modifierProfile()
    {
        if (!SessionHelpers::isConnected()) {
            return redirect("/login")->withErrors(['errors' => "Vous devez être connecté pour accéder à cette page."]);
        }

        $equipe = SessionHelpers::getConnected();

        return view('equipe.modifierProfile', compact('equipe'));
    }

    public function miseAjourProfile(Request $request)
    {
        if (!SessionHelpers::isConnected()) {
            return redirect("/login")->withErrors(['errors' => "Vous devez être connecté pour accéder à cette page."]);
        }

        $equipe = SessionHelpers::getConnected();

        $request->validate([
            'nomequipe' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:equipes,email',
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        
        $equipe->nomequipe = $request->nomequipe;
        $equipe->email = $request->email;
        $equipe->telephone = $request->telephone;

        
        if ($request->filled('password')) {
            $equipe->password = bcrypt($request->password);
        }

        $equipe->save();

        return redirect()->route('modifierProfile')->with('success', 'Profil mis à jour avec succès.');
    }
}
