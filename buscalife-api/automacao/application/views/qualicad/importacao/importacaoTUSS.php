<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-users"></i> Importa TUSS
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
  
	
    <div class="row">
		
        <!-- File upload form -->
        <div class="col-md-12" id="importFrm">
            <form action="<?php echo base_url() ?>importaTUSS" method="post" enctype="multipart/form-data">
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

        <a class="btn btn-primary" href="<?php echo base_url(). 'exportaTUSS/'.$this->session->flashdata('num_linhas_importadas'); ?>" <?php if ($this->session->flashdata('num_linhas_importadas') == null) {echo 'disabled'; echo ' onclick=\'return false;\''; } ?>>
            <i class="fa fa-upload"></i> Exportar importação atual</a>
        <a class="btn btn-primary" href="<?php echo base_url(); ?>exportaTUSS/0">
            <i class="fa fa-upload"></i> Exportar todos registros</a>

        <!-- Data list table -->
      <!--  <table class="table table-striped table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>TbProFat_Cd_ProFat</th>
                    <th>TbConvenio_Id_Convenio*</th>
                    <th>Cd_Tuss*</th>
                    <th>Ds_Tuss</th>
                    <th>Dt_IniVigencia</th>
                    <th>Dt_FimVigencia</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php //if(!empty($infoTUSS)){ foreach($infoTUSS as $registro){ ?>
                <tr>
                    <td><?php //echo $registro->TbProFat_Cd_ProFat ?></td>
                    <td><?php //echo $registro->TbConvenio_Id_Convenio ?></td>
                    <td><?php //echo $registro->Cd_Tuss ?></td>
                    <td><?php //echo $registro->Ds_Tuss ?></td>
                    <td><?php //echo $registro->Dt_IniVigencia ?></td>
                    <td><?php //echo $registro->Dt_FimVigencia ?></td>
                    <td>
                        <a class="btn btn-sm btn-danger deleteUser" href="<?php //echo base_url().'apagaImportacaoTUSS/'.$registro->Id_Tuss; ?> "title="Excluir">
                            <i class="fa fa-trash-o"></i>
                        </a>
                    </td>
                </tr>
                <?php// } }else{ ?>
                <tr><td colspan="5">Nenhum registro encontrado...</td></tr>
                <?php// } ?>
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