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

function carregar_status_mensagem_1()
{
    $whatsapp = $_SESSION['whatsapp'];
    $query = "SELECT st_msg_1 FROM tb_controle_mensagens WHERE whatsapp='$whatsapp'";
    $result = query($query);
    while( $row = $result->fetch_array() )
        {
            if ($row['st_msg_1'] == 1) return 'ENVIADA';            
        }    
}

function display_primeira_mensagem()
{
    $time = date("H");
    /* Set the $timezone variable to become the current timezone */
    $timezone = date("e");
    /* If the time is less than 1200 hours, show good morning */
    if ($time < "12") {
        return "Bom dia!";
    } else
    /* If the time is grater than or equal to 1200 hours, but less than 1700 hours, so good afternoon */
    if ($time >= "12" && $time < "17") {
        return "Boa tarde!";
    } else
    /* Should the time be between or equal to 1700 and 1900 hours, show good evening */
    if ($time >= "17" && $time < "19") {
        return "Boa noite!";
    } else
    /* Finally, show good night if the time is greater than or equal to 1900 hours */
    if ($time >= "19") {
        return "Boa noite!";
    }
}

function display_segunda_mensagem()
{
    return 'Você trabalha com '.$_SESSION['atividade'].'?';
}

function display_terceira_mensagem()
{
    return 'Meu nome é Thuany, trabalho em uma plataforma de busca de profissionais chamada BuscaQuemFaz (buscaquemfaz.com.br), a primeira no Brasil com Inteligência Artificial';
}

function display_quarta_mensagem()
{
    return 'Tenho clientes na sua região buscando pelos seus serviços';
}

function display_quinta_mensagem()
{
    return 'Se tiver interesse, é só fazer seu cadastro verificado que recomendamos você, segue o link:';
}

function display_sexta_mensagem()
{
    return 'https://buscaquemfaz.com.br/cadastro-profissional/q.php?whatsapp="'.$_SESSION['whatsapp'].'"';
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

function capturar_profissional()
{
    unset($_SESSION['whatsapp']);
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $atividade = clean($_POST['atividade']);
        $whatsapp = preg_replace("/[^0-9]/", "",$_POST['whatsapp']);
        $cep = clean($_POST['cep']);        
        $queryWhatsapp = "SELECT whatsapp FROM tb_profissional WHERE whatsapp='$whatsapp'";
        $resultWhatsapp = query($queryWhatsapp);
        confirm($resultWhatsapp);

        if (row_count($resultWhatsapp) == 0) {
            $query = "INSERT into tb_profissional (atividade,whatsapp,cep) values ('$atividade','$whatsapp','$cep')";
            $queryControleMensagens = "INSERT into tb_controle_mensagens (whatsapp) values ('$whatsapp')";
            confirm(query($query)); 
            confirm(query($queryControleMensagens));        
            set_whatsapp_profissional($whatsapp);
            set_atividade_profissional($atividade);
            set_message("<div class='alert alert-success'>O profissional foi cadastrado com sucesso.</div>");            
            redirect('roteiro.php');
        } else {
            set_message("<div class='alert alert-success'>Este número de whatsapp já foi cadastrado.</div>");
            redirect('captura.php');
        }
    }
}

function primeira_mensagem()
{
    return 'Boa noite';
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

function teste()
{
    return 'Leo';
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