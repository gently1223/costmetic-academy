<?php include(app_path().'/common/header.php'); ?>
<style>
    .template {
        border: 1px solid black;
        cursor: pointer;
    }
    
    .template-selected {
        border: 4px solid green;
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
                                        <div class="mb-3">
                                            
                                            <?php if(Session::has('error')) { ?>
                                            <p class="alert alert-danger"><?php echo Session::get('error'); ?></p>
                                            <?php } ?>
                                            <?php if(Session::has('success')) { ?>
                                            <p class="alert alert-success"><?php echo Session::get('success'); ?></p>
                                            <?php } ?>
                                            <?php if(isset($_GET['s'])) { ?>
                                            <p class="alert alert-success">Thank You, you have successfully signed the contract.</p>
                                            <?php } $fc_exp=0; $fc_edu=0; ?>
                                            
                                            <div id="form-box">
                                                    <div class="main-card mb-2 card">
                                    <div class="card-body p-0">
                                        <form class="" action="" method="post" enctype="multipart/form-data">
                                            <?php echo csrf_field(); ?>
                                            <div class="form-row p-4 ml-0" style="max-width:100%;">
                                                
                                                <div class="col-md-12">
                                                    <div class="position-relative form-group">
                                                        <label for="exampleEmail11" class=""><?php echo trans('forms.cv_title'); ?> <font style="color:red;">*</font></label>
                                                        <input type="text" name="title" class="form-control" required value="<?php if(isset($_GET['ti'])) echo $_GET['ti']; else if(isset($cv_details->title)) echo $cv_details->title; ?>" id="title">
                                                        <small>*<?php echo trans('forms.for_your_reference'); ?></small>
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-12">
                                                <h5><?php echo trans('forms.select_template'); ?>:</h5><hr>
                                                </div>
                                                
                                                <?php 
                                                if(isset($_GET['t']) AND ($_GET['t']>=1 AND $_GET['t']<=3)) $template=$_GET['t'];
                                                else if(isset($cv_details->template)) $template=$cv_details->template;
                                                else $template=1;
                                                ?>
                                                <input type="hidden" name="template" value="<?php echo $template; ?>" id="template">
                                                
                                                <div class="col-4 col-md-4 text-center">
                                                    <img src="<?php echo url('cv_templates/template1.jpg'); ?>" class="template <?php if($template=='1') echo 'template-selected'; ?>" style="width:100%; max-width:200px;" onclick="$('#template').val('1'); $('.template').removeClass('template-selected'); $(this).addClass('template-selected'); window.location='?t=1&ti='+$('#title').val();">
                                                </div>
                                                
                                                <div class="col-4 col-md-4 text-center">
                                                    <img src="<?php echo url('cv_templates/template2.jpg'); ?>" class="template <?php if($template=='2') echo 'template-selected'; ?>" style="width:100%; max-width:200px;" onclick="$('#template').val('2'); $('.template').removeClass('template-selected'); $(this).addClass('template-selected'); window.location='?t=2&ti='+$('#title').val();">
                                                </div>
                                                
                                                <div class="col-4 col-md-4 text-center">
                                                    <img src="<?php echo url('cv_templates/template3.jpg'); ?>" class="template <?php if($template=='3') echo 'template-selected'; ?>" style="width:100%; max-width:200px;" onclick="$('#template').val('3'); $('.template').removeClass('template-selected'); $(this).addClass('template-selected'); window.location='?t=3&ti='+$('#title').val();">
                                                </div>
                                                
                                                <div class="col-12 col-md-12 text-center mt-5" style="overflow-x:auto;">
                                                    
                                                    <iframe src="<?php echo url('cover-page?t='.$template.'&user='.$user->id.'&cv='.$cv); ?>" style="width:700px; border:1px solid black;" frameborder="0" scrolling="no" onload="resizeIframe(this)"></iframe>
                                                    
                                                </div>
                                                
                                                <div class="col-12 col-md-12 text-center mt-3" style="overflow-x:auto;">
                                                    
                                                    <iframe src="<?php echo url('covering-letter?t='.$template.'&user='.$user->id.'&cv='.$cv); ?>" style="width:700px; border:1px solid black;" frameborder="0" scrolling="no" onload="resizeIframe(this)"></iframe>
                                                    
                                                </div>
                                                
                                                <div class="col-12 col-md-12 text-center mt-3" style="overflow-x:auto;">
                                                    
                                                    <iframe src="<?php echo url('template?t='.$template.'&user='.$user->id.'&cv='.$cv); ?>" style="width:700px; border:1px solid black;" frameborder="0" scrolling="no" onload="resizeIframe(this)"></iframe>
                                                    
                                                </div>
                                                
                                            </div>
                                            
                                            <div class="form-row p-4 ml-0" style="background:#dedede; max-width:100%;">
                                                
                                                <div class="col-md-12">
                                                <h5><?php echo trans('forms.attachment'); ?>:</h5><hr>
                                                </div>
                                                
                                                <div class="form-row" style="width:100%;">
                                                <div class="col-md-12">
                                                    <div class="position-relative form-group">
                                                        <input type="file" class="form-control file" name="attachment" style="display:none;" accept="application/pdf">
                                                        <div class="browse" style="border:1px solid #d2d6de; padding:5px; cursor:pointer; background:white;"><i class="fa fa-image"></i> <?php echo trans('forms.choose_file'); ?></div>
                                                        
                                                        <p class="mt-2" id="file_name"></p>
                                                    </div>
                                                </div>
                                                </div>
                                                
                                            </div>
                                            
                                            <div class="form-row p-4 ml-0" style="max-width:100%;">
                                            <a href="<?php if($cv==0) echo url('create-cv'); else echo url('create-cv/'.$cv); ?>"><button class="mt-0 btn btn-primary mr-2" type="button"><i class="fa fa-arrow-left"></i> <?php echo trans('forms.back_edit'); ?></button></a>
                                            <button class="mt-0 btn btn-primary"><?php echo trans('forms.request_generate_pdf'); ?></button>
                                            </div>
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
<?php include(app_path().'/common/footer.php'); ?>

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
</script>
<script>
    
    window.fc_exp=<?php echo $fc_exp; ?>;
    window.fc_edu=<?php echo $fc_edu; ?>;
    
    function add_job_resp(th, fc)
    {
        $(th).prev().children('#job_resp_box').append('<input type="text" name="job_responsibilities'+fc+'[]" class="form-control mb-2">');
    }
    
    function add_edu_details(th, fc)
    {
        $(th).prev().children('#edu_details_box').append('<input type="text" name="edu_details'+fc+'[]" class="form-control mb-2">');
    }
    
    function add_lng(th)
    {
        $("#lng_box").append('<div class="col-md-6">\
                                                    <div class="position-relative form-group">\
                                                        <label for="exampleEmail11" class=""><?php echo trans("forms.language"); ?></label>\
                                                        <input type="text" name="language[]" class="form-control">\
                                                    </div>\
                                                </div>\
                                                <div class="col-md-6">\
                                                    <div class="position-relative form-group">\
                                                        <label for="exampleEmail11" class=""><?php echo trans("forms.fluency"); ?> </label>\
                                                        <input type="text" name="lng_fluency[]" class="form-control">\
                                                    </div>\
                                                </div>');
    }
    
    function add_skill(th)
    {
        $("#skill_box").append('<div class="col-md-6">\
                                                    <div class="position-relative form-group">\
                                                        <label for="exampleEmail11" class=""><?php echo trans("forms.skill"); ?></label>\
                                                        <input type="text" name="skill[]" class="form-control">\
                                                    </div>\
                                                </div>\
                                                <div class="col-md-6">\
                                                    <div class="position-relative form-group">\
                                                        <label for="exampleEmail11" class=""><?php echo trans("forms.fluency"); ?> </label>\
                                                        <input type="text" name="skill_fluency[]" class="form-control">\
                                                    </div>\
                                                </div>');
    }
    
    function add_exp(th, fc)
    {
        window.fc+=1;
        $("#exp_box").append('<div class="col-md-12"><center><hr style="border:1px dashed #dedede;"></center></div><div class="col-md-6">\
                                                    <div class="position-relative form-group">\
                                                        <label for="exampleEmail11" class=""><?php echo trans("forms.job_title"); ?> </label>\
                                                        <input type="text" name="job_title[]" class="form-control">\
                                                    </div>\
                                                </div>\
                                                <div class="col-md-6">\
                                                    <div class="position-relative form-group">\
                                                        <label for="exampleEmail11" class=""><?php echo trans("forms.company_name"); ?> </label>\
                                                        <input type="text" name="company_name[]" class="form-control">\
                                                    </div>\
                                                </div>\
                                                <div class="col-md-6">\
                                                    <div class="position-relative form-group">\
                                                        <label for="exampleEmail11" class="" style="display:block;"><?php echo trans("forms.from"); ?> </label>\
                                                        <select name="from_month[]" class="form-control" style="display:inline-block; max-width:100px;">\
                                                            <option value=""><?php echo trans("forms.month"); ?></option>\
                                                            <option value="1">01</option>\
                                                            <option value="2">02</option>\
                                                            <option value="3">03</option>\
                                                            <option value="4">04</option>\
                                                            <option value="5">05</option>\
                                                            <option value="6">06</option>\
                                                            <option value="7">07</option>\
                                                            <option value="8">08</option>\
                                                            <option value="9">09</option>\
                                                            <option value="10">10</option>\
                                                            <option value="11">11</option>\
                                                            <option value="12">12</option>\
                                                        </select>\
                                                        <select name="from_year[]" class="form-control" style="display:inline-block; max-width:100px;">\
                                                            <option value=""><?php echo trans("forms.year"); ?></option>\
                                                            <?php for($i=date("Y"); $i>=1980; $i--) { ?>
                                                            <option value="<?php echo $i; ?>"><?php echo $i; ?></option>\
                                                            <?php } ?>
                                                        </select>\
                                                        &nbsp;&nbsp;<b>-</b>&nbsp;&nbsp; <input type="checkbox" name="to_present'+window.fc_exp+'" value="1"> Present\
                                                    </div>\
                                                </div>\
                                                <div class="col-md-6">\
                                                    <div class="position-relative form-group">\
                                                        <label for="exampleEmail11" class="" style="display:block;"><?php echo trans("forms.to"); ?> </label>\
                                                        <select name="to_month[]" class="form-control" style="display:inline-block; max-width:100px;">\
                                                            <option value=""><?php echo trans("forms.month"); ?></option>\
                                                            <option value="1">01</option>\
                                                            <option value="2">02</option>\
                                                            <option value="3">03</option>\
                                                            <option value="4">04</option>\
                                                            <option value="5">05</option>\
                                                            <option value="6">06</option>\
                                                            <option value="7">07</option>\
                                                            <option value="8">08</option>\
                                                            <option value="9">09</option>\
                                                            <option value="10">10</option>\
                                                            <option value="11">11</option>\
                                                            <option value="12">12</option>\
                                                        </select>\
                                                        <select name="to_year[]" class="form-control" style="display:inline-block; max-width:100px;">\
                                                            <option value=""><?php echo trans("forms.year"); ?></option>\
                                                            <?php for($i=date('Y'); $i>=1980; $i--) { ?>
                                                            <option value="<?php echo $i; ?>"><?php echo $i; ?></option>\
                                                            <?php } ?>
                                                        </select>\
                                                    </div>\
                                                </div>\
                                                <div class="col-md-12">\
                                                    <div class="position-relative form-group">\
                                                        <label for="exampleEmail11" class=""><?php echo trans("forms.responsibilities"); ?> </label>\
                                                        <span id="job_resp_box">\
                                                        <input type="text" name="job_responsibilities'+window.fc_exp+'[]" class="form-control mb-2">\
                                                        </span>\
                                                    </div>\
                                                    <a href="javascript:void(0)" onclick="add_job_resp(this, '+window.fc_exp+')"><i class="fa fa-plus-circle"></i> <?php echo trans('forms.add_more'); ?> </a>\
                                                </div>');
    }
                             
    function add_edu(th, fc)
    {
        window.fc_edu+=1;
        $("#edu_box").append('<div class="col-md-12"><center><hr style="border:1px dashed white;"></center></div><div class="col-md-6">\
                                                    <div class="position-relative form-group">\
                                                        <label for="exampleEmail11" class=""><?php echo trans("forms.school_university"); ?> </label>\
                                                        <input type="text" name="school[]" class="form-control">\
                                                    </div>\
                                                </div>\
                                                <div class="col-md-6">\
                                                    <div class="position-relative form-group">\
                                                        <label for="exampleEmail11" class=""><?php echo trans("forms.qualification"); ?> </label>\
                                                        <input type="text" name="qualification[]" class="form-control">\
                                                    </div>\
                                                </div>\
                                                <div class="col-md-6">\
                                                    <div class="position-relative form-group">\
                                                        <label for="exampleEmail11" class="" style="display:block;"><?php echo trans("forms.from"); ?> </label>\
                                                        <select name="edu_from_month[]" class="form-control" style="display:inline-block; max-width:100px;">\
                                                            <option value=""><?php echo trans("forms.month"); ?></option>\
                                                            <option value="1">01</option>\
                                                            <option value="2">02</option>\
                                                            <option value="3">03</option>\
                                                            <option value="4">04</option>\
                                                            <option value="5">05</option>\
                                                            <option value="6">06</option>\
                                                            <option value="7">07</option>\
                                                            <option value="8">08</option>\
                                                            <option value="9">09</option>\
                                                            <option value="10">10</option>\
                                                            <option value="11">11</option>\
                                                            <option value="12">12</option>\
                                                        </select>\
                                                        <select name="edu_from_year[]" class="form-control" style="display:inline-block; max-width:100px;">\
                                                            <option value=""><?php echo trans("forms.year"); ?></option>\
                                                            <?php for($i=date("Y"); $i>=1980; $i--) { ?>
                                                            <option value="<?php echo $i; ?>"><?php echo $i; ?></option>\
                                                            <?php } ?>
                                                        </select>\
                                                        &nbsp;&nbsp;<b>-</b>&nbsp;&nbsp; <input type="checkbox" name="edu_to_present'+window.fc_edu+'" value="1"> Present\
                                                    </div>\
                                                </div>\
                                                <div class="col-md-6">\
                                                    <div class="position-relative form-group">\
                                                        <label for="exampleEmail11" class="" style="display:block;"><?php echo trans("forms.to"); ?> </label>\
                                                        <select name="edu_to_month[]" class="form-control" style="display:inline-block; max-width:100px;">\
                                                            <option value=""><?php echo trans("forms.month"); ?></option>\
                                                            <option value="1">01</option>\
                                                            <option value="2">02</option>\
                                                            <option value="3">03</option>\
                                                            <option value="4">04</option>\
                                                            <option value="5">05</option>\
                                                            <option value="6">06</option>\
                                                            <option value="7">07</option>\
                                                            <option value="8">08</option>\
                                                            <option value="9">09</option>\
                                                            <option value="10">10</option>\
                                                            <option value="11">11</option>\
                                                            <option value="12">12</option>\
                                                        </select>\
                                                        <select name="edu_to_year[]" class="form-control" style="display:inline-block; max-width:100px;">\
                                                            <option value=""><?php echo trans("forms.year"); ?></option>\
                                                            <?php for($i=date('Y'); $i>=1980; $i--) { ?>
                                                            <option value="<?php echo $i; ?>"><?php echo $i; ?></option>\
                                                            <?php } ?>
                                                        </select>\
                                                    </div>\
                                                </div>\
                                                <div class="col-md-12">\
                                                    <div class="position-relative form-group">\
                                                        <label for="exampleEmail11" class=""><?php echo trans("forms.responsibilities"); ?> </label>\
                                                        <span id="edu_details_box">\
                                                        <input type="text" name="edu_details'+window.fc_edu+'[]" class="form-control mb-2">\
                                                        </span>\
                                                    </div>\
                                                    <a href="javascript:void(0)" onclick="add_edu_details(this, '+window.fc_edu+')"><i class="fa fa-plus-circle"></i> <?php echo trans('forms.add_more'); ?> </a>\
                                                </div>');
    }
</script>