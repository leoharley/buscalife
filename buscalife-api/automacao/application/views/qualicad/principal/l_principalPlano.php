<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      <i class="fa fa-users"></i> Listar Planos
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
        <a class="btn btn-primary" href="<?php echo base_url(); ?>principalPlano/cadastrar">
          <i class="fa fa-plus"></i> Adicionar plano</a>
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
              <table style="width:100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                <thead>
                  <tr>
                    <th>Id Seq</th>
                    <th>Plano (descrição)</th>
                    <th>Convênio (descrição)</th>
                    <th>Índice (descrição)</th>
                    <th>Regra (descrição)</th>
                    <th>Código ERP</th>
                    <th>Tipo acomodação padrão</th>
                    <th>Plano ativo?</th>
                    <th>Ações</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                      if(!empty($registrosPlanos))
                      {
                          foreach($registrosPlanos as $registro)
                          {
                      ?>
                    <tr>
                      <td>
                        <?php echo $registro->Id_Plano ?>
                      </td>
                      <td>
                        <?php echo $registro->Ds_Plano ?>
                      </td>
                      <td>
                        <?php echo $registro->Ds_Convenio ?>
                      </td>
                      <td>
                        <?php echo $registro->Ds_indice ?>
                      </td>
                    <td>
                        <?php echo $registro->Ds_Regra ?>
                    </td>
                      <td>
                        <?php echo $registro->Cd_PlanoERP ?>
                      </td>
                      <td>
                        <?php if ($registro->Tp_AcomodacaoPadrao == '1') { echo 'Enfermaria'; } else if ($registro->Tp_AcomodacaoPadrao == '2') { echo 'Apartamento'; } ?>
                      </td>
                      <td>
                        <?php echo ($registro->Tp_Ativo == 'S') ? 'Sim' : 'Não'; ?>
                      </td>
                      <td class="text-center">
                        <!--  <a class="btn btn-sm btn-primary" href="<?php //echo base_url().'log-history/'.$record->userId; ?>" title="Log geçmişi">
                              <i class="fa fa-history"></i>
                          </a> -->
                          <a class="btn btn-sm btn-info" href="<?php echo base_url().'principalPlano/editar/'.$registro->Id_Plano; ?>" title="Editar">
                              <i class="fa fa-pencil"></i>
                          </a>
                          <a class="btn btn-sm btn-danger deleteUser" href="<?php echo base_url().'apagaPlano/'.$registro->Id_Plano; ?>" title="Excluir">
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