<!DOCTYPE html>

<html lang="es">
<head>
	<title>Recuperar Contrase&ntilde;a</title>
	<meta charset="utf-8"/>
	<link rel="stylesheet" href="/iiet/assets/css/bootstrap.css"/>
	<link rel="stylesheet" href="/iiet/assets/css/colores.css"/>
	<link rel="stylesheet" href="/iiet/assets/css/fa-all.min.css"/>
    <link rel="stylesheet" href="/iiet/assets/css/datatables.min.css"/>
    <link rel="stylesheet" href="/iiet/assets/css/mdb.css"/>
	<link rel="stylesheet" href="/iiet/assets/css/tema-iiet.css"/>

	<link href="https://fonts.googleapis.com/css?family=Roboto:300,400" rel="stylesheet"/>

	<style type="text/css">
		.form-control {
			display: inline;
			width: 20rem;
		}
	</style>
</head>
<body>

<header class="mb-3">
	<div class="navbar navbar-dark navbar-expand-lg">
		<div class="container-fluid">
			<h2 class="col-6 text-light mb-0">GeohelmintSoft</h2>
		</div>
	</div>
</header>
<section class="container pt-5">
	<div class="row mb-5">
		<div class="col-12 text-center">
			<h3>Recuperar Contrase&ntilde;a</h3>
			<p>Por favor ingrese su Email para poder enviarle un email de recuperación de contrase&ntilde;a.</p>
		</div>
	</div>
    <form method="POST" action="/iiet/auth/forgot_password">
    	<div class="form-row justify-content-center">
    		<div class="col-6 form-group text-center">
    			<label for="identity" class="pr-2">Email</label>
    			<input type="email" for="identity" class="form-control" name="identity" required autocomplete="off" />
    		</div>
    	</div>
    	<div class="form-row justify-content-center">
    		<div class="col-2">
	    		<input type="submit" class="btn btn-primary btn-block" value="Enviar"/>
    		</div>
    	</div>
    </form>
</section>



<!-- <div id="infoMessage"><?php echo $message;?></div>

<?php echo form_open("auth/forgot_password");?>

      <p>
      	<label for="identity"><?php echo (($type=='email') ? sprintf(lang('forgot_password_email_label'), $identity_label) : sprintf(lang('forgot_password_identity_label'), $identity_label));?></label> <br />
      	<?php echo form_input($identity);?>
      </p>

      <p><?php echo form_submit('submit', lang('forgot_password_submit_btn'));?></p>

<?php echo form_close();?> -->

</body>
<script src="/iiet/assets/js/jquery-3.3.1.min.js"></script>
<script src="/iiet/assets/js/popper.min.js"></script>
<script src="/iiet/assets/js/bootstrap.min.js"></script>
</html>
