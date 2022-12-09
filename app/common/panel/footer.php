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

<script type="text/javascript" src="<?php echo url('assets/scripts/main.07a59de7b920cd76b874.js'); ?>"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js" defer></script>
<!-- DataTables -->
<!--<script src="<?php echo url('plugins/datatables/jquery.dataTables.min.js'); ?>"></script>
<script src="<?php echo url('plugins/datatables/dataTables.bootstrap.min.js'); ?>"></script>-->
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<!-- page script -->


<script>
	$(".delete_appointment").submit(function(e){
        //alert("calling delete appointment");
        e.preventDefault();
        
        var formData=new FormData(this);
        
        $.ajax({
                url: "<?php echo url('admin/delete-appointment') ?>",
                type: "POST",
                data:  formData,
                beforeSend: function(){ //alert('sending');
                },
                contentType: false,
                processData:false,
                success: function(data) { //alert(data);
                    //success
                    // here we will handle errors and validation messages
                    if ( ! data.success) {
                    	//alert("some error occurred");
                    } else {
                        // ALL GOOD! just show the success message!
                        $("#example3").DataTable().row("#app-"+data.id).remove().draw();
                        document.location.reload(true);
                        
                        //$("#app-"+data.id).remove();
                    }
                },
                error: function()  {
                    //error
                } 	        
        });
    });
    
    $("#example3").DataTable({
        order:[],
        responsive: true,
        'iDisplayLength': 100
    });
    
    $(".dynamic-table").DataTable({
        order:[],
        responsive: true,
        'iDisplayLength': 100
    });
    
    $(document).ready(function() {
        $('.select-multiple').select2();
        
        $('#task_assign_to').select2({
            dropdownParent: $("#add-task")
        });
        
        $('#attendees').select2({
            dropdownParent: $("#exampleModal")
        });
        
        $('#assign_course').select2({
            dropdownParent: $("#contract")
        });
        
        var today_calendar_val = $('.today_calendar').val();
        if(!today_calendar_val) {
        	
        $('.today_calendar').daterangepicker({
        singleDatePicker: true,
        startDate: new Date(),
        locale: {
            format: 'DD-MM-YYYY'
        }
        }); 
         }
        else{
        $('.today_calendar').daterangepicker({
        singleDatePicker: true,
        locale: {
            format: 'DD-MM-YYYY'
        }
        });
    	}
    });
    $(document).ready(function(){
      $('[data-toggle="tooltip"]').tooltip();
    });
</script>
</body>
</html>
