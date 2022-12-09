<div class="app-wrapper-footer">
                    <div class="app-footer">
                        <div class="">
                            <div class="app-footer__inner">
                                <div class="app-footer-left">
                                    <div class="footer-dots">
                                        <?php echo env('APP_NAME') ?> Copyright <?php echo date('Y'); ?>
                                    </div>
                                </div>
                                <div class="app-footer-right">
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</div>
<div class="app-drawer-overlay d-none animated fadeIn"></div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script type="text/javascript" src="<?php echo url('assets/scripts/main.07a59de7b920cd76b874.js'); ?>"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js" defer></script>
</body>

<!-- DataTables -->
<!--<script src="<?php echo url('plugins/datatables/jquery.dataTables.min.js'); ?>"></script>
<script src="<?php echo url('plugins/datatables/dataTables.bootstrap.min.js'); ?>"></script>-->
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<!-- page script -->
<script>
    $("#example3").DataTable({
        order:[],
        responsive: true,
        'iDisplayLength': 100
    });
    $(document).ready(function(){
  $('[data-toggle="tooltip"]').tooltip();
});
</script>

</html>
