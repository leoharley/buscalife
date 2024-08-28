<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Created by PhpStorm.
 * User: dimas.filho
 * Date: 03/09/15
 * Time: 17:09
 */
class Menu
{
   public function montar_menu_default($coGrupo, $coPrograma, $coProgramaModulo){
       $CI = get_instance();
       $CI->load->model('Menu');
       $arrResult = $CI->Menu->retornarMenu($coPrograma, $coProgramaModulo, $coGrupo);
       foreach($arrResult as $ind => $menu){
           $arrResult[$ind]['SUB'] = $CI->Menu->retornarMenu($coPrograma, $coProgramaModulo, $coGrupo, $menu['CO_SEQ_MENU']);
       }
       return $arrResult;
   }

}