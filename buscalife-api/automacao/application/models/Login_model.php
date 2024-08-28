<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Login_model extends CI_Model
{
    
    /**
     * This function used to check the login credentials of the user
     * @param string $email : This is email of the user
     * @param string $password : This is encrypted password of the user
     */
    function loginMe($email, $password)
    {
        $this->db->select('Usuario.Id_Usuario, Usuario.Nome_Usuario, Usuario.Cpf_Usuario, Usuario.Email,
        Usuario.Senha, Usuario.Admin, Perfil.Id_CdPerfil, Perfil.Ds_Perfil, UsuEmp.TbEmpresa_Id_Empresa, Usuario.Tp_Ativo');
        $this->db->from('TabUsuario as Usuario');
        $this->db->join('TbUsuEmp as UsuEmp','UsuEmp.TabUsuario_Id_Usuario = Usuario.Id_Usuario','left');
        $this->db->join('TbPerfil as Perfil','Perfil.Id_CdPerfil = UsuEmp.TbPerfil_Id_CdPerfil','left');
        $this->db->where('Usuario.Email', $email);
        $this->db->where('Usuario.Tp_Ativo','S');
        $this->db->where('Usuario.Deletado','N');
        $query = $this->db->get();
        
        $user = $query->result();
        
        if(!empty($user)){
        //    if(verifyHashedPassword($password, $user[0]->Senha)){
            if($password == $user[0]->Senha){
                return $user;
            } else {
                return array();
            }
        } else {
            return array();
        }
    }

    /**
     * This function used to check email exists or not
     * @param {string} $email : This is users email id
     * @return {boolean} $result : TRUE/FALSE
     */
    function checkEmailExist($email)
    {
        $this->db->select('Id_Usuario');
        $this->db->where('Email', $email);
        $this->db->where('Tp_Ativo','S');
        $this->db->where('Deletado','N');
        $query = $this->db->get('TabUsuario');

        if ($query->num_rows() > 0){
            return true;
        } else {
            return false;
        }
    }


    /**
     * This function used to insert reset password data
     * @param {array} $data : This is reset password data
     * @return {boolean} $result : TRUE/FALSE
     */
    function resetPasswordUser($data)
    {
        $result = $this->db->insert('tbl_reset_password', $data);

        if($result) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * This function is used to get customer information by email-id for forget password email
     * @param string $email : Email id of customer
     * @return object $result : Information of customer
     */
    function getCustomerInfoByEmail($email)
    {
        $this->db->select('userId, email, name');
        $this->db->from('tbl_users');
        $this->db->where('isDeleted', 0);
        $this->db->where('email', $email);
        $query = $this->db->get();

        return $query->result();
    }

    /**
     * This function used to check correct activation deatails for forget password.
     * @param string $email : Email id of user
     * @param string $activation_id : This is activation string
     */
    function checkActivationDetails($email, $activation_id)
    {
        $this->db->select('id');
        $this->db->from('tbl_reset_password');
        $this->db->where('email', $email);
        $this->db->where('activation_id', $activation_id);
        $query = $this->db->get();

        return $query->num_rows();
    }

    // This function used to create new password by reset link
    function createPasswordUser($email, $password)
    {
        $this->db->where('Email', $email);
        $this->db->where('Tp_Ativo','S');
        $this->db->where('Deletado','N');
        $this->db->update('TabUsuario', array('Senha'=>$password));
    //    $this->db->update('TabUsuario', array('Senha'=>getHashedPassword($password)));
        $this->db->delete('tbl_reset_password', array('email'=>$email));
    }

    /**
     * This function used to save login information of user
     * @param array $loginInfo : This is users login information
     */
    function loginsert($logInfo)
    {
        $this->db->trans_start();
        $this->db->insert('tbl_log', $logInfo);
        $this->db->trans_complete();
    }

    /**
     * This function is used to get last login info by user id
     * @param number $userId : This is user id
     * @return number $result : This is query result
     */
    function lastLoginInfo($userId)
    {
        $this->db->select('BaseTbl.createdDtm');
        $this->db->where('BaseTbl.userId', $userId);
        $this->db->order_by('BaseTbl.id', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get('tbl_log as BaseTbl');

        return $query->row();
    }
}

?>