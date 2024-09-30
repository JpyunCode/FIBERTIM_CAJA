<?php
include 'assets/php/functions/db_connect.php';
$month = isset($_GET['month']) ? $_GET['month'] : date('Y-m');
?>
<div class="container-fluid">
    <div class="col-lg-12">
        <div class="card">
            <div class="card_body">
                <div class="row justify-content-center pt-4">
                    <label for="" class="mt-2">Parámetro en meses</label>
                    <div class="col-sm-3">
                        <input type="month" name="month" id="month" value="<?php echo $month ?>" class="form-control">
                    </div>
                </div>
                <hr>
                <div class="col-md-12">
                    <table class="table table-bordered" id='report-list'>
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
								<th class="">ID Cliente</th>
								<th class="">Metodo de pago</th>
								<th class="">Monto pagado</th>
								<th class="">Numero de operacion</th>
								<th class="">Fecha de pago</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            $total = 0;
                            $typePago = array("", "Efectivo", "Transferencia", "Yape");
                            $payments = $conn->query("SELECT * FROM TPagos as tp inner join TClientes as tc on tp.IdCliente=tc.IdCliente where date_format(FechaPago,'%Y-%m') = '$month';");
                            if ($payments->num_rows > 0) :
                                while ($row = $payments->fetch_array()) :
                                    $total += $row['MontoPagado'];
                            ?>
                                    <tr>
                                        <td class="text-center">
											<?php echo $i++ ?>
										</td>
										<td>
											<p><?php echo $row['Nombre'] ?></p>
										</td>
										<td>
											<p><?php echo $typePago[$row['MetodoPago']] ?></p>
										</td>
										<td class="text-right">
											<p><?php echo number_format($row['MontoPagado'], 2) ?></p>
										</td>
										<td>
											<p><?php echo ucwords($row['NroOperacion']) ?></p>
										</td>
										<td>
											<p><?php echo date("M d,Y H:i A", strtotime($row['FechaPago'])) ?></p>
										</td>
                                    </tr>
                                <?php
                                endwhile;
                            else :
                                ?>
                                <tr>
                                    <th class="text-center" colspan="7">Sin datos que mostrar</th>
                                </tr>
                            <?php
                            endif;
                            ?>
                        </tbody>

                        <tfoot>
                            <tr>
                                <th></th>
                                <th></th>
                                <th class="text-right">Total</th>
                                <th class="text-right"><p><?php echo number_format($total, 2) ?></p></th>
                                <th></th>
                                <th></th>
                            </tr>
                        </tfoot>
                    </table>
                    <hr>
                    <div class="col-md-12 mb-4">
                        <center>
                            <button class="btn btn-success col-sm-3 col-md-2" type="button" id="print"><i class="fa fa-print"></i> Imprimir</button>
                        </center>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<noscript>
    <style>
        table#report-list {
            width: 100%;
            border-collapse: collapse
        }

        table#report-list td,
        table#report-list th {
            border: 1px solid
        }

        p {
            margin: unset;
        }

        .text-center {
            text-align: center
        }

        .text-right {
            text-align: right
        }
    </style>
</noscript>

<script>
    $(document).ready( function () {
        $('#report-list').DataTable({
            paging: false,
            searching: false,
            scrollY: 400,
            layout: {
                topStart: {
                    buttons: ['excel','pdf',{extend: 'print', footer: true}]
                }
            },
            language: {
				url: '//cdn.datatables.net/plug-ins/2.1.7/i18n/es-MX.json',
			}
        });
    } );
    $('#month').change(function() {
        location.replace('index.php?page=payments_report&month=' + $(this).val())
    })
    $('#print').click(function() {
        var _c = $('#report-list').clone();
        var ns = $('noscript').clone();
        ns.append(_c)
        var nw = window.open('', '_blank', 'width=900,height=600')
        nw.document.write('<p class="text-center"><b>Reporte de Pago de <?php echo date("F, Y", strtotime($month)) ?></b></p>')
        nw.document.write(ns.html())
        nw.document.close()
        nw.print()
        setTimeout(() => {
            nw.close()
        }, 500);
    })
</script>