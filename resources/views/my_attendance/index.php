<?php include(app_path().'/common/header.php'); ?>

                    <div class="app-inner-layout app-inner-layout-page">
                        <div class="app-inner-layout__wrapper">
                            <div class="app-inner-layout__sidebar">
                                <div class="app-layout__sidebar-inner dropdown-menu-rounded">
                                    <div class="nav flex-column">
                                        <div class="nav-item-header text-primary nav-item">
                                            Dashboards Examples
                                        </div>
                                        <a class="dropdown-item active" href="analytics-dashboard.html">Analytics</a>
                                        <a class="dropdown-item" href="management-dashboard.html">Management</a>
                                        <a class="dropdown-item" href="advertisement-dashboard.html">Advertisement</a>
                                        <a class="dropdown-item" href="index.html">Helpdesk</a>
                                        <a class="dropdown-item" href="monitoring-dashboard.html">Monitoring</a>
                                        <a class="dropdown-item" href="crypto-dashboard.html">Cryptocurrency</a>
                                        <a class="dropdown-item" href="pm-dashboard.html">Project Management</a>
                                        <a class="dropdown-item" href="product-dashboard.html">Product</a>
                                        <a class="dropdown-item" href="statistics-dashboard.html">Statistics</a>
                                    </div>                            </div>
                            </div>
                            <div class="app-inner-layout__content pt-0">
                                <div class="tab-content">
                                    <div class="container-fluid">
                                        <div class="card mb-3">
                                            <div class="card-header-tab card-header">
                                                <div class="card-header-title font-size-lg text-capitalize font-weight-normal">
                                                </div>
                                                
                                            </div>
                                            <?php if(Session::has('error')) { ?>
                                            <p class="alert alert-danger"><?php echo Session::get('error'); ?></p>
                                            <?php } ?>
                                            <?php if(Session::has('success')) { ?>
                                            <p class="alert alert-success"><?php echo Session::get('success'); ?></p>
                                            <?php } ?>
                                                
                                            <div class="card-body">
                                                <?php 
                                                if(!empty($courses)) {
                                                    foreach($courses as $course) {
                                                ?>
                                                <div id="accordion<?php echo $course['course']->id; ?>" class="accordion-wrapper mb-3">
                                                    <div class="">
                                                        <div id="headingOne<?php echo $course['course']->id; ?>" class="card-header" style="background:#E2E2E0;">
                                                            <button type="button" data-toggle="collapse" data-target="#collapseOne2<?php echo $course['course']->id; ?>" aria-expanded="false" aria-controls="collapseOne" class="text-left m-0 p-0 btn btn-link btn-block collapsed">
                                                                <h5 class="m-0 p-0" style="font-size:18px;"><?php echo $course['course']->title; ?></h5>
                                                            </button>
                                                        </div>
                                                        <div data-parent="#accordion<?php echo $course['course']->id; ?>" id="collapseOne2<?php echo $course['course']->id; ?>" aria-labelledby="headingOne<?php echo $course['course']->id; ?>" class="collapse" style="">
                                                            <div class="card-body">
                                                                
                                                
                                    <ul class='nav nav-tabs mb-3' id='profile-form-tab' role='tablist'>
                      <li class='nav-item'>
<a aria-controls='attendance<?php echo $course['course']->id; ?>' aria-selected='true' class="nav-link active" data-toggle='tab' href='#attendance<?php echo $course['course']->id; ?>' id='attendance-tab-<?php echo $course['course']->id; ?>' role='tab'>Attendance</a>
</li>
<li class='nav-item'>
<a aria-controls='notes<?php echo $course['course']->id; ?>' aria-selected='true' class="nav-link" data-toggle='tab' href='#notes<?php echo $course['course']->id; ?>' id='notes-tab-<?php echo $course['course']->id; ?>' role='tab'>Notes</a>
</li>
<li class='nav-item'>
<a aria-controls='details<?php echo $course['course']->id; ?>' aria-selected='true' class="nav-link" data-toggle='tab' href='#details<?php echo $course['course']->id; ?>' id='details-tab-<?php echo $course['course']->id; ?>' role='tab'>Course details</a>
</li>
<li class='nav-item'>
<a aria-controls='appointments<?php echo $course['course']->id; ?>' aria-selected='false' class="nav-link" data-toggle='tab' href='#appointments<?php echo $course['course']->id; ?>' id='appointments-tab-<?php echo $course['course']->id; ?>' role='tab'>Appointments</a>
</li>
</ul>
                                                                <p class="alert alert-danger" style="display:none;" id="error-<?php echo $course['course']->id; ?>"></p>
                                    <div class='tab-content'>
                                        <div aria-labelledby='attendance-tab-<?php echo $course['course']->id; ?>' class="tab-pane fade show active" id='attendance<?php echo $course['course']->id; ?>' role='tabpanel'>
                                            <div class="form-row d-none">
                                                <div class="col-md-6">
                                                    <div class="position-relative form-group">
                                                        <label for="examplePassword11" class="">Attendance for <font style="color:red;">*</font></label>
                                                        <input name="attendance_date" type="text" class="form-control today_calendar" id="attendance_date">
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-6">
                                                    <div class="position-relative form-group">
                                                    <label for="examplePassword11" class="" style="display:block;">&nbsp;</label>
                                                    <button class="btn btn-primary" onclick="change_date('<?php echo $course['course']->id; ?>')">Submit</button>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <table style="width: 100%;" id="example33" class="table table-hover table-striped table-bordered">
                                                                <thead>
                                                                <tr>
                                                                    <th>Date</th>
                                                                    <th>Present</th>
                                                                    <th>Absent</th>
                                                                    <th>Late</th>
                                                                </tr>
                                                                </thead>
                                                                <tbody id="attendance-box">
                                                                <?php 
                                                                    if(!empty($course['attendance'])) {
                                                                        foreach($course['attendance'] as $attendance) {
                                                                            $date=date('Y-m-d');
                                                                ?>
                                                                <tr>
                                                                    <td><?php echo $attendance['appointment']->date; ?></td>
                                                                    <td><?php if($attendance['attendance']=='1') echo '<span class="fa fa-check" style="color:green;"></span>'; ?></td>
                                                                    <td><?php if($attendance['attendance']=='0') echo '<span class="fa fa-check" style="color:red;"></span>'; ?></td>
                                                                    <td><?php if($attendance['attendance']=='2') echo '<span class="fa fa-check" style="color:red;"></span> ('.$attendance['late'].' min)'; ?></td>
                                                                </tr>
                                                                <?php } } ?>
                                                                </tbody>
                                                                <tfoot>
                                                                </tfoot>
                                            </table>
                                        </div>
                                        
                                        <div aria-labelledby='notes-tab-<?php echo $course['course']->id; ?>' class="tab-pane fade" id='notes<?php echo $course['course']->id; ?>' role='tabpanel'>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="position-relative form-group">
                                                        <textarea class="form-control" name="note" id="note" placeholder="Write a note..." rows="8"></textarea>
                                                    </div>
                                                    <div class="position-relative form-group">
                                                        <button class="btn btn-primary pt-2 pb-2" type="button" onclick="add_note(this, '<?php echo $course['course']->id; ?>')">Add Note</button>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div id="notes-box">
                                                        <?php 
                                                            if(!empty($course['notes'])) {
                                                                foreach($course['notes'] as $note) {
                                                            ?>
                                                        <div style="border:1px solid #ced4da; padding:5px; margin-bottom:10px; border-radius:5px;">
                                                        <div style="overflow:hidden;">
                                                            <div class="float-left">
                                                            </div>
                                                            
                                                            <div class="float-left">
                                                                <?php echo date_format(new DateTime($note['note']->added_on),'d-m-Y'); ?>
                                                                <p style='color:#777'><?php echo date_format(new DateTime($note['note']->added_on),'H:i'); ?></p>
                                                            </div>
                                                            </div>
                                                            
                                                            <div><?php echo $note['note']->notes; ?></div>
                                                        </div>
                                                        <?php } } ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div aria-labelledby='details-tab-<?php echo $course['course']->id; ?>' class="tab-pane fade" id='details<?php echo $course['course']->id; ?>' role='tabpanel'>
                                            <h5><?php echo $course['course']->title; ?></h5>
                                            <p><?php echo $course['course']->description; ?></p>
                                        </div>
                                            
                                        <div aria-labelledby='appointments-tab-<?php echo $course['course']->id; ?>' class="tab-pane fade" id='appointments<?php echo $course['course']->id; ?>' role='tabpanel'>
                                                                
                                                                <table style="width: 100%;" id="example3" class="table table-hover table-striped table-bordered">
                                                                <thead>
                                                                <tr>
                                                                    <th>Date</th>
                                                                    <th>Time</th>
                                                                    <th>Module Item</th>
                                                                    <th>Room</th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                <?php 
                                                                    if(!empty($course['appointments'])) {
                                                                        foreach($course['appointments'] as $appointment) {
                                                                ?>
                                                                <tr id="app-<?php echo $appointment['appointment']->id; ?>">
                                                                    <td><?php echo $appointment['appointment']->date; ?></td>
                                                                    <td><?php echo $appointment['appointment']->time.' - '.$appointment['appointment']->time_end; ?></td>
                                                                    <td><?php echo $appointment['appointment']->title; ?></td>
                                                                    <td><?php echo $appointment['room'].' ('.$appointment['location'].')'; ?></td>
                                                                </tr>
                                                                <?php } } ?>
                                                                </tbody>
                                                                <tfoot>
                                                                </tfoot>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                        </div>
                                    </div>
                                                <?php } } ?>
                                            </div>
                                        </div>
                                    </div>
                                        
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
<?php include(app_path().'/common/footer.php'); ?>

