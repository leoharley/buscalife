<?php
include('inc/header.php');
//include('inc/nav.php');
//login_check_pages();

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

?>

    <div class="row">
        <div class="col-lg-6 col-lg-offset-3">
            <?php //display_message(); ?>
            <?php cadastrar_profissional(); ?>
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
                                    <h3 class="pt-4 font-weight-bold">Cadastro de Profissional Indicado</h3>
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
                                        <label for="servico">Você foi indicado para serviços de:</label>
                                        <input type="text" name="servico" id="servico" tabindex="1" class="form-control"
                                            placeholder="" value="<?php display_atividade_profissional(); ?>" disabled>
                                    </div>
                                    <div class="form-group">
                                        <label for="whatsapp">Seu WhatsApp:</label>
                                        <input type="text" name="whatsapp" id="whatsapp" tabindex="2" class="form-control"
                                            placeholder="" value="<?php display_whatsapp_profissional(); ?>" enabled>
                                    </div>
                                    <div class="form-group">
                                        <label for="nome_completo">Informe seu nome completo:</label>
                                        <input type="text" name="nome_completo" id="nome_completo" tabindex="3" class="form-control"
                                            placeholder="Nome completo" value="" required>
                                    </div>
                                    <div class="form-group">
                                    <label for="como_deseja_ser_contratado">Como deseja ser contratado?</label>
                                        <select name="como_deseja_ser_contratado" id="como_deseja_ser_contratado" tabindex="4" class="form-control">
                                        <option value="" selected disabled>Escolha uma das opções</option>
                                        <option value="1">Por todos que precisem de <?php display_atividade_profissional(); ?></option>
                                        <option value="2">Só por quem pesquisar pelo meu nome</option>
                                        </select>
                                    </div>
                                    <div class="form-group" id="msg_certificado" style="display:none">
                                        <div class="row">
                                            <div class="col-sm-12">
                                            Para que sua contratação seja direcionada a todos que precisem de <?php display_atividade_profissional(); ?>,
                                            é necessário a emissão do <a href=# data-toggle="modal" data-target="#exampleModal">CPV (Certificado de Profissional Verificado)</a>. Taxa para emissão: R$ 30,00
                                            </div>
                                        </div>
                                    </div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">      
      <div class="modal-body">
        O que é o <strong>CPV</strong> (Certificado de Profissional Verificado)?
        <br/>
        Documento composto por certidões de autenticidade cadastral e certidões negativas:<br/>
         <li>Validação de CPF/CNPJ</li>
         <li>Validação de endereço comercial (se houver)</li>
         <li>Certidão negativa de inscrição (CNI) (se houver)</li>
         <li>Certidão negativa de antecedentes criminais pela Polícia Federal e por órgãos das justiças estaduais e federal, polícia rodoviária federal, polícias civis, polícias penais federal, estaduais e distrital.</li>
         <br/>
        <small><strong> Política de privacidade e condições gerais: </strong><br/>
         <p>1. Uso das Informações: As informações coletadas são utilizadas exclusivamente para os fins relacionados à emissão dos certificados, incluindo verificação de elegibilidade, processamento de pedidos, comunicação sobre o status do certificado e envio do certificado físico ou digital.</p>
         <p>2. Armazenamento Seguro: Todas as informações pessoais são armazenadas de forma segura e protegida contra acesso não autorizado, uso indevido ou divulgação.</p>
         <p>3. Divulgação a Terceiros: As informações pessoais do profissional não será vendida, compartilhada ou divulgada a terceiros sem o consentimento expresso do indivíduo, exceto quando necessário por lei ou para cumprir com obrigações contratuais ou regulatórias relacionadas à emissão de certificados.</p>
         <p>4. Validade do certificado: 03 (três) meses.</p>
         <p>5. O certificado emitido é de propriedade do profissional e será enviado por E-mail ou Whatsapp no prazo de 24 horas após a aquisição.</p></small>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>        
      </div>
    </div>
  </div>
</div>
                                    
                                    <div class="form-group" id="emitir_certificado_btn" style="display:none;text-align:center">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <input type="submit" ng-click="login()" ng-name="register-submit-1" id="register-submit-1"
                                                    tabindex="4" class="form-control btn btn-register"
                                                    value="EMITIR CERTIFICADO E CADASTRAR">                                                
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group" id="cadastrar_btn" style="text-align:center;display:none">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <input type="submit" name="register-submit-2" id="register-submit-2"
                                                    tabindex="4" class="form-control btn btn-register"
                                                    value="CADASTRAR">
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

document.getElementById('como_deseja_ser_contratado').addEventListener('change', function () {
    var style = this.value == 1 ? 'block' : 'none';
    document.getElementById('emitir_certificado_btn').style.display = style;
    document.getElementById('msg_certificado').style.display = style;
    var style = this.value == 2 ? 'block' : 'none';
    document.getElementById('cadastrar_btn').style.display = style;
});
</script>