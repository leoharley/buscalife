<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class PrincipalModel extends CI_Model
{
    
// INICIO DAS CONSULTAS NA TELA DE CONVENIO
    function listaConvenio($IdEmpresa, $searchText = '', $page, $segment)
    {
        $this->db->select('*');
        $this->db->from('TbConvenio as Convenio');
        $this->db->join('TbUsuEmp as UsuEmp', 'UsuEmp.Id_UsuEmp = Convenio.TbUsuEmp_Id_UsuEmp','inner');
        $this->db->join('tb_status_homologacao as StatusHom', 'StatusHom.id_status_homologacao = Convenio.id_status_homologacao AND StatusHom.st_ativo = \'S\'','left');
   //     $this->db->join('tbl_roles as Role', 'Role.roleId = Usuarios.roleId','left');
        if(!empty($searchText)) {
            $likeCriteria = "(Convenio.Ds_Convenio  LIKE '%".$searchText."%'
                            OR  Convenio.CNPJ_Convenio  LIKE '%".$searchText."%')";
            $this->db->where($likeCriteria);
        }
    //    $this->db->where('Convenio.Deletado !=', 'S');
        $this->db->where('Convenio.TbEmpresa_Id_Empresa', $IdEmpresa);
        $this->db->limit($page, $segment);
        $this->db->order_by('Convenio.Id_Convenio', 'ASC');
        $query = $this->db->get();
        
        $result = $query->result();        
        return $result;
    }

    function adicionaConvenio($info)
    {
        $this->db->trans_start();
        $this->db->insert('TbConvenio', $info);
        
        $insert_id = $this->db->insert_id();
        
        $this->db->trans_complete();
        
        return $insert_id;
    }

    function editaConvenio($info, $id)
    {
        $this->db->where('Id_Convenio', $id);
        $this->db->update('TbConvenio', $info);
        
        return TRUE;
    }

    function apagaConvenio($info,$id)
    {
        $this->db->where('Id_Convenio', $id);
        $res = $this->db->delete('TbConvenio');

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

    function consultaConvenioExistente($Ds_Convenio, $CNPJ_Convenio, $IdEmpresa)
    {
        $this->db->select('Convenio.Id_Convenio, Convenio.Ds_Convenio, Convenio.CNPJ_Convenio, Convenio.Cd_ConvenioERP');
        $this->db->from('TbConvenio as Convenio');
        $this->db->join('TbUsuEmp as UsuEmp', 'UsuEmp.Id_UsuEmp = Convenio.TbUsuEmp_Id_UsuEmp','inner');
        $campos = "(Convenio.Ds_Convenio = '".$Ds_Convenio."'
                    AND Convenio.CNPJ_Convenio = '".$CNPJ_Convenio."'
                    AND UsuEmp.TbEmpresa_Id_Empresa  = '".$IdEmpresa."')";
        $this->db->where($campos);
    //    $this->db->where('Convenio.Deletado !=', 'S');
        $query = $this->db->get();

        return $query->result();
    }

    function consultaCodERPExistente($Cd_ConvenioERP, $IdEmpresa)
    {
        $this->db->select('Convenio.Id_Convenio, Convenio.CNPJ_Convenio, Convenio.Cd_ConvenioERP');
        $this->db->from('TbConvenio as Convenio');
        $this->db->join('TbUsuEmp as UsuEmp', 'UsuEmp.Id_UsuEmp = Convenio.TbUsuEmp_Id_UsuEmp','inner');
        $campos = "(Convenio.Cd_ConvenioERP = '".$Cd_ConvenioERP."'
                    AND UsuEmp.TbEmpresa_Id_Empresa  = '".$IdEmpresa."')";
        $this->db->where($campos);
    //    $this->db->where('Convenio.Deletado !=', 'S');
        $query = $this->db->get();

        return $query->result();
    }

    function consultaExcValoresTUSSExistente($CD_Convenio, $Cd_TUSS, $IdEmpresa)
    {
        $this->db->select('*');
        $this->db->from('TbExcValores as ExcValores');
        $this->db->where('ExcValores.CD_Convenio', $CD_Convenio);
        $this->db->where('ExcValores.Cd_TUSS', $Cd_TUSS);
        $this->db->where('ExcValores.TbEmpresa_Id_Empresa', $IdEmpresa);
    //    $this->db->where('ExcValores.Deletado !=', 'S');
        $query = $this->db->get();

        return $query->result();
    }

    function consultaExcValoresProFatExistente($CD_Convenio, $Cd_ProFat, $IdEmpresa)
    {
        $this->db->select('*');
        $this->db->from('TbExcValores as ExcValores');
        $this->db->where('ExcValores.CD_Convenio', $CD_Convenio);
        $this->db->where('ExcValores.Cd_ProFat', $Cd_ProFat);
        $this->db->where('ExcValores.TbEmpresa_Id_Empresa', $IdEmpresa);
    //    $this->db->where('ExcValores.Deletado !=', 'S');
        $query = $this->db->get();

        return $query->result();
    }

    function carregaInfoConvenio($IdConvenio)
    {
        $this->db->select('*');
        $this->db->from('TbConvenio');
        $this->db->where('Id_Convenio', $IdConvenio);
        $query = $this->db->get();

        return $query->result();
    }

    function carregaInfoHistoricoExc()
    {
        $this->db->select('*');
        $this->db->from('tbhistoricoexc as HistoricoExc');
        $this->db->join('TbEmpresa as Empresa', 'Empresa.Id_Empresa = HistoricoExc.idempresa','left');
        $query = $this->db->get();

        return $query->result();
    }

    function carregaInfoConveniosEmpresa($idEmpresa)
    {
        $this->db->select('*');
        $this->db->from('TbConvenio as Convenio');
        $this->db->where('Convenio.TbEmpresa_Id_Empresa', $idEmpresa);
    //    $this->db->where('Convenio.Deletado !=', 'S');
        $this->db->where('Convenio.Tp_Ativo', 'S');
        $query = $this->db->get();

        return $query->result();
    }

