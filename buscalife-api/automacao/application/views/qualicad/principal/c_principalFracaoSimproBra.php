<?php

$Id_FracaoSimproBra = '';
$TbProFat_Cd_ProFat = '';
$TbFaturamento_Id_Faturamento  = '';
$TbTUSS_Id_Tuss  = '';

$Ds_FracaoSimproBra = '';
$Ds_Laboratorio = '';
$Ds_Apresentacao = '';
$Tp_MatMed = '';
$Vl_FatorDivisao = '';
$Qt_Prod = '';
$Tp_Ativo = '';

if ($this->uri->segment(2) == 'editar') {
if(!empty($infoFracaoSimproBra))
{
    foreach ($infoFracaoSimproBra as $r)
    {
        $Id_FracaoSimproBra = $r->Id_FracaoSimproBra;
        $TbProFat_Cd_ProFat = $r->TbProFat_Cd_ProFat;
        $TbFaturamento_Id_Faturamento = $r->TbFaturamento_Id_Faturamento;
        $TbTUSS_Id_Tuss = $r->TbTUSS_Id_Tuss;
        $Ds_FracaoSimproBra = $r->Ds_FracaoSimproBra;
        $Ds_Laboratorio = $r->Ds_Laboratorio;
        $Ds_Apresentacao = $r->Ds_Apresentacao;
        $Tp_MatMed = $r->Tp_MatMed;
        $Vl_FatorDivisao = $r->Vl_FatorDivisao;
        $Qt_Prod = $r->Qt_Prod;
        $Tp_Ativo = $r->Tp_Ativo;
    }
}
}

