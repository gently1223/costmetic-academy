<?php

include (app_path() . '/common/panel/header.php');
$days_i = 0;
?>
<link href="https://www.jqueryscript.net/css/jquerysctipttop.css"
	rel="stylesheet" type="text/css">
<link href="<?php echo url('hummingbird/hummingbird-treeview.css'); ?>"
	rel="stylesheet" type="text/css">
<style>
.hummingbird-treeview * {
	font-size: 18px;
}
</style>
<div class="app-inner-layout app-inner-layout-page">
	<div class="app-inner-layout__wrapper">
		<div class="app-inner-layout__sidebar">
			<div class="app-layout__sidebar-inner dropdown-menu-rounded">
				<div class="nav flex-column">
					<div class="nav-item-header text-primary nav-item">Dashboards
						Examples</div>
					<a class="dropdown-item active" href="analytics-dashboard.html">Analytics</a>
					<a class="dropdown-item" href="management-dashboard.html">Management</a>
					<a class="dropdown-item" href="advertisement-dashboard.html">Advertisement</a>
					<a class="dropdown-item" href="index.html">Helpdesk</a> <a
						class="dropdown-item" href="monitoring-dashboard.html">Monitoring</a>
					<a class="dropdown-item" href="crypto-dashboard.html">Cryptocurrency</a>
					<a class="dropdown-item" href="pm-dashboard.html">Project
						Management</a> <a class="dropdown-item"
						href="product-dashboard.html">Product</a> <a class="dropdown-item"
						href="statistics-dashboard.html">Statistics</a>
				</div>
			</div>
		</div>
		<div class="app-inner-layout__content pt-0">
			<div class="tab-content">
				<div class="container-fluid">
					<div class="card mb-3">
                                            <?php if(Session::has('error')) { ?>
                                            <p
							class="alert alert-danger"><?php echo Session::get('error'); ?></p>
                                            <?php } ?>
                                            <?php if(Session::has('success')) { ?>
                                            <p
							class="alert alert-success"><?php echo Session::get('success'); ?></p>
                                            <?php } ?>
                                            
                                        <form class="" action=""
							method="post" onsubmit="return check_data();" id="app_form">
                                            <?php echo csrf_field(); ?>
                                            <input type="hidden"
								name="send" value="0" id="send">
							<div id="form-box">
								<div class="main-card mb-2 card">
									<div class="card-body">

										<div class="col-12"
											style="margin-bottom: 25px; padding-left: 0px; padding-right: 0px;">
											<div class="position-relative form-group">
												<label for="exampleEmail11" class="">Create appointments
													within:</label> <input type="text"
													name="appointments_period" class="form-control date_range"
													id="date-range-<?php echo $course->id; ?>" required
													onchange="appointments_date(this, '<?php echo $course->id; ?>');">
												<p id="appointments-date-error-<?php echo $course->id; ?>"
													class="alert alert-danger mt-2 mb-0" style="display: none;">
													<i class="fa fa-info-circle"></i> Given days doesn't come
													within the date range. Therefore, no appointments will be
													generated.
												</p>
											</div>
											<div class="position-relative form-group">
															<label for="exampleEmail11" class="">Unterrichtsform</label>
															<select type="text" name="appointment_form"
																class="form-control select" required
																style="width: 100%;" id="appointment_form">
																<option value="Please Select">Bitte auswählen</option>
														<option value="Presence">Präsenzunterricht</option>
																<option value="Digital">Digitalunterricht</option>
																<option value="Self-Learning">Selbstlernheit</option>
																<option value="Other">Andere form</option>
																	</select>
														</div>

											<label for="exampleEmail11" class="">Select Module Items:</label>
											<input type="hidden" name="mis"
												id="mis-<?php echo $course->id; ?>"
												value="<?php echo $course->mis; ?>">
											<div id="treeview_container"
												class="hummingbird-treeview well h-scroll-large">
												<ul id="treeview-products-<?php echo $course->id; ?>"
													class="hummingbird-base">
                                                                    <?php

