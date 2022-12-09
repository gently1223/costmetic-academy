<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('setlocale/{locale}', function ($locale) {
  if (in_array($locale, \Config::get('app.locales'))) {
    Session::put('locale', $locale);
  }
  return redirect()->back();
});

Route::get('/', function () {
    return redirect('dashboard');
});

Auth::routes(['new_prospect_page'=>false]);
//Auth::routes(['/admin/new_prospect_page'=>false]);
    
Route::get('generate-pdf','admin\dashboard@generate_pdf');
//2022-05-07
Route::get('new_prospect_page', 'account@get_prospect_page');
Route::post('new_prospect_page', 'admin\contacts@new_prospect_page');

Route::get('login','account@login');
Route::post('login','account@login');
Route::get('forgot-password','account@forgot_password');
Route::post('forgot-password','account@forgot_password');
Route::get('set-password/{ID}/{CODE}','account@set_password');
Route::post('set-password/{ID}/{CODE}','account@set_password');
Route::get('email-confirmation/{ID}/{CODE}','account@email_confirmation');
Route::post('email-confirmation/{ID}/{CODE}','account@email_confirmation');
Route::get('logout','account@logout');

Route::get('send-todo-reminders','admin\to_do@send_reminders');
Route::get('send-voucher-reminder','cron_jobs@send_voucher_reminder');

