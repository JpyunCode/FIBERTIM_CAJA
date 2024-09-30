<!DOCTYPE html>
<html lang="en">

<?php
session_start();
include 'assets/php/functions/db_connect.php';

?>

<head>
	<meta charset="utf-8">
	<meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Gestion de pagos</title>
	<link rel="icon" type="image/x-icon" href="assets/img/favicon.png">
    <link href="assets/css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
	<?php
    #include('footer.php');
    ?>
    <?php
	if (isset($_SESSION['login_IdUsuario']))
		header("location:index.php?page=payments");
	?>

</head>
<style>
	body {
		width: 100%;
		height: calc(100%);
		position: fixed;
		top: 0;
		left: 0
	}

	main#main {
		width: 100%;
		height: calc(100%);
		display: flex;
		align-items: center;
		/*background-image: url(assets/uploads/background.jpg);*/
		background-size: cover;
	}
	.caja_popup 
	{
		display: none;
		position: absolute;
		padding:0;
		background-color:rgba(0, 0, 0, 0.5);
		width:100%;
		height:100%;
	}
	.contenedor_popup 
	{
		border-radius: 5px;
		top: 10%;
		left: 50%;
		position: absolute;
		transform: translate(-50%,-50%);
		width:400px;
		border-radius: 5px;
		transition: all 0.2s;
		
		
	}
</style>

<body class="bg-primary">


	<main id="main">

		<div class="align-self-center w-100">

			<div id="login-center" align="center">
				<div class="card col-md-3 ">
					<div class="card-body">
						<h1 class="text-center mb-5"><img src="assets/img/logo.jpg" width="249px"></h1>

						<form id="login-form">
							<div class="form-group">
								<label for="Correo" class="control-label">Correo</label>
								<input type="text" id="Correo" name="Correo" class="form-control">
							</div>
							<div class="form-group">
								<label for="Contraseña" class="control-label">Contraseña</label>
								<input type="password" id="Contraseña" name="Contraseña" class="form-control">
							</div>
							<div class="col-md-10 ml-auto">
							<!-- <a href="#" id="olvidar" title="Recuperar Clave">Recuperar Clave</a> -->
								<!-- <a class="" id="recuperar" onclick="abrirform()">Recuperar contraseña</a> -->
								<!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">Launch demo modal</button> -->
							</div>
							<br>
							<button class="btn btn-primary">Ingresar</button>
							<br>
						</form>
					</div>
				</div>
			</div>
		</div>
	</main>

	<a href="#" class="back-to-top"><i class="icofont-simple-up"></i></a>

</body>

<script>
	$('#login-form').submit(function(e) {
		e.preventDefault()
		$('#login-form button[type="button"]').attr('disabled', true).html('Logging in...');
		if ($(this).find('.alert-danger').length > 0)
			$(this).find('.alert-danger').remove();
		$.ajax({
			url: 'assets/php/functions/ajax.php?action=login',
			method: 'POST',
			data: $(this).serialize(),
			error: err => {
				console.log(err)
				$('#login-form button[type="button"]').removeAttr('disabled').html('Login');

			},
			success: function(resp) {
				if (resp == 1) {
					location.href = 'index.php?page=payments';
				} else {
					$('#login-form').prepend('<div class="alert alert-danger">Correo o Contraseña incorrecta.</div>')
					$('#login-form button[type="button"]').removeAttr('disabled').html('Login');
				}
			}
		})
	})
	
</script>

 
<script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
<!-- <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script> -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</html>