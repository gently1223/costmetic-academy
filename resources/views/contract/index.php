<?php $close_sidebar=1;
include(app_path().'/common/header.php');
?>
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
                            <div class="app-inner-layout__content">
                                <div class="tab-content">
                                    <div class="container-fluid">
                                        
                                        <div class="row">
                                            <div class="col-12 col-md-8">
                                                <div id="pdfRenderer" style="min-height:100vh; margin-bottom:30px;"></div>
                                            </div>
                                            
                                            <div class="col-12 col-md-4">
                                                <div id="signature-pad" class="jay-signature-pad">
            <div class="jay-signature-pad--body">
                <center><canvas id="jay-signature-pad"></canvas></center>
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
                                                
                                                <form action="" method="post" id="signature-form">
                                                    <input type="hidden" name="coach" value="<?php if($user->type=='Coach') echo $user->id; else echo $coach; ?>" id="coach">
                                                    <p class="alert alert-danger mt-3 mb-0" id="error" style="display:none;"></p>
                                                <button class="btn btn-success mt-3" style="width:100%;" id="submit_btn"><?php echo trans('forms.submit_document'); ?></button>
                                                </form>
                                            </div>
                                        </div>
                                        
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

<?php include(app_path().'/common/footer.php'); ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfobject/2.1.1/pdfobject.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfobject/2.1.1/pdfobject.min.js"></script>
<script>
    $(document).ready(function(){
        var options = {
            height: "100vh",
            pdfOpenParams: { view: 'FitH', page: '1' }
        };
        
        PDFObject.embed("<?php echo url('company_files/contracts/'.$contract->contract) ?>", "#pdfRenderer", options);
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
    
    $("#signature-form").submit(function(e){
        e.preventDefault();
        $("#error").hide();
        
        if (signaturePad.isEmpty()) {
            $("#error").text('Please provide a signature first.');
            $("#error").show();
        } else {
            var dataURL = signaturePad.toDataURL();
            
            var id='<?php echo $contract->id; ?>'
            var formData=new FormData(this);
            var token='<?php echo csrf_token(); ?>';
            formData.append('_token', token);
            formData.append('id', id);
            formData.append('image', dataURL);
        
        $.ajax({
                url: "<?php echo url('save-signature') ?>",
                type: "POST",
                data:  formData,
                beforeSend: function(){ //alert('sending');
                    $("#submit_btn").attr('disabled', true);
                },
                contentType: false,
                processData:false,
                success: function(data) { //alert(data);
                    //success
                    $("#submit_btn").attr('disabled', false);
                    // here we will handle errors and validation messages
                    if ( ! data.success) {
                    } else {
                        // ALL GOOD! just show the success message!
                        //alert("Saved");
                        window.location='<?php echo url('my-contracts?s=1'); ?>';
                    }
                },
                error: function()  {
                    //error
                } 	        
        });
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