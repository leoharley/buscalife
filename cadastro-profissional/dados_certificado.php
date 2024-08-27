<?php
include('inc/header.php');
//include('inc/nav.php');
//login_check_pages();
?>

    <div class="row">
        <div class="col-lg-6 col-lg-offset-3">
            <?php display_message(); ?>
            <?php dados_certificado(); ?>
        </div>
    </div>

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
                                    <img src="img/logo.png" style="margin-top:20px;width:10%;height: auto;">
                                    <h5><strong>BuscaQuemFaz.com.br</strong></h5>
                                </div>
                                <div class="panel-heading" style="margin-top:-10px;margin-bottom:-10px">
                                    <h3 class="pt-4 font-weight-bold">Dados para o seu Certificado de Profissional Verificado</h3>
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
                                        <label for="cpf">CPF:</label>
                                        <input type="text" name="cpf" id="cpf" tabindex="1" class="form-control"
                                            placeholder="" value="" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="dt_nascimento">Data de nascimento:</label>
                                        <input type="date" name="dt_nascimento" id="dt_nascimento" tabindex="2" class="form-control"
                                            placeholder="Data de nascimento" value="" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="nome_mae">Nome da mãe:</label>
                                        <input type="text" name="nome_mae" id="nome_mae" tabindex="3" class="form-control"
                                            placeholder="Nome da mãe" value="" required>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-sm-6 col-sm-offset-3">
                                                <input type="submit" name="register-submit" id="register-submit"
                                                    tabindex="4" class="form-control btn btn-register"
                                                    value="FINALIZAR">
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
<script>
    $(document).ready(function(){
    $('#whatsapp').mask('(00) 00000-0000');
});
</script>