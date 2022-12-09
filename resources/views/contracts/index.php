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
                                            <?php if(isset($_GET['s'])) { ?>
                                            <p class="alert alert-success">Thank You, you have successfully signed the contract.</p>
                                            <?php } ?>
                                                
                                            <div class="card-body">
                                                <table style="width: 100%;" id="example3"
                                                       class="table table-hover table-striped table-bordered">
                                                    <thead>
                                                    <tr>
                                                        <th><?php echo trans('dashboard.contract'); ?></th>
                                                        <th><?php echo trans('forms.created_on'); ?></th>
                                                        <th><?php echo trans('dashboard.actions'); ?></th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php 
                                                        if(!empty($contracts)) {
                                                            foreach($contracts as $contract) {
                                                                $type=$contract['contract']->type;
                if($type=='Standard contract for Coach / Trainer') $type=trans('forms.standard_contract_for_coach_trainer');
                else if($type=='Coaching Contract for Coachee') $type=trans('forms.coaching_contract_for_coachee');
                else if($type=='Education Contract for Student') $type=trans('forms.education_contract_for_student');
                else if($type=='Extended Education Contract for Student') $type=trans('forms.extended_education_contract_for_student');
                else if($type=='Retraining Contract for Coachee / Student') $type=trans('forms.retraining_contract_for_coachee_student');
                else if($type=='Amendments to Retraining Contract') $type=trans('forms.amendments_to_retraining_contract');
                else if($type=='Contract for Student / Coachee Internship') $type=trans('forms.contract_for_student_coachee_internship');
                else if($type=='Private Jobsearch contract for Student / Coachee') $type=trans('forms.private_jobsearch_contract_for_student_coachee');
                                                        ?>
                                                    <tr>
                                                        <td><?php echo $type; ?></td>
                                                        <td>
                                                            <?php echo date_format(new DateTime($contract['contract']->on_date),'d-m-Y'); ?>
                                                            <p><?php echo date_format(new DateTime($contract['contract']->on_date),'H:i'); ?></p>
                                                        </td>
                                                        <td>
                                                            <a href="<?php echo url('company_files/contracts/'.$contract['contract']->contract); ?>" target="_blank" style="color: #da624a;"><button class="border-0 btn-transition btn btn-success">
                                                            <i class="fa fa-file-pdf"></i> <?php echo trans('forms.view_contract'); ?>
                                                            </button></a>
                                                            
                                                            <?php if($contract['sign_btn']=='1') { ?>
                                                            <a href="<?php echo url('contract/'.$contract['contract']->id); ?>" style="color: #da624a;"><button class="border-0 btn-transition btn btn-success">
                                                            <?php echo trans('forms.sign_contract'); ?>
                                                            </button></a>
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

<div class="modal fade" id="convert" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="<?php echo url('admin/convert-prospect'); ?>" method="post">
                    <input type="hidden" name="c_id" value="0" id="c_id">
                    <?php echo csrf_field(); ?>
              <div class="modal-header">
                  <h4 class="modal-title" id="modal-title">Convert Prospect</h4>
              </div>
              <div class="modal-body">
                  <p class="alert alert-success" id="ass-success" style="display:none;"></p>
                  <div class="row">
                      <div class="col-12 col-lg-12">
                          <div class="form-group">
                            <label for="exampleInputEmail1">Convert to <font style="color:red;">*</font></label>
                              <select name="convert" id="convert" class="form-control" required>
                                  <option value="">Please Select</option>
                                  <option value="Student">Student</option>
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

<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script>
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
    
    $('.calendar').daterangepicker({
        singleDatePicker: true,
        startDate: '01-01-1990',
        locale: {
            format: 'DD-MM-YYYY'
        }
    });
</script>