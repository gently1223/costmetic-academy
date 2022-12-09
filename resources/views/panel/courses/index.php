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
                                            <div class="card-header-tab card-header">
                                                <div class="card-header-title font-size-lg text-capitalize font-weight-normal">
                                                </div>
                                                
                                                <div class="btn-actions-pane-right actions-icon-btn">
                                                    <button type="button" class="btn-shadow btn btn-wide btn-success" onclick="$('#form-box').slideToggle()">
                                                    <span class="btn-icon-wrapper pr-1 opacity-7">
                                                        <i class="fa fa-plus"></i>
                                                    </span>
                                                    <?php echo trans('forms.add_new'); ?>
                                                    </button>
                                                </div>
                                                
                                            </div>
                                            <?php if(Session::has('error')) { ?>
                                            <p class="alert alert-danger"><?php echo Session::get('error'); ?></p>
                                            <?php } ?>
                                            <?php if(Session::has('success')) { ?>
                                            <p class="alert alert-success"><?php echo Session::get('success'); ?></p>
                                            <?php } ?>
                                                <div id="form-box" style="display:none;">
                                                    <div class="main-card mb-2 card">
                                    <div class="card-body"><h5 class="card-title"><?php echo trans('forms.add_new_course'); ?></h5>
                                        <form class="" action="" method="post">
                                            <?php echo csrf_field(); ?>
                                            <div class="form-row">
                                                <div class="col-md-12">
                                                    <div class="position-relative form-group">
                                                        <label for="exampleEmail11" class=""><?php echo trans('forms.type'); ?> <font style="color:red;">*</font></label>
                                                        <select name="type" id="exampleEmail11" class="form-control" required>
                                                            <option value="Regular">Regular</option>
                                                            <option value="Coaching">Coaching</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="form-row">
                                                <div class="col-md-12">
                                                    <div class="position-relative form-group">
                                                        <label for="exampleEmail11" class=""><?php echo trans('forms.title'); ?> <font style="color:red;">*</font></label>
                                                        <input name="title" id="exampleEmail11" type="text" class="form-control" required>
                                                    </div>
                                                </div>
                                                <!--<div class="col-md-3">
                                                    <div class="position-relative form-group">
                                                        <label for="examplePassword11" class="">Authorised Number <font style="color:red;">*</font></label>
                                                        <input type="text" class="form-control" name="auth_no" value="" required>
                                                    </div>
                                                </div>-->
                                            </div>
                                            
                                            
                                            <div class="form-row">
                                                <div class="col-md-12">
                                                    <div class="position-relative form-group">
                                                        <label for="examplePassword11" class=""><?php echo trans('forms.description'); ?> <font style="color:red;">*</font></label>
                                                        <textarea class="form-control" name="description" id="editor"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="form-row">
                                                <div class="col-md-12">
                                                    <div class="position-relative form-group">
                                                        <label for="exampleEmail11" class=""><?php echo trans('forms.coach'); ?> <font style="color:red;">*</font></label>
                                                        <select name="coach" id="exampleEmail11" class="form-control" required>
                                                            <option value=""></option>
                                                            <?php 
                                                            if(!empty($coaches)) {
                                                                foreach($coaches as $coach) {
                                                            ?>
                                                            <option value="<?php echo $coach['coach']->id; ?>"><?php echo $coach['coach']->name; ?></option>
                                                            <?php } } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div id="accordion" class="accordion-wrapper mb-3">
                                                    <div class="">
                                                        <div id="headingOne" class="card-header" style="background:#E2E2E0;">
                                                            <button type="button" data-toggle="collapse" data-target="#collapseOne1" aria-expanded="false" aria-controls="collapseOne" class="text-left m-0 p-0 btn btn-link btn-block collapsed">
                                                                <h5 class="m-0 p-0" style="font-size:18px;"><?php echo trans('forms.select_products_modules'); ?></h5>
                                                            </button>
                                                        </div>
                                                        <div data-parent="#accordion" id="collapseOne1" aria-labelledby="headingOne" class="collapse" style="">
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
                                            
                                            <div id="accordion" class="accordion-wrapper mb-3">
                                                    <div class="">
                                                        <div id="headingOne" class="card-header" style="background:#E2E2E0;">
                                                            <button type="button" data-toggle="collapse" data-target="#collapseOne2" aria-expanded="false" aria-controls="collapseOne" class="text-left m-0 p-0 btn btn-link btn-block collapsed">
                                                                <h5 class="m-0 p-0" style="font-size:18px;"><?php echo trans('forms.timetable'); ?></h5>
                                                            </button>
                                                        </div>
                                                        <div data-parent="#accordion" id="collapseOne2" aria-labelledby="headingOne" class="collapse" style="">
                                                            <div class="card-body">
                                                                <h5><?php echo trans('forms.new_class'); ?></h5>
                                                                <div class="form-row">
                                                <div class="col-md-6">
                                                    <div class="position-relative form-group">
                                                        <label for="examplePassword11" class=""><?php echo trans('forms.title'); ?></label>
                                                        <input type="text" class="form-control" name="class_title" id="class_title"/>
                                                    </div>
                                                </div>
                                                                    
                                                <div class="col-md-2">
                                                    <div class="position-relative form-group">
                                                        <label for="examplePassword11" class=""><?php echo trans('forms.day'); ?></label>
                                                        <select type="text" class="form-control" name="class_day" id="class_day">
                                                            <option value=""></option>
                                                            <option value="Monday">Monday</option>
                                                            <option value="Tuesday">Tuesday</option>
                                                            <option value="Wednesday">Wednesday</option>
                                                            <option value="Thursday">Thursday</option>
                                                            <option value="Friday">Friday</option>
                                                            <option value="Saturday">Saturday</option>
                                                            <option value="Sunday">Sunday</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                                    
                                                <div class="col-md-2">
                                                    <div class="position-relative form-group">
                                                        <label for="examplePassword11" class=""><?php echo trans('forms.from'); ?></label>
                                                        <select class="form-control" name="class_from" id="class_from">
                                                            <option value=""></option>
                                                            <?php for($i=0; $i<=23; $i++) {
                                                                    if($i<10) $num='0'.$i;
                                                                    else $num=$i;
                                                                ?>
                                                                <option value="<?php echo $num.':00'; ?>"><?php echo $num.':00'; ?></option>
                                                                <option value="<?php echo $num.':30'; ?>"><?php echo $num.':30'; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                                    
                                                <div class="col-md-2">
                                                    <div class="position-relative form-group">
                                                        <label for="examplePassword11" class=""><?php echo trans('forms.to'); ?></label>
                                                        <select class="form-control" name="class_to" id="class_to">
                                                            <option value=""></option>
                                                            <?php for($i=0; $i<=23; $i++) {
                                                                    if($i<10) $num='0'.$i;
                                                                    else $num=$i;
                                                                ?>
                                                                <option value="<?php echo $num.':00'; ?>"><?php echo $num.':00'; ?></option>
                                                                <option value="<?php echo $num.':30'; ?>"><?php echo $num.':30'; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                                    
                                                <div class="col-md-6">
                                                    <div class="position-relative form-group">
                                                        <label for="examplePassword11" class=""><?php echo trans('forms.notes'); ?></label>
                                                        <textarea class="form-control" name="class_notes" id="class_notes"></textarea>
                                                    </div>
                                                </div>
                                                                    
                                                <div class="col-md-4">
                                                    <div class="position-relative form-group">
                                                        <label for="examplePassword11" class=""><?php echo trans('forms.room'); ?></label>
                                                        <select class="form-control" name="class_room" id="class_room">
                                                            <option value=""></option>
                                                            <?php 
                                                            if(!empty($rooms)) {
                                                                foreach($rooms as $room) {
                                                            ?>
                                                            <option value="<?php echo $room['room']->id; ?>" data-name="<?php echo $room['room']->name.' ('.$room['location'].')'; ?>"><?php echo $room['room']->name.' ('.$room['location'].')'; ?></option>
                                                            <?php } } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-2">
                                                    <div class="position-relative form-group">
                                                        <label for="examplePassword11" class="">&nbsp </label>
                                                        <button type="button" class="btn-shadow btn btn-wide btn-success" style="display:block;" onclick="add_class()">
                                                        <?php echo trans('forms.add_class'); ?>
                                                        </button>
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-12">
                                                    <p class="alert alert-danger" id="f_error" style="display:none;"></p>
                                                    <div class="table-responsive">
                                                            <table class="mb-0 table">
                                                                <thead>
                                                                <tr>
                                                                    <th><?php echo trans('forms.class'); ?></th>
                                                                    <th><?php echo trans('forms.day_time'); ?></th>
                                                                    <th><?php echo trans('forms.notes'); ?></th>
                                                                    <th><?php echo trans('forms.room'); ?></th>
                                                                    <th></th>
                                                                </tr>
                                                                </thead>
                                                                <tbody id="classes-data">
                                                                    
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                </div>
                                            </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            
                                            <button class="mt-2 btn btn-primary"><?php echo trans('forms.submit'); ?></button>
                                        </form>
                                    </div>
                                </div>
                                                </div>
                                            <div class="card-body">
                                                <table style="width: 100%;" id="example3"
                                                       class="table table-hover table-striped table-bordered">
                                                    <thead>
                                                    <tr>
                                                        <th><?php echo trans('dashboard.course_name'); ?></th>
                                                        <th><?php echo trans('dashboard.description'); ?></th>
                                                        <th><?php echo trans('dashboard.products'); ?></th>
                                                        <th><?php echo trans('dashboard.total_hours'); ?></th>
                                                        <th><?php echo trans('dashboard.total_cost'); ?></th>
                                                        <th><?php echo trans('forms.coach'); ?></th>
                                                        <th><?php echo trans('dashboard.added_on'); ?></th>
                                                        <th><?php echo trans('dashboard.actions'); ?></th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php 
                                                        if(!empty($courses)) {
                                                            foreach($courses as $course) {
                                                        ?>
                                                    <tr>
                                                        <td><?php echo $course['course']->title; ?></td>
                                                        <td><?php echo $course['course']->description; ?></td>
                                                        <td>
                                                            <?php echo count($course['products']); ?>
                                                            <button class="btn btn-success float-right" style="padding-top:1px; padding-bottom:0px;" data-toggle="modal" data-target="#products-<?php echo $course['course']->id; ?>"><?php echo trans('forms.view_details'); ?></button>
                                                        </td>
                                                        <td><?php echo $course['total_lessons']; ?></td>
                                                        <td>$<?php echo $course['total_cost']; ?></td>
                                                        <td><?php echo $course['coach']; ?></td>
                                                        <td><?php echo date_format(new DateTime($course['course']->added_on),'d-m-Y'); ?>
                                                            <p><?php echo date_format(new DateTime($course['course']->added_on),'H:i'); ?></p>
                                                        </td>
                                                        <td>
                                                        <button class="btn btn-success" style="padding-top:1px; padding-bottom:0px; margin-bottom:5px;" data-toggle="modal" data-target="#classes-<?php echo $course['course']->id; ?>"><?php echo trans('forms.timetable'); ?></button><br>
                                                            
                                                        <a href="<?php echo url('admin/edit-course/'.$course['course']->id); ?>"><button class="border-0 btn-transition btn btn-outline-success">
                                                        <i class="fa fa-edit"></i>
                                                        </button></a>
                                                        
                                                        <form action="" method="post" style="display:inline;">
                                                            <?php echo csrf_field(); ?>
                                                            <input type="hidden" name="delete" value="<?php echo $course['course']->id; ?>">
                                                        <button class="border-0 btn-transition btn btn-outline-danger" onclick="return confirm('Do you really want to delete this course?');">
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
<div class="modal fade" id="products-<?php echo $course['course']->id; ?>" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
          <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <form action="" method="post">
                    <?php echo csrf_field(); ?>
              <div class="modal-header">
                  <h4 class="modal-title" id="modal-title">Products</h4>
              </div>
              <div class="modal-body">
                  
                  <ul>
                                                                    <?php 
                                                                    if(!empty($course['products'])) {
                                                                        foreach($course['products'] as $p) {
                                                                            $p_id=$p['product']->id;
                                                                    ?>
                                                                    <li><?php echo $p['product']->title.' ('.trans('forms.lessons').': '.$p['total_lessons'].' '.trans('forms.total_cost').': $'.$p['total_cost'].')'; ?></li>
                                                                    
                                                                    <ul>
                                                                        <?php 
                                                                    if(!empty($p['modules'])) {
                                                                        foreach($p['modules'] as $m) {
                                                                    ?>
                                                                    <li><?php echo $m['module']->title.' ('.trans('forms.lessons').': '.$m['total_lessons'].' '.trans('forms.total_cost').': $'.$m['total_cost'].')'; ?></li>
                                                                        
                                                                        <ul>
                                                                            <?php 
                                                                    if(!empty($m['items'])) {
                                                                        foreach($m['items'] as $item) {
                                                                    ?>
                                                                    <li><?php echo $item['item']->title.' ('.trans('forms.lessons').': '.$item['item']->lessons.' '.trans('forms.total_cost').': $'.$item['item']->lessons*$item['item']->price_lessons.')'; ?></li>
                                                                        <?php } } ?>
                                                                        </ul>
                                                                        <?php } } ?>
                                                                        
                                                                    </ul>
                                                                    <li style="list-style-type:none; padding-bottom:15px;"></li>
                                                                    <?php } } ?>
                        </ul>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default pull-right" data-dismiss="modal">Close</button>
              </div>
                  </form>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>

<div class="modal fade" id="classes-<?php echo $course['course']->id; ?>" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
          <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <form action="" method="post">
                    <?php echo csrf_field(); ?>
              <div class="modal-header">
                  <h4 class="modal-title" id="modal-title">Timetable</h4>
              </div>
              <div class="modal-body">
                  
                                                            <table class="mb-0 table">
                                                                <thead>
                                                                <tr>
                                                                    <th>Class</th>
                                                                    <th>Day &amp; Time</th>
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
                                                                    <td><?php echo $c['class']->name; ?></td>
                                                                    <td><?php echo $c['class']->day.' at '.date_format(new DateTime($c['class']->fromm),'H:i').' to '.date_format(new DateTime($c['class']->too),'H:i'); ?></td>
                                                                    <td><?php echo $c['class']->notes; ?></td>
                                                                    <td><?php echo $c['room']; ?></td>
                                                                    </tr>
                                                                    <?php } } ?>
                                                                </tbody>
                                                            </table>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default pull-right" data-dismiss="modal">Close</button>
              </div>
                  </form>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
<?php } } ?>

<script>
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
</script>