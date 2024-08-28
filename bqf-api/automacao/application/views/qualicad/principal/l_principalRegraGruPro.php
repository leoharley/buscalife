<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      <i class="fa fa-users"></i> Listar Regra GruPro
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
        <a class="btn btn-primary" href="<?php echo base_url(); ?>principalRegraGruPro/cadastrar">
          <i class="fa fa-plus"></i> Adicionar regra grupro</a>
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
                    <th>GrupoPro</th>
                    <th>Regra</th>
                    <th>Faturamento</th>
                    <th>Percentual pago</th>
                    <th>Início vigência</th>
                    <th>Fim vigência</th>
                    <th>Ativo?</th>
                    <th>Ações</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                      if(!empty($registroRegraGruPro))
                      {
                          foreach($registroRegraGruPro as $registro)
                          {
                      ?>
                    <tr>
                      <td>
                        <?php echo $registro->Id_RegraGruPro ?>
                      </td>
                      <td>
                        <?php echo $registro->CodGrupoPro .'-'.$registro->Ds_GrupoPro ?>
                      </td>
                      <td>
                        <?php echo $registro->Ds_Regra ?>
                      </td>
                      <td>
                        <?php echo $registro->Ds_Faturamento ?>
                      </td>
                      <td>
                        <?php echo $registro->Perc_Pago ?>
                      </td>
                      <td>
                        <?php echo ($registro->Dt_IniVigencia != '0000-00-00') ? date("d/m/Y", strtotime($registro->Dt_IniVigencia)) : ''; ?>                        
                      </td>
                      <td>
                        <?php echo ($registro->Dt_FimVigencia != '0000-00-00') ? date("d/m/Y", strtotime($registro->Dt_FimVigencia)) : ''; ?>                        
                      </td>
                      <td>
                        <?php echo ($registro->Tp_Ativo == 'S') ? 'Sim' : 'Não'; ?>
                      </td>
                       
                      <td class="text-center">
                        <!--  <a class="btn btn-sm btn-primary" href="<?php //echo base_url().'log-history/'.$record->userId; ?>" title="Log geçmişi">
                              <i class="fa fa-history"></i>
                          </a> -->
                          <a class="btn btn-sm btn-info" href="<?php echo base_url().'principalRegraGruPro/editar/'.$registro->Id_RegraGruPro ; ?>" title="Editar">
                              <i class="fa fa-pencil"></i>
                          </a>
                          <a class="btn btn-sm btn-danger deleteUser" href="<?php echo base_url().'apagaRegraGruPro/'.$registro->Id_RegraGruPro ; ?>" title="Excluir">
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