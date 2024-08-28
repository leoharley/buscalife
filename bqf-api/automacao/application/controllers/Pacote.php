<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';
/**
 * Class : Admin (AdminController)
 * Admin class to control to authenticate admin credentials and include admin functions.
 * @author : Samet Aydın / sametay153@gmail.com
 * @version : 1.0
 * @since : 27.02.2018
 */
class Pacote extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('login_model');
        $this->load->model('user_model');
        $this->load->model('CadastroModel');
        $this->load->model('PrincipalModel');
        $this->load->model('PermissaoModel');
        $this->load->model('PacoteModel');
        // Datas -> libraries ->BaseController / This function used load user sessions
        $this->datas();
        // isLoggedIn / Login control function /  This function used login control
        $isLoggedIn = $this->session->userdata('isLoggedIn');
        if(!isset($isLoggedIn) || $isLoggedIn != TRUE)
        {
            redirect('login');
        }
        
        else
        {
            // isAdmin / Admin role control function / This function used admin role control
            if($this->isAdmin() == TRUE)
            {
                $this->accesslogincontrol();
            }
        }
    }

    // INICIO DAS FUNÇÕES DA TELA DE PACOTE

    function pacotePacote()
    {
            $tpTela = $this->uri->segment(2);

            $data['perfis'] = $this->CadastroModel->carregaPerfisUsuarios();

            if ($tpTela == 'listar') {

                if ($this->session->userdata('email') != 'admin@admin.com')
                {
                    if (isset($this->PermissaoModel->permissaoTela($this->session->userdata('IdUsuEmp'),'TelaConvenio')[0]->Tp_Ativo)) {
                    if ($this->PermissaoModel->permissaoTela($this->session->userdata('IdUsuEmp'),'TelaConvenio')[0]->Tp_Ativo == 'N' ||
                        $this->PermissaoModel->permissaoAcaoConsultar($this->session->userdata('IdUsuEmp'),'TelaConvenio')[0]->Consultar == 'N')
                        {
                            redirect('telaNaoAutorizada');
                        }
                    } else {
                            redirect('telaNaoAutorizada');
                    }
                }        

                $searchText = $this->security->xss_clean($this->input->post('searchText'));
                $data['searchText'] = $searchText;
                
                $this->load->library('pagination');
                
                $count = $this->CadastroModel->userListingCount($searchText);

                $returns = $this->paginationCompress ( "pacotePacote/listar", $count, 100 );
                
                $data['registrosPacotes'] = $this->PacoteModel->listaPacote($this->session->userdata('IdEmpresa'), $searchText, $returns["page"], $returns["segment"]);
                
                $process = 'Listar pacotes';
                $processFunction = 'Pacote/pacotePacote';
                $this->logrecord($process,$processFunction);

                $this->global['pageTitle'] = 'QUALICAD : Lista de Pacotes';
                
                $this->loadViews("qualicad/pacote/l_pacotePacote", $this->global, $data, NULL);
            }
            else if ($tpTela == 'cadastrar') {

                if ($this->PermissaoModel->permissaoAcaoInserir($this->session->userdata('IdUsuEmp'),'TelaConvenio')[0]->Inserir == 'N')
                {
                    redirect('acaoNaoAutorizada');
                }

                $data['infoPlano'] = $this->PrincipalModel->carregaInfoPlanosEmpresa($this->session->userdata('IdEmpresa'));
                $data['infoConvenio'] = $this->PrincipalModel->carregaInfoConveniosEmpresa($this->session->userdata('IdEmpresa'));
                $data['infoGrupoPro'] = $this->PrincipalModel->carregaInfoGrupoPro($this->session->userdata('IdEmpresa'));              
                $data['infoSubstancias'] = $this->PacoteModel->carregaInfoSubstancias($this->session->userdata('IdEmpresa'));
                $data['infoSetores'] = $this->PacoteModel->carregaInfoSetores($this->session->userdata('IdEmpresa'));
            
                $this->global['pageTitle'] = 'QUALICAD : Cadastro de Pacote';
                $this->loadViews("qualicad/pacote/c_pacotePacote", $this->global, $data, NULL); 
            }
            else if ($tpTela == 'editar') {

                if ($this->PermissaoModel->permissaoAcaoAtualizar($this->session->userdata('IdUsuEmp'),'TelaConvenio')[0]->Atualizar == 'N')
                {
                    redirect('acaoNaoAutorizada');
                }

                $cd_pacote = $this->uri->segment(3);
                if($cd_pacote == null)
                {
                    redirect('pacotePacote/listar');
                }

                $data['infoPacote'] = $this->PacoteModel->carregaInfoPacote($cd_pacote);
                $data['infoPlano'] = $this->PrincipalModel->carregaInfoPlanosEmpresa($this->session->userdata('IdEmpresa'));
                $data['infoConvenio'] = $this->PrincipalModel->carregaInfoConveniosEmpresa($this->session->userdata('IdEmpresa'));
                $data['infoGrupoPro'] = $this->PrincipalModel->carregaInfoGrupoPro($this->session->userdata('IdEmpresa'));                                 
                $data['infoSubstancias'] = $this->PacoteModel->carregaInfoSubstancias($this->session->userdata('IdEmpresa'));
                $data['infoSetores'] = $this->PacoteModel->carregaInfoSetores($this->session->userdata('IdEmpresa'));

                $data['infoExcecaoPacotePacote'] = $this->PacoteModel->carregaInfoExcecaoPacotePacote($cd_pacote,$this->session->userdata('IdEmpresa'));

                $this->global['pageTitle'] = 'QUALICAD : Editar pacote';      
                $this->loadViews("qualicad/pacote/c_pacotePacote", $this->global, $data, NULL);
            }
    }

    function adicionaPacote() 
    {
            if (array_key_exists('IrLista',$this->input->post())) {
                redirect('pacotePacote/listar'); 
            } 



            $this->load->library('form_validation');

            $this->form_validation->set_rules('Nome_Usuario','Nome','trim|required|max_length[128]');
            $this->form_validation->set_rules('Cpf_Usuario','CPF','trim|required|max_length[128]');
            $this->form_validation->set_rules('Email','Email','trim|required|valid_email|max_length[128]');
            $this->form_validation->set_rules('Senha','Senha','required|max_length[20]');
            $this->form_validation->set_rules('resenha','Confirme a senha','trim|required|matches[password]|max_length[20]');

        //VALIDAÇÃO

        //    $this->form_validation->set_rules('perfil','Role','trim|required|numeric');
            
        /*    if($this->form_validation->run() == FALSE)
            {

                redirect('cadastroUsuario/cadastrar');
            }
            else
        { */
                $cd_pacote_erp = $this->input->post('cd_pacote_erp')?$this->input->post('cd_pacote_erp'):null;
                $desc_pacote = $this->input->post('desc_pacote')?$this->input->post('desc_pacote'):null;
                $cd_convenio_id = $this->input->post('TbConvenio_Id_Convenio')?$this->input->post('TbConvenio_Id_Convenio'):null;
                $cd_plano_id = $this->input->post('TbPlano_Id_Plano')?$this->input->post('TbPlano_Id_Plano'):null;
                $cd_profat = $this->input->post('cd_profat')?$this->input->post('cd_profat'):null;
                $qtd_diarias = $this->input->post('qtd_diarias')?$this->input->post('qtd_diarias'):null;
                $dt_vigencia_inicial = $this->input->post('dt_vigencia_inicial')?$this->input->post('dt_vigencia_inicial'):null;
                $dt_vigencia_final = $this->input->post('dt_vigencia_final')?$this->input->post('dt_vigencia_final'):null;

            //    $roleId = $this->input->post('role');
            
            // ***** VERIFICAÇÕES DE DUPLICIDADE NA ADIÇÃO *****
               /* if ($this->PrincipalModel->consultaConvenioExistente($CNPJ_Convenio,$this->session->userdata('IdEmpresa')) != null) {
                $this->session->set_flashdata('error', 'CNPJ já foi cadastrado!');
                redirect('principalConvenio/listar');
                }
                
                if ($this->PrincipalModel->consultaCodERPExistente($Cd_ConvenioERP,$this->session->userdata('IdEmpresa')) != null) {
                $this->session->set_flashdata('error', 'Código ERP já foi cadastrado!');
                redirect('principalConvenio/listar');
                }*/
            // ***** FIM DE VERIFICAÇÕES *****    

                //SE O CONVENIO FOR SETADO COMO ATIVO PEGAR DATA ATUAL
               /* if ($Tp_Ativo == 'S')
                {
                    $Dt_Ativo = date('Y-m-d H:i:s');
                } else
                {
                    $Dt_Ativo = null;
                }

                $Dt_Ativo = date('Y-m-d H:i:s');*/

                    //'Senha'=>getHashedPassword($senha)

                $infoPacote = array('cd_pacote_erp'=>$cd_pacote_erp, 
                                    'id_empresa'=>$this->session->userdata('IdEmpresa'),'desc_pacote'=> $desc_pacote, 'cd_convenio_id'=> $cd_convenio_id,
                                    'cd_plano_id'=>$cd_plano_id, 'cd_profat'=>$cd_profat, 'qtd_diarias'=>$qtd_diarias,
                                    'dt_vigencia_inicial'=>$dt_vigencia_inicial, 'dt_vigencia_final'=>$dt_vigencia_final);
                                    
                $result = $this->PacoteModel->adicionaPacote($infoPacote);


                /*ADICIONAR EXCEÇÃO DE PACOTE*/
                
                $cd_pacote = $result;
                $cd_grupro = $this->input->post('cd_grupro')?$this->input->post('cd_grupro'):null;
                $cd_substancia  = $this->input->post('cd_substancia')?$this->input->post('cd_substancia'):null;
                $cd_tuss = $this->input->post('cd_tuss')?$this->input->post('cd_tuss'):null;
                $cd_setor = $this->input->post('cd_setor')?$this->input->post('cd_setor'):null;

                $Tp_GrupoPro = $this->input->post('Tp_GrupoPro')?$this->input->post('Tp_GrupoPro'):null;
                $TbGrupoPro_CodGrupo  = $this->input->post('TbGrupoPro_CodGrupo')?$this->input->post('TbGrupoPro_CodGrupo'):null;
              
                //    $roleId = $this->input->post('role');

                //VERIFICAÇÃO DE DUPLICIDADE
                //        if ($this->PrincipalModel->consultaPlanoExistente($CNPJ_Convenio,$this->session->userdata('IdUsuEmp')) == null) {

                //SE O CONVENIO FOR SETADO COMO ATIVO PEGAR DATA ATUAL
                /*if ($Tp_Ativo == 'S')
                {
                    $Dt_Ativo = date('Y-m-d H:i:s');
                } else
                {
                    $Dt_Ativo = null;
                }*/

                //'Senha'=>getHashedPassword($senha)


            $carregaGrupoPro = $this->PrincipalModel->carregaInfoGrupoProTpGrupoPro($Tp_GrupoPro,$this->session->userdata('IdEmpresa'));
            
            if ($carregaGrupoPro != null && $TbGrupoPro_CodGrupo != 'SELECIONE') {

            // ***** VERIFICAÇÕES DE DUPLICIDADE NA ADIÇÃO *****
            /*if ($this->PrincipalModel->consultaRegraGruProExistente($TbGrupoPro_CodGrupo,$result,$this->session->userdata('IdEmpresa')) != null) {
                $this->session->set_flashdata('error', 'Regra GruPro já foi cadastrado!');
                redirect('principalRegraGruPro/cadastrar');
                }*/
                    
            foreach ($carregaGrupoPro as $data){
                if ($Tp_GrupoPro != 'SELECIONE'&&$cd_substancia != 'SELECIONE'&&$cd_setor != 'SELECIONE') {
                $infoExcecaoPacote = array('cd_grupro'=>$data->CodGrupoPro, 'id_empresa'=>$this->session->userdata('IdEmpresa'),
                    'cd_pacote'=> $result, 'cd_substancia'=> $cd_substancia,'cd_tuss'=>$cd_tuss,
                    'cd_setor'=>$cd_setor);

                $result2 = $this->PacoteModel->adicionaExcecaoPacote($infoExcecaoPacote);
                } else {
                    $result2 = 1;
                }
            } }
            else {
                $result2 = 2;
            }
            

            if(($result > 0)&&($result2 > 0))
            {
                $process = 'Adicionar pacote';
                $processFunction = 'Pacote/adicionaPacote';
                $this->logrecord($process,$processFunction);

                if (($result2) == 2||($result2) == 1){
                $this->session->set_flashdata('success', 'Pacote criado com sucesso');
                } else
                {
                $this->session->set_flashdata('success', 'Pacote e exceção pacote criados com sucesso');
                }

                if (array_key_exists('salvarIrLista',$this->input->post())) {
                    redirect('pacotePacote/listar');
                }
                else if (array_key_exists('salvarMesmaTela',$this->input->post())) {
                    redirect('pacotePacote/cadastrar');
                }
                else if (array_key_exists('salvarExcecaoPacote',$this->input->post())) {
                    redirect('pacotePacote/editar/'.$result);
                }

            }
            else
            {
                $this->session->set_flashdata('error', 'Falha na criação do pacote');
            }

            redirect('pacotePacote/cadastrar');




              /*  if (is_numeric($cd_grupro)&&is_numeric($cd_substancia)&&is_numeric($cd_tuss)&&is_numeric($cd_setor)) 
                {
                    $infoExcecaoPacote = array('cd_pacote' => $cd_pacote, 'id_empresa' => $this->session->userdata('IdEmpresa'),
                    'cd_grupro' => $cd_grupro, 'cd_substancia' => $cd_substancia, 'cd_tuss' => $cd_tuss, 'cd_setor' => $cd_setor);

                    $resultExcecaoPacote = $this->PacoteModel->adicionaExcecaoPacote($infoExcecaoPacote);

                    if($resultExcecaoPacote != null)
                    {
                        $process = 'Adicionar pacote e exceção de pacote';
                        $processFunction = 'Pacote/adicionaPacote';
                        $this->logrecord($process,$processFunction);

                        $this->session->set_flashdata('success', 'Pacote e exceção pacote criados com sucesso');

                        if (array_key_exists('salvarIrLista',$this->input->post())) {
                            redirect('pacotePacote/listar'); 
                        }
                        else if (array_key_exists('salvarMesmaTela',$this->input->post())) {
                            redirect('pacotePacote/cadastrar'); 
                        }
                        else if (array_key_exists('salvarAvancar',$this->input->post())) {
                            redirect('pacotePacote/cadastrar');
                        }
                        else if (array_key_exists('salvarExcecaoPacote',$this->input->post())) {
                            redirect('pacoteExcecaoPacote/editar/'.$cd_pacote);
                        }

                    }
                    else
                    {
                        $this->session->set_flashdata('error', 'Falha na criação do pacote');
                        redirect('pacotePacote/cadastrar');
                    }

                } else {

                    if($cd_pacote != null)
                    {
                        $process = 'Adicionar pacote';
                        $processFunction = 'Pacote/adicionaPacote';
                        $this->logrecord($process,$processFunction);

                        $this->session->set_flashdata('success', 'Pacote criado com sucesso');

                        if (array_key_exists('salvarIrLista',$this->input->post())) {
                            redirect('pacotePacote/listar'); 
                        }
                        else if (array_key_exists('salvarMesmaTela',$this->input->post())) {
                            redirect('pacotePacote/cadastrar'); 
                        }
                        else if (array_key_exists('salvarAvancar',$this->input->post())) {
                            redirect('pacotePacote/cadastrar');
                        }
                        else if (array_key_exists('salvarExcecaoPacote',$this->input->post())) {
                            redirect('pacotePacote/editar/'.$cd_pacote);
                        }

                    }
                    else
                    {
                        $this->session->set_flashdata('error', 'Falha na criação do pacote');
                        redirect('pacotePacote/cadastrar');
                    }

                }
                           
                
                redirect('pacotePacote/cadastrar');*/
    }


    function editaPacote()
    {
            if (array_key_exists('IrLista',$this->input->post())) {
                redirect('pacotePacote/listar'); 
            } 

            $this->load->library('form_validation');

            $cd_pacote = $this->input->post('cd_pacote');

            //VALIDAÇÃO
            
         /*   $this->form_validation->set_rules('fname','Full Name','trim|required|max_length[128]');
            $this->form_validation->set_rules('email','Email','trim|required|valid_email|max_length[128]');
            $this->form_validation->set_rules('password','Password','matches[cpassword]|max_length[20]');
            $this->form_validation->set_rules('cpassword','Confirm Password','matches[password]|max_length[20]');
            $this->form_validation->set_rules('role','Role','trim|required|numeric');
            $this->form_validation->set_rules('mobile','Mobile Number','required|min_length[10]');
            
            if($this->form_validation->run() == FALSE)
            { 
                $this->editOld($userId);
            }
            else
            { */

                $cd_pacote_erp = $this->input->post('cd_pacote_erp')?$this->input->post('cd_pacote_erp'):null;
                $desc_pacote = $this->input->post('desc_pacote')?$this->input->post('desc_pacote'):null;
                $cd_convenio_id = $this->input->post('TbConvenio_Id_Convenio')?$this->input->post('TbConvenio_Id_Convenio'):null;
                $cd_plano_id = $this->input->post('TbPlano_Id_Plano')?$this->input->post('TbPlano_Id_Plano'):null;
                $cd_profat = $this->input->post('cd_profat')?$this->input->post('cd_profat'):null;
                $qtd_diarias = $this->input->post('qtd_diarias')?$this->input->post('qtd_diarias'):null;
                $dt_vigencia_inicial = $this->input->post('dt_vigencia_inicial')?$this->input->post('dt_vigencia_inicial'):null;
                $dt_vigencia_final = $this->input->post('dt_vigencia_final')?$this->input->post('dt_vigencia_final'):null;

                /*foreach ($this->PrincipalModel->carregaInfoConvenio($IdConvenio) as $data){
                    $Tp_Ativo_Atual = ($data->Tp_Ativo);
                }

                // ***** VERIFICAÇÕES DE DUPLICIDADE NA EDIÇÃO *****
                if ($this->PrincipalModel->consultaConvenioExistente($CNPJ_Convenio,$this->session->userdata('IdEmpresa')) != null) {
                    if ($this->PrincipalModel->carregaInfoConvenio($IdConvenio)[0]->CNPJ_Convenio != $CNPJ_Convenio) {
                        $this->session->set_flashdata('error', 'CNPJ já foi cadastrado!');
                        redirect('principalConvenio/listar');
                    }
                }
                    
                if ($this->PrincipalModel->consultaCodERPExistente($Cd_ConvenioERP,$this->session->userdata('IdEmpresa')) != null) {
                    if ($this->PrincipalModel->carregaInfoConvenio($IdConvenio)[0]->Cd_ConvenioERP != $Cd_ConvenioERP) {
                    $this->session->set_flashdata('error', 'Código ERP já foi cadastrado!');
                    redirect('principalConvenio/listar');
                    }
                }*/
                // ***** FIM DE VERIFICAÇÕES *****    


                /*foreach ($this->PrincipalModel->carregaInfoConvenio($IdConvenio) as $data){
                    $Tp_Ativo_Atual = ($data->Tp_Ativo);
                }

                //SE O CONVENIO FOR SETADO COMO ATIVO PEGAR DATA ATUAL
                if ($Tp_Ativo_Atual == 'N' && $Tp_Ativo == 'S')
                {
                    $Dt_Ativo = date('Y-m-d H:i:s');
                    $Dt_Inativo = null;
                } else if ($Tp_Ativo == 'N')
                {
                    $Dt_Ativo = null;
                    $Dt_Inativo = date('Y-m-d H:i:s');
                }

                $Dt_Ativo = date('Y-m-d H:i:s');
                $Dt_Inativo = date('Y-m-d H:i:s');*/

                //'Senha'=>getHashedPassword($senha)
                $infoPacote = array('cd_pacote_erp'=>$cd_pacote_erp, 
                                    'id_empresa'=>$this->session->userdata('IdEmpresa'),'desc_pacote'=> $desc_pacote, 'cd_convenio_id'=> $cd_convenio_id,
                                    'cd_plano_id'=>$cd_plano_id, 'cd_profat'=>$cd_profat, 'qtd_diarias'=>$qtd_diarias,
                                    'dt_vigencia_inicial'=>$dt_vigencia_inicial, 'dt_vigencia_final'=>$dt_vigencia_final);

                $result = $this->PacoteModel->editaPacote($infoPacote, $cd_pacote);


                /*EDITAR EXCECAO PACOTE*/

                $cd_grupro = $this->input->post('cd_grupro')?$this->input->post('cd_grupro'):null;
                $cd_substancia  = $this->input->post('cd_substancia')?$this->input->post('cd_substancia'):null;
                $cd_tuss = $this->input->post('cd_tuss')?$this->input->post('cd_substancia'):null;
                $cd_setor = $this->input->post('cd_setor')?$this->input->post('cd_setor'):null;                

                $Tp_GrupoPro = $this->input->post('Tp_GrupoPro')?$this->input->post('Tp_GrupoPro'):null;
                $TbGrupoPro_CodGrupo  = $this->input->post('TbGrupoPro_CodGrupo')?$this->input->post('TbGrupoPro_CodGrupo'):null;
                    
               
                //    $roleId = $this->input->post('role');
                

                //VERIFICAÇÃO DE DUPLICIDADE
                //        if ($this->PrincipalModel->consultaPlanoExistente($CNPJ_Convenio,$this->session->userdata('IdUsuEmp')) == null) {

                //SE O CONVENIO FOR SETADO COMO ATIVO PEGAR DATA ATUAL
                /*if ($Tp_Ativo == 'S')
                {
                    $Dt_Ativo = date('Y-m-d H:i:s');
                } else
                {
                    $Dt_Ativo = null;
                }*/

                //'Senha'=>getHashedPassword($senha)

                //if ($Ds_Plano != '') {

                    // ***** VERIFICAÇÕES DE DUPLICIDADE *****
                   /* if ($this->PrincipalModel->consultaPlanoCodERPExistente($Cd_PlanoERP,$IdConvenio,$this->session->userdata('IdEmpresa')) != null) {
                        $this->session->set_flashdata('error', 'Cod. ERP já foi cadastrado!');
                        redirect('principalConvenio/editar/'.$IdConvenio);
                        }*/
                    // ***** FIM DE VERIFICAÇÕES *****


            $carregaGrupoPro = $this->PrincipalModel->carregaInfoGrupoProTpGrupoPro($Tp_GrupoPro,$this->session->userdata('IdEmpresa'));
            
            if ($carregaGrupoPro != null && $TbGrupoPro_CodGrupo != 'SELECIONE') {

            // ***** VERIFICAÇÕES DE DUPLICIDADE NA ADIÇÃO *****
            /*if ($this->PrincipalModel->consultaRegraGruProExistente($TbGrupoPro_CodGrupo,$result,$this->session->userdata('IdEmpresa')) != null) {
                $this->session->set_flashdata('error', 'Regra GruPro já foi cadastrado!');
                redirect('principalRegraGruPro/cadastrar');
                }*/
                    
            foreach ($carregaGrupoPro as $data){
                if ($Tp_GrupoPro != 'SELECIONE'&&$cd_substancia != 'SELECIONE'&&$cd_setor != 'SELECIONE') {
                $infoExcecaoPacote = array('cd_grupro'=>$data->CodGrupoPro, 'id_empresa'=>$this->session->userdata('IdEmpresa'),
                    'cd_pacote'=> $cd_pacote, 'cd_substancia'=> $cd_substancia,'cd_tuss'=>$cd_tuss,
                    'cd_setor'=>$cd_setor);

                $result2 = $this->PacoteModel->adicionaExcecaoPacote($infoExcecaoPacote);                
                } else {
                    $result2 = 1;
                }
            } }
            else {
                $result2 = 2;
            }
            

            if(($result > 0)&&($result2 > 0))
            {
                $process = 'Editar pacote';
                $processFunction = 'Pacote/editaPacote';
                $this->logrecord($process,$processFunction);

                if (($result2) == 2||($result2) == 1){
                $this->session->set_flashdata('success', 'Pacote atualizado com sucesso');
                } else
                {
                $this->session->set_flashdata('success', 'Pacote e exceção pacote atualizados com sucesso');
                }

                if (array_key_exists('salvarIrLista',$this->input->post())) {
                    redirect('pacotePacote/listar');
                }
                else if (array_key_exists('salvarMesmaTela',$this->input->post())) {
                    redirect('pacotePacote/cadastrar');
                }
                else if (array_key_exists('salvarExcecaoPacote',$this->input->post())) {
                    redirect('pacotePacote/editar/'.$cd_pacote);
                }

            }
            else
            {
                $this->session->set_flashdata('error', 'Falha na edição do pacote');
            }

            redirect('pacotePacote/listar');

           // }
    }

    function apagaPacote()
    {

            if ($this->PermissaoModel->permissaoAcaoExcluir($this->session->userdata('IdUsuEmp'),'TelaConvenio')[0]->Excluir == 'N')
                {
                    redirect('acaoNaoAutorizada');
                }

            $cd_pacote = $this->uri->segment(2);            
            
            $resultado = $this->PacoteModel->apagaPacote($cd_pacote);
            
            if ($resultado > 0) {
                // echo(json_encode(array('status'=>TRUE)));

                 $process = 'Exclusão de pacote';
                 $processFunction = 'Pacote/apagaPacote';
                 $this->logrecord($process,$processFunction);

                 if ($resultado === 1451) {
                     $this->session->set_flashdata('error', 'Erro ao excluir pacote');
                    }
                 else {
                     $this->session->set_flashdata('success', 'Pacote deletado com sucesso');
                    }

                }
                else 
                { 
                    //echo(json_encode(array('status'=>FALSE))); 
                    $this->session->set_flashdata('error', 'Falha em excluir o pacote');
                }
                redirect('pacotePacote/listar');
    }

    // INICIO DAS FUNÇÕES DA TELA DE EXCECAO PACOTE

    function pacoteExcecaoPacote()
    {
            $tpTela = $this->uri->segment(2);

            $data['perfis'] = $this->CadastroModel->carregaPerfisUsuarios();

            if ($tpTela == 'listar') {

                if ($this->session->userdata('email') != 'admin@admin.com')
                    {
                        if ($this->PermissaoModel->permissaoTela($this->session->userdata('IdUsuEmp'),'TelaConvenio')[0]->Tp_Ativo == 'N' ||
                            $this->PermissaoModel->permissaoAcaoConsultar($this->session->userdata('IdUsuEmp'),'TelaConvenio')[0]->Consultar == 'N')
                            {
                                redirect('telaNaoAutorizada');
                            }
                    }

                $searchText = $this->security->xss_clean($this->input->post('searchText'));
                $data['searchText'] = $searchText;
                
                $this->load->library('pagination');
                
                $count = $this->CadastroModel->userListingCount($searchText);

                $returns = $this->paginationCompress ( "pacoteExcecaoPacote/listar", $count, 100 );
                
                $data['registrosExcecaoPacotes'] = $this->PacoteModel->listaExcecaoPacote($this->session->userdata('IdEmpresa'), $searchText, $returns["page"], $returns["segment"]);
                
                $process = 'Listar Exceção Pacote';
                $processFunction = 'Pacote/pacoteExcecaoPacote';
                $this->logrecord($process,$processFunction);

                $this->global['pageTitle'] = 'QUALICAD : Lista de Exceção Pacote';
                
                $this->loadViews("qualicad/pacote/l_pacoteExcecaoPacote", $this->global, $data, NULL);
            }
            else if ($tpTela == 'cadastrar') {

                if ($this->PermissaoModel->permissaoAcaoInserir($this->session->userdata('IdUsuEmp'),'TelaConvenio')[0]->Inserir == 'N')
                {
                    redirect('acaoNaoAutorizada');
                }

                $data['infoConvenio'] = $this->PrincipalModel->carregaInfoConveniosEmpresa($this->session->userdata('IdEmpresa'));
                $data['infoIndice'] = $this->PrincipalModel->carregaInfoIndicesEmpresa($this->session->userdata('IdEmpresa'));
                $data['infoRegra'] = $this->PrincipalModel->carregaInfoRegrasEmpresa($this->session->userdata('IdEmpresa'));
                $this->global['pageTitle'] = 'QUALICAD : Cadastro de Exceção Pacote';
                $this->loadViews("qualicad/pacote/c_pacoteExcecaoPacote", $this->global, $data, NULL); 
            }
            else if ($tpTela == 'editar') {

                if ($this->PermissaoModel->permissaoAcaoAtualizar($this->session->userdata('IdUsuEmp'),'TelaConvenio')[0]->Atualizar == 'N')
                {
                    redirect('acaoNaoAutorizada');
                }

                $cd_pacote_excecao = $this->uri->segment(3);

                if($cd_pacote_excecao == null)
                {
                    redirect('pacotePacote/listar');
                }

                $data['infoPacoteExcecao'] = $this->PacoteModel->carregaInfoPacoteExcecao($cd_pacote_excecao);
                $data['infoGrupoPro'] = $this->PrincipalModel->carregaInfoGrupoPro($this->session->userdata('IdEmpresa'));                                 
                $data['infoSubstancias'] = $this->PacoteModel->carregaInfoSubstancias($this->session->userdata('IdEmpresa'));
                $data['infoSetores'] = $this->PacoteModel->carregaInfoSetores($this->session->userdata('IdEmpresa'));

                $this->global['pageTitle'] = 'QUALICAD : Editar Exceção Pacote';      
                $this->loadViews("qualicad/pacote/c_pacoteExcecaoPacote", $this->global, $data, NULL);
            }
    }

    function adicionaExcecaoPacote()
    {
            if (array_key_exists('IrLista',$this->input->post())) {
                redirect('principalPlano/listar'); 
            } 

            $this->load->library('form_validation');

            $this->form_validation->set_rules('Nome_Usuario','Nome','trim|required|max_length[128]');
            $this->form_validation->set_rules('Cpf_Usuario','CPF','trim|required|max_length[128]');
            $this->form_validation->set_rules('Email','Email','trim|required|valid_email|max_length[128]');
            $this->form_validation->set_rules('Senha','Senha','required|max_length[20]');
            $this->form_validation->set_rules('resenha','Confirme a senha','trim|required|matches[password]|max_length[20]');

            //VALIDAÇÃO

            //    $this->form_validation->set_rules('perfil','Role','trim|required|numeric');

            /*    if($this->form_validation->run() == FALSE)
                {

                    redirect('cadastroUsuario/cadastrar');
                }
                else
            { */

            $Ds_Plano = ucwords(strtolower($this->security->xss_clean($this->input->post('Ds_Plano'))));
            $TbConvenio_Id_Convenio = $this->input->post('TbConvenio_Id_Convenio');
            $TbIndice_Id_Indice = $this->input->post('TbIndice_Id_Indice');
            $TbRegra_Id_Regra  = $this->input->post('TbRegra_Id_Regra');
            $Cd_PlanoERP = $this->input->post('Cd_PlanoERP');
            $Tp_AcomodacaoPadrao = $this->input->post('Tp_AcomodacaoPadrao');
            $Tp_Ativo = $this->input->post('Tp_Ativo');

            //    $roleId = $this->input->post('role');


            // ***** VERIFICAÇÕES DE DUPLICIDADE *****
            if ($this->PrincipalModel->consultaPlanoCodERPExistente($Cd_PlanoERP,$TbConvenio_Id_Convenio,$this->session->userdata('IdEmpresa')) != null) {
                $this->session->set_flashdata('error', 'Cod. ERP já foi cadastrado!');
                redirect('principalPlano/cadastrar');
                }
            // ***** FIM DE VERIFICAÇÕES *****    


            //VERIFICAÇÃO DE DUPLICIDADE
    //        if ($this->PrincipalModel->consultaPlanoExistente($CNPJ_Convenio,$this->session->userdata('IdUsuEmp')) == null) {

                //SE O CONVENIO FOR SETADO COMO ATIVO PEGAR DATA ATUAL
                if ($Tp_Ativo == 'S')
                {
                    $Dt_Ativo = date('Y-m-d H:i:s');
                } else
                {
                    $Dt_Ativo = null;
                }

                //'Senha'=>getHashedPassword($senha)

                $infoPlano = array('TbConvenio_Id_Convenio'=>$TbConvenio_Id_Convenio,  'TbEmpresa_Id_Empresa'=>$this->session->userdata('IdEmpresa'),
                    'Ds_Plano'=>$Ds_Plano, 'TbIndice_Id_Indice'=> $TbIndice_Id_Indice, 'TbRegra_Id_Regra'=> $TbRegra_Id_Regra, 'Cd_PlanoERP'=>$Cd_PlanoERP,
                    'Tp_AcomodacaoPadrao'=>$Tp_AcomodacaoPadrao, 'CriadoPor'=>$this->vendorId, 'AtualizadoPor'=>$this->vendorId,
                    'Tp_Ativo'=>$Tp_Ativo, 'Dt_Criacao'=>date('Y-m-d'), 'Dt_Ativo'=>$Dt_Ativo);

                $result = $this->PrincipalModel->adicionaPlano($infoPlano);

                if($result > 0)
                {
                    $process = 'Adicionar plano';
                    $processFunction = 'Principal/adicionaPlano';
                    $this->logrecord($process,$processFunction);

                    $this->session->set_flashdata('success', 'Plano criado com sucesso');

                    if (array_key_exists('salvarIrLista',$this->input->post())) {
                        redirect('principalPlano/listar'); 
                    }
                    else if (array_key_exists('salvarMesmaTela',$this->input->post())) {
                        redirect('principalPlano/cadastrar'); 
                    }
                    else if (array_key_exists('salvarRetroceder',$this->input->post())) {
                        redirect('principalConvenio/cadastrar');
                    }

                }
                else
                {
                    $this->session->set_flashdata('error', 'Falha na criação do plano');
                }

          //  } else {
            //    $this->session->set_flashdata('error', 'Convênio já foi cadastrado!');
          //  }

            redirect('principalPlano/cadastrar');
    }


    function editaExcecaoPacote()
    {
        if (array_key_exists('IrLista',$this->input->post())) {
            redirect('pacotePacote/listar');
        }

        $this->load->library('form_validation');

        $cd_pacote_excecao = $this->input->post('cd_pacote_excecao');

        //VALIDAÇÃO

        /*   $this->form_validation->set_rules('fname','Full Name','trim|required|max_length[128]');
           $this->form_validation->set_rules('email','Email','trim|required|valid_email|max_length[128]');
           $this->form_validation->set_rules('password','Password','matches[cpassword]|max_length[20]');
           $this->form_validation->set_rules('cpassword','Confirm Password','matches[password]|max_length[20]');
           $this->form_validation->set_rules('role','Role','trim|required|numeric');
           $this->form_validation->set_rules('mobile','Mobile Number','required|min_length[10]');

           if($this->form_validation->run() == FALSE)
           {
               $this->editOld($userId);
           }
           else
           { */
 
        $cd_pacote = $this->input->post('cd_pacote');
        $cd_substancia  = $this->input->post('cd_substancia')?$this->input->post('cd_substancia'):null;
        $cd_tuss = $this->input->post('cd_tuss')?$this->input->post('cd_tuss'):null;
        $cd_setor = $this->input->post('cd_setor')?$this->input->post('cd_setor'):null;

       /* foreach ($this->PrincipalModel->carregaInfoRegraGruPro($IdRegraGruPro) as $data){
            $Tp_Ativo_Atual = ($data->Tp_Ativo);
        }

        //SE O CONVENIO FOR SETADO COMO ATIVO PEGAR DATA ATUAL
        if ($Tp_Ativo_Atual == 'N' && $Tp_Ativo == 'S')
        {
            $Dt_Ativo = date('Y-m-d H:i:s');
            $Dt_Inativo = null;
        } else if ($Tp_Ativo_Atual == 'S' && $Tp_Ativo == 'N')
        {
            $Dt_Ativo = null;
            $Dt_Inativo = date('Y-m-d H:i:s');
        } */

        $infoExcecaoPacote = array('cd_substancia'=>$cd_substancia, 'cd_tuss'=>$cd_tuss,
                    'cd_setor'=> $cd_setor);

        $resultado = $this->PacoteModel->editaExcecaoPacote($infoExcecaoPacote,$cd_pacote_excecao);

        if(($resultado == true))
        {
            $process = 'Exceção pacote atualizado';
            $processFunction = 'Pacote/editaExcecaoPacote';
            $this->logrecord($process,$processFunction);

            if (array_key_exists('salvareVoltar',$this->input->post())) {
                $this->session->set_flashdata('success', 'Exceção pacote atualizado com sucesso');
                redirect('pacotePacote/editar/'.$cd_pacote);
            }

            $this->session->set_flashdata('success', 'Exceção pacote atualizado com sucesso');
        }
        else
        {
            $this->session->set_flashdata('error', 'Falha na atualização da exceção pacote');
        }
    }

    function apagaExcecaoPacote()
    {
            if ($this->PermissaoModel->permissaoAcaoExcluir($this->session->userdata('IdUsuEmp'),'TelaConvenio')[0]->Excluir == 'N')
                {
                    redirect('acaoNaoAutorizada');
                }

                
            $cd_pacote = $this->uri->segment(3);
            $cd_pacote_excecao = $this->uri->segment(2);        
            
            $resultado = $this->PacoteModel->apagaExcecaoPacote($cd_pacote_excecao);
            
            if ($resultado > 0) {
                // echo(json_encode(array('status'=>TRUE)));

                $process = 'Exclusão de pacote exceção';
                $processFunction = 'Pacote/apagaPacoteExcecao';
                $this->logrecord($process,$processFunction);

                if ($resultado === 1451) {
                    $this->session->set_flashdata('error', 'Existe associação ativa');
                   }
                else {
                    $this->session->set_flashdata('success', 'Pacote exceção deletado com sucesso');
                   }

                }
                else 
                { 
                    //echo(json_encode(array('status'=>FALSE))); 
                    $this->session->set_flashdata('error', 'Falha em excluir o pacote exceção');
                }
                redirect('pacotePacote/editar/'.$cd_pacote);
    }

    // FIM DAS FUNÇÕES DA TELA DE EXCECAO PACOTE

    // INICIO DAS FUNÇÕES DA TELA DE SUBSTANCIA

    function pacoteSubstancia()
    {
            $tpTela = $this->uri->segment(2);

            $data['perfis'] = $this->CadastroModel->carregaPerfisUsuarios();

            if ($tpTela == 'listar') {

                if ($this->session->userdata('email') != 'admin@admin.com')
                    {
                        if ($this->PermissaoModel->permissaoTela($this->session->userdata('IdUsuEmp'),'TelaFaturamento')[0]->Tp_Ativo == 'N' ||
                            $this->PermissaoModel->permissaoAcaoConsultar($this->session->userdata('IdUsuEmp'),'TelaFaturamento')[0]->Consultar == 'N')
                            {
                                redirect('telaNaoAutorizada');
                            }
                    }

                $searchText = $this->security->xss_clean($this->input->post('searchText'));
                $data['searchText'] = $searchText;
                
                $this->load->library('pagination');
                
                $count = $this->CadastroModel->userListingCount($searchText);

                $returns = $this->paginationCompress ( "pacoteSubstancia/listar", $count, 100 );
                
                $data['registrosSubstancia'] = $this->PacoteModel->listaSubstancia($this->session->userdata('IdEmpresa'), $searchText, $returns["page"], $returns["segment"]);
                
                $process = 'Listar Substâncias';
                $processFunction = 'Pacote/principalSubstancia';
                $this->logrecord($process,$processFunction);

                $this->global['pageTitle'] = 'QUALICAD : Lista de Substâncias';
                
                $this->loadViews("qualicad/pacote/l_pacoteSubstancia", $this->global, $data, NULL);
            }
            else if ($tpTela == 'cadastrar') {

                if ($this->PermissaoModel->permissaoAcaoInserir($this->session->userdata('IdUsuEmp'),'TelaConvenio')[0]->Inserir == 'N')
                {
                    redirect('acaoNaoAutorizada');
                }

               /* $data['infoPorteMedico'] = $this->PrincipalModel->carregaInfoPorteMedico($this->session->userdata('IdEmpresa'));
                $data['infoTUSS'] = $this->PrincipalModel->carregaInfoTUSSEmpresa($this->session->userdata('IdEmpresa'));*/

                $this->global['pageTitle'] = 'QUALICAD : Cadastro de Substância';
                $this->loadViews("qualicad/pacote/c_pacoteSubstancia", $this->global, $data, NULL); 
            }
            else if ($tpTela == 'editar') {

                if ($this->PermissaoModel->permissaoAcaoAtualizar($this->session->userdata('IdUsuEmp'),'TelaConvenio')[0]->Atualizar == 'N')
                {
                    redirect('acaoNaoAutorizada');
                }

                $IdSubstancia = $this->uri->segment(3);
                if($IdSubstancia == null)
                {
                    redirect('pacoteSubstancia/listar');
                }
                $data['infoSubstancia'] = $this->PacoteModel->carregaInfoSubstancia($IdSubstancia);

/*                $data['infoFatItem'] = $this->PrincipalModel->carregaInfoFatItemFaturamento($IdFaturamento,$this->session->userdata('IdEmpresa'));
                $data['infoPorteMedico'] = $this->PrincipalModel->carregaInfoPorteMedico($this->session->userdata('IdEmpresa'));
                $data['infoTUSS'] = $this->PrincipalModel->carregaInfoTUSSEmpresa($this->session->userdata('IdEmpresa'));*/

                $this->global['pageTitle'] = 'QUALICAD : Editar substância';      
                $this->loadViews("qualicad/pacote/c_pacoteSubstancia", $this->global, $data, NULL);
            }
    }

    function adicionaSubstancia() 
    {
            if (array_key_exists('IrLista',$this->input->post())) {
                redirect('pacoteSubstancia/listar'); 
            } 

            $this->load->library('form_validation');

            $this->form_validation->set_rules('Nome_Usuario','Nome','trim|required|max_length[128]');
            $this->form_validation->set_rules('Cpf_Usuario','CPF','trim|required|max_length[128]');
            $this->form_validation->set_rules('Email','Email','trim|required|valid_email|max_length[128]');
            $this->form_validation->set_rules('Senha','Senha','required|max_length[20]');
            $this->form_validation->set_rules('resenha','Confirme a senha','trim|required|matches[password]|max_length[20]');

            //VALIDAÇÃO

            //    $this->form_validation->set_rules('perfil','Role','trim|required|numeric');

            /*    if($this->form_validation->run() == FALSE)
                {

                    redirect('cadastroUsuario/cadastrar');
                }
                else
            { */

            $desc_substancia = ucwords(strtolower($this->security->xss_clean($this->input->post('desc_substancia'))));
        
            //    $roleId = $this->input->post('role');

            //           if ($this->PrincipalModel->consultaConvenioExistente($CNPJ_Convenio,$this->session->userdata('IdEmpresa')) == null) {

            //SE O CONVENIO FOR SETADO COMO ATIVO PEGAR DATA ATUAL
           /* if ($Tp_Ativo == 'S')
            {
                $Dt_Ativo = date('Y-m-d H:i:s');
            } else
            {
                $Dt_Ativo = null;
            }*/

            //'Senha'=>getHashedPassword($senha)

            $infoSubstancia = array('id_empresa'=>$this->session->userdata('IdEmpresa'),
                'desc_substancia'=> $desc_substancia);

            $result = $this->PacoteModel->adicionaSubstancia($infoSubstancia);

            if(($result > 0))
            {
                $process = 'Adicionar substância';
                $processFunction = 'Pacote/adicionaSubstancia';
                $this->logrecord($process,$processFunction);

                $this->session->set_flashdata('success', 'Substância criado com sucesso');
                        
                if (array_key_exists('salvarIrLista',$this->input->post())) {
                    redirect('pacoteSubstancia/listar'); 
                }
                else if (array_key_exists('salvarMesmaTela',$this->input->post())) {
                    redirect('pacoteSubstancia/cadastrar');
                }
                else if (array_key_exists('salvarFatItem',$this->input->post())) {
                    redirect('pacoteSubstancia/editar/'.$cd_substancia);
                }

            }
            else
            {
                $this->session->set_flashdata('error', 'Falha na criação da substância');
            }

            //          } else {
            //             $this->session->set_flashdata('error', 'Convênio já foi cadastrado!');
            //         }

            redirect('pacoteSubstancia/cadastrar');

            //    }
    }


    function editaSubstancia()
    {
            if (array_key_exists('IrLista',$this->input->post())) {
                redirect('pacoteSubstancia/listar'); 
            } 

            $this->load->library('form_validation');

            $IdSubstancia = $this->input->post('cd_substancia');

            //VALIDAÇÃO

            /*   $this->form_validation->set_rules('fname','Full Name','trim|required|max_length[128]');
                $this->form_validation->set_rules('email','Email','trim|required|valid_email|max_length[128]');
                $this->form_validation->set_rules('password','Password','matches[cpassword]|max_length[20]');
                $this->form_validation->set_rules('cpassword','Confirm Password','matches[password]|max_length[20]');
                $this->form_validation->set_rules('role','Role','trim|required|numeric');
                $this->form_validation->set_rules('mobile','Mobile Number','required|min_length[10]');

                if($this->form_validation->run() == FALSE)
                {
                    $this->editOld($userId);
                }
                else
                { */

                    $desc_substancia = ucwords(strtolower($this->security->xss_clean($this->input->post('desc_substancia'))));
        
                    //    $roleId = $this->input->post('role');
        
                    //           if ($this->PrincipalModel->consultaConvenioExistente($CNPJ_Convenio,$this->session->userdata('IdEmpresa')) == null) {
        
                    //SE O CONVENIO FOR SETADO COMO ATIVO PEGAR DATA ATUAL
                   /* if ($Tp_Ativo == 'S')
                    {
                        $Dt_Ativo = date('Y-m-d H:i:s');
                    } else
                    {
                        $Dt_Ativo = null;
                    }*/
        
                    //'Senha'=>getHashedPassword($senha)
        
                    $infoSubstancia = array('id_empresa'=>$this->session->userdata('IdEmpresa'),
                        'desc_substancia'=> $desc_substancia);
        
                    $result = $this->PacoteModel->editaSubstancia($infoSubstancia, $IdSubstancia);
        
                    if($result)
                    {
                        $process = 'Adicionar substância';
                        $processFunction = 'Pacote/adicionaSubstancia';
                        $this->logrecord($process,$processFunction);
        
                        $this->session->set_flashdata('success', 'Substância atualizada com sucesso');
                                
                        if (array_key_exists('salvarIrLista',$this->input->post())) {
                            redirect('pacoteSubstancia/listar'); 
                        }
                        else if (array_key_exists('salvarMesmaTela',$this->input->post())) {
                            redirect('pacoteSubstancia/cadastrar');
                        }
                        else if (array_key_exists('salvarFatItem',$this->input->post())) {
                            redirect('pacoteSubstancia/editar/'.$cd_substancia);
                        }
        
                    }
                    else
                    {
                        $this->session->set_flashdata('error', 'Falha na atualização da substância');
                    }
        
                    //          } else {
                    //             $this->session->set_flashdata('error', 'Convênio já foi cadastrado!');
                    //         }
        
                    redirect('pacoteSubstancia/listar');
            // }
    }

    function apagaSubstancia()
    {
            if ($this->PermissaoModel->permissaoAcaoExcluir($this->session->userdata('IdUsuEmp'),'TelaConvenio')[0]->Excluir == 'N')
                {
                    redirect('acaoNaoAutorizada');
                }

            $IdSubstancia = $this->uri->segment(2);
             
            $resultado = $this->PacoteModel->apagaSubstancia($IdSubstancia);
            
            if ($resultado > 0) {
                // echo(json_encode(array('status'=>TRUE)));

                $process = 'Exclusão de substância';
                $processFunction = 'Principal/apagaSubstancia';
                $this->logrecord($process,$processFunction);

                if ($resultado === 1451) {
                    $this->session->set_flashdata('error', 'Erro ao excluir substância');
                   }
                else {
                    $this->session->set_flashdata('success', 'Substância deletada com sucesso');
                   }

                }
                else 
                { 
                    //echo(json_encode(array('status'=>FALSE))); 
                    $this->session->set_flashdata('error', 'Falha em excluir substância');
                }
                redirect('pacoteSubstancia/listar');
    }
    // FIM DAS FUNÇÕES DA TELA DE SUBSTANCIA

    // INICIO DAS FUNÇÕES DA TELA DE SETOR

    function pacoteSetor()
    {
            $tpTela = $this->uri->segment(2);

            $data['perfis'] = $this->CadastroModel->carregaPerfisUsuarios();

            if ($tpTela == 'listar') {

            /*    if ($this->session->userdata('email') != 'admin@admin.com')
                {
                    if ($this->PermissaoModel->permissaoTela($this->session->userdata('IdUsuEmp'),'TelaRegra')[0]->Tp_Ativo == 'N' ||
                        $this->PermissaoModel->permissaoAcaoConsultar($this->session->userdata('IdUsuEmp'),'TelaRegra')[0]->Consultar == 'N')
                        {
                            redirect('telaNaoAutorizada');
                        }
                } */

                $searchText = $this->security->xss_clean($this->input->post('searchText'));
                $data['searchText'] = $searchText;
                
                $this->load->library('pagination');
                
                $count = $this->CadastroModel->userListingCount($searchText);

                $returns = $this->paginationCompress ( "cadastroUsuario/listar", $count, 100 );
                
                $data['registrosSetor'] = $this->PacoteModel->listaSetor($this->session->userdata('IdEmpresa'), $searchText, $returns["page"], $returns["segment"]);
                
                $process = 'Listar setor';
                $processFunction = 'Pacote/pacotesetor';
                $this->logrecord($process,$processFunction);

                $this->global['pageTitle'] = 'QUALICAD : Lista de Setor';
                
                $this->loadViews("qualicad/pacote/l_pacoteSetor", $this->global, $data, NULL);
            }
            else if ($tpTela == 'cadastrar') {

            /*    if ($this->PermissaoModel->permissaoAcaoInserir($this->session->userdata('IdUsuEmp'),'TelaRegra')[0]->Inserir == 'N')
                    {
                        redirect('acaoNaoAutorizada');
                    } */
                /*$data['infoGrupoPro'] = $this->PrincipalModel->carregaInfoGrupoPro($this->session->userdata('IdEmpresa'));
                $data['infoFaturamento'] = $this->PrincipalModel->carregaInfoFaturamentoEmpresa($this->session->userdata('IdEmpresa'));*/

                $this->global['pageTitle'] = 'QUALICAD : Lista de Setor';
                $this->loadViews("qualicad/pacote/c_pacoteSetor", $this->global, $data, NULL); 
            }
            else if ($tpTela == 'editar') {

            /*    if ($this->PermissaoModel->permissaoAcaoAtualizar($this->session->userdata('IdUsuEmp'),'TelaRegra')[0]->Atualizar == 'N')
                    {
                        redirect('acaoNaoAutorizada');
                    } */

                $IdSetor = $this->uri->segment(3);
                if($IdSetor == null)
                {
                    redirect('pacoteSetor/listar');
                }
                /*$data['infoRegra'] = $this->PrincipalModel->carregaInfoRegra($IdRegra);
                $data['infoGrupoPro'] = $this->PrincipalModel->carregaInfoGrupoPro($this->session->userdata('IdEmpresa'));
                $data['infoFaturamento'] = $this->PrincipalModel->carregaInfoFaturamentoEmpresa($this->session->userdata('IdEmpresa'));

                $data['infoRegraGruPro'] = $this->PrincipalModel->carregaInfoRegraGruProRegra($IdRegra,$this->session->userdata('IdEmpresa'));*/

                $data['infoSetor'] = $this->PacoteModel->carregaInfoSetor($IdSetor);
                
                $this->global['pageTitle'] = 'QUALICAD : Editar Setor';      
                $this->loadViews("qualicad/pacote/c_pacoteSetor", $this->global, $data, NULL);
            }
    }

    function adicionaSetor() 
    {
            if (array_key_exists('IrLista',$this->input->post())) {
                redirect('pacoteSetor/listar'); 
            }  

            $this->load->library('form_validation');

            $this->form_validation->set_rules('Nome_Usuario','Nome','trim|required|max_length[128]');
            $this->form_validation->set_rules('Cpf_Usuario','CPF','trim|required|max_length[128]');
            $this->form_validation->set_rules('Email','Email','trim|required|valid_email|max_length[128]');
            $this->form_validation->set_rules('Senha','Senha','required|max_length[20]');
            $this->form_validation->set_rules('resenha','Confirme a senha','trim|required|matches[password]|max_length[20]');

            //VALIDAÇÃO

            //    $this->form_validation->set_rules('perfil','Role','trim|required|numeric');

            /*    if($this->form_validation->run() == FALSE)
                {

                    redirect('cadastroUsuario/cadastrar');
                }
                else
            { */

            $desc_setor = ucwords(strtolower($this->security->xss_clean($this->input->post('desc_setor'))));
            $cd_setor_erp = $this->input->post('cd_setor_erp');

            //    $roleId = $this->input->post('role');

            //           if ($this->PrincipalModel->consultaConvenioExistente($CNPJ_Convenio,$this->session->userdata('IdEmpresa')) == null) {

            //SE O CONVENIO FOR SETADO COMO ATIVO PEGAR DATA ATUAL
            /*if ($Tp_Ativo == 'S')
            {
                $Dt_Ativo = date('Y-m-d H:i:s');
            } else
            {
                $Dt_Ativo = null;
            }*/

            //'Senha'=>getHashedPassword($senha)

            $infoSetor = array('id_empresa'=>$this->session->userdata('IdEmpresa'),
                'desc_setor'=> $desc_setor, 'cd_setor_erp'=> $cd_setor_erp);

            $result = $this->PacoteModel->adicionaSetor($infoSetor);

            
            if(($result > 0))
            {
                $process = 'Adicionar setor';
                $processFunction = 'Pacote/adicionaSetor';
                $this->logrecord($process,$processFunction);

                $this->session->set_flashdata('success', 'Setor criado com sucesso');
                        
                if (array_key_exists('salvarIrLista',$this->input->post())) {
                    redirect('pacoteSetor/listar'); 
                }
                else if (array_key_exists('salvarMesmaTela',$this->input->post())) {
                    redirect('pacoteSetor/cadastrar');
                }

            }
            else
            {
                $this->session->set_flashdata('error', 'Falha na criação do setor');
            }

            //          } else {
            //             $this->session->set_flashdata('error', 'Convênio já foi cadastrado!');
            //         }

            redirect('pacoteSetor/cadastrar');

        //    }
    }


    function editaSetor()
    {
            if (array_key_exists('IrLista',$this->input->post())) {
                redirect('pacoteSetor/listar'); 
            }  

            $this->load->library('form_validation');

            $IdSetor = $this->input->post('cd_setor');

            //VALIDAÇÃO

            /*   $this->form_validation->set_rules('fname','Full Name','trim|required|max_length[128]');
                $this->form_validation->set_rules('email','Email','trim|required|valid_email|max_length[128]');
                $this->form_validation->set_rules('password','Password','matches[cpassword]|max_length[20]');
                $this->form_validation->set_rules('cpassword','Confirm Password','matches[password]|max_length[20]');
                $this->form_validation->set_rules('role','Role','trim|required|numeric');
                $this->form_validation->set_rules('mobile','Mobile Number','required|min_length[10]');

                if($this->form_validation->run() == FALSE)
                {
                    $this->editOld($userId);
                }
                else
                { */

            $desc_setor = ucwords(strtolower($this->security->xss_clean($this->input->post('desc_setor'))));
            $cd_setor_erp = $this->input->post('cd_setor_erp');

            /*foreach ($this->PrincipalModel->carregaInfoRegra($IdRegra) as $data){
                $tpativoatual = ($data->Tp_Ativo);
            }

            if ($tpativoatual == 'N' && $Tp_Ativo == 'S')
            {
                $Dt_Ativo = date('Y-m-d H:i:s');
                $Dt_Inativo = null;
            } else if ($Tp_Ativo == 'N')
            {
                $Dt_Ativo = null;
                $Dt_Inativo = date('Y-m-d H:i:s');
            } else
            {
                $Dt_Ativo = date('Y-m-d H:i:s');
                $Dt_Inativo = date('Y-m-d H:i:s');
            }*/

            //'Senha'=>getHashedPassword($senha)
            $infoSetor = array('id_empresa'=>$this->session->userdata('IdEmpresa'),
                'desc_setor'=> $desc_setor, 'cd_setor_erp'=> $cd_setor_erp);

            $resultado = $this->PacoteModel->editaSetor($infoSetor, $IdSetor);
      
            if($resultado)
                    {
                        $process = 'Editar setor';
                        $processFunction = 'Pacote/editaSetor';
                        $this->logrecord($process,$processFunction);
        
                        $this->session->set_flashdata('success', 'Setor atualizado com sucesso');
                                
                        if (array_key_exists('salvarIrLista',$this->input->post())) {
                            redirect('pacoteSetor/listar'); 
                        }
                        else if (array_key_exists('salvarMesmaTela',$this->input->post())) {
                            redirect('pacoteSetor/cadastrar');
                        }
        
                    }
                    else
                    {
                        $this->session->set_flashdata('error', 'Falha na atualização do setor');
                    }
        
                    //          } else {
                    //             $this->session->set_flashdata('error', 'Convênio já foi cadastrado!');
                    //         }
        
                    redirect('pacoteSetor/listar');
        // }
    }

    function apagaSetor()
    {

    /*        if ($this->PermissaoModel->permissaoAcaoExcluir($this->session->userdata('IdUsuEmp'),'TelaRegra')[0]->Excluir == 'N')
                {
                    redirect('acaoNaoAutorizada');
                } */

            $cd_setor = $this->uri->segment(2);           
            
            $resultado = $this->PacoteModel->apagaSetor($cd_setor);
            
            if ($resultado > 0) {
                // echo(json_encode(array('status'=>TRUE)));

                $process = 'Exclusão de setor';
                $processFunction = 'Pacote/apagaSetor';
                $this->logrecord($process,$processFunction);

                if ($resultado === 1451) {
                    $this->session->set_flashdata('error', 'Setor associado a um pacote');
                   }
                else {
                    $this->session->set_flashdata('success', 'Setor deletado com sucesso');
                   }

                }
                else 
                { 
                    //echo(json_encode(array('status'=>FALSE))); 
                    $this->session->set_flashdata('error', 'Falha em excluir o setor');
                }
                redirect('pacoteSetor/listar');
    }
    // FIM DAS FUNÇÕES DA TELA DE SETOR


    // INICIO DAS FUNÇÕES DA TELA DE EXCEÇÃO PROCEDIMENTO

    function pacoteExcecaoProcedimento()
    {
            $tpTela = $this->uri->segment(2);

            $data['perfis'] = $this->CadastroModel->carregaPerfisUsuarios();

            if ($tpTela == 'listar') {

                if ($this->session->userdata('email') != 'admin@admin.com')
                {
                    if (isset($this->PermissaoModel->permissaoTela($this->session->userdata('IdUsuEmp'),'TelaConvenio')[0]->Tp_Ativo)) {
                    if ($this->PermissaoModel->permissaoTela($this->session->userdata('IdUsuEmp'),'TelaConvenio')[0]->Tp_Ativo == 'N' ||
                        $this->PermissaoModel->permissaoAcaoConsultar($this->session->userdata('IdUsuEmp'),'TelaConvenio')[0]->Consultar == 'N')
                        {
                            redirect('telaNaoAutorizada');
                        }
                    } else {
                            redirect('telaNaoAutorizada');
                    }
                }        

                $searchText = $this->security->xss_clean($this->input->post('searchText'));
                $data['searchText'] = $searchText;
                
                $this->load->library('pagination');
                
                $count = $this->CadastroModel->userListingCount($searchText);

                $returns = $this->paginationCompress ( "pacoteExcecaoProcedimento/listar", $count, 100 );
                
                $data['registrosExcecaoProcedimento'] = $this->PacoteModel->listaExcecaoProcedimento($this->session->userdata('IdEmpresa'), $searchText, $returns["page"], $returns["segment"]);
                
                $process = 'Listar Exceção Procedimento';
                $processFunction = 'Pacote/pacoteExcecaoProcedimento';
                $this->logrecord($process,$processFunction);

                $this->global['pageTitle'] = 'QUALICAD : Lista de Exceção Procedimento';
                
                $this->loadViews("qualicad/pacote/l_pacoteExcecaoProcedimento", $this->global, $data, NULL);
            }
            else if ($tpTela == 'cadastrar') {

                if ($this->PermissaoModel->permissaoAcaoInserir($this->session->userdata('IdUsuEmp'),'TelaConvenio')[0]->Inserir == 'N')
                {
                    redirect('acaoNaoAutorizada');
                }
                
                $data['infoPacoteExcecoes'] = $this->PacoteModel->carregaInfoPacoteExcecoes($this->session->userdata('IdEmpresa'));

                $this->global['pageTitle'] = 'QUALICAD : Cadastro de Exceção Procedimento';
                $this->loadViews("qualicad/pacote/c_pacoteExcecaoProcedimento", $this->global, $data, NULL); 
            }
            else if ($tpTela == 'editar') {

                if ($this->PermissaoModel->permissaoAcaoAtualizar($this->session->userdata('IdUsuEmp'),'TelaConvenio')[0]->Atualizar == 'N')
                {
                    redirect('acaoNaoAutorizada');
                }

                $IdExcecaoProcedimento = $this->uri->segment(3);
                if($IdExcecaoProcedimento == null)
                {
                    redirect('pacoteExcecaoProcedimento/listar');
                }

                $data['infoPacoteExcecoes'] = $this->PacoteModel->carregaInfoPacoteExcecoes($this->session->userdata('IdEmpresa'));
                $data['infoExcecaoProcedimento'] = $this->PacoteModel->carregaInfoPacoteExcecaoProced($IdExcecaoProcedimento);

                $this->global['pageTitle'] = 'QUALICAD : Editar exceção procedimento';      
                $this->loadViews("qualicad/pacote/c_pacoteExcecaoProcedimento", $this->global, $data, NULL);
            }
    }

    function adicionaExcecaoProcedimento() 
    {
            if (array_key_exists('IrLista',$this->input->post())) {
                redirect('pacoteExcecaoProcedimento/listar'); 
            } 

            $this->load->library('form_validation');

            $this->form_validation->set_rules('Nome_Usuario','Nome','trim|required|max_length[128]');
            $this->form_validation->set_rules('Cpf_Usuario','CPF','trim|required|max_length[128]');
            $this->form_validation->set_rules('Email','Email','trim|required|valid_email|max_length[128]');
            $this->form_validation->set_rules('Senha','Senha','required|max_length[20]');
            $this->form_validation->set_rules('resenha','Confirme a senha','trim|required|matches[password]|max_length[20]');

        //VALIDAÇÃO

        //    $this->form_validation->set_rules('perfil','Role','trim|required|numeric');
            
        /*    if($this->form_validation->run() == FALSE)
            {

                redirect('cadastroUsuario/cadastrar');
            }
            else
        { */
                $cd_pacote_excecao = $this->input->post('cd_pacote_excecao')?$this->input->post('cd_pacote_excecao'):null;
                $cd_tuss = $this->input->post('cd_tuss')?$this->input->post('cd_tuss'):null;
                $tp_ativo = $this->input->post('tp_ativo')?$this->input->post('tp_ativo'):null;
               
                //    $roleId = $this->input->post('role');
    
                //           if ($this->PrincipalModel->consultaConvenioExistente($CNPJ_Convenio,$this->session->userdata('IdEmpresa')) == null) {
    
                //SE O CONVENIO FOR SETADO COMO ATIVO PEGAR DATA ATUAL
                /*if ($Tp_Ativo == 'S')
                {
                    $Dt_Ativo = date('Y-m-d H:i:s');
                } else
                {
                    $Dt_Ativo = null;
                }*/
    
                //'Senha'=>getHashedPassword($senha)
    
                $infoExcecaoProcedimento = array('id_empresa'=>$this->session->userdata('IdEmpresa'),
                    'cd_pacote_excecao'=> $cd_pacote_excecao, 'cd_tuss'=> $cd_tuss);
    
                $result = $this->PacoteModel->adicionaExcecaoProcedimento($infoExcecaoProcedimento);
    
                
                if(($result > 0))
                {
                    $process = 'Adicionar Exceção Procedimento';
                    $processFunction = 'Pacote/adicionaExcecaoProcedimento';
                    $this->logrecord($process,$processFunction);
    
                    $this->session->set_flashdata('success', 'Exceção procedimento criado com sucesso');
                            
                    if (array_key_exists('salvarIrLista',$this->input->post())) {
                        redirect('pacoteExcecaoProcedimento/listar'); 
                    }
                    else if (array_key_exists('salvarMesmaTela',$this->input->post())) {
                        redirect('pacoteExcecaoProcedimento/cadastrar');
                    }
    
                }
                else
                {
                    $this->session->set_flashdata('error', 'Falha na criação da exceção procedimento');
                }
    
                //          } else {
                //             $this->session->set_flashdata('error', 'Convênio já foi cadastrado!');
                //         }
    
                redirect('pacoteExcecaoProcedimento/cadastrar');
    
            //    }
    }


    function editaExcecaoProcedimento()
    {
            if (array_key_exists('IrLista',$this->input->post())) {
                redirect('pacoteExcecaoProcedimento/listar'); 
            } 

            $this->load->library('form_validation');

            $IdExcecaoProcedimento = $this->input->post('cd_pacote_excecao_proced');

            //VALIDAÇÃO
            
         /*   $this->form_validation->set_rules('fname','Full Name','trim|required|max_length[128]');
            $this->form_validation->set_rules('email','Email','trim|required|valid_email|max_length[128]');
            $this->form_validation->set_rules('password','Password','matches[cpassword]|max_length[20]');
            $this->form_validation->set_rules('cpassword','Confirm Password','matches[password]|max_length[20]');
            $this->form_validation->set_rules('role','Role','trim|required|numeric');
            $this->form_validation->set_rules('mobile','Mobile Number','required|min_length[10]');
            
            if($this->form_validation->run() == FALSE)
            { 
                $this->editOld($userId);
            }
            else
            { */

                $cd_pacote_excecao = $this->input->post('cd_pacote_excecao')?$this->input->post('cd_pacote_excecao'):null;
                $cd_tuss = $this->input->post('cd_tuss')?$this->input->post('cd_tuss'):null;
                $tp_ativo = $this->input->post('tp_ativo')?$this->input->post('tp_ativo'):null;
               
                //    $roleId = $this->input->post('role');
    
                //           if ($this->PrincipalModel->consultaConvenioExistente($CNPJ_Convenio,$this->session->userdata('IdEmpresa')) == null) {
    
                //SE O CONVENIO FOR SETADO COMO ATIVO PEGAR DATA ATUAL
                /*if ($Tp_Ativo == 'S')
                {
                    $Dt_Ativo = date('Y-m-d H:i:s');
                } else
                {
                    $Dt_Ativo = null;
                }*/
    
                //'Senha'=>getHashedPassword($senha)
    
                $infoExcecaoProcedimento = array('id_empresa'=>$this->session->userdata('IdEmpresa'),
                    'cd_pacote_excecao'=> $cd_pacote_excecao, 'cd_tuss'=> $cd_tuss);
    
                $result = $this->PacoteModel->editaExcecaoProcedimento($infoExcecaoProcedimento, $IdExcecaoProcedimento);
    
                
                if(($result > 0))
                {
                    $process = 'Editar Exceção Procedimento';
                    $processFunction = 'Pacote/editaExcecaoProcedimento';
                    $this->logrecord($process,$processFunction);
    
                    $this->session->set_flashdata('success', 'Exceção procedimento atualizado com sucesso');
                            
                    if (array_key_exists('salvarIrLista',$this->input->post())) {
                        redirect('pacoteExcecaoProcedimento/listar'); 
                    }
                    else if (array_key_exists('salvarMesmaTela',$this->input->post())) {
                        redirect('pacoteExcecaoProcedimento/cadastrar');
                    }
    
                }
                else
                {
                    $this->session->set_flashdata('error', 'Falha na edição da exceção procedimento');
                }
    
                //          } else {
                //             $this->session->set_flashdata('error', 'Convênio já foi cadastrado!');
                //         }
    
                redirect('pacoteExcecaoProcedimento/listar');
    
            //    }
    }

    function apagaExcecaoProcedimento()
    {

            if ($this->PermissaoModel->permissaoAcaoExcluir($this->session->userdata('IdUsuEmp'),'TelaConvenio')[0]->Excluir == 'N')
                {
                    redirect('acaoNaoAutorizada');
                }

            $IdExcecaoProcedimento = $this->uri->segment(2);            
            
            $resultado = $this->PacoteModel->apagaExcecaoProcedimento($IdExcecaoProcedimento);
            
            if ($resultado > 0) {
                // echo(json_encode(array('status'=>TRUE)));

                 $process = 'Exclusão de exceção procedimento';
                 $processFunction = 'Pacote/apagaExcecaoProcedimento';
                 $this->logrecord($process,$processFunction);

                 if ($resultado === 1451) {
                     $this->session->set_flashdata('error', 'Erro ao excluir Exceção Procedimento');
                    }
                 else {
                     $this->session->set_flashdata('success', 'Exceção procedimento deletado com sucesso');
                    }

                }
                else 
                { 
                    //echo(json_encode(array('status'=>FALSE))); 
                    $this->session->set_flashdata('error', 'Erro ao excluir Exceção Procedimento');
                }
                redirect('pacoteExcecaoProcedimento/listar');
    }

    function consultaPacoteExcecao()
    {
           
            $cd_pacote_excecao = $this->uri->segment(2);
                       
            $resultado = $this->PacoteModel->consultaPacoteExcecao($cd_pacote_excecao);
            
            echo json_encode($resultado);
    }

    function valor($valor)
    {
        if (strpos($valor, ',') !== false) {
        return (str_replace(',','.',str_replace('.','',$valor)));
        } else {
        return ($valor);
        }
    }
    

}