// FIM DAS CONSULTAS NA TELA DE CONVENIO

    // INICIO DAS CONSULTAS NA TELA DE PLANO
    function listaPlano($IdEmpresa, $searchText = '', $page, $segment)
    {
        $this->db->select('Plano.Id_Plano, Plano.Ds_Plano, Convenio.Ds_Convenio, Indice.Ds_indice, Regra.Ds_Regra, Plano.Cd_PlanoERP, Plano.Tp_AcomodacaoPadrao, Plano.Tp_Ativo');
        $this->db->from('TbPlano as Plano');
        $this->db->join('TbConvenio as Convenio', 'Convenio.Id_Convenio = Plano.TbConvenio_Id_Convenio AND Convenio.Tp_Ativo = \'S\'','left');
        $this->db->join('TbIndice as Indice', 'Indice.Id_Indice = Plano.TbIndice_Id_Indice AND Indice.Tp_Ativo = \'S\'','left');
        $this->db->join('TbRegra as Regra', 'Regra.Id_Regra = Plano.TbRegra_Id_Regra AND Regra.Tp_Ativo = \'S\'','left');
    //     $this->db->join('tbl_roles as Role', 'Role.roleId = Usuarios.roleId','left');
        if(!empty($searchText)) {
            $likeCriteria = "(Plano.Ds_Plano LIKE '%".$searchText."%')";
            $this->db->where($likeCriteria);
        }

    //    $this->db->where('Plano.Deletado !=', 'S');
        $this->db->where('Plano.TbEmpresa_Id_Empresa', $IdEmpresa);
        $this->db->limit($page, $segment);
        $this->db->order_by('Plano.Id_Plano', 'ASC');
        $query = $this->db->get();

        $result = $query->result();
        return $result;
    }

    function adicionaPlano($info)
    {
        $this->db->trans_start();
        $this->db->insert('TbPlano', $info);

        $insert_id = $this->db->insert_id();

        $this->db->trans_complete();

        return $insert_id;
    }

    function editaPlano($info, $id)
    {
        $this->db->where('Id_Plano', $id);
        $this->db->update('TbPlano', $info);

        return TRUE;
    }

 /*   function apagaPlano($info, $id)
    {
        $this->db->where('Id_Plano', $id);
        $this->db->update('TbPlano', $info);

        return $this->db->affected_rows();
    } */

    function consultaPlanoCodERPExistente($Cd_PlanoERP,$TbConvenio_Id_Convenio,$IdEmpresa)
    {
        $this->db->select('Plano.Id_Plano, Plano.TbConvenio_Id_Convenio');
        $this->db->from('TbPlano as Plano');
        $campos = "(Plano.TbConvenio_Id_Convenio = '".$TbConvenio_Id_Convenio."' 
                    AND Plano.TbEmpresa_Id_Empresa  = '".$IdEmpresa."' 
                    AND Plano.Cd_PlanoERP = '".$Cd_PlanoERP."')";
        $this->db->where($campos);
    //    $this->db->where('Plano.Deletado !=', 'S');
        $query = $this->db->get();

        return $query->result();
    }

    function apagaPlano($info,$id)
    {
        $this->db->where('Id_Plano', $id);
        $res = $this->db->delete('TbPlano');

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

    function carregaInfoPlanosEmpresa($idEmpresa)
    {
        $this->db->select('*');
        $this->db->from('TbPlano as Plano');
        $this->db->where('Plano.TbEmpresa_Id_Empresa', $idEmpresa);
    //    $this->db->where('Plano.Deletado !=', 'S');
        $this->db->where('Plano.Tp_Ativo', 'S');
        $query = $this->db->get();

        return $query->result();
    }

    function carregaInfoPlanosConvenio($idConvenio, $idEmpresa)
    {
        $this->db->select('Indice.Ds_indice, Regra.Ds_Regra, Plano.*');
        $this->db->from('TbPlano as Plano');
        $this->db->join('TbIndice as Indice', 'Indice.Id_Indice = Plano.TbIndice_Id_Indice AND Indice.Tp_Ativo = \'S\'','left');
        $this->db->join('TbRegra as Regra', 'Regra.Id_Regra = Plano.TbRegra_Id_Regra AND Regra.Tp_Ativo = \'S\'','left');
        $this->db->where('Plano.TbConvenio_Id_Convenio', $idConvenio);
        $this->db->where('Plano.TbEmpresa_Id_Empresa', $idEmpresa);
    //    $this->db->where('Plano.Deletado !=', 'S');
        $query = $this->db->get();

        return $query->result();
    }

/*    function consultaPlanoExistente($CNPJ_Convenio, $IdUsuEmp)
    {
        $this->db->select('Id_Convenio');
        $this->db->from('TbConvenio');
        $campos = "(CNPJ_Convenio = '".$CNPJ_Convenio."'
                    AND TbUsuEmp_Id_UsuEmp  = '".$IdUsuEmp."')";
        $this->db->where($campos);
        $query = $this->db->get();

        return $query->result();
    } */

    function carregaInfoPlano($Id)
    {
        $this->db->select('*');
        $this->db->from('TbPlano');
        $this->db->where('Id_Plano', $Id);
        $query = $this->db->get();

        return $query->result();
    }
// FIM DAS CONSULTAS NA TELA DE PLANO

// INICIO DAS CONSULTAS NA TELA DE FATURAMENTO
function listaFaturamento($IdEmpresa, $searchText = '', $page, $segment)
{
    $this->db->select('*');
    $this->db->from('TbFaturamento as Faturamento');
//    $this->db->join('TbConvenio as Convenio', 'Empresa.Id_Empresa = UsuEmp.TbEmpresa_Id_Empresa AND Empresa.Deletado <> \'S\' AND Empresa.Tp_Ativo = \'S\'','inner');
//     $this->db->join('tbl_roles as Role', 'Role.roleId = Usuarios.roleId','left');
    if(!empty($searchText)) {
        $likeCriteria = "(Faturamento.Ds_Faturamento  LIKE '%".$searchText."%')";
        $this->db->where($likeCriteria);
    }

//    $this->db->where('Faturamento.Deletado !=', 'S');
    $this->db->where('Faturamento.TbEmpresa_Id_Empresa', $IdEmpresa);
    $this->db->limit($page, $segment);
    $this->db->order_by('Faturamento.Id_Faturamento', 'ASC');
    $query = $this->db->get();
    
    $result = $query->result();        
    return $result;
}

function adicionaFaturamento($info)
{
    $this->db->trans_start();
    $this->db->insert('TbFaturamento', $info);
    
    $insert_id = $this->db->insert_id();
    
    $this->db->trans_complete();
    
    return $insert_id;
}

function editaFaturamento($info, $id)
{
    $this->db->where('Id_Faturamento', $id);
    $this->db->update('TbFaturamento', $info);
    
    return TRUE;
}

function apagaFaturamento($info,$id)
    {
        $this->db->where('Id_Faturamento', $id);
        $res = $this->db->delete('TbFaturamento');

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

function carregaInfoFaturamento($Id)
{
    $this->db->select('Faturamento.*');
    $this->db->from('TbFaturamento as Faturamento');    
    $this->db->where('Id_Faturamento', $Id);
    $query = $this->db->get();

    return $query->result();
}

function carregaInfoFaturamentoEmpresa($idEmpresa)
    {
        $this->db->select('*');
        $this->db->from('TbFaturamento as Faturamento');
        $this->db->where('Faturamento.TbEmpresa_Id_Empresa', $idEmpresa);
    //    $this->db->where('Faturamento.Deletado !=', 'S');
        $this->db->where('Faturamento.Tp_Ativo', 'S');
        $query = $this->db->get();

        return $query->result();
    }
// FIM DAS CONSULTAS NA TELA DE FATURAMENTO

// INICIO DAS CONSULTAS NA TELA DE REGRA
function listaRegra($IdEmpresa, $searchText = '', $page, $segment)
{
    $this->db->select('*');
    $this->db->from('TbRegra as Regra');
//     $this->db->join('tbl_roles as Role', 'Role.roleId = Usuarios.roleId','left');
    if(!empty($searchText)) {
        $likeCriteria = "(Regra.Ds_Regra LIKE '%".$searchText."%')";
        $this->db->where($likeCriteria);
    }

//    $this->db->where('Regra.Deletado !=', 'S');
    $this->db->where('Regra.TbEmpresa_Id_Empresa', $IdEmpresa);
    $this->db->limit($page, $segment);
    $query = $this->db->get();
    
    $result = $query->result();        
    return $result;
}

function adicionaRegra($info)
{
    $this->db->trans_start();
    $this->db->insert('TbRegra', $info);
    
    $insert_id = $this->db->insert_id();
    
    $this->db->trans_complete();
    
    return $insert_id;
}

function editaRegra($info, $id)
{
    $this->db->where('Id_Regra', $id);
    $this->db->update('TbRegra', $info);
    
    return TRUE;
}

function apagaRegra($info,$id)
    {
        $this->db->where('Id_Regra', $id);
        $res = $this->db->delete('TbRegra');

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

function carregaInfoRegra($Id)
{
    $this->db->select('*');
    $this->db->from('TbRegra');
    $this->db->where('Id_Regra', $Id);
    $query = $this->db->get();

    return $query->result();
}

function carregaInfoRegrasEmpresa($idEmpresa)
{
    $this->db->select('*');
    $this->db->from('TbRegra as Regra');
    $this->db->where('Regra.TbEmpresa_Id_Empresa', $idEmpresa);
//    $this->db->where('Regra.Deletado !=', 'S');
    $this->db->where('Regra.Tp_Ativo', 'S');
    $query = $this->db->get();

    return $query->result();
}
// FIM DAS CONSULTAS NA TELA DE REGRA

// INICIO DAS CONSULTAS NA TELA DE INDICE
function listaIndice($IdEmpresa, $searchText = '', $page, $segment)
{
    $this->db->select('*');
    $this->db->from('TbIndice as Indice');
//     $this->db->join('tbl_roles as Role', 'Role.roleId = Usuarios.roleId','left');
    if(!empty($searchText)) {
        $likeCriteria = "(Indice.Ds_Indice LIKE '%".$searchText."%')";
        $this->db->where($likeCriteria);
    }
 //   $this->db->where('Indice.Deletado !=', 'S');
    $this->db->where('Indice.TbEmpresa_Id_Empresa', $IdEmpresa);
    $this->db->limit($page, $segment);
    $this->db->order_by('Indice.Id_Indice', 'ASC');
    $query = $this->db->get();
    
    $result = $query->result();        
    return $result;
}

function adicionaIndice($info)
{
    $this->db->trans_start();
    $this->db->insert('TbIndice', $info);
    
    $insert_id = $this->db->insert_id();
    
    $this->db->trans_complete();
    
    return $insert_id;
}

function editaIndice($info, $id)
{
    $this->db->where('Id_Indice', $id);
    $this->db->update('TbIndice', $info);
    
    return TRUE;
}

function apagaIndice($info,$id)
    {
        $this->db->where('Id_Indice', $id);
        $res = $this->db->delete('TbIndice');

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

function carregaInfoIndice($Id)
{
    $this->db->select('*');
    $this->db->from('TbIndice');
    $this->db->where('Id_Indice', $Id);
    $query = $this->db->get();

    return $query->result();
}

function carregaInfoIndicesEmpresa($idEmpresa)
{
    $this->db->select('*');
    $this->db->from('TbIndice as Indice');
    $this->db->where('Indice.TbEmpresa_Id_Empresa', $idEmpresa);
//    $this->db->where('Indice.Deletado !=', 'S');
    $this->db->where('Indice.Tp_Ativo', 'S');
    $query = $this->db->get();

    return $query->result();
}
// FIM DAS CONSULTAS NA TELA DE INDICE


// INICIO DAS CONSULTAS NA TELA DE INDICE GRUPO PRO
    function listaIndiceGrupoPro($IdEmpresa, $searchText = '', $page, $segment)
    {
        $this->db->select('DISTINCT("IndiceGrupo"."Id_IndiceGrupo"), IndiceGrupo.*, Indice.Ds_indice, GrupoPro.CodGrupoPro, GrupoPro.Ds_GrupoPro');
        $this->db->from('TbIndiceGrupo as IndiceGrupo');
        $this->db->join('TbGrupoPro as GrupoPro', 'GrupoPro.CodGrupoPro = IndiceGrupo.TbGrupoPro_CodGrupo AND GrupoPro.Tp_Ativo = \'S\'','left');
        $this->db->join('TbIndice as Indice', 'Indice.Id_Indice = IndiceGrupo.TbIndice_Id_Indice AND Indice.Tp_Ativo = \'S\'','left');
//     $this->db->join('tbl_roles as Role', 'Role.roleId = Usuarios.roleId','left');
        if(!empty($searchText)) {
            $likeCriteria = "(GrupoPro.Ds_GrupoPro LIKE '%".$searchText."%')";
            $this->db->where($likeCriteria);
        }
    //    $this->db->where('IndiceGrupo.Deletado !=', 'S');
        $this->db->where('IndiceGrupo.TbEmpresa_Id_Empresa', $IdEmpresa);
        $this->db->limit($page, $segment);
        $query = $this->db->get();

        $result = $query->result();
        return $result;
    }

    function adicionaIndiceGrupoPro($info)
    {
        $this->db->trans_start(); 
        $this->db->insert('TbIndiceGrupo', $info);

        $insert_id = $this->db->insert_id();

        $this->db->trans_complete();

        return $insert_id;
    }

    function consultaIndiceGruProExistente($TbGrupoPro_CodGrupo, $TbIndice_Id_Indice, $IdEmpresa)
    {
        $this->db->select('*');
        $this->db->from('TbIndiceGrupo as IndiceGruPro');
        $this->db->where('IndiceGruPro.TbGrupoPro_CodGrupo', $TbGrupoPro_CodGrupo);
        $this->db->where('IndiceGruPro.TbIndice_Id_Indice', $TbIndice_Id_Indice);
        $this->db->where('IndiceGruPro.TbEmpresa_Id_Empresa', $IdEmpresa);
    //    $this->db->where('IndiceGruPro.Deletado !=', 'S');
        $query = $this->db->get();

        return $query->result();
    }

    function consultaRegraGruProExistente($TbGrupoPro_CodGrupo, $TbRegra_Id_Regra, $IdEmpresa)
    {
        $this->db->select('*');
        $this->db->from('Tb_RegraGruPro as RegraGruPro');
        $this->db->where('RegraGruPro.TbGrupoPro_CodGrupo', $TbGrupoPro_CodGrupo);
        $this->db->where('RegraGruPro.TbRegra_Id_Regra', $TbRegra_Id_Regra);
        $this->db->where('RegraGruPro.TbEmpresa_Id_Empresa', $IdEmpresa);
    //    $this->db->where('RegraGruPro.Deletado !=', 'S');
        $query = $this->db->get();

    //    var_dump($this->db->last_query());exit;

        return $query->result();
    }

    function editaIndiceGrupoPro($info, $id)
    {
        $this->db->where('Id_IndiceGrupo', $id);
        $this->db->update('TbIndiceGrupo', $info);

        return TRUE;
    }

    function apagaIndiceGrupoPro($info,$id)
    {
        $this->db->where('Id_IndiceGrupo', $id);
        $res = $this->db->delete('TbIndiceGrupo');

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

    function carregaInfoIndiceGrupoPro($Id)
    {
        $this->db->select('*');
        $this->db->from('TbIndiceGrupo');
        $this->db->where('Id_IndiceGrupo', $Id);
        $query = $this->db->get();

        return $query->result();
    }

    function carregaInfoIndiceGrupoProPorIndice($id, $idEmpresa)
    {
        $this->db->select('distinct("IndiceGrupo"."Id_IndiceGrupo"), GrupoPro.CodGrupoPro, GrupoPro.Ds_GrupoPro, IndiceGrupo.*');
        $this->db->from('TbIndiceGrupo as IndiceGrupo');
        $this->db->join('TbGrupoPro as GrupoPro', 'GrupoPro.CodGrupoPro = IndiceGrupo.TbGrupoPro_CodGrupo AND GrupoPro.Tp_Ativo = \'S\' AND GrupoPro.TbEmpresa_Id_Empresa = '.$idEmpresa.'','left');
        $this->db->where('IndiceGrupo.TbIndice_Id_Indice', $id);
        $this->db->where('IndiceGrupo.TbEmpresa_Id_Empresa', $idEmpresa);
        // $this->db->where('IndiceGrupo.Deletado !=', 'S');
        $query = $this->db->get();

        return $query->result();
    }

    function carregaInfoIndiceGrupoProEmpresa($idEmpresa)
    {
        $this->db->select('*');
        $this->db->from('TbIndiceGrupo as IndiceGrupo');
        $this->db->where('IndiceGrupo.TbEmpresa_Id_Empresa', $idEmpresa);
    //    $this->db->where('IndiceGrupo.Deletado !=', 'S');
        $this->db->where('IndiceGrupo.Tp_Ativo', 'S');
        $query = $this->db->get();

        return $query->result();
    }

    function carregaInfoGrupoPro($idEmpresa)
    {
        $this->db->select('*');
        $this->db->from('TbGrupoPro as GrupoPro');
        $this->db->where('GrupoPro.TbEmpresa_Id_Empresa', $idEmpresa);
    //    $this->db->where('GrupoPro.Deletado !=', 'S');
        $this->db->where('GrupoPro.Tp_Ativo', 'S');
        $this->db->order_by('GrupoPro.CodGrupoPro', 'ASC');
        $query = $this->db->get();

        return $query->result();
    }

// FIM DAS CONSULTAS NA TELA DE INDICE GRUPO PRO

// INICIO DAS CONSULTAS NA TELA DE REGRA PROIBIÇÃO
function listaRegraProibicao($IdEmpresa, $searchText = '', $page, $segment)
{
    $this->db->select('DISTINCT(\'Id_RegraProibicao\'), RegraProibicao.*,Faturamento.Ds_Faturamento,GrupoPro.Ds_GrupoPro,Plano.Ds_Plano, Convenio.Ds_Convenio');
    $this->db->from('Tb_RegraProibicao as RegraProibicao');
    $this->db->join('TbFaturamento as Faturamento', 'Faturamento.Id_Faturamento = RegraProibicao.TbFaturamento_Id_Faturamento AND Faturamento.Tp_Ativo = \'S\'','left');
    $this->db->join('TbGrupoPro as GrupoPro', 'GrupoPro.CodGrupoPro = RegraProibicao.TbGrupoPro_CodGrupo AND GrupoPro.Tp_Ativo = \'S\' and GrupoPro.TbEmpresa_Id_Empresa = '.$IdEmpresa.'','left');
    $this->db->join('TbPlano as Plano', 'Plano.Id_Plano = RegraProibicao.TbPlano_Id_Plano AND Plano.Tp_Ativo = \'S\'','left');
    $this->db->join('TbConvenio as Convenio', 'Convenio.Id_Convenio = Plano.TbConvenio_Id_Convenio AND Convenio.Tp_Ativo = \'S\'','left');
//     $this->db->join('tbl_roles as Role', 'Role.roleId = Usuarios.roleId','left');
    if(!empty($searchText)) {
        $likeCriteria = "(RegraProibicao.Ds_RegraProibicao LIKE '%".$searchText."%')";
        $this->db->where($likeCriteria);
    }
//    $this->db->where('RegraProibicao.Deletado !=', 'S');
    $this->db->where('RegraProibicao.TbEmpresa_Id_Empresa', $IdEmpresa);
    $this->db->limit($page, $segment);
    $this->db->order_by('Convenio.Ds_Convenio', 'ASC');
    $this->db->order_by('Plano.Ds_Plano', 'ASC');
    $query = $this->db->get();
	
    $result = $query->result();
    return $result;
}

function adicionaRegraProibicao($info)
{
    $this->db->trans_start();
    $this->db->insert('Tb_RegraProibicao', $info);

    $insert_id = $this->db->insert_id();

    $this->db->trans_complete();

    return $insert_id;
}

function editaRegraProibicao($info, $id)
{
    $this->db->where('Id_RegraProibicao', $id);
    $this->db->update('Tb_RegraProibicao', $info);

    return TRUE;
}

function apagaRegraProibicao($info,$id)
{
    $this->db->where('Id_RegraProibicao', $id);
    $res = $this->db->delete('Tb_RegraProibicao');

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

function carregaInfoRegraProibicao($Id)
{
    $this->db->select('*');
    $this->db->from('Tb_RegraProibicao');
    $this->db->where('Id_RegraProibicao', $Id);
    $query = $this->db->get();

    return $query->result();
}

function carregaInfoRegraProibicaoEmpresa($idEmpresa)
{
    $this->db->select('*');
    $this->db->from('Tb_RegraProibicao as RegraProibicao');
    $this->db->where('RegraProibicao.TbEmpresa_Id_Empresa', $idEmpresa);
//    $this->db->where('RegraProibicao.Deletado !=', 'S');
    $this->db->where('RegraProibicao.Tp_Ativo', 'S');
    $query = $this->db->get();

    return $query->result();
}
// FIM DAS CONSULTAS NA TELA DE REGRA PROIBIÇÃO

// INICIO DAS CONSULTAS NA TELA DE FRAÇÃO SIMPRO BRA
    function listaFracaoSimproBra($IdEmpresa, $searchText = '', $page, $segment)
    {
        $this->db->select('FracaoSimproBra.*');
        $this->db->from('Tb_FracaoSimproBra as FracaoSimproBra');
        $this->db->join('TbProFat as ProFat', 'ProFat.Cd_ProFat = FracaoSimproBra.TbProFat_Cd_ProFat AND ProFat.Tp_Ativo = \'S\'','left');
        $this->db->join('TbFaturamento as Faturamento', 'Faturamento.Id_Faturamento = FracaoSimproBra.TbFaturamento_Id_Faturamento AND Faturamento.Tp_Ativo = \'S\'','left');
        $this->db->join('TbTUSS as TUSS', 'TUSS.Id_Tuss = FracaoSimproBra.TbTUSS_Id_Tuss AND TUSS.Tp_Ativo = \'S\'','left');
//     $this->db->join('tbl_roles as Role', 'Role.roleId = Usuarios.roleId','left');
        if(!empty($searchText)) {
            $likeCriteria = "(FracaoSimproBra.Ds_FracaoSimproBra LIKE '%".$searchText."%'
                            OR FracaoSimproBra.Ds_Laboratorio LIKE '%".$searchText."%'
                            OR FracaoSimproBra.Ds_Apresentacao LIKE '%".$searchText."%')";
            $this->db->where($likeCriteria);
        }
    //    $this->db->where('FracaoSimproBra.Deletado !=', 'S');
        $this->db->where('FracaoSimproBra.TbEmpresa_Id_Empresa', $IdEmpresa);
        $this->db->limit($page, $segment);
        $query = $this->db->get();

        $result = $query->result();
        return $result;
    }

    function adicionaFracaoSimproBra($info)
    {
        $this->db->trans_start();
        $this->db->insert('Tb_FracaoSimproBra', $info);

        $insert_id = $this->db->insert_id();

        $this->db->trans_complete();

        return $insert_id;
    }

    function editaFracaoSimproBra($info, $id)
    {
        $this->db->where('Id_FracaoSimproBra ', $id);
        $this->db->update('Tb_FracaoSimproBra', $info);

        return TRUE;
    }

    function apagaFracaoSimproBra($info,$id)
    {
        $this->db->where('Id_FracaoSimproBra', $id);
        $res = $this->db->delete('Tb_FracaoSimproBra');
    
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

    function carregaInfoFracaoSimproBra($Id)
    {
        $this->db->select('*');
        $this->db->from('Tb_FracaoSimproBra');
        $this->db->where('Id_FracaoSimproBra', $Id);
        $query = $this->db->get();

        return $query->result();
    }

    function carregaInfoFracaoSimproBraEmpresa($idEmpresa)
    {
        $this->db->select('*');
        $this->db->from('Tb_FracaoSimproBra as FracaoSimproBra');
        $this->db->where('FracaoSimproBra.TbEmpresa_Id_Empresa', $idEmpresa);
    //    $this->db->where('FracaoSimproBra.Deletado !=', 'S');
        $this->db->where('FracaoSimproBra.Tp_Ativo', 'S');
        $query = $this->db->get();

        return $query->result();
    }

    function carregaInfoProFatEmpresa($idEmpresa)
    {
        $this->db->select('*');
        $this->db->from('TbProFat as ProFat');
        $this->db->where('ProFat.TbEmpresa_Id_Empresa', $idEmpresa);
    //    $this->db->where('ProFat.Deletado !=', 'S');
        $this->db->where('ProFat.Tp_Ativo', 'S');
        $query = $this->db->get();

        return $query->result();
    }

    function carregaInfoTUSSEmpresa($idEmpresa)
    {
        $this->db->select('*');
        $this->db->from('TbTUSS as TUSS');
        $this->db->where('TUSS.TbEmpresa_Id_Empresa', $idEmpresa);
    //    $this->db->where('TUSS.Deletado !=', 'S');
        $this->db->where('TUSS.Tp_Ativo', 'S');
        $query = $this->db->get();

        return $query->result();
    }
// FIM DAS CONSULTAS NA TELA DE FRAÇÃO SIMPRO BRA

// INICIO DAS CONSULTAS NA TELA DE FATURAMENTO ITEM
    function listaFaturamentoItem($IdEmpresa, $searchText = '', $page, $segment)
    {
        $this->db->select('TUSS.Id_Tuss,TUSS.Cd_Tuss,TUSS.Ds_Tuss,PorteMedico.Id_PorteMedico,PorteMedico.Cd_PorteMedico,PorteMedico.Ds_PorteMedico,FaturamentoItem.*,Faturamento.Ds_Faturamento');
        $this->db->from('TbFatItem as FaturamentoItem');
        $this->db->join('TbFaturamento as Faturamento', 'Faturamento.Id_Faturamento = FaturamentoItem.TbFaturamento_Id_Faturamento AND Faturamento.Tp_Ativo = \'S\'','left');
        $this->db->join('TbPorteMedico as PorteMedico', 'PorteMedico.Cd_PorteMedico = FaturamentoItem.Cd_PorteMedico AND PorteMedico.Tp_Ativo = \'S\'','left');
        $this->db->join('TbTUSS as TUSS', 'TUSS.Cd_Tuss = FaturamentoItem.Cd_TUSS AND TUSS.Tp_Ativo = \'S\'','left');
//     $this->db->join('tbl_roles as Role', 'Role.roleId = Usuarios.roleId','left');
        if(!empty($searchText)) {
            $likeCriteria = "(FaturamentoItem.Ds_FatItem LIKE '%".$searchText."%')";
            $this->db->where($likeCriteria);
        }
    //    $this->db->where('FaturamentoItem.Deletado !=', 'S');
        $this->db->where('FaturamentoItem.TbEmpresa_Id_Empresa', $IdEmpresa);
        $this->db->limit($page, $segment);
        $this->db->order_by('FaturamentoItem.Id_FatItem', 'DESC');
        $query = $this->db->get();

        $result = $query->result();
        return $result;
    }

    function carregaInfoFatItemFaturamento($idFaturamento, $idEmpresa)
    {
        $this->db->select('TUSS.Id_Tuss,TUSS.Cd_Tuss,TUSS.Ds_Tuss, PorteMedico.Id_PorteMedico, PorteMedico.Cd_PorteMedico,PorteMedico.Ds_PorteMedico, FatItem.*');
        $this->db->from('TbFatItem as FatItem');
        $this->db->join('TbPorteMedico as PorteMedico', 'PorteMedico.Cd_PorteMedico = FatItem.Cd_PorteMedico AND PorteMedico.Tp_Ativo = \'S\'','left');
        $this->db->join('TbTUSS as TUSS', 'TUSS.Cd_Tuss = FatItem.Cd_TUSS AND TUSS.Tp_Ativo = \'S\'','left');
        $this->db->where('FatItem.TbFaturamento_Id_Faturamento ', $idFaturamento);
        $this->db->where('FatItem.TbEmpresa_Id_Empresa', $idEmpresa);
        $this->db->limit(1000);
    //    $this->db->where('FatItem.Deletado !=', 'S');
        $query = $this->db->get();

        return $query->result();
    }

    function adicionaFaturamentoItem($info)
    {
        $this->db->trans_start();
        $this->db->insert('TbFatItem', $info);

        $insert_id = $this->db->insert_id();

        $this->db->trans_complete();

        return $insert_id;
    }

    function editaFaturamentoItem($info, $id)
    {
        $this->db->where('Id_FatItem', $id);
        $this->db->update('TbFatItem', $info);

        return TRUE;
    }

    function apagaFaturamentoItem($id)
    {
        $this->db->where('Id_FatItem', $id);
        $res = $this->db->delete('TbFatItem');
    
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

    function carregaInfoFaturamentoItem($Id)
    {
        $this->db->select('*');
        $this->db->from('TbFatItem');
        $this->db->where('Id_FatItem', $Id);
        $query = $this->db->get();

        return $query->result();
    }

    function carregaInfoGrupoProTpGrupoPro($tpGrupoPro, $idEmpresa)
    {
        $this->db->select('GrupoPro.*');
        $this->db->from('TbGrupoPro as GrupoPro');
        $this->db->where('GrupoPro.Tp_GrupoPro', $tpGrupoPro);
        $this->db->where('GrupoPro.TbEmpresa_Id_Empresa', $idEmpresa);
    //    $this->db->where('GrupoPro.Deletado !=', 'S');
        $query = $this->db->get();

        return $query->result();
    }

    function carregaInfoFaturamentoItemEmpresa($idEmpresa)
    {
        $this->db->select('*');
        $this->db->from('TbFatItem as FaturamentoItem');
        $this->db->where('FaturamentoItem.TbEmpresa_Id_Empresa', $idEmpresa);
    //    $this->db->where('FaturamentoItem.Deletado !=', 'S');
        $this->db->where('FaturamentoItem.Tp_Ativo', 'S');
        $query = $this->db->get();

        return $query->result();
    }
// FIM DAS CONSULTAS NA TELA DE FATURAMENTO ITEM

// INICIO DAS CONSULTAS NA TELA DE UNIDADE
    function listaUnidade($IdEmpresa, $searchText = '', $page, $segment)
    {
        $this->db->select('*');
        $this->db->from('Tb_Unidade as Unidade');
//     $this->db->join('tbl_roles as Role', 'Role.roleId = Usuarios.roleId','left');
        if(!empty($searchText)) {
            $likeCriteria = "(Unidade.Ds_Unidade LIKE '%".$searchText."%')";
            $this->db->where($likeCriteria);
        }
    //    $this->db->where('Unidade.Deletado !=', 'S');
        $this->db->where('Unidade.TbEmpresa_Id_Empresa', $IdEmpresa);
        $this->db->limit($page, $segment);
        $query = $this->db->get();

        $result = $query->result();
        return $result;
    }

    function adicionaUnidade($info)
    {
        $this->db->trans_start();
        $this->db->insert('Tb_Unidade', $info);

        $insert_id = $this->db->insert_id();

        $this->db->trans_complete();

        return $insert_id;
    }

    function editaUnidade($info, $id)
    {
        $this->db->where('Id_Unidade', $id);
        $this->db->update('Tb_Unidade', $info);

        return TRUE;
    }

    function apagaUnidade($info,$id)
    {
        $this->db->where('Id_Unidade', $id);
        $res = $this->db->delete('Tb_Unidade');
    
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

    function carregaInfoUnidade($Id)
    {
        $this->db->select('*');
        $this->db->from('Tb_Unidade');
        $this->db->where('Id_Unidade', $Id);
        $query = $this->db->get();

        return $query->result();
    }

    function carregaInfoUnidadeEmpresa($idEmpresa)
    {
        $this->db->select('*');
        $this->db->from('Tb_Unidade as Unidade');
        $this->db->where('Unidade.TbEmpresa_Id_Empresa', $idEmpresa);
    //    $this->db->where('Unidade.Deletado !=', 'S');
        $this->db->where('Unidade.Tp_Ativo', 'S');
        $query = $this->db->get();

        return $query->result();
    }
// FIM DAS CONSULTAS NA TELA DE UNIDADE




// INICIO DAS CONSULTAS NA TELA DE PROIBIÇÃO
function listaProibicao($IdEmpresa, $searchText = '', $page, $segment)
{
    $this->db->select('*');
    $this->db->from('Tb_Proibicao as Proibicao');
//     $this->db->join('tbl_roles as Role', 'Role.roleId = Usuarios.roleId','left');
    if(!empty($searchText)) {
        $likeCriteria = "(Proibicao.Tp_Proibicao LIKE '%".$searchText."%')";
        $this->db->where($likeCriteria);
    }
//    $this->db->where('Proibicao.Deletado !=', 'S');
    $this->db->where('Proibicao.TbEmpresa_Id_Empresa', $IdEmpresa);
    $this->db->limit($page, $segment);
    $query = $this->db->get();

    $result = $query->result();
    return $result;
}

function adicionaProibicao($info)
{
    $this->db->trans_start();
    $this->db->insert('Tb_Proibicao', $info);

    $insert_id = $this->db->insert_id();

    $this->db->trans_complete();

    return $insert_id;
}

function editaProibicao($info, $id)
{
    $this->db->where('Id_Proibicao', $id);
    $this->db->update('Tb_Proibicao', $info);

    return TRUE;
}

function apagaProibicao($info,$id)
{
    $this->db->where('Id_Proibicao', $id);
    $res = $this->db->delete('Tb_Proibicao');

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

function carregaInfoProibicao($Id)
{
    $this->db->select('*');
    $this->db->from('Tb_Proibicao');
    $this->db->where('Id_Proibicao', $Id);
    $query = $this->db->get();

    return $query->result();
}

function carregaInfoProibicaoEmpresa($idEmpresa)
{
    $this->db->select('*');
    $this->db->from('Tb_Proibicao as Proibicao');
    $this->db->where('Proibicao.TbEmpresa_Id_Empresa', $idEmpresa);
//    $this->db->where('Proibicao.Deletado !=', 'S');
    $this->db->where('Proibicao.Tp_Ativo', 'S');
    $query = $this->db->get();

    return $query->result();
}
// FIM DAS CONSULTAS NA TELA DE PROIBIÇÃO

// INICIO DAS CONSULTAS NA TELA DE EXCEÇÃO VALORES
function listaExcecaoValores($IdEmpresa, $searchText = '', $page, $segment)
{
    $this->db->select('DISTINCT("ExcValores"."Id_ExcValores"),ProFat.Ds_ProFat, TUSS.Ds_Tuss, Convenio.Ds_Convenio, ExcValores.*');
    $this->db->from('TbExcValores as ExcValores');
    $this->db->join('TbConvenio as Convenio', 'Convenio.Cd_ConvenioERP = ExcValores.CD_Convenio','left');
    $this->db->join('TbTUSS as TUSS', 'TUSS.Cd_Tuss = ExcValores.Cd_TUSS','left');
    $this->db->join('TbProFat as ProFat', 'ProFat.CodProFat = ExcValores.Cd_ProFat','left');
    if(!empty($searchText)) {
        $likeCriteria = "(ExcValores.Ds_ExcValores  LIKE '%".$searchText."%')";
        $this->db->where($likeCriteria);
    }
//    $this->db->where('ExcValores.Deletado !=', 'S');
    $this->db->where('ExcValores.TbEmpresa_Id_Empresa', $IdEmpresa);
    $this->db->limit($page, $segment);
    $this->db->order_by('ExcValores.Id_ExcValores', 'ASC');
    $query = $this->db->get();
	    
    $result = $query->result();        
    return $result;
}

function adicionaExcecaoValores($info)
{
    $this->db->trans_start();
    $this->db->insert('TbExcValores', $info);
    
    $insert_id = $this->db->insert_id();
    
    $this->db->trans_complete();
    
    return $insert_id;
}

function editaExcecaoValores($info, $id)
{
    $this->db->where('Id_ExcValores', $id);
    $this->db->update('TbExcValores', $info);
    
    return TRUE;
}

function apagaExcecaoValores($info,$id)
{
    $this->db->where('Id_ExcValores', $id);
    $res = $this->db->delete('TbExcValores');

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

/*function consultaExcecaoValoresExistente($CNPJ_Convenio, $IdEmpresa)
{
    $this->db->select('Convenio.Id_Convenio');
    $this->db->from('TbConvenio as Convenio');
    $this->db->join('TbUsuEmp as UsuEmp', 'UsuEmp.Id_UsuEmp = Convenio.TbUsuEmp_Id_UsuEmp','inner');
    $campos = "(Convenio.CNPJ_Convenio = '".$CNPJ_Convenio."'
                AND UsuEmp.TbEmpresa_Id_Empresa  = '".$IdEmpresa."')";
    $this->db->where($campos);
    $this->db->where('Convenio.Deletado !=', 'S');
    $query = $this->db->get();

    return $query->result();
}*/

function carregaInfoExcecaoValores($IdExcValores)
{
    $this->db->select('*');
    $this->db->from('TbExcValores');
    $this->db->where('Id_ExcValores', $IdExcValores);
    $query = $this->db->get();

    return $query->result();
}

function carregaInfoExcValoresEmpresa($idEmpresa)
{
    $this->db->select('*');
    $this->db->from('TbExcValores as ExcValores');
    $this->db->where('ExcValores.TbEmpresa_Id_Empresa', $idEmpresa);
//    $this->db->where('ExcValores.Deletado !=', 'S');
    $this->db->where('ExcValores.Tp_Ativo', 'S');
    $query = $this->db->get();

    return $query->result();
}

function buscaProFat($Ds_ProFat)
    {
        $this->db->select('ProFat.CodProFat as id, CONCAT("ProFat"."CodProFat", \' - \', "ProFat"."Ds_ProFat") as "text"');
        $this->db->from('TbProFat as ProFat');
        $likeCriteria = "(ProFat.Ds_ProFat LIKE '%".$Ds_ProFat['term']."%'
                        OR ProFat.CodProFat LIKE '%".$Ds_ProFat['term']."%')";
        $this->db->where($likeCriteria);

        $query = $this->db->get();

        return $query->result();
    }

// INICIO DAS CONSULTAS NA TELA DE REGRAGRUPRO
    function listaRegraGruPro($IdEmpresa, $searchText = '', $page, $segment)
    {
        $this->db->select('GruPro.CodGrupoPro, GruPro.Ds_GrupoPro, Regra.Id_Regra, Regra.Ds_Regra, Faturamento.Id_Faturamento, Faturamento.Ds_Faturamento, RegraGruPro.*');
        $this->db->from('Tb_RegraGruPro as RegraGruPro');
        $this->db->join('TbGrupoPro as GruPro', 'GruPro.CodGrupoPro = RegraGruPro.TbGrupoPro_CodGrupo','left');
        $this->db->join('TbRegra as Regra', 'Regra.Id_Regra = RegraGruPro.TbRegra_Id_Regra','left');
        $this->db->join('TbFaturamento as Faturamento', 'Faturamento.Id_Faturamento = RegraGruPro.TbFaturamento_Id_Faturamento','left');
        if(!empty($searchText)) {
            $likeCriteria = "(GruPro.Ds_GrupoPro  LIKE '%".$searchText."%')";
            $this->db->where($likeCriteria);
        }
    //    $this->db->where('RegraGruPro.Deletado !=', 'S');
        $this->db->where('RegraGruPro.TbEmpresa_Id_Empresa', $IdEmpresa);
        $this->db->limit($page, $segment);
        $query = $this->db->get();

        $result = $query->result();
        return $result;
    }

    function adicionaRegraGruPro($info)
    {
        $this->db->trans_start();
        $this->db->insert('Tb_RegraGruPro', $info);

        $insert_id = $this->db->insert_id();

        $this->db->trans_complete();

        return $insert_id;
    }

    function editaRegraGruPro($info, $id)
    {
        $this->db->where('Id_RegraGruPro', $id);
        $this->db->update('Tb_RegraGruPro', $info);

        return TRUE;
    }

    function apagaRegraGruPro($info,$id)
    {
        $this->db->where('Id_RegraGruPro', $id);
        $res = $this->db->delete('Tb_RegraGruPro');

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

    function apagaRegraGruProPelaRegra($id)
    {
        $this->db->where('TbRegra_Id_Regra', $id);
        $res = $this->db->delete('Tb_RegraGruPro');

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

    function carregaInfoRegraGruPro($IdRegraGruPro)
    {
        $this->db->select('GrupoPro.CodGrupoPro, GrupoPro.Tp_GrupoPro, GrupoPro.Ds_GrupoPro, Faturamento.Id_Faturamento, Faturamento.Ds_Faturamento, RegraGruPro.*');
        $this->db->from('Tb_RegraGruPro as RegraGruPro');
        $this->db->join('TbGrupoPro as GrupoPro', 'GrupoPro.CodGrupoPro = RegraGruPro.TbGrupoPro_CodGrupo AND GrupoPro.Tp_Ativo = \'S\'','left');
        $this->db->join('TbFaturamento as Faturamento', 'Faturamento.Id_Faturamento = RegraGruPro.TbFaturamento_Id_Faturamento AND Faturamento.Tp_Ativo = \'S\'','left');
        $this->db->where('RegraGruPro.Id_RegraGruPro', $IdRegraGruPro);
    //    $this->db->where('RegraGruPro.Deletado !=', 'S');
    //    $this->db->where('RegraGruPro.Tp_Ativo', 'S');
        $this->db->order_by('GrupoPro.Tp_GrupoPro', 'ASC');
        $this->db->order_by('Faturamento.Id_Faturamento', 'ASC');
        $query = $this->db->get();

        return $query->result();
    }

    function carregaInfoRegraGruProEmpresa($idEmpresa)
    {
        $this->db->select('GrupoPro.CodGrupoPro, GrupoPro.Ds_GrupoPro, Faturamento.Id_Faturamento, Faturamento.Ds_Faturamento, RegraGruPro.*');
        $this->db->from('Tb_RegraGruPro as RegraGruPro');
        $this->db->join('TbGrupoPro as GrupoPro', 'GrupoPro.CodGrupoPro = RegraGruPro.TbGrupoPro_CodGrupo AND GrupoPro.Tp_Ativo = \'S\' AND GrupoPro.TbEmpresa_Id_Empresa = '.$idEmpresa.'','left');
        $this->db->join('TbFaturamento as Faturamento', 'Faturamento.Id_Faturamento = RegraGruPro.TbFaturamento_Id_Faturamento AND Faturamento.Tp_Ativo = \'S\' AND Faturamento.TbEmpresa_Id_Empresa = '.$idEmpresa.'','left');
        $this->db->where('RegraGruPro.TbEmpresa_Id_Empresa', $idEmpresa);
    //    $this->db->where('RegraGruPro.Deletado !=', 'S');
        $this->db->where('RegraGruPro.Tp_Ativo', 'S');
        $query = $this->db->get();

        return $query->result();
    }

    function carregaInfoRegraGruProRegra($idRegra,$idEmpresa)
    {
        $this->db->select('GrupoPro.CodGrupoPro, GrupoPro.Tp_GrupoPro, GrupoPro.Ds_GrupoPro, Faturamento.Id_Faturamento, Faturamento.Ds_Faturamento, RegraGruPro.*');
        $this->db->from('Tb_RegraGruPro as RegraGruPro');
        $this->db->join('TbGrupoPro as GrupoPro', 'GrupoPro.CodGrupoPro = RegraGruPro.TbGrupoPro_CodGrupo AND GrupoPro.Tp_Ativo = \'S\' AND GrupoPro.TbEmpresa_Id_Empresa = '.$idEmpresa.'','left');
        $this->db->join('TbFaturamento as Faturamento', 'Faturamento.Id_Faturamento = RegraGruPro.TbFaturamento_Id_Faturamento AND Faturamento.Tp_Ativo = \'S\' AND Faturamento.TbEmpresa_Id_Empresa = '.$idEmpresa.'','left');
        $this->db->where('RegraGruPro.TbRegra_Id_Regra', $idRegra);
        $this->db->where('RegraGruPro.TbEmpresa_Id_Empresa', $idEmpresa);
    //    $this->db->where('RegraGruPro.Deletado !=', 'S');
    //    $this->db->where('RegraGruPro.Tp_Ativo', 'S');
        $this->db->order_by('GrupoPro.Tp_GrupoPro', 'ASC');
        $this->db->order_by('GrupoPro.CodGrupoPro', 'ASC');
        $this->db->order_by('Faturamento.Id_Faturamento', 'ASC');
        $query = $this->db->get();

    //    var_dump ($this->db->last_query());exit;

        return $query->result();
    }

    function carregaInfoPorteMedico($idEmpresa)
    {
        $this->db->select('*');
        $this->db->from('TbPorteMedico as PorteMedico');
        $this->db->where('PorteMedico.TbEmpresa_Id_Empresa', $idEmpresa);
    //    $this->db->where('PorteMedico.Deletado !=', 'S');
        $this->db->where('PorteMedico.Tp_Ativo', 'S');
        $query = $this->db->get();

        return $query->result();
    }

    function carregaInfoEmpresas()
    {
        $this->db->select('*');
        $this->db->from('TbEmpresa as Empresa');
        $this->db->where('Empresa.Tp_Ativo', 'S');
        $query = $this->db->get();

        return $query->result();
    }

    function carregaInfoConvenios()
    {
        $this->db->select('*');
        $this->db->from('TbConvenio as Convenio');
        $this->db->where('Convenio.Tp_Ativo', 'S');
        $query = $this->db->get();

        return $query->result();
    }

    function consultaValoresTabela($DsTabela,$DsCampoDestino,$idEmpresa)
    {
        switch ($DsCampoDestino) {
            case 'Cd_ConvenioERP':
                $camposelect = ' ,Convenio.Ds_Convenio as ds_valores2';
                break;
            case 'TbFaturamento_Id_Faturamento':
                $camposelect = ' ,Faturamento.Ds_Faturamento as ds_valores2';
                break;
            default:
                $camposelect = null;
                break;
        }

        $this->db->select('DISTINCT("Principal"."'.$DsCampoDestino.'") as ds_valores'.$camposelect);
        $this->db->from($DsTabela.' as Principal');
        if ($DsCampoDestino == 'Cd_ConvenioERP') {$this->db->join('TbConvenio as Convenio', 'Convenio.Cd_ConvenioERP = Principal.Cd_ConvenioERP','left');}
        if ($DsCampoDestino == 'TbFaturamento_Id_Faturamento') {$this->db->join('TbFaturamento as Faturamento', 'Faturamento.Id_Faturamento = Principal.TbFaturamento_Id_Faturamento','left');}
        $this->db->where('Principal.TbEmpresa_Id_Empresa', $idEmpresa);

        switch ($DsCampoDestino) {
            case 'Cd_ConvenioERP':
                $this->db->order_by('Principal.Cd_ConvenioERP', 'ASC');
                break;
            case 'TbFaturamento_Id_Faturamento':
                $this->db->order_by('Principal.TbFaturamento_Id_Faturamento', 'ASC');
                break;
            default:
                break;
        }

        $query = $this->db->get();

        return $query->result();
    }

    function excluiDados($idEmpresa,$noTabela,$noCampo,$valores)
    {        
        if ($noCampo != 'TODA A TABELA') {
            $this->db->where($noCampo, $valores);
        }
        $this->db->where('TbEmpresa_Id_Empresa', $idEmpresa);
        $res = $this->db->delete($noTabela);

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

    function atualizaHist($info)
    {
        $this->db->trans_start();
        $this->db->insert('tbhistoricoexc', $info);
        
        $insert_id = $this->db->insert_id();
        
        $this->db->trans_complete();
        
        return $insert_id;
    }

    function carregaInfoControleCronjob()
    {
        $this->db->select('*');
        $this->db->from('tb_controle_cronjob as Controle');
        $query = $this->db->get();

        return $query->result();
    }

    function carregaInfoStatusHomologacao()
    {
        $this->db->select('*');
        $this->db->from('tb_status_homologacao');
        $this->db->where('st_ativo', 'S');
        $query = $this->db->get();

        return $query->result();
    }

// FIM DAS CONSULTAS NA TELA DE REGRAGRUPRO

}

  