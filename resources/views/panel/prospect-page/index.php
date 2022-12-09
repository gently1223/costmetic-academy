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
<style>
.jay-signature-pad {
	width: 100% !important;
	border: 1px solid #e8e8e8;
	background-color: #fff;
	box-shadow: 0 3px 20px rgba(0, 0, 0, 0.27), 0 0 40px rgba(0, 0, 0, 0.08)
		inset;
	border-radius: 15px;
	padding: 20px;
	padding-left: 0px;
	padding-right: 0px;
}

canvas {
	box-shadow: 0 3px 20px rgba(0, 0, 0, 0.27), 0 0 40px rgba(0, 0, 0, 0.08)
		inset;
}

.txt-center {
	text-align: -webkit-center;
}
</style>

<div class="">
	<div class="tab-content">
		<div class="container-fluid">
			<div class="card mb-3">
				<div id="form-box" style="display: block;">
					<div class="main-card mb-2 card">
						<div class="card-body">
                         <?php if (Session::has('error')) { ?>
                            <p class="alert alert-danger"><?php echo Session::get('error'); ?></p>
                        <?php } ?>
                        <?php if (Session::has('success')) { ?>
                            <p class="alert alert-success"><?php echo Session::get('success'); ?></p>
                        <?php }  ?>
                            <h5 class="card-title"
								style="text-transform: none;"><?php if(isset($is_prospect_sign_page)) echo trans('forms.welcome_new_customer'); else echo trans('forms.add_prospect'); ?></h5>
							<form class=""
								action="<?php if(isset($is_prospect_sign_page)) echo "/new_prospect_page"; ?>"
								method="post" onsubmit="return check_data3();" id="form_box"
								enctype="multipart/form-data">
                                        <?php echo csrf_field(); ?>
								<div class="form-row">
									<!-- Welcome new customer || Herzlich Wilkommen Neukunde -->
									<h5 class="section-title col-md-12"><?php echo trans('forms.welcome_new_customer'); ?></h5>
									<div class="col-md-6" id="interest_field">
										<div class="position-relative form-group">
											<label for="examplePassword11" class=""
												style="display: block;"><?php echo trans('forms.interested_party_for'); ?> <font
												style="color: red;">*</font></label> <input type="radio"
												class="" name="voucher_type"
												<?php if(isset($is_prospect_sign_page)) echo 'disabled';?>
												value="avgs"
												<?php if(isset($contact_addl_row)) { if($contact_addl_row->voucher_type == "avgs") echo 'checked'; }?>>&nbsp;<?php echo trans('forms.avgs'); ?>&nbsp;&nbsp;<input
												type="radio" class="" name="voucher_type" value="bgs"
												<?php if(isset($is_prospect_sign_page)) echo 'disabled';?>
												<?php if(isset($contact_addl_row)) { if($contact_addl_row->voucher_type == "bgs") echo 'checked'; } else {  echo 'checked';}?>>&nbsp;<?php echo trans('forms.bgs'); ?>  
										</div>
									</div>
									<div class="col-md-6" id="created_on">
										<div class="position-relative form-group">
											<label for="examplePassword11" class=""><?php echo trans('forms.date'); ?> <font
												style="color: red;">*</font></label> <input type="text"
												class="form-control today_calendar required"
												name="created_on" required id="created_on_field"
												<?php if(isset($is_prospect_sign_page)) echo 'disabled';?>
												<?php if(isset($contact_row)) { echo "value='" . date_format(new DateTime($contact_row->created_on),'d-m-Y') . "'"; }?>>
										</div>
									</div>
									<div class="col-md-6" id="consultant_name">
										<div class="position-relative form-group ss-item-required">
											<label for="examplePassword11" class=""><?php echo trans('forms.consultant_name'); ?> <font
												style="color: red;">*</font></label> <input
												name="consultant_name" type="text"
												class="form-control requried" required
												id="consultant_name_field"
												<?php if(isset($is_prospect_sign_page)) echo 'disabled';?>
												<?php if(isset($contact_addl_row)) { echo "value='$contact_addl_row->consultant_name'"; }?>>
										</div>
									</div>
									<div class="col-md-6">
										<div class="position-relative form-group">
											<label for="exampleEmail1177" class=""><?php echo trans('forms.referral_source_title'); ?></label>
											<select name="referral_source" class="form-control"
												id="referral_source">
												<option value=""><?php echo trans('forms.please_select'); ?></option>
                                                <?php
                                                if (isset($contact_row) && ! empty($contact_row->referral_source)) {
                                                    $referral_source = $contact_row->referral_source;
                                                }
                                                if (! empty($referral_sources)) {
                                                    foreach ($referral_sources as $source) {
                                                        ?>
                                                <option
													value="<?php echo $source->name; ?>"
													<?php if(isset($referral_source) && $referral_source == $source->name) echo 'selected'; ?>><?php echo $source->name; ?></option>
                                                <?php } } ?>
                                            </select>
										</div>
									</div>

									<!-- Personliche Daten des Kunden || How did you hear about us: -->
									<h5 class="section-title col-md-12"><?php echo trans('forms.hear_about_us'); ?></h5>
									<div class="col-md-3" id="first_name">
										<div class="position-relative form-group ss-item-required">
											<label for="exampleEmail11" class=""><?php echo trans('forms.first_name'); ?> <font
												style="color: red;">*</font></label> <input
												name="first_name" id="first_name_field" type="text"
												class="form-control required" required
												<?php if(isset($contact_row) && !empty($contact_row->name)) { $first_name = explode(' ', $contact_row->name)[0]; echo "value='$first_name'"; }?>>
										</div>
									</div>
									<div class="col-md-3" id="last_name">
										<div class="position-relative form-group ss-item-required">
											<label for="exampleEmail11" class=""><?php echo trans('forms.last_name'); ?> <font
												style="color: red;">*</font></label> <input name="last_name"
												id="last_name_field" type="text"
												class="form-control required" required
												<?php if(isset($contact_row) && !empty($contact_row->name) && sizeof(explode(' ', $contact_row->name)) > 1) { $last_name = explode(' ', $contact_row->name)[1]; echo "value='$last_name'"; }?>>
										</div>
									</div>
									<div class="col-md-3" id="dob">
										<div class="position-relative form-group ss-item-required">
											<label for="examplePassword11" class=""><?php echo trans('forms.birthday'); ?> <font
												style="color: red;">*</font></label> <input type="text"
												class="form-control today_calendar required" name="dob"
												required id="dob_field"
												<?php if(isset($contact_row)) { $dob = $contact_row->dob; $dob = date_format(new DateTime($dob),'d-m-Y'); echo "value=$dob"; }?>>
										</div>
									</div>
									<div class="col-md-3" id="gender_div">
										<div class="position-relative form-group ss-item-required">
											<label for="exampleEmail11" class=""><?php echo trans('forms.gender'); ?> <font
												style="color: red;">*</font></label>
                                                     <?php

                                                    if (isset($contact_row) && ! empty($contact_row->gender)) {
                                                        $gender = $contact_row->gender;
                                                    }
                                                    ?>
                                                
                                                        <select
												name="gender" id="gender" type="text"
												class="form-control required" required>
												<option value=""><?php echo trans('forms.please_select'); ?></option>

												<option value="Male"
													<?php if(isset($gender) && $gender == "Male") echo 'selected'; ?>><?php echo trans('forms.male'); ?></option>

												<option value="Female"
													<?php if(isset($gender) && $gender == "Female") echo 'selected'; ?>><?php echo trans('forms.female'); ?></option>

												<option value="Neutral"
													<?php if(isset($gender) && $gender == "Neutral") echo 'selected'; ?>><?php echo trans('forms.neutral'); ?></option>
											</select>
										</div>
									</div>

									<div class="col-md-3" id="street_name">
										<div class="position-relative form-group ss-item-required">
											<label for="exampleEmail11" class=""><?php echo trans('forms.street_name'); ?> <font
												style="color: red;">*</font></label> <input
												name="street_name" type="text" class="form-control required"
												required id="street_name_field"
												<?php if(isset($contact_row)) { echo "value='$contact_row->street_name'"; }?>>
										</div>
									</div>
									<div class="col-md-3" id="door_no">
										<div class="position-relative form-group ss-item-required">
											<label for="exampleEmail11" class=""><?php echo trans('forms.door_no'); ?> <font
												style="color: red;">*</font></label> <input name="door_no"
												id="door_no_field" type="text" class="form-control required"
												required
												<?php if(isset($contact_row)) { echo "value='$contact_row->door_no'"; }?>>
										</div>
									</div>
									<div class="col-md-3" id="zip_code">
										<div class="position-relative form-group ss-item-required">
											<label for="exampleEmail11" class=""><?php echo trans('forms.zip_code'); ?> <font
												style="color: red;">*</font></label> <input name="zip_code"
												type="text" class="form-control required" required
												id="zip_code_field"
												<?php if(isset($contact_row)) { echo "value='$contact_row->zip_code'"; }?>>
										</div>
									</div>
									<div class="col-md-3" id="city">
										<div class="position-relative form-group ss-item-required">
											<label for="exampleEmail11" class=""><?php echo trans('forms.city'); ?> <font
												style="color: red;">*</font></label> <input name="city"
												id="city_field" type="text" class="form-control required"
												required
												<?php if(isset($contact_row)) { echo "value='$contact_row->city'"; }?>>
										</div>
									</div>
									<div class="col-md-3" id="phone_no">
										<div class="position-relative form-group ss-item-required">
											<label for="examplePassword11" class=""><?php echo trans('forms.phone_no'); ?> <font
												style="color: red;">*</font></label> <input name="phone_no"
												type="text" class="form-control requried" required
												id="mobile_field"
												<?php if(isset($contact_row)) { echo "value='$contact_row->phone_no'"; }?>>
										</div>
									</div>
									<div class="col-md-3" id="email">
										<div class="position-relative form-group ss-item-required">
											<label for="examplePassword11" class=""><?php echo trans('forms.email'); ?> <font
												style="color: red;">*</font></label> <input name="email"
												type="email" class="form-control requried" required
												id="email_field" onchange="check_email(this)"
												<?php if(isset($contact_row)) { echo "value='$contact_row->email' disabled"; }?>>
											<p class="alert alert-danger"
												style="position: absolute; right: 0px; top: 0px; padding-top: 0px; padding-bottom: 0px; display: none;"
												id="email-error">Email already exists.</p>
										</div>
									</div>
									<!-- Persónliche Situation || Personal Situation -->
									<h5 class="section-title col-md-12"><?php echo trans('forms.person_situation'); ?></h5>
									<div class="col-md-6" id="own_house">
										<div class="position-relative form-group ss-item-required">
											<label for="examplePassword11" class=""
												style="display: block;"><?php echo trans('forms.own_house'); ?> <font
												style="color: red;">*</font></label> <input type="radio"
												class="" name="own_house" value="1"
												<?php if(isset($contact_addl_row)) { if($contact_addl_row->own_house == "1") echo 'checked'; } ?>>&nbsp;<?php echo trans('forms.yes'); ?>&nbsp;&nbsp;<input
												type="radio" class="" name="own_house" value="0"
												<?php if(isset($contact_addl_row)) { if($contact_addl_row->own_house == "0") echo 'checked'; } else { echo 'checked'; } ?>>&nbsp;<?php echo trans('forms.no'); ?>  
										</div>
									</div>
									<div class="col-md-6">
										<div class="position-relative form-group ss-item-required">
											<label for="exampleEmail11" class=""><?php echo trans('forms.marital_status'); ?> <font
												style="color: red;">*</font></label> <select
												name="marital_status" id="marital_status" type="text"
												class="form-control" required>
												<option value=""><?php echo trans('forms.please_select'); ?></option>

												<option value="Single"
													<?php if(isset($contact_row) && isset($contact_row->marital_status) && $contact_row->marital_status == "Single") { echo 'selected';  }  ?>><?php echo trans('forms.single'); ?></option>
												<option value="Married"
													<?php if(isset($contact_row) && isset($contact_row->marital_status) && $contact_row->marital_status == "Married") { echo 'selected';  }  ?>><?php echo trans('forms.married'); ?></option>
												<option value="Widow"
													<?php if(isset($contact_row) && isset($contact_row->marital_status) && $contact_row->marital_status == "Widow") { echo 'selected';  }  ?>><?php echo trans('forms.widow') ?></option>
												<option value="Unknown"
													<?php if(isset($contact_row) && isset($contact_row->marital_status) && $contact_row->marital_status == "Unknown") { echo 'selected';  }  ?>><?php echo trans('forms.unknown') ?></option>
											</select>
										</div>
									</div>
									<div class="col-md-3" id="kids_counter">
										<div class="position-relative form-group">
											<label for="examplePassword11" class=""><?php echo trans('forms.kids_counter'); ?> </label>
											<input name="kids_counter" type="number" class="form-control"
												id="kids_counter_field" value="kids_counter"
												<?php if(isset($contact_addl_row)) { echo "value='$contact_addl_row->kids_count'"; }?>>
										</div>
									</div>
									<div class="col-md-3" id="kids_age">
										<div class="position-relative form-group">
											<label for="examplePassword11" class=""><?php echo trans('forms.kids_age') ?> </label>
											<input name="kids_age" type="text" class="form-control "
												id="kids_age_field"
												<?php if(isset($contact_addl_row)) { echo "value='$contact_addl_row->kids_age'"; }?>>
										</div>
									</div>
									<div class="col-md-6" id="child_care">
										<div class="position-relative form-group">
											<label for="examplePassword11" class=""><?php echo trans('forms.child_care') ?> </label>
											<input name="child_care" type="text" class="form-control "
												id="child_care_field"
												<?php if(isset($contact_row)) { echo "value='$contact_row->child_care'"; }?>>
										</div>
									</div>

									<!-- Bildungshistorie || Educational History -->
									<h5 class="section-title col-md-12"><?php echo trans('forms.education_history') ?></h5>
									<div class="col-md-6" id="school_education">
										<div class="position-relative form-group">
											<label for="examplePassword11" class=""><?php echo trans('forms.school_education') ?> </label>
											<input name="school_education" type="text"
												class="form-control " id="school_education"
												<?php if(isset($contact_addl_row)) { echo "value='$contact_addl_row->school_education'"; }?>>
										</div>
									</div>
									<div class="col-md-6" id="internship">
										<div class="position-relative form-group">
											<label for="examplePassword11" class=""><?php echo trans('forms.internship') ?> </label>
											<input name="internship" type="text" class="form-control"
												id="internship"
												<?php if(isset($contact_addl_row)) { echo "value='$contact_addl_row->internship'"; }?>>
										</div>
									</div>
									<div class="col-md-6" id="graduation">
										<div class="position-relative form-group">
											<label for="examplePassword11" class=""><?php echo trans('forms.graduation') ?> </label>
											<input name="graduation" type="text" class="form-control"
												id="graduation"
												<?php if(isset($contact_addl_row)) { echo "value='$contact_addl_row->graduation'"; }?>>
										</div>
									</div>
									<div class="col-md-6" id="professional_qualification">
										<div class="position-relative form-group">
											<label for="examplePassword11" class=""><?php echo trans('forms.professional_qualification') ?></label>
											<input name="professional_qualification" type="text"
												class="form-control" id="professional_qualification"
												<?php if(isset($contact_row)) { echo "value='$contact_row->professional_qualifications'"; }?>>
										</div>
									</div>

									<div class="col-md-3" id="language_course_undertaken">
										<div class="position-relative form-group ss-item-required">
											<label for="examplePassword11" class=""
												style="display: block;"><?php echo trans('forms.language_course_undertaken'); ?> <font
												style="color: red;">*</font></label> <input type="radio"
												class="" name="language_course_undertaken" value="1"
												<?php if(isset($contact_addl_row)) { if($contact_addl_row->language_course_undertaken == "1") echo 'checked'; } else { echo 'checked'; } ?>>&nbsp;<?php echo trans('forms.yes') ?>&nbsp;&nbsp;<input
												type="radio" class="" name="language_course_undertaken"
												value="0"
												<?php if(isset($contact_addl_row)) { if($contact_addl_row->language_course_undertaken == "0") echo 'checked'; } ?>>&nbsp;<?php echo trans('forms.no') ?>  
										</div>
									</div>
									<div class="col-md-3" id="german_level">
										<div class="position-relative form-group ss-item-required">
											<label for="examplePassword11" class=""
												style="display: block;"><?php echo trans('forms.german_level'); ?> <font
												style="color: red;">*</font></label> <input type="radio"
												class="" name="german_level" value="B1"
												<?php if(isset($contact_addl_row)) { if($contact_addl_row->german_level == "B1") echo 'checked'; } else { echo 'checked'; } ?>>&nbsp;B1&nbsp;&nbsp;<input
												type="radio" class="" name="german_level" value="B2"
												<?php if(isset($contact_addl_row)) { if($contact_addl_row->german_level == "B2") echo 'checked'; } ?>>&nbsp;B2&nbsp;&nbsp;<input
												type="radio" class="" name="german_level" value="Native"
												<?php if(isset($contact_addl_row)) { if($contact_addl_row->german_level == "Native") echo 'checked'; }  ?>>&nbsp;Muttersprache
										</div>
									</div>
									<div class="col-md-6" id="other_language">
										<div class="position-relative form-group">
											<label for="examplePassword11" class=""><?php echo trans('forms.other_language') ?> </label>
											<input name="other_language" type="text" class="form-control"
												id="other_language_field"
												<?php if(isset($contact_addl_row)) { echo "value='$contact_addl_row->other_languages'"; }?>>
										</div>
									</div>
									<div class="col-md-6" id="employment_history">
										<div class="position-relative form-group">
											<label for="examplePassword11" class=""><?php echo trans('forms.employment_history') ?> </label>
											<textarea class="form-control" name="employment_history"
												id="employment_history_field" cols="4" rows="5"><?php if(isset($contact_row)) { echo $contact_row->professional_qualifications; }?></textarea>

										</div>
									</div>
									<!-- Massnahmen historie -->
									<h5 class="section-title col-md-12"><?php echo trans('forms.massnahme_history') ?></h5>

									<div class="col-md-6">
										<div class="position-relative form-group ss-item-required">
											<label for="exampleEmail11" class=""><?php echo trans('forms.funding_source'); ?> <font
												style="color: red;">*</font></label> <select
												name="funding_source" id="funding_source"
												<?php  if(isset($contact_row) && !empty($contact_row->funding_source)) { echo "disabled"; } ?>
												type="text" class="form-control">
												<option value=""><?php echo trans('forms.please_select'); ?></option>
                                                    <?php
                                                    if (! empty($funding_sources)) {
                                                        foreach ($funding_sources as $source) {
                                                            ?>
                                                    <option
													value="<?php echo $source->id; ?>"
													<?php  if(isset($contact_row)) { $funding_source = $contact_row->funding_source; }  if(isset($funding_source) && $funding_source == $source->id) echo 'selected'; ?>><?php echo $source->name; ?></option>
                                                    <?php } } ?>                                           
                                                </select>
										</div>
									</div>
									<div class="col-md-6" id="employment_name">
										<div class="position-relative form-group ss-item-required">
											<label for="examplePassword11" class=""><?php echo trans('forms.employment_name'); ?> <font
												style="color: red;">*</font></label> <input
												name="employment_name" type="text"
												class="form-control required" required
												id="employment_name_field"
												<?php if(isset($contact_addl_row)) { echo "value='$contact_addl_row->employment_agency_name' disabled"; }?>>
										</div>
									</div>
									<div class="col-md-6" id="tel_email_intermediary">
										<div class="position-relative form-group ss-item-required">
											<label for="examplePassword11" class=""><?php echo trans('forms.tel_email_intermediary'); ?> <font
												style="color: red;">*</font></label> <input
												name="tel_email_intermediary" type="text"
												class="form-control required" required
												id="tel_email_intermediary_field"
												<?php if(isset($contact_addl_row)) { echo "value='$contact_addl_row->employment_agency_telno' disabled"; }?>>
										</div>
									</div>
									<div class="col-md-6" id="customer_no">
										<div class="position-relative form-group ss-item-required">
											<label for="examplePassword11" class=""><?php echo trans('forms.customer_no'); ?> <font
												style="color: red;">*</font></label> <input
												name="customer_no" type="text" class="form-control required"
												required id="customer_no_field"
												<?php if(isset($contact_row)) { echo "value='$contact_row->customer_no' disabled"; }?>>
										</div>
									</div>
									<div class="col-md-6" id="registration_date">
										<div class="position-relative form-group ss-item-required">
											<label for="examplePassword11" class=""><?php echo trans('forms.registration_date'); ?> <font
												style="color: red;">*</font></label> <input
												name="registration_date" type="text"
												class="form-control today_calendar requried" required
												id="registration_date_field"
												<?php if(isset($contact_addl_row)) { $registration_date = $contact_addl_row->registration_date; $registration_date = date_format(new DateTime($registration_date),'d-m-Y'); echo "value='$registration_date' disabled"; }?>>
										</div>
									</div>
									<div class="col-md-6" id="participation_in_massnahmen">
										<div class="position-relative form-group ss-item-required">
											<label for="examplePassword11" class=""
												style="display: block;"><?php echo trans('forms.participation_in_massnahmen'); ?> <font
												style="color: red;">*</font></label> <input type="radio"
												class="" name="participation_in_massnahmen" value="1"
												<?php if(isset($contact_addl_row)) {if($contact_addl_row->participation_in_massnahmen == "1")  echo "checked disabled"; } else { echo "checked"; }?>>&nbsp;<?php echo trans('forms.yes'); ?>&nbsp;&nbsp;<input
												type="radio" class="" name="participation_in_massnahmen"
												value="0"
												<?php if(isset($contact_addl_row)) { echo "disabled "; if($contact_addl_row->participation_in_massnahmen == "0") echo "checked"; }?>>&nbsp;<?php echo trans('forms.no'); ?>  
										</div>
									</div>


									<div class="col-md-6" id="massnahmen_details">
										<div class="position-relative form-group ss-item-required">
											<label for="examplePassword11" class=""><?php echo trans('forms.massnahmen_details') ?> <font
												style="color: red;">*</font></label> <input
												name="massnahmen_details" type="text"
												class="form-control required" required
												id="massnahmen_details_field"
												<?php if(isset($contact_addl_row)) { echo "value='$contact_addl_row->massnahmen_details' disabled"; }?>>
										</div>
									</div>
									<div class="col-md-6" style="display: block;">
										<div class="position-relative form-group">
											<label for="examplePassword11" class=""><?php echo trans('forms.next_appt_with_funding_source'); ?>
                                                </label> <input
												name="next_appt_with_funding_source" type="text"
												class="form-control today_calendar"
												id="next_appt_with_funding_source_field"
												<?php if(isset($contact_addl_row)) { $registration_date = $contact_addl_row->next_appt_with_funding_source; $registration_date = date_format(new DateTime($registration_date),'d-m-Y'); echo "value=$registration_date"; }?>>
										</div>
									</div>
									<!-- Technische ausstattung -->
									<h5 class="section-title col-md-12"><?php echo trans('forms.technical_history') ?></h5>

									<div class="col-md-6" id="have_internet">
										<div class="position-relative form-group">
											<label for="examplePassword11" class=""
												style="display: block;"><?php echo trans('forms.have_internet'); ?> <font
												style="color: red;">*</font></label> <input type="radio"
												class="" name="have_internet" value="1"
												<?php if(isset($contact_addl_row)) {if($contact_addl_row->have_internet == "1")  echo "checked"; } else { echo "checked"; }?>>&nbsp;Ja&nbsp;&nbsp;<input
												type="radio" class="" name="have_internet" value="0"
												<?php if(isset($contact_addl_row)) {if($contact_addl_row->have_internet == "0")  echo "checked"; } ?>>Nein

										</div>
									</div>
									<div class="col-md-6" id="internet_enabled_media">
										<div class="position-relative form-group">
											<label for="examplePassword11" class=""
												style="display: block;"><?php echo trans('forms.internet_media') ?> </label>
											<input type="checkbox" class="" name="know_smartphone"
												value="1"
												<?php if(isset($contact_addl_row)) {if($contact_addl_row->know_smartphone == "1")  echo "checked"; }?>>&nbsp;
											<font><?php echo trans('forms.know_smartphone') ?></font>&nbsp;&nbsp;
											<input type="checkbox" class="" name="know_laptop" value="1"
												<?php if(isset($contact_addl_row)) {if($contact_addl_row->know_laptop == "1")  echo "checked"; }?>>&nbsp;
											<font><?php echo trans('forms.know_laptop') ?></font>
											&nbsp;&nbsp; <input type="checkbox" class=""
												name="know_tablet" value="1"
												<?php if(isset($contact_addl_row)) {if($contact_addl_row->know_tablet == "1")  echo "checked"; }?>>
											&nbsp;<font><?php echo trans('forms.know_tablet') ?></font>
										</div>
									</div>

									<div class="col-md-6" id="know_online_tools">
										<div class="position-relative form-group">
											<label for="examplePassword11" class=""
												style="display: block;"><?php echo trans('forms.know_online_tools'); ?> <font
												style="color: red;">*</font></label> <input type="radio"
												name="know_online_tools" class="" value="1"
												<?php if(isset($contact_addl_row)) {if($contact_addl_row->know_online_tools == "1")  echo "checked"; } else { echo "checked"; }?>>&nbsp;Ja&nbsp;&nbsp;<input
												type="radio" class="" name="know_online_tools" value="0"
												<?php if(isset($contact_addl_row)) {if($contact_addl_row->know_online_tools == "0")  echo "checked"; } ?>>&nbsp;Nein
										</div>
									</div>
									<!--  Gesundheit -->
									<h5 class="section-title col-md-12"><?php echo trans('forms.health_history') ?></h5>

									<div class="col-md-6" id="have_health_issues">
										<div class="position-relative form-group">
											<label for="examplePassword11" class=""
												style="display: block;"><?php echo trans('forms.have_health_issues'); ?>  <font
												style="color: red;">*</font></label> <input type="radio"
												name="have_health_issues" class="" value="1"
												<?php if(isset($contact_addl_row)) {if($contact_addl_row->have_health_issues == "1")  echo "checked"; } ?>>&nbsp;Ja&nbsp;&nbsp;<input
												type="radio" class="" name="have_health_issues" value="0"
												<?php if(isset($contact_addl_row)) {if($contact_addl_row->have_health_issues == "0")  echo "checked"; } else { echo "checked"; }?>>&nbsp;Nein
										</div>
									</div>
									<div class="col-md-6" id="therapy_experience">
										<div class="position-relative form-group">
											<label for="examplePassword11" class=""
												style="display: block;"><?php echo trans('forms.therapy_experience'); ?> <font
												style="color: red;">*</font></label> <input type="radio"
												name="therapy_experience" class="" value="1"
												<?php if(isset($contact_addl_row)) {if($contact_addl_row->therapy_experience == "1")  echo "checked"; } ?>>&nbsp;Ja&nbsp;&nbsp;<input
												type="radio" class="" name="therapy_experience" value="0"
												<?php if(isset($contact_addl_row)) {if($contact_addl_row->therapy_experience == "0")  echo "checked"; } else { echo "checked"; }?>>&nbsp;Nein
										</div>
									</div>
									<div class="col-md-6" id="corona_vaccinnated">
										<div class="position-relative form-group">
											<label for="examplePassword11" class=""
												style="display: block;"><?php echo trans('forms.corona_vaccinnated'); ?>  <font
												style="color: red;">*</font></label> <input type="radio"
												name="corona_vaccinnated" class="" value="1"
												<?php if(isset($contact_addl_row)) {if($contact_addl_row->corona_vaccinnated == "1")  echo "checked"; } else { echo "checked"; }?>>&nbsp;Ja&nbsp;&nbsp;<input
												type="radio" class="" name="corona_vaccinnated" value="0"
												<?php if(isset($contact_addl_row)) {if($contact_addl_row->corona_vaccinnated == "0")  echo "checked"; } ?>>&nbsp;Nein
										</div>
									</div>
									<div class="col-md-6" id="undertaking_treatment">
										<div class="position-relative form-group">
											<label for="examplePassword11" class=""
												style="display: block;"><?php echo trans('forms.undertaking_treatment'); ?> <font
												style="color: red;">*</font></label> <input type="radio"
												name="undertaking_treatment" class="" value="1"
												<?php if(isset($contact_addl_row)) {if($contact_addl_row->undertaking_treatment == "1")  echo "checked"; } ?>>&nbsp;Ja&nbsp;&nbsp;<input
												type="radio" class="" name="undertaking_treatment" value="0"
												<?php if(isset($contact_addl_row)) {if($contact_addl_row->undertaking_treatment == "0")  echo "checked"; } else { echo "checked"; }?>>&nbsp;Nein
										</div>
									</div>
									<!--  Massnahmen suggestion-->
									<h5 class="section-title col-md-12"><?php echo trans('forms.suggested_massnahmen') ?></h5>

									<div class="col-md-6">
										<div class="position-relative form-group ss-item-required">
											<label for="examplePassword11" class=""><?php echo trans('forms.recommended_measures'); ?> <font
												style="color: red;">*</font></label> <input
												name="recommended_measures" type="text"
												class="form-control required" required
												id="recommended_measures_field"
												<?php if(isset($contact_addl_row)) { echo "value='$contact_addl_row->recommended_measures' disabled"; }?>>
										</div>
									</div>
									<div class="col-md-6" style="display: block;">
										<div class="position-relative form-group">
											<label for="examplePassword11" class=""><?php echo trans('forms.planned_start_date'); ?> 
                                                </label> <input
												name="planned_start_date" type="text"
												class="form-control today_calendar"
												id="planned_start_date_field"
												<?php if(isset($contact_addl_row)) { $registration_date = $contact_addl_row->planned_start_date; $registration_date = date_format(new DateTime($registration_date),'d-m-Y'); echo "value='$registration_date' disabled"; }?>>
										</div>
									</div>
									<div class="col-md-4" id="hybrid_teachingmethod">
										<div class="position-relative form-group">
											<label for="examplePassword11" class=""
												style="display: block;"><?php echo trans('forms.hybrid_teachingmethod'); ?> <font
												style="color: red;">*</font></label> <input type="radio"
												class="" name="hybrid_teachingmethod" value="1"
												<?php if(isset($contact_addl_row)) {if($contact_addl_row->hybrid_teachingmethod == "1")  echo "checked"; } else { echo "checked"; }?>>&nbsp;Ja&nbsp;&nbsp;<input
												type="radio" class="" name="hybrid_teachingmethod" value="0"
												<?php if(isset($contact_addl_row)) {if($contact_addl_row->hybrid_teachingmethod == "0")  echo "checked"; } ?>>&nbsp;Nein
										</div>
									</div>
									<div class="col-md-4" id="online_teachingmethod">
										<div class="position-relative form-group">
											<label for="examplePassword11" class=""
												style="display: block;"><?php echo trans('forms.online_teachingmethod'); ?> <font
												style="color: red;">*</font></label> <input type="radio"
												class="" name="online_teachingmethod" value="1"
												<?php if(isset($contact_addl_row)) {if($contact_addl_row->online_teachingmethod == "1")  echo "checked"; } else { echo "checked"; }?>>&nbsp;Ja&nbsp;&nbsp;<input
												type="radio" class="" name="online_teachingmethod" value="0"
												<?php if(isset($contact_addl_row)) {if($contact_addl_row->online_teachingmethod == "0")  echo "checked"; } ?>>&nbsp;Nein
										</div>
									</div>
									<div class="col-md-4" id="presence_teachingmethod">
										<div class="position-relative form-group">
											<label for="examplePassword11" class=""
												style="display: block;"><?php echo trans('forms.presence_teachingmethod'); ?>  <font
												style="color: red;">*</font></label> <input type="radio"
												class="" name="presence_teachingmethod" value="1"
												<?php if(isset($contact_addl_row)) {if($contact_addl_row->presence_teachingmethod == "1")  echo "checked"; } else { echo "checked"; }?>>&nbsp;Ja&nbsp;&nbsp;<input
												type="radio" class="" name="presence_teachingmethod"
												value="0"
												<?php if(isset($contact_addl_row)) {if($contact_addl_row->presence_teachingmethod == "0")  echo "checked"; } ?>>&nbsp;Nein
										</div>
									</div>

									<div class="col-md-12" id="notes_div">
										<div class="position-relative form-group">
											<label for="examplePassword11" class=""
												style="display: block;"><?php echo trans('forms.weiteres'); ?></label>
											<textarea class="form-control" name="notes" id="notes"
												cols="4" rows="5"><?php if(isset($contact_row)) { echo $contact_row->notes; }?></textarea>
										</div>
									</div>
                                    
                                    <?php if(!isset($is_prospect_sign_page)) {  ?>
                                    <div class="col-md-12">
										<div id="accordion12" class="accordion-wrapper mb-3">
											<div class="">
												<div id="headingOne12" class="card-header"
													style="background: #E2E2E0;">
													<button type="button" data-toggle="collapse"
														data-target="#collapseOne112" aria-expanded="false"
														aria-controls="collapseOne"
														class="text-left m-0 p-0 btn btn-link btn-block collapsed">
														<h5 class="m-0 p-0" style="font-size: 18px;"><?php echo trans('forms.select_products_modules'); ?></h5>
													</button>
												</div>
												<div data-parent="#accordion12" id="collapseOne112"
													aria-labelledby="headingOne12" class="collapse" style="">
													<div class="card-body" id="product-modules-container"
														style="overflow-x: auto;">
														<input type="hidden" name="products_selected"
															id="selected_products">

														<div id="treeview_container"
															class="hummingbird-treeview well h-scroll-large">
															<ul id="treeview2" class="hummingbird-base">
                                                                    <?php
                                        $node = '';
                                        if (! empty($products)) {
                                            $in = 0;
                                            foreach ($products as $p) {
                                                $p_id = $p['product']->id;

                                                if ($in ++ != 0)
                                                    $node .= ',';
                                                $node .= '{ "id": "p-' . $p_id . '", "text": "' . $p['product']->title . '", "children": [';
                                                ?>
                                                                    <input
																	type="hidden"
																	name="modules_selected_<?php echo $p_id; ?>"
																	id="selected_modules_<?php echo $p_id; ?>">

																<li><i class="fa fa-plus"></i> <label> <input
																		type="checkbox"
																		class="mp-<?php echo $p['product']->id; ?>"
																		name="products[]"
																		value="<?php echo $p['product']->id; ?>"
																		onchange="select_items(this, '.p-<?php echo $p['product']->id; ?>')"
																		id="p-<?php echo $p_id; ?>"
																		data-id="cp2-<?php echo $p_id; ?>"
																		onclick="item_selected('<?php echo $p_id; ?>')">
                                                                        
                                                                        <?php echo $p['product']->title.' ('.trans('forms.lessons').': '.$p['total_lessons'].' '.trans('forms.total_cost').': €'.$p['total_cost'].')'; ?>
                                                                        </label>

																	<ul>
                                                                        <?php
                                                if (! empty($p['modules'])) {
                                                    $in2 = 0;
                                                    foreach ($p['modules'] as $m) {
                                                        $m_id = $m['module']->id;

                                                        if ($in2 ++ != 0)
                                                            $node .= ',';
                                                        $node .= '{ "id": "m-' . $m_id . '", "text": "' . $m['module']->title . '", "children": [';
                                                        ?>
                                                                    <li>
																			<i class="fa fa-plus"></i> <label> <input
																				type="checkbox"
																				class="p-<?php echo $p['product']->id; ?>"
																				name="modules<?php echo $p_id; ?>[]"
																				value="<?php echo $m['module']->id; ?>"
																				onchange="select_items(this, '.m-<?php echo $m['module']->id; ?>')"
																				id="m-<?php echo $m_id; ?>"
																				data-id="cm2-<?php echo $m_id; ?>"
																				onclick="item_selected('<?php echo $p_id; ?>'); item_selected2('<?php echo $p_id; ?>', '<?php echo $m_id; ?>')">
																		</label>
                                                                        
                                                                        <?php echo $m['module']->title.' ('.trans('forms.lessons').': '.$m['total_lessons'].' '.trans('forms.total_cost').': €'.$m['total_cost'].')'; ?>
                                                                        
                                                                        <ul>
                                                                            <?php
                                                        if (! empty($m['items'])) {
                                                            $in3 = 0;
                                                            foreach ($m['items'] as $item) {
                                                                $mi_id = $item['item']->id;

                                                                if ($in3 ++ != 0)
                                                                    $node .= ',';
                                                                $node .= '{ "id": "mi-' . $mi_id . '", "text": "' . $item['item']->title . '" }';
                                                                ?>
                                                                    <li>

																					<label> <input type="checkbox"
																						class="p-<?php echo $p['product']->id; ?> m-<?php echo $m['module']->id; ?>"
																						name="items<?php echo $m['module']->id; ?>[]"
																						value="<?php echo $item['item']->id; ?>"
																						id="mi-<?php echo $mi_id; ?>"
																						data-id="cmi2-<?php echo $mi_id; ?>"
																						onclick="item_selected('<?php echo $p_id; ?>'); item_selected2('<?php echo $p_id; ?>', '<?php echo $m_id; ?>')">
                                                                        
                                                                        <?php echo $item['item']->title; ?>
                                                                        </label>
                                                                        
                                                                        <?php echo ' ( '.trans('forms.lessons').': <input type="number" name="lessons'.$item['item']->id.'" value="'.$item['item']->lessons.'" style="max-width:60px; padding-top:0px; padding-bottom:0px;" min="0" max="'.$item['item']->lessons.'" required> '.trans('forms.price_lesson').': € <input type="number" name="prices'.$item['item']->id.'" value="'.$item['item']->price_lessons.'" style="max-width:60px; padding-top:0px; padding-bottom:0px;" required min="0" step="any"> )'; ?></li>
                                                                        <?php } } ?>
                                                                        </ul>
																		</li>
                                                                        <?php $node.=' ]}'; } } ?>
                                                                        
                                                                    </ul>
																</li>
																<!--<li style="list-style-type:none; padding-bottom:25px;"></li>-->
                                                                    <?php $node.=' ] }'; } } ?>
                                                                </ul>
														</div>

													</div>
												</div>
											</div>
										</div>
									</div>
                                   <?php }  ?>
                                    <div class="col-12 col-md-12">
										<div id="pdfRenderer"></div>
									</div>

									<div class="col-12 col-md-12 mb-4">
										<div class="position-relative form-group">
											<label for="exampleEmail11" class=""><?php echo trans('forms.signature'); ?></label>
											<input type="hidden" name="signature" id="signature" value="">
											<div id="signature-pad" class="jay-signature-pad">
												<div class="jay-signature-pad--body">
													<center>
														<canvas id="jay-signature-pad"></canvas>
													</center>
												</div>
												<div class="signature-pad--footer txt-center mt-2">
													<div class="description">
														<strong> <?php echo trans('forms.sign_above'); ?> </strong>
													</div>
													<div class="signature-pad--actions txt-center">
														<div>
															<button type="button" class="button clear"
																data-action="clear"><?php

                echo trans('forms.clear');
                ?></button>
														</div>
													</div>
												</div>
											</div>
										</div>
										<input type="hidden" id="hiddensignature" name="mysignaturee"
											value="">
									</div>
									<div class="col-12 col-md-12 mb-4">
										<p class="alert alert-danger contact_error"
											style="display: none;"></p>
									</div>
									<div class="col-12 col-md-12 mb-4">
										<input type="hidden" id="mailflag" name="mailflag"
											value="<?php if(isset($is_prospect_sign_page)) echo '0'; ?>">
										<input type="hidden" id="c_id" name="c_id"
											value="<?php if(isset($contact_row))  echo $contact_row->id;  else  echo "-1"; ?>">
										<button class="mt-2 btn btn-primary" id="signaturebutton"><?php echo trans('forms.submit'); ?></button>&nbsp;&nbsp;&nbsp;
                                   <?php if(!isset($is_prospect_sign_page) || $is_prospect_sign_page == 0) {  ?>      <button
											class="mt-2 btn btn-success" id="postmailbutton"><?php echo trans('forms.sendMail'); ?></button> <?php } ?>
                               </div>
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
<?php include(app_path().'/common/panel/footer.php'); ?>

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

