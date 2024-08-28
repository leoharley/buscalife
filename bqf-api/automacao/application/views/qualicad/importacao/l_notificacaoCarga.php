<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      <i class="fa fa-users"></i> Listar Notificação Carga
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
                    <th>Id Notificação</th>
                    <th>Id Empresa</th>
                    <th>Id Convenio</th>
                    <th>Tp Carga</th>
                    <th>Nome Arquivo</th>
                    <th>Dt Notificação</th>
                    <th>Link para Download</th>
                    <th>Ações</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                      if(!empty($infoNotificacaoCarga))
                      {
                          foreach($infoNotificacaoCarga as $registro)
                          {
                      ?>
                    <tr>
                      <td>
                        <?php echo $registro->id_notificacao_carga ?>
                      </td>
                      <td>
                        <?php echo $registro->id_empresa ?>
                      </td>
                      <td>
                        <?php echo $registro->id_convenio ?>
                      </td>
                      <td>
                        <?php echo $registro->filetype ?>
                      </td>
                      <td>
                        <?php echo $registro->filename ?>
                      </td>
                      <td>
                        <?php echo date("d/m/Y", strtotime($registro->dt_notificacao_carga)) ?>
                      </td>
                      <td>
                        <?php echo '<a href="'.$registro->url.'" target="_blank">'.$registro->url.'</a>' ?>
                      </td>
                      <td class="text-center">
                          <a class="btn btn-sm btn-danger deleteUser" href="<?php echo base_url().'limpaNotificacaoCarga/'.$registro->id_notificacao_carga; ?>" title="Limpar">
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