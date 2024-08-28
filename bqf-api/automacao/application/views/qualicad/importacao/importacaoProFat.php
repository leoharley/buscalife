<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-users"></i> Importa ProFat
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
 <!--   <div class="text-right">
        <a class="btn btn-primary" href="<?php// echo base_url(); ?>importacaoDeletaProFat">
         <i class="fa fa-erase"></i> Apagar Base</a>
      </div>
    <br/>  -->

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
            <form action="<?php echo base_url() ?>importaProFat" method="post" enctype="multipart/form-data">
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

        <a class="btn btn-primary" href="<?php echo base_url(). 'exportaProFat/'.$this->session->flashdata('num_linhas_importadas'); ?>" <?php if ($this->session->flashdata('num_linhas_importadas') == null) {echo 'disabled'; echo ' onclick=\'return false;\''; } ?>>
            <i class="fa fa-upload"></i> Exportar importação atual</a>
        <a class="btn btn-primary" href="<?php echo base_url(); ?>exportaProFat/0">
            <i class="fa fa-upload"></i> Exportar todos registros</a>

        <?php echo $this->session->flashdata('errosDeChaveMsg'); ?>
        
        <!-- Data list table -->
      <!--  <table class="table table-striped table-bordered" id="dataTables-example">
            <thead class="thead-dark">
                <tr>
                    <th>CodProFat</th>
                    <th>Ds_ProFat</th>
                    <th>Ds_Unidade</th>
                    <th>TbGrupoPro_CodGrupo*</th>
                    <th>Tp_Ativo</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php //if(!empty($infoProFat)){ foreach($infoProFat as $registro){ ?>
                <tr>
                    <td><?php //echo $registro->CodProFat ?></td>
                    <td><?php //echo $registro->Ds_ProFat ?></td>
                    <td><?php //echo $registro->Ds_Unidade ?></td>
                    <td><?php //echo $registro->TbGrupoPro_CodGrupo ?></td>
                    <td><?php //echo ($registro->Tp_Ativo == 'S') ? 'Sim' : 'Não'; ?></td>
                    <td>
                        <a class="btn btn-sm btn-danger deleteUser" href="<?php //echo base_url().'apagaImportacaoProFat/'.$registro->Cd_ProFat; ?> "title="Excluir">
                            <i class="fa fa-trash-o"></i>
                        </a>
                    </td>
                </tr>
                <?php //} }else{ ?>
                <tr><td colspan="5"></td></tr>
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