<div class="modal fade" id="contract" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="<?php echo url('admin/convert-prospect'); ?>" method="post">
                    <input type="hidden" name="c_id" value="0" id="c_id">
                    <?php echo csrf_field(); ?>
              <div class="modal-header">
                  <h4 class="modal-title" id="modal-title">Create Contract</h4>
              </div>
              <div class="modal-body">
                  <p class="alert alert-success" id="ass-success" style="display:none;"></p>
                  <div class="row">
                      <div class="col-12 col-lg-12" style="display:none;">
                          <div class="form-group">
                            <label for="exampleInputEmail1">Convert to <font style="color:red;">*</font></label>
                              <select name="convert" id="convert" class="form-control" required>
                                  <option value="">Please Select</option>
                                  <option value="Student" selected>Student</option>
                                  <option value="Coachee">Coachee</option>
                              </select>
                          </div>
                      </div>
                  </div>
                  
                  <div class="row">
                      <div class="col-12 col-lg-12">
                          <div id="accordion2" class="accordion-wrapper mb-3">
                                                    <div class="">
                                                        <div id="headingOne2" class="card-header" style="background:#E2E2E0;">
                                                            <button type="button" data-toggle="collapse" data-target="#collapseOne2" aria-expanded="false" aria-controls="collapseOne" class="text-left m-0 p-0 btn btn-link btn-block collapsed">
                                                                <h5 class="m-0 p-0" style="font-size:18px;"><?php echo trans('forms.select_products_modules'); ?></h5>
                                                            </button>
                                                        </div>
                                                        <div data-parent="#accordion2" id="collapseOne2" aria-labelledby="headingOne2" class="collapse" style="">
                                                            <div class="card-body">
                                                                <ul>
                                                                    <?php 
                                                                    if(!empty($products)) {
                                                                        foreach($products as $p) {
                                                                            $p_id=$p['product']->id;
                                                                    ?>
                                                                    <li><input type="checkbox" name="products[]" value="<?php echo $p['product']->id; ?>"> <?php echo $p['product']->title.' ('.trans('forms.lessons').': '.$p['total_lessons'].' '.trans('forms.total_cost').': $'.$p['total_cost'].')'; ?></li>
                                                                    
                                                                    <ul>
                                                                        <?php 
                                                                    if(!empty($p['modules'])) {
                                                                        foreach($p['modules'] as $m) {
                                                                    ?>
                                                                    <li><input type="checkbox" name="modules<?php echo $p_id; ?>[]" value="<?php echo $m['module']->id; ?>"> <?php echo $m['module']->title.' ('.trans('forms.lessons').': '.$m['total_lessons'].' '.trans('forms.total_cost').': $'.$m['total_cost'].')'; ?></li>
                                                                        
                                                                        <ul>
                                                                            <?php 
                                                                    if(!empty($m['items'])) {
                                                                        foreach($m['items'] as $item) {
                                                                    ?>
                                                                    <li><input type="checkbox" name="items<?php echo $p_id; ?>[]" value="<?php echo $item['item']->id; ?>"> <?php echo $item['item']->title.' ('.trans('forms.lessons').': '.$item['item']->lessons.' '.trans('forms.total_cost').': $'.$item['item']->lessons*$item['item']->price_lessons.')'; ?></li>
                                                                        <?php } } ?>
                                                                        </ul>
                                                                        <?php } } ?>
                                                                        
                                                                    </ul>
                                                                    <li style="list-style-type:none; padding-bottom:15px;"></li>
                                                                    <?php } } ?>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                      </div>
                  </div>
                  
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default pull-right" data-dismiss="modal" id="add-appointment-close">Cancel</button>
                <button type="submit" class="btn btn-primary pull-right" style="margin-right:10px;" id="submit_btn">Submit</button>
              </div>
                  </form>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>

