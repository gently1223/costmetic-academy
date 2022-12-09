

<div class="modal fade" id="add-task" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
          <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <form action="" method="post" id="task_form" enctype="multipart/form-data">
                    <input type="hidden" name="t_id" value="0" id="task_id">
                    <?php echo csrf_field(); ?>
              <div class="modal-header">
                  <h4 class="modal-title" id="modal-title-task"><?php echo trans('dashboard.add_todo'); ?></h4>
              </div>
              <div class="modal-body">
                  <p class="alert alert-success" id="ass-success" style="display:none;"></p>
                  
                  <div class="form-row">
                                                <div class="col-md-6">
                                                    <div class="position-relative form-group">
                                                        <input name="title" id="task_title" type="text" class="form-control" required placeholder="<?php echo trans('forms.todo'); ?>">
                                                    </div>
                                                </div>
                                                    <div class="col-md-6">
                                                    <div class="position-relative form-group">
                                                        <select name="priority" id="task_priority" class="form-control" required>
                                                            <option value=""><?php echo trans('forms.priority'); ?></option>
                                                            <option value="1"><?php echo trans('forms.priority_high'); ?></option>
                                                            <option value="2"><?php echo trans('forms.priority_normal'); ?></option>
                                                            <option value="3"><?php echo trans('forms.priority_low'); ?></option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="form-row">
                                                <div class="col-md-12">
                                                    <div class="position-relative form-group">
                                                        <textarea class="form-control" name="description" id="task_description" placeholder="<?php echo trans('forms.write_note'); ?>"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            
                                            <div class="form-row">
                                                <div class="col-md-6">
                                                    <div class="position-relative form-group">
                                                        <label for="examplePassword11" class=""><?php echo trans('forms.due_date'); ?> <font style="color:red;">*</font></label>
                                                        <input name="due_date" type="text" class="form-control calendar">
                                                    </div>
                                                </div>
                                                <div class="col-md-6" style="<?php if($user->type!='Coach') echo 'display:none;'; ?>">
                                                    <div class="position-relative form-group">
                                                        <label for="examplePassword11" class=""><?php echo trans('forms.assign_to'); ?></label>
                                                        <select name="assign_to" class="form-control" id="task_assign_to">
                                                            <option value="0"><?php echo trans('forms.please_select'); ?></option>
                                                            <?php 
                                                            if(!empty($task_contacts)) {
                                                                foreach($task_contacts as $contact) {
                                                            ?>
                                                            <option value="<?php echo $contact->id; ?>"><?php echo $contact->name; ?></option>
                                                            <?php } } ?>
                                                        </select>
                                                    </div>
                                                </div>
                  
                                            
                                                <div class="col-md-6">
                                                    <div class="position-relative form-group">
                                                        <label for="examplePassword11" class=""><?php echo trans('forms.attach_file'); ?></label>
                                                        <p id="file_name" style="display:none;"></p>
                                                        <input name="file" type="file" class="form-control file" style="display:none;">
                                                        <div class="browse" style="border: 1px solid #ced4da; width:130px; text-align:center; pading:5px; border-radius:100px; padding-top:7px; padding-bottom:7px; cursor:pointer;"><?php echo trans('forms.choose_file'); ?></div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="position-relative form-group">
                                                        <label for="examplePassword11" class=""><input type="checkbox" name="reminder" value="1" onchange="reminder_field2(this)" id="reminder"> <?php echo trans('forms.reminder'); ?></label>
                                                        <input name="reminder_date" type="text" class="form-control reminder" readonly id="reminder_field">
                                                    </div>
                                                </div>
                  </div>
                                            
                  
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default pull-right" data-dismiss="modal" id="add-task-close"><?php echo trans('forms.cancel'); ?></button>
                <button type="submit" class="btn btn-primary pull-right" style="margin-right:10px;" id="submit_btn_task"><?php echo trans('forms.submit'); ?></button>
              </div>
                  </form>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>

