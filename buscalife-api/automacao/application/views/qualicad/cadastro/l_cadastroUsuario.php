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
      <i class="fa fa-users"></i> Listar Usuários
      <small>Listar</small>
    </h1>
  </section>
  <section class="content">
    <div class="col-xs-12">
      <div class="text-left">
        <a class="btn btn-primary" href="<?php echo base_url(); ?>cadastroUsuario/cadastrar">
          <i class="fa fa-plus"></i> Adicionar usuário</a>
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
                    <th>CPF</th>
                    <th>E-mail</th>
                    <th>Usuário ativo?</th>
                  <!--  <th>Admin?</th> -->
                  <!--  <th>Data ativo</th>
                    <th>Data inativo</th> -->                    
                    <th>Ações</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                      if(!empty($registrosUsuarios))
                      {
                          foreach($registrosUsuarios as $registro)
                          {
                      ?>
                    <tr>
                      <td>
                        <?php echo $registro->Id_Usuario ?>
                      </td>
                      <td>
                        <?php echo $registro->Nome_Usuario ?>
                      </td>
                      <td>
                        <?php echo $registro->Cpf_Usuario ?>
                      </td>
                      <td>
                        <?php echo $registro->Email ?>
                      </td>
                      <td>
                        <?php echo ($registro->Tp_Ativo == 'S') ? 'Sim' : 'Não'; ?>
                      </td>
                    <!--  <td>
                        <?php //echo ($registro->Admin == 'S') ? 'Sim' : 'Não'; ?>
                      </td> -->
                  <!--    <td>
                        <?php //echo ($registro->Dt_Ativo != null) ? date("d/m/Y", strtotime($registro->Dt_Ativo)) : ''; ?>
                      </td>
                      <td>
                        <?php //echo ($registro->Dt_Inativo != null) ? date("d/m/Y", strtotime($registro->Dt_Inativo)) : ''; ?>
                      </td> -->
                      <td class="text-center">
                          <a class="btn btn-sm btn-info" href="<?= base_url().'cadastroUsuario/editar/'.$registro->Id_Usuario ?>" title="Editar">
                              <i class="fa fa-pencil"></i>
                          </a>
                          <a class="btn btn-sm btn-danger deleteUser" href="<?= base_url().'apagaUsuario/'.$registro->Id_Usuario ?>" data-userid="<?= $registro->Id_Usuario ?>" title="Excluir">
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