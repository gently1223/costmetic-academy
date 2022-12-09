<?php include(app_path().'/common/panel/header.php'); ?>
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
                                        <div class="card mb-3">
                                            <?php if(Session::has('error')) { ?>
                                            <p class="alert alert-danger"><?php echo Session::get('error'); ?></p>
                                            <?php } ?>
                                            <?php if(Session::has('success')) { ?>
                                            <p class="alert alert-success"><?php echo Session::get('success'); ?></p>
                                            <?php } ?>
                                                <div id="form-box">
                                                    <div class="main-card mb-2">
                                    <div class="card-body"><h5 class="card-title"><?php echo trans('forms.edit_user'); ?></h5>
                                        <form class="" action="" method="post">
                                            <?php echo csrf_field(); ?>
                                            <div class="form-row">
                                                <div class="col-md-6">
                                                    <div class="position-relative form-group">
                                                        <label for="exampleEmail11" class=""><?php echo trans('forms.username'); ?> <font style="color:red;">*</font></label>
                                                        <input name="username" id="exampleEmail11" type="text" class="form-control" required value="<?php echo $user->username; ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="position-relative form-group">
                                                        <label for="examplePassword11" class=""><?php echo trans('forms.password'); ?> <font style="color:red;">*</font></label>
                                                        <input name="pass" id="examplePassword11" type="password" class="form-control" required value="<?php echo $user->pass; ?>"></div>
                                                </div>
                                            </div>
                                            
                                            
                                            <div class="form-row">
                                                <div class="col-md-6">
                                                    <div class="position-relative form-group">
                                                        <label for="exampleEmail11" class=""><?php echo trans('forms.name'); ?> <font style="color:red;">*</font></label>
                                                        <input name="name" id="exampleEmail11" type="text" class="form-control" required value="<?php echo $user->name; ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="position-relative form-group">
                                                        <label for="examplePassword11" class=""><?php echo trans('forms.email'); ?> <font style="color:red;">*</font></label>
                                                        <input name="email" id="examplePassword11" type="email" class="form-control" required value="<?php echo $user->email; ?>"></div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="position-relative form-group">
                                                        <label for="exampleZip" class=""><?php echo trans('forms.type'); ?> <font style="color:red;">*</font></label>
                                                        <select name="type" id="exampleZip" class="form-control">
                                                        <option value="3"  <?php if($user->type=='3') echo 'selected'; ?>><?php echo trans('forms.manager'); ?></option>
                                                        <option value="2"  <?php if($user->type=='2') echo 'selected'; ?>><?php echo trans('forms.admin'); ?></option>
                                                        </select>
                                                    </div>
                                                </div>
                                                 <div class="col-12 col-md-12">
                                                    <div class="position-relative form-group">
                                                        <label for="exampleEmail11" class=""><?php echo trans('forms.signature'); ?></label>
                                                        <input type="hidden" name="signature" id="signature" value="<?php if(isset($user->signature)) echo $user->signature; ?>">
                                                        
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
                                             <input type="hidden" id="hiddensignature" name="mysignaturee" value="">  
                                            <button class="mt-2 btn btn-primary" id="signaturebutton"><?php echo trans('forms.update'); ?></button>
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

                <script src="<?php echo url('digital_signature/signature_pad.min.js'); ?>"></script>
<script src="<?php echo url('digital_signature/signature_pad2.min.js'); ?>"></script>
<script>
            var mybutton=document.getElementById("signaturebutton");
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
              mybutton.addEventListener("click", function (event) {
               if (!signaturePad.isEmpty()) {
            var dataURL = signaturePad.toDataURL();
            $("#hiddensignature").val(dataURL);
        }
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