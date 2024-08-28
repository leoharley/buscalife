<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class CadastroModel extends CI_Model
{
    /**
     * This function is used to get the user listing count
     * @param string $searchText : This is optional search text
     * @return number $count : This is row count
     */
    function userListingCount($searchText = '')
    {
        $this->db->select('BaseTbl.userId, BaseTbl.email, BaseTbl.name, BaseTbl.mobile, Role.role');
        $this->db->from('tbl_users as BaseTbl');
        $this->db->join('tbl_roles as Role', 'Role.roleId = BaseTbl.roleId','left');
        if(!empty($searchText)) {
            $likeCriteria = "(BaseTbl.email  LIKE '%".$searchText."%'
                            OR  BaseTbl.name  LIKE '%".$searchText."%'
                            OR  BaseTbl.mobile  LIKE '%".$searchText."%')";
            $this->db->where($likeCriteria);
        }
        $this->db->where('BaseTbl.isDeleted', 0);
        $query = $this->db->get();
        
        return $query->num_rows();
    }
    
    /**
     * This function is used to get the user listing count
     * @param string $searchText : This is optional search text
     * @param number $page : This is pagination offset
     * @param number $segment : This is pagination limit
     * @return array $result : This is result
     */

// INICIO DAS CONSULTAS NA TELA DE USUÁRIO
    function listaUsuarios($idUser, $idEmpresa, $searchText = '', $page, $segment)
    {
        $this->db->select('Usuarios.Id_Usuario, Usuarios.Nome_Usuario, Usuarios.Admin, Usuarios.Cpf_Usuario, Usuarios.Tp_Ativo, Usuarios.Dt_Ativo, Usuarios.CriadoPor, Usuarios.Dt_Inativo, Usuarios.Email');
        $this->db->from('TabUsuario as Usuarios');
        $this->db->join('TbUsuEmp as UsuEmp', 'UsuEmp.TabUsuario_Id_Usuario = Usuarios.Id_Usuario AND UsuEmp.Deletado <> \'S\'','left');
   //     $this->db->join('tbl_roles as Role', 'Role.roleId = Usuarios.roleId','left');
        if(!empty($searchText)) {
            $likeCriteria = "(Usuarios.Email  LIKE '%".$searchText."%'
                            OR  Usuarios.Nome_Usuario  LIKE '%".$searchText."%'
                            OR  Usuarios.Cpf_Usuario  LIKE '%".$searchText."%')";
            $this->db->where($likeCriteria);
        }
        $this->db->where('UsuEmp.TbEmpresa_Id_Empresa', $idEmpresa);
        $this->db->where('Usuarios.Deletado <>', 'S');
        $this->db->where('Usuarios.Id_Usuario <>', $idUser);
        $this->db->where('Usuarios.CriadoPor', $idUser);

        $this->db->limit($page, $segment);
        $query = $this->db->get();
		        
        $result = $query->result();        
        return $result;
    }

    function adicionaUsuario($infoUsuario)
    {
        $this->db->trans_start();
        $this->db->insert('TabUsuario', $infoUsuario);
        
        $insert_id = $this->db->insert_id();
        
        $this->db->trans_complete();

        $infoUsuEmp = array('TabUsuario_Id_Usuario'=> $insert_id, 'CriadoPor'=>$infoUsuario['CriadoPor'],
        'AtualizadoPor'=>$infoUsuario['CriadoPor'], 'TbEmpresa_Id_Empresa'=>$this->session->userdata('IdEmpresa'),
		'Dt_Atualizacao'=>date('Y-m-d H:i:s'));

        $this->db->trans_start();
        $this->db->insert('TbUsuEmp', $infoUsuEmp);
        
        $insert_id_UsuEmp = $this->db->insert_id();
        
        $this->db->trans_complete();
        
        return $insert_id;
    }

    function editaUsuario($infoUsuario, $IdUsuario)
    {
        $this->db->where('Id_Usuario', $IdUsuario);
        $this->db->update('TabUsuario', $infoUsuario);
        
        return TRUE;
    }

    function setaUsuarioAdm($IdUsuario, $infoUsuario)
    {
        $this->db->where('Id_Usuario', $IdUsuario);
        $this->db->update('TabUsuario', $infoUsuario);
        
        return TRUE;
    }
    
    function apagaUsuario($infoUsuario, $IdUsuario)
    {
        $this->db->where('TabUsuario_Id_Usuario', $IdUsuario);
        $res1 = $this->db->delete('TbUsuEmp');

        $this->db->where('Id_Usuario', $IdUsuario);
        $res2 = $this->db->delete('TabUsuario');

        if(!$res1 && !$res2)
        {
            $error = $this->db->error();
            return $error['code'];
            //return array $error['code'] & $error['message']
        }
        else
        {
            return TRUE;
        }

        // $this->db->where('Id_Usuario', $IdUsuario);
        // $this->db->update('TabUsuario', $infoUsuario);
        
        // return $this->db->affected_rows();
    }

    function carregaInfoUsuario($IdUsuario)
    {
        $this->db->select('Id_Usuario, Nome_Usuario, Email, Cpf_Usuario, Admin, Tp_Ativo');
        $this->db->from('TabUsuario');
        $this->db->where('Id_Usuario', $IdUsuario);
        $query = $this->db->get();
        
        return $query->result();
    }

    function carregaInfoUsuarioPorEmail($email)
    {
        $this->db->select('Id_Usuario, Nome_Usuario, Email, Cpf_Usuario, Admin, Tp_Ativo');
        $this->db->from('TabUsuario');
        $this->db->where('Email', $email);
        $query = $this->db->get();

        return $query->result();
    }

    function consultaUsuarioExistente($CpfUsuario, $Email)
    {
        $this->db->select('Id_Usuario, Nome_Usuario, Email, Cpf_Usuario, Tp_Ativo');
        $this->db->from('TabUsuario');
        $campos = "((\"Cpf_Usuario\" = '".$CpfUsuario."'
                    OR Email = '".$Email."')
                    AND Deletado = 'N')";
        $this->db->where($campos);
        $query = $this->db->get();
        
        return $query->result();
    }

    function carregaEmpresasPerfilUsuario($IdUsuario)
    {
    $this->db->select('Empresa.Id_Empresa, Empresa.Nome_Empresa, UsuEmp.TbEmpresa_Id_Empresa,
                        UsuEmp.TbPerfil_Id_CdPerfil, Perfil.Ds_Perfil');
    $this->db->from('TbUsuEmp as UsuEmp');
    $this->db->join('TbEmpresa as Empresa', 'Empresa.Id_Empresa = UsuEmp.TbEmpresa_Id_Empresa AND Empresa.Deletado <> \'S\' AND Empresa.Tp_Ativo = \'S\'','inner');
    $this->db->join('TbPerfil as Perfil', 'Perfil.Id_CdPerfil = UsuEmp.TbPerfil_Id_CdPerfil AND Perfil.Deletado <> \'S\' AND Perfil.Tp_Ativo = \'S\'','inner');
    $this->db->where('UsuEmp.TabUsuario_Id_Usuario', $IdUsuario);
    $this->db->where('UsuEmp.Deletado', 'N');
//    $this->db->where('UsuEmp.TbPerfil_Id_CdPerfil <>', '99');

    $query = $this->db->get();
	    
    return $query->result();
    }

    function carregaPerfilUsuario($IdEmpresa, $IdUsuario)
    {
    $this->db->select('UsuEmp.Id_UsuEmp, UsuEmp.TbEmpresa_Id_Empresa, UsuEmp.TbPerfil_Id_CdPerfil, Perfil.Ds_Perfil, Usuario.Admin');
    $this->db->from('TbUsuEmp as UsuEmp');
    $this->db->join('TbEmpresa as Empresa', 'Empresa.Id_Empresa = UsuEmp.TbEmpresa_Id_Empresa AND Empresa.Deletado <> \'S\' AND Empresa.Tp_Ativo = \'S\'','inner');
    $this->db->join('TbPerfil as Perfil', 'Perfil.Id_CdPerfil = UsuEmp.TbPerfil_Id_CdPerfil AND Perfil.Deletado <> \'S\' AND Perfil.Tp_Ativo = \'S\'','inner');
    $this->db->join('TabUsuario as Usuario', 'Usuario.Id_Usuario = UsuEmp.TabUsuario_Id_Usuario AND Usuario.Deletado <> \'S\' AND Usuario.Tp_Ativo = \'S\'','inner');
    $this->db->where('UsuEmp.TbEmpresa_Id_Empresa', $IdEmpresa);
    $this->db->where('UsuEmp.TabUsuario_Id_Usuario', $IdUsuario);
    $this->db->where('UsuEmp.Deletado', 'N');
    $query = $this->db->get();
	    
    return $query->result();
    }
// FIM DAS CONSULTAS NA TELA DE USUÁRIO
    
// INICIO DAS CONSULTAS NA TELA DE EMPRESA
function listaEmpresas($idUser, $idEmpresa, $searchText = '', $page, $segment)
{
    $this->db->select('Empresas.Id_Empresa, Empresas.Nome_Empresa, Empresas.CNPJ, Empresas.Cd_EmpresaERP, Empresas.End_Empresa, Empresas.Nome_Contato, 
    Empresas.Telefone, Empresas.Email_Empresa, Empresas.CriadoPor, Empresas.Dt_Valida_Contrato, Empresas.Tp_Ativo, Empresas.Dt_Ativo, Empresas.Dt_Inativo');
    $this->db->from('TbEmpresa as Empresas');
//     $this->db->join('tbl_roles as Role', 'Role.roleId = Usuarios.roleId','left');
    if(!empty($searchText)) {
        $likeCriteria = "(Empresas.Email_Empresa  LIKE '%".$searchText."%'
                        OR  Empresas.Nome_Empresa  LIKE '%".$searchText."%'
                        OR  Empresas.CNPJ  LIKE '%".$searchText."%')";
        $this->db->where($likeCriteria);
    }
    $likeCriteria2 = "(Empresas.CriadoPor = '".$idUser."'
                        OR  Empresas.Id_Empresa = '".$idEmpresa."')";
    $this->db->where($likeCriteria2);
    $this->db->where('Empresas.Deletado <>', 'S');
    $this->db->limit($page, $segment);
    $query = $this->db->get();
    
    $result = $query->result();        
    return $result;
}

