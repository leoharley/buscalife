<?php

$Id_Faturamento = '';
$Ds_Faturamento = '';
$Tp_Faturamento = '';
$Tp_TabFat = '';
$Tp_Ativo = '';

if ($this->uri->segment(2) == 'editar') {
if(!empty($infoFaturamento))
{
    foreach ($infoFaturamento as $r)
    {
        $Id_Faturamento = $r->Id_Faturamento;
        $Ds_Faturamento = $r->Ds_Faturamento;
        $Tp_Faturamento = $r->Tp_Faturamento;
        $Tp_TabFat = $r->Tp_TabFat;
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
            <i class="fa fa-users"></i> <?php echo ($this->uri->segment(2) == 'cadastrar') ? 'Cadastrar Faturamento' : 'Editar Faturamento' ; ?>
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
                    <form role="form" id="addFaturamento" action="<?php echo ($this->uri->segment(2) == 'cadastrar') ? base_url().'adicionaFaturamento' : base_url().'editaFaturamento'; ?>" method="post" role="form">
                        <div class="box-body" style="padding-left:1rem;padding-right:1rem">
                            
                        
                        <div class="row" style="display: inline-block;width: 98%;height: 100%;margin: 0.15rem;padding-top: 0.85rem;padding-left:1rem;padding-right:1rem;
                            background-color: #f5f5f5;padding-bottom:2rem">

                                <h4><strong>Faturamento</strong></h4>

                                <table style="width:100%;">
                                    <thead>
                                    <tr style="background-color:#e0e0e0">
                                        <th class="header-label" style="padding:10px">
                                        Código
                                        </th>
                                        <th class="header-label" style="padding:10px">
                                        Faturamento (descrição)
                                        </th>
                                        <th class="header-label" style="padding:10px">
                                        Tipo de faturamento
                                        </th>
                                        <th class="header-label" style="padding:10px">
                                        Tabela de Faturamento
                                        </th>                                      
                                        <th class="header-label" style="padding:10px">
                                        Faturamento ativo?
                                        </th>
                                    </tr>
                                </thead>
                                <tr id="row0">
                                    <td style="width:12%">
                                    <input type="text" class="form-control required" value="<?php echo ($this->uri->segment(2) == 'cadastrar') ? set_value('Id_Faturamento') : $Id_Faturamento ; ?>" id="Id_Faturamento" name="Id_Faturamento" disabled>
                                    </td>

                                    <td>
                                    <input type="text" class="form-control required" value="<?php echo ($this->uri->segment(2) == 'cadastrar') ? set_value('Ds_Faturamento') : $Ds_Faturamento ; ?>" id="Ds_Faturamento" name="Ds_Faturamento" maxlength="128">
                                    <input type="hidden" value="<?php echo $Id_Faturamento; ?>" name="Id_Faturamento" id="Id_Faturamento" /> 
                                    </td>

                                    <td>
                                    <select class="form-control required" id="Tp_Faturamento" name="Tp_Faturamento" required>
                                    <option value="" disabled selected>SELECIONE</option>
                                    <option value="REAIS" <?php if ($this->uri->segment(2) == 'editar' && $Tp_Faturamento == 'REAIS') { echo 'selected'; } ?>>Reais</option>
                                    <option value="CH" <?php if ($this->uri->segment(2) == 'editar' && $Tp_Faturamento == 'CH') { echo 'selected'; } ?>>CH</option>
                                    <option value="CBHPM" <?php if ($this->uri->segment(2) == 'editar' && $Tp_Faturamento == 'CBHPM') { echo 'selected'; } ?>>CBHPM</option>
                                    </select>
                                    </td>

                                    <td>
                                    <select class="form-control" id="Tp_TabFat" name="Tp_TabFat">
                                    <option value="" disabled selected>SELECIONE</option>
                                    <option value="SPFB" <?php if ($this->uri->segment(2) == 'editar' && $Tp_TabFat == 'SPFB') { echo 'selected'; } ?>>SPFB – Simpro Preço Fábrica</option>
                                    <option value="SPMC" <?php if ($this->uri->segment(2) == 'editar' && $Tp_TabFat == 'SPMC') { echo 'selected'; } ?>>SPMC – Simpro Preço Medio Consumidor</option>
                                    <option value="SPCO" <?php if ($this->uri->segment(2) == 'editar' && $Tp_TabFat == 'SPCO') { echo 'selected'; } ?>>SPCO – Simpro Preço Congelado</option>
                                    <option value="BPMC" <?php if ($this->uri->segment(2) == 'editar' && $Tp_TabFat == 'BPMC') { echo 'selected'; } ?>>BPMC – Brasindice Preço Medio Consumidor</option>
                                    <option value="BPFB" <?php if ($this->uri->segment(2) == 'editar' && $Tp_TabFat == 'BPFB') { echo 'selected'; } ?>>BPFB – Brasindice preço Fabrica</option>
                                    <option value="BPCO" <?php if ($this->uri->segment(2) == 'editar' && $Tp_TabFat == 'BPCO') { echo 'selected'; } ?>>BPCO – Brasindice Preço Congelado</option>
                                    <option value="PROP" <?php if ($this->uri->segment(2) == 'editar' && $Tp_TabFat == 'PROP') { echo 'selected'; } ?>>PROP – Própria</option>
                                    <option value="" <?php if ($this->uri->segment(2) == 'editar' && $Tp_TabFat == '') { echo 'selected'; } ?>>EM BRANCO</option>
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

                            <div class="row" style="display: inline-block;width: 98%;height: 100%;margin: 0.15rem;padding-top: 0.85rem;padding-left:1rem;padding-right:1rem;
                            background-color: #f5f5f5;padding-bottom:2rem;">

                                <h4><strong>Faturamento Item</strong></h4>

                                <div class="table-responsive">
                                <table id="dataTables-example" style="overflow-x:auto;width:150%!important;">
                                    <thead>
                                    <tr style="background-color:#e0e0e0">
                                        <th class="header-label" style="padding:10px">
                                        Ações
                                        </th>
                                        <th class="header-label" style="padding:10px">
                                        Cd_TUSS
                                        </th>
                                        <th class="header-label" style="padding:10px">
                                        Cd_TISS
                                        </th>
                                        <th class="header-label" style="padding:10px">
                                        Descrição
                                        </th>
                                        <th class="header-label" style="padding:10px">
                                        Valor do honorário
                                        </th>
                                        <th class="header-label" style="padding:10px">
                                        Valor operacional
                                        </th>
                                        <th class="header-label" style="padding:10px">
                                        Valor total
                                        </th>
                                        <th class="header-label" style="padding:10px">
                                        Valor filme
                                        </th>
                                        <th class="header-label" style="padding:10px">
                                        Cd_PorteMedico
                                        </th>
                                        <th class="header-label" style="padding:10px">
                                        Início da vigência
                                        </th>
                                        <th class="header-label" style="padding:10px">
                                        Fim da vigência
                                        </th>
                                        <th class="header-label" style="padding:10px">
                                        Qt_Embalagem
                                        </th>
                                        <th class="header-label" style="padding:10px">
                                        Ds_Unidade
                                        </th>
                                        <th class="header-label" style="padding:10px">
                                        Ativo?
                                        </th>
                                    </tr>
                                </thead>
                                <tr id="row0">
                                            <td style="width:5%!important">
                                            </td>    
                                            <td style="width:12%!important">
                                           <!-- <select class="form-control" id="Cd_TUSS" name="Cd_TUSS">
                                            <option value="" disabled selected>SELECIONE</option>
                                            <?php
                                            /*if(!empty($infoTUSS))
                                            {
                                                foreach ($infoTUSS as $tuss)
                                                {
                                                    ?>
                                                <option value="<?php echo $tuss->Cd_Tuss ?>">
                                                    <?php echo $tuss->Cd_Tuss .' - '.$tuss->Ds_Tuss ?>
                                                </option>
                                                <?php
                                                }
                                            }*/
                                            ?>
                                            </select>-->
                                            <input type="text" class="form-control" value="<?php echo set_value('Cd_TUSS'); ?>" id="Cd_TUSS" name="Cd_TUSS">                                        
                                            </td>

                                            <td style="width:2%!important">
                                            <input type="text" class="form-control" value="<?php echo set_value('Cd_TISS'); ?>" id="Cd_TISS" name="Cd_TISS">
                                            </td>

                                            <td style="width:14%!important">
                                            <input type="text" class="form-control" id="Ds_FatItem" value="<?php echo set_value('Ds_FatItem'); ?>" name="Ds_FatItem"
                                               maxlength="128">
                                            </td>

                                            <td style="width:3%!important">
                                            <input type="text" class="form-control valor" value="<?php echo set_value('Vl_Honorário'); ?>" id="Vl_Honorário" name="Vl_Honorário"
                                               maxlength="11">
                                            </td>

                                            <td style="width:3%!important">
                                            <input type="text" class="form-control valor" value="<?php echo set_value('Vl_Operacional'); ?>" id="Vl_Operacional" name="Vl_Operacional"
                                               maxlength="11">
                                            </td>

                                            <td style="width:4%!important">
                                            <input type="text" class="form-control valor" value="<?php echo set_value('Vl_Total'); ?>" id="Vl_Total" name="Vl_Total"
                                               maxlength="11">
                                            </td>

                                            <td style="width:4%!important">
                                            <input type="text" class="form-control valor" value="<?php echo set_value('Vl_Filme'); ?>" id="Vl_Filme" name="Vl_Filme"
                                               maxlength="11">
                                            </td>

                                            <td>
                                            <select class="form-control" id="Cd_PorteMedico" name="Cd_PorteMedico">
                                            <option value="" disabled selected>SELECIONE</option>
                                            <?php
                                            if(!empty($infoPorteMedico))
                                            {
                                                foreach ($infoPorteMedico as $portemedico)
                                                {
                                                    ?>
                                                <option value="<?php echo $portemedico->Cd_PorteMedico ?>">
                                                    <?php echo $portemedico->Cd_PorteMedico .' - '.$portemedico->Ds_PorteMedico ?>
                                                </option>
                                                <?php
                                                }
                                            }
                                            ?>
                                            </select>                                            
                                            </td>

                                            <td style="width:4%!important">
                                            <input type="date" class="form-control" value="<?php echo set_value('Dt_IniVigencia'); ?>" id="Dt_IniVigencia" name="Dt_IniVigencia">
                                            </td>

                                            <td style="width:4%!important">
                                            <input type="date" class="form-control" value="<?php echo set_value('Dt_FimVigencia'); ?>" id="Dt_FimVigencia" name="Dt_FimVigencia">
                                            </td>                                            

                                            <td style="width:4%!important">
                                            <input type="text" class="form-control" value="<?php echo set_value('Qt_Embalagem'); ?>" id="Qt_Embalagem" name="Qt_Embalagem">
                                            </td>

                                            <td>
                                            <input type="text" class="form-control" value="<?php echo set_value('Ds_Unidade'); ?>" id="Ds_Unidade" name="Ds_Unidade">
                                            </td>

                                            <td style="width:3%!important">
                                            <select class="form-control" id="Tp_Ativo_FatItem" name="Tp_Ativo_FatItem">
                                            <option value="S">Sim</option>
                                            <option value="N">Não</option>
                                            </select>
                                            </td>
                                </tr>

                                <?php
                                if(!empty($infoFatItem))
                                {
                                foreach ($infoFatItem as $fatitem)
                                {
                                ?>
                                <tr style="background-color:#c0c0c0">
                                    <td>
                                    <a class="btn btn-sm btn-info" href="<?php echo base_url().'principalFaturamentoItem/editar/'.$fatitem->Id_FatItem; ?>" title="Editar">
                                        <i class="fa fa-pencil"></i>
                                    </a>
                                    <a class="btn btn-sm btn-danger" href="<?php echo base_url().'apagaFaturamentoItem_Sub/'.$fatitem->Id_FatItem.'/'.$Id_Faturamento; ?>" title="Excluir">
                                        <i class="fa fa-trash-o"></i>
                                    </a>
                                    </td>
                                    <td>
                                    <input type="text" class="form-control" value="<?php echo $fatitem->Cd_Tuss. '-' .$fatitem->Ds_Tuss ?>" disabled>
                                    </td>
                                    <td>
                                    <input type="text" class="form-control" value="<?php echo $fatitem->Cd_TISS ?>" disabled>
                                    </td>
                                    <td>
                                    <input type="text" class="form-control" value="<?php echo $fatitem->Ds_FatItem ?>" disabled>
                                    </td>
                                    <td>
                                    <input type="text" class="form-control" value="<?php echo $fatitem->Vl_Honorário ?>" disabled>
                                    </td>
                                    <td>
                                    <input type="text" class="form-control" value="<?php echo $fatitem->Vl_Operacional ?>" disabled>
                                    </td>
                                    <td>
                                    <input type="text" class="form-control" value="<?php echo $fatitem->Vl_Total ?>" disabled>
                                    </td>
                                    <td>
                                    <input type="text" class="form-control" value="<?php echo $fatitem->Vl_Filme ?>" disabled>
                                    </td>
                                    <td>
                                    <input type="text" class="form-control" value="<?php echo $fatitem->Cd_PorteMedico. '-' .$fatitem->Ds_PorteMedico ?>" disabled>
                                    </td>
                                    <td>
                                    <input type="text" class="form-control" value="<?php echo $fatitem->Dt_IniVigencia ?>" disabled>
                                    </td>
                                    <td>
                                    <input type="text" class="form-control" value="<?php echo $fatitem->Dt_FimVigencia ?>" disabled>
                                    </td>
                                    <td>
                                    <input type="text" class="form-control" value="<?php echo $fatitem->Qt_Embalagem ?>" disabled>
                                    </td>
                                    <td>
                                    <input type="text" class="form-control" value="<?php echo $fatitem->Ds_Unidade ?>" disabled>
                                    </td>
                                    <td>
                                    <input type="text" class="form-control" value="<?php echo ($fatitem->Tp_Ativo == 'S') ? 'Sim' : 'Não'; ?>" disabled>
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
                            <input type="button" class="btn btn-primary" onclick="window.location='<?php echo base_url(); ?>principalFaturamento/listar';" value="Lista (CTRL+L)" name="IrLista" id="IrLista"/>
                            <input type="submit" class="btn btn-primary" value="Salva e lista (CTRL+S)" name="salvarIrLista" id="salvarIrLista" style="margin-left:5px;"/>
                            <input type="submit" class="btn btn-primary" value="Salva e cadastra novamente (CTRL+A)" name="salvarMesmaTela" id="salvarMesmaTela" style="margin-left:5px;<?php if ($this->uri->segment(2) == 'editar') { echo 'display:none'; } ?>"/>
                            <input type="submit" class="btn btn-primary" value="Salva e adiciona outro item (CTRL+P)" name="salvarFatItem" id="salvarFatItem" style="margin-left:5px;"/>
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
<script src="<?php echo base_url(); ?>assets/js/addFaturamento.js" type="text/javascript"></script>
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
    shortcut.add("ctrl+p", function() {
        document.getElementById('salvarFatItem').click();
    });
</script>