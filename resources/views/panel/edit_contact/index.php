<?php include(app_path().'/common/panel/header.php'); ?>
<link href="https://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">
<link href="<?php echo url('hummingbird/hummingbird-treeview.css'); ?>" rel="stylesheet" type="text/css">
<style>
    .hummingbird-treeview * {
    font-size: 18px;
    }
</style>

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
                                    <div class="card-body"><h5 class="card-title">Edit Contact</h5>
                                        <form class="" action="" method="post" onsubmit="return check_data();" novalidate>
                                            <?php echo csrf_field(); ?>
                                            <div class="form-row">
                                                <div class="col-md-6">
                                                    <div class="position-relative form-group">
                                                        <label for="exampleEmail11" class=""><?php echo trans('forms.type'); ?> <font style="color:red;">*</font></label>
                                                        <select name="type" id="contact_type" type="text" class="form-control" required onchange="show_form(this.value);">
                                                        <option value=""><?php echo trans('forms.please_select'); ?></option>
                                                            
                                                        <option value="Prospect" <?php if($contact->type=='Prospect') echo 'selected'; ?> ><?php echo trans('forms.prospect'); ?></option>
                                                            
                                                        <option value="Employee"><?php echo trans('forms.employee'); ?></option>
                                                        
                                                        <option value="Expert Advisor" <?php if($contact->type=='Expert Advisor') echo 'selected'; ?> ><?php echo trans('forms.expert_advisor'); ?></option>
                                                            
                                                        <option value="Coach" <?php if($contact->type=='Coach') echo 'selected'; ?> ><?php echo trans('forms.lecturer'); ?> / <?php echo trans('forms.coach'); ?></option>
                                                            
                                                        <option value="Lecturer" <?php if($contact->type=='Lecturer') echo 'selected'; ?> ><?php echo trans('forms.lecturer'); ?></option>
                                                            
                                                        <option value="Student" <?php if($contact->type=='Student') echo 'selected'; ?> ><?php echo trans('forms.student'); ?> / <?php echo trans('forms.coachee'); ?></option>
                                                            
                                                        <option value="Internship Company" <?php if($contact->type=='Internship Company') echo 'selected'; ?> ><?php echo trans('forms.internship_company'); ?></option>
                                                            
                                                        <option value="Other Contacts" <?php if($contact->type=='Other Contacts') echo 'selected'; ?> ><?php echo trans('forms.other_contacts'); ?></option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6" id="company_name" style="display:none;">
                                                    <div class="position-relative form-group">
                                                        <label for="examplePassword11" class=""><?php echo trans('forms.company_name'); ?> <font style="color:red;">*</font></label>
                                                        <input name="company_name" type="text" class="form-control required" required id="company_name_field" value="<?php echo $contact->company_name; ?>"></div>
                                                </div>
                                                <div class="col-md-6" id="type_checkbox_student" style="display:none;">
                                                    <div class="position-relative form-group">
                                                        <label for="exampleEmail11" class=""><?php echo trans('forms.type'); ?> <font style="color:red;">*</font></label><br>
                                                        <?php 
                                                        $types=array();
                                                        if($contact->types!='') $types=explode(',', $contact->types);
                                                        ?>
                                                        <input name="types[]" type="checkbox" value="Student" <?php if(in_array('Student', $types) OR empty($types)) echo 'checked'; ?> > <?php echo trans('forms.student'); ?>
                                                        <input name="types[]" type="checkbox" value="Coachee" <?php if(in_array('Coachee', $types)) echo 'checked'; ?> > <?php echo trans('forms.coachee'); ?>
                                                    </div>
                                                </div>
                                                <div class="col-md-6" id="type_checkbox_trainer" style="display:none;">
                                                    <div class="position-relative form-group">
                                                        <label for="exampleEmail11" class=""><?php echo trans('forms.type'); ?> <font style="color:red;">*</font></label><br>
                                                        <input name="types2[]" type="checkbox" value="Coach" <?php if(in_array('Coach', $types) OR empty($types)) echo 'checked'; ?> > <?php echo trans('forms.coach'); ?>
                                                        <input name="types2[]" type="checkbox" value="Trainer" <?php if(in_array('Trainer', $types)) echo 'checked'; ?> > <?php echo trans('forms.lecturer'); ?>
                                                    </div>
                                                </div>
                                                <div class="col-md-3" id="first_name">
                                                    <div class="position-relative form-group">
                                                        <label for="exampleEmail11" class=""><?php echo trans('forms.first_name'); ?> <font style="color:red;">*</font></label>
                                                        <input name="first_name" type="text" class="form-control required" required id="first_name_field" value="<?php echo explode(' ', $contact->name)[0]; ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-3" id="last_name">
                                                    <div class="position-relative form-group">
                                                        <label for="exampleEmail11" class=""><?php echo trans('forms.last_name'); ?> <font style="color:red;">*</font></label>
                                                        <input name="last_name" id="last_name_field" type="text" class="form-control required" required value="<?php if(isset(explode(' ', $contact->name)[1])) echo explode(' ', $contact->name)[1]; ?>">
                                                    </div>
                                                </div>
                                            
                                            
                                                <div class="col-md-6">
                                                    <div class="position-relative form-group" style="position:relative;">
                                                        <label for="examplePassword11" class=""><?php echo trans('forms.email'); ?> <font style="color:red;">*</font></label>
                                                        <input name="email" id="email_field" type="email" class="form-control required" required value="<?php echo $contact->email; ?>" onchange="check_email(this, '<?php echo $contact->id; ?>')">
                                                        <p class="alert alert-danger" style="position:absolute; right:0px; top:0px; padding-top:0px; padding-bottom:0px; display:none;" id="email-error">Email already exists.</p>
                                                    </div>
                                                </div>
                                                <div class="col-md-6" id="gender">
                                                    <div class="position-relative form-group">
                                                        <label for="exampleEmail11" class=""><?php echo trans('forms.gender'); ?> <font style="color:red;">*</font></label>
                                                        <select name="gender" id="gender_filed" class="form-control required" required>
                                                        <option value=""><?php echo trans('forms.please_select'); ?></option>
                                                            
                                                        <option value="Male" <?php if($contact->gender=='Male') echo 'selected'; ?>><?php echo trans('forms.male'); ?></option>
                                                        
                                                        <option value="Female" <?php if($contact->gender=='Female') echo 'selected'; ?>><?php echo trans('forms.female'); ?></option>
                                                            
                                                        <option value="Neutral" <?php if($contact->gender=='Neutral') echo 'selected'; ?>><?php echo trans('forms.neutral'); ?></option>
                                                        </select>
                                                    </div>
                                                </div>
                                                
                                                <div class="col-12 col-lg-6" id="contract_box">
                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1"><?php echo trans('forms.contract_type'); ?></label>
                                                        <select name="contract_type" id="contract_field" class="form-control">
                                                            <option value=""><?php echo trans('forms.please_select'); ?></option>
                                                            <option value="Standard Contract for Sachberater">Standard Contract for Sachberater</option>
                                                            <option value="Standard contract for Coach / Trainer">Standard contract for Coach / Trainer</option>
                                                            <option value="Coaching Contract for Coachee">Coaching Contract for Coachee</option>
                                                            <option value="Education Contract for Student">Education Contract for Student</option>
                                                            <option value="Standard Contract for Internship company">Standard Contract for Internship company</option>
                                                            <option value="Contract for student / coachee for Internship">Contract for student / coachee for Internship</option>
                                                            <option value="Retraining Contract for Coachee / Student">Retraining Contract for Coachee / Student</option>
                                                            <option value="Amendments to Retraining Contract">Amendments to Retraining Contract</option>
                                                            <option value="Jobsearch contract for Student / Coachee">Jobsearch contract for Student / Coachee</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            
                                            <div id="form-field-box">
                                                <?php $not_requred=1; include(app_path().'/common/contact_form.php'); ?>
                                            </div>
                                                
                                                <div class="col-md-6">
                                                    <div class="position-relative form-group">
                                                        <textarea class="form-control" name="note" id="note" placeholder="Write a note..." rows="8"></textarea>
                                                    </div>
                                                    <div class="position-relative form-group">
                                                        <button class="btn btn-primary pt-2 pb-2" type="button" onclick="add_note(this)">Add Note</button>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div id="notes-box">
                                                        <?php 
                                                            if(!empty($notes)) {
                                                                foreach($notes as $note) {
                                                            ?>
                                                        <div style="border:1px solid #ced4da; padding:5px; margin-bottom:10px; border-radius:5px;">
                                                        <div style="overflow:hidden;">
                                                            <div class="float-left">
                                                                <?php echo $note['user']->name; ?>
                                                                <p style='color:#777'><?php echo $note['user']->email; ?></p>
                                                            </div>
                                                            
                                                            <div class="float-right">
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
                                            
                                            <div id="accordion" class="accordion-wrapper mb-3 products_module" style="<?php if($contact->type!='Coach') echo 'display:none;'; ?>">
                                                    <div class="">
                                                        <div id="headingOne" class="card-header" style="background:#E2E2E0;">
                                                            <button type="button" data-toggle="collapse" data-target="#collapseOne1" aria-expanded="false" aria-controls="collapseOne" class="text-left m-0 p-0 btn btn-link btn-block collapsed">
                                                                <h5 class="m-0 p-0" style="font-size:18px;"><?php echo trans('forms.select_products_modules'); ?></h5>
                                                            </button>
                                                        </div>
                                                        <div data-parent="#accordion" id="collapseOne1" aria-labelledby="headingOne" class="collapse" style="">
                                                            <div class="card-body" id="product-modules-container" style="overflow-x:auto;">
                                                                <input type="hidden" name="products_selected" id="selected_products" value="<?php if(!empty($contact_products)) echo implode(',', $contact_products); ?>">
                                                                
                                                                <div id="treeview_container" class="hummingbird-treeview well h-scroll-large">
                                                                <ul id="treeview" class="hummingbird-base">
                                                                    <?php 
                                                                    if(!empty($products)) {
                                                                        foreach($products as $p) {
                                                                            $p_id=$p['product']->id;
                                                                    ?>
                                                                    <input type="hidden" name="modules_selected_<?php echo $p_id; ?>" id="selected_modules_<?php echo $p_id; ?>" value="<?php if(!empty($contact_modules)) echo implode(',', $contact_modules); ?>">
                                                                    <li> <i class="fa fa-plus"></i>
                                                                        
                                                                        <label>
                                                                        <input type="checkbox" name="products[]" value="<?php echo $p['product']->id; ?>" <?php if(in_array($p['product']->id, $contact_products)) echo 'checked'; ?> onchange="select_items(this, '.p-<?php echo $p['product']->id; ?>')" id="p-<?php echo $p_id; ?>" onclick="item_selected('<?php echo $p_id; ?>')"> <?php echo $p['product']->title.' ('.trans('forms.lessons').': '.$p['total_lessons'].' '.trans('forms.total_cost').': €'.$p['total_cost'].')'; ?>
                                                                        </label>
                                                                    
                                                                    <ul>
                                                                        <?php 
                                                                    if(!empty($p['modules'])) {
                                                                        foreach($p['modules'] as $m) {
                                                                            $m_id=$m['module']->id;
                                                                    ?>
                                                                        
                                                                    <li> <i class="fa fa-plus"></i>
                                                                        
                                                                        <label>
                                                                        <input type="checkbox" name="modules<?php echo $p_id; ?>[]" value="<?php echo $m['module']->id; ?>" <?php if(in_array($m['module']->id, $contact_modules)) echo 'checked'; ?> onchange="select_items(this, '.m-<?php echo $m['module']->id; ?>')" id="m-<?php echo $m_id; ?>" onclick="item_selected('<?php echo $p_id; ?>'); item_selected2('<?php echo $p_id; ?>', '<?php echo $m_id; ?>')"> <?php echo $m['module']->title.' ('.trans('forms.lessons').': '.$m['total_lessons'].' '.trans('forms.total_cost').': €'.$m['total_cost'].')'; ?>
                                                                        </label>
                                                                        
                                                                        <ul>
                                                                            <?php 
                                                                    if(!empty($m['items'])) {
                                                                        foreach($m['items'] as $item) {
                                                                    ?>
                                                                    <li>
                                                                        
                                                                        <label>
                                                                        <input type="checkbox" name="items<?php echo $m['module']->id; ?>[]" value="<?php echo $item['item']->id; ?>" <?php if(in_array($item['item']->id, $contact_items)) echo 'checked'; ?> id="mi-<?php echo $item['item']->id; ?>"  onclick="item_selected('<?php echo $p_id; ?>'); item_selected2('<?php echo $p_id; ?>', '<?php echo $m_id; ?>')"> <?php echo $item['item']->title; ?>
                                                                        </label>
                                                                        
                                                                        <?php echo ' ('.trans('forms.lessons').': '.$item['item']->lessons.', <input type="hidden" name="lessons'.$item['item']->id.'" value="'.$item['item']->lessons.'" style="max-width:60px; padding-top:0px; padding-bottom:0px;" min="0" max="'.$item['item']->lessons.'" required> '.trans('forms.price_lesson').': €'.$item['item']->price_lessons.')'; ?>
                                                                            
                                                                    </li>
                                                                        <?php } } ?>
                                                                        </ul>
                                                                        </li>
                                                                        <?php } } ?>
                                                                        
                                                                    </ul>
                                                                    </li>
                                                                    <?php } } ?>
                                                                </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            
                                            <!--<div id="accordion" class="accordion-wrapper mb-3">
                                                    <div class="">
                                                        <div id="headingOne" class="card-header" style="background:#E2E2E0;">
                                                            <button type="button" data-toggle="collapse" data-target="#collapseOne1" aria-expanded="false" aria-controls="collapseOne" class="text-left m-0 p-0 btn btn-link btn-block collapsed">
                                                                <h5 class="m-0 p-0" style="font-size:18px;">Select Course</h5>
                                                            </button>
                                                        </div>
                                                        <div data-parent="#accordion" id="collapseOne1" aria-labelledby="headingOne" class="collapse" style="">
                                                            <div class="card-body">
                                                                <ul>
                                                                    <?php 
                                                                    if(!empty($courses)) {
                                                                        foreach($courses as $course) {
                                                                            $p_id=$course['course']->id;
                                                                    ?>
                                                                    <li><input type="checkbox" class="courses" name="courses[]" value="<?php echo $course['course']->id; ?>" onchange="show_box(this)"> <?php echo $course['course']->title; ?></li>
                                                                    
                                                                    <div style="border:1px solid #ced4da; border-radius:20px; display:none;" id="box-<?php echo $course['course']->id; ?>">
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
                                                                    <li><?php echo $item['item']->title.' ('.trans('forms.lessons').': <input type="number" name="lessons'.$item['course_item']->id.'" value="'.$item['item']->lessons.'" style="max-width:60px; padding-top:0px; padding-bottom:0px;" min="0" max="'.$item['item']->lessons.'" required> '.trans('forms.price_lesson').': $'.$item['item']->price_lessons.')'; ?></li>
                                                                        <?php } } ?>
                                                                        </ul>
                                                                        <?php } } ?>
                                                                        
                                                                    </ul>
                                                                    <li style="list-style-type:none; padding-bottom:15px;"></li>
                                                                    <?php } } ?>
                                                                        </ul>
                                                                    </div>
                                                                    <?php } } ?>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>-->
                                            <input type="checkbox" name="courses[]" value="1" style="display:none;" checked>
                                            
                                            <p class="alert alert-danger" id="error" style="display:none;"><?php echo Session::get('error'); ?></p>
                                            <button class="mt-2 btn btn-primary" id="submit_btn_c"><?php echo trans('forms.submit'); ?></button>
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

