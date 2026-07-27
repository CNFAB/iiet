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
			<h3>Nueva Contrase&ntilde;a</h3>
			<p>Por favor ingrese su nueva contrase&ntilde;a.</p>
		</div>
	</div>
    <form method="POST" action="/iiet/auth/forgot_password">
    	<div class="form-row justify-content-center">
    		<div class="col-6">
    			<div class="row justify-content-center align-items-end mb-4">
    				<div class="col-4 text-right">
    					<label for="identity" class="mb-0">Contrase&ntilde;a</label>
    				</div>
    				<div class="col-8">
    					<input type="password" for="identity" class="form-control" name="identity" required autocomplete="off" />
    				</div>
    			</div>
    			<div class="row justify-content-center align-items-end mb-5">
    				<div class="col-4 text-right">
    					<label for="identity" class="mb-0">Repita la Contrase&ntilde;a</label>
    				</div>
    				<div class="col-8">
    					<input type="password" for="identity" class="form-control" name="identity" required autocomplete="off" />
    				</div>
    			</div>
    		</div>
    	</div>
    	<div class="form-row justify-content-center">
    		<div class="col-2">
	    		<input type="submit" class="btn btn-primary btn-block" value="Aceptar"/>
    		</div>
    	</div>
    </form>
</section>
</body>
<script src="/iiet/assets/js/jquery-3.3.1.min.js"></script>
<script src="/iiet/assets/js/popper.min.js"></script>
<script src="/iiet/assets/js/bootstrap.min.js"></script>
</html>
