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
            //$aiResponse = $this->nameCheck($requestText);
            $aiResponse = 'e dai';
        }

        $data['responseText'] =  $aiResponse;

        echo json_encode($data); 

    }

    function nameCheck($var) {
        $nameScore = 0;
        //If name < 4 score + '3'
        $chars_count = strlen($var);
        $consonants = preg_replace('![^BCDFGHJKLMNPQRSTVWXZ]!i','',$var);
        $consonant_count = strlen($consonants);
        $vowels = preg_replace('![^AEIOUY]!i','',$var);
        $vowel_count = strlen($vowels);
        //We're expecting first and last name.
        if ($chars_count < 4){
            $nameScore = $nameScore + 3;    
        }

        //if name > 4 and no spaces score + '4'
        if (($chars_count > 4)&& (!preg_match('![ ]!',$var))){
            $nameScore = $nameScore + 4;    
        }

        if (($chars_count > 4)&&(($consonant_count==0)||($vowel_count==0))){
            $nameScore = $nameScore + 5;            
        }

        //if name > 4 and vowel to consonant ratio < 1/8 score + '5'
        if (($consonant_count > 0) && ($vowel_count > 0) && ($chars_count > 4) && ($vowel_count/$consonant_count < 1/8)){
            $nameScore = $nameScore + 5;    
        }
        //Needs at least 1 letter.
        if (!preg_match('![A-Za-z]!',$var)){
            $nameScore = $nameScore + 10;           
        }

        return $nameScore;
    }

}