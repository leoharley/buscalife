<?php

$Id_CdPerfil  = '';
$Ds_Perfil = '';
$Tp_Ativo = '';
$PerfilAdmin = '';

if ($this->uri->segment(2) == 'editar') {
if(!empty($infoPerfil))
{
    foreach ($infoPerfil as $r)
    {
        $Id_CdPerfil = $r->Id_CdPerfil;
        $Ds_Perfil = $r->Ds_Perfil;
        $Tp_Ativo = $r->Tp_Ativo;
        $PerfilAdmin = $r->PerfilAdmin;
    }
}
}
?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-users"></i> <?php echo ($this->uri->segment(2) == 'cadastrar') ? 'Cadastrar Perfil' : 'Editar Perfil' ; ?>
            <small><?php echo ($this->uri->segment(2) == 'cadastrar') ? 'Adicionar' : 'Editar' ; ?></small>
        </h1>
    </section>

    <section class="content">

        <div class="row">
            <!-- left column -->
            <div class="col-md-8">
                <!-- general form elements -->

                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Preencha o campo abaixo</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <?php $this->load->helper("form"); ?>
                    <form role="form" id="addPerfil" action="<?php echo ($this->uri->segment(2) == 'cadastrar') ? base_url().'adicionaPerfil' : base_url().'editaPerfil'; ?>" method="post" role="form">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Ds_Perfil">Descrição</label>
                                        <input type="text" class="form-control required" value="<?php echo ($this->uri->segment(2) == 'cadastrar') ? set_value('Ds_Perfil') : $Ds_Perfil ; ?>" id="Ds_Perfil" name="Ds_Perfil" maxlength="128">
                                        <input type="hidden" value="<?php echo $Id_CdPerfil; ?>" name="Id_CdPerfil" id="Id_CdPerfil" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Tp_Ativo">Perfil ativo?</label>
                                        <select class="form-control required" id="Tp_Ativo" name="Tp_Ativo">
                                            <option value="S" <?php if ($this->uri->segment(2) == 'editar' && $Tp_Ativo == 'S') { echo 'selected'; } else if ($this->uri->segment(2) == 'cadastrar') { echo 'selected'; } ?>>Sim</option>
                                            <option value="N" <?php if ($this->uri->segment(2) == 'editar' && $Tp_Ativo == 'N') { echo 'selected'; } ?>>Não</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="PerfilAdmin">Perfil Admin?</label>
                                        <select class="form-control required" id="PerfilAdmin" name="PerfilAdmin">
                                            <option value="S" <?php if ($this->uri->segment(2) == 'editar' && $PerfilAdmin == 'S') { echo 'selected'; } ?>>Sim</option>
                                            <option value="N" <?php if ($this->uri->segment(2) == 'editar' && $PerfilAdmin == 'N') { echo 'selected'; } else if ($this->uri->segment(2) == 'cadastrar') { echo 'selected'; } ?>>Não</option>
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