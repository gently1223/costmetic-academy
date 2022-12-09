<?php include(app_path().'/common/header.php'); ?>
<style>
            .jay-signature-pad {
                width:100% !important;
                border: 1px solid #e8e8e8;
                background-color: #fff;
                box-shadow: 0 3px 20px rgba(0, 0, 0, 0.27), 0 0 40px rgba(0, 0, 0, 0.08) inset;
                border-radius: 15px;
                padding: 20px;
                padding-left: 0px;
                padding-right: 0px;
            }
    
    canvas{
        box-shadow: 0 3px 20px rgba(0, 0, 0, 0.27), 0 0 40px rgba(0, 0, 0, 0.08) inset;
    }
            .txt-center {
                text-align: -webkit-center;
            }
</style>
<style>
    @-webkit-keyframes passing-through {
  0% {
    opacity: 0;
    -webkit-transform: translateY(40px);
    -moz-transform: translateY(40px);
    -ms-transform: translateY(40px);
    -o-transform: translateY(40px);
    transform: translateY(40px); }
  30%, 70% {
    opacity: 1;
    -webkit-transform: translateY(0px);
    -moz-transform: translateY(0px);
    -ms-transform: translateY(0px);
    -o-transform: translateY(0px);
    transform: translateY(0px); }
  100% {
    opacity: 0;
    -webkit-transform: translateY(-40px);
    -moz-transform: translateY(-40px);
    -ms-transform: translateY(-40px);
    -o-transform: translateY(-40px);
    transform: translateY(-40px); } }
@-moz-keyframes passing-through {
  0% {
    opacity: 0;
    -webkit-transform: translateY(40px);
    -moz-transform: translateY(40px);
    -ms-transform: translateY(40px);
    -o-transform: translateY(40px);
    transform: translateY(40px); }
  30%, 70% {
    opacity: 1;
    -webkit-transform: translateY(0px);
    -moz-transform: translateY(0px);
    -ms-transform: translateY(0px);
    -o-transform: translateY(0px);
    transform: translateY(0px); }
  100% {
    opacity: 0;
    -webkit-transform: translateY(-40px);
    -moz-transform: translateY(-40px);
    -ms-transform: translateY(-40px);
    -o-transform: translateY(-40px);
    transform: translateY(-40px); } }
@keyframes passing-through {
  0% {
    opacity: 0;
    -webkit-transform: translateY(40px);
    -moz-transform: translateY(40px);
    -ms-transform: translateY(40px);
    -o-transform: translateY(40px);
    transform: translateY(40px); }
  30%, 70% {
    opacity: 1;
    -webkit-transform: translateY(0px);
    -moz-transform: translateY(0px);
    -ms-transform: translateY(0px);
    -o-transform: translateY(0px);
    transform: translateY(0px); }
  100% {
    opacity: 0;
    -webkit-transform: translateY(-40px);
    -moz-transform: translateY(-40px);
    -ms-transform: translateY(-40px);
    -o-transform: translateY(-40px);
    transform: translateY(-40px); } }
@-webkit-keyframes slide-in {
  0% {
    opacity: 0;
    -webkit-transform: translateY(40px);
    -moz-transform: translateY(40px);
    -ms-transform: translateY(40px);
    -o-transform: translateY(40px);
    transform: translateY(40px); }
  30% {
    opacity: 1;
    -webkit-transform: translateY(0px);
    -moz-transform: translateY(0px);
    -ms-transform: translateY(0px);
    -o-transform: translateY(0px);
    transform: translateY(0px); } }
@-moz-keyframes slide-in {
  0% {
    opacity: 0;
    -webkit-transform: translateY(40px);
    -moz-transform: translateY(40px);
    -ms-transform: translateY(40px);
    -o-transform: translateY(40px);
    transform: translateY(40px); }
  30% {
    opacity: 1;
    -webkit-transform: translateY(0px);
    -moz-transform: translateY(0px);
    -ms-transform: translateY(0px);
    -o-transform: translateY(0px);
    transform: translateY(0px); } }
@keyframes slide-in {
  0% {
    opacity: 0;
    -webkit-transform: translateY(40px);
    -moz-transform: translateY(40px);
    -ms-transform: translateY(40px);
    -o-transform: translateY(40px);
    transform: translateY(40px); }
  30% {
    opacity: 1;
    -webkit-transform: translateY(0px);
    -moz-transform: translateY(0px);
    -ms-transform: translateY(0px);
    -o-transform: translateY(0px);
    transform: translateY(0px); } }
@-webkit-keyframes pulse {
  0% {
    -webkit-transform: scale(1);
    -moz-transform: scale(1);
    -ms-transform: scale(1);
    -o-transform: scale(1);
    transform: scale(1); }
  10% {
    -webkit-transform: scale(1.1);
    -moz-transform: scale(1.1);
    -ms-transform: scale(1.1);
    -o-transform: scale(1.1);
    transform: scale(1.1); }
  20% {
    -webkit-transform: scale(1);
    -moz-transform: scale(1);
    -ms-transform: scale(1);
    -o-transform: scale(1);
    transform: scale(1); } }
@-moz-keyframes pulse {
  0% {
    -webkit-transform: scale(1);
    -moz-transform: scale(1);
    -ms-transform: scale(1);
    -o-transform: scale(1);
    transform: scale(1); }
  10% {
    -webkit-transform: scale(1.1);
    -moz-transform: scale(1.1);
    -ms-transform: scale(1.1);
    -o-transform: scale(1.1);
    transform: scale(1.1); }
  20% {
    -webkit-transform: scale(1);
    -moz-transform: scale(1);
    -ms-transform: scale(1);
    -o-transform: scale(1);
    transform: scale(1); } }
@keyframes pulse {
  0% {
    -webkit-transform: scale(1);
    -moz-transform: scale(1);
    -ms-transform: scale(1);
    -o-transform: scale(1);
    transform: scale(1); }
  10% {
    -webkit-transform: scale(1.1);
    -moz-transform: scale(1.1);
    -ms-transform: scale(1.1);
    -o-transform: scale(1.1);
    transform: scale(1.1); }
  20% {
    -webkit-transform: scale(1);
    -moz-transform: scale(1);
    -ms-transform: scale(1);
    -o-transform: scale(1);
    transform: scale(1); } }
.dropzone, .dropzone * {
  box-sizing: border-box; }

