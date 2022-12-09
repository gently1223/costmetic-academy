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
                                    <div class="card-body"><h5 class="card-title"><?php echo trans('forms.add_new_document'); ?></h5>
                                        <form class="" action="" method="post" enctype="multipart/form-data">
                                            <?php echo csrf_field(); ?>
                                            <div class="form-row">
                                                <div class="col-md-6">
                                                    <div class="position-relative form-group">
                                                        <label for="exampleEmail11" class=""><?php echo trans('forms.type'); ?> <font style="color:red;">*</font></label>
                                                        <select name="name" id="exampleEmail11" class="form-control" required>
                                                            <option value="Standard contract for Coach / Trainer"><?php echo trans('forms.standard_contract_for_coach_trainer'); ?></option>
                                                            <option value="Coaching Contract for Coachee"><?php echo trans('forms.coaching_contract_for_coachee'); ?></option>
                                                            <option value="Education Contract for Student"><?php echo trans('forms.education_contract_for_student'); ?></option>
                                                            <option value="Extended Education Contract for Student"><?php echo trans('forms.extended_education_contract_for_student'); ?></option>
                                                            <option value="Retraining Contract for Coachee / Student"><?php echo trans('forms.retraining_contract_for_coachee_student'); ?></option>
                                                            <option value="Amendments to Retraining Contract"><?php echo trans('forms.amendments_to_retraining_contract'); ?></option>
                                                            <option value="Contract for Student / Coachee Internship"><?php echo trans('forms.contract_for_student_coachee_internship'); ?></option>
                                                            <option value="Private Jobsearch contract for Student / Coachee"><?php echo trans('forms.private_jobsearch_contract_for_student_coachee'); ?></option>
                                                            <?php if(!empty($document_types)) {
                                                                foreach($document_types as $t) {
                                                            ?>
                                                            <option value="<?php echo $t->name; ?>"><?php echo $t->name; ?></option>
                                                            <?php } } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-6">
                                                    <div class="position-relative form-group">
                                                        <label for="exampleEmail11" class=""><?php echo trans('dashboard.contact'); ?> <font style="color:red;">*</font></label>
                                                        <select name="contact" id="exampleEmail11" class="form-control" required>
                                                            <option value=""><?php echo trans('forms.please_select'); ?></option>
                                                            <?php if(!empty($contacts)) {
                                                                foreach($contacts as $t) {
                                                            ?>
                                                            <option value="<?php echo $t->id; ?>"><?php echo $t->name; ?></option>
                                                            <?php } } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-12">
                                                <div class="position-relative form-group">
                                                        <label for="exampleEmail11" class=""><?php echo trans('forms.document'); ?> <font style="color:red;">*</font></label>
                                                        <input name="file" id="exampleEmail11" type="file" class="form-control file" required style="display:none;">
                                                        <div class="browse" style="border:1px solid black; border-radius:3px; max-width:200px; padding:10px; padding-top:5px; padding-bottom:5px; cursor:pointer;"><?php echo trans('forms.choose_file'); ?></div>
                                                        <p class="mt-2" id="file_name" style="display:none;"></p>
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
                                                        <th><?php echo trans('dashboard.type'); ?></th>
                                                        <th><?php echo trans('dashboard.contract'); ?></th>
                                                        <th><?php echo trans('dashboard.contact'); ?></th>
                                                        <th style="min-width:70px;"><?php echo trans('dashboard.added_on'); ?></th>
                                                        <th><?php echo trans('dashboard.actions'); ?></th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php 
                                                        if(!empty($contracts)) {
                                                            foreach($contracts as $contract) {
                                                                if($contract['contract']->signature=='') { $signed='<br>'.trans('dashboard.no_signature'); $color='#da624a'; }
                                                                else { $signed='<br>'.trans('dashboard.signed'); $color='green'; }
                                                                
                                                                if($contract['contract']->document=='1') $signed='';
                
                                                                $created_on=date_format(new DateTime($contract['contract']->on_date),'d-m-Y H:i');
                                                                
                                                                if($contract['contract']->document=='0')
                                                                $url=url('company_files/contracts/'.$contract['contract']->contract);
                                                                else
                                                                $url=url('company_files/documents/'.$contract['contract']->contract);
                                                                
                                                                $type=$contract['contract']->type;
                if($type=='Standard contract for Coach / Trainer') $type=trans('forms.standard_contract_for_coach_trainer');
                else if($type=='Coaching Contract for Coachee') $type=trans('forms.coaching_contract_for_coachee');
                else if($type=='Education Contract for Student') $type=trans('forms.education_contract_for_student');
                else if($type=='Extended Education Contract for Student') $type=trans('forms.extended_education_contract_for_student');
                else if($type=='Retraining Contract for Coachee / Student') $type=trans('forms.retraining_contract_for_coachee_student');
                else if($type=='Amendments to Retraining Contract') $type=trans('forms.amendments_to_retraining_contract');
                else if($type=='Contract for Student / Coachee Internship') $type=trans('forms.contract_for_student_coachee_internship');
                else if($type=='Private Jobsearch contract for Student / Coachee') $type=trans('forms.private_jobsearch_contract_for_student_coachee');
                else if($type=='Voucher') $type=trans('forms.voucher');
                                                        ?>
                                                    <tr>
                                                        <td><?php echo $type; ?></td>
                                                        <td><a href=" <?php echo $url; ?>" target="_blank" style="color: <?php echo $color; ?>;"><i class="fa fa-file-pdf"></i> <?php
                                                                echo $contract['contract']->contract; ?></a>
                                                            <?php
                                                                if($contract['contract']->status!='3')
                                                                echo $signed;
                                                                else
                                                                {
                                                                    echo '<br><font style="color:red; font-weight:bold;"><i class="fa fa-history"></i> '.trans('forms.expired').'</font>';
                                                                }
                                                            ?>
                                                            
                                                            <?php if($contract['contract']->appointments=='0') { ?>
                                                            <!--<br>
                                                            <button class="btn btn-success" data-toggle="modal" data-target="#generate_appointments" onclick="fetch_timetable('<?php echo $contract['contract']->id; ?>')">Generate Appointments</button>-->
                                                            <?php } ?>
                                                        </td>
                                                        <td><?php if($contract['contact']=='NA') echo 'Contact deleted.';  else echo $contract['contact']->name.'<br>'.$contract['contact']->email; ?>
                                                        </td>
                                                        <td><?php echo date_format(new DateTime($contract['contract']->on_date),'d-m-Y'); ?>
                                                            <p style="color:#777;"><?php echo date_format(new DateTime($contract['contract']->on_date),'H:i'); ?></p>
                                                        </td>
                                                        <td>
                                                            <?php if($contract['contract']->status=='3') { ?>
                                                        <form action="" method="post" style="display:inline;">
                                                            <?php echo csrf_field(); ?>
                                                            <input type="hidden" name="resend" value="<?php echo $contract['contract']->id; ?>">
                                                        <button class="border-0 btn-transition btn btn-success" onclick="return confirm('Do you really want to resend this contract?');">
                                                        <?php echo trans('forms.resend'); ?>
                                                        </button>
                                                        </form>
                                                            <?php } ?>
                                                            
                                                            <?php if($contract['contract']->signature=='' OR $contract['contract']->document=='1') { ?>
                                                        <form action="" method="post" style="display:inline;">
                                                            <?php echo csrf_field(); ?>
                                                            <input type="hidden" name="delete" value="<?php echo $contract['contract']->id; ?>">
                                                        <button class="border-0 btn-transition btn btn-outline-danger" onclick="return confirm('Do you really want to delete this contract?');">
                                                        <i class="fa fa-trash"></i>
                                                        </button>
                                                        </form>
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

<div class="modal fade" id="generate_appointments" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
          <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
              <div class="modal-header">
                  <h4 class="modal-title" id="modal-title2">Generate Appointments</h4>
              </div>
                
                <form action="" method="post">
                    <input type="hidden" name="generate_appointments" value="1">
                    <input type="hidden" name="contract_id" value="0" id="contract_id">
                    <?php echo csrf_field(); ?>
              <div class="modal-body">
                  <p class="alert alert-success" id="ass-success" style="display:none;"></p>
<div aria-labelledby='contracts-tab' class="tab-pane fade show active" id='contracts' role='tabpanel'>
        
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Class</th>
                <th style="min-width:200px;">Days</th>
                <th>From</th>
                <th>To</th>
                <th>Notes</th>
                <th style="min-width:200px;">Room</th>
            </tr>
        </thead>
        <tbody id="contract-timetable">
            
        </tbody>
    </table>
        
    </div>
    
    <div aria-labelledby='create-tab' class="tab-pane fade" id='create-contracts' role='tabpanel'>
              
    </div>
                  
                <p class="alert alert-danger" id="error2" style="display:none;"></p>
              </div>
              <div class="modal-footer">    
                <button type="button" class="btn btn-default pull-right" data-dismiss="modal" id="add-appointment-close">Close</button>
    <button type="submit" class="btn btn-primary pull-right" style="margin-right:10px;" id="submit_btn"><?php echo trans('forms.submit'); ?></button>
              </div>
    </form>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>

<script>
    function fetch_timetable(c_id)
    {
        $('#contract_id').val(c_id);
        
        var formData=new FormData();
        var token='<?php echo csrf_token(); ?>';
        formData.append('_token', token);
        formData.append('contract_id', c_id);
        
        $.ajax({
                url: "<?php echo url('admin/fetch-timetable') ?>",
                type: "POST",
                data:  formData,
                beforeSend: function(){ //alert('sending');
                        $("#contract-timetable").empty();
                },
                contentType: false,
                processData:false,
                success: function(data) { //alert(data);
                    //success
                    // here we will handle errors and validation messages
                    if ( ! data.success) {
                    } else {
                        // ALL GOOD! just show the success message!
                        $("#contract-timetable").append(data.timetable);
                        $('.select-multiple').select2();
                    }
                },
                error: function()  {
                    //error
                } 	        
        });
    }
    
    $(document).on('click', '.browse', function(){
                    var file = $(this).prev();
                    file.trigger('click');
                  });

		  $(document).on('change', '.file', function(e){
                      /*var o=new FileReader;
                      o.readAsDataURL(e.target.files[0]),o.onloadend=function(o){
                          $("#car_image").attr("src",o.target.result); 
                      }*/
                    $("#file_name").text($(this).val().replace(/C:\\fakepath\\/i, ''));
                    $("#file_name").show();
                  });
</script>