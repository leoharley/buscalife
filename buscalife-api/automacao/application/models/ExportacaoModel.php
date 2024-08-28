<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class ExportacaoModel extends CI_Model
{

    function exportaFatItem($idEmpresa,$var)
    {
        if ($var != 0) {
            $this->db->select('*');
            $this->db->from('TbFatItem');   
            $this->db->order_by('Id_FatItem','DESC');
            $this->db->limit($var);
            $query = $this->db->get();
            return $query->result();
        }
        $this->db->select('*');
        $this->db->from('TbFatItem as FatItem');
        $this->db->where('FatItem.Deletado !=', 'S');
        $this->db->where('FatItem.Tp_Ativo', 'S');
        $this->db->where('FatItem.TbEmpresa_Id_Empresa', $idEmpresa);
        $this->db->order_by('FatItem.Id_FatItem', 'ASC');
        $query = $this->db->get();

        return $query->result();
    }

    function exportaGrupoPro($idEmpresa,$var)
    {
        if ($var != 0) {
            $this->db->select('*');
            $this->db->from('TbGrupoPro');   
            $this->db->order_by('CodGrupoPro','DESC');
            $this->db->limit($var);
            $query = $this->db->get();
            return $query->result();
        }
        $this->db->select('*');
        $this->db->from('TbGrupoPro as GrupoPro');
        $this->db->where('GrupoPro.Deletado !=', 'S');
        $this->db->where('GrupoPro.Tp_Ativo', 'S');
        $this->db->where('GrupoPro.TbEmpresa_Id_Empresa', $idEmpresa);
        $this->db->order_by('GrupoPro.CodGrupoPro', 'ASC');
        $query = $this->db->get();

        return $query->result();
    }

    function exportaProFat($idEmpresa,$var)
    {
        if ($var != 0) {
            $this->db->select('*');
            $this->db->from('TbProFat');   
            $this->db->order_by('Cd_ProFat','DESC');
            $this->db->limit($var);
            $query = $this->db->get();
            return $query->result();
        }
        $this->db->select('*');
        $this->db->from('TbProFat as ProFat');
        $this->db->where('ProFat.Deletado !=', 'S');
        $this->db->where('ProFat.Tp_Ativo', 'S');
        $this->db->where('ProFat.TbEmpresa_Id_Empresa', $idEmpresa);
        $this->db->order_by('ProFat.CodProFat', 'ASC');
        $query = $this->db->get();

        return $query->result();
    }

    function exportaTUSS($idEmpresa,$var)
    {
        if ($var != 0) {
            $this->db->select('*');
            $this->db->from('TbTUSS');   
            $this->db->order_by('Id_Tuss','DESC');
            $this->db->limit($var);
            $query = $this->db->get();
            return $query->result();
        }
        $this->db->select('*');
        $this->db->from('TbTUSS as TUSS');
        $this->db->where('TUSS.Deletado !=', 'S');
        $this->db->where('TUSS.Tp_Ativo', 'S');
        $this->db->where('TUSS.TbEmpresa_Id_Empresa', $idEmpresa);
        $this->db->order_by('TUSS.TbProFat_Cd_ProFat', 'ASC');
        $query = $this->db->get();

        return $query->result();
    }

    function exportaRegraGruPro($idEmpresa,$var)
    {
        if ($var != 0) {
            $this->db->select('*');
            $this->db->from('Tb_RegraGruPro');   
            $this->db->order_by('Id_RegraGruPro','DESC');
            $this->db->limit($var);
            $query = $this->db->get();
            return $query->result();
        }
        $this->db->select('*');
        $this->db->from('Tb_RegraGruPro as RegraGruPro');
        $this->db->where('RegraGruPro.Deletado !=', 'S');
        $this->db->where('RegraGruPro.Tp_Ativo', 'S');
        $this->db->where('RegraGruPro.TbEmpresa_Id_Empresa', $idEmpresa);
        $this->db->order_by('RegraGruPro.TbGrupoPro_CodGrupo', 'ASC');
        $query = $this->db->get();

        return $query->result();
    }

    function exportaFracaoSimproBra($idEmpresa,$var)
    {
        if ($var != 0) {
            $this->db->select('*');
            $this->db->from('Tb_FracaoSimproBra');   
            $this->db->order_by('Id_FracaoSimproBra','DESC');
            $this->db->limit($var);
            $query = $this->db->get();
            return $query->result();
        }
        $this->db->select('*');
        $this->db->from('Tb_FracaoSimproBra as FracaoSimproBra');
        $this->db->where('FracaoSimproBra.Deletado !=', 'S');
        $this->db->where('FracaoSimproBra.Tp_Ativo', 'S');
        $this->db->where('FracaoSimproBra.TbEmpresa_Id_Empresa', $idEmpresa);
        $this->db->order_by('FracaoSimproBra.TbProFat_Cd_ProFat', 'ASC');
        $query = $this->db->get();

        return $query->result();
    }

    function exportaProduto($idEmpresa,$var)
    {
        if ($var != 0) {
            $this->db->select('*');
            $this->db->from('Tb_Produto');   
            $this->db->order_by('Id_Produto','DESC');
            $this->db->limit($var);
            $query = $this->db->get();
            return $query->result();
        }
        $this->db->select('*');
        $this->db->from('Tb_Produto as Produto');
        $this->db->where('Produto.Deletado !=', 'S');
        $this->db->where('Produto.Tp_Ativo', 'S');
        $this->db->where('Produto.TbEmpresa_Id_Empresa', $idEmpresa);
        $this->db->order_by('Produto.TbProFat_Cd_ProFat', 'ASC');
        $query = $this->db->get();

        return $query->result();
    }

    function exportaProducao($idEmpresa,$var)
    {
        if ($var != 0) {
            $this->db->select('*');
            $this->db->from('Tb_Producao');   
            $this->db->order_by('Id_Producao','DESC');
            $this->db->limit($var);
            $query = $this->db->get();
            return $query->result();
        }
        $this->db->select('*');
        $this->db->from('Tb_Producao as Producao');
        $this->db->where('Producao.Deletado !=', 'S');
        $this->db->where('Producao.Tp_Ativo', 'S');
        $this->db->where('Producao.TbEmpresa_Id_Empresa', $idEmpresa);
        $this->db->order_by('Producao.TbProFat_Cd_ProFat', 'ASC');
        $query = $this->db->get();

        return $query->result();
    }

    function exportaPorteMedico($idEmpresa,$var)
    {
        if ($var != 0) {
            $this->db->select('*');
            $this->db->from('TbPorteMedico');   
            $this->db->order_by('Id_PorteMedico','DESC');
            $this->db->limit($var);
            $query = $this->db->get();
            return $query->result();
        }
        $this->db->select('*');
        $this->db->from('TbPorteMedico as PorteMedico');
        $this->db->where('PorteMedico.Deletado !=', 'S');
        $this->db->where('PorteMedico.Tp_Ativo', 'S');
        $this->db->where('PorteMedico.TbEmpresa_Id_Empresa', $idEmpresa);
        $this->db->order_by('PorteMedico.Cd_PorteMedico', 'ASC');
        $query = $this->db->get();

        return $query->result();
    }

    function exportaExcecaoValores($idEmpresa,$var)
    {
        if ($var != 0) {
            $this->db->select('*');
            $this->db->from('TbExcValores');   
            $this->db->order_by('Id_ExcValores','DESC');
            $this->db->limit($var);
            $query = $this->db->get();
            return $query->result();
        }
        $this->db->select('*');
        $this->db->from('TbExcValores as ExcValores');
        $this->db->where('ExcValores.Deletado !=', 'S');
        $this->db->where('ExcValores.Tp_Ativo', 'S');
        $this->db->where('ExcValores.TbEmpresa_Id_Empresa', $idEmpresa);
        $this->db->order_by('ExcValores.CD_Convenio', 'ASC');
        $query = $this->db->get();

        return $query->result();
    }

    function exportaTbBI()
    {
        $this->db->reconnect();
        $this->db->select('cd_emp, cd_convenio, nm_convenio, cd_plano, ds_plano, cd_Regra, ds_Regra, cd_tab_Fat, ds_Tab_Fat, Cd_GrupoPro, Ds_GrupoPro, Tp_GrupoPro, Tp_Moeda_tab_fat, perc_pgto, cd_indice, ds_indice, vl_indice, vl_M2filme, vl_honorario_ind, vl_uco_ind, cd_profat, ds_pro_Fat, ds_unidade_Fat, Vl_HonorarioProced, Vl_OperacaoProced, Vl_TotalProced, QT_M2_FILME_cont, Vl_ExcecaoProced, CD_PRESTADOR, Cd_PorteMedico, Ds_PorteMedico, Vl_PorteMedico, Cd_PorteMedicoExcecao, Vl_PorteMedicoExcecao, Vl_BrutoProced, vl_contrato_neg, Vl_ExcecaoProced_final, Vl_ContratoProced, Cd_ProibicaoRegra, Tp_ProibicaoRegra, Tp_AtendProibicaoRegra, Vl_ProibicaoRegra, TP_PROIBICAO, TP_TUSS, DS_TIP_TUSS, Cd_Tuss, Ds_Tuss, CD_TISS, cd_tuss_Valido, ds_tuss_Valido, cd_tiss_fracao, Ind-vr as Indvr, Ind-vr-filme as Indvrfilme, Ind-vr-honor as Indvrhonor, Ind-Vr-Uco as IndVrUco, Vl_Venda, vr_operacional, vr_honorario, qt_m2_filme, vr_porte_medico, VL_FATOR_DIVISAO, qt_embalagem, Vl_Excecao, tp_exc_conv, Vl_FinalConv, CD_PRODUTO, DS_PRODUTO, Ds_Unidadeproduto, Vl_CustoMedio, Vl_Fator, Vl_FatorProFat, Vl_CustoFinal, Qt_FinalProd, Vl_FinalProd, vr_dif_vr_convenio_val_pro, vr_dif_venda_custo, Diverg_regra_proibicao_vl, Diverg_sem_tuss, Diverg_sem_simpro_brasindice, Diverg_sem_tab_propriobrasindice, qtde_tuss_duplic, ds_tp_gru_pro, vl_fator_divisao_fracao, tp_AcomodacaoPadrao, ds_ind_quali, ds_regra_quali, cd_gru_pro_quali, cd_tab_Fat_quali, ds_Tab_Fat_quali, tp_Fat_quali, perc_pago_quali, cd_porte_med_quali, ds_porte_med_quali, vr_final_conv, TbEmpresa_Id_Empresa');
        $this->db->from('TbBI as BI');
    //    $this->db->where('BI.Tp_Ativo', 'S');
    //    $this->db->where('BI.TbEmpresa_Id_Empresa', $idEmpresa);
        $query = $this->db->get();
        $this->db->close();

        return $query->result();
    }

    function apagaEmpresaTbBI($idEmpresa,$idConvenio)
    {
        $this->db->where('cd_emp', intval($idEmpresa));
        $this->db->where('cd_convenio', intval($idConvenio));
        $res = $this->db->delete('TbBI');

        if(!$res)
        {
            $error = $this->db->error();
            return $error['code'];
            //return array $error['code'] & $error['message']
        }
        else
        {
            return TRUE;
        }

    }

    function apagaTmpConvenio($idEmpresa)
    {
        $this->db->where('TbEmpresa_Id_Empresa', intval($idEmpresa));
        $res = $this->db->delete('Tmp_Convenio');

        if(!$res)
        {
            $error = $this->db->error();
            return $error['code'];
            //return array $error['code'] & $error['message']
        }
        else
        {
            return TRUE;
        }

    }

    function apagaTmpContrato($idEmpresa)
    {
        $this->db->where('TbEmpresa_Id_Empresa', intval($idEmpresa));
        $res = $this->db->delete('Tmp_Contrato');

        if(!$res)
        {
            $error = $this->db->error();
            return $error['code'];
            //return array $error['code'] & $error['message']
        }
        else
        {
            return TRUE;
        }

    }

    function exportaContrato($idEmpresa,$var)
    {
        if ($var != 0) {
            $this->db->select('*');
            $this->db->from('TbContrato');   
            $this->db->order_by('Id_Contrato','DESC');
            $this->db->limit($var);
            $query = $this->db->get();
            return $query->result();
        }
        $this->db->select('*');
        $this->db->from('TbContrato as Contrato');
        $this->db->where('Contrato.Deletado !=', 'S');
        $this->db->where('Contrato.Tp_Ativo', 'S');
        $this->db->where('Contrato.TbEmpresa_Id_Empresa', $idEmpresa);
        $this->db->order_by('Contrato.Id_Contrato', 'ASC');
        $query = $this->db->get();

        return $query->result();
    }

    function consultaConvenioBI($idEmpresa,$idConvenio,$limit,$offset)
    {  
    $this->db->start_cache();
    $sql="SELECT CON_CONV_FINAL.id_convenio,
            CON_CONV_FINAL.ds_convenio,
            CON_CONV_FINAL.Cd_ConvenioERP,
            CON_CONV_FINAL.tbempresa_id_empresa,
            CON_CONV_FINAL.Id_Plano,
            CON_CONV_FINAL.Ds_Plano,
            CON_CONV_FINAL.Cd_PlanoERP,
            CON_CONV_FINAL.Tp_AcomodacaoPadrao,
            CON_CONV_FINAL.TbIndice_Id_Indice,
            CON_CONV_FINAL.Ds_indice,
            CON_CONV_FINAL.Vl_Indice,
            CON_CONV_FINAL.Vl_M2Filme,
            CON_CONV_FINAL.Vl_IND_Honorário,
            CON_CONV_FINAL.Vl_UCO,
            CON_CONV_FINAL.TbRegra_Id_Regra,
            CON_CONV_FINAL.Ds_Regra,
            CON_CONV_FINAL.TbGrupoPro_CodGrupo,
            CON_CONV_FINAL.Ds_GrupoPro,
            CON_CONV_FINAL.Tp_GrupoPro,
            CON_CONV_FINAL.Desc_Tp_GrupoPro,
            CON_CONV_FINAL.TbFaturamento_Id_Faturamento,
            CON_CONV_FINAL.Ds_Faturamento,
            CON_CONV_FINAL.Tp_Faturamento,
            CON_CONV_FINAL.Perc_Pago,
            CON_CONV_FINAL.Cd_TUSS,
            CON_CONV_FINAL.Cd_TISS,
            CON_CONV_FINAL.Ds_FatItem,
            CON_CONV_FINAL.Vl_Honorário Vl_Honorario,
            CON_CONV_FINAL.Vl_Operacional,
            CON_CONV_FINAL.Vl_Filme,
            CON_CONV_FINAL.Vl_Total,
            CON_CONV_FINAL.Qt_Embalagem,
            CON_CONV_FINAL.Ds_Unidade,
            CON_CONV_FINAL.Cd_PorteMedico,
            CON_CONV_FINAL.Ds_PorteMedico,
            CON_CONV_FINAL.Vl_PorteMedico,
            CON_CONV_FINAL.Ds_Tuss,
            CON_CONV_FINAL.TP_TUSS,
            CON_CONV_FINAL.DS_TIP_TUSS,
            CON_CONV_FINAL.TbProFat_Cd_ProFat,
            CON_CONV_FINAL.Vl_ExcValores,
            CON_CONV_FINAL.Tp_ExcValores,
            CON_CONV_FINAL.Vl_FatorDivisao,
            CON_CONV_FINAL.VR_FINAL_CONV
            ,round (CASE WHEN  CON_CONV_FINAL.tp_FATURAMENTO = 'REAIS'
                        THEN  ((CON_CONV_FINAL.VR_FINAL_CONV  + (NVL(CON_CONV_FINAL.Vl_Filme,0) * NVL( CON_CONV_FINAL.Vl_M2Filme,0) ) ) *  CON_CONV_FINAL.Perc_Pago)/100
                        ELSE  CASE WHEN   CON_CONV_FINAL.tp_FATURAMENTO = 'CBHPM'
                        THEN (((NVL(CON_CONV_FINAL.Vl_Honorário,0) * NVL(CON_CONV_FINAL.Vl_PorteMedico,0) )
                                        + ( NVL(CON_CONV_FINAL.Vl_Operacional,0) * NVL(CON_CONV_FINAL.Vl_UCO,0)   )
                                        + (NVL(CON_CONV_FINAL.Vl_Filme,0)* NVL(CON_CONV_FINAL.Vl_M2Filme ,0) ) )* CON_CONV_FINAL.Perc_Pago)/100
                                ELSE (((NVL(CON_CONV_FINAL.Vl_Honorário,0) *  NVL(CON_CONV_FINAL.Vl_IND_Honorário,0))
                                        + (NVL(CON_CONV_FINAL.Vl_Operacional,0) * NVL(CON_CONV_FINAL.Vl_Indice,0))
                                        + (NVL(CON_CONV_FINAL.Vl_Filme,0) * NVL(CON_CONV_FINAL.Vl_M2Filme ,0)))* CON_CONV_FINAL.Perc_Pago)/100
                                END
                    END ,2)    VR_FINAL ,
            CON_CONV_FINAL.Id_RegraProibicao,
            CON_CONV_FINAL.Ds_RegraProibicao,
            CON_CONV_FINAL.Tp_RegraProibicao,
            CON_CONV_FINAL.Tp_Atendimento,
            CON_CONV_FINAL.Vl_RegraProibicao
            FROM 
            (SELECT EXV.id_convenio,
            EXV.ds_convenio,
            EXV.Cd_ConvenioERP,
            EXV.tbempresa_id_empresa,
            EXV.Id_Plano,
            EXV.Ds_Plano,
            EXV.Cd_PlanoERP,
            EXV.Tp_AcomodacaoPadrao,
            EXV.TbIndice_Id_Indice,
            EXV.Ds_indice,
            EXV.Vl_Indice,
            EXV.Vl_M2Filme,
            EXV.Vl_IND_Honorário,
            EXV.Vl_UCO,
            EXV.TbRegra_Id_Regra,
            EXV.Ds_Regra,
            EXV.TbGrupoPro_CodGrupo,
            EXV.Tp_GrupoPro,
            EXV.Ds_GrupoPro,
            EXV.Desc_Tp_GrupoPro,
            EXV.TbFaturamento_Id_Faturamento,
            EXV.Ds_Faturamento,
            EXV.Tp_Faturamento,
            EXV.Perc_Pago,
            EXV.Cd_TUSS,
            EXV.Cd_TISS,
            EXV.Ds_FatItem,
            EXV.Vl_Honorário ,
            EXV.Vl_Operacional,
            EXV.Vl_Filme,
            EXV.Vl_Total,
            EXV.Qt_Embalagem,
            EXV.Ds_Unidade,
            EXV.Cd_PorteMedico,
            EXV.Ds_PorteMedico,
            EXV.Vl_PorteMedico,
            EXV.Ds_Tuss,
            EXV.TP_TUSS,
            EXV.DS_TIP_TUSS,
            EXV.TbProFat_Cd_ProFat,
            TbExcValores.Vl_ExcValores,
            TbExcValores.Tp_ExcValores,
            Tb_FracaoSimproBra.Vl_FatorDivisao,
            round(case when Tb_FracaoSimproBra.Vl_FatorDivisao is not null
                    then (case when (TbExcValores.Vl_ExcValores is not null )
                                then case when (TbExcValores.Tp_ExcValores is null OR TbExcValores.Tp_ExcValores = '')
                                        then TbExcValores.Vl_ExcValores
                                        else EXV.Vl_Total
                                            end 
                                        else  EXV.Vl_Total
                                        end) /  Tb_FracaoSimproBra.Vl_FatorDivisao
                                else (case when (TbExcValores.Vl_ExcValores is not null )
                                                then case when (TbExcValores.Tp_ExcValores is null OR TbExcValores.Tp_ExcValores = '')
                                            then TbExcValores.Vl_ExcValores
                                            else EXV.Vl_Total
                                    end 
                                    else  EXV.Vl_Total
                            end) 
                end,2) vr_final_conv,
            Tb_RegraProibicao.Id_RegraProibicao,
            Tb_RegraProibicao.Ds_RegraProibicao,
            Tb_RegraProibicao.Tp_RegraProibicao,
            Tb_RegraProibicao.Tp_Atendimento,
            Tb_RegraProibicao.Vl_RegraProibicao

            FROM
            (SELECT AA.id_convenio,
            AA.ds_convenio,
            AA.Cd_ConvenioERP,
            AA.tbempresa_id_empresa,
            AA.Id_Plano,
            AA.Ds_Plano,
            AA.Cd_PlanoERP,
            AA.Tp_AcomodacaoPadrao,
            AA.TbIndice_Id_Indice,
            AA.Ds_indice,
            AA.Vl_Indice,
            AA.Vl_M2Filme,
            AA.Vl_IND_Honorário,
            AA.Vl_UCO,
            AA.TbRegra_Id_Regra,
            AA.Ds_Regra,
            AA.TbGrupoPro_CodGrupo,
            AA.Tp_GrupoPro,
            AA.Ds_GrupoPro,
            AA.Desc_Tp_GrupoPro,
            AA.TbFaturamento_Id_Faturamento,
            AA.Ds_Faturamento,
            AA.Tp_Faturamento,
            AA.Perc_Pago,
            AA.Cd_TUSS,
            AA.Cd_TISS,
            AA.Ds_FatItem,
            AA.Vl_Honorário,
            AA.Vl_Operacional,
            AA.Vl_Filme,
            AA.Vl_Total,
            AA.Qt_Embalagem,
            AA.Ds_Unidade,
            AA.Cd_PorteMedico,
            AA.Ds_PorteMedico,
            AA.Vl_PorteMedico,
            TbTUSS.Ds_Tuss,
            TbTUSS.TP_TUSS,
            TbTUSS.DS_TIP_TUSS,
            TbTUSS.TbProFat_Cd_ProFat

            FROM
            (SELECT TbConvenio.id_convenio,
            TbConvenio.ds_convenio,
            TbConvenio.Cd_ConvenioERP,
            TbConvenio.tbempresa_id_empresa,
            TbPlano.Id_Plano,
            TbPlano.Ds_Plano,
            TbPlano.Cd_PlanoERP,
            TbPlano.Tp_AcomodacaoPadrao,
            TbPlano.TbIndice_Id_Indice,
            TbIndice.Ds_indice,
            TbIndice.Vl_Indice,
            TbIndice.Vl_M2Filme,
            TbIndice.Vl_Honorário Vl_IND_Honorário,
            TbIndice.Vl_UCO,
            TbPlano.TbRegra_Id_Regra,
            TbRegra.Ds_Regra,
            Tb_RegraGruPro.TbGrupoPro_CodGrupo,
            Tb_RegraGruPro.TbFaturamento_Id_Faturamento,
            TbFaturamento.Ds_Faturamento,
            TbFaturamento.Tp_Faturamento,
            Tb_RegraGruPro.Perc_Pago,
            TbFatItem.Cd_TUSS,
            TbFatItem.Cd_TISS,
            TbFatItem.Ds_FatItem,
            TbFatItem.Vl_Honorário,
            TbFatItem.Vl_Operacional,
            TbFatItem.Vl_Filme,
            TbFatItem.Vl_Total,
            TbFatItem.Qt_Embalagem,
            TbFatItem.Ds_Unidade,
            TbFatItem.Cd_PorteMedico,
            TbPorteMedico.Ds_PorteMedico,
            TbPorteMedico.Vl_PorteMedico,
            TbGrupoPro.Tp_GrupoPro,
            TbGrupoPro.Desc_Tp_GrupoPro,
            TbGrupoPro.Ds_GrupoPro

            FROM TbConvenio,TbPlano,TbIndice,TbRegra,Tb_RegraGruPro, TbGrupoPro, TbFaturamento,TbFatItem

            LEFT OUTER JOIN TbPorteMedico ON 
            (TbPorteMedico.Id_TabFaturamento = TbFatItem.TbFaturamento_Id_Faturamento
            AND TbPorteMedico.Cd_PorteMedico = TbFatItem.Cd_PorteMedico)

            where TbConvenio.tbempresa_id_empresa = $idEmpresa
            and TbConvenio.Cd_ConvenioERP = $idConvenio
            and TbConvenio.id_convenio = TbPlano.TbConvenio_Id_Convenio
            and TbConvenio.tbempresa_id_empresa = TbPlano.TbEmpresa_Id_Empresa
            and TbPlano.TbIndice_Id_Indice = TbIndice.Id_Indice
            and TbPlano.TbEmpresa_Id_Empresa = TbIndice.TbEmpresa_Id_Empresa
            and TbPlano.TbRegra_Id_Regra = TbRegra.Id_Regra
            and TbPlano.TbEmpresa_Id_Empresa = TbRegra.TbEmpresa_Id_Empresa
            and TbRegra.Id_Regra = Tb_RegraGruPro.TbRegra_Id_Regra
            and TbRegra.TbEmpresa_Id_Empresa = Tb_RegraGruPro.TbEmpresa_Id_Empresa
            and Tb_RegraGruPro.TbFaturamento_Id_Faturamento = TbFaturamento.Id_Faturamento
            and Tb_RegraGruPro.TbFaturamento_Id_Faturamento = TbFatItem.TbFaturamento_Id_Faturamento
            and Tb_RegraGruPro.TbEmpresa_Id_Empresa = TbFatItem.TbEmpresa_Id_Empresa
            and Tb_RegraGruPro.TbGrupoPro_CodGrupo = TbGrupoPro.CodGrupoPro
            and Tb_RegraGruPro.TbEmpresa_Id_Empresa = TbGrupoPro.TbEmpresa_Id_Empresa 
            and TbConvenio.Tp_Ativo= 'S'
            and TbPlano.Tp_Ativo = 'S'
            and TbIndice.Tp_Ativo = 'S'
            and TbRegra.Tp_Ativo = 'S'
            and TbGrupoPro.Tp_Ativo = 'S'
            ) AA
            inner JOIN TbTUSS ON (TbTUSS.TbConvenio_Id_Convenio =  AA.Cd_ConvenioERP 
            AND TbTUSS.Cd_Tuss = AA.CD_TUSS 
            and TbTUSS.cd_gru_pro = AA.TbGrupoPro_CodGrupo)) EXV
            LEFT OUTER JOIN TbExcValores ON (TbExcValores.CD_Convenio = EXV.Cd_ConvenioERP 
            AND TbExcValores.Cd_TUSS =  EXV.Cd_TUSS 
            AND TbExcValores.Cd_ProFat = EXV.TbProFat_Cd_ProFat 
            and TbExcValores.TbEmpresa_Id_Empresa = EXV.tbempresa_id_empresa)
            LEFT OUTER JOIN Tb_FracaoSimproBra ON 
            (Tb_FracaoSimproBra.TbEmpresa_Id_Empresa = EXV.tbempresa_id_empresa 
            and Tb_FracaoSimproBra.TbFatItem_Id_FatItem =EXV.TbFaturamento_Id_Faturamento 
            and Tb_FracaoSimproBra.CD_TISS = EXV.Cd_TISS)
            Left outer join Tb_RegraProibicao on 
            ( Tb_RegraProibicao.TbEmpresa_Id_Empresa =  EXV.tbempresa_id_empresa 
            and Tb_RegraProibicao.TbPlano_Id_Plano = EXV.Id_Plano 
            and Tb_RegraProibicao.TbGrupoPro_CodGrupo = EXV.TbGrupoPro_CodGrupo )) CON_CONV_FINAL

            group BY
                CON_CONV_FINAL.id_convenio,
                CON_CONV_FINAL.ds_convenio,
                CON_CONV_FINAL.Cd_ConvenioERP,
                CON_CONV_FINAL.tbempresa_id_empresa,
                CON_CONV_FINAL.Id_Plano,
                CON_CONV_FINAL.Ds_Plano,
                CON_CONV_FINAL.Cd_PlanoERP,
                CON_CONV_FINAL.Tp_AcomodacaoPadrao,
                CON_CONV_FINAL.TbIndice_Id_Indice,
                CON_CONV_FINAL.Ds_indice,
                CON_CONV_FINAL.Vl_Indice,
                CON_CONV_FINAL.Vl_M2Filme,
                CON_CONV_FINAL.Vl_IND_Honorário,
                CON_CONV_FINAL.Vl_UCO,
                CON_CONV_FINAL.TbRegra_Id_Regra,
                CON_CONV_FINAL.Ds_Regra,
                CON_CONV_FINAL.TbGrupoPro_CodGrupo,
                CON_CONV_FINAL.Ds_GrupoPro,
                CON_CONV_FINAL.Tp_GrupoPro,
                CON_CONV_FINAL.Desc_Tp_GrupoPro,
                CON_CONV_FINAL.TbFaturamento_Id_Faturamento,
                CON_CONV_FINAL.Ds_Faturamento,
                CON_CONV_FINAL.Tp_Faturamento,
                CON_CONV_FINAL.Perc_Pago,
                CON_CONV_FINAL.Cd_TUSS,
                CON_CONV_FINAL.Cd_TISS,
                CON_CONV_FINAL.Ds_FatItem,
                CON_CONV_FINAL.Vl_Honorário,
                CON_CONV_FINAL.Vl_Operacional,
                CON_CONV_FINAL.Vl_Filme,
                CON_CONV_FINAL.Vl_Total,
                CON_CONV_FINAL.Qt_Embalagem,
                CON_CONV_FINAL.Ds_Unidade,
                CON_CONV_FINAL.Cd_PorteMedico,
                CON_CONV_FINAL.Ds_PorteMedico,
                CON_CONV_FINAL.Vl_PorteMedico,
                CON_CONV_FINAL.Ds_Tuss,
                CON_CONV_FINAL.TP_TUSS,
                CON_CONV_FINAL.DS_TIP_TUSS,
                CON_CONV_FINAL.TbProFat_Cd_ProFat,
                CON_CONV_FINAL.Vl_ExcValores,
                CON_CONV_FINAL.Tp_ExcValores,
                CON_CONV_FINAL.Vl_FatorDivisao,
                CON_CONV_FINAL.VR_FINAL_CONV
                    ,round (CASE WHEN  CON_CONV_FINAL.tp_FATURAMENTO = 'REAIS'
                                THEN  ((CON_CONV_FINAL.VR_FINAL_CONV  + (NVL(CON_CONV_FINAL.Vl_Filme,0) * NVL( CON_CONV_FINAL.Vl_M2Filme,0) ) ) *  CON_CONV_FINAL.Perc_Pago)/100
                                ELSE  CASE WHEN   CON_CONV_FINAL.tp_FATURAMENTO = 'CBHPM'
                                THEN (((NVL(CON_CONV_FINAL.Vl_Honorário,0) * NVL(CON_CONV_FINAL.Vl_PorteMedico,0) )
                                                + ( NVL(CON_CONV_FINAL.Vl_Operacional,0) * NVL(CON_CONV_FINAL.Vl_UCO,0)   )
                                                + (NVL(CON_CONV_FINAL.Vl_Filme,0)* NVL(CON_CONV_FINAL.Vl_M2Filme ,0) ) )* CON_CONV_FINAL.Perc_Pago)/100
                                        ELSE (((NVL(CON_CONV_FINAL.Vl_Honorário,0) *  NVL(CON_CONV_FINAL.Vl_IND_Honorário,0))
                                                + (NVL(CON_CONV_FINAL.Vl_Operacional,0) * NVL(CON_CONV_FINAL.Vl_Indice,0))
                                                + (NVL(CON_CONV_FINAL.Vl_Filme,0) * NVL(CON_CONV_FINAL.Vl_M2Filme ,0)))* CON_CONV_FINAL.Perc_Pago)/100
                                        END
                            END ,2)   ,
                CON_CONV_FINAL.Id_RegraProibicao,
                CON_CONV_FINAL.Ds_RegraProibicao,
                CON_CONV_FINAL.Tp_RegraProibicao,
                CON_CONV_FINAL.Tp_Atendimento,
                CON_CONV_FINAL.Vl_RegraProibicao
    --  LIMIT 20000
    --  LIMIT 40000 OFFSET 20000
        LIMIT $limit OFFSET $offset
      ";
    
//    echo (nl2br($sql));exit;

    $query = $this->db->query($sql);
    $this->db->stop_cache();
    $this->db->flush_cache();
    return $query->result();
    }

    function consultaContratoBI($idEmpresa,$idConvenio,$limit,$offset)
    {
    $this->db->start_cache();
    $sql="SELECT CON_CONTRATO.TbEmpresa_Id_Empresa,
        CON_CONTRATO.Cd_EmpresaERP, 
        CON_CONTRATO.Cd_ConvenioERP, 
        CON_CONTRATO.ds_convenioerp, 
        CON_CONTRATO.Cd_PlanoERP, 
        CON_CONTRATO.Ds_PlanoERP, 
        CON_CONTRATO.Cd_IndiceERP, 
        CON_CONTRATO.Ds_IndiceERP, 
        CON_CONTRATO.Dt_VigenciaIndiceERP, 
        CON_CONTRATO.Vl_IndiceERP, 
        CON_CONTRATO.Vl_FilmeIndiceERP, 
        CON_CONTRATO.Vl_HonorarioIndiceERP, 
        CON_CONTRATO.Vl_UCOIndiceERP, 
        CON_CONTRATO.Cd_RegraERP, 
        CON_CONTRATO.Ds_RegraERP, 
        CON_CONTRATO.Cd_TabFatERP, 
        CON_CONTRATO.Ds_TabFatERP, 
        CON_CONTRATO.Cd_MoedaERP, 
        CON_CONTRATO.Ds_MoedaERP, 
        CON_CONTRATO.Cd_RegraGruProErp, 
        CON_CONTRATO.Ds_RegraGruProErp, 
        CON_CONTRATO.TP_GRU_PRO_ERP,
        CON_CONTRATO.DS_TP_GRU_PRO_ERP,
        CON_CONTRATO.Per_RegraPGErp, 
        CON_CONTRATO.Cd_ProFatERP, 
        CON_CONTRATO.Ds_ProFatERP, 
        CON_CONTRATO.UnidadeProFatERP, 
        CON_CONTRATO.Vl_ProHonorarioERP, 
        CON_CONTRATO.Vl_ProOperaçãoERP, 
        CON_CONTRATO.Vl_ProTotalERP, 
        CON_CONTRATO.Vl_ProExcecValorERP,
        CON_CONTRATO.Ds_PrestadoraExcec,
        CON_CONTRATO.Qtde_M2FilmeERP, 
        CON_CONTRATO.Cd_PortMedicoERP, 
        CON_CONTRATO.Ds_PortMedicoERP, 
        CON_CONTRATO.Vl_PorteMedicoERP, 
        CON_CONTRATO.Cd_ExcecPorMedicoERP, 
        CON_CONTRATO.Vl_ExcecPorMedicoERP, 
        CON_CONTRATO.Vl_FinalERP, 
        CON_CONTRATO.Vl_FinalExecERP, 
        CON_CONTRATO.CD_PRODUTO, 
        CON_CONTRATO.DS_PRODUTO, 
        CON_CONTRATO.Cd_unidade, 
        CON_CONTRATO.Vl_CustoMedio, 
        CON_CONTRATO.Vl_Fator, 
        CON_CONTRATO.Vl_FatorProFat, 
        CON_CONTRATO.Vl_CustoFinal,
        CON_CONTRATO.vr_contrato_final,
        CON_CONTRATO.Tp_ProibicaoERP, 
        CON_CONTRATO.CD_TISS,
        CON_CONTRATO.vl_fator_divisao_fracao,
        CON_CONTRATO.qtde_final,
        CON_CONTRATO.PRODUCAO_FINAL,
        CON_CONTRATO.TP_TUSS,
        CON_CONTRATO.DS_TIP_TUSS,
        CON_CONTRATO.Cd_Tuss,
        CON_CONTRATO.Ds_Tuss,
        CON_CONTRATO.PRODUTO_ATIVO,
        con_qtprofat_tuss.qtde_tuss_duplic
    FROM

    (SELECT TbContrato.TbEmpresa_Id_Empresa,
        TbContrato.Cd_EmpresaERP, 
        TbContrato.Cd_ConvenioERP, 
        TbContrato.ds_convenioerp, 
        TbContrato.Cd_PlanoERP, 
        TbContrato.Ds_PlanoERP, 
        TbContrato.Cd_IndiceERP, 
        TbContrato.Ds_IndiceERP, 
        TbContrato.Dt_VigenciaIndiceERP, 
        TbContrato.Vl_IndiceERP, 
        TbContrato.Vl_FilmeIndiceERP, 
        TbContrato.Vl_HonorarioIndiceERP, 
        TbContrato.Vl_UCOIndiceERP, 
        TbContrato.Cd_RegraERP, 
        TbContrato.Ds_RegraERP, 
        TbContrato.Cd_TabFatERP, 
        TbContrato.Ds_TabFatERP, 
        TbContrato.Cd_MoedaERP, 
        TbContrato.Ds_MoedaERP, 
        TbContrato.Cd_RegraGruProErp, 
        TbContrato.Ds_RegraGruProErp, 
        TbContrato.TP_GRU_PRO_ERP,
        TbContrato.DS_TP_GRU_PRO_ERP,
        TbContrato.Per_RegraPGErp, 
        TbContrato.Cd_ProFatERP, 
        TbContrato.Ds_ProFatERP, 
        TbContrato.UnidadeProFatERP, 
        TbContrato.Vl_ProHonorarioERP, 
        TbContrato.Vl_ProOperaçãoERP, 
        TbContrato.Vl_ProTotalERP, 
        TbContrato.Vl_ProExcecValorERP,
        TbContrato.Ds_PrestadoraExcec,
        TbContrato.Qtde_M2FilmeERP, 
        TbContrato.Cd_PortMedicoERP, 
        TbContrato.Ds_PortMedicoERP, 
        TbContrato.Vl_PorteMedicoERP, 
        TbContrato.Cd_ExcecPorMedicoERP, 
        TbContrato.Vl_ExcecPorMedicoERP, 
        TbContrato.Vl_FinalERP, 
        TbContrato.Vl_FinalExecERP, 
        Tb_Produto.CD_PRODUTO, 
        Tb_Produto.DS_PRODUTO, 
        Tb_Produto.Cd_unidade, 
        Tb_Produto.Vl_CustoMedio, 
        Tb_Produto.Vl_Fator, 
        Tb_Produto.Vl_FatorProFat, 
        Tb_Produto.Vl_CustoFinal,
        
        CASE WHEN  (TbContrato.Vl_ProExcecValorERP > 0 AND (TbContrato.Ds_PrestadoraExcec = NULL or TbContrato.Ds_PrestadoraExcec = '' ))
            THEN  TbContrato.Vl_ProExcecValorERP 
            ELSE CASE WHEN  (TbContrato.Cd_ExcecPorMedicoERP != NULL )
                        THEN  TbContrato.Vl_FinalExecERP
                        ELSE TbContrato.Vl_FinalERP 
                END
        END vr_contrato_final,
        
        CASE WHEN (TbContrato.Vl_ProExcecValorERP > 0 AND (TbContrato.Ds_PrestadoraExcec = NULL or TbContrato.Ds_PrestadoraExcec = '' ))
            THEN  'TbContrato.Vl_ProExcecValorERP' 
            ELSE CASE WHEN  (TbContrato.Cd_ExcecPorMedicoERP != NULL )
                        THEN  'TbContrato.Vl_FinalExecERP2'
                        ELSE  'TbContrato.Vl_FinalERP'
                END
        END teste,
    
        TbContrato.Tp_ProibicaoERP, 
        TbContrato.CD_TISS,
        TbContrato.vl_fator_divisao_fracao,
        CON_TUSS.qtde_final,
        CON_TUSS.PRODUCAO_FINAL,
        TbTUSS.TP_TUSS,
        TbTUSS.DS_TIP_TUSS,
        TbTUSS.Cd_Tuss,
        TbTUSS.Ds_Tuss,
    
    case when((TbContrato.TP_GRU_PRO_ERP ='MT' or TbContrato.TP_GRU_PRO_ERP ='MD') and (Tb_Produto.CD_PRODUTO is not null))
        then case when  Tb_Produto.CD_PRODUTO is not null
                    then 'A'
                END
        else 'A'
    END AS PRODUTO_ATIVO

    FROM TbProFat,
    TbContrato
    LEFT JOIN Tb_Produto ON (TbContrato.TbEmpresa_Id_Empresa = Tb_Produto.TbEmpresa_Id_Empresa AND TbContrato.Cd_ProFatERP = Tb_Produto .TbProFat_Cd_ProFat) 
    LEFT JOIN TbTUSS ON (TbContrato.TbEmpresa_Id_Empresa = TbTUSS.TbEmpresa_Id_Empresa AND TbContrato.Cd_ConvenioERP = TbTUSS.TbConvenio_Id_Convenio AND  TbContrato.Cd_ProFatERP = TbTUSS.TbProFat_Cd_ProFat)
    LEFT JOIN (SELECT Tb_Producao.TbEmpresa_Id_Empresa,
        Tb_Producao.TbContrato_Cd_EmpresaERP,
        Tb_Producao.TbContrato_Cd_Convenio,
        Tb_Producao.TbContrato_Cd_PlanoERP,
        Tb_Producao.TbContrato_Cd_ProFatERP,
        TbTUSS.Dt_IniVigencia,
        Sum(case when TbTUSS.Dt_IniVigencia is not null
                then case when Tb_Producao.Dt_Lancamento >=TbTUSS.Dt_IniVigencia
                        then Tb_Producao.Qt_Lancamento
                        else 0
                    END
                ELSE
                    Tb_Producao.Qt_Lancamento
            END)  qtde_final,
        Sum(case when TbTUSS.Dt_IniVigencia is not null
                then case when Tb_Producao.Dt_Lancamento >=TbTUSS.Dt_IniVigencia
                        then Tb_Producao.Vl_Conta
                        else 0
                    END
                ELSE
                    Tb_Producao.Vl_Conta
            END)  producao_final
                            
    FROM Tb_Producao 
            LEFT JOIN  TbTUSS ON( Tb_Producao.TbEmpresa_Id_Empresa = TbTUSS.TbEmpresa_Id_Empresa 
                                and 	Tb_Producao.TbContrato_Cd_Convenio = TbTUSS.TbConvenio_Id_Convenio
                                and Tb_Producao.TbContrato_Cd_ProFatERP = TbTUSS.TbProFat_Cd_ProFat)
    group by 
    Tb_Producao.TbEmpresa_Id_Empresa,
        Tb_Producao.TbContrato_Cd_EmpresaERP,
        Tb_Producao.TbContrato_Cd_Convenio,
        Tb_Producao.TbContrato_Cd_PlanoERP,
        Tb_Producao.TbContrato_Cd_ProFatERP,
        TbTUSS.Dt_IniVigencia) CON_TUSS ON (TbContrato.Cd_EmpresaERP = CON_TUSS.TbContrato_Cd_EmpresaERP AND  TbContrato.Cd_ConvenioERP = CON_TUSS.TbContrato_Cd_Convenio AND  TbContrato.Cd_PlanoERP = CON_TUSS.TbContrato_Cd_PlanoERP AND TbContrato.Cd_ProFatERP = CON_TUSS.TbContrato_Cd_ProFatERP)


    WHERE 
    (TbProFat.CodProFat = TbContrato.Cd_ProFatERP and TbContrato.TbEmpresa_Id_Empresa = TbProFat.TbEmpresa_Id_Empresa)
    AND TbContrato.Cd_EmpresaERP =  $idEmpresa
    and  TbContrato.Cd_ConvenioERP = $idConvenio
    and (case when(TbContrato.TP_GRU_PRO_ERP ='MT' or TbContrato.TP_GRU_PRO_ERP ='MD')
        then case when  Tb_Produto.CD_PRODUTO is not null
                    then 'A'
                END
        else 'A'
    END) IN ('A')
    ) CON_CONTRATO

    left outer join (SELECT TbEmpresa.Id_Empresa,
                        TbEmpresa.Cd_EmpresaERP,
                        TbConvenio.Id_Convenio,
                        TbConvenio.Cd_ConvenioERP,
                        TbTUSS.Cd_Tuss,
                        count(TbTUSS.TbProFat_Cd_ProFat) qtde_tuss_duplic
                    FROM TbEmpresa ,
                        TbConvenio,
                        TbTUSS 
                    WHERE
                        TbEmpresa.Id_Empresa = TbConvenio.TbEmpresa_Id_Empresa
                        and TbConvenio.Cd_ConvenioERP = TbTUSS.TbConvenio_Id_Convenio 
                        and TbEmpresa.Id_Empresa = TbTUSS.TbEmpresa_Id_Empresa
                    group by 
                        TbEmpresa.Id_Empresa,
                        TbEmpresa.Cd_EmpresaERP,
                        TbConvenio.Id_Convenio,
                        TbConvenio.Cd_ConvenioERP,
                        TbTUSS.Cd_Tuss) con_qtprofat_tuss on (con_qtprofat_tuss.Cd_EmpresaERP = CON_CONTRATO.Cd_EmpresaERP 
                                                            and con_qtprofat_tuss.Cd_ConvenioERP = CON_CONTRATO.Cd_ConvenioERP
                                                            and con_qtprofat_tuss.Cd_Tuss = CON_CONTRATO.Cd_Tuss)

    --    LIMIT 20000
    --    LIMIT 40000 OFFSET 20000
        LIMIT $limit OFFSET $offset
      ";

//    echo (nl2br($sql));exit;
    $query = $this->db->query($sql);
    $this->db->stop_cache();
    $this->db->flush_cache();
    return $query->result();
    }

    function showallprocess()
    {
        $sql = "SHOW FULL PROCESSLIST";
        $query = $this->db->query($sql);

        return $query->result();
    }

    function kill_other_processes()
    {
        $this->db->reconnect();
        $query = $this->db->query("SELECT kill_other_processes()");
        $this->db->close();
        return TRUE;
    }

    function cargaBI($idEmpresa,$idConvenio)
    {
        $this->db->reconnect();
        $query = $this->db->query("SELECT cargabi({$idEmpresa},{$idConvenio})");
        $this->db->close();
        return TRUE;
    }

    function cargaBICompleto()
    {
        $this->db->reconnect();
        $query = $this->db->query("SELECT cargabicompleto()");
        $this->db->close();
        return TRUE;
    }

    function cargaHistoricoBI()
    {
        $this->db->reconnect();
        $query = $this->db->query("SELECT cargahistoricobi()");
        $this->db->close();
        return TRUE;
    }


    function cargaTmpConvenio($idEmpresa,$idConvenio)
    {
        $this->db->reconnect();
      //  $query = $this->db->query("SELECT cargatmpconvenio({$idEmpresa},{$idConvenio})");
        $query = $this->db->query("SELECT cargatmpconveniocompleto()");
        $this->db->close();
        return TRUE;
    }

    function cargaTmpContrato($idEmpresa,$idConvenio)
    {
        $this->db->reconnect();
    //    $query = $this->db->query("SELECT cargatmpcontrato({$idEmpresa},{$idConvenio})");
        $query = $this->db->query("SELECT cargatmpcontratocompleto()");
        $this->db->close();
        return TRUE;
    }

    function exportaRelatorioRegra($idEmpresa,$cdConvenio)
    {

    if ($cdConvenio == 0) {
        $whereConvenio = null;   
    } else 
    {
        $whereConvenio = 'and tc."Cd_ConvenioERP" ='.$cdConvenio;
    }

    $this->db->reconnect();
    $this->db->start_cache();
    $sql="select tc.\"TbEmpresa_Id_Empresa\" ,
        tc.\"Id_Convenio\" ,
        tc.\"Cd_ConvenioERP\" ,
        tc.\"Ds_Convenio\" ,
        tc.\"Tp_Convenio\" ,
        tc.dt_homolga_bi ,
        tc.sn_homolog ,
        tc.dt_reajuste,
        tp.\"Id_Plano\" ,
        tp.\"Cd_PlanoERP\" ,
        tp.\"Ds_Plano\", 
        tp.\"TbIndice_Id_Indice\" ,
        ti.\"Ds_indice\" ,
        ti.\"Vl_Indice\" ,
        ti.\"Vl_M2Filme\" ,
        ti.\"Vl_Honorário\" ,
        ti.\"Vl_UCO\", 
        tp.\"TbRegra_Id_Regra\" ,
        tr.\"Ds_Regra\",
        trgp.\"TbGrupoPro_CodGrupo\" ,
        tgp.\"Ds_GrupoPro\" ,
        tgp.\"Tp_GrupoPro\" ,
        tgp.\"Desc_Tp_GrupoPro\" ,
        trgp.\"TbFaturamento_Id_Faturamento\" ,
        tf.\"Ds_Faturamento\" ,
        tf.\"Tp_Faturamento\" ,
        tf.\"Tp_TabFat\" ,
        trgp.\"Perc_Pago\" ,
        trgp.sn_faturanf ,
        count(tfi.\"Id_FatItem\") qtde_fatitem
    -- count(tev.\"Id_ExcValores\") qtde_excecao_vr
    from \"TbConvenio\" tc 
    left outer join \"TbPlano\" tp on (tp.\"TbConvenio_Id_Convenio\" = tc.\"Id_Convenio\" and tp.\"TbEmpresa_Id_Empresa\" = tc.\"TbEmpresa_Id_Empresa\")
    left outer join \"TbIndice\" ti on (ti.\"TbEmpresa_Id_Empresa\" = tp.\"TbEmpresa_Id_Empresa\" and ti.\"Id_Indice\" = tp.\"TbIndice_Id_Indice\")
    left outer join \"TbRegra\" tr on (tr.\"TbEmpresa_Id_Empresa\" = tp.\"TbEmpresa_Id_Empresa\" and tr.\"Id_Regra\" = tp.\"TbRegra_Id_Regra\")
    left outer join \"Tb_RegraGruPro\" trgp on (trgp.\"TbEmpresa_Id_Empresa\" = tp.\"TbEmpresa_Id_Empresa\" and trgp.\"TbRegra_Id_Regra\" = tp.\"TbRegra_Id_Regra\")
    left outer join \"TbFaturamento\" tf on ( trgp.\"TbEmpresa_Id_Empresa\" = tf.\"TbEmpresa_Id_Empresa\" and trgp.\"TbFaturamento_Id_Faturamento\" = tf.\"Id_Faturamento\")
    left outer join \"TbGrupoPro\" tgp on (tgp.\"TbEmpresa_Id_Empresa\" =trgp.\"TbEmpresa_Id_Empresa\" and tgp.\"CodGrupoPro\"  = trgp.\"TbGrupoPro_CodGrupo\"  )
    left outer join \"TbFatItem\" tfi on (tfi.\"TbFaturamento_Id_Faturamento\" = trgp.\"TbFaturamento_Id_Faturamento\" and trgp.\"TbEmpresa_Id_Empresa\" = tfi.\"TbEmpresa_Id_Empresa\")
    --left outer join \"TbExcValores\" tev on (tev.\"CD_Convenio\" = tc.\"Id_Convenio\" and tev.\"TbEmpresa_Id_Empresa\" = tc.\"TbEmpresa_Id_Empresa\") 
    where   
    tc.\"TbEmpresa_Id_Empresa\" = $idEmpresa  --- alterar empresa    
    $whereConvenio

    group by 
    tc.\"TbEmpresa_Id_Empresa\" ,
        tc.\"Id_Convenio\" ,
        tc.\"Cd_ConvenioERP\" ,
        tc.\"Ds_Convenio\" ,
        tc.\"Tp_Convenio\" ,
        tc.dt_homolga_bi ,
        tc.sn_homolog ,
        tc.dt_reajuste,
        tp.\"Id_Plano\" ,
        tp.\"Cd_PlanoERP\" ,
        tp.\"Ds_Plano\", 
        tp.\"TbIndice_Id_Indice\" ,
        ti.\"Ds_indice\" ,
        ti.\"Vl_Indice\" ,
        ti.\"Vl_M2Filme\" ,
        ti.\"Vl_Honorário\" ,
        ti.\"Vl_UCO\", 
        tp.\"TbRegra_Id_Regra\" ,
        tr.\"Ds_Regra\",
        trgp.\"TbGrupoPro_CodGrupo\" ,
        tgp.\"Ds_GrupoPro\" ,
        tgp.\"Tp_GrupoPro\" ,
        tgp.\"Desc_Tp_GrupoPro\" ,
        trgp.\"TbFaturamento_Id_Faturamento\" ,
        tf.\"Ds_Faturamento\" ,
        tf.\"Tp_Faturamento\" ,
        tf.\"Tp_TabFat\" ,
        trgp.\"Perc_Pago\" ,
        trgp.sn_faturanf
      ";

    $query = $this->db->query($sql);
    $this->db->stop_cache();
    $this->db->flush_cache();
    return $query->result();
    }
    
    function consultaTbBI($idEmpresa)
    {
    $this->db->reconnect();
    $this->db->start_cache();
    $sql="select con_cont_conv1.cd_emp,
    con_cont_conv1.cd_convenio,
    con_cont_conv1.nm_convenio,
    con_cont_conv1.cd_plano,
    con_cont_conv1.ds_plano,
    con_cont_conv1.cd_Regra,
    con_cont_conv1.ds_Regra,
    con_cont_conv1.cd_tab_Fat,
    con_cont_conv1.ds_Tab_Fat,
    con_cont_conv1.cd_gru_pro 				Cd_GrupoPro,
    con_cont_conv1.ds_gru_pro 				Ds_GrupoPro,
    con_cont_conv1.tp_gru_pro 				Tp_GrupoPro,
    con_cont_conv1.Ds_MoedaERP 				Tp_Moeda_tab_fat,
    con_cont_conv1.perc_pgto,
    con_cont_conv1.cd_indice,
    con_cont_conv1.ds_indice,
    con_cont_conv1.vl_indice,
    con_cont_conv1.vl_M2filme,
    con_cont_conv1.vl_honorario_ind,
    con_cont_conv1.vl_uco_ind,
   con_cont_conv1.cd_profat,
    con_cont_conv1.ds_pro_Fat,
    con_cont_conv1.ds_unidade_Fat,
     con_cont_conv1.Vl_HonorarioProced,
    con_cont_conv1.Vl_OperacaoProced,
    con_cont_conv1.Vl_TotalProced,
    con_cont_conv1.QT_M2_FILME_cont,
    con_cont_conv1.Vl_ExcecaoProced,
    con_cont_conv1.CD_PRESTADOR,
     con_cont_conv1.Cd_PorteMedico,
    con_cont_conv1.Ds_PorteMedico,
    con_cont_conv1.Vl_PorteMedico,
    con_cont_conv1.Cd_PorteMedicoExcecao,
    con_cont_conv1.Vl_PorteMedicoExcecao,
    0   										Vl_BrutoProced,
   con_cont_conv1.vl_contrato_neg,
   con_cont_conv1.Vl_ExcecaoProced_final,
    con_cont_conv1.Vl_ContratoProced,
    con_cont_conv1.Cd_ProibicaoRegra,
    con_cont_conv1.Tp_ProibicaoRegra,
    con_cont_conv1.Tp_AtendProibicaoRegra,
    con_cont_conv1.Vl_ProibicaoRegra,
     con_cont_conv1.TP_PROIBICAO,
      con_cont_conv1.TP_TUSS,
    con_cont_conv1.DS_TIP_TUSS,
    con_cont_conv1.Cd_Tuss,
    con_cont_conv1.Ds_Tuss,
    con_cont_conv1.CD_TISS,
     con_tuss_valido.cd_tuss				cd_tuss_Valido,
     con_cont_conv1.ds_tuss_Valido,
    con_tiss.cd_tiss 					cd_tiss_fracao,
     con_cont_conv1.vl_ind_quali				'Ind-vr',
    con_cont_conv1.vl_ind_filme_quali			'Ind-vr-filme',
    con_cont_conv1.vl_ind_honor_quali			'Ind-vr-honor',
    con_cont_conv1.vl_ind_uco_quali			'Ind-Vr-Uco',
     con_cont_conv1.vl_total_quali			'Vl_Venda', 
     con_cont_conv1.vl_oper_quali			'vr_operacional',
     con_cont_conv1.vl_honor_quali			'vr_honorario',
    con_cont_conv1.vl_filme_quali			'qt_m2_filme',
   con_cont_conv1.vl_porte_med_quali			'vr_porte_medico',
    con_cont_conv1.Vl_FatorDivisao			'VL_FATOR_DIVISAO',
       con_cont_conv1.qt_emb_quali			'qt_embalagem',
    con_cont_conv1.vl_excvalor_quali			'Vl_Excecao',
    con_cont_conv1.Tp_ExcValores				'tp_exc_conv',
     con_cont_conv1.VR_FINAL				'Vl_FinalConv',
     con_cont_conv1.CD_PRODUTO,
    con_cont_conv1.DS_PRODUTO,
    con_cont_conv1.Ds_Unidadeproduto,
    con_cont_conv1.Vl_CustoMedio,
    con_cont_conv1.Vl_Fator,
    con_cont_conv1.Vl_FatorProFat,
    con_cont_conv1.Vl_CustoFinal,
     con_cont_conv1.Qt_FinalProd,
    con_cont_conv1.Vl_FinalProd,
    0  								'vr_dif_vr_convenio_val_pro',
    0								'vr_dif_venda_custo',
    0								'Diverg_regra_proibicao_vl',     
    0  								'Diverg_sem_tuss',
    0								'Diverg_sem_simpro_brasindice',
    0								'Diverg_sem_tab_propriobrasindice',
    con_cont_conv1.qtde_tuss_duplic,
    con_cont_conv1.ds_tp_gru_pro,
    con_cont_conv1.vl_fator_divisao_fracao,
    con_cont_conv1.tp_AcomodacaoPadrao,
    con_cont_conv1.ds_ind_quali,
    con_cont_conv1.ds_regra_quali,
    con_cont_conv1.cd_gru_pro_quali,
    con_cont_conv1.cd_tab_Fat_quali,
    con_cont_conv1.ds_Tab_Fat_quali,
    con_cont_conv1.tp_Fat_quali,
    con_cont_conv1.perc_pago_quali,
    con_cont_conv1.cd_porte_med_quali,
    con_cont_conv1.ds_porte_med_quali,
    con_cont_conv1.vr_final_conv,
    con_cont_conv1.Ds_RegraProibicao,
    con_cont_conv1.TbEmpresa_Id_Empresa
from 
(SELECT Tmp_Contrato.TbEmpresa_Id_Empresa,
    Tmp_Contrato.Cd_EmpresaERP 			cd_emp,
    Tmp_Contrato.Cd_ConvenioERP 			cd_convenio,
    Tmp_Contrato.ds_convenioerp 			nm_convenio,
    Tmp_Contrato.Cd_PlanoERP 			cd_plano,
    Tmp_Contrato.Ds_PlanoERP 			ds_plano,
    Tmp_Contrato.Cd_IndiceERP 			cd_indice,
    Tmp_Contrato.Ds_IndiceERP 			ds_indice,
    Tmp_Contrato.Vl_IndiceERP 			vl_indice,
    Tmp_Contrato.Vl_FilmeIndiceERP 		vl_M2filme,
    Tmp_Contrato.Vl_HonorarioIndiceERP 	vl_honorario_ind,
    Tmp_Contrato.Vl_UCOIndiceERP 		vl_uco_ind,
    Tmp_Contrato.Cd_RegraERP 			cd_Regra,
    Tmp_Contrato.Ds_RegraERP 			ds_Regra,
    Tmp_Contrato.Cd_TabFatERP 			cd_tab_Fat,
    Tmp_Contrato.Ds_TabFatERP 			ds_Tab_Fat,
    Tmp_Contrato.Cd_MoedaERP 			tp_moeda_tab_Fat,
    Tmp_Contrato.Ds_MoedaERP,
    Tmp_Contrato.Cd_RegraGruProErp 		cd_gru_pro,
    Tmp_Contrato.Ds_RegraGruProErp 		ds_gru_pro,
    Tmp_Contrato.TP_GRU_PRO_ERP 			tp_gru_pro,
    Tmp_Contrato.DS_TP_GRU_PRO_ERP 		ds_tp_gru_pro,
    Tmp_Contrato.Per_RegraPGErp 			perc_pgto,
    Tmp_Contrato.Cd_ProFatERP 			cd_profat,
    Tmp_Contrato.Ds_ProFatERP 			ds_pro_Fat,
    Tmp_Contrato.UnidadeProFatERP 		ds_unidade_Fat,
    Tmp_Contrato.Vl_ProHonorarioERP 		Vl_HonorarioProced,
    Tmp_Contrato.Vl_ProOperaçãoERP 		Vl_OperacaoProced,
    Tmp_Contrato.Vl_ProTotalERP 			Vl_TotalProced,
    Tmp_Contrato.Qtde_M2FilmeERP 		QT_M2_FILME_cont,
    Tmp_Contrato.Vl_ProExcecValorERP 		Vl_ExcecaoProced,
    Tmp_Contrato.Ds_PrestadoraExcec 		CD_PRESTADOR,
    Tmp_Contrato.Cd_PortMedicoERP 		Cd_PorteMedico,
    Tmp_Contrato.Ds_PortMedicoERP 		Ds_PorteMedico,
    Tmp_Contrato.Vl_PorteMedicoERP 		Vl_PorteMedico,
    Tmp_Contrato.Cd_ExcecPorMedicoERP 		Cd_PorteMedicoExcecao,
    Tmp_Contrato.Vl_ExcecPorMedicoERP 		Vl_PorteMedicoExcecao,
    Tmp_Contrato.Vl_FinalERP 			vl_contrato_neg,
    Tmp_Contrato.Vl_FinalExecERP 		Vl_ExcecaoProced_final,
    Tmp_Contrato.vr_contrato_final 		Vl_ContratoProced,
    Tmp_Contrato.Tp_ProibicaoERP 		TP_PROIBICAO,
    Tmp_Contrato.CD_PRODUTO,
    Tmp_Contrato.DS_PRODUTO,
    Tmp_Contrato.Cd_Unidade 			Ds_Unidadeproduto,
    Tmp_Contrato.Vl_CustoMedio,
    Tmp_Contrato.Vl_Fator,
    Tmp_Contrato.Vl_FatorProFat,
    Tmp_Contrato.Vl_CustoFinal,
    Tmp_Contrato.TP_TUSS,
    Tmp_Contrato.DS_TIP_TUSS,
    Tmp_Contrato.Cd_Tuss,
    Tmp_Contrato.Ds_Tuss,
    Tmp_Contrato.CD_TISS,
    Tmp_Contrato.vl_fator_divisao_fracao,
    Tmp_Contrato.qtde_final 			Qt_FinalProd,
    Tmp_Contrato.PRODUCAO_FINAL 			Vl_FinalProd,
    Tmp_Contrato.qtde_tuss_duplic,
			
    Tmp_Convenio.Cd_TISS 				cd_tiss_valido,
    Tmp_Convenio.Ds_FatItem 			ds_tuss_Valido,
    Tmp_Convenio.Tp_AcomodacaoPadrao,
    Tmp_Convenio.Ds_indice 			ds_ind_quali,
    Tmp_Convenio.Vl_Indice 			vl_ind_quali,
    Tmp_Convenio.Vl_M2Filme 			vl_ind_filme_quali,
    Tmp_Convenio.Vl_IND_Honorário 		vl_ind_honor_quali,
    Tmp_Convenio.Vl_UCO 				vl_ind_uco_quali,
    Tmp_Convenio.Ds_Regra 				ds_regra_quali,
    Tmp_Convenio.TbGrupoPro_CodGrupo 		cd_gru_pro_quali,
    Tmp_Convenio.TbFaturamento_Id_Faturamento cd_tab_Fat_quali,
    Tmp_Convenio.Ds_Faturamento 			ds_Tab_Fat_quali,
    Tmp_Convenio.Tp_Faturamento 			tp_Fat_quali,
    Tmp_Convenio.Perc_Pago 			perc_pago_quali,
    Tmp_Convenio.Vl_Honorario 			vl_honor_quali,
    Tmp_Convenio.Vl_Operacional 			vl_oper_quali,
    Tmp_Convenio.Vl_Filme 				vl_filme_quali,
    Tmp_Convenio.Vl_Total 				vl_total_quali,
    Tmp_Convenio.Qt_Embalagem 			qt_emb_quali,
    Tmp_Convenio.Cd_PorteMedico 			cd_porte_med_quali,
    Tmp_Convenio.Ds_PorteMedico 			ds_porte_med_quali,
    Tmp_Convenio.Vl_PorteMedico 			vl_porte_med_quali,
    Tmp_Convenio.Vl_ExcValores  			vl_excvalor_quali,
    Tmp_Convenio.Tp_ExcValores,
    Tmp_Convenio.Vl_FatorDivisao,
    Tmp_Convenio.vr_final_conv,
    Tmp_Convenio.VR_FINAL,
    Tmp_Convenio.Id_RegraProibicao 		Cd_ProibicaoRegra,
    Tmp_Convenio.Ds_RegraProibicao,
    Tmp_Convenio.Tp_RegraProibicao 		Tp_ProibicaoRegra,
    Tmp_Convenio.Tp_Atendimento 			Tp_AtendProibicaoRegra,
    Tmp_Convenio.Vl_RegraProibicao 		Vl_ProibicaoRegra
   
   FROM Tmp_Contrato
   LEFT join Tmp_Convenio on (Tmp_Contrato.TbEmpresa_Id_Empresa = Tmp_Convenio.TbEmpresa_Id_Empresa 
       and  Tmp_Contrato.Cd_ConvenioERP = Tmp_Convenio.Cd_ConvenioERP 
       and Tmp_Contrato.Cd_PlanoERP = Tmp_Convenio.Cd_PlanoERP 
       and  Tmp_Contrato.Cd_ProFatERP = Tmp_Convenio.TbProFat_Cd_ProFat 
       and  Tmp_Contrato.Cd_Tuss = Tmp_Convenio.Cd_TUSS 
       and (Tmp_Contrato.CD_TISS = Tmp_Convenio.Cd_TISS or Tmp_Contrato.CD_TISS = 0))                    
) con_cont_conv1
left outer join (select AA.Id_Empresa,
    AA.Cd_EmpresaERP,
    AA.Id_Convenio,
    AA.Cd_ConvenioERP,
    AA.Id_Plano,
    AA.Cd_PlanoERP,
    AA.TbRegra_Id_Regra,
    AA.Ds_Regra,
    AA.Tp_GrupoPro,
    AA.TbFaturamento_Id_Faturamento,
    AA.Ds_Faturamento,
    TbFatItem.Cd_TISS
    
FROM
(select TbEmpresa.Id_Empresa,
                        TbEmpresa.Cd_EmpresaERP,
                        TbConvenio.Id_Convenio,
                        TbConvenio.Cd_ConvenioERP,
                        TbPlano.Id_Plano,
                        TbPlano.Cd_PlanoERP,
                        TbPlano.TbRegra_Id_Regra,
                        TbRegra.Ds_Regra,
                        TbGrupoPro.Tp_GrupoPro,
                        Tb_RegraGruPro.TbFaturamento_Id_Faturamento,
                        TbFaturamento.Ds_Faturamento
from TbEmpresa, 
TbConvenio,
TbPlano,
TbRegra,
Tb_RegraGruPro,
TbFaturamento,
TbGrupoPro
where TbEmpresa.Id_Empresa = TbConvenio.TbEmpresa_Id_Empresa
     and TbConvenio.Id_Convenio = TbPlano.TbConvenio_Id_Convenio
     and TbPlano.TbRegra_Id_Regra = TbRegra.Id_Regra 
     and TbPlano.TbEmpresa_Id_Empresa = TbRegra.TbEmpresa_Id_Empresa
     and TbRegra.Id_Regra = Tb_RegraGruPro.TbRegra_Id_Regra 
     and TbRegra.TbEmpresa_Id_Empresa = Tb_RegraGruPro.TbEmpresa_Id_Empresa
     and Tb_RegraGruPro.TbFaturamento_Id_Faturamento =TbFaturamento.Id_Faturamento 
     and Tb_RegraGruPro.TbEmpresa_Id_Empresa = TbFaturamento.TbEmpresa_Id_Empresa
   
     and Tb_RegraGruPro.TbEmpresa_Id_Empresa = TbGrupoPro.TbEmpresa_Id_Empresa
     and Tb_RegraGruPro.TbGrupoPro_CodGrupo = TbGrupoPro.CodGrupoPro
group by 
        TbEmpresa.Id_Empresa,
     TbEmpresa.Cd_EmpresaERP,
      TbConvenio.Id_Convenio,
      TbConvenio.Cd_ConvenioERP,
      TbPlano.Id_Plano,
      TbPlano.Cd_PlanoERP,
      TbPlano.TbRegra_Id_Regra,
      TbRegra.Ds_Regra,
      TbGrupoPro.Tp_GrupoPro,
      Tb_RegraGruPro.TbFaturamento_Id_Faturamento,
      TbFaturamento.Ds_Faturamento) AA,
TbFatItem

WHERE
AA.TbFaturamento_Id_Faturamento = TbFatItem.TbFaturamento_Id_Faturamento 
and AA.Id_Empresa = TbFatItem.TbEmpresa_Id_Empresa
and TbFatItem.Cd_TISS is not null
and TbFatItem.Tp_Ativo = 'S') con_tiss on (con_tiss.Cd_EmpresaERP = con_cont_conv1.cd_emp 
                         and con_tiss.Cd_ConvenioERP = con_cont_conv1.cd_convenio 
                         and con_tiss.Cd_PlanoERP = con_cont_conv1.cd_plano
                         and con_tiss.Tp_GrupoPro = con_cont_conv1.tp_gru_pro 
                         and con_tiss.Cd_TISS = con_cont_conv1.cd_tiss)
left outer join (SELECT Tmp_Convenio.TbEmpresa_Id_Empresa ,
                     Tmp_Convenio.Cd_ConvenioERP ,
                     Tmp_Convenio.Cd_PlanoERP,
                     Tmp_Convenio.TbProFat_Cd_ProFat,
                     Tmp_Convenio.Cd_TUSS 
FROM Tmp_Convenio 
group by 
 Tmp_Convenio.TbEmpresa_Id_Empresa ,
 Tmp_Convenio.Cd_ConvenioERP ,
   Tmp_Convenio.Cd_PlanoERP,
   Tmp_Convenio.TbProFat_Cd_ProFat,
   Tmp_Convenio.Cd_TUSS) con_tuss_valido on (con_tuss_valido.TbEmpresa_Id_Empresa = con_cont_conv1.TbEmpresa_Id_Empresa
                     and con_tuss_valido.Cd_ConvenioERP =  con_cont_conv1.cd_convenio
                     and con_tuss_valido.Cd_PlanoERP = con_cont_conv1.cd_plano
                     and con_tuss_valido.TbProFat_Cd_ProFat =con_cont_conv1.cd_profat
                     and con_tuss_valido.cd_tuss =con_cont_conv1.Cd_Tuss)
    WHERE con_cont_conv1.TbEmpresa_Id_Empresa = $idEmpresa
      ";

    $query = $this->db->query($sql);
    $this->db->stop_cache();
    $this->db->flush_cache();
    return $query->result();
    }

    function adicionaConvenio($info)
    {
        $this->db->trans_start();
        $this->db->insert('Tmp_Convenio', $info);

        $insert_id = $this->db->insert_id();

        $this->db->trans_complete();

        return $insert_id;
    }

    function adicionaContrato($info)
    {
        $this->db->trans_start();
        $this->db->insert('Tmp_Contrato', $info);

        $insert_id = $this->db->insert_id();

        $this->db->trans_complete();

        return $insert_id;
    }

    function adicionaTbBI($info)
    {
        $this->db->trans_start();
        $this->db->insert('TbBI', $info);

        $insert_id = $this->db->insert_id();

        $this->db->trans_complete();

        return $insert_id;
    }

    function consultaCodERPEmpresa($IdEmpresa)
    {
        $this->db->select('empresa.Cd_EmpresaERP');
        $this->db->from('TbEmpresa as empresa');
        $this->db->where('empresa.Id_Empresa', $IdEmpresa);
        $query = $this->db->get();  

        return $query->result();
    }

    function atualizaControleCronjob($id,$info)
    {
        $this->db->where('id', $id);
        $this->db->update('tb_controle_cronjob', $info);

        return TRUE;
    }

    function carregaInfoConvenios($idEmpresa)
    {
        $this->db->select('*');
        $this->db->from('TbConvenio as Convenio');
        $this->db->where('Convenio.TbEmpresa_Id_Empresa', $idEmpresa);
        $this->db->where('Convenio.Tp_Ativo', 'S');
        $query = $this->db->get();

        return $query->result();
    }

    


}

  