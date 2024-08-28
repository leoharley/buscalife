<?php

$Id_Empresa = '';
$Nome_Empresa = '';
$CNPJ = '';
$Cd_EmpresaERP = '';
$End_Empresa = '';
$Nome_Contato = '';
$Telefone = '';
$Email_Empresa = '';
$Dt_Valida_Contrato = '';
$Tp_Ativo = '';

if ($this->uri->segment(2) == 'editar') {
if(!empty($infoEmpresa))
{
    foreach ($infoEmpresa as $r)
    {
        $Id_Empresa = $r->Id_Empresa;
        $Nome_Empresa = $r->Nome_Empresa;
        $CNPJ = $r->CNPJ;
        $Cd_EmpresaERP = $r->Cd_EmpresaERP;
        $End_Empresa = $r->End_Empresa;
        $Nome_Contato = $r->Nome_Contato;
        $Telefone = $r->Telefone;
        $Email_Empresa = $r->Email_Empresa;
        $Dt_Valida_Contrato = $r->Dt_Valida_Contrato;
        $Tp_Ativo = $r->Tp_Ativo;
    }
}
}

?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-users"></i> <?php echo ($this->uri->segment(2) == 'cadastrar') ? 'Cadastrar Empresa' : 'Editar Empresa' ; ?>
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
                    <form role="form" id="addEmpresa" action="<?php echo ($this->uri->segment(2) == 'cadastrar') ? base_url().'adicionaEmpresa' : base_url().'editaEmpresa'; ?>" method="post" role="form">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Nome_Empresa">Nome</label>
                                        <input type="text" class="form-control required" value="<?php echo ($this->uri->segment(2) == 'cadastrar') ? set_value('Nome_Empresa') : $Nome_Empresa ; ?>" id="Nome_Empresa" name="Nome_Empresa" maxlength="128">
                                        <input type="hidden" value="<?php echo $Id_Empresa; ?>" name="Id_Empresa" id="Id_Empresa" />
                                    </div>

                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="CNPJ">CNPJ</label>
                                        <input type="text" data-inputmask="'mask': '99.999.999/9999-99'" class="form-control required CNPJ" id="CNPJ" value="<?php echo ($this->uri->segment(2) == 'cadastrar') ? set_value('CNPJ') : $CNPJ ; ?>" name="CNPJ"
                                            maxlength="18">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Cd_EmpresaERP">Código</label>
                                        <input type="text" class="form-control required Cd_EmpresaERP" id="Cd_EmpresaERP" value="<?php echo ($this->uri->segment(2) == 'cadastrar') ? set_value('Cd_EmpresaERP') : $Cd_EmpresaERP ; ?>" name="Cd_EmpresaERP"
                                            maxlength="13">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="End_Empresa">Endereço</label>
                                        <input type="text" class="form-control required End_Empresa" id="End_Empresa" value="<?php echo ($this->uri->segment(2) == 'cadastrar') ? set_value('End_Empresa') : $End_Empresa ; ?>" name="End_Empresa"
                                            maxlength="100">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Nome_Contato">Nome do contato</label>
                                        <input type="text" class="form-control required Nome_Contato" id="Nome_Contato" value="<?php echo ($this->uri->segment(2) == 'cadastrar') ? set_value('Nome_Contato') : $Nome_Contato ; ?>" name="Nome_Contato"
                                            maxlength="128">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Telefone">Telefone</label>
                                        <input type="text" data-inputmask="'mask': '(99)99999-9999'"class="form-control required Telefone" id="Telefone" value="<?php echo ($this->uri->segment(2) == 'cadastrar') ? set_value('Telefone') : $Telefone ; ?>" name="Telefone"
                                            maxlength="15">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Email_Empresa">Email</label>
                                        <input type="text" class="form-control required email" id="Email_Empresa" value="<?php echo ($this->uri->segment(2) == 'cadastrar') ? set_value('Email_Empresa') : $Email_Empresa ; ?>" name="Email_Empresa"
                                            maxlength="128">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Dt_Valida_Contrato">Data de validade do contrato</label>
                                        <input type="date" class="form-control required Dt_Valida_Contrato" value="<?php echo ($this->uri->segment(2) == 'cadastrar') ? set_value('Dt_Valida_Contrato') : $Dt_Valida_Contrato ; ?>" id="Dt_Valida_Contrato" name="Dt_Valida_Contrato">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="Tp_Ativo">Empresa ativa?</label>
                                    <select class="form-control required" id="Tp_Ativo" name="Tp_Ativo">
                                        <option value="S" <?php if ($this->uri->segment(2) == 'editar' && $Tp_Ativo == 'S') { echo 'selected'; } else if ($this->uri->segment(2) == 'cadastrar') { echo 'selected'; } ?>>Sim</option>
                                        <option value="N" <?php if ($this->uri->segment(2) == 'editar' && $Tp_Ativo == 'N') { echo 'selected'; } ?>>Não</option>
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
<script src="<?php echo base_url(); ?>assets/js/addEmpresa.js" type="text/javascript"></script>
<script>
$(document).ready(function(){
    $(":input").inputmask();
});
</script>