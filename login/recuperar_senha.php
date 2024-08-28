<?php
include('inc/header.php');
login_check_pages();
?>
    <div class="row">
				<div class="col-lg-6 col-lg-offset-3 col-md-6 col-md-offset-3">
					<div class="alert-placeholder">
                        <?php recover();?>
					</div>
					<div class="panel panel-success">
						<div class="panel-body">
							<div class="row">
								<div class="col-lg-12">									
									<div class="col-xs-12">
										<div style="text-align:center">
											<img src="img/logo.png?ver=1.3" class="logo">
										</div>
										<div style="text-align:center">
											<h3 class="pt-4 font-weight-bold">Recuperar senha</h3>
										</div>
									</div>
									<form id="register-form" method="post" role="form" autocomplete="off">
										<div class="form-group">
											<label for="email">Endereço de E-mail</label>
											<input type="email" name="email" id="email" tabindex="1" class="form-control" placeholder="E-mail" value="" autocomplete="off" />
										</div>
										<div class="form-group">
											<div class="row">
												<div class="col-lg-6 col-sm-6 col-xs-6">
													<input type="submit" name="cancel-submit" id="cencel-submit" tabindex="2" class="form-control btn btn-danger" value="Cancelar" />
												</div>
												<div class="col-lg-6 col-sm-6 col-xs-6">
													<input type="submit" name="recover-submit" id="recover-submit" tabindex="2" class="form-control btn btn-primary" value="Enviar link de recuperação" />
												</div>
											</div>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
<?php
include('inc/footer.php');
?>