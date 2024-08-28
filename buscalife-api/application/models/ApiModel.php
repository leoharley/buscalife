<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class ApiModel extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('idEmpresa') != null) {
            $this->banco_empresa = $this->load->database($this->session->userdata('idEmpresa'), TRUE);
        } else {
            $this->banco_empresa = $this->load->database('default', TRUE);
        }
    }
    

    function adicionaNotificacaoCarga($info)
    {
        $this->db->trans_start();
        $this->db->insert('tb_notificacao_carga', $info);
        
        $insert_id = $this->db->insert_id();
        
        $this->db->trans_complete();
        
        return $insert_id;
    }
    

}

  