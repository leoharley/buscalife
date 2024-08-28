<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-users"></i> Importa Simpro
            <small>Importação de mensagem</small>
        </h1>
    </section>

<style>
  table {
    border-color: #808080!important;
  }
  th {
    border-color: #808080!important;
    color: black;
    background-color: #d0d0d0;
    }
  td {
    border-color: #808080!important;
    color: black;
    }
  .box {
    width: 100%!important;
  }
  </style>   

    <section class="content">


<div class="container">
    <?php
    $this->load->helper('form');
    $error = $this->session->flashdata('error');
    if($error)
    {
        ?>
        <div class="alert alert-danger alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <?php echo $this->session->flashdata('error'); ?>
        </div>
    <?php } ?>
    <?php
    $success = $this->session->flashdata('success');
    if($success)
    {
        ?>
        <div class="alert alert-success alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <?php echo $this->session->flashdata('success'); ?>
            <br/>
            <?php
            $errosDeChaveMsg = $this->session->flashdata('errosDeChaveMsg');
            if ($errosDeChaveMsg != '') echo 'VERIFICAR AS LINHAS (não inseridas): '. $errosDeChaveMsg; ?>
        </div>
    <?php } ?>

    <div class="row">
		
        <!-- File upload form -->
        <div class="col-md-12" id="importFrm">
            <form action="<?php echo base_url() ?>importaSimproMsg" method="post" enctype="multipart/form-data">
                <br/>
                <input type="file" name="file" id="file" onChange='getoutput()'/>
                <input id='outputfile' type='hidden' name='outputfile'>
                <br/>
                <input type="submit" class="btn btn-primary" name="importSubmit" id="importSubmit" value="ATUALIZAR">
                
                <div id="loader" style="display:none;margin-top:30px">
                <span><strong>O arquivo está sendo carregado, aguarde...    </strong></span>
                <img src="<?php echo base_url(); ?>assets/images/loading.gif" style="width:100px;height:auto">
                </div>

                <br/>
                <br/>

                <p>Última Mensagem: <span style="color:green"><b><?php if (isset($infoSimproMsgs[0]->NumeroMsg)) {echo substr_replace($infoSimproMsgs[0]->NumeroMsg,"/", 2, 0);} ?></b></span></p>
                <p>Data de Envio: <span style="color:green"><b><?php if (isset($infoSimproMsgs[0]->Dt_Criacao)) {echo date("d/m/Y", strtotime($infoSimproMsgs[0]->Dt_Criacao));} ?></b></span></p>
                <p>Data da Atualização: <span style="color:green"><b><?php if (isset($infoSimproMsgs[0]->Dt_Criacao)) {echo date("d/m/Y", strtotime($infoSimproMsgs[0]->Dt_Criacao));} ?></b></span></p>

                <br/>
                <p><b>HISTÓRICO DE MENSAGENS</b></p>
                <div class="row" style="display: inline-block;width: 88%;height: 100%;margin: 0.15rem;padding-top: 0.85rem;padding-left:1rem;padding-right:1rem;
                            background-color: #f5f5f5;padding-bottom:2rem">
                <table class="table table-striped table-bordered" style="width:100%" id="dataTables-example">
                    <thead class="thead-dark">
                        <tr>
                            <th>Nº da Mensagem</th>
                            <th>Dt. de Envio</th>
                            <th>Dt. de Atualização</th>
                            <th>Inclusões</th>
                            <th>Atualização de Preços</th>
                            <th>Alterações</th>
                            <th>Fora de Linha</th>
                            <th>Atualização Suspensa</th>
                            <th>Descontinuados</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(!empty($consolidadoSimproMsgs)){ foreach($consolidadoSimproMsgs as $registro){ ?>
                        <tr>
                            <td><?php if (isset ($registro->NumeroMsg)) { echo substr_replace($registro->NumeroMsg,"/", 2, 0); } ?></td>
                            <td><?php if (isset ($registro->Dt_Criacao)) { echo date("d/m/Y", strtotime($registro->Dt_Criacao)); } ?></td>
                            <td><?php if (isset ($registro->Dt_Criacao)) { echo date("d/m/Y", strtotime($registro->Dt_Criacao)); } ?></td>
                            <td><?php echo $registro->inclusoes ?></td>
                            <td><?php echo $registro->precos ?></td>
                            <td><?php echo $registro->alteracoes ?></td>
                            <td><?php echo $registro->fora_linha ?></td>
                            <td><?php echo $registro->atualizacao_suspensa ?></td>
                            <td><?php echo $registro->descontinuados ?></td>
                        </tr>
                        <?php } }else{ ?>
                        <tr><td colspan="5">Nenhum registro encontrado...</td></tr>
                        <?php } ?>
                    </tbody>
                </table>
                </div>

            </form>
        </div>
    <!--    <a class="btn btn-primary" href="<?php //echo base_url(). 'exportaProducao/'.$this->session->flashdata('num_linhas_importadas'); ?>" <?php if ($this->session->flashdata('num_linhas_importadas') == null) {echo 'disabled'; echo ' onclick=\'return false;\''; } ?>>
            <i class="fa fa-upload"></i> Exportar importação atual</a>
        <a class="btn btn-primary" href="<?php //echo base_url(); ?>exportaProducao/0">
            <i class="fa fa-upload"></i> Exportar todos registros</a> -->

        <!-- Data list table -->
        
    </div>
</div>

</section>
</div>

<script>
function formToggle(ID){
    var element = document.getElementById(ID);
    if(element.style.display === "none"){
        element.style.display = "block";
    }else{
        element.style.display = "none";
    }
}

function getFile(filePath) {
        return filePath.substr(filePath.lastIndexOf('\\') + 1).split('.')[0];
    }

function getoutput() {
    $('#outputfile').val(getFile($('#file').val()));    
}

$(document).ready(function () {
        $('#importSubmit').attr('disabled', true);
        $('input:file').change(
            function () {
                if ($(this).val()) {
                    $('#importSubmit').removeAttr('disabled');
                }
                else {
                    $('#importSubmit').attr('disabled', true);
                }
            });

            $('#importSubmit').click(
            function () {
                $("#importSubmit").toggleClass('disabled');
                $('#loader').show();
            });
    });
</script>