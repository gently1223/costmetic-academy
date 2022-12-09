<?php include(app_path().'/common/panel/header.php'); ?>

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
                                            <?php if(Session::has('error')) { ?>
                                            <p class="alert alert-danger"><?php echo Session::get('error'); ?></p>
                                            <?php } ?>
                                            <?php if(Session::has('success')) { ?>
                                            <p class="alert alert-success"><?php echo Session::get('success'); ?></p>
                                            <?php } ?>
                                            
                                                <div id="form-box">
                                                    <div class="main-card mb-2 card">
                                    <div class="card-body">
                                        <form class="" action="" method="post" onsubmit="return check_data();">
                                            <?php echo csrf_field(); ?>
                                            <input type="hidden" name="type" value="Regular">
                                            <div class="form-row">
                                                <div class="col-md-6">
                                                    <div class="position-relative form-group">
                                                        <label for="exampleEmail11" class=""><?php echo trans('forms.title'); ?> <font style="color:red;">*</font></label>
                                                        <input name="title" id="exampleEmail11" type="text" class="form-control" required value="<?php echo $course->title; ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="position-relative form-group">
                                                        <label for="examplePassword11" class=""><?php echo trans('forms.begin'); ?> <font style="color:red;">*</font></label>
                                                        <input type="text" class="form-control today_calendar2 required" name="period" required id="period_field2" value="<?php echo date_format(new DateTime($course->beginning),'d-m-Y'); ?>">
                                                    </div>
                                                </div>
                                                <?php 
                                                $coaches2=array();
                                                if(!empty($course->coaches)) $coaches2=explode(';', $course->coaches);
                                                ?>
                                                <?php if($course->type=='Regular') { ?>
                                                <div class="col-md-12">
                                                    <div class="position-relative form-group">
                                                        <label for="exampleEmail11" class=""><?php echo trans('forms.lecturer'); ?> <font style="color:red;">*</font></label>
                                                        <select name="coaches[]" class="form-control select-multiple" required multiple="multiple" style="width:100%;" style="width:100%;">
                                                            <?php 
                                                            if(!empty($coaches)) {
                                                                foreach($coaches as $coach) {
                                                                    $types=explode(',', $coach['coach']->types);
                                                                    if(!in_array('Trainer', $types)) continue;
                                                            ?>
                                                            <option value="<?php echo $coach['coach']->id; ?>" <?php if(in_array($coach['coach']->id, $coaches2)) echo 'selected'; ?> ><?php echo $coach['coach']->name; ?></option>
                                                            <?php } } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                                
                                                <?php if($course->type=='Coaching') { ?>
                                                <div class="col-md-12">
                                                    <div class="position-relative form-group">
                                                        <label for="exampleEmail11" class=""><?php echo trans('forms.coach'); ?> <font style="color:red;">*</font></label>
                                                        <select name="coaches[]"  class="form-control select-multiple" required multiple="multiple" style="width:100%;" style="width:100%;" id="exampleEmail11">
                                                            <option value=""><?php echo trans('forms.please_select'); ?></option>
                                                            <?php 
                                                            if(!empty($coaches)) {
                                                                foreach($coaches as $coach) {
                                                                    $types=explode(',', $coach['coach']->types);
                                                                    if(!in_array('Coach', $types)) continue;
                                                            ?>
                                                            <option value="<?php echo $coach['coach']->id; ?>" <?php if(in_array($coach['coach']->id, $coaches2)) echo 'selected'; ?> ><?php echo $coach['coach']->name; ?></option>
                                                            <?php } } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                            </div>
                                            
                                            <div class="form-row">
                                                <div class="col-md-12">
                                                    <div class="position-relative form-group">
                                                        <label for="examplePassword11" class=""><?php echo trans('forms.description'); ?></label>
                                                        <textarea class="form-control" name="description" id="editor"><?php echo $course->description; ?></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <p class="alert alert-danger" id="course-error" style="display:none;"></p>
                                            <button class="mt-2 btn btn-primary"><?php echo trans('forms.update'); ?></button>
                                        </form>
                                    </div>
                                </div>
                                                </div>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
<?php include(app_path().'/common/panel/footer.php'); ?>

<?php 
if(!empty($courses)) {
    foreach($courses as $course) {
?>
<div class="modal fade" id="course-<?php echo $course['course']->id; ?>" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
          <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
              <div class="modal-header">
                  <h4 class="modal-title" id="modal-title">Course</h4>
              </div>
              <div class="modal-body">
                  <ul class='nav nav-tabs mb-3' id='profile-form-tab' role='tablist'>
<li class='nav-item'>
<a aria-controls='products-<?php echo $course['course']->id; ?>' aria-selected='true' class="nav-link active" data-toggle='tab' href='#products-<?php echo $course['course']->id; ?>' id='products-tab-<?php echo $course['course']->id; ?>' role='tab'>Products</a>
</li>
<li class='nav-item'>
<a aria-controls='timetable-<?php echo $course['course']->id; ?>' aria-selected='false' class="nav-link" data-toggle='tab' href='#timetable-<?php echo $course['course']->id; ?>' id='timetable-tab-<?php echo $course['course']->id; ?>' role='tab'>Timetable</a>
</li>
<li class='nav-item'>
<a aria-controls='dozents-<?php echo $course['course']->id; ?>' aria-selected='false' class="nav-link" data-toggle='tab' href='#dozents-<?php echo $course['course']->id; ?>' id='dozents-tab-<?php echo $course['course']->id; ?>' role='tab'>Dozents</a>
</li>
<li class='nav-item'>
<a aria-controls='students-<?php echo $course['course']->id; ?>' aria-selected='false' class="nav-link" data-toggle='tab' href='#students-<?php echo $course['course']->id; ?>' id='students-tab-<?php echo $course['course']->id; ?>' role='tab'>Students</a>
</li>
<li class='nav-item'>
<a aria-controls='appointments-<?php echo $course['course']->id; ?>' aria-selected='false' class="nav-link" data-toggle='tab' href='#appointments-<?php echo $course['course']->id; ?>' id='appointments-tab-<?php echo $course['course']->id; ?>' role='tab'>Appointments</a>
</li>
</ul>
                  <div class='tab-content' id='profile-form-content'>
                      <p class="alert alert-success" id="course_success-<?php echo $course['course']->id; ?>" style="display:none;"></p>
                      <p class="alert alert-danger" id="course_error-<?php echo $course['course']->id; ?>" style="display:none;"></p>
                      
                      <div aria-labelledby='products-tab-<?php echo $course['course']->id; ?>' class="tab-pane fade show active" id='products-<?php echo $course['course']->id; ?>' role='tabpanel'>
                  <ul>
                                                                    <?php 
                                                                    if(!empty($course['products'])) {
                                                                        foreach($course['products'] as $p) {
                                                                            $p_id=$p['product']->id;
                                                                    ?>
                                                                    <li><?php echo $p['product']->title.' ('.trans('forms.lessons').': '.$p['total_lessons'].' '.trans('forms.total_cost').': €'.$p['total_cost'].')'; ?></li>
                                                                    
                                                                    <ul>
                                                                        <?php 
                                                                    if(!empty($p['modules'])) {
                                                                        foreach($p['modules'] as $m) {
                                                                    ?>
                                                                    <li><?php echo $m['module']->title.' ('.trans('forms.lessons').': '.$m['total_lessons'].' '.trans('forms.total_cost').': €'.$m['total_cost'].')'; ?></li>
                                                                        
                                                                        <ul>
                                                                            <?php 
                                                                    if(!empty($m['items'])) {
                                                                        foreach($m['items'] as $item) {
                                                                    ?>
                                                                    <li><?php echo $item['item']->title.' ('.trans('forms.lessons').': '.$item['item']->lessons.' '.trans('forms.total_cost').': €'.$item['item']->lessons*$item['item']->price_lessons.')'; ?></li>
                                                                        <?php } } ?>
                                                                        </ul>
                                                                        <?php } } ?>
                                                                        
                                                                    </ul>
                                                                    <li style="list-style-type:none; padding-bottom:15px;"></li>
                                                                    <?php } } ?>
                        </ul>
                      </div>
                      
                      <div aria-labelledby='timetable-tab-<?php echo $course['course']->id; ?>' class="tab-pane fade" id='timetable-<?php echo $course['course']->id; ?>' role='tabpanel'>
                          <table class="mb-0 table">
                                                                <thead>
                                                                <tr>
                                                                    <th>Days</th>
                                                                    <th>Time</th>
                                                                    <th>Notes</th>
                                                                    <th>Room</th>
                                                                </tr>
                                                                </thead>
                                                                <tbody id="classes-data">
                                                                    <?php 
                                                                    if(!empty($course['classes'])) {
                                                                        foreach($course['classes'] as $c) {
                                                                            $p_id=$c['class']->id;
                                                                    ?>
                                                                    <tr>
                                                                    <td><?php echo $c['class']->day; ?></td>
                                                                    <td><?php echo date_format(new DateTime($c['class']->fromm),'H:i').' to '.date_format(new DateTime($c['class']->too),'H:i'); ?></td>
                                                                    <td><?php echo $c['class']->notes; ?></td>
                                                                    <td><?php echo $c['room']; ?></td>
                                                                    </tr>
                                                                    <?php } } ?>
                                                                </tbody>
                                                            </table>
                      </div>
                      
                      <div aria-labelledby='dozents-tab-<?php echo $course['course']->id; ?>' class="tab-pane fade" id='dozents-<?php echo $course['course']->id; ?>' role='tabpanel'>
                          <table style="width: 100%;" id="example3"
                                                       class="table table-hover table-striped table-bordered">
                                                    <thead>
                                                    <tr>
                                                        <th><?php echo trans('dashboard.name'); ?></th>
                                                        <th><?php echo trans('forms.email'); ?></th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php 
                                                        if(!empty($course['dozents'])) {
                                                            foreach($course['dozents'] as $dozent) {
                                                        ?>
                                                    <tr>
                                                        <td><?php if($dozent['contact']=='NA') echo 'Contact deleted.';  else echo $dozent['contact']->name; ?>
                                                        </td>
                                                        <td><?php if($dozent['contact']=='NA') echo 'Contact deleted.';  else echo $dozent['contact']->email; ?>
                                                        </td>
                                                    </tr>
                                                    <?php } } ?>
                                                    </tbody>
                                                    <tfoot>
                                                    </tfoot>
                                                </table>
                      </div>
                      
                      <div aria-labelledby='students-tab-<?php echo $course['course']->id; ?>' class="tab-pane fade" id='students-<?php echo $course['course']->id; ?>' role='tabpanel'>
                          <table style="width: 100%;" id="example3"
                                                       class="table table-hover table-striped table-bordered">
                                                    <thead>
                                                    <tr>
                                                        <th><?php echo trans('dashboard.type'); ?></th>
                                                        <th><?php echo trans('dashboard.contract'); ?></th>
                                                        <th><?php echo trans('dashboard.contact'); ?></th>
                                                        <th><?php echo trans('dashboard.added_on'); ?></th>
                                                        <th><?php echo trans('dashboard.actions'); ?></th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php 
                                                        if(!empty($course['students'])) {
                                                            foreach($course['students'] as $contract) {
                                                                if($contract['contract']->signature=='') { $signed='<br>'.trans('dashboard.no_signature'); $color='#da624a'; }
                                                                else { $signed='<br>'.trans('dashboard.signed'); $color='green'; }
                                                                
                                                                if($contract['contract']->document=='1') $signed='';
                                                                
                                                                $created_on=date_format(new DateTime($contract['contract']->on_date),'d-m-Y H:i');
                                                                
                                                                if($contract['contract']->document=='0')
                                                                $url=url('company_files/contracts/'.$contract['contract']->contract);
                                                                else
                                                                $url=url('company_files/documents/'.$contract['contract']->contract);
                                                        ?>
                                                    <tr>
                                                        <td><?php echo $contract['contract']->type; ?></td>
                                                        <td><a href=" <?php echo $url; ?>" target="_blank" style="color: <?php echo $color; ?>"><i class="fa fa-file-pdf"></i> <?php
                                                                echo $contract['contract']->contract; ?></a>
                                                            <?php echo $signed; ?>
                                                            
                                                        </td>
                                                        <td><?php if($contract['contact']=='NA') echo 'Contact deleted.';  else echo $contract['contact']->name.'<br>'.$contract['contact']->email; ?>
                                                        </td>
                                                        <td><?php echo date_format(new DateTime($contract['contract']->on_date),'d-m-Y'); ?>
                                                            <p style="color:#777;"><?php echo date_format(new DateTime($contract['contract']->on_date),'H:i'); ?></p>
                                                        </td>
                                                        <td>
                                                            
                                                        <form action="" method="post" style="display:inline;">
                                                            <?php echo csrf_field(); ?>
                                                            <input type="hidden" name="delete" value="<?php echo $contract['contract']->id; ?>">
                                                        <button class="border-0 btn-transition btn btn-outline-danger" onclick="return confirm('Do you really want to delete this contract?');">
                                                        <i class="fa fa-trash"></i>
                                                        </button>
                                                        </form>
                                                        </td>
                                                    </tr>
                                                    <?php } } ?>
                                                    </tbody>
                                                    <tfoot>
                                                    </tfoot>
                                                </table>
                      </div>
                      
                      <div aria-labelledby='appointments-tab-<?php echo $course['course']->id; ?>' class="tab-pane fade" id='appointments-<?php echo $course['course']->id; ?>' role='tabpanel'>
                      </div>
                      
                  </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default pull-right" data-dismiss="modal">Close</button>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>

<?php } } ?>

<script>
    function generate_appointments(th, contract_id, course_id)
    {
        var sub_btn=$(th).children('#submit_btn');
        $(sub_btn).attr('disabled', true);
        
        var formData=new FormData();
        var token='<?php echo csrf_token(); ?>';
        formData.append('_token', token);
        formData.append('contract_id', contract_id);
        
        $.ajax({
                url: "<?php echo url('admin/generate-appointments') ?>",
                type: "POST",
                data:  formData,
                beforeSend: function(){ //alert('sending');
                    $("#course_error-"+course_id).hide();
                },
                contentType: false,
                processData:false,
                success: function(data) { //alert(data);
                    //success
                    // here we will handle errors and validation messages
                    if ( ! data.success) {
                        $(sub_btn).attr('disabled', false);
                        $("#course_error-"+course_id).html(data.error);
                        $("#course_error-"+course_id).show();
                    } else {
                        // ALL GOOD! just show the success message!
                        $(sub_btn).hide();
                        $("#course_success-"+course_id).text('Appointments generated successfully.');
                        $("#course_success-"+course_id).show();
                        window.location='';
                    }
                },
                error: function()  {
                    //error
                } 	        
        });
        
        return false;
    }
    
    function add_class()
    {
        $("#f_error").hide();
        var title=$("#class_title").val();
        var day=$("#class_day").val();
        var from=$("#class_from").val();
        var to=$("#class_to").val();
        var notes=$("#class_notes").val();
        var room=$("#class_room").val();
        var room_name=$('option:selected', $("#class_room")).attr('data-name');
        var day_time=day+' at '+from+' to '+to;
        
        if(title!='' && from!='' && to!='')
        {
                                                            $("#classes-data").append('<tr>\
                                                                    <th scope="row"><input type="hidden" name="classes_id[]" value="0"><input type="hidden" name="classes[]" value="'+title+'">'+title+'</th>\
                                                                    <td><input type="hidden" name="days[]" value="'+day+'"><input type="hidden" name="froms[]" value="'+from+'"><input type="hidden" name="tos[]" value="'+to+'">'+day_time+'</td>\
                                                                    <td><input type="hidden" name="notes[]" value="'+notes+'">'+notes+'</td>\
                                                                    <td><input type="hidden" name="rooms[]" value="'+room+'">'+room_name+'</td>\
                                                                    <td><a href="javascript:void(0)" style="color:red;" onclick="$(this).parent().parent().remove();"><i class="fa fa-minus-circle"></i></a></td>\
                                                                </tr>');
            $("#class_title").val('');
            $("#class_day").val('');
            $("#class_from").val('');
            $("#class_to").val('');
            $("#class_notes").val('');
            $("#class_room").val('');
        }
        else {
            $("#f_error").text('All fields are required.');
            $("#f_error").show();
        }
    }
    
    window.lessons=0;
    
    function add_module()
    {
        $("#f_error").hide();
        var max=$("#max_lessons").val();
        var id=$("#mod").val();
        var title=$('option:selected', $("#mod")).attr('data-title');
        var lessons=$('option:selected', $("#mod")).attr('data-lessons');
        var total_cost=$('option:selected', $("#mod")).attr('data-total-cost');
        
        if(id!='')
        {
            if( (parseInt(window.lessons)+parseInt(lessons)) < parseInt(max) ) {
                window.lessons=parseInt(window.lessons)+parseInt(lessons);
        $("#modules-data").append('<tr>\
                                                                    <th scope="row"><input type="hidden" name="modules[]" value="'+id+'">'+title+'</th>\
                                                                    <td>'+lessons+'</td>\
                                                                    <td>$'+total_cost+'</td>\
                                                                    <td><a href="javascript:void(0)" style="color:red;" onclick="$(this).parent().parent().remove();"><i class="fa fa-minus-circle"></i></a></td>\
                                                                </tr>');
            }
            else{
                $("#f_error").text("Total lessons cannot be greater than: "+max);
                $("#f_error").show();
            }
        }
        
        var id=$("#mod").val('');
    }
</script>
<script src="https://cdn.ckeditor.com/ckeditor5/11.2.0/classic/ckeditor.js"></script>
<script>
    var editor = null;
    ClassicEditor.create(document.querySelector("#editor"), {
        toolbar: [
            "bold",
            "italic",
            "link",
            "bulletedList",
            "numberedList",
            "blockQuote",
            "undo",
            "redo"
        ]
    })
            .then(editor => {
        //debugger;
        window.editor = editor;
    })
    .catch(error => {
        console.error(error);
    });
    
    function check_data()
    {
        $("#course-error").hide();
        
        var period=$("#period_field2").val();
        var dates=period.split(' - ');
        if(dates[0]==dates[1]) 
        {
            $("#course-error").text('<?php echo trans('forms.beginning_end_same'); ?>');
            $("#course-error").show();
            return false;
        }
        
        return true;
    }
    
    $('.date_range').daterangepicker({
        startDate: new Date(),
        locale: {
            format: 'DD-MM-YYYY'
        }
    });
    
    $('.today_calendar2').daterangepicker({
        singleDatePicker: true,
        startDate: '<?php echo date_format(new DateTime($course->beginning),'d-m-Y'); ?>',
        locale: {
            format: 'DD-MM-YYYY'
        }
    });
</script>