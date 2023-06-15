<!DOCTYPE html>
<html lang="en">

<?php
session_start();
include('db_connect.php');

?>

<head>
	<meta charset="utf-8">
	<meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Gestion de pagos</title>
	<link rel="icon" type="image/x-icon" href="assets/img/favicon.png">
    <link href="assets/css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
  

	<?php
    #include('footer.php');
    ?>
    <?php
	if (isset($_SESSION['login_id']))
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
		background-image: url(assets/uploads/background.jpg);
		background-size: cover;
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
								<label for="username" class="control-label">Correo</label>
								<input type="text" id="username" name="username" class="form-control">
							</div>
							<div class="form-group">
								<label for="password" class="control-label">Contraseña</label>
								<input type="password" id="password" name="password" class="form-control">
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
			url: 'ajax.php?action=login',
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
					$('#login-form').prepend('<div class="alert alert-danger">Username or password is incorrect.</div>')
					$('#login-form button[type="button"]').removeAttr('disabled').html('Login');
				}
			}
		})
	})
</script>
  
<script src="https://code.jquery.com/jquery-3.7.0.js" integrity="sha256-JlqSTELeR4TLqP0OG9dxM7yDPqX1ox/HfgiSLBj8+kM=" crossorigin="anonymous"></script>
</html>