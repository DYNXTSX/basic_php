<?php
class UserGateway
{
    /**
     * UserGateway est la classe qui est la seule intéraction avec la basse de donée
     * orienté sur l'utilisateur
     */

    private $con;

    public function __construct(Connection $con)
    {
        $this->con = $con;
    }

    /**
     * CheckCompteExist() :
     * Vérifier que le mot de passe entré par l'utilisateur et celui dans la BDD
     * soient les mêmes.
     */
    public function CheckCompteExist(string $login, string $password){
        $accounts = $this->con->query("SELECT * FROM users WHERE email = ?", $login)->fetchArray();
        return password_verify($password, $accounts['password']);
    }

    /**
     * ChangePassword() :
     * Permet de mettre à jours le mot de passe dans la BDD.
     */
    public function ChangePassword(string $login, string $password){
        $passwordsecure = password_hash($password, PASSWORD_DEFAULT);
        $a = $this->con->query("UPDATE users SET password = ? WHERE email = ?", $passwordsecure, $login);
    }

    /**
     * CheckVerifCompte() :
     * Verification de l'existance d'un compte avec le login
     */
    public function CheckVerifCompte(string $login) {
        $account = $this->con->query("SELECT * FROM users WHERE email = ?", $login);
        return $account->numRows();
    }

    /**
     * SaveToken() :
     * Met à jours le token dans la BDD en utilisant le login de l'utilisateur
     */
    public function SaveToken(string $login, string $token){
        $f = $this->con->query("UPDATE users SET token = ? WHERE email = ?", $token, $login);
    }

    /**
     * CheckToken() :
     * Vérifier que le token dans la BDD est le même que celui dans l'URL.
     */
    public function CheckToken(string $login, string $token){
        $accounts = $this->con->query("SELECT * FROM users WHERE email = ?", $login)->fetchArray();
        if($token == $accounts['token'])
            return 1;
        else
            return 0;
    }

    /**
     * RecupererEmail() :
     * Permet de récupérer l'email avec le login.
     */
    public function RecupererEmail(string $login){
        $accounts = $this->con->query("SELECT * FROM users WHERE email = ?", $login)->fetchArray();
        return $accounts['email'];
    }

    /**
     * RecupUser() :
     * Permet de récupérer les informations sur l'utilisateur avec son login.
     */
    public function RecupUser(string $login){
        $u = $this->con->query("SELECT * FROM users WHERE email = ?", $login)->fetchArray();
        $us = new   User($u['id_user'],$u['nom'],$u['prenom'],$u['email']);
        return $us;
    }

    public function getUserById($id){
        $u = $this->con->query("SELECT * FROM users WHERE id_user = ?", $id)->fetchArray();
        $us = new   User($u['id_user'],$u['nom'],$u['prenom'],$u['email']);
        return $us;
    }
}