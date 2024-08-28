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
        $this->load->model('login_model');
        $this->load->model('user_model');
        $this->load->model('ImportacaoModel');
        $this->load->model('PermissaoModel');
        $this->load->model('PrincipalModel');
        $this->load->model('CadastroModel');
        $this->load->model('ApiModel');
        // Datas -> libraries ->BaseController / This function used load user sessions
        $this->datas();
   
    }

    public function notificaCargaDasa()
    {    
        $idempresa = $this->input->post('idEmpresa')?$this->input->post('idEmpresa'):0;
        $idconvenio = $this->input->post('idConvenio')?$this->input->post('idConvenio'):0;
        $filetype = $this->input->post('fileType')?$this->input->post('fileType'):'';
        $filename = $this->input->post('fileName')?$this->input->post('fileName'):'';
        $url = $this->input->post('url')?$this->input->post('url'):'';
     
        $data['id_empresa'] = $idempresa;
        $data['id_convenio'] = $idconvenio;
        $data['filetype'] = $filetype;
        $data['filename'] = $filename;
        $data['url'] = $url;
        $data['dt_notificacao_carga'] = date('Y-m-d');

        if ($filetype == 'contrato') {
            if ((
                $data['id_empresa']&&
                $data['id_convenio']&&
                $data['filetype']&&
                $data['filename']&&
                $data['url']) != null) {
                $data['st_acessado'] = 'nao'; 
                $data['status'] = 'sucesso'; 
            } else {
                $data['status'] = 'erro';
            } 
        } else {
            if ((
                $data['id_empresa']&&
                $data['filetype']&&
                $data['filename']&&
                $data['url']) != null) {
                $data['st_acessado'] = 'nao';
                $data['status'] = 'sucesso'; 
            } else {
                $data['status'] = 'erro';
            }
        }
        
        $result = $this->ApiModel->adicionaNotificacaoCarga($data);

        echo $result;

        echo json_encode($data);

    }
    
 

}