$('#signaturebutton').on('click', function(){
	$('#mailflag').val(0);
	$(this).prop('disabled', true);	
	$('#form_box').submit();
	$(this).prop('disabled', false);
	
});

$('#postmailbutton').on('click', function(){
	$('#mailflag').val(1);
	$(this).prop('disabled', true);
	$('#form_box').submit();
	
	$(this).prop('disabled', false);
})

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


<script
	src="<?php echo url('digital_signature/signature_pad.min.js'); ?>"></script>
<script
	src="<?php echo url('digital_signature/signature_pad2.min.js'); ?>"></script>
<script>
            var mybutton=document.getElementById("signaturebutton");
            var wrapper = document.getElementById("signature-pad");
            var clearButton = wrapper.querySelector("[data-action=clear]");
            var changeCdataURLolorButton = wrapper.querySelector("[data-action=change-color]");
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
            // resizeCanvas();
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
    
           	
	function makeid(length) {
		var result = '';
		var characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
		var charactersLength = characters.length;
		for ( var i = 0; i < length; i++ ) {
		result += characters.charAt(Math.floor(Math.random() * charactersLength));
		}
		return result;
	}

        </script>
<script>
       
     function add_module_items(th)
    {
    	// alert('hi');
        $("#module_items_box").append('<div class="form-row" style="margin-right:15px;margin-left:15px;"><div class="col-md-6">\
                                                    <div class="position-relative form-group">\
                                                        <label for="exampleEmail11" class=""><?php echo trans("forms.module_title"); ?></label>\
                                                        <input type="text" name="module_title[]" class="form-control">\
                                                    </div>\
                                                </div>\
                                                <div class="col-md-6">\
                                                    <div class="position-relative form-group">\
                                                        <label for="exampleEmail11" class=""><?php echo trans("forms.module_items"); ?> </label>\
                                                        <textarea rows="1" name="module_items[]" class="form-control" style="display:inline; max-width:94%;"></textarea> <a style="color:red;" href="javascript:void(0)" onclick="$(this).parent().parent().parent().remove();"><i class="fa fa-minus-circle"></i></a>\
                                                    </div>\
                                                </div></div>');
    }
        </script>
