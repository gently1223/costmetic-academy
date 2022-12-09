<?php include(app_path() . '/common/panel/header.php'); ?>

 <div class="app-inner-layout app-inner-layout-page">
	<div class="app-inner-layout__wrapper">

		<div class="app-inner-layout__content pt-0">
			<div class="tab-content">
				<div class="container-fluid">
					<div class="card mb-3">
						<div class="card-header-tab card-header">
							<div
								class="card-header-title font-size-lg text-capitalize font-weight-normal">
							</div>

							<div class="btn-actions-pane-right actions-icon-btn">
								<button type="button"
									class="btn-shadow btn btn-wide btn-success"
									onclick="$('#form-box').slideToggle()">
									<span class="btn-icon-wrapper pr-1 opacity-7"> <i
										class="fa fa-plus"></i>
									</span> Add New
								</button>
							</div>

						</div>

						<div id="form-box" style="display: none;">
							<div class="main-card mb-2 card">
								<div class="card-body">
									<h5 class="card-title">Add New Offer</h5>
									<form action="" method="post">
                                        <?php echo csrf_field(); ?>
                                                                                  <div
											class="form-row">
											<div class="col-md-6">
												<div class="position-relative form-group">
													<label for="studentname" class=""><?php echo trans('forms.select_student'); ?><font
														style="color: red;">*</font></label> <select
														class="form-control" name="studentname" id="studentname" onchange="getdiv();"
														style="width: 100%;">
                                      <?php  foreach ($students as $w) { ?>
                                        <option
															value=" <?php echo  $w->id ?>"><?php echo $w->name ?></option>


                                      <?php } ?>



                                    </select>
												</div>
											</div>
											<div class="col-md-6">
												<div class="position-relative form-group">
													<label for="studentname" class=""><?php echo trans('forms.select_expert_advisor'); ?><font
														style="color: red;">*</font></label> <select
														class="form-control" name="expertadv" style="width: 100%;">
                                      <?php  foreach ($expertadv as $w) { ?>
                                        <option
															value=" <?php echo  $w->id ?>"><?php echo $w->name ?></option>


                                      <?php } ?>



                                    </select>
												</div>
											</div>
											<div class="col-md-6">
												<div class="position-relative form-group">
													<label for="offtype" class=""><?php echo trans('forms.select_type'); ?> <font
														style="color: red;">*</font></label> <select
														name="offtype" id="offtype" class="form-control"
														onchange="getdiv();" required="required">
														<option value="">Bitte auswählen</option>
														<option value="1">Umschulung</option>
														<option value="2">Coaching</option>
														
													</select>
												</div>
											</div>
											<div class="col-md-6">
												<div class="position-relative form-group">
													<label for="examplePassword11" class=""><?php echo trans('forms.consultation_date'); ?><font
														style="color: red;">*</font></label> <input
														name="due_date" type="text" class="form-control calendar">
												</div>
											</div>
											<div class="col-md-6">
												<div class="position-relative form-group">
													<label for="consultmode" class=""><?php echo trans('forms.consultation_mode'); ?> <font
														style="color: red;">*</font></label> <select
														name="consultmode" id="consultmode" class="form-control">
														<option value="Persönliches">Persönliches</option>
														<option value="Digitales">Digitales</option>
														<option value="Telefonisches">Telefonisches</option>


													</select>
												</div>
											</div>
											<div class="col-md-6">
												<div class="position-relative form-group">
													<label for="examplePassword11" class=""><?php echo trans('forms.begin_date'); ?>  <font
														style="color: red;">*</font></label> <input
														name="begin_date" type="text"
														class="form-control calendar">
												</div>
											</div>
										</div>

										<div id="regular_id" class="row" style="display: none;">
											<div class="col-md-6">
												<div class="position-relative form-group">
													<label for="studentname" class=""><b><?php echo trans('forms.regular_qualifications'); ?></b>
														<font style="color: red;">*</font></label><br>
                                                   <?php  foreach ($regular_qualifications as $w) { ?>
                                                   <input type="radio"
														name="regularquali" value=" <?php echo $w->id ?>"
														onchange="getblock();" id="qualimainid"> <?php

echo $w->qualification . '<br>';
                                                }
                                                echo '<br/><br>';
                                                ?>
                                                    <label
														for="regular_addon" class=""><b><?php echo trans('forms.regular_addon'); ?></b>
														<font style="color: red;">*</font></label><br>
                                                    <?php  foreach ($regular_addon as $y) { ?>
                                                     <input type="radio"
														name="regularaddon[]" value="<?php echo $y->id ?>"
														onchange="getblock();" id="qualimainid"> <?php

echo $y->addon_text . '<br>';
                                                    }
                                                    echo '<br/><br>';
                                                    ?>