?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-users"></i> <?php echo ($this->uri->segment(2) == 'cadastrar') ? 'Cadastrar Fração Mat/Med' : 'Editar Fração Mat/Med' ; ?>
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
                    <form role="form" id="addFracaoSimproBra" action="<?php echo ($this->uri->segment(2) == 'cadastrar') ? base_url().'adicionaFracaoSimproBra' : base_url().'editaFracaoSimproBra'; ?>" method="post" role="form">
                        <div class="box-body">

                        <div class="row" style="display: inline-block;width: 98%;height: 100%;margin: 0.15rem;padding-top: 0.85rem;padding-left:1rem;padding-right:1rem;
                            background-color: #f5f5f5;padding-bottom:2rem">

                                <h4><strong>Fração Mat/Med</strong></h4>

                                <table style="width:100%;">
                                    <thead>
                                    <tr style="background-color:#e0e0e0">
                                        <th class="header-label" style="padding:10px">
                                        Id Seq
                                        </th>
                                        <th class="header-label" style="padding:10px">
                                        ProFat associado
                                        </th>
                                        <th class="header-label" style="padding:10px">
                                        Faturamento associado
                                        </th>                                        
                                        <th class="header-label" style="padding:10px">
                                        TUSS associada
                                        </th>
                                        <th class="header-label" style="padding:10px">
                                        Descrição Fração Mat/Med
                                        </th>
                                        <th class="header-label" style="padding:10px">
                                        Descrição laboratório
                                        </th>
                                        <th class="header-label" style="padding:10px">
                                        Descrição apresentação
                                        </th>
                                        <th class="header-label" style="padding:10px">
                                        Tipo MatMed
                                        </th>
                                        <th class="header-label" style="padding:10px">
                                        Valor do fator de divisão
                                        </th>
                                        <th class="header-label" style="padding:10px">
                                        Qtd. de produção
                                        </th>
                                        <th class="header-label" style="padding:10px">
                                        Ativo?
                                        </th>
                                    </tr>
                                </thead>
                                <tr id="row0">
                                            <td style="width:5%!important">
                                            <input type="text" class="form-control required" value="<?php echo ($this->uri->segment(2) == 'cadastrar') ? set_value('Id_FracaoSimproBra') : $Id_FracaoSimproBra ; ?>" id="Id_FracaoSimproBra" name="Id_FracaoSimproBra" disabled>
                                            </td>

                                            <td style="width:10%">
                                            <select class="form-control required" id="TbProFat_Cd_ProFat" name="TbProFat_Cd_ProFat" required>
                                            <option value="" disabled selected>SELECIONE</option>
                                            <?php
                                            if(!empty($infoProFat))
                                            {
                                                foreach ($infoProFat as $proFat)
                                                {
                                                    ?>
                                                <option value="<?php echo $proFat->Cd_ProFat ?>" <?php if ($this->uri->segment(2) == 'editar' && $proFat->Cd_ProFat == $TbProFat_Cd_ProFat) { echo 'selected'; } ?>>
                                                    <?php echo $proFat->Cd_ProFat.' - '.$proFat->Ds_ProFat ?>
                                                </option>
                                                <?php
                                                }
                                            }
                                            ?>
                                            </select>
                                            <input type="hidden" value="<?php echo $Id_FracaoSimproBra; ?>" name="Id_FracaoSimproBra" id="Id_FracaoSimproBra" /> 
                                            </td>

                                            <td style="width:10%">
                                            <select class="form-control required" id="TbFaturamento_Id_Faturamento" name="TbFaturamento_Id_Faturamento" required>
                                            <option value="" disabled selected>SELECIONE</option>
                                            <?php
                                            if(!empty($infoFaturamento))
                                            {
                                                foreach ($infoFaturamento as $faturamento)
                                                {
                                                    ?>
                                                <option value="<?php echo $faturamento->Id_Faturamento ?>" <?php if ($this->uri->segment(2) == 'editar' && $faturamento->Id_Faturamento  == $TbFaturamento_Id_Faturamento) { echo 'selected'; } ?>>
                                                    <?php echo $faturamento->Id_Faturamento.' - '.$faturamento->Ds_Faturamento ?>
                                                </option>
                                                <?php
                                                }
                                            }
                                            ?>
                                            </select>
                                            </td>

                                            <td style="width:10%">
                                            <select class="form-control required" id="TbTUSS_Id_Tuss" name="TbTUSS_Id_Tuss" required>
                                            <option value="" disabled selected>SELECIONE</option>
                                            <?php
                                            if(!empty($infoTUSS))
                                            {
                                                foreach ($infoTUSS as $tuss)
                                                {
                                                    ?>
                                                <option value="<?php echo $tuss->Id_Tuss ?>" <?php if ($this->uri->segment(2) == 'editar' && $tuss->Id_Tuss == $TbTUSS_Id_Tuss) { echo 'selected'; } ?>>
                                                    <?php echo $tuss->Id_Tuss.' - '.$tuss->Ds_Tuss ?>
                                                </option>
                                                <?php
                                                }
                                            }
                                            ?>
                                            </select>
                                            </td>

                                            <td>
                                            <input type="text" class="form-control required" value="<?php echo ($this->uri->segment(2) == 'cadastrar') ? set_value('Ds_FracaoSimproBra') : $Ds_FracaoSimproBra ; ?>" id="Ds_FracaoSimproBra" name="Ds_FracaoSimproBra"
                                            maxlength="128">
                                            </td>

                                            <td>
                                            <input type="text" class="form-control required" value="<?php echo ($this->uri->segment(2) == 'cadastrar') ? set_value('Ds_Laboratorio') : $Ds_Laboratorio ; ?>" id="Ds_Laboratorio" name="Ds_Laboratorio"
                                            maxlength="128">
                                            </td>

                                            <td>
                                            <input type="text" class="form-control required" value="<?php echo ($this->uri->segment(2) == 'cadastrar') ? set_value('Ds_Apresentacao') : $Ds_Apresentacao ; ?>" id="Ds_Apresentacao" name="Ds_Apresentacao"
                                            maxlength="128">
                                            </td>

                                            <td style="width:10%">
                                            <select class="form-control required" id="Tp_MatMed" name="Tp_MatMed" required>
                                            <option value="" disabled selected>SELECIONE</option>
                                            <option value="MED" <?php if ($this->uri->segment(2) == 'editar' && $Tp_MatMed == 'MED') { echo 'selected'; } ?>>MED</option>
                                            <option value="MAT" <?php if ($this->uri->segment(2) == 'editar' && $Tp_MatMed == 'MAT') { echo 'selected'; } ?>>MAT</option>
                                            <option value="SOL" <?php if ($this->uri->segment(2) == 'editar' && $Tp_MatMed == 'SOL') { echo 'selected'; } ?>>SOL</option>
                                            </select>
                                            </td>
                                            
                                            <td>
                                            <input type="text" class="form-control required valor" value="<?php echo ($this->uri->segment(2) == 'cadastrar') ? set_value('Vl_FatorDivisao') : $Vl_FatorDivisao ; ?>" id="Vl_FatorDivisao" name="Vl_FatorDivisao"
                                            maxlength="11">
                                            </td>

                                            <td>
                                            <input type="text" class="form-control required" value="<?php echo ($this->uri->segment(2) == 'cadastrar') ? set_value('Qt_Prod') : $Qt_Prod ; ?>" id="Qt_Prod" name="Qt_Prod"
                                            maxlength="11">
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
                            <input type="button" class="btn btn-primary" onclick="window.location='<?php echo base_url(); ?>principalFracaoSimproBra/listar';" value="Lista (CTRL+L)" name="IrLista" id="IrLista"/>
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
<script src="<?php echo base_url(); ?>assets/js/addFracaoSimproBra.js" type="text/javascript"></script>
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