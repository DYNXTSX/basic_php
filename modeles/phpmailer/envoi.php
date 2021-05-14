<?php
// Pour l'envoi de mails, issu de : https://www.000webhost.com/forum/t/how-to-use-phpmailer/134686/8
define("mail_host", "ssl0.ovh.net");
define("mail_port", "587");
define("mail_smtpsecure", "tls");
define("mail_smtpauth", true);
define("mail_username", "xxxxxx@gmail.fr");
define("mail_password", "XXXXXXXXXXXXX");
define("mail_from", "contact@entreprise.fr"); //email qui sera affiché
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require "mail/Exception.php";
require "mail/PHPMailer.php";
require "mail/SMTP.php";

class envoi{
    function sendMail($dest, $sujet, $message_html, $message="")
    {
        $mailer = new PHPMailer;
        $mailer->CharSet = 'UTF-8';
        $mailer->isSMTP();
        $mailer->SMTPDebug = 0;
        $mailer->Host = mail_host;
        $mailer->Port = mail_port;
        $mailer->SMTPSecure = mail_smtpsecure;
        $mailer->SMTPAuth = mail_smtpauth;
        $mailer->Username = mail_username;
        $mailer->Password = mail_password;
        $mailer->setFrom(mail_from);
        if(strpos($dest, ",")!==false)
        {
            $dest = explode(",", $dest);
            for($i=0;$i<count($dest);$i++)
                $mailer->addAddress($dest[$i]);
        }
        else
            $mailer->addAddress($dest);
        $mailer->Subject = $sujet;
        $mailer->msgHTML($message_html);
        if($message!="")
            $mailer->AltBody = $message;
        if($mailer->send())
            return true;
        else
            return false;
    }
}