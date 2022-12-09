<?php

$student_signature_check = 0;
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Language" content="en">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Login | <?php echo env('APP_NAME'); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no"
    />
    <meta name="description" content="Kero HTML Bootstrap 4 Dashboard Template">

    <!-- Disable tap highlight on IE -->
    <meta name="msapplication-tap-highlight" content="no">

    <link href="<?php echo url('main.07a59de7b920cd76b874.css'); ?>" rel="stylesheet"></head>
    <body>
    <div class="app-container app-theme-white body-tabs-shadow">
            <div class="app-container">
                <div class="Xh-100 bg-animation" style="background: #d2d6de;">
                    <div class="d-flex Xh-100 justify-content-center align-items-center">
                        <div class="mx-auto app-login-box col-md-8" style="background: white;">
                            <center><img src="<?php echo url('images/logo.png'); ?>" style="width:300px; height:66px;"></center>
 
                                    <!----------------------------------------------------------------------------->

<form onsubmit="validateForm()"  action="{{route('tagesdokuStudentStore')}}" method="post" >
    @csrf
    <input type="hidden" name="id" value="{{$attendance->id}}">
    <input type="hidden" name="sign2"  id="sign2">

                                    <hr/>
<center>
    <h2>@lang('forms.tagasdoku_pdf_heading')</h2>