$course_mis = array();
                                                                    if ($course->mis != '')
                                                                        $course_mis = explode(';', $course->mis);

                                                                    if (! empty($courses[0]['products'])) {
                                                                        foreach ($courses[0]['products'] as $p) {
                                                                            $p_id = $p['product']->id;
                                                                            ?>
                                                                    <li>
														<i class="fa fa-plus"></i> <label><?php echo $p['product']->title.' ('.trans('forms.lessons').': '.$p['total_lessons'].' '.trans('forms.total_cost').': €'.$p['total_cost'].')'; ?></label>

														<ul>
                                                                        <?php
                                                                            if (! empty($p['modules'])) {
                                                                                foreach ($p['modules'] as $m) {
                                                                                    ?>
                                                                    <li>
																<i class="fa fa-plus"></i> <label><?php echo $m['module']->title.' ('.trans('forms.lessons').': '.$m['total_lessons'].' '.trans('forms.total_cost').': €'.$m['total_cost'].')'; ?></label>

																<ul>
                                                                            <?php
                                                                                    if (! empty($m['items'])) {
                                                                                        foreach ($m['items'] as $item) {
                                                                                            ?>
                                                                            <li>
																		<label><input type="checkbox"
																			name="items<?php echo $p_id; ?>[]"
																			value="<?php echo $item['item']->id; ?>"
																			onchange="mi_selected(this, '<?php echo $course->id; ?>')"> <?php echo $item['item']->title.' ('.trans('forms.lessons').': '.$item['item']->lessons.' '.trans('forms.total_cost').': €'.$item['item']->lessons*$item['item']->price_lessons.')'; ?></label>
																	</li>
                                                                        <?php } } ?>
                                                                        </ul>
															</li>
                                                                        <?php } } ?>
                                                                        
                                                                    </ul>
													</li>
                                                                    <?php } } ?>
                        </ul>
											</div>
										</div>
										<div class="col12">

											<div class="position-relative form-group">
												<label for="exampleEmail11" class=""><?php echo trans('forms.lecturer'); ?> <font
													style="color: red;">*</font></label> <select
													name="coaches[]" class="form-control select-multiple"
													required multiple="multiple" style="width: 100%;"
													style="width:100%;">
                                                            <?php

