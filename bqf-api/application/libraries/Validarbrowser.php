<?php
/**
 * Created by PhpStorm.
 * User: alexandre.brito
 * Date: 27/10/15
 * Time: 17:05
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Validarbrowser
{

    public static  $browser;
    public static  $versao;
    public static  $sistema;
    public static  $vBrowser = array(
        'MSIE'    => array('MSIE ([0-9].[0-9]{1,2})', 11),//(string, versao)
        'Opera'       => array('Opera/([0-9].[0-9]{1,2})', 8),
        'Firefox'  => array('Firefox/([0-9\.]+)', 19),
        'Chrome'   => array('Chrome/([0-9\.]+)', 25),
        'Safari'   => array('Safari/([0-9\.]+)', 5)
    );

    public static  $linkUpdate = array(
        'Windows' => array(
            'MSIE'    => 'http://windows.microsoft.com/pt-br/internet-explorer/download-ie',//(string, versao)
            'Opera'       => 'http://www.opera.com/computer/windows',
            'Firefox'  => 'https://support.mozilla.org/pt-BR/kb/atualizando-firefox',
            'Chrome'   => 'http://support.google.com/chrome/bin/answer.py?hl=pt-BR&answer=95414',
            'Safari'   => 'http://support.apple.com/kb/DL1531?viewlocale=pt_BR'
        ),
        'Mac' => array(
            'Opera'       => 'http://www.opera.com/computer/mac',
            'Firefox'  => 'https://support.mozilla.org/pt-BR/kb/atualizando-firefox',
            'Chrome'   => 'http://support.google.com/chrome/bin/answer.py?hl=pt-BR&answer=95414',
            'Safari'   => 'http://support.apple.com/kb/HT1338'
        ),
        'Linux' => array(
            'Opera'       => 'http://www.opera.com/computer/linux',
            'Firefox'  => 'https://support.mozilla.org/pt-BR/kb/atualizando-firefox',
            'Chrome'   => 'http://support.google.com/chrome/bin/answer.py?hl=pt-BR&answer=95414',
            'Safari'   => 'http://support.apple.com/kb/HT1338'
        ),
    );

    public static function setBrowser(){
        $useragent = $_SERVER['HTTP_USER_AGENT'];
        foreach (self::$vBrowser as $reg => $value){
            //Se safari, busca a versão depois da string "Version"
            if (preg_match('|'.$value[0].'|',$useragent,$matched) && preg_match('|Version/([0-9\.]+)|',$useragent,$version)){
                self::$browser = $reg;
                self::$versao  = (int)$version[1];
            }else{
                if (preg_match('|'.$value[0].'|',$useragent,$matched) && $reg != 'Safari'){
                    self::$browser = $reg;
                    self::$versao = (int)$matched[1];
                }
            }
        }
    }

    public static function setSistema(){
        $useragent = $_SERVER['HTTP_USER_AGENT'];
        $sistemas = array('Windows', 'Mac', 'Linux');
        foreach ($sistemas as $value) {
            preg_match('/'.$value.'/i',$useragent,$vOs);
            if (isset($vOs[0])) {
                self::$sistema = $vOs[0];
            }
        }
    }

    public static function validar(){
        self::setBrowser();
        if (self::$vBrowser[self::$browser][1] > self::$versao){
            return false;
        }else{
            return true;
        }
    }

    public static function getUrlUpdate(){
        self::setBrowser();
        self::setSistema();

        return self::$linkUpdate[self::$sistema][self::$browser];
    }
}
