<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';
/**
 * Class : Admin (AdminController)
 * Admin class to control to authenticate admin credentials and include admin functions.
 * @author : Samet Aydın / sametay153@gmail.com
 * @version : 1.0
 * @since : 27.02.2018
 */
class Api extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        // Datas -> libraries ->BaseController / This function used load user sessions
        $this->datas();
   
    }

    public function chatbot()
    {   
        session_start();        
        $requestText = $this->input->post('requestText')?$this->input->post('requestText'):0;

        if ($requestText == 'eu quero doce') {
            $aiResponse = 'to nem ai';
        } else {
            if(!$this->isValidName($requestText)){
                $aiResponse = 'Qual é o nome completo dessa pessoa que você quer que eu procure?aqui:'.$_SESSION['id'];                
            }
            else {
                $aiResponse = 'Certo. Você teria mais alguma informação dessa pessoa? CPF, telefone, etc...aqui'.$_SESSION['id'];                
            }
        }

        $data['responseText'] =  $aiResponse;

        echo json_encode($data); 

    }

    public function isValidName($name) {
        // Remove espaços extras do início e do fim
        $name = trim($name);
    
        // Verifica se o nome não está vazio e contém pelo menos duas palavras
        if (empty($name) || str_word_count($name) < 2) {
            return false;
        }
    
        // Verifica se o nome contém apenas letras, espaços e alguns caracteres especiais
        // O regex permite letras (maiúsculas e minúsculas), acentos, espaços e apóstrofos
        if (preg_match('/^[a-zA-ZÀ-ÿ\'\s-]+$/u', $name)) {
            return true;
        }
    
        return false;
    }

}