</center>
<br/>
<div style="border:1px solid black;padding:10px;">
    <p><b>@lang('forms.date')</b> : {{date('d.m.Y',strtotime($appointment->date))}}</p>
    <p><b>@lang('forms.coach')</b> : {{$coach->name}}</p>
    <p><b>@lang('forms.coachee')</b> : {{$coachee->name}}</p>
    <p><b>@lang('forms.appointment_ue')</b> : {{$appointment->ue}}</p>
    <p><b>@lang('forms.module')</b> : {{$module->title}}</p>
    <p><b>@lang('forms.module_items')</b> : @if(isset($module_item->title)){{$module_item->title}}@endif</p>
    @if(isset($attendance->mis_ids) && strlen($attendance->mis_ids) > 0)
    <p><b>@lang('forms.appointment_mis')</b> : <br/><?php  $mis_ids = explode(';',$attendance->mis_ids); ?>
             @foreach($module_item_services as $key => $mis)
             @if(in_array($mis->id, $mis_ids))
             {{$mis->title}}<br/>
             @endif
             @endforeach
             </p>
      @endif
     @if(isset($appointment->teaching_method) && strlen($appointment->teaching_method) > 0)
     <p><b>@lang('forms.teaching_method')</b> : <br/><?php  $tea_mets = explode(',',$appointment->teaching_method); ?>
             @foreach($tea_mets as $tm)
             {{$tm}}<br/>
             @endforeach
             </p>
     @endif
   </div><br/>
   
   @if($appointment->item_id == env('MI_WEG_ZIEL_PLANUNG', 2798))
   	<div style="border:1px solid black;padding:10px;"><h5>Weg Ziel Planung block will be displayed here</h5></div>
	@endif
	
	@if($appointment->item_id == env('MI_PROFESSIONALE_BEWERBUNGSUNTERLAGEN', 2801))
    	<div style="border:1px solid black;padding:10px;"><h5>Professionale Bewerbungsunterlagen block will be displayed here</h5></div>
	@endif
	
	@if($appointment->item_id == env('MI_DURCHHALTEVERMOEGEN_BELASTBARKEIT', 2793))
   <div style="border:1px solid black;padding:10px;"><h5>Zusätzliche Herausforderungen erschwerten bisher die berufliche Laufbahn/Perspective:</h5>
   
   @if(str_contains($attendance_additional->durch_belast_options, 'durch_belast_options_gesund')) 
       <div class="checkbox">
          <label><input name="durch_belast_options_gesund" type="checkbox" checked value="durch_belast_options_gesund" disabled> gesundheitlich</label>
        </div>
     @endif 
     @if(str_contains($attendance_additional->durch_belast_options, 'durch_belast_options_familie')) 
    <div class="checkbox">
      <label><input name="durch_belast_options_familie" type="checkbox" disabled checked value="durch_belast_options_familie"> familiäre</label>
    </div>
     @endif 
    @if(str_contains($attendance_additional->durch_belast_options, 'durch_belast_options_partner')) 
    <div class="checkbox">
      <label><input name="durch_belast_options_partner" type="checkbox" disabled checked value="durch_belast_options_partner"> partnerschaftliche</label>
    </div>
     @endif 
    @if(str_contains($attendance_additional->durch_belast_options, 'durch_belast_options_kinder')) 
    <div class="checkbox">
      <label><input name="durch_belast_options_kinder" type="checkbox" disabled checked value="durch_belast_options_kinder"> Kinderbetreuung</label>
    </div>
     @endif 
    @if(str_contains($attendance_additional->durch_belast_options, 'durch_belast_options_financial')) 
    <div class="checkbox">
      <label><input name="durch_belast_options_financial" type="checkbox" disabled checked value="durch_belast_options_financial"> finanzielle</label>
    </div>
     @endif 
    @if(str_contains($attendance_additional->durch_belast_options, 'durch_belast_options_recht')) 
    <div class="checkbox">
      <label><input name="durch_belast_options_recht" type="checkbox" disabled checked value="durch_belast_options_recht"> rechtliche</label>
    </div>
     @endif 
    @if(str_contains($attendance_additional->durch_belast_options, 'durch_belast_options_sprach')) 
    <div class="checkbox">
      <label><input name="durch_belast_options_sprach" type="checkbox" disabled checked value="durch_belast_options_sprach"> sprachliche/kulturelle</label>
    </div>
     @endif 
    @if(str_contains($attendance_additional->durch_belast_options, 'durch_belast_options_pflege')) 
    <div class="checkbox">
      <label><input name="durch_belast_options_gesund" type="checkbox" disabled checked value="durch_belast_options_pflege"> Pflege von Angehörigen</label>
    </div>
     @endif 
     @if(isset($attendance_additional->durch_belast_options_other)) 
    <div class="checkbox">
      <label><input name="durch_belast_options_other" type="checkbox" disabled checked value="durch_belast_options_other"> Sonstiges:</label><br/>
      <p style="margin-left:30px;"><?php echo nl2br($attendance_additional->durch_belast_options_other);?><br/></p>
    </div>
     @endif 
   </div>
	@endif
	
	@if($appointment->item_id == env('MI_SELBST_UND_FREMDWAHRNEHMUNG_TEIL_1', 2792))
	
    	<div style="border:1px solid black;padding:10px;">
        	<h5>Berufliche Kompetenzen / neu entdeckte Potentiale / neu entdeckte berufliche Perspektiven:</h5>
        	<h6><u>Resourceanalyse / neue berufliche Potentiale:</u></h6>
        	@if(isset($attendance_additional->selbst_fremd_strengths))
            	<br/><b>Stärken:</b><br/>
           		<?php echo nl2br($attendance_additional->selbst_fremd_strengths);?><br/>
       		@endif
       		@if(isset($attendance_additional->selbst_fremd_weakness))
            	<br/><b>Schwächen:</b><br/>
           		<?php echo nl2br($attendance_additional->selbst_fremd_weakness);?><br/>
       		@endif
       		@if(isset($attendance_additional->selbst_fremd_potential))
            	<br/><b>Neu entdeckte Potentiale:</b><br/>
           		<?php echo nl2br($attendance_additional->selbst_fremd_potential);?><br/>
       		@endif
       		@if(isset($attendance_additional->selbst_fremd_energykiller))
            	<br/><b>Energiekiller:</b><br/>
           		<?php echo nl2br($attendance_additional->selbst_fremd_energykiller);?><br/>
       		@endif
       		@if(isset($attendance_additional->selbst_fremd_energygiver))
            	<br/><b>Energiegeber:</b><br/>
           		<?php echo nl2br($attendance_additional->selbst_fremd_energygiver);?><br/>
       		@endif
       		@if(isset($attendance_additional->selbst_fremd_ziel_planung) || isset($attendance_additional->selbst_fremd_beruf_persp))
       			<hr/>
           		@if(isset($attendance_additional->selbst_fremd_ziel_planung))
                	<br/><b>Neue berufliche Zielstellung & Weg-Ziel Planung:</b><br/>
               		<?php echo nl2br($attendance_additional->selbst_fremd_ziel_planung);?><br/>
           		@endif
           		@if(isset($attendance_additional->selbst_fremd_beruf_persp))
                	<br/><b>Neue entdekte berufliche Perspektiven:</b><br/>
               		<?php echo nl2br($attendance_additional->selbst_fremd_beruf_persp);?><br/>
           		@endif
       		@endif
   		</div>
	@endif
	
	@if($appointment->item_id == env('MI_MOEGLICHKEITEN_VISIONEN', 2794))
   <div style="border:1px solid black;padding:10px;"><h5>Kompetenzanalyse</h5>
       @if(isset($attendance_additional->moeglich_vision_competence))
        	<b>Welche Abschlüsse und Qualifikationen bringt der Coachee mit:</b><br/>
        	<?php echo nl2br($attendance_additional->moeglich_vision_competence);?><br/>
        @endif
        @if(isset($attendance_additional->moeglich_vision_experience))
        	<br/><b>Berufserfahrungen:</b><br/>
        	<?php echo nl2br($attendance_additional->moeglich_vision_experience);?><br/>
    	@endif
   </div>
	@endif
   
   
   
     @if(isset($next_appointment->date))
     <br/><div style="border:1px solid black;padding:10px;">
     <b>@lang('forms.next_appointment')</b><br/>
     <p><b>Datum & Uhrzeit</b> : {{date('d.m.Y',strtotime($next_appointment->date))}} {{$next_appointment->time}} - {{$next_appointment->time_end}}</p>
     <p><b>Modul & Modulitem</b> : {{$next_appointment->title}}</p>
     </div>
     @endif

