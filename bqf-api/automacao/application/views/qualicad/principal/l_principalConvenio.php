<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      <i class="fa fa-users"></i> Listar Convênios
      <small>Listar</small>
    </h1>
  </section>

  <style>
  table {
    border-color: #808080!important;
  }
  th {
    border-color: #808080!important;
    color: black;
    background-color: #d0d0d0;
    }
  td {
    border-color: #808080!important;
    color: black;
    }
  .box {
    width: 100%!important;
  }
  </style>
  
  <section class="content">
    <div class="col-xs-12">
      <div class="text-left">
        <a class="btn btn-primary" href="<?php echo base_url(); ?>principalConvenio/cadastrar">
          <i class="fa fa-plus"></i> Adicionar convênio</a>
      </div>
      <br/>
      <div class="box">
        <div class="box-header">
          <div class="box-tools">
          </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body table-responsive no-padding">
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
            <div class="panel-body">
              <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                <thead>
                  <tr>
                  <!--  <th>Id Seq</th> -->
                    <th>Convênio (descrição)</th>
                    <th>CNPJ</th>
                    <th>Código ERP</th>
                    <th>Tipo</th>
                    <th>Convênio ativo?</th>
                    <th>Data de início</th>
                    <th>Data de vigência</th>
                    <th>Status Homolog.</th>
                    <th>Ações</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                      if(!empty($registrosConvenios))
                      {
                          foreach($registrosConvenios as $registro)
                          {
                      ?>
                    <tr>
                    <!--  <td>
                        <?php //echo $registro->Id_Convenio ?>
                      </td> -->
                      <td>
                        <?php echo $registro->Ds_Convenio ?>
                      </td>
                      <td>
                        <?php echo $registro->CNPJ_Convenio ?>
                      </td>
                      <td>
                        <?php echo $registro->Cd_ConvenioERP ?>
                      </td>
                      <td>
                            <?php if ($registro->Tp_Convenio == '1') { echo 'Convênio'; } else if ($registro->Tp_Convenio == '2') { echo 'Filantrópico'; } else if ($registro->Tp_Convenio == '3') { echo 'Particular'; } ?>
                      </td>
                      <td>
                          <?php echo ($registro->Tp_Ativo == 'S') ? 'Sim' : 'Não'; ?>
                      </td>
                      <td>
                          <?php echo ($registro->Dt_InicioConvenio != null) ? date("d/m/Y", strtotime($registro->Dt_InicioConvenio)) : ''; ?>
                      </td>
                      <td>
                          <?php echo ($registro->Dt_VigenciaConvenio != null) ? date("d/m/Y", strtotime($registro->Dt_VigenciaConvenio)) : ''; ?>
                      </td>
                      <td>
                      <?php echo $registro->ds_status ?>
                      </td>
                      <td class="text-center">
                        <!--  <a class="btn btn-sm btn-primary" href="<?php //echo base_url().'log-history/'.$record->userId; ?>" title="Log geçmişi">
                              <i class="fa fa-history"></i>
                          </a> -->
                          <a class="btn btn-sm btn-info" href="<?php echo base_url().'principalConvenio/editar/'.$registro->Id_Convenio; ?>" title="Editar">
                              <i class="fa fa-pencil"></i>
                          </a>
                          <a class="btn btn-sm btn-danger deleteUser" href="<?php echo base_url().'apagaConvenio/'.$registro->Id_Convenio; ?>" title="Excluir">
                              <i class="fa fa-trash-o"></i>
                          </a>
                      </td>
                    </tr>
                    <?php
                          }
                      }
                      ?>
                </tbody>
              </table>
            </div>
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
    </div>
</div>
</section>
</div>