function show_form(type) {
  //$("#form-field-box").empty();
  $("#contacts-form").show();
  $(".col-md-3").show();
  $(".col-md-6").show();
  $(".col-md-12").show();
  $(".required").attr('required', 'required');
  $("#company_name").hide();
  $("#company_name_field").removeAttr('required');

  $("#type_checkbox_student").hide();
  $("#type_checkbox_trainer").hide();
  $("#customer_no").hide();
  $("#org_zeichen").hide();
  $("#parents").hide();

  $("#start_working").hide();
  $("#start_working_field").removeAttr('required');
  $("#bank_name").hide();
  $("#bank_name_field").removeAttr('required');
  $("#iban").hide();
  $("#iban_field").removeAttr('required');
  $("#bic").hide();
  $("#bic_field").removeAttr('required');
  //$("#contract_box").hide(); $("#contract_field").removeAttr('required');

  $("#unlimited_employment").hide();
  $("#employment_end").hide();
  $("#employment_end_field").removeAttr('required');
  $("#yearly_salary").hide();
  $("#yearly_salary_field").removeAttr('required');
  $("#working_hours").hide();
  $("#working_hours_field").removeAttr('required');
  $("#probation_period").hide();
  $("#probation_period_field").removeAttr('required');
  $("#position").hide();
  $("#position_field").removeAttr('required');

  $("#price_ue").hide();
  $("#price_ue_field").removeAttr('required');
  $(".products_module").hide();
  $("#team_email_box").hide();

  if (type == 'Coachee' || type == 'Student') {
    $("#marital_status").hide();
    $("#marital_status").removeAttr('required');
    $("#contract_box").show();
    $("#contract_field").removeAttr('required');

    $("#type_checkbox_student").show();
    $("#type_checkbox_trainer").hide();
    $("#parents").show();
    $("#customer_no").show();
  } else if (type == 'Clerk') {

  } else if (type == 'Coach') {
    $("#marital_status").hide();
    $("#marital_status").removeAttr('required');
    $("#contract_box").show();
    $("#contract_field").removeAttr('required');

    $("#type_checkbox_trainer").show();
    $("#type_checkbox_student").hide();

    $("#contact_person").hide();
    $("#contact_person_field").removeAttr('required');
    $("#child_care").hide();
    $("#child_care_field").removeAttr('required');
    $("#funding_source").hide();
    $("#funding_source_field").removeAttr('required');
    $("#funding_source_address").hide();
    $("#funding_source_address_field").removeAttr('required');
    $("#period").hide();
    $("#period_field").removeAttr('required');
    $("#voucher").hide();
    $("#voucher_field").removeAttr('required');

    //$("#start_working").show(); $("#start_working_field").attr('required', 'required');
    $("#bank_name").show();
    $("#bank_name_field").attr('required', 'required');
    $("#iban").show();
    $("#iban_field").attr('required', 'required');
    $("#bic").show();
    $("#bic_field").attr('required', 'required');
    $("#price_ue").show();
    $("#price_ue_field").attr('required', 'required');
    $(".products_module").show();
    //$("#unlimited_employment").show();
    //$("#employment_end").show(); $("#employment_end_field").attr('required', 'required');
  } else if (type == 'Lecturer') {
    $("#marital_status").hide();
    $("#marital_status").removeAttr('required');

    $("#contact_person").hide();
    $("#contact_person_field").removeAttr('required');
    $("#child_care").hide();
    $("#child_care_field").removeAttr('required');
    $("#funding_source").hide();
    $("#funding_source_field").removeAttr('required');
    $("#funding_source_address").hide();
    $("#funding_source_address_field").removeAttr('required');
    $("#period").hide();
    $("#period_field").removeAttr('required');
    $("#voucher").hide();
    $("#voucher_field").removeAttr('required');

    $("#start_working").show();
    $("#start_working_field").attr('required', 'required');
    $("#bank_name").show();
    $("#bank_name_field").attr('required', 'required');
    $("#iban").show();
    $("#iban_field").attr('required', 'required');
    $("#bic").show();
    $("#bic_field").attr('required', 'required');
    $("#price_ue").show();
    $("#price_ue_field").attr('required', 'required');
    $(".products_module").show();
  } else if (type == 'Internship Company') {
    $("#first_name").hide();
    $("#first_name_field").removeAttr('required');
    $("#last_name").hide();
    $("#last_name_field").removeAttr('required');
    $("#gender").hide();
    $("#gender_field").removeAttr('required');
    $("#dob").hide();
    $("#dob_field").removeAttr('required');
    $("#birth_location").hide();
    $("#birth_location_field").removeAttr('required');
    $("#mobile").show();
    $("#mobile_field").attr('required', 'required');
    $("#marital_status").hide();
    $("#marital_status_field").removeAttr('required');
    $("#child_care").hide();
    $("#child_care_field").removeAttr('required');
    $("#funding_source").hide();
    $("#funding_source_field").removeAttr('required');
    $("#funding_source_address").hide();
    $("#funding_source_address_field").removeAttr('required');
    $("#period").hide();
    $("#period_field").removeAttr('required');
    $("#voucher").hide(); //$("#voucher_field").removeAttr('required');

    $("#company_name").show();
    $("#company_name_field").attr('required', 'required');
    $("#email_field").removeAttr('required');
  } else if (type == 'Prospect' || type == 'Expert Advisor') {
    $("#child_care").hide();
    $("#child_care_field").removeAttr('required');
    if (type == 'Prospect') {
      $("#funding_source").hide();
      $("#funding_source_field").removeAttr('required');
    }
    $("#contact_person").hide();
    $("#contact_person_field").removeAttr('required');
    $("#funding_source_address").hide();
    $("#funding_source_address_field").removeAttr('required');
    $("#period").hide();
    $("#period_field").removeAttr('required');
    $("#voucher").hide();
    $("#voucher_field").removeAttr('required');

    //if(type=='Prospect')
    //$("#customer_no").show();

    if (type == 'Expert Advisor') {
      $("#org_zeichen").show();
      $("#team_email_box").show();
      $("#email_field").removeAttr('required');
    }

  } else if (type == 'Employee') {
    $("#child_care").hide();
    $("#child_care_field").removeAttr('required');
    $("#funding_source").hide();
    $("#funding_source_field").removeAttr('required');
    $("#contact_person").hide();
    $("#contact_person_field").removeAttr('required');
    $("#funding_source_address").hide();
    $("#funding_source_address_field").removeAttr('required');
    $("#period").hide();
    $("#period_field").removeAttr('required');
    $("#voucher").hide();
    $("#voucher_field").removeAttr('required');

    $("#start_working").show();
    $("#start_working_field").attr('required', 'required');
    $("#bank_name").show();
    $("#bank_name_field").attr('required', 'required');
    $("#iban").show();
    $("#iban_field").attr('required', 'required');
    $("#bic").show();
    $("#bic_field").attr('required', 'required');

    $("#unlimited_employment").show();
    $("#employment_end").show();
    $("#employment_end_field").attr('required', 'required');
    $("#yearly_salary").show();
    $("#yearly_salary_field").attr('required', 'required');
    $("#working_hours").show();
    $("#working_hours_field").attr('required', 'required');
    $("#probation_period").show();
    $("#probation_period_field").attr('required', 'required');
    $("#position").show();
    $("#position_field").attr('required', 'required');

  } else if (type == 'Expert Advisor') {
    $("#marital_status").hide();
    $("#marital_status_field").removeAttr('required');

  } else if (type == 'Other Contacts') {
    $("#child_care").hide();
    $("#child_care_field").removeAttr('required');
    $("#contact_person").hide();
    $("#contact_person_field").removeAttr('required');
    $("#funding_source").hide();
    $("#funding_source_field").removeAttr('required');
    $("#funding_source_address").hide();
    $("#funding_source_address_field").removeAttr('required');
    $("#period").hide();
    $("#period_field").removeAttr('required');
    $("#voucher").hide();
    $("#voucher_field").removeAttr('required');

  } else $("#contacts-form").hide();
}

function check_data() {
  $("#error").hide();
  $(".contact_error").hide();
  var atLeastOneIsChecked = $('input[name="courses[]"]:checked').length > 0;

  if (!$("#period_field").prop('required')) {

  } else {
    //alert("YES");

    var period = $("#period_field").val();
    var dates = period.split(' - ');
    if (dates[0] == dates[1]) {
      $("#error").text('<?php echo trans('forms.beginning_end_same'); ?>');
      $("#error").show();
      $(".contact_error").text('<?php echo trans('forms.beginning_end_same'); ?>');
      $(".contact_error").show();
      return false;
    }

  }

  /*if(!atLeastOneIsChecked)
  {
      $("#error").text('<?php echo trans('forms.select_course_first'); ?>');
      $("#error").show();
      $(".contact_error").text('<?php echo trans('forms.select_course_first'); ?>');
      $(".contact_error").show();
      return false;
  }*/

  return true;
}

function show_parent_box(th) {
  if ($(th).is(":checked")) $("#parent_box").show();
  else $("#parent_box").hide();

}