<?php
include __DIR__.'/../functions/db_connect.php';
if (isset($_GET['IdCliente'])) {
    $qry = $conn->query("SELECT * FROM TClientes where IdCliente= " . $_GET['IdCliente']);
    foreach ($qry->fetch_array() as $k => $val) {
        $$k = $val;
    }
}
?>
<div class="container-fluid">
    <form action="" id="manage-cliente">
        <input type="hidden" name="IdCliente" value="<?php echo isset($IdCliente) ? $IdCliente : '' ?>">
        <div id="msg" class="form-group"></div>
        <!-- <div class="form-group">
            <label for="" class="control-label">ID</label>
            <input type="text" class="form-control" name="id_no" value="<?php #echo isset($id_no) ? $id_no : '' ?>" required>
        </div> -->
        <div class="form-group">
            <label for="" class="control-label">Nombre</label>
            <input type="text" class="form-control" name="Nombre" value="<?php echo isset($Nombre) ? $Nombre : '' ?>" required>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="" class="control-label">Tipo Documento</label>
                <!-- <input type="text" class="form-control" name="TipoDocumento" value="<?php echo isset($TipoDocumento) ? $TipoDocumento : '' ?>" required> -->
                <select name="TipoDocumento" id="TipoDocumento" class="custom-select">
						<option value="1" <?php echo isset($TipoDocumento) && $TipoDocumento == 1 ? 'selected' : '' ?>>DNI</option>
						<option value="2" <?php echo isset($TipoDocumento) && $TipoDocumento == 2 ? 'selected' : '' ?>>Carnet de extranjeria</option>
						<option value="3" <?php echo isset($TipoDocumento) && $TipoDocumento == 3 ? 'selected' : '' ?>>Pasaporte</option>
						<option value="4" <?php echo isset($TipoDocumento) && $TipoDocumento == 4 ? 'selected' : '' ?>>RUC</option>
				</select>
            </div>
            <div class="form-group col-md-6">
                <label for="" class="control-label">Nro. Documento</label>
                <input type="number" class="form-control" name="NroDocumento" value="<?php echo isset($NroDocumento) ? $NroDocumento : '' ?>" required>
            </div>
        </div>
        <div class="form-group">
            <label for="" class="control-label">Telefono</label>
            <input type="tel" class="form-control" name="Telefono" value="<?php echo isset($Telefono) ? $Telefono : '' ?>" required>
        </div>
        <div class="form-group">
            <label for="" class="control-label">Direccion</label>
            <input type="text" class="form-control" name="Direccion" value="<?php echo isset($Direccion) ? $Direccion : '' ?>" required>
        </div>
        <div class="form-group">
            <label for="" class="control-label">Correo</label>
            <input type="email" class="form-control" name="Email" value="<?php echo isset($Email) ? $Email : '' ?>">
        </div>
        <div class="form-group">
            <label for="" class="control-label">Tipo de Conexion</label>
            <!-- <input type="text" class="form-control" name="ConexionTipo" value="<?php echo isset($ConexionTipo) ? $ConexionTipo : '' ?>" required> -->
            <select name="ConexionTipo" id="ConexionTipo" class="custom-select">
				<option value="1" <?php echo isset($ConexionTipo) && $ConexionTipo == 1 ? 'selected' : '' ?>>Fibra Optica</option>
				<option value="2" <?php echo isset($ConexionTipo) && $ConexionTipo == 2 ? 'selected' : '' ?>>Inalambrico</option>
			</select>
        </div>
        <div class="form-group">
            <label for="" class="control-label">Tipo de Plan</label>
            <!-- <input type="text" class="form-control" name="Plan" value="<?php echo isset($Plan) ? $Plan : '' ?>" required> -->
            <select name="Plan" id="Plan" class="custom-select">
				<option value="1" data-PagoMensual="100" <?php echo isset($Plan) && $Plan == '1' ? 'selected' : '' ?>>50 Mbps</option>
				<option value="2" data-PagoMensual="150" <?php echo isset($Plan) && $Plan == '2' ? 'selected' : '' ?>>100 Mbps</option>
                <option value="3" data-PagoMensual="200" <?php echo isset($Plan) && $Plan == '3' ? 'selected' : '' ?>>200 Mbps</option>
			</select>
        </div>
        <div class="form-group">
            <label for="" class="control-label">Pago mensual</label>
            <input type="text" class="form-control" id="PagoMensual" name="PagoMensual" value="<?php echo isset($PagoMensual) ? $PagoMensual : '100.00' ?>" required>
        </div>
        <div class="form-group">
            <label for="" class="control-label">Estado</label>
            <!-- <input type="text" class="form-control" name="Estado" value="<?php echo isset($Estado) ? $Estado : '' ?>" required> -->
            <select name="Estado" id="Estado" class="custom-select">
				<option value="1" <?php echo isset($Estado) && $Estado == 1 ? 'selected' : '' ?>>Activo</option>
				<option value="2" <?php echo isset($Estado) && $Estado == 2 ? 'selected' : '' ?>>Inactivo</option>
			</select>
        </div>
        <button class="btn btn-primary" id='submit' onclick="$('#uni_modal form').submit()">Guardar</button>
        <button class="btn btn-danger" data-dismiss="modal">Cancelar</button>
    </form>
</div>

<script>
    $('#manage-cliente').on('reset', function() {
        $('#msg').html('')
        $('input:hidden').val('')
    })
    $('#manage-cliente').submit(function(e) {
        e.preventDefault()
        start_load()
        $('#msg').html('')
        $.ajax({
            url: 'assets/php/functions/ajax.php?action=save_cliente',
            data: new FormData($(this)[0]),
            cache: false,
            contentType: false,
            processData: false,
            method: 'POST',
            type: 'POST',
            success: function(resp) {
                if (resp == 1) {
                    alert_toast("Datos guardados exitósamente", 'success')
                    setTimeout(function() {
                        location.reload()
                    }, 1000)
                } else if (resp == 2) {
                    $('#msg').html('<div class="alert alert-danger mx-2">ID existe actualmente </div>')
                    end_load()
                } else if (resp == 3) {
                    $('#msg').html('<div class="alert alert-danger mx-2">Complete los campos requeridos </div>')
                    end_load()
                } else if (resp == 4) {
                    $('#msg').html('<div class="alert alert-danger mx-2">Campo telefono incorrecto </div>')
                    end_load()
                } else if (resp == 5) {
                    $('#msg').html('<div class="alert alert-danger mx-2">Campo nombre incorrecto </div>')
                    end_load()
                }
            }
        })
    })

    $('.select2').select2({
        placeholder: "Porfavor selecciona aquí",
        width: '100%'
    })

    $('#Plan').change(function() {
		var amount = $('#Plan option[value="' + $(this).val() + '"]').attr('data-PagoMensual')
		$('#PagoMensual').val(parseFloat(amount).toLocaleString('en-US', {
			style: 'decimal',
			maximumFractionDigits: 2,
			minimumFractionDigits: 2
		}))
	})
</script>