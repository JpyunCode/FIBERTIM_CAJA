<?php

?>

<div class="container-fluid">
    <div class="col-lg-12">
        <div class="row mb-4 mt-4">
            <div class="col-md-12">

            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card ">
                    <div class="card-header">
                        <b>Lista de Usuarios</b>
                        <span class="float:right">
							<a class="btn btn-primary col-md-1 col-sm-6 float-right" href="javascript:void(0)" id="new_user">
								<i class="fa fa-plus"></i> Usuario
							</a>
						</span>
                    </div>

                    <div class="card-body">
                        <table class="table table-condensed table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th class="text-center">Nombre</th>
                                    <th class="text-center">Correo</th>
                                    <th class="text-center">Tipo</th>
									<th class="text-center">Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                include 'db_connect.php';
                                $type = array("", "Admin", "Staff", "Alumnus/Alumna");
                                $users = $conn->query("SELECT * FROM users order by name asc");
                                $i = 1;
                                while ($row = $users->fetch_assoc()) :
                                ?>
                                    <tr>
                                        <td class="text-center">
                                            <?php echo $i++ ?>
                                        </td>
                                        <td>
                                            <?php echo ucwords($row['name']) ?>
                                        </td>

                                        <td>
                                            <?php echo $row['username'] ?>
                                        </td>
                                        <td>
                                            <?php echo $type[$row['type']] ?>
                                        </td>
                                        </td>
										<td class="text-center">
											<button class="btn btn-primary edit_user" type="button" data-id="<?php echo $row['id'] ?>"><i class="fa fa-edit"></i></button>
											<button class="btn btn-danger delete_user" type="button" data-id="<?php echo $row['id'] ?>"><i class="fa fa-trash"></i></button>
										</td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
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
		$('table').dataTable()
	})
	$('#new_user').click(function() {
		uni_modal('Nuevo Usuario', 'assets/php/users/manage_user.php', "mid-large")
	})
	$('.edit_user').click(function() {
		uni_modal('Editar Usuario', 'assets/php/users/manage_user.php?id=' + $(this).attr('data-id'), "mid-large")
	})
	$('.delete_user').click(function() {
		_conf("¿Deseas eliminar a esta usuario?", "delete_user", [$(this).attr('data-id')])
	})

	function delete_user($id) {
		start_load()
		$.ajax({
			url: 'ajax.php?action=delete_user',
			method: 'POST',
			data: {
				id: $id
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