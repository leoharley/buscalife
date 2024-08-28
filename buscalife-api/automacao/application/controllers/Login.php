<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';
/**
 * Class : Login (LoginController)
 * Admin class to control to authenticate admin credentials and include admin functions.
 * @author : Samet Aydın / sametay153@gmail.com
 * @version : 1.0
 * @since : 27.02.2018
 */
class Login extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('login_model');
        $this->load->model('CadastroModel');
    }

    /**
     * Index Page for this controller.
     */
    public function index()
    {
        $this->isLoggedIn();
    }

    /**
     * This function is used to open error /404 not found page
     */
    public function error()
    {
        $isLoggedIn = $this->session->userdata('isLoggedIn');
        
        if(!isset($isLoggedIn) || $isLoggedIn != TRUE)
        {
            $this->load->view('login');
        }
        else
        {
            $process = 'Hata';
            $processFunction = 'Login/error';
            $this->logrecord($process,$processFunction);
            redirect('pageNotFound');
        }
    }

    /**
     * This function is used to access denied page
     */
    public function noaccess() {
        
        $this->global['pageTitle'] = 'QUALICAD : Acesso negado';
        $this->datas();

        $this->load->view ( 'includes/header', $this->global );
		$this->load->view ( 'access' );
		$this->load->view ( 'includes/footer' );
    }

    public function telaNaoAutorizada() {
        
        $this->global['pageTitle'] = 'QUALICAD : Acesso negado';
        $this->datas();

        $this->load->view ( 'includes/header', $this->global );
		$this->load->view ( 'telaNaoAutorizada' );
		$this->load->view ( 'includes/footer' );
    }

    public function acaoNaoAutorizada() {
        
        $this->global['pageTitle'] = 'QUALICAD : Acesso negado';
        $this->datas();

        $this->load->view ( 'includes/header', $this->global );
		$this->load->view ( 'acaoNaoAutorizada' );
		$this->load->view ( 'includes/footer' );
    }

    /**
     * This function used to check the user is logged in or not
     */
    function isLoggedIn()
    {
        $isLoggedIn = $this->session->userdata('isLoggedIn');
        
        if(!isset($isLoggedIn) || $isLoggedIn != TRUE)
        {
            $this->load->view('login');
        }
        else
        {
            if (null !== $this->session->userdata('idEmpresa') || $this->session->userdata('isAdmin') == 'S') {
                redirect('/dashboard');
            } 
            else
            {
                $this->load->view('login');
            }
        }
    }
    
    
    /**
     * This function used to logged in user
     */
    public function loginMe()
    {
        $this->load->library('form_validation');
        
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|max_length[128]|trim');
        $this->form_validation->set_rules('password', 'Password', 'required|max_length[32]');
        
        if($this->form_validation->run() == FALSE)
        {
            $this->index();
        }
        else
        {
            $email = $this->security->xss_clean($this->input->post('email'));
            $password = $this->input->post('password');
            
            $result = $this->login_model->loginMe($email, $password);

            if(count($result) > 0)
            {
                foreach ($result as $res)
                {
                //    $lastLogin = $this->login_model->lastLoginInfo($res->userId);
                    
                    $process = 'Autenticação';
                    $processFunction = 'Login/loginMe';

                    $empresasPerfilUsuario = $this->CadastroModel->carregaEmpresasPerfilUsuario($res->Id_Usuario);

                    $associadoEmpresaPerfil = FALSE;

                    foreach ($empresasPerfilUsuario as $data){
                        if ($data->TbPerfil_Id_CdPerfil != NULL && $data->TbEmpresa_Id_Empresa != NULL) 
                        {
                            $associadoEmpresaPerfil = TRUE;
                        }
                    }

                    
                    $role = 0; 
                    $roleText = 'Admin';

                  /*  else 
                    { 
                        $role = $empresasPerfilUsuario['Id_CdPerfil']; 
                        $roleText = $empresasPerfilUsuario['Ds_Perfil'];
                        $idempresa = $empresasPerfilUsuario['TbEmpresa_Id_Empresa'];
                     } */

                    if ($associadoEmpresaPerfil || $res->Admin == 'S') {
                   
                    $sessionArray = array('userId'=>$res->Id_Usuario,
                                            'email'=>$res->Email,               
                                            'role'=>$role,
                                            'roleText'=>$roleText,
                                            'name'=>$res->Nome_Usuario,
                                        //    'lastLogin'=> $lastLogin->createdDtm,
                                            'isAdmin'=>$res->Admin,
                                            'status'=> $res->Tp_Ativo,
                                            'isLoggedIn' => TRUE
                                    );

                    $this->session->set_userdata($sessionArray);

                //    unset($sessionArray['userId'], $sessionArray['isLoggedIn'], $sessionArray['lastLogin']);
                    
                    $this->logrecord($process,$processFunction);

                //    if ($res->Admin == 'S') { redirect('/dashboard'); } else { redirect('/welcome'); }

                //EXCEÇÃO DE NÃO PRECISAR ESTAR ASSOCIADO A UMA EMPRESA SE FOR O SUPERADMIN  
                if ($this->session->userdata('email') == 'admin@admin.com')
                {
                    $sessionArray = array('isAdmin'=>'S');
                    $this->session->set_userdata($sessionArray);
                    redirect('/dashboard');
                } else {
                    redirect('/acesso');
                }
                
                    //    redirect('/dashboard');
                
                    redirect('/acesso');
//                    $this->load->view('welcome');

                                } else {
                                    $this->session->set_flashdata('error', 'Usuário não associado a perfil/empresa');
                                    redirect('/login');
                                }


                }
            }
            else
            {
                $this->session->set_flashdata('error', 'O endereço de e-mail ou a senha estão incorretos');
                
                redirect('/login');
            }
        }
    }

    public function welcome()
    {
        $isLoggedIn = $this->session->userdata('isLoggedIn');
        
        if(!isset($isLoggedIn) || $isLoggedIn != TRUE)
        {
            redirect('/login');
        }
        else
        {
            if (empty($this->CadastroModel->carregaEmpresasPerfilUsuario($this->session->userdata('userId')))) 
                {
                    redirect('/dashboard');
                }
            $data['empresasPerfilUsuario'] = $this->CadastroModel->carregaEmpresasPerfilUsuario($this->session->userdata('userId'));
            $this->load->view('welcome',$data);
        }
    }

    public function escolheEmpresa()
    {
        $IdEmpresa = $this->input->post('Id_Empresa');
        foreach ($this->CadastroModel->carregaInfoEmpresa($IdEmpresa) as $data){
            $NomeEmpresa = ($data->Nome_Empresa);
            $Cd_EmpresaERP = ($data->Cd_EmpresaERP);
        }

        $sessionArray = array('idEmpresa'=>$IdEmpresa,'nomeEmpresa'=>$NomeEmpresa, 'Cd_EmpresaERP'=>$Cd_EmpresaERP);

        $this->session->set_userdata($sessionArray);

      //  if ($this->session->userdata ('isAdmin') != 'S') {
        foreach ($this->CadastroModel->carregaPerfilUsuario($IdEmpresa, $this->session->userdata('userId')) as $data){
            $role = ($data->TbPerfil_Id_CdPerfil);
            $roleText = ($data->Ds_Perfil);
            $IdUsuEmp = ($data->Id_UsuEmp);
            $isAdmin = ($data->Admin);
        }
        
        $sessionArray = array('role'=>$role,'roleText'=>$roleText,'IdUsuEmp'=>$IdUsuEmp, 'IdEmpresa'=>$IdEmpresa, 'isAdmin'=>$isAdmin);
      //  }

        $this->session->set_userdata($sessionArray);

        redirect('/login');
    }

    /**
     * This function used to load forgot password view
     */
    public function forgotPassword()
    {
        $isLoggedIn = $this->session->userdata('isLoggedIn');
        
        if(!isset($isLoggedIn) || $isLoggedIn != TRUE)
        {
            $this->load->view('forgotPassword');
        }
        else
        {
            redirect('/dashboard');
        }
    }
    
    /**
     * This function used to generate reset password request link
     */
    function resetPasswordUser()
    {
        $status = '';
        
        $this->load->library('form_validation');
        
        $this->form_validation->set_rules('login_email','Email','trim|required|valid_email');
                
        if($this->form_validation->run() == FALSE)
        {
            $this->forgotPassword();
        }
        else 
        {
            $email = $this->security->xss_clean($this->input->post('login_email'));
            
            if($this->login_model->checkEmailExist($email))
            {
                $encoded_email = urlencode($email);
                
                $this->load->helper('string');
                $data['email'] = $email;
                $data['activation_id'] = random_string('alnum',15);
                $data['createdDtm'] = date('Y-m-d H:i:s');
                $data['agent'] = getBrowserAgent();
                $data['client_ip'] = $this->input->ip_address();

                $this->load->library('MY_PHPMailer');

                $save = $this->login_model->resetPasswordUser($data);
                
                if($save)
                {
                    $data1['reset_link'] = base_url() . "resetPasswordConfirmUser/" . $data['activation_id'] . "/" . $encoded_email;
                    $userInfo = $this->CadastroModel->carregaInfoUsuarioPorEmail($email);

                    if(!empty($userInfo)){
                        $data1["name"] = $userInfo[0]->Nome_Usuario;
                        $data1["email"] = $userInfo[0]->Email;
                        $data1["message"] = "Foi solicitado o envio do link abaixo:";
                    }

                    $tmp["data"] = $data1;

                    $mail = new PHPMailer(true);                              // Passing `true` enables exceptions

                    //Server settings
                    $mail->isSMTP();
                    $mail->SMTPDebug = 0;
                    $mail->Host = 'smtp.hostinger.com';
                    $mail->Port = 587;
                    $mail->SMTPAuth = true;
                    $mail->Username = 'contato@hellou.com.br';
                    $mail->Password = '%Qualicad123';
                    $mail->setFrom('contato@hellou.com.br', 'Qualicad (Contato)');
                    $mail->addAddress($data1["email"], $data1["name"]);
                    $mail->Subject = 'Redefinir senha';
                    // $mail->msgHTML(file_get_contents('message.html'), __DIR__);
                    $mail->Body = $this->load->view('email/resetPassword', $tmp, TRUE);
                    $mail->isHTML(true);

                    $sendStatus = $mail->send();

                //    $sendStatus = resetPasswordEmail($data1);
                //    $sendStatus = TRUE;

                    $process = 'Solicitação de redefinição de senha';
                    $processFunction = 'Login/resetPasswordUser';
                    $this->logrecord($process,$processFunction);

                    if($sendStatus){
                        $status = "send";
                        setFlashData($status, "Seu link de redefinição de senha foi enviado com sucesso, verifique seu e-mail.");
                    } else {
                        $status = "notsend";
                        setFlashData($status, "Falha no envio de e-mail, tente novamente.");
                    }
                }
                else
                {
                    $status = 'unable';
                    setFlashData($status, "Ocorreu um erro ao enviar suas informações, tente novamente.");
                }
            }
            else
            {
                $status = 'invalid';
                setFlashData($status, "Seu endereço de e-mail não está registrado no sistema.");
            }
            redirect('/forgotPassword');
        }
    }

    /**
     * This function used to reset the password 
     * @param string $activation_id : This is unique id
     * @param string $email : This is user email
     */
    function resetPasswordConfirmUser($activation_id, $email)
    {
        // Get email and activation code from URL values at index 3-4
        $email = urldecode($email);
        
        // Check activation id in database
        $is_correct = $this->login_model->checkActivationDetails($email, $activation_id);
        
        $data['email'] = $email;
        $data['activation_code'] = $activation_id;
        
        if ($is_correct == 1)
        {
            $this->load->view('newPassword', $data);
        }
        else
        {
            redirect('/login');
        }
    }
    
    /**
     * This function used to create new password for user
     */
    function createPasswordUser()
    {
        $status = '';
        $message = '';
        $email = $this->input->post("email");
        $activation_id = $this->input->post("activation_code");
        
        $this->load->library('form_validation');
        
        $this->form_validation->set_rules('password','Password','required|max_length[20]');
        $this->form_validation->set_rules('cpassword','Confirm Password','trim|required|matches[password]|max_length[20]');
        
        if($this->form_validation->run() == FALSE)
        {
            $this->resetPasswordConfirmUser($activation_id, urlencode($email));
        }
        else
        {
            $password = $this->input->post('password');
            $cpassword = $this->input->post('cpassword');
            
            // Check activation id in database
            $is_correct = $this->login_model->checkActivationDetails($email, $activation_id);
            
            if($is_correct == 1)
            {               
                $this->login_model->createPasswordUser($email, $password);
                
                $process = 'Redefinição de senha';
                $processFunction = 'Login/createPasswordUser';
                $this->logrecord($process,$processFunction);

                $status = 'success';
                $message = 'Senha alterada com sucesso';
            }
            else
            {
                $status = 'error';
                $message = 'Não foi possível alterar a senha';
            }
            
            setFlashData($status, $message);

            redirect("/login");
        }
    }
}

?>