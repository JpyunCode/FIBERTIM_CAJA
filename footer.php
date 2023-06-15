<script type="text/javascript" src="assets/js/select2.min.js"></script>
<script type="text/javascript" src="assets/js/jquery.datetimepicker.full.min.js"></script>
<script type="text/javascript" src="assets/js/jquery-te-1.4.0.min.js" charset="utf-8"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.js"></script>


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