<div class="modal fade" id="error-modal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="" method="post">
                    <input type="hidden" name="c_id" value="0" id="c_id">
                    <?php echo csrf_field(); ?>
              <div class="modal-header">
                  <h4 class="modal-title" id="modal-title">Error</h4>
              </div>
              <div class="modal-body">
                  <p class="alert alert-success" id="error"></p>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default pull-right" data-dismiss="modal" id="add-appointment-close">Close</button>
              </div>
                  </form>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>

<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script>
    $(".accept_appointment").submit(function(e){
        e.preventDefault();
        $(".alert").hide();
        var id=$(this).attr('data-id');
        $("#app-btn-"+id).attr('disabled', true);
        var formData=new FormData(this);
        
        $.ajax({
                url: "<?php echo url('accept-appointment') ?>",
                type: "POST",
                data:  formData,
                beforeSend: function(){ //alert('sending');
                },
                contentType: false,
                processData:false,
                success: function(data) { //alert(data);
                    $("#app-btn-"+data.id).attr('disabled', false);
                    //success
                    // here we will handle errors and validation messages
                    if ( ! data.success) {
                        if(data.error!='') {
                        $("#error-"+data.course).text(data.error);
                        $("#error-"+data.course).show();
                        var scrollPos =  $("#error-"+data.course).offset().top;
                        $(window).scrollTop(scrollPos);
                        }
                    } else {
                        // ALL GOOD! just show the success message!
                        $("#app-btn-"+data.id).html("<i class='fa fa-check'></i> Accepted");
                    }
                },
                error: function()  {
                    //error
                } 	        
        });
    });
    
    $(document).on('click', '.browse', function(){
                    var file = $(this).prev();
                    file.trigger('click');
    });
    
    $(document).on('change', '.file', function(e){
                      /*var o=new FileReader;
                      o.readAsDataURL(e.target.files[0]),o.onloadend=function(o){
                          $("#current_img").attr("src",o.target.result); 
                      }*/
                    $("#file_name").text($(this).val().replace(/C:\\fakepath\\/i, ''));
    });
    
    function show_form(type)
    {
        //$("#form-field-box").empty();
        $("#contacts-form").show();
        $(".col-md-3").show();
        $(".col-md-6").show();
        $(".col-md-12").show();
        $(".required").attr('required', 'required');
        $("#company_name").hide(); $("#company_name_field").removeAttr('required');
        
        $("#type_checkbox_student").hide();
        $("#type_checkbox_trainer").hide();
        
        if(type=='Coachee')
        {
            $("#marital_status").hide();
            $("#marital_status").removeAttr('required');
        }
        else if(type=='Student')
        {
            $("#marital_status").hide();
            $("#marital_status").removeAttr('required');
            
            $("#type_checkbox_student").show();
            $("#type_checkbox_trainer").hide();
        }
        else if(type=='Clerk')
        {
            
        }
        else if(type=='Coach')
        {
            $("#marital_status").hide();
            $("#marital_status").removeAttr('required');
            
            $("#type_checkbox_trainer").show();
            $("#type_checkbox_student").hide();
        }
        else if(type=='Lecturer')
        {
            $("#marital_status").hide();
            $("#marital_status").removeAttr('required');
        }
        else if(type=='Internship Company')
        {
            $("#first_name").hide(); $("#first_name_field").removeAttr('required');
            $("#last_name").hide(); $("#last_name_field").removeAttr('required');
            $("#gender").hide(); $("#gender_field").removeAttr('required');
            $("#dob").hide(); $("#dob_field").removeAttr('required');
            $("#mobile").hide(); $("#mobile_field").removeAttr('required');
            $("#marital_status").hide(); $("#marital_status_field").removeAttr('required');
            $("#child_care").hide(); $("#child_care_field").removeAttr('required');
            $("#funding_source").hide(); $("#funding_source_field").removeAttr('required');
            $("#funding_source_address").hide(); $("#funding_source_address_field").removeAttr('required');
            $("#period").hide(); $("#period_field").removeAttr('required');
            $("#voucher").hide(); $("#voucher_field").removeAttr('required');
            
            $("#company_name").show(); $("#company_name_field").attr('required', 'required');
        }
        else if(type=='Prospect' || type=='Expert Advisor')
        {
            $("#child_care").hide(); $("#child_care_field").removeAttr('required');
            $("#funding_source").hide(); $("#funding_source_field").removeAttr('required');
            $("#contact_person").hide(); $("#contact_person_field").removeAttr('required');
            $("#funding_source_address").hide(); $("#funding_source_address_field").removeAttr('required');
            $("#period").hide(); $("#period_field").removeAttr('required');
            $("#voucher").hide(); $("#voucher_field").removeAttr('required');
        }
        else if(type=='Expert Advisor')
        {
            $("#marital_status").hide(); $("#marital_status_field").removeAttr('required');
            
        }
        else if(type=='Other Contacts')
        {
            $("#child_care").hide(); $("#child_care_field").removeAttr('required');
            $("#contact_person").hide(); $("#contact_person_field").removeAttr('required');
            $("#funding_source").hide(); $("#funding_source_field").removeAttr('required');
            $("#funding_source_address").hide(); $("#funding_source_address_field").removeAttr('required');
            $("#period").hide(); $("#period_field").removeAttr('required');
            $("#voucher").hide(); $("#voucher_field").removeAttr('required');
            
        }
        else $("#contacts-form").hide();
    }
    
    $('.date_range').daterangepicker({
        startDate: new Date(),
        locale: {
            format: 'DD-MM-YYYY'
        }
    });
    
    $('.today_calendar').daterangepicker({
        singleDatePicker: true,
        startDate: new Date(),
        locale: {
            format: 'DD-MM-YYYY'
        }
    });
    
    function change_status(status, s_id, date, c_id, late_field)
    {
        if(status!='2') $(late_field).val('0');
        var late=$(late_field).val();
        var formData=new FormData();
        var token='<?php echo csrf_token(); ?>';
        formData.append('_token', token);
        formData.append('status', status);
        formData.append('late', late);
        formData.append('student_id', s_id);
        formData.append('course_id', c_id);
        formData.append('date', date);
        
        
        $.ajax({
                url: "<?php echo url('mark-attendance') ?>",
                type: "POST",
                data:  formData,
                beforeSend: function(){ //alert('sending');
                },
                contentType: false,
                processData:false,
                success: function(data) { //console.log(data);
                    //success
                    // here we will handle errors and validation messages
                    if ( ! data.success) {
                    } else {
                        // ALL GOOD! just show the success message!
                    }
                },
                error: function()  {
                    //error
                } 	        
        });
    }
    
    function change_date(course_id)
    {
        var date=$("#attendance_date").val();;
        var formData=new FormData();
        var token='<?php echo csrf_token(); ?>';
        formData.append('_token', token);
        formData.append('course_id', course_id);
        formData.append('date', date);
        
        $.ajax({
                url: "<?php echo url('attendance-register-date') ?>",
                type: "POST",
                data:  formData,
                beforeSend: function(){ //alert('sending');
                },
                contentType: false,
                processData:false,
                success: function(data) { //console.log(data);
                    //success
                    // here we will handle errors and validation messages
                    if ( ! data.success) {
                    } else {
                        // ALL GOOD! just show the success message!
                        $("#attendance-box").empty();
                        $("#attendance-box").append(data.students);
                    }
                },
                error: function()  {
                    //error
                } 	        
        });
    }
    
    function add_note(th, course_id)
    {
        var notes=$("#note").val();
        if(notes!='')
        {
            notes=notes.replace(/\n/g,"<br>");
            var formData=new FormData();
            var token='<?php echo csrf_token(); ?>';
            formData.append('_token', token);
            formData.append('course_id', course_id);
            formData.append('notes', notes);
        
        
        $.ajax({
                url: "<?php echo url('attendance-add-notes') ?>",
                type: "POST",
                data:  formData,
                beforeSend: function(){ //alert('sending');
                        $(th).attr('disabled', true);
                },
                contentType: false,
                processData:false,
                success: function(data) { //console.log(data);
                    //success
                    $(th).attr('disabled', false);
                    $("#note").val('');
                    // here we will handle errors and validation messages
                    if ( ! data.success) {
                    } else {
                        // ALL GOOD! just show the success message!
                        $("#notes-box").prepend(data.notes);
                    }
                },
                error: function()  {
                    //error
                } 	        
        });
        }
    }
    
    function change_late(student_id, date, course_id, late)
    {
        var formData=new FormData();
            var token='<?php echo csrf_token(); ?>';
            formData.append('_token', token);
            formData.append('course_id', course_id);
            formData.append('student_id', student_id);
            formData.append('date', date);
            formData.append('late', late);
        
        
        $.ajax({
                url: "<?php echo url('attendance-late') ?>",
                type: "POST",
                data:  formData,
                beforeSend: function(){ //alert('sending');
                },
                contentType: false,
                processData:false,
                success: function(data) { //console.log(data);
                    //success
                    // here we will handle errors and validation messages
                    if ( ! data.success) {
                    } else {
                        // ALL GOOD! just show the success message!
                    }
                },
                error: function()  {
                    //error
                } 	        
        });
    }
</script>