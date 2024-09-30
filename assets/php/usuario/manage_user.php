<?php
include __DIR__.'/../functions/db_connect.php';
session_start();
if (isset($_GET['IdUsuario'])) {
	$user = $conn->query("SELECT * FROM TUsuarios where IdUsuario =" . $_GET['IdUsuario']);
	foreach ($user->fetch_array() as $k => $v) {
		$meta[$k] = $v;
	}
}
?>
<div class="container-fluid">
	<div id="msg"></div>

	<form action="" id="manage-user">
		<input type="hidden" name="IdUsuario" value="<?php echo isset($meta['IdUsuario']) ? $meta['IdUsuario'] : '' ?>">
		<div class="form-group">
			<label for="Nombre">Nombre</label>
			<input type="text" name="Nombre" id="Nombre" class="form-control" value="<?php echo isset($meta['Nombre']) ? $meta['Nombre'] : '' ?>" required>
		</div>
		<div class="form-group">
			<label for="Correo">Correo</label>
			<input type="text" name="Correo" id="Correo" class="form-control" value="<?php echo isset($meta['Correo']) ? $meta['Correo'] : '' ?>" required autocomplete="off">
		</div>
		<div class="form-group">
			<label for="Contraseña">Contraseña</label>
			<input type="password" name="Contraseña" id="Contraseña" class="form-control" value="" autocomplete="off">
			<?php if (isset($meta['IdUsuario'])) : ?>
				<small><i>Leave this blank if you dont want to change the Contraseña.</i></small>
			<?php endif; ?>
		</div>
		<?php if (isset($meta['TipoUsuario']) && $meta['TipoUsuario'] == 3) : ?>
			<input type="hidden" name="TipoUsuario" value="3">
		<?php else : ?>
			<?php if (!isset($_GET['mtype'])) : ?>
				<div class="form-group">
					<label for="TipoUsuario">Tipo de Usuario</label>
					<select name="TipoUsuario" id="TipoUsuario" class="custom-select">
						<option value="2" <?php echo isset($meta['TipoUsuario']) && $meta['TipoUsuario'] == 2 ? 'selected' : '' ?>>Cajero</option>
						<option value="1" <?php echo isset($meta['TipoUsuario']) && $meta['TipoUsuario'] == 1 ? 'selected' : '' ?>>Administrador</option>
					</select>
				</div>
			<?php endif; ?>
		<?php endif; ?>

		<button class="btn btn-primary" id='submit' onclick="$('#uni_modal form').submit()">Guardar</button>
        <button class="btn btn-danger" data-dismiss="modal">Cancelar</button>
	</form>
</div>

<script>
	$('#manage-user').submit(function(e) {
		e.preventDefault();
		start_load()
		$.ajax({
			url: 'assets/php/functions/ajax.php?action=save_user',
			method: 'POST',
			data: $(this).serialize(),
			success: function(resp) {
				if (resp == 1) {
					alert_toast("Data successfully saved", 'success')
					setTimeout(function() {
						location.reload()
					}, 1500)
				} else {
					$('#msg').html('<div class="alert alert-danger">Correo already exist</div>')
					end_load()
				}
			}
		})
	})
</script>