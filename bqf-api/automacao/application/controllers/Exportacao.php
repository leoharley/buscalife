<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';
/**
 * Class : Admin (AdminController)
 * Admin class to control to authenticate admin credentials and include admin functions.
 * @author : Samet Aydın / sametay153@gmail.com
 * @version : 1.0
 * @since : 27.02.2018
 */

class Exportacao extends BaseController
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
        $this->load->model('ExportacaoModel');
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

    //  EXPORTACAO FAT ITEM

    function exportaFatItem()
    {
        $var = $this->uri->segment(2);

        /* file name */
		$filename = 'TbFatItem.csv';

		$exportacao = $this->ExportacaoModel->exportaFatItem($this->session->userdata('IdEmpresa'),$var);

        header('Content-type: aapplication/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-type: application/force-download');
        header('Content-Disposition: attachment; filename='.$filename.'');
        header('Pragma: no-cache');
        header('Cache-Control: max-age=0');
        header('X-Accel-Buffering: no');
        ob_clean();
        flush();

        $handle = fopen('php://output', 'w');
        fputcsv($handle, array('Id_FatItem', 'CodFatItem', 'TbFaturamento_Id_Faturamento',
        'Ds_FatItem','Dt_IniVigencia','Dt_FimVigencia','Vl_Honorario','Vl_Operacional','Vl_Total',
        'Vl_Filme','Cd_PorteMedico','Cd_TUSS','Cd_TISS','Qt_Embalagem','Ds_Unidade','Tp_Ativo'),'|');

        foreach ($exportacao as $data) {
            fputcsv($handle, array($data->Id_FatItem, $data->CodFatItem, $data->TbFaturamento_Id_Faturamento,
            $data->Ds_FatItem,$data->Dt_IniVigencia,$data->Dt_FimVigencia,$this->valor($data->Vl_Honorário),$this->valor($data->Vl_Operacional),
            $this->valor($data->Vl_Total),$this->valor($data->Vl_Filme),$data->Cd_PorteMedico,$data->Cd_TUSS,$data->Cd_TISS,$data->Qt_Embalagem,
            $data->Ds_Unidade,$data->Tp_Ativo),'|');
        }
            fclose($handle);
        exit;
    }

    //  EXPORTACAO GRUPOPRO

    function exportaGrupoPro()
    {
        $var = $this->uri->segment(2);

        /* file name */
        $filename = 'TbGrupoPro.csv';

        $exportacao = $this->ExportacaoModel->exportaGrupoPro($this->session->userdata('IdEmpresa'),$var);

        header('Content-type: aapplication/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-type: application/force-download');
        header('Content-Disposition: attachment; filename='.$filename.'');
        header('Pragma: no-cache');
        header('Cache-Control: max-age=0');
        header('X-Accel-Buffering: no');
        ob_clean();
        flush();

        $handle = fopen('php://output', 'w');
        fputcsv($handle, array('CodGrupoPro', 'Ds_GrupoPro', 'Tp_GrupoPro',
            'Desc_Tp_GrupoPro','Dt_Criacao','Tp_Ativo'),'|');

        foreach ($exportacao as $data) {
            fputcsv($handle, array($data->CodGrupoPro, $data->Ds_GrupoPro, $data->Tp_GrupoPro,
                $data->Desc_Tp_GrupoPro,$data->Dt_Criacao,$data->Tp_Ativo),'|');
        }
        fclose($handle);
        exit;
    }

    //  EXPORTACAO PROFAT

    function exportaProFat()
    {
        $var = $this->uri->segment(2);

        /* file name */
        $filename = 'TbProFat.csv';

        $exportacao = $this->ExportacaoModel->exportaProFat($this->session->userdata('IdEmpresa'),$var);

        header('Content-type: aapplication/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-type: application/force-download');
        header('Content-Disposition: attachment; filename='.$filename.'');
        header('Pragma: no-cache');
        header('Cache-Control: max-age=0');
        header('X-Accel-Buffering: no');
        ob_clean();
        flush();

        $handle = fopen('php://output', 'w');
        fputcsv($handle, array('CodProFat', 'Ds_ProFat', 'Ds_Unidade',
            'TbGrupoPro_CodGrupo','Tp_Ativo'),'|');

        foreach ($exportacao as $data) {
            fputcsv($handle, array($data->CodProFat, $data->Ds_ProFat, $data->Ds_Unidade,
                $data->TbGrupoPro_CodGrupo,$data->Tp_Ativo),'|');
        }
        fclose($handle);
        exit;
    }

    //  EXPORTACAO TUSS

    function exportaTUSS()
    {
        $var = $this->uri->segment(2);

        /* file name */
        $filename = 'TbTUSS.csv';

        $exportacao = $this->ExportacaoModel->exportaTUSS($this->session->userdata('IdEmpresa'),$var);

        header('Content-type: aapplication/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-type: application/force-download');
        header('Content-Disposition: attachment; filename='.$filename.'');
        header('Pragma: no-cache');
        header('Cache-Control: max-age=0');
        header('X-Accel-Buffering: no');
        ob_clean();
        flush();

        $handle = fopen('php://output', 'w');
        fputcsv($handle, array('TbProFat_Cd_ProFat', 'TbConvenio_Id_Convenio', 'Cd_Tuss',
            'Ds_Tuss','Dt_IniVigencia','Dt_FimVigencia','TbEmpresa_Id_Empresa','TP_TUSS','DS_TIP_TUSS','cd_gru_pro'),'|');

        foreach ($exportacao as $data) {
            fputcsv($handle, array($data->TbProFat_Cd_ProFat, $data->TbConvenio_Id_Convenio, $data->Cd_Tuss,
                $data->Ds_Tuss,$data->Dt_IniVigencia,$data->Dt_FimVigencia,$data->TbEmpresa_Id_Empresa,$data->TP_TUSS
                ,$data->DS_TIP_TUSS,$data->cd_gru_pro),'|');
        }
        fclose($handle);
        exit;
    }

    //  EXPORTACAO REGRAGRUPRO

    function exportaRegraGruPro()
    {
        $var = $this->uri->segment(2);

        /* file name */
        $filename = 'Tb_RegraGruPro.csv';

        $exportacao = $this->ExportacaoModel->exportaRegraGruPro($this->session->userdata('IdEmpresa'),$var);

        header('Content-type: aapplication/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-type: application/force-download');
        header('Content-Disposition: attachment; filename='.$filename.'');
        header('Pragma: no-cache');
        header('Cache-Control: max-age=0');
        header('X-Accel-Buffering: no');
        ob_clean();
        flush();

        $handle = fopen('php://output', 'w');
        fputcsv($handle, array('TbGrupoPro_CodGrupo', 'TbRegra_Id_Regra', 'TbFaturamento_Id_Faturamento',
            'Perc_Pago','Dt_IniVigencia','Dt_FimVigencia'),'|');

        foreach ($exportacao as $data) {
            fputcsv($handle, array($data->TbGrupoPro_CodGrupo, $data->TbRegra_Id_Regra, $data->TbFaturamento_Id_Faturamento,
            $this->valor($data->Perc_Pago),$data->Dt_IniVigencia,$data->Dt_FimVigencia),'|');
        }
        fclose($handle);
        exit;
    }

    //  EXPORTACAO FRACAOSIMPROBRA

    function exportaFracaoSimproBra()
    {
        $var = $this->uri->segment(2);

        /* file name */
        $filename = 'Tb_FracaoSimproBra.csv';

        $exportacao = $this->ExportacaoModel->exportaFracaoSimproBra($this->session->userdata('IdEmpresa'),$var);

        header('Content-type: aapplication/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-type: application/force-download');
        header('Content-Disposition: attachment; filename='.$filename.'');
        header('Pragma: no-cache');
        header('Cache-Control: max-age=0');
        header('X-Accel-Buffering: no');
        ob_clean();
        flush();

        $handle = fopen('php://output', 'w');
        fputcsv($handle, array('TbProFat_CodProFat', 'TbFaturamento_Id_Faturamento', 'TbTUSS_Id_Tuss',
            'Ds_FracaoSimproBra','Ds_Laboratorio','Ds_Apresentacao','Tp_MatMed','Vl_FatorDivisao','Qt_Prod'),'|');

        foreach ($exportacao as $data) {
            fputcsv($handle, array($data->TbProFat_Cd_ProFat, $data->TbFaturamento_Id_Faturamento, $data->TbTUSS_Id_Tuss,
                $data->Ds_FracaoSimproBra,$data->Ds_Laboratorio,$data->Ds_Apresentacao,$data->Tp_MatMed,$this->valor($data->Vl_FatorDivisao),
                $data->Qt_Prod),'|');
        }
        fclose($handle);
        exit;
    }

    //  EXPORTACAO PRODUTO

    function exportaProduto()
    {
        $var = $this->uri->segment(2);

        /* file name */
        $filename = 'Tb_Produto.csv';

        $exportacao = $this->ExportacaoModel->exportaProduto($this->session->userdata('IdEmpresa'),$var);

        header('Content-type: aapplication/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-type: application/force-download');
        header('Content-Disposition: attachment; filename='.$filename.'');
        header('Pragma: no-cache');
        header('Cache-Control: max-age=0');
        header('X-Accel-Buffering: no');
        ob_clean();
        flush();

        $handle = fopen('php://output', 'w');
        fputcsv($handle, array('TbProFat_Cd_ProFat', 'Tb_Unidade_Id_Unidade', 'Cd_Produto',
            'Ds_Produto','Ds_Especie','Cd_ProdutoMestre','SN_Mestre','Vl_CustoMedio','Vl_Fator',
            'Vl_FatorProFat','Vl_CustoFinal'),'|');

        foreach ($exportacao as $data) {
            fputcsv($handle, array($data->TbProFat_Cd_ProFat, $data->Tb_Unidade_Id_Unidade, $data->Cd_Produto,
                $data->Ds_Produto,$data->Ds_Especie,$data->Cd_ProdutoMestre,$data->SN_Mestre,$this->valor($data->Vl_CustoMedio),
                $this->valor($data->Vl_Fator),$this->valor($data->Vl_FatorProFat),$this->valor($data->Vl_CustoFinal)),'|');
        }
        fclose($handle);
        exit;
    }

    //  EXPORTACAO PRODUCAO

    function exportaProducao()
    {
        $var = $this->uri->segment(2);

        /* file name */
        $filename = 'Tb_Producao.csv';

        $exportacao = $this->ExportacaoModel->exportaProducao($this->session->userdata('IdEmpresa'),$var);

        header('Content-type: aapplication/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-type: application/force-download');
        header('Content-Disposition: attachment; filename='.$filename.'');
        header('Pragma: no-cache');
        header('Cache-Control: max-age=0');
        header('X-Accel-Buffering: no');
        ob_clean();
        flush();

        $handle = fopen('php://output', 'w');
        fputcsv($handle, array('TbProFat_Cd_ProFat', 'TbPlano_Id_Plano', 'Num_Conta',
            'Num_Atendimento','Dt_Lancamento','Qt_Lancamento','Vl_Conta','Cd_Movimento','Cd_ITMovimento'),'|');

        foreach ($exportacao as $data) {
            fputcsv($handle, array($data->TbProFat_Cd_ProFat, $data->TbPlano_Id_Plano, $data->Num_Conta,
                $data->Num_Atendimento,$data->Dt_Lancamento,$data->Qt_Lancamento,$data->Vl_Conta,$data->Cd_Movimento,
                $data->Cd_ITMovimento),'|');
        }
        fclose($handle);
        exit;
    }

    //  EXPORTACAO CONTRATO

    function exportaContrato()
    {
        $var = $this->uri->segment(2);

        /* file name */
        $filename = 'Tb_Contrato.csv';

        $exportacao = $this->ExportacaoModel->exportaContrato($this->session->userdata('IdEmpresa'),$var);

        header('Content-type: aapplication/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-type: application/force-download');
        header('Content-Disposition: attachment; filename='.$filename.'');
        header('Pragma: no-cache');
        header('Cache-Control: max-age=0');
        header('X-Accel-Buffering: no');
        ob_clean();
        flush();

        $handle = fopen('php://output', 'w');
        fputcsv($handle, array('Cd_EmpresaERP', 'Cd_ConvenioERP', 'Cd_PlanoERP', 'Cd_ProFatERP', 'Cd_IndiceERP', 
        'Ds_IndiceERP', 'Dt_VigenciaIndiceERP', 'Vl_IndiceERP', 'Vl_FilmeIndiceERP', 'Vl_HonorarioIndiceERP', 
        'Vl_UCOIndiceERP', 'Cd_RegraERP', 'Ds_RegraERP', 'Cd_TabFatERP', 'Ds_TabFatERP', 'Cd_MoedaERP', 
        'Ds_MoedaERP', 'Cd_RegraGruProErp', 'Ds_RegraGruProErp', 'Per_RegraPGErp', 'Ds_ProFatERP', 'UnidadeProFatERP', 
        'Vl_ProHonorarioERP', 'Vl_ProOperaçãoERP', 'Vl_ProTotalERP', 'Vl_ProExcecValorERP', 'Ds_PrestadoraExcec', 
        'Qtde_M2FilmeERP', 'Cd_PortMedicoERP', 'Ds_PortMedicoERP', 'Vl_PorteMedicoERP', 'Cd_ExcecPorMedicoERP', 
        'Vl_ExcecPorMedicoERP', 'Vl_FinalERP', 'Vl_FinalExecERP', 'Tp_ProibicaoERP'),'|');

        foreach ($exportacao as $data) {
            fputcsv($handle, array($data->Cd_EmpresaERP, $data->Cd_ConvenioERP, $data->Cd_PlanoERP,
                $data->Cd_ProFatERP,$data->Cd_IndiceERP,$data->Ds_IndiceERP,$data->Dt_VigenciaIndiceERP,$this->valor($data->Vl_IndiceERP),
                $this->valor($data->Vl_FilmeIndiceERP),$this->valor($data->Vl_HonorarioIndiceERP),$this->valor($data->Vl_UCOIndiceERP),$data->Cd_RegraERP,
                $data->Ds_RegraERP,$data->Cd_TabFatERP,$data->Ds_TabFatERP,$data->Cd_MoedaERP,$data->Ds_MoedaERP,$data->Cd_RegraGruProErp,
                $data->Ds_RegraGruProErp,$data->Per_RegraPGErp,$data->Ds_ProFatERP,$data->UnidadeProFatERP,$this->valor($data->Vl_ProHonorarioERP),
                $this->valor($data->Vl_ProOperaçãoERP),$this->valor($data->Vl_ProTotalERP),$this->valor($data->Vl_ProExcecValorERP),$data->Ds_PrestadoraExcec,
                $data->Qtde_M2FilmeERP,$data->Cd_PortMedicoERP,$data->Ds_PortMedicoERP,$this->valor($data->Vl_PorteMedicoERP),$data->Cd_ExcecPorMedicoERP,
                $this->valor($data->Vl_ExcecPorMedicoERP),$this->valor($data->Vl_FinalERP),$this->valor($data->Vl_FinalExecERP),$data->Tp_ProibicaoERP),'|');
        }
        fclose($handle);
        exit;
    }

    //  EXPORTACAO PORTE MEDICO

    function exportaPorteMedico()
    {
        $var = $this->uri->segment(2);

        /* file name */
        $filename = 'TbPorteMedico.csv';

        $exportacao = $this->ExportacaoModel->exportaPorteMedico($this->session->userdata('IdEmpresa'),$var);

        header('Content-type: aapplication/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-type: application/force-download');
        header('Content-Disposition: attachment; filename='.$filename.'');
        header('Pragma: no-cache');
        header('Cache-Control: max-age=0');
        header('X-Accel-Buffering: no');
        ob_clean();
        flush();

        $handle = fopen('php://output', 'w');
        fputcsv($handle, array('Id_PorteMedico', 'Id_TabFaturamento', 'Cd_PorteMedico',
            'Ds_PorteMedico','Vl_PorteMedico'),'|');

        foreach ($exportacao as $data) {
            fputcsv($handle, array($data->Id_PorteMedico, $data->Id_TabFaturamento, $data->Cd_PorteMedico,
                $data->Ds_PorteMedico,$this->valor($data->Vl_PorteMedico)),'|');
        }
        fclose($handle);
        exit;
    }

    //  EXPORTACAO EXCECAO VALORES

    function exportaExcecaoValores()
    {
        $var = $this->uri->segment(2);

        /* file name */
        $filename = 'TbExcValores.csv';

        $exportacao = $this->ExportacaoModel->exportaExcecaoValores($this->session->userdata('IdEmpresa'),$var);

        header('Content-type: aapplication/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-type: application/force-download');
        header('Content-Disposition: attachment; filename='.$filename.'');
        header('Pragma: no-cache');
        header('Cache-Control: max-age=0');
        header('X-Accel-Buffering: no');
        ob_clean();
        flush();

        $handle = fopen('php://output', 'w');
        fputcsv($handle, array('Id_ExcValores', 'CD_Convenio', 'Cd_TUSS',
            'Cd_ProFat','Ds_ExcValores','ClasseEvento','Tp_ExcValores',
            'Vl_ExcValores'),'|');

        foreach ($exportacao as $data) {
            fputcsv($handle, array($data->Id_ExcValores, $data->CD_Convenio, $data->Cd_TUSS,
                $data->Cd_ProFat,$data->Ds_ExcValores,$data->ClasseEvento,$data->Tp_ExcValores,
                $this->valor($data->Vl_ExcValores)),'|');
        }
        fclose($handle);
        exit;
    }

    /* EXPORTACAO BI */
    function exportacaoBI()
    {
        $data['roles'] = $this->user_model->getUserRoles();

        $this->global['pageTitle'] = 'QUALICAD : Exportação BI';
        
        $data['infoControleCargaBI'] = $this->PrincipalModel->carregaInfoControleCronjob();

     /*   $data['empresasPerfilUsuario'] = $this->CadastroModel->carregaEmpresasPerfilUsuario($this->session->userdata('userId'));
        $data['infoConvenio'] = $this->PrincipalModel->carregaInfoConveniosEmpresa($this->session->userdata('IdEmpresa'));    */

        $this->loadViews("qualicad/exportacao/exportacaoBI", $this->global, $data, NULL);
    }

    function exportacaoBI_progresso()
    {
        $data['roles'] = $this->user_model->getUserRoles();

        $this->global['pageTitle'] = 'QUALICAD : Exportação BI';
        
        $data['empresasPerfilUsuario'] = $this->CadastroModel->carregaEmpresasPerfilUsuario($this->session->userdata('userId'));
        $data['infoConvenio'] = $this->PrincipalModel->carregaInfoConveniosEmpresa($this->session->userdata('IdEmpresa'));    

        $this->loadViews("qualicad/exportacao/exportacaoBI_progresso", $this->global, $data, NULL);
    }

    function exportacaoTbBI_progresso()
    {
        $data['roles'] = $this->user_model->getUserRoles();

        $this->global['pageTitle'] = 'QUALICAD : Exportação BI';
        
        $data['empresasPerfilUsuario'] = $this->CadastroModel->carregaEmpresasPerfilUsuario($this->session->userdata('userId'));
        $data['infoConvenio'] = $this->PrincipalModel->carregaInfoConveniosEmpresa($this->session->userdata('IdEmpresa'));    

        $this->loadViews("qualicad/exportacao/exportacaoTbBI_progresso", $this->global, $data, NULL);
    }

    function exportacaoBI_finalizar()
    {
        $data['roles'] = $this->user_model->getUserRoles();

        $this->global['pageTitle'] = 'QUALICAD : Exportação BI';

        $data['empresasPerfilUsuario'] = $this->CadastroModel->carregaEmpresasPerfilUsuario($this->session->userdata('userId'));
        $data['infoConvenio'] = $this->PrincipalModel->carregaInfoConveniosEmpresa($this->session->userdata('IdEmpresa'));

        $this->loadViews("qualicad/exportacao/exportacaoBI_finalizar", $this->global, $data, NULL);
    }

    function exportaBI()
    {
    /*   $idConvenio = $this->input->post('TbConvenio_Id_Convenio');
        $idEmpresa = $this->input->post('Id_Empresa');

        if ($idConvenio == '0') {
            $cargaBI = $this->ExportacaoModel->cargaBICompleto();
            redirect('exportacaoBI');
        }
        
        $apagaEmpresaTbBI = $this->ExportacaoModel->apagaEmpresaTbBI(($this->ExportacaoModel->consultaCodERPEmpresa(intval($idEmpresa)))[0]->Cd_EmpresaERP,$idConvenio);

        $cargaBI = $this->ExportacaoModel->cargaBI(($this->ExportacaoModel->consultaCodERPEmpresa(intval($idEmpresa)))[0]->Cd_EmpresaERP,$idConvenio); */

       // $this->ExportacaoModel->cargaHistoricoBI();        

        $infoControleCronjob = array('st_iniciar'=>1, 'st_concluido'=>0,'id_usuario'=>$this->vendorId);
        $id = 1;
        $atualizaControleCronjob = $this->ExportacaoModel->atualizaControleCronjob($id, $infoControleCronjob);

        if ($atualizaControleCronjob) { 
            $successMsg = '<strong>Atualização do BI solicitada com sucesso!</strong>';
            $this->session->set_flashdata('success', $successMsg);
        } else {
            $errorMsg = '<strong>Erro na solicitação!</strong>';
            $this->session->set_flashdata('error', $successMsg);
        }
        redirect('exportacaoBI');
    }

    function exportaBI_bkp()
    {
        if (array_key_exists('geraTbBI',$this->input->post())) {
            $this->exportaTbBI();
        }

        $idConvenio = $this->input->post('TbConvenio_Id_Convenio');
        $idEmpresa = $this->input->post('Id_Empresa');

        if ($this->input->post('offset') == '') {

        $apagaTmpConvenio = $this->ExportacaoModel->apagaTmpConvenio($this->input->post('Id_Empresa'));

        $this->ExportacaoModel->cargaTmpConvenio($idEmpresa,$idConvenio);

        $this->session->set_flashdata('offset', 'cargaTmpConvenio');
        $this->session->set_flashdata('idconvenio', $idConvenio);
        $this->session->set_flashdata('idempresa', $idEmpresa);

        redirect('exportacaoBI_progresso');

        } else if ($this->input->post('offset') == 'cargaTmpConvenio') {

        $apagaTmpContrato = $this->ExportacaoModel->apagaTmpContrato($this->input->post('Id_Empresa'));
		
        $this->ExportacaoModel->cargaTmpContrato(($this->ExportacaoModel->consultaCodERPEmpresa(intval($idEmpresa)))[0]->Cd_EmpresaERP,$idConvenio);

        $this->session->set_flashdata('offset', 'cargaTmpContrato');
        $this->session->set_flashdata('idconvenio', $idConvenio);
        $this->session->set_flashdata('idempresa', $idEmpresa);

        redirect('exportacaoBI_progresso');
        }

        else if ($this->input->post('offset') == 'cargaTmpContrato') {

        $apagaEmpresaTbBI = $this->ExportacaoModel->apagaEmpresaTbBI($this->input->post('Id_Empresa'));

        $this->ExportacaoModel->cargaBI();

        $this->ExportacaoModel->cargaHistoricoBI();

        $this->session->set_flashdata('offset', 'concluido');
        $this->session->set_flashdata('concluido', 'true');
        $this->session->set_flashdata('idconvenio', $idConvenio);
        $this->session->set_flashdata('idempresa', $idEmpresa);

        redirect('exportacaoBI_finalizar');

        }

    /*    $idConvenio = $this->input->post('TbConvenio_Id_Convenio');
        $idEmpresa = $this->input->post('Id_Empresa');

        set_time_limit(0);

        $todosInseridosConvenio = false;
        $todosInseridosContrato = false;
        $insertCountConvenio = $notAddCountConvenio = 0;
        $insertCountContrato = $notAddCountContrato = 0;

        if ($this->input->post('offset') == '') {
            $offset = 0;
            $this->session->set_flashdata('concluido', 'false');
            $insertCountConvenioSession = $notAddCountConvenioSession = 0;
            $insertCountContratoSession = $notAddCountContratoSession = 0;
        } else {
            $offset = $this->input->post('offset');
        }

        $insertCountConvenioSession = intval($this->input->post('insertCountConvenioSession'));
        $insertCountContratoSession = intval($this->input->post('insertCountContratoSession'));

        $limit = 25000;

        $consultaConvenioBI = $this->ExportacaoModel->consultaConvenioBI($idEmpresa,$idConvenio,$limit,$offset);

        $memData = array();
        if(!empty($consultaConvenioBI)){

            foreach($consultaConvenioBI as $row) {
                foreach($row as $key => $value) {
                    $memData += array(
                        $key => $value
                    );
                }
                $memData += array(
                    'Tp_Ativo'=> 'S');

                $insert = $this->ExportacaoModel->adicionaConvenio($memData);

                if($insert != 0){
                    $insertCountConvenioSession++;
                    $insertCountConvenio++;
                } else {
                    $notAddCountConvenioSession++;
                    $notAddCountConvenio++;
                }

                $memData = array();
            }
        }

        $consultaContratoBI = $this->ExportacaoModel->consultaContratoBI($this->ExportacaoModel->consultaCodERPEmpresa($idEmpresa)[0]->Cd_EmpresaERP,$idConvenio,$limit,$offset);

        $memData = array();
        if(!empty($consultaContratoBI)) {
            
            foreach ($consultaContratoBI as $row) {
                foreach ($row as $key => $value) {
                    $memData += array(
                        $key => $value
                    );
                }
                $memData += array(
                    'Tp_Ativo' => 'S');

                $insert = $this->ExportacaoModel->adicionaContrato($memData);

                if ($insert != 0) {
                    $insertCountContrato++;
                    $insertCountContratoSession++;
                } else {
                    $notAddCountContrato++;
                    $notAddCountContratoSession++;
                }

                $memData = array();
            }
        }

        $offset = $offset + 25000;

        $this->session->set_flashdata('offset', $offset);

        if ($insertCountConvenio == '')
        {
            $msgInseridosConvenio = 'Todas as linhas foram inseridas ('.$insertCountConvenioSession.')' ;
            $todosInseridosConvenio = true;
        } else {
            $msgInseridosConvenio = 'Inseridos até agora ('.$insertCountConvenioSession.')';
        }

        if ($insertCountContrato == '')
        {
            $msgInseridosContrato = 'Todas as linhas foram inseridas ('.$insertCountContratoSession.')' ;
            $todosInseridosContrato = true;
        } else {
            $msgInseridosContrato = 'Inseridos até agora ('.$insertCountContratoSession.')';
        }

        $successMsg = 'TMP_CONVENIO: '.$msgInseridosConvenio.' | Não inseridos ('.$notAddCountConvenio.')<br/>
                        TMP_CONTRATO: '.$msgInseridosContrato.' | Não inseridos ('.$notAddCountContrato.')';

        $this->session->set_flashdata('success', $successMsg);

        $this->session->set_flashdata('idconvenio', $idConvenio);

        $this->session->set_flashdata('insertCountContratoSession', $insertCountContratoSession);
        $this->session->set_flashdata('insertCountConvenioSession', $insertCountConvenioSession);
        

        // COLOCAR NA SESSION O notAddCountConvenio E O notAddCountContrato

        if ($todosInseridosConvenio && $todosInseridosContrato) {
        //    redirect('exportacaoTbBI_progresso');
            $this->session->set_flashdata('concluido tabelas temporárias, agora clique no botão abaixo para gerar a TbBI', 'true');
            redirect('exportacaoBI_finalizar');
        } else {
            redirect('exportacaoBI_progresso');
        }
        */
    }

    function geraCsvBI()
    {

    $filename = 'exportBI.csv';

    $exportacao = $this->ExportacaoModel->exportaTbBI();

        header('Content-type: aapplication/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-type: application/force-download');
        header('Content-Disposition: attachment; filename='.$filename.'');
        header('Pragma: no-cache');
        header('Cache-Control: max-age=0');
        header('X-Accel-Buffering: no');
        ob_clean();
        flush();

        $handle = fopen('php://output', 'w');
        fputcsv($handle, array('cd_emp', 'cd_convenio', 'nm_convenio', 'cd_plano', 'ds_plano', 'cd_Regra', 'ds_Regra', 'cd_tab_Fat', 'ds_Tab_Fat', 'Cd_GrupoPro', 'Ds_GrupoPro', 'Tp_GrupoPro', 'Tp_Moeda_tab_fat', 'perc_pgto', 'cd_indice', 'ds_indice', 'vl_indice', 'vl_M2filme', 'vl_honorario_ind', 'vl_uco_ind', 'cd_profat', 'ds_pro_Fat', 'ds_unidade_Fat', 'Vl_HonorarioProced', 'Vl_OperacaoProced', 'Vl_TotalProced', 'QT_M2_FILME_cont', 'Vl_ExcecaoProced', 'CD_PRESTADOR', 'Cd_PorteMedico', 'Ds_PorteMedico', 'Vl_PorteMedico', 'Cd_PorteMedicoExcecao', 'Vl_PorteMedicoExcecao', 'Vl_BrutoProced', 'vl_contrato_neg', 'Vl_ExcecaoProced_final', 'Vl_ContratoProced', 'Cd_ProibicaoRegra', 'Tp_ProibicaoRegra', 'Tp_AtendProibicaoRegra', 'Vl_ProibicaoRegra', 'TP_PROIBICAO', 'TP_TUSS', 'DS_TIP_TUSS', 'Cd_Tuss', 'Ds_Tuss', 'CD_TISS', 'cd_tuss_Valido', 'ds_tuss_Valido', 'cd_tiss_fracao', 'Ind-vr', 'Ind-vr-filme', 'Ind-vr-honor', 'Ind-Vr-Uco', 'Vl_Venda', 'vr_operacional', 'vr_honorario', 'qt_m2_filme', 'vr_porte_medico', 'VL_FATOR_DIVISAO', 'qt_embalagem', 'Vl_Excecao', 'tp_exc_conv', 'Vl_FinalConv', 'CD_PRODUTO', 'DS_PRODUTO', 'Ds_Unidadeproduto', 'Vl_CustoMedio', 'Vl_Fator', 'Vl_FatorProFat', 'Vl_CustoFinal', 'Qt_FinalProd', 'Vl_FinalProd', 'vr_dif_vr_convenio_val_pro', 'vr_dif_venda_custo', 'Diverg_regra_proibicao_vl', 'Diverg_sem_tuss', 'Diverg_sem_simpro_brasindice', 'Diverg_sem_tab_propriobrasindice', 'qtde_tuss_duplic', 'ds_tp_gru_pro', 'vl_fator_divisao_fracao', 'tp_AcomodacaoPadrao', 'ds_ind_quali', 'ds_regra_quali', 'cd_gru_pro_quali', 'cd_tab_Fat_quali', 'ds_Tab_Fat_quali', 'tp_Fat_quali', 'perc_pago_quali', 'cd_porte_med_quali', 'ds_porte_med_quali', 'vr_final_conv', 'TbEmpresa_Id_Empresa'),'|');

        foreach ($exportacao as $data) {
            fputcsv($handle, array($data->cd_emp, $data->cd_convenio, $data->nm_convenio, $data->cd_plano, $data->ds_plano, 
            $data->cd_Regra, $data->ds_Regra, $data->cd_tab_Fat, $data->ds_Tab_Fat, $data->Cd_GrupoPro, 
            $data->Ds_GrupoPro, $data->Tp_GrupoPro, $data->Tp_Moeda_tab_fat, number_format($data->perc_pgto, 4, ',', '.'), $data->cd_indice, 
            $data->ds_indice, number_format($data->vl_indice, 4, ',', '.'), number_format($data->vl_M2filme, 4, ',', '.'), number_format($data->vl_honorario_ind, 4, ',', '.'), number_format($data->vl_uco_ind, 4, ',', '.'), 
            $data->cd_profat, $data->ds_pro_Fat, $data->ds_unidade_Fat, number_format($data->Vl_HonorarioProced, 4, ',', '.'), number_format($data->Vl_OperacaoProced, 4, ',', '.'), 
            number_format($data->Vl_TotalProced, 4, ',', '.'), $data->QT_M2_FILME_cont, number_format($data->Vl_ExcecaoProced, 4, ',', '.'), $data->CD_PRESTADOR, $data->Cd_PorteMedico, 
            $data->Ds_PorteMedico, number_format($data->Vl_PorteMedico, 4, ',', '.'), $data->Cd_PorteMedicoExcecao, number_format($data->Vl_PorteMedicoExcecao, 4, ',', '.'), 
            number_format($data->Vl_BrutoProced, 4, ',', '.'), number_format($data->vl_contrato_neg, 4, ',', '.'), number_format($data->Vl_ExcecaoProced_final, 4, ',', '.'), number_format($data->Vl_ContratoProced, 4, ',', '.'), 
            $data->Cd_ProibicaoRegra, $data->Tp_ProibicaoRegra, $data->Tp_AtendProibicaoRegra, number_format($data->Vl_ProibicaoRegra, 4, ',', '.'), 
            $data->TP_PROIBICAO, $data->TP_TUSS, $data->DS_TIP_TUSS, $data->Cd_Tuss, $data->Ds_Tuss, $data->CD_TISS, 
            $data->cd_tuss_Valido, $data->ds_tuss_Valido, $data->cd_tiss_fracao, number_format($data->Indvr, 4, ',', '.'), number_format($data->Indvrfilme, 4, ',', '.'), 
            number_format($data->Indvrhonor, 4, ',', '.'), number_format($data->IndVrUco, 4, ',', '.'), number_format($data->Vl_Venda, 4, ',', '.'), $data->vr_operacional, $data->vr_honorario, 
            $data->qt_m2_filme, $data->vr_porte_medico, number_format($data->VL_FATOR_DIVISAO, 4, ',', '.'), $data->qt_embalagem, number_format($data->Vl_Excecao, 4, ',', '.'), 
            $data->tp_exc_conv, number_format($data->Vl_FinalConv, 4, ',', '.'), $data->CD_PRODUTO, $data->DS_PRODUTO, $data->Ds_Unidadeproduto, 
            number_format($data->Vl_CustoMedio, 4, ',', '.'), number_format($data->Vl_Fator, 4, ',', '.'), number_format($data->Vl_FatorProFat, 4, ',', '.'), number_format($data->Vl_CustoFinal, 4, ',', '.'), $data->Qt_FinalProd, 
            number_format($data->Vl_FinalProd, 4, ',', '.'), $data->vr_dif_vr_convenio_val_pro, $data->vr_dif_venda_custo, $data->Diverg_regra_proibicao_vl, 
            $data->Diverg_sem_tuss, $data->Diverg_sem_simpro_brasindice, $data->Diverg_sem_tab_propriobrasindice, $data->qtde_tuss_duplic, 
            $data->ds_tp_gru_pro, number_format($data->vl_fator_divisao_fracao, 4, ',', '.'), $data->tp_AcomodacaoPadrao, $data->ds_ind_quali, $data->ds_regra_quali, 
            $data->cd_gru_pro_quali, $data->cd_tab_Fat_quali, $data->ds_Tab_Fat_quali, $data->tp_Fat_quali, number_format($data->perc_pago_quali, 4, ',', '.'), 
            $data->cd_porte_med_quali, $data->ds_porte_med_quali, number_format($data->vr_final_conv, 4, ',', '.'), $data->TbEmpresa_Id_Empresa),'|');
        }
        fclose($handle);

    }

    function gerarTbBI()
    {
        //    $this->killAllProcess();,

        $this->ExportacaoModel->cargaBI();

        $this->session->set_flashdata('concluido', 'true');
        redirect('exportacaoBI_finalizar');
    }

    function exportaTbBI()
    {
        $this->ExportacaoModel->kill_other_processes();
        $this->ExportacaoModel->cargaBI();

        $this->session->set_flashdata('concluido', 'true');
        redirect('exportacaoBI_finalizar');

    }

    function exportacaoRelatorioRegra()
    {
        $data['roles'] = $this->user_model->getUserRoles();

        $this->global['pageTitle'] = 'QUALICAD : Exportação relatório de regras por convênio e empresa';
        
        $data['infoConvenios'] = $this->ExportacaoModel->carregaInfoConvenios($this->session->userdata('IdEmpresa'));

    //    $data['infoFracaoSimproBra'] = $this->ImportacaoModel->carregaInfoFracaoSimproBra($this->session->userdata('IdEmpresa'));
       // $data['infoLayoutImportacao'] = $this->ImportacaoModel->carregaInfoLayoutImportacaoEmpresa('FracaoSimproBra',$this->session->userdata('IdEmpresa'));

        $this->loadViews("qualicad/exportacao/exportacaoRelatorioRegra", $this->global, $data, NULL);
    }

    /*function exportaRelatorioRegraPDF()
    {   
        $cdConvenio = $this->uri->segment(2);
        $data['exportacao'] = $this->ExportacaoModel->exportaRelatorioRegra($this->session->userdata('IdEmpresa'),$cdConvenio);     
        $this->global['pageTitle'] = 'QUALICAD : Relatorio Regra PDF';
 
        $this->loadViews("qualicad/exportacao/relatorios/relatorioRegra", $this->global, $data, NULL);
        exit;

        $this->load->library('pdfgenerator');
	    
	    $data['exportacao'] = $this->ExportacaoModel->exportaRelatorioRegra($this->session->userdata('IdEmpresa'),$cdConvenio);     
        $this->global['pageTitle'] = 'QUALICAD : Relatorio Regra PDF';
        $html = $this->loadViews("qualicad/exportacao/relatorios/relatorioRegra", $this->global, $data, NULL);
	    //Load html view
	    $this->pdfgenerator->generate($html, null, 'file.pdf');
	    
	    if($this->pdfgenerator->create('save')) {
	    	//PDF was successfully saved or downloaded
	    	echo 'PDF saved';
	    }

    }*/

    function exportaRelatorioRegra()
    {

        $cdConvenio = $this->input->post('TbConvenio_Id_Convenio');

        /* file name */
		$filename = 'relatorioRegra.xls';

		$exportacao = $this->ExportacaoModel->exportaRelatorioRegra($this->session->userdata('IdEmpresa'),$cdConvenio);

        header('Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-type: application/force-download');
        header('Content-Disposition: attachment; filename='.$filename.'');
        header('Pragma: no-cache');
        header('Cache-Control: max-age=0');
        header('X-Accel-Buffering: no');
        ob_clean();
        flush();

        echo $this->load->view("qualicad/exportacao/relatorios/relatorioRegra", array('exportacao' => $exportacao), true);

     /*   $handle = fopen('php://output', 'w');
        fputcsv($handle, array('TbEmpresa_Id_Empresa','Id_Convenio','Cd_ConvenioERP',
        'Ds_Convenio','Tp_Convenio','dt_homolga_bi','sn_homolog','dt_reajuste','Id_Plano',
        'Cd_PlanoERP','Ds_Plano','TbIndice_Id_Indice','Ds_indice','Vl_Indice','Vl_M2Filme','Vl_Honorário',
        'Vl_UCO','TbRegra_Id_Regra','Ds_Regra','TbGrupoPro_CodGrupo','Ds_GrupoPro','Tp_GrupoPro','Desc_Tp_GrupoPro',
        'TbFaturamento_Id_Faturamento','Ds_Faturamento','Tp_Faturamento','Tp_TabFat','Perc_Pago','sn_faturanf',
        'qtde_fatitem'),'|');

        foreach ($exportacao as $data) {
            fputcsv($handle, array($data->TbEmpresa_Id_Empresa, $data->Id_Convenio, $data->Cd_ConvenioERP,
            $data->Ds_Convenio,$data->Tp_Convenio,$data->dt_homolga_bi,$data->sn_homolog,$data->dt_reajuste,
            $data->Id_Plano,$data->Cd_PlanoERP,$data->Ds_Plano,$data->TbIndice_Id_Indice,$data->Ds_indice,$data->Vl_Indice,
            $data->Vl_M2Filme,$data->Vl_Honorário,$data->Vl_UCO,$data->TbRegra_Id_Regra,$data->Ds_Regra,$data->TbGrupoPro_CodGrupo,
            $data->Ds_GrupoPro,$data->Tp_GrupoPro,$data->Desc_Tp_GrupoPro,$data->TbFaturamento_Id_Faturamento,$data->Ds_Faturamento,
            $data->Tp_Faturamento,$data->Tp_TabFat,$data->Perc_Pago,$data->sn_faturanf,$data->qtde_fatitem),'|');
        } 
        fclose($handle);*/
        exit;        
    }

    function valor($val)
    {
        $val = str_replace(",",".",$val);
        $val = preg_replace('/\.(?=.*\.)/', '', $val);
        return floatval($val);
    }


}