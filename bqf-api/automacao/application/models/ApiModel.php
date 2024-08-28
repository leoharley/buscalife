<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class ApiModel extends CI_Model
{
    
    function adicionaNotificacaoCarga($info)
    {
        $this->db->trans_start();
        $this->db->insert('tb_notificacao_carga', $info);
        
        $insert_id = $this->db->insert_id();
        
        $this->db->trans_complete();
        
        return $insert_id;
    }

}

  