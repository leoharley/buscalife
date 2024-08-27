<?php

function clean($str)
{
    return htmlentities($str);
}

function redirect($location)
{
    header("location: {$location}");
    exit();
}

function set_message($message)
{
    if (!empty($message)) {
        $_SESSION['message'] = $message;
    } else {
        $message = "";
    }
}

function display_message()
{
    if (isset($_SESSION['message'])) {
        echo $_SESSION['message'];
        unset($_SESSION['message']);
    }
}

function set_whatsapp_profissional($whatsapp)
{
    if (!empty($whatsapp)) {
        $_SESSION['whatsapp'] = $whatsapp;
    } else {
        $whatsapp = "";
    }
}

function display_whatsapp_profissional()
{
    if (isset($_SESSION['whatsapp'])) {
        echo $_SESSION['whatsapp'];
       // unset($_SESSION['idprofissional']);
    }
}

function set_atividade_profissional($atividade)
{
    if (!empty($atividade)) {
        $_SESSION['atividade'] = $atividade;
    } else {
        $atividade = "";
    }
}

function display_atividade_profissional()
{
    if (isset($_SESSION['atividade'])) {
        echo $_SESSION['atividade'];
       // unset($_SESSION['idprofissional']);
    }
}

function token_generator()
{
    $token = $_SESSION['token'] = md5(uniqid(mt_rand(), true));
    return $token;
}


function email_exists($email)
{
    $email = filter_var($email,FILTER_SANITIZE_EMAIL);
    $query = "SELECT id FROM tb_usuario WHERE email = '$email'";
    if (row_count(query($query))) {
        return true;
    } else {
        return false;
    }
}

function whatsapp_exists($whatsapp)
{
    $whatsapp = filter_var($whatsapp,   FILTER_SANITIZE_STRING);
    $query = "SELECT id FROM tb_usuario WHERE whatsapp = '$whatsapp'";
    if (row_count(query($query))) {
        return true;
    } else {
        return false;
    }
}

function validate_user_registration()
{
    $errors = [];
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $first_name = clean($_POST['first_name']);
        $last_name = clean($_POST['last_name']);
        $whatsapp = clean($_POST['whatsapp']);
        $email = clean($_POST['email']);
        $password = clean($_POST['password']);
        $confirm_password = clean($_POST['confirm_password']);
        if (strlen($first_name) < 3) {
            $errors[] = "Seu primeiro nome não pode ser menos que 3 caracteres.";
        }
        if (strlen($last_name) < 3) {
            $errors[] = "Seu último nome não pode ser menos que 3 caracteres.";
        }
        if (strlen($whatsapp) < 15) {
            $errors[] = "Seu número de whatsapp não pode ser menor que 11 dígitos.";
        }        
        if (email_exists($email)) {
            $errors[] = "Desculpe, mas este e-mail já existe.";
        }
        if (whatsapp_exists($whatsapp)) {
            $errors[] = "Desculpe, mas este número de whatsapp já existe.";
        }
        if (strlen($password) < 8) {
            $errors[] = "Sua senha não pode ser menor que 8 caracteres.";
        }
        if ($password != $confirm_password) {
            $errors[] = "As senhas não são iguais.";
        }
        if (!empty($errors)) {
            foreach ($errors as $error) {
                echo '<div class="alert alert alert-danger">' . $error . '
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span></button></div>';
            }
        } else {
            $first_name = filter_var($first_name,   FILTER_SANITIZE_STRING);
            $last_name  = filter_var($last_name,    FILTER_SANITIZE_STRING);
            $whatsapp   = filter_var($whatsapp,     FILTER_SANITIZE_STRING);
            $email      = filter_var($email,        FILTER_SANITIZE_EMAIL);
            $password   = filter_var($password,     FILTER_SANITIZE_STRING);
            //$password   = password_hash($password,PASSWORD_DEFAULT );
            createuser($first_name, $last_name, $whatsapp, $email, $password);
        }
    }
}

