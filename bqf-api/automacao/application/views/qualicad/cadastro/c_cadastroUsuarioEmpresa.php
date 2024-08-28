
<?php

$Id_UsuEmp  = '';
$TbEmpresa_Id_Empresa = '';
$TbPerfil_Id_CdPerfil = '';
$Nome_Usuario = '';
$Nome_Empresa = '';

if(!empty($infoUsuarioEmpresa))
{
    foreach ($infoUsuarioEmpresa as $r)
    {
        $Id_UsuEmp = $r->Id_UsuEmp;
        $TbEmpresa_Id_Empresa = $r->TbEmpresa_Id_Empresa;
        $TbPerfil_Id_CdPerfil = $r->TbPerfil_Id_CdPerfil;
        $Nome_Usuario = $r->Nome_Usuario;
        $Nome_Empresa = $r->Nome_Empresa;
    }
}

?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-users"></i> Cadastrar Usuário / Empresa
            <small>Associar</small>
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
                <?php $this->load->helper('form'); ?>
                <div class="row">
                    <div class="col-md-12">
                    <?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
                    </div>
                </div>
                <?php
                    $this->load->helper('form');
                    $error = $this->session->flashdata('error');
                    if($error)
                    {
                        ?>
                    <div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <?php echo $error; ?>
                    </div>
                    <?php }
                    $success = $this->session->flashdata('success');
                    if($success)
                    {
                        ?>
                    <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <?php echo $success; ?>
                    </div>
                    <?php } ?>

                    <form role="form" id="addUser" action="<?php echo base_url() ?>adicionaUsuarioEmpresa" method="post" role="form">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Id_Usuario">Usuário</label>
                                        <select class="form-control required" id="Id_Usuario" name="Id_Usuario">
                                            <?php
                                            if(!empty($infoUsuarioCriados))
                                            {
                                                foreach ($infoUsuarioCriados as $usuario)
                                                {
                                                    ?>
                                                <option value="<?php echo $usuario->Id_Usuario ?>">
                                                    <?php echo $usuario->Nome_Usuario ?>
                                                </option>
                                                <?php
                                                }
                                            } else {
                                                echo '<option value="0">VOCÊ NÃO CADASTROU USUÁRIO</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Id_Empresa">Empresa</label>
                                        <select class="form-control required" id="Id_Empresa" name="Id_Empresa">
                                            <?php
                                            if(!empty($infoEmpresasCriadas))
                                            {
                                                foreach ($infoEmpresasCriadas as $empresa)
                                                {
                                                    ?>
                                                <option value="<?php echo $empresa->Id_Empresa ?>" <?php if($empresa->Id_Empresa == $TbEmpresa_Id_Empresa) {echo "selected=selected";} ?>>
                                                    <?php echo $empresa->Nome_Empresa ?>
                                                </option>
                                                <?php
                                                }
                                            } else {
                                                echo '<option value="0">VOCÊ NÃO CADASTROU EMPRESA</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Id_CdPerfil">Perfil</label>
                                        <select class="form-control required" id="Id_CdPerfil" name="Id_CdPerfil">
                                        <!--    <option value="99">Administrador</option> -->
                                            <?php
                                            if(!empty($infoPerfis))
                                            {
                                                foreach ($infoPerfis as $perfil)
                                                {
                                                    ?>
                                                <option value="<?php echo $perfil->Id_CdPerfil  ?>" <?php if($perfil->Id_CdPerfil == $TbPerfil_Id_CdPerfil) {echo "selected=selected";} ?>>
                                                    <?php echo $perfil->Ds_Perfil ?>
                                                </option>
                                                <?php
                                                }
                                            }
                                            ?>
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