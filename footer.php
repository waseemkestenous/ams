            <!-- footer content -->
            <footer>
                <div class="pull-right">
                    <?php echo _poweredby; ?>
                </div>
                <div class="clearfix"></div>
            </footer>
            <!-- /footer content -->
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script src="assets/gentela/vendors/validator/multifield.js"></script>
    <script src="assets/gentela/vendors/validator/validator.js"></script>
    
    <!-- Javascript functions   -->
    <script>
        function hideshow(){
            var password = document.getElementById("password1");
            var slash = document.getElementById("slash");
            var eye = document.getElementById("eye");
            
            if(password.type === 'password'){
                password.type = "text";
                slash.style.display = "block";
                eye.style.display = "none";
            }
            else{
                password.type = "password";
                slash.style.display = "none";
                eye.style.display = "block";
            }

        }
    </script>
   <!-- <script>
        // initialize a validator instance from the "FormValidator" constructor.
        // A "<form>" element is optionally passed as an argument, but is not a must
        var validator = new FormValidator({
            "events": ['blur', 'input', 'change']
        }, document.forms[0]);
        // on form "submit" event
        document.forms[0].onsubmit = function(e) {
            var submit = true,
                validatorResult = validator.checkAll(this);
            console.log(validatorResult);
            return !!validatorResult.valid;
        };
        // on form "reset" event
        document.forms[0].onreset = function(e) {
            validator.reset();
        };
        // stuff related ONLY for this demo page:
        $('.toggleValidationTooltips').change(function() {
            validator.settings.alerts = !this.checked;
            if (this.checked)
                $('form .alert').remove();
        }).prop('checked', false);

    </script>-->

    <!-- jQuery -->
    <script src="assets/gentela/vendors/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="assets/gentela/vendors/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <!-- FastClick -->
    <script src="assets/gentela/vendors/fastclick/lib/fastclick.js"></script>
    <!-- NProgress -->
    <script src="assets/gentela/vendors/nprogress/nprogress.js"></script>
    <!-- jQuery custom content scroller -->
    <script src="assets/gentela/vendors/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js"></script>
    <!-- Chart.js -->
    <script src="assets/gentela/vendors/Chart.js/dist/Chart.min.js"></script>
    <!-- gauge.js -->
    <script src="assets/gentela/vendors/gauge.js/dist/gauge.min.js"></script>
    <!-- bootstrap-progressbar -->
    <script src="assets/gentela/vendors/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
    <!-- iCheck -->
    <script src="assets/gentela/vendors/iCheck/icheck.min.js"></script>
    <!-- Switchery -->
    <script src="assets/gentela/vendors/switchery/dist/switchery.min.js"></script>
    <!-- Select2 -->
    <script src="assets/gentela/vendors/select2/dist/js/select2.full.min.js"></script>
    <!-- Skycons -->
    <script src="assets/gentela/vendors/skycons/skycons.js"></script>
    <!-- Flot -->
    <script src="assets/gentela/vendors/Flot/jquery.flot.js"></script>
    <script src="assets/gentela/vendors/Flot/jquery.flot.pie.js"></script>
    <script src="assets/gentela/vendors/Flot/jquery.flot.time.js"></script>
    <script src="assets/gentela/vendors/Flot/jquery.flot.stack.js"></script>
    <script src="assets/gentela/vendors/Flot/jquery.flot.resize.js"></script>
    <!-- Flot plugins -->
    <script src="assets/gentela/vendors/flot.orderbars/js/jquery.flot.orderBars.js"></script>
    <script src="assets/gentela/vendors/flot-spline/js/jquery.flot.spline.min.js"></script>
    <script src="assets/gentela/vendors/flot.curvedlines/curvedLines.js"></script>
    <!-- DateJS -->
    <script src="assets/gentela/vendors/DateJS/build/date.js"></script>
    <!-- JQVMap -->
    <script src="assets/gentela/vendors/jqvmap/dist/jquery.vmap.js"></script>
    <script src="assets/gentela/vendors/jqvmap/dist/maps/jquery.vmap.world.js"></script>
    <script src="assets/gentela/vendors/jqvmap/examples/js/jquery.vmap.sampledata.js"></script>
    <!-- bootstrap-daterangepicker -->
    <script src="assets/gentela/vendors/moment/min/moment.min.js"></script>
    <script src="assets/gentela/vendors/bootstrap-daterangepicker/daterangepicker.js"></script>
    <!-- Datatables -->
    <script src="assets/gentela/vendors/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="assets/gentela/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
    <script src="assets/gentela/vendors/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
    <script src="assets/gentela/vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js"></script>
    <script src="assets/gentela/vendors/datatables.net-buttons/js/buttons.flash.min.js"></script>
    <script src="assets/gentela/vendors/datatables.net-buttons/js/buttons.html5.min.js"></script>
    <script src="assets/gentela/vendors/datatables.net-buttons/js/buttons.print.min.js"></script>
    <script src="assets/gentela/vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js"></script>
    <script src="assets/gentela/vendors/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
    <script src="assets/gentela/vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="assets/gentela/vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js"></script>
    <script src="assets/gentela/vendors/datatables.net-scroller/js/dataTables.scroller.min.js"></script>
    <script src="assets/gentela/vendors/jszip/dist/jszip.min.js"></script>
    <script src="assets/gentela/vendors/pdfmake/build/pdfmake.min.js"></script>
    <script src="assets/gentela/vendors/pdfmake/build/vfs_fonts.js"></script>
    <!-- ECharts -->
    <script src="assets/gentela/vendors/echarts/dist/echarts.min.js"></script>
    <script src="assets/gentela/vendors/echarts/map/js/world.js"></script>
    <!-- validator -->
    <script src="assets/gentela/vendors/validator/multifield.js"></script>
    <script src="assets/gentela/vendors/validator/validator.js"></script>
    <!-- Custom Theme Scripts -->
    <script src="assets/gentela/build/js/custom.js"></script>
</body>
</html>
<?php
    $conn->close();
?>