<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script src="<?php echo url('hummingbird/hummingbird-treeview.js'); ?>"></script>
<script>
$("#treeview").hummingbird();
$( "#checkAll" ).click(function() {
  $("#treeview").hummingbird("checkAll");
});
$( "#uncheckAll" ).click(function() {
  $("#treeview").hummingbird("uncheckAll");
});
$( "#collapseAll" ).click(function() {
  $("#treeview").hummingbird("collapseAll");
});
$( "#checkNode" ).click(function() {
  $("#treeview").hummingbird("checkNode",{attr:"id",name: "node-0-2-2",expandParents:false});
});
</script>
<script>
<?php include(app_path().'/common/panel/show_form.php'); ?>

</script>
<script> 

    function item_selected(p_id)
    {
        var old_files=$("#selected_products").val();
        if(old_files!='')
        var files=old_files.split(',');
        else var files=[];
        files.push(p_id);
        var new_files=files.join(',');
        $("#selected_products").val(new_files);
    }

    function select_items(th, checkboxes)
    {
        if($(th).is(':checked')) $(checkboxes).prop('checked', true);
        else $(checkboxes).prop('checked', false);
    }
    
    function item_selected2(p_id, m_id)
    {
        var old_files=$("#selected_modules_"+p_id).val();
        if(old_files!='')
        var files=old_files.split(',');
        else var files=[];
        files.push(m_id);
        var new_files=files.join(',');
        $("#selected_modules_"+p_id).val(new_files);
    }
    
    function add_note(th)
    {
        var notes=$("#note").val();
        if(notes!='')
        {
            notes=notes.replace(/\n/g,"<br>");
            var formData=new FormData();
            var token='<?php echo csrf_token(); ?>';
            var c_id='<?php echo $contact->id; ?>';
            formData.append('_token', token);
            formData.append('c_id', c_id);
            formData.append('notes', notes);
        
        
        $.ajax({
                url: "<?php echo url('admin/add-notes') ?>",
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
    
    function delete_note(id)
    {
            var formData=new FormData();
            var token='<?php echo csrf_token(); ?>';
            formData.append('_token', token);
            formData.append('id', id);
        
        
        $.ajax({
                url: "<?php echo url('admin/delete-notes') ?>",
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
    
    function show_box(th)
    {
        var status=0;
        if($(th).is(":checked")) status=1;
        
        var id=$(th).val();
        if(status==1) $("#box-"+id).show();
        else $("#box-"+id).hide();
    }
    
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
    
    $('.date_range').daterangepicker({
        startDate: '<?php if(isset($contact->beginning)) echo date_format(new DateTime($contact->beginning),'d-m-Y'); ?>',
        endDate: '<?php if(isset($contact->beginning)) echo date_format(new DateTime($contact->end),'d-m-Y'); ?>',
        locale: {
            format: 'DD-MM-YYYY'
        }
    });
    
    $('.calendar').daterangepicker({
        singleDatePicker: true,
        startDate: '<?php if(isset($contact->dob)) echo date_format(new DateTime($contact->dob),'d-m-Y'); ?>',
        locale: {
            format: 'DD-MM-YYYY'
        }
    });
    
    $(document).ready(function(){
        //show_form('<?php echo $contact->type; ?>');
        get_address($("#funding_source_field"));
        <?php if(isset($contact->type)) {?>
        	show_form('<?php echo $contact->type; ?>');
        	<?php } ?>
    });

 
</script>