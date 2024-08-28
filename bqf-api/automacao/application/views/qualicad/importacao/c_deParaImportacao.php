<?php

$Id_DeparaImportacao = '';
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
}

?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-users"></i> <?php echo ($this->uri->segment(2) == 'cadastrar') ? 'Cadastrar uma regra de um conjunto DEPARA' : 'Editar uma regra de um conjunto DEPARA' ; ?>
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
                    <form role="form" id="addDePara" action="<?php echo ($this->uri->segment(2) == 'cadastrar') ? base_url().'adicionaDePara' : base_url().'editaDePara'; ?>" method="post" role="form">
                        <div class="box-body">

                        <div class="row" style="display: inline-block;width: 98%;height: 100%;margin: 0.15rem;padding-top: 0.85rem;padding-left:1rem;padding-right:1rem;
                            background-color: #f5f5f5;padding-bottom:2rem">

                                <h4><strong>Regra</strong></h4>

                                <table style="width:100%;">
                                    <thead>
                                    <tr style="background-color:#e0e0e0">
                                        <th class="header-label" style="padding:10px">
                                        Conjunto DEPARA (descrição)
                                        </th>                                
                                        <th class="header-label" style="padding:10px">
                                        Tabela no banco
                                        </th>
                                        <th class="header-label" style="padding:10px">
                                        Campo de origem (CSV)
                                        </th>
                                        <th class="header-label" style="padding:10px">
                                        Campo de destino (no banco)
                                        </th>
                                        <th class="header-label" style="padding:10px">
                                        É data?
                                        </th>
                                        <th class="header-label" style="padding:10px">
                                        É valor?
                                        </th>
                                        <th class="header-label" style="padding:10px">
                                        Regra ativa?
                                        </th>
                                    </tr>
                                </thead>
                                <tr id="row0">
                                            <td>
                                            <select class="form-control required" id="Tb_Id_LayoutImportacao" name="Tb_Id_LayoutImportacao">
                                            <?php
                                            if(!empty($infoLayoutImportacao))
                                            {
                                                foreach ($infoLayoutImportacao as $layoutimportacao)
                                                {
                                                    ?>
                                                <option value="<?php echo $layoutimportacao->Id_LayoutImportacao ?>" <?php if ($this->uri->segment(2) == 'editar' && $layoutimportacao->Id_LayoutImportacao  == $Tb_Id_LayoutImportacao) { echo 'selected'; } ?>>
                                                    <?php echo $layoutimportacao->Id_LayoutImportacao.' - '.$layoutimportacao->Ds_LayoutImportacao ?>
                                                </option>
                                                <?php
                                                }
                                            }
                                            ?>
                                            </select>
                                             <input type="hidden" value="<?php echo $Id_DeparaImportacao; ?>" name="Id_DeparaImportacao" id="Id_DeparaImportacao" />
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
                                            <option value="tb_pacote" <?php if ($this->uri->segment(2) == 'editar' && $No_Tabela == 'tb_pacote') { echo 'selected'; } ?>>tb_pacote</option>
                                            <option value="tb_pacote_excecao" <?php if ($this->uri->segment(2) == 'editar' && $No_Tabela == 'tb_pacote_excecao') { echo 'selected'; } ?>>tb_pacote_excecao</option>
                                            <option value="tb_pacote_substancia" <?php if ($this->uri->segment(2) == 'editar' && $No_Tabela == 'tb_pacote_substancia') { echo 'selected'; } ?>>tb_pacote_substancia</option>
                                            <option value="tb_analisebi" <?php if ($this->uri->segment(2) == 'editar' && $No_Tabela == 'tb_analisebi') { echo 'selected'; } ?>>tb_analisebi</option>
                                            </select>
                                            </td>

                                            <td>
                                            <input type="text" class="form-control required" id="No_CampoOrigem" value="<?php echo ($this->uri->segment(2) == 'cadastrar') ? set_value('No_CampoOrigem') : $No_CampoOrigem ; ?>" name="No_CampoOrigem"
                                            maxlength="128">
                                            </td>

                                            <td>
                                            <select class="form-control required" id="No_CampoDestino" name="No_CampoDestino">
                                            </select>
                                            </td>

                                            <td>
                                            <select class="form-control required" id="St_Data" name="St_Data">
                                            <option value="S" <?php if ($this->uri->segment(2) == 'editar' && $St_Valor == 'S') { echo 'selected'; } ?>>Sim</option>
											<option value="N" <?php if ($this->uri->segment(2) == 'editar' && $St_Valor == 'N') { echo 'selected'; } else if ($this->uri->segment(2) == 'cadastrar') { echo 'selected'; }?>>Não</option>
                                            </select>
                                            </td>

                                            <td>
                                            <select class="form-control required" id="St_Valor" name="St_Valor">
                                            <option value="S" <?php if ($this->uri->segment(2) == 'editar' && $St_Valor == 'S') { echo 'selected'; } ?>>Sim</option>
											<option value="N" <?php if ($this->uri->segment(2) == 'editar' && $St_Valor == 'N') { echo 'selected'; } else if ($this->uri->segment(2) == 'cadastrar') { echo 'selected'; }?>>Não</option>
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
                            <input type="button" class="btn btn-primary" onclick="window.location='<?php echo base_url(); ?>importacaoDePara/listar';" value="Lista (CTRL+L)" name="IrLista" id="IrLista"/>
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
                $('select[name="No_CampoDestino"]').empty();
                $.each(data, function(key, value) {
                    $('select[name="No_CampoDestino"]').append('<option value="'+ value.Ds_CampoDestino +'">'+ value.Ds_CampoDestino +'</option>');
                });
            }
        });

    $('select[name="No_Tabela"]').on('change', function() {
        var DsTabela = $(this).val();
        if(DsTabela) {
            $.ajax({
                url: '<?php echo base_url(); ?>consultaCamposTabela/'+DsTabela,
                type: "GET",
                dataType: "json",
                success:function(data) {
                    $('select[name="No_CampoDestino"]').empty();
                    $.each(data, function(key, value) {
                        $('select[name="No_CampoDestino"]').append('<option value="'+ value.Ds_CampoDestino +'">'+ value.Ds_CampoDestino +'</option>');
                    });
                }
            });
        }else{
            $('select[name="No_CampoDestino"]').empty();
        }
    });
    
    });

</script>    