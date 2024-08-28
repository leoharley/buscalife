<?php

$Id_Regra = '';
$Ds_Regra = '';
$Tp_Ativo = '';

if ($this->uri->segment(2) == 'editar') {
if(!empty($infoRegra))
{
    foreach ($infoRegra as $r)
    {
        $Id_Regra = $r->Id_Regra;
        $Ds_Regra = $r->Ds_Regra;
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

    .grade {
        border: #b0b0b0 0.5px solid; 
        padding: 5px;
    }

</style>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-users"></i> <?php echo ($this->uri->segment(2) == 'cadastrar') ? 'Cadastrar Regra' : 'Editar Regra' ; ?>
            <small><?php echo ($this->uri->segment(2) == 'cadastrar') ? 'Adicionar' : 'Editar' ; ?></small>
        </h1>
    </section>

    <section class="content" ng-app="appPrincipal" ng-controller="entercontroller">

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
                    <form role="form" id="addRegra" action="<?php echo ($this->uri->segment(2) == 'cadastrar') ? base_url().'adicionaRegra' : base_url().'editaRegra'; ?>" method="post" role="form">
                        <div class="box-body" style="padding-left:1rem;padding-right:1rem">
                            
                        
                        <div class="row" style="display: inline-block;width: 98%;height: 100%;margin: 0.15rem;padding-top: 0.85rem;padding-left:1rem;padding-right:1rem;
                            background-color: #f5f5f5;padding-bottom:2rem">

                                <h4><strong>Regra</strong></h4>

                                <table style="width:100%;">
                                    <thead>
                                    <tr style="background-color:#e0e0e0">
                                        <th class="header-label" style="padding:10px">
                                        Id Seq
                                        </th>
                                        <th class="header-label" style="padding:10px">
                                        Regra (descrição)
                                        </th>
                                        <th class="header-label" style="padding:10px">
                                        Regra ativa?
                                        </th>                                        
                                    </tr>
                                </thead>
                                <tr id="row0">
                                    
                                            <td style="width:15%">
                                            <input type="text" class="form-control required" value="<?php echo ($this->uri->segment(2) == 'cadastrar') ? set_value('Id_Regra') : $Id_Regra ; ?>" id="Id_Regra" name="Id_Regra" disabled>
                                            <input type="hidden" value="<?php echo $Id_Regra; ?>" name="Id_Regra" id="Id_Regra" /> 
                                            </td>

                                            <td>
                                            <input type="text" class="form-control required" value="<?php echo ($this->uri->segment(2) == 'cadastrar') ? set_value('Ds_Regra') : $Ds_Regra ; ?>" id="Ds_Regra" name="Ds_Regra" maxlength="128">
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
                         

                            <div class="row" style="display: inline-block;width: 98%;height: 100%;margin: 0.15rem;padding-top: 0.85rem;padding-left:1rem;padding-right:1rem;
                            background-color: #f5f5f5;padding-bottom:2rem">

                                <h4><strong>Regra Grupo</strong></h4>

                                <table id="dataTables-example" style="width:100%;">
                                    <thead>
                                    <tr style="background-color:#e0e0e0">
                                        <th class="header-label" style="padding:10px">
                                        Id Seq
                                        </th>
                                        <th class="header-label" style="padding:10px">
                                        Tp Grupo Pro
                                        </th>
                                        <th class="header-label" style="padding:10px">
                                        Grupo pro associado
                                        </th>
                                        <th class="header-label" style="padding:10px">
                                        Faturamento associado
                                        </th>                                        
                                        <th class="header-label" style="padding:10px">
                                        Percentual pago
                                        </th>
                                        <th class="header-label" style="padding:10px">
                                        Início da vigência
                                        </th>
                                        <th class="header-label" style="padding:10px">
                                        Fim da vigência
                                        </th>
                                        <th class="header-label" style="padding:10px">
                                        Fatura NF
                                        </th>
                                        <th class="header-label" style="padding:10px">
                                        Cobrança por TISS
                                        </th>
                                        <th class="header-label" style="padding:10px">
                                        Ativo?
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                <tr id="row0">

                                            <td style="width:8%!important">
                                            <input type="text" class="form-control" value="<?php echo set_value('Id_RegraGruPro'); ?>" id="Id_RegraGruPro" name="Id_RegraGruPro" disabled>
                                            </td>

                                            <td style="width:10%">
                                                <select class="form-control" name="Tp_GrupoPro" ng-model="Tp_GrupoPro" ng-init="Tp_GrupoPro='SELECIONE'" ng-disabled="TbGrupoPro_CodGrupo!=='SELECIONE'">
                                                    <option value="SELECIONE">SELECIONE</option>
                                                    <option value="MD">MD</option>
                                                    <option value="MT">MT</option>
                                                    <option value="OP">OP</option>
                                                    <option value="SH">SH</option>
                                                    <option value="SP">SP</option>
                                                    <option value="SD">SD</option>
                                                </select>
                                            </td>

                                            <td>
                                                <select class="form-control" name="TbGrupoPro_CodGrupo" ng-selected="SELECIONE" ng-init="TbGrupoPro_CodGrupo='SELECIONE'" ng-model="TbGrupoPro_CodGrupo" ng-disabled="Tp_GrupoPro!=='SELECIONE'">
                                                    <option value="SELECIONE">SELECIONE</option>
                                                    <?php
                                                    if(!empty($infoGrupoPro))
                                                    {
                                                        foreach ($infoGrupoPro as $grupopro)
                                                        {
                                                            ?>
                                                            <option value="<?php echo $grupopro->CodGrupoPro ?>">
                                                                <?php echo $grupopro->CodGrupoPro .' - '.$grupopro->Ds_GrupoPro ?>
                                                            </option>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </td>

                                            <td>
                                            <select class="form-control" id="TbFaturamento_Id_Faturamento" name="TbFaturamento_Id_Faturamento">
                                                <option value="" disabled selected>SELECIONE</option>
                                                <?php
                                                if(!empty($infoFaturamento))
                                                {
                                                    foreach ($infoFaturamento as $faturamento)
                                                    {
                                                        ?>
                                                        <option value="<?php echo $faturamento->Id_Faturamento ?>">
                                                            <?php echo $faturamento->Id_Faturamento.' - '.$faturamento->Ds_Faturamento ?>
                                                        </option>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                            </td>

                                            <td>
                                                <input type="text" class="form-control valor" id="Perc_Pago" value="<?php echo set_value('Perc_Pago'); ?>" name="Perc_Pago"
                                                       maxlength="13">
                                            </td>

                                            <td>
                                                <input type="date" class="form-control" value="<?php echo set_value('Dt_IniVigencia'); ?>" id="Dt_IniVigencia" name="Dt_IniVigencia">
                                            </td>

                                            <td>
                                                <input type="date" class="form-control" value="<?php echo set_value('Dt_FimVigencia'); ?>" id="Dt_FimVigencia" name="Dt_FimVigencia">
                                            </td>

                                            <td>
                                                <input type="text" class="form-control" id="sn_faturanf" value="<?php echo set_value('sn_faturanf'); ?>" name="sn_faturanf"
                                                       maxlength="2">
                                            </td>

                                            <td>
                                                <input type="text" class="form-control" id="sn_cobrancatiss" value="<?php echo set_value('sn_cobrancatiss'); ?>" name="sn_cobrancatiss"
                                                       maxlength="2">
                                            </td>

                                            <td>
                                                <select class="form-control" id="Tp_Ativo_RegraGruPro" name="Tp_Ativo_RegraGruPro">
                                                    <option value="S">Sim</option>
                                                    <option value="N">Não</option>
                                                </select>
                                            </td>

                                </tr>

                                <?php
                                if(!empty($infoRegraGruPro))
                                {
                                foreach ($infoRegraGruPro as $regragrupro)
                                {
                                ?>
                                <tr style="background-color:#c0c0c0">
                                    <td class="grade">
                                        <span> <?= $regragrupro->Id_RegraGruPro ?> </span>                                        
                                    </td>
                                    <td class="grade">
                                        <span> <?= $regragrupro->Tp_GrupoPro ?> </span>                                        
                                    </td>
                                    <td class="grade">
                                        <span> <?= $regragrupro->CodGrupoPro .' - '.$regragrupro->Ds_GrupoPro ?> </span>                                        
                                    </td>
                                    <td class="grade">
                                        <span> <?= $regragrupro->Id_Faturamento .' - '.$regragrupro->Ds_Faturamento ?> </span>                                        
                                    </td>
                                    <td class="grade">
                                        <span id="perc"> <?= $regragrupro->Perc_Pago ?> </span>                                      
                                    </td>
                                    <td class="grade">
                                        <span> <?= ($regragrupro->Dt_IniVigencia != null) ? date("d/m/Y", strtotime($regragrupro->Dt_IniVigencia)) : ''; ?> </span>
                                    </td>
                                    <td class="grade">
                                        <span> <?= ($regragrupro->Dt_FimVigencia != null) ? date("d/m/Y", strtotime($regragrupro->Dt_FimVigencia)) : ''; ?> </span>
                                    </td>
                                    <td class="grade">
                                        <span> <?= $regragrupro->sn_faturanf ?> </span>
                                    </td>
                                    <td class="grade">
                                        <span> <?= $regragrupro->sn_cobrancatiss ?> </span>
                                    </td>
                                    <td class="grade">
                                        <span> <?= ($regragrupro->Tp_Ativo == 'S') ? 'Sim' : 'Não'; ?> </span>
                                    </td>
                                    <td class="grade">
                                    <a class="btn btn-sm btn-info" href="<?php echo base_url().'principalRegraGruPro/editar/'.$regragrupro->Id_RegraGruPro; ?>" title="Editar">
                                        <i class="fa fa-pencil"></i>
                                    </a>
                                    </td>
                                    <td class="grade">
                                    <a class="btn btn-sm btn-danger" href="<?php echo base_url().'apagaRegraGruPro_Sub/'.$regragrupro->Id_RegraGruPro.'/'.$Id_Regra; ?>" title="Excluir">
                                        <i class="fa fa-trash-o"></i>
                                    </a>
                                    </td>
                                </tr>
                                    <?php
                                }
                                }
                                ?>
                                </tbody>
                                </table>
                            </div>

                        </div>
                        <!-- /.box-body -->

                        <div class="box-footer">
                            <input type="button" class="btn btn-primary" onclick="window.location='<?php echo base_url(); ?>principalRegra/listar';" value="Lista (CTRL+L)" name="IrLista" id="IrLista"/>
                            <input type="submit" class="btn btn-primary" value="Salva e lista (CTRL+S)" name="salvarIrLista" id="salvarIrLista" style="margin-left:5px;"/>
                            <input type="submit" class="btn btn-primary" value="Salva e cadastra novamente (CTRL+A)" name="salvarMesmaTela" id="salvarMesmaTela" style="margin-left:5px;<?php if ($this->uri->segment(2) == 'editar') { echo 'display:none'; } ?>"/>
                            <input type="submit" class="btn btn-primary" value="Salva e adiciona outro regra grupro (CTRL+P)" name="salvarRegraGruPro" id="salvarRegraGruPro" style="margin-left:5px;"/>
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
<script src="<?php echo base_url(); ?>assets/js/addRegra.js" type="text/javascript"></script>

<script>
$(document).ready(function(){
    //    $(":input").inputmask();
        $('.valor').maskMoney({precision:4,thousands:'.', decimal:','});
        document.getElementById("perc").focus();
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
        document.getElementById('salvarRegraGruPro').click();
    });
</script>

<script !src="">
    var app = angular.module('appPrincipal', []);
    app.controller('entercontroller', function ($scope, $http) {
        console.log('success');
    });
</script>