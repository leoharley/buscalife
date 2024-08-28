<?php

$Id_Convenio = '';
$Ds_Convenio = '';
$CNPJ_Convenio = '';
$Cd_ConvenioERP = '';
$Tp_Convenio = '';
$Dt_InicioConvenio = '';
$Dt_VigenciaConvenio = '';
$id_status_homologacao = '';
$dt_homolga_bi = '';
$dt_reajuste = '';
$Tp_Ativo = '';

if ($this->uri->segment(2) == 'editar') {
if(!empty($infoConvenio))
{
    foreach ($infoConvenio as $r)
    {
        $Id_Convenio = $r->Id_Convenio;
        $Ds_Convenio = $r->Ds_Convenio;
        $CNPJ_Convenio = $r->CNPJ_Convenio;
        $Cd_ConvenioERP = $r->Cd_ConvenioERP;
        $Tp_Convenio = $r->Tp_Convenio;
        $Dt_InicioConvenio = $r->Dt_InicioConvenio;
        $Dt_VigenciaConvenio = $r->Dt_VigenciaConvenio;
        $id_status_homologacao = $r->id_status_homologacao;
        $dt_homolga_bi = $r->dt_homolga_bi;
        $dt_reajuste = $r->dt_reajuste;
        $Tp_Ativo = $r->Tp_Ativo;
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


</style>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
    <h1>
        <i class="fa fa-users"></i> <?php echo ($this->uri->segment(2) == 'cadastrar') ? 'Cadastrar Convênio' : 'Editar Convênio' ; ?>
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
                    <form role="form" id="addConvenio" action="<?php echo ($this->uri->segment(2) == 'cadastrar') ? base_url().'adicionaConvenio' : base_url().'editaConvenio'; ?>" method="post" role="form">
                        <div class="box-body" style="padding-left:1rem;padding-right:1rem">
                            
                        <div class="row" style="display: inline-block;width: 98%;height: 100%;margin: 0.15rem;padding-top: 0.85rem;padding-left:1rem;padding-right:1rem;
                            background-color: #f5f5f5;padding-bottom:2rem">

                                <h4><strong>Convênio</strong></h4>

                                <div class="table-responsive">
                                

                                <table id="dataTables-example" style="overflow-x:auto;width:150%!important;">
                                    <thead>
                                    <tr style="background-color:#e0e0e0">
                                       <!-- <th class="header-label" style="padding:10px">
                                        Id Seq
                                        </th> -->
                                        <th class="header-label" style="padding:10px">
                                        Convênio(desc.)
                                        </th>
                                        <th class="header-label" style="padding:10px">
                                        CNPJ
                                        </th>                                        
                                        <th class="header-label" style="padding:10px">
                                        Cod. ERP
                                        </th>
                                        <th class="header-label" style="padding:10px">
                                        Tipo
                                        </th>
                                        <th class="header-label" style="padding:10px">
                                        Ínicio
                                        </th>
                                        <th class="header-label" style="padding:10px">
                                        Vigência
                                        </th>
                                        <th class="header-label" style="padding:10px">
                                        Status Homolog.
                                        </th>
                                        <th class="header-label" style="padding:10px">
                                        Dt. Homolog. do BI
                                        </th>
                                        <th class="header-label" style="padding:10px">
                                        Dt. Reajuste
                                        </th>
                                        <th class="header-label" style="padding:10px">
                                        Ativo?
                                        </th>
                                    </tr>
                                </thead>
                                <tr id="row0">
                                           <!-- <td style="width:8%">
                                            <input type="text" class="form-control required" value="<?php //echo ($this->uri->segment(2) == 'cadastrar') ? set_value('Id_Convenio') : $Id_Convenio ; ?>" id="Id_Convenio" name="Id_Convenio" disabled>
                                            </td> -->

                                            <td style="width:10%">
                                            <input type="text" class="form-control required" value="<?php echo ($this->uri->segment(2) == 'cadastrar') ? set_value('Ds_Convenio') : $Ds_Convenio ; ?>" id="Ds_Convenio" name="Ds_Convenio" maxlength="128">
                                            <input type="hidden" value="<?php echo $Id_Convenio; ?>" name="Id_Convenio" id="Id_Convenio" /> 
                                            </td>

                                            <td style="width:10%">
                                            <input type="text" data-inputmask="'mask': '99.999.999/9999-99'" class="form-control required cnpj" value="<?php echo ($this->uri->segment(2) == 'cadastrar') ? set_value('CNPJ_Convenio') : $CNPJ_Convenio ; ?>" id="CNPJ_Convenio" name="CNPJ_Convenio" maxlength="128">
                                            </td>

                                            <td>
                                            <input type="text" class="form-control required" id="Cd_ConvenioERP" value="<?php echo ($this->uri->segment(2) == 'cadastrar') ? set_value('Cd_ConvenioERP') : $Cd_ConvenioERP ; ?>" name="Cd_ConvenioERP"
                                            maxlength="13">
                                            </td>

                                            <td style="width:10%">
                                            <select class="form-control required" id="Tp_Convenio" name="Tp_Convenio" required>
                                            <option value="" disabled selected>SELECIONE</option>
                                            <option value="1" <?= $Tp_Convenio=='1'?'selected':''; ?>>Convênio</option>
                                            <option value="2" <?= $Tp_Convenio=='2'?'selected':''; ?>>Filantrópico</option>
                                            <option value="3" <?= $Tp_Convenio=='3'?'selected':''; ?>>Particular</option>
                                            </select>
                                            </td>

                                            <td>
                                            <input type="date" class="form-control required" value="<?php echo ($this->uri->segment(2) == 'cadastrar') ? set_value('Dt_InicioConvenio') : $Dt_InicioConvenio ; ?>" id="Dt_InicioConvenio" name="Dt_InicioConvenio">
                                            </td>

                                            <td>
                                            <input type="date" class="form-control" value="<?php echo ($this->uri->segment(2) == 'cadastrar') ? set_value('Dt_VigenciaConvenio') : $Dt_VigenciaConvenio ; ?>" id="Dt_VigenciaConvenio" name="Dt_VigenciaConvenio">
                                            </td>
                          
                                            <td style="width:10%">
                                                <select class="form-control" id="id_status_homologacao" name="id_status_homologacao">
                                                    <option value="" disabled selected>SELECIONE</option>
                                                    <?php
                                                    if(!empty($infoStatusHomologacao))
                                                    {
                                                        foreach ($infoStatusHomologacao as $statushomologacao)
                                                        {
                                                            ?>
                                                            <option value="<?php echo $statushomologacao->id_status_homologacao ?>" <?php if ($this->uri->segment(2) == 'editar' && $statushomologacao->id_status_homologacao == $id_status_homologacao) { echo 'selected'; } ?>>
                                                                <?php echo $statushomologacao->id_status_homologacao.' - '.$statushomologacao->ds_status ?>
                                                            </option>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </td>

                                            <td>
                                            <input type="date" class="form-control" value="<?php echo ($this->uri->segment(2) == 'cadastrar') ? set_value('dt_homolga_bi') : $dt_homolga_bi ; ?>" id="dt_homolga_bi" name="dt_homolga_bi">
                                            </td>

                                            <td>
                                            <input type="date" class="form-control" value="<?php echo ($this->uri->segment(2) == 'cadastrar') ? set_value('dt_reajuste') : $dt_reajuste ; ?>" id="dt_reajuste" name="dt_reajuste">
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

                            <div class="row" style="display: inline-block;width: 98%;height: 100%;margin: 0.15rem;padding-top: 0.85rem;padding-left:1rem;padding-right:1rem;
                            background-color: #f5f5f5;padding-bottom:2rem">

                                <h4><strong>Plano</strong></h4>

                                <table id="table" style="width:100%;">
                                    <thead>
                                    <tr style="background-color:#e0e0e0">
                                        <th class="header-label" style="padding:10px">
                                        Id Seq
                                        </th>                                        
                                        <th class="header-label" style="padding:10px">
                                        Cod. ERP
                                        </th>
                                        <th class="header-label" style="padding:10px">
                                        Desc. do plano
                                        </th>
                                        <th class="header-label" style="padding:10px">
                                        Acomodação padrão
                                        </th>
                                        <th class="header-label" style="padding:10px">
                                        Índice
                                        </th>
                                        <th class="header-label" style="padding:10px">
                                        Regra
                                        </th>
                                        <th class="header-label" style="padding:10px">
                                        Plano ativo?
                                        </th>
                                    </tr>
                                </thead>
                                <tr id="row0">                                            
                                            <td>
                                            <input type="text" class="form-control" id="Id_Plano" value="<?php echo set_value('Id_Plano') ; ?>" name="Id_Plano"
                                                maxlength="11" disabled>
                                            </td>

                                            <td>
                                            <input type="text" class="form-control" id="Cd_PlanoERP" value="<?php echo set_value('Cd_PlanoERP') ; ?>" name="Cd_PlanoERP"
                                                maxlength="11">
                                            </td>

                                            <td>
                                            <input type="text" class="form-control" id="Ds_Plano" value="<?php echo set_value('Ds_Plano') ; ?>" name="Ds_Plano"
                                                maxlength="128">
                                            </td>

                                            <td>
                                            <select class="form-control" id="Tp_AcomodacaoPadrao" name="Tp_AcomodacaoPadrao">
                                                <option value="" disabled selected>SELECIONE</option>
                                                <option value="1">Enfermaria</option>
                                                <option value="2">Apartamento</option>
                                            </select>
                                            </td>

                                            <td>
                                                <select class="form-control" id="TbIndice_Id_Indice" name="TbIndice_Id_Indice">
                                                    <option value="" disabled selected>SELECIONE</option>
                                                    <?php
                                                    if(!empty($infoIndice))
                                                    {
                                                        foreach ($infoIndice as $indice)
                                                        {
                                                            ?>
                                                            <option value="<?php echo $indice->Id_Indice ?>">
                                                                <?php echo $indice->Id_Indice.' - '.$indice->Ds_indice ?>
                                                            </option>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </td>

                                            <td>
                                            <select class="form-control" id="TbRegra_Id_Regra" name="TbRegra_Id_Regra">
                                                <option value="" disabled selected>SELECIONE</option>
                                                <?php
                                                if(!empty($infoRegra))
                                                {
                                                    foreach ($infoRegra as $regra)
                                                    {
                                                        ?>
                                                        <option value="<?php echo $regra->Id_Regra ?>">
                                                            <?php echo $regra->Id_Regra.' - '.$regra->Ds_Regra ?>
                                                        </option>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                            </td>

                                            <td>
                                            <select class="form-control" id="Tp_Ativo_Plano" name="Tp_Ativo_Plano">
                                                <option value="S">Sim</option>
                                                <option value="N">Não</option>
                                            </select>
                                            </td>                                            
                                </tr>

                                <?php
                                if(!empty($infoPlano))
                                {
                                foreach ($infoPlano as $plano)
                                {
                                ?>
                                <tr style="background-color:#c0c0c0">                                    
                                    <td>
                                        <input type="text" class="form-control" value="<?php echo $plano->Id_Plano ?>" disabled>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" value="<?php echo $plano->Cd_PlanoERP ?>" disabled>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" value="<?php echo $plano->Ds_Plano ?>" disabled>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" value="<?php if ($plano->Tp_AcomodacaoPadrao == '1') { echo 'Enfermaria'; } else if ($plano->Tp_AcomodacaoPadrao == '2') { echo 'Apartamento'; } ?>" disabled>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" value="<?php echo $plano->TbIndice_Id_Indice.' - '.$plano->Ds_indice ?>" disabled>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" value="<?php echo $plano->TbRegra_Id_Regra.' - '.$plano->Ds_Regra ?>" disabled>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" value="<?php echo ($plano->Tp_Ativo == 'S') ? 'Sim' : 'Não'; ?>" disabled>
                                    </td>
                                    <td>
                                    <a class="btn btn-sm btn-info" href="<?php echo base_url().'principalPlano/editar/'.$plano->Id_Plano; ?>" title="Editar">
                                        <i class="fa fa-pencil"></i>
                                    </a>
                                    </td>
                                    <td>
                                    <a class="btn btn-sm btn-danger" href="<?php echo base_url().'apagaPlano_Sub/'.$plano->Id_Plano.'/'.$Id_Convenio; ?>" title="Excluir">
                                        <i class="fa fa-trash-o"></i>
                                    </a>
                                    </td>
                                    
                                </tr>
                                    <?php
                                }
                                }
                                ?>

                                </table>
                            </div>

                        </div>
                        <!-- /.box-body -->

                        <div class="box-footer">
                            <input type="button" class="btn btn-primary" onclick="window.location='<?php echo base_url(); ?>principalConvenio/listar';" value="Lista (CTRL+L)" name="IrLista" id="IrLista"/>
                            <input type="submit" class="btn btn-primary" value="Salva e lista (CTRL+S)" name="salvarIrLista" id="salvarIrLista" style="margin-left:5px;"/>
                            <input type="submit" class="btn btn-primary" value="Salva e cadastra outro convênio (CTRL+A)" name="salvarMesmaTela" id="salvarMesmaTela" style="margin-left:5px;<?php if ($this->uri->segment(2) == 'editar') { echo 'display:none'; } ?>"/>
                            <input type="submit" class="btn btn-primary" value="Salva e adiciona outro plano (CTRL+P)" name="salvarPlano" id="salvarPlano" style="margin-left:5px;"/>
                        <!--    <input type="submit" class="btn btn-primary" value="Salva e cadastra plano (CTRL+P)" name="salvarAvancar" id="salvarAvancar" style="margin-left:5px;<?php //if ($this->uri->segment(2) == 'editar') { echo 'display:none'; } ?>"/> -->
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
<script src="<?php echo base_url(); ?>assets/js/addConvenio.js" type="text/javascript"></script>
<script>

    $(document).ready(function(){
        $(":input").inputmask();
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
    shortcut.add("ctrl+p", function() {
        document.getElementById('salvarPlano').click();
    });

</script>