$dozents = array();
                                                            if ($course->dozents != '')
                                                                $dozents = explode(';', $course->dozents);
                                                            if (! empty($lecturers)) {
                                                                foreach ($lecturers as $coach) {
                                                                    ?>
                                                            <option
														value="<?php echo $coach['coach']->id; ?>"
														<?php if(in_array($coach['coach']->id, $dozents)) echo 'selected'; ?>><?php echo $coach['coach']->name; ?></option>
                                                            <?php } } ?>
                                                        </select>
											</div>


											<div class="position-relative form-group"
												style="margin-bottom: 25px; padding-left: 10px; padding-right: 0px;">
												<!-- Adding a checkbox for Doppel Buchung confirmation -->
												<input type="checkbox" id="doppelBuchung"
													name="doppelBuchung" value="1" /> <label
													style="padding-left: 10px;" for="doppelBuchung"><b>Bitte
														ankreuzen wenn Sie Doppelbuchung erstellen möchten.</b></label>
											</div>
										</div>

										<table class="table table-bordered">
											<thead>
												<tr>
													<th style="min-width: 250px;">Days</th>
													<th style="min-width: 85px;">From</th>
													<th style="min-width: 85px;">UE</th>
													<th style="min-width: 85px;">Break (minutes)</th>
													<th>Notes</th>
													<th></th>
													<th style="min-width: 200px;">Room</th>
												</tr>
											</thead>
											<tbody id="contract-timetable-<?php echo $course->id; ?>">
                                                <?php
                                                if (! empty($classes)) {
                                                    $i2 = 0;
                                                    foreach ($classes as $c) {
                                                        $p_id = $c['class']->id;
                                                        ?>
                                                <tr>
													<!--<td>
                                                    <input type="text" name="classes[]" class="form-control" required value="<?php echo $c['class']->name; ?>">
                                                </td>-->
													<td><input type="hidden" name="classes_id[]"
														value="<?php echo $c['class']->id; ?>">
                                                    <?php
                                                        $days = array();
                                                        if ($c['class']->day != '')
                                                            $days = explode(';', $c['class']->day);
                                                        ?>
                                                    <select
														name="days[]" class="form-control"
														style="padding-left: 0px; padding-right: 0px;" required
														onchange="day_selected(this, '<?php echo $course->id; ?>');"
														id="days-selected-<?php echo $course->id.'-'.$c['class']->id; ?>">
															<option value="Monday"
																<?php if(in_array('Monday', $days)) echo 'selected'; ?>><?php echo trans('forms.monday'); ?></option>
															<option value="Tuesday"
																<?php if(in_array('Tuesday', $days)) echo 'selected'; ?>><?php echo trans('forms.tuesday'); ?></option>
															<option value="Wednesday"
																<?php if(in_array('Wednesday', $days)) echo 'selected'; ?>><?php echo trans('forms.wednesday'); ?></option>
															<option value="Thursday"
																<?php if(in_array('Thursday', $days)) echo 'selected'; ?>><?php echo trans('forms.thursday'); ?></option>
															<option value="Friday"
																<?php if(in_array('Friday', $days)) echo 'selected'; ?>><?php echo trans('forms.friday'); ?></option>
															<option value="Saturday"
																<?php if(in_array('Saturday', $days)) echo 'selected'; ?>><?php echo trans('forms.saturday'); ?></option>
															<option value="Sunday"
																<?php if(in_array('Sunday', $days)) echo 'selected'; ?>><?php echo trans('forms.sunday'); ?></option>
													</select>
														<p id="appointments-days-error-<?php echo $course->id; ?>"
															class="alert alert-danger mt-2 mb-0"
															style="display: none;">
															<i class="fa fa-info-circle"></i> These days doesn't come
															within the date range.
														</p></td>
													<td><select class="form-control" name="froms[]"
														id="class_from"
														style="padding-left: 0px; padding-right: 0px;" required>
															<option value=""></option>
                                                            <?php

for ($i = 0; $i <= 23; $i ++) {
                                                            if ($i < 10)
                                                                $num = '0' . $i;
                                                            else
                                                                $num = $i;
                                                            ?>
                                                                <option
																value="<?php echo $num.':00'; ?>"
																<?php if(date_format(new DateTime($c['class']->fromm),'H:i')==$num.':00') echo 'selected'; ?>><?php echo $num.':00'; ?></option>
															<option value="<?php echo $num.':15'; ?>"
																<?php if(date_format(new DateTime($c['class']->fromm),'H:i')==$num.':15') echo 'selected'; ?>><?php echo $num.':15'; ?></option>
															<option value="<?php echo $num.':30'; ?>"
																<?php if(date_format(new DateTime($c['class']->fromm),'H:i')==$num.':30') echo 'selected'; ?>><?php echo $num.':30'; ?></option>
															<option value="<?php echo $num.':45'; ?>"
																<?php if(date_format(new DateTime($c['class']->fromm),'H:i')==$num.':45') echo 'selected'; ?>><?php echo $num.':45'; ?></option>
                                                            <?php } ?>
                                                    </select></td>
													<td>
														<!--<select class="form-control" name="tos[]" id="class_too" style="padding-left:0px; padding-right:0px;">
                                                            <option value=""></option>
                                                            <?php

for ($i = 0; $i <= 23; $i ++) {
                                                            if ($i < 10)
                                                                $num = '0' . $i;
                                                            else
                                                                $num = $i;
                                                            ?>
                                                                <option value="<?php echo $num.':00'; ?>" <?php if(date_format(new DateTime($c['class']->too),'H:i')==$num.':00') echo 'selected'; ?> ><?php echo $num.':00'; ?></option>
                                                                <option value="<?php echo $num.':15'; ?>" <?php if(date_format(new DateTime($c['class']->too),'H:i')==$num.':15') echo 'selected'; ?> ><?php echo $num.':15'; ?></option>
                                                                <option value="<?php echo $num.':30'; ?>" <?php if(date_format(new DateTime($c['class']->too),'H:i')==$num.':30') echo 'selected'; ?> ><?php echo $num.':30'; ?></option>
                                                                <option value="<?php echo $num.':45'; ?>" <?php if(date_format(new DateTime($c['class']->too),'H:i')==$num.':45') echo 'selected'; ?> ><?php echo $num.':45'; ?></option>
                                                            <?php } ?>
                                                    </select>--> <input
														type="number" name="ues[]" class="form-control"
														value="<?php echo $c['class']->ue; ?>" min="1" required>
													</td>
													<td><input type="number" name="breaks[]"
														class="form-control"
														value="<?php echo $c['class']->breaks; ?>" min="0"></td>
													<td><input type="text" name="notes[]" class="form-control"
														value="<?php echo $c['class']->notes; ?>"></td>
													<td>
                                                        <?php if($i2++!=0) { ?>
                                        <a href="javascript:void(0)"
														onclick="$(this).parent().parent().remove();"><i
															class="fa fa-minus-circle" style="color: red;"></i></a>
													</td>
                                                    <?php } ?>
                                                <td><select
														class="form-control" name="rooms[]"
														style="padding-left: 0px; pading-right: 0px;">
															<option value="automatic">Automatisch</option>
                                                            <?php
                                                        if (! empty($rooms)) {
                                                            foreach ($rooms as $room) {
                                                                ?>
                                                            <option
																value="<?php echo $room['room']->id; ?>"
																data-name="<?php echo $room['room']->name.' ('.$room['location'].')'; ?>"
																<?php if($room['room']->id==$c['class']->room) echo 'selected'; ?>
																data-capacity="<?php echo $room['room']->capacity; ?>"><?php echo $room['room']->name.' ('.$room['location'].')'; ?></option>
                                                            <?php } } ?>
                                                        </select></td>
												</tr>
                                                <?php $days_i++; } } ?>
                                            </tbody>
										</table>
										<p class="alert alert-warning" id="room-manual-warning">Note:
											Manually selected rooms will be booked, even when it is
											already booked in other Umschulung or Coaching</p>

										<a href="javascript:void(0)"
											onclick="new_class('#contract-timetable-<?php echo $course->id; ?>', '<?php echo $course->id; ?>')"><i
											class="fa fa-plus"></i> Add new</a><br>

										<div>
											<p class="alert alert-danger" id="course-error"
												style="display: none;"></p>
											<button class="mt-2 btn btn-primary"><?php echo trans('forms.generate_appointments'); ?></button>
										</div>
									</div>
								</div>

							</div>
						</form>

						<div class="card-body">
							<table style="width: 100%;" id="example3"
								class="table table-hover table-striped table-bordered">
								<thead>
									<tr>
										<th></th>
										<th>Date</th>
										<th>Time</th>
										<th>Unterrichtsform</th>
										<th>Module Name > Module Item</th>
										<th>UE</th>
										<th>Room</th>
										<th>Dozenten</th>
										<th>Status</th>
									</tr>
								</thead>
								<tbody>
                                                        <?php

