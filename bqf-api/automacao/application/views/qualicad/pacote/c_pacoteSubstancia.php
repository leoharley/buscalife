<?php

$cd_substancia = '';
$desc_substancia = '';

if ($this->uri->segment(2) == 'editar') {
if(!empty($infoSubstancia))
{
    foreach ($infoSubstancia as $r)
    {
        $cd_substancia = $r->cd_substancia;
        $desc_substancia = $r->desc_substancia;
    }
}
}

?>

<style>
    #table, th, td {
    border: 1px solid #c0c0c0;
    border-collapse: collapse;
    }
    #table input {border:0!important;outline:0;}
    #table input:focus {outline:none!important;}
    #table select {border:0!important;outline:0;}
    #table select:focus {outline:none!important;}

    #table thead {
    position: sticky;
    top: 0;
    }

    #table thead th {
    border: 1px solid #e4eff8;
    background: white;
    cursor: pointer;
    }

    #table thead th.header-label {
    cursor: pointer;
    background: linear-gradient(0deg, #3c8dbc, #4578a2 5%, #e4eff8 150%);
    color: white;
    border: 1px solid white;
    }

    .box {
    width: 152%!important;
    }   
</style>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-users"></i> <?php echo ($this->uri->segment(2) == 'cadastrar') ? 'Cadastrar Substância' : 'Editar Substância' ; ?>
            <small><?php echo ($this->uri->segment(2) == 'cadastrar') ? 'Adicionar' : 'Editar' ; ?></small>
        </h1>
    </section>

    <section class="content">

        <div class="row">
            <!-- left column -->
            <div class="col-md-8">
                <!-- general form elements -->

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
                </div>
                <?php } ?>

                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Selecione e preencha os campos abaixo</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <?php $this->load->helper("form"); ?>
                    <form role="form" id="addSubstancia" action="<?php echo ($this->uri->segment(2) == 'cadastrar') ? base_url().'adicionaSubstancia' : base_url().'editaSubstancia'; ?>" method="post" role="form">
                        <div class="box-body">

                        <div class="row" style="display: inline-block;width: 100%;height: 100%;margin: 0.15rem;padding-top: 0.85rem;padding-left:1rem;padding-right:1rem;
                            background-color: #f5f5f5;padding-bottom:2rem">

                                <h4><strong>Substância</strong></h4>

                                <table style="width:40%;">
                                    <thead>
                                    <tr style="background-color:#e0e0e0">
                                    <!--    <th class="header-label" style="padding:10px">
                                        Id Seq
                                        </th>  -->                                  
                                        <th class="header-label" style="padding:10px">
                                        Substância (descrição)
                                        </th>
                                    </tr>
                                </thead>
                                <tr id="row0">
                                        <td>
                                        <input type="text" class="form-control required" id="desc_substancia" value="<?php echo ($this->uri->segment(2) == 'cadastrar') ? set_value('desc_substancia') : $desc_substancia ; ?>" name="desc_substancia">
                                        <input type="hidden" value="<?php echo $cd_substancia; ?>" name="cd_substancia" id="cd_substancia" /> 
                                        </td>
                                </tr>

                                </table>
                            </div>

                            
                        </div>
                        <!-- /.box-body -->

                        <div class="box-footer">
                            <input type="button" class="btn btn-primary" onclick="window.location='<?php echo base_url(); ?>principalRegraProibicao/listar';" value="Lista (CTRL+L)" name="IrLista" id="IrLista"/>
                            <input type="submit" class="btn btn-primary" value="Salva e lista (CTRL+S)" name="salvarIrLista" id="salvarIrLista" style="margin-left:5px;"/>
                            <input type="submit" class="btn btn-primary" value="Salva e cadastra novamente (CTRL+A)" name="salvarMesmaTela" id="salvarMesmaTela" style="margin-left:5px;<?php if ($this->uri->segment(2) == 'editar') { echo 'display:none'; } ?>"/>
                            <!--    <input type="reset" class="btn btn-info" value="Limpar Campos" /> -->
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-4">
                    <div class="row">
                        <div class="col-md-12">
                            <?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
                        </div>
                    </div>
            </div>
        </div>
    </section>
</div>
<script src="<?php echo base_url(); ?>assets/js/addUser.js" type="text/javascript"></script>
<script>
    $(document).ready(function(){
    //    $(":input").inputmask();
        $('.valor').maskMoney({precision:4,thousands:'.', decimal:','});
    });

    shortcut.add("ctrl+l", function() {
    document.getElementById('IrLista').click();
    });
    shortcut.add("ctrl+s", function() {
        document.getElementById('salvarIrLista').click();
    });
    shortcut.add("ctrl+a", function() {
        document.getElementById('salvarMesmaTela').click();
    });
</script>