<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class PermissaoModel extends CI_Model
{
    
    function permissaoTela($IdUsuEmp, $dsTela)
    {
        $this->db->select('Tela.Tp_Ativo');
        $this->db->from('TbUsuEmp as UsuEmp'); 
        $this->db->join('TabTela as Tela', 'Tela.TbPerfil_Id_CdPerfil = UsuEmp.TbPerfil_Id_CdPerfil','left');
        $this->db->where('UsuEmp.Id_UsuEmp', $IdUsuEmp);
        $this->db->where('UsuEmp.Deletado', 'N');
        $this->db->where('Tela.Ds_Tela', $dsTela);
        $query = $this->db->get();
        return $query->result();
    }

    function permissaoAcaoAtualizar($IdUsuEmp, $dsTela)
    {
        $this->db->select('Permissao.Atualizar');    
        $this->db->from('TbPermissao as Permissao'); 
        $this->db->join('TbUsuEmp as UsuEmp', 'UsuEmp.TbPerfil_Id_CdPerfil = Permissao.TbPerfil_Id_CdPerfil','inner');
        $this->db->join('TabTela as Tela', 'Tela.TbPerfil_Id_CdPerfil = Permissao.TbPerfil_Id_CdPerfil and Tela.Id_Tela = Permissao.TabTela_Id_Tela','inner');
        $this->db->where('UsuEmp.Id_UsuEmp', $IdUsuEmp);
        $this->db->where('UsuEmp.Deletado', 'N');
        $this->db->where('Tela.Ds_Tela', $dsTela);
        $query = $this->db->get();

        return $query->result();
    }

    function permissaoAcaoInserir($IdUsuEmp, $dsTela)
    {
        $this->db->select('Permissao.Inserir');    
        $this->db->from('TbPermissao as Permissao'); 
        $this->db->join('TbUsuEmp as UsuEmp', 'UsuEmp.TbPerfil_Id_CdPerfil = Permissao.TbPerfil_Id_CdPerfil','inner');
        $this->db->join('TabTela as Tela', 'Tela.TbPerfil_Id_CdPerfil = Permissao.TbPerfil_Id_CdPerfil and Tela.Id_Tela = Permissao.TabTela_Id_Tela','inner');
        $this->db->where('UsuEmp.Id_UsuEmp', $IdUsuEmp);
        $this->db->where('UsuEmp.Deletado', 'N');
        $this->db->where('Tela.Ds_Tela', $dsTela);
        $query = $this->db->get();

        return $query->result();
    }

    function permissaoAcaoExcluir($IdUsuEmp, $dsTela)
    {       
        $this->db->select('Permissao.Excluir');    
        $this->db->from('TbPermissao as Permissao'); 
        $this->db->join('TbUsuEmp as UsuEmp', 'UsuEmp.TbPerfil_Id_CdPerfil = Permissao.TbPerfil_Id_CdPerfil','inner');
        $this->db->join('TabTela as Tela', 'Tela.TbPerfil_Id_CdPerfil = Permissao.TbPerfil_Id_CdPerfil and Tela.Id_Tela = Permissao.TabTela_Id_Tela','inner');
        $this->db->where('UsuEmp.Id_UsuEmp', $IdUsuEmp);
        $this->db->where('UsuEmp.Deletado', 'N');
        $this->db->where('Tela.Ds_Tela', $dsTela);
        $query = $this->db->get();

        return $query->result();
    }

    function permissaoAcaoConsultar($IdUsuEmp, $dsTela)
    {
        $this->db->select('Permissao.Consultar');    
        $this->db->from('TbPermissao as Permissao'); 
        $this->db->join('TbUsuEmp as UsuEmp', 'UsuEmp.TbPerfil_Id_CdPerfil = Permissao.TbPerfil_Id_CdPerfil','inner');
        $this->db->join('TabTela as Tela', 'Tela.TbPerfil_Id_CdPerfil = Permissao.TbPerfil_Id_CdPerfil and Tela.Id_Tela = Permissao.TabTela_Id_Tela','inner');
        $this->db->where('UsuEmp.Id_UsuEmp', $IdUsuEmp);
        $this->db->where('UsuEmp.Deletado', 'N');
        $this->db->where('Tela.Ds_Tela', $dsTela);
        $query = $this->db->get();

        return $query->result();
    }

    function permissaoAcaoImprimir($IdUsuEmp, $dsTela)
    {
        $this->db->select('Permissao.Imprimir');    
        $this->db->from('TbPermissao as Permissao'); 
        $this->db->join('TbUsuEmp as UsuEmp', 'UsuEmp.TbPerfil_Id_CdPerfil = Permissao.TbPerfil_Id_CdPerfil','inner');
        $this->db->join('TabTela as Tela', 'Tela.TbPerfil_Id_CdPerfil = Permissao.TbPerfil_Id_CdPerfil and Tela.Id_Tela = Permissao.TabTela_Id_Tela','inner');
        $this->db->where('UsuEmp.Id_UsuEmp', $IdUsuEmp);
        $this->db->where('UsuEmp.Deletado', 'N');
        $this->db->where('Tela.Ds_Tela', $dsTela);
        $query = $this->db->get();

        return $query->result();
    }

}

  