<script>
        
        
        function check_email(th)
    {
        var email=$(th).val();
        var formData=new FormData();
        var token='<?php echo csrf_token(); ?>';
        formData.append('_token', token);
        formData.append('id', '0');
        formData.append('email', email);
        
        $.ajax({
                url: "<?php echo url('admin/check-email') ?>",
                type: "POST",
                data:  formData,
                beforeSend: function(){ //alert('sending');
                    //$("#submit_btn").attr('disabled', true);
                },
                contentType: false,
                processData:false,
                success: function(data) { 
                    //success
                  
                    // here we will handle errors and validation messages
                        $("#email-error").show();
                      
                    if ( ! data.success) {
                    } else {
                        // ALL GOOD! just show the success message!
                        $("#email-error").hide();
                     
                    }
                },
                error: function()  {
                    //error
                } 	        
        });
    }
        
        
        function enable_buttons() {
        $('#postmailbutton').prop('disabled', false);
        $('#signaturebutton').prop('disabled', false);
        }
    function check_data3()
    {   
        
        var mailflag = $('#mailflag').val();
    	if(signaturePad.isEmpty() && mailflag == 0) {
    	//alert("sign is empty & mailflag is 0");
    		$("#error").text('Please provide a signature first');
    		$("#error").show();
    	enable_buttons();
    		return false;
    	} else {
    		
            $("#error").hide();
            $(".contact_error").hide();
            
           var basic_fields_ok = 1;
            
            var fields = $('.ss-item-required').find('select, textarea, input').serializeArray();

              $.each(fields, function (i, field) {
              
                if (!field.value){
                alert(field.name + " field is missing value");
                $("#error").text(field.name + ' is required');
                 $("#error").show();
                 $(".contact_error").text(field.name + ' is required');
                 $(".contact_error").show();
                 basic_fields_ok = 0;
                 enable_buttons();
                 return false;
                 }
              });
              
            
            var gender = document.getElementById('gender');
            var marital_status = document.getElementById('marital_status');
            var referral_source = document.getElementById('referral_source');
            var funding_source = document.getElementById('funding_source');
    
            var atLeastOneIsChecked1 = (gender.selectedIndex > 0);
            var atLeastOneIsChecked2 = (marital_status.selectedIndex > 0);
            var atLeastOneIsChecked3 = (referral_source.selectedIndex > 0);
            var atLeastOneIsChecked4 = (funding_source.selectedIndex > 0);     
            
            var dob=$("#dob_field").val();
            if(dob != '') {
                var data=dob.split('-');
                
                if(data[2]==(new Date).getFullYear())
                {
                    $("#error").text('<?php echo trans('forms.dob_year_old'); ?>');
                    $("#error").show();
                    $(".contact_error").text('<?php echo trans('forms.dob_year_old'); ?>');
                    $(".contact_error").show();
                    enable_buttons();
                    return false;
                }
            }

			//TODO: Uma Continue here. this is always failing
            if(!atLeastOneIsChecked1)
            {
                $("#error").text('Please specify Geschlecht.');
                $("#error").show();
                $(".contact_error").text('Please specify Geschlecht.');
                $(".contact_error").show();
                enable_buttons();
                return false;
            }
            
            if(!atLeastOneIsChecked2)
            {
            
                $("#error").text('Please specify Familienstand');
                $("#error").show();
                $(".contact_error").text('Please specify Familienstand');
                $(".contact_error").show();
                enable_buttons();
                return false;
            }
            
            if(!atLeastOneIsChecked4)
            {
            
                $("#error").text('Please select Fördergeldgeber');
                $("#error").show();
                $(".contact_error").text('Please select Fördergeldgeber');
                $(".contact_error").show();
                enable_buttons();
                return false;
            }
            //alert("returning true");
            if(basic_fields_ok == 0)
            	return false;
            else
            	return true;
        }
    }
        </script>

