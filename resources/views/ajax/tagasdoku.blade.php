 <?php
        $teacher_signature_check = 0;
        $student_signature_check = 0;
 ?>
 <form  onsubmit="ajaxSaveTagesdoku()" id="tagesdoku_form" >
    <input type="hidden" name="appointment_id" value="{{$appointment->id}}">
    <input type="hidden" name="submit_type" id="submit_type" value="unknown">
    @csrf

    <div class="row">
        <div class="form-group col-md-4">
                <label>@lang('forms.date')</label>
                <input type="text" name="tagesdoku_date" id="tagesdoku_date" class="form-control"  value="{{$appointment->date}}" readonly>
        </div>
        <div class="form-group col-md-4">
                <label>@lang('forms.coach')</label>
                <input type="text" name="tagesdoku_coach" id="tagesdoku_coach" class="form-control" readonly  value="<?php echo $user->name; ?>">
        </div>
        <div class="form-group col-md-4">
                <label>@lang('forms.coachee')</label>
                <input type="text" name="tagesdoku_coachee" id="tagesdoku_coachee" class="form-control" value="<?php foreach($students as $stud) { echo $stud['student']->name . ' '; }?>" readonly>
        </div>

        

        <div class="form-group col-md-4">
                <label>@lang('forms.appointment_ue')</label>
                <input type="text" name="tagesdoku_ue" id="tagesdoku_ue" class="form-control" value="{{$appointment->ue}}" readonly>
        </div>

        <div class="form-group col-md-4">
                <label>@lang('forms.module')</label>
                <input type="text" name="tagesdoku_module" id="tagesdoku_module" class="form-control" value="{{$module->title}}" readonly>
        </div>

        <div class="form-group col-md-4">
                <label>@lang('forms.module_items')</label>
                <input type="text" name="tagesdoku_module_item" id="tagesdoku_module_item" class="form-control"  value="@if(isset($module_item->title)){{$module_item->title}}@endif"  readonly>
        </div>

        <div class="col-md-4">
            <label>@lang('forms.appointment_mis')</label>
            <div id="mis_content">
                @foreach($module_item_services as $key => $mis)
                <div class="checkbox">
                  <label><input @if(isset($attendance->mis_ids) && stripos($attendance->mis_ids, strval($mis->id))>-1) checked @endif name="tagesdoku_mis[]" type="checkbox" value="{{$mis->id}}"> {{$mis->title}}</label>
                </div>
                @endforeach
                <div class="checkbox">
                  <label><input name="x" onclick="$('#tagesdoku_mis_other').toggle()" type="checkbox" > Other</label>
                </div>
                <div id="tagesdoku_mis_other" style="display:none;">
                	<textarea rows=4 cols=5  class="form-control"  name="tagesdoku_mis_other"></textarea>
                </div>
            </div>
            
        </div>


        


        <div class="form-group col-md-4">
            <label for="tagesdoku_teaching_method" class="">@lang('forms.teaching_method') <font style="color:red;">*</font></label>
                <select name="tagesdoku_teaching_method[]" class="form-control select-multiple"  id="tagesdoku_teaching_method" multiple="" style="width:100%;">
                    @foreach($teaching_method_all as $t)
                    <option  class="tagesdoku_teaching_method_option" value="{{$t->name}}" @if(isset($appointment->teaching_method) && stripos($appointment->teaching_method,$t->name)>-1) selected @endif >{{$t->name}}</option>
                    @endforeach
                </select>

        </div>
        
        <div class="col-12 col-md-12"><hr/>
        <p style="text-align: center"><b>Achtung:</b> Wenn ein Tagesdoku mit ähnliches Termin gibt, wird es automatisch übertragen.</p>
        <hr/>
        </div>
        
		<?php if($appointment->item_id == env('MI_WEG_ZIEL_PLANUNG', 2798)) { ?>

        <div class="col-12 col-md-12"><h3>Folgende arbeitmarktnahe Job-Perspektiven wurden erarbeitet:</h3></div>
        <div class="col-12 col-md-12">
            <div id="textbox-wrapper">
                <div class="col-12 col-md-12">
                    <label for="plan_a">Plan A</label>
                    <textarea rows=4 cols=10  class="form-control"  name="plan_a">@if(isset($attendance_additional->weg_ziel_planung_plan_a)){{$attendance_additional->weg_ziel_planung_plan_a}}@endif</textarea>
                </div>
                <div class="col-12 col-md-12">
                    <label for="plan_b">Plan B</label>
                    <textarea rows=4 cols=5  class="form-control"  name="plan_b">@if(isset($attendance_additional->weg_ziel_planung_plan_b)){{$attendance_additional->weg_ziel_planung_plan_b}}@endif</textarea>
                </div>
                <div class="col-12 col-md-12">
                    <label for="plan_c">Plan C</label>
                    <textarea rows=4 cols=5  class="form-control"  name="plan_c">@if(isset($attendance_additional->weg_ziel_planung_plan_c)){{$attendance_additional->weg_ziel_planung_plan_c}}@endif</textarea>
                </div>
                @if(isset($attendance_additional->weg_ziel_planung_plan_d)||isset($attendance_additional->weg_ziel_planning_plan_e))
                <div class="col-12 col-md-12">
                    <label for="plan_b">Plan D</label>
                    <textarea rows=4 cols=5  class="form-control"  name="plan_d">@if(isset($attendance_additional->weg_ziel_planung_plan_d)){{$attendance_additional->weg_ziel_planung_plan_d}}@endif</textarea>
                </div>
                <div class="col-12 col-md-12">
                    <label for="plan_c">Plan E</label>
                    <textarea rows=4 cols=5  class="form-control"  name="plan_e">@if(isset($attendance_additional->weg_ziel_planung_plan_e)){{$attendance_additional->weg_ziel_planung_plan_e}}@endif</textarea>
                </div>
                @endif
            </div>
        </div>
        
        @if(!isset($attendance_additional->weg_ziel_planung_plan_d)||!isset($attendance_additional->weg_ziel_planning_plan_e))
               
        <div class="col-12 col-md-12" style="margin: 15px">
            <button class="btn btn-info" id="plus" onclick="appendTextbox(event); return false;"><i class="fa fa-plus"></i></button>
        </div>
        @endif
		<?php } ?>
		
		<?php if($appointment->item_id == env('MI_PROFESSIONALE_BEWERBUNGSUNTERLAGEN', 2801)) { ?>
        <div class="col-12 col-md-12"><h3>Folgende Plattformen wurden genutzt (ankreuzen):</h3>
        @if(isset($attendance_additional->prof_bewerbung_platforms_used))
            <div class="checkbox">
              <label><input name="jobborse_fur_stellensuche" type="checkbox" @if(
                str_contains($attendance_additional->prof_bewerbung_platforms_used,  'jobborse_fur_stellensuche')) checked @endif value="jobborse_fur_stellensuche"> Jobbörse für Stellensuche </label>
            </div>
            <div class="checkbox">
              <label><input name="kursnet_fur_weiterbildungen_und_umschulungen" type="checkbox" @if(
                str_contains($attendance_additional->prof_bewerbung_platforms_used,  'kursnet_fur_weiterbildungen_und_umschulungen')) checked @endif value="kursnet_fur_weiterbildungen_und_umschulungen"> Kursnet für Weiterbildungen und Umschulungen </label>
            </div>
            <div class="checkbox">
              <label><input name="berufsnet_fur_ausfuhrliche_berufsinformationen" type="checkbox" @if(
                str_contains($attendance_additional->prof_bewerbung_platforms_used,  'berufsnet_fur_ausfuhrliche_berufsinformationen')) checked @endif value="berufsnet_fur_ausfuhrliche_berufsinformationen"> Berufenet für ausführliche Berufsinformationen </label>
            </div>
            @else
            <div class="checkbox">
                <label><input name="jobborse_fur_stellensuche" type="checkbox"> Jobbörse für Stellensuche </label>
            </div>
            <div class="checkbox">
                <label><input name="kursnet_fur_weiterbildungen_und_umschulungen" type="checkbox"> Kursnet für Weiterbildungen und Umschulungen </label>
            </div>
            <div class="checkbox">
                <label><input name="berufsnet_fur_ausfuhrliche_berufsinformationen" type="checkbox"> Berufenet für ausführliche Berufsinformationen </label>
            </div>
        @endif

        @if(isset($attendance_additional->prof_bewerbung_platforms_used_other))
            <div class="checkbox">
              <label><input name="x" onclick="$('#prof_bewerbung_platforms_used_other').toggle()" type="checkbox" checked > Sonstiges:</label>
            </div>
            <div id="prof_bewerbung_platforms_used_other">
                <textarea rows=4 cols=5  class="form-control"  name="prof_bewerbung_platforms_used_other">{{preg_replace("/<br.*>/U", PHP_EOL, $attendance_additional->prof_bewerbung_platforms_used_other)}}</textarea>
            </div>
            @else
            <div class="checkbox">
              <label><input name="x" onclick="$('#prof_bewerbung_platforms_used_other').toggle()" type="checkbox" > Sonstiges:</label>
            </div>
            <div id="prof_bewerbung_platforms_used_other" style="display:none;">
                <textarea rows=4 cols=5  class="form-control"  name="prof_bewerbung_platforms_used_other"></textarea>
            </div>
        @endif
</div>

        <div class="col-12 col-md-12"><br/><h3>Professionelle Bewerbunasmappe:</h3>
            <div class="checkbox">
              <label><input name="professionelles_anschreiben_erarbeitet" type="checkbox" @if(isset($attendance_additional->prof_bewerbung_mappe) && 
                str_contains($attendance_additional->prof_bewerbung_mappe,  'professionelles_anschreiben_erarbeitet')) checked @endif value="professionelles_anschreiben_erarbeitet"> Professionelles Anschreiben erarbeitet </label>
            </div>
            <div class="checkbox">
              <label><input name="professionellen_lebenslauf_erarbeitet" type="checkbox" @if( isset($attendance_additional->prof_bewerbung_mappe) && 
                str_contains($attendance_additional->prof_bewerbung_mappe,  'professionellen_lebenslauf_erarbeitet')) checked @endif value="professionellen_lebenslauf_erarbeitet"> Professionellen Lebenslauf erarbeitet </label>
            </div>
            <div class="checkbox">
              <label><input name="zertifikate_wurden_fur_die_mappe_zusammengestellt" type="checkbox" @if( isset($attendance_additional->prof_bewerbung_mappe) && 
                str_contains($attendance_additional->prof_bewerbung_mappe,  'zertifikate_wurden_fur_die_mappe_zusammengestellt')) checked @endif value="zertifikate_wurden_fur_die_mappe_zusammengestellt"> Zertifikate Wurden für die Mappe Zusammengestellt </label>
            </div>
        </div>
 
		<?php } ?>
		
		
