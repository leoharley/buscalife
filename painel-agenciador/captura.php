<?php
include('inc/header.php');
//include('inc/nav.php');
//login_check_pages();
?>

    <div class="row">
        <div class="col-lg-6 col-lg-offset-3">
            <?php display_message(); ?>
            <?php capturar_profissional(); ?>
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
                                    <img src="img/logo.png" style="margin-top:20px;width:10%;height: auto;">
                                </div>
                                <div class="panel-heading">
                                    <h3 class="pt-4 font-weight-bold">Capturar profissional</h3>
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
                                        <label for="atividade">Atividade:</label>
                                        <input type="text" name="atividade" id="atividade" tabindex="1" class="form-control"
                                            placeholder="Colar aqui a atividade do profissional" value="" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="atividade">Whatsapp:</label>
                                        <input type="text" name="whatsapp" id="whatsapp" tabindex="2" class="form-control"
                                            placeholder="Colar aqui o whatsApp" value="" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="atividade">CEP:</label>
                                        <input type="text" name="cep" id="cep" tabindex="3" class="form-control"
                                            placeholder="Colar aqui o CEP" value="" required>
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