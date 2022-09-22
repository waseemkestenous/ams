<?php if(!isset($currentuserid)) header("Location:index.php?page=home"); ?>
                <!-- footer content -->
                <footer>
                    <div class="pull-right">
                        <?php echo T('_poweredby'); ?>
                    </div>
                    <div class="clearfix"></div>
                </footer>
                <!-- /footer content -->
            </div>
        </div>
        <!-- Javascript functions   -->
        <?php echo $footer_code_st; ?>
        <!-- jQuery -->
        <script src="assets/gentela/vendors/jquery/dist/jquery.min.js"></script>
        <!-- Bootstrap -->
        <script src="assets/gentela/vendors/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Custom Theme Scripts -->
        <script src="assets/gentela/build/js/custom.js"></script>
        <?php echo $footer_code_end; ?>
    </body>
</html>
<?php
    $conn->close();
?>