<?php if($appointment->item_id == env('MI_PROFESSIONALE_BEWERBUNGSUNTERLAGEN', 2801)) { ?>
        <!-- --------------- CV Upload ---------------- -->
        <div class="col-12 col-md-12"><hr/>
            <h3>mind. 5-10 Bewerbungen wurden versendet</h3><br/></div>
            <div class="col-12 col-md-12">
                <div class="checkbox" style="display: block;">
                    <label><input name="anwendungen_zeigen_check" id="anwendungen_zeigen_check" onclick="$('#anwendungen_zeigen').toggle()" type="checkbox" > Anwendungen zeigen </label>
                </div>
            </div>
            <div id="anwendungen_zeigen" style="display:none;" class="col-12 col-md-12">
              <div class="form-group col-12 col-md-12">
                <label for="" class=""><b>CV-1</b></label>
                <div class="row">
                    <div class="col-12 col-xl-4 col-lg-6 mb-2">
                        <input type="text" name="prof_bewerbung_sent_cv1_to" id="prof_bewerbung_sent_cv1_to" class="form-control"  value="{{isset($attendance_additional->prof_bewerbung_sent_cv1_to) ? $attendance_additional->prof_bewerbung_sent_cv1_to : ''}}" placeholder="Please specify to whom this CV is sent">  
                    </div>
                    <div class="col-12 col-xl-2 col-lg-6 mb-2">
                        <select name="pdf_bewerbung_sent_cv1_cvs_id" class="form-control">
                            <option value="">Select CV</option>
                            @foreach($cvs as $cv)
                                <option value="{{ $cv->id }}" @if(isset($attendance_additional->pdf_bewerbung_sent_cv1_cvs_id)) @if($attendance_additional->pdf_bewerbung_sent_cv1_cvs_id == $cv->id) selected @endif @endif>{{ $cv->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 col-xl-4 col-lg-6 mb-2">
                        <input type="text" name="cv1_name" id="cv1_name" class="form-control" value="" placeholder="Selected filename will appear here" readonly>
                    </div>
                    <div class="col-12 col-xl-2 col-lg-6 mb-2">
                        <input name="cv1" id="cv1" type="file" class="form-control file" style="display:none;">
                        <div class="browse" style="border: 1px solid #ced4da; width:130px; text-align:center; pading:5px; border-radius:100px; padding-top:7px; padding-bottom:7px; cursor:pointer;"><?php echo trans('forms.choose_file'); ?></div>    
                    </div>
                </div>
              </div>  
              <div class="form-group col-12">
                <label for="" class=""><b>CV-2</b></label>
                <div class="row">
                    <div class="col-12 col-xl-4 col-lg-6 mb-2">
                        <input type="text" name="prof_bewerbung_sent_cv2_to" id="prof_bewerbung_sent_cv2_to" class="form-control"  value="{{isset($attendance_additional->prof_bewerbung_sent_cv2_to) ? $attendance_additional->prof_bewerbung_sent_cv2_to : ''}}" placeholder="Please specify to whom this CV is sent">  
                    </div>
                    <div class="col-12 col-xl-2 col-lg-6 mb-2">
                        <select name="pdf_bewerbung_sent_cv2_cvs_id" class="form-control">
                            <option value="">Select CV</option>     
                            @foreach($cvs as $cv)
                                <option value="{{ $cv->id }}" @if(isset($attendance_additional->pdf_bewerbung_sent_cv2_cvs_id)) @if($attendance_additional->pdf_bewerbung_sent_cv2_cvs_id == $cv->id) selected @endif @endif}>{{ $cv->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 col-xl-4 col-lg-6 mb-2">
                        <input type="text" name="cv2_name" id="cv2_name" class="form-control" value="" placeholder="Selected filename will appear here" readonly>
                    </div>
                    <div class="col-12 col-xl-2 col-lg-6 mb-2">
                        <input name="cv2" id="cv2" type="file" class="form-control file" style="display:none;">
                        <div class="browse" style="border: 1px solid #ced4da; width:130px; text-align:center; pading:5px; border-radius:100px; padding-top:7px; padding-bottom:7px; cursor:pointer;"><?php echo trans('forms.choose_file'); ?></div>    
                    </div>
                </div>
              </div> 
              <div class="form-group col-12">
                <label for="" class=""><b>CV-3</b></label>
                <div class="row">
                <div class="col-12 col-xl-4 col-lg-6 mb-2">
                        <input type="text" name="prof_bewerbung_sent_cv3_to" id="prof_bewerbung_sent_cv3_to" class="form-control"  value="{{isset($attendance_additional->prof_bewerbung_sent_cv3_to) ? $attendance_additional->prof_bewerbung_sent_cv3_to : ''}}" placeholder="Please specify to whom this CV is sent">  
                    </div>
                    <div class="col-12 col-xl-2 col-lg-6 mb-2">
                        <select name="pdf_bewerbung_sent_cv3_cvs_id" class="form-control">
                            <option value="">Select CV</option>
                            @foreach($cvs as $cv)
                                <option value="{{ $cv->id }}" @if(isset($attendance_additional->pdf_bewerbung_sent_cv3_cvs_id)) @if($attendance_additional->pdf_bewerbung_sent_cv3_cvs_id == $cv->id) selected @endif @endif}>{{ $cv->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 col-xl-4 col-lg-6 mb-2">
                        <input type="text" name="cv3_name" id="cv3_name" class="form-control" value="" placeholder="Selected filename will appear here" readonly>
                    	@if(isset($attendance_additional->pdf_bewerbung_sent_cv3))<input type="hidden" name="cv3_name_hidden" id="cv3_name_hidden" class="form-control" value="{{$attendance_additional->pdf_bewerbung_sent_cv3}}"> @endif
                    </div>
                    <div class="col-12 col-xl-2 col-lg-6 mb-2">
                        <input name="cv3" id="cv3" type="file" class="form-control file" style="display:none;">
                        <div class="browse" style="border: 1px solid #ced4da; width:130px; text-align:center; pading:5px; border-radius:100px; padding-top:7px; padding-bottom:7px; cursor:pointer;"><?php echo trans('forms.choose_file'); ?></div>    
                    </div>
                </div>
              </div> 
              <div class="form-group col-12">
                <label for="" class=""><b>CV-4</b></label>
                <div class="row">
                <div class="col-12 col-xl-4 col-lg-6 mb-2">
                        <input type="text" name="prof_bewerbung_sent_cv4_to" id="prof_bewerbung_sent_cv4_to" class="form-control"  value="{{isset($attendance_additional->prof_bewerbung_sent_cv4_to) ? $attendance_additional->prof_bewerbung_sent_cv4_to : ''}}" placeholder="Please specify to whom this CV is sent">  
                    </div>
                    <div class="col-12 col-xl-2 col-lg-6 mb-2">
                        <select name="pdf_bewerbung_sent_cv4_cvs_id" class="form-control">
                            <option value="">Select CV</option>
                            @foreach($cvs as $cv)
                                <option value="{{ $cv->id }}" @if(isset($attendance_additional->pdf_bewerbung_sent_cv4_cvs_id)) @if($attendance_additional->pdf_bewerbung_sent_cv4_cvs_id == $cv->id) selected @endif @endif}>{{ $cv->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 col-xl-4 col-lg-6 mb-2">
                        <input type="text" name="cv4_name" id="cv4_name" class="form-control" placeholder="Selected filename will appear here" readonly>
                        @if(isset($attendance_additional->pdf_bewerbung_sent_cv4))<input type="hidden" name="cv4_name_hidden" id="cv4_name_hidden" class="form-control" value="{{$attendance_additional->pdf_bewerbung_sent_cv4}}"> @endif
                    </div>
                    <div class="col-12 col-xl-2 col-lg-6 mb-2">
                        <input name="cv4" id="cv4" type="file" class="form-control file" style="display:none;">
                        <div class="browse" style="border: 1px solid #ced4da; width:130px; text-align:center; pading:5px; border-radius:100px; padding-top:7px; padding-bottom:7px; cursor:pointer;"><?php echo trans('forms.choose_file'); ?></div>    
                    </div>
                </div>
              </div> 
              <div class="form-group col-12">
                <label for="" class=""><b>CV-5</b></label>
                <div class="row">
                    <div class="col-12 col-xl-4 col-lg-6 mb-2">
                        <input type="text" name="prof_bewerbung_sent_cv5_to" id="prof_bewerbung_sent_cv5_to" class="form-control"  value="{{isset($attendance_additional->prof_bewerbung_sent_cv5_to) ? $attendance_additional->prof_bewerbung_sent_cv5_to : ''}}" placeholder="Please specify to whom this CV is sent">  
                    </div>
                    <div class="col-12 col-xl-2 col-lg-6 mb-2">
                        <select name="pdf_bewerbung_sent_cv5_cvs_id" class="form-control">
                            <option value="">Select CV</option>
                            @foreach($cvs as $cv)
                                <option value="{{ $cv->id }}" @if(isset($attendance_additional->pdf_bewerbung_sent_cv5_cvs_id)) @if($attendance_additional->pdf_bewerbung_sent_cv5_cvs_id == $cv->id) selected @endif @endif}>{{ $cv->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 col-xl-4 col-lg-6 mb-2">
                        <input type="text" name="cv5_name" id="cv5_name" class="form-control" value="" placeholder="Selected filename will appear here" readonly>
                        @if(isset($attendance_additional->pdf_bewerbung_sent_cv5))<input type="hidden" name="cv5_name_hidden" id="cv5_name_hidden" class="form-control" value="{{$attendance_additional->pdf_bewerbung_sent_cv5}}"> @endif
                    </div>
                    <div class="col-12 col-xl-2 col-lg-6 mb-2">
                        <input name="cv5" id="cv5" type="file" class="form-control file" style="display:none;">
                        <div class="browse" style="border: 1px solid #ced4da; width:130px; text-align:center; pading:5px; border-radius:100px; padding-top:7px; padding-bottom:7px; cursor:pointer;"><?php echo trans('forms.choose_file'); ?></div>    
                    </div>
                </div>
              </div> 
              <div class="form-group col-12">
                <label for="" class=""><b>CV-6</b></label>
                <div class="row">
                    <div class="col-12 col-xl-4 col-lg-6 mb-2">
                        <input type="text" name="prof_bewerbung_sent_cv6_to" id="prof_bewerbung_sent_cv6_to" class="form-control"  value="{{isset($attendance_additional->prof_bewerbung_sent_cv6_to) ? $attendance_additional->prof_bewerbung_sent_cv6_to : ''}}" placeholder="Please specify to whom this CV is sent">  
                    </div>
                    <div class="col-12 col-xl-2 col-lg-6 mb-2">
                        <select name="pdf_bewerbung_sent_cv6_cvs_id" class="form-control">
                            <option value="">Select CV</option>
                            @foreach($cvs as $cv)
                                <option value="{{ $cv->id }}" @if(isset($attendance_additional->pdf_bewerbung_sent_cv6_cvs_id)) @if($attendance_additional->pdf_bewerbung_sent_cv6_cvs_id == $cv->id) selected @endif @endif}>{{ $cv->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 col-xl-4 col-lg-6 mb-2">
                        <input type="text" name="cv6_name" id="cv6_name" class="form-control" value="" placeholder="Selected filename will appear here" readonly>
                        @if(isset($attendance_additional->pdf_bewerbung_sent_cv6))<input type="hidden" name="cv6_name_hidden" id="cv6_name_hidden" class="form-control" value="{{$attendance_additional->pdf_bewerbung_sent_cv6}}"> @endif
                    </div><div class="col-12 col-xl-2 col-lg-6 mb-2">
                        <input name="cv6" id="cv6" type="file" class="form-control file" style="display:none;">
                        <div class="browse" style="border: 1px solid #ced4da; width:130px; text-align:center; pading:5px; border-radius:100px; padding-top:7px; padding-bottom:7px; cursor:pointer;"><?php echo trans('forms.choose_file'); ?></div>    
                    </div>
                </div>
              </div> 
              <div class="form-group col-12">
                <label for="" class=""><b>CV-7</b></label>
                <div class="row">
                    <div class="col-12 col-xl-4 col-lg-6 mb-2">
                        <input type="text" name="prof_bewerbung_sent_cv7_to" id="prof_bewerbung_sent_cv7_to" class="form-control"  value="{{isset($attendance_additional->prof_bewerbung_sent_cv7_to) ? $attendance_additional->prof_bewerbung_sent_cv7_to : ''}}" placeholder="Please specify to whom this CV is sent">  
                    </div>
                    <div class="col-12 col-xl-2 col-lg-6 mb-2">
                        <select name="pdf_bewerbung_sent_cv7_cvs_id" class="form-control">
                            <option value="">Select CV</option>
                            @foreach($cvs as $cv)
                                <option value="{{ $cv->id }}" @if(isset($attendance_additional->pdf_bewerbung_sent_cv7_cvs_id)) @if($attendance_additional->pdf_bewerbung_sent_cv7_cvs_id == $cv->id) selected @endif @endif}>{{ $cv->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 col-xl-4 col-lg-6 mb-2">
                        <input type="text" name="cv7_name" id="cv7_name" class="form-control" value="" placeholder="Selected filename will appear here" readonly>
                        @if(isset($attendance_additional->pdf_bewerbung_sent_cv7))<input type="hidden" name="cv7_name_hidden" id="cv7_name_hidden" class="form-control" value="{{$attendance_additional->pdf_bewerbung_sent_cv7}}"> @endif
                    </div>
                    <div class="col-12 col-xl-2 col-lg-6 mb-2">
                        <input name="cv7" id="cv7" type="file" class="form-control file" style="display:none;">
                        <div class="browse" style="border: 1px solid #ced4da; width:130px; text-align:center; pading:5px; border-radius:100px; padding-top:7px; padding-bottom:7px; cursor:pointer;"><?php echo trans('forms.choose_file'); ?></div>    
                    </div>
                </div>
              </div> 
              <div class="form-group col-12">
                <label for="" class=""><b>CV-8</b></label>
                <div class="row">
                    <div class="col-12 col-xl-4 col-lg-6 mb-2">
                        <input type="text" name="prof_bewerbung_sent_cv8_to" id="prof_bewerbung_sent_cv8_to" class="form-control"  value="{{isset($attendance_additional->prof_bewerbung_sent_cv8_to) ? $attendance_additional->prof_bewerbung_sent_cv8_to : ''}}" placeholder="Please specify to whom this CV is sent">  
                    </div>
                    <div class="col-12 col-xl-2 col-lg-6 mb-2">
                        <select name="pdf_bewerbung_sent_cv8_cvs_id" class="form-control">
                            <option value="">Select CV</option>
                            @foreach($cvs as $cv)
                                <option value="{{ $cv->id }}" @if(isset($attendance_additional->pdf_bewerbung_sent_cv8_cvs_id)) @if($attendance_additional->pdf_bewerbung_sent_cv8_cvs_id == $cv->id) selected @endif @endif}>{{ $cv->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 col-xl-4 col-lg-6 mb-2">
                        <input type="text" name="cv8_name" id="cv8_name" class="form-control" value="" placeholder="Selected filename will appear here" readonly>
                        @if(isset($attendance_additional->pdf_bewerbung_sent_cv8))<input type="hidden" name="cv8_name_hidden" id="cv8_name_hidden" class="form-control" value="{{$attendance_additional->pdf_bewerbung_sent_cv8}}"> @endif
                    </div>
                    <div class="col-12 col-xl-2 col-lg-6 mb-2">
                        <input name="cv8" id="cv8" type="file" class="form-control file" style="display:none;">
                        <div class="browse" style="border: 1px solid #ced4da; width:130px; text-align:center; pading:5px; border-radius:100px; padding-top:7px; padding-bottom:7px; cursor:pointer;"><?php echo trans('forms.choose_file'); ?></div>    
                    </div>
                </div>
              </div> 
              <div class="form-group col-12">
                <label for="" class=""><b>CV-9</b></label>
                <div class="row">
                    <div class="col-12 col-xl-4 col-lg-6 mb-2">
                        <input type="text" name="prof_bewerbung_sent_cv9_to" id="prof_bewerbung_sent_cv9_to" class="form-control"  value="{{isset($attendance_additional->prof_bewerbung_sent_cv9_to) ? $attendance_additional->prof_bewerbung_sent_cv9_to : ''}}" placeholder="Please specify to whom this CV is sent">  
                    </div>
                    <div class="col-12 col-xl-2 col-lg-6 mb-2">
                        <select name="pdf_bewerbung_sent_cv9_cvs_id" class="form-control">
                            <option value="">Select CV</option>
                            @foreach($cvs as $cv)
                                <option value="{{ $cv->id }}" @if(isset($attendance_additional->pdf_bewerbung_sent_cv9_cvs_id)) @if($attendance_additional->pdf_bewerbung_sent_cv9_cvs_id == $cv->id) selected @endif @endif}>{{ $cv->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 col-xl-4 col-lg-6 mb-2">
                        <input type="text" name="cv9_name" id="cv9_name" class="form-control" value="" placeholder="Selected filename will appear here" readonly>
                        @if(isset($attendance_additional->pdf_bewerbung_sent_cv9))<input type="hidden" name="cv9_name_hidden" id="cv9_name_hidden" class="form-control" value="{{$attendance_additional->pdf_bewerbung_sent_cv9}}"> @endif
                    </div>
                    <div class="col-12 col-xl-2 col-lg-6 mb-2">
                        <input name="cv9" id="cv9" type="file" class="form-control file" style="display:none;">
                        <div class="browse" style="border: 1px solid #ced4da; width:130px; text-align:center; pading:5px; border-radius:100px; padding-top:7px; padding-bottom:7px; cursor:pointer;"><?php echo trans('forms.choose_file'); ?></div>    
                    </div>
                </div>
              </div> 
              <div class="form-group col-12">
                <label for="" class=""><b>CV-10</b></label>
                <div class="row">
                    <div class="col-12 col-xl-4 col-lg-6 mb-2">
                        <input type="text" name="prof_bewerbung_sent_cv10_to" id="prof_bewerbung_sent_cv10_to" class="form-control"  value="{{isset($attendance_additional->prof_bewerbung_sent_cv10_to) ? $attendance_additional->prof_bewerbung_sent_cv10_to : ''}}" placeholder="Please specify to whom this CV is sent">  
                    </div>
                    <div class="col-12 col-xl-2 col-lg-6 mb-2">
                        <select name="pdf_bewerbung_sent_cv10_cvs_id" class="form-control">
                            <option value="">Select CV</option>
                            @foreach($cvs as $cv)
                                <option value="{{ $cv->id }}" @if(isset($attendance_additional->pdf_bewerbung_sent_cv10_cvs_id)) @if($attendance_additional->pdf_bewerbung_sent_cv10_cvs_id == $cv->id) selected @endif @endif}>{{ $cv->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 col-xl-4 col-lg-6 mb-2">
                        <input type="text" name="cv10_name" id="cv10_name" class="form-control" value="" placeholder="Selected filename will appear here" readonly>
                        @if(isset($attendance_additional->pdf_bewerbung_sent_cv10))<input type="hidden" name="cv10_name_hidden" id="cv10_name_hidden" class="form-control" value="{{$attendance_additional->pdf_bewerbung_sent_cv10}}"> @endif
                    </div>
                    <div class="col-12 col-xl-2 col-lg-6 mb-2">
                        <input name="cv10" id="cv10" type="file" class="form-control file" style="display:none;">
                        <div class="browse" style="border: 1px solid #ced4da; width:130px; text-align:center; pading:5px; border-radius:100px; padding-top:7px; padding-bottom:7px; cursor:pointer;"><?php echo trans('forms.choose_file'); ?></div>    
                    </div>
                </div>
              </div> 
            </div>

        <!-- --------------- End CV Upload ---------------- -->
        <?php } ?>
		
		
		<?php if($appointment->item_id == env('MI_DURCHHALTEVERMOEGEN_BELASTBARKEIT', 2793)) { ?>
        <div class="col-12 col-md-12">
        <hr/>
        <h3>Zusätzliche Herausforderungen erschwerten bisher die berufliche Laufbahn/Perspective:</h3><br/>
        <h6>Zum Ankreuzen:</h6>
        
        @if(isset($attendance_additional->durch_belast_options))
            <div class="checkbox">
              <label><input name="durch_belast_options_gesund" type="checkbox" @if(str_contains($attendance_additional->durch_belast_options, 'durch_belast_options_gesund')) checked @endif value="durch_belast_options_gesund"> gesundheitlich</label>
            </div>
            <div class="checkbox">
              <label><input name="durch_belast_options_familie" type="checkbox" @if(str_contains($attendance_additional->durch_belast_options, 'durch_belast_options_familie')) checked @endif value="durch_belast_options_familie"> familiäre</label>
            </div>
            <div class="checkbox">
              <label><input name="durch_belast_options_partner" type="checkbox" @if(str_contains($attendance_additional->durch_belast_options, 'durch_belast_options_partner')) checked @endif value="durch_belast_options_partner"> partnerschaftliche</label>
            </div>
            <div class="checkbox">
              <label><input name="durch_belast_options_kinder" type="checkbox" @if(str_contains($attendance_additional->durch_belast_options, 'durch_belast_options_kinder')) checked @endif value="durch_belast_options_kinder"> Kinderbetreuung</label>
            </div>
            <div class="checkbox">
              <label><input name="durch_belast_options_financial" type="checkbox" @if(str_contains($attendance_additional->durch_belast_options, 'durch_belast_options_financial')) checked @endif value="durch_belast_options_financial"> finanzielle</label>
            </div>
            <div class="checkbox">
              <label><input name="durch_belast_options_recht" type="checkbox" @if(str_contains($attendance_additional->durch_belast_options, 'durch_belast_options_recht')) checked @endif value="durch_belast_options_recht"> rechtliche</label>
            </div>
            <div class="checkbox">
              <label><input name="durch_belast_options_sprach" type="checkbox" @if(str_contains($attendance_additional->durch_belast_options, 'durch_belast_options_sprach')) checked @endif value="durch_belast_options_sprach"> sprachliche/kulturelle</label>
            </div>
            <div class="checkbox">
              <label><input name="durch_belast_options_gesund" type="checkbox" @if(str_contains($attendance_additional->durch_belast_options, 'durch_belast_options_pflege')) checked @endif value="durch_belast_options_pflege"> Pflege von Angehörigen</label>
            </div>
        @else
        	<div class="checkbox">
              <label><input name="durch_belast_options_gesund" type="checkbox" value="durch_belast_options_gesund"> gesundheitlich</label>
            </div>
            <div class="checkbox">
              <label><input name="durch_belast_options_familie" type="checkbox" value="durch_belast_options_familie"> familiäre</label>
            </div>
            <div class="checkbox">
              <label><input name="durch_belast_options_partner" type="checkbox" value="durch_belast_options_partner"> partnerschaftliche</label>
            </div>
            <div class="checkbox">
              <label><input name="durch_belast_options_kinder" type="checkbox" value="durch_belast_options_kinder"> Kinderbetreuung</label>
            </div>
            <div class="checkbox">
              <label><input name="durch_belast_options_financial" type="checkbox" value="durch_belast_options_financial"> finanzielle</label>
            </div>
            <div class="checkbox">
              <label><input name="durch_belast_options_recht" type="checkbox" value="durch_belast_options_recht"> rechtliche</label>
            </div>
            <div class="checkbox">
              <label><input name="durch_belast_options_sprach" type="checkbox" value="durch_belast_options_sprach"> sprachliche/kulturelle</label>
            </div>
            <div class="checkbox">
              <label><input name="durch_belast_options_pflege" type="checkbox" value="durch_belast_options_pflege"> Pflege von Angehörigen</label>
            </div>
            
        @endif
        @if(isset($attendance_additional->durch_belast_options_other  ))
        	<div class="checkbox">
              <label><input name="x" onclick="$('#durch_belast_options_other_div').toggle()" type="checkbox" checked > Sonstiges:</label>
            </div>
            <div id="durch_belast_options_other_div">
            	<textarea rows=4 cols=5  class="form-control"  name="durch_belast_options_other">{{$attendance_additional->durch_belast_options_other}}</textarea>
            </div>
        @else
         	<div class="checkbox">
              <label><input name="x" onclick="$('#durch_belast_options_other_div').toggle()" type="checkbox" > Sonstiges:</label>
            </div>
            <div id="durch_belast_options_other_div" style="display:none;">
            	<textarea rows=4 cols=5  class="form-control"  name="durch_belast_options_other"></textarea>
            </div>
        @endif
        </div>
		<?php } ?>
		
		<?php if($appointment->item_id == env('MI_SELBST_UND_FREMDWAHRNEHMUNG_TEIL_1', 2792)) { ?>
        <div class="col-12 col-md-12"><hr/>
        <h3>Berufliche Kompetenzen / neu entdeckte Potentiale / neu entdeckte berufliche Perspektiven:</h3><br/>
        <h6><u>Resourceanalyse / neue berufliche Potentiale:</u></h6><br/>
        </div>
        <div class="col-12 col-md-12">
        <label for="selbst_fremd_strengths">Stärken</label>
        <textarea rows=4 cols=5  class="form-control"  name="selbst_fremd_strengths">@if(isset($attendance_additional->selbst_fremd_strengths)){{$attendance_additional->selbst_fremd_strengths}}@endif</textarea>
        </div>
        <div class="col-12 col-md-12">
        <label for="selbst_fremd_strengths">Schwächen</label>
        <textarea rows=4 cols=5  class="form-control"  name="selbst_fremd_weakness">@if(isset($attendance_additional->selbst_fremd_weakness)){{$attendance_additional->selbst_fremd_weakness}}@endif</textarea>
        </div>
        <div class="col-12 col-md-12">
        <label for="selbst_fremd_strengths">Neu entdeckte Potentiale:</label>
        <textarea rows=4 cols=5  class="form-control"  name="selbst_fremd_potential">@if(isset($attendance_additional->selbst_fremd_potential)){{$attendance_additional->selbst_fremd_potential}}@endif</textarea>
        </div>
        <div class="col-12 col-md-12">
        <label for="selbst_fremd_strengths">Energiekiller</label>
        <textarea rows=4 cols=5  class="form-control"  name="selbst_fremd_energykiller">@if(isset($attendance_additional->selbst_fremd_energykiller)){{$attendance_additional->selbst_fremd_energykiller}}@endif</textarea>
        </div>
        <div class="col-12 col-md-12">
        <label for="selbst_fremd_strengths">Energiegeber</label>
        <textarea rows=4 cols=5  class="form-control"  name="selbst_fremd_energygiver">@if(isset($attendance_additional->selbst_fremd_energygiver)){{$attendance_additional->selbst_fremd_energygiver}}@endif</textarea>
        </div>
        <br/><br/>
        <div class="col-12 col-md-12">
        <label for="selbst_fremd_strengths">Neue berufliche Zielstellung & Weg-Ziel Planung:</label>
        <textarea rows=4 cols=5  class="form-control"  name="selbst_fremd_ziel_planung">@if(isset($attendance_additional->selbst_fremd_ziel_planung)){{$attendance_additional->selbst_fremd_ziel_planung}}@endif</textarea>
        </div>
        <div class="col-12 col-md-12">
        <label for="selbst_fremd_strengths">Neue entdekte berufliche Perspektiven:</label>
        <textarea rows=4 cols=5  class="form-control"  name="selbst_fremd_beruf_persp">@if(isset($attendance_additional->selbst_fremd_beruf_persp)){{$attendance_additional->selbst_fremd_beruf_persp}}@endif</textarea>
        </div>
		<?php } ?>
		
		<?php if($appointment->item_id == env('MI_MOEGLICHKEITEN_VISIONEN', 2794)) { ?>
        <div class="col-12 col-md-12"><hr/><h5>Kompetenzanalyse</h5><br/>
        <label for="moeglich_vision_competence">Welche Abschlüsse und Qualifikationen bringt der Coachee mit:</label>
        <textarea rows=4 cols=5  class="form-control"  name="moeglich_vision_competence">@if(isset($attendance_additional->moeglich_vision_competence)){{$attendance_additional->moeglich_vision_competence}}@endif</textarea>
       	<label for="moeglich_vision_experience">Berufserfahrungen:</label>
        <textarea rows=4 cols=5  class="form-control"  name="moeglich_vision_experience">@if(isset($attendance_additional->moeglich_vision_experience)){{$attendance_additional->moeglich_vision_experience}}@endif</textarea>
       
       </div>
		<?php } ?>


     

        <div class="col-12 col-md-12"><hr/>
            <h3>Coachingverhalten</h3><br/></div>
            
            <div class="col-12 col-md-12" id="next_appointment">
                <table class="table table-bordered" >
                    <tr>
                        <td><b>Verhält sich vorbildlich</b></td>
                        <td>
                            <div id='vorbildlich_jqxRating'>
                            </div>
                            <input type="hidden" name="vorbildlich" id="vorbildlich" value="{{isset($attendance_verhalten->vorbildlich) ? $attendance_verhalten->vorbildlich :''}}">
                        </td>
                    </tr>
                    <tr>
                        <td><b>Sucht nach realistischen Lösungen</b></td>
                        <td>
                            <div id='sucht_loesungen_jqxRating'>
                            </div>
                            <input type="hidden" name="sucht_loesungen" id="sucht_loesungen" value="{{isset($attendance_verhalten->sucht_loesungen) ? $attendance_verhalten->sucht_loesungen :''}}">
                        </td>
                    </tr>
                    <tr>
                        <td><b>Agiert entscheidungs-freudig; geht Probleme an</b></td>
                        <td>
                            <div id='agiert_entscheidung_jqxRating'>
                            </div>
                            <input type="hidden" name="agiert_entscheidung" id="agiert_entscheidung" value="{{isset($attendance_verhalten->agiert_entscheidung) ? $attendance_verhalten->agiert_entscheidung :''}}">
                        </td>
                    </tr>
                    <tr>
                        <td><b>Ist motiviert, Konflikte zu lösen</b></td>
                        <td>
                            <div id='motiviert_konflikt_solve_jqxRating'>
                            </div>
                            <input type="hidden" name="motiviert_konflikt_solve" id="motiviert_konflikt_solve" value="{{isset($attendance_verhalten->motiviert_konflikt_solve) ? $attendance_verhalten->motiviert_konflikt_solve :''}}">
                        </td>
                    </tr>
                    <tr>
                        <td><b>Ist motiviert, Problemen auf den Grund zu gehen</b></td>
                        <td>
                            <div id='motiviert_problem_solve_jqxRating'>
                            </div>
                            <input type="hidden" name="motiviert_problem_solve" id="motiviert_problem_solve" value="{{isset($attendance_verhalten->motiviert_problem_solve) ? $attendance_verhalten->motiviert_problem_solve :''}}">
                        </td>
                    </tr>
                    <tr>
                        <td><b>Formuliert klare Erwartungen</b></td>
                        <td>
                            <div id='formuliert_klare_erwartung_jqxRating'>
                            </div>
                            <input type="hidden" name="formuliert_klare_erwartung" id="formuliert_klare_erwartung" value="{{isset($attendance_verhalten->formuliert_klare_erwartung) ? $attendance_verhalten->formuliert_klare_erwartung :''}}">
                        </td>
                    </tr>
                </table>
            </div>
    
      	<div class="col-12 col-md-12" id="next_appointment">
       	 	<hr />
            @if(isset($next_appointment->date))
            	
            
            <h3>@lang('forms.next_appointment')</h3>
            
                <table class="table table-bordered" >
                    <tr>
                        <td><b>Datum & Uhrzeit</b></td>
                        <td>{{$next_appointment->date}} {{$next_appointment->time}} - {{$next_appointment->time_end}}</td>
                    </tr>
                    <tr>
                        <td><b>Modul & Modulitem</b></td>
                        <td>{{$next_appointment->title}}</td>
                    </tr>
                </table>
              
            @else
            
            	<h5>Keine Termine mehr!</h5>
            	
            @endif
        </div>
    
    
        <div class="col-12 col-md-6">
            <label>@lang('forms.coach_signature')</label>
            <br/>
            @if(isset($attendance->id))
                @if(!empty($attendance->teacher_signature))
                @php $teacher_signature_check++; @endphp
               <img src="{{asset('signatures')}}/{{$attendance->teacher_signature}}">
                @endif
            @endif
            @if($teacher_signature_check==0)
            <canvas id="signature1"  style="border: 1px dashed black;"></canvas>
            <br/>
            <button type="button" class="btn btn-info"  onclick="clearSignature('signature1')" >@lang('forms.clear')</button>
            @endif
        </div>
        <div class="col-12 col-md-6">
            <label>@lang('forms.coachee_signature')</label>
            <br/>
            @if(isset($attendance->id))
            @if(!empty($attendance->student_signature))
            @php $student_signature_check++; @endphp
           <img src="{{asset('signatures')}}/{{$attendance->student_signature}}">
            @endif
            @endif
            @if($student_signature_check==0)
            <canvas id="signature2"  style="border: 1px dashed black;"></canvas>
            <br/>
            <button type="button" class="btn btn-info"  onclick="clearSignature('signature2')" >@lang('forms.clear')</button>
            @endif
        </div>
        <div class="col-12 col-md-12">&nbsp;<br/></div>

         <div class="col-12 col-md-12"><br/><br/>
        


            <button id="save_pdf"  onclick="$('#submit_type').val('save_pdf')"  style="display: none;" type="submit" class="btn btn-primary"  >@lang('forms.save_generatepdf')</button>
            <button  id="save_send" onclick="$('#submit_type').val('save_send')" style="display: none;" type="submit" class="btn btn-primary"  >@lang('forms.save_send')</button>

         @if(!(isset($attendance->id) && $attendance->status == 1))
            <!-- <button type="submit" class="btn btn-primary">@lang('forms.save_generatepdf')</button> -->
            @endif
            
            @if(isset($attendance->id) && !isset($attendance->pdf_url))
            <!-- <a target='_blank'  href="{{route('tagasdokuPdf',['id'=>base64_encode($attendance->id)])}}" class="btn btn-primary">@lang('forms.pdf')</a> -->
           @endif
             @if(isset($attendance->id) && !isset($attendance->student_signature))
            <!-- <button type="button" class="btn btn-primary">@lang('forms.save_send')</button> -->
            @endif
            

        </div>
                                                
    </div>

    </form>
<script src="<?php echo url('assets/plugins/jqwidgets/jqxcore.js'); ?>"></script>
<script src="<?php echo url('assets/plugins/jqwidgets/jqxrating.js'); ?>"></script>
<script src="<?php echo url('assets/plugins/dropzone/dropzone.js'); ?>"></script>
<script type="text/javascript">
    var token = "<?php echo csrf_token() ?>";
    $()
</script>
<script type="text/javascript">
    // Plan Adding
    var count;
    count = 0;
    let plan_d = "{{isset($attendance_additional->weg_ziel_planung_plan_d) ? $attendance_additional->weg_ziel_planung_plan_d :''}}";
    let plan_e = "{{isset($attendance_additional->weg_ziel_planung_plan_e) ? $attendance_additional->weg_ziel_planung_plan_e :''}}";
    if((plan_d == "") || (plan_e == "")) {
        function appendTextbox(event){
            event.preventDefault();
            count++;
            if (count < 3) {
                var ch_key = String.fromCharCode(count + 99);
                var ch_key_upper = String.fromCharCode(count + 67);
                if (count == 1)
                    var textbox = '<div class="col-12 col-md-12"><label for="plan_' + ch_key  + '">Plan ' + ch_key_upper + '</label><textarea rows=4 cols=5  class="form-control"  name="plan_' + ch_key + '"></textarea></div>';            
                if (count == 2)
                    var textbox = '<div class="col-12 col-md-12"><label for="plan_' + ch_key  + '">Plan ' + ch_key_upper + '</label><textarea rows=4 cols=5  class="form-control"  name="plan_' + ch_key + '"></textarea></div>';
                $("#textbox-wrapper").append(textbox);
            } else document.querySelector("#plus").disabled = true;
        }
    }
    else document.querySelector("#plus").disabled = true;
    
    @if(isset($attendance_additional->pdf_bewerbung_sent_cv10_cvs_id) || 
        isset($attendance_additional->pdf_bewerbung_sent_cv9_cvs_id) ||
        isset($attendance_additional->pdf_bewerbung_sent_cv8_cvs_id) ||
        isset($attendance_additional->pdf_bewerbung_sent_cv7_cvs_id) ||
        isset($attendance_additional->pdf_bewerbung_sent_cv6_cvs_id) ||
        isset($attendance_additional->pdf_bewerbung_sent_cv5_cvs_id) ||
        isset($attendance_additional->pdf_bewerbung_sent_cv4_cvs_id) ||
        isset($attendance_additional->pdf_bewerbung_sent_cv3_cvs_id) ||
        isset($attendance_additional->pdf_bewerbung_sent_cv2_cvs_id) ||
        isset($attendance_additional->pdf_bewerbung_sent_cv1_cvs_id))
        
    	//var checkBoxes = document.getElementByName("anwendungen_zeigen_check");
    	//$('#anwendungen_zeigen_check').trigger('click');
    	
    	$("input[name='anwendungen_zeigen_check']").prop("checked", true);
    	$('#anwendungen_zeigen').toggle();
    @endif

     $(document).ready(function () {
            let vorbildlich = "{{isset($attendance_verhalten->vorbildlich) ? $attendance_verhalten->vorbildlich :''}}";
            let sucht_loesungen = "{{isset($attendance_verhalten->sucht_loesungen) ? $attendance_verhalten->sucht_loesungen :''}}";
            let agiert_entscheidung = "{{isset($attendance_verhalten->agiert_entscheidung) ? $attendance_verhalten->agiert_entscheidung :''}}";
            let motiviert_konflikt_solve = "{{isset($attendance_verhalten->motiviert_konflikt_solve) ? $attendance_verhalten->motiviert_konflikt_solve :''}}";
            let motiviert_problem_solve = "{{isset($attendance_verhalten->motiviert_problem_solve) ? $attendance_verhalten->motiviert_problem_solve :''}}";
            let formuliert_klare_erwartung = "{{isset($attendance_verhalten->formuliert_klare_erwartung) ? $attendance_verhalten->formuliert_klare_erwartung :''}}";
            // Create jqxRating.

            $("#vorbildlich_jqxRating").jqxRating({ width: 350, height: 35, value: vorbildlich});
            $("#sucht_loesungen_jqxRating").jqxRating({ width: 350, height: 35, value: sucht_loesungen});
            $("#agiert_entscheidung_jqxRating").jqxRating({ width: 350, height: 35, value: agiert_entscheidung});
            $("#motiviert_konflikt_solve_jqxRating").jqxRating({ width: 350, height: 35, value: motiviert_konflikt_solve});
            $("#motiviert_problem_solve_jqxRating").jqxRating({ width: 350, height: 35, value: motiviert_problem_solve});
            $("#formuliert_klare_erwartung_jqxRating").jqxRating({ width: 350, height: 35, value: formuliert_klare_erwartung});
            
            // bind to jqxRating 'change' event.
            $("#vorbildlich_jqxRating").bind('change', function (event) {
                switch(event.value) {
                  case 1:
                  document.getElementById("vorbildlich").value = 1;
                   break;
                  case 2:
                  document.getElementById("vorbildlich").value = 2;
                   break;
                  case 3:
                  document.getElementById("vorbildlich").value = 3;
                   break;
                   case 4:
                  document.getElementById("vorbildlich").value = 4;
                   break;
                   case 5:
                  document.getElementById("vorbildlich").value = 5;
                   break;
                }
                
            });
            
            // bind to jqxRating 'change' event.
            $("#sucht_loesungen_jqxRating").bind('change', function (event) {
                switch(event.value) {
                  case 1:
                  document.getElementById("sucht_loesungen").value = 1;
                   break;
                  case 2:
                  document.getElementById("sucht_loesungen").value = 2;
                   break;
                  case 3:
                  document.getElementById("sucht_loesungen").value = 3;
                   break;
                   case 4:
                  document.getElementById("sucht_loesungen").value = 4;
                   break;
                   case 5:
                  document.getElementById("sucht_loesungen").value = 5;
                   break;
                }
                
            });
            
            // bind to jqxRating 'change' event.
            $("#agiert_entscheidung_jqxRating").bind('change', function (event) {
                switch(event.value) {
                  case 1:
                  document.getElementById("agiert_entscheidung").value = 1;
                   break;
                  case 2:
                  document.getElementById("agiert_entscheidung").value = 2;
                   break;
                  case 3:
                  document.getElementById("agiert_entscheidung").value = 3;
                   break;
                   case 4:
                  document.getElementById("agiert_entscheidung").value = 4;
                   break;
                   case 5:
                  document.getElementById("agiert_entscheidung").value = 5;
                   break;
                }
                
            });

            // bind to jqxRating 'change' event.
            $("#motiviert_konflikt_solve_jqxRating").bind('change', function (event) {
                switch(event.value) {
                  case 1:
                  document.getElementById("motiviert_konflikt_solve").value = 1;
                   break;
                  case 2:
                  document.getElementById("motiviert_konflikt_solve").value = 2;
                   break;
                  case 3:
                  document.getElementById("motiviert_konflikt_solve").value = 3;
                   break;
                   case 4:
                  document.getElementById("motiviert_konflikt_solve").value = 4;
                   break;
                   case 5:
                  document.getElementById("motiviert_konflikt_solve").value = 5;
                   break;
                }
                
            });
            
            // bind to jqxRating 'change' event.
            $("#motiviert_problem_solve_jqxRating").bind('change', function (event) {
                switch(event.value) {
                  case 1:
                  document.getElementById("motiviert_problem_solve").value = 1;
                   break;
                  case 2:
                  document.getElementById("motiviert_problem_solve").value = 2;
                   break;
                  case 3:
                  document.getElementById("motiviert_problem_solve").value = 3;
                   break;
                   case 4:
                  document.getElementById("motiviert_problem_solve").value = 4;
                   break;
                   case 5:
                  document.getElementById("motiviert_problem_solve").value = 5;
                   break;
                }
                
            });
            
            // bind to jqxRating 'change' event.
            $("#formuliert_klare_erwartung_jqxRating").bind('change', function (event) {
                switch(event.value) {
                  case 1:
                  document.getElementById("formuliert_klare_erwartung").value = 1;
                   break;
                  case 2:
                  document.getElementById("formuliert_klare_erwartung").value = 2;
                   break;
                  case 3:
                  document.getElementById("formuliert_klare_erwartung").value = 3;
                   break;
                   case 4:
                  document.getElementById("formuliert_klare_erwartung").value = 4;
                   break;
                   case 5:
                  document.getElementById("formuliert_klare_erwartung").value = 5;
                   break;
                }
                
            });

            /*--------------------------------------*/

            $("#tagesdoku_form").find("input[type=file]").each(function(index, field){
                let cv = index + 1;
                field.addEventListener('change', (event) => {
                    var filename = event.target.value.replace(/^.*[\\\/]/, '')
                    document.getElementById("cv" + cv + "_name").setAttribute('value', filename);
                });
            });
        });
</script>
<script type="text/javascript">
     /*----------------------------*/

    var signaturePad1;
    var signaturePad2;
    var teacher_signature_check = parseInt({{$teacher_signature_check}});
    var student_signature_check = parseInt({{$student_signature_check}});

    /*----------------------------*/

    function makeSignature(){
        if (teacher_signature_check==0){
            var canvas1 = document.getElementById("signature1");
            signaturePad1 = new SignaturePad(canvas1, {
                backgroundColor: 'rgb(255, 255, 255)'
            });
        }

        if (student_signature_check==0) {

            var canvas2 = document.getElementById("signature2");
            signaturePad2 = new SignaturePad(canvas2, {
                backgroundColor: 'rgb(255, 255, 255)'
            });
        }
    }

    /*----------------------------*/
    function clearSignature(idx){
        if (idx=="signature1") {
            signaturePad1.clear();
        }
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


      async function ajaxSaveTagesdoku(){
        event.preventDefault();
        let myForm = document.getElementById('tagesdoku_form');
        var sign1 = '';
        var sign2 = '';
        if (teacher_signature_check==0){
             sign1 = signaturePad1.toDataURL();
             if (signaturePad1.isEmpty()){
                sign1 = "";
             }
        }

        if (student_signature_check==0){
            sign2 = signaturePad2.toDataURL();
            if (signaturePad2.isEmpty()){
                sign2 = "";
             }
        }
         
         
        let formData = new FormData(myForm);
        formData.append('sign1', sign1);
        formData.append('sign2', sign2);
		 $.LoadingOverlay("show");
         let response = await fetch('{{route("ajaxStoreTagesdoku")}}', {
                          method: 'POST',
                          body: formData
                        });


        let result = await response.json();
         $.LoadingOverlay("hide");
        console.log(result);
        if (result.code==1){
            if(result.error!=""){
                alert(result.error);
            }
            window.location='<?php echo url('attendance-register'); ?>';
            //open_tagesdoku(result.output.course_id,result.output.appointment_id);
        }
        
                        
      }


      function buttonShow(){
        var sp1 = 0;
        var sp2 = 0;

        if (teacher_signature_check!=1){
            if (signaturePad1.isEmpty()){
                sp1 = 0;
            }else{
                sp1 = 1;
            }
        }else{
            sp1 = 1;
        }
        

        if (signaturePad2.isEmpty()){
            sp2 = 0;
        }else{
            sp2 = 1;
        }

        if (sp1==1 && sp2==1) {
            $('#save_pdf').show();
        }else{
            $('#save_pdf').hide();
        }

        if (sp1==1 && sp2==0) {
            $('#save_send').show();
        }else{
            $('#save_send').hide();
        }
        
      }


      setInterval(function() { buttonShow();}, 1000);

</script>