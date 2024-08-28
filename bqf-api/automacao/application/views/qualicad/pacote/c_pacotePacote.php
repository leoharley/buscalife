<?php

$cd_pacote = '';


if ($this->uri->segment(2) == 'editar') {
if(!empty($infoPacote))
{
    foreach ($infoPacote as $r)
    {
        $cd_pacote = $r->cd_pacote;
        $cd_pacote_erp = $r->cd_pacote_erp;
        $desc_pacote = $r->desc_pacote;
        $cd_profat = $r->cd_profat;
        $qtd_diarias = $r->qtd_diarias;
        $dt_vigencia_inicial = $r->dt_vigencia_inicial;
        $dt_vigencia_final = $r->dt_vigencia_final;
        $TbConvenio_Id_Convenio = $r->cd_convenio_id;
        $TbPlano_Id_Plano = $r->cd_plano_id;
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
            <i class="fa fa-users"></i> <?php echo ($this->uri->segment(2) == 'cadastrar') ? 'Cadastrar Pacote' : 'Editar Pacote' ; ?>
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
                    <form role="form" id="addPacote" action="<?php echo ($this->uri->segment(2) == 'cadastrar') ? base_url().'adicionaPacote' : base_url().'editaPacote'; ?>" method="post" role="form">
                        <div class="box-body" style="padding-left:1rem;padding-right:1rem">
                            
                        
                        <div class="row" style="display: inline-block;width: 100%;height: 100%;margin: 0.15rem;padding-top: 0.85rem;padding-left:1rem;padding-right:1rem;
                            background-color: #f5f5f5;padding-bottom:2rem">

                                <h4><strong>Pacote</strong></h4>

                                <table id="dataTables-example2" style="overflow-x:auto;width:100%!important;">
                                    <thead>
                                    <tr style="background-color:#e0e0e0">
                                        <th class="header-label" style="padding:10px">
                                        Código ERP
                                        </th>
                                        <th class="header-label" style="padding:10px">
                                        Pacote (descrição)
                                        </th>
                                        <th class="header-label" style="padding:10px">
                                        Convênio
                                        </th>
                                        <th class="header-label" style="padding:10px">
                                        Plano
                                        </th>
                                        <th class="header-label" style="padding:10px">
                                        Profat
                                        </th>
                                        <th class="header-label" style="padding:10px">
                                        Profat_starta
                                        </th>
                                        <th class="header-label" style="padding:10px">
                                        Qtd. Diárias
                                        </th> 
                                        <th class="header-label" style="padding:10px">
                                        Dt Vigência Inicial
                                        </th>
                                        <th class="header-label" style="padding:10px">
                                        Dt Vigência Final
                                        </th>
                                    </tr>
                                </thead>
                                <tr id="row0">
                                    <td style="width:12%">
                                    <input type="text" class="form-control required" value="<?php echo ($this->uri->segment(2) == 'cadastrar') ? set_value('cd_pacote_erp') : $cd_pacote_erp ; ?>" id="cd_pacote_erp" name="cd_pacote_erp">
                                    </td>

                                    <td>
                                    <input type="text" class="form-control required" value="<?php echo ($this->uri->segment(2) == 'cadastrar') ? set_value('desc_pacote') : $desc_pacote ; ?>" id="desc_pacote" name="desc_pacote" maxlength="128">
                                    <input type="hidden" value="<?php echo $cd_pacote; ?>" name="cd_pacote" id="cd_pacote" /> 
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
                                    </td>

                                    <td style="width:25%!important">
                                    <select class="form-control required" id="TbPlano_Id_Plano" name="TbPlano_Id_Plano" required>
                                    <option value="" disabled selected>SELECIONE</option>
                                    <?php
                                    if(!empty($infoPlano))
                                    {
                                        foreach ($infoPlano as $plano)
                                        {
                                            ?>
                                        <option value="<?php echo $plano->Id_Plano ?>" <?php if ($this->uri->segment(2) == 'editar' && $plano->Id_Plano == $TbPlano_Id_Plano) { echo 'selected'; } ?>>
                                            <?php echo $plano->Id_Plano.' - '.$plano->Ds_Plano ?>
                                        </option>
                                        <?php
                                        }
                                    }
                                    ?>
                                    </select>
                                    </td>

                                    <td style="width:5%!important">
                                    <select id="itemName" class="form-control" style="width:300px" name="cd_profat_pacote"></select>
                                    </td>

                                    <td style="width:5%!important">
                                    <select id="itemName2" class="form-control" style="width:300px" name="cd_profat"></select>
                                    </td>
                                   
                                    <td>
                                    <input type="text" class="form-control required" value="<?php echo ($this->uri->segment(2) == 'cadastrar') ? set_value('qtd_diarias') : $qtd_diarias ; ?>" id="qtd_diarias" name="qtd_diarias">
                                    </td>

                                    <td>
                                    <input type="date" class="form-control" value="<?php echo ($this->uri->segment(2) == 'cadastrar') ? set_value('dt_vigencia_inicial') : $dt_vigencia_inicial ; ?>" id="dt_vigencia_inicial" name="dt_vigencia_inicial">
                                    </td>

                                    <td>
                                    <input type="date" class="form-control" value="<?php echo ($this->uri->segment(2) == 'cadastrar') ? set_value('dt_vigencia_final') : $dt_vigencia_final ; ?>" id="dt_vigencia_final" name="dt_vigencia_final">
                                    </td>
                                    
                                </tr>

                                </table>
                            </div>

                            <div class="row" style="display: inline-block;width: 100%;height: 100%;margin: 0.15rem;padding-top: 0.85rem;padding-left:1rem;padding-right:1rem;
                            background-color: #f5f5f5;padding-bottom:2rem;">

                                <h4><strong>Exceção de Pacote</strong></h4>

                                <div class="table-responsive">
                                <table id="dataTables-example" style="overflow-x:auto;">
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
                                            <input type="text" class="form-control" id="cd_pacote_excecao" value="<?php echo set_value('cd_pacote_excecao') ; ?>" name="cd_pacote_excecao"
                                                maxlength="11" disabled>
                                            </td>                                            

                                            <td style="width:10%">
                                                <select class="form-control" name="Tp_GrupoPro" ng-model="Tp_GrupoPro" ng-init="Tp_GrupoPro='SELECIONE'" ng-disabled="cd_tuss!==''||cd_substancia!=='SELECIONE'||TbGrupoPro_CodGrupo!=='SELECIONE'">
                                                    <option value="SELECIONE">SELECIONE</option>
                                                    <option value="MD">MD</option>
                                                    <option value="MT">MT</option>
                                                    <option value="OP">OP</option>
                                                    <option value="SH">SH</option>
                                                    <option value="SP">SP</option>
                                                    <option value="SD">SD</option>
                                                </select>
                                            </td>

                                            <td style="width:30%">
                                                <select class="form-control" name="TbGrupoPro_CodGrupo" ng-selected="SELECIONE" ng-init="TbGrupoPro_CodGrupo='SELECIONE'" ng-model="TbGrupoPro_CodGrupo" ng-disabled="cd_tuss!==''||cd_substancia!=='SELECIONE'||Tp_GrupoPro!=='SELECIONE'">
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
                                                <select class="form-control" name="cd_substancia" ng-model="cd_substancia" ng-selected="SELECIONE" ng-init="cd_substancia='SELECIONE'" ng-disabled="cd_tuss!==''||TbGrupoPro_CodGrupo!=='SELECIONE'||Tp_GrupoPro!=='SELECIONE'">
                                                    <option value="SELECIONE">SELECIONE</option>
                                                    <?php
                                                    if(!empty($infoSubstancias))
                                                    {
                                                        foreach ($infoSubstancias as $substancia)
                                                        {
                                                            ?>
                                                            <option value="<?php echo $substancia->cd_substancia ?>">
                                                                <?php echo $substancia->cd_substancia .' - '.$substancia->desc_substancia ?>
                                                            </option>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </td>

                                            <td  style="width:5%!important">
                                            <input type="text" class="form-control" value="<?php echo set_value('cd_tuss'); ?>" id="cd_tuss" name="cd_tuss" ng-model="cd_tuss" ng-init="cd_tuss=''" ng-disabled="cd_substancia!=='SELECIONE'||TbGrupoPro_CodGrupo!=='SELECIONE'||Tp_GrupoPro!=='SELECIONE'">
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
                                                            <option value="<?php echo $setor->cd_setor ?>">
                                                                <?php echo $setor->cd_setor .' - '.$setor->desc_setor ?>
                                                            </option>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </td>
                                </tr>

                                <?php
                                if(!empty($infoExcecaoPacotePacote))
                                {
                                foreach ($infoExcecaoPacotePacote as $excecao)
                                {
                                ?>
                                <tr style="background-color:#c0c0c0">                                    
                                    <td>
                                        <input type="text" class="form-control" value="<?php echo $excecao->cd_pacote_excecao ?>" disabled>
                                    </td>                                    
                                    <td>
                                        <input type="text" class="form-control" value="<?php echo $excecao->Tp_GrupoPro ?>" disabled>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" value="<?php echo $excecao->CodGrupoPro.' - '.$excecao->Ds_GrupoPro ?>" disabled>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" value="<?php echo $excecao->cd_substancia.' - '.$excecao->desc_substancia ?>" disabled>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" value="<?php echo $excecao->cd_tuss ?>" disabled>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" value="<?php echo $excecao->cd_setor.' - '.$excecao->desc_setor ?>" disabled>
                                    </td>
                                    <td>
                                    <a class="btn btn-sm btn-info" href="<?php echo base_url().'pacoteExcecaoPacote/editar/'.$excecao->cd_pacote_excecao; ?>" title="Editar">
                                        <i class="fa fa-pencil"></i>
                                    </a>
                                    </td>
                                    <td>
                                    <a class="btn btn-sm btn-danger" href="<?php echo base_url().'apagaExcecaoPacote/'.$excecao->cd_pacote_excecao.'/'.$cd_pacote; ?>" title="Excluir">
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
                            <input type="button" class="btn btn-primary" onclick="window.location='<?php echo base_url(); ?>pacotePacote/listar';" value="Lista (CTRL+L)" name="IrLista" id="IrLista"/>
                            <input type="submit" class="btn btn-primary" value="Salva e lista (CTRL+S)" name="salvarIrLista" id="salvarIrLista" style="margin-left:5px;"/>
                            <input type="submit" class="btn btn-primary" value="Salva e cadastra novamente (CTRL+A)" name="salvarMesmaTela" id="salvarMesmaTela" style="margin-left:5px;<?php if ($this->uri->segment(2) == 'editar') { echo 'display:none'; } ?>"/>
                            <input type="submit" class="btn btn-primary" value="Salva e adiciona outro item (CTRL+P)" name="salvarExcecaoPacote" id="salvarExcecaoPacote" style="margin-left:5px;"/>
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

        $("#itemName").select2({
                language: {
                    inputTooShort: function(args) {
                    // args.minimum is the minimum required length
                    // args.input is the user-typed text
                    return "Digite código ou descrição para localizar";
                    },
                    inputTooLong: function(args) {
                    // args.maximum is the maximum allowed length
                    // args.input is the user-typed text
                    return "Limite de texto excedido";
                    },
                    errorLoading: function() {
                    return "Erro ao carregar resultados";
                    },
                    loadingMore: function() {
                    return "Carregando mais resultados";
                    },
                    noResults: function() {
                    return "Nenhum resultado localizado";
                    },
                    searching: function() {
                    return "Buscando...";
                    },
                    maximumSelected: function(args) {
                    // args.maximum is the maximum number of items the user may select
                    return "Erro ao carregar resultados";
                    }
                },
                placeholder: "Buscar",
                minimumInputLength: 3,
                formatInputTooShort: "Please add more text",
                ajax: {
                    url:"<?php echo base_url(); ?>buscaProFat",
                    dataType: 'json',
                    quietMillis: 100,
                    data: function (term, page) {
                        return {
                            q: term, //search term
                            page_limit: 10, // page size
                            page: page
                        };
                    },
                    processResults: function (response) {
                        return {
                            results: response
                        };
                    },
                    cache: true
                },
                escapeMarkup: function (m) { return m; }
            });

            $("#itemName2").select2({
                language: {
                    inputTooShort: function(args) {
                    // args.minimum is the minimum required length
                    // args.input is the user-typed text
                    return "Digite código ou descrição para localizar";
                    },
                    inputTooLong: function(args) {
                    // args.maximum is the maximum allowed length
                    // args.input is the user-typed text
                    return "Limite de texto excedido";
                    },
                    errorLoading: function() {
                    return "Erro ao carregar resultados";
                    },
                    loadingMore: function() {
                    return "Carregando mais resultados";
                    },
                    noResults: function() {
                    return "Nenhum resultado localizado";
                    },
                    searching: function() {
                    return "Buscando...";
                    },
                    maximumSelected: function(args) {
                    // args.maximum is the maximum number of items the user may select
                    return "Erro ao carregar resultados";
                    }
                },
                placeholder: "Buscar",
                minimumInputLength: 3,
                formatInputTooShort: "Please add more text",
                ajax: {
                    url:"<?php echo base_url(); ?>buscaProFat",
                    dataType: 'json',
                    quietMillis: 100,
                    data: function (term, page) {
                        return {
                            q: term, //search term
                            page_limit: 10, // page size
                            page: page
                        };
                    },
                    processResults: function (response) {
                        return {
                            results: response
                        };
                    },
                    cache: true
                },
                escapeMarkup: function (m) { return m; }
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
    shortcut.add("ctrl+p", function() {
        document.getElementById('salvarFatItem').click();
    });
</script>

<script !src="">
    var app = angular.module('appPrincipal', []);
    app.controller('entercontroller', function ($scope, $http) {
        console.log('success');
    });
</script>