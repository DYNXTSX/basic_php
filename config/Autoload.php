<?php
class Autoload
{
    private static $_instance=null;

    public static function charger() {
        if(null!==self::$_instance) {
            throw new RuntimeException(sprintf('%s is already started',__CLASS__));
        }
        self::$_instance=new self();
        if(!spl_autoload_register(array(self::$_instance, '_autoload'), false)) {
            throw new RuntimeException(sprintf('%s Could not start the autoload',__CLASS__));
        }
    }

    private static function _autoload($class) {
        $filename = $class.'.php';
        $dir =array('modeles/phpmailer/', 'modeles/modeles/','modeles/gateways/','modeles/classes/','config/','controleur/');
        foreach ($dir as $d){
            $file=$d.$filename;
            if (file_exists($file)){
                include $file;
            }
        }
    }
}