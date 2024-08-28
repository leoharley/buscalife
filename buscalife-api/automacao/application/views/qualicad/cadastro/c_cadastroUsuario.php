<?php

$Id_Usuario = '';
$Nome_Usuario = '';
$Email = '';
$Cpf_Usuario = '';
$Admin = '';
$Tp_Ativo = '';

if ($this->uri->segment(2) == 'editar') {
if(!empty($infoUsuario))
{
    foreach ($infoUsuario as $r)
    {
        $Id_Usuario = $r->Id_Usuario;
        $Nome_Usuario = $r->Nome_Usuario;
        $Email = $r->Email;
        $Cpf_Usuario = $r->Cpf_Usuario;
        $Admin = $r->Admin;
        $Tp_Ativo = $r->Tp_Ativo;
    }
}
}

?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-users"></i> <?php echo ($this->uri->segment(2) == 'cadastrar') ? 'Cadastrar Usuários' : 'Editar Usuários' ; ?>
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
                        <h3 class="box-title">Preencha os campos abaixos</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <?php $this->load->helper("form"); ?>
                    <form role="form" id="addUser" action="<?php echo ($this->uri->segment(2) == 'cadastrar') ? base_url().'adicionaUsuario' : base_url().'editaUsuario'; ?>" method="post" role="form">
                        <div class="box-body">
                            <div class="row">

                                <!-- VARCHAR/INTEGER/FLOAT -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Nome_Usuario">Nome</label>
                                        <input type="text" class="form-control required" value="<?php echo ($this->uri->segment(2) == 'cadastrar') ? set_value('Nome_Usuario') : $Nome_Usuario ; ?>" id="Nome_Usuario" name="Nome_Usuario" maxlength="128">
                                        <input type="hidden" value="<?php echo $Id_Usuario; ?>" name="Id_Usuario" id="Id_Usuario" />
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Cpf_Usuario">CPF</label>
                                        <input data-inputmask="'mask': '999.999.999-99'" type="text" class="form-control required cpf_usuario" id="Cpf_Usuario" value="<?php echo ($this->uri->segment(2) == 'cadastrar') ? set_value('Cpf_Usuario') : $Cpf_Usuario; ?>" name="Cpf_Usuario"
                                            maxlength="14">
                                    </div>
                                </div>

                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Email">Email</label>
                                        <input type="text" class="form-control email required" value="<?php echo ($this->uri->segment(2) == 'cadastrar') ? set_value('Email') : $Email; ?>" id="Email" name="Email" maxlength="128">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Tp_Ativo">Usuário ativo?</label>
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
                                        <label for="Senha">Senha</label>
                                        <input type="password" class="form-control <?php echo ($this->uri->segment(2) == 'cadastrar') ? 'required' : '' ; ?>" id="Senha" name="Senha" maxlength="20">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="resenha">Redigite a senha</label>
                                        <input type="password" class="form-control <?php echo ($this->uri->segment(2) == 'cadastrar') ? 'required' : '' ; ?> equalTo" id="resenha" name="resenha" maxlength="20">
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
<script src="<?php echo base_url(); ?>assets/js/<?php echo ($this->uri->segment(2) == 'cadastrar') ?'addUser.js':'addUserEditar.js';?>" type="text/javascript"></script>
<script>
$(document).ready(function(){
    $(":input").inputmask();
});
</script>