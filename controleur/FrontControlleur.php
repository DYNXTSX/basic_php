<?php


class FrontControlleur
{

    /**
     * FrontControlleur
     * Les actions de la vue dépendent du role de l'utilisateur
     * Toutes les actions ne sont pas atteignable par défaut, cela dépend du role
     *
     * Nous avons les roles
     *      - visiteur => personne non connecté
     *      - user => personne connecté pouvant effectuer des actions sur l'outil de gestion des licences
     */

    function __construct(){
        global $vues;
        try{
            Validation::prepSession();
            $status = UserModele::isUser();

            switch ($status){
                case NULL:
                    $erreur = "Erreur sur le role";
                    break;

                case "visiteur":
                    $visiteur = new VisiteurControl();
                    break;

                case "user":
                    $user = new UserControl();
                    break;

                default:
                    echo"le role est ni null, ni admin, ni user";
                    break;
            }


        }catch(PDOException $e){
            $codeErreur = $e;
            require($vues['Erreur']);
        }

    }
}