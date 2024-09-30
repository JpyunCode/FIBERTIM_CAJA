<?php include 'assets/php/functions/db_connect.php'; ?>
<style>
	input[type=checkbox] {
		/* Double-sized Checkboxes */
		-ms-transform: scale(1.3);
		/* IE */
		-moz-transform: scale(1.3);
		/* FF */
		-webkit-transform: scale(1.3);
		/* Safari and Chrome */
		-o-transform: scale(1.3);
		/* Opera */
		transform: scale(1.3);
		padding: 10px;
		cursor: pointer;
	}
</style>

<div class="container-fluid">

	<div class="col-lg-12">
		<div class="row mb-4 mt-4">
			<div class="col-md-12">

			</div>
		</div>
		<div class="row">
			<!-- FORM Panel -->

			<!-- Table Panel -->
			<div class="col-md-12">
				<div class="card">
					<div class="card-header">
						<b>Lista de Clientes </b>
						<span class="float:right">
							<a class="btn btn-primary col-md-1 col-sm-6 float-right" href="javascript:void(0)" id="new_client">
								<i class="fa fa-plus"></i> Cliente
							</a>
						</span>
					</div>
					<div class="card-body">
						<table class="table table-condensed table-bordered table-hover">
							<thead>
								<tr>
									<th class="text-center">#</th>
									<th class="">ID</th>
									<th class="">Nombre</th>
									<th class="">Información</th>
									<th class="">Detalles</th>
									<th class="">Estado</th>
									<th class="text-center">Acción</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$i = 1;
								$typeDocument = array("", "DNI", "Carnet de extranjeria", "Pasaporte", "RUC");
								$typeConexion = array("", "Fibra Optica", "Inalambrico");
								$typePlan = array("", "50 Mbps", "100 Mbps","200Mbps");
								$typeStatus = array("", "Activo", "Inactivo", "Suspendio temporalmente");
								$student = $conn->query("SELECT * FROM TClientes");
								while ($row = $student->fetch_assoc()) :
								?>
									<tr>
										<td class="text-center">
											<?php echo $i++ ?>
										</td>
										<td class="text-center">
											<?php echo $row['IdCliente'] ?>
										</td>
										<td>
											<?php echo ucwords($row['Nombre']) ?>
										</td>
										<td class="">
											<p><?php echo $typeDocument[$row['TipoDocumento']] ?>: <?php echo $row['NroDocumento'] ?></p>
											<p>Telefono: <?php echo $row['Telefono'] ?></p>
											<p>Dirección: <?php echo $row['Direccion'] ?></p>
											<p>Correo: <?php echo $row['Email'] ?></p>
										</td>
										<td>
											<p>Tipo de conexion:<?php echo $typeConexion[$row['ConexionTipo']] ?></p>
											<p>Plan:<?php echo  $typePlan[$row['Plan']] ?></p>
											<p>Pago mensual:<?php echo $row['PagoMensual'] ?></p>
											<p>Fecha instalacion:<?php echo $row['FechaInstalacion'] ?></p>
										</td>
										<td>
											<?php echo $typeStatus[$row['Estado']] ?>
										</td>
										<td class="text-center">
											<button class="btn btn-primary edit_client" type="button" data-IdCliente="<?php echo $row['IdCliente'] ?>"><i class="fa fa-edit"></i></button>
											<button class="btn btn-danger delete_client" type="button" data-IdCliente="<?php echo $row['IdCliente'] ?>"><i class="fa fa-trash"></i></button>
										</td>
									</tr>
								<?php endwhile; ?>
							</tbody>

						</table>
					</div>
				</div>
			</div>
			<!-- Table Panel -->
		</div>
	</div>

</div>
<style>
	td {
		vertical-align: middle !important;
	}

	td p {
		margin: unset
	}

	img {
		max-width: 100px;
		max-height: 150px;
	}
</style>

<script>
	$(document).ready(function() {
		$('table').dataTable({
			scrollY: 400,
			language: {
				url: '//cdn.datatables.net/plug-ins/2.1.7/i18n/es-MX.json',
			}
		})
	})
	$('#new_client').click(function() {
		uni_modal("Nuevo Cliente ", "assets/php/cliente/manage_client.php", "mid-large")

	})
	$('.edit_client').click(function() {
		uni_modal("Gestionar Información del Cliente", "assets/php/cliente/manage_client.php?IdCliente=" + $(this).attr('data-IdCliente'), "mid-large")

	})
	$('.delete_client').click(function() {
		_conf("Deseas eliminar este cliente? ", "delete_cliente", [$(this).attr('data-IdCliente')])
	})

	function delete_cliente($IdCliente) {
		start_load()
		$.ajax({
			url: 'assets/php/functions/ajax.php?action=delete_cliente',
			method: 'POST',
			data: {
				IdCliente: $IdCliente
			},
			success: function(resp) {
				if (resp == 1) {
					alert_toast("Datos eliminados exitósamente", 'success')
					setTimeout(function() {
						location.reload()
					}, 1500)

				}
			}
		})
	}
</script>