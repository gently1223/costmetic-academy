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
                                            
                                            <div class="card-body">
                                                <table style="width: 100%;" id="example3"
                                                       class="table table-hover table-striped table-bordered">
                                                    <thead>
                <tr>
                  <th>#<?php echo trans('dashboard.id'); ?></th>
                  <th><?php echo trans('dashboard.user'); ?></th>
                  <th><?php echo trans('dashboard.activity'); ?></th>
                  <th><?php echo trans('dashboard.date_time'); ?></th>
                </tr>
                </thead>
                <tbody>
                  <?php
                  if(!empty($activities)) {
                    foreach($activities as $activity) {
                        $r_id=$activity['activity']->id;
                   ?>
                <tr>
                  <td><?php echo $r_id; ?></td>
                  <td><font style="color: #777;">#<?php echo $activity['user']->id; ?></font> -
                      <?php echo $activity['user']->name; ?>
                      <p style="color: #777;"><?php echo $activity['user']->username; ?></p>
                  </td>
                  <td><?php echo $activity['activity']->activity; ?></td>
                  <td>
                      <?php echo date_format(new DateTime($activity['activity']->on_date),'Y-m-d'); ?>
                      <p style="color: #777;"><?php echo date_format(new DateTime($activity['activity']->on_date),'H:i:s'); ?></p>
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
                                                                    <td><?php echo $c['class']->day.' at '.$c['class']->fromm.' to '.$c['class']->too; ?></td>
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