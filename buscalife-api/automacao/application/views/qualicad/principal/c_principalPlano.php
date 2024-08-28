<?php

$Id_Plano = '';
$TbConvenio_Id_Convenio = '';
$TbIndice_Id_Indice = '';
$TbRegra_Id_Regra = '';
$Ds_Plano = '';
$Cd_PlanoERP = '';
$Tp_AcomodacaoPadrao = '';
$Tp_Ativo = '';

if ($this->uri->segment(2) == 'editar') {
if(!empty($infoPlano))
{
    foreach ($infoPlano as $r)
    {
        $Id_Plano = $r->Id_Plano;
        $TbConvenio_Id_Convenio = $r->TbConvenio_Id_Convenio;
        $TbIndice_Id_Indice = $r->TbIndice_Id_Indice;
        $TbRegra_Id_Regra = $r->TbRegra_Id_Regra;
        $Ds_Plano = $r->Ds_Plano;
        $Cd_PlanoERP = $r->Cd_PlanoERP;
        $Tp_AcomodacaoPadrao = $r->Tp_AcomodacaoPadrao;
        $Tp_Ativo = $r->Tp_Ativo;
    }
}
}

?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-users"></i> <?php echo ($this->uri->segment(2) == 'cadastrar') ? 'Cadastrar Plano' : 'Editar Plano' ; ?>
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
                    <form role="form" id="addPlano" action="<?php echo ($this->uri->segment(2) == 'cadastrar') ? base_url().'adicionaPlano' : base_url().'editaPlano'; ?>" method="post" role="form">
                        <div class="box-body">

                        <div class="row" style="display: inline-block;width: 98%;height: 100%;margin: 0.15rem;padding-top: 0.85rem;padding-left:1rem;padding-right:1rem;
                            background-color: #f5f5f5;padding-bottom:2rem">

                                <h4><strong>Plano</strong></h4>

                                <table style="width:100%;">
                                    <thead>
                                    <tr style="background-color:#e0e0e0">
                                        <th class="header-label" style="padding:10px">
                                        Id Seq
                                        </th>
                                        <th class="header-label" style="padding:10px">
                                        Convênio
                                        </th>
                                        <th class="header-label" style="padding:10px">
                                        Índice
                                        </th>                                        
                                        <th class="header-label" style="padding:10px">
                                        Regra
                                        </th>
                                        <th class="header-label" style="padding:10px">
                                        Descrição do plano
                                        </th>
                                        <th class="header-label" style="padding:10px">
                                        Código ERP
                                        </th>
                                        <th class="header-label" style="padding:10px">
                                        Tipo de acomodação padrão
                                        </th>
                                        <th class="header-label" style="padding:10px">
                                        Plano ativo?
                                        </th>
                                    </tr>
                                </thead>
                                <tr id="row0">
                                            <td>
                                            <input type="text" style="pointer-events:none" class="form-control" value="<?php echo ($this->uri->segment(2) == 'cadastrar') ? set_value('Id_Plano') : $Id_Plano ; ?>" id="Id_Plano" name="Id_Plano">
                                            </td>
                                            <td>
                                                <select class="form-control required" id="TbConvenio_Id_Convenio" name="TbConvenio_Id_Convenio" required>
                                                <option value="" disabled selected>SELECIONE</option>
                                                <?php
                                                if(!empty($infoConvenio))
                                                {
                                                    foreach ($infoConvenio as $convenio)
                                                    {
                                                        ?>
                                                    <option value="<?php echo $convenio->Id_Convenio ?>" <?php if ($this->uri->segment(2) == 'editar' && $convenio->Id_Convenio == $TbConvenio_Id_Convenio) { echo 'selected'; } ?>>
                                                        <?php echo $convenio->Id_Convenio.' - '.$convenio->Ds_Convenio ?>
                                                    </option>
                                                    <?php
                                                    }
                                                }
                                                ?>
                                                </select>
                                                <input type="hidden" value="<?php echo $Id_Plano; ?>" name="Id_Plano" id="Id_Plano" />
                                            </td>

                                            <td>
                                                <select class="form-control required" id="TbIndice_Id_Indice" name="TbIndice_Id_Indice" required>
                                                <option value="" disabled selected>SELECIONE</option>
                                                <?php
                                                if(!empty($infoIndice))
                                                {
                                                    foreach ($infoIndice as $indice)
                                                    {
                                                        ?>
                                                    <option value="<?php echo $indice->Id_Indice ?>" <?php if ($this->uri->segment(2) == 'editar' && $indice->Id_Indice == $TbIndice_Id_Indice) { echo 'selected'; } ?>>
                                                        <?php echo $indice->Id_Indice.' - '.$indice->Ds_indice ?>
                                                    </option>
                                                    <?php
                                                    }
                                                }
                                                ?>
                                                </select>
                                            </td>

                                            <td>
                                                <select class="form-control required" id="TbRegra_Id_Regra" name="TbRegra_Id_Regra" required>
                                                <option value="" disabled selected>SELECIONE</option>
                                                <?php
                                                if(!empty($infoRegra))
                                                {
                                                    foreach ($infoRegra as $regra)
                                                    {
                                                        ?>
                                                    <option value="<?php echo $regra->Id_Regra ?>" <?php if ($this->uri->segment(2) == 'editar' && $regra->Id_Regra == $TbRegra_Id_Regra) { echo 'selected'; } ?>>
                                                        <?php echo $regra->Id_Regra.' - '.$regra->Ds_Regra ?>
                                                    </option>
                                                    <?php
                                                    }
                                                }
                                                ?>
                                                </select>
                                            </td>

                                            <td>
                                            <input type="text" class="form-control required" id="Ds_Plano" value="<?php echo ($this->uri->segment(2) == 'cadastrar') ? set_value('Ds_Plano') : $Ds_Plano ; ?>" name="Ds_Plano"
                                            maxlength="128">
                                            </td>

                                            <td>
                                            <input type="text" class="form-control required" id="Cd_PlanoERP" value="<?php echo ($this->uri->segment(2) == 'cadastrar') ? set_value('Cd_PlanoERP') : $Cd_PlanoERP ; ?>" name="Cd_PlanoERP"
                                            maxlength="11">
                                            </td>

                                            <td>
                                                <select class="form-control required" id="Tp_AcomodacaoPadrao" name="Tp_AcomodacaoPadrao" required>
                                                <option value="" disabled selected>SELECIONE</option>
                                                <option value="1" <?php if ($this->uri->segment(2) == 'editar' && $Tp_AcomodacaoPadrao == '1') { echo 'selected'; } ?>>Enfermaria</option>
                                                <option value="2" <?php if ($this->uri->segment(2) == 'editar' && $Tp_AcomodacaoPadrao == '2') { echo 'selected'; } ?>>Apartamento</option>
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
                            
                        
                        
                        <!-- /.box-body -->

                        <div class="box-footer">
                            <input type="button" class="btn btn-primary" onclick="window.location='<?php echo base_url(); ?>principalPlano/listar';" value="Lista (CTRL+L)" name="IrLista" id="IrLista"/>
                            <input type="submit" class="btn btn-primary" value="Salva e lista (CTRL+S)" name="salvarIrLista" id="salvarIrLista" style="margin-left:5px;"/>
                            <input type="submit" class="btn btn-primary" value="Salva e cadastra novamente (CTRL+A)" name="salvarMesmaTela" id="salvarMesmaTela" style="margin-left:5px;<?php if ($this->uri->segment(2) == 'editar') { echo 'display:none'; } ?>"/>
                            <input type="submit" class="btn btn-primary" value="Salva e cadastra convênio (CTRL+C)" name="salvarRetroceder" id="salvarRetroceder" style="margin-left:5px;<?php if ($this->uri->segment(2) == 'editar') { echo 'display:none'; } ?>"/>
                            <input type="submit" class="btn btn-primary" value="Salva e edita convênio associado(CTRL+V)" name="salvareVoltar" id="salvareVoltar" style="margin-left:5px;<?php if ($this->uri->segment(2) == 'cadastrar') { echo 'display:none'; } ?>"/>
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
<script src="<?php echo base_url(); ?>assets/js/addPlano.js" type="text/javascript"></script>

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
    shortcut.add("ctrl+v", function() {
        document.getElementById('salvareVoltar').click();
    });
</script>    