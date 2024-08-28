<?php

$Id_RegraGruPro = '';
$Tp_GrupoPro = '';
$TbGrupoPro_CodGrupo = '';
$TbRegra_Id_Regra = '';
$TbFaturamento_Id_Faturamento = '';
$Perc_Pago = '';
$Dt_IniVigencia = '';
$Dt_FimVigencia = '';
$sn_faturanf = '';
$sn_cobrancatiss = '';
$Tp_Ativo = '';

if ($this->uri->segment(2) == 'editar') {
    if(!empty($infoRegraGruPro))
    {
        foreach ($infoRegraGruPro as $r)
        {
            $Id_RegraGruPro = $r->Id_RegraGruPro;
            $Tp_GrupoPro = $r->Tp_GrupoPro;
            $TbGrupoPro_CodGrupo = $r->TbGrupoPro_CodGrupo;
            $TbRegra_Id_Regra = $r->TbRegra_Id_Regra;
            $TbFaturamento_Id_Faturamento = $r->TbFaturamento_Id_Faturamento;
            $Perc_Pago = $r->Perc_Pago;
            $Dt_IniVigencia = $r->Dt_IniVigencia;
            $sn_faturanf = $r->sn_faturanf;
            $sn_cobrancatiss = $r->sn_cobrancatiss;
            $Tp_Ativo = $r->Tp_Ativo;
        }
    }
}

