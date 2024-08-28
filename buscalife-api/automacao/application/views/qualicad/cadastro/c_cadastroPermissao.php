<?php

$Id_Permissao   = '';
$Ds_Perfil = '';
$Ds_Tela = '';
$Atualizar = '';
$Inserir = '';
$Excluir = '';
$Consultar = '';
$Imprimir = '';

if(!empty($infoPermissao))
{
    foreach ($infoPermissao as $r)
    {
        $Id_Permissao  = $r->Id_Permissao ;
        $Ds_Perfil = $r->Ds_Perfil;
        $Ds_Tela = $r->Ds_Tela;
        $Atualizar = $r->Atualizar;
        $Inserir = $r->Inserir;
        $Excluir = $r->Excluir;
        $Consultar = $r->Consultar;
        $Imprimir = $r->Imprimir;
    }
}

?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-users"></i> Editar Permissão
            <small>Editar</small>
        </h1>
    </section>

    <section class="content">

        <div class="row">
            <!-- left column -->
            <div class="col-md-8">
                <!-- general form elements -->



                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Selecione os campos abaixo</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <?php $this->load->helper("form"); ?>
                    <form role="form" id="addUser" action="<?php echo base_url() ?>editaPermissao" method="post" role="form">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Ds_Perfil">Perfil</label>
                                        <input type="text" class="form-control required" value="<?php echo $Ds_Perfil ; ?>" id="Ds_Perfil" name="Ds_Perfil" maxlength="128" disabled>
                                        <input type="hidden" value="<?php echo $Id_Permissao; ?>" name="Id_Permissao" id="Id_Permissao" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Ds_Tela">Tela</label>
                                        <input type="text" class="form-control required" value="<?php echo $Ds_Tela ; ?>" id="Ds_Tela" name="Ds_Tela" maxlength="128" disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Atualizar">Atualizar</label>
                                        <select class="form-control required" id="Atualizar" name="Atualizar">
                                            <option value="S" <?php if ($Atualizar == 'S') { echo 'selected'; } ?>>Sim</option>
                                            <option value="N" <?php if ($Atualizar == 'N') { echo 'selected'; } ?>>Não</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Inserir">Inserir</label>
                                        <select class="form-control required" id="Inserir" name="Inserir">
                                            <option value="S" <?php if ($Inserir == 'S') { echo 'selected'; } ?>>Sim</option>
                                            <option value="N" <?php if ($Inserir == 'N') { echo 'selected'; } ?>>Não</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Excluir">Excluir</label>
                                        <select class="form-control required" id="Excluir" name="Excluir">
                                            <option value="S" <?php if ($Excluir == 'S') { echo 'selected'; } ?>>Sim</option>
                                            <option value="N" <?php if ($Excluir == 'N') { echo 'selected'; } ?>>Não</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Consultar">Consultar</label>
                                        <select class="form-control required" id="Consultar" name="Consultar">
                                            <option value="S" <?php if ($Consultar == 'S') { echo 'selected'; } ?>>Sim</option>
                                            <option value="N" <?php if ($Consultar == 'N') { echo 'selected'; } ?>>Não</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Imprimir">Imprimir</label>
                                        <select class="form-control required" id="Imprimir" name="Imprimir">
                                            <option value="S" <?php if ($Imprimir == 'S') { echo 'selected'; } ?>>Sim</option>
                                            <option value="N" <?php if ($Imprimir == 'N') { echo 'selected'; } ?>>Não</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <!-- /.box-body -->

                        <div class="box-footer">
                            <input type="submit" class="btn btn-primary" value="Salvar" />
                            <input type="reset" class="btn btn-default" value="Limpar" />
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