<br>




													<div id="divblk1" style="display: none;">


	 <?php  foreach ($qual_blk1 as $w) { ?>
                                                   <input
															type="checkbox" name="divblkget1[]"
															value=" <?php echo $w->id ?>" change=> <?php

echo $w->text_blk . '<br><br>';
}
?>
                                                </div>
													<div id="divblk2" style="display: none;">


	 <?php  foreach ($qual_blk2 as $w) { ?>
                                                   <input
															type="checkbox" name="divblkget2[]"
															value=" <?php echo $w->id ?>" change=> <?php

echo $w->text_blk . '<br><br>';
}
?>
                                            </div>

													<div id="divblk3" style="display: none;">


	 <?php  foreach ($qual_blk3 as $w) { ?>
                                                   <input
															type="checkbox" name="divblkget3[]"
															value=" <?php echo $w->id ?>" change=> <?php

echo $w->text_blk . '<br><br>';
}
?>
</div>










												</div>
											</div>
											<div class="col-md-6">
												<div class="position-relative form-group">
													<label for="studentname" class=""><b><?php echo trans('forms.regular_extra_qualifications'); ?></b>
														<font style="color: red;">*</font></label><br>
                                                   <?php  foreach ($regular_textblocks as $w) { ?>
                                                   <input
														type="checkbox" name="regulartexts[]"
														value=" <?php echo $w->id ?>"> <?php

echo $w->textblock . '<br>';
                                                    $getaddon = \DB::table('regular_extraqualifications')->select('id', 'extra_text', 'corporation_partner', 'text_main_id')
                                                        ->where('text_main_id', $w->id)
                                                        ->get();
                                                    if ($getaddon != '') {
                                                        foreach ($getaddon as $extra) {
                                                            if ($extra->corporation_partner == 0) {
                                                                echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="regularextra[]" value="' . $extra->id . '">&nbsp;&nbsp;<font size="2">' . $extra->extra_text . '</font><br>';
                                                            }
                                                            if ($extra->corporation_partner == 1) {
                                                                echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="regularextra[]" value="' . $extra->id . '">&nbsp;&nbsp;<font size="2">' . $extra->extra_text . '</font><br>';
                                                            }
                                                        }
                                                    }
                                                }
                                                ?>

                                                </div>
											</div>

										</div>

										<div class="col-md-12" id="coachdiv" style="display: none;">
                                                <label for="exampleEmail11" class=""><?php echo trans('forms.select_products_modules'); ?></label>
                                                <div id="treeview_container" class="hummingbird-treeview well h-scroll-large">
                                                    <input type="hidden" name="products_selected" id="selected_products">
                                                    <ul id="treeview-products-1" class="hummingbird-base">

                                                    </ul>
                                                </div>
                                            </div>
										
										<div id="staticblk" style="display: none;">
											<input type="checkbox" name="staticblk[]" value="1"> Wir haben gemeinsam evaluiert, dass die berufliche Zukunft derzeit noch sehr unklar ist und der Kunde gern mit einem Coach daran arbeiten möchte.<br><br>
											<input type="checkbox" name="staticblk[]" value="2"> So sollen Unsicherheiten bzgl. der persönlichen Zukunft abgebaut werden und gleichzeitig eine realistische Vorstellung der beruflichen Zukunft entwickelt werden, die bis hin zum Jobeinstieg durch uns unterstützt wird. 

