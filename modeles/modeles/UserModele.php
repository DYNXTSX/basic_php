<?php

class UserModele
{

    /**
     * isUser() :
     *
     * Premet de connaitre le role de l'utilisateur.
     */
    public static function isUser(){
        if(isset($_SESSION['role'])) {
            $status = Validation::Nettoyer_string($_SESSION['role']);
            if($status=="user"){
                return "user";
            } else {
                return "visiteur";
            }
        }else{
            return "visiteur";
        }
    }
    /**
     * Explication :
     * Permet de voir si un compte existe bien (avec le login)
     */
    public function getCodeVerifCompte(string $login) {
        global $con;
        $gtwUser= new UserGateway($con);
        $login=Validation::Nettoyer_string($login);
        return $gtwUser->CheckVerifCompte($login);
    }

    /**
     * Explication :
     * Verification de l'existance d'un comtpe ou non, grace au login
     */
    public function getCodeVerifExistance(string $login, string $password){
        global $con;
        $gtwUser= new UserGateway($con);
        return $gtwUser->CheckCompteExist($login, $password);
    }

    /**
     * sendMailToChangePassword() :
     * Permet l'envoie du mail pour changer le mot de passe
     */
    public function sendMailToChangePassword(string $login, string $email){
        require_once ('modeles/phpmailer/envoi.php');
        //partie personne
        $user = $this->recupUser($email);
        //partie mail
        $mail = new envoi();
        $token = rand(10,9999);
        $this->saveToken($login, $token);
        $link = "<a href='http://localhost/code/index.php?action=changePassword&key=".$login."&token=".$token."'>Cliquer ici !</a>";

        $body_html = '
        <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Numtech</title>
        <style type="text/css">
            html,
            body {
                margin: 0 auto !important;
                padding: 0 !important;
                height: 100% !important;
                width: 100% !important;
            }
    
            * {
                -ms-text-size-adjust: 100%;
                -webkit-text-size-adjust: 100%;
            }
    
            div[style*="margin: 16px 0"] {
                margin: 0 !important;
            }
    
            table,
            td {
                mso-table-lspace: 0pt !important;
                mso-table-rspace: 0pt !important;
            }
    
            table {
                border-spacing: 0 !important;
                border-collapse: collapse !important;
                table-layout: fixed !important;
                margin: 0 auto !important;
            }
    
            img {
                line-height: 100%;
                outline: none;
                text-decoration: none;
                -ms-interpolation-mode: bicubic;
                border: 0;
                max-width: 100%;
                height: auto;
                vertical-align: middle;
            }
    
            .yshortcuts a {
                border-bottom: none !important;
            }
    
            a[x-apple-data-detectors] {
                color: inherit !important;
                text-decoration: none !important;
                font-size: inherit !important;
                font-family: inherit !important;
                font-weight: inherit !important;
                line-height: inherit !important;
            }
    
            @media screen and (min-width: 600px) {
                .ios-responsive-grid {
                    display: -webkit-box !important;
                    display: flex !important;
                }
                .ios-responsive-grid__unit  {
                    float: left;
                }
            }
        </style>
        <style type="text/css">
            li {
                text-indent: -1em;
            }
        </style>
        <style type="text/css">
            .button__td,
            .button__a {
                transition: all 100ms ease;
            }
    
            .button__td:hover,
            .button__a:hover {
                background: #1ab77b !important;
            }
    
            @media screen and (max-width: 599px) {
                .tw-card { padding: 20px !important; }
                .tw-h1 { font-size: 22px !important; }
                .mobile-hidden {
                    display: none !important;
                }
                .mobile-d-block {
                    display: block !important;
                }
                .mobile-w-full {
                    width: 100% !important;
                }
                .mobile-m-h-auto {
                    margin: 0 auto !important;
                }
                .mobile-p-0 {
                    padding: 0 !important;
                }
                .mobile-p-t-0 {
                    padding-top: 0 !important;
                }
                .mobile-img-fluid {
                    max-width: 100% !important;
                    width: 100% !important;
                    height: auto !important;
                }
            }
        </style>
        </head>
    
        <body style="background: #ffffff; height: 100% !important; margin: 0 auto !important; padding: 0 !important; width: 100% !important; ;">
        <div style="display: none; font-size: 1px; line-height: 1px; max-height: 0; max-width: 0; opacity: 0; overflow: hidden; mso-hide: all;">
        </div>
        <table cellpadding="0" cellspacing="0" style="background: #f2f2f2; border: 0; border-radius: 0; width: 100%;">
            <tbody><tr>
                <td align="center" class="" style="padding: 0 20px;">
                    <table cellpadding="0" cellspacing="0" style="background: #f2f2f2; border: 0; border-radius: 0;">
                        <tbody><tr>
                            <td align="center" class="" style="width: 600px;">
                                <table cellpadding="0" cellspacing="0" dir="ltr" style="border: 0; width: 100%;">
                                    <tbody>
                                    <tr>
                                        <td class="" style="padding: 20px 0; text-align: center; ;">
                                            <a href="https://numtech.fr/" style="text-decoration: none; ;" target="_blank">
                                                <img alt="Numtech" class=" " src="https://www.banquedesterritoires.fr/sites/default/files/2018-11/00291_02_logo%20NUMTECH%20horizontal%20transparent.png" style="border: 0; height: auto; max-width: 100%; vertical-align: middle; ;" width="250">
                                            </a>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                                <table cellpadding="0" cellspacing="0" style="background: #ffffff; border: 0; border-radius: 4px; width: 100%;">
                                    <tbody>
                                    <tr>
                                        <td align="center" class="tw-card" style="padding: 20px 50px;">
                                            <table cellpadding="0" cellspacing="0" dir="ltr" style="border: 0; width: 100%;">
                                                <tbody><tr>
                                                    <td class="" style="padding: 20px 0; text-align: center; ;">
                                                        <img alt="" class=" " src="https://static.twistapp.com/eee278cf8d8222ad8c36e3fdfeeafbf5.png" style="border: 0; height: auto; max-width: 100%; vertical-align: middle; ;" width="337">
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                            <table cellpadding="0" cellspacing="0" dir="ltr" style="border: 0; width: 100%;">
                                                <tbody>
                                                <tr>
                                                    <td class="" style="text-align: left; color: #474747; font-family: sans-serif;;">
                                                        <p style="mfont-size: 14px; mso-line-height-rule: exactly;">
                                                            <span style="font-weight: bold;;">
                                Changement de mot de passe
                                                            </span>
                                                        </p>
                                                        <p style=" margin: 0; font-size: 14px; mso-line-height-rule: exactly;">
                                Bonjour '.$user->getNomComplet().' !
                                                        </p>
                                                        <p style=" margin: 0; font-size: 14px; mso-line-height-rule: exactly;">
                                Vous avez demandé le changement de votre mot de passe pour l\'outil de Gestion de Licences Numtech.
                                                        </p>
                                                        <p style=" margin: 0; font-size: 14px; mso-line-height-rule: exactly;">
                                Pour se faire, il suffit de '.$link.' !
                                                        </p>
                                                        <p style="margin: 20px 0 20px 0; font-size: 14px; mso-line-height-rule: exactly;">
                                 Cordialement,<br><br>
                                                            <span style="font-weight: bold;;">
                                Service Automatique Numtech
                                                            </span>
                                                        </p>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                                <table cellpadding="0" cellspacing="0" dir="ltr" style="border: 0; width: 100%;">
                                    <tbody><tr>
                                        <td class="" style="padding: 20px 0; text-align: center; color: #8f8f8f; font-family: sans-serif; font-size: 12px; mso-line-height-rule: exactly; line-height: 20px;;">
                                            <p style="margin: 20px 0;; margin: 0;;">
                                Email automatique envoyé par <a href="https://numtech.fr/" style="color: #316fea; text-decoration: none;" target="_blank">Numtech</a> !
                                            </p>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            </tbody>
        </table>
        </body>
        ';

        $body = "NUMTECH\r\n pour changer de mot de passe : $link";
        $destinataires = $email;
        $sujet = "Changement de mot de passe";
        $test = $mail->sendMail($destinataires,$sujet,$body_html,$body);
    }