Route::group(['middleware' => 'auth'], function () {
 Route::post('fetch-appointment', 'admin\appointments@fetch_appointment');
 Route::post('/upload-profile-image', 'account@upload_profile_image');
    
 Route::get('/dashboard', 'dashboard@index');
 Route::post('/dashboard', 'dashboard@index');
    
 Route::get('/my-contracts', 'contracts@index');
 Route::get('/contract/{ID}', 'dashboard@view_contract');
 Route::post('/save-signature', 'dashboard@save_signature');
    
 Route::get('/my-profile', 'dashboard@my_profile');
 Route::post('/my-profile', 'dashboard@my_profile');
 Route::get('/room-overview', 'appointments@get_readonly_appointments');
    
 Route::get('/my-cvs', 'dashboard@my_cvs');
 Route::post('/my-cvs', 'dashboard@my_cvs');
 Route::get('/create-cv', 'dashboard@create_cv');
 Route::post('/create-cv', 'dashboard@create_cv');
 Route::get('/create-cv/{ID}', 'dashboard@create_cv');
 Route::post('/create-cv/{ID}', 'dashboard@create_cv');
 Route::get('/cv-preview', 'dashboard@cv_preview');
 Route::post('/cv-preview', 'dashboard@cv_preview');
 Route::get('/cv-preview/{ID}', 'dashboard@cv_preview');
 Route::post('/cv-preview/{ID}', 'dashboard@cv_preview');
 Route::get('/cover-page', 'dashboard@cover_page');
 Route::get('/covering-letter', 'dashboard@covering_letter');
 Route::get('/template', 'dashboard@template');
 Route::post('/save-signature-cv', 'dashboard@save_signature_cv');

 //Route::get('/my-appointments', 'appointments@index');
 Route::get('/my-appointments', 'appointments@get_readonly_appointments');
 Route::post('/my-appointments', 'appointments@index');
 Route::get('/course-offers', 'appointments@course_offers');
 Route::post('/course-offers', 'appointments@course_offers');
 Route::post('accept-appointment', 'appointments@accept_appointment');
 Route::post('delete-appointment', 'appointments@delete_appointment');
 
 Route::get('/attendance-register', 'appointments@attendance_register');
 Route::post('/attendance-register', 'appointments@attendance_register');
 Route::get('/my-attendance', 'appointments@my_attendance');
 Route::post('/my-attendance', 'appointments@my_attendance');
 Route::post('/update-teaching-data', 'appointments@update_teaching_data');
 Route::post('/mark-attendance', 'appointments@mark_attendance');
 Route::post('/attendance-register-date', 'appointments@attendance_register_date');
 Route::post('attendance-add-notes', 'appointments@attendance_add_notes');
 Route::post('attendance-add-notes-date', 'appointments@attendance_add_notes_date');
 Route::post('/attendance-late', 'appointments@attendance_late');
 Route::post('attendance-fetch-notes-date', 'appointments@attendance_fetch_notes_date');
 Route::post('/update-student-attendance-notes', 'appointments@update_student_attendance_notes');
 Route::post('/update-student-attendance-motivationrating', 'appointments@update_student_attendance_motivationrating');
 Route::post('/update-student-attendance-servicerating', 'appointments@update_student_attendance_servicerating');
 Route::post('/update-student-test-notes', 'appointments@update_student_test_notes');
 Route::post('/update-student-test-result', 'appointments@update_student_test_result');
 Route::post('/update-student-test-score', 'appointments@update_student_test_score');
 Route::get('/sick-leaves', 'appointments@sick_leaves');
 Route::post('/sick-leaves', 'appointments@sick_leaves');
 Route::get('/edit-sick-leave/{ID}', 'appointments@edit_sick_leave');
 Route::post('/edit-sick-leave/{ID}', 'appointments@edit_sick_leave');
    
 Route::get('/to-do', 'to_do@to_do');
 Route::post('/to-do', 'to_do@to_do');
 Route::post('/manage-todos', 'to_do@manage_todos');
 Route::post('/update-status', 'to_do@update_status');
 Route::post('/upload-files', 'account@upload_files');

 //20-12-21
 Route::get('/offers', 'offers@view')->name('contacts.view');
 Route::get('/create-appointment/{id}', 'offers@create_appointment')->name('contacts.create-appointment');
 Route::get('/view-appointment/{id}', 'offers@create_appointment')->name('contacts.view-appointment');
 Route::post('/create-appointment', 'offers@manage_appointment')->name('contacts.manage-appointment');
 Route::post('/get-rooms', 'offers@get_rooms')->name('contacts.get-rooms');
 Route::post('/get-lession', 'offers@get_lession')->name('contacts.get-lession');
 Route::post('/manage_appointment', 'offers@manage_appointment')->name('contacts.manage-appointment');
 Route::post('/check-ue', 'offers@check_ue')->name('contacts.check-ue');
 Route::post('/create-final-appointment', 'offers@create_final_appointments')->name('contacts.create-final-appointment');
 Route::post('/accept-appointments', 'offers@accept_appointments')->name('contacts.accept-appointments');

 /* ankit work */
 Route::post('/ajax-tagesdoku-details', 'appointments@ajaxTagesdokuDetails')->name('ajaxTagesdokuDetails');
 Route::post('/ajax-tagesdoku-store', 'appointments@ajaxStoreTagesdoku')->name('ajaxStoreTagesdoku');
 Route::get('/tagasdoku-pdf/{id}', 'appointments@tagasdokuPdf')->name('tagasdokuPdf');
 Route::get('/tagasdoku-send/{id}', 'appointments@tagasdokuSend')->name('tagasdokuSend');
 Route::get('tagesdoku-student/{id}','PublicController@tagesdokuStudent')->name('tagesdokuStudent');
 Route::post('tagesdoku-student-store','PublicController@tagesdokuStudentStore')->name('tagesdokuStudentStore');
 Route::get('/test', 'appointments@test')->name('test');
 /* ankit work */



});

Route::get('/admin', function () {
    return redirect('admin/login');
});

Route::get('admin/login','admin\account@login');
Route::post('admin/login','admin\account@login');
Route::get('admin/forgot-password','admin\account@forgot_password');
Route::post('admin/forgot-password','admin\account@forgot_password');
Route::get('admin/set-password/{ID}/{CODE}','admin\account@set_password');
Route::post('admin/set-password/{ID}/{CODE}','admin\account@set_password');

