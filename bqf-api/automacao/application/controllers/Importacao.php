<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';
/**
 * Class : Admin (AdminController)
 * Admin class to control to authenticate admin credentials and include admin functions.
 * @author : Samet Aydın / sametay153@gmail.com
 * @version : 1.0
 * @since : 27.02.2018
 */
class Importacao extends BaseController
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
        $this->load->model('CadastroModel');
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

    // IMPORTAÇÃO GRUPO PRO

    function importacaoGrupoPro()
    {
        $data['roles'] = $this->user_model->getUserRoles();

        $this->global['pageTitle'] = 'QUALICAD : Importação GrupoPro';

    //    $data['infoGrupoPro'] = $this->ImportacaoModel->carregaInfoGrupoPro($this->session->userdata('IdEmpresa'));
        $data['infoLayoutImportacao'] = $this->ImportacaoModel->carregaInfoLayoutImportacaoEmpresa('GrupoPro',$this->session->userdata('IdEmpresa'));

        $this->loadViews("qualicad/importacao/importacaoGrupoPro", $this->global, $data, NULL);
    }

    public function importaGrupoPro(){
        $data = array();
        $memData = array();

    //    $DePara = $this->ImportacaoModel->consultaDePara('GrupoPro',$this->session->userdata('IdEmpresa'));

        // If import request is submitted
        if($this->input->post('importSubmit')){
            // Form field validation rules
            $this->load->library('form_validation');

            $this->form_validation->set_rules('file', 'CSV file', 'callback_file_check');
            
            // Validate submitted form data
            if($this->form_validation->run() == true){
                $insertCount = $updateCount = $rowCount = $notAddCount = $duplicidade = 0;
                
                // If file uploaded
                if(is_uploaded_file($_FILES['file']['tmp_name'])){
                    // Load CSV reader library
                    $this->load->library('CSVReader');
                    
                    // Parse data from CSV file
                    $csvData = $this->csvreader->parse_csv($_FILES['file']['tmp_name']);
                    $dePara = $this->ImportacaoModel->consultaDePara($this->input->post('Tb_Id_LayoutImportacao'),'GrupoPro',$this->session->userdata('IdEmpresa'));

                    $errosDeChave = array();
                    $campoNaoLocalizado = '';

                    // Insert/update CSV data into database
                    if(!empty($csvData)){
                        foreach($csvData as $row) {
                            $rowCount++;

                            $memData = array();

                            for ($i=0;$i<count($dePara);$i++) {
                                if (!isset($row[(preg_replace('/\s+/', '', $dePara[$i]->No_CampoOrigem))])) {$campoNaoLocalizado = 'true';}
                                if (isset($row[(preg_replace('/\s+/', '', $dePara[$i]->No_CampoOrigem))])) {
                                    if (preg_replace('/\s+/', '', $dePara[$i]->St_Valor) == 'S' || $dePara[$i]->St_Data == 'S') {
                                        if (preg_replace('/\s+/', '', $dePara[$i]->St_Valor) == 'S') {
                                            $memData += array(
                                                (preg_replace('/\s+/', '', $dePara[$i]->No_CampoDestino)) => $this->valor($row[(preg_replace('/\s+/', '', $dePara[$i]->No_CampoOrigem))])
                                            );
                                        }
                                        if (preg_replace('/\s+/', '', $dePara[$i]->St_Data) == 'S') {
                                            $memData += array(
                                                (preg_replace('/\s+/', '', $dePara[$i]->No_CampoDestino)) => $this->data($row[(preg_replace('/\s+/', '', $dePara[$i]->No_CampoOrigem))])
                                            );
                                        }
                                    } else {
                                        $memData += array(
                                            (preg_replace('/\s+/', '', $dePara[$i]->No_CampoDestino)) => $this->data($row[(preg_replace('/\s+/', '', $dePara[$i]->No_CampoOrigem))])
                                        );
                                    }
                                }
                            }

                                $memData += array(
                                    'TbUsuEmp_Id_UsuEmp' => $this->session->userdata('IdUsuEmp'),
                                    'TbEmpresa_Id_Empresa'=>$this->session->userdata('IdEmpresa'),
                                    'CriadoPor'=>$this->vendorId,
                                    'Dt_Criacao'=>date('Y-m-d'),
                                    'Tp_Ativo'=> 'S');
                                
                                $insert = 0;
								
                                // ***** VERIFICAÇÕES DE DUPLICIDADE NA ADIÇÃO *****
                                if (isset($memData['CodGrupoPro'])) {
                                if ($this->ImportacaoModel->consultaRegraTbGrupoProExistente($memData['CodGrupoPro'],$this->session->userdata('IdEmpresa')) != null) {
                                    $duplicidade++;
                                    } else {
                                        $insert = $this->ImportacaoModel->adicionaGrupoPro($memData);
                                    }
                                }                        
                                // ***** FIM DE VERIFICAÇÕES *****    
                            
                                if($insert){
                                    $insertCount++;
                                } else {
                                    array_push($errosDeChave, ($rowCount+1));
                                    $notAddCount++;
                                }

                        }

                        $temp = null;

                        /* DEBUG DE CHAVE NÃO LOCALIZADA */
                        $i = 0;
                        foreach ($errosDeChave as $row) {
                        $i++;
                        if ($i < sizeof($errosDeChave) ) { 
                            $temp .= $row . ', ';
                        } else {
                            $temp .= $row;
                        }
                        }

                        $this->session->set_flashdata('errosDeChaveMsg', $temp);
                                                
                        // Status message with imported data count
                        $notAddCount = ($rowCount - ($insertCount + $updateCount));
                        $successMsg = 'Tabela FatItem importada com sucesso! Qtd. Linhas ('.$rowCount.') | Inseridos ('.$insertCount.') | Atualizados ('.$updateCount.') | Não inseridos ('.$notAddCount.') | Duplicidades ('.$duplicidade.')';

                        $this->session->set_flashdata('num_linhas_importadas', $insertCount);
                        if ($campoNaoLocalizado == '') {
                            $successMsg = 'Tabela Contrato importada com sucesso! Qtd. Linhas ('.$rowCount.') | Inseridos ('.$insertCount.') | Atualizados ('.$updateCount.') | Não inseridos ('.$notAddCount.')';
                            $this->session->set_flashdata('success', $successMsg);
                        } else {
                            $successMsg = 'Tabela Contrato importada com sucesso! Qtd. Linhas ('.$rowCount.') | Inseridos ('.$insertCount.') | Atualizados ('.$updateCount.') | Não inseridos ('.$notAddCount.')
                            <br/><strong>OBS: Algumas colunas do CSV não tem DEPARA cadastrado</strong>';
                            $this->session->set_flashdata('success', $successMsg);
                        }
                    }
                }else{
                    $this->session->set_flashdata('error', 'Erro no upload do arquivo, verifique se é um arquivo CSV válido e tente novamente.');
                }
            }else{
                $this->session->set_flashdata('error', 'Arquivo inválido! Selecione um arquivo CSV');
            //    $this->session->set_userdata('error_msg', 'Invalid file, please select only CSV file.');
            }
        }
        redirect('importacaoGrupoPro');
    }


    function apagaImportacaoGrupoPro()
    {

        $IdGrupoPro = $this->uri->segment(2);

        $resultado = $this->ImportacaoModel->apagaImportacaoGrupoPro($IdGrupoPro);

        if ($resultado > 0) {
            // echo(json_encode(array('status'=>TRUE)));

            $process = 'Exclusão de importação Grupo Pro';
            $processFunction = 'Importacao/apagaImportacaoGrupoPro';
            $this->logrecord($process,$processFunction);

            if ($resultado === 1451) {
                $this->session->set_flashdata('error', 'Existe Regra Grupo ou ProFat associada');
            }
            else {
                $this->session->set_flashdata('success', 'GrupoPro deletado com sucesso');
            }

        }
        else
        {
            //echo(json_encode(array('status'=>FALSE)));
            $this->session->set_flashdata('error', 'Falha em excluir o GruPro');
        }
        redirect('importacaoGrupoPro');
    }


    // IMPORTAÇÃO PROFAT

    function importacaoProFat()
    {
        $searchText = $this->security->xss_clean($this->input->post('searchText'));
        $data['searchText'] = $searchText;
        
        $this->load->library('pagination');
        
        $count = $this->CadastroModel->userListingCount($searchText);

        $returns = $this->paginationCompress ( "importacaoProFat/listar", $count, 100 );
        
     //   $data['infoProFat'] = $this->ImportacaoModel->carregaInfoProFat($this->session->userdata('IdEmpresa'), $searchText, $returns["page"], $returns["segment"]);
        $data['infoLayoutImportacao'] = $this->ImportacaoModel->carregaInfoLayoutImportacaoEmpresa('ProFat',$this->session->userdata('IdEmpresa'));
        
        $process = 'Listar importação ProFat';
        $processFunction = 'importacao/importacaoProFat';
        $this->logrecord($process,$processFunction);

        $this->global['pageTitle'] = 'QUALICAD : Importação ProFat';
        
        $this->loadViews("qualicad/importacao/importacaoProFat", $this->global, $data, NULL);

    }

    public function importaProFat(){
        $data = array();
        $memData = array();

        //    $DePara = $this->ImportacaoModel->consultaDePara('GrupoPro',$this->session->userdata('IdEmpresa'));

        // If import request is submitted
        if($this->input->post('importSubmit')){
            // Form field validation rules
            $this->load->library('form_validation');

            $this->form_validation->set_rules('file', 'CSV file', 'callback_file_check');

            // Validate submitted form data
            if($this->form_validation->run() == true){
                $insertCount = $updateCount = $rowCount = $notAddCount = $duplicidade = 0;

                // If file uploaded
                if(is_uploaded_file($_FILES['file']['tmp_name'])){
                    // Load CSV reader library
                    $this->load->library('CSVReader');

                    // Parse data from CSV file
                    $csvData = $this->csvreader->parse_csv($_FILES['file']['tmp_name']);
                    $dePara = $this->ImportacaoModel->consultaDePara($this->input->post('Tb_Id_LayoutImportacao'),'ProFat',$this->session->userdata('IdEmpresa'));

                    $errosDeChave = array();
                    $campoNaoLocalizado = '';
                    
                    // Insert/update CSV data into database
                    if(!empty($csvData)){
                        foreach($csvData as $row) {
                            $rowCount++;

                            $memData = array();
                            for ($i=0;$i<count($dePara);$i++) {
                                if (!isset($row[(preg_replace('/\s+/', '', $dePara[$i]->No_CampoOrigem))])) {$campoNaoLocalizado = 'Algumas colunas do CSV não tem DEPARA cadastrado';}
                                if (isset($row[(preg_replace('/\s+/', '', $dePara[$i]->No_CampoOrigem))])) {
                                    if (preg_replace('/\s+/', '', $dePara[$i]->St_Valor) == 'S' || $dePara[$i]->St_Data == 'S') {
                                        if (preg_replace('/\s+/', '', $dePara[$i]->St_Valor) == 'S') {
                                            $memData += array(
                                                (preg_replace('/\s+/', '', $dePara[$i]->No_CampoDestino)) => $this->valor($row[(preg_replace('/\s+/', '', $dePara[$i]->No_CampoOrigem))])
                                            );
                                        }
                                        if (preg_replace('/\s+/', '', $dePara[$i]->St_Data) == 'S') {
                                            $memData += array(
                                                (preg_replace('/\s+/', '', $dePara[$i]->No_CampoDestino)) => $this->data($row[(preg_replace('/\s+/', '', $dePara[$i]->No_CampoOrigem))])
                                            );
                                        }
                                    } else {
                                        $memData += array(
                                            (preg_replace('/\s+/', '', $dePara[$i]->No_CampoDestino)) => $this->data($row[(preg_replace('/\s+/', '', $dePara[$i]->No_CampoOrigem))])
                                        );
                                    }
                                }
                            }

                            $memData += array(
                                'TbUsuEmp_Id_UsuEmp' => $this->session->userdata('IdUsuEmp'),
                                'TbEmpresa_Id_Empresa'=>$this->session->userdata('IdEmpresa'),
                                'Dt_Criacao'=>date('Y-m-d'),
                                'CriadoPor'=>$this->vendorId,
                                'Tp_Ativo'=> 'S');

                            $insert = 0;
                            $upgrade = 0;
                            // ***** VERIFICAÇÕES DE DUPLICIDADE NA ADIÇÃO *****
                           
                            if (isset($memData['CodProFat'])) {

                                    if ($this->ImportacaoModel->consultaRegraTbProFatExistente($memData['CodProFat'],$this->session->userdata('IdEmpresa')) != null) {    
                                        if ($this->ImportacaoModel->consultaRegraTbProFatCdGrupoProExistente($memData['CodProFat'],$this->session->userdata('IdEmpresa'),$memData['TbGrupoPro_CodGrupo']) == null) {
                                            $upgrade = $this->ImportacaoModel->atualizaProFat($memData);
                                        } else {
                                            $duplicidade++; 
                                        }
                                    } else {
                                        $insert = $this->ImportacaoModel->adicionaProFat($memData);
                                    }

                                }
                            

                            //$insert = $this->ImportacaoModel->adicionaProFat($memData);

                            // ***** FIM DE VERIFICAÇÕES *****    

                            if($insert){
                                $insertCount++;
                            } else {
                                array_push($errosDeChave, ($rowCount+1));
                                $notAddCount++;
                            }

                            if($upgrade){
                                $updateCount++;
                            } else {
                                array_push($errosDeChave, ($rowCount+1));
                                $notAddCount++;
                            }

                        }

                        $temp = null;

                        /* DEBUG DE CHAVE NÃO LOCALIZADA */
                        $i = 0;
                        foreach ($errosDeChave as $row) {
                        $i++;
                        if ($i < sizeof($errosDeChave) ) { 
                            $temp .= $row . ', ';
                        } else {
                            $temp .= $row;
                        }
                        }

                        $this->session->set_flashdata('errosDeChaveMsg', $temp);

                        // Status message with imported data count
                        $notAddCount = ($rowCount - ($insertCount + $updateCount));
                        $successMsg = 'Tabela FatItem importada com sucesso! Qtd. Linhas ('.$rowCount.') | Inseridos ('.$insertCount.') | Atualizados ('.$updateCount.') | Não inseridos ('.$notAddCount.') | Duplicidades ('.$duplicidade.')';

                        $this->session->set_flashdata('num_linhas_importadas', $insertCount);
                        if ($campoNaoLocalizado == '') {
                            $this->session->set_flashdata('success', $successMsg);
                        } else {
                            $this->session->set_flashdata('error', $campoNaoLocalizado);
                        }
                    }
                }else{
                    $this->session->set_flashdata('error', 'Erro no upload do arquivo, verifique se é um arquivo CSV válido e tente novamente.');
                }
            }else{
                $this->session->set_flashdata('error', 'Arquivo inválido! Selecione um arquivo CSV');
                //    $this->session->set_userdata('error_msg', 'Invalid file, please select only CSV file.');
            }
        }
      
        redirect('importacaoProFat');
    }

    function apagaImportacaoProFat()
    {

        $IdProFat = $this->uri->segment(2);

        $resultado = $this->ImportacaoModel->apagaImportacaoProFat($IdProFat);

        if ($resultado > 0) {
            // echo(json_encode(array('status'=>TRUE)));

            $process = 'Exclusão de importação ProFat';
            $processFunction = 'Importacao/apagaImportacaoProFat';
            $this->logrecord($process,$processFunction);

            if ($resultado === 1451) {
                $this->session->set_flashdata('error', 'Existe exceção de valores associada');
            }
            else {
                $this->session->set_flashdata('success', 'ProFat deletada com sucesso');
            }

        }
        else
        {
            //echo(json_encode(array('status'=>FALSE)));
            $this->session->set_flashdata('error', 'Falha em excluir o ProFat');
        }
        redirect('importacaoProFat');
    }


    function importacaoDeletaProFat()
    {     
        $resultado = $this->ImportacaoModel->apagaProFat();
        
        if ($resultado > 0) {
            // echo(json_encode(array('status'=>TRUE)));

             $process = 'Limpa Tabela ProFat';
             $processFunction = 'Importacao/importacaoDeletaProFat';
             $this->logrecord($process,$processFunction);

             if ($resultado === 1451) {
                 $this->session->set_flashdata('error', 'Existe associação ativa');
                }
             else {
                 $this->session->set_flashdata('success', 'ProFat deletada com sucesso');
                }

            }
            else 
            { 
                //echo(json_encode(array('status'=>FALSE))); 
                $this->session->set_flashdata('error', 'Falha em excluir a ProFat');
            }
            redirect('importacaoProFat');      

    }
    // IMPORTAÇÃO TUSS

    function importacaoTUSS()
    {
        $data['roles'] = $this->user_model->getUserRoles();

        $this->global['pageTitle'] = 'QUALICAD : Importação TUSS';

     //   $data['infoTUSS'] = $this->ImportacaoModel->carregaInfoTUSS($this->session->userdata('IdEmpresa'));
        $data['infoLayoutImportacao'] = $this->ImportacaoModel->carregaInfoLayoutImportacaoEmpresa('TUSS',$this->session->userdata('IdEmpresa'));

        $this->loadViews("qualicad/importacao/importacaoTUSS", $this->global, $data, NULL);
    }

    function importacaoTUSS_progresso()
    {
        $data['progresso'] = $this->uri->segment(2);
        $data['filename'] = $this->uri->segment(3);
        $data['size'] = $this->uri->segment(4);
        $data['rowcount'] = $this->uri->segment(5);
        $data['insertcount'] = $this->uri->segment(6);
        $data['updatecount'] = $this->uri->segment(7);
        $data['notaddcount'] = $this->uri->segment(8);
        $data['duplicidade'] = $this->uri->segment(9);
        $data['depara'] = $this->uri->segment(10);

        $data['roles'] = $this->user_model->getUserRoles();   

        $this->global['pageTitle'] = 'QUALICAD : Importação TUSS';

        $this->loadViews("qualicad/importacao/importacaoTUSS_progresso", $this->global, $data, NULL);
    }

    public function importaTUSS(){
        $data = array();
        $memData = array();
        $campoNaoLocalizado = '';

        $arrayTmpFiles = array();
        $count=0;
        set_time_limit(1000);

        //    $DePara = $this->ImportacaoModel->consultaDePara('GrupoPro',$this->session->userdata('IdEmpresa'));

        // If import request is submitted
        if($this->input->post('importSubmit')||$this->input->post('progresso') != ''){
            // Form field validation rules
            $this->load->library('form_validation');

            $this->form_validation->set_rules('file', 'CSV file', 'callback_file_check');

            // Validate submitted form data
            if($this->form_validation->run() == true||$this->input->post('progresso') != ''){
                $insertCount = $updateCount = $rowCount = $notAddCount = $duplicidade = 0;

                // If file uploaded
                if(is_uploaded_file($_FILES['file']['tmp_name'])||$this->input->post('progresso') != ''){
                    // Load CSV reader library                

                    if ($this->input->post('progresso') == '') {
                        $arrayTmpFiles = $this->splitCsv($_FILES['file']['tmp_name']);
                        $count = 1;
                        $rowCount = 0;
                        $insertCount = 0;
                        $updateCount = 0;
                        $notAddCount = 0;
                        $duplicidade = 0;
                        $depara = $this->input->post('Tb_Id_LayoutImportacao');
                        $filename = strstr(str_replace('/tmp/', '', $arrayTmpFiles[0]),'_', true);
                        $size = sizeof($arrayTmpFiles);
                        redirect('importacaoTUSS_progresso/'.$count.'/'.$filename.'/'.$size.'/'.$rowCount.'/'.$insertCount.'/'.$updateCount.'/'.$notAddCount.'/'.$duplicidade.'/'.$depara);
                    }

                    $basedir = $_SERVER['DOCUMENT_ROOT'];

                    $this->load->library('CSVReader');

                    $rowCount = $this->input->post('rowcount');
                    $insertCount = $this->input->post('insertcount');
                    $updateCount = $this->input->post('updatecount');
                    $notAddCount = $this->input->post('notaddcount');
                    $duplicidade = $this->input->post('duplicidade');

                    $csvData = $this->csvreader->parse_csv($basedir.'/tmp/'.$this->input->post('filename').'_'.$this->input->post('progresso').'.csv');
                    $dePara = $this->ImportacaoModel->consultaDePara($this->input->post('depara'),'TUSS',$this->session->userdata('IdEmpresa'));

                    $errosDeChave = array();

                    // Insert/update CSV data into database
                    if(!empty($csvData)){
                        foreach($csvData as $row) {
                            $rowCount++;

                            $memData = array();

                            for ($i=0;$i<count($dePara);$i++) {
                                if (!isset($row[(preg_replace('/\s+/', '', $dePara[$i]->No_CampoOrigem))])) {$campoNaoLocalizado = 'true';}
                                if (isset($row[(preg_replace('/\s+/', '', $dePara[$i]->No_CampoOrigem))])) {
                                    if (preg_replace('/\s+/', '', $dePara[$i]->St_Valor) == 'S' || preg_replace('/\s+/', '', $dePara[$i]->St_Data) == 'S') {
                                        if (preg_replace('/\s+/', '', $dePara[$i]->St_Valor) == 'S') {
                                            $memData += array(
                                                (preg_replace('/\s+/', '', $dePara[$i]->No_CampoDestino)) => $this->valor($row[(preg_replace('/\s+/', '', $dePara[$i]->No_CampoOrigem))])
                                            );
                                        }
                                        if (preg_replace('/\s+/', '', $dePara[$i]->St_Data) == 'S') {
                                            $memData += array(
                                                (preg_replace('/\s+/', '', $dePara[$i]->No_CampoDestino)) => $this->data($row[(preg_replace('/\s+/', '', $dePara[$i]->No_CampoOrigem))])
                                            );
                                        }
                                    } else {

                                        $memData += array(
                                            (preg_replace('/\s+/', '', $dePara[$i]->No_CampoDestino)) => $this->data($row[(preg_replace('/\s+/', '', $dePara[$i]->No_CampoOrigem))])
                                        );
                                            
                                    }
                                }
                            }
                            $memData += array( 
                                'TbEmpresa_Id_Empresa'=>$this->session->userdata('IdEmpresa'),                               
                                'CriadoPor'=>$this->vendorId,
                                'Dt_Criacao'=>date('Y-m-d'),
                                'Tp_Ativo'=> 'S');
                               
                            $insert = 0;
                            // ***** VERIFICAÇÕES DE DUPLICIDADE NA ADIÇÃO *****
                            if (isset($memData['TbProFat_Cd_ProFat'])&&isset($memData['TbConvenio_Id_Convenio'])) {
                            if ($this->ImportacaoModel->consultaRegraTbTUSSExistente($memData['TbProFat_Cd_ProFat'],$memData['TbConvenio_Id_Convenio'],$this->session->userdata('IdEmpresa')) != null) {
                                $duplicidade++;
                                } else {
                                $insert = $this->ImportacaoModel->adicionaTUSS($memData);
                                $TbEmpresa_Id_Empresa_Do_CSV = NULL;
                                }
                            }                        
                            // ***** FIM DE VERIFICAÇÕES *****

                            if($insert){
                                $insertCount++;
                            } else {

                              /*  if (isset($memData['TbProFat_Cd_ProFat'])) {
                                    array_push($errosDeChave, $memData['TbProFat_Cd_ProFat']); 
                                } */

                                array_push($errosDeChave, ($rowCount+1)); 

                                $notAddCount++;
                            }

                        }

                     //   var_dump($rowCount);exit;

                        $temp = null;

                        /* DEBUG DE CHAVE NÃO LOCALIZADA */
                        $i = 0;
                        foreach ($errosDeChave as $row) {
                        $i++;
                        if ($i < sizeof($errosDeChave) ) { 
                            $temp .= $row . ', ';
                        } else {
                            $temp .= $row;
                        }
                        }
    
                        $this->session->set_flashdata('errosDeChaveMsg', $temp);
                    //    $this->session->set_flashdata('errosDeChaveMsg', $errosDeChaveMsg);

                        // Status message with imported data count
                        $notAddCount = ($rowCount - ($insertCount + $updateCount));
                        $successMsg = 'Tabela FatItem importada com sucesso! Qtd. Linhas ('.$rowCount.') | Inseridos ('.$insertCount.') | Atualizados ('.$updateCount.') | Não inseridos ('.$notAddCount.') | Duplicidades ('.$duplicidade.')';

                        $this->session->set_flashdata('num_linhas_importadas', $insertCount);
                        if ($campoNaoLocalizado == '') {
                            $successMsg = 'Qtd. Linhas ('.$rowCount.') | Inseridos ('.$insertCount.') | Atualizados ('.$updateCount.') | Não inseridos ('.$notAddCount.') | Duplicidades ('.$duplicidade.')';
                            $this->session->set_flashdata('success', $successMsg);
                        } else {
                            $successMsg = 'Qtd. Linhas ('.$rowCount.') | Inseridos ('.$insertCount.') | Atualizados ('.$updateCount.') | Não inseridos ('.$notAddCount.') | Duplicidades ('.$duplicidade.')
                            <br/><strong>OBS: Algumas colunas do CSV não tem DEPARA cadastrado</strong>';
                            $this->session->set_flashdata('success', $successMsg);
                        }

                    }
                }else{
                    $this->session->set_flashdata('error', 'Erro no upload do arquivo, verifique se é um arquivo CSV válido e tente novamente.');
                    redirect('importacaoTUSS');
                }
            }else{
                $this->session->set_flashdata('error', 'Arquivo inválido! Selecione um arquivo CSV');
                //    $this->session->set_userdata('error_msg', 'Invalid file, please select only CSV file.');
            }
            if ($this->input->post('progresso') != '' && $this->input->post('progresso') <= $this->input->post('size')) {
                $count = $this->input->post('progresso') + 1;
                redirect('importacaoTUSS_progresso/'.$count.'/'.$this->input->post('filename').'/'.$this->input->post('size').'/'.$rowCount.'/'.$insertCount.'/'.$updateCount.'/'.$notAddCount.'/'.$duplicidade.'/'.$this->input->post('depara'));
                } else {  
                    //redirecionar para página de finalização
                    redirect('importacaoTUSS_progresso/completo/'.$this->input->post('filename').'/'.$this->input->post('size').'/'.$rowCount.'/'.$insertCount.'/'.$updateCount.'/'.$notAddCount.'/'.$duplicidade.'/'.$this->input->post('depara'));
                }
            }       
    }

    function apagaImportacaoTUSS()
    {

        $IdTUSS = $this->uri->segment(2);

        $resultado = $this->ImportacaoModel->apagaImportacaoTUSS($IdTUSS);

        if ($resultado > 0) {
            // echo(json_encode(array('status'=>TRUE)));

            $process = 'Exclusão de importação TUSS';
            $processFunction = 'Importacao/apagaImportacaoTUSS';
            $this->logrecord($process,$processFunction);

            if ($resultado === 1451) {
                $this->session->set_flashdata('error', 'Existe associação ativa');
            }
            else {
                $this->session->set_flashdata('success', 'TUSS deletado com sucesso');
            }

        }
        else
        {
            //echo(json_encode(array('status'=>FALSE)));
            $this->session->set_flashdata('error', 'Falha em excluir o TUSS');
        }
        redirect('importacaoTUSS');
    }

    // IMPORTAÇÃO RegraGruPro

    function importacaoRegraGruPro()
    {
        $data['roles'] = $this->user_model->getUserRoles();

        $this->global['pageTitle'] = 'QUALICAD : Importação RegraGruPro';

    //    $data['infoRegraGruPro'] = $this->ImportacaoModel->carregaInfoRegraGruPro($this->session->userdata('IdEmpresa'));
        $data['infoLayoutImportacao'] = $this->ImportacaoModel->carregaInfoLayoutImportacaoEmpresa('RegraGruPro',$this->session->userdata('IdEmpresa'));

        $this->loadViews("qualicad/importacao/importacaoRegraGruPro", $this->global, $data, NULL);
    }

    public function importaRegraGruPro(){
        $data = array();
        $memData = array();

        //    $DePara = $this->ImportacaoModel->consultaDePara('GrupoPro',$this->session->userdata('IdEmpresa'));

        // If import request is submitted
        if($this->input->post('importSubmit')){
            // Form field validation rules
            $this->load->library('form_validation');

            $this->form_validation->set_rules('file', 'CSV file', 'callback_file_check');

            // Validate submitted form data
            if($this->form_validation->run() == true){
                $insertCount = $updateCount = $rowCount = $notAddCount = 0;

                // If file uploaded
                if(is_uploaded_file($_FILES['file']['tmp_name'])){
                    // Load CSV reader library
                    $this->load->library('CSVReader');

                    // Parse data from CSV file
                    $csvData = $this->csvreader->parse_csv($_FILES['file']['tmp_name']);
                    $dePara = $this->ImportacaoModel->consultaDePara($this->input->post('Tb_Id_LayoutImportacao'),'RegraGruPro',$this->session->userdata('IdEmpresa'));

                    $errosDeChave = array();
                    $campoNaoLocalizado = '';

                    // Insert/update CSV data into database
                    if(!empty($csvData)){
                        foreach($csvData as $row) {
                            $rowCount++;

                            $memData = array();

                            for ($i=0;$i<count($dePara);$i++) {
                                if (!isset($row[($dePara[$i]->No_CampoOrigem)])) {$campoNaoLocalizado = 'Algumas colunas do CSV não tem DEPARA cadastrado';}
                                if (isset($row[($dePara[$i]->No_CampoOrigem)])) {
                                    if ($dePara[$i]->St_Valor == 'S' || $dePara[$i]->St_Data == 'S') {
                                        if ($dePara[$i]->St_Valor == 'S') {
                                            $memData += array(
                                                ($dePara[$i]->No_CampoDestino) => $this->valor($row[($dePara[$i]->No_CampoOrigem)])
                                            );
                                        }
                                        if ($dePara[$i]->St_Data == 'S') {
                                            $memData += array(
                                                ($dePara[$i]->No_CampoDestino) => $this->data($row[($dePara[$i]->No_CampoOrigem)])
                                            );
                                        }
                                    } else {
                                        $memData += array(
                                            ($dePara[$i]->No_CampoDestino) => $this->data($row[($dePara[$i]->No_CampoOrigem)])
                                        );
                                    }
                                }
                            }

                            $memData += array(
                                'TbUsuEmp_Id_UsuEmp' => $this->session->userdata('IdUsuEmp'),
                                'TbEmpresa_Id_Empresa'=>$this->session->userdata('IdEmpresa'),
                                'Dt_Criacao'=>date('Y-m-d'),
                                'CriadoPor'=>$this->vendorId,
                                'Tp_Ativo'=> 'S');


                            $insert = $this->ImportacaoModel->adicionaRegraGruPro($memData);

                            if($insert){
                                $insertCount++;
                            } else {
                                array_push($errosDeChave, ($rowCount+1));
                                $notAddCount++;
                            }

                        }

                        $temp = null;

                        /* DEBUG DE CHAVE NÃO LOCALIZADA */
                        $i = 0;
                        foreach ($errosDeChave as $row) {
                        $i++;
                        if ($i < sizeof($errosDeChave) ) { 
                            $temp .= $row . ', ';
                        } else {
                            $temp .= $row;
                        }
                        }

                        $this->session->set_flashdata('errosDeChaveMsg', $temp);

                        // Status message with imported data count
                        $notAddCount = ($rowCount - ($insertCount + $updateCount));
                        $successMsg = 'Tabela RegraGruPro importada com sucesso! Qtd. Linhas ('.$rowCount.') | Inseridos ('.$insertCount.') | Atualizados ('.$updateCount.') | Não inseridos ('.$notAddCount.')';

                        $this->session->set_flashdata('num_linhas_importadas', $insertCount);
                        if ($campoNaoLocalizado == '') {
                            $this->session->set_flashdata('success', $successMsg);
                        } else {
                            $this->session->set_flashdata('error', $campoNaoLocalizado);
                        }
                    }
                }else{
                    $this->session->set_flashdata('error', 'Erro no upload do arquivo, verifique se é um arquivo CSV válido e tente novamente.');
                }
            }else{
                $this->session->set_flashdata('error', 'Arquivo inválido! Selecione um arquivo CSV');
                //    $this->session->set_userdata('error_msg', 'Invalid file, please select only CSV file.');
            }
        }
        redirect('importacaoRegraGruPro');
    }

    function apagaImportacaoRegraGruPro()
    {

        $IdRegraGruPro = $this->uri->segment(2);

        $resultado = $this->ImportacaoModel->apagaImportacaoRegraGruPro($IdRegraGruPro);

        if ($resultado > 0) {
            // echo(json_encode(array('status'=>TRUE)));

            $process = 'Exclusão de importação RegraGruPro';
            $processFunction = 'Importacao/apagaImportacaoRegraGruPro';
            $this->logrecord($process,$processFunction);

            if ($resultado === 1451) {
                $this->session->set_flashdata('error', 'Existe associação ativa');
            }
            else {
                $this->session->set_flashdata('success', 'RegraGruPro deletado com sucesso');
            }

        }
        else
        {
            //echo(json_encode(array('status'=>FALSE)));
            $this->session->set_flashdata('error', 'Falha em excluir o RegraGruPro');
        }
        redirect('importacaoRegraGruPro');
    }

    // IMPORTAÇÃO FracaoSimproBra

    function importacaoFracaoSimproBra()
    {
        $data['roles'] = $this->user_model->getUserRoles();

        $this->global['pageTitle'] = 'QUALICAD : Importação FracaoSimproBra';

    //    $data['infoFracaoSimproBra'] = $this->ImportacaoModel->carregaInfoFracaoSimproBra($this->session->userdata('IdEmpresa'));
        $data['infoLayoutImportacao'] = $this->ImportacaoModel->carregaInfoLayoutImportacaoEmpresa('FracaoSimproBra',$this->session->userdata('IdEmpresa'));

        $this->loadViews("qualicad/importacao/importacaoFracaoSimproBra", $this->global, $data, NULL);
    }

    public function importaFracaoSimproBra(){
        $data = array();
        $memData = array();

        //    $DePara = $this->ImportacaoModel->consultaDePara('GrupoPro',$this->session->userdata('IdEmpresa'));

        // If import request is submitted
        if($this->input->post('importSubmit')){
            // Form field validation rules
            $this->load->library('form_validation');

            $this->form_validation->set_rules('file', 'CSV file', 'callback_file_check');

            // Validate submitted form data
            if($this->form_validation->run() == true){
                $insertCount = $updateCount = $rowCount = $notAddCount = 0;

                // If file uploaded
                if(is_uploaded_file($_FILES['file']['tmp_name'])){
                    // Load CSV reader library
                    $this->load->library('CSVReader');

                    // Parse data from CSV file
                    $csvData = $this->csvreader->parse_csv($_FILES['file']['tmp_name']);
                    $dePara = $this->ImportacaoModel->consultaDePara($this->input->post('Tb_Id_LayoutImportacao'),'FracaoSimproBra',$this->session->userdata('IdEmpresa'));

                    $errosDeChave = array();
                    $campoNaoLocalizado = '';

                    // Insert/update CSV data into database
                    if(!empty($csvData)){
                        foreach($csvData as $row) {
                            $rowCount++;

                            $memData = array();

                            for ($i=0;$i<count($dePara);$i++) {
                                if (!isset($row[(preg_replace('/\s+/', '', $dePara[$i]->No_CampoOrigem))])) {$campoNaoLocalizado = 'true';}
                                if (isset($row[(preg_replace('/\s+/', '', $dePara[$i]->No_CampoOrigem))])) {
                                    if (preg_replace('/\s+/', '', $dePara[$i]->St_Valor) == 'S' || $dePara[$i]->St_Data == 'S') {
                                        if (preg_replace('/\s+/', '', $dePara[$i]->St_Valor) == 'S') {
                                            $memData += array(
                                                (preg_replace('/\s+/', '', $dePara[$i]->No_CampoDestino)) => $this->valor($row[(preg_replace('/\s+/', '', $dePara[$i]->No_CampoOrigem))])
                                            );
                                        }
                                        if (preg_replace('/\s+/', '', $dePara[$i]->St_Data) == 'S') {
                                            $memData += array(
                                                (preg_replace('/\s+/', '', $dePara[$i]->No_CampoDestino)) => $this->data($row[(preg_replace('/\s+/', '', $dePara[$i]->No_CampoOrigem))])
                                            );
                                        }
                                    } else {
                                        $memData += array(
                                            (preg_replace('/\s+/', '', $dePara[$i]->No_CampoDestino)) => $row[(preg_replace('/\s+/', '', $dePara[$i]->No_CampoOrigem))]
                                        );
                                    }
                                }
                            }

                            $memData += array(
                                'TbUsuEmp_Id_UsuEmp' => $this->session->userdata('IdUsuEmp'),
                                'TbEmpresa_Id_Empresa'=>$this->session->userdata('IdEmpresa'),
                                'CriadoPor'=>$this->vendorId,
                                'AtualizadoPor'=>$this->vendorId,
                                'Dt_Criacao'=>date('Y-m-d'),
                                'Tp_Ativo'=> 'S');

                            $insert = 0;
                        
                            // ***** VERIFICAÇÕES DE DUPLICIDADE NA ADIÇÃO *****
                           /* if (isset($memData['CD_TISS'])) {
                            if ($this->ImportacaoModel->consultaRegraTbFracaoSimproBraExistente($memData['CD_TISS'],$memData['TbFatItem_Id_FatItem'],$this->session->userdata('IdEmpresa')) != null) {
                                $duplicidade++;
                                } else {
                                    $insert = $this->ImportacaoModel->adicionaFracaoSimproBra($memData);
                                }
                            }  */          

                            $insert = $this->ImportacaoModel->adicionaFracaoSimproBra($memData);

                            //$insert = $this->ImportacaoModel->adicionaFracaoSimproBra($memData);

                            if($insert){
                                $insertCount++;
                            } else {
                                array_push($errosDeChave, ($rowCount+1));
                                $notAddCount++;
                            }

                        }

                        $temp = null;

                        /* DEBUG DE CHAVE NÃO LOCALIZADA */
                        $i = 0;
                        foreach ($errosDeChave as $row) {
                        $i++;
                        if ($i < sizeof($errosDeChave) ) { 
                            $temp .= $row . ', ';
                        } else {
                            $temp .= $row;
                        }
                        }

                        $this->session->set_flashdata('errosDeChaveMsg', $temp);

                        // Status message with imported data count
                        $notAddCount = ($rowCount - ($insertCount + $updateCount));
                        $successMsg = 'Tabela FracaoSimproBra importada com sucesso! Qtd. Linhas ('.$rowCount.') | Inseridos ('.$insertCount.') | Atualizados ('.$updateCount.') | Não inseridos ('.$notAddCount.')';

                        $this->session->set_flashdata('num_linhas_importadas', $insertCount);
                        if ($campoNaoLocalizado == '') {
                            $successMsg = 'Tabela Contrato importada com sucesso! Qtd. Linhas ('.$rowCount.') | Inseridos ('.$insertCount.') | Atualizados ('.$updateCount.') | Não inseridos ('.$notAddCount.')';
                            $this->session->set_flashdata('success', $successMsg);
                        } else {
                            $successMsg = 'Tabela Contrato importada com sucesso! Qtd. Linhas ('.$rowCount.') | Inseridos ('.$insertCount.') | Atualizados ('.$updateCount.') | Não inseridos ('.$notAddCount.')
                            <br/><strong>OBS: Algumas colunas do CSV não tem DEPARA cadastrado</strong>';
                            $this->session->set_flashdata('success', $successMsg);
                        }
                    }
                }else{
                    $this->session->set_flashdata('error', 'Erro no upload do arquivo, verifique se é um arquivo CSV válido e tente novamente.');
                }
            }else{
                $this->session->set_flashdata('error', 'Arquivo inválido! Selecione um arquivo CSV');
                //    $this->session->set_userdata('error_msg', 'Invalid file, please select only CSV file.');
            }
        }
        redirect('importacaoFracaoSimproBra');
    }

    function apagaImportacaoFracaoSimproBra()
    {

        $IdFracaoSimproBra = $this->uri->segment(2);

        $resultado = $this->ImportacaoModel->apagaImportacaoFracaoSimproBra($IdFracaoSimproBra);

        if ($resultado > 0) {
            // echo(json_encode(array('status'=>TRUE)));

            $process = 'Exclusão de importação Fracao SimproBra';
            $processFunction = 'Importacao/apagaImportacaoFracaoSimproBra';
            $this->logrecord($process,$processFunction);

            if ($resultado === 1451) {
                $this->session->set_flashdata('error', 'Existe associação ativa');
            }
            else {
                $this->session->set_flashdata('success', 'Fração SimproBra deletada com sucesso');
            }

        }
        else
        {
            //echo(json_encode(array('status'=>FALSE)));
            $this->session->set_flashdata('error', 'Falha em excluir Fração SimproBra');
        }
        redirect('importacaoFracaoSimproBra');
    }

    // IMPORTAÇÃO Produto

    function importacaoProduto()
    {
        $data['roles'] = $this->user_model->getUserRoles();

        $this->global['pageTitle'] = 'QUALICAD : Importação Produto';

    //    $data['infoProduto'] = $this->ImportacaoModel->carregaInfoProduto($this->session->userdata('IdEmpresa'));
        $data['infoLayoutImportacao'] = $this->ImportacaoModel->carregaInfoLayoutImportacaoEmpresa('Produto',$this->session->userdata('IdEmpresa'));

        $this->loadViews("qualicad/importacao/importacaoProduto", $this->global, $data, NULL);
    }

    public function importaProduto(){
        $data = array();
        $memData = array();

        //    $DePara = $this->ImportacaoModel->consultaDePara('GrupoPro',$this->session->userdata('IdEmpresa'));

        // If import request is submitted
        if($this->input->post('importSubmit')){
            // Form field validation rules
            $this->load->library('form_validation');

            $this->form_validation->set_rules('file', 'CSV file', 'callback_file_check');

            // Validate submitted form data
            if($this->form_validation->run() == true){
                $insertCount = $updateCount = $rowCount = $notAddCount = $duplicidade = 0;

                // If file uploaded
                if(is_uploaded_file($_FILES['file']['tmp_name'])){
                    // Load CSV reader library
                    $this->load->library('CSVReader');

                    // Parse data from CSV file
                    $csvData = $this->csvreader->parse_csv($_FILES['file']['tmp_name']);
                    $dePara = $this->ImportacaoModel->consultaDePara($this->input->post('Tb_Id_LayoutImportacao'),'Produto',$this->session->userdata('IdEmpresa'));

                    $errosDeChave = array();
                    $campoNaoLocalizado = '';

                    // Insert/update CSV data into database
                    if(!empty($csvData)){
                        foreach($csvData as $row) {
                            $rowCount++;

                            $memData = array();
							
                            for ($i=0;$i<count($dePara);$i++) {
                                if (!isset($row[(preg_replace('/\s+/', '', $dePara[$i]->No_CampoOrigem))])) {$campoNaoLocalizado = 'Algumas colunas do CSV não tem DEPARA cadastrado';}
                                if (isset($row[(preg_replace('/\s+/', '', $dePara[$i]->No_CampoOrigem))])) {
                                    if (preg_replace('/\s+/', '', $dePara[$i]->St_Valor) == 'S' || preg_replace('/\s+/', '', $dePara[$i]->St_Data) == 'S') {
                                        if (preg_replace('/\s+/', '', $dePara[$i]->St_Valor) == 'S') {
                                            $memData += array(
                                                (preg_replace('/\s+/', '', $dePara[$i]->No_CampoDestino)) => $this->valor($row[(preg_replace('/\s+/', '', $dePara[$i]->No_CampoOrigem))])
                                            );
                                        }
                                        if (preg_replace('/\s+/', '', $dePara[$i]->St_Data) == 'S') {
                                            $memData += array(
                                                (preg_replace('/\s+/', '', $dePara[$i]->No_CampoDestino)) => $this->data($row[(preg_replace('/\s+/', '', $dePara[$i]->No_CampoOrigem))])
                                            );
                                        }
                                    } else {
                                        if (preg_replace('/\s+/', '', $dePara[$i]->No_CampoDestino) == 'TbEmpresa_Id_Empresa') {
                                            $memData += array(
                                                (preg_replace('/\s+/', '', $dePara[$i]->No_CampoDestino)) => $this->ImportacaoModel->consultaIdEmpresaPorERP($this->data($row[(preg_replace('/\s+/', '', $dePara[$i]->No_CampoOrigem))]))[0]->Id_Empresa
                                            );   
                                            }
                                            else {
                                            $memData += array(
                                                (preg_replace('/\s+/', '', $dePara[$i]->No_CampoDestino)) => $this->data($row[(preg_replace('/\s+/', '', $dePara[$i]->No_CampoOrigem))])
                                            );
                                            }
                                    }
                                }
                            }

                            $memData += array(
                            //    'TbUsuEmp_Id_UsuEmp' => $this->session->userdata('IdUsuEmp'),
                                'TbEmpresa_Id_Empresa'=>$this->session->userdata('IdEmpresa'),
                                'Dt_Criacao'=>date('Y-m-d'),
                                'CriadoPor'=>$this->vendorId,
                                'Tp_Ativo'=> 'S');

                            $insert = 0;
							
                            // ***** VERIFICAÇÕES DE DUPLICIDADE NA ADIÇÃO *****
                            if (isset($memData['Cd_Produto'])) {
                            if ($this->ImportacaoModel->consultaRegraTbProdutoExistente($memData['Cd_Produto'],$this->session->userdata('IdEmpresa')) != null) {
                                $duplicidade++;
                                } else {
                                    $insert = $this->ImportacaoModel->adicionaProduto($memData);
                                }
                            }                       
                            // ***** FIM DE VERIFICAÇÕES *****

							//$insert = $this->ImportacaoModel->adicionaProduto($memData);
							
                            if($insert){
                                $insertCount++;
                            } else {
                                array_push($errosDeChave, ($rowCount+1));
                                $notAddCount++;
                            }

                        }

                        $temp = null;

                        /* DEBUG DE CHAVE NÃO LOCALIZADA */
                        $i = 0;
                        foreach ($errosDeChave as $row) {
                        $i++;
                        if ($i < sizeof($errosDeChave) ) { 
                            $temp .= $row . ', ';
                        } else {
                            $temp .= $row;
                        }
                        }

                        $this->session->set_flashdata('errosDeChaveMsg', $temp);

                        // Status message with imported data count
                        $notAddCount = ($rowCount - ($insertCount + $updateCount));
                        $successMsg = 'Tabela FatItem importada com sucesso! Qtd. Linhas ('.$rowCount.') | Inseridos ('.$insertCount.') | Atualizados ('.$updateCount.') | Não inseridos ('.$notAddCount.') | Duplicidades ('.$duplicidade.')';

                        $this->session->set_flashdata('num_linhas_importadas', $insertCount);
                        if ($campoNaoLocalizado == '') {
                            $this->session->set_flashdata('success', $successMsg);
                        } else {
                            $this->session->set_flashdata('error', $campoNaoLocalizado);
                        }
                    }
                }else{
                    $this->session->set_flashdata('error', 'Erro no upload do arquivo, verifique se é um arquivo CSV válido e tente novamente.');
                }
            }else{
                $this->session->set_flashdata('error', 'Arquivo inválido! Selecione um arquivo CSV');
                //    $this->session->set_userdata('error_msg', 'Invalid file, please select only CSV file.');
            }
        }
        redirect('importacaoProduto');
    }

    function apagaImportacaoProduto()
    {

        $IdProduto = $this->uri->segment(2);

        $resultado = $this->ImportacaoModel->apagaImportacaoProduto($IdProduto);

        if ($resultado > 0) {
            // echo(json_encode(array('status'=>TRUE)));

            $process = 'Exclusão de importação Produto';
            $processFunction = 'Importacao/apagaImportacaoProduto';
            $this->logrecord($process,$processFunction);

            if ($resultado === 1451) {
                $this->session->set_flashdata('error', 'Existe associação ativa');
            }
            else {
                $this->session->set_flashdata('success', 'Produto deletado com sucesso');
            }

        }
        else
        {
            //echo(json_encode(array('status'=>FALSE)));
            $this->session->set_flashdata('error', 'Falha em excluir Produto');
        }
        redirect('importacaoProduto');
    }

    // IMPORTAÇÃO Produção

    function importacaoProducao()
    {
      //  $data['roles'] = $this->user_model->getUserRoles();

        $this->global['pageTitle'] = 'QUALICAD : Importação Producao';

    //    $data['infoProducao'] = $this->ImportacaoModel->carregaInfoProducao($this->session->userdata('IdEmpresa'));
        $data['infoLayoutImportacao'] = $this->ImportacaoModel->carregaInfoLayoutImportacaoEmpresa('Producao',$this->session->userdata('IdEmpresa'));

        $this->loadViews("qualicad/importacao/importacaoProducao", $this->global, $data, NULL);
    }

    public function importaProducao(){
        $data = array();
        $memData = array();

        //    $DePara = $this->ImportacaoModel->consultaDePara('GrupoPro',$this->session->userdata('IdEmpresa'));

        // If import request is submitted
        if($this->input->post('importSubmit')){
            // Form field validation rules
            $this->load->library('form_validation');

            $this->form_validation->set_rules('file', 'CSV file', 'callback_file_check');

            // Validate submitted form data
            if($this->form_validation->run() == true){
                $insertCount = $updateCount = $rowCount = $notAddCount = $duplicidade = 0;

                // If file uploaded
                if(is_uploaded_file($_FILES['file']['tmp_name'])){
                    // Load CSV reader library
                    $this->load->library('CSVReader');

                    // Parse data from CSV file
                    $csvData = $this->csvreader->parse_csv($_FILES['file']['tmp_name']);
                    $dePara = $this->ImportacaoModel->consultaDePara($this->input->post('Tb_Id_LayoutImportacao'),'Producao',$this->session->userdata('IdEmpresa'));

                    $errosDeChave = array();
                    $campoNaoLocalizado = '';

                    // Insert/update CSV data into database
                    if(!empty($csvData)){
                        foreach($csvData as $row) {
                            $rowCount++;

                            $memData = array();

                            for ($i=0;$i<count($dePara);$i++) {
                                if (!isset($row[(preg_replace('/\s+/', '', $dePara[$i]->No_CampoOrigem))])) {$campoNaoLocalizado = 'Algumas colunas do CSV não tem DEPARA cadastrado';}
                                if (isset($row[(preg_replace('/\s+/', '', $dePara[$i]->No_CampoOrigem))])) {
                                    if (preg_replace('/\s+/', '', $dePara[$i]->St_Valor) == 'S' || preg_replace('/\s+/', '', $dePara[$i]->St_Data) == 'S') {
                                        if (preg_replace('/\s+/', '', $dePara[$i]->St_Valor) == 'S') {
                                            $memData += array(
                                                (preg_replace('/\s+/', '', $dePara[$i]->No_CampoDestino)) => $this->valor($row[(preg_replace('/\s+/', '', $dePara[$i]->No_CampoOrigem))])
                                            );
                                        }
                                        if (preg_replace('/\s+/', '', $dePara[$i]->St_Data) == 'S') {
                                            $memData += array(
                                                (preg_replace('/\s+/', '', $dePara[$i]->No_CampoDestino)) => $this->data($row[(preg_replace('/\s+/', '', $dePara[$i]->No_CampoOrigem))])
                                            );
                                        }
                                    } else {
                                        if (preg_replace('/\s+/', '', $dePara[$i]->No_CampoDestino) == 'TbEmpresa_Id_Empresa') {
                                            $memData += array(
                                                (preg_replace('/\s+/', '', $dePara[$i]->No_CampoDestino)) => $this->ImportacaoModel->consultaIdEmpresaPorERP($this->data($row[(preg_replace('/\s+/', '', $dePara[$i]->No_CampoOrigem))]))[0]->Id_Empresa
                                            );   
                                            }
                                            else {
                                            $memData += array(
                                                (preg_replace('/\s+/', '', $dePara[$i]->No_CampoDestino)) => $this->data($row[(preg_replace('/\s+/', '', $dePara[$i]->No_CampoOrigem))])
                                            );
                                            }
                                    }
                                }
                            }

                            $memData += array(
                            //    'TbUsuEmp_Id_UsuEmp' => $this->session->userdata('IdUsuEmp'),
                                'TbEmpresa_Id_Empresa'=>$this->session->userdata('IdEmpresa'),
                                'Dt_Criacao'=>date('Y-m-d'),
                                'CriadoPor'=>$this->vendorId,
							//	'TbContrato_Id_Contrato'=>12,
							//	'TbContrato_Cd_Convenio'=>12,
							//	'TbContrato_Cd_PlanoERP'=>12,
                                'Tp_Ativo'=> 'S');
                            
                            $insert = 0;
                        /*    // ***** VERIFICAÇÕES DE DUPLICIDADE NA ADIÇÃO *****
                            if (isset($memData['TbProFat_Cd_ProFat'])&&isset($memData['Dt_Lancamento'])&&isset($memData['TbPlano_Id_Plano'])) {
                            if ($this->ImportacaoModel->consultaRegraTbProducaoExistente($memData['TbProFat_Cd_ProFat'],$memData['Dt_Lancamento'],$memData['TbPlano_Id_Plano'],$this->session->userdata('IdEmpresa')) != null) {
                                $duplicidade++;
                                } else {
                                    $insert = $this->ImportacaoModel->adicionaProducao($memData);
                                }
                            }                        
                            // ***** FIM DE VERIFICAÇÕES ***** */

                            $insert = $this->ImportacaoModel->adicionaProducao($memData);

                            if($insert){
                                $insertCount++;
                            } else {
                                array_push($errosDeChave, ($rowCount+1));
                                $notAddCount++;
                            }

                        }

                        $temp = null;

                        /* DEBUG DE CHAVE NÃO LOCALIZADA */
                        $i = 0;
                        foreach ($errosDeChave as $row) {
                        $i++;
                        if ($i < sizeof($errosDeChave) ) { 
                            $temp .= $row . ', ';
                        } else {
                            $temp .= $row;
                        }
                        }

                        $this->session->set_flashdata('errosDeChaveMsg', $temp);

                        // Status message with imported data count
                        $notAddCount = ($rowCount - ($insertCount + $updateCount));
                        $successMsg = 'Tabela FatItem importada com sucesso! Qtd. Linhas ('.$rowCount.') | Inseridos ('.$insertCount.') | Atualizados ('.$updateCount.') | Não inseridos ('.$notAddCount.') | Duplicidades ('.$duplicidade.')';

                        $this->session->set_flashdata('num_linhas_importadas', $insertCount);
                        if ($campoNaoLocalizado == '') {
                            $this->session->set_flashdata('success', $successMsg);
                        } else {
                            $this->session->set_flashdata('error', $campoNaoLocalizado);
                        }
                    }
                }else{
                    $this->session->set_flashdata('error', 'Erro no upload do arquivo, verifique se é um arquivo CSV válido e tente novamente.');
                }
            }else{
                $this->session->set_flashdata('error', 'Arquivo inválido! Selecione um arquivo CSV');
                //    $this->session->set_userdata('error_msg', 'Invalid file, please select only CSV file.');
            }
        }
        redirect('importacaoProducao');
    }

    function apagaImportacaoProducao()
    {

        $IdProducao = $this->uri->segment(2);

        $resultado = $this->ImportacaoModel->apagaImportacaoProducao($IdProducao);

        if ($resultado > 0) {
            // echo(json_encode(array('status'=>TRUE)));

            $process = 'Exclusão de importação Produção';
            $processFunction = 'Importacao/apagaImportacaoProducao';
            $this->logrecord($process,$processFunction);

            if ($resultado === 1451) {
                $this->session->set_flashdata('error', 'Existe associação ativa');
            }
            else {
                $this->session->set_flashdata('success', 'Produção deletada com sucesso');
            }

        }
        else
        {
            //echo(json_encode(array('status'=>FALSE)));
            $this->session->set_flashdata('error', 'Falha em excluir Produção');
        }
        redirect('importacaoProducao');
    }

    // IMPORTAÇÃO Contrato

    function importacaoContrato()
    {
        $data['roles'] = $this->user_model->getUserRoles();

        $this->global['pageTitle'] = 'QUALICAD : Importação Contrato';

    //    $data['infoContrato'] = $this->ImportacaoModel->carregaInfoContrato($this->session->userdata('IdEmpresa'));
        $data['infoLayoutImportacao'] = $this->ImportacaoModel->carregaInfoLayoutImportacaoEmpresa('Contrato',$this->session->userdata('IdEmpresa'));

        $this->loadViews("qualicad/importacao/importacaoContrato", $this->global, $data, NULL);
    }

    function importacaoContrato_progresso()
    {
        $data['progresso'] = $this->uri->segment(2);
        $data['filename'] = $this->uri->segment(3);
        $data['size'] = $this->uri->segment(4);
        $data['rowcount'] = $this->uri->segment(5);
        $data['insertcount'] = $this->uri->segment(6);
        $data['updatecount'] = $this->uri->segment(7);
        $data['notaddcount'] = $this->uri->segment(8);
        $data['duplicidade'] = $this->uri->segment(9);
        $data['depara'] = $this->uri->segment(10);

        $data['roles'] = $this->user_model->getUserRoles();   

        $this->global['pageTitle'] = 'QUALICAD : Importação Contrato';

        $this->loadViews("qualicad/importacao/importacaoContrato_progresso", $this->global, $data, NULL);
    }

    public function importaContrato(){

        $data = array();
        $memData = array();
        $campoNaoLocalizado = '';

        $arrayTmpFiles = array();
        $count=0;
        set_time_limit(1000);

        //    $DePara = $this->ImportacaoModel->consultaDePara('GrupoPro',$this->session->userdata('IdEmpresa'));

        // If import request is submitted
        if($this->input->post('importSubmit')||$this->input->post('progresso') != ''){
            // Form field validation rules
            $this->load->library('form_validation');

            $this->form_validation->set_rules('file', 'CSV file', 'callback_file_check');

            // Validate submitted form data
            if($this->form_validation->run() == true||$this->input->post('progresso') != ''){
                $insertCount = $updateCount = $rowCount = $notAddCount = 0;

                // If file uploaded
                if(is_uploaded_file($_FILES['file']['tmp_name'])||$this->input->post('progresso') != ''){
                    // Load CSV reader library                

                    if ($this->input->post('progresso') == '') {
                        $arrayTmpFiles = $this->splitCsv($_FILES['file']['tmp_name']);
                        $count = 1;
                        $rowCount = 0;
                        $insertCount = 0;
                        $updateCount = 0;
                        $notAddCount = 0;
                        $duplicidade = 0;
                        $depara = $this->input->post('Tb_Id_LayoutImportacao');
                        $filename = strstr(str_replace('/tmp/', '', $arrayTmpFiles[0]),'_', true);
                        $size = sizeof($arrayTmpFiles);
                        redirect('importacaoContrato_progresso/'.$count.'/'.$filename.'/'.$size.'/'.$rowCount.'/'.$insertCount.'/'.$updateCount.'/'.$notAddCount.'/'.$duplicidade.'/'.$depara);
                    }

                    $basedir = $_SERVER['DOCUMENT_ROOT'];

                    $this->load->library('CSVReader');

                    $rowCount = $this->input->post('rowcount');
                    $insertCount = $this->input->post('insertcount');
                    $updateCount = $this->input->post('updatecount');
                    $notAddCount = $this->input->post('notaddcount');
                    $duplicidade = $this->input->post('duplicidade');

                    $csvData = $this->csvreader->parse_csv($basedir.'/tmp/'.$this->input->post('filename').'_'.$this->input->post('progresso').'.csv');
                    $dePara = $this->ImportacaoModel->consultaDePara($this->input->post('depara'),'Contrato',$this->session->userdata('IdEmpresa'));

                    $errosDeChave = array();

                    // Insert/update CSV data into database
                    if(!empty($csvData)){
                        foreach($csvData as $row) {
                            $rowCount++;

                            $memData = array();

                            for ($i=0;$i<count($dePara);$i++) {                              
                                if (!isset($row[(preg_replace('/\s+/', '', $dePara[$i]->No_CampoOrigem))])) {$campoNaoLocalizado = 'true';}
                                if (isset($row[(preg_replace('/\s+/', '', $dePara[$i]->No_CampoOrigem))])) {
                                    if (preg_replace('/\s+/', '', $dePara[$i]->St_Valor) == 'S' || $dePara[$i]->St_Data == 'S') {
                                        if (preg_replace('/\s+/', '', $dePara[$i]->St_Valor) == 'S') {
                                            $memData += array(
                                                (preg_replace('/\s+/', '', $dePara[$i]->No_CampoDestino)) => $this->valor($row[(preg_replace('/\s+/', '', $dePara[$i]->No_CampoOrigem))])
                                            );
                                        }
                                        if (preg_replace('/\s+/', '', $dePara[$i]->St_Data) == 'S') {
                                            $memData += array(
                                                (preg_replace('/\s+/', '', $dePara[$i]->No_CampoDestino)) => $this->data($row[(preg_replace('/\s+/', '', $dePara[$i]->No_CampoOrigem))])
                                            );
                                        }
                                    } else {
                                        $memData += array(
                                            (preg_replace('/\s+/', '', $dePara[$i]->No_CampoDestino)) => $this->data($row[(preg_replace('/\s+/', '', $dePara[$i]->No_CampoOrigem))])
                                        );
                                    }
                                }
                            }

                            $memData += array(
                            //    'TbUsuEmp_Id_UsuEmp' => $this->session->userdata('IdUsuEmp'),
                                'TbEmpresa_Id_Empresa'=>$this->session->userdata('IdEmpresa'),
                                'CriadoPor'=>$this->vendorId,
                                'Dt_Criacao'=>date('Y-m-d'),
                                'Tp_Ativo'=> 'S');                           

                            $insert = $this->ImportacaoModel->adicionaContrato($memData);

                            if($insert){
                                $insertCount++;
                            } else {
                                array_push($errosDeChave, ($rowCount+1));
                                $notAddCount++;
                            }

                        }

                        $temp = null;

                        /* DEBUG DE CHAVE NÃO LOCALIZADA */
                        $i = 0;
                        foreach ($errosDeChave as $row) {
                        $i++;
                        if ($i < sizeof($errosDeChave) ) { 
                            $temp .= $row . ', ';
                        } else {
                            $temp .= $row;
                        }
                        }

                        $this->session->set_flashdata('errosDeChaveMsg', $temp);

                        // Status message with imported data count
                        $notAddCount = ($rowCount - ($insertCount + $updateCount));
                        $successMsg = 'Tabela Contrato importada com sucesso! Qtd. Linhas ('.$rowCount.') | Inseridos ('.$insertCount.') | Atualizados ('.$updateCount.') | Não inseridos ('.$notAddCount.')';

                        $this->session->set_flashdata('num_linhas_importadas', $insertCount);
                        if ($campoNaoLocalizado == '') {
                            $successMsg = 'Tabela Contrato importada com sucesso! Qtd. Linhas ('.$rowCount.') | Inseridos ('.$insertCount.') | Atualizados ('.$updateCount.') | Não inseridos ('.$notAddCount.')';
                            $this->session->set_flashdata('success', $successMsg);
                        } else {
                            $successMsg = 'Tabela Contrato importada com sucesso! Qtd. Linhas ('.$rowCount.') | Inseridos ('.$insertCount.') | Atualizados ('.$updateCount.') | Não inseridos ('.$notAddCount.')
                            <br/><strong>OBS: Algumas colunas do CSV não tem DEPARA cadastrado</strong>';
                            $this->session->set_flashdata('success', $successMsg);
                        }
                    }
                }
            }else{
                $this->session->set_flashdata('error', 'Erro no upload do arquivo, verifique se é um arquivo CSV válido e tente novamente.');
                redirect('importacaoContrato');
            }
        }else{
            $this->session->set_flashdata('error', 'Arquivo inválido! Selecione um arquivo CSV');
            //    $this->session->set_userdata('error_msg', 'Invalid file, please select only CSV file.');
        }

    if ($this->input->post('progresso') != '' && $this->input->post('progresso') <= $this->input->post('size')) {
        $count = $this->input->post('progresso') + 1;
        redirect('importacaoContrato_progresso/'.$count.'/'.$this->input->post('filename').'/'.$this->input->post('size').'/'.$rowCount.'/'.$insertCount.'/'.$updateCount.'/'.$notAddCount.'/'.$duplicidade.'/'.$this->input->post('depara'));
        } else {  
            //redirecionar para página de finalização
            redirect('importacaoContrato_progresso/completo/'.$this->input->post('filename').'/'.$this->input->post('size').'/'.$rowCount.'/'.$insertCount.'/'.$updateCount.'/'.$notAddCount.'/'.$duplicidade.'/'.$this->input->post('depara'));
        }
    }


    function importacaoDePara()
    {
            $tpTela = $this->uri->segment(2);

            $data['perfis'] = $this->CadastroModel->carregaPerfisUsuarios();

            if ($tpTela == 'listar') {

                if ($this->session->userdata('isAdmin') != 'S')
                    {             
                    redirect('telaNaoAutorizada');
                    }

                $searchText = $this->security->xss_clean($this->input->post('searchText'));
                $data['searchText'] = $searchText;
                
                $this->load->library('pagination');
                
                $count = $this->CadastroModel->userListingCount($searchText);

                $returns = $this->paginationCompress ( "importacaoDePara/listar", $count, 300 );
                
                $data['registrosDePara'] = $this->ImportacaoModel->listaDePara($this->session->userdata('IdEmpresa'), $searchText, $returns["page"], $returns["segment"]);
                
                $process = 'Listar DePara';
                $processFunction = 'Importacao/importacaoDePara';
                $this->logrecord($process,$processFunction);

                $this->global['pageTitle'] = 'QUALICAD : Lista de Plano';
                
                $this->loadViews("qualicad/importacao/l_deParaImportacao", $this->global, $data, NULL);
            }
            else if ($tpTela == 'cadastrar') {

                if ($this->session->userdata('isAdmin') != 'S')
                    {             
                    redirect('telaNaoAutorizada');
                    }

                $data['infoLayoutImportacao'] = $this->ImportacaoModel->carregaInfoLayoutImportacaoEmpresa('todos',$this->session->userdata('IdEmpresa'));

                $this->global['pageTitle'] = 'QUALICAD : Cadastro de DePara';
                $this->loadViews("qualicad/importacao/c_deParaImportacao", $this->global, $data, NULL); 
            }
            else if ($tpTela == 'editar') {

                if ($this->session->userdata('isAdmin') != 'S')
                    {             
                    redirect('telaNaoAutorizada');
                    }

                $IdDePara = $this->uri->segment(3);
                if($IdDePara == null)
                {
                    redirect('importacaoDePara/listar');
                }
                $data['infoDePara'] = $this->ImportacaoModel->carregaInfoDeParaId($IdDePara);
                $data['infoLayoutImportacao'] = $this->ImportacaoModel->carregaInfoLayoutImportacaoEmpresa('todos',$this->session->userdata('IdEmpresa'));

                $this->global['pageTitle'] = 'QUALICAD : Editar DePara';      
                $this->loadViews("qualicad/importacao/c_deParaImportacao", $this->global, $data, NULL);
            }
    }

    function adicionaDePara() 
    {
            if (array_key_exists('IrLista',$this->input->post())) {
                redirect('importacaoDePara/listar'); 
            } 

            $Tb_Id_LayoutImportacao = $this->input->post('Tb_Id_LayoutImportacao');
            $No_Importacao = $this->ImportacaoModel->consultaNoImportacao($Tb_Id_LayoutImportacao,$this->session->userdata('IdEmpresa'))[0]->No_Importacao;
            $No_Tabela = $this->input->post('No_Tabela');
            $No_CampoOrigem = $this->input->post('No_CampoOrigem');
            $No_CampoDestino  = $this->input->post('No_CampoDestino');
            $St_Valor  = $this->input->post('St_Valor');
            $Tp_Ativo = $this->input->post('Tp_Ativo');

            //    $roleId = $this->input->post('role');

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

                $infoDePara = array('Tb_Id_LayoutImportacao'=>$Tb_Id_LayoutImportacao, 'No_Importacao'=>$No_Importacao,  'TbEmpresa_Id_Empresa'=>$this->session->userdata('IdEmpresa'),
                    'No_Tabela'=>$No_Tabela, 'No_CampoOrigem'=> $No_CampoOrigem, 'No_CampoDestino'=> $No_CampoDestino,
                    'CriadoPor'=>$this->vendorId, 'AtualizadoPor'=>$this->vendorId, 'St_Valor'=>$St_Valor,
                    'Tp_Ativo'=>$Tp_Ativo, 'Dt_Ativo'=>$Dt_Ativo);

                $result = $this->ImportacaoModel->adicionaDePara($infoDePara);

                if($result > 0)
                {
                    $process = 'Adicionar DePara';
                    $processFunction = 'Importacao/adicionaDePara';
                    $this->logrecord($process,$processFunction);

                    $this->session->set_flashdata('success', 'DePara criado com sucesso');

                    if (array_key_exists('salvarIrLista',$this->input->post())) {
                        redirect('importacaoDePara/listar'); 
                    }
                    else if (array_key_exists('salvarMesmaTela',$this->input->post())) {
                        redirect('importacaoDePara/cadastrar'); 
                    }
                    else if (array_key_exists('salvarRetroceder',$this->input->post())) {
                        redirect('importacaoDePara/cadastrar');
                    }

                }
                else
                {
                    $this->session->set_flashdata('error', 'Falha na criação do DePara');
                }

          //  } else {
            //    $this->session->set_flashdata('error', 'Convênio já foi cadastrado!');
          //  }

            redirect('importacaoDePara/cadastrar');
    }

    // IMPORTAÇÃO VALOR PORTE MÉDICO

    function importacaoPorteMedico()
    {
        $data['roles'] = $this->user_model->getUserRoles();

        $this->global['pageTitle'] = 'QUALICAD : Importação Porte Médico';

        //$data['infoPorteMedico'] = $this->ImportacaoModel->carregaInfoPorteMedico($this->session->userdata('IdEmpresa'));
        $data['infoLayoutImportacao'] = $this->ImportacaoModel->carregaInfoLayoutImportacaoEmpresa('PorteMedico',$this->session->userdata('IdEmpresa'));

        $this->loadViews("qualicad/importacao/importacaoPorteMedico", $this->global, $data, NULL);
    }

    public function importaPorteMedico(){
        $data = array();
        $memData = array();

        //    $DePara = $this->ImportacaoModel->consultaDePara('GrupoPro',$this->session->userdata('IdEmpresa'));

        // If import request is submitted
        if($this->input->post('importSubmit')){
            // Form field validation rules
            $this->load->library('form_validation');

            $this->form_validation->set_rules('file', 'CSV file', 'callback_file_check');

            // Validate submitted form data
            if($this->form_validation->run() == true){
                $insertCount = $updateCount = $rowCount = $notAddCount = 0;

                // If file uploaded
                if(is_uploaded_file($_FILES['file']['tmp_name'])){
                    // Load CSV reader library
                    $this->load->library('CSVReader');

                    // Parse data from CSV file
                    $csvData = $this->csvreader->parse_csv($_FILES['file']['tmp_name']);
                    $dePara = $this->ImportacaoModel->consultaDePara($this->input->post('Tb_Id_LayoutImportacao'),'PorteMedico',$this->session->userdata('IdEmpresa'));

                    $errosDeChave = array();
                    $campoNaoLocalizado = '';

                    // Insert/update CSV data into database
                    if(!empty($csvData)){
                        foreach($csvData as $row) {
                            $rowCount++;

                            $memData = array();

                            for ($i=0;$i<count($dePara);$i++) {
                                if (!isset($row[($dePara[$i]->No_CampoOrigem)])) {$campoNaoLocalizado = 'Algumas colunas do CSV não tem DEPARA cadastrado';}
                                if (isset($row[($dePara[$i]->No_CampoOrigem)])) {
                                    if ($dePara[$i]->St_Valor == 'S' || $dePara[$i]->St_Data == 'S') {
                                        if ($dePara[$i]->St_Valor == 'S') {
                                            $memData += array(
                                                ($dePara[$i]->No_CampoDestino) => $this->valor($row[($dePara[$i]->No_CampoOrigem)])
                                            );
                                        }
                                        if ($dePara[$i]->St_Data == 'S') {
                                            $memData += array(
                                                ($dePara[$i]->No_CampoDestino) => $this->data($row[($dePara[$i]->No_CampoOrigem)])
                                            );
                                        }
                                    } else {
                                        $memData += array(
                                            ($dePara[$i]->No_CampoDestino) => $this->data($row[($dePara[$i]->No_CampoOrigem)])
                                        );
                                    }
                                }
                            }

                            $memData += array(
                            //    'TbUsuEmp_Id_UsuEmp' => $this->session->userdata('IdUsuEmp'),
                                'TbEmpresa_Id_Empresa'=>$this->session->userdata('IdEmpresa'),
                                'CriadoPor'=>$this->vendorId,
                                'AtualizadoPor'=>$this->vendorId,
                                'Dt_Criacao'=>date('Y-m-d'),
                                'Tp_Ativo'=> 'S');

                            $insert = $this->ImportacaoModel->adicionaPorteMedico($memData);

                            if($insert){
                                $insertCount++;
                            } else {
                                array_push($errosDeChave, ($rowCount+1));
                                $notAddCount++;
                            }

                        }

                        $temp = null;

                        /* DEBUG DE CHAVE NÃO LOCALIZADA */
                        $i = 0;
                        foreach ($errosDeChave as $row) {
                        $i++;
                        if ($i < sizeof($errosDeChave) ) { 
                            $temp .= $row . ', ';
                        } else {
                            $temp .= $row;
                        }
                        }

                        $this->session->set_flashdata('errosDeChaveMsg', $temp);

                        // Status message with imported data count
                        $notAddCount = ($rowCount - ($insertCount + $updateCount));
                        $successMsg = 'Tabela Porte Médico importada com sucesso! Qtd. Linhas ('.$rowCount.') | Inseridos ('.$insertCount.') | Atualizados ('.$updateCount.') | Não inseridos ('.$notAddCount.')';

                        $this->session->set_flashdata('num_linhas_importadas', $insertCount);
                        if ($campoNaoLocalizado == '') {
                            $this->session->set_flashdata('success', $successMsg);
                        } else {
                            $this->session->set_flashdata('error', $campoNaoLocalizado);
                        }
                    }
                }else{
                    $this->session->set_flashdata('error', 'Erro no upload do arquivo, verifique se é um arquivo CSV válido e tente novamente.');
                }
            }else{
                $this->session->set_flashdata('error', 'Arquivo inválido! Selecione um arquivo CSV');
                //    $this->session->set_userdata('error_msg', 'Invalid file, please select only CSV file.');
            }
        }
        redirect('importacaoPorteMedico');
    }

    function apagaImportacaoPorteMedico()
    {

        $IdPorteMedico = $this->uri->segment(2);

        $resultado = $this->ImportacaoModel->apagaImportacaoPorteMedico($IdPorteMedico);

        if ($resultado > 0) {
            // echo(json_encode(array('status'=>TRUE)));

            $process = 'Exclusão de importação Porte Médico';
            $processFunction = 'Importacao/apagaImportacaoPorteMedico';
            $this->logrecord($process,$processFunction);

            if ($resultado === 1451) {
                $this->session->set_flashdata('error', 'Existe associação ativa');
            }
            else {
                $this->session->set_flashdata('success', 'Porte Médico deletado com sucesso');
            }

        }
        else
        {
            //echo(json_encode(array('status'=>FALSE)));
            $this->session->set_flashdata('error', 'Falha em excluir Porte Médico');
        }
        redirect('importacaoPorteMedico');
    }


    // IMPORTAÇÃO EXCEÇÃO VALORES

    function importacaoExcecaoValores()
    {
        $data['roles'] = $this->user_model->getUserRoles();

        $this->global['pageTitle'] = 'QUALICAD : Importação Exceção Valores';

       // $data['infoExcecaoValores'] = $this->ImportacaoModel->carregaInfoExcecaoValores($this->session->userdata('IdEmpresa'));
        $data['infoLayoutImportacao'] = $this->ImportacaoModel->carregaInfoLayoutImportacaoEmpresa('ExcecaoValores',$this->session->userdata('IdEmpresa'));

        $this->loadViews("qualicad/importacao/importacaoExcecaoValores", $this->global, $data, NULL);
    }

    public function importaExcecaoValores(){
        $data = array();
        $memData = array();

        //    $DePara = $this->ImportacaoModel->consultaDePara('GrupoPro',$this->session->userdata('IdEmpresa'));

        // If import request is submitted
        if($this->input->post('importSubmit')){
            // Form field validation rules
            $this->load->library('form_validation');

            $this->form_validation->set_rules('file', 'CSV file', 'callback_file_check');

            // Validate submitted form data
            if($this->form_validation->run() == true){
                $insertCount = $updateCount = $rowCount = $notAddCount = $duplicidade = 0;

                // If file uploaded
                if(is_uploaded_file($_FILES['file']['tmp_name'])){
                    // Load CSV reader library
                    $this->load->library('CSVReader');

                    // Parse data from CSV file
                    $csvData = $this->csvreader->parse_csv($_FILES['file']['tmp_name']);
                    $dePara = $this->ImportacaoModel->consultaDePara($this->input->post('Tb_Id_LayoutImportacao'),'ExcecaoValores',$this->session->userdata('IdEmpresa'));

                    $errosDeChave = array();
                    $campoNaoLocalizado = '';

                    // Insert/update CSV data into database
                    if(!empty($csvData)){
                        foreach($csvData as $row) {
                            $rowCount++;

                            $memData = array();

                            for ($i=0;$i<count($dePara);$i++) {
                                if (!isset($row[(preg_replace('/\s+/', '', $dePara[$i]->No_CampoOrigem))])) {$campoNaoLocalizado = 'true';}
                                if (isset($row[(preg_replace('/\s+/', '', $dePara[$i]->No_CampoOrigem))])) {
                                    if (preg_replace('/\s+/', '', $dePara[$i]->St_Valor) == 'S' || $dePara[$i]->St_Data == 'S') {
                                        if (preg_replace('/\s+/', '', $dePara[$i]->St_Valor) == 'S') {
                                            $memData += array(
                                                (preg_replace('/\s+/', '', $dePara[$i]->No_CampoDestino)) => $this->valor($row[(preg_replace('/\s+/', '', $dePara[$i]->No_CampoOrigem))])
                                            );
                                        }
                                        if (preg_replace('/\s+/', '', $dePara[$i]->St_Data) == 'S') {
                                            $memData += array(
                                                (preg_replace('/\s+/', '', $dePara[$i]->No_CampoDestino)) => $this->data($row[(preg_replace('/\s+/', '', $dePara[$i]->No_CampoOrigem))])
                                            );
                                        }
                                    } else {
                                        $memData += array(
                                            (preg_replace('/\s+/', '', $dePara[$i]->No_CampoDestino)) => $this->data($row[(preg_replace('/\s+/', '', $dePara[$i]->No_CampoOrigem))])
                                        );
                                    }
                                }
                            }

                            $memData += array(
                                'TbEmpresa_Id_Empresa'=>$this->session->userdata('IdEmpresa'),
                                'CriadoPor'=>$this->vendorId,
                                'AtualizadoPor'=>$this->vendorId,
                                'Dt_Criacao'=>date('Y-m-d'),
                                'Tp_Ativo'=> 'S');

                            $insert = 0;
                            // ***** VERIFICAÇÕES DE DUPLICIDADE NA ADIÇÃO *****
                         /*   if (isset($memData['Cd_TUSS'])&&isset($memData['Cd_ProFat'])&&isset($memData['CD_Convenio'])) {
                            if ($this->ImportacaoModel->consultaRegraTbExcValoresExistente($memData['Cd_TUSS'],$memData['Cd_ProFat'],$memData['CD_Convenio'],$this->session->userdata('IdEmpresa')) != null) {
                                $duplicidade++;
                                } else { */
                                    $insert = $this->ImportacaoModel->adicionaExcecaoValores($memData);
                         /*       }
                            }     */                   
                            // ***** FIM DE VERIFICAÇÕES *****

                            if($insert){
                                $insertCount++;
                            } else {
                                array_push($errosDeChave, ($rowCount+1));
                                $notAddCount++;
                            }

                        }

                        $temp = null;

                        /* DEBUG DE CHAVE NÃO LOCALIZADA */
                        $i = 0;
                        foreach ($errosDeChave as $row) {
                        $i++;
                        if ($i < sizeof($errosDeChave) ) { 
                            $temp .= $row . ', ';
                        } else {
                            $temp .= $row;
                        }
                        }

                        $this->session->set_flashdata('errosDeChaveMsg', $temp);

                        // Status message with imported data count
                        $notAddCount = ($rowCount - ($insertCount + $updateCount));
                        $successMsg = 'Tabela FatItem importada com sucesso! Qtd. Linhas ('.$rowCount.') | Inseridos ('.$insertCount.') | Atualizados ('.$updateCount.') | Não inseridos ('.$notAddCount.') | Duplicidades ('.$duplicidade.')';

                        $this->session->set_flashdata('num_linhas_importadas', $insertCount);
                        if ($campoNaoLocalizado == '') {
                            $successMsg = 'Tabela Contrato importada com sucesso! Qtd. Linhas ('.$rowCount.') | Inseridos ('.$insertCount.') | Atualizados ('.$updateCount.') | Não inseridos ('.$notAddCount.')';
                            $this->session->set_flashdata('success', $successMsg);
                        } else {
                            $successMsg = 'Tabela Contrato importada com sucesso! Qtd. Linhas ('.$rowCount.') | Inseridos ('.$insertCount.') | Atualizados ('.$updateCount.') | Não inseridos ('.$notAddCount.')
                            <br/><strong>OBS: Algumas colunas do CSV não tem DEPARA cadastrado</strong>';
                            $this->session->set_flashdata('success', $successMsg);
                        }
                    }
                }else{
                    $this->session->set_flashdata('error', 'Erro no upload do arquivo, verifique se é um arquivo CSV válido e tente novamente.');
                }
            }else{
                $this->session->set_flashdata('error', 'Arquivo inválido! Selecione um arquivo CSV');
                //    $this->session->set_userdata('error_msg', 'Invalid file, please select only CSV file.');
            }
        }
        redirect('importacaoExcecaoValores');
    }

    function apagaImportacaoExcecaoValores()
    {

        $IdExcecaoValores = $this->uri->segment(2);

        $resultado = $this->ImportacaoModel->apagaImportacaoExcecaoValores($IdExcecaoValores);

        if ($resultado > 0) {
            // echo(json_encode(array('status'=>TRUE)));

            $process = 'Exclusão de importação Exceção Valores';
            $processFunction = 'Importacao/apagaImportacaoExcecaoValores';
            $this->logrecord($process,$processFunction);

            if ($resultado === 1451) {
                $this->session->set_flashdata('error', 'Existe associação ativa');
            }
            else {
                $this->session->set_flashdata('success', 'Exceção valores deletada com sucesso');
            }

        }
        else
        {
            //echo(json_encode(array('status'=>FALSE)));
            $this->session->set_flashdata('error', 'Falha em excluir Exceção Valores');
        }
        redirect('importacaoExcecaoValores');
    }


    // IMPORTAÇÃO FATITEM

    function importacaoFatItem()
    {
        $data['roles'] = $this->user_model->getUserRoles();

        $this->global['pageTitle'] = 'QUALICAD : Importação FatItem';
        
        $data['infoFaturamento'] = $this->ImportacaoModel->carregaInfoFaturamento($this->session->userdata('IdEmpresa'));
        $data['infoLayoutImportacao'] = $this->ImportacaoModel->carregaInfoLayoutImportacaoEmpresa('FatItem',$this->session->userdata('IdEmpresa'));

        $this->loadViews("qualicad/importacao/importacaoFatItem", $this->global, $data, NULL);
    }

    public function importaFatItem(){
        $data = array();
        $memData = array();

        $this->session->set_flashdata('Id_LayoutImportacao', $this->input->post('Tb_Id_LayoutImportacao'));
        $this->session->set_flashdata('Id_Faturamento', $this->input->post('TbFaturamento_Id_Faturamento'));

        //    $DePara = $this->ImportacaoModel->consultaDePara('GrupoPro',$this->session->userdata('IdEmpresa'));

        // If import request is submitted
        if($this->input->post('importSubmit')){
            // Form field validation rules
            $this->load->library('form_validation');

            $this->form_validation->set_rules('file', 'CSV file', 'callback_file_check');

            // Validate submitted form data
            if($this->form_validation->run() == true){
                $insertCount = $updateCount = $rowCount = $notAddCount = $duplicidade = 0;

                // If file uploaded
                if(is_uploaded_file($_FILES['file']['tmp_name'])){
                    // Load CSV reader library
                    $this->load->library('CSVReader');

                    // Parse data from CSV file
                    $csvData = $this->csvreader->parse_csv($_FILES['file']['tmp_name']);
                    $dePara = $this->ImportacaoModel->consultaDePara($this->input->post('Tb_Id_LayoutImportacao'),'FatItem',$this->session->userdata('IdEmpresa'));

                    $errosDeChave = array();
                    $campoNaoLocalizado = '';

                    // Insert/update CSV data into database
                    if(!empty($csvData)){
                        foreach($csvData as $row) {
                            $rowCount++;

                            $memData = array();

                            for ($i=0;$i<count($dePara);$i++) {
                                if (!isset($row[(preg_replace('/\s+/', '', $dePara[$i]->No_CampoOrigem))])) {$campoNaoLocalizado = 'true';}
                                if (isset($row[(preg_replace('/\s+/', '', $dePara[$i]->No_CampoOrigem))])) {
                                    if ($dePara[$i]->St_Valor == 'S' || $dePara[$i]->St_Data == 'S') {
                                        if ($dePara[$i]->St_Valor == 'S') {
                                            $memData += array(
                                                (preg_replace('/\s+/', '', $dePara[$i]->No_CampoDestino)) => $this->valor($row[(preg_replace('/\s+/', '', $dePara[$i]->No_CampoOrigem))])
                                            );
                                        }
                                        if (preg_replace('/\s+/', '', $dePara[$i]->St_Data) == 'S') {
                                            $memData += array(
                                                (preg_replace('/\s+/', '', $dePara[$i]->No_CampoDestino)) => $this->data($row[(preg_replace('/\s+/', '', $dePara[$i]->No_CampoOrigem))])
                                            );
                                        }
                                    } else {
                                        $memData += array(
                                            (preg_replace('/\s+/', '', $dePara[$i]->No_CampoDestino)) => $row[(preg_replace('/\s+/', '', $dePara[$i]->No_CampoOrigem))]
                                        );
                                    }
                                }
                            }

                            $memData += array(
                                'TbFaturamento_Id_Faturamento' => $this->input->post('TbFaturamento_Id_Faturamento'),                                
                                'TbEmpresa_Id_Empresa'=>$this->session->userdata('IdEmpresa'),
                                'CriadoPor'=>$this->vendorId,
                                'AtualizadoPor'=>$this->vendorId,
                                'Dt_Criacao'=>date('Y-m-d'),
                                'Tp_Ativo'=> 'S');    
        
                            $insert = 0;

                            if (!isset($memData['Cd_TISS'])) { $memData['Cd_TISS'] = null; }

                            // ***** VERIFICAÇÕES DE DUPLICIDADE NA ADIÇÃO *****
                          //  if (isset($memData['Cd_TUSS'])&&isset($memData['Cd_TISS'])&&isset($memData['TbFaturamento_Id_Faturamento'])&&isset($memData['TbEmpresa_Id_Empresa'])) {
                            if ($this->ImportacaoModel->consultaRegraTbFatItemExistente($memData['Cd_TUSS'],$memData['Cd_TISS'],$memData['TbFaturamento_Id_Faturamento'],$this->session->userdata('IdEmpresa')) != null) {
                                $duplicidade++;
                                } else {
                                    $insert = $this->ImportacaoModel->adicionaFatItem($memData);
                                }
                         //   }
                            // ***** FIM DE VERIFICAÇÕES *****

                        //    $insert = $this->ImportacaoModel->adicionaFatItem($memData);

                            if($insert){
                                $insertCount++;
                            } else {
                              /*  if (isset($memData['TbProFat_Cd_ProFat'])) {
                                    array_push($errosDeChave, $memData['TbProFat_Cd_ProFat']); 
                                }*/
                                array_push($errosDeChave, ($rowCount+1));
                                $notAddCount++;
                            }
                        }

                        $temp = null;

                        /* DEBUG DE CHAVE NÃO LOCALIZADA */
                        $i = 0;
                        foreach ($errosDeChave as $row) {
                        $i++;
                        if ($i < sizeof($errosDeChave) ) { 
                            $temp .= $row . ', ';
                        } else {
                            $temp .= $row;
                        }
                        }

                        $this->session->set_flashdata('errosDeChaveMsg', $temp);


                        // Status message with imported data count
                        $notAddCount = ($rowCount - ($insertCount + $updateCount));
                        $successMsg = 'Tabela FatItem importada com sucesso! Qtd. Linhas ('.$rowCount.') | Inseridos ('.$insertCount.') | Atualizados ('.$updateCount.') | Não inseridos ('.$notAddCount.') | Duplicidades ('.$duplicidade.')';

                        $this->session->set_flashdata('num_linhas_importadas', $insertCount);
                        if ($campoNaoLocalizado == '') {
                            $successMsg = 'Tabela Contrato importada com sucesso! Qtd. Linhas ('.$rowCount.') | Inseridos ('.$insertCount.') | Atualizados ('.$updateCount.') | Não inseridos ('.$notAddCount.')';
                            $this->session->set_flashdata('success', $successMsg);
                        } else {
                            $successMsg = 'Tabela Contrato importada com sucesso! Qtd. Linhas ('.$rowCount.') | Inseridos ('.$insertCount.') | Atualizados ('.$updateCount.') | Não inseridos ('.$notAddCount.')
                            <br/><strong>OBS: Algumas colunas do CSV não tem DEPARA cadastrado</strong>';
                            $this->session->set_flashdata('success', $successMsg);
                        }
                    }
                }else{
                    $this->session->set_flashdata('error', 'Erro no upload do arquivo, verifique se é um arquivo CSV válido e tente novamente.');
                }
            }else{
                $this->session->set_flashdata('error', 'Arquivo inválido! Selecione um arquivo CSV');
                //    $this->session->set_userdata('error_msg', 'Invalid file, please select only CSV file.');
            }
        }
        redirect('importacaoFatItem');
    }

    function apagaImportacaoFatItem()
    {

        $IdFatItem = $this->uri->segment(2);

        $resultado = $this->ImportacaoModel->apagaImportacaoFatItem($IdFatItem);

        if ($resultado > 0) {
            // echo(json_encode(array('status'=>TRUE)));

            $process = 'Exclusão de importação Fat Item';
            $processFunction = 'Importacao/apagaImportacaoFatItem';
            $this->logrecord($process,$processFunction);

            if ($resultado === 1451) {
                $this->session->set_flashdata('error', 'Existe associação ativa');
            }
            else {
                $this->session->set_flashdata('success', 'FatItem deletada com sucesso');
            }

        }
        else
        {
            //echo(json_encode(array('status'=>FALSE)));
            $this->session->set_flashdata('error', 'Falha em excluir o FatItem');
        }
        redirect('importacaoFatItem');
    }


    function layoutImportacao()
    {
            $tpTela = $this->uri->segment(2);

            $data['perfis'] = $this->CadastroModel->carregaPerfisUsuarios();

            if ($tpTela == 'listar') {

                if ($this->session->userdata('isAdmin') != 'S')
                    {             
                    redirect('telaNaoAutorizada');
                    }

                $searchText = $this->security->xss_clean($this->input->post('searchText'));
                $data['searchText'] = $searchText;
                
                $this->load->library('pagination');
                
                $count = $this->CadastroModel->userListingCount($searchText);

                $returns = $this->paginationCompress ( "layoutImportacao/listar", $count, 100 );
                
                $data['registrosLayoutImportacao'] = $this->ImportacaoModel->listaLayoutImportacao($this->session->userdata('IdEmpresa'), $searchText, $returns["page"], $returns["segment"]);
                
                $process = 'Listar Layout Importacao';
                $processFunction = 'Importacao/layoutImportacao';
                $this->logrecord($process,$processFunction);

                $this->global['pageTitle'] = 'QUALICAD : Lista de Layout Importação';
                
                $this->loadViews("qualicad/importacao/l_layoutImportacao", $this->global, $data, NULL);
            }
            else if ($tpTela == 'cadastrar') {

                if ($this->session->userdata('isAdmin') != 'S')
                    {             
                    redirect('telaNaoAutorizada');
                    }                

                $this->global['pageTitle'] = 'QUALICAD : Cadastro de Layout Importação';
                $this->loadViews("qualicad/importacao/c_layoutImportacao", $this->global, $data, NULL); 
            }
            else if ($tpTela == 'editar') {

                if ($this->session->userdata('isAdmin') != 'S')
                    {             
                    redirect('telaNaoAutorizada');
                    }

                $IdLayoutImportacao = $this->uri->segment(3);
                if($IdLayoutImportacao == null)
                {
                    redirect('layoutImportacao/listar');
                }
                $data['infoLayoutImportacao'] = $this->ImportacaoModel->carregaInfoLayoutImportacao($IdLayoutImportacao);                

                $this->global['pageTitle'] = 'QUALICAD : Editar Layout Importação';      
                $this->loadViews("qualicad/importacao/c_layoutImportacao", $this->global, $data, NULL);
            }
    }

    function adicionaLayoutImportacao() 
    {
            if (array_key_exists('IrLista',$this->input->post())) {
                redirect('layoutImportacao/listar'); 
            } 

            $Ds_LayoutImportacao = ucwords(strtolower($this->security->xss_clean($this->input->post('Ds_LayoutImportacao'))));
            $No_Importacao = $this->input->post('No_Importacao');
            $Tp_Ativo = $this->input->post('Tp_Ativo');

            //    $roleId = $this->input->post('role');

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

                $infoLayoutImportacao = array('Ds_LayoutImportacao'=>$Ds_LayoutImportacao, 'No_Importacao'=>$No_Importacao,  
                'TbEmpresa_Id_Empresa'=>$this->session->userdata('IdEmpresa'), 'Tp_Ativo'=>$Tp_Ativo);

                $result = $this->ImportacaoModel->adicionaLayoutImportacao($infoLayoutImportacao);

                if($result > 0)
                {
                    $process = 'Adicionar Layout Importação';
                    $processFunction = 'Importacao/adicionaLayoutImportacao';
                    $this->logrecord($process,$processFunction);

                    $this->session->set_flashdata('success', 'Layout Importação criado com sucesso');

                    if (array_key_exists('salvarIrLista',$this->input->post())) {
                        redirect('layoutImportacao/listar'); 
                    }
                    else if (array_key_exists('salvarMesmaTela',$this->input->post())) {
                        redirect('layoutImportacao/cadastrar'); 
                    }
                    else if (array_key_exists('salvarRetroceder',$this->input->post())) {
                        redirect('layoutImportacao/cadastrar');
                    }

                }
                else
                {
                    $this->session->set_flashdata('error', 'Falha na criação do Layout Importação');
                }

          //  } else {
            //    $this->session->set_flashdata('error', 'Convênio já foi cadastrado!');
          //  }

            redirect('layoutImportacao/cadastrar');
    }


    function editaLayoutImportacao()
    {
            if (array_key_exists('IrLista',$this->input->post())) {
                redirect('layoutImportacao/listar');
            } 

            $this->load->library('form_validation');

            $IdLayoutImportacao = $this->input->post('Id_LayoutImportacao');

            $Ds_LayoutImportacao = ucwords(strtolower($this->security->xss_clean($this->input->post('Ds_LayoutImportacao'))));
            $No_Importacao = $this->input->post('No_Importacao');
            $Tp_Ativo = $this->input->post('Tp_Ativo');

            foreach ($this->ImportacaoModel->carregaInfoLayoutImportacao($IdLayoutImportacao) as $data){
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

            $infoLayoutImportacao = array('Ds_LayoutImportacao'=>$Ds_LayoutImportacao, 'No_Importacao'=>$No_Importacao,  
            'TbEmpresa_Id_Empresa'=>$this->session->userdata('IdEmpresa'), 'Tp_Ativo'=>$Tp_Ativo);

            $resultado = $this->ImportacaoModel->editaLayoutImportacao($infoLayoutImportacao,$IdLayoutImportacao);

            if($resultado == true)
            {
                $process = 'Layout Importação atualizado';
                $processFunction = 'Importacao/editaLayoutImportacao';
                $this->logrecord($process,$processFunction);

                $this->session->set_flashdata('success', 'Layout Importação atualizado com sucesso');
            }
            else
            {
                $this->session->set_flashdata('error', 'Falha na atualização do Layout Importação');
            }

            redirect('layoutImportacao/listar');
            // }
    }

    function apagaLayoutImportacao()
    {
            if (($this->session->userdata('email') != 'homarbsb@gmail.com')&&($this->session->userdata('email') != 'yunnabsb@gmail.com')&&($this->session->userdata('email') != 'anamrbs@gmail.com'))
            {             
            redirect('telaNaoAutorizada');
            }

            $IdLayoutImportacao = $this->uri->segment(2);

            $resultado = $this->ImportacaoModel->apagaLayoutImportacao($IdLayoutImportacao);
            
            if ($resultado > 0) {
                // echo(json_encode(array('status'=>TRUE)));

                $process = 'Exclusão de Layout Importação';
                $processFunction = 'Importacao/apagaLayoutImportacao';
                $this->logrecord($process,$processFunction);

                if ($resultado === 1451) {
                    $this->session->set_flashdata('error', 'Existe associação ativa');
                }
                else {
                    $this->session->set_flashdata('success', 'Layout Importação deletado com sucesso');
                }

                }
                else 
                { 
                    //echo(json_encode(array('status'=>FALSE))); 
                    $this->session->set_flashdata('error', 'Falha em excluir o Layout Importação');
                }
                redirect('layoutImportacao/listar');
    }


    function editaDePara()
    {
            if (array_key_exists('IrLista',$this->input->post())) {
                redirect('importacaoDePara/listar');
            } 

            $this->load->library('form_validation');

            $IdDePara = $this->input->post('Id_DeparaImportacao');

            $Tb_Id_LayoutImportacao = $this->input->post('Tb_Id_LayoutImportacao');
            $No_Importacao = ucwords(strtolower($this->security->xss_clean($this->input->post('No_Importacao'))));
            $No_Tabela = $this->input->post('No_Tabela');
            $No_CampoOrigem = $this->input->post('No_CampoOrigem');
            $No_CampoDestino  = $this->input->post('No_CampoDestino');
            $St_Valor  = $this->input->post('St_Valor');
            $Tp_Ativo = $this->input->post('Tp_Ativo');

            foreach ($this->ImportacaoModel->carregaInfoDePara($IdDePara) as $data){
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

            $infoDePara = array('Tb_Id_LayoutImportacao'=>$Tb_Id_LayoutImportacao, 'No_Importacao'=>$No_Importacao, 'TbEmpresa_Id_Empresa'=>$this->session->userdata('IdEmpresa'),
                'No_Tabela'=>$No_Tabela, 'No_CampoOrigem'=> $No_CampoOrigem, 'No_CampoDestino'=> $No_CampoDestino,
                'CriadoPor'=>$this->vendorId, 'AtualizadoPor'=>$this->vendorId, 'St_Valor'=>$St_Valor,
                'Tp_Ativo'=>$Tp_Ativo, 'Dt_Ativo'=>$Dt_Ativo);


            $resultado = $this->ImportacaoModel->editaDePara($infoDePara,$IdDePara);

            if($resultado == true)
            {
                $process = 'DePara atualizado';
                $processFunction = 'Importacao/editaDePara';
                $this->logrecord($process,$processFunction);

                $this->session->set_flashdata('success', 'DePara atualizado com sucesso');
            }
            else
            {
                $this->session->set_flashdata('error', 'Falha na atualização do DePara');
            }

            redirect('importacaoDePara/listar');
            // }
    }

    function apagaDePara()
    {
            if (($this->session->userdata('email') != 'homarbsb@gmail.com')&&($this->session->userdata('email') != 'yunnabsb@gmail.com')&&($this->session->userdata('email') != 'anamrbs@gmail.com'))
            {             
            redirect('telaNaoAutorizada');
            }

            $IdDePara = $this->uri->segment(2);
            
            $resultado = $this->ImportacaoModel->apagaDePara($IdDePara);
            
            if ($resultado > 0) {
                // echo(json_encode(array('status'=>TRUE)));

                $process = 'Exclusão de DePara';
                $processFunction = 'Importacao/apagaDePara';
                $this->logrecord($process,$processFunction);

                if ($resultado === 1451) {
                    $this->session->set_flashdata('error', 'Existe associação ativa');
                }
                else {
                    $this->session->set_flashdata('success', 'DePara deletado com sucesso');
                }

                }
                else 
                { 
                    //echo(json_encode(array('status'=>FALSE))); 
                    $this->session->set_flashdata('error', 'Falha em excluir o DePara');
                }
                redirect('importacaoDePara/listar');
    }


    function consultaCamposTabela()
    {
           
            $DsTabela = $this->uri->segment(2);
                       
            $resultado = $this->ImportacaoModel->consultaCamposTabela($DsTabela);
            
            echo json_encode($resultado);
    }


    // IMPORTAÇÃO SIMPRO

    function importacaoSimproMsg()
    {
        $data['roles'] = $this->user_model->getUserRoles();

        $this->global['pageTitle'] = 'QUALICAD : Importação Simpro';
        
        $data['infoSimproMsgs'] = $this->ImportacaoModel->carregaInfoSimproMsgs();

        $data['consolidadoSimproMsgs'] = $this->ImportacaoModel->carregaConsolidadoSimproMsgs();

        $this->loadViews("qualicad/importacao/importacaoSimproMsg", $this->global, $data, NULL);
    }

    public function importaSimproMsg(){
       
        $backupTbSimpro = $this->ImportacaoModel->backupTbSimpro($this->vendorId);
        
        $data = array();
        $memData = array();

        // If import request is submitted
        if($this->input->post('importSubmit')){
            // Form field validation rules
            $this->load->library('form_validation');

            $this->form_validation->set_rules('file', 'CSV file', 'callback_file_check');

            // Validate submitted form data
            if($this->form_validation->run() == true){
                $insertCount = $updateCount = $rowCount = $notAddCount = $duplicidade = 0;

                // If file uploaded
                if(is_uploaded_file($_FILES['file']['tmp_name'])){
                    // Load CSV reader library

                    $this->load->library('CSVReader');

                    // Parse data from CSV file
                    $csvData = $this->csvreader->parse_csv($_FILES['file']['tmp_name'], 'simpro');

                    $apagaSimproMsg = $this->ImportacaoModel->apagaSimproMsg($this->input->post('outputfile')[4].$this->input->post('outputfile')[5].$this->input->post('outputfile')[7].$this->input->post('outputfile')[8].$this->input->post('outputfile')[9].$this->input->post('outputfile')[10]);

                    // Insert/update CSV data into database
                    if(!empty($csvData)){
                        foreach($csvData as $row) {
                            $rowCount++;

                            $memData = array();

                            $vigencia = sprintf('%08d', $row['VIGENCIA']);

                            $memData += array(
                                'NumeroMsg' => $this->input->post('outputfile')[4].$this->input->post('outputfile')[5].$this->input->post('outputfile')[7].$this->input->post('outputfile')[8].$this->input->post('outputfile')[9].$this->input->post('outputfile')[10],
                                'Cd_Usuario' => $row['CD_USUARIO'],
                                'Cd_Fracao'=> $row['CD_FRACAO'],
                                'Ds_Produto'=> $row['DESCRICAO'],
                                'DT_Vigencia'=> DateTime::createFromFormat('dmY', $vigencia)->format('Y-m-d'),
                                'Identificacao'=> $row['IDENTIF'],
                                'Pr_FabEmbalagem'=> $row['PC_EM_FAB'] / 100,
                                'Pr_VenEmbalagem'=> $row['PC_EM_VEN'] / 100,
                                'Pr_UsuEmbalagem'=> $row['PC_EM_USU'] / 100,
                                'Pr_FabFracao'=> $row['PC_FR_FAB'] / 1000,
                                'Pr_VenFracao'=> $row['PC_FR_VEN'] / 1000,
                                'Pr_UsuFracao'=> $row['PC_FR_USU'] / 1000,
                                'Tp_Embalagem'=> $row['TP_EMBAL'],
                                'Tp_Fracao'=> $row['TP_FRACAO'],
                                'Qt_Embalagem'=> $row['QTDE_EMBAL'] / 100,
                                'Qt_Fracao'=> $row['QTDE_FRAC'] / 100,
                                'Perc_LucroUsu'=> $row['PERC_LUCR'] / 100,
                                'Tp_Alteracao'=> $row['TIP_ALT'],
                                'Fabricante'=> $row['FABRICA'],
                                'Cd_Simpro'=> $row['CD_SIMPRO'],
                                'Cd_Mercado'=> $row['CD_MERCADO'],
                                'Perc_Desconto'=> $row['PERC_DESC'] / 100,
                                'Perc_IPI'=> $row['VLR_IPI'] / 100,
                                'Nm_RegAnvisa'=> $row['CD_REG_ANV'],
                                'Dt_ValRegAnvisa'=> $row['DT_REG_ANV'],
                                'Nm_CodBarra'=> $row['CD_BARRA'],
                                'Tp_Lista'=> $row['LISTA'],
                                'Uso_Hospitalar'=> $row['HOSPITALAR'],
                                'ProdFracao_SN'=> $row['FRACIONAR'],
                                'Cd_TUSS'=> $row['CD_TUSS'],
                                'Classif_Produto'=> $row['CD_CLASSIF'],
                                'Refer_Produto'=> $row['CD_REF_PRO'],
                                'Generico_SN'=> $row['GENERICO'],
                                'Diversos_SN'=> $row['DIVERSOS'],
                                'Dt_Criacao'=>date('Y-m-d'),
                                'Dt_Atualizacao'=>date('Y-m-d'),
                                'CriadoPor'=>$this->vendorId,
                                'Dt_Ativo'=>date('Y-m-d'));

                            $memData += array(
                                    'CriadoPor'=>$this->vendorId,
                                    'Dt_Criacao'=>date('Y-m-d')
                                );

                            $insertMsg = $this->ImportacaoModel->adicionaSimproMsg($memData);

                            if ($row['TIP_ALT'] == 'I') { $insertSimpro = $this->ImportacaoModel->adicionaSimproMae($memData); }

                            /* FAZER UMA CHECAGEM SE O ITEM EXISTE NA TBSIMPRO */
                      
                            $existeNaSimpro = $this->ImportacaoModel->verificaExisteSimpro($memData['Cd_Simpro']);
                            
                            if ($existeNaSimpro != null) {
                            if ($row['TIP_ALT'] == 'P') { $insertSimpro = $this->ImportacaoModel->atualizaPrecoSimproMae($memData); }
                            if ($row['TIP_ALT'] == 'A') { $insertSimpro = $this->ImportacaoModel->atualizaLinhaSimproMae($memData); }
                            } else {
                                $memData['Tp_Alteracao'] = 'I';
                                
                                $insertSimpro = $this->ImportacaoModel->adicionaSimproMae($memData);
                            }

                            /** SENÃO EXISTIR EU FAÇO O INSERT (TIPO I) */
                            
                            if ($row['TIP_ALT'] == 'L' || $row['TIP_ALT'] == 'D' || $row['TIP_ALT'] == 'S') { $insertSimpro = $this->ImportacaoModel->atualizaTipAltSimproMae($memData); }

                            if($insertMsg){
                                $insertCount++;
                            } else {                                
                                $notAddCount++;
                            }

                         /*   $verCondInclFatItemPelaSimpro = $this->ImportacaoModel->verCondInclFatItemPelaSimpro($memData['Cd_Simpro'], $this->session->userdata('IdEmpresa')); 
                            
                            if ($verCondInclFatItemPelaSimpro != null) {
                                $verSeExisteCdSimproNaFatItem = $this->ImportacaoModel->verSeExisteCdSimproNaFatItem($memData['Cd_Simpro'],$verCondInclFatItemPelaSimpro[0]->TbFaturamento_Id_Faturamento);
                                    if($verSeExisteCdSimproNaFatItem == null) {
                                        $atualizaInclusaoFatItem = $this->ImportacaoModel->inclusaoFatItemPelaSimpro($verCondInclFatItemPelaSimpro);                        
                                    }                        
                                } */

                        }
                        
                     /*   $verCondPrecoAltFatItemPelaSimpro = $this->ImportacaoModel->verCondPrecoAltFatItemPelaSimpro($memData['Cd_Simpro'],$memData['NumeroMsg']);
                        
                        if ($verCondPrecoAltFatItemPelaSimpro[0]->Id_FatItem != null) { */
                     /*       $atualizaPrecoFatItem = $this->ImportacaoModel->precoFatItemPelaSimpro($memData['NumeroMsg']);
                            $atualizaAlteracoesFatItem = $this->ImportacaoModel->alteracoesFatItemPelaSimpro($memData['NumeroMsg']);
                    //    }
  
                        $atualizaForadeLinhaFatItem = $this->ImportacaoModel->foradeLinhaFatItemPelaSimpro($memData['NumeroMsg']);
*/
                        }

                        // Status message with imported data count
                        $notAddCount = ($rowCount - ($insertCount + $updateCount));
                        $successMsg = 'Tabela Simpro Msg importada com sucesso! Qtd. Linhas ('.$rowCount.') | Inseridos ('.$insertCount.') | Atualizados ('.$updateCount.') | Não inseridos ('.$notAddCount.') | Duplicidades ('.$duplicidade.')';

                        $this->session->set_flashdata('num_linhas_importadas', $insertCount);
                        if ($campoNaoLocalizado == '') {
                            $this->session->set_flashdata('success', $successMsg);
                        } else {
                            $this->session->set_flashdata('error', $campoNaoLocalizado);
                        }
                    }
                }else{
                    $this->session->set_flashdata('error', 'Erro no upload do arquivo, verifique se é um arquivo CSV válido e tente novamente.');
                }
            }else{
                $this->session->set_flashdata('error', 'Arquivo inválido! Selecione um arquivo CSV');
                //    $this->session->set_userdata('error_msg', 'Invalid file, please select only CSV file.');
            }
        redirect('importacaoSimproMsg');
    }



    // IMPORTAÇÃO SIMPRO MAE

    function importacaoSimproMae()
    {
        $data['roles'] = $this->user_model->getUserRoles();

        $this->global['pageTitle'] = 'QUALICAD : Importação Simpro Mãe';

        $this->loadViews("qualicad/importacao/importacaoSimproMae", $this->global, $data, NULL);
    }

    function importacaoSimproMae_progresso()
    {
        $data['progresso'] = $this->uri->segment(2);
        $data['filename'] = $this->uri->segment(3);
        $data['size'] = $this->uri->segment(4);
        $data['rowcount'] = $this->uri->segment(5);
        $data['insertcount'] = $this->uri->segment(6);
        $data['updatecount'] = $this->uri->segment(7);
        $data['notaddcount'] = $this->uri->segment(8);
        $data['duplicidade'] = $this->uri->segment(9);

        $data['roles'] = $this->user_model->getUserRoles();

        $this->global['pageTitle'] = 'QUALICAD : Importação Simpro Mãe';

        $this->loadViews("qualicad/importacao/importacaoSimproMae_progresso", $this->global, $data, NULL);
    }


    public function importaSimproMae(){
        $data = array();
        $memData = array();
        $campoNaoLocalizado = '';

        $arrayTmpFiles = array();
        $count=0;
        set_time_limit(1000);

        // If import request is submitted
        if($this->input->post('importSubmit')||$this->input->post('progresso') != ''){

            // Form field validation rules
            $this->load->library('form_validation');

            $this->form_validation->set_rules('file', 'CSV file', 'callback_file_check');

            // Validate submitted form data
            if($this->form_validation->run() == true||$this->input->post('progresso') != ''){
                $insertCount = $updateCount = $rowCount = $notAddCount = $duplicidade = 0;

                // If file uploaded
                if(is_uploaded_file($_FILES['file']['tmp_name'])||$this->input->post('progresso') != ''){
                    // Load CSV reader library                

                    if ($this->input->post('progresso') == '') {
                        $arrayTmpFiles = $this->splitCsv($_FILES['file']['tmp_name'],true);
                        $count = 1;
                        $rowCount = 0;
                        $insertCount = 0;
                        $updateCount = 0;
                        $notAddCount = 0;
                        $duplicidade = 0;
                        $filename = strstr(str_replace('/tmp/', '', $arrayTmpFiles[0]),'_', true);
                        $size = sizeof($arrayTmpFiles);
                        redirect('importacaoSimproMae_progresso/'.$count.'/'.$filename.'/'.$size.'/'.$rowCount.'/'.$insertCount.'/'.$updateCount.'/'.$notAddCount.'/'.$duplicidade);
                    }

                    $basedir = $_SERVER['DOCUMENT_ROOT'];

                    $this->load->library('CSVReader');

                    $rowCount = $this->input->post('rowcount');
                    $insertCount = $this->input->post('insertcount');
                    $updateCount = $this->input->post('updatecount');
                    $notAddCount = $this->input->post('notaddcount');
                    $duplicidade = $this->input->post('duplicidade');

                    $csvData = $this->csvreader->parse_csv($basedir.'/tmp/'.$this->input->post('filename').'_'.$this->input->post('progresso').'.csv', 'simpro');
                                        
                    $errosDeChave = array();

                    if(!empty($csvData)){
                        foreach($csvData as $row) {
                            $rowCount++;

                            $memData = array();

                            $vigencia = sprintf('%08d', $row['VIGENCIA']);

                            $memData += array(                                
                                'Cd_Usuario' => $row['CD_USUARIO'],
                                'Cd_Fracao'=> $row['CD_FRACAO'],
                                'Ds_Produto'=> $row['DESCRICAO'],
                                'DT_Vigencia'=> DateTime::createFromFormat('dmY', $vigencia)->format('Y-m-d'),
                                'Identificacao'=> $row['IDENTIF'],
                                'Pr_FabEmbalagem'=> $row['PC_EM_FAB'] / 100,
                                'Pr_VenEmbalagem'=> $row['PC_EM_VEN'] / 100,
                                'Pr_UsuEmbalagem'=> $row['PC_EM_USU'] / 100,
                                'Pr_FabFracao'=> $row['PC_FR_FAB'] / 1000,
                                'Pr_VenFracao'=> $row['PC_FR_VEN'] / 1000,
                                'Pr_UsuFracao'=> $row['PC_FR_USU'] / 1000,
                                'Tp_Embalagem'=> $row['TP_EMBAL'],
                                'Tp_Fracao'=> $row['TP_FRACAO'],
                                'Qt_Embalagem'=> $row['QTDE_EMBAL'] / 100,
                                'Qt_Fracao'=> $row['QTDE_FRAC'] / 100,
                                'Perc_LucroUsu'=> $row['PERC_LUCR'] / 100,
                                'Tp_Alteracao'=> $row['TIP_ALT'],
                                'Fabricante'=> $row['FABRICA'],
                                'Cd_Simpro'=> $row['CD_SIMPRO'],
                                'Cd_Mercado'=> $row['CD_MERCADO'],
                                'Perc_Desconto'=> $row['PERC_DESC'] / 100,
                                'Perc_IPI'=> $row['VLR_IPI'] / 100,
                                'Nm_RegAnvisa'=> $row['CD_REG_ANV'],
                                'Dt_ValRegAnvisa'=> $row['DT_REG_ANV'],
                                'Nm_CodBarra'=> $row['CD_BARRA'],
                                'Tp_Lista'=> $row['LISTA'],
                                'Uso_Hospitalar'=> $row['HOSPITALAR'],
                                'ProdFracao_SN'=> $row['FRACIONAR'],
                                'Cd_TUSS'=> $row['CD_TUSS'],
                                'Classif_Produto'=> $row['CD_CLASSIF'],
                                'Refer_Produto'=> $row['CD_REF_PRO'],
                                'Generico_SN'=> $row['GENERICO'],
                                'Diversos_SN'=> $row['DIVERSOS']);

                                $memData += array(
                                    'CriadoPor'=>$this->vendorId,
                                    'Dt_Criacao'=>date('Y-m-d')
                                );

                            $insert = 0;

                            // ***** VERIFICAÇÕES DE DUPLICIDADE NA ADIÇÃO *****
                           /* if (isset($memData['Cd_Simpro'])) {
                                if ($this->ImportacaoModel->consultaCdSimproTbSimproExistente($memData['Cd_Simpro'])) {
                                        $duplicidade++;
                                    } else {
                                        $insert = $this->ImportacaoModel->adicionaSimproMae($memData);
                                    }
                                }*/
                            // ***** FIM DE VERIFICAÇÕES *****

                            $insert = $this->ImportacaoModel->adicionaSimproMae($memData);
                            
                            if($insert != 0){
                                $insertCount++;
                            } else {
                                array_push($errosDeChave, ($rowCount+1));
                                $notAddCount++;
                            }
                        }

                        // Status message with imported data count
                        $notAddCount = ($rowCount - ($insertCount + $updateCount));
                        $successMsg = 'Tabela Simpro Mãe importada com sucesso! Qtd. Linhas ('.$rowCount.') | Inseridos ('.$insertCount.') | Atualizados ('.$updateCount.') | Não inseridos ('.$notAddCount.') | Duplicidades ('.$duplicidade.')';

                        $this->session->set_flashdata('num_linhas_importadas', $insertCount);
                        if ($campoNaoLocalizado == '') {
                            $this->session->set_flashdata('success', $successMsg);
                        } else {
                            $this->session->set_flashdata('error', $campoNaoLocalizado);
                        }

                    }
                    }
                }else{
                    $this->session->set_flashdata('error', 'Erro no upload do arquivo, verifique se é um arquivo CSV válido e tente novamente.');
                    redirect('importacaoSimproMae');
                }
            }else{
                $this->session->set_flashdata('error', 'Arquivo inválido! Selecione um arquivo CSV');
                //    $this->session->set_userdata('error_msg', 'Invalid file, please select only CSV file.');
            }

        if ($this->input->post('progresso') != '' && $this->input->post('progresso') <= $this->input->post('size')) {
            $count = $this->input->post('progresso') + 1;
            redirect('importacaoSimproMae_progresso/'.$count.'/'.$this->input->post('filename').'/'.$this->input->post('size').'/'.$rowCount.'/'.$insertCount.'/'.$updateCount.'/'.$notAddCount.'/'.$duplicidade);
            } else {  
                //redirecionar para página de finalização
                redirect('importacaoSimproMae_progresso/completo/'.$this->input->post('filename').'/'.$this->input->post('size').'/'.$rowCount.'/'.$insertCount.'/'.$updateCount.'/'.$notAddCount.'/'.$duplicidade);
            }

    }

    // IMPORTAÇÃO BRASINDICE MSG

    function importacaoBrasindiceMsg()
    {
        $data['roles'] = $this->user_model->getUserRoles();

        $this->global['pageTitle'] = 'QUALICAD : Importação Brasindice';
        
        $data['infoBrasindiceMsgs'] = $this->ImportacaoModel->carregaInfoBrasindiceMsgs();

        $data['consolidadoBrasindiceMsgs'] = $this->ImportacaoModel->carregaConsolidadoBrasindiceMsgs();

        $this->loadViews("qualicad/importacao/importacaoBrasindiceMsg", $this->global, $data, NULL);
    }

    public function importaBrasindiceMsg(){
       
        $backupTbBrasindice = $this->ImportacaoModel->backupTbBrasindice($this->vendorId);
        
        $data = array();
        $memData = array();

        $tpBrasindice = $this->input->post('tpBrasindice');

        // If import request is submitted
        if($this->input->post('importSubmit')){
            // Form field validation rules
            $this->load->library('form_validation');

            $this->form_validation->set_rules('file', 'CSV file', 'callback_file_check');

            // Validate submitted form data
            if($this->form_validation->run() == true){
                $insertCount = $updateCount = $rowCount = $notAddCount = $duplicidade = 0;

                // If file uploaded
                if(is_uploaded_file($_FILES['file']['tmp_name'])){
                    // Load CSV reader library

                    $this->load->library('CSVReader');

                    // Parse data from CSV file
                    $csvData = $this->csvreader->parse_csv($_FILES['file']['tmp_name'], 'brasindicemsg', $tpBrasindice);

                    $apagaBrasindiceMsg = $this->ImportacaoModel->apagaBrasindiceMsg($this->input->post('outputfile')[4].$this->input->post('outputfile')[5].$this->input->post('outputfile')[7].$this->input->post('outputfile')[8].$this->input->post('outputfile')[9].$this->input->post('outputfile')[10]);

                    // Insert/update CSV data into database
                    if(!empty($csvData)){
                        foreach($csvData as $row) {
                            $rowCount++;

                            $memData = array();

                            $vigencia = sprintf('%08d', $row['VIGENCIA']);

                            $memData += array(                                
                                'Cd_Lab'=> $row['CD_LAB'],
                                'Ds_Lab'=> $row['DS_LAB'],
                                'Cd_Produto'=> $row['CD_PRODUTO'],
                                'Ds_Produto'=> $row['DS_PRODUTO'],
                                'Cd_Apresentacao'=> $row['CD_APRESENTACAO'],
                                'Ds_Apresentacao'=> $row['DS_APRESENTACAO'],
                                'Vl_Preco'=> $this->valor($row['VL_PRECO']) / 100,
                                'Qt_Fracao'=> $row['QT_FRACAO'],
                                'Tp_Preco'=> $row['TP_PRECO'],
                                'Vl_PrecoFracao'=> $this->valor($row['VL_PRECOFRACAO']) / 100,
                                'Edicao'=> $row['EDICAO'],
                                'IPI'=> $row['IPI'],
                                'SN_PortPisCofins'=> $row['SN_PORTPISCOFINS'],
                                'Cd_Ean'=> (isset($row['CD_EAN'])?$row['CD_EAN']:null),
                                'Cd_TISS'=> $row['CD_TISS'],
                                'Cd_TUSS'=> $row['CD_TUSS'],
                                'Dt_Criacao'=>date('Y-m-d'),
                                'Dt_Atualizacao'=>date('Y-m-d'),
                                'CriadoPor'=>$this->vendorId,
                                'Tp_Brasindice' => $this->input->post('tpBrasindice'),
                                'Perc_Aliqutota' => $this->input->post('tpAliquota'));

                            $insertMsg = $this->ImportacaoModel->adicionaBrasindiceMsg($memData);

                            if ($row['TIP_ALT'] == 'I') { $insertBrasindice = $this->ImportacaoModel->adicionaBrasindiceMae($memData); }
                            if ($row['TIP_ALT'] == 'P') { $insertBrasindice = $this->ImportacaoModel->atualizaPrecoBrasindiceMae($memData); }
                            if ($row['TIP_ALT'] == 'A') { $insertBrasindice = $this->ImportacaoModel->atualizaLinhaBrasindiceMae($memData); }
                            if ($row['TIP_ALT'] == 'S') { $insertBrasindice = $this->ImportacaoModel->atualizaTipAltBrasindiceMae($memData); }

                            if($insertMsg){
                                $insertCount++;
                            } else {                                
                                $notAddCount++;
                            }
                        }
                        
                        $atualizaInclusaoFatItem = $this->ImportacaoModel->inclusaoFatItemPelaBrasindice();
                        $atualizaPrecoFatItem = $this->ImportacaoModel->precoFatItemPelaBrasindice();
                        $atualizaAlteracoesFatItem = $this->ImportacaoModel->alteracoesFatItemPelaBrasindice();
                        $atualizaForadeLinhaFatItem = $this->ImportacaoModel->foradeLinhaFatItemPelaBrasindice();

                        }

                        // Status message with imported data count
                        $notAddCount = ($rowCount - ($insertCount + $updateCount));
                        $successMsg = 'Tabela Brasindice Msg importada com sucesso! Qtd. Linhas ('.$rowCount.') | Inseridos ('.$insertCount.') | Atualizados ('.$updateCount.') | Não inseridos ('.$notAddCount.') | Duplicidades ('.$duplicidade.')';

                        $this->session->set_flashdata('num_linhas_importadas', $insertCount);
                        if ($campoNaoLocalizado == '') {
                            $this->session->set_flashdata('success', $successMsg);
                        } else {
                            $this->session->set_flashdata('error', $campoNaoLocalizado);
                        }
                    }
                }else{
                    $this->session->set_flashdata('error', 'Erro no upload do arquivo, verifique se é um arquivo CSV válido e tente novamente.');
                }
            }else{
                $this->session->set_flashdata('error', 'Arquivo inválido! Selecione um arquivo CSV');
                //    $this->session->set_userdata('error_msg', 'Invalid file, please select only CSV file.');
            }
        redirect('importacaoBrasindiceMsg');
    }



    // IMPORTAÇÃO BRASINDICE MAE

    function importacaoBrasindiceMae()
    {
        $data['roles'] = $this->user_model->getUserRoles();

        $this->global['pageTitle'] = 'QUALICAD : Importação Brasindice Mãe';

        $this->loadViews("qualicad/importacao/importacaoBrasindiceMae", $this->global, $data, NULL);
    }


    public function importaBrasindiceMae(){
        $data = array();
        $memData = array();

        $tpBrasindice = $this->input->post('tpBrasindice');

        // If import request is submitted
        if($this->input->post('importSubmit')){
            // Form field validation rules
            $this->load->library('form_validation');

            $this->form_validation->set_rules('file', 'CSV file', 'callback_file_check');

            // Validate submitted form data
            if($this->form_validation->run() == false){
                $insertCount = $updateCount = $rowCount = $notAddCount = $duplicidade = 0;

                // If file uploaded
                if(is_uploaded_file($_FILES['file']['tmp_name'])){
                    // Load CSV reader library

                    $this->load->library('CSVReader');

                    // Parse data from CSV file
                    $csvData = $this->csvreader->parse_csv($_FILES['file']['tmp_name'], 'brasindicemae', $tpBrasindice);                 

                    // Insert/update CSV data into database
                    if(!empty($csvData)){
                        foreach($csvData as $row) {
                            $rowCount++;

                            $memData = array();                           

                            $memData += array(   
                                'NumeroMsg' => preg_replace('/[^0-9]/', '', $this->input->post('outputfile')),                             
                                'Cd_Lab'=> intval($row['CD_LAB']),
                                'Ds_Lab'=> $row['DS_LAB'],
                                'Cd_Produto'=> $row['CD_PRODUTO'],
                                'Ds_Produto'=> $row['DS_PRODUTO'],
                                'Cd_Apresentacao'=> $row['CD_APRESENTACAO'],
                                'Ds_Apresentacao'=> $row['DS_APRESENTACAO'],
                                'Vl_Preco'=> $this->valor($row['VL_PRECO']) / 100,
                                'Qt_Fracao'=> $row['QT_FRACAO'],
                                'Tp_Preco'=> $row['TP_PRECO'],
                                'Vl_PrecoFracao'=> $this->valor($row['VL_PRECOFRACAO']) / 100,
                                'Edicao'=> $row['EDICAO'],
                                'IPI'=> $row['IPI'],
                                'SN_PortPisCofins'=> $row['SN_PORTPISCOFINS'],
                                'Cd_Ean'=> (isset($row['CD_EAN'])?$row['CD_EAN']:null),
                                'Cd_TISS'=> $row['CD_TISS'],
                                'Cd_TUSS'=> $row['CD_TUSS'],
                                'Tp_Brasindice' => $this->input->post('tpBrasindice'),
                                'Perc_Aliqutota'=> $this->input->post('tpAliquota'),
                                'Dt_Criacao'=>date('Y-m-d'),
                                'Dt_Atualizacao'=>date('Y-m-d'),
                                'CriadoPor'=>$this->vendorId);
      
                            //$insert = $this->ImportacaoModel->adicionaBrasindiceMae($memData);

                            $verificaBrasindiceCondInclusao = $this->ImportacaoModel->verificaBrasindiceCondInclusao($memData['Cd_TISS'],$memData['Tp_Preco']);                            

                            if ($verificaBrasindiceCondInclusao == null) {
                                $memData['TP_ALT'] = 'I';                                
                                $inclusaoBrasindiceMae = $this->ImportacaoModel->adicionaBrasindiceMae($memData);
                                $insertCount++;                      
                            }

                            $verificaBrasindiceCondAltPreco = $this->ImportacaoModel->verificaBrasindiceCondAltPreco($memData['Cd_TISS'],$memData['Tp_Preco'],preg_replace('/[^0-9]/', '', $this->input->post('outputfile')));                            

                            if ($verificaBrasindiceCondAltPreco != null) {
                                $memData['TP_ALT'] = 'P';                                
                                $inclusaoBrasindiceMae = $this->ImportacaoModel->adicionaBrasindiceMae($memData);
                                $atualizaPrecoCount++;                      
                            }

                            $verificaBrasindiceCondAltTUSS = $this->ImportacaoModel->verificaBrasindiceCondAltTUSS($memData['Cd_TISS'],$memData['Tp_Preco'],preg_replace('/[^0-9]/', '', $this->input->post('outputfile')),$memData['Cd_TUSS']);                            

                            if ($verificaBrasindiceCondAltTUSS != null) {
                                $memData['TP_ALT'] = 'A';                                
                                $inclusaoBrasindiceMae = $this->ImportacaoModel->adicionaBrasindiceMae($memData);
                                $atualizaTUSSCount++;                      
                            }

                            $verificaBrasindiceCondExclusao = $this->ImportacaoModel->verificaBrasindiceCondExclusao($memData['Cd_TISS'],$memData['Tp_Preco'],preg_replace('/[^0-9]/', '', $this->input->post('outputfile')));                            

                            if ($verificaBrasindiceCondExclusao == null) {
                                $memData['TP_ALT'] = 'S';                                
                                $inclusaoBrasindiceMae = $this->ImportacaoModel->adicionaBrasindiceMae($memData);
                                $atualizaExclusaoCount++;                      
                            }
                            

                        }
                        }
                        
                        // Status message with imported data count
                        //$notAddCount = ($rowCount - ($insertCount + $updateCount));
                        $successMsg = 'Tabela Brasindice Mãe importada com sucesso! Inclusões ('.$insertCount.') | Alteração de Preço ('.$atualizaPrecoCount.') | Alteração TUSS ('.$atualizaTUSSCount.') | Exclusão de item ('.$atualizaExclusaoCount.')';

                        $this->session->set_flashdata('num_linhas_importadas', $insertCount);
                        if ($campoNaoLocalizado == '') {
                            $this->session->set_flashdata('success', $successMsg);
                        } else {
                            $this->session->set_flashdata('error', $campoNaoLocalizado);
                        }
                    }
                }else{
                    $this->session->set_flashdata('error', 'Erro no upload do arquivo, verifique se é um arquivo CSV válido e tente novamente.');
                }
            }else{
                $this->session->set_flashdata('error', 'Arquivo inválido! Selecione um arquivo CSV');
                //    $this->session->set_userdata('error_msg', 'Invalid file, please select only CSV file.');
            }
        redirect('importacaoBrasindiceMae');
    }


    // IMPORTAÇÃO ITENS EMPACOTADOS

    function importacaoItensEmpacotados()
    {
        $data['roles'] = $this->user_model->getUserRoles();

        $this->global['pageTitle'] = 'QUALICAD : Importação Itens Empacotados';

    //    $data['infoContrato'] = $this->ImportacaoModel->carregaInfoContrato($this->session->userdata('IdEmpresa'));
        $data['infoLayoutImportacao'] = $this->ImportacaoModel->carregaInfoLayoutImportacaoEmpresa('ItensEmpacotados',$this->session->userdata('IdEmpresa'));

        $this->loadViews("qualicad/importacao/importacaoItensEmpacotados", $this->global, $data, NULL);
    }

    function importacaoItensEmpacotados_progresso()
    {
        $data['progresso'] = $this->uri->segment(2);
        $data['filename'] = $this->uri->segment(3);
        $data['size'] = $this->uri->segment(4);
        $data['rowcount'] = $this->uri->segment(5);
        $data['insertcount'] = $this->uri->segment(6);
        $data['updatecount'] = $this->uri->segment(7);
        $data['notaddcount'] = $this->uri->segment(8);
        $data['duplicidade'] = $this->uri->segment(9);
        $data['depara'] = $this->uri->segment(10);

        $data['roles'] = $this->user_model->getUserRoles();   

        $this->global['pageTitle'] = 'QUALICAD : Importação Itens Empacotados';

        $this->loadViews("qualicad/importacao/importacaoItensEmpacotados_progresso", $this->global, $data, NULL);
    }

    public function importaItensEmpacotados(){

        $data = array();
        $memData = array();
        $campoNaoLocalizado = '';

        $arrayTmpFiles = array();
        $count=0;
        set_time_limit(1000);

        //    $DePara = $this->ImportacaoModel->consultaDePara('GrupoPro',$this->session->userdata('IdEmpresa'));

        // If import request is submitted
        if($this->input->post('importSubmit')||$this->input->post('progresso') != ''){
            // Form field validation rules
            $this->load->library('form_validation');

            $this->form_validation->set_rules('file', 'CSV file', 'callback_file_check');

            // Validate submitted form data
            if($this->form_validation->run() == true||$this->input->post('progresso') != ''){
                $insertCount = $updateCount = $rowCount = $notAddCount = 0;

                // If file uploaded
                if(is_uploaded_file($_FILES['file']['tmp_name'])||$this->input->post('progresso') != ''){
                    // Load CSV reader library                

                    if ($this->input->post('progresso') == '') {
                        $arrayTmpFiles = $this->splitCsv($_FILES['file']['tmp_name']);
                        $count = 1;
                        $rowCount = 0;
                        $insertCount = 0;
                        $updateCount = 0;
                        $notAddCount = 0;
                        $duplicidade = 0;
                        $depara = $this->input->post('Tb_Id_LayoutImportacao');
                        $filename = strstr(str_replace('/tmp/', '', $arrayTmpFiles[0]),'_', true);
                        $size = sizeof($arrayTmpFiles);
                        redirect('importacaoItensEmpacotados_progresso/'.$count.'/'.$filename.'/'.$size.'/'.$rowCount.'/'.$insertCount.'/'.$updateCount.'/'.$notAddCount.'/'.$duplicidade.'/'.$depara);
                    }

                    $basedir = $_SERVER['DOCUMENT_ROOT'];

                    $this->load->library('CSVReader');

                    $rowCount = $this->input->post('rowcount');
                    $insertCount = $this->input->post('insertcount');
                    $updateCount = $this->input->post('updatecount');
                    $notAddCount = $this->input->post('notaddcount');
                    $duplicidade = $this->input->post('duplicidade');

                    $csvData = $this->csvreader->parse_csv($basedir.'/tmp/'.$this->input->post('filename').'_'.$this->input->post('progresso').'.csv');
                    $dePara = $this->ImportacaoModel->consultaDePara($this->input->post('depara'),'ItensEmpacotados',$this->session->userdata('IdEmpresa'));

                    $errosDeChave = array();

                    // Insert/update CSV data into database
                    if(!empty($csvData)){
                        foreach($csvData as $row) {
                            $rowCount++;

                            $memData = array();

                            for ($i=0;$i<count($dePara);$i++) {                              
                                if (!isset($row[(preg_replace('/\s+/', '', $dePara[$i]->No_CampoOrigem))])) {$campoNaoLocalizado = 'true';}
                                if (isset($row[(preg_replace('/\s+/', '', $dePara[$i]->No_CampoOrigem))])) {
                                    if (preg_replace('/\s+/', '', $dePara[$i]->St_Valor) == 'S' || $dePara[$i]->St_Data == 'S') {
                                        if (preg_replace('/\s+/', '', $dePara[$i]->St_Valor) == 'S') {
                                            $memData += array(
                                                (preg_replace('/\s+/', '', $dePara[$i]->No_CampoDestino)) => $this->valor($row[(preg_replace('/\s+/', '', $dePara[$i]->No_CampoOrigem))])
                                            );
                                        }
                                        if (preg_replace('/\s+/', '', $dePara[$i]->St_Data) == 'S') {
                                            $memData += array(
                                                (preg_replace('/\s+/', '', $dePara[$i]->No_CampoDestino)) => $this->data($row[(preg_replace('/\s+/', '', $dePara[$i]->No_CampoOrigem))])
                                            );
                                        }
                                    } else {
                                        $memData += array(
                                            (preg_replace('/\s+/', '', $dePara[$i]->No_CampoDestino)) => $this->data($row[(preg_replace('/\s+/', '', $dePara[$i]->No_CampoOrigem))])
                                        );
                                    }
                                }
                            }

                            $memData += array(
                            //    'TbUsuEmp_Id_UsuEmp' => $this->session->userdata('IdUsuEmp'),
                                'tbempresa_id_empresa'=>$this->session->userdata('IdEmpresa'),
                                'criadopor'=>$this->vendorId,
                                'tp_ativo'=> 'S');                           

                            $insert = $this->ImportacaoModel->adicionaItensEmpacotados($memData);

                            if($insert){
                                $insertCount++;
                            } else {
                                array_push($errosDeChave, ($rowCount+1));
                                $notAddCount++;
                            }

                        }

                        $temp = null;

                        /* DEBUG DE CHAVE NÃO LOCALIZADA */
                        $i = 0;
                        foreach ($errosDeChave as $row) {
                        $i++;
                        if ($i < sizeof($errosDeChave) ) { 
                            $temp .= $row . ', ';
                        } else {
                            $temp .= $row;
                        }
                        }

                        $this->session->set_flashdata('errosDeChaveMsg', $temp);

                        // Status message with imported data count
                        $notAddCount = ($rowCount - ($insertCount + $updateCount));
                        $successMsg = 'Tabela itens empacotados importada com sucesso! Qtd. Linhas ('.$rowCount.') | Inseridos ('.$insertCount.') | Atualizados ('.$updateCount.') | Não inseridos ('.$notAddCount.')';

                        $this->session->set_flashdata('num_linhas_importadas', $insertCount);
                        if ($campoNaoLocalizado == '') {
                            $successMsg = 'Tabela itens empacotados importada com sucesso! Qtd. Linhas ('.$rowCount.') | Inseridos ('.$insertCount.') | Atualizados ('.$updateCount.') | Não inseridos ('.$notAddCount.')';
                            $this->session->set_flashdata('success', $successMsg);
                        } else {
                            $successMsg = 'Tabela itens empacotados importada com sucesso! Qtd. Linhas ('.$rowCount.') | Inseridos ('.$insertCount.') | Atualizados ('.$updateCount.') | Não inseridos ('.$notAddCount.')
                            <br/><strong>OBS: Algumas colunas do CSV não tem DEPARA cadastrado</strong>';
                            $this->session->set_flashdata('success', $successMsg);
                        }
                    }
                }
            }else{
                $this->session->set_flashdata('error', 'Erro no upload do arquivo, verifique se é um arquivo CSV válido e tente novamente.');
                redirect('importacaoItensEmpacotados');
            }
        }else{
            $this->session->set_flashdata('error', 'Arquivo inválido! Selecione um arquivo CSV');
            //    $this->session->set_userdata('error_msg', 'Invalid file, please select only CSV file.');
        }

    if ($this->input->post('progresso') != '' && $this->input->post('progresso') <= $this->input->post('size')) {
        $count = $this->input->post('progresso') + 1;
        redirect('importacaoItensEmpacotados_progresso/'.$count.'/'.$this->input->post('filename').'/'.$this->input->post('size').'/'.$rowCount.'/'.$insertCount.'/'.$updateCount.'/'.$notAddCount.'/'.$duplicidade.'/'.$this->input->post('depara'));
        } else {  
            //redirecionar para página de finalização
            redirect('importacaoItensEmpacotados_progresso/completo/'.$this->input->post('filename').'/'.$this->input->post('size').'/'.$rowCount.'/'.$insertCount.'/'.$updateCount.'/'.$notAddCount.'/'.$duplicidade.'/'.$this->input->post('depara'));
        }
    }


    // IMPORTAÇÃO PACOTE

    function importacaoPacote()
    {
        $data['roles'] = $this->user_model->getUserRoles();

        $this->global['pageTitle'] = 'QUALICAD : Importação Pacote';

    //    $data['infoContrato'] = $this->ImportacaoModel->carregaInfoContrato($this->session->userdata('IdEmpresa'));
        $data['infoLayoutImportacao'] = $this->ImportacaoModel->carregaInfoLayoutImportacaoEmpresa('Pacote',$this->session->userdata('IdEmpresa'));

        $this->loadViews("qualicad/importacao/importacaoPacote", $this->global, $data, NULL);
    }

    function importacaoPacote_progresso()
    {
        $data['progresso'] = $this->uri->segment(2);
        $data['filename'] = $this->uri->segment(3);
        $data['size'] = $this->uri->segment(4);
        $data['rowcount'] = $this->uri->segment(5);
        $data['insertcount'] = $this->uri->segment(6);
        $data['updatecount'] = $this->uri->segment(7);
        $data['notaddcount'] = $this->uri->segment(8);
        $data['duplicidade'] = $this->uri->segment(9);
        $data['depara'] = $this->uri->segment(10);

        $data['roles'] = $this->user_model->getUserRoles();   

        $this->global['pageTitle'] = 'QUALICAD : Importação Pacote';

        $this->loadViews("qualicad/importacao/importacaoPacote_progresso", $this->global, $data, NULL);
    }

    public function importaPacote(){

        $data = array();
        $memData = array();
        $campoNaoLocalizado = '';

        $arrayTmpFiles = array();
        $count=0;
        set_time_limit(1000);

        //    $DePara = $this->ImportacaoModel->consultaDePara('GrupoPro',$this->session->userdata('IdEmpresa'));

        // If import request is submitted
        if($this->input->post('importSubmit')||$this->input->post('progresso') != ''){
            // Form field validation rules
            $this->load->library('form_validation');

            $this->form_validation->set_rules('file', 'CSV file', 'callback_file_check');

            // Validate submitted form data
            if($this->form_validation->run() == true||$this->input->post('progresso') != ''){
                $insertCount = $updateCount = $rowCount = $notAddCount = 0;

                // If file uploaded
                if(is_uploaded_file($_FILES['file']['tmp_name'])||$this->input->post('progresso') != ''){
                    // Load CSV reader library                

                    if ($this->input->post('progresso') == '') {
                        $arrayTmpFiles = $this->splitCsv($_FILES['file']['tmp_name']);
                        $count = 1;
                        $rowCount = 0;
                        $insertCount = 0;
                        $updateCount = 0;
                        $notAddCount = 0;
                        $duplicidade = 0;
                        $depara = $this->input->post('Tb_Id_LayoutImportacao');
                        $filename = strstr(str_replace('/tmp/', '', $arrayTmpFiles[0]),'_', true);
                        $size = sizeof($arrayTmpFiles);
                        redirect('importacaoPacote_progresso/'.$count.'/'.$filename.'/'.$size.'/'.$rowCount.'/'.$insertCount.'/'.$updateCount.'/'.$notAddCount.'/'.$duplicidade.'/'.$depara);
                    }

                    $basedir = $_SERVER['DOCUMENT_ROOT'];

                    $this->load->library('CSVReader');

                    $rowCount = $this->input->post('rowcount');
                    $insertCount = $this->input->post('insertcount');
                    $updateCount = $this->input->post('updatecount');
                    $notAddCount = $this->input->post('notaddcount');
                    $duplicidade = $this->input->post('duplicidade');

                    $csvData = $this->csvreader->parse_csv($basedir.'/tmp/'.$this->input->post('filename').'_'.$this->input->post('progresso').'.csv');
                    $dePara = $this->ImportacaoModel->consultaDePara($this->input->post('depara'),'Pacote',$this->session->userdata('IdEmpresa'));

                    $errosDeChave = array();

                    // Insert/update CSV data into database
                    if(!empty($csvData)){
                        foreach($csvData as $row) {
                            $rowCount++;

                            $memData = array();

                            for ($i=0;$i<count($dePara);$i++) {
                                if (!isset($row[(preg_replace('/\s+/', '', $dePara[$i]->No_CampoOrigem))])) {$campoNaoLocalizado = 'true';}
                                if (isset($row[(preg_replace('/\s+/', '', $dePara[$i]->No_CampoOrigem))])) {
                                    if (preg_replace('/\s+/', '', $dePara[$i]->St_Valor) == 'S' || $dePara[$i]->St_Data == 'S') {
                                        if (preg_replace('/\s+/', '', $dePara[$i]->St_Valor) == 'S') {
                                            $memData += array(
                                                (preg_replace('/\s+/', '', $dePara[$i]->No_CampoDestino)) => $this->valor($row[(preg_replace('/\s+/', '', $dePara[$i]->No_CampoOrigem))])
                                            );
                                        }
                                        if (preg_replace('/\s+/', '', $dePara[$i]->St_Data) == 'S') {
                                            $memData += array(
                                                (preg_replace('/\s+/', '', $dePara[$i]->No_CampoDestino)) => $this->data($row[(preg_replace('/\s+/', '', $dePara[$i]->No_CampoOrigem))])
                                            );
                                        }
                                    } else {
                                        $memData += array(
                                            (preg_replace('/\s+/', '', $dePara[$i]->No_CampoDestino)) => $this->data($row[(preg_replace('/\s+/', '', $dePara[$i]->No_CampoOrigem))])
                                        );
                                    }
                                }
                            }

                            $memData += array(
                            //    'TbUsuEmp_Id_UsuEmp' => $this->session->userdata('IdUsuEmp'),
                                'id_empresa'=>$this->session->userdata('IdEmpresa'),
                              //  'criadopor'=>$this->vendorId,
                                'tp_ativo'=> 'S'
                            );                                                        
                            
                            $insert = $this->ImportacaoModel->adicionaTabelaDepara($memData,$dePara[0]->No_Tabela);

                            if($insert){
                                $insertCount++;
                            } else {
                                array_push($errosDeChave, ($rowCount+1));
                                $notAddCount++;
                            }

                        }

                        $temp = null;

                        /* DEBUG DE CHAVE NÃO LOCALIZADA */
                        $i = 0;
                        foreach ($errosDeChave as $row) {
                        $i++;
                        if ($i < sizeof($errosDeChave) ) { 
                            $temp .= $row . ', ';
                        } else {
                            $temp .= $row;
                        }
                        }

                        $this->session->set_flashdata('errosDeChaveMsg', $temp);

                        // Status message with imported data count
                        $notAddCount = ($rowCount - ($insertCount + $updateCount));
                        $successMsg = 'Tabela '.$dePara[0]->No_Tabela.' importada com sucesso! Qtd. Linhas ('.$rowCount.') | Inseridos ('.$insertCount.') | Atualizados ('.$updateCount.') | Não inseridos ('.$notAddCount.')';

                        $this->session->set_flashdata('num_linhas_importadas', $insertCount);
                        if ($campoNaoLocalizado == '') {
                            $successMsg = 'Tabela '.$dePara[0]->No_Tabela.' importada com sucesso! Qtd. Linhas ('.$rowCount.') | Inseridos ('.$insertCount.') | Atualizados ('.$updateCount.') | Não inseridos ('.$notAddCount.')';
                            $this->session->set_flashdata('success', $successMsg);
                        } else {
                            $successMsg = 'Tabela '.$dePara[0]->No_Tabela.' importada com sucesso! Qtd. Linhas ('.$rowCount.') | Inseridos ('.$insertCount.') | Atualizados ('.$updateCount.') | Não inseridos ('.$notAddCount.')
                            <br/><strong>OBS: Algumas colunas do CSV não tem DEPARA cadastrado</strong>';
                            $this->session->set_flashdata('success', $successMsg);
                        }
                    }
                }
            }else{
                $this->session->set_flashdata('error', 'Erro no upload do arquivo, verifique se é um arquivo CSV válido e tente novamente.');
                redirect('importacaoPacote');
            }
        }else{
            $this->session->set_flashdata('error', 'Arquivo inválido! Selecione um arquivo CSV');
            //    $this->session->set_userdata('error_msg', 'Invalid file, please select only CSV file.');
        }

    if ($this->input->post('progresso') != '' && $this->input->post('progresso') <= $this->input->post('size')) {
        $count = $this->input->post('progresso') + 1;
        redirect('importacaoPacote_progresso/'.$count.'/'.$this->input->post('filename').'/'.$this->input->post('size').'/'.$rowCount.'/'.$insertCount.'/'.$updateCount.'/'.$notAddCount.'/'.$duplicidade.'/'.$this->input->post('depara'));
        } else {  
            //redirecionar para página de finalização
            redirect('importacaoPacote_progresso/completo/'.$this->input->post('filename').'/'.$this->input->post('size').'/'.$rowCount.'/'.$insertCount.'/'.$updateCount.'/'.$notAddCount.'/'.$duplicidade.'/'.$this->input->post('depara'));
        }
    }


    // IMPORTAÇÃO ANALISE BI

    function importacaoAnaliseBI()
    {
      //  $data['roles'] = $this->user_model->getUserRoles();

        $this->global['pageTitle'] = 'QUALICAD : Importação Análise BI';

    //    $data['infoProducao'] = $this->ImportacaoModel->carregaInfoProducao($this->session->userdata('IdEmpresa'));
        $data['infoLayoutImportacao'] = $this->ImportacaoModel->carregaInfoLayoutImportacaoEmpresa('AnaliseBI',$this->session->userdata('IdEmpresa'));

        $this->loadViews("qualicad/importacao/importacaoAnaliseBI", $this->global, $data, NULL);
    }

    public function importaAnaliseBI(){
        $data = array();
        $memData = array();

        //    $DePara = $this->ImportacaoModel->consultaDePara('GrupoPro',$this->session->userdata('IdEmpresa'));

        // If import request is submitted
        if($this->input->post('importSubmit')){
            // Form field validation rules
           // $this->load->library('form_validation');

        //    $this->form_validation->set_rules('file', 'CSV file', 'callback_file_check');

            // Validate submitted form data
            if(true){
                $insertCount = $updateCount = $rowCount = $notAddCount = $duplicidade = 0;

                // If file uploaded
                if(is_uploaded_file($_FILES['file']['tmp_name'])){
                    // Load CSV reader library
                    $this->load->library('CSVReader');

                    // Parse data from CSV file
                    $csvData = $this->csvreader->parse_csv($_FILES['file']['tmp_name']);
                    $dePara = $this->ImportacaoModel->consultaDePara($this->input->post('Tb_Id_LayoutImportacao'),'AnaliseBI',$this->session->userdata('IdEmpresa'));

                    $errosDeChave = array();
                    $campoNaoLocalizado = '';

                    // Insert/update CSV data into database
                    if(!empty($csvData)){
                        foreach($csvData as $row) {
                            $rowCount++;

                            $memData = array();

                            for ($i=0;$i<count($dePara);$i++) {

                                if (!isset($row[(trim($dePara[$i]->No_CampoOrigem))])) {var_dump($dePara[$i]->No_CampoOrigem);exit;$campoNaoLocalizado = 'Algumas colunas do CSV não tem DEPARA cadastrado';}
                                if (isset($row[(trim($dePara[$i]->No_CampoOrigem))])) {
                                    if (trim($dePara[$i]->St_Valor) == 'S' || trim($dePara[$i]->St_Data) == 'S') {
                                        if (trim($dePara[$i]->St_Valor) == 'S') {
                                            $memData += array(
                                                (trim($dePara[$i]->No_CampoDestino)) => $this->valor($row[(trim($dePara[$i]->No_CampoOrigem))])
                                            );
                                        }
                                        if (trim($dePara[$i]->St_Data == 'S')) {
                                            $memData += array(
                                                (trim($dePara[$i]->No_CampoDestino)) => $this->data($row[(trim($dePara[$i]->No_CampoOrigem))])
                                            );
                                        }
                                    } else {
                                        if (trim($dePara[$i]->No_CampoOrigem) == 'Empresa') {
                                            
                                            //GRAVA O CD_EMPRESAERP
                                            $memData += array(
                                                (trim($dePara[$i]->No_CampoDestino)) => $this->data($row[(trim($dePara[$i]->No_CampoOrigem))])
                                            );
                                            
                                            //GRAVA O ID_EMPRESA
                                            $memData += array(
                                                'tbempresa_id_empresa' => $this->ImportacaoModel->consultaIdEmpresaPorERP($this->data($row[(trim($dePara[$i]->No_CampoOrigem))]))[0]->Id_Empresa
                                            );

                                            }
                                            else {
                                            $memData += array(
                                                (trim($dePara[$i]->No_CampoDestino)) => $this->data($row[(trim($dePara[$i]->No_CampoOrigem))])
                                            );
                                            }
                                    }
                                }
                            }
                            
                            $memData += array(                            
                                'dt_criacao'=>date('Y-m-d'),
                                'criadopor'=>$this->vendorId,
                                'tp_ativo'=> 'S');

                            //    var_dump($memData);exit;
                            
                            $insert = 0;
                        /*    // ***** VERIFICAÇÕES DE DUPLICIDADE NA ADIÇÃO *****
                            if (isset($memData['TbProFat_Cd_ProFat'])&&isset($memData['Dt_Lancamento'])&&isset($memData['TbPlano_Id_Plano'])) {
                            if ($this->ImportacaoModel->consultaRegraTbProducaoExistente($memData['TbProFat_Cd_ProFat'],$memData['Dt_Lancamento'],$memData['TbPlano_Id_Plano'],$this->session->userdata('IdEmpresa')) != null) {
                                $duplicidade++;
                                } else {
                                    $insert = $this->ImportacaoModel->adicionaProducao($memData);
                                }
                            }                        
                            // ***** FIM DE VERIFICAÇÕES ***** */

                            $insert = $this->ImportacaoModel->adicionaAnaliseBI($memData);

                            if($insert){
                                $insertCount++;
                            } else {
                                array_push($errosDeChave, ($rowCount+1));
                                $notAddCount++;
                            }

                        }

                        $temp = null;

                        /* DEBUG DE CHAVE NÃO LOCALIZADA */
                        $i = 0;
                        foreach ($errosDeChave as $row) {
                        $i++;
                        if ($i < sizeof($errosDeChave) ) { 
                            $temp .= $row . ', ';
                        } else {
                            $temp .= $row;
                        }
                        }

                        $this->session->set_flashdata('errosDeChaveMsg', $temp);

                        // Status message with imported data count
                        $notAddCount = ($rowCount - ($insertCount + $updateCount));
                        $successMsg = 'Tabela Análise BI importada com sucesso! Qtd. Linhas ('.$rowCount.') | Inseridos ('.$insertCount.') | Atualizados ('.$updateCount.') | Não inseridos ('.$notAddCount.') | Duplicidades ('.$duplicidade.')';

                        $this->session->set_flashdata('num_linhas_importadas', $insertCount);
                        if ($campoNaoLocalizado == '') {
                            $this->session->set_flashdata('success', $successMsg);
                        } else {
                            $this->session->set_flashdata('error', $campoNaoLocalizado);
                        }
                    }
                }else{
                    $this->session->set_flashdata('error', 'Erro no upload do arquivo, verifique se é um arquivo CSV válido e tente novamente.');
                }
            }else{
                $this->session->set_flashdata('error', 'Arquivo inválido! Selecione um arquivo CSV');
                //    $this->session->set_userdata('error_msg', 'Invalid file, please select only CSV file.');
            }
        }
        redirect('importacaoAnaliseBI');
    }


    function atualizarFatItemPelaSimpro()
    {
        $data['roles'] = $this->user_model->getUserRoles();

        $this->global['pageTitle'] = 'QUALICAD : Atualizar FatItem Pela Simpro';
        
        $data['infoFaturamento'] = $this->ImportacaoModel->carregaInfoFaturamentoAtualizarFatItem();

        $data['infoNumeroMsg'] = $this->ImportacaoModel->carregaInfoSimproMsgs();
        
        $this->loadViews("qualicad/importacao/atualizarFatItemPelaSimpro", $this->global, $data, NULL);
    }

    public function atualizaFatItemPelaSimpro(){

        $carregaSimproPelaMsg = $this->ImportacaoModel->carregaSimproPelaMsg($this->input->post('NumeroMsg'));
        
        foreach($carregaSimproPelaMsg as $row) {

            $verCondInclFatItemPelaSimpro = $this->ImportacaoModel->verCondInclFatItemPelaSimpro($row->Cd_Simpro,$this->input->post('TbFaturamento_Id_Faturamento'),$this->input->post('NumeroMsg')); 
                            
            if ($verCondInclFatItemPelaSimpro != null) {
                $verSeExisteCdSimproNaFatItem = $this->ImportacaoModel->verSeExisteCdSimproNaFatItem($row->Cd_Simpro,$this->input->post('TbFaturamento_Id_Faturamento'));
                    if($verSeExisteCdSimproNaFatItem == null) {
                        $atualizaInclusaoFatItem = $this->ImportacaoModel->inclusaoFatItemPelaSimpro($verCondInclFatItemPelaSimpro);                        
                    }                        
                }

        }

            $atualizaPrecoFatItem = $this->ImportacaoModel->precoFatItemPelaSimpro($this->input->post('NumeroMsg'));
            $atualizaAlteracoesFatItem = $this->ImportacaoModel->alteracoesFatItemPelaSimpro($this->input->post('NumeroMsg'));

            $atualizaForadeLinhaFatItem = $this->ImportacaoModel->foradeLinhaFatItemPelaSimpro($this->input->post('NumeroMsg'));

            $successMsg = '<strong>Processamento concluído!</strong><br/>Incluídos ('.($atualizaInclusaoFatItem?$atualizaInclusaoFatItem:0).') | Atual. Preço ('.$atualizaPrecoFatItem.') | Atual. Alterações ('.$atualizaAlteracoesFatItem.') | Atual. Fora de Linha ('.$atualizaForadeLinhaFatItem.')';

            $this->session->set_flashdata('success', $successMsg);

            redirect('atualizarFatItemPelaSimpro');
    }


    function atualizarFatItemPelaBrasindice()
    {
        $data['roles'] = $this->user_model->getUserRoles();

        $this->global['pageTitle'] = 'QUALICAD : Atualizar FatItem Pela Brasindice';
        
        $data['infoFaturamento'] = $this->ImportacaoModel->carregaInfoFaturamentoAtualizarFatItem();

        $data['infoNumeroMsg'] = $this->ImportacaoModel->carregaInfoBrasindiceMsgs();
        
        $this->loadViews("qualicad/importacao/atualizarFatItemPelaBrasindice", $this->global, $data, NULL);
    }

    public function atualizaFatItemPelaBrasindice()
    {
        exit;
        $carregaSimproPelaMsg = $this->ImportacaoModel->carregaSimproPelaMsg($this->input->post('NumeroMsg'));
        
        foreach($carregaSimproPelaMsg as $row) {

            $verCondInclFatItemPelaSimpro = $this->ImportacaoModel->verCondInclFatItemPelaSimpro($row->Cd_Simpro,$this->input->post('TbFaturamento_Id_Faturamento'),$this->input->post('NumeroMsg')); 
                            
            if ($verCondInclFatItemPelaSimpro != null) {
                $verSeExisteCdSimproNaFatItem = $this->ImportacaoModel->verSeExisteCdSimproNaFatItem($row->Cd_Simpro,$this->input->post('TbFaturamento_Id_Faturamento'));
                    if($verSeExisteCdSimproNaFatItem == null) {
                        $atualizaInclusaoFatItem = $this->ImportacaoModel->inclusaoFatItemPelaSimpro($verCondInclFatItemPelaSimpro);                        
                    }                        
                }

        }

            $atualizaPrecoFatItem = $this->ImportacaoModel->precoFatItemPelaSimpro($this->input->post('NumeroMsg'));
            $atualizaAlteracoesFatItem = $this->ImportacaoModel->alteracoesFatItemPelaSimpro($this->input->post('NumeroMsg'));

            $atualizaForadeLinhaFatItem = $this->ImportacaoModel->foradeLinhaFatItemPelaSimpro($this->input->post('NumeroMsg'));

            $successMsg = '<strong>Processamento concluído!</strong><br/>Incluídos ('.($atualizaInclusaoFatItem?$atualizaInclusaoFatItem:0).') | Atual. Preço ('.$atualizaPrecoFatItem.') | Atual. Alterações ('.$atualizaAlteracoesFatItem.') | Atual. Fora de Linha ('.$atualizaForadeLinhaFatItem.')';

            $this->session->set_flashdata('success', $successMsg);

            redirect('atualizarFatItemPelaSimpro');
    }

    /*
     * Callback function to check file value and type during validation
     */
    public function file_check($str){
        $allowed_mime_types = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain');
        if(isset($_FILES['file']['name']) && $_FILES['file']['name'] != ""){
            $mime = get_mime_by_extension($_FILES['file']['name']);
            $fileAr = explode('.', $_FILES['file']['name']);
            $ext = end($fileAr);
            if((($ext == 'csv') || ($ext == 'CSV')) && in_array($mime, $allowed_mime_types)){
                return true;
            }else{
                $this->form_validation->set_message('file_check', 'Favor selecione somente um arquivo CSV.');
                return false;
            }
        }else{
            $this->form_validation->set_message('file_check', 'Favor selecione somente um arquivo CSV.');
            return false;
        }
    }

    function listaNotificacaoCarga()
    {
        $data['roles'] = $this->user_model->getUserRoles();

        $this->global['pageTitle'] = 'QUALICAD : Notificação de carga';

        $data['infoNotificacaoCarga'] = $this->ImportacaoModel->carregaInfoNotificacaoCarga();

        $this->loadViews("qualicad/importacao/l_notificacaoCarga", $this->global, $data, NULL);
    }


    function limpaNotificacaoCarga()
    {
        $data = array();

        $data['id_notificacao_carga'] = $this->uri->segment(2);
        $data['st_acessado'] = 'sim';

        $resultado = $this->ImportacaoModel->limpaNotificacaoCarga($data);

        if ($resultado) {

            $process = 'Limpar notificação de carga';
            $processFunction = 'Importacao/limpaNotificacaoCarga';
            $this->logrecord($process,$processFunction);

            if ($resultado === 1451) {
                $this->session->set_flashdata('error', 'Erro na limpeza das notificações');
            }
            else {
                $this->session->set_flashdata('success', 'Limpeza realizada com sucesso');
            }

        }
        else
        {
            $this->session->set_flashdata('error', 'Erro na limpeza das notificações');
        }
        redirect('listaNotificacaoCarga');
    }

    function valor($val)
    {
        $val = str_replace(",",".",$val);
        $val = preg_replace('/\.(?=.*\.)/', '', $val);
       // return ($val); 
        return floatval($val);      
    }

    function data($data)
    {
        if ($data == '') { 
            return null; 
        }
        return str_replace("'","",preg_replace("/(\d+)\D+(\d+)\D+(\d+)/","$3-$2-$1",$data));
    }

    function adicionaCabecalhoSimpro($data, $headers = null) {
        $outstream = fopen("php://output", "a");
        function __outputCSV(&$vals, $key, $filehandler) {
            fputcsv($filehandler, $vals); // add parameters if you want
        }
        if ($headers) {
            $data = array_merge(array($headers), $data);
        }
        array_walk($data, "__outputCSV", $outstream);
        fclose($outstream);
    }


    function splitCsv($arquivoCSV, $semHeader=null) {

        $arrayTmpFiles = [];
        $split_dir = $_SERVER['DOCUMENT_ROOT'];
        $ufile_target = '';

        array_map( 'unlink', array_filter((array) glob($split_dir."/tmp/*") ) );
        
        $file_header = '';
        $file_content = '';
        $max_rows = 500;

        $file_src = $arquivoCSV;
        $file_name = str_replace('.csv','',$arquivoCSV);
        $file_counter = 1; // append to end of file name
  
        $i = 0; // source file row counter
        $col = 0; // source file row counter
        $row = 1; // destination file counter (keep under $max_rows)
        
        if(($handle = fopen($file_src, 'r')) !== FALSE) {
  
          while (($data = fgetcsv($handle, 0, ',')) !== FALSE) {
            $col = count($data);
            //echo '<pre>'.print_r($data,1).'</pre>';
            if($i==0){
              
              // store the file header
              for($n=0;$n<$col;$n++){
                if($n>0){
                  $file_header.= ',';
                }
                
                $file_header.= $data[$n];
              }
              
              $file_header.= "\n";
            }
            else{
              if($row<$max_rows){
                for($n=0;$n<$col;$n++){
                  if($n>0){
                    $file_content.= ',';
                  }
                
                  $file_content.= $data[$n];
                }
                
                $file_content.= "\n";
              }
              else{
                if ($file_counter!=1&&$semHeader) { $file_header = null; }
                $this->make_file($file_name,$file_counter,$split_dir,$file_header,$file_content);
                
                array_push($arrayTmpFiles,$file_name.'_'.$file_counter);
                
                // increment
                $file_counter++;
                
                // reset
                $file_content = '';
                
                // record this row
                for($n=0;$n<$col;$n++){
                  if($n>0){
                    $file_content.= ',';
                  }
  
                  $file_content.= $data[$n];
                }
                
                $file_content.= "\n";
                
                
                $row = 1;
              }
              $row++;
            }
            $i++;
          }
          
          if ($file_counter!=1&&$semHeader) { $file_header = null; }
          $this->make_file($file_name,$file_counter,$split_dir,$file_header,$file_content);
          
          array_push($arrayTmpFiles,$file_name.'_'.$file_counter);
          
          fclose($handle);

        }

        return ($arrayTmpFiles);
          
    }

      function make_file($file_name,$file_counter,$split_dir,$file_header,$file_content){
    
        // name file
        $name = $file_name.'_'.$file_counter.'.csv';

        $basedir = $_SERVER['DOCUMENT_ROOT'];
        
        // set path
        $path =  $basedir.$name;
        
        // set content
        $content = str_replace('', '"', $file_header.$file_content);
        
        // save file
        if(($fp = fopen($path, 'w+')) !== FALSE) {
          fwrite($fp, $content);
          fclose($fp);
        }
        
      }

}