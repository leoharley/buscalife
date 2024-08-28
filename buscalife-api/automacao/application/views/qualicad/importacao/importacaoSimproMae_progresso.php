<link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-users"></i> Importa Simpro (Carga mãe)
            <small>Importação de tabela mãe</small>
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
            <form action="<?php echo base_url() ?>importaSimproMae" method="post" enctype="multipart/form-data">
                <br/>
                <input type="file" name="file" id="file" style="display:none" onChange='getoutput()'/>
                <input id='outputfile' type='hidden' name='outputfile'>
                <br/>
                <input type="submit" class="btn btn-primary" style="display:none" name="importSubmit2" id="importSubmit2" value="">
                
                <div style="color:green!important;width:93%!important" id="progressbar"></div>

                <input type="hidden" name="progresso" id="progresso" value="<?php echo $progresso; ?>">
                <input type="hidden" name="filename" id="filename" value="<?php echo $filename; ?>">
                <input type="hidden" name="size" id="size" value="<?php echo $size; ?>">
                <input type="hidden" name="rowcount" id="rowcount" value="<?php echo $rowcount; ?>">
                <input type="hidden" name="insertcount" id="insertcount" value="<?php echo $insertcount; ?>">
                <input type="hidden" name="updatecount" id="updatecount" value="<?php echo $updatecount; ?>">
                <input type="hidden" name="notaddcount" id="notaddcount" value="<?php echo $notaddcount; ?>">
                <input type="hidden" name="duplicidade" id="duplicidade" value="<?php echo $duplicidade; ?>">

                <div id="loader" style="margin-top:30px">
                <span>
                <?php if ($progresso != 'completo') {
                        echo "<strong>O arquivo está sendo importado, aguarde...    </strong>
                        </span>
                        <img src='".base_url()."assets/images/loading.gif' style='width:100px;height:auto'>"; 
                    } else {
                        echo "<strong>O arquivo foi importado com sucesso!</strong>";
                    }
                ?>
                </div>

            </form>
        </div>

        <br/>

    <!--    <a class="btn btn-primary" href="<?php //echo base_url(). 'exportaProducao/'.$this->session->flashdata('num_linhas_importadas'); ?>" <?php if ($this->session->flashdata('num_linhas_importadas') == null) {echo 'disabled'; echo ' onclick=\'return false;\''; } ?>>
            <i class="fa fa-upload"></i> Exportar importação atual</a>
        <a class="btn btn-primary" href="<?php //echo base_url(); ?>exportaProducao/0">
            <i class="fa fa-upload"></i> Exportar todos registros</a> -->  
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

$( function() {
    $( "#progressbar" ).progressbar({
      min: 0,
      max: <?= $progresso=='completo'?'100':$size; ?>,
      value: <?= $progresso=='completo'?'100':$progresso; ?>,
      create: function(event, ui) {$(this).find('.ui-widget-header').css({'background-color':'green'})}
    });
  } );

$(document).ready(function () {
        
        <?php if ($progresso != 'completo') { echo "$('#importSubmit2').click();"; } ?>

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