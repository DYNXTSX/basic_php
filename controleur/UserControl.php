<?php
class UserControl
{
    function __construct() {
        mb_internal_encoding('UTF-8');
        /**
         *
         * L'utilisateur désigne une personne connecté
         * Ses actions sont orienté sur l'outil de gestion des licences
         *
         */

        global $vues;
        try {
            $action = $_REQUEST['action'] ?? NULL;
            switch ($action) {
                case NULL:
                    $this->casNull();
                    break;
                case "seConnecter" :
                    $this->casSeConnecter();
                    break;

                case "Deconnexion":
                    $this->deconnectionUser();
                    break;

                default:
                    $this->casDefault();
                    break;
            }
        }
        catch (PDOException $e)
        {
            $codeErreur = $e;
            require_once($vues['Erreur']);
        }
        catch (Exception $e2)
        {
            $codeErreur = $e2;
            require ($vues['Erreur']);
        }
    }


    /**
     * casNull() :
     *
     * Ce cas désigne le fait qu'il n'y a pas d'action de la part de l'utilisateur
     * Ainsi, nous le redirigons vers la page de GestionLicences
     */
    function casNull() {
        global $vues;
        $_SESSION['erreur'] = "";
        require_once($vues['GestionLicences']);
    }

    /**
     * casSeConnecter() :
     *
     * Ce cas indique que la personne s'est connectée
     */
    function casSeConnecter() {
        global $vues;
        $_SESSION['erreur'] = "";
        require_once($vues['GestionLicences']);
    }

    /**
     * casDefault() :
     *
     * Ce cas désigne l'action par défault (quand elle ne correspond à rien).
     * Ici, l'utilisateur est redirigé sur la page d'erreur
     */
    function casDefault() {
        global $vues;
        $_SESSION['erreur'] = "Cet URL ne semble pas exister ! ";
        require_once($vues['Erreur']);
    }

    /**AddContact
     * recupererPersonne() :
     * @param string $login => login de l'utilisateur
     * @return User => les informations de l'utilisateur
     *
     * Cette méthode permet de récupérer les informations de l'utilisateur et les
     * placer dans un User (voir modeles).
     */
    function recupererPersonne(string $login){
        $model = new UserModele();
        return $model->recupUser($login);
    }

    /**
     * deconnectionUser() :
     *
     * Cette méthode permet de déconnecter l'utilisateur de l'outil
     * de gestion des licences.
     */
    function deconnectionUser(){
        $model = new UserModele();
        $model->seDeconnecter();
        header("location: index.php");
    }
}