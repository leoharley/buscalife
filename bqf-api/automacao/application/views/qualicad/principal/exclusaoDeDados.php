<?php

/*$Id_DeparaImportacao = '';
$Tb_Id_LayoutImportacao = '';
$No_Importacao = '';
$No_Tabela = '';
$No_CampoOrigem = '';
$No_CampoDestino = '';
$Tp_Ativo = '';

if ($this->uri->segment(2) == 'editar') {
if(!empty($infoDePara))
{
    foreach ($infoDePara as $r)
    {
        $Id_DeparaImportacao = $r->Id_DeparaImportacao;
        $Tb_Id_LayoutImportacao = $r->Tb_Id_LayoutImportacao;
        $No_Importacao = $r->No_Importacao;
        $No_Tabela = $r->No_Tabela;
        $No_CampoOrigem = $r->No_CampoOrigem;
        $No_CampoDestino = $r->No_CampoDestino;
        $Tp_Ativo = $r->Tp_Ativo;
    }
}
}*/

?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-users"></i> Exclusão de Registros
            <small>Excluir</small>
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
                        <h3 class="box-title">Selecione os campos abaixo</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <?php $this->load->helper("form"); ?>
                    <form role="form" id="exclusaoDeDados" action="<?php echo base_url().'excluiDados'; ?>" method="post" role="form">
                        <div class="box-body">

                        <div class="row" style="display: inline-block;width: 95%!important;height: 100%;margin: 0.15rem;padding-top: 0.85rem;padding-left:1rem;padding-right:1rem;
                            background-color: #f5f5f5;padding-bottom:2rem">

                                <table style="width:100%;">
                                    <thead>
                                    <tr style="background-color:#e0e0e0">
                                        <th class="header-label" style="padding:10px">
                                        Empresa
                                        </th>                                
                                        <th class="header-label" style="padding:10px">
                                        Tabela
                                        </th>
                                        <th class="header-label" style="padding:10px">
                                        Itens Tabela
                                        </th>
                                        <th class="header-label" style="padding:10px">
                                        Filtros disponíveis
                                        </th>
                                        <th class="header-label" style="padding:10px">
                                        Ação
                                        </th>
                                    </tr>
                                </thead>
                                <tr id="row0">
                                            <td>
                                            <select class="form-control required" id="Tb_Id_Empresa" name="Tb_Id_Empresa">
                                            <?php
                                            if(!empty($infoEmpresas))
                                            {
                                                foreach ($infoEmpresas as $empresa)
                                                {
                                                    ?>
                                                <option value="<?php echo $empresa->Id_Empresa ?>">
                                                    <?php echo $empresa->Id_Empresa.' - '.$empresa->Nome_Empresa ?>
                                                </option>
                                                <?php
                                                }
                                            }
                                            ?>
                                            </select>
    
                                            </td>  

                                            <td>
                                            <select class="form-control required" id="No_Tabela" name="No_Tabela">
                                            <option value="TabTela" <?php if ($this->uri->segment(2) == 'editar' && $No_Tabela == 'TabTela') { echo 'selected'; } else if ($this->uri->segment(2) == 'cadastrar') { echo 'selected'; } ?>>TabTela</option>
                                            <option value="TabUsuario" <?php if ($this->uri->segment(2) == 'editar' && $No_Tabela == 'TabUsuario') { echo 'selected'; } ?>>TabUsuario</option>
                                            <option value="TbConvenio" <?php if ($this->uri->segment(2) == 'editar' && $No_Tabela == 'TbConvenio') { echo 'selected'; } ?>>TbConvenio</option>
                                            <option value="TbEmpresa" <?php if ($this->uri->segment(2) == 'editar' && $No_Tabela == 'TbEmpresa') { echo 'selected'; } ?>>TbEmpresa</option>
                                            <option value="TbFatItem" <?php if ($this->uri->segment(2) == 'editar' && $No_Tabela == 'TbFatItem') { echo 'selected'; } ?>>TbFatItem</option>
                                            <option value="TbFaturamento" <?php if ($this->uri->segment(2) == 'editar' && $No_Tabela == 'TbFaturamento') { echo 'selected'; } ?>>TbFaturamento</option>
                                            <option value="TbGrupoPro" <?php if ($this->uri->segment(2) == 'editar' && $No_Tabela == 'TbGrupoPro') { echo 'selected'; } ?>>TbGrupoPro</option>
                                            <option value="TbIndice" <?php if ($this->uri->segment(2) == 'editar' && $No_Tabela == 'TbIndice') { echo 'selected'; } ?>>TbIndice</option>
                                            <option value="TbIndiceGrupo" <?php if ($this->uri->segment(2) == 'editar' && $No_Tabela == 'TbIndiceGrupo') { echo 'selected'; } ?>>TbIndiceGrupo</option>
                                            <option value="TbPerfil" <?php if ($this->uri->segment(2) == 'editar' && $No_Tabela == 'TbPerfil') { echo 'selected'; } ?>>TbPerfil</option>
                                            <option value="TbPermissao" <?php if ($this->uri->segment(2) == 'editar' && $No_Tabela == 'TbPermissao') { echo 'selected'; } ?>>TbPermissao</option>
                                            <option value="TbPlano" <?php if ($this->uri->segment(2) == 'editar' && $No_Tabela == 'TbIndice') { echo 'selected'; } ?>>TbPlano</option>
                                            <option value="TbProFat" <?php if ($this->uri->segment(2) == 'editar' && $No_Tabela == 'TbProFat') { echo 'selected'; } ?>>TbProFat</option>
                                            <option value="TbRegra" <?php if ($this->uri->segment(2) == 'editar' && $No_Tabela == 'TbRegra') { echo 'selected'; } ?>>TbRegra</option>
                                            <option value="TbTUSS" <?php if ($this->uri->segment(2) == 'editar' && $No_Tabela == 'TbTUSS') { echo 'selected'; } ?>>TbTUSS</option>
                                            <option value="TbUsuEmp" <?php if ($this->uri->segment(2) == 'editar' && $No_Tabela == 'TbUsuEmp') { echo 'selected'; } ?>>TbUsuEmp</option>
                                            <option value="Tb_FracaoSimproBra" <?php if ($this->uri->segment(2) == 'editar' && $No_Tabela == 'Tb_FracaoSimproBra') { echo 'selected'; } ?>>Tb_FracaoSimproBra</option>
                                            <option value="Tb_Producao" <?php if ($this->uri->segment(2) == 'editar' && $No_Tabela == 'Tb_Producao') { echo 'selected'; } ?>>Tb_Producao</option>
                                            <option value="Tb_Produto" <?php if ($this->uri->segment(2) == 'editar' && $No_Tabela == 'Tb_Produto') { echo 'selected'; } ?>>Tb_Produto</option>
                                            <option value="Tb_Proibicao" <?php if ($this->uri->segment(2) == 'editar' && $No_Tabela == 'Tb_Proibicao') { echo 'selected'; } ?>>Tb_Proibicao</option>
                                            <option value="Tb_RegraGruPro" <?php if ($this->uri->segment(2) == 'editar' && $No_Tabela == 'Tb_RegraGruPro') { echo 'selected'; } ?>>Tb_RegraGruPro</option>
                                            <option value="Tb_RegraProibicao" <?php if ($this->uri->segment(2) == 'editar' && $No_Tabela == 'Tb_RegraProibicao') { echo 'selected'; } ?>>Tb_RegraProibicao</option>
                                            <option value="Tb_Unidade" <?php if ($this->uri->segment(2) == 'editar' && $No_Tabela == 'Tb_Unidade') { echo 'selected'; } ?>>Tb_Unidade</option>
                                            <option value="TbPorteMedico" <?php if ($this->uri->segment(2) == 'editar' && $No_Tabela == 'TbPorteMedico') { echo 'selected'; } ?>>TbPorteMedico</option>
                                            <option value="TbExcValores" <?php if ($this->uri->segment(2) == 'editar' && $No_Tabela == 'TbExcValores') { echo 'selected'; } ?>>TbExcValores</option>
                                            <option value="TbContrato" <?php if ($this->uri->segment(2) == 'editar' && $No_Tabela == 'TbContrato') { echo 'selected'; } ?>>TbContrato</option>
                                            <option value="tb_itens_empacotados" <?php if ($this->uri->segment(2) == 'editar' && $No_Tabela == 'tb_itens_empacotados') { echo 'selected'; } ?>>tb_itens_empacotados</option>
                                            </select>
                                            </td>

                                            <td>
                                            <select class="form-control required" id="No_Campo" name="No_Campo">
                                            </select>
                                            </td>

                                            <td>
                                            <select class="form-control required" id="Valores" name="Valores">                                            
                                            </select>
                                            </td>

                                            <td class="text-center">
                                            <a class="btn btn-sm btn-danger" href="#" title="Excluir" data-toggle="modal" data-target="#confirm-delete">
                                                    <i class="fa fa-trash-o"></i>
                                            </a>
                                    </tr>
                                    <tr id="row1">

                                </tr>

                                </table>

                                <div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                               <strong>Exclusão de valores</strong>
                                            </div>
                                            <div class="modal-body">
                                                Deseja realmente excluir?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-primary">Confirmo</button>
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <br/>
                                <h4 class="box-title">Histórico de exclusão</h4>
                                <!-- Data list table -->
                                <table class="table table-striped table-bordered" id="dataTables-example" style="width:100%;">
                                    <thead class="thead-dark">
                                    <tr style="background-color:#e0e0e0">
                                        <th class="header-label" style="padding:10px">
                                        Empresa
                                        </th>                                
                                        <th class="header-label" style="padding:10px">
                                        Tabela
                                        </th>
                                        <th class="header-label" style="padding:10px">
                                        Itens Tabela
                                        </th>
                                        <th class="header-label" style="padding:10px">
                                        Filtro utilizado
                                        </th>
                                        <th class="header-label" style="padding:10px">
                                        Data
                                        </th>
                                    </tr>
                                    </thead>
                                
                                    <tbody>
                                        <?php if(!empty($infoHistoricoExc)){ foreach($infoHistoricoExc as $registro){ ?>
                                        <tr>
                                            <td><?= $registro->idempresa . ' - '  .$registro->Nome_Empresa ?></td>
                                            <td><?= $registro->notabela ?></td>
                                            <td><?= $registro->nocampo ?></td>
                                            <td><?= $registro->dsvalores ?></td>
                                            <td><?= date("d/m/Y", strtotime($registro->dtexclusao)) ?></td>
                                        </tr>
                                        <?php } }else{ ?>
                                        <tr><td colspan="5">Nenhum registro encontrado...</td></tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                                

                            </div>                            
                        </div>
                        <!-- /.box-body -->

                        <div class="box-footer">
                            
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
<script src="<?php echo base_url(); ?>assets/js/addDePara.js" type="text/javascript"></script>

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

    $(document).ready(function() {

    var DsTabela = $('#No_Tabela').val();
        $.ajax({
            url: '<?php echo base_url(); ?>consultaCamposTabela/'+DsTabela,
            type: "GET",
            dataType: "json",
            success:function(data) {
                $('select[name="No_Campo"]').empty();
                $.each(data, function(key, value) {
                    $('select[name="No_Campo"]').append('<option value="0">TODA A TABELA</option>');
                    $('select[name="No_Campo"]').append('<option value="'+ value.Ds_CampoDestino +'">'+ value.Ds_CampoDestino +'</option>');
                });
            }
        });

    $('select[name="Tb_Id_Empresa"]').on('change', function() {
        $('select[name="Valores"]').empty();
    });

    $('select[name="No_Tabela"]').on('change', function() {
        $('select[name="Valores"]').empty();
        var DsTabela = $(this).val();
        const array = ['TbFaturamento_Id_Faturamento','Cd_ConvenioERP','TbContrato_Cd_Convenio','TbConvenio_Id_Convenio','TbRegra_Id_Regra']
        if(DsTabela) {
            $.ajax({
                url: '<?php echo base_url(); ?>consultaCamposTabela/'+DsTabela,
                type: "GET",
                dataType: "json",
                success:function(data) {                
                    $('select[name="No_Campo"]').empty();
                    $('select[name="No_Campo"]').append('<option value="0">TODA A TABELA</option>');
                    $.each(data, function(key, value) {
                        if (!array.includes(value.Ds_CampoDestino)) { disabled = 'DISABLED'; } else { disabled = ''; }
                        $('select[name="No_Campo"]').append('<option value="'+ value.Ds_CampoDestino +'"'+' '+disabled+'>'+ value.Ds_CampoDestino +'</option>');
                    });
                }
            });
        }else{
            $('select[name="No_Campo"]').empty();
        }
    });


    $('select[name="No_Campo"]').on('change', function() {
        var IdEmpresa = $('select[name="Tb_Id_Empresa"]').val();
        var DsTabela = $('select[name="No_Tabela"]').val();
        var DsCampoDestino = $(this).val();

        if(DsTabela&&DsCampoDestino&&IdEmpresa) {
            $.ajax({
                url: '<?php echo base_url(); ?>consultaValoresTabela/'+DsTabela+'/'+DsCampoDestino+'/'+IdEmpresa,
                type: "GET",
                dataType: "json",
                success:function(data) {
                    $('select[name="Valores"]').empty();
                    $.each(data, function(key, value) {
                        var ds_valores3=null;
                        if (DsCampoDestino == 'Cd_ConvenioERP'||DsCampoDestino == 'TbFaturamento_Id_Faturamento') { 
                            ds_valores3 = value.ds_valores + ' - ' + value.ds_valores2; 
                        }
                        else { 
                            ds_valores3 = value.ds_valores; 
                        }
                        $('select[name="Valores"]').append('<option value="'+ value.ds_valores +'">'+ ds_valores3 +'</option>');
                    });
                }
            });
        }else{
            $('select[name="Valores"]').empty();
        }
    });


    });

</script>    