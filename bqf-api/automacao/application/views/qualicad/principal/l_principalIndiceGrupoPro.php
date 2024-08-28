<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      <i class="fa fa-users"></i> Listar Índice por Grupo de Procedimento
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
        <a class="btn btn-primary" href="<?php echo base_url(); ?>principalIndiceGrupoPro/cadastrar">
          <i class="fa fa-plus"></i> Adicionar índice por grupo de procedimento</a>
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
                    <th>Id Seq</th>
                    <th>Índice</th>
                    <th>Grupo de procedimento (descrição)</th>
                    <th>Data de início</th>
                    <th>Data de final</th>
                    <th>Valor índice</th>
                    <th>Valor M2 Filme</th>
                    <th>Honorário</th>
                    <th>UCO</th>
                    <th>Ativo?</th>
                    <th>Ações</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                      if(!empty($registrosIndiceGrupoPro))
                      {
                          foreach($registrosIndiceGrupoPro as $registro)
                          {
                      ?>
                    <tr>
                      <td>
                        <?php echo $registro->Id_IndiceGrupo ?>
                      </td>
                      <td>
                        <?php echo $registro->Ds_indice ?>
                      </td>
                      <td>
                        <?php echo $registro->CodGrupoPro .'-'.$registro->Ds_GrupoPro ?>
                      </td>
                      <td>
                        <?php echo ($registro->Dt_IniVigencia != '0000-00-00') ? date("d/m/Y", strtotime($registro->Dt_IniVigencia)) : ''; ?>
                      </td>
                      <td>
                        <?php echo ($registro->Dt_FimVigencia != '0000-00-00') ? date("d/m/Y", strtotime($registro->Dt_FimVigencia)) : ''; ?>
                      </td>
                      <td>
                        <?php echo $registro->Vl_Indice ?>
                      </td>
                      <td>
                        <?php echo $registro->Vl_M2Filme ?>
                      </td>
                      <td>
                        <?php echo $registro->Vl_Honorario ?>
                      </td>
                      <td>
                        <?php echo $registro->Vl_UCO ?>
                      </td>
                      <td>
                        <?php echo ($registro->Tp_Ativo == 'S') ? 'Sim' : 'Não'; ?>
                      </td>
                      <td class="text-center">
                        <!--  <a class="btn btn-sm btn-primary" href="<?php //echo base_url().'log-history/'.$record->userId; ?>" title="Log geçmişi">
                              <i class="fa fa-history"></i>
                          </a> -->
                          <a class="btn btn-sm btn-info" href="<?php echo base_url().'principalIndiceGrupoPro/editar/'.$registro->Id_IndiceGrupo; ?>" title="Editar">
                              <i class="fa fa-pencil"></i>
                          </a>
                          <a class="btn btn-sm btn-danger deleteUser" href="<?php echo base_url().'apagaIndiceGrupoPro/'.$registro->Id_IndiceGrupo; ?>" title="Excluir">
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