function createuser($first_name, $last_name, $whatsapp, $email, $password)
{
    global $url;
    $first_name = escape($first_name);
    $last_name = escape($last_name);
    $whatsapp = escape($whatsapp);
    $email = escape($email);
    $password = escape($password);
    //$password   = password_hash($password,PASSWORD_DEFAULT );
    $token = md5($email . microtime());
    $sql = "INSERT INTO tb_usuario(first_name,last_name,whatsapp,email,password,token,activition) ";
    $sql .= "VALUES('$first_name','$last_name','$whatsapp','$email','$password','$token',0)";
    confirm(query($sql));
    set_message('<div class="alert alert alert-success">Favor, verifique sua caixa de entrada ou pasta de Spam para visualizar o link de ativação.</div>');                
    $subject = "\u0041\u0074\u0069\u0076\u0061\u00e7\u00e3\u006f\u0020\u0064\u0065\u0020\u0063\u006f\u006e\u0074\u0061";
    $msg = "Clique no link abaixo para ativar sua conta
            $url/ativar.php?email=$email&code=$token";
    $headers = "From: contato@buscaquemfaz.com.br";
    send_email($email, $subject, $msg, $headers);
    redirect('login.php');
}

function send_email($email, $subject, $msg, $headers)
{
    return mail($email, $subject, $msg, $headers);
}

function activate_user()
{
    if ($_SERVER['REQUEST_METHOD'] == "GET") {
        $email = clean($_GET['email']);
        $code = clean($_GET['code']);
        $email      = filter_var($email, FILTER_SANITIZE_EMAIL);
        $code   = filter_var($code, FILTER_SANITIZE_STRING);
        $query = "SELECT id FROM tb_usuario WHERE email='$email' AND token='$code'";
        $queryEmail = "SELECT id FROM tb_usuario WHERE email='$email'";
        $result = query($query);
        $resultEmail = query($queryEmail);
        confirm($result);
        confirm($resultEmail);

        if (row_count($result) == 1) {
            $query = "UPDATE tb_usuario SET activition = 1, token = 0 Where email='$email' and token='$code'";
            confirm(query($query));
            set_message("<div class='alert alert-success'>Sua conta foi ativada com sucesso. Faça o login.</div>");
            redirect('login.php');
        } else {
            if (row_count($resultEmail) == 1) {
                set_message("<div class='alert alert-success'>Sua conta já foi ativada.</div>");
                redirect('login.php');
            } else {
                set_message("<div class='alert alert-danger'>O link de ativação está incorreto. Favor faça o cadastro novamente.</div>");
                redirect('cadastro.php');
            }
        }
    }
}

function validate_user_login()
{
    $errors = [];
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $email = clean($_POST['email']);
        $password = clean($_POST['password']);
        $remember = clean(isset($_POST['remember']));
        //$password   = password_hash($password,PASSWORD_DEFAULT );
        if (empty($email)) {
            $errors[] = "Campo de e-mail não pode ser vazio";
        }
        if (empty($password)) {
            $errors[] = "Campo de senha não pode ser vazio";
        }
        if (empty($errors)) {
            if (user_login($email, $password, $remember)) {
                redirect('../teste.php');
            } else {
                $errors[] = "E-mail ou senha incorreto. Favor tentar novamente.";
            }
        }
        if (!empty($errors)) {
            foreach ($errors as $error) {
                echo '<div class="alert alert alert-danger">' . $error . '
                          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <span aria-hidden="true">&times;</span></button></div>';
            }
        }
    }

}

function user_login($email, $password, $remember)
{
    $password   = filter_var($password, FILTER_SANITIZE_STRING);
    //$password   = password_hash($password,PASSWORD_DEFAULT );
    $email      = filter_var($email,    FILTER_SANITIZE_EMAIL);
    $remember   = filter_var($remember, FILTER_SANITIZE_STRING);

    $query = "SELECT id FROM tb_usuario WHERE email='$email' AND password='$password'";
    $result = query($query);
    if (row_count($result) == 1) {
        if ($remember == "1") {
            setcookie('email', $email, time() + (86400 * 30));
        }
        $_SESSION['email'] = $email;
        return true;
    } else {
        return false;
    }
}

function login_check_admin()
{
    if (isset($_SESSION['email']) || isset($_COOKIE['email'])) {
        return true;
    } else {
        redirect('login.php');
    }
}

function login_check_pages()
{
    if (isset($_SESSION['email']) || isset($_COOKIE['email'])) {
        redirect('../teste.php');
    }
}

