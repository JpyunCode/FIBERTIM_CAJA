<!DOCTYPE html>
<html lang="en">

<?php session_start(); ?>

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Gestion de pagos</title>
	<link rel="icon" type="image/x-icon" href="assets/img/favicon.png">
    <link href="assets/css/style.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <!-- DATATABLES -->
    <!-- <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.css" /> -->
    <!-- <link rel="stylesheet" href="https://cdn.datatables.net/2.1.7/css/dataTables.dataTables.css" /> -->
    <link href="https://cdn.datatables.net/v/dt/jszip-3.10.1/dt-2.1.7/b-3.1.2/b-colvis-3.1.2/b-html5-3.1.2/b-print-3.1.2/datatables.min.css" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
    <!-- <script src="https://use.fontawesome.com/aa65abb934.js"></script> -->
    <script src="https://kit.fontawesome.com/e3c3b046da.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <?php
    if (!isset($_SESSION['login_IdUsuario']))
        header('location:login.php');

    ?>

</head>
<style>
    .modal-dialog.large {
        width: 80% !important;
        max-width: unset;
    }

    .modal-dialog.mid-large {
        width: 50% !important;
        max-width: unset;
    }

    #viewer_modal .btn-close {
        position: absolute;
        z-index: 999999;
        /*right: -4.5em;*/
        background: unset;
        color: white;
        border: unset;
        font-size: 27px;
        top: 0;
    }

    #viewer_modal .modal-dialog {
        width: 80%;
        max-width: unset;
        height: calc(90%);
        max-height: unset;
    }

    #viewer_modal .modal-content {
        background: black;
        border: unset;
        height: calc(100%);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    #viewer_modal img,
    #viewer_modal video {
        max-height: calc(100%);
        max-width: calc(100%);
    }
</style>

<body>
    <?php include 'topbar.php' ?>
    <?php include 'navbar.php' ?>  
    <div class="toast" id="alert_toast" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-body text-white">
        </div>
    </div>

    <main id="view-panel">
        <?php $page = isset($_GET['page']) ? $_GET['page'] : 'home'; ?>
        <?php include $page . '.php' ?>


    </main>

    <div id="preloader"></div>
    <a href="#" class="back-to-top"><i class="icofont-simple-up"></i></a>

    <div class="modal fade" id="confirm_modal" role='dialog'>
        <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title">Confirmación</h5>
            </div>
            <div class="modal-body">
            <div id="delete_content"></div>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-primary" id='confirm' onclick="">Continuar</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
        </div>
    </div>
    <div class="modal fade" id="uni_modal" role='dialog'>
        <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title"></h5>
            </div>
            <div class="modal-body">
            </div>
            <div class="modal-footer">
            <!-- <button class="btn btn-primary" id='submit' onclick="$('#uni_modal form').submit()">Guardar</button>
            <button class="btn btn-danger" data-dismiss="modal">Cancelar</button> -->
            </div>
        </div>
        </div>
    </div>
    <div class="modal fade" id="viewer_modal" role='dialog'>
        <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <button type="button" class="btn-close" data-dismiss="modal"><span class="fa fa-times"></span></button>
            <img src="" alt="">
        </div>
        </div>
    </div>
</body>

<script>
    window.start_load = function() {
        $('body').prepend('<div id="preloader2"></div>')
    }
    window.end_load = function() {
        $('#preloader2').fadeOut('fast', function() {
        $(this).remove();
        })
    }
    window.viewer_modal = function($src = '') {
        start_load()
        var t = $src.split('.')
        t = t[1]
        if (t == 'mp4') {
        var view = $("<video src='" + $src + "' controls autoplay></video>")
        } else {
        var view = $("<img src='" + $src + "' />")
        }
        $('#viewer_modal .modal-content video,#viewer_modal .modal-content img').remove()
        $('#viewer_modal .modal-content').append(view)
        $('#viewer_modal').modal({
        show: true,
        backdrop: 'static',
        keyboard: false,
        focus: true
        })
        end_load()

    }
    window.uni_modal = function($title = '', $url = '', $size = "") {
        start_load()
        $.ajax({
        url: $url,
        error: err => {
            console.log()
            alert("Ocurrió un error")
        },
        success: function(resp) {
            if (resp) {
            $('#uni_modal .modal-title').html($title)
            $('#uni_modal .modal-body').html(resp)
            if ($size != '') {
                $('#uni_modal .modal-dialog').addClass($size)
            } else {
                $('#uni_modal .modal-dialog').removeAttr("class").addClass("modal-dialog modal-md")
            }
            $('#uni_modal').modal({
                show: true,
                backdrop: 'static',
                keyboard: false,
                focus: true
            })
            end_load()
            }
        }
        })
    }
    window._conf = function($msg = '', $func = '', $params = []) {
        $('#confirm_modal #confirm').attr('onclick', $func + "(" + $params.join(',') + ")")
        $('#confirm_modal .modal-body').html($msg)
        $('#confirm_modal').modal('show')
    }
    window.alert_toast = function($msg = 'TEST', $bg = 'success') {
        $('#alert_toast').removeClass('bg-success')
        $('#alert_toast').removeClass('bg-danger')
        $('#alert_toast').removeClass('bg-info')
        $('#alert_toast').removeClass('bg-warning')

        if ($bg == 'success')
        $('#alert_toast').addClass('bg-success')
        if ($bg == 'danger')
        $('#alert_toast').addClass('bg-danger')
        if ($bg == 'info')
        $('#alert_toast').addClass('bg-info')
        if ($bg == 'warning')
        $('#alert_toast').addClass('bg-warning')
        $('#alert_toast .toast-body').html($msg)
        $('#alert_toast').toast({
        delay: 3000
        }).toast('show');
    }
    $(document).ready(function() {
        $('#preloader').fadeOut('fast', function() {
        $(this).remove();
        })
    })
    $('.datetimepicker').datetimepicker({
        format: 'Y/m/d H:i',
        startDate: '+3d'
    })
    $('.select2').select2({
        placeholder: "Porfavor selecciona aquí",
        width: "100%"
    })
</script>
<?php
    include('./footer.php');
?>
</html>