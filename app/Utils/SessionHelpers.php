<?php

namespace App\Utils;

use App\Models\Admin;
use App\Models\Equipe;

class SessionHelpers
{
    static string $sessionKey = "LOGIN";
    static string $sessionAdminKey ="LOGINADMIN";

    /**
     * Connecte une équipe, c'est-à-dire stocke l'équipe dans la session
     * @param Equipe $equipe
     * @return void
     */
    static function login(Equipe $equipe): void
    {
        session()->put(self::$sessionKey, $equipe);
        session()->save();
    }

    /**
     * Connecte un admin, c'est-à-dire stocke l'admin dans la session
     * @param Admin $admin
     * @return void
     */
    static function loginAdmin(Admin $admin): void
    {
        session()->put(self::$sessionAdminKey, $admin);
        session()->save();
    }

    /**
     * Déconnecte une équipe, c'est-à-dire supprime l'équipe de la session
     * @return void
     */
    static function logout(): void
    {
        session()->forget(self::$sessionKey);
        session()->save();
    }

    static function logoutAdmin(): void
    {
        session()->forget(self::$sessionAdminKey);
        session()->save();
    }

    /**
     * Retourne l'équipe connectée, ou null si aucune équipe n'est connectée
     * @return Equipe|null
     */
    static function getConnected(): ?Equipe
    {
        return session(self::$sessionKey, null);
    }

    /**
     * Retourne l'admin connectée, ou null si aucun admin n'est connectée
     * @return Admin|null
     */
    static function AdmingetConnected(): ?Admin
    {
        return session(self::$sessionAdminKey, null);
    }

    

    /**
     * Vérifie si une équipe est connectée. Retourne true si une équipe est connectée, false sinon
     * @return bool
     */
    static function isConnected(): bool
    {
        return session()->has(self::$sessionKey);
    }

    static function AdminisConnected(): bool
    {
        return session()->has(self::$sessionAdminKey);
    }

    public static function flash(string $type, $message)
    {
        session()->flash($type, $message);
    }
}
