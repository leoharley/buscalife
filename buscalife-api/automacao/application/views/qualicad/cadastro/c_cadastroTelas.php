<?php

$Id_Tela  = '';
$Ds_Perfil = '';
$Ds_Tela = '';
$Tp_Ativo = '';

if(!empty($infoTelas))
{
    foreach ($infoTelas as $r)
    {
        $Id_Tela = $r->Id_Tela;
        $Ds_Perfil = $r->Ds_Perfil;
        $Ds_Tela = $r->Ds_Tela;
        $Tp_Ativo = $r->Tp_Ativo;
    }
}

?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-users"></i> Editar Tela
            <small>Ativar/Desativar</small>
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
                    <form role="form" id="addUser" action="<?php echo base_url() ?>editaTelas" method="post" role="form">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Ds_Perfil">Perfil</label>
                                        <input type="text" class="form-control required" value="<?php echo $Ds_Perfil ; ?>" id="Ds_Perfil" name="Ds_Perfil" maxlength="128" disabled>
                                        <input type="hidden" value="<?php echo $Id_Tela; ?>" name="Id_Tela" id="Id_Tela" />
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
                                        <label for="Tp_Ativo">Configurar permissões neste perfil?</label>
                                        <select class="form-control required" id="Tp_Ativo" name="Tp_Ativo">
                                            <option value="S" <?php if ($Tp_Ativo == 'S') { echo 'selected'; } ?>>Sim</option>
                                            <option value="N" <?php if ($Tp_Ativo == 'N') { echo 'selected'; } ?>>Não</option>
                                        </select>
                                    </div>
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