.dropzone {
  min-height: 150px;
  border: 2px solid rgba(0, 0, 0, 0.3);
  background: white;
  padding: 54px 54px; }
  .dropzone.dz-clickable {
    cursor: pointer; }
    .dropzone.dz-clickable * {
      cursor: default; }
    .dropzone.dz-clickable .dz-message, .dropzone.dz-clickable .dz-message * {
      cursor: pointer; }
  .dropzone.dz-started .dz-message {
    display: none; }
  .dropzone.dz-drag-hover {
    border-style: solid; }
    .dropzone.dz-drag-hover .dz-message {
      opacity: 0.5; }
  .dropzone .dz-message {
    text-align: center;
    margin: 2em 0; }
  .dropzone .dz-preview {
    position: relative;
    display: inline-block;
    vertical-align: top;
    margin: 16px;
    min-height: 100px; }
    .dropzone .dz-preview:hover {
      z-index: 1000; }
      .dropzone .dz-preview:hover .dz-details {
        opacity: 1; }
    .dropzone .dz-preview.dz-file-preview .dz-image {
      border-radius: 20px;
      background: #999;
      background: linear-gradient(to bottom, #eee, #ddd); }
    .dropzone .dz-preview.dz-file-preview .dz-details {
      opacity: 1; }
    .dropzone .dz-preview.dz-image-preview {
      background: white; }
      .dropzone .dz-preview.dz-image-preview .dz-details {
        -webkit-transition: opacity 0.2s linear;
        -moz-transition: opacity 0.2s linear;
        -ms-transition: opacity 0.2s linear;
        -o-transition: opacity 0.2s linear;
        transition: opacity 0.2s linear; }
    .dropzone .dz-preview .dz-remove {
      font-size: 14px;
      text-align: center;
      display: block;
      cursor: pointer;
      border: none; }
      .dropzone .dz-preview .dz-remove:hover {
        text-decoration: underline; }
    .dropzone .dz-preview:hover .dz-details {
      opacity: 1; }
    .dropzone .dz-preview .dz-details {
      z-index: 20;
      position: absolute;
      top: 0;
      left: 0;
      opacity: 0;
      font-size: 13px;
      min-width: 100%;
      max-width: 100%;
      padding: 2em 1em;
      text-align: center;
      color: rgba(0, 0, 0, 0.9);
      line-height: 150%; }
      .dropzone .dz-preview .dz-details .dz-size {
        margin-bottom: 1em;
        font-size: 16px; }
      .dropzone .dz-preview .dz-details .dz-filename {
        white-space: nowrap; }
        .dropzone .dz-preview .dz-details .dz-filename:hover span {
          border: 1px solid rgba(200, 200, 200, 0.8);
          background-color: rgba(255, 255, 255, 0.8); }
        .dropzone .dz-preview .dz-details .dz-filename:not(:hover) {
          overflow: hidden;
          text-overflow: ellipsis; }
          .dropzone .dz-preview .dz-details .dz-filename:not(:hover) span {
            border: 1px solid transparent; }
      .dropzone .dz-preview .dz-details .dz-filename span, .dropzone .dz-preview .dz-details .dz-size span {
        background-color: rgba(255, 255, 255, 0.4);
        padding: 0 0.4em;
        border-radius: 3px; }
    .dropzone .dz-preview:hover .dz-image img {
      -webkit-transform: scale(1.05, 1.05);
      -moz-transform: scale(1.05, 1.05);
      -ms-transform: scale(1.05, 1.05);
      -o-transform: scale(1.05, 1.05);
      transform: scale(1.05, 1.05);
      -webkit-filter: blur(8px);
      filter: blur(8px); }
    .dropzone .dz-preview .dz-image {
      border-radius: 20px;
      overflow: hidden;
      width: 120px;
      height: 120px;
      position: relative;
      display: block;
      z-index: 10; }
      .dropzone .dz-preview .dz-image img {
        display: block; }
    .dropzone .dz-preview.dz-success .dz-success-mark {
      -webkit-animation: passing-through 3s cubic-bezier(0.77, 0, 0.175, 1);
      -moz-animation: passing-through 3s cubic-bezier(0.77, 0, 0.175, 1);
      -ms-animation: passing-through 3s cubic-bezier(0.77, 0, 0.175, 1);
      -o-animation: passing-through 3s cubic-bezier(0.77, 0, 0.175, 1);
      animation: passing-through 3s cubic-bezier(0.77, 0, 0.175, 1); }
    .dropzone .dz-preview.dz-error .dz-error-mark {
      opacity: 1;
      -webkit-animation: slide-in 3s cubic-bezier(0.77, 0, 0.175, 1);
      -moz-animation: slide-in 3s cubic-bezier(0.77, 0, 0.175, 1);
      -ms-animation: slide-in 3s cubic-bezier(0.77, 0, 0.175, 1);
      -o-animation: slide-in 3s cubic-bezier(0.77, 0, 0.175, 1);
      animation: slide-in 3s cubic-bezier(0.77, 0, 0.175, 1); }
    .dropzone .dz-preview .dz-success-mark, .dropzone .dz-preview .dz-error-mark {
      pointer-events: none;
      opacity: 0;
      z-index: 500;
      position: absolute;
      display: block;
      top: 50%;
      left: 50%;
      margin-left: -27px;
      margin-top: -27px; }
      .dropzone .dz-preview .dz-success-mark svg, .dropzone .dz-preview .dz-error-mark svg {
        display: block;
        width: 54px;
        height: 54px; }
    .dropzone .dz-preview.dz-processing .dz-progress {
      opacity: 1;
      -webkit-transition: all 0.2s linear;
      -moz-transition: all 0.2s linear;
      -ms-transition: all 0.2s linear;
      -o-transition: all 0.2s linear;
      transition: all 0.2s linear; }
    .dropzone .dz-preview.dz-complete .dz-progress {
      opacity: 0;
      -webkit-transition: opacity 0.4s ease-in;
      -moz-transition: opacity 0.4s ease-in;
      -ms-transition: opacity 0.4s ease-in;
      -o-transition: opacity 0.4s ease-in;
      transition: opacity 0.4s ease-in; }
    .dropzone .dz-preview:not(.dz-processing) .dz-progress {
      -webkit-animation: pulse 6s ease infinite;
      -moz-animation: pulse 6s ease infinite;
      -ms-animation: pulse 6s ease infinite;
      -o-animation: pulse 6s ease infinite;
      animation: pulse 6s ease infinite; }
    .dropzone .dz-preview .dz-progress {
      opacity: 1;
      z-index: 1000;
      pointer-events: none;
      position: absolute;
      height: 16px;
      left: 50%;
      top: 50%;
      margin-top: -8px;
      width: 80px;
      margin-left: -40px;
      background: rgba(255, 255, 255, 0.9);
      -webkit-transform: scale(1);
      border-radius: 8px;
      overflow: hidden; }
      .dropzone .dz-preview .dz-progress .dz-upload {
        background: #333;
        background: linear-gradient(to bottom, #666, #444);
        position: absolute;
        top: 0;
        left: 0;
        bottom: 0;
        width: 0;
        -webkit-transition: width 300ms ease-in-out;
        -moz-transition: width 300ms ease-in-out;
        -ms-transition: width 300ms ease-in-out;
        -o-transition: width 300ms ease-in-out;
        transition: width 300ms ease-in-out; }
    .dropzone .dz-preview.dz-error .dz-error-message {
      display: block; }
    .dropzone .dz-preview.dz-error:hover .dz-error-message {
      opacity: 1;
      pointer-events: auto; }
    .dropzone .dz-preview .dz-error-message {
      pointer-events: none;
      z-index: 1000;
      position: absolute;
      display: block;
      display: none;
      opacity: 0;
      -webkit-transition: opacity 0.3s ease;
      -moz-transition: opacity 0.3s ease;
      -ms-transition: opacity 0.3s ease;
      -o-transition: opacity 0.3s ease;
      transition: opacity 0.3s ease;
      border-radius: 8px;
      font-size: 13px;
      top: 130px;
      left: -10px;
      width: 140px;
      background: #be2626;
      background: linear-gradient(to bottom, #be2626, #a92222);
      padding: 0.5em 1.2em;
      color: white; }
      .dropzone .dz-preview .dz-error-message:after {
        content: '';
        position: absolute;
        top: -6px;
        left: 64px;
        width: 0;
        height: 0;
        border-left: 6px solid transparent;
        border-right: 6px solid transparent;
        border-bottom: 6px solid #be2626; }
    
    .pi-image-box{
        float: left;
        border: 2px dashed #007fed;
        border-radius: 10px;
        width: 200px;
        padding:10px;
        text-align: center;
        padding-top: 20px;
        padding-bottom: 30px;
        cursor: pointer;
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
                                        <form class="" action="" method="post" enctype="multipart/form-data" id="cv_form">
                                            <input type="hidden" name="create_cv" value="1">
                                            <?php echo csrf_field(); ?>
                                            
                                            <div class="form-row p-4 ml-0" style="max-width:100%;">
                                                
                                                <div class="col-md-12">
                                                <h5><?php echo trans('forms.personal_details'); ?>:</h5><hr>
                                                </div>
                                                
                                                <div class="form-row" style="width:100%;">
                                                    
                                                    <div class="col-md-12 mb-3">
                                                        <input type="hidden" name="profile_image" value="<?php echo $user->profile_image; ?>" id="img_file">
                                                    
                                                    <?php if($user->profile_image!='') { ?>
                                                    <img src="<?php echo url('images/profile/'.$user->profile_image); ?>" id="profile_image" style="max-width:200px; max-height:200px; float:left; margin-right:10px;">
                                                    <?php } else { ?>
                                                    <p>You can upload a profile picture from <a href="<?php echo url('my-profile'); ?>" style="text-decoration:underline; color:blue;">My Profile</a> page to use in the resume.</p>
                                                    <?php } ?>
                                                    </div>
                                                    
                                                    <!--<div class="col-md-12 mb-3">
                                                    <div class="position-relative form-group">
                                                        <label for="exampleEmail11" class="" style="display:block;"><?php //echo trans('forms.profile_image'); ?> <font style="color:red;">*</font></label>
                                                        <input type="file" name="pi" class="file" style="display:none;" id="profile_file">
                                                        <img src="<?php //if(isset($personal_details->profile_image)) echo url('company_files/profile_images/'.$personal_details->profile_image); ?>" id="profile_image" style="max-width:200px; max-height:200px; float:left; margin-right:10px;">
                                                        <div class="pi-image-box browse">
                                                            <p class="mb-0">
                                                                <i class="fa fa-plus"></i><br>
                                                                <?php //echo trans('forms.click_here_upload'); ?>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>-->
                                                    
                                                <div class="col-md-6">
                                                    <div class="position-relative form-group">
                                                        <label for="exampleEmail11" class=""><?php echo trans('forms.name'); ?> <font style="color:red;">*</font></label>
                                                        <input type="text" name="name" class="form-control" required value="<?php if(isset($personal_details->name)) echo $personal_details->name; else echo $user->name; ?>">
                                                    </div>
                                                </div>
                                                    
                                                <div class="col-md-6">
                                                    <div class="position-relative form-group">
                                                        <label for="exampleEmail11" class=""><?php echo trans('forms.email'); ?> <font style="color:red;">*</font></label>
                                                        <input type="text" name="email" class="form-control" required value="<?php if(isset($personal_details->email)) echo $personal_details->email; else echo $user->email; ?>">
                                                    </div>
                                                </div>
                                                    
                                                <div class="col-md-6">
                                                    <div class="position-relative form-group">
                                                        <label for="exampleEmail11" class=""><?php echo trans('forms.phone_no'); ?> <font style="color:red;">*</font></label>
                                                        <input type="text" name="phone_no" class="form-control" required value="<?php if(isset($personal_details->phone_no)) echo $personal_details->phone_no; else echo $user->phone_no; ?>">
                                                    </div>
                                                </div>
                                                    
                                                <div class="col-md-6">
                                                    <div class="position-relative form-group">
                                                        <label for="exampleEmail11" class=""><?php echo trans('forms.dob'); ?> <font style="color:red;">*</font></label>
                                                        <input type="text" name="dob" class="form-control" required value="<?php if(isset($personal_details->dob)) echo $personal_details->dob; ?>">
                                                    </div>
                                                </div>
                                                    
                                                <div class="col-md-12">
                                                    <div class="position-relative form-group">
                                                        <label for="exampleEmail11" class=""><?php echo trans('forms.address'); ?> <font style="color:red;">*</font></label>
                                                        <textarea name="address" class="form-control" required><?php if(isset($personal_details->address)) echo $personal_details->address; ?></textarea>
                                                    </div>
                                                </div>
                                                    
                                                <div class="col-md-12">
                                                    <p style="font-weight:bold; margin-top:20px;">Covering letter:</p>
                                                </div>
                                                    
                                                <div class="col-md-6">
                                                    <div class="position-relative form-group">
                                                        <label for="exampleEmail11" class=""><?php echo trans('forms.position_applied_for'); ?></label>
                                                        <input type="text" name="title" class="form-control" value="<?php if(isset($personal_details->title)) echo $personal_details->title; ?>">
                                                    </div>
                                                </div>
                                                    
                                                <div class="col-md-12">
                                                    <div class="position-relative form-group">
                                                        <label for="exampleEmail11" class=""><?php echo trans('forms.to_address'); ?></label>
                                                        <textarea name="to_address" class="form-control" placeholder="Company Name,
Person / Dept Name, 
Address (Street name, door no, zip code & city)" rows="3"><?php if(isset($personal_details->to_address)) echo $personal_details->to_address; ?></textarea>
                                                    </div>
                                                </div>
                                                    
                                                <div class="col-md-12">
                                                    <div class="position-relative form-group">
                                                        <label for="exampleEmail11" class=""><?php echo trans('forms.contents'); ?></label>
                                                        <textarea name="content" class="form-control" rows="5"><?php if(isset($personal_details->content)) echo $personal_details->content; ?></textarea>
                                                    </div>
                                                </div>
                                                    
                                                <div class="col-12 col-md-12">
                                                    <div class="position-relative form-group">
                                                        <label for="exampleEmail11" class=""><?php echo trans('forms.signature'); ?></label>
                                                        <input type="hidden" name="signature" id="signature" value="<?php if(isset($personal_details->signature)) echo $personal_details->signature; ?>">
                                                        
                                                        <div id="signature-pad" class="jay-signature-pad" style="width:100%;">
            <div class="jay-signature-pad--body" style="width:100%;">
                <center><canvas id="jay-signature-pad" style="max-width:100%;"></canvas></center>
            </div>
            <div class="signature-pad--footer txt-center mt-2">
                <div class="description"><strong> <?php echo trans('forms.sign_above'); ?> </strong></div>
                <div class="signature-pad--actions txt-center">
                    <div>
                        <button type="button" class="button clear" data-action="clear"><?php echo trans('forms.clear'); ?></button>
                    </div>
                </div>
            </div>
        </div>
                                                    </div>
                                                </div>
                                                    
                                                </div>
                                                
                                            </div>
                                            
                                            <div class="form-row p-4 ml-0" style="background:#dedede; max-width:100%;">
                                                
                                                <div class="col-md-12">
                                                <h5><?php echo trans('forms.experience'); ?>:</h5><hr>
                                                </div>
                                                
                                                <div class="row" id="exp_box">
                                                <div class="col-md-6">
                                                    <div class="position-relative form-group">
                                                        <label for="exampleEmail11" class=""><?php echo trans('forms.job_title'); ?></label>
                                                        <input type="text" name="job_title[]" class="form-control" value="<?php if(isset($experience[0])) echo $experience[0]->job_title; ?>">
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-6">
                                                    <div class="position-relative form-group">
                                                        <label for="exampleEmail11" class=""><?php echo trans('forms.company_name'); ?> </label>
                                                        <input type="text" name="company_name[]" class="form-control" value="<?php if(isset($experience[0])) echo $experience[0]->company_name; ?>">
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-6">
                                                    <div class="position-relative form-group">
                                                        <label for="exampleEmail11" class="" style="display:block;"><?php echo trans('forms.from'); ?> </label>
                                                        <select name="from_month[]" class="form-control" style="display:inline-block; max-width:100px;">
                                                            <option value=""><?php echo trans('forms.month'); ?></option>
                                                            <option value="1" <?php if(isset($experience[0]) AND $experience[0]->from_month=='1') echo 'selected'; ?> >01</option>
                                                            <option value="2" <?php if(isset($experience[0]) AND $experience[0]->from_month=='2') echo 'selected'; ?> >02</option>
                                                            <option value="3" <?php if(isset($experience[0]) AND $experience[0]->from_month=='3') echo 'selected'; ?> >03</option>
                                                            <option value="4" <?php if(isset($experience[0]) AND $experience[0]->from_month=='4') echo 'selected'; ?> >04</option>
                                                            <option value="5" <?php if(isset($experience[0]) AND $experience[0]->from_month=='5') echo 'selected'; ?> >05</option>
                                                            <option value="6" <?php if(isset($experience[0]) AND $experience[0]->from_month=='6') echo 'selected'; ?> >06</option>
                                                            <option value="7" <?php if(isset($experience[0]) AND $experience[0]->from_month=='7') echo 'selected'; ?> >07</option>
                                                            <option value="8" <?php if(isset($experience[0]) AND $experience[0]->from_month=='8') echo 'selected'; ?> >08</option>
                                                            <option value="9" <?php if(isset($experience[0]) AND $experience[0]->from_month=='9') echo 'selected'; ?> >09</option>
                                                            <option value="10" <?php if(isset($experience[0]) AND $experience[0]->from_month=='10') echo 'selected'; ?> >10</option>
                                                            <option value="11" <?php if(isset($experience[0]) AND $experience[0]->from_month=='11') echo 'selected'; ?> >11</option>
                                                            <option value="12" <?php if(isset($experience[0]) AND $experience[0]->from_month=='12') echo 'selected'; ?> >12</option>
                                                        </select>
                                                        
                                                        <select name="from_year[]" class="form-control" style="display:inline-block; max-width:100px;">
                                                            <option value=""><?php echo trans('forms.year'); ?></option>
                                                            <?php for($i=date('Y'); $i>=1980; $i--) { ?>
                                                            <option value="<?php echo $i; ?>" <?php if(isset($experience[0]) AND $experience[0]->from_year==$i) echo 'selected'; ?> ><?php echo $i; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                        
                                                        &nbsp;&nbsp;<b>-</b>&nbsp;&nbsp; <input type="checkbox" name="to_present<?php echo $fc_exp; ?>" value="1" <?php if(isset($experience[0]) AND $experience[0]->present=='1') echo 'checked'; ?> > <?php echo trans('forms.present'); ?>
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-6">
                                                    <div class="position-relative form-group">
                                                        <label for="exampleEmail11" class="" style="display:block;"><?php echo trans('forms.to'); ?> </label>
                                                        <select name="to_month[]" class="form-control" style="display:inline-block; max-width:100px;">
                                                            <option value=""><?php echo trans('forms.month'); ?></option>
                                                            <option value="1" <?php if(isset($experience[0]) AND $experience[0]->to_month=='1') echo 'selected'; ?> >01</option>
                                                            <option value="2" <?php if(isset($experience[0]) AND $experience[0]->to_month=='2') echo 'selected'; ?> >02</option>
                                                            <option value="3" <?php if(isset($experience[0]) AND $experience[0]->to_month=='3') echo 'selected'; ?> >03</option>
                                                            <option value="4" <?php if(isset($experience[0]) AND $experience[0]->to_month=='4') echo 'selected'; ?> >04</option>
                                                            <option value="5" <?php if(isset($experience[0]) AND $experience[0]->to_month=='5') echo 'selected'; ?> >05</option>
                                                            <option value="6" <?php if(isset($experience[0]) AND $experience[0]->to_month=='6') echo 'selected'; ?> >06</option>
                                                            <option value="7" <?php if(isset($experience[0]) AND $experience[0]->to_month=='7') echo 'selected'; ?> >07</option>
                                                            <option value="8" <?php if(isset($experience[0]) AND $experience[0]->to_month=='8') echo 'selected'; ?> >08</option>
                                                            <option value="9" <?php if(isset($experience[0]) AND $experience[0]->to_month=='9') echo 'selected'; ?> >09</option>
                                                            <option value="10" <?php if(isset($experience[0]) AND $experience[0]->to_month=='10') echo 'selected'; ?> >10</option>
                                                            <option value="11" <?php if(isset($experience[0]) AND $experience[0]->to_month=='11') echo 'selected'; ?> >11</option>
                                                            <option value="12" <?php if(isset($experience[0]) AND $experience[0]->to_month=='12') echo 'selected'; ?> >12</option>
                                                        </select>
                                                        
                                                        <select name="to_year[]" class="form-control" style="display:inline-block; max-width:100px;">
                                                            <option value=""><?php echo trans('forms.year'); ?></option>
                                                            <?php for($i=date('Y'); $i>=1980; $i--) { ?>
                                                            <option value="<?php echo $i; ?>" <?php if(isset($experience[0]) AND $experience[0]->to_year==$i) echo 'selected'; ?> ><?php echo $i; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-12">
                                                    <div class="position-relative form-group">
                                                        <label for="exampleEmail11" class=""><?php echo trans('forms.responsibilities'); ?> </label>
                                                        <span id="job_resp_box">
                                                            <?php 
                                                            $exp=array();
                                                            if(isset($experience[0]) AND $experience[0]->responsibilities!='') $exp=explode(';', $experience[0]->responsibilities);
                                                            
                                                            if(!empty($exp)) { $ic2=0;
                                                                foreach($exp as $e) {
                                                            ?>
                                                            <span>
                                                            <input type="text" name="job_responsibilities<?php echo $fc_exp; ?>[]" class="form-control mb-2" value="<?php echo $e; ?>" <?php if($ic2!=0) { ?> style="max-width:97%; display:inline-block;" <?php } ?> >
                                                                <?php if($ic2++!=0) { ?>
                                                            <a href="javascript:void(0)" onclick="$(this).parent().remove();"><i class="fa fa-minus-circle" style="color:red;"></i></a>
                                                                <?php } ?>
                                                            </span>
                                                            <?php } } else { ?>
                                                            <input type="text" name="job_responsibilities<?php echo $fc_exp; ?>[]" class="form-control mb-2">
                                                            <?php } ?>
                                                        </span>
                                                    </div>
                                                    <a href="javascript:void(0)" onclick="add_job_resp(this, '<?php echo $fc_exp; ?>')"><i class="fa fa-plus-circle"></i> <?php echo trans('forms.add_more'); ?> </a>
                                                </div>
                                                    
                                                    <?php 
                                                    if(count($experience)>1) {
                                                        for($i=1; $i<count($experience); $i++) { $fc_exp++;
                                                    ?>
                                                    <div class="form-row pt-0 pb-0 ml-0" style="padding-left:10px; padding-right:17px;">
                                                        
                                                    <div class="col-md-12"><center><hr style="border:1px dashed white;"></center></div>
                                                        
                                                        <div class="col-md-12 mb-2">
                                                    <a href="javascript:void(0)" class="" onclick="$(this).parent().parent().remove();" style=""><i class="fa fa-minus-circle" style="color:red;"></i> <?php echo trans('forms.remove_experience'); ?> </a>
                                                        </div>
                                                        
                                                    <div class="col-md-6">
                                                    <div class="position-relative form-group">
                                                        <label for="exampleEmail11" class=""><?php echo trans('forms.job_title'); ?></label>
                                                        <input type="text" name="job_title[]" class="form-control" value="<?php if(isset($experience[$i])) echo $experience[$i]->job_title; ?>">
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-6">
                                                    <div class="position-relative form-group">
                                                        <label for="exampleEmail11" class=""><?php echo trans('forms.company_name'); ?> </label>
                                                        <input type="text" name="company_name[]" class="form-control" value="<?php if(isset($experience[$i])) echo $experience[$i]->company_name; ?>">
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-6">
                                                    <div class="position-relative form-group">
                                                        <label for="exampleEmail11" class="" style="display:block;"><?php echo trans('forms.from'); ?> </label>
                                                        <select name="from_month[]" class="form-control" style="display:inline-block; max-width:100px;">
                                                            <option value=""><?php echo trans('forms.month'); ?></option>
                                                            <option value="1" <?php if(isset($experience[$i]) AND $experience[$i]->from_month=='1') echo 'selected'; ?> >01</option>
                                                            <option value="2" <?php if(isset($experience[$i]) AND $experience[$i]->from_month=='2') echo 'selected'; ?> >02</option>
                                                            <option value="3" <?php if(isset($experience[$i]) AND $experience[$i]->from_month=='3') echo 'selected'; ?> >03</option>
                                                            <option value="4" <?php if(isset($experience[$i]) AND $experience[$i]->from_month=='4') echo 'selected'; ?> >04</option>
                                                            <option value="5" <?php if(isset($experience[$i]) AND $experience[$i]->from_month=='5') echo 'selected'; ?> >05</option>
                                                            <option value="6" <?php if(isset($experience[$i]) AND $experience[$i]->from_month=='6') echo 'selected'; ?> >06</option>
                                                            <option value="7" <?php if(isset($experience[$i]) AND $experience[$i]->from_month=='7') echo 'selected'; ?> >07</option>
                                                            <option value="8" <?php if(isset($experience[$i]) AND $experience[$i]->from_month=='8') echo 'selected'; ?> >08</option>
                                                            <option value="9" <?php if(isset($experience[$i]) AND $experience[$i]->from_month=='9') echo 'selected'; ?> >09</option>
                                                            <option value="10" <?php if(isset($experience[$i]) AND $experience[$i]->from_month=='10') echo 'selected'; ?> >10</option>
                                                            <option value="11" <?php if(isset($experience[$i]) AND $experience[$i]->from_month=='11') echo 'selected'; ?> >11</option>
                                                            <option value="12" <?php if(isset($experience[$i]) AND $experience[$i]->from_month=='12') echo 'selected'; ?> >12</option>
                                                        </select>
                                                        
                                                        <select name="from_year[]" class="form-control" style="display:inline-block; max-width:100px;">
                                                            <option value=""><?php echo trans('forms.year'); ?></option>
                                                            <?php for($i2=date('Y'); $i2>=1980; $i2--) { ?>
                                                            <option value="<?php echo $i2; ?>" <?php if(isset($experience[$i]) AND $experience[$i]->from_year==$i2) echo 'selected'; ?> ><?php echo $i2; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                        
                                                        &nbsp;&nbsp;<b>-</b>&nbsp;&nbsp; <input type="checkbox" name="to_present<?php echo $fc_exp; ?>" value="1" <?php if(isset($experience[$i]) AND $experience[$i]->present=='1') echo 'checked'; ?> > <?php echo trans('forms.present'); ?>
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-6">
                                                    <div class="position-relative form-group">
                                                        <label for="exampleEmail11" class="" style="display:block;"><?php echo trans('forms.to'); ?> </label>
                                                        <select name="to_month[]" class="form-control" style="display:inline-block; max-width:100px;">
                                                            <option value=""><?php echo trans('forms.month'); ?></option>
                                                            <option value="1" <?php if(isset($experience[$i]) AND $experience[$i]->to_month=='1') echo 'selected'; ?> >01</option>
                                                            <option value="2" <?php if(isset($experience[$i]) AND $experience[$i]->to_month=='2') echo 'selected'; ?> >02</option>
                                                            <option value="3" <?php if(isset($experience[$i]) AND $experience[$i]->to_month=='3') echo 'selected'; ?> >03</option>
                                                            <option value="4" <?php if(isset($experience[$i]) AND $experience[$i]->to_month=='4') echo 'selected'; ?> >04</option>
                                                            <option value="5" <?php if(isset($experience[$i]) AND $experience[$i]->to_month=='5') echo 'selected'; ?> >05</option>
                                                            <option value="6" <?php if(isset($experience[$i]) AND $experience[$i]->to_month=='6') echo 'selected'; ?> >06</option>
                                                            <option value="7" <?php if(isset($experience[$i]) AND $experience[$i]->to_month=='7') echo 'selected'; ?> >07</option>
                                                            <option value="8" <?php if(isset($experience[$i]) AND $experience[$i]->to_month=='8') echo 'selected'; ?> >08</option>
                                                            <option value="9" <?php if(isset($experience[$i]) AND $experience[$i]->to_month=='9') echo 'selected'; ?> >09</option>
                                                            <option value="10" <?php if(isset($experience[$i]) AND $experience[$i]->to_month=='10') echo 'selected'; ?> >10</option>
                                                            <option value="11" <?php if(isset($experience[$i]) AND $experience[$i]->to_month=='11') echo 'selected'; ?> >11</option>
                                                            <option value="12" <?php if(isset($experience[$i]) AND $experience[$i]->to_month=='12') echo 'selected'; ?> >12</option>
                                                        </select>
                                                        
                                                        <select name="to_year[]" class="form-control" style="display:inline-block; max-width:100px;">
                                                            <option value=""><?php echo trans('forms.year'); ?></option>
                                                            <?php for($i2=date('Y'); $i2>=1980; $i2--) { ?>
                                                            <option value="<?php echo $i2; ?>" <?php if(isset($experience[$i]) AND $experience[$i]->to_year==$i2) echo 'selected'; ?> ><?php echo $i2; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-12">
                                                    <div class="position-relative form-group">
                                                        <label for="exampleEmail11" class=""><?php echo trans('forms.responsibilities'); ?> </label>
                                                        <span id="job_resp_box">
                                                            <?php 
                                                            $exp=array();
                                                            if(isset($experience[$i]) AND $experience[$i]->responsibilities!='') $exp=explode(';', $experience[$i]->responsibilities);
                                                            
                                                            if(!empty($exp)) { $ic2=0;
                                                                foreach($exp as $e) {
                                                            ?>
                                                            <span>
                                                            <input type="text" name="job_responsibilities<?php echo $fc_exp; ?>[]" class="form-control mb-2" value="<?php echo $e; ?>" <?php if($ic2!=0) { ?> style="max-width:97%; display:inline-block;" <?php } ?> >
                                                                <?php if($ic2++!=0) { ?>
                                                            <a href="javascript:void(0)" onclick="$(this).parent().remove();"><i class="fa fa-minus-circle" style="color:red;"></i></a>
                                                                <?php } ?>
                                                            </span>
                                                            <?php } } else { ?>
                                                            <input type="text" name="job_responsibilities<?php echo $fc_exp; ?>[]" class="form-control mb-2">
                                                            <?php } ?>
                                                        </span>
                                                    </div>
                                                    <a href="javascript:void(0)" onclick="add_job_resp(this, '<?php echo $fc_exp; ?>')"><i class="fa fa-plus-circle"></i> <?php echo trans('forms.add_more'); ?> </a>
                                                </div>
                                                </div>
                                                    <?php } } ?>
                                                </div>
                                                
                                                <div class="col-md-12 text-right">
                                                    <a href="javascript:void(0)" onclick="add_exp(this, '<?php echo $fc_exp; ?>')"><i class="fa fa-plus"></i> <?php echo trans('forms.add_experience'); ?> </a>
                                                </div>
                                            </div>
                                            
                                            <div class="form-row p-4 ml-0" style="max-width:100%;">
                                                
                                                <div class="col-md-12">
                                                <h5><?php echo trans('forms.education'); ?>:</h5><hr>
                                                </div>
                                                
                                                <div class="row" id="edu_box">
                                                <div class="col-md-6">
                                                    <div class="position-relative form-group">
                                                        <label for="exampleEmail11" class=""><?php echo trans('forms.school_university'); ?></label>
                                                        <input type="text" name="school[]" class="form-control" value="<?php if(isset($education[0])) echo $education[0]->school; ?>">
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-6">
                                                    <div class="position-relative form-group">
                                                        <label for="exampleEmail11" class=""><?php echo trans('forms.qualification'); ?> </label>
                                                        <input type="text" name="qualification[]" class="form-control" value="<?php if(isset($education[0])) echo $education[0]->qualification; ?>">
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-6">
                                                    <div class="position-relative form-group">
                                                        <label for="exampleEmail11" class="" style="display:block;"><?php echo trans('forms.from'); ?> </label>
                                                        <select name="edu_from_month[]" class="form-control" style="display:inline-block; max-width:100px;">
                                                            <option value=""><?php echo trans('forms.month'); ?></option>
                                                            <option value="1" <?php if(isset($education[0]) AND $education[0]->from_month=='1') echo 'selected'; ?> >01</option>
                                                            <option value="2" <?php if(isset($education[0]) AND $education[0]->from_month=='2') echo 'selected'; ?> >02</option>
                                                            <option value="3" <?php if(isset($education[0]) AND $education[0]->from_month=='3') echo 'selected'; ?> >03</option>
                                                            <option value="4" <?php if(isset($education[0]) AND $education[0]->from_month=='4') echo 'selected'; ?> >04</option>
                                                            <option value="5" <?php if(isset($education[0]) AND $education[0]->from_month=='5') echo 'selected'; ?> >05</option>
                                                            <option value="6" <?php if(isset($education[0]) AND $education[0]->from_month=='6') echo 'selected'; ?> >06</option>
                                                            <option value="7" <?php if(isset($education[0]) AND $education[0]->from_month=='7') echo 'selected'; ?> >07</option>
                                                            <option value="8" <?php if(isset($education[0]) AND $education[0]->from_month=='8') echo 'selected'; ?> >08</option>
                                                            <option value="9" <?php if(isset($education[0]) AND $education[0]->from_month=='9') echo 'selected'; ?> >09</option>
                                                            <option value="10" <?php if(isset($education[0]) AND $education[0]->from_month=='10') echo 'selected'; ?> >10</option>
                                                            <option value="11" <?php if(isset($education[0]) AND $education[0]->from_month=='11') echo 'selected'; ?> >11</option>
                                                            <option value="12" <?php if(isset($education[0]) AND $education[0]->from_month=='12') echo 'selected'; ?> >12</option>
                                                        </select>
                                                        
                                                        <select name="edu_from_year[]" class="form-control" style="display:inline-block; max-width:100px;">
                                                            <option value=""><?php echo trans('forms.year'); ?></option>
                                                            <?php for($i=date('Y'); $i>=1980; $i--) { ?>
                                                            <option value="<?php echo $i; ?>" <?php if(isset($education[0]) AND $education[0]->from_year==$i) echo 'selected'; ?> ><?php echo $i; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                        
                                                        &nbsp;&nbsp;<b>-</b>&nbsp;&nbsp; <input type="checkbox" name="edu_to_present<?php echo $fc_edu; ?>" value="1" <?php if(isset($education[0]) AND $education[0]->present=='1') echo 'selected'; ?> > <?php echo trans('forms.present'); ?>
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-6">
                                                    <div class="position-relative form-group">
                                                        <label for="exampleEmail11" class="" style="display:block;"><?php echo trans('forms.to'); ?> </label>
                                                        <select name="edu_to_month[]" class="form-control" style="display:inline-block; max-width:100px;">
                                                            <option value=""><?php echo trans('forms.month'); ?></option>
                                                            <option value="1" <?php if(isset($education[0]) AND $education[0]->to_month=='1') echo 'selected'; ?> >01</option>
                                                            <option value="2" <?php if(isset($education[0]) AND $education[0]->to_month=='2') echo 'selected'; ?> >02</option>
                                                            <option value="3" <?php if(isset($education[0]) AND $education[0]->to_month=='3') echo 'selected'; ?> >03</option>
                                                            <option value="4" <?php if(isset($education[0]) AND $education[0]->to_month=='4') echo 'selected'; ?> >04</option>
                                                            <option value="5" <?php if(isset($education[0]) AND $education[0]->to_month=='5') echo 'selected'; ?> >05</option>
                                                            <option value="6" <?php if(isset($education[0]) AND $education[0]->to_month=='6') echo 'selected'; ?> >06</option>
                                                            <option value="7" <?php if(isset($education[0]) AND $education[0]->to_month=='7') echo 'selected'; ?> >07</option>
                                                            <option value="8" <?php if(isset($education[0]) AND $education[0]->to_month=='8') echo 'selected'; ?> >08</option>
                                                            <option value="9" <?php if(isset($education[0]) AND $education[0]->to_month=='9') echo 'selected'; ?> >09</option>
                                                            <option value="10" <?php if(isset($education[0]) AND $education[0]->to_month=='10') echo 'selected'; ?> >10</option>
                                                            <option value="11" <?php if(isset($education[0]) AND $education[0]->to_month=='11') echo 'selected'; ?> >11</option>
                                                            <option value="12" <?php if(isset($education[0]) AND $education[0]->to_month=='12') echo 'selected'; ?> >12</option>
                                                        </select>
                                                        
                                                        <select name="edu_to_year[]" class="form-control" style="display:inline-block; max-width:100px;">
                                                            <option value=""><?php echo trans('forms.year'); ?></option>
                                                            <?php for($i=date('Y'); $i>=1980; $i--) { ?>
                                                            <option value="<?php echo $i; ?>" <?php if(isset($education[0]) AND $education[0]->to_year==$i) echo 'selected'; ?> ><?php echo $i; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-12">
                                                    <div class="position-relative form-group">
                                                        <label for="exampleEmail11" class=""><?php echo trans('forms.details'); ?> </label>
                                                        <span id="edu_details_box">
                                                            <?php 
                                                            $details=array();
                                                            if(isset($education[0]) AND $education[0]->details!='') $details=explode(';', $education[0]->details);
                                                            
                                                            if(!empty($details)) { $ic2=0;
                                                                foreach($details as $detail) {
                                                            ?>
                                                            <span>
                                                            <input type="text" name="edu_details<?php echo $fc_edu; ?>[]" class="form-control mb-2" value="<?php echo $detail; ?>" <?php if($ic2!=0) { ?> style="max-width:97%; display:inline-block;" <?php } ?> >
                                                                <?php if($ic2++!=0) { ?>
                                                            <a href="javascript:void(0)" onclick="$(this).parent().remove();"><i class="fa fa-minus-circle" style="color:red;"></i></a>
                                                                <?php } ?>
                                                            </span>
                                                            <?php } } else { ?>
                                                            <input type="text" name="edu_details<?php echo $fc_edu; ?>[]" class="form-control mb-2">
                                                            <?php } ?>
                                                        </span>
                                                    </div>
                                                    <a href="javascript:void(0)" onclick="add_edu_details(this, '<?php echo $fc_edu; ?>')"><i class="fa fa-plus-circle"></i> <?php echo trans('forms.add_more'); ?> </a>
                                                </div>
                                                    
                                                    <?php 
                                                    if(count($education)>1) {
                                                        for($i=1; $i<count($education); $i++) { $fc_edu++;
                                                    ?>
                                                    <div class="form-row pt-0 pb-0 ml-0" style="padding-left:10px; padding-right:17px;">
                                                        
                                                    <div class="col-md-12"><center><hr style="border:1px dashed #dedede;"></center></div>
                                                    
                                                    <div class="col-md-12 mb-2">
                                                    <a href="javascript:void(0)" class="" onclick="$(this).parent().parent().remove();" style=""><i class="fa fa-minus-circle" style="color:red;"></i> <?php echo trans('forms.remove_education'); ?> </a>
                                                        </div>
                                                    
                                                    <div class="col-md-6">
                                                    <div class="position-relative form-group">
                                                        <label for="exampleEmail11" class=""><?php echo trans('forms.school_university'); ?></label>
                                                        <input type="text" name="school[]" class="form-control" value="<?php if(isset($education[$i])) echo $education[$i]->school; ?>">
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-6">
                                                    <div class="position-relative form-group">
                                                        <label for="exampleEmail11" class=""><?php echo trans('forms.qualification'); ?> </label>
                                                        <input type="text" name="qualification[]" class="form-control" value="<?php if(isset($education[$i])) echo $education[$i]->qualification; ?>">
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-6">
                                                    <div class="position-relative form-group">
                                                        <label for="exampleEmail11" class="" style="display:block;"><?php echo trans('forms.from'); ?> </label>
                                                        <select name="edu_from_month[]" class="form-control" style="display:inline-block; max-width:100px;">
                                                            <option value=""><?php echo trans('forms.month'); ?></option>
                                                            <option value="1" <?php if(isset($education[$i]) AND $education[$i]->from_month=='1') echo 'selected'; ?> >01</option>
                                                            <option value="2" <?php if(isset($education[$i]) AND $education[$i]->from_month=='2') echo 'selected'; ?> >02</option>
                                                            <option value="3" <?php if(isset($education[$i]) AND $education[$i]->from_month=='3') echo 'selected'; ?> >03</option>
                                                            <option value="4" <?php if(isset($education[$i]) AND $education[$i]->from_month=='4') echo 'selected'; ?> >04</option>
                                                            <option value="5" <?php if(isset($education[$i]) AND $education[$i]->from_month=='5') echo 'selected'; ?> >05</option>
                                                            <option value="6" <?php if(isset($education[$i]) AND $education[$i]->from_month=='6') echo 'selected'; ?> >06</option>
                                                            <option value="7" <?php if(isset($education[$i]) AND $education[$i]->from_month=='7') echo 'selected'; ?> >07</option>
                                                            <option value="8" <?php if(isset($education[$i]) AND $education[$i]->from_month=='8') echo 'selected'; ?> >08</option>
                                                            <option value="9" <?php if(isset($education[$i]) AND $education[$i]->from_month=='9') echo 'selected'; ?> >09</option>
                                                            <option value="10" <?php if(isset($education[$i]) AND $education[$i]->from_month=='10') echo 'selected'; ?> >10</option>
                                                            <option value="11" <?php if(isset($education[$i]) AND $education[$i]->from_month=='11') echo 'selected'; ?> >11</option>
                                                            <option value="12" <?php if(isset($education[$i]) AND $education[$i]->from_month=='12') echo 'selected'; ?> >12</option>
                                                        </select>
                                                        
                                                        <select name="edu_from_year[]" class="form-control" style="display:inline-block; max-width:100px;">
                                                            <option value=""><?php echo trans('forms.year'); ?></option>
                                                            <?php for($i2=date('Y'); $i2>=1980; $i2--) { ?>
                                                            <option value="<?php echo $i2; ?>" <?php if(isset($education[$i]) AND $education[$i]->from_year==$i2) echo 'selected'; ?> ><?php echo $i2; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                        
                                                        &nbsp;&nbsp;<b>-</b>&nbsp;&nbsp; <input type="checkbox" name="edu_to_present<?php echo $fc_edu; ?>" value="1" <?php if(isset($education[$i]) AND $education[$i]->present=='1') echo 'selected'; ?> > <?php echo trans('forms.present'); ?>
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-6">
                                                    <div class="position-relative form-group">
                                                        <label for="exampleEmail11" class="" style="display:block;"><?php echo trans('forms.to'); ?> </label>
                                                        <select name="edu_to_month[]" class="form-control" style="display:inline-block; max-width:100px;">
                                                            <option value=""><?php echo trans('forms.month'); ?></option>
                                                            <option value="1" <?php if(isset($education[$i]) AND $education[$i]->to_month=='1') echo 'selected'; ?> >01</option>
                                                            <option value="2" <?php if(isset($education[$i]) AND $education[$i]->to_month=='2') echo 'selected'; ?> >02</option>
                                                            <option value="3" <?php if(isset($education[$i]) AND $education[$i]->to_month=='3') echo 'selected'; ?> >03</option>
                                                            <option value="4" <?php if(isset($education[$i]) AND $education[$i]->to_month=='4') echo 'selected'; ?> >04</option>
                                                            <option value="5" <?php if(isset($education[$i]) AND $education[$i]->to_month=='5') echo 'selected'; ?> >05</option>
                                                            <option value="6" <?php if(isset($education[$i]) AND $education[$i]->to_month=='6') echo 'selected'; ?> >06</option>
                                                            <option value="7" <?php if(isset($education[$i]) AND $education[$i]->to_month=='7') echo 'selected'; ?> >07</option>
                                                            <option value="8" <?php if(isset($education[$i]) AND $education[$i]->to_month=='8') echo 'selected'; ?> >08</option>
                                                            <option value="9" <?php if(isset($education[$i]) AND $education[$i]->to_month=='9') echo 'selected'; ?> >09</option>
                                                            <option value="10" <?php if(isset($education[$i]) AND $education[$i]->to_month=='10') echo 'selected'; ?> >10</option>
                                                            <option value="11" <?php if(isset($education[$i]) AND $education[$i]->to_month=='11') echo 'selected'; ?> >11</option>
                                                            <option value="12" <?php if(isset($education[$i]) AND $education[$i]->to_month=='12') echo 'selected'; ?> >12</option>
                                                        </select>
                                                        
                                                        <select name="edu_to_year[]" class="form-control" style="display:inline-block; max-width:100px;">
                                                            <option value=""><?php echo trans('forms.year'); ?></option>
                                                            <?php for($i2=date('Y'); $i2>=1980; $i2--) { ?>
                                                            <option value="<?php echo $i2; ?>" <?php if(isset($education[$i]) AND $education[$i]->to_year==$i2) echo 'selected'; ?> ><?php echo $i2; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-12">
                                                    <div class="position-relative form-group">
                                                        <label for="exampleEmail11" class=""><?php echo trans('forms.details'); ?> </label>
                                                        <span id="edu_details_box">
                                                            <?php 
                                                            $details=array();
                                                            if(isset($education[$i]) AND $education[$i]->details!='') $details=explode(';', $education[$i]->details);
                                                            
                                                            if(!empty($details)) { $ic2=0;
                                                                foreach($details as $detail) {
                                                            ?>
                                                            <span>
                                                            <input type="text" name="edu_details<?php echo $fc_edu; ?>[]" class="form-control mb-2" value="<?php echo $detail; ?>" <?php if($ic2!=0) { ?> style="max-width:97%; display:inline-block;" <?php } ?> >
                                                                <?php if($ic2++!=0) { ?>
                                                            <a href="javascript:void(0)" onclick="$(this).parent().remove();"><i class="fa fa-minus-circle" style="color:red;"></i></a>
                                                                <?php } ?>
                                                            </span>
                                                            <?php } } else { ?>
                                                            <input type="text" name="edu_details<?php echo $fc_edu; ?>[]" class="form-control mb-2">
                                                            <?php } ?>
                                                        </span>
                                                    </div>
                                                    <a href="javascript:void(0)" onclick="add_edu_details(this, '<?php echo $fc_edu; ?>')"><i class="fa fa-plus-circle"></i> <?php echo trans('forms.add_more'); ?> </a>
                                                </div>
                                                    </div>
                                                    <?php } } ?>
                                                </div>
                                                
                                                <div class="col-md-12 text-right">
                                                    <a href="javascript:void(0)" onclick="add_edu(this, '<?php echo $fc_edu; ?>')"><i class="fa fa-plus"></i> <?php echo trans('forms.add_education'); ?> </a>
                                                </div>
                                            </div>
                                            
                                            <div class="form-row p-4 ml-0" style="background:#dedede; max-width:100%;">
                                                
                                                <div class="col-md-12">
                                                <h5>Kenntnisse &amp; Interessen:</h5><hr>
                                                </div>
                                                
                                                <div class="" id="lng_box" style="width:100%;">
                                                    <?php 
                                                    if(!empty($languages)) { $ic2=0;
                                                        foreach($languages as $language) {
                                                    ?>
                                                    <div class="form-row">
                                                <div class="col-md-6">
                                                    <div class="position-relative form-group">
                                                        <label for="exampleEmail11" class=""><?php echo trans('forms.language'); ?></label>
                                                        <input type="text" name="language[]" class="form-control" value="<?php echo $language->language; ?>">
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-6">
                                                    <div class="position-relative form-group">
                                                        <label for="exampleEmail11" class=""><?php echo trans('forms.fluency'); ?> </label>
                                                        <input type="text" name="lng_fluency[]" class="form-control" value="<?php echo $language->fluency; ?>" <?php if($ic2!=0) { ?> style="display:inline; max-width:94%;" <?php } ?> > <?php if($ic2++!=0) { ?> <a style="color:red;" href="javascript:void(0)" onclick="$(this).parent().parent().parent().remove();"><i class="fa fa-minus-circle"></i></a> <?php } ?>
                                                    </div>
                                                </div>
                                                    </div>
                                                    <?php } } else { ?>
                                                    <div class="form-row">
                                                    <div class="col-md-6">
                                                    <div class="position-relative form-group">
                                                        <label for="exampleEmail11" class=""><?php echo trans('forms.language'); ?></label>
                                                        <input type="text" name="language[]" class="form-control">
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-6">
                                                    <div class="position-relative form-group">
                                                        <label for="exampleEmail11" class=""><?php echo trans('forms.fluency'); ?> </label>
                                                        <input type="text" name="lng_fluency[]" class="form-control">
                                                    </div>
                                                </div>
                                                    </div>
                                                    <?php } ?>
                                                </div>
                                                
                                                <div class="col-md-12">
                                                    <a href="javascript:void(0)" onclick="add_lng(this)"><i class="fa fa-plus-circle"></i> <?php echo trans('forms.add_more'); ?> </a>
                                                </div>
                                                
                                                <div class="col-md-12"><center><hr style="border:1px dashed #dedede;"></center></div>
                                                
                                                <div class="" id="skill_box" style="width:100%;">
                                                    <?php 
                                                    if(!empty($skills)) { $ic2=0;
                                                        foreach($skills as $skill) {
                                                    ?>
                                                    <div class="form-row">
                                                <div class="col-md-6">
                                                    <div class="position-relative form-group">
                                                        <label for="exampleEmail11" class=""><?php echo trans('forms.skill'); ?></label>
                                                        <input type="text" name="skill[]" class="form-control" value="<?php echo $skill->skill; ?>">
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-6">
                                                    <div class="position-relative form-group">
                                                        <label for="exampleEmail11" class=""><?php echo trans('forms.fluency'); ?> </label>
                                                        <input type="text" name="skill_fluency[]" class="form-control" value="<?php echo $skill->fluency; ?>" <?php if($ic2!=0) { ?> style="display:inline; max-width:94%;" <?php } ?> > <?php if($ic2++!=0) { ?><a style="color:red;" href="javascript:void(0)" onclick="$(this).parent().parent().parent().remove();"><i class="fa fa-minus-circle"></i></a><?php } ?>
                                                    </div>
                                                </div>
                                                    </div>
                                                    <?php } } else { ?>
                                                    <div class="form-row">
                                                    <div class="col-md-6">
                                                    <div class="position-relative form-group">
                                                        <label for="exampleEmail11" class=""><?php echo trans('forms.skill'); ?></label>
                                                        <input type="text" name="skill[]" class="form-control">
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-6">
                                                    <div class="position-relative form-group">
                                                        <label for="exampleEmail11" class=""><?php echo trans('forms.fluency'); ?> </label>
                                                        <input type="text" name="skill_fluency[]" class="form-control">
                                                    </div>
                                                </div>
                                                    </div>
                                                    <?php } ?>
                                                </div>
                                                
                                                <div class="col-md-12">
                                                    <a href="javascript:void(0)" onclick="add_skill(this)"><i class="fa fa-plus-circle"></i> <?php echo trans('forms.add_more'); ?> </a>
                                                </div>
                                                
                                                <div class="col-md-12"><center><hr style="border:1px dashed #dedede;"></center></div>
                                                
                                                <div class="form-row" style="width:100%;">
                                                <div class="col-md-12">
                                                    <div class="position-relative form-group">
                                                        <label for="exampleEmail11" class=""><?php echo trans('forms.hobby'); ?></label>
                                                        <textarea name="hobby" class="form-control"><?php if(isset($hobby->hobby)) echo $hobby->hobby; ?></textarea>
                                                    </div>
                                                </div>
                                                </div>
                                                
                                            </div>
                                            
                                            <div class="form-row p-4 ml-0" style="max-width:100%;">
                                            <button class="mt-0 btn btn-primary" id="submit_btn"><?php echo trans('forms.save_continue'); ?></button>
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
    window.fc_exp=<?php echo $fc_exp; ?>;
    window.fc_edu=<?php echo $fc_edu; ?>;
    
    function add_job_resp(th, fc)
    {
        $(th).prev().children('#job_resp_box').append('<span><input type="text" name="job_responsibilities'+fc+'[]" class="form-control mb-2" style="max-width:97%; display:inline-block;"> <a href="javascript:void(0)" onclick="$(this).parent().remove();"><i class="fa fa-minus-circle" style="color:red;"></i></a></span>');
    }
    
    function add_edu_details(th, fc)
    {
        $(th).prev().children('#edu_details_box').append('<span><input type="text" name="edu_details'+fc+'[]" class="form-control mb-2" style="max-width:97%; display:inline-block;"> <a href="javascript:void(0)" onclick="$(this).parent().remove();"><i class="fa fa-minus-circle" style="color:red;"></i></a></span>');
    }
    
    function add_lng(th)
    {
        $("#lng_box").append('<div class="form-row"><div class="col-md-6">\
                                                    <div class="position-relative form-group">\
                                                        <label for="exampleEmail11" class=""><?php echo trans("forms.language"); ?></label>\
                                                        <input type="text" name="language[]" class="form-control">\
                                                    </div>\
                                                </div>\
                                                <div class="col-md-6">\
                                                    <div class="position-relative form-group">\
                                                        <label for="exampleEmail11" class=""><?php echo trans("forms.fluency"); ?> </label>\
                                                        <input type="text" name="lng_fluency[]" class="form-control" style="display:inline; max-width:94%;"> <a style="color:red;" href="javascript:void(0)" onclick="$(this).parent().parent().parent().remove();"><i class="fa fa-minus-circle"></i></a>\
                                                    </div>\
                                                </div></div>');
    }
    
    function add_skill(th)
    {
        $("#skill_box").append('<div class="form-row"><div class="col-md-6">\
                                                    <div class="position-relative form-group">\
                                                        <label for="exampleEmail11" class=""><?php echo trans("forms.skill"); ?></label>\
                                                        <input type="text" name="skill[]" class="form-control">\
                                                    </div>\
                                                </div>\
                                                <div class="col-md-6">\
                                                    <div class="position-relative form-group">\
                                                        <label for="exampleEmail11" class=""><?php echo trans("forms.fluency"); ?> </label>\
                                                        <input type="text" name="skill_fluency[]" class="form-control" style="display:inline; max-width:94%;"> <a style="color:red;" href="javascript:void(0)" onclick="$(this).parent().parent().parent().remove();"><i class="fa fa-minus-circle"></i></a>\
                                                    </div>\
                                                </div></div>');
    }
    
    function add_exp(th, fc)
    {
        window.fc_exp+=1;
        $("#exp_box").append('<div class="form-row pt-0 pb-0 ml-0" style="padding-left:10px; padding-right:17px;"><div class="col-md-12"><center><hr style="border:1px dashed white;"></center></div><div class="col-md-12 mb-2">\
                                                    <a href="javascript:void(0)" class="" onclick="$(this).parent().parent().remove();" style=""><i class="fa fa-minus-circle" style="color:red;"></i> <?php echo trans('forms.remove_experience'); ?> </a>\
                                                        </div>\
                                                <div class="col-md-6">\
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
                                                </div></div>');
    }
                             
    function add_edu(th, fc)
    {
        window.fc_edu+=1;
        $("#edu_box").append('<div class="form-row pt-0 pb-0 ml-0" style="padding-left:10px; padding-right:17px;"><div class="col-md-12"><center><hr style="border:1px dashed #dedede;"></center></div><div class="col-md-12 mb-2">\
                                                    <a href="javascript:void(0)" class="" onclick="$(this).parent().parent().remove();" style=""><i class="fa fa-minus-circle" style="color:red;"></i> <?php echo trans('forms.remove_education'); ?> </a>\
                                                        </div>\
                             <div class="col-md-6">\
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
                                                </div></div>');
    }
                             
                             $(document).on('click', '.browse', function(){
                            //$("#error").hide();
                    var file = $('#profile_file');
                    file.trigger('click');
                  });

		  $(document).on('change', '.file', function(e){
                      var o=new FileReader;
                      var fileType = e.target.files[0]['type'];
              
                      var validImageTypes = ['image/gif', 'image/jpeg', 'image/png', 'image/jpg', 'image/svg'];
                      if (!validImageTypes.includes(fileType)) {
                          alert('Please upload a valid file.');
                          $(".file").val('');
                      }
                      else
                      {
                          var flag=1;
                          var totalBytes = e.target.files[0].size;
                            if(totalBytes < 1000000){
                                // + 'KB'
                                var _size = Math.floor(totalBytes/1000);
                            }else{
                                // + 'MB'
                            var _size = Math.floor(totalBytes/1000000);
                                if(parseInt(_size)>5) flag=0;
                            }
                          
                          if(flag==1) {
                              var formData=new FormData();
                              var token='<?php echo csrf_token(); ?>';
                              formData.append('_token', token);
                              formData.append('file', e.target.files[0]);
        
                                $.ajax({
                                    url: "<?php echo url('upload-profile-image') ?>",
                                    type: "POST",
                                    data:  formData,
                                    beforeSend: function(){ //alert('sending');
                                        //$("#submit_btn").attr('disabled', true);
                                    },
                                    contentType: false,
                                    processData:false,
                                    success: function(data) { //alert(data);
                                        //$("#submit_btn").attr('disabled', false);
                                    //success
                                    // here we will handle errors and validation messages
                                    if ( ! data.success) {
                                    } else {
                                        // ALL GOOD! just show the success message!
                                        $("#img_file").val(data.name);
                                        $(".file").val('');
                                    }
                                    },
                                    error: function()  {
                                        //error
                                    }
                                });
                              
                        o.readAsDataURL(e.target.files[0]),o.onloadend=function(o){
                            $("#profile_image").attr("src",o.target.result);
                        } 
                          }
                          else{
                              alert('Image must be less than 5 MB.');
                              $(".file").val('');
                          }
                      }
                      //$(this).prev().text($(this).val().replace(/C:\\fakepath\\/i, ''));
                  });
</script>

<script src="<?php echo url('digital_signature/signature_pad.min.js'); ?>"></script>
<script src="<?php echo url('digital_signature/signature_pad2.min.js'); ?>"></script>
<script>
            var wrapper = document.getElementById("signature-pad");
            var clearButton = wrapper.querySelector("[data-action=clear]");
            var changeColorButton = wrapper.querySelector("[data-action=change-color]");
            var savePNGButton = wrapper.querySelector("[data-action=save-png]");
            var saveJPGButton = wrapper.querySelector("[data-action=save-jpg]");
            var saveSVGButton = wrapper.querySelector("[data-action=save-svg]");
            var canvas = wrapper.querySelector("canvas");
            var signaturePad = new SignaturePad(canvas, {
                backgroundColor: 'rgb(255, 255, 255)'
            });
            // Adjust canvas coordinate space taking into account pixel ratio,
            // to make it look crisp on mobile devices.
            // This also causes canvas to be cleared.
            function resizeCanvas() {
                // When zoomed out to less than 100%, for some very strange reason,
                // some browsers report devicePixelRatio as less than 1
                // and only part of the canvas is cleared then.
                var ratio =  Math.max(window.devicePixelRatio || 1, 1);
                // This part causes the canvas to be cleared
                canvas.width = canvas.offsetWidth * ratio;
                canvas.height = canvas.offsetHeight * ratio;
                canvas.getContext("2d").scale(ratio, ratio);
                // This library does not listen for canvas changes, so after the canvas is automatically
                // cleared by the browser, SignaturePad#isEmpty might still return false, even though the
                // canvas looks empty, because the internal data of this library wasn't cleared. To make sure
                // that the state of this library is consistent with visual state of the canvas, you
                // have to clear it manually.
                signaturePad.clear();
            }
            // On mobile devices it might make more sense to listen to orientation change,
            // rather than window resize events.
            window.onresize = resizeCanvas;
            resizeCanvas();
            function download(dataURL, filename) {
                var blob = dataURLToBlob(dataURL);
                var url = window.URL.createObjectURL(blob);
                var a = document.createElement("a");
                a.style = "display: none";
                a.href = url;
                a.download = filename;
                document.body.appendChild(a);
                a.click();
                window.URL.revokeObjectURL(url);
            }
            // One could simply use Canvas#toBlob method instead, but it's just to show
            // that it can be done using result of SignaturePad#toDataURL.
            function dataURLToBlob(dataURL) {
                var parts = dataURL.split(';base64,');
                var contentType = parts[0].split(":")[1];
                var raw = window.atob(parts[1]);
                var rawLength = raw.length;
                var uInt8Array = new Uint8Array(rawLength);
                for (var i = 0; i < rawLength; ++i) {
                    uInt8Array[i] = raw.charCodeAt(i);
                }
                return new Blob([uInt8Array], { type: contentType });
            }
            clearButton.addEventListener("click", function (event) {
                signaturePad.clear();
            });
    
    window.success=0;
    
    $("#cv_form").submit(function(e){
        var frm=$(this);
        
        if(window.success==0) {
        e.preventDefault();
        
        if (!signaturePad.isEmpty()) {
            var dataURL = signaturePad.toDataURL();
            
            var formData=new FormData(this);
            var token='<?php echo csrf_token(); ?>';
            formData.append('_token', token);
            formData.append('image', dataURL);
        
        $.ajax({
                url: "<?php echo url('save-signature-cv') ?>",
                type: "POST",
                data:  formData,
                beforeSend: function(){ //alert('sending');
                    $("#submit_btn").attr('disabled', true);
                },
                contentType: false,
                processData:false,
                success: function(data) { //alert(data.success);
                    //success
                    //$("#submit_btn").attr('disabled', false);
                    // here we will handle errors and validation messages
                    if ( ! data.success) {
                        window.success=1;
                        $(frm).submit();
                    } else {
                        // ALL GOOD! just show the success message!
                        //alert("Saved");
                        $("#signature").val(data.signature);
                        window.success=1;
                        $(frm).submit();
                    }
                },
                error: function()  {
                    //error
                } 	        
        });
        }
        else {
            window.success=1;
            $(frm).submit(); 
        }
        }
    });
    
    function makeid(length) {
   var result           = '';
   var characters       = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
   var charactersLength = characters.length;
   for ( var i = 0; i < length; i++ ) {
      result += characters.charAt(Math.floor(Math.random() * charactersLength));
   }
   return result;
}
        </script>