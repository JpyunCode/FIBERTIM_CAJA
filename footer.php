<!-- <script type="text/javascript" src="assets/js/select2.min.js"></script> -->
<script type="text/javascript" src="assets/js/jquery.datetimepicker.full.min.js"></script>
<script type="text/javascript" src="assets/js/jquery-te-1.4.0.min.js" charset="utf-8"></script>
<!-- DATATABLES -->
<!-- <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.js"></script> -->
<!-- <script src="https://cdn.datatables.net/2.1.7/js/dataTables.js"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/v/dt/jszip-3.10.1/dt-2.1.7/b-3.1.2/b-colvis-3.1.2/b-html5-3.1.2/b-print-3.1.2/datatables.min.js"></script>



<script>
    function onReady(callback) {
        var intervalID = window.setInterval(checkReady, 1000);

        function checkReady() {
        if (document.getElementsByTagName('body')[0] !== undefined) {
            window.clearInterval(intervalID);
            callback.call(this);
        }
        }
    }

    function show(id, value) {
        document.getElementById(id).style.display = value ? 'block' : 'none';
    }

    onReady(function() {
        show('page', true);
        show('loading', false);
    });
</script>
    <footer class="bg-primary text-white text-center text-lg-start fixed-bottom">
    <!-- Grid container -->

    <!-- Grid container -->

    <!-- Copyright -->
    
    <!--/ Copy this code to have a working example -->