<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';
/**
 * Class : Admin (AdminController)
 * Admin class to control to authenticate admin credentials and include admin functions.
 * @author : Samet Aydın / sametay153@gmail.com
 * @version : 1.0
 * @since : 27.02.2018
 */
class ExportacaoAcessoExterno extends BaseController
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
   
    }

    function exportaBI_AE()
    {
        $filename = 'exportBi.csv';

        $idEmpresa = $this->uri->segment(2);
        $idConvenio = $this->uri->segment(3);
        $token = $this->uri->segment(4);

        if ($token == 'b820bfc5-e344-4c6d-a468-ff4c477234ce') {

            if (strpos(base_url(), 'homologacao') !== FALSE) {
                header('Location: https://zoetek.com.br/qualicad/biexp/bi_data_hom.csv');
                exit;
            } else {
                switch ($idEmpresa) {
                    case '1':
                        header('Location: https://zoetek.com.br/qualicad/biexp/bi_data_prod_emp_1.csv');
                        break;
                    case '2':
                        header('Location: https://zoetek.com.br/qualicad/biexp/bi_data_prod_emp_2.csv');
                        break;
                    case '8':
                        header('Location: https://zoetek.com.br/qualicad/biexp/bi_data_prod_emp_8.csv');
                        break;
                    case '15':
                        header('Location: https://zoetek.com.br/qualicad/biexp/bi_data_prod_emp_15.csv');
                        break;
                    case '5':
                        header('Location: https://zoetek.com.br/qualicad/biexp/bi_data_prod_emp_5.csv');
                        break;      
                }                
                exit;
            }

      /*  $exportacao = $this->ExportacaoModel->exportaTbBI();

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
        fclose($handle); */

    }   else
     {
        echo 'ACESSO NEGADO';exit;
     }

    }


}