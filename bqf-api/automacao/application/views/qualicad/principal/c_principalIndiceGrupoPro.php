<?php

$Id_IndiceGrupo = '';
$TbGrupoPro_CodGrupo = '';
$TbIndice_Id_Indice  = '';

$Dt_IniVigencia = '';
$Dt_FimVigencia = '';
$Vl_Indice = '';
$Vl_M2Filme = '';
$Vl_Honorario = '';
$Vl_UCO = '';
$Tp_Ativo = '';

if ($this->uri->segment(2) == 'editar') {
if(!empty($infoIndiceGrupoPro))
{
    foreach ($infoIndiceGrupoPro as $r)
    {
        $Id_IndiceGrupo = $r->Id_IndiceGrupo;
        $TbGrupoPro_CodGrupo = $r->TbGrupoPro_CodGrupo;
        $TbIndice_Id_Indice = $r->TbIndice_Id_Indice;
        $Dt_IniVigencia = $r->Dt_IniVigencia;
        $Dt_FimVigencia = $r->Dt_FimVigencia;
        $Vl_Indice = $r->Vl_Indice;
        $Vl_M2Filme = $r->Vl_M2Filme;
        $Vl_Honorario = $r->Vl_Honorario;
        $Vl_UCO = $r->Vl_UCO;
        $Tp_Ativo = $r->Tp_Ativo;
    }
}
}

?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-users"></i> <?php echo ($this->uri->segment(2) == 'cadastrar') ? 'Cadastrar Índice por Grupo de Procedimento' : 'Editar Índice por Grupo de Procedimento' ; ?>
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
                    <form role="form" id="addIndiceGrupoPro" action="<?php echo ($this->uri->segment(2) == 'cadastrar') ? base_url().'adicionaIndiceGrupoPro' : base_url().'editaIndiceGrupoPro'; ?>" method="post" role="form">
                        <div class="box-body">
                            
                            <div class="row" style="display: inline-block;width: 98%;height: 100%;margin: 0.15rem;padding-top: 0.85rem;padding-left:1rem;padding-right:1rem;
                            background-color: #f5f5f5;padding-bottom:2rem">

                                <h4><strong>Índice Grupo Pro</strong></h4>

                                <table style="width:100%;">
                                    <thead>
                                    <tr style="background-color:#e0e0e0">
                                        <th class="header-label" style="padding:10px">
                                        Id Seq
                                        </th>
                                        <th class="header-label" style="padding:10px">
                                        Índice associado
                                        </th>
                                        <th class="header-label" style="padding:10px">
                                        Grupo associado
                                        </th>                                        
                                        <th class="header-label" style="padding:10px">
                                        Data de início da vigência
                                        </th>
                                        <th class="header-label" style="padding:10px">
                                        Data de fim da vigência
                                        </th>
                                        <th class="header-label" style="padding:10px">
                                        Valor índice
                                        </th>
                                        <th class="header-label" style="padding:10px">
                                        Valor M2 Filme
                                        </th>
                                        <th class="header-label" style="padding:10px">
                                        Valor honorário
                                        </th>
                                        <th class="header-label" style="padding:10px">
                                        Valor UCO
                                        </th>
                                        <th class="header-label" style="padding:10px">
                                        Índice por grupo ativo?
                                        </th>
                                    </tr>
                                </thead>
                                <tr id="row0">
                                            <td>
                                            <input type="text" class="form-control required" value="<?php echo ($this->uri->segment(2) == 'cadastrar') ? set_value('Id_IndiceGrupo') : $Id_IndiceGrupo ; ?>" id="Id_IndiceGrupo" name="Id_IndiceGrupo" disabled>
                                            </td>

                                            <td style="width:10%">
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
                                            <input type="hidden" value="<?php echo $Id_IndiceGrupo; ?>" name="Id_IndiceGrupo" id="Id_IndiceGrupo" /> 
                                            </td>

                                            <td>
                                            <select class="form-control required" id="TbGrupoPro_CodGrupo" name="TbGrupoPro_CodGrupo" required>
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

                                            <td>
                                            <input type="date" class="form-control required" value="<?php echo ($this->uri->segment(2) == 'cadastrar') ? set_value('Dt_IniVigencia') : $Dt_IniVigencia ; ?>" id="Dt_IniVigencia" name="Dt_IniVigencia">
                                            </td>

                                            <td>
                                            <input type="date" class="form-control" value="<?php echo ($this->uri->segment(2) == 'cadastrar') ? set_value('Dt_FimVigencia') : $Dt_FimVigencia ; ?>" id="Dt_FimVigencia" name="Dt_FimVigencia">
                                            </td>

                                            <td>
                                            <input type="text" class="form-control valor required" value="<?php echo ($this->uri->segment(2) == 'cadastrar') ? set_value('Vl_Indice') : $Vl_Indice ; ?>" id="Vl_Indice" name="Vl_Indice">
                                            </td>

                                            <td>
                                            <input type="text" class="form-control valor required" value="<?php echo ($this->uri->segment(2) == 'cadastrar') ? set_value('Vl_M2Filme') : $Vl_M2Filme ; ?>" id="Vl_M2Filme" name="Vl_M2Filme">
                                            </td>

                                            <td>
                                            <input type="text" class="form-control valor required" value="<?php echo ($this->uri->segment(2) == 'cadastrar') ? set_value('Vl_Honorario') : $Vl_Honorario ; ?>" id="Vl_Honorario" name="Vl_Honorario"
                                            maxlength="11">
                                            </td>

                                            <td>
                                            <input type="text" class="form-control valor required" value="<?php echo ($this->uri->segment(2) == 'cadastrar') ? set_value('Vl_UCO') : $Vl_UCO ; ?>" id="Vl_UCO" name="Vl_UCO"
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
                        

                        <!-- /.box-body -->

                        <div class="box-footer">
                            <input type="button" class="btn btn-primary" onclick="window.location='<?php echo base_url(); ?>principalIndiceGrupoPro/listar';" value="Lista (CTRL+L)" name="IrLista" id="IrLista"/>
                            <input type="submit" class="btn btn-primary" value="Salva e lista (CTRL+S)" name="salvarIrLista" id="salvarIrLista" style="margin-left:5px;"/>
                            <input type="submit" class="btn btn-primary" value="Salva e cadastra novamente (CTRL+A)" name="salvarMesmaTela" id="salvarMesmaTela" style="margin-left:5px;<?php if ($this->uri->segment(2) == 'editar') { echo 'display:none'; } ?>"/>
                            <input type="submit" class="btn btn-primary" value="Salva e edita índice associado(CTRL+V)" name="salvareVoltar" id="salvareVoltar" style="margin-left:5px;<?php if ($this->uri->segment(2) == 'cadastrar') { echo 'display:none'; } ?>"/>
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
<script src="<?php echo base_url(); ?>assets/js/addIndiceGrupoPro.js" type="text/javascript"></script>
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