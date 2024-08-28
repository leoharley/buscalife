<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <title>QUALICAD | Modelo de painel</title>
  <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
  <link href="<?php echo base_url(); ?>assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css"
  />
  <link href="<?php echo base_url(); ?>assets/dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body class="login-page">
<img src="<?php echo base_url(); ?>assets/images/bg.jpeg" style="position:absolute;width:100%;height:100%;top:0;z-index: -1">
  <div class="login-box" style="z-index:1;margin-left:65%;margin-top:200px;">
    <div class="login-logo">
    <!--   <a href="#">
			<b>Sistema - Qualidade no Cadastro (Convênio)</b></a> -->
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body" style="background-color: #0020333d">
      <p class="login-box-msg">Login</p>
      <?php $this->load->helper('form'); ?>
      <div class="row">
        <div class="col-md-12">
          <?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
        </div>
      </div>
      <?php
        $this->load->helper('form');
        $error = $this->session->flashdata('error');
        if($error)
        {
            ?>
        <div class="alert alert-danger alert-dismissable">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
          <?php echo $error; ?>
        </div>
        <?php }
        $success = $this->session->flashdata('success');
        if($success)
        {
            ?>
        <div class="alert alert-success alert-dismissable">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
          <?php echo $success; ?>
        </div>
        <?php } ?>

        <form action="<?php echo base_url(); ?>escolheEmpresa" method="post">
          <div class="form-group has-feedback">
            <input type="email" class="form-control" value="<?php echo $this->session->userdata('email')?>" name="email" disabled />
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            <input type="password" class="form-control" value="password" name="password" disabled />
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          </div>
          <div class="form-group">
              <label for="Id_Empresa">Empresa</label>
              <select class="form-control required" id="Id_Empresa" name="Id_Empresa">
                  <?php
                  if(!empty($empresasPerfilUsuario))
                  {
                      foreach ($empresasPerfilUsuario as $empresa)
                      {
                          ?>
                      <option value="<?php echo $empresa->Id_Empresa ?>">
                          <?php echo $empresa->Nome_Empresa ?>
                      </option>
                      <?php
                      }
                  }
                  ?>
              </select>
          </div>
          <div class="row">
            <div class="col-xs-8">
              <!-- <div class="checkbox icheck">
                <label>
                  <input type="checkbox"> Remember Me
                </label>
              </div>  -->
            </div>
            <!-- /.col -->
            <div class="col-xs-12">
              <div class="col-xs-2">
              </div>
              <div class="col-xs-8">
                <input type="submit" class="btn btn-primary btn-block btn-flat" value="Painel de Controle" />
              </div>
              <div class="col-xs-2">
              </div>
            </div>
            <!-- /.col -->
          </div>
        </form>

    </div>
    <!-- /.login-box-body -->
  </div>
  <!-- /.login-box -->

  <script src="<?php echo base_url(); ?>assets/js/jQuery-2.1.4.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
</body>

</html>