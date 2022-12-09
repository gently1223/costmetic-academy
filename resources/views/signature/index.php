<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Signature Pad demo</title>
        <style>
            .jay-signature-pad {
                position: relative;
                display: -ms-flexbox;
                -ms-flex-direction: column;
                width: 100%;
                height: 100%;
                max-width: 500px;
                max-height: 315px;
                border: 1px solid #e8e8e8;
                background-color: #fff;
                box-shadow: 0 3px 20px rgba(0, 0, 0, 0.27), 0 0 40px rgba(0, 0, 0, 0.08) inset;
                border-radius: 15px;
                padding: 20px;
            }
            .txt-center {
                text-align: -webkit-center;
            }
        </style>
    </head>
    <body>
        <h2>Signature Pad Demo</h2>
        <div id="signature-pad" class="jay-signature-pad">
            <div class="jay-signature-pad--body">
                <canvas id="jay-signature-pad" width=400 height=250></canvas>
            </div>
            <div class="signature-pad--footer txt-center">
                <div class="description"><strong> SIGN ABOVE </strong></div>
                <div class="signature-pad--actions txt-center">
                    <div>
                        <button type="button" class="button clear" data-action="clear">Clear</button>
                        <button type="button" class="button" data-action="change-color">Change color</button>
                    </div><br/>
                    <div>
                        <button type="button" class="button save" data-action="save-png">Save as PNG</button>
                        <button type="button" class="button save" data-action="save-jpg">Save as JPG</button>
                        <button type="button" class="button save" data-action="save-svg">Save as SVG</button>
                    </div>
                </div>
            </div>
        </div>
        <script src="<?php echo url('digital_signature/signature_pad.min.js'); ?>"></script>
        <script src="<?php echo url('digital_signature/signature_pad2.min.js'); ?>"></script>
        
        <!--<script src="https://cdn.jsdelivr.net/npm/signature_pad@2.3.2/dist/signature_pad.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/signature_pad/1.5.3/signature_pad.min.js"></script>-->
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
            changeColorButton.addEventListener("click", function (event) {
                var r = Math.round(Math.random() * 255);
                var g = Math.round(Math.random() * 255);
                var b = Math.round(Math.random() * 255);
                var color = "rgb(" + r + "," + g + "," + b +")";
                signaturePad.penColor = color;
            });
            savePNGButton.addEventListener("click", function (event) {
                if (signaturePad.isEmpty()) {
                alert("Please provide a signature first.");
                } else {
                var dataURL = signaturePad.toDataURL();
                download(dataURL, "signature.png");
                }
            });
            saveJPGButton.addEventListener("click", function (event) {
                if (signaturePad.isEmpty()) {
                alert("Please provide a signature first.");
                } else {
                var dataURL = signaturePad.toDataURL("image/jpeg");
                download(dataURL, "signature.jpg");
                }
            });
            saveSVGButton.addEventListener("click", function (event) {
                if (signaturePad.isEmpty()) {
                alert("Please provide a signature first.");
                } else {
                var dataURL = signaturePad.toDataURL('image/svg+xml');
                download(dataURL, "signature.svg");
                }
            });
        </script>
    </body>
</html>