<script>
    $(document).on('click', '.browse', function(){
                    var file = $(this).prev();
                    file.trigger('click');
                  });

		  $(document).on('change', '.file', function(e){
                    $("#file_name").text($(this).val().replace(/C:\\fakepath\\/i, ''));
                    $("#file_name").show();
            });
    
    function reminder_field2(th)
    {
        var status=0;
        if($(th).is(":checked")) status=1;
        
        if(status==1) $("#reminder_field").attr('readonly', false);
        else $("#reminder_field").attr('readonly', true);
    }
    
    $("#task_form").submit(function(e){
        e.preventDefault();
        
        var formData=new FormData(this);
        $.ajax({
                url: "<?php echo url('manage-todos') ?>",
                type: "POST",
                data:  formData,
                beforeSend: function(){ //alert('sending');
                    $("#submit_btn_task").attr('disabled', true);
                },
                contentType: false,
                processData:false,
                success: function(data) { //alert(data);
                    //success
                    $("#submit_btn_task").attr('disabled', false);
                    // here we will handle errors and validation messages
                    if ( ! data.success) {
                    } else {
                        // ALL GOOD! just show the success message!
                        if(data.edit=='0')
                        $("#tasks").prepend(data.task);
                        else
                        {
                            $("#task-"+data.edit).empty();
                            $("#task-"+data.edit).html(data.task);
                        }
                        $("#add-task-close").click();
                        $("#task_title").val('');
                        $("#task_description").val('');
                        $("#task_assign_to").val('');
                        $("#task_priority").val('');
                    }
                },
                error: function()  {
                    //error
                } 	        
        });
    });
    
    function edit_task(t_id, title, priority, description, due_date, assign_to, reminder, reminder_date)
    {
        $('#modal-title-task').text('<?php echo trans('forms.edit_todo'); ?>');
        $("#task_id").val(t_id);
        $("#task_title").val(title);
        $("#task_priority").val(priority);
        $("#task_description").val(description);
        $("#task_assign_to").val(assign_to);
        $("#file_name").hide();
        
        if(reminder=='1') { $("#reminder").prop('checked', true); $("#reminder_field").attr('readonly', false); }
        else { $("#reminder").prop('checked', false); $("#reminder_field").attr('readonly', true); reminder_date=new Date(); }
        
        $('.calendar').daterangepicker({
        singleDatePicker: true,
        startDate: due_date,
        locale: {
            format: 'DD-MM-YYYY'
        }
        });
        
        $('.reminder').daterangepicker({
        timePicker: true,
        singleDatePicker: true,
        showDropdowns: true,
        startDate: reminder_date,
        locale: {
            format: 'DD-MM-YYYY hh:mm A'
        }
    });
    }
    
    function delete_todo(id)
    {
        var formData=new FormData();
        var token='<?php echo csrf_token(); ?>';
        formData.append('_token', token);
        formData.append('delete_todo', id);
        
        $.ajax({
                url: "<?php echo url('manage-todos') ?>",
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
                    } else {
                        // ALL GOOD! just show the success message!
                        $("#task-"+id).remove();
                    }
                },
                error: function()  {
                    //error
                } 	        
        });
    }
    
    function update_status(th)
    {
        var status=0;
        if($(th).is(":checked")) status=1;
        
        var id=$(th).val();
        var formData=new FormData();
        var token='<?php echo csrf_token(); ?>';
        formData.append('_token', token);
        formData.append('id', id);
        formData.append('status', status);
        
        $.ajax({
                url: "<?php echo url('update-status') ?>",
                type: "POST",
                data:  formData,
                beforeSend: function(){ //alert('sending');
                    //$("#submit_btn").attr('disabled', true);
                },
                contentType: false,
                processData:false,
                success: function(data) { //alert(data);
                    //success
                    //$("#submit_btn").attr('disabled', false);
                    // here we will handle errors and validation messages
                    if ( ! data.success) {
                    } else {
                        // ALL GOOD! just show the success message!
                        if(status=='1')
                            {
                                $("#task-"+id).detach().prependTo('#completed_to_do');
                            }
                        else
                            {
                                $("#task-"+id).detach().prependTo('#tasks');
                            }
                    }
                },
                error: function()  {
                    //error
                } 	        
        });
    }
</script>