    /**
     * saveToken() :
     * Permet de sauvegarder un token (chaine de caractères pour le lien de modification de mot de passe)
     */
    public function saveToken(string $login, string $token){
        global $con;
        $gtwUser= new UserGateway($con);
        $gtwUser->SaveToken($login, $token);
    }

    /**
     * checkToken() :
     * Permet de vérifier que le token entré est le bon pour l'utilisateur indiqué
     */
    public function checkToken(string $login, string $token){
        global $con;
        $gtwUser= new UserGateway($con);
        return $gtwUser->CheckToken($login, $token);
    }

    /**
     * changePassword() :
     * Permet le changement de mot de passe
     */
    public function changePassword(string $login, string $password){
        global $con;
        $gtwUser= new UserGateway($con);
        $gtwUser->ChangePassword($login, $password);
    }

    /**
     * getEmail() :
     * Permet de récupérer l'email de l'utilisateur
     */
    public function getEmail(string $login){
        global $con;
        $gtwUser= new UserGateway($con);
        return $gtwUser->RecupererEmail($login);
    }

    /**
     * recupUser() :
     * Peremt de récupérer l'utilisateur sous forme d'user (class)
     */
    public function recupUser(string $login){
        global $con;
        $gtwUser= new UserGateway($con);
        return $gtwUser->RecupUser($login);
    }

    /**
     * seDeconnecter() :
     * A votre grande surprise, est utilisé pour la déconnection et la destruction des sessions.
     */
    public function seDeconnecter() {
        session_destroy();
        $_SESSION = array();
        Validation::prepSession();
    }
}