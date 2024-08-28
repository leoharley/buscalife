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
        $requestText = $this->input->post('requestText')?$this->input->post('requestText'):0;

        if ($requestText == 'eu quero doce') {
            $aiResponse = 'to nem ai';
        } else {
            if(preg_match('/[bcdfghjklmnpqrtsvwxyz]{4}|[aeiou]{4}|([a-z])\1{2}/i',$this->nameCheck($requestText))){
                $aiResponse = 'Não é nome';
            }
            else {
                $aiResponse = 'é nome';
            }
        }

        $data['responseText'] =  $aiResponse;

        echo json_encode($data); 

    }

}