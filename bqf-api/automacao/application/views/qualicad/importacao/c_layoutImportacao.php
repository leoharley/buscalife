<?php

$Id_LayoutImportacao = '';
$Ds_LayoutImportacao = '';
$No_Importacao = '';
$Tp_Ativo = '';

if ($this->uri->segment(2) == 'editar') {
if(!empty($infoLayoutImportacao))
{
    foreach ($infoLayoutImportacao as $r)
    {
        $Id_LayoutImportacao = $r->Id_LayoutImportacao;
        $Ds_LayoutImportacao = $r->Ds_LayoutImportacao;
        $No_Importacao = $r->No_Importacao;
        $Tp_Ativo = $r->Tp_Ativo;
    }
}
}

?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-users"></i> <?php echo ($this->uri->segment(2) == 'cadastrar') ? 'Cadastrar conjunto DEPARA' : 'Editar conjunto DEPARA' ; ?>
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
                    <form role="form" id="addLayoutImportacao" action="<?php echo ($this->uri->segment(2) == 'cadastrar') ? base_url().'adicionaLayoutImportacao' : base_url().'editaLayoutImportacao'; ?>" method="post" role="form">
                        <div class="box-body">
                            
                        
                        <div class="row" style="display: inline-block;width: 98%;height: 100%;margin: 0.15rem;padding-top: 0.85rem;padding-left:1rem;padding-right:1rem;
                            background-color: #f5f5f5;padding-bottom:2rem">

                                <h4><strong>Conjunto DEPARA</strong></h4>

                                <table style="width:100%;">
                                    <thead>
                                    <tr style="background-color:#e0e0e0">
                                        <th class="header-label" style="padding:10px">
                                        Código
                                        </th>
                                        <th class="header-label" style="padding:10px">
                                        Conjunto DEPARA (descrição)
                                        </th>
                                        <th class="header-label" style="padding:10px">
                                        Tela de importação que aparece este conjunto para escolher
                                        </th>
                                        <th class="header-label" style="padding:10px">
                                        Ativo?
                                        </th>
                                    </tr>
                                </thead>
                                <tr id="row0">
                                            <td>
                                            <input type="text" class="form-control required" value="<?php echo ($this->uri->segment(2) == 'cadastrar') ? set_value('Id_LayoutImportacao') : $Id_LayoutImportacao ; ?>" id="Id_LayoutImportacao" name="Id_LayoutImportacao" disabled>
                                            </td>

                                            <td>
                                            <input type="text" class="form-control required" value="<?php echo ($this->uri->segment(2) == 'cadastrar') ? set_value('Ds_LayoutImportacao') : $Ds_LayoutImportacao ; ?>" id="Ds_LayoutImportacao" name="Ds_LayoutImportacao" maxlength="128">
                                            <input type="hidden" value="<?php echo $Id_LayoutImportacao; ?>" name="Id_LayoutImportacao" id="Id_LayoutImportacao" /> 
                                            </td>

                                            <td>
                                            <select class="form-control required" id="No_Importacao" name="No_Importacao">
                                            <option value="FatItem" <?php if ($this->uri->segment(2) == 'editar' && $No_Importacao == 'FatItem') { echo 'selected'; } else if ($this->uri->segment(2) == 'cadastrar') { echo 'selected'; } ?>>FatItem</option>
                                            <option value="GrupoPro" <?php if ($this->uri->segment(2) == 'editar' && $No_Importacao == 'GrupoPro') { echo 'selected'; } else if ($this->uri->segment(2) == 'cadastrar') { echo 'selected'; } ?>>GrupoPro</option>
                                            <option value="ProFat" <?php if ($this->uri->segment(2) == 'editar' && $No_Importacao == 'ProFat') { echo 'selected'; } ?>>ProFat</option>
                                            <option value="TUSS" <?php if ($this->uri->segment(2) == 'editar' && $No_Importacao == 'TUSS') { echo 'selected'; } ?>>TUSS</option>
                                            <option value="RegraGruPro" <?php if ($this->uri->segment(2) == 'editar' && $No_Importacao == 'RegraGruPro') { echo 'selected'; } ?>>RegraGruPro</option>
                                            <option value="FracaoSimproBra" <?php if ($this->uri->segment(2) == 'editar' && $No_Importacao == 'FracaoSimproBra') { echo 'selected'; } ?>>FracaoSimproBra</option>
                                            <option value="Produto" <?php if ($this->uri->segment(2) == 'editar' && $No_Importacao == 'Produto') { echo 'selected'; } ?>>Produto</option>
                                            <option value="Producao" <?php if ($this->uri->segment(2) == 'editar' && $No_Importacao == 'Producao') { echo 'selected'; } ?>>Producao</option>
                                            <option value="Contrato" <?php if ($this->uri->segment(2) == 'editar' && $No_Importacao == 'Contrato') { echo 'selected'; } ?>>Contrato</option>
                                            <option value="PorteMedico" <?php if ($this->uri->segment(2) == 'editar' && $No_Importacao == 'PorteMedico') { echo 'selected'; } ?>>PorteMedico</option>
                                            <option value="ExcecaoValores" <?php if ($this->uri->segment(2) == 'editar' && $No_Importacao == 'ExcecaoValores') { echo 'selected'; } ?>>ExcecaoValores</option>
                                            <option value="ItensEmpacotados" <?php if ($this->uri->segment(2) == 'editar' && $No_Importacao == 'ItensEmpacotados') { echo 'selected'; } ?>>ItensEmpacotados</option>
                                            <option value="Pacote" <?php if ($this->uri->segment(2) == 'editar' && $No_Importacao == 'Pacote') { echo 'selected'; } ?>>Pacote</option>
                                            <option value="AnaliseBI" <?php if ($this->uri->segment(2) == 'editar' && $No_Importacao == 'AnaliseBI') { echo 'selected'; } ?>>AnaliseBI</option>
                                            </select>
                                            </td>
                                            
                                            <td>
                                            <select class="form-control required" id="Tp_Ativo" name="Tp_Ativo">
                                            <option value="S" <?php if ($this->uri->segment(2) == 'editar' && $Tp_Ativo == 'S') { echo 'selected'; } else if ($this->uri->segment(2) == 'cadastrar') { echo 'selected'; } ?>>Sim</option>
											<option value="N" <?php if ($this->uri->segment(2) == 'editar' && $Tp_Ativo == 'N') { echo 'selected'; } ?>>Não</option>
                                            </select>
                                            </td>
                                </tr>

                                </table>
                            </div>
                        </div>
                        <!-- /.box-body -->

                        <div class="box-footer">
                            <input type="button" class="btn btn-primary" onclick="window.location='<?php echo base_url(); ?>layoutImportacao/listar';" value="Lista (CTRL+L)" name="IrLista" id="IrLista"/>
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
<script src="<?php echo base_url(); ?>assets/js/addLayoutImportacao.js" type="text/javascript"></script>

<script>
    shortcut.add("ctrl+l", function() {
    document.getElementById('IrLista').click();
    });   
    shortcut.add("ctrl+s", function() {
        document.getElementById('salvarIrLista').click();
    });
    shortcut.add("ctrl+a", function() {
        document.getElementById('salvarMesmaTela').click();
    });
    shortcut.add("ctrl+c", function() {
        document.getElementById('salvarRetroceder').click();
    });
</script>    