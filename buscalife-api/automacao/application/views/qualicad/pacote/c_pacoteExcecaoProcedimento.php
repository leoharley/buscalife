<?php

$cd_pacote_excecao = '';
$cd_pacote_excecao_proced = '';

if ($this->uri->segment(2) == 'editar') {
if(!empty($infoExcecaoProcedimento))
{
    foreach ($infoExcecaoProcedimento as $r)
    {
        $cd_pacote_excecao_proced = $r->cd_pacote_excecao_proced;
        $cd_tuss = $r->cd_tuss;
        $cd_pacote_excecao = $r->cd_pacote_excecao;
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
            <i class="fa fa-users"></i> <?php echo ($this->uri->segment(2) == 'cadastrar') ? 'Cadastrar Exceção Procedimento' : 'Editar Exceção Procedimento' ; ?>
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
                    <form role="form" id="addExcecaoProcedimento" action="<?php echo ($this->uri->segment(2) == 'cadastrar') ? base_url().'adicionaExcecaoProcedimento' : base_url().'editaExcecaoProcedimento'; ?>" method="post" role="form">
                        <div class="box-body">

                        <div class="row" style="display: inline-block;width: 100%;height: 100%;margin: 0.15rem;padding-top: 0.85rem;padding-left:1rem;padding-right:1rem;
                            background-color: #f5f5f5;padding-bottom:2rem">

                                <h4><strong>Exceção Procedimento</strong></h4>

                                <table style="width:100%;">
                                    <thead>
                                    <tr style="background-color:#e0e0e0">
                                    <!--    <th class="header-label" style="padding:10px">
                                        Id Seq
                                        </th>  -->                                  
                                        <th class="header-label" style="padding:10px">
                                        Pacote Exceção
                                        </th>
                                        <th class="header-label" style="padding:10px">
                                        TUSS
                                        </th>
                                    </tr>
                                </thead>
                                <tr id="row0">
                                        <td>
                                            <select class="form-control" name="cd_pacote_excecao">
                                                <option value="SELECIONE">SELECIONE</option>
                                                <?php
                                                if(!empty($infoPacoteExcecoes))
                                                {
                                                    foreach ($infoPacoteExcecoes as $pacoteexcecao)
                                                    {
                                                        ?>
                                                        <option value="<?php echo $pacoteexcecao->cd_pacote_excecao ?>" <?php if ($this->uri->segment(2) == 'editar' && $pacoteexcecao->cd_pacote_excecao == $cd_pacote_excecao) { echo 'selected'; } ?>>
                                                            <?php echo $pacoteexcecao->cd_pacote_excecao . ' - ' . $pacoteexcecao->desc_pacote ?>
                                                        </option>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                        <input type="hidden" value="<?php echo $cd_pacote_excecao_proced; ?>" name="cd_pacote_excecao_proced" id="cd_pacote_excecao_proced" />    
                                        <input type="hidden" value="<?php echo $cd_pacote_excecao; ?>" name="cd_pacote_excecao" id="cd_pacote_excecao" />    
                                        </td>
                                        <td>
                                        <input type="text" class="form-control required" id="cd_tuss" value="<?php echo ($this->uri->segment(2) == 'cadastrar') ? set_value('cd_tuss') : $cd_tuss ; ?>" name="cd_tuss">
                                        </td>
                                </tr>

                                </table>
                            </div>

                            <div class="row" style="display: inline-block;width: 100%;height: 100%;margin: 0.15rem;padding-top: 0.85rem;padding-left:1rem;padding-right:1rem;
                            background-color: #f5f5f5;padding-bottom:2rem;">

                                <h4><strong>Pacote exceção selecionado</strong></h4>

                                <div class="table-responsive">
                                <table id="" style="overflow-x:auto;">
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

                                <tr style="background-color:#c0c0c0">                                    
                                    <td>
                                        <input type="text" class="form-control" id="cd_pacote_excecao" name="cd_pacote_excecao" disabled>
                                    </td>                                    
                                    <td>
                                        <input type="text" class="form-control" name="Tp_GrupoPro" disabled>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" name="TbGrupoPro_CodGrupo" disabled>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" name="cd_substancia" disabled>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" name="cd_tuss" disabled>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" name="cd_setor" disabled>
                                    </td>                                
                                </tr>
                                </table>
                            </div>

                        </div>
                        <!-- /.box-body -->    
                            
                        </div>
                        <!-- /.box-body -->

                        <div class="box-footer">
                            <input type="button" class="btn btn-primary" onclick="window.location='<?php echo base_url(); ?>pacoteExcecaoProcedimento/listar';" value="Lista (CTRL+L)" name="IrLista" id="IrLista"/>
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


        var cd_pacote_excecao = $('#cd_pacote_excecao').val();
        console.log('aqui'+cd_pacote_excecao);
        $.ajax({
            url: '<?php echo base_url(); ?>consultaPacoteExcecao/'+cd_pacote_excecao,
            type: "GET",
            dataType: "json",
            success:function(data) {
                    $('input[name="cd_pacote_excecao"]').empty();                   
                    $('input[name="Tp_GrupoPro"]').empty();
                    $('input[name="TbGrupoPro_CodGrupo"]').empty();
                    $('input[name="cd_substancia"]').empty();
                    $('input[name="cd_tuss"]').empty();
                    $('input[name="cd_setor"]').empty();
                $.each(data, function(key, value) {
                    $('input[name="cd_pacote_excecao"]').val(value.cd_pacote_excecao);                    
                    $('input[name="Tp_GrupoPro"]').val(value.Tp_GrupoPro);
                    $('input[name="TbGrupoPro_CodGrupo"]').val(value.CodGrupoPro + ' - ' + value.Ds_GrupoPro);                    
                    $('input[name="cd_substancia"]').val(value.cd_substancia + ' - ' + value.desc_substancia);
                    $('input[name="cd_tuss"]').val(value.cd_tuss);                    
                    $('input[name="cd_setor"]').val(value.cd_setor + ' - ' + value.desc_setor);
                });
            }
        });

        $('select[name="cd_pacote_excecao"]').on('change', function() {
            var cd_pacote_excecao = $(this).val();
            if(cd_pacote_excecao) {
                $.ajax({
                    url: '<?php echo base_url(); ?>consultaPacoteExcecao/'+cd_pacote_excecao,
                    type: "GET",
                    dataType: "json",
                    success:function(data) {
                            $('input[name="cd_pacote_excecao"]').empty();                            
                            $('input[name="Tp_GrupoPro"]').empty();
                            $('input[name="TbGrupoPro_CodGrupo"]').empty();
                            $('input[name="cd_substancia"]').empty();
                            $('input[name="cd_tuss"]').empty();
                            $('input[name="cd_setor"]').empty();
                        $.each(data, function(key, value) {
                            $('input[name="cd_pacote_excecao"]').val(value.cd_pacote_excecao);                           
                            $('input[name="Tp_GrupoPro"]').val(value.Tp_GrupoPro);
                            $('input[name="TbGrupoPro_CodGrupo"]').val(value.CodGrupoPro + ' - ' + value.Ds_GrupoPro);                    
                            $('input[name="cd_substancia"]').val(value.cd_substancia + ' - ' + value.desc_substancia);
                            $('input[name="cd_tuss"]').val(value.cd_tuss);                    
                            $('input[name="cd_setor"]').val(value.cd_setor + ' - ' + value.desc_setor);
                        });
                    }
                });
            }else{
                $('input[name="cd_pacote_excecao"]').empty();                
                $('input[name="Tp_GrupoPro"]').empty();
                $('input[name="TbGrupoPro_CodGrupo"]').empty();
                $('input[name="cd_substancia"]').empty();
                $('input[name="cd_tuss"]').empty();
                $('input[name="cd_setor"]').empty();
            }
        });




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