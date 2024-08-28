<?php
include('inc/header.php');
//include('inc/nav.php');
login_check_pages();
?>


    <div class="row">
        <div class="col-lg-6 col-lg-offset-3">

            <?php display_message(); ?>                               
            <?php validate_user_login(); ?>
        </div>
    </div>
    
    <div class="container">  
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="panel panel-login">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-12">
                                <div style="text-align:center">
                                    <img src="img/logo.png?ver=1.2" class="logo">
                                </div>
                                <div class="panel-heading">
                                    <h3 class="pt-4 font-weight-bold">Seja Bem-Vindo(a)</h3>
                                </div>
                            </div>
                        <!--  <div class="col-xs-6">
                                <a href="register.php" id="">Register</a>
                            </div> -->
                        </div>
                        <hr>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <form id="login-form" method="post" role="form" style="display: block;">
                                    <div class="form-group">
                                        <input type="email" name="email" id="email" tabindex="1" class="form-control"
                                            placeholder="E-mail" required>
                                    </div>
                                    <div class="form-group">
                                        <input type="password" name="password" id="login-
                                            password" tabindex="2" class="form-control" placeholder="Senha" required>
                                    </div>
                                    <div class="form-group text-center">
                                        <input type="checkbox" tabindex="3" class="" name="remember" id="remember">
                                        <label for="remember">Lembrar</label>
                                    </div>

                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="text-center">
                                                    <a href="recuperar_senha.php" tabindex="5">Esqueceu a senha?</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group text-center">                                        
                                        Não tem conta? <a href="cadastro.php">Cadastre-se agora</a>
                                    </div>

                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-sm-6 col-sm-offset-3">
                                                <input type="submit" name="login-submit" id="login-submit" tabindex="4"
                                                    class="form-control btn btn-primary" value="Entrar">
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
<?php
include('inc/footer.php');
?>