$send = 0;
                                                        if (! empty($appointments)) {
                                                            foreach ($appointments as $appointment) {
                                                                if ($appointment['appointment']->status == '0')
                                                                    $send = 1;
                                                                ?>
                                                    <tr
										id="app-<?php echo $appointment['appointment']->id; ?>">
										<td style="width: 20px;">
											<center>
												<form action="" method="post" class="delete_appointment">
                                                                <?php echo csrf_field(); ?>
                                                                <input
														type="hidden" name="id"
														value="<?php echo $appointment['appointment']->id; ?>">
													<button
														style="background: transparent; border: 0px; cursor: pointer;"
														onclick="return confirm('Are you sure you want to delete this appointment?');">
														<i class="fa fa-trash" style="color: red;"></i>
													</button>
												</form>
											</center>
										</td>
										<td><?php echo $appointment['appointment']->date; ?></td>
										<td><?php echo $appointment['appointment']->time.' - '.$appointment['appointment']->time_end; ?></td>
										<td><?php if($appointment['appointment']->appointment_form == 'Presence') echo 'Präsenz';
										elseif($appointment['appointment']->appointment_form == 'Digital') echo 'Digital'; 
										elseif($appointment['appointment']->appointment_form == 'Self-Learning') echo 'Selbstlernheit'; 
										elseif($appointment['appointment']->appointment_form == 'Other') echo 'Andere';
										else echo 'Unbekannt'; ?></td>
										<td><?php echo $appointment['appointment']->title; ?></td>
										<td><?php echo $appointment['appointment']->ue; ?></td>
										<td><?php echo $appointment['room']; ?></td>
										<td><?php echo $appointment['dozents']; ?></td>
										<td>
                                                        
                                                            <?php
                                                                /*
                                                                 * status = 0 = created
                                                                 * status = 1 = accepted
                                                                 * status = 2 = sent
                                                                 * status = 3 = cancelled (after accepting appointment)
                                                                 * status = 4 = rejected
                                                                 */
                                                                if ($appointment['appointment']->status == '1') {
                                                                    echo '<span style="color:#3ac47d;"><i class="fa fa-check"></i> Accepted</span><br><br> ' . $appointment['coach'];
                                                                } else if ($appointment['appointment']->status == '2')
                                                                    echo 'Gesendet';
                                                                else if ($appointment['appointment']->status == '4')
                                                                    echo 'Abgelehnt';
                                                               else if ($appointment['appointment']->status == '5')
                                                                    echo 'Geändert durch admin';
                                                               else if ($appointment['appointment']->status == '3')
                                                                        echo 'Storniert';
                                                               else
                                                                   echo $appointment['appointment']->status;
                                                                ?>
                                                        </td>
									</tr>
                                                    <?php } } ?>
                                                    </tbody>
								<tfoot>
								</tfoot>
							</table>
							<div>
								<p class="alert alert-danger" id="course-error"
									style="display: none;"></p>
								<button class="mt-2 btn btn-primary" type="button"
									onclick="$('#app_form').submit();"><?php echo trans('forms.generate_new_appointments'); ?></button>
                                                <?php if($send==1) { ?>
                                            <button
									class="mt-2 btn btn-success"
									onclick="$('#send').val('1'); $('#app_form').submit();"
									type="button">Send to Dozents</button>
                                                <?php } ?>
                                            </div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</div>