function recover()
{
    global $url;
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        if (isset($_POST['cancel-submit'])) {
            redirect('login.php');
        }
        if (isset($_POST['recover-submit'])) {
            $email = $_POST['email'];
            $email = filter_var($email, FILTER_SANITIZE_EMAIL);
            $query = "SELECT id FROM tb_usuario WHERE email='$email'";
            $result = query($query);
            if (row_count($result) == 1) {
                $token = token_generator();
                $query = "UPDATE tb_usuario set token='$token' WHERE email='$email'";
                query($query);
                set_message('<div class="alert alert alert-success">Favor, verifique sua caixa de entrada ou pasta de Spam para visualizar o link.</div>');
                $subject = "\u0041\u0074\u0069\u0076\u0061\u00e7\u00e3\u006f\u0020\u0064\u0065\u0020\u0063\u006f\u006e\u0074\u0061";
                $msg = "Please Click the link below to Activate Your Account
                $url/restaurar.php?email=$email&token=$token";
                $headers = "From: contato@buscaquemfaz.com.br";
                send_email($email, $subject, $msg, $headers);
                redirect('login.php');
            } else {
                set_message("Este e-mail não existe");
                redirect('recuperar_senha.php');
            }
        }
        echo "<p class='alert alert-danger text-center'>";
        display_message();
        echo "</p>";
    }
}


function cadastrar_profissional()
{
    if ($_SERVER['REQUEST_METHOD'] == "GET") {        
        $whatsapp = preg_replace("/[^0-9]/", "",$_GET['whatsapp']);
        set_whatsapp_profissional($whatsapp);
        $queryAtividade = "SELECT atividade FROM tb_profissional WHERE whatsapp='$whatsapp'";
        $resultAtividade = query($queryAtividade);

        while( $row = $resultAtividade->fetch_array() )
            {
                set_atividade_profissional($row['atividade']);
            }
    }

    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $como_deseja_ser_contratado = clean($_POST['como_deseja_ser_contratado']);
        if ($como_deseja_ser_contratado == '2') {
            redirect('cadastro_concluido.php');
        }
        $nome_completo = clean($_POST['nome_completo']);
        $whatsapp = preg_replace("/[^0-9]/", "",$_POST['whatsapp']);        
        
        $query = "UPDATE tb_profissional SET nome_completo = '$nome_completo' where whatsapp='$whatsapp'";
        confirm(query($query));    
        redirect('dados_certificado.php');        
    }
}

function dados_certificado()
{
    date_default_timezone_get();
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $whatsapp = $_SESSION['whatsapp'];
        $cpf = clean($_POST['cpf']);
        $dt_nascimento = clean($_POST['dt_nascimento']);
        $nome_mae = clean($_POST['nome_mae']);
        $dt_cadastro = date('m/d/Y', time());      
        
        $query = "UPDATE tb_profissional SET cpf = '$cpf', dt_nascimento = '$dt_nascimento', nome_mae = '$nome_mae', dt_cadastro = '$dt_cadastro' where whatsapp='$whatsapp'";
        confirm(query($query));    
        redirect('redirecionamento.php');        
    }
}

function check_code()
{
    if ($_SERVER['REQUEST_METHOD'] == "GET")
    {
        $email = $_GET['email'];
        $token = $_GET['token'];
        $email  = filter_var($email,   FILTER_SANITIZE_EMAIL);
        $token  = filter_var($token,    FILTER_SANITIZE_STRING);
        $query = "SELECT id FROM tb_usuario WHERE email='$email' AND token='$token'";
        $result = query($query);
        if (row_count($result) == 1) {
            return true;
        }
    }
    if ($_SERVER['REQUEST_METHOD'] == "POST"){
        if(isset($_POST['reset-password-submit'])){
            $email = $_GET['email'];
            $password = $_POST['password'];
            $confirm_password = $_POST['confirm_password'];

            $email              = filter_var($email,               FILTER_SANITIZE_EMAIL);
            $password           = filter_var($password,            FILTER_SANITIZE_STRING);
            $confirm_password   = filter_var($confirm_password,    FILTER_SANITIZE_STRING);

            if($password == $confirm_password){
               // $password   = password_hash($password,PASSWORD_DEFAULT );
                $query = "UPDATE tb_usuario set password='$password', token='0' WHERE email='$email'";
                query($query);
                set_message('<p class="alert alert-success">Sua senha foi atualizada. Faça o login agora.</p>');
                redirect('login.php');
            }
        }
    }
}