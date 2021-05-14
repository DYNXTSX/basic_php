<?php
class Validation
{
    /**
     * Nettoyer_string() :
     *
     * Permet de nétoyer une chaine de caractère, empechant les failles XSS
     */
    static function Nettoyer_string($string){
        return filter_var($string,FILTER_SANITIZE_STRING);
    }

    static function Quotes_string($string){
        return htmlspecialchars($string, ENT_QUOTES);
    }

    static function Null_Or_Not_Null($string){
        if($string === null){
            return null;
        }
        return $string;
    }

    /**
     * Nettoyer_int() :
     *
     * Permet de nétoyer un entier, empechant les failles XSS
     */
    static function Nettoyer_int($string){
        return filter_var($string,FILTER_SANITIZE_NUMBER_INT);
    }

    /**
     * prepSession() :
     *
     * Ceci définie la session de base.
     * Avec le role Visiteur et aucun Login.
     */
    static function prepSession(){
        if(session_status() == PHP_SESSION_NONE) {
            session_start();

            if(!isset($_SESSION['role']))
            {
                $_SESSION['role']="Visiteur";
            }

            if(!isset($_SESSION['login']))
            {
                $_SESSION['login']="";
            }
        }
    }

    /**
     * dateToFrench() :
     *
     * Cette méthode permet de retourner une date dans un format donné
     * Le tout en Français.
     */
    static function dateToFrench($date, $format)
    {
        $english_days = array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday');
        $french_days = array('Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche');
        $english_months = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
        $french_months = array('Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre');
        return str_replace($english_months, $french_months, str_replace($english_days, $french_days, date($format, strtotime($date) ) ) );
    }
}