<?php if(!isset($currentuserid)) header("Location:index.php?page=home"); ?>
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
        <!-- Javascript functions   -->
        <!-- jQuery -->
        <script src="assets/gentela/vendors/jquery/dist/jquery.min.js"></script>
        <!-- Bootstrap -->
        <script src="assets/gentela/vendors/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Custom Theme Scripts -->
        <script src="assets/gentela/build/js/custom.js"></script>
    </body>
</html>
<?php
    $conn->close();
?>