Der Kunde wünscht sich Unterstützung im Bereich der Erstellung von Bewerbungsunterlagen, der Selbst- & Fremdwahrnehmung inkl. Ressourcenanalyse, Blockaden aufdecken und Selbstsicherheit in Bewerbungsverfahren sowie Unterstützung bei der Weg-Ziel-Planung und das ausloten von neuen Möglichkeiten
<br><br>

										</div>
										
										<div class="row">
											<div class="col-md-6">
												<div class="position-relative form-group">
													<label for="studentname" class=""><?php echo trans('forms.signature_user'); ?><font
														style="color: red;">*</font></label> <select
														class="form-control" name="signature" style="width: 100%;">
                                      <?php  foreach ($signature as $w) { ?>
                                        <option
															value=" <?php echo  $w->id ?>"><?php echo $w->username ?></option>


                                      <?php } ?>



                                    </select>
												</div>
											</div>
											<div class="col-md-6">
												<div class="position-relative form-group">
													<label for="studentname" class=""><?php echo trans('forms.description'); ?><font
														style="color: red;">*</font></label>
													<textarea name="description" class="form-control"></textarea>
												</div>
											</div>
										</div>
										<p class="alert alert-danger contact_error"
											style="display: none;"></p>
										<button type="submit" class="btn btn-primary pull-right"
											style="margin-right: 10px;" id="submit_btn"><?php echo trans('dashboard.generate_pdf'); ?></button>
									</form>
								</div>
							</div>
						</div>
						<br>
						<div class="card-body">
                                            	 <?php if(Session::has('success')) { ?>
                                            <p
								class="alert alert-success"><?php echo Session::get('success'); ?></p>
                                            <?php } ?>
                                                <table
								style="width: 100%;" id="example3"
								class="table table-hover table-striped table-bordered">
								<thead>
									<tr>
										<th><?php echo trans('dashboard.student_name'); ?></th>
										<th><?php echo trans('dashboard.expert_advisor'); ?></th>
										<th><?php echo trans('dashboard.offer_type'); ?></th>
										<th><?php echo trans('dashboard.pdf'); ?></th>
										<th style="max-width: 150px;"><?php echo trans('dashboard.added_on'); ?></th>
										<th><?php echo trans('dashboard.actions'); ?></th>
									</tr>
								</thead>
								<tbody>
                                                        <?php
                                                        if (! empty($offers)) {
                                                            foreach ($offers as $off) {
                                                                ?>
                                                    <tr>
										<td>
                                                           <?php echo $off->name; ?>
                                                        </td>
										<td>
                                                              <?php

$expert = \DB::table('contacts')->select('*')
                                                                    ->where('id', $off->expertadvisor)
                                                                    ->get();
if(isset($expert[0]))
                                                                echo $expert[0]->name;
                                                                ?>
                                                        </td>
                                                        <td style="max-width: 150px;">
                                                           <?php echo ($off->type == 1)?'Unschulung':'Coaching'; ?>  
                                                        </td>
										<td style="max-width: 150px;">
                                                           <?php echo '<a href="'.url('company_files/offers/'.$off->pdf_name).'" target="_blank">PDF ansehen</a>'; ?>  
                                                        </td>
										<td>
                                                           <?php echo date_format(new DateTime($off->created_at),'d.m.Y h:i:s'); ?>
                                                            
                                                        </td>
										<td>
											<form action="" method="post" style="display: inline;">
                                                            <?php echo csrf_field(); ?>
                                                            <input
													type="hidden" name="mail_pdf"
													value="<?php echo $off->id; ?>">
												<button
													class="border-0 btn-transition btn btn-outline-danger"
													>
													<i class="fa fa-envelope"></i>
												</button>
											</form>
											<form action="" method="post" style="display: inline;">
                                                            <?php echo csrf_field(); ?>
                                                            <input
													type="hidden" name="delete"
													value="<?php echo $off->offid; ?>">
												<button
													class="border-0 btn-transition btn btn-outline-danger"
													onclick="return confirm('Do you really want to delete this contract?');">
													<i class="fa fa-trash"></i>
												</button>
											</form>
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

<?php include(app_path() . '/common/panel/footer.php'); ?>


<script src="https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@2.1.7/dist/loadingoverlay.min.js"></script>

<script type="text/javascript"
	src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript"
	src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script type="text/javascript"
	src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/5.8.2/tinymce.min.js"></script>
<script type="text/javascript">
    tinymce.init({
        selector: "textarea",
        themes: "modern",   
        plugins: [
            "advlist autolink lists link image charmap print preview anchor",
            "searchreplace visualblocks code fullscreen",
            "insertdatetime media table contextmenu paste moxiemanager"
        ],
        toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"   
    });
    </script>
<script>

    
    
     $('.calendar').daterangepicker({
        singleDatePicker: true,
        showDropdowns: true,
        startDate: new Date(),
        locale: {
            format: 'DD-MM-YYYY'
        }
    });
    
    	function getblock()
	{

var qualid=$('input[id="qualimainid"]:checked').val();
$("#divblk1").hide();
$("#divblk2").hide();
$("#divblk3").hide();
if(qualid==1)
{
$("#divblk1").show();
$("#divblk2").hide();
$("#divblk3").hide();
         
}
if(qualid==2)
{
$("#divblk1").hide();
$("#divblk2").show();
$("#divblk3").hide();
}
if(qualid==3)
{
$("#divblk1").hide();
$("#divblk2").hide();
$("#divblk3").show();
}
}
    function getdiv()
    {

          $("#regular_id").hide();
            $("#coachdiv").hide();
              $("#staticblk").hide();
       var offertype= $('#offtype').val();
       //  $.LoadingOverlay("show");
     
       if(offertype==1)
       {
          // $("#regular_id").addClass("row");

         $("#regular_id").show();
       }
       
       
       //let id = $(this).val();
      
        //TODO: Retrieve the available recommendations for the selected contact & display in dropdown
        
        if(offertype==2)
       {
          // $("#regular_id").addClass("row");
         $("#coachdiv").show();
         
         

    
       // $("#treeview-products-1").hummingbird();
       
       var studname = document.getElementById('studentname');
       //alert(studname.value);
       
        //Retrieve all the PMI 
        $.ajax({
            
            url: "<?php echo url('admin/get-all-pmi') ?>",
            headers: {
                    'X-CSRF-TOKEN': "<?php echo csrf_token(); ?>"
                },
             data: {
                contact_id: studname.value
            },
            dataType: "json",
            type: 'GET',
            success: function(data) {
           // alert("getdiv() ajax success called");
            //console.log(data.treeview);
            $('.hummingbird-base').html(data.treeview);
              $("#staticblk").show();
                $.LoadingOverlay("hide");
                if (data.success) {
                    $(".hummingbird-base").html(data.treeview);                   
                }
            },
            error: function()  {
                console.log("error happend");
                } 
        });
    }
    
      
    }
       
    
</script>


<?php include(app_path().'/common/panel/prospect_form_header.php'); ?>
<link href="https://www.jqueryscript.net/css/jquerysctipttop.css"
	rel="stylesheet" type="text/css">
<link href="<?php echo url('hummingbird/hummingbird-treeview.css'); ?>"
	rel="stylesheet" type="text/css">
<style>
.hummingbird-treeview * {
	font-size: 18px;
}
.section-title {
	border-top: 1px solid #c0c0c0;
	padding-top: 1rem;
}
</style>



<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script type="text/javascript"
	src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript"
	src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script src="<?php echo url('hummingbird/hummingbird-treeview.js'); ?>"></script>
<script>
$("#treeview").hummingbird();
$( "#checkAll" ).click(function() {
$("#treeview").hummingbird("checkAll");
});
$( "#uncheckAll" ).click(function() {
  $("#treeview").hummingbird("uncheckAll");
});
$( "#collapseAll" ).click(function() {
  $("#treeview").hummingbird("collapseAll");
});
$( "#checkNode" ).click(function() {
  $("#treeview").hummingbird("checkNode",{attr:"id",name: "node-0-2-2",expandParents:false});
});
    
 $("#treeview2").hummingbird();

function item_selected(p_id)
    {
        var old_files=$("#selected_products").val();
        if(old_files!='')
        var files=old_files.split(',');
        else var files=[];
        files.push(p_id);
        var new_files=files.join(',');
        $("#selected_products").val(new_files);
    }
    
    function item_selected2(p_id, m_id)
    {
        var old_files=$("#selected_modules_"+p_id).val();
        if(old_files!='')
        var files=old_files.split(',');
        else var files=[];
        files.push(m_id);
        var new_files=files.join(',');
        $("#selected_modules_"+p_id).val(new_files);
    }
    
    function item_selected12(p_id)
    {
        var old_files=$("#selected_products2").val();
        if(old_files!='')
        var files=old_files.split(',');
        else var files=[];
        files.push(p_id);
        var new_files=files.join(',');
        $("#selected_products2").val(new_files);
    }
    
    function item_selected22(p_id, m_id)
    {
        var old_files=$("#selected_modules2_"+p_id).val();
        if(old_files!='')
        var files=old_files.split(',');
        else var files=[];
        files.push(m_id);
        var new_files=files.join(',');
        $("#selected_modules2_"+p_id).val(new_files);
    }
    
    function select_items(th, checkboxes)
    {
        if($(th).is(':checked')) $(checkboxes).prop('checked', true);
        else $(checkboxes).prop('checked', false);
    }

</script>

