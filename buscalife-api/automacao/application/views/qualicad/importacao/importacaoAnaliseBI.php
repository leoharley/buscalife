<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-users"></i> Importa Análise BI
            <small>Importação</small>
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
    #importFrm {
        margin-bottom: 20px;
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
            <form action="<?php echo base_url() ?>importaAnaliseBI" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="Ds_Layout">Conjunto DEPARA</label>
                    <select class="form-control required" id="Tb_Id_LayoutImportacao" name="Tb_Id_LayoutImportacao">
                    <?php
                    if(!empty($infoLayoutImportacao))
                    {
                        foreach ($infoLayoutImportacao as $layoutimportacao)
                        {
                            ?>
                        <option value="<?php echo $layoutimportacao->Id_LayoutImportacao ?>" <?php if ($this->uri->segment(2) == 'editar' && $layoutimportacao->Id_LayoutImportacao  == $Tb_Id_LayoutImportacao) { echo 'selected'; } ?>>
                            <?php echo $layoutimportacao->Id_LayoutImportacao.' - '.$layoutimportacao->Ds_LayoutImportacao ?>
                        </option>
                        <?php
                        }
                    }
                    ?>
                    </select>
                </div>
                <br/>
                <input type="file" name="file" />
                <br/>
                <input type="submit" class="btn btn-primary" name="importSubmit" id="importSubmit" value="IMPORTAR">
                
                <div id="loader" style="display:none;margin-top:30px">
                <span><strong>O arquivo está sendo carregado, aguarde...    </strong></span>
                <img src="<?php echo base_url(); ?>assets/images/loading.gif" style="width:100px;height:auto">
                </div>

            </form>
        </div>

        <br/>
        <span style="color:red"><small>* VERIFICAR SE EXISTE CORRESPONDÊNCIA DE VALORES NAS CHAVES ESTRANGEIRAS</small></span>
        <br/>
        <br/>

        <a class="btn btn-primary" href="<?php echo base_url(). 'exportaProducao/'.$this->session->flashdata('num_linhas_importadas'); ?>" <?php if ($this->session->flashdata('num_linhas_importadas') == null) {echo 'disabled'; echo ' onclick=\'return false;\''; } ?>>
            <i class="fa fa-upload"></i> Exportar importação atual</a>
        <a class="btn btn-primary" href="<?php echo base_url(); ?>exportaProducao/0">
            <i class="fa fa-upload"></i> Exportar todos registros</a>

        <!-- Data list table -->
       <!-- <table class="table table-striped table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>TbProFat_Cd_ProFat</th>
                    <th>TbPlano_Id_Plano*</th>
                    <th>Num_Conta</th>
                    <th>Num_Atendimento</th>
                    <th>Dt_Lancamento</th>
                    <th>Qt_Lancamento</th>
                    <th>Vl_Conta</th>
                    <th>Cd_Movimento</th>
                    <th>Cd_ITMovimento</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php //if(!empty($infoProducao)){ foreach($infoProducao as $registro){ ?>
                <tr>
                    <td><?php //echo $registro->TbProFat_Cd_ProFat ?></td>
                    <td><?php //echo $registro->TbPlano_Id_Plano ?></td>
                    <td><?php //echo $registro->Num_Conta ?></td>
                    <td><?php //echo $registro->Num_Atendimento ?></td>
                    <td><?php //echo $registro->Dt_Lancamento ?></td>
                    <td><?php //echo $registro->Qt_Lancamento ?></td>
                    <td><?php //echo $registro->Vl_Conta ?></td>
                    <td><?php //echo $registro->Cd_Movimento ?></td>
                    <td><?php //echo $registro->Cd_ITMovimento ?></td>
                    <td>
                        <a class="btn btn-sm btn-danger deleteUser" href="<?php //echo base_url().'apagaImportacaoProducao/'.$registro->Id_Producao; ?> "title="Excluir">
                            <i class="fa fa-trash-o"></i>
                        </a>
                    </td>
                </tr>
                <?php //} }else{ ?>
                <tr><td colspan="5">Nenhum registro encontrado...</td></tr>
                <?php //} ?>
            </tbody>
        </table> -->
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
                $('#loader').show();
            });
    });
</script>