<br/>
<br/>
<div style="border:1px solid black;padding:10px;">
    <table style="width:100%">
    <tr>
        <td align="center" >
            @lang('forms.coachee_signature')<br/>


            @if(!empty($attendance->student_signature))
            @php $student_signature_check++; @endphp
           <img src="{{asset('signatures')}}/{{$attendance->student_signature}}">
            @endif

            @if($student_signature_check==0)
            <canvas id="signature2"  style="border: 1px dashed black;"></canvas>
            <br/>
            <button type="button" class="btn btn-info"  onclick="clearSignature('signature2')" >@lang('forms.clear')</button>
            @endif


        
        </td>
    </tr>
</table>
</div>
 @if($student_signature_check==0)
<div class="text-center">
    <button class="btn btn-primary" >@lang('forms.submit')</button>
</div>
@endif



</form>


     <!----------------------------------------------------------------------------->























                            <div class="text-center text-white opacity-8 mt-3">Copyright © <?php echo env('APP_NAME'); echo ' '.date('Y'); ?></div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo url('assets/scripts/main.07a59de7b920cd76b874.js'); ?>"></script></body>
<script src="<?php echo url('digital_signature/signature_pad.min.js'); ?>"></script>
<script src="<?php echo url('digital_signature/signature_pad2.min.js'); ?>"></script>


<script type="text/javascript">
     /*----------------------------*/

    var signaturePad2;
    var student_signature_check = parseInt({{$student_signature_check}});

    /*----------------------------*/

    function makeSignature(){

        if (student_signature_check==0) {

            var canvas2 = document.getElementById("signature2");
            signaturePad2 = new SignaturePad(canvas2, {
                backgroundColor: 'rgb(255, 255, 255)'
            });
        }
    }

    /*----------------------------*/
    function clearSignature(idx){
        
        if (idx=="signature2") {
            signaturePad2.clear();
        }
    }

    /*----------------------------*/

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
     /*----------------------------*/


      makeSignature();
      $('.select-multiple').select2();

      /*----------------------------*/


      async function validateForm(){
        
       
        var sign2 = '';

        if (student_signature_check==0){
            sign2 = signaturePad2.toDataURL();
            if (signaturePad2.isEmpty()){
                sign2 = "";
             }
        }
         
        if (sign2==""){
            event.preventDefault();
            alert("please sign");
        }

        $('#sign2').val(sign2);  
                        
      }

</script>


</html>
