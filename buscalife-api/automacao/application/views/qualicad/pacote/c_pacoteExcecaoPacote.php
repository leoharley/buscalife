<?php

$cd_pacote_excecao = '';


if ($this->uri->segment(2) == 'editar') {
if(!empty($infoPacoteExcecao))
{
    foreach ($infoPacoteExcecao as $r)
    {
        $cd_pacote_excecao = $r->cd_pacote_excecao;
        $cd_pacote = $r->cd_pacote;
        $cd_grupro = $r->cd_grupro;
        $cd_substancia = $r->cd_substancia;
        $cd_tuss = $r->cd_tuss;
        $cd_setor = $r->cd_setor;        
        $Tp_GrupoPro = $r->Tp_GrupoPro;
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
            <i class="fa fa-users"></i> <?php echo ($this->uri->segment(2) == 'cadastrar') ? 'Cadastrar Exceção Pacote' : 'Editar Exceção Pacote' ; ?>
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
                    <form role="form" id="addSetor" action="<?php echo ($this->uri->segment(2) == 'cadastrar') ? base_url().'adicionaExcecaoPacote' : base_url().'editaExcecaoPacote'; ?>" method="post" role="form">
                        <div class="box-body">

                        <div class="row" style="display: inline-block;width: 100%;height: 100%;margin: 0.15rem;padding-top: 0.85rem;padding-left:1rem;padding-right:1rem;
                            background-color: #f5f5f5;padding-bottom:2rem">

                                <h4><strong>Exceção Pacote</strong></h4>

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
                                        GruPro
                                        </th>
                                        <th class="header-label" style="padding:10px">
                                        Substância
                                        </th>
                                        <th class="header-label" style="padding:10px">
                                        TUSS
                                        </th>
                                        <th class="header-label" style="padding:10px">
                                        Setor
                                        </th>
                                    </tr>
                                </thead>
                                <tr id="row0">
                                            <td style="width:5%">
                                            <input type="text" class="form-control" id="cd_pacote_excecao" value="<?php echo ($this->uri->segment(2) == 'cadastrar') ? set_value('cd_pacote_excecao') : $cd_pacote_excecao ; ?>" name="cd_pacote_excecao"
                                                maxlength="11" disabled>
                                            <input type="hidden" value="<?php echo $cd_pacote_excecao; ?>" name="cd_pacote_excecao" id="cd_pacote_excecao" />    
                                            <input type="hidden" value="<?php echo $cd_pacote; ?>" name="cd_pacote" id="cd_pacote" />    
                                            </td>                                            

                                            <td style="width:10%">
                                                <select class="form-control" name="Tp_GrupoPro" disabled>
                                                    <option value="SELECIONE">SELECIONE</option>
                                                    <option value="MD" <?php if ($this->uri->segment(2) == 'editar' && $Tp_GrupoPro == 'MD') { echo 'selected'; } ?>>MD</option>
                                                    <option value="MT" <?php if ($this->uri->segment(2) == 'editar' && $Tp_GrupoPro == 'MT') { echo 'selected'; } ?>>MT</option>
                                                    <option value="OP" <?php if ($this->uri->segment(2) == 'editar' && $Tp_GrupoPro == 'OP') { echo 'selected'; } ?>>OP</option>
                                                    <option value="SH" <?php if ($this->uri->segment(2) == 'editar' && $Tp_GrupoPro == 'SH') { echo 'selected'; } ?>>SH</option>
                                                    <option value="SP" <?php if ($this->uri->segment(2) == 'editar' && $Tp_GrupoPro == 'SP') { echo 'selected'; } ?>>SP</option>
                                                    <option value="SD" <?php if ($this->uri->segment(2) == 'editar' && $Tp_GrupoPro == 'SD') { echo 'selected'; } ?>>SD</option>
                                                </select>
                                            </td>

                                            <td style="width:30%">
                                                <select class="form-control" name="TbGrupoPro_CodGrupo" disabled>
                                                    <option value="SELECIONE">SELECIONE</option>
                                                    <?php
                                                    if(!empty($infoGrupoPro))
                                                    {
                                                        foreach ($infoGrupoPro as $grupopro)
                                                        {
                                                            ?>
                                                            <option value="<?php echo $grupopro->CodGrupoPro ?>" <?php if ($this->uri->segment(2) == 'editar' && $grupopro->CodGrupoPro == $cd_grupro) { echo 'selected'; } ?>>
                                                                <?php echo $grupopro->CodGrupoPro .' - '.$grupopro->Ds_GrupoPro ?>
                                                            </option>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </td>

                                            <td>
                                                <select class="form-control" name="cd_substancia">
                                                    <option value="SELECIONE">SELECIONE</option>
                                                    <?php
                                                    if(!empty($infoSubstancias))
                                                    {
                                                        foreach ($infoSubstancias as $substancia)
                                                        {
                                                            ?>
                                                            <option value="<?php echo $substancia->cd_substancia ?>" <?php if ($this->uri->segment(2) == 'editar' && $substancia->cd_substancia == $cd_substancia) { echo 'selected'; } ?>>
                                                                <?php echo $substancia->cd_substancia .' - '.$substancia->desc_substancia ?>
                                                            </option>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </td>

                                            <td  style="width:5%!important">
                                            <input type="text" class="form-control" value="<?php echo ($this->uri->segment(2) == 'cadastrar') ? set_value('cd_tuss') : $cd_tuss ; ?>" id="cd_tuss" name="cd_tuss">
                                            </td>

                                            <td>
                                                <select class="form-control" name="cd_setor">
                                                    <option value="SELECIONE">SELECIONE</option>
                                                    <?php
                                                    if(!empty($infoSetores))
                                                    {
                                                        foreach ($infoSetores as $setor)
                                                        {
                                                            ?>
                                                            <option value="<?php echo $setor->cd_setor ?>" <?php if ($this->uri->segment(2) == 'editar' && $setor->cd_setor == $cd_setor) { echo 'selected'; } ?>>
                                                                <?php echo $setor->cd_setor .' - '.$setor->desc_setor ?>
                                                            </option>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </td>
                                </tr>

                                </table>
                            </div>

                            
                        </div>
                        <!-- /.box-body -->

                        <div class="box-footer">
                        <input type="button" class="btn btn-primary" onclick="window.location='<?php echo base_url(); ?>principalRegraGruPro/listar';" value="Lista (CTRL+L)" name="IrLista" id="IrLista" style="display:none"/>                            
                            <input type="submit" class="btn btn-primary" value="Salva e volta (CTRL+V)" name="salvareVoltar" id="salvareVoltar" style="margin-left:5px;<?php if ($this->uri->segment(2) == 'cadastrar') { echo 'display:none'; } ?>"/>
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