<?php
if (! empty($courses) and 0) {
    foreach ($courses as $course) {
        ?>
<div class="modal fade" id="course-<?php echo $course['course']->id; ?>"
	tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="modal-title">Course</h4>
			</div>
			<div class="modal-body">
				<ul class='nav nav-tabs mb-3' id='profile-form-tab' role='tablist'>
					<li class='nav-item'><a
						aria-controls='products-<?php echo $course['course']->id; ?>'
						aria-selected='true' class="nav-link active" data-toggle='tab'
						href='#products-<?php echo $course['course']->id; ?>'
						id='products-tab-<?php echo $course['course']->id; ?>' role='tab'>Products</a>
					</li>
					<li class='nav-item'><a
						aria-controls='timetable-<?php echo $course['course']->id; ?>'
						aria-selected='false' class="nav-link" data-toggle='tab'
						href='#timetable-<?php echo $course['course']->id; ?>'
						id='timetable-tab-<?php echo $course['course']->id; ?>' role='tab'>Timetable</a>
					</li>
					<li class='nav-item'><a
						aria-controls='students-<?php echo $course['course']->id; ?>'
						aria-selected='false' class="nav-link" data-toggle='tab'
						href='#students-<?php echo $course['course']->id; ?>'
						id='students-tab-<?php echo $course['course']->id; ?>' role='tab'>Students</a>
					</li>
					<li class='nav-item'><a
						aria-controls='appointments-<?php echo $course['course']->id; ?>'
						aria-selected='false' class="nav-link" data-toggle='tab'
						href='#appointments-<?php echo $course['course']->id; ?>'
						id='appointments-tab-<?php echo $course['course']->id; ?>'
						role='tab'>Appointments</a></li>
				</ul>
				<div class='tab-content' id='profile-form-content'>
					<p class="alert alert-success"
						id="course_success-<?php echo $course['course']->id; ?>"
						style="display: none;"></p>
					<p class="alert alert-danger"
						id="course_error-<?php echo $course['course']->id; ?>"
						style="display: none;"></p>

					<div
						aria-labelledby='products-tab-<?php echo $course['course']->id; ?>'
						class="tab-pane fade show active"
						id='products-<?php echo $course['course']->id; ?>' role='tabpanel'>
						<ul>
                                                                    <?php
        if (! empty($course['products'])) {
            foreach ($course['products'] as $p) {
                $p_id = $p['product']->id;
                ?>
                                                                    <li><?php echo $p['product']->title.' ('.trans('forms.lessons').': '.$p['total_lessons'].' '.trans('forms.total_cost').': $'.$p['total_cost'].')'; ?></li>

							<ul>
                                                                        <?php
                if (! empty($p['modules'])) {
                    foreach ($p['modules'] as $m) {
                        ?>
                                                                    <li><?php echo $m['module']->title.' ('.trans('forms.lessons').': '.$m['total_lessons'].' '.trans('forms.total_cost').': $'.$m['total_cost'].')'; ?></li>

								<ul>
                                                                            <?php
                        if (! empty($m['items'])) {
                            foreach ($m['items'] as $item) {
                                ?>
                                                                    <li><?php echo $item['item']->title.' ('.trans('forms.lessons').': '.$item['item']->lessons.' '.trans('forms.total_cost').': $'.$item['item']->lessons*$item['item']->price_lessons.')'; ?></li>
                                                                        <?php } } ?>
                                                                        </ul>
                                                                        <?php } } ?>
                                                                        
                                                                    </ul>
							<li style="list-style-type: none; padding-bottom: 15px;"></li>
                                                                    <?php } } ?>
                        </ul>
					</div>

					<div
						aria-labelledby='timetable-tab-<?php echo $course['course']->id; ?>'
						class="tab-pane fade"
						id='timetable-<?php echo $course['course']->id; ?>'
						role='tabpanel'>
						<table class="mb-0 table">
							<thead>
								<tr>
									<th>Class</th>
									<th>Day &amp; Time</th>
									<th>Notes</th>
									<th>Room</th>
								</tr>
							</thead>
							<tbody id="classes-data">
                                                                    <?php
        if (! empty($course['classes'])) {
            foreach ($course['classes'] as $c) {
                $p_id = $c['class']->id;
                ?>
                                                                    <tr>
									<td><?php echo $c['class']->name; ?></td>
									<td><?php echo $c['class']->day.' at '.date_format(new DateTime($c['class']->fromm),'H:i').' to '.date_format(new DateTime($c['class']->too),'H:i'); ?></td>
									<td><?php echo $c['class']->notes; ?></td>
									<td><?php echo $c['room']; ?></td>
								</tr>
                                                                    <?php } } ?>
                                                                </tbody>
						</table>
					</div>

					<div
						aria-labelledby='students-tab-<?php echo $course['course']->id; ?>'
						class="tab-pane fade"
						id='students-<?php echo $course['course']->id; ?>' role='tabpanel'>
						<table style="width: 100%;" id="example3"
							class="table table-hover table-striped table-bordered">
							<thead>
								<tr>
									<th><?php echo trans('dashboard.type'); ?></th>
									<th><?php echo trans('dashboard.contract'); ?></th>
									<th><?php echo trans('dashboard.contact'); ?></th>
									<th><?php echo trans('dashboard.added_on'); ?></th>
									<th><?php echo trans('dashboard.actions'); ?></th>
								</tr>
							</thead>
							<tbody>
                                                        <?php
        if (! empty($course['students'])) {
            foreach ($course['students'] as $contract) {
                if ($contract['contract']->signature == '')
                    $signed = '<br>No Signature';
                else
                    $signed = '<br>Signed';

                if ($contract['contract']->document == '1')
                    $signed = '';
                ?>
                                                    <tr>
									<td><?php echo $contract['contract']->type; ?></td>
									<td><a
										href=" <?php echo url('contracts/'.$contract['contract']->contract); ?>"
										target="_blank" style="color: #da624a;"><i
											class="fa fa-file-pdf"></i> <?php
                echo $contract['contract']->contract;
                ?></a>
                                                            <?php echo $signed; ?>
                                                            
                                                            <?php if($contract['contract']->appointments=='0') { ?>
                                                            <br>
										<form
											action="<?php echo url('admin/generate-appointments') ?>"
											method="post"
											onsubmit="return generate_appointments(this, '<?php echo $contract['contract']->id; ?>', '<?php echo $course['course']->id; ?>')">
											<input type="hidden" name="contract_id"
												value="<?php echo $contract['contract']->id; ?>">
                                                            <?php echo csrf_field(); ?>
                                                            <button
												class="btn btn-success" id="submit_btn">Generate
												Appointments</button>
										</form>
                                                            <?php } ?>
                                                        </td>
									<td><?php if($contract['contact']=='NA') echo 'Contact deleted.';  else echo $contract['contact']->name.'<br>'.$contract['contact']->email; ?>
                                                        </td>
									<td><?php echo date_format(new DateTime($contract['contract']->on_date),'d-m-Y'); ?>
                                                            <p
											style="color: #777;"><?php echo date_format(new DateTime($contract['contract']->on_date),'H:i'); ?></p>
									</td>
									<td>

										<form action="" method="post" style="display: inline;">
                                                            <?php echo csrf_field(); ?>
                                                            <input
												type="hidden" name="delete"
												value="<?php echo $contract['contract']->id; ?>">
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

					<div
						aria-labelledby='appointments-tab-<?php echo $course['course']->id; ?>'
						class="tab-pane fade"
						id='appointments-<?php echo $course['course']->id; ?>'
						role='tabpanel'></div>

				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default pull-right"
					data-dismiss="modal">Close</button>
			</div>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>

<?php } } ?>




<script>
    $("#treeview-products-<?php echo $course->id; ?>").hummingbird();
    
    function day_selected(th){
        var days=$(th).val();
        var rooms_list=$(th).parent().parent().children('#rooms_column').children('#rooms_list');
        //var rooms_days=$(rooms_list).val();
        
        $(rooms_list+" option").each(function() {
            alert(this.text + ' ' + this.value);
        });
    }
    
    function mi_selected(th, c_id)
    {
        var mi=$(th).val();
        var old_mis=$("#mis-"+c_id).val();
        if(old_mis!='')
        var mis=old_mis.split(';');
        else var mis=[];
        
        if($(th).is(':checked'))
        {
            //alert('mi checked');
            
            mis.push(mi);
            var new_mis=mis.join(';');
            $("#mis-"+c_id).val(new_mis);
        }
        else 
        {
            //alert('mi unchecked');
            mis = $.grep(mis, function(value) {
                return value != mi;
            });
            var new_mis=mis.join(';');
            $("#mis-"+c_id).val(new_mis);
        }
        
    }
    
    function appointments_date(th, c_id)
    {
        //var date=$(th).val();
        //var dates=date.split(' - ');
    }
    
    function day_selected(th, c_id)
    {
        $(th).parent().children("#appointments-days-error-"+c_id).hide();
        var date=$("#date-range-"+c_id).val();
        var dates=date.split(' - ');
        var days=$(th).val();
        
        var total_days=daysBetween(dates[0], dates[1]);
        
        if(total_days<7)
            {
                
                var date1=dates[0].split('-');
                var date2=dates[1].split('-');
                var from = new Date(date1[2], date1[1] - 1, date1[0]),
                to = new Date(date2[2], date2[1] - 1, date2[0]);
        
                var dates_days=get_days(from, to);
                //var dates_days=dates_days_s.split(',');
                
                //if(days.some((val) => dates_days.indexOf(val) !== -1)) alert('yes');
                if(days.some( ai => dates_days.includes(ai) )) { }
                else
                $(th).parent().children("#appointments-days-error-"+c_id).show();
            }
    }
    
    function get_days(from, to) {
    var d = new Date(from),
        a = [],
        y = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
    while (d < to) {
        a.push(y[d.getDay()]);
        d.setDate(d.getDate() + 1);
    }
    if (d.getDay() === to.getDay()) // include last day
        a.push(y[d.getDay()]);
    return a;
}
    
    function treatAsUTC(date) {
        var date_data=date.split('-');
        date=date_data[1]+'/'+date_data[0]+'/'+date_data[2];
        var result = new Date(date);
        result.setMinutes(result.getMinutes() - result.getTimezoneOffset());
        //alert(result);
        return result;
    }

    function daysBetween(startDate, endDate) {
        var millisecondsPerDay = 24 * 60 * 60 * 1000;
        return (treatAsUTC(endDate) - treatAsUTC(startDate)) / millisecondsPerDay;
    }
    
    
    
    $(".delete_appointment").submit(function(e){
        e.preventDefault();       
        var formData=new FormData(this);
        
        $.ajax({
                url: "<?php echo url('admin/delete-appointment') ?>",
                type: "POST",
                data:  formData,
                contentType: false,
                processData:false,
                success: function(data) { 
                    //success
                    // here we will handle errors and validation messages
                    if ( ! data.success) {
                    	alert("some error occurred");
                    } else {
                        // ALL GOOD! just show the success message!
                        location.reload();
                    }
                },
                error: function()  {
                alert("error happened");
                    //error
                } 	        
        });
    });
    
    window.days='<?php echo $days_i; ?>';
    
    function new_class(id, c_id)
    {
        $(id).append('<tr>\
                                                <td><input type="hidden" name="classes_id[]" value="0">\
                                                    <select name="days[]" class="form-control" style="padding-left:0px; padding-right:0px;" required onchange="day_selected(this, \''+c_id+'\');">\
                                                        <option value="Monday">Monday</option>\
                                                        <option value="Tuesday">Tuesday</option>\
                                                        <option value="Wednesday">Wednesday</option>\
                                                        <option value="Thursday">Thursday</option>\
                                                        <option value="Friday">Friday</option>\
                                                        <option value="Saturday">Saturday</option>\
                                                        <option value="Sunday">Sunday</option>\
                                                    </select>\
                                                    <p id="appointments-days-error-'+c_id+'" class="alert alert-danger mt-2 mb-0" style="display:none;"><i class="fa fa-info-circle"></i> These days doesn\'t come within the date range.</p>\
                                                </td>\
                                                <td>\
                                                    <select class="form-control" name="froms[]" id="class_from" style="padding-left:0px; padding-right:0px;" required>\
                                                            <option value=""></option>\
                                                            <?php

for ($i = 0; $i <= 23; $i ++) {
                                                                if ($i < 10)
                                                                    $num = '0' . $i;
                                                                else
                                                                    $num = $i;
                                                                ?>
                                                                <option value="<?php echo $num.':00'; ?>"><?php echo $num.':00'; ?></option>\
                                                                <option value="<?php echo $num.':15'; ?>"><?php echo $num.':15'; ?></option>\
                                                                <option value="<?php echo $num.':30'; ?>"><?php echo $num.':30'; ?></option>\
                                                                <option value="<?php echo $num.':45'; ?>"><?php echo $num.':45'; ?></option>\
                                                            <?php } ?>
                                                    </select>\
                                                </td>\
                                                <td>\
                                                    <input type="number" name="ues[]" class="form-control" min="1" required>\
                                                </td>\
                                                <td>\
                                                <input type="number" name="breaks[]" class="form-control" min="0" value="0">\
                                                </td>\
                                                <td>\
                                                    <input type="text" name="notes[]" class="form-control" values="">\
                                                </td>\
                                        <td>\
                                        <a href="javascript:void(0)" onclick="$(this).parent().parent().remove();"><i class="fa fa-minus-circle" style="color:red;"></i></a>\
                                        </td>\
                                                <td id="rooms_column">\
                                                    <select class="form-control" name="rooms[]" style="padding-left:0px; pading-right:0px;" id="rooms_list">\
                                                            <option value="automatic"><?php echo trans('forms.automatic'); ?></option>\
                                                            <?php
                                                            if (! empty($rooms)) {
                                                                foreach ($rooms as $room) {
                                                                    ?>
                                                            <option value="<?php echo $room['room']->id; ?>" data-name="<?php echo $room['room']->name.' ('.$room['location'].')'; ?>" data-capacity="<?php echo $room['room']->capacity; ?>" data-days="<?php echo $room['days']; ?>" <?php //if($total_students>$room['room']->capacity) echo 'disabled'; ?> ><?php echo $room['room']->name.' ('.$room['location'].')'; ?></option>\
                                                            <?php } } ?>
                                                        </select>\
                                                </td>\
                                                </tr>');
                                        
                                        $('.select-multiple').select2();
        window.days+=1;
    }
    
    function generate_appointments(th, contract_id, course_id)
    {
        var sub_btn=$(th).children('#submit_btn');
        $(sub_btn).attr('disabled', true);
        
        var formData=new FormData();
        var token='<?php echo csrf_token(); ?>';
        formData.append('_token', token);
        formData.append('contract_id', contract_id);
        
        $.ajax({
                url: "<?php echo url('admin/generate-appointments') ?>",
                type: "POST",
                data:  formData,
                beforeSend: function(){ //alert('sending');
                    $("#course_error-"+course_id).hide();
                },
                contentType: false,
                processData:false,
                success: function(data) { //alert(data);
                    //success
                    // here we will handle errors and validation messages
                    if ( ! data.success) {
                        $(sub_btn).attr('disabled', false);
                        $("#course_error-"+course_id).html(data.error);
                        $("#course_error-"+course_id).show();
                    } else {
                        // ALL GOOD! just show the success message!
                        $(sub_btn).hide();
                        $("#course_success-"+course_id).text('Appointments generated successfully.');
                        $("#course_success-"+course_id).show();
                        window.location='';
                    }
                },
                error: function()  {
                    //error
                } 	        
        });
        
        return false;
    }
    
    function add_class()
    {
        $("#f_error").hide();
        var title=$("#class_title").val();
        var day=$("#class_day").val();
        var from=$("#class_from").val();
        var to=$("#class_to").val();
        var notes=$("#class_notes").val();
        var room=$("#class_room").val();
        var room_name=$('option:selected', $("#class_room")).attr('data-name');
        var day_time=day+' at '+from+' to '+to;
        
        if(title!='' && from!='' && to!='')
        {
                                                            $("#classes-data").append('<tr>\
                                                                    <th scope="row"><input type="hidden" name="classes_id[]" value="0"><input type="hidden" name="classes[]" value="'+title+'">'+title+'</th>\
                                                                    <td><input type="hidden" name="days[]" value="'+day+'"><input type="hidden" name="froms[]" value="'+from+'"><input type="hidden" name="tos[]" value="'+to+'">'+day_time+'</td>\
                                                                    <td><input type="number" name="breaks[]" class="form-control" min="0"></td>\
                                                                    <td><input type="hidden" name="notes[]" value="'+notes+'">'+notes+'</td>\
                                                                    <td><input type="hidden" name="rooms[]" value="'+room+'">'+room_name+'</td>\
                                                                    <td><a href="javascript:void(0)" style="color:red;" onclick="$(this).parent().parent().remove();"><i class="fa fa-minus-circle"></i></a></td>\
                                                                </tr>');
            $("#class_title").val('');
            $("#class_day").val('');
            $("#class_from").val('');
            $("#class_to").val('');
            $("#class_notes").val('');
            $("#class_room").val('');
        }
        else {
            $("#f_error").text('All fields are required.');
            $("#f_error").show();
        }
    }
    
    window.lessons=0;
    
    function add_module()
    {
        $("#f_error").hide();
        var max=$("#max_lessons").val();
        var id=$("#mod").val();
        var title=$('option:selected', $("#mod")).attr('data-title');
        var lessons=$('option:selected', $("#mod")).attr('data-lessons');
        var total_cost=$('option:selected', $("#mod")).attr('data-total-cost');
        
        if(id!='')
        {
            if( (parseInt(window.lessons)+parseInt(lessons)) < parseInt(max) ) {
                window.lessons=parseInt(window.lessons)+parseInt(lessons);
        $("#modules-data").append('<tr>\
                                                                    <th scope="row"><input type="hidden" name="modules[]" value="'+id+'">'+title+'</th>\
                                                                    <td>'+lessons+'</td>\
                                                                    <td>$'+total_cost+'</td>\
                                                                    <td><a href="javascript:void(0)" style="color:red;" onclick="$(this).parent().parent().remove();"><i class="fa fa-minus-circle"></i></a></td>\
                                                                </tr>');
            }
            else{
                $("#f_error").text("Total lessons cannot be greater than: "+max);
                $("#f_error").show();
            }
        }
        
        var id=$("#mod").val('');
    }
</script>
<script
	src="https://cdn.ckeditor.com/ckeditor5/11.2.0/classic/ckeditor.js"></script>
<script>
    var editor = null;
    ClassicEditor.create(document.querySelector("#editor"), {
        toolbar: [
            "bold",
            "italic",
            "link",
            "bulletedList",
            "numberedList",
            "blockQuote",
            "undo",
            "redo"
        ]
    })
            .then(editor => {
        //debugger;
        window.editor = editor;
    })
    .catch(error => {
        console.error(error);
    });
    
    function check_data()
    {
        return true;
        $("#course-error").hide();
        
        var period=$("#period_field2").val();
        var dates=period.split(' - ');
        if(dates[0]==dates[1]) 
        {
            $("#course-error").text('<?php echo trans('forms.beginning_end_same'); ?>');
            $("#course-error").show();
            return false;
        }
        
        return true;
    }
    
    $('.date_range').daterangepicker({
        startDate: new Date(),
        locale: {
            format: 'DD-MM-YYYY'
        }
    });
    
    $(document).ready(function(){
        $('.select-multiple').select2();
    });
    
</script>
<?php include(app_path().'/common/panel/footer.php'); ?>