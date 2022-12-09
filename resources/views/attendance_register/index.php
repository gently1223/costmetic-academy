<?php include(app_path().'/common/header.php'); ?>
<style type="text/css">
    .jay-signature-pad{
        border: 1px dashed black;
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
                                            <div class="card-header-tab card-header">
                                                <div class="card-header-title font-size-lg text-capitalize font-weight-normal">
                                                </div>
                                                
                                            </div>
                                            <?php if(Session::has('error')) { ?>
                                            <p class="alert alert-danger"><?php echo Session::get('error'); ?></p>
                                            <?php } ?>
                                            <?php if(Session::has('success')) { ?>
                                            <p class="alert alert-success"><?php echo Session::get('success'); ?></p>
                                            <?php } ?>
                                                
                                            <div class="card-body">
                                                <?php 
                                                if(!empty($courses)) {
                                                    foreach($courses as $course) {
                                                ?>
                                                <div id="accordion<?php echo $course['course']->id; ?>" class="accordion-wrapper mb-3">
                                                    <div class="">
                                                        <div id="headingOne<?php echo $course['course']->id; ?>" class="card-header" style="background:#E2E2E0;">
                                                            <button type="button" data-toggle="collapse" data-target="#collapseOne2<?php echo $course['course']->id; ?>" aria-expanded="<?php if(isset($_GET['c']) AND $_GET['c']==$course['course']->id) echo 'true'; else echo 'false'; ?>" aria-controls="collapseOne" class="text-left m-0 p-0 btn btn-link btn-block collapsed">
                                                                <h5 class="m-0 p-0" style="font-size:18px;"><?php echo $course['course']->title; ?></h5>
                                                            </button>
                                                        </div>
                                                        <div data-parent="#accordion<?php echo $course['course']->id; ?>" id="collapseOne2<?php echo $course['course']->id; ?>" aria-labelledby="headingOne<?php echo $course['course']->id; ?>" class="<?php if(isset($_GET['c']) AND $_GET['c']==$course['course']->id) echo 'show'; ?> collapse" style="">
                                                            <div class="card-body">
                                                
                                    <ul class='nav nav-tabs mb-3' id='profile-form-tab' role='tablist'>
<li class='nav-item'>
<a aria-controls='appointments<?php echo $course['course']->id; ?>' aria-selected='<?php if(!isset($_GET['t'])) echo 'true'; else echo 'false'; ?>' class="nav-link <?php if(!isset($_GET['t'])) echo 'active'; ?>" data-toggle='tab' href='#appointments<?php echo $course['course']->id; ?>' id='appointments-tab-<?php echo $course['course']->id; ?>' role='tab'>Appointments</a>
</li>
<li class='nav-item'>
<a aria-controls='notes<?php echo $course['course']->id; ?>' aria-selected='true' class="nav-link" data-toggle='tab' href='#notes<?php echo $course['course']->id; ?>' id='notes-tab-<?php echo $course['course']->id; ?>' role='tab'>Notes</a>
</li>
<li class='nav-item'>
<a aria-controls='details<?php echo $course['course']->id; ?>' aria-selected='true' class="nav-link" data-toggle='tab' href='#details<?php echo $course['course']->id; ?>' id='details-tab-<?php echo $course['course']->id; ?>' role='tab'>Course details</a>
</li>
<li class='nav-item'>
<a aria-controls='attendance<?php echo $course['course']->id; ?>' aria-selected='false' class="nav-link" data-toggle='tab' href='#attendance<?php echo $course['course']->id; ?>' id='attendance-tab-<?php echo $course['course']->id; ?>' role='tab'>Attendance</a>
</li>
<li class='nav-item'>
<a aria-controls='tests<?php echo $course['course']->id; ?>' aria-selected='<?php if(isset($_GET['t'])) echo 'true'; else echo 'false'; ?>' class="nav-link <?php if(isset($_GET['t'])) echo 'active'; ?>" data-toggle='tab' href='#tests<?php echo $course['course']->id; ?>' id='tests-tab-<?php echo $course['course']->id; ?>' role='tab'>Tests</a>
</li>
<li class='nav-item'>
<a aria-controls='tagesdoku<?php echo $course['course']->id; ?>' aria-selected='<?php if(isset($_GET['t'])) echo 'true'; else echo 'false'; ?>' class="nav-link <?php if(isset($_GET['t'])) echo 'active'; ?>" data-toggle='tab' href='#tagesdoku<?php echo $course['course']->id; ?>' id='tagesdoku-tab-<?php echo $course['course']->id; ?>' role='tab'>Tagesdoku</a>
</li>
</ul>
                                                                <p class="alert alert-danger" style="display:none;" id="error-<?php echo $course['course']->id; ?>"></p>
                                    <div class='tab-content'>

                                        <!--------------------------tagesdoku --------------------->
                                        <div aria-labelledby='tagesdoku-tab-<?php echo $course['course']->id; ?>' class="tab-pane fade" id='tagesdoku<?php echo $course['course']->id; ?>' role='tabpanel'>


                                        </div>
                                        <!--------------------------tagesdoku End--------------------->




                                        <div aria-labelledby='attendance-tab-<?php echo $course['course']->id; ?>' class="tab-pane fade" id='attendance<?php echo $course['course']->id; ?>' role='tabpanel'>
                                            <input type="hidden" name="appointment_id" value="0" id="appointment_id_<?php echo $course['course']->id; ?>">
                                            <div class="form-row">
                                                <div class="col-md-12 d-none">
                                                    <h5 id="attendance_date_text"></h5><br>
                                                </div>
                                                
                                                <div class="col-md-2">
                                                    <div class="position-relative form-group">
                                                        <label for="examplePassword11" class="">Attendance for <font style="color:red;">*</font></label>
                                                        <input name="attendance_date" type="text" class="form-control today_calendar" id="attendance_date" disabled>
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-6">
                                                    <div class="position-relative form-group">
                                                        <label for="examplePassword11" class="">Module Item <font style="color:red;">*</font></label>
                                                        <input name="module_item" type="text" class="form-control" disabled id="module_item">
                                                    </div>
                                                </div>
                                                
                                                <!-- <div class="col-md-6">
                                                    <div class="position-relative form-group">
                                                        <label for="teaching_form" class="">Teaching form <font style="color:red;">*</font></label>
                                                        <select name="teaching_form[]" class="form-control select-multiple" required id="teaching_form_<?php echo $course['course']->id; ?>" multiple="" style="width:100%;">
                                                            <option value="Prasenz-Unterrichtsform">Prasenz-Unterrichtsform</option>
                                                            <option value="Digitale Unterrichtsform">Digitale Unterrichtsform</option>
                                                            <option value="Selbstlernheit">Selbstlernheit</option>
                                                        </select>
                                                    </div>
                                                </div> -->
                                                
                                                <div class="col-md-4">
                                                    <div class="position-relative form-group">
                                                        <label for="teaching_method" class="">Teaching method <font style="color:red;">*</font></label>
                                                        <select name="teaching_method[]" class="form-control select-multiple" required id="teaching_method_<?php echo $course['course']->id; ?>" multiple="" style="width:100%;">
                                                        <?php if(!empty($teaching_methods)) {
                                                            foreach($teaching_methods as $t) {
                                                            ?>
                                                            <option value="<?php echo $t->name; ?>"><?php echo $t->name; ?></option>
                                                            <?php } } ?>
                                                        
                                                        
                                                                  </select>
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-6">
                                                    <div class="position-relative form-group">
                                                    <button class="btn btn-primary" onclick="update_teaching_data('<?php echo $course['course']->id; ?>')" type="button" id="save_btn_<?php echo $course['course']->id; ?>">Save</button>
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-6 d-none">
                                                    <div class="position-relative form-group">
                                                    <label for="examplePassword11" class="" style="display:block;">&nbsp;</label>
                                                    <button class="btn btn-primary" onclick="change_date('<?php echo $course['course']->id; ?>')" id="btn_register_submit">Submit</button>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <table style="width: 100%;" id="example33" class="table table-hover table-striped table-bordered">
                                                                <thead>
                                                                <tr>
                                                                    <th>Student</th>
                                                                    <th>Present</th>
                                                                    <th>Absent</th>
                                                                    <th>Late</th>
                                                                    <th>Motivation</th>
                                                                    <th>Leistung</th>
                                                                    <th>Notes</th>
                                                                </tr>
                                                                </thead>
                                                                <tbody id="attendance-box">
                                                                <?php 
                                                                    if(!empty($course['students']) AND 0) {
                                                                        foreach($course['students'] as $student) {
                                                                            $date=date('Y-m-d');
                                                                ?>
                                                                <tr>
                                                                    <td><?php echo $student['student']->name; ?></td>
                                                                    <td><input type="radio" name="status" value="1" onchange="change_status('1', '<?php echo $student['student']->id; ?>', '<?php echo $date; ?>', '<?php echo $course['course']->id; ?>', '#late-<?php echo $student['student']->id; ?>')" <?php if($student['attendance']=='1') echo 'checked'; ?> ></td>
                                                                    <td><input type="radio" name="status" value="0" onchange="change_status('0', '<?php echo $student['student']->id; ?>', '<?php echo $date; ?>', '<?php echo $course['course']->id; ?>', '#late-<?php echo $student['student']->id; ?>')" <?php if($student['attendance']=='0') echo 'checked'; ?> ></td>
                                                                    <td><input type="radio" name="status" value="2" onchange="change_status('2', '<?php echo $student['student']->id; ?>', '<?php echo $date; ?>', '<?php echo $course['course']->id; ?>', '#late-<?php echo $student['student']->id; ?>')" <?php if($student['attendance']=='2') echo 'checked'; ?> >
                                                                        <div class="form-group" style="display:inline-block; margin-left:10px;">
                                                                    <div class='input-group' style="border-radius:5px;">
<input class='form-control' type="number" min="0" step="any" name="late" value="<?php echo $student['late']; ?>" id="late-<?php echo $student['student']->id; ?>" style="display:inline-block; max-width:70px;" onchange="change_late('<?php echo $student['student']->id; ?>', '<?php echo $date; ?>', '<?php echo $course['course']->id; ?>', this.value)">
<span class='input-group-append' style="border-radius:5px;">
<span class='input-group-text' style="border-left:0px;">min</span>
</span>
</div>
                                                                            </div>
                                                                    </td>
                                                                </tr>
                                                                <?php } } ?>
                                                                </tbody>
                                                                <tfoot>
                                                                </tfoot>
                                            </table>
                                            
                                            <div class="row mt-4" style="display:none;" id="notes_box">
                                                <div class="col-md-6">
                                                    <div class="position-relative form-group">
                                                        <textarea class="form-control" name="note2" id="note2" placeholder="<?php echo trans('forms.write_note'); ?>" rows="8"></textarea>
                                                    </div>
                                                    <div class="position-relative form-group">
                                                        <button class="btn btn-primary pt-2 pb-2" type="button" onclick="add_note2(this, '<?php echo $course['course']->id; ?>')"><?php echo trans('forms.add_note'); ?></button>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div id="notes-box2">
                                                        <?php 
                                                            if(!empty($attendance_notes)) {
                                                                foreach($attendance_notes as $note) {
                                                            ?>
                                                        <div style="border:1px solid #ced4da; padding:5px; margin-bottom:10px; border-radius:5px;">
                                                        <div style="overflow:hidden;">
                                                            <div class="float-left">
                                                            </div>
                                                            
                                                            <div class="float-left">
                                                                <?php echo date_format(new DateTime($note['note']->added_on),'d-m-Y'); ?>
                                                                <p style='color:#777'><?php echo date_format(new DateTime($note['note']->added_on),'H:i'); ?></p>
                                                            </div>
                                                            </div>
                                                            
                                                            <div><?php echo $note['note']->notes; ?></div>
                                                        </div>
                                                        <?php } } ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div aria-labelledby='tests-tab-<?php echo $course['course']->id; ?>' class="tab-pane fade <?php if(isset($_GET['t'])) echo 'show active'; ?>" id='tests<?php echo $course['course']->id; ?>' role='tabpanel'>
                                            <form action="" method="post">
                                                <?php echo csrf_field(); ?>
                                                <input type="hidden" name="course_id" value="<?php echo $course['course']->id; ?>">
                                            <div class="form-row">
                                                <div class="col-md-12 d-none">
                                                    <h5 id="attendance_date_text"></h5><br>
                                                </div>
                                                
                                                <div class="col-md-6">
                                                    <div class="position-relative form-group">
                                                        <label for="examplePassword11" class="">Date <font style="color:red;">*</font></label>
                                                        <input name="test_date" type="text" class="form-control today_calendar" required>
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-6">
                                                    <div class="position-relative form-group">
                                                        <label for="examplePassword11" class="">Test name <font style="color:red;">*</font></label>
                                                        <input name="test_name" type="text" class="form-control" required>
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-6">
                                                    <div class="position-relative form-group">
                                                    <button class="btn btn-primary">Submit</button>
                                                    </div>
                                                </div>
                                            </div>
                                            </form>
                                            
                                            <?php 
                                                        if(!empty($course['tests'])) {
                                                            foreach($course['tests'] as $test) {
                                            ?>
                                            <div id="testaccordion<?php echo $test['test']->id; ?>" class="accordion-wrapper mb-3">
                                                    <div class="">
                                                        <div id="testheadingOne<?php echo $test['test']->id; ?>" class="card-header" style="background:#E2E2E0;">
                                                            <button type="button" data-toggle="collapse" data-target="#testcollapseOne2<?php echo $test['test']->id; ?>" aria-expanded="false" aria-controls="collapseOne" class="text-left m-0 p-0 btn btn-link btn-block collapsed">
                                                                <h5 class="m-0 p-0" style="font-size:18px;"><?php echo $test['test']->name.' ('.date_format(new DateTime($test['test']->date),'d-m-Y').')'; ?></h5>
                                                            </button>
                                                        </div>
                                                        <div data-parent="#testaccordion<?php echo $test['test']->id; ?>" id="testcollapseOne2<?php echo $test['test']->id; ?>" aria-labelledby="testheadingOne<?php echo $test['test']->id; ?>" class="collapse" style="">
                                                            <div class="card-body">
                                            <table style="width: 100%;" id="example33" class="table table-hover table-striped table-bordered">
                                                                <thead>
                                                                <tr>
                                                                    <th>Student</th>
                                                                    <th>Result</th>
                                                                    <th>Score</th>
                                                                    <th>Notes</th>
                                                                </tr>
                                                                </thead>
                                                                <tbody id="tt-student-box">
                                                                <?php 
                                                                    if(!empty($test['students'])) {
                                                                        foreach($test['students'] as $student) {
                                                                            $date=date('Y-m-d');
                                                                ?>
                                                                <tr>
                                                                    <td><?php echo $student['student']->name; ?></td>
                                                                    <td><select name="rating-'.$row4->id.'" class="form-control" onchange="update_result_test('<?php echo $test['test']->id ?>', '<?php echo $student['student']->id; ?>','<?php echo $date; ?>', '<?php echo $course['course']->id; ?>', this.value)">
                                                                        <option>Please select</option>
                                                                        <option value="Passed" <?php if($student['result']=='Passed') echo 'selected'; ?> >Passed</option>
                                                                        <option value="Failed" <?php if($student['result']=='Failed') echo 'selected'; ?> >Failed</option>
                                                                    </select>
                                                                    </td>
                                                                    <td><select name="rating-'.$row4->id.'" class="form-control" onchange="update_score_test('<?php echo $test['test']->id ?>', '<?php echo $student['student']->id; ?>','<?php echo $date; ?>', '<?php echo $course['course']->id; ?>', this.value)">
                                                                        <option>Please select</option>
                                                                        <option value="1" <?php if($student['score']=='1') echo 'selected'; ?> >1</option>
                                                                        <option value="2" <?php if($student['score']=='2') echo 'selected'; ?> >2</option>
                                                                        <option value="3" <?php if($student['score']=='3') echo 'selected'; ?> >3</option>
                                                                        <option value="4" <?php if($student['score']=='4') echo 'selected'; ?> >4</option>
                                                                        <option value="5" <?php if($student['score']=='5') echo 'selected'; ?> >5</option>
                                                                        <option value="6" <?php if($student['score']=='6') echo 'selected'; ?> >6</option>
                                                                    </select>
                                                                    </td>
                                                                    <td>
                                                                        <input class="form-control" type="text" name="notes-<?php echo $test['test']->id ?>-<?php echo $student['student']->id; ?>" value="<?php echo $student['notes']; ?>" id="notes-<?php echo $test['test']->id ?>-<?php echo $student['student']->id; ?>" style="display:inline-block; width:100%;" onkeyup="update_notes_test('<?php echo $test['test']->id ?>', '<?php echo $student['student']->id; ?>','<?php echo $date; ?>', '<?php echo $course['course']->id; ?>', this.value)">
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
                                            <?php } } ?>
                                            
                                            <div class="row mt-4" style="display:none;" id="notes_box">
                                                <div class="col-md-6">
                                                    <div class="position-relative form-group">
                                                        <textarea class="form-control" name="note2" id="note2" placeholder="<?php echo trans('forms.write_note'); ?>" rows="8"></textarea>
                                                    </div>
                                                    <div class="position-relative form-group">
                                                        <button class="btn btn-primary pt-2 pb-2" type="button" onclick="add_note2(this, '<?php echo $course['course']->id; ?>')"><?php echo trans('forms.add_note'); ?></button>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div id="notes-box2">
                                                        <?php 
                                                            if(!empty($attendance_notes)) {
                                                                foreach($attendance_notes as $note) {
                                                            ?>
                                                        <div style="border:1px solid #ced4da; padding:5px; margin-bottom:10px; border-radius:5px;">
                                                        <div style="overflow:hidden;">
                                                            <div class="float-left">
                                                            </div>
                                                            
                                                            <div class="float-left">
                                                                <?php echo date_format(new DateTime($note['note']->added_on),'d-m-Y'); ?>
                                                                <p style='color:#777'><?php echo date_format(new DateTime($note['note']->added_on),'H:i'); ?></p>
                                                            </div>
                                                            </div>
                                                            
                                                            <div><?php echo $note['note']->notes; ?></div>
                                                        </div>
                                                        <?php } } ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div aria-labelledby='notes-tab-<?php echo $course['course']->id; ?>' class="tab-pane fade" id='notes<?php echo $course['course']->id; ?>' role='tabpanel'>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="position-relative form-group">
                                                        <textarea class="form-control" name="note" id="note" placeholder="<?php echo trans('forms.write_note'); ?>" rows="8"></textarea>
                                                    </div>
                                                    <div class="position-relative form-group">
                                                        <button class="btn btn-primary pt-2 pb-2" type="button" onclick="add_note(this, '<?php echo $course['course']->id; ?>')"><?php echo trans('forms.add_note'); ?></button>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div id="notes-box">
                                                        <?php 
                                                            if(!empty($course['notes'])) {
                                                                foreach($course['notes'] as $note) {
                                                            ?>
                                                        <div style="border:1px solid #ced4da; padding:5px; margin-bottom:10px; border-radius:5px;">
                                                        <div style="overflow:hidden;">
                                                            <div class="float-left">
                                                            </div>
                                                            
                                                            <div class="float-left">
                                                                <?php echo date_format(new DateTime($note['note']->added_on),'d-m-Y'); ?>
                                                                <p style='color:#777'><?php echo date_format(new DateTime($note['note']->added_on),'H:i'); ?></p>
                                                            </div>
                                                            </div>
                                                            
                                                            <div><?php echo $note['note']->notes; ?></div>
                                                        </div>
                                                        <?php } } ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div aria-labelledby='details-tab-<?php echo $course['course']->id; ?>' class="tab-pane fade" id='details<?php echo $course['course']->id; ?>' role='tabpanel'>
                                            <h5><?php echo $course['course']->title; ?></h5>
                                            <p><?php echo $course['course']->description; ?></p>
                                        </div>
                                            
                                        <div aria-labelledby='appointments-tab-<?php echo $course['course']->id; ?>' class="tab-pane fade <?php if(!isset($_GET['t'])) echo 'show active'; ?>" id='appointments<?php echo $course['course']->id; ?>' role='tabpanel'>
                                                                
                                                                <table style="width: 100%;" class="table table-hover table-striped table-bordered dynamic-table">
                                                                <thead>
                                                                <tr>
                                                                    <th>Date</th>
                                                                    <th>Time</th>
                                                                    <th>Unterrichtsform</th>
                                                                    <th>Module Item</th>
                                                                    <th>Room</th>
                                                                    <th></th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                <?php 
                                                                    if(!empty($course['appointments'])) {
                                                                        foreach($course['appointments'] as $appointment) {
                                                                ?>
                                                                <tr id="app-<?php echo $appointment['appointment']->id; ?>">
                                                                    <td><?php echo $appointment['appointment']->date; ?></td>
                                                                    <td><?php echo $appointment['appointment']->time.' - '.$appointment['appointment']->time_end; ?></td>
                                                                    <td><?php if($appointment['appointment']->appointment_form == 'Presence') echo 'Präsenz';
                                        elseif($appointment['appointment']->appointment_form == 'Digital') echo 'Digital'; 
                                        elseif($appointment['appointment']->appointment_form == 'Self-Learning') echo 'Selbstlernheit'; 
                                        elseif($appointment['appointment']->appointment_form == 'Other') echo 'Andere';
                                        else echo 'Unbekannt'; ?></td>
                                        
                                                                    <td><?php echo $appointment['appointment']->title; ?></td>
                                                                    <td><?php echo $appointment['room'];
                                                                            if(isset($appointment['location'])) echo ' ('.$appointment['location'].')'; ?></td>
                                                                    <td>
<?php if($course['course']->type == 'Regular') { ?>
                                                                    <button class="btn btn-success" onclick="open_register('<?php echo $course['course']->id; ?>' ,'<?php echo date_format(new DateTime($appointment['appointment']->date),'d-m-Y'); ?>', '<?php echo $appointment['appointment']->title; ?>', <?php echo $appointment['appointment']->id; ?>)" <?php if(date_format(new DateTime($appointment['appointment']->date),'Y-m-d')>date('Y-m-d')) echo ''; ?> >Attendance</button>
                                                               <?php } else {
                                                                   
                                                                   if (isset($appointment['attendance']) && $appointment['attendance']->id > 0 && isset( $appointment['attendance']->pdf_url) ) {
                                                                       echo '<a target="_blank" href="'.url('company_files/tagesdoku/'.$appointment['attendance']->pdf_url).'" target="_blank">View PDF</a>';

                                                                       /*

                                                                       echo '&nbsp;<a class="btn btn-primary" target="_blank" href="'.route('tagasdokuSend',['id'=>base64_encode($appointment['attendance']->id)]).'" target="_blank">Send</a>'; 
                                                                       */
                                                                 
                                                                   } else {
                                                                     
                                                                   ?>     <button class="btn btn-success" onclick="open_tagesdoku(<?php echo $course['course']->id; ?> , <?php echo $appointment['appointment']->id; ?>)"  >Tagesdoku</button>
                                                            <?php   } } ?>        </td>
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
                                                <?php } } ?>
                                            </div>
                                        </div>
                                    </div>
                                        
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
<?php include(app_path().'/common/footer.php'); ?>

<div class="modal fade" id="contract" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="<?php echo url('admin/convert-prospect'); ?>" method="post">
                    <input type="hidden" name="c_id" value="0" id="c_id">
                    <?php echo csrf_field(); ?>
              <div class="modal-header">
                  <h4 class="modal-title" id="modal-title">Create Contract</h4>
              </div>
              <div class="modal-body">
                  <p class="alert alert-success" id="ass-success" style="display:none;"></p>
                  <div class="row">
                      <div class="col-12 col-lg-12" style="display:none;">
                          <div class="form-group">
                            <label for="exampleInputEmail1">Convert to <font style="color:red;">*</font></label>
                              <select name="convert" id="convert" class="form-control" required>
                                  <option value="">Please Select</option>
                                  <option value="Student" selected>Student</option>
                                  <option value="Coachee">Coachee</option>
                              </select>
                          </div>
                      </div>
                  </div>
                  
                  <div class="row">
                      <div class="col-12 col-lg-12">
                          <div id="accordion2" class="accordion-wrapper mb-3">
                                                    <div class="">
                                                        <div id="headingOne2" class="card-header" style="background:#E2E2E0;">
                                                            <button type="button" data-toggle="collapse" data-target="#collapseOne2" aria-expanded="false" aria-controls="collapseOne" class="text-left m-0 p-0 btn btn-link btn-block collapsed">
                                                                <h5 class="m-0 p-0" style="font-size:18px;"><?php echo trans('forms.select_products_modules'); ?></h5>
                                                            </button>
                                                        </div>
                                                        <div data-parent="#accordion2" id="collapseOne2" aria-labelledby="headingOne2" class="collapse" style="">
                                                            <div class="card-body">
                                                                <ul>
                                                                    <?php 
                                                                    if(!empty($products)) {
                                                                        foreach($products as $p) {
                                                                            $p_id=$p['product']->id;
                                                                    ?>
                                                                    <li><input type="checkbox" name="products[]" value="<?php echo $p['product']->id; ?>"> <?php echo $p['product']->title.' ('.trans('forms.lessons').': '.$p['total_lessons'].' '.trans('forms.total_cost').': $'.$p['total_cost'].')'; ?></li>
                                                                    
                                                                    <ul>
                                                                        <?php 
                                                                    if(!empty($p['modules'])) {
                                                                        foreach($p['modules'] as $m) {
                                                                    ?>
                                                                    <li><input type="checkbox" name="modules<?php echo $p_id; ?>[]" value="<?php echo $m['module']->id; ?>"> <?php echo $m['module']->title.' ('.trans('forms.lessons').': '.$m['total_lessons'].' '.trans('forms.total_cost').': $'.$m['total_cost'].')'; ?></li>
                                                                        
                                                                        <ul>
                                                                            <?php 
                                                                    if(!empty($m['items'])) {
                                                                        foreach($m['items'] as $item) {
                                                                    ?>
                                                                    <li><input type="checkbox" name="items<?php echo $p_id; ?>[]" value="<?php echo $item['item']->id; ?>"> <?php echo $item['item']->title.' ('.trans('forms.lessons').': '.$item['item']->lessons.' '.trans('forms.total_cost').': $'.$item['item']->lessons*$item['item']->price_lessons.')'; ?></li>
                                                                        <?php } } ?>
                                                                        </ul>
                                                                        <?php } } ?>
                                                                        
                                                                    </ul>
                                                                    <li style="list-style-type:none; padding-bottom:15px;"></li>
                                                                    <?php } } ?>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                      </div>
                  </div>
                  
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default pull-right" data-dismiss="modal" id="add-appointment-close">Cancel</button>
                <button type="submit" class="btn btn-primary pull-right" style="margin-right:10px;" id="submit_btn">Submit</button>
              </div>
                  </form>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>

<div class="modal fade" id="error-modal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="" method="post">
                    <input type="hidden" name="c_id" value="0" id="c_id">
                    <?php echo csrf_field(); ?>
              <div class="modal-header">
                  <h4 class="modal-title" id="modal-title">Error</h4>
              </div>
              <div class="modal-body">
                  <p class="alert alert-success" id="error"></p>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default pull-right" data-dismiss="modal" id="add-appointment-close">Close</button>
              </div>
                  </form>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>

<script src="<?php echo url('digital_signature/signature_pad.min.js'); ?>"></script>
<script src="<?php echo url('digital_signature/signature_pad2.min.js'); ?>"></script>

<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script>
    function open_register(course_id, date, title, appointment_id)
    {
        $("#attendance_date").val(date);
        $("#attendance_date_text").text(date);
        $("#appointment_id_"+course_id).val(appointment_id);
        $("#btn_register_submit").click();
        $("#module_item").val(title);
        $("#notes_box").show();
        
        $('#appointments-tab-'+course_id).removeClass('active');
        $('#appointments'+course_id).removeClass('show active');
        $('#attendance-tab-'+course_id).addClass('active');
        $('#attendance'+course_id).addClass('show active');
    }


   
    
    $(".accept_appointment").submit(function(e){
        e.preventDefault();
        $(".alert").hide();
        var id=$(this).attr('data-id');
        $("#app-btn-"+id).attr('disabled', true);
        var formData=new FormData(this);
        
        $.ajax({
                url: "<?php echo url('accept-appointment') ?>",
                type: "POST",
                data:  formData,
                beforeSend: function(){ //alert('sending');
                },
                contentType: false,
                processData:false,
                success: function(data) { //alert(data);
                    $("#app-btn-"+data.id).attr('disabled', false);
                    //success
                    // here we will handle errors and validation messages
                    if ( ! data.success) {
                        if(data.error!='') {
                        $("#error-"+data.course).text(data.error);
                        $("#error-"+data.course).show();
                        var scrollPos =  $("#error-"+data.course).offset().top;
                        $(window).scrollTop(scrollPos);
                        }
                    } else {
                        // ALL GOOD! just show the success message!
                        $("#app-btn-"+data.id).html("<i class='fa fa-check'></i> Accepted");
                    }
                },
                error: function()  {
                    //error
                }           
        });
    });
    
    $(document).on('click', '.browse', function(){
                    var file = $(this).prev();
                    file.trigger('click');
    });
    
    $(document).on('change', '.file', function(e){
                      /*var o=new FileReader;
                      o.readAsDataURL(e.target.files[0]),o.onloadend=function(o){
                          $("#current_img").attr("src",o.target.result); 
                      }*/
                    $("#file_name").text($(this).val().replace(/C:\\fakepath\\/i, ''));
    });
    
    function show_form(type)
    {
        //$("#form-field-box").empty();
        $("#contacts-form").show();
        $(".col-md-3").show();
        $(".col-md-6").show();
        $(".col-md-12").show();
        $(".required").attr('required', 'required');
        $("#company_name").hide(); $("#company_name_field").removeAttr('required');
        
        $("#type_checkbox_student").hide();
        $("#type_checkbox_trainer").hide();
        
        if(type=='Coachee')
        {
            $("#marital_status").hide();
            $("#marital_status").removeAttr('required');
        }
        else if(type=='Student')
        {
            $("#marital_status").hide();
            $("#marital_status").removeAttr('required');
            
            $("#type_checkbox_student").show();
            $("#type_checkbox_trainer").hide();
        }
        else if(type=='Clerk')
        {
            
        }
        else if(type=='Coach')
        {
            $("#marital_status").hide();
            $("#marital_status").removeAttr('required');
            
            $("#type_checkbox_trainer").show();
            $("#type_checkbox_student").hide();
        }
        else if(type=='Lecturer')
        {
            $("#marital_status").hide();
            $("#marital_status").removeAttr('required');
        }
        else if(type=='Internship Company')
        {
            $("#first_name").hide(); $("#first_name_field").removeAttr('required');
            $("#last_name").hide(); $("#last_name_field").removeAttr('required');
            $("#gender").hide(); $("#gender_field").removeAttr('required');
            $("#dob").hide(); $("#dob_field").removeAttr('required');
            $("#mobile").hide(); $("#mobile_field").removeAttr('required');
            $("#marital_status").hide(); $("#marital_status_field").removeAttr('required');
            $("#child_care").hide(); $("#child_care_field").removeAttr('required');
            $("#funding_source").hide(); $("#funding_source_field").removeAttr('required');
            $("#funding_source_address").hide(); $("#funding_source_address_field").removeAttr('required');
            $("#period").hide(); $("#period_field").removeAttr('required');
            $("#voucher").hide(); $("#voucher_field").removeAttr('required');
            
            $("#company_name").show(); $("#company_name_field").attr('required', 'required');
        }
        else if(type=='Prospect' || type=='Expert Advisor')
        {
            $("#child_care").hide(); $("#child_care_field").removeAttr('required');
            $("#funding_source").hide(); $("#funding_source_field").removeAttr('required');
            $("#contact_person").hide(); $("#contact_person_field").removeAttr('required');
            $("#funding_source_address").hide(); $("#funding_source_address_field").removeAttr('required');
            $("#period").hide(); $("#period_field").removeAttr('required');
            $("#voucher").hide(); $("#voucher_field").removeAttr('required');
        }
        else if(type=='Expert Advisor')
        {
            $("#marital_status").hide(); $("#marital_status_field").removeAttr('required');
            
        }
        else if(type=='Other Contacts')
        {
            $("#child_care").hide(); $("#child_care_field").removeAttr('required');
            $("#contact_person").hide(); $("#contact_person_field").removeAttr('required');
            $("#funding_source").hide(); $("#funding_source_field").removeAttr('required');
            $("#funding_source_address").hide(); $("#funding_source_address_field").removeAttr('required');
            $("#period").hide(); $("#period_field").removeAttr('required');
            $("#voucher").hide(); $("#voucher_field").removeAttr('required');
            
        }
        else $("#contacts-form").hide();
    }
    
    $('.date_range').daterangepicker({
        startDate: new Date(),
        locale: {
            format: 'DD-MM-YYYY'
        }
    });
    
    $('.today_calendar').daterangepicker({
        singleDatePicker: true,
        startDate: new Date(),
        locale: {
            format: 'DD-MM-YYYY'
        }
    });
    
    function change_status(status, s_id, date, c_id, late_field)
    {
        if(status!='2') $(late_field).val('0');
        var late=$(late_field).val();
        var formData=new FormData();
        var token='<?php echo csrf_token(); ?>';
        formData.append('_token', token);
        formData.append('status', status);
        formData.append('late', late);
        formData.append('student_id', s_id);
        formData.append('course_id', c_id);
        formData.append('date', date);
        
        
        $.ajax({
                url: "<?php echo url('mark-attendance') ?>",
                type: "POST",
                data:  formData,
                beforeSend: function(){ //alert('sending');
                },
                contentType: false,
                processData:false,
                success: function(data) { //console.log(data);
                    //success
                    // here we will handle errors and validation messages
                    if ( ! data.success) {
                    } else {
                        // ALL GOOD! just show the success message!
                    }
                },
                error: function()  {
                    //error
                }           
        });
    }
    
    function update_teaching_data(course_id)
    {
        var app_id=$("#appointment_id_"+course_id).val();
        var teaching_form=$("#teaching_form_"+course_id).val();
        var teaching_method=$("#teaching_method_"+course_id).val();
        
        var formData=new FormData();
        var token='<?php echo csrf_token(); ?>';
        formData.append('_token', token);
        formData.append('course_id', course_id);
        formData.append('appointment_id', app_id);
        formData.append('teaching_form', teaching_form);
        formData.append('teaching_method', teaching_method);
        
        $.ajax({
                url: "<?php echo url('update-teaching-data') ?>",
                type: "POST",
                data:  formData,
                beforeSend: function(){ //alert('sending');
                },
                contentType: false,
                processData:false,
                success: function(data) { //console.log(data);
                    //success
                    // here we will handle errors and validation messages
                    if ( ! data.success) {
                    } else {
                        // ALL GOOD! just show the success message!
                        $("#save_btn_"+course_id).html('<i class="fa fa-check"></i> Saved');
                        setTimeout(function(){ $("#save_btn_"+course_id).text('Save'); }, 3000);
                    }
                },
                error: function()  {
                    //error
                }           
        });
    }
    
    function change_date(course_id)
    {
        var date=$("#attendance_date").val();
        var app_id=$("#appointment_id_"+course_id).val();
        var formData=new FormData();
        var token='<?php echo csrf_token(); ?>';
        formData.append('_token', token);
        formData.append('course_id', course_id);
        formData.append('appointment_id', app_id);
        formData.append('date', date);
        
        $.ajax({
                url: "<?php echo url('attendance-register-date') ?>",
                type: "POST",
                data:  formData,
                beforeSend: function(){ //alert('sending');
                },
                contentType: false,
                processData:false,
                success: function(data) { //console.log(data);
                    //success
                    // here we will handle errors and validation messages
                    if ( ! data.success) {
                    } else {
                        // ALL GOOD! just show the success message!
                        $("#attendance-box").empty();
                        $("#attendance-box").append(data.students);
                        $("#appointment_id_"+course_id).val(data.appointment);
                        //$("#teaching_form_"+course_id).val(data.teaching_form);
                        //$("#teaching_method_"+course_id).val(data.teaching_method);
                        if(data.teaching_form!= null)
                         var teaching_form=data.teaching_form.split(',');
                        else 
                          var teaching_form='';
                          
                        var arr=[];
                        $(teaching_form).each(function(v, k){
                            arr.push(k);
                        });
                        $('#teaching_form_'+course_id).val(arr).trigger('change');
                        
                        if(data.teaching_method!= null)
                         var teaching_method=data.teaching_method.split(',');
                        else 
                          var teaching_method='';
                          
                        
                        var arr2=[];
                        $(teaching_method).each(function(v, k){
                            arr2.push(k);
                        });
                        $('#teaching_method_'+course_id).val(arr2).trigger('change');
                        //$('.select-multiple').select2();
                    }
                },
                error: function()  {
                    //error
                }           
        });
        
        $.ajax({
                url: "<?php echo url('attendance-fetch-notes-date') ?>",
                type: "POST",
                data:  formData,
                beforeSend: function(){ //alert('sending');
                },
                contentType: false,
                processData:false,
                success: function(data) { //console.log(data);
                    //success
                    // here we will handle errors and validation messages
                    if ( ! data.success) {
                    } else {
                        // ALL GOOD! just show the success message!
                        $("#notes-box2").empty();
                        $("#notes-box2").append(data.notes);
                    }
                },
                error: function()  {
                    //error
                }           
        });
    }
    
    function add_note(th, course_id)
    {
        var notes=$("#note").val();
        if(notes!='')
        {
            notes=notes.replace(/\n/g,"<br>");
            var formData=new FormData();
            var token='<?php echo csrf_token(); ?>';
            formData.append('_token', token);
            formData.append('course_id', course_id);
            formData.append('notes', notes);
        
        
        $.ajax({
                url: "<?php echo url('attendance-add-notes') ?>",
                type: "POST",
                data:  formData,
                beforeSend: function(){ //alert('sending');
                        $(th).attr('disabled', true);
                },
                contentType: false,
                processData:false,
                success: function(data) { //console.log(data);
                    //success
                    $(th).attr('disabled', false);
                    $("#note").val('');
                    // here we will handle errors and validation messages
                    if ( ! data.success) {
                    } else {
                        // ALL GOOD! just show the success message!
                        $("#notes-box").prepend(data.notes);
                    }
                },
                error: function()  {
                    //error
                }           
        });
        }
    }
    
    function add_note2(th, course_id)
    {
        var notes=$("#note2").val();
        var date=$("#attendance_date").val();
        if(notes!='')
        {
            notes=notes.replace(/\n/g,"<br>");
            var formData=new FormData();
            var token='<?php echo csrf_token(); ?>';
            formData.append('_token', token);
            formData.append('course_id', course_id);
            formData.append('notes', notes);
            formData.append('date', date);
        
        
        $.ajax({
                url: "<?php echo url('attendance-add-notes-date') ?>",
                type: "POST",
                data:  formData,
                beforeSend: function(){ //alert('sending');
                        $(th).attr('disabled', true);
                },
                contentType: false,
                processData:false,
                success: function(data) { //console.log(data);
                    //success
                    $(th).attr('disabled', false);
                    $("#note2").val('');
                    // here we will handle errors and validation messages
                    if ( ! data.success) {
                    } else {
                        // ALL GOOD! just show the success message!
                        $("#notes-box2").prepend(data.notes);
                    }
                },
                error: function()  {
                    //error
                }           
        });
        }
    }
    
    function change_late(student_id, date, course_id, late)
    {
        change_status('2', student_id, date, course_id, '#late-'+student_id);
        $("input[name=status-"+student_id+"][value=2]").attr('checked', 'checked');
        
        var formData=new FormData();
            var token='<?php echo csrf_token(); ?>';
            formData.append('_token', token);
            formData.append('course_id', course_id);
            formData.append('student_id', student_id);
            formData.append('date', date);
            formData.append('late', late);
        
        
        $.ajax({
                url: "<?php echo url('attendance-late') ?>",
                type: "POST",
                data:  formData,
                beforeSend: function(){ //alert('sending');
                },
                contentType: false,
                processData:false,
                success: function(data) { //console.log(data);
                    //success
                    // here we will handle errors and validation messages
                    if ( ! data.success) {
                    } else {
                        // ALL GOOD! just show the success message!
                    }
                },
                error: function()  {
                    //error
                }           
        });
    }
    
    function update_notes(student_id, date, course_id, notes)
    {
        var formData=new FormData();
            var token='<?php echo csrf_token(); ?>';
            formData.append('_token', token);
            formData.append('course_id', course_id);
            formData.append('student_id', student_id);
            formData.append('date', date);
            formData.append('notes', notes);
        
        
        $.ajax({
                url: "<?php echo url('update-student-attendance-notes') ?>",
                type: "POST",
                data:  formData,
                beforeSend: function(){ //alert('sending');
                },
                contentType: false,
                processData:false,
                success: function(data) { //console.log(data);
                    //success
                    // here we will handle errors and validation messages
                    if ( ! data.success) {
                    } else {
                        // ALL GOOD! just show the success message!
                    }
                },
                error: function()  {
                    //error
                }           
        });
    }
    
    function update_motivationrating(student_id, date, course_id, rating)
    {
        var formData=new FormData();
            var token='<?php echo csrf_token(); ?>';
            formData.append('_token', token);
            formData.append('course_id', course_id);
            formData.append('student_id', student_id);
            formData.append('date', date);
            formData.append('rating', rating);
        
        
        $.ajax({
                url: "<?php echo url('update-student-attendance-motivationrating') ?>",
                type: "POST",
                data:  formData,
                beforeSend: function(){ //alert('sending');
                },
                contentType: false,
                processData:false,
                success: function(data) { //console.log(data);
                    //success
                    // here we will handle errors and validation messages
                    if ( ! data.success) {
                    } else {
                        // ALL GOOD! just show the success message!
                    }
                },
                error: function()  {
                    //error
                }           
        });
    }
    function update_servicerating(student_id, date, course_id, rating)
    {
        var formData=new FormData();
            var token='<?php echo csrf_token(); ?>';
            formData.append('_token', token);
            formData.append('course_id', course_id);
            formData.append('student_id', student_id);
            formData.append('date', date);
            formData.append('rating', rating);
        
        
        $.ajax({
                url: "<?php echo url('update-student-attendance-servicerating') ?>",
                type: "POST",
                data:  formData,
                beforeSend: function(){ //alert('sending');
                },
                contentType: false,
                processData:false,
                success: function(data) { //console.log(data);
                    //success
                    // here we will handle errors and validation messages
                    if ( ! data.success) {
                    } else {
                        // ALL GOOD! just show the success message!
                    }
                },
                error: function()  {
                    //error
                }           
        });
    }
    
    function update_result_test(test_id, student_id, date, course_id, result)
    {
        var formData=new FormData();
            var token='<?php echo csrf_token(); ?>';
            formData.append('_token', token);
            formData.append('test_id', test_id);
            formData.append('course_id', course_id);
            formData.append('student_id', student_id);
            formData.append('date', date);
            formData.append('result', result);
        
        
        $.ajax({
                url: "<?php echo url('update-student-test-result') ?>",
                type: "POST",
                data:  formData,
                beforeSend: function(){ //alert('sending');
                },
                contentType: false,
                processData:false,
                success: function(data) { //console.log(data);
                    //success
                    // here we will handle errors and validation messages
                    if ( ! data.success) {
                    } else {
                        // ALL GOOD! just show the success message!
                    }
                },
                error: function()  {
                    //error
                }           
        });
    }
    
    function update_score_test(test_id, student_id, date, course_id, score)
    {
        var formData=new FormData();
            var token='<?php echo csrf_token(); ?>';
            formData.append('_token', token);
            formData.append('test_id', test_id);
            formData.append('course_id', course_id);
            formData.append('student_id', student_id);
            formData.append('date', date);
            formData.append('score', score);
        
        
        $.ajax({
                url: "<?php echo url('update-student-test-score') ?>",
                type: "POST",
                data:  formData,
                beforeSend: function(){ //alert('sending');
                },
                contentType: false,
                processData:false,
                success: function(data) { //console.log(data);
                    //success
                    // here we will handle errors and validation messages
                    if ( ! data.success) {
                    } else {
                        // ALL GOOD! just show the success message!
                    }
                },
                error: function()  {
                    //error
                }           
        });
    }
    
    function update_notes_test(test_id, student_id, date, course_id, notes)
    {
        var formData=new FormData();
            var token='<?php echo csrf_token(); ?>';
            formData.append('_token', token);
            formData.append('test_id', test_id);
            formData.append('course_id', course_id);
            formData.append('student_id', student_id);
            formData.append('date', date);
            formData.append('notes', notes);
        
        
        $.ajax({
                url: "<?php echo url('update-student-test-notes') ?>",
                type: "POST",
                data:  formData,
                beforeSend: function(){ //alert('sending');
                },
                contentType: false,
                processData:false,
                success: function(data) { //console.log(data);
                    //success
                    // here we will handle errors and validation messages
                    if ( ! data.success) {
                    } else {
                        // ALL GOOD! just show the success message!
                    }
                },
                error: function()  {
                    //error
                }           
        });
    }
    
    $(document).ready(function(){
        $('.select-multiple').select2();
    });
    
</script>



<script>


   
            
            
    
    $("#signature-form").submit(function(e){
        e.preventDefault();
        $("#error").hide();
        
        if (signaturePad.isEmpty()) {
            $("#error").text('Please provide a signature first.');
            $("#error").show();
        } else {
            var dataURL = signaturePad.toDataURL();
            
            var id='X'
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




 function open_tagesdoku(course_id, appointment_id)
    {
        $('#tagesdoku'+course_id).html('');

        $.post("<?php echo route('ajaxTagesdokuDetails');?>",
          {
            _token: "<?php echo csrf_token();?>",
            appointment_id: appointment_id
          },
          function(data, status){
            $('#tagesdoku'+course_id).html(data);
         });

        
        
        $('#appointments-tab-'+course_id).removeClass('active');
        $('#appointments'+course_id).removeClass('show active');

        $('#tagesdoku-tab-'+course_id).addClass('active');
        $('#tagesdoku'+course_id).addClass('show active');
        
       
    }
        </script>