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
  
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      <i class="fa fa-users"></i> Listar Empresas
      <small>Listar</small>
    </h1>
  </section>
  <section class="content">
    <div class="col-xs-12">
      <div class="text-left">
        <a class="btn btn-primary" href="<?php echo base_url(); ?>cadastroEmpresa/cadastrar">
          <i class="fa fa-plus"></i> Adicionar empresa</a>
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
                    <th>Id</th>
                    <th>Nome</th>
                    <th>CNPJ</th>
                    <th>Cd_EmpresaERP</th>
                    <th>Endereço</th>
                    <th>Contato</th>
                    <th>Telefone</th>
                    <th>Email</th>
                    <th>Val. contrato</th>
                  <!--  <th>Data ativa</th>
                    <th>Data inativa</th> -->
                    <th>Empresa ativa?</th>
                    <th>Ações</th>
                  </tr>
                </thead>
                <tbody>  
                  <?php
                      if(!empty($registrosEmpresas))
                      {
                          foreach($registrosEmpresas as $registro)
                          {
                      ?>
                    <tr>
                      <td>
                        <?php echo $registro->Id_Empresa ?>
                      </td>
                      <td>
                        <?php echo $registro->Nome_Empresa ?>
                      </td>
                      <td>
                        <?php echo $registro->CNPJ ?>
                      </td>
                      <td>
                        <?php echo $registro->Cd_EmpresaERP ?>
                      </td>
                      <td>
                        <?php echo $registro->End_Empresa ?>
                      </td>
                      <td>
                        <?php echo $registro->Nome_Contato ?>
                      </td>
                      <td>
                        <?php echo $registro->Telefone ?>
                      </td>
                      <td>
                        <?php echo $registro->Email_Empresa ?>
                      </td>
                      <td>
                        <?php echo date("d/m/Y", strtotime($registro->Dt_Valida_Contrato)) ?>
                      </td>
                    <!--  <td>
                        <?php // echo ($registro->Dt_Ativo != null) ? date("d/m/Y", strtotime($registro->Dt_Ativo)) : ''; ?>
                      </td>
                      <td>
                        <?php // echo ($registro->Dt_Inativo != null) ? date("d/m/Y", strtotime($registro->Dt_Inativo)) : ''; ?>
                      </td> -->
                      <td>
                        <?php echo ($registro->Tp_Ativo == 'S') ? 'Sim' : 'Não'; ?>
                      </td>
                      <td class="text-center">
                        <!--  <a class="btn btn-sm btn-primary" href="<?php //echo base_url().'log-history/'.$record->userId; ?>" title="Log geçmişi">
                              <i class="fa fa-history"></i>
                          </a> -->
                          <a class="btn btn-sm btn-info" href="<?php echo base_url().'cadastroEmpresa/editar/'.$registro->Id_Empresa; ?>" title="Editar">
                              <i class="fa fa-pencil"></i>
                          </a>
                          <a class="btn btn-sm btn-danger deleteUser" href="<?php echo base_url().'apagaEmpresa/'.$registro->Id_Empresa; ?>" data-userid="<?php echo $registro->Id_Empresa; ?>" title="Excluir">
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