<?php include __DIR__.'/../functions/db_connect.php'; ?>
<?php
if (isset($_GET['IdPago'])) {
	$qry = $conn->query("SELECT * FROM TPagos where IdPago = {$_GET['IdPago']} ");
	foreach ($qry->fetch_array() as $k => $v) {
		$$k = $v;
	}
}
?>
<div class="container-fluid">
	<form action="" id="manage-payment">
		<div id="msg"></div>
		<input type="hidden" name="IdPago" value="<?php echo isset($IdPago) ? $IdPago : '' ?>">
		<div class="form-group">
			<label for="" class="control-label">ID Cliente/Nombre</label>
			<select name="IdCliente" id="IdCliente" class="custom-select input-sm select2">
				<option value=""></option>
				<?php
				$fees = $conn->query("SELECT tc.* FROM TPagos as tp right join TClientes as tc on tp.IdCliente=tc.IdCliente;");
				while ($row = $fees->fetch_assoc()) :
					#$paid = $conn->query("SELECT sum(amount) as paid FROM payments where ef_id=" . $row['id'] . (isset($id) ? " and id!=$id " : ''));
					#$paid = $paid->num_rows > 0 ? $paid->fetch_array()['paid'] : '';
					#$balance = $row['total_fee'] - $paid;
				?>
					<option value="<?php echo $row['IdCliente'] ?>" data-PagoMensual="<?php echo $row['PagoMensual'] ?>" <?php echo isset($IdCliente) && $IdCliente == $row['IdCliente'] ? 'selected' : '' ?>><?php echo  $row['IdCliente'] . ' | ' . ucwords($row['Nombre']) ?></option>
				<?php endwhile; ?>
			</select>
		</div>
		<div class="form-group">
			<label for="" class="control-label">Metodo de Pago</label>
			<!-- <input type="text" class="form-control text-right" name="MetodoPago" value="<?php echo isset($MetodoPago) ? number_format($MetodoPago) : 0 ?>" required> -->
            <select name="MetodoPago" id="MetodoPago" class="custom-select">
				<option value="1" <?php echo isset($MetodoPago) && $MetodoPago == 1 ? 'selected' : '' ?>>Efectivo</option>
				<option value="2" <?php echo isset($MetodoPago) && $MetodoPago == 2 ? 'selected' : '' ?>>Transferencia</option>
				<option value="3" <?php echo isset($MetodoPago) && $MetodoPago == 3 ? 'selected' : '' ?>>Yape</option>
			</select>
		</div>
        <div class="form-group">
			<label for="" class="control-label">Monto Pagado</label>
			<input type="text" class="form-control text-right" name="MontoPagado" id="MontoPagado" value="<?php echo isset($MontoPagado) ? number_format($MontoPagado) : 0 ?>" required>
		</div>
		<div class="form-group">
			<label for="" class="control-label">Nro Operacion</label>
			<input type="text" class="form-control text-right" name="NroOperacion" value="<?php echo isset($NroOperacion) ? ($NroOperacion) : 0 ?>" required>
		</div>
		<!-- <div class="form-group">
			<label for="" class="control-label">Observaciones</label>
			<textarea name="remarks" id="" cols="30" rows="3" class="form-control" required=""><?php #echo isset($remarks) ? $remarks : '' ?></textarea>
		</div> -->
		<button class="btn btn-primary" id='submit'>Guardar</button>
        <button class="btn btn-danger" data-dismiss="modal">Cancelar</button>
	</form>
</div>

<script>
	$('.select2').select2({
		placeholder: 'Porfavor selecciona aquí',
		width: '100%'
	})
	$('#IdCliente').change(function() {
		var amount = $('#IdCliente option[value="' + $(this).val() + '"]').attr('data-PagoMensual')
		$('#MontoPagado').val(parseFloat(amount).toLocaleString('en-US', {
			style: 'decimal',
			maximumFractionDigits: 2,
			minimumFractionDigits: 2
		}))
	})
	$('#manage-payment').submit(function(e) {
		e.preventDefault()
		start_load()
		$.ajax({
			url: 'assets/php/functions/ajax.php?action=save_payment',
			data: $(this).serialize(),
			method: 'POST',
            type: 'POST',
			error: err => {
				console.log(err)
				end_load()
			},
			success: function(resp) {
				if (resp == 1) {
                    alert_toast("Datos guardados exitósamente", 'success')
                    setTimeout(function() {
                        location.reload()
                    }, 1000)
                } else {
                    $('#msg').html('<div class="alert alert-danger mx-2">ID existe actualmente </div>')
                    end_load()
                }
			}
		})
	})
</script>