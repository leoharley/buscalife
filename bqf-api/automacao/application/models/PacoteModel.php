<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class PacoteModel extends CI_Model
{
    
// INICIO DAS CONSULTAS NA TELA DE PACOTE
    function listaPacote($IdEmpresa, $searchText = '', $page, $segment)
    {
        $this->db->select('*');
        $this->db->from('tb_pacote as Pacote');
        $this->db->join('TbConvenio as Convenio', 'Convenio.Id_Convenio = Pacote.cd_convenio_id AND Convenio.Tp_Ativo = \'S\'','left');
        $this->db->join('TbPlano as Plano', 'Plano.Id_Plano = Pacote.cd_plano_id AND Plano.Tp_Ativo = \'S\'','left');
        if(!empty($searchText)) {
            $likeCriteria = "(Pacote.desc_pacote  LIKE '%".$searchText."%'
                            OR Pacote.cd_pacote_erp  LIKE '%".$searchText."%')";
            $this->db->where($likeCriteria);
        }
    //    $this->db->where('Convenio.Deletado !=', 'S');
        $this->db->where('Pacote.id_empresa', $IdEmpresa);
        $this->db->limit($page, $segment);
        $this->db->order_by('Pacote.cd_pacote', 'ASC');
        $query = $this->db->get();
        
        $result = $query->result();        
        return $result;
    }

    function adicionaPacote($info)
    {
        $this->db->trans_start();
        $this->db->insert('tb_pacote', $info);
        
        $insert_id = $this->db->insert_id();
        
        $this->db->trans_complete();
        
        return $insert_id;
    }

    function editaPacote($info, $id)
    {
        $this->db->where('cd_pacote', $id);
        $this->db->update('tb_pacote', $info);
        
        return TRUE;
    }

    function apagaPacote($id)
    {
        $this->db->where('cd_pacote', $id);
        $res = $this->db->delete('tb_pacote');

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

    // INICIO DAS CONSULTAS NA TELA DE EXCEÇÃO DE PACOTE
    function listaExcecaoPacote($IdEmpresa, $searchText = '', $page, $segment)
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

    function adicionaExcecaoPacote($info)
    {
        $this->db->trans_start();
        $this->db->insert('tb_pacote_excecao', $info);

        $insert_id = $this->db->insert_id();

        $this->db->trans_complete();

        return $insert_id;
    }

    function editaExcecaoPacote($info, $id)
    {
        $this->db->where('cd_pacote_excecao', $id);
        $this->db->update('tb_pacote_excecao', $info);

        return TRUE;
    }

    function apagaExcecaoPacote($id)
    {
        $this->db->where('cd_pacote_excecao', $id);
        $res = $this->db->delete('tb_pacote_excecao');
    
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


    // INICIO DAS CONSULTAS NA TELA DE SUBSTANCIA
    function listaSubstancia($IdEmpresa, $searchText = '', $page, $segment)
    {
        $this->db->select('*');
        $this->db->from('tb_pacote_substancia as substancia');        
//     $this->db->join('tbl_roles as Role', 'Role.roleId = Usuarios.roleId','left');
        if(!empty($searchText)) {
            $likeCriteria = "(substancia.desc_substancia LIKE '%".$searchText."%')";
            $this->db->where($likeCriteria);
        }
    //    $this->db->where('FaturamentoItem.Deletado !=', 'S');
        $this->db->where('substancia.id_empresa', $IdEmpresa);
        $this->db->limit($page, $segment);
        $this->db->order_by('substancia.cd_substancia', 'DESC');
        $query = $this->db->get();

        $result = $query->result();
        return $result;
    }

    function adicionaSubstancia($info)
    {
        $this->db->trans_start();
        $this->db->insert('tb_pacote_substancia', $info);

        $insert_id = $this->db->insert_id();

        $this->db->trans_complete();

        return $insert_id;
    }

    function editaSubstancia($info, $id)
    {
        $this->db->where('cd_substancia', $id);
        $this->db->update('tb_pacote_substancia', $info);

        return TRUE;
    }

    function apagaSubstancia($id)
    {
        $this->db->where('cd_substancia', $id);
        $res = $this->db->delete('tb_pacote_substancia');
    
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


    // INICIO DAS CONSULTAS NA TELA DE SETOR
    function listaSetor($IdEmpresa, $searchText = '', $page, $segment)
    {
        $this->db->select('*');
        $this->db->from('tb_pacote_setor as setor');        
//     $this->db->join('tbl_roles as Role', 'Role.roleId = Usuarios.roleId','left');
        if(!empty($searchText)) {
            $likeCriteria = "(setor.desc_setor LIKE '%".$searchText."%')";
            $this->db->where($likeCriteria);
        }
    //    $this->db->where('FaturamentoItem.Deletado !=', 'S');
        $this->db->where('setor.id_empresa', $IdEmpresa);
        $this->db->limit($page, $segment);
        $this->db->order_by('setor.cd_setor', 'DESC');
        $query = $this->db->get();

        $result = $query->result();
        return $result;
    }

    function adicionaSetor($info)
    {
        $this->db->trans_start();
        $this->db->insert('tb_pacote_setor', $info);

        $insert_id = $this->db->insert_id();

        $this->db->trans_complete();

        return $insert_id;
    }

    function editaSetor($info, $id)
    {
        $this->db->where('cd_setor', $id);
        $this->db->update('tb_pacote_setor', $info);

        return TRUE;
    }

    function apagaSetor($id)
    {
        $this->db->where('cd_setor', $id);
        $res = $this->db->delete('tb_pacote_setor');
    
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

    // INICIO DAS CONSULTAS NA TELA DE EXCEÇÃO PROCEDIMENTO
    function listaExcecaoProcedimento($IdEmpresa, $searchText = '', $page, $segment)
    {
        $this->db->select('excproced.cd_pacote_excecao_proced,excproced.cd_pacote_excecao,excproced.cd_tuss,pacote.desc_pacote');        
        $this->db->from('tb_pacote_excecao_proced as excproced');
        $this->db->join('tb_pacote_excecao as PacoteExcecao', 'PacoteExcecao.cd_pacote_excecao = excproced.cd_pacote_excecao','left');           
        $this->db->join('tb_pacote as pacote', 'pacote.cd_pacote = PacoteExcecao.cd_pacote','left');        
        $this->db->join('TbGrupoPro as GrupoPro', 'GrupoPro.CodGrupoPro = PacoteExcecao.cd_grupro','left');           
//     $this->db->join('tbl_roles as Role', 'Role.roleId = Usuarios.roleId','left');
        if(!empty($searchText)) {
            $likeCriteria = "(excproced.cd_pacote_excecao LIKE '%".$searchText."%')";
            $this->db->where($likeCriteria);
        }
    //    $this->db->where('FaturamentoItem.Deletado !=', 'S');
        $this->db->where('excproced.id_empresa', $IdEmpresa);
        $this->db->group_by('excproced.cd_pacote_excecao_proced,excproced.cd_pacote_excecao,excproced.cd_tuss,pacote.desc_pacote');
        $this->db->limit($page, $segment);
        $this->db->order_by('excproced.cd_pacote_excecao_proced', 'DESC');
        $query = $this->db->get();

        $result = $query->result();
        return $result;
    }

    function adicionaExcecaoProcedimento($info)
    {
        $this->db->trans_start();
        $this->db->insert('tb_pacote_excecao_proced', $info);

        $insert_id = $this->db->insert_id();

        $this->db->trans_complete();

        return $insert_id;
    }

    function editaExcecaoProcedimento($info, $id)
    {
        $this->db->where('cd_pacote_excecao_proced', $id);
        $this->db->update('tb_pacote_excecao_proced', $info);

        return TRUE;
    }

    function carregaInfoPacoteExcecaoProced($cd_pacote_excecao_proced)
    {
        $this->db->select('*');
        $this->db->from('tb_pacote_excecao_proced');
        $this->db->where('cd_pacote_excecao_proced', $cd_pacote_excecao_proced);
        $query = $this->db->get();

        return $query->result();
    }

    function apagaExcecaoProcedimento($id)
    {
        $this->db->where('cd_pacote_excecao_proced', $id);
        $res = $this->db->delete('tb_pacote_excecao_proced');
    
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

    function carregaInfoPacote($cd_pacote)
    {
        $this->db->select('*');
        $this->db->from('tb_pacote');
        $this->db->where('cd_pacote', $cd_pacote);
        $query = $this->db->get();

        return $query->result();
    }

    function carregaInfoSubstancias($IdEmpresa)
    {
        $this->db->select('*');
        $this->db->from('tb_pacote_substancia');
        $this->db->where('id_empresa', $IdEmpresa);
        $query = $this->db->get();

        return $query->result();
    }

    function carregaInfoSubstancia($cd_substancia)
    {
        $this->db->select('*');
        $this->db->from('tb_pacote_substancia');
        $this->db->where('cd_substancia', $cd_substancia);
        $query = $this->db->get();

        return $query->result();
    }

    function carregaInfoSetor($cd_setor)
    {
        $this->db->select('*');
        $this->db->from('tb_pacote_setor');
        $this->db->where('cd_setor', $cd_setor);
        $query = $this->db->get();

        return $query->result();
    }

    function carregaInfoSetores($IdEmpresa)
    {
        $this->db->select('*');
        $this->db->from('tb_pacote_setor');
        $this->db->where('id_empresa', $IdEmpresa);
        $query = $this->db->get();

        return $query->result();
    }

    function carregaInfoPacoteExcecao($cd_pacote_excecao)
    {
        $this->db->select('*');
        $this->db->from('tb_pacote_excecao');
        $this->db->join('TbGrupoPro as GrupoPro', 'GrupoPro.CodGrupoPro = cd_grupro AND GrupoPro.Tp_Ativo = \'S\'','left');        
        $this->db->where('cd_pacote_excecao', $cd_pacote_excecao);
        $query = $this->db->get();

        return $query->result();     
    }

    function carregaInfoPacoteExcecoes($IdEmpresa)
    {
        $this->db->select('pacoteexcecao.cd_pacote_excecao,pacote.desc_pacote');
        $this->db->from('tb_pacote_excecao as pacoteexcecao');
        $this->db->join('TbGrupoPro as GrupoPro', 'GrupoPro.CodGrupoPro = pacoteexcecao.cd_grupro AND GrupoPro.Tp_Ativo = \'S\'','left');
        $this->db->join('tb_pacote as pacote', 'pacote.cd_pacote = pacoteexcecao.cd_pacote','left');        
        $this->db->where('pacoteexcecao.id_empresa', $IdEmpresa);
        $this->db->group_by('pacoteexcecao.cd_pacote_excecao,pacote.desc_pacote');
        $query = $this->db->get();

        return $query->result();     
    }


    function carregaInfoExcecaoPacotePacote($cdExcecaoPacote,$idEmpresa)
    {
        $this->db->select('GrupoPro.CodGrupoPro, GrupoPro.Tp_GrupoPro, GrupoPro.Ds_GrupoPro, PacoteExc.*, Substancia.*, Setor.*');
        $this->db->from('tb_pacote_excecao as PacoteExc');
        $this->db->join('TbGrupoPro as GrupoPro', 'GrupoPro.CodGrupoPro = PacoteExc.cd_grupro AND GrupoPro.Tp_Ativo = \'S\' AND GrupoPro.TbEmpresa_Id_Empresa = '.$idEmpresa.'','left');        
        $this->db->join('tb_pacote_substancia as Substancia', 'Substancia.cd_substancia = PacoteExc.cd_substancia AND Substancia.id_empresa = '.$idEmpresa.'','left');        
        $this->db->join('tb_pacote_setor as Setor', 'Setor.cd_setor = PacoteExc.cd_setor AND Setor.id_empresa = '.$idEmpresa.'','left');        
        $this->db->where('PacoteExc.cd_pacote', $cdExcecaoPacote);
        $this->db->where('PacoteExc.id_empresa', $idEmpresa);
        $this->db->order_by('GrupoPro.Tp_GrupoPro', 'ASC');
        $this->db->order_by('GrupoPro.CodGrupoPro', 'ASC');
        $query = $this->db->get();

        return $query->result();
    }


    function consultaPacoteExcecao($cd_pacote_excecao)
    {
        $this->db->select('*');
        $this->db->from('tb_pacote_excecao as PacoteExc');
        $this->db->join('TbGrupoPro as GrupoPro', 'GrupoPro.CodGrupoPro = cd_grupro AND GrupoPro.Tp_Ativo = \'S\'','left');
        $this->db->join('tb_pacote_substancia as Substancia', 'Substancia.cd_substancia = PacoteExc.cd_substancia','left');        
        $this->db->join('tb_pacote_setor as Setor', 'Setor.cd_setor = PacoteExc.cd_setor','left');        
        $this->db->where('cd_pacote_excecao', $cd_pacote_excecao);
        $query = $this->db->get();

        return $query->result();
    }
    

}

  