function adicionaEmpresa($infoEmpresa)
{
    $this->db->trans_start();
    $this->db->insert('TbEmpresa', $infoEmpresa);
    
    $insert_id = $this->db->insert_id();
    
    $this->db->trans_complete();
    
    return $insert_id;
}

function editaEmpresa($infoEmpresa, $IdEmpresa)
{
    $this->db->where('Id_Empresa', $IdEmpresa);
    $this->db->update('TbEmpresa', $infoEmpresa);
    
    return TRUE;
}

function apagaEmpresa($infoEmpresa, $IdEmpresa)
{

        $this->db->where('Id_Empresa', $IdEmpresa);
        $res = $this->db->delete('TbEmpresa');

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

    // $this->db->where('Id_Empresa', $IdEmpresa);
    // $this->db->update('TbEmpresa', $infoEmpresa);
    
    // return $this->db->affected_rows();
}

function carregaInfoEmpresa($IdEmpresa)
{
    $this->db->select('Id_Empresa, Nome_Empresa, CNPJ, Cd_EmpresaERP, End_Empresa, Nome_Contato,
    Telefone, Email_Empresa, Dt_Valida_Contrato, Tp_Ativo');
    $this->db->from('TbEmpresa');
    $this->db->where('Id_Empresa', $IdEmpresa);
    $query = $this->db->get();
    
    return $query->result();
}
// FIM DAS CONSULTAS NA TELA DE EMPRESA

// INICIO DAS CONSULTAS NA TELA DE PERFIL
function listaPerfis($idUser, $searchText = '', $page, $segment)
{
    $this->db->select('Perfis.Id_CdPerfil, Perfis.Ds_Perfil, Perfis.CriadoPor, Perfis.AtualizadoPor, Perfis.Dt_Atualizacao, Perfis.Dt_Ativo, 
    Perfis.Dt_Inativo, Perfis.Tp_Ativo');
    $this->db->from('TbPerfil as Perfis');
//     $this->db->join('tbl_roles as Role', 'Role.roleId = Usuarios.roleId','left');
    if(!empty($searchText)) {
        $likeCriteria = "(Perfis.Ds_Perfil  LIKE '%".$searchText."%')";
        $this->db->where($likeCriteria);
    }
    $this->db->where('Perfis.Deletado <>', 'S');
    $this->db->where('Perfis.CriadoPor', $idUser);
    $this->db->limit($page, $segment);
    $query = $this->db->get();
    
    $result = $query->result();        
    return $result;
}

function adicionaPerfil($infoPerfil)
{
    $this->db->trans_start();
    $this->db->insert('TbPerfil', $infoPerfil);
    $insert_id = $this->db->insert_id();
    $this->db->trans_complete();

    $DsTelas = array('TelaConvenio','TelaPlano','TelaRegra','TelaIndice','TelaRegraFat','TelaUsuario','TelaFaturamento','TelaEmpresa','TelaIndiceGrupoPro','TelaRegraProibicao','TelaFracaoSimproBra','TelaFaturamentoItem','TelaUnidade','TelaExcecaoValores','TelaRegraGruPro');

    foreach ($DsTelas as $data) {
        $infoTelas = array('TbPerfil_Id_CdPerfil'=> $insert_id, 'Ds_Tela'=>$data, 'CriadoPor'=>$infoPerfil['CriadoPor'],
        'CriadoPor'=>$infoPerfil['CriadoPor'], 'Dt_Atualizacao'=>date('Y-m-d H:i:s'));
        $this->db->trans_start();
        $this->db->insert('TabTela', $infoTelas);
        $insert_id_Tela = $this->db->insert_id();
        $this->db->trans_complete();

        $infoPermissao = array('TbPerfil_Id_CdPerfil'=> $insert_id, 'TabTela_Id_Tela'=>$insert_id_Tela,
        'CriadoPor'=>$infoPerfil['CriadoPor'],'Dt_Atualizacao'=>date('Y-m-d H:i:s'));
        $this->db->trans_start();
        $this->db->insert('TbPermissao', $infoPermissao);
        
        $insert_id_Permissao = $this->db->insert_id();
        
        $this->db->trans_complete();
    }
    
    return $insert_id;
}

function editaPerfil($infoPerfil, $IdPerfil)
{
    $this->db->where('Id_CdPerfil', $IdPerfil);
    $this->db->update('TbPerfil', $infoPerfil);
    
    return TRUE;
}

function apagaPerfil($infoPerfil, $IdPerfil)
{
        $this->db->where('TbPerfil_Id_CdPerfil', $IdPerfil);
        $res1 = $this->db->delete('TbPermissao');

        $this->db->where('Id_CdPerfil', $IdPerfil);
        $res2 = $this->db->delete('TbPerfil');

        if(!$res1 && !$res2)
        {
            $error = $this->db->error();
            return $error['code'];
            //return array $error['code'] & $error['message']
        }
        else
        {
            return TRUE;
        }
        
    // $this->db->where('Id_CdPerfil', $IdPerfil);
    // $this->db->update('TbPerfil', $infoPerfil);
    
    // return $this->db->affected_rows();
}

function carregaInfoPerfil($IdPerfil)
{
    $this->db->select('Id_CdPerfil, Ds_Perfil, PerfilAdmin, PerfilAdmin, CriadoPor, AtualizadoPor, Dt_Atualizacao, Dt_Ativo,
    Dt_Inativo, Tp_Ativo');
    $this->db->from('TbPerfil');
    $this->db->where('Id_CdPerfil', $IdPerfil);
    $query = $this->db->get();
    
    return $query->result();
}
// FIM DAS CONSULTAS NA TELA DE PERFIL


// INICIO DAS CONSULTAS NA TELA DE TELAS
function listaTelas($idUser, $searchText = '', $page, $segment)
{
    $this->db->select('Telas.Id_Tela, Perfis.Ds_Perfil, Telas.Ds_Tela, Telas.Tp_Ativo');
    $this->db->from('TabTela as Telas');
    $this->db->join('TbPerfil as Perfis', 'Perfis.Id_CdPerfil = Telas.TbPerfil_Id_CdPerfil AND Perfis.Deletado <> \'S\' AND Perfis.Tp_Ativo = \'S\'','inner');
    if(!empty($searchText)) {
        $likeCriteria = "(Perfis.Ds_Perfil  LIKE '%".$searchText."%')";
        $this->db->where($likeCriteria);
    }
    $this->db->where('Telas.CriadoPor', $idUser);
    $this->db->limit($page, $segment);
    $query = $this->db->get();
    
    $result = $query->result();        
    return $result;
}

function editaTelas($infoTelas, $IdTelas)
{
    $this->db->where('Id_Tela', $IdTelas);
    $this->db->update('TabTela', $infoTelas);
    
    return TRUE;
}

function carregaInfoTelas($IdTelas)
{
    $this->db->select('Telas.Id_Tela, Perfis.Ds_Perfil, Telas.Ds_Tela, Telas.Tp_Ativo');
    $this->db->from('TabTela as Telas');
    $this->db->join('TbPerfil as Perfis', 'Perfis.Id_CdPerfil = Telas.TbPerfil_Id_CdPerfil AND Perfis.Deletado <> \'S\' AND Perfis.Tp_Ativo = \'S\'','inner');
    $this->db->where('Id_Tela', $IdTelas);
    $query = $this->db->get();
    
    return $query->result();
}
// FIM DAS CONSULTAS NA TELA DE TELAS

// INICIO DAS CONSULTAS NA TELA DE PERMISSOES
function listaPermissao($idUser, $searchText = '', $page, $segment)
{
    $this->db->select('Permissao.Id_Permissao, Perfis.Ds_Perfil, Telas.Ds_Tela, Permissao.Atualizar,
    Permissao.Inserir, Permissao.Excluir, Permissao.Consultar, Permissao.Imprimir');
    $this->db->from('TbPermissao as Permissao');
    $this->db->join('TabTela as Telas', 'Telas.Id_Tela = Permissao.TabTela_Id_Tela AND Telas.Tp_Ativo = \'S\'','inner');
    $this->db->join('TbPerfil as Perfis', 'Perfis.Id_CdPerfil = Permissao.TbPerfil_Id_CdPerfil AND Perfis.Deletado = \'N\' AND Perfis.Tp_Ativo = \'S\'','inner');
    if(!empty($searchText)) {
        $likeCriteria = "(Perfis.Ds_Perfil  LIKE '%".$searchText."%'
                        OR  Telas.Ds_Tela  LIKE '%".$searchText."%')";
        $this->db->where($likeCriteria);
    }
    $this->db->where('Permissao.CriadoPor', $idUser);
    $this->db->limit($page, $segment);
    $query = $this->db->get();
    
    $result = $query->result();        
    return $result;
}

function editaPermissao($infoPermissao, $IdPermissao)
{
    $this->db->where('Id_Permissao', $IdPermissao);
    $this->db->update('TbPermissao', $infoPermissao);
    
    return TRUE;
}

function carregaInfoPermissao($IdPermissao)
{
    $this->db->select('Permissao.Id_Permissao, Perfis.Ds_Perfil, Telas.Ds_Tela, Permissao.Atualizar,
    Permissao.Inserir, Permissao.Excluir, Permissao.Consultar, Permissao.Imprimir');
    $this->db->from('TbPermissao as Permissao');
    $this->db->join('TabTela as Telas', 'Telas.Id_Tela = Permissao.TabTela_Id_Tela AND Telas.Tp_Ativo = \'S\'','inner');
    $this->db->join('TbPerfil as Perfis', 'Perfis.Id_CdPerfil = Permissao.TbPerfil_Id_CdPerfil AND Perfis.Deletado <> \'S\' AND Perfis.Tp_Ativo = \'S\'','inner');
    $this->db->where('Id_Permissao', $IdPermissao);
    $query = $this->db->get();
    
    return $query->result();
}
// FIM DAS CONSULTAS NA TELA DE PERMISSAO

// INICIO DAS CONSULTAS NA TELA DE USUÁRIO/EMPRESA
function listaUsuarioEmpresa($idUser, $searchText = '', $page, $segment)
{
    $this->db->select('UsuEmp.Id_UsuEmp, Usuario.Id_Usuario, Usuario.Nome_Usuario, Empresa.Nome_Empresa, Perfis.Ds_Perfil');
    $this->db->from('TbUsuEmp as UsuEmp');
    $this->db->join('TabUsuario as Usuario', 'Usuario.Id_Usuario = UsuEmp.TabUsuario_Id_Usuario AND Usuario.Tp_Ativo = \'S\' AND Usuario.Deletado <> \'S\'','left');
    $this->db->join('TbEmpresa as Empresa', 'Empresa.Id_Empresa = UsuEmp.TbEmpresa_Id_Empresa AND Empresa.Tp_Ativo = \'S\' AND Empresa.Deletado <> \'S\'','left');
    $this->db->join('TbPerfil as Perfis', 'Perfis.Id_CdPerfil = UsuEmp.TbPerfil_Id_CdPerfil AND Perfis.Tp_Ativo = \'S\' AND Perfis.Deletado <> \'S\'','left');
    if(!empty($searchText)) {
        $likeCriteria = "(Usuario.Nome_Usuario  LIKE '%".$searchText."%'
                        OR  Empresa.Nome_Empresa  LIKE '%".$searchText."%'
                        OR  Perfis.Ds_Perfil  LIKE '%".$searchText."%')";
        $this->db->where($likeCriteria);
    }
    $this->db->where('UsuEmp.Deletado', 'N');
    $this->db->where('UsuEmp.CriadoPor', $idUser);
    $this->db->where('UsuEmp.TabUsuario_Id_Usuario <>', $idUser);
    $this->db->limit($page, $segment);
    $query = $this->db->get();
    
    $result = $query->result();        
    return $result;
}

function verificaUsuarioEmpresa($Id_Empresa,$Id_Usuario)
    {

        $this->db->select('UsuEmp.Id_UsuEmp, UsuEmp.TbEmpresa_Id_Empresa, UsuEmp.TabUsuario_Id_Usuario, UsuEmp.TbPerfil_Id_CdPerfil');
        $this->db->from('TbUsuEmp as UsuEmp');
        $this->db->where('TbEmpresa_Id_Empresa', $Id_Empresa);
        $this->db->where('TabUsuario_Id_Usuario', $Id_Usuario);
        $this->db->where('UsuEmp.Deletado <>', 'S');
        $query = $this->db->get();
        
        return $query->result();

    }

function adicionaUsuarioEmpresa($infoUsuarioEmpresa)
    {
        $this->db->trans_start();
        $this->db->insert('TbUsuEmp', $infoUsuarioEmpresa);
        
        $insert_id = $this->db->insert_id();
        
        $this->db->trans_complete();
        
        return $insert_id;
    }

function editaUsuarioEmpresa($infoUsuarioEmpresa, $IdUsuEmp)
{
    $this->db->where('Id_UsuEmp', $IdUsuEmp);
    $this->db->update('TbUsuEmp', $infoUsuarioEmpresa);
    
    return TRUE;
}

function apagaUsuarioEmpresa($infoUsuEmp, $IdUsuEmp)
{

        $this->db->where('Id_UsuEmp', $IdUsuEmp);
        $res = $this->db->delete('TbUsuEmp');

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

    // $this->db->where('Id_UsuEmp ', $IdUsuEmp);
    // $this->db->update('TbUsuEmp', $infoUsuEmp);
    
    // return $this->db->affected_rows();
}

function carregaInfoUsuarioEmpresa($IdUsuEmp)
{
    $this->db->select('UsuEmp.Id_UsuEmp, UsuEmp.TbEmpresa_Id_Empresa, UsuEmp.TbPerfil_Id_CdPerfil, Usuario.Nome_Usuario, Empresa.Nome_Empresa');
    $this->db->from('TbUsuEmp as UsuEmp');
    $this->db->join('TabUsuario as Usuario', 'Usuario.Id_Usuario = UsuEmp.TabUsuario_Id_Usuario AND Usuario.Tp_Ativo = \'S\' AND Usuario.Deletado <> \'S\'','left');
    $this->db->join('TbEmpresa as Empresa', 'Empresa.Id_Empresa = UsuEmp.TbEmpresa_Id_Empresa AND Empresa.Tp_Ativo = \'S\' AND Empresa.Deletado <> \'S\'','left');
    $this->db->where('Id_UsuEmp', $IdUsuEmp);
    $this->db->where('UsuEmp.Deletado <>', 'S');
    $query = $this->db->get();
    
    return $query->result();
}

function carregaInfoUsuarioCriados($CriadoPor)
{
        $this->db->select('Id_Usuario, Nome_Usuario, Email, Cpf_Usuario, Tp_Ativo');
        $this->db->from('TabUsuario');
        $this->db->where('CriadoPor', $CriadoPor);
        $this->db->where('Deletado <>', 'S');
        $this->db->where('Tp_Ativo', 'S');
        $this->db->where('Id_Usuario <>', $CriadoPor);
        $query = $this->db->get();
        
        return $query->result();
}

function carregaEmpresasCriadas($CriadoPor)
{
    $this->db->select('Empresas.Id_Empresa, Empresas.Nome_Empresa');
    $this->db->from('TbEmpresa as Empresas');
    $this->db->where('CriadoPor', $CriadoPor);
    $this->db->where('Deletado <>', 'S');
    $this->db->where('Tp_Ativo', 'S');
    $query = $this->db->get();
    
    return $query->result();
}

function carregaEmpresas()
{
    $this->db->select('Empresas.Id_Empresa, Empresas.Nome_Empresa');
    $this->db->from('TbEmpresa as Empresas');
    $this->db->where('Perfis.Deletado <>', 'S');
    $this->db->where('Perfis.Tp_Ativo', 'S');
    $query = $this->db->get();
    
    return $query->result();
}

function carregaPerfisCriados($CriadoPor)
{
    $this->db->select('Perfis.Id_CdPerfil, Perfis.Ds_Perfil');
    $this->db->from('TbPerfil as Perfis');
    $this->db->where('Perfis.Deletado <>', 'S');
    $this->db->where('Perfis.Tp_Ativo', 'S');
    $this->db->where('Perfis.CriadoPor', $CriadoPor);
    $query = $this->db->get();
    
    return $query->result();
}

// FIM DAS CONSULTAS NA TELA DE USUÁRIO/EMPRESA

    /**
     * This function is used to get the user roles information
     * @return array $result : This is result of the query
     */
    function carregaPerfisUsuarios()
    {
        $this->db->select('Id_CdPerfil, Ds_Perfil');
        $this->db->from('TbPerfil');
        $query = $this->db->get();
        
        return $query->result();
    }


    /**
     * This function is used to check whether email id is already exist or not
     * @param {string} $email : This is email id
     * @param {number} $userId : This is user id
     * @return {mixed} $result : This is searched result
     */
    function checkEmailExists($email, $userId = 0)
    {
        $this->db->select("email");
        $this->db->from("tbl_users");
        $this->db->where("email", $email);   
        $this->db->where("isDeleted", 0);
        if($userId <> 0){
            $this->db->where("userId <>", $userId);
        }
        $query = $this->db->get();

        return $query->result();
    }
    
    
    /**
     * This function is used to add new user to system
     * @return number $insert_id : This is last inserted id
     */
    function addNewUser($userInfo)
    {
        $this->db->trans_start();
        $this->db->insert('tbl_users', $userInfo);
        
        $insert_id = $this->db->insert_id();
        
        $this->db->trans_complete();
        
        return $insert_id;
    }
    
    /**
     * This function used to get user information by id
     * @param number $userId : This is user id
     * @return array $result : This is user information
     */
    function getUserInfo($userId)
    {
        $this->db->select('userId, name, email, mobile, roleId');
        $this->db->from('tbl_users');
        $this->db->where('isDeleted', 0);
        $this->db->where('userId', $userId);
        $query = $this->db->get();
        
        return $query->result();
    }
    
    
    /**
     * This function is used to update the user information
     * @param array $userInfo : This is users updated information
     * @param number $userId : This is user id
     */
    function editUser($userInfo, $userId)
    {
        $this->db->where('userId', $userId);
        $this->db->update('tbl_users', $userInfo);
        
        return TRUE;
    }
    
    
    
    /**
     * This function is used to delete the user information
     * @param number $userId : This is user id
     * @return boolean $result : TRUE / FALSE
     */
    function deleteUser($userId, $userInfo)
    {
        $this->db->where('userId', $userId);
        $this->db->update('tbl_users', $userInfo);
        
        return $this->db->affected_rows();
    }


    /**
     * This function is used to match users password for change password
     * @param number $userId : This is user id
     */
    function matchOldPassword($userId, $oldPassword)
    {
        $this->db->select('userId, password');
        $this->db->where('userId', $userId);        
        $this->db->where('isDeleted', 0);
        $query = $this->db->get('tbl_users');
        
        $user = $query->result();

        if(!empty($user)){
            if(verifyHashedPassword($oldPassword, $user[0]->password)){
                return $user;
            } else {
                return array();
            }
        } else {
            return array();
        }
    }
    
    /**
     * This function is used to change users password
     * @param number $userId : This is user id
     * @param array $userInfo : This is user updation info
     */
    function changePassword($userId, $userInfo)
    {
        $this->db->where('userId', $userId);
        $this->db->where('isDeleted', 0);
        $this->db->update('tbl_users', $userInfo);
        
        return $this->db->affected_rows();
    }


    /**
     * This function is used to get user log history count
     * @param number $userId : This is user id
     */
    	
    function logHistoryCount($userId)
    {
        $this->db->select('*');
        $this->db->from('tbl_log as BaseTbl');

        if ($userId == NULL)
        {
            $query = $this->db->get();
            return $query->num_rows();
        }
        else
        {
            $this->db->where('BaseTbl.userId', $userId);
            $query = $this->db->get();
            return $query->num_rows();
        }
    }

    /**
     * This function is used to get user log history
     * @param number $userId : This is user id
     * @return array $result : This is result
     */
    function logHistory($userId)
    {
        $this->db->select('*');        
        $this->db->from('tbl_log as BaseTbl');

        if ($userId == NULL)
        {
            $this->db->order_by('BaseTbl.createdDtm', 'DESC');
            $query = $this->db->get();
            $result = $query->result();        
            return $result;
        }
        else
        {
            $this->db->where('BaseTbl.userId', $userId);
            $this->db->order_by('BaseTbl.createdDtm', 'DESC');
            $query = $this->db->get();
            $result = $query->result();
            return $result;
        }
    }

    /**
     * This function used to get user information by id
     * @param number $userId : This is user id
     * @return array $result : This is user information
     */
    function getUserInfoById($userId)
    {
        $this->db->select('userId, name, email, mobile, roleId');
        $this->db->from('tbl_users');
        $this->db->where('isDeleted', 0);
        $this->db->where('userId', $userId);
        $query = $this->db->get();
        
        return $query->row();
    }

    /**
     * This function is used to get tasks
     */
    function getTasks()
    {
        $this->db->select('*');
        $this->db->from('tbl_task as TaskTbl');
        $this->db->join('tbl_users as Users','Users.userId = TaskTbl.createdBy');
        $this->db->join('tbl_roles as Roles','Roles.roleId = Users.roleId');
        $this->db->join('tbl_tasks_situations as Situations','Situations.statusId = TaskTbl.statusId');
        $this->db->join('tbl_tasks_prioritys as Prioritys','Prioritys.priorityId = TaskTbl.priorityId');
        $this->db->order_by('TaskTbl.statusId ASC, TaskTbl.priorityId');
        $query = $this->db->get();
        $result = $query->result();        
        return $result;
    }

    /**
     * This function is used to get task prioritys
     */
    function getTasksPrioritys()
    {
        $this->db->select('*');
        $this->db->from('tbl_tasks_prioritys');
        $query = $this->db->get();
        
        return $query->result();
    }

    /**
     * This function is used to get task situations
     */
    function getTasksSituations()
    {
        $this->db->select('*');
        $this->db->from('tbl_tasks_situations');
        $query = $this->db->get();
        
        return $query->result();
    }
    
    /**
     * This function is used to add a new task
     */
    function addNewTasks($taskInfo)
    {
        $this->db->trans_start();
        $this->db->insert('tbl_task', $taskInfo);
        
        $insert_id = $this->db->insert_id();
        
        $this->db->trans_complete();
        
        return $insert_id;
    }

    /**
     * This function used to get task information by id
     * @param number $taskId : This is task id
     * @return array $result : This is task information
     */
    function getTaskInfo($taskId)
    {
        $this->db->select('*');
        $this->db->from('tbl_task');
        $this->db->join('tbl_tasks_situations as Situations','Situations.statusId = tbl_task.statusId');
        $this->db->join('tbl_tasks_prioritys as Prioritys','Prioritys.priorityId = tbl_task.priorityId');
        $this->db->where('id', $taskId);
        $query = $this->db->get();
        
        return $query->result();
    }
    
    /**
     * This function is used to edit tasks
     */
    function editTask($taskInfo, $taskId)
    {
        $this->db->where('id', $taskId);
        $this->db->update('tbl_task', $taskInfo);
        
        return $this->db->affected_rows();
    }
    
    /**
     * This function is used to delete tasks
     */
    function deleteTask($taskId)
    {
        $this->db->where('id', $taskId);
        $this->db->delete('tbl_task');
        return TRUE;
    }

    /**
     * This function is used to return the size of the table
     * @param string $tablename : This is table name
     * @param string $dbname : This is database name
     * @return array $return : Table size in mb
     */
    function gettablemb($tablename,$dbname)
    {
        $this->db->select('round(((data_length + index_length)/1024/1024),2) as total_size');
        $this->db->from('information_schema.tables');
        $this->db->where('table_name', $tablename);
        $this->db->where('table_schema', $dbname);
        $query = $this->db->get($tablename);
        
        return $query->row();
    }

    /**
     * This function is used to delete tbl_log table records
     */
    function clearlogtbl()
    {
        $this->db->truncate('tbl_log');
        return TRUE;
    }

    /**
     * This function is used to delete tbl_log_backup table records
     */
    function clearlogBackuptbl()
    {
        $this->db->truncate('tbl_log_backup');
        return TRUE;
    }

    /**
     * This function is used to get user log history
     * @return array $result : This is result
     */
    function logHistoryBackup()
    {
        $this->db->select('*');        
        $this->db->from('tbl_log_backup as BaseTbl');
        $this->db->order_by('BaseTbl.createdDtm', 'DESC');
        $query = $this->db->get();
        $result = $query->result();        
        return $result;
    }

    /**
     * This function is used to complete tasks
     */
    function endTask($taskId, $taskInfo)
    {
        $this->db->where('id', $taskId);
        $this->db->update('tbl_task', $taskInfo);
        
        return $this->db->affected_rows();
    }

    /**
     * This function is used to get the tasks count
     * @return array $result : This is result
     */
    function tasksCount()
    {
        $this->db->select('*');
        $this->db->from('tbl_task as BaseTbl');
        $query = $this->db->get();
        return $query->num_rows();
    }

    /**
     * This function is used to get the finished tasks count
     * @return array $result : This is result
     */
    function finishedTasksCount()
    {
        $this->db->select('*');
        $this->db->from('tbl_task as BaseTbl');
        $this->db->where('BaseTbl.statusId', 2);
        $query = $this->db->get();
        return $query->num_rows();
    }

    /**
     * This function is used to get the logs count
     * @return array $result : This is result
     */
    function logsCount()
    {
        $this->db->select('*');
        $this->db->from('tbl_log as BaseTbl');
        $query = $this->db->get();
        return $query->num_rows();
    }

    /**
     * This function is used to get the users count
     * @return array $result : This is result
     */
    function usersCount()
    {
        $this->db->select('*');
        $this->db->from('tbl_users as BaseTbl');
        $this->db->where('isDeleted', 0);
        $query = $this->db->get();
        return $query->num_rows();
    }

    function getUserStatus($userId)
    {
        $this->db->select('BaseTbl.status');
        $this->db->where('BaseTbl.userId', $userId);
        $this->db->limit(1);
        $query = $this->db->get('tbl_users as BaseTbl');

        return $query->row();
    }
}

  