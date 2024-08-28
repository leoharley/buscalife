<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class MY_PHPMailer {
    //MY_ para informar ao framework de que se trata de uma classe customizada, ou seja, não faz parte do framework. Pode ser alterada no arquivo config.php em application/config/

    private $mailer;
    
    public function __construct() {
        require_once(APPPATH.'third_party/phpmailer/class.phpmailer.php');
        require_once(APPPATH.'third_party/phpmailer/PHPMailerAutoload.php');





    }

}
?>