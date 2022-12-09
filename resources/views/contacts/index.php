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
                                    <div class="card-body"><h5 class="card-title"><?php echo trans('forms.add_new_contact'); ?></h5>
                                        <form class="" action="" method="post" onsubmit="return check_data3();">
                                            <?php echo csrf_field(); ?>
                                            <div class="form-row">
                                                <div class="col-md-6">
                                                    <div class="position-relative form-group">
                                                        <label for="exampleEmail11" class=""><?php echo trans('forms.type'); ?> <font style="color:red;">*</font></label>
                                                        <select name="type" id="contact_type" type="text" class="form-control" required onchange="show_form(this.value);">
                                                        <option value=""><?php echo trans('forms.please_select'); ?></option>
                                                            
                                                        <option value="Prospect"><?php echo trans('forms.prospect'); ?></option>
                                                            
                                                        <option value="Employee"><?php echo trans('forms.employee'); ?></option>
                                                        
                                                        <option value="Expert Advisor"><?php echo trans('forms.expert_advisor'); ?></option>
                                                            
                                                        <option value="Coach"><?php echo trans('forms.lecturer'); ?> / <?php echo trans('forms.coach'); ?></option>
                                                            
                                                        <option value="Student"><?php echo trans('forms.student'); ?> / <?php echo trans('forms.coachee'); ?></option>
                                                            
                                                        <option value="Internship Company"><?php echo trans('forms.internship_company'); ?></option>
                                                            
                                                        <option value="Other Contacts"><?php echo trans('forms.other_contacts'); ?></option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6" id="company_name" style="display:none;">
                                                    <div class="position-relative form-group">
                                                        <label for="examplePassword11" class=""><?php echo trans('forms.company_name'); ?> <font style="color:red;">*</font></label>
                                                        <input name="company_name" type="text" class="form-control required" required id="company_name_field"></div>
                                                </div>
                                                <div class="col-md-6" id="type_checkbox_student" style="display:none;">
                                                    <div class="position-relative form-group">
                                                        <label for="exampleEmail11" class=""><?php echo trans('forms.type'); ?> <font style="color:red;">*</font></label><br>
                                                        <input name="types[]" type="checkbox" value="Student" checked> <?php echo trans('forms.student'); ?>
                                                        <input name="types[]" type="checkbox" value="Coachee"> <?php echo trans('forms.coachee'); ?>
                                                    </div>
                                                </div>
                                                <div class="col-md-6" id="type_checkbox_trainer" style="display:none;">
                                                    <div class="position-relative form-group">
                                                        <label for="exampleEmail11" class=""><?php echo trans('forms.type'); ?> <font style="color:red;">*</font></label><br>
                                                        <input name="types2[]" type="checkbox" value="Coach" checked> <?php echo trans('forms.coach'); ?>
                                                        <input name="types2[]" type="checkbox" value="Trainer"> <?php echo trans('forms.lecturer'); ?>
                                                    </div>
                                                </div>
                                                <div class="col-md-3" id="first_name">
                                                    <div class="position-relative form-group">
                                                        <label for="exampleEmail11" class=""><?php echo trans('forms.first_name'); ?> <font style="color:red;">*</font></label>
                                                        <input name="first_name" type="text" class="form-control required" required id="first_name_field">
                                                    </div>
                                                </div>
                                                <div class="col-md-3" id="last_name">
                                                    <div class="position-relative form-group">
                                                        <label for="exampleEmail11" class=""><?php echo trans('forms.last_name'); ?> <font style="color:red;">*</font></label>
                                                        <input name="last_name" id="last_name_field" type="text" class="form-control required" required>
                                                    </div>
                                                </div>
                                            
                                            
                                                <div class="col-md-6">
                                                    <div class="position-relative form-group" style="position:relative;">
                                                        <label for="examplePassword11" class=""><?php echo trans('forms.email'); ?> <font style="color:red;">*</font></label>
                                                        <input name="email" id="examplePassword11" type="email" class="form-control required" required onchange="check_email(this, '0')">
                                                    <p class="alert alert-danger" style="position:absolute; right:0px; top:0px; padding-top:0px; padding-bottom:0px; display:none;" id="email-error"><?php echo trans('login.email_already_exists'); ?></p>
                                                    </div>
                                                </div>
                                                <div class="col-md-6" id="gender">
                                                    <div class="position-relative form-group">
                                                        <label for="exampleEmail11" class=""><?php echo trans('forms.gender'); ?> <font style="color:red;">*</font></label>
                                                        <select name="gender" id="gender_filed" type="text" class="form-control required" required>
                                                        <option value=""><?php echo trans('forms.please_select'); ?></option>
                                                            
                                                        <option value="Male"><?php echo trans('forms.male'); ?></option>
                                                        
                                                        <option value="Female"><?php echo trans('forms.female'); ?></option>
                                                            
                                                        <option value="Neutral"><?php echo trans('forms.neutral'); ?></option>
                                                        </select>
                                                    </div>
                                                </div>
                                                
                                                <!--<div class="col-12 col-lg-6" id="contract_box" style="display:none;">
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
                                                </div>-->
                                            
                                            <div id="form-field-box">
                                                <?php include(app_path().'/common/contact_form.php'); ?>
                                            </div>
                                                
                                                <div class="col-md-6">
                                                    <div class="position-relative form-group">
                                                        <input type="text" class="form-control" name="note" id="note" placeholder="Write a note...">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="position-relative form-group">
                                                        <button class="btn btn-primary pt-2 pb-2" type="button" onclick="add_note()">Add Note</button>
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-12">
                                                    <table class="table table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th>Notes</th>
                                                                <th></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="notes-box">
                                                            
                                                        </tbody>
                                                    </table>
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
                                                                    <li><input type="checkbox" name="products[]" value="<?php echo $p['product']->id; ?>"> <?php echo $p['product']->title.' ('.trans('forms.lessons').': '.$p['total_lessons'].' '.trans('forms.total_cost').': €'.$p['total_cost'].')'; ?></li>
                                                                    
                                                                    <ul>
                                                                        <?php 
                                                                    if(!empty($p['modules'])) {
                                                                        foreach($p['modules'] as $m) {
                                                                    ?>
                                                                    <li><input type="checkbox" name="modules<?php echo $p_id; ?>[]" value="<?php echo $m['module']->id; ?>"> <?php echo $m['module']->title.' ('.trans('forms.lessons').': '.$m['total_lessons'].' '.trans('forms.total_cost').': €'.$m['total_cost'].')'; ?></li>
                                                                        
                                                                        <ul>
                                                                            <?php 
                                                                    if(!empty($m['items'])) {
                                                                        foreach($m['items'] as $item) {
                                                                    ?>
                                                                    <li><input type="checkbox" name="items<?php echo $p_id; ?>[]" value="<?php echo $item['item']->id; ?>"> <?php echo $item['item']->title.' ('.trans('forms.lessons').': <input type="number" name="lessons'.$item['item']->id.'" value="'.$item['item']->lessons.'" style="max-width:60px; padding-top:0px; padding-bottom:0px;" min="0" max="'.$item['item']->lessons.'" required> '.trans('forms.price_lesson').': €'.$item['item']->price_lessons.')'; ?></li>
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
                                            
                                            <div id="accordion" class="accordion-wrapper mb-3 d-none">
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
                                                                    
                                                                    <div style="border:1px solid #ced4da; border-radius:20px; display:none;" class="box-<?php echo $course['course']->id; ?>">
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
                                                                    <li><?php echo $item['item']->title.' ('.trans('forms.lessons').': <input type="number" name="lessons'.$item['course_item']->id.'" value="'.$item['item']->lessons.'" style="max-width:60px; padding-top:0px; padding-bottom:0px;" min="0" max="'.$item['item']->lessons.'" required> '.trans('forms.price_lesson').': €'.$item['item']->price_lessons.')'; ?></li>
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
                                                </div>
                                            
                                            <p class="alert alert-danger contact_error" style="display:none;"></p>
                                            <button class="mt-2 btn btn-primary" id="submit_btn_c"><?php echo trans('forms.submit'); ?></button>
                                        </form>
                                    </div>
                                </div>
                                                </div>
                                            <div class="card-body">
                                                <table style="width: 100%;" id="example3"
                                                       class="table table-hover table-striped table-bordered">
                                                    <thead>
                                                    <tr>
                                                        <th><?php echo trans('dashboard.contact'); ?></th>
                                                        <th><?php echo trans('dashboard.type'); ?></th>
                                                        <th><?php echo trans('dashboard.last_login'); ?></th>
                                                        <th><?php echo trans('dashboard.added_on'); ?></th>
                                                        <th><?php echo trans('dashboard.actions'); ?></th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php 
                                                        if(!empty($contacts)) {
                                                            foreach($contacts as $user) {
                                                        ?>
                                                    <tr>
                                                        <td><?php if($user['contact']->type=='Internship Company') echo $user['contact']->company_name; else echo $user['contact']->name; ?>
                                                        <p><?php echo $user['contact']->email; ?></p></td>
                                                        <td><?php 
                                                                if($user['contact']->type=='Prospect') echo trans('forms.prospect');
                                                                else if($user['contact']->type=='Employee') echo trans('forms.employee');
                                                                else if($user['contact']->type=='Expert Advisor') echo trans('forms.expert_advisor');
                                                                else if($user['contact']->type=='Coach') echo trans('forms.coach');
                                                                else if($user['contact']->type=='Lecturer') echo trans('forms.lecturer');
                                                                else if($user['contact']->type=='Student') echo trans('forms.student');
                                                                else if($user['contact']->type=='Internship Company') echo trans('forms.internship_company');
                                                                else if($user['contact']->type=='Other Contacts') echo trans('forms.other_contacts');
                                                            ?></td>
                                                        <td>
                                                            <?php if($user['contact']->last_login!='0000-00-00 00:00:00') { ?>
                                                            <?php echo date_format(new DateTime($user['contact']->last_login),'d-m-Y'); ?>
                                                            <p><?php echo date_format(new DateTime($user['contact']->last_login),'H:i'); ?></p>
                                                            <?php } else echo 'NA'; ?>
                                                        </td>
                                                        <td>
                                                            <?php echo date_format(new DateTime($user['contact']->created_on),'d-m-Y'); ?>
                                                            <p><?php echo date_format(new DateTime($user['contact']->created_on),'H:i'); ?></p>
                                                        </td>
                                                        <td>
                                                        <a href="<?php echo url('admin/edit-contact/'.$user['contact']->id); ?>"><button class="border-0 btn-transition btn btn-outline-success">
                                                        <i class="fa fa-edit"></i>
                                                        </button></a>
                                                            
                                                        <form action="" method="post" style="display:inline;">
                                                            <?php echo csrf_field(); ?>
                                                            <input type="hidden" name="delete" value="<?php echo $user['contact']->id; ?>">
                                                        <button class="border-0 btn-transition btn btn-outline-danger" onclick="return confirm('Do you really want to delete this contact?');">
                                                        <i class="fa fa-trash"></i>
                                                        </button>
                                                        </form>
                                                            
                                                            <br>
                                                            <?php if($user['contact']->type!='Student' AND $user['contact']->type!='Coachee' AND $user['contact']->type!='Coach' AND $user['contact']->type!='Expert Advisor') { ?>
                                                            
                                                            <!--<button class="border-0 btn-transition btn btn-success" data-toggle="modal" data-target="#convert2" onclick="$('.c_id').val('<?php echo $user['contact']->id; ?>');">
                                                            Convert
                                                            </button>-->
                                                            <a href="<?php echo url('admin/convert/'.$user['contact']->id); ?>"><button class="border-0 btn-transition btn btn-success">
                                                            <?php echo trans('dashboard.convert'); ?>
                                                            </button></a>
                                                            
                                                            <?php }
                                                            if($user['contact']->type!='Prospect' AND $user['contact']->type!='Internship Company') { ?>
                                                            <button class="border-0 btn-transition btn btn-success" data-toggle="modal" data-target="#contract" onclick="fetch_contracts('<?php echo $user['contact']->id; ?>')">
                                                            Contact Details
                                                            </button>
                                                            <?php } ?>
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

<div class="modal fade" id="contract" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
          <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
              <div class="modal-header">
                  <h4 class="modal-title" id="modal-title2">Contact Details</h4>
              </div>
              <div class="modal-body">
                  <p class="alert alert-success" id="ass-success" style="display:none;"></p>
                  
                  <ul class='nav nav-tabs mb-3' id='profile-form-tab' role='tablist'>
                      <li class='nav-item'>
<a aria-controls='products' aria-selected='true' class="nav-link active" data-toggle='tab' href='#products' id='products-tab' role='tab'>Products</a>
</li>
<li class='nav-item'>
<a aria-controls='contracts' aria-selected='true' class="nav-link" data-toggle='tab' href='#contracts' id='contracts-tab' role='tab'>Contracts</a>
</li>
<li class='nav-item'>
<a aria-controls='documents' aria-selected='true' class="nav-link" data-toggle='tab' href='#documents' id='documents-tab' role='tab'>Documents</a>
</li>
<li class='nav-item'>
<a aria-controls='create-contracts' aria-selected='false' class="nav-link" data-toggle='tab' href='#create-contracts' id='create-tab' role='tab'>Create Contract</a>
</li>
</ul>
<div class='tab-content' id='profile-form-content'>
    <div aria-labelledby='products-tab' class="tab-pane fade show active" id='products' role='tabpanel'>
    </div>
    
<div aria-labelledby='contracts-tab' class="tab-pane fade" id='contracts' role='tabpanel'>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Contract Type</th>
                <th>Contract PDF</th>
                <th>Created On</th>
            </tr>
        </thead>
        <tbody id="user-contracts">
            
        </tbody>
    </table>
    </div>
    
    <div aria-labelledby='documents-tab' class="tab-pane fade" id='documents' role='tabpanel'>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Document Type</th>
                <th>Document File</th>
                <th>Added On</th>
            </tr>
        </thead>
        <tbody id="user-documents">
            
        </tbody>
    </table>
    </div>
    
    <div aria-labelledby='create-tab' class="tab-pane fade" id='create-contracts' role='tabpanel' style="overflow:hidden;">
                <form action="<?php echo url('admin/create-contract'); ?>" method="post" onsubmit="return check_data2();">
                    <input type="hidden" name="c_id" value="0" id="c_id">
                    <?php echo csrf_field(); ?>
        <div class="row">
                      <div class="col-12 col-lg-6">
                          <div class="form-group">
                            <label for="exampleInputEmail1"><?php echo trans('forms.contract'); ?> <font style="color:red;">*</font></label>
                              <select name="contract_type" id="contract_type" class="form-control" required onchange="contract_type2(this)">
                                  <option value=""><?php echo trans('forms.please_select'); ?></option>
                                  <option value="Standard Contract for Sachberater">Standard Contract for Sachberater</option>
                                  <option value="Standard contract for Coach / Trainer">Standard contract for Coach / Trainer</option>
                                  <option value="Coaching Contract for Coachee">Coaching Contract for Coachee</option>
                                  <option value="Education Contract for Student">Education Contract for Student</option>
                                  <option value="Extended Education Contract for Student">Extended Education Contract for Student</option>
                                  <option value="Retraining Contract for Coachee / Student">Retraining Contract for Coachee / Student</option>
                                  <option value="Amendments to Retraining Contract">Amendments to Retraining Contract</option>
                                  <option value="Contract for student / coachee for Internship">Contract for student / coachee for Internship</option>
                                  <option value="Private Jobsearch contract for Student / Coachee">Private Jobsearch contract for Student / Coachee</option>
                                  <option value="Standard Contract for Internship company">Standard Contract for Internship company</option>
                                  <option value="Work Contract for Employee">Work Contract for Employee</option>
                                  <option value="Amendments to Work Contract for Employee">Amendments to Work Contract for Employee</option>
                              </select>
                          </div>
                      </div>
                      <div class="col-md-6">
                        <div class="position-relative form-group">
                            <label for="examplePassword11" class=""><?php echo trans('forms.beginning_end'); ?> <font style="color:red;">*</font></label>
                            <input type="text" class="form-control date_range required" name="period" required id="period_field2">
                        </div>
                    </div>
                  </div>
                    
                    <div class="row">
                        <div class="col-12 col-lg-6" id="qualifications" style="display:none;">
                            <label for="exampleInputEmail1">Professional Qualification for</label><br>
                            <input type="checkbox" name="p_qualifications[]" value="Drogist/in"> Drogist/in<br>
                            <input type="checkbox" name="p_qualifications[]" value="Kaufmann/frau im Einzelhandel"> Kaufmann/frau im Einzelhandel<br>
                            <input type="checkbox" name="p_qualifications[]" value="Verkäufer/in"> Verkäufer/in<br><br>
                        </div>
                        
                        <div class="col-12 col-lg-6" id="e_qualifications" style="display:none;">
                            <label for="exampleInputEmail1">Elective Qualification</label><br>
                            <input type="checkbox" name="e_qualifications[]" value="Beauty & Cosmetic (inkl. Visagistik, Parfüm- &amp; Dufttraining, Dermatologie)"> Beauty &amp; Cosmetic (inkl. Visagistik, Parfüm- &amp; Dufttraining, Dermatologie)<br>
                            <input type="checkbox" name="e_qualifications[]" value="Fashion & Design (inkl. Stoff- &amp; Schnittkunde, Nähkurs, Workshops)"> Fashion &amp; Design (inkl. Stoff- &amp; Schnittkunde, Nähkurs, Workshops)<br>
                            <input type="checkbox" name="e_qualifications[]" value="Drogerie & Gesundheit (inkl. Skin Cosmetics, Freiverkäufliche Arzneimittel)"> Drogerie &amp; Gesundheit (inkl. Skin Cosmetics, Freiverkäufliche Arzneimittel)<br><br>
                            <input type="checkbox" name="e_qualifications[]" value="E-Commerce (inkl. Konzeption & Einrichtung Online Shop, Planung & Umsetzung Online Shop, Workshops)"> E-Commerce (inkl. Konzeption &amp; Einrichtung Online Shop, Planung &amp; Umsetzung Online Shop, Workshops)<br><br>
                            <input type="checkbox" name="e_qualifications[]" value="Kassensystemdaten und Kundenservice"> Kassensystemdaten und Kundenservice<br><br>
                        </div>
                    </div>
                  
                  <div class="row">
                      <div class="col-12 col-lg-12">
                          <div id="accordion1" class="accordion-wrapper mb-3">
                                                    <div class="">
                                                        <div id="headingOne1" class="card-header" style="background:#E2E2E0;">
                                                            <button type="button" data-toggle="collapse" data-target="#collapseOne11" aria-expanded="false" aria-controls="collapseOne" class="text-left m-0 p-0 btn btn-link btn-block collapsed">
                                                                <h5 class="m-0 p-0" style="font-size:18px;"><?php echo trans('forms.select_course'); ?></h5>
                                                            </button>
                                                        </div>
                                                        <div data-parent="#accordion1" id="collapseOne11" aria-labelledby="headingOne1" class="collapse" style="">
                                                            <div class="card-body">
                                                                <ul>
                                                                    <?php 
                                                                    if(!empty($courses)) {
                                                                        foreach($courses as $course) {
                                                                            $p_id=$course['course']->id;
                                                                    ?>
                                                                    <li><input type="checkbox" class="courses" name="courses[]" value="<?php echo $course['course']->id; ?>" onchange="show_box(this)"> <?php echo $course['course']->title; ?></li>
                                                                    
                                                                    <div style="border:1px solid #ced4da; border-radius:20px; display:none;" class="box-<?php echo $course['course']->id; ?>">
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
                                                                    <li><?php echo $item['item']->title.' ('.trans('forms.lessons').': <input type="number" name="lessons'.$item['course_item']->id.'" value="'.$item['item']->lessons.'" style="max-width:60px; padding-top:0px; padding-bottom:0px;" min="0" max="'.$item['item']->lessons.'" required> '.trans('forms.price_lesson').': €'.$item['item']->price_lessons.')'; ?></li>
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
                                                </div>
                      </div>
                  </div>
    <button type="submit" class="btn btn-primary pull-right" style="margin-right:10px;" id="submit_btn"><?php echo trans('forms.submit'); ?></button>
    </form>
    </div>
    
</div>
                  
                <p class="alert alert-danger" id="error2" style="display:none;"></p>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default pull-right" data-dismiss="modal" id="add-appointment-close">Close</button>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>

<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

<script>
    <?php include(app_path().'/common/panel/show_form.php'); ?>
    function add_note()
    {
        var notes=$("#note").val();
        if(notes!='')
            {
                $("#notes-box").prepend("<tr><td><input type='hidden' name='notes[]' value='"+notes+"'>"+notes+"</td>\
                    <td><center>\
                    <a href='javascript:void(0)' onclick='$(this).parent().parent().parent().remove();' style='color:red;'><i class='fa fa-trash'></i></a>\
                    </center>\
                    </td>\
                </tr>");
                $("#note").val('');
            }
    }
    
    function contract_type2(th)
    {
        var contract=$(th).val();
        if(contract=='Education Contract for Student') {
            $("#qualifications").show();
            $("#e_qualifications").show();
        }
        else {
            $("#qualifications").hide();
            $("#e_qualifications").hide();
        }
    }

    function fetch_contracts(c_id, type)
    {
        $('.nav-link').removeClass('active');
        $('.tab-pane').removeClass('show active');
        
        if(type!='Student' && type!='Coach' && type!='Internship Company') { 
            $(".hide-tab").hide(); 
            $('#documents-tab').addClass('active');
            $('#documents').addClass('show active');
            $('#products-tab').removeClass('active');
            $('#products').removeClass('show active');
        }
        else { 
            $(".hide-tab").show();   
            $('#documents-tab').removeClass('active');
            $('#documents').removeClass('show active');
            $('#products-tab').addClass('active');
            $('#products').addClass('show active');
             }
        
        $('#c_id').val(c_id);
        
        var formData=new FormData();
        var token='<?php echo csrf_token(); ?>';
        formData.append('_token', token);
        formData.append('c_id', c_id);
        
        
        $.ajax({
                url: "<?php echo url('admin/fetch-contact-products') ?>",
                type: "POST",
                data:  formData,
                beforeSend: function(){ //alert('sending');
                        $("#products").empty();
                },
                contentType: false,
                processData:false,
                success: function(data) { //console.log(data);
                    //success
                    // here we will handle errors and validation messages
                    if ( ! data.success) {
                    } else {
                        // ALL GOOD! just show the success message!
                        $("#products").append(data.products);
                        $("#treeview-contact-products").hummingbird();
                    }
                },
                error: function()  {
                    //error
                } 	        
        });
        
        $.ajax({
                url: "<?php echo url('admin/fetch-contracts') ?>",
                type: "POST",
                data:  formData,
                beforeSend: function(){ //alert('sending');
                        $("#user-contracts").empty();
                },
                contentType: false,
                processData:false,
                success: function(data) { //alert(data);
                    //success
                    // here we will handle errors and validation messages
                    if ( ! data.success) {
                    } else {
                        // ALL GOOD! just show the success message!
                        $("#user-contracts").append(data.contracts);
                    }
                },
                error: function()  {
                    //error
                } 	        
        });
        
        $.ajax({
                url: "<?php echo url('admin/fetch-documents') ?>",
                type: "POST",
                data:  formData,
                beforeSend: function(){ //alert('sending');
                        $("#user-documents").empty();
                },
                contentType: false,
                processData:false,
                success: function(data) { //alert(data);
                    //success
                    // here we will handle errors and validation messages
                    if ( ! data.success) {
                    } else {
                        // ALL GOOD! just show the success message!
                        $("#user-documents").append(data.contracts);
                    }
                },
                error: function()  {
                    //error
                } 	        
        });
    }
    
    function fetch_contracts(c_id)
    {
        $('#c_id').val(c_id);
        
        var formData=new FormData();
        var token='<?php echo csrf_token(); ?>';
        formData.append('_token', token);
        formData.append('c_id', c_id);
        
        
        $.ajax({
                url: "<?php echo url('admin/fetch-contact-products') ?>",
                type: "POST",
                data:  formData,
                beforeSend: function(){ //alert('sending');
                        $("#products").empty();
                },
                contentType: false,
                processData:false,
                success: function(data) { //console.log(data);
                    //success
                    // here we will handle errors and validation messages
                    if ( ! data.success) {
                    } else {
                        // ALL GOOD! just show the success message!
                        $("#products").append(data.products);
                    }
                },
                error: function()  {
                    //error
                } 	        
        });
        
        $.ajax({
                url: "<?php echo url('admin/fetch-contracts') ?>",
                type: "POST",
                data:  formData,
                beforeSend: function(){ //alert('sending');
                        $("#user-contracts").empty();
                },
                contentType: false,
                processData:false,
                success: function(data) { //alert(data);
                    //success
                    // here we will handle errors and validation messages
                    if ( ! data.success) {
                    } else {
                        // ALL GOOD! just show the success message!
                        $("#user-contracts").append(data.contracts);
                    }
                },
                error: function()  {
                    //error
                } 	        
        });
        
        $.ajax({
                url: "<?php echo url('admin/fetch-documents') ?>",
                type: "POST",
                data:  formData,
                beforeSend: function(){ //alert('sending');
                        $("#user-documents").empty();
                },
                contentType: false,
                processData:false,
                success: function(data) { //alert(data);
                    //success
                    // here we will handle errors and validation messages
                    if ( ! data.success) {
                    } else {
                        // ALL GOOD! just show the success message!
                        $("#user-documents").append(data.contracts);
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
        if(status==1) $(".box-"+id).show();
        else $(".box-"+id).hide();
    }
    
    
    function check_data3()
    {
        $("#error").hide();
        $(".contact_error").hide();
        var atLeastOneIsChecked = $('input[name="courses[]"]:checked').length > 0;

        if(!$("#period_field").prop('required')){
            
        } else {
            //alert("YES");
        
        var period=$("#period_field").val();
        var dates=period.split(' - ');
        if(dates[0]==dates[1]) 
        {
           // $("#error").text('<?php echo trans('forms.beginning_end_same'); ?>');
            $("#error").show();
            //$(".contact_error").text('<?php echo trans('forms.beginning_end_same'); ?>');
            $(".contact_error").show();
            return false;
        }
        
        }
        
        if(!atLeastOneIsChecked)
        {
            //$("#error").text('Please select a course first.');
            //$("#error").show();
            //$(".contact_error").text('Please select a course first.');
            //$(".contact_error").show();
            //return false;
        }
        
        return true;
    }
    
    function check_data2()
    {
        $("#error2").hide();
        var contract_type=$("#contract_type").val();        
        if(contract_type=='Standard contract for Coach / Trainer') {        
        return true;
        }
        
        var atLeastOneIsChecked = $('input[name="courses[]"]:checked').length > 0;
        
        var period=$("#period_field2").val();
        var dates=period.split(' - ');
        if(dates[0]==dates[1]) 
        {
            $("#error2").text('<?php echo trans('forms.beginning_end_same'); ?>');
            $("#error2").show();
            return false;
        }
        
        if(!atLeastOneIsChecked)
        {
            $("#error2").text('<?php echo trans('forms.select_course_first'); ?>');
            $("#error2").show();
            return false;
        }
        
        return true;
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
        startDate: new Date(),
        locale: {
            format: 'DD-MM-YYYY'
        }
    });
    
    $('.calendar').daterangepicker({
        singleDatePicker: true,
        startDate: '01-01-1990',
        locale: {
            format: 'DD-MM-YYYY'
        }
    });
</script>