Route::group(['middleware' => 'admin_auth'], function () {
 Route::get('/admin/attendance-register', 'admin\appointments@attendance_register');
 Route::post('/admin/attendance-register', 'admin\appointments@attendance_register');
 Route::post('/admin/attendance-register-date', 'admin\appointments@attendance_register_date');
 Route::post('/admin/attendance-fetch-notes-date', 'admin\appointments@attendance_fetch_notes_date');
    
 Route::get('/admin/activities', 'admin\activities@activities');
    
 Route::get('/admin/logout', 'admin\account@logout');
 Route::get('/admin/dashboard', 'admin\dashboard@index');
    
 Route::get('/admin/my-profile', 'admin\dashboard@my_profile');
 Route::post('/admin/my-profile', 'admin\dashboard@my_profile');
 Route::get('/admin/manage_offer', 'admin\offers@manage_offer');
 Route::post('/admin/manage_offer', 'admin\offers@manage_offer');
 Route::get('/admin/get-all-pmi', 'admin\offers@get_pmi_treeview');
  Route::get('/admin/get-all-pmi2', 'admin\offers@get_pmi_treeview2');
 Route::post('/admin/add-signature', 'admin\dashboard@add_signature');
 Route::post('/admin/user-signature', 'admin\account@add_signature');  
 Route::post('/admin/upload-files', 'admin\account@upload_files');
 Route::get('/admin/manage-users', 'admin\account@manage_users');
 Route::post('/admin/manage-users', 'admin\account@manage_users');
 Route::get('/admin/edit-user/{ID}', 'admin\account@edit_user');
 Route::post('/admin/edit-user/{ID}', 'admin\account@edit_user');
    
 Route::get('/admin/coachee-contract', 'admin\contacts@coachee_contract');
    
 Route::get('/admin/contacts', 'admin\contacts@index');
 Route::post('/admin/contacts', 'admin\contacts@index');
 Route::get('/admin/edit-contact/{ID}', 'admin\contacts@edit_contact');
 Route::post('/admin/edit-contact/{ID}', 'admin\contacts@edit_contact');
 Route::post('/admin/check-email', 'admin\contacts@check_email');
 Route::post('/admin/convert-prospect', 'admin\contacts@convert');
 Route::get('/admin/contract/{ID}', 'admin\contacts@view_contract');
 Route::get('/admin/signature', 'admin\contacts@signature');
 Route::post('/admin/save-signature', 'admin\contacts@save_signature');
 Route::post('/admin/create-contract', 'admin\contacts@contract');
 Route::post('/admin/fetch-contracts', 'admin\contacts@fetch_contracts');
 Route::post('/admin/fetch-documents', 'admin\contacts@fetch_documents');
 Route::post('/admin/fetch-contact-products', 'admin\contacts@fetch_products');
 Route::post('/admin/fetch-modules', 'admin\contacts@fetch_modules');
 Route::post('/admin/delete-contract', 'admin\contacts@delete_contract');
    
 Route::get('/admin/cvs', 'admin\dashboard@cvs');
 Route::post('/admin/cvs', 'admin\dashboard@cvs');
 Route::get('/admin/resume', 'dashboard@template');
 Route::get('/admin/cover-page', 'dashboard@cover_page');
 Route::get('/admin/cover-letter', 'dashboard@covering_letter');
    
 Route::get('/admin/convert/{ID}', 'admin\contacts@convert');
 Route::post('/admin/convert/{ID}', 'admin\contacts@convert');
    
 Route::post('/admin/fetch-products', 'admin\products@fetch_products');
 Route::post('/admin/fetch-funding', 'admin\products@fetch_funding');
    
 Route::get('/admin/regular-courses', 'admin\course@regular_courses');
 Route::post('/admin/regular-courses', 'admin\course@manage_courses');
 Route::get('/admin/coaching-courses', 'admin\course@coaching_courses');
 Route::post('/admin/coaching-courses', 'admin\course@manage_courses');
 Route::get('/admin/course-appointments/{ID}', 'admin\course@course_appointments');
 Route::post('/admin/course-appointments/{ID}', 'admin\course@course_appointments');
 Route::post('/admin/generate-appointments', 'admin\course@generate_appointments');
 Route::post('/admin/delete-appointment', 'admin\course@delete_appointment');
 Route::get('/admin/edit-course/{ID}', 'admin\course@edit_course');
 Route::post('/admin/edit-course/{ID}', 'admin\course@edit_course');
 Route::get('/admin/coaching-end-report/{ID}', 'admin\course@coaching_end_report');
 Route::post('/admin/coaching-end-report/{ID}', 'admin\course@coaching_end_report');
 Route::get('/admin/has-incomplete-appointments/{ID}', 'admin\course@has_incomplete_appointments');
 
    
 Route::get('/admin/to-do', 'admin\to_do@to_do');
 Route::post('/admin/to-do', 'admin\to_do@to_do');
 Route::post('/admin/manage-todos', 'admin\to_do@manage_todos');
 Route::post('/admin/update-status', 'admin\to_do@update_status');
    
 Route::get('/admin/products', 'admin\products@index');
 Route::post('/admin/products', 'admin\products@index');
 Route::post('/admin/import-products', 'admin\products@fetch_data_xlsx');
 Route::get('/admin/edit-product/{ID}', 'admin\products@edit_product');
 Route::post('/admin/edit-product/{ID}', 'admin\products@edit_product');
 Route::get('/admin/edit-module/{ID}', 'admin\products@edit_module');
 Route::post('/admin/edit-module/{ID}', 'admin\products@edit_module');
 Route::get('/admin/edit-module-item/{ID}', 'admin\products@edit_module_item');
 Route::post('/admin/edit-module-item/{ID}', 'admin\products@edit_module_item');
 Route::get('/admin/edit-module-item-service/{ID}', 'admin\products@edit_module_item_service');
 Route::post('/admin/edit-module-item-service/{ID}', 'admin\products@edit_module_item_service');
    
 Route::get('/admin/subscribers', 'admin\marketing@subscribers');
 Route::post('/admin/subscribers', 'admin\marketing@subscribers');
 Route::get('/admin/export-subscribers', 'admin\marketing@export_subscribers');
    
 Route::get('/admin/product-categories', 'admin\products@product_categories');
 Route::post('/admin/product-categories', 'admin\products@product_categories');
 Route::get('/admin/edit-product-category/{ID}', 'admin\products@edit_product_category');
 Route::post('/admin/edit-product-category/{ID}', 'admin\products@edit_product_category');
    
 Route::get('/admin/calendar-categories', 'admin\meta_data@calendar_categories');
 Route::post('/admin/calendar-categories', 'admin\meta_data@calendar_categories');
 Route::get('/admin/edit-calendar-category/{ID}', 'admin\meta_data@edit_calendar_category');
 Route::post('/admin/edit-calendar-category/{ID}', 'admin\meta_data@edit_calendar_category');
    
 Route::get('/admin/modules', 'admin\products@modules');
 Route::post('/admin/modules', 'admin\products@modules');
 Route::get('/admin/module-items', 'admin\products@module_items');
 Route::post('/admin/module-items', 'admin\products@module_items');
 Route::get('/admin/module-item-services', 'admin\products@module_item_services');
 Route::post('/admin/module-item-services', 'admin\products@module_item_services');
 Route::get('/admin/p-m-mi-templates', 'admin\products@p_m_mi_templates');
 Route::post('/admin/p-m-mi-templates', 'admin\products@p_m_mi_templates');
 Route::get('/admin/edit-p-m-mi-template/{ID}', 'admin\products@edit_p_m_mi_templates');
 Route::post('/admin/edit-p-m-mi-template/{ID}', 'admin\products@edit_p_m_mi_templates');
    
 Route::get('/admin/rooms', 'admin\rooms@index');
 Route::post('/admin/rooms', 'admin\rooms@index');
 Route::get('/admin/edit-room/{ID}', 'admin\rooms@edit_room');
 Route::post('/admin/edit-room/{ID}', 'admin\rooms@edit_room');
    
 Route::get('/admin/appointments', 'admin\appointments@index');
 Route::post('/admin/appointments', 'admin\appointments@index');
 Route::get('/admin/create-appointment', 'admin\appointments@create_appointment');
 Route::post('/admin/create-appointment', 'admin\appointments@create_appointment');
 Route::get('/admin/fetch-appointment', 'admin\appointments@fetch_appointment');
 Route::post('/admin/fetch-appointment', 'admin\appointments@fetch_appointment');
 Route::get('/admin/remove-appointment', 'admin\appointments@remove_appointment');
 Route::post('/admin/remove-appointment', 'admin\appointments@remove_appointment');
    
 Route::get('/admin/room-locations', 'admin\rooms@room_locations');
 Route::post('/admin/room-locations', 'admin\rooms@room_locations');
 Route::get('/admin/edit-room-location/{ID}', 'admin\rooms@edit_room_location');
 Route::post('/admin/edit-room-location/{ID}', 'admin\rooms@edit_room_location');
 Route::get('/admin/funding-sources', 'admin\contacts@funding_sources');
 Route::post('/admin/funding-sources', 'admin\contacts@funding_sources');
 Route::get('/admin/edit-funding-source/{ID}', 'admin\contacts@edit_funding_source');
 Route::post('/admin/edit-funding-source/{ID}', 'admin\contacts@edit_funding_source');
    
 Route::get('/admin/documents', 'admin\meta_data@documents');
 Route::post('/admin/documents', 'admin\meta_data@documents');
 Route::get('/admin/edit-document-type/{ID}', 'admin\meta_data@edit_document_type');
 Route::post('/admin/edit-document-type/{ID}', 'admin\meta_data@edit_document_type');
 Route::get('/admin/referral-sources', 'admin\meta_data@referral_sources');
 Route::post('/admin/referral-sources', 'admin\meta_data@referral_sources');
 Route::get('/admin/teaching-methods', 'admin\meta_data@teaching_methods');
 Route::post('/admin/teaching-methods', 'admin\meta_data@teaching_methods');
 Route::get('/admin/edit-teaching-method/{ID}', 'admin\meta_data@edit_teaching_method');
 Route::post('/admin/edit-teaching-method/{ID}', 'admin\meta_data@edit_teaching_method');
    
 Route::get('/admin/holidays', 'admin\appointments@holidays');
 Route::post('/admin/holidays', 'admin\appointments@holidays');
 Route::get('/admin/sick-leaves', 'admin\appointments@sick_leaves');
 Route::post('/admin/sick-leaves', 'admin\appointments@sick_leaves');
    
 Route::get('/admin/contracts-documents', 'admin\dashboard@contracts_documents');
 Route::post('/admin/contracts-documents', 'admin\dashboard@contracts_documents');
 Route::post('/admin/fetch-timetable', 'admin\dashboard@fetch_timetable');
    
 Route::post('/admin/add-notes', 'admin\contacts@add_notes');
 Route::post('/admin/delete-notes', 'admin\contacts@delete_notes');
 Route::post('create_certificate', 'admin\certificate@create_certificate');
 Route::get('/admin/certificates', 'admin\certificate@view_certificates');
 Route::post('/admin/certificates', 'admin\certificate@view_certificates');

 //16 Dec 2021 offers module create
 Route::get('/admin/coaching-offers', 'admin\coaching_offers@view_offers')->name('admin.coaching-offers');
 Route::post('/admin/coaching-offers', 'admin\coaching_offers@manage_offers')->name('admin.manage_offers');
 Route::post('/admin/get-lectures', 'admin\coaching_offers@get_lectures')->name('admin.get-lectures');
 Route::post('/admin/fetch-pmi-tree', 'admin\offers@get_pmi_treeview_offer')->name('admin.fetch-pmi-tree');
 
 Route::get('admin/get_treeview','admin\coaching_offers@get_treeview');
 Route::get('admin/view-offer/{id}','admin\coaching_offers@view_offer')->name("admin.view-offer");
 Route::get('admin/view-appointments/{id}','admin\coaching_offers@view_appointments')->name("admin.view-appointments");
 Route::post('/admin/update-appointment', 'admin\coaching_offers@update_appointment')->name('admin.update-appointment');
 Route::get('admin/delete-offer/{id}','admin\coaching_offers@delete_coaching_offer')->name("admin.delete-offer");
 Route::post('/admin/edit-appointment', 'admin\coaching_offers@edit_appointment')->name('admin.edit-appointment');
 Route::get('/admin/edit-appointment', 'admin\coaching_offers@update_appointments')->name('admin.update-appointments');
 Route::post('/admin/save-appointment', 'admin\coaching_offers@save_appointment')->name('admin.save-appointment');
 Route::post('/admin/check-appointment', 'admin\coaching_offers@check_appointment')->name('admin.check-appointment');
 Route::post('/admin/get-rooms', 'admin\coaching_offers@get_rooms')->name('admin.get-rooms');
 Route::get('/admin/new_prospect_page', 'admin\contacts@new_prospect_page');
 Route::post('/admin/new_prospect_page', 'admin\contacts@new_prospect_page');
});
