<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-users"></i> Cadastrar Proibição
            <small>Associar / Adicionar</small>
        </h1>
    </section>

    <section class="content">

        <div class="row">
            <!-- left column -->
            <div class="col-md-8">
                <!-- general form elements -->



                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Selecione e preencha os campos abaixo</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <?php $this->load->helper("form"); ?>
                    <form role="form" id="addUser" action="<?php echo base_url() ?>addNewUser" method="post" role="form">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="dsprofat">ProFat associada</label>
                                        <select class="form-control required" id="dsprofat" name="dsprofat">
                                            <option value="1">PRO_FAT_1</option>
											<option value="2">PRO_FAT_2</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="dsplano">Plano associado</label>
                                        <select class="form-control required" id="dsplano" name="dsplano">
                                            <option value="1">PLANO_1</option>
											<option value="2">PLANO_2</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="tpproibicao">Tipo de proibição</label>
                                        <select class="form-control required" id="tpproibicao" name="tpproibicao">
                                            <option value="1">TP_PROIBICAO_1</option>
											<option value="2">TP_PROIBICAO_2</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="dtiniproibicao">Data de início da proibição</label>
                                        <input type="date" class="form-control required" value="<?php echo set_value('dtiniproibicao'); ?>" id="dtiniproibicao" name="dtiniproibicao">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="dtfimproibicao">Data de fim da proibição</label>
                                        <input type="date" class="form-control required" value="<?php echo set_value('dtfimproibicao'); ?>" id="dtfimproibicao" name="dtfimproibicao">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="cdsetor">Cód. do setor</label>
                                        <input type="text" class="form-control required" value="<?php echo set_value('cdsetor'); ?>" id="cdsetor" name="cdsetor"
                                        maxlength="11">
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