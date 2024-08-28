<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      <i class="fa fa-users"></i> Listar Fração Simpro Bra
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
        <a class="btn btn-primary" href="<?php echo base_url(); ?>principalFracaoSimproBra/cadastrar">
          <i class="fa fa-plus"></i> Adicionar fração</a>
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
                    <th>ProFat (descrição)</th>
                    <th>Faturamento (descrição)</th>
                    <th>TUSS (descrição)</th>
                    <th>Fração Simpro Bra (descrição)</th>
                    <th>Laboratório (descrição)</th>
                    <th>Apresentação (descrição)</th>
                    <th>Tipo MatMED</th>
                    <th>Valor Fator Divisão</th>
                    <th>Qtd. Produto</th>
                    <th>Ativo?</th>
                    <th>Ações</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                      if(!empty($registrosFracaoSimproBra))
                      {
                          foreach($registrosFracaoSimproBra as $registro)
                          {
                      ?>
                    <tr>
                      <td>
                        <?php echo $registro->Id_FracaoSimproBra ?>
                      </td>
                      <td>
                        <?php echo $registro->TbProFat_Cd_ProFat ?>
                      </td>
                      <td>
                        <?php echo $registro->TbFaturamento_Id_Faturamento ?>
                      </td>
                      <td>
                        <?php echo $registro->TbTUSS_Id_Tuss ?>
                      </td>
                      <td>
                        <?php echo $registro->Ds_FracaoSimproBra ?>
                      </td>
                      <td>
                        <?php echo $registro->Ds_Laboratorio ?>
                      </td>
                      <td>
                        <?php echo $registro->Ds_Apresentacao ?>
                      </td>
                      <td>
                        <?php echo $registro->Tp_MatMed ?>
                      </td>
                      <td>
                        <?php echo $registro->Vl_FatorDivisao ?>
                      </td>
                      <td>
                        <?php echo $registro->Qt_Prod ?>
                      </td>
                      <td>
                        <?php echo ($registro->Tp_Ativo == 'S') ? 'Sim' : 'Não'; ?>
                      </td>
                      <td class="text-center">
                        <!--  <a class="btn btn-sm btn-primary" href="<?php //echo base_url().'log-history/'.$record->userId; ?>" title="Log geçmişi">
                              <i class="fa fa-history"></i>
                          </a> -->
                          <a class="btn btn-sm btn-info" href="<?php echo base_url().'principalFracaoSimproBra/editar/'.$registro->Id_FracaoSimproBra; ?>" title="Editar">
                              <i class="fa fa-pencil"></i>
                          </a>
                          <a class="btn btn-sm btn-danger deleteUser" href="<?php echo base_url().'apagaFracaoSimproBra/'.$registro->Id_FracaoSimproBra; ?>" title="Excluir">
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