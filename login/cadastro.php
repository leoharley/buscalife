<?php
include('inc/header.php');
//include('inc/nav.php');
login_check_pages();
?>

    <div class="row">
        <div class="col-lg-6 col-lg-offset-3">
            <?php display_message(); ?>
            <?php validate_user_registration(); ?>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="panel panel-login">
                    <div class="panel-heading">
                        <div class="row">
                            <!--<div class="col-xs-6">
                                <a href="login.php">Login</a>
                            </div>-->
                            <div class="col-xs-12">
                                <div style="text-align:center">
                                    <img src="img/logo.png?ver=1.1" style="margin-top:20px;width:40vw;height: auto;">
                                </div>
                                <div class="panel-heading">
                                    <h3 class="pt-4 font-weight-bold">Fazer o cadastro</h3>
                                </div>
                            </div>
                        </div>
                        <hr>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <form id="register-form" method="post" role="form">
                                    <div class="form-group">
                                        <input type="text" name="first_name" id="fname" tabindex="1" class="form-control"
                                            placeholder="Primeiro nome" value="" required>
                                    </div>
                                    <div class="form-group">
                                        <input type="text" name="last_name" id="lname" tabindex="1" class="form-control"
                                            placeholder="Último nome" value="" required>
                                    </div>
                                    <div class="form-group">
                                        <input type="text" name="whatsapp" id="whatsapp" tabindex="1" class="form-control"
                                            placeholder="Whatsapp" value="" required>
                                    </div>
                                    <div class="form-group">
                                        <input type="email" name="email" id="register_email" tabindex="1"
                                            class="form-control" placeholder="Endereço de e-mail" value="" required>
                                    </div>
                                    <div class="form-group">
                                        <input type="password" name="password" id="password" tabindex="2"
                                            class="form-control" placeholder="Senha" required>
                                    </div>
                                    <div class="form-group">
                                        <input type="password" name="confirm_password" id="confirm-password" tabindex="2"
                                            class="form-control" placeholder="Redigite a senha" required>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-sm-6 col-sm-offset-3">
                                                <input type="submit" name="register-submit" id="register-submit"
                                                    tabindex="4" class="form-control btn btn-register"
                                                    value="Cadastrar">
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </div>

<?php
include('inc/footer.php');
?>
<script>
    $(document).ready(function(){
    $('#whatsapp').mask('(00) 00000-0000');
});
</script>