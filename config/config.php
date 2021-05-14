<?php
require ("Connection.php");

// liste des modules a inclure
$dConfig['includes']=array('Validation.php');

//BDD
$user='root';
$pass='';
$dbname = 'gestion_licences';
$hostname='localhost';
$con = new Connection($hostname, $user, $pass, $dbname);

//Vues principales
$vues['Login']='vues/php/PageConnection.php';
$vues['ForgotPassword']='vues/php/ForgotPassword.php';
$vues['ChangePassword']='vues/php/ChangePassword.php';
$vues['Accueil']='vues/php/Accueil.php';
$vues['Erreur']='vues/php/Erreur.php';

//Vues secondaires
$vues['Integration']='vues/php/integration/intégration.php';
