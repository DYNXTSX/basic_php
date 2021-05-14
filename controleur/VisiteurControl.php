<?php
class VisiteurControl
{

    function __construct()
    {

        /**
         *
         * Le visiteur désigne une personne non connecté
         * Ses actions sont très réduite
         *
         */

        global $vues;
        try{
            $action = $_REQUEST['action'] ?? NULL;
            switch ($action) {
                case NULL:
                    $this->casNull();
                    break;

                case "seConnecter":
                    $this->casSeConnecter();
                    break;

                case "forgotPswd" : //page connection
                    $this->casForgotPassword();
                    break;

                case "needNewPassword" : //page connection
                    $this->casNeedNewPassword();
                    break;

                case "changePassword" : //page connection
                    $this->casChangePassword();
                    break;

                default:
                    $this->casDefault();
                    break;
            }
        }catch (PDOException $e)
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
     * Ce cas désigne le fait qu'il n'y a pas d'action de la part du visiteur
     * Ainsi, nous le redirigons vers la page de login
     */
    function casNull() {
        global $vues;
        $_SESSION['erreur'] = "";
        require_once($vues['Login']);
    }

    /**
     * casDefault() :
     *
     * Ce cas désigne l'action par défault (quand elle ne correspond à rien).
     * Ici, un visiteur est redirigé sur la page d'erreur
     */
    function casDefault() {
        global $vues;
        $_SESSION['erreur'] = "Cet URL ne semble pas exister ! ";
        require_once($vues['Erreur']);
    }

    /**
     * casSeConnecter() :
     *
     * Ce cas désigne le fait que le visiteur souhaite se connecter.
     * Pour ce faire, nous appelons la méthode VerifCompte() qui va vérifier si
     * les champs indiqués par le visiteur sont bon ou non.
     *
     * S'ils sont bon alors l'utilisateur devient un utilisateur (voir fonction
     * VerifCompte()), sinon, l'utilisateur est ramené sur la page de login.
     */
    function casSeConnecter(){
        global $vues;
        $CodeConnection = $this->VerifCompte();
        if($CodeConnection==0){
            $_SESSION['erreur']="erreur compte";
            require_once($vues['Login']);
        } else if($CodeConnection == 1){
            require_once($vues['GestionLicences']);
        }
    }

    /**
     * casForgotPassword() :
     *
     * Ce cas désigne si le visiteur clique sur le bouton d'oublie de mot de passe.
     * Dans ce cas, nous lui affichons la vue dédié à cela.
     */
    function casForgotPassword() {
        global $vues;
        require_once($vues['ForgotPassword']);
    }

    /**
     * casChangePassword() :
     *
     * Ce cas désigne que le visiteur change de mot de passe.
     * Même principe qu'au dessus, nous lui affichons la page dédié à cela.
     */
    function casChangePassword() {
        global $vues;
        require_once($vues['ChangePassword']);
    }

    /**
     * VerifCompte() :
     *
     * Cette méthode est dédié à la vérification des informations du visiteur
     * afin de savoir s'il peut devenir utilisateur.
     *
     * => Nous récupérons ses informations entrées (login & mdp)
     * => Nous les nétoyons (empécher les failles XSS)
     * => Nous vérifions que le login existe
     * => Nous vérifions ensuite que les mdps correspondent
     *
     * Si tout est bon :
     * => définition du visiteur en tant qu'utilisateur
     */
    function VerifCompte(){
        $model=new UserModele();
        $login=$_POST['login'];
        $password=$_POST['password'];

        if(isset($login) && isset($mdp)){
            $login=Validation::Nettoyer_string($login);
            $password=Validation::Nettoyer_string($mdp);
        }
        //si l'utilisateur existe
        $codeConnectionlogin = $model->getCodeVerifCompte($login);
        if($codeConnectionlogin <= 0){
            return 0;
        }
        //si c'est le bon compte
        $codeConnection = $model->getCodeVerifExistance($login, $password);
        if($codeConnection == 1){
            $_SESSION['login'] = $login;
            $_SESSION['role']="user";
            return 1;
        }
        return 0;
    }

    /**
     * casNeedNewPassword() :
     *
     * Méthode appelée sur la page ForgotPassword.php, qui va envoyer
     * un mail à l'utilisateur avec un lien lui permétant de modifier son mdp.
     *
     * => Récupération du login
     * => Nous nétoyons le login (empécher les failles XSS)
     * => Nous vérifions que le compte existe
     * => Nous récupérons l'email
     * => Nous utilisons la méthode sendMailToChangePassword($login, $email)
     * pour permettre à l'utilisateur de changer son mdp.
     *
     */
    function casNeedNewPassword(){
        global $vues;
        $model=new UserModele();
        $login=$_POST['login'];
        if(isset($login)&&isset($email)){
            $login=Validation::Nettoyer_string($login);
        }
        $codeConnection = $model->getCodeVerifCompte($login);
        if($codeConnection > 0){
            //compte existe, plus qu'a trouver l'email
            $email = $model->getEmail($login);
            if($email == ""){
                $_SESSION['erreur']="erreur email";
            }else{
                $_SESSION['erreur']="email va être envoyé à $email";
                $model->sendMailToChangePassword($login, $email);
            }
        }else{
            $_SESSION['erreur']="Login introuvable";
        }
        require_once($vues['ForgotPassword']);
    }

    /**
     * casSucessChangePassword() :
     *
     * Méthode appelée sur la page ChangePassword.php, qui va permettre
     * avec le lien récupéré par email, de mettre à jours son MDP.
     *
     * => Comparer les mots de passes saisie pour vérifier que se sont les mêmes
     * => Vérifier que le token est le bon
     * => Mettre à jours le mot de passe
     * => Changer le token (empécher de remodifier le MDP avec le même lien)
     */
    function casSucessChangePassword(string $login, string $token, string $pswd1, string $pswd2){
        global $vues;
        $model=new UserModele();
        if($pswd1 != $pswd2){
            echo "Les mots de passes ne corespondent ";
        }else{
            if($model->checkToken($login, $token) == 0){
                echo "Erreur dans l'url !" ;
            }else{
                $model->changePassword($login, $pswd1);
                $token = rand(10,99999999999999999999);

                global $con;
                $gtwUser= new UserGateway($con);
                $gtwUser->SaveToken($login, $token);

                header('Location: index.php');
                $_SESSION['erreur'] = "";
            }
        }
    }

}