?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-users"></i> <?php echo ($this->uri->segment(2) == 'cadastrar') ? 'Cadastrar Regra GruPro' : 'Editar Regra GruPro' ; ?>
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
                    <form role="form" id="addRegraGruPro" action="<?php echo ($this->uri->segment(2) == 'cadastrar') ? base_url().'adicionaRegraGruPro' : base_url().'editaRegraGruPro'; ?>" method="post" role="form">
                        <div class="box-body">

                        <div class="row" style="display: inline-block;width: 98%;height: 100%;margin: 0.15rem;padding-top: 0.85rem;padding-left:1rem;padding-right:1rem;
                            background-color: #f5f5f5;padding-bottom:2rem">

                                <h4><strong>Regra GruPro</strong></h4>

                                <table style="width:100%;">
                                    <thead>
                                    <tr style="background-color:#e0e0e0">
                                        <th class="header-label" style="padding:10px">
                                        Id Seq
                                        </th>
                                        <th class="header-label" style="padding:10px">
                                        Tp Grupo Pro
                                        </th>
                                        <th class="header-label" style="padding:10px">
                                        GrupoPro
                                        </th>
                                        <th class="header-label" style="padding:10px">
                                        Regra
                                        </th>                                        
                                        <th class="header-label" style="padding:10px">
                                        Faturamento
                                        </th>
                                        <th class="header-label" style="padding:10px">
                                        Percentual pago
                                        </th>
                                        <th class="header-label" style="padding:10px">
                                        Ínicio
                                        </th>
                                        <th class="header-label" style="padding:10px">
                                        Vigência
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
                                <tr id="row0">
                                            <td style="width:5%!important;">
                                            <input type="text" class="form-control required" value="<?php echo ($this->uri->segment(2) == 'cadastrar') ? set_value('Id_RegraGruPro') : $Id_RegraGruPro ; ?>" id="Id_RegraGruPro" name="Id_RegraGruPro" disabled>
                                            </td>

                                            <td style="width:10%">
                                                <select class="form-control required" id="Tp_GrupoPro" name="Tp_GrupoPro" disabled>
                                                    <option value="" disabled selected>SELECIONE</option>
                                                    <option value="MD" <?php if ($Tp_GrupoPro == 'MD') { echo 'selected'; } ?>>MD</option>
                                                    <option value="MT" <?php if ($Tp_GrupoPro == 'MT') { echo 'selected'; } ?>>MT</option>
                                                    <option value="OP" <?php if ($Tp_GrupoPro == 'OP') { echo 'selected'; } ?>>OP</option>
                                                    <option value="SH" <?php if ($Tp_GrupoPro == 'SH') { echo 'selected'; } ?>>SH</option>
                                                    <option value="SP" <?php if ($Tp_GrupoPro == 'SP') { echo 'selected'; } ?>>SP</option>
                                                    <option value="SD" <?php if ($Tp_GrupoPro == 'SD') { echo 'selected'; } ?>>SD</option>
                                                </select>
                                                <input type="hidden" value="<?php echo $Id_RegraGruPro; ?>" name="Id_RegraGruPro" id="Id_RegraGruPro" />     
                                            </td>

                                            <td>
                                            <select class="form-control required" id="TbGrupoPro_CodGrupo" name="TbGrupoPro_CodGrupo" disabled>
                                            <option value="" disabled selected>SELECIONE</option>
                                            <?php
                                            if(!empty($infoGrupoPro))
                                            {
                                                foreach ($infoGrupoPro as $grupoPro)
                                                {
                                                    ?>
                                                    <option value="<?php echo $grupoPro->CodGrupoPro ?>" <?php if ($this->uri->segment(2) == 'editar' && $grupoPro->CodGrupoPro == $TbGrupoPro_CodGrupo) { echo 'selected'; } ?>>
                                                        <?php echo $grupoPro->CodGrupoPro.' - '.$grupoPro->Ds_GrupoPro ?>
                                                    </option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                            </select>
                                            </td>


                                            <td style="width:10%">
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
                                            <select class="form-control required" id="TbFaturamento_Id_Faturamento" name="TbFaturamento_Id_Faturamento" required>
                                            <option value="" disabled selected>SELECIONE</option>
                                            <?php
                                            if(!empty($infoFaturamento))
                                            {
                                                foreach ($infoFaturamento as $faturamento)
                                                {
                                                    ?>
                                                    <option value="<?php echo $faturamento->Id_Faturamento ?>" <?php if ($this->uri->segment(2) == 'editar' && $faturamento->Id_Faturamento == $TbFaturamento_Id_Faturamento) { echo 'selected'; } ?>>
                                                        <?php echo $faturamento->Id_Faturamento.' - '.$faturamento->Ds_Faturamento ?>
                                                    </option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                            </select>
                                            </td>

                                            <td>
                                            <input type="text" class="form-control valor required" id="Perc_Pago" value="<?php echo ($this->uri->segment(2) == 'cadastrar') ? set_value('Perc_Pago') : $Perc_Pago ; ?>" name="Perc_Pago"
                                               maxlength="13">
                                            </td>

                                            <td>
                                            <input type="date" class="form-control required" value="<?php echo ($this->uri->segment(2) == 'cadastrar') ? set_value('Dt_IniVigencia') : $Dt_IniVigencia ; ?>" id="Dt_IniVigencia" name="Dt_IniVigencia">
                                            </td>

                                            <td>
                                            <input type="date" class="form-control" value="<?php echo ($this->uri->segment(2) == 'cadastrar') ? set_value('Dt_FimVigencia') : $Dt_FimVigencia ; ?>" id="Dt_FimVigencia" name="Dt_FimVigencia">
                                            </td>

                                            <td>
                                            <select class="form-control required" id="sn_faturanf" name="sn_faturanf">
                                            <option value="S" <?php if ($this->uri->segment(2) == 'editar' && $sn_faturanf == 'S') { echo 'selected'; } else if ($this->uri->segment(2) == 'cadastrar') { echo 'selected'; } ?>>Sim</option>
											<option value="N" <?php if ($this->uri->segment(2) == 'editar' && $sn_faturanf == 'N') { echo 'selected'; } ?>>Não</option>
                                            </select>
                                            </td>

                                            <td>
                                            <select class="form-control required" id="sn_cobrancatiss" name="sn_cobrancatiss">
                                            <option value="S" <?php if ($this->uri->segment(2) == 'editar' && $sn_cobrancatiss == 'S') { echo 'selected'; } else if ($this->uri->segment(2) == 'cadastrar') { echo 'selected'; } ?>>Sim</option>
											<option value="N" <?php if ($this->uri->segment(2) == 'editar' && $sn_cobrancatiss == 'N') { echo 'selected'; } ?>>Não</option>
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
                            <input type="button" class="btn btn-primary" onclick="window.location='<?php echo base_url(); ?>principalRegraGruPro/listar';" value="Lista (CTRL+L)" name="IrLista" id="IrLista" style="display:none"/>
                            <input type="submit" class="btn btn-primary" value="Salva e lista (CTRL+S)" name="salvarIrLista" id="salvarIrLista" style="margin-left:5px;display:none"/>
                            <input type="submit" class="btn btn-primary" value="Salva e cadastra outra regra grupro (CTRL+A)" name="salvarMesmaTela" id="salvarMesmaTela" style="margin-left:5px;<?php if ($this->uri->segment(2) == 'editar') { echo 'display:none'; } ?>"/>
                            <input type="submit" class="btn btn-primary" value="Salva e volta (CTRL+V)" name="salvareVoltar" id="salvareVoltar" style="margin-left:5px;<?php if ($this->uri->segment(2) == 'cadastrar') { echo 'display:none'; } ?>"/>
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
<script src="<?php echo base_url(); ?>assets/js/addRegraGruPro.js" type="text/javascript"></script>

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
    shortcut.add("ctrl+v", function() {
        document.getElementById('salvareVoltar').click();
    });

</script>