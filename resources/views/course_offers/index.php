<?php

include (app_path() . '/common/header.php');
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
						<div class="card-header-tab card-header">
							<div
								class="card-header-title font-size-lg text-capitalize font-weight-normal">
							</div>

						</div>
                                            <?php if(Session::has('error')) { ?>
                                            <p
							class="alert alert-danger"><?php echo Session::get('error'); ?></p>
                                            <?php } ?>
                                            <?php if(Session::has('success')) { ?>
                                            <p
							class="alert alert-success"><?php echo Session::get('success'); ?></p>
                                            <?php } ?>
                                                
                                            <div class="card-body">
                                                <?php
                                                if (! empty($courses)) {
                                                    foreach ($courses as $course) {
                                                        if (empty($course['appointments']) and $course['course']->type == 'Regular')
                                                            continue;
                                                        ?>
                                                <div
								id="accordion<?php echo $course['course']->id; ?>"
								class="accordion-wrapper mb-3">
								<div class="">
									<div id="headingOne<?php echo $course['course']->id; ?>"
										class="card-header" style="background: #E2E2E0;">
										<button type="button" data-toggle="collapse"
											data-target="#collapseOne2<?php echo $course['course']->id; ?>"
											aria-expanded="<?php if(isset($_GET['c']) AND $_GET['c']==$course['course']->id) echo 'true'; else echo 'false'; ?>"
											aria-controls="collapseOne"
											class="text-left m-0 p-0 btn btn-link btn-block collapsed">
											<h5 class="m-0 p-0" style="font-size: 18px;"><?php echo $course['course']->title; ?></h5>
										</button>
									</div>
									<div
										data-parent="#accordion<?php echo $course['course']->id; ?>"
										id="collapseOne2<?php echo $course['course']->id; ?>"
										aria-labelledby="headingOne<?php echo $course['course']->id; ?>"
										class="collapse <?php if(isset($_GET['c']) AND $_GET['c']==$course['course']->id) echo 'show'; ?>"
										style="">
										<div class="card-body">
											<p class="alert alert-danger" style="display: none;"
												id="error-<?php echo $course['course']->id; ?>"></p>
                                                                
                                                                <?php if($course['course']->type=='Coaching') { ?>
                                                                <div
												class="mb-4">
												<form class="" action="" method="post"
													onsubmit="return check_data();" id="app_form">
                                            <?php echo csrf_field(); ?>
                                            <input type="hidden"
														name="create_send" value="0" id="send"> <input
														type="hidden" name="course_id"
														value="<?php echo $course['course']->id; ?>" id="send">


													<div class="col-12"
														style="margin-bottom: 25px; padding-left: 0px; padding-right: 0px;">
														<div class="position-relative form-group">
															<label for="exampleEmail11" class="">Create appointments
																within:</label> <input type="text"
																name="appointments_period"
																class="form-control date_range"
																id="date-range-<?php echo $course['course']->id; ?>"
																required
																onchange="appointments_date(this, '<?php echo $course['course']->id; ?>');">
															<p
																id="appointments-date-error-<?php echo $course['course']->id; ?>"
																class="alert alert-danger mt-2 mb-0"
																style="display: none;">
																<i class="fa fa-info-circle"></i> Given days doesn't
																come within the date range. Therefore, no appointments
																will be generated.
															</p>
														</div>
														<div class="position-relative form-group">
															<label for="exampleEmail11" class="">Unterrichtsform</label>
															<select type="text" name="appointment_form"
																class="form-control select" required
																style="width: 100%;" id="appointment_form">
																<option value="Presence">Präsenzunterricht</option>
																<option value="Digital">Digitalunterricht</option>
																<option value="Self-Learning">Selbstlernheit</option>
																<option value="Other">Andere form</option>
																<option value="Please Select">Bitte auswählen</option>
															</select>
														</div>
                                                    
                                                    <?php
                                                            $mis = array();
                                                            if ($course['course']->mis != '')
                                                                $mis = explode(';', $course['course']->mis);
                                                            ?>
                                                    <!--<div class="position-relative form-group">
                                                        <label for="exampleEmail11" class="">Select Module Items:</label>
                                                    <select type="text" name="mis[]" class="form-control select-multiple" multiple="" required style="width:100%;">
                                                        <?php
                                                            if (! empty($course['mis']) and 0) {
                                                                foreach ($course['mis'] as $mi) {
                                                                    ?>
                                                        <option value="<?php echo $mi['module_item']->id; ?>" <?php if(in_array($mi['module_item']->id, $mis)) echo 'selected'; ?> ><?php echo $mi['module_item']->title; ?></option>
                                                        <?php } } ?>
                                                        
                                                    </select>
                                                    </div>-->

														<label for="exampleEmail11" class="">Select Module Items:</label>
														<input type="hidden" name="mis"
															id="mis-<?php echo $course['course']->id; ?>"
															value="<?php echo $course['course']->mis; ?>">
														<div id="treeview_container"
															class="hummingbird-treeview well h-scroll-large">
															<ul
																id="treeview-products-<?php echo $course['course']->id; ?>"
																class="hummingbird-base">
                                                                    <?php

$course_mis = array();
                                                            if ($course['course']->mis != '')
                                                                $course_mis = explode(';', $course['course']->mis);

                                                            if (! empty($course['products'])) {
                                                                foreach ($course['products'] as $p) {
                                                                    $p_id = $p['product']->id;
                                                                    ?>
                                                                    <li>
																	<i class="fa fa-plus"></i> <label><?php echo $p['product']->title.' ('.trans('forms.lessons').': '.$p['total_lessons'].')'; ?></label>

																	<ul>
                                                                        <?php
                                                                    if (! empty($p['modules'])) {
                                                                        foreach ($p['modules'] as $m) {
                                                                            ?>
                                                                    <li>
																			<i class="fa fa-plus"></i> <label><?php echo $m['module']->title.' ('.trans('forms.lessons').': '.$m['total_lessons'].')'; ?></label>

																			<ul>
                                                                            <?php
                                                                            if (! empty($m['items'])) {
                                                                                foreach ($m['items'] as $item) {
                                                                                    ?>
                                                                            <li>
																					<label><input type="checkbox"
																						name="items<?php echo $p_id; ?>[]"
																						value="<?php echo $item['item']->id; ?>"
																						onchange="mi_selected(this, '<?php echo $course['course']->id; ?>')"
																						<?php if(in_array($item['item']->id, $course_mis)) echo 'checked'; ?>> <?php echo $item['item']->title.' ('.trans('forms.lessons').': '.$item['item']->lessons.')'; ?></label>
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

													<table class="table table-bordered">
														<thead>
															<tr>
																<th style="min-width: 250px;">Days</th>
																<!--<th style="min-width:200px;">MIs</th>-->
																<th style="min-width: 85px;">From</th>
																<th style="min-width: 85px;">UE</th>
																<th style="min-width: 85px;">Break (minutes)</th>
																<th>Notes</th>
																<th></th>
																<!--<th style="min-width:200px;">Room</th>-->
															</tr>
														</thead>
														<tbody
															id="contract-timetable-<?php echo $course['course']->id; ?>">
                                                <?php
                                                            if (! empty($course['classes'])) {
                                                                $i2 = 0;
                                                                foreach ($course['classes'] as $c) {
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
                                                    <select type="text"
																	name="days<?php echo $days_i; ?>[]"
																	class="form-control select-multiple" multiple=""
																	required
																	onchange="day_selected(this, '<?php echo $course['course']->id; ?>');"
																	style="width: 100%;"
																	id="days-selected-<?php echo $course['course']->id; ?>">
																		<option value="Monday"
																			<?php if(in_array('Monday', $days)) echo 'selected'; ?>>Monday</option>
																		<option value="Tuesday"
																			<?php if(in_array('Tuesday', $days)) echo 'selected'; ?>>Tuesday</option>
																		<option value="Wednesday"
																			<?php if(in_array('Wednesday', $days)) echo 'selected'; ?>>Wednesday</option>
																		<option value="Thursday"
																			<?php if(in_array('Thursday', $days)) echo 'selected'; ?>>Thursday</option>
																		<option value="Friday"
																			<?php if(in_array('Friday', $days)) echo 'selected'; ?>>Friday</option>
																		<option value="Saturday"
																			<?php if(in_array('Saturday', $days)) echo 'selected'; ?>>Saturday</option>
																		<option value="Sunday"
																			<?php if(in_array('Sunday', $days)) echo 'selected'; ?>>Sunday</option>
																</select>
																	<p
																		id="appointments-days-error-<?php echo $course['course']->id; ?>"
																		class="alert alert-danger mt-2 mb-0"
																		style="display: none;">
																		<i class="fa fa-info-circle"></i> These days doesn't
																		come within the date range.
																	</p></td>
																<!--<td>
                                                    <?php
                                                                    $mis = array();
                                                                    if ($c['class']->mis != '')
                                                                        $mis = explode(';', $c['class']->mis);
                                                                    ?>
                                                    <select type="text" name="mis<?php echo $days_i; ?>[]" class="form-control select-multiple" multiple="" required style="width:200px;">
                                                        <?php
                                                                    if (! empty($course['mis'])) {
                                                                        foreach ($course['mis'] as $mi) {
                                                                            ?>
                                                        <option value="<?php echo $mi['module_item']->id; ?>" <?php if(in_array($mi['module_item']->id, $mis)) echo 'selected'; ?> ><?php echo $mi['module_item']->title; ?></option>
                                                        <?php } } ?>
                                                        
                                                    </select>
                                                </td>-->
																<td><select class="form-control" name="froms[]"
																	id="class_from"
																	style="padding-left: 0px; padding-right: 0px;">
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
																	value="<?php echo $c['class']->ue; ?>" min="1">
																</td>
																<td><input type="number" name="breaks[]"
																	class="form-control"
																	value="<?php echo $c['class']->breaks; ?>" min="0"></td>
																<td><input type="text" name="notes[]"
																	class="form-control"
																	value="<?php echo $c['class']->notes; ?>"></td>
																<td>
                                                <?php if($i2++!=0) { ?>
                                                    <a
																	href="javascript:void(0)"
																	onclick="$(this).parent().parent().remove();"><i
																		class="fa fa-minus-circle" style="color: red;"></i></a>
                                                <?php } ?>
                                                </td>
																<!--<td>
                                                    <select class="form-control" name="rooms[]" style="padding-left:0px; pading-right:0px;">
                                                            <option value=""></option>
                                                            <?php
                                                                    // if(!empty($rooms)) {
                                                                    // foreach($rooms as $room) {
                                                                    ?>
                                                            <option value="<?php //echo $room['room']->id; ?>" data-name="<?php //echo $room['room']->name.' ('.$room['location'].')'; ?>" <?php //if($room['room']->id==$c['class']->room) echo 'selected'; ?> data-capacity="<?php //echo $room['room']->capacity; ?>"><?php //echo $room['room']->name.' ('.$room['location'].')'; ?></option>
                                                            <?php //} } ?>
                                                        </select>
                                                </td>-->
															</tr>
                                                <?php $days_i++; } } ?>
                                            </tbody>
													</table>
													<a href="javascript:void(0)"
														onclick="new_class('#contract-timetable-<?php echo $course['course']->id; ?>', '<?php echo $course['course']->id; ?>')"><i
														class="fa fa-plus"></i> Add new</a><br>

													<div>
														<p class="alert alert-danger" id="course-error"
															style="display: none;"></p>
														<button class="mt-2 btn btn-primary">Generate Appointments</button>
													</div>
												</form>
											</div>
                                                                <?php } ?>
                                                                
                                                                <?php
                                                        if (! empty($course['appointments'])) {
                                                            ?>
                                                                <div
												class="mb-2">
												<form action="" method="post" style="display: inline-block;">
                                                                        <?php echo csrf_field(); ?>
                                                                        <input
														type="hidden" name="course_id"
														value="<?php echo $course['course']->id; ?>"> <input
														type="hidden" name="selected_ids" value=""
														id="selected_ids_<?php echo $course['course']->id; ?>">
													<button class="btn btn-success" disabled
														id="accept_selected_btn_<?php echo $course['course']->id; ?>">Accept Selected</button>
												</form>
												<!--  <form action="" method="post" style="display:inline-block;">
                                                                        <?php echo csrf_field(); ?>
                                                                        <input type="hidden" name="course_id" value="<?php echo $course['course']->id; ?>">
                                                                        <input type="hidden" name="selected_ids" value="" id="selected_ids_<?php echo $course['course']->id; ?>">
                                                                        <button class="btn btn-danger" disabled id="reject_selected_btn_<?php echo $course['course']->id; ?>">Reject Selected</button>
                                                                    </form> -->
												<form action="" method="post" style="display: inline-block;">
                                                                        <?php echo csrf_field(); ?>
                                                                        <input
														type="hidden" name="course_id"
														value="<?php echo $course['course']->id; ?>"> <input
														type="hidden" name="accept_all" value="1">
													<button class="btn btn-success" id="accept_all">Accept All</button>
												</form>
												<!-- <form action="" method="post" style="display:inline-block;">
                                                                        <?php echo csrf_field(); ?>
                                                                        <input type="hidden" name="course_id" value="<?php echo $course['course']->id; ?>">
                                                                        <input type="hidden" name="reject_all" value="1">
                                                                        <button class="btn btn-danger" id="reject_all">Reject All</button>
                                                                    </form> -->
											</div>
                                                                <?php } ?>
                                                                
                                                                <table
												style="width: 100%;" id="example3"
												class="table table-hover table-striped table-bordered">
												<thead>
													<tr>
														<th></th>
														<th>Date</th>
														<th>Time</th>
														<th>Module Item</th>
														<th>Room</th>
													</tr>
												</thead>
												<tbody>
                                                                <?php
                                                        if (! empty($course['appointments'])) {
                                                            foreach ($course['appointments'] as $appointment) {
                                                                ?>
                                                                <tr
														id="app-<?php echo $appointment['appointment']->id; ?>">
														<td>
                                                                        <?php
                                                                if ($appointment['appointment']->status == '1' and $appointment['appointment']->contact == $user->id)
                                                                    $accept = 1;
                                                                else if ($appointment['appointment']->contact == '0' or $appointment['appointment']->contact == '')
                                                                    $accept = 0;
                                                                else
                                                                    $accept = 1;

                                                                if ($accept == 0) {
                                                                    ?>
                                                                        <input
															type="checkbox" class="app_ids" name="app_id[]"
															value="<?php echo $appointment['appointment']->id; ?>"
															onchange="app_selected(this, this.value, '<?php echo $course['course']->id; ?>')">
                                                                        <?php } else echo "<span style='color:#3ac47d;'><i class='fa fa-check'></i> Accepted</span>"; ?>
                                                                        
                                                                        <!-- <form class="delete_appointment" action="<?php echo url('delete-appointment') ?>" method="post" data-id="<?php echo $appointment['appointment']->id; ?>" style="display:inline;"> 
                                                                        <?php echo csrf_field(); ?>
                                                                        <input type="hidden" name="id" value="<?php echo $appointment['appointment']->id; ?>">
                                                                        <button class="btn btn-danger p-1" id="app-btn-<?php echo $appointment['appointment']->id; ?>" style="display:inline;" onclick="return confirm('Do you really want to delete this appointment?')">
                                                                        <i class="fa fa-trash"></i>
                                                                        </button>
                                                                        </form>-->
														</td>
														<td><?php echo $appointment['appointment']->date; ?></td>
														<td><?php echo $appointment['appointment']->time.' - '.$appointment['appointment']->time_end; ?></td>
														<td><?php echo $appointment['appointment']->title; ?></td>
														<td><?php

echo $appointment['room'];
                                                                if (isset($appointment['location']))
                                                                    echo ' (' . $appointment['location'] . ')';
                                                                ?></td>
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
                                            </div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</div>
<?php include(app_path().'/common/footer.php'); ?>

<div class="modal fade" id="contract" tabindex="-1" role="dialog"
	aria-labelledby="mySmallModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<form action="<?php echo url('admin/convert-prospect'); ?>"
				method="post">
				<input type="hidden" name="c_id" value="0" id="c_id">
                    <?php echo csrf_field(); ?>
              <div class="modal-header">
					<h4 class="modal-title" id="modal-title">Create Contract</h4>
				</div>
				<div class="modal-body">
					<p class="alert alert-success" id="ass-success"
						style="display: none;"></p>
					<div class="row">
						<div class="col-12 col-lg-12" style="display: none;">
							<div class="form-group">
								<label for="exampleInputEmail1">Convert to <font
									style="color: red;">*</font></label> <select name="convert"
									id="convert" class="form-control" required>
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
									<div id="headingOne2" class="card-header"
										style="background: #E2E2E0;">
										<button type="button" data-toggle="collapse"
											data-target="#collapseOne2" aria-expanded="false"
											aria-controls="collapseOne"
											class="text-left m-0 p-0 btn btn-link btn-block collapsed">
											<h5 class="m-0 p-0" style="font-size: 18px;"><?php echo trans('forms.select_products_modules'); ?></h5>
										</button>
									</div>
									<div data-parent="#accordion2" id="collapseOne2"
										aria-labelledby="headingOne2" class="collapse" style="">
										<div class="card-body">
											<ul>
                                                                    <?php
                                                                    if (! empty($products)) {
                                                                        foreach ($products as $p) {
                                                                            $p_id = $p['product']->id;
                                                                            ?>
                                                                    <li><input
													type="checkbox" name="products[]"
													value="<?php echo $p['product']->id; ?>"> <?php echo $p['product']->title.' ('.trans('forms.lessons').': '.$p['total_lessons'].' '.trans('forms.total_cost').': $'.$p['total_cost'].')'; ?></li>

												<ul>
                                                                        <?php
                                                                            if (! empty($p['modules'])) {
                                                                                foreach ($p['modules'] as $m) {
                                                                                    ?>
                                                                    <li><input
														type="checkbox" name="modules<?php echo $p_id; ?>[]"
														value="<?php echo $m['module']->id; ?>"> <?php echo $m['module']->title.' ('.trans('forms.lessons').': '.$m['total_lessons'].' '.trans('forms.total_cost').': $'.$m['total_cost'].')'; ?></li>

													<ul>
                                                                            <?php
                                                                                    if (! empty($m['items'])) {
                                                                                        foreach ($m['items'] as $item) {
                                                                                            ?>
                                                                    <li><input
															type="checkbox" name="items<?php echo $p_id; ?>[]"
															value="<?php echo $item['item']->id; ?>"> <?php echo $item['item']->title.' ('.trans('forms.lessons').': '.$item['item']->lessons.' '.trans('forms.total_cost').': $'.$item['item']->lessons*$item['item']->price_lessons.')'; ?></li>
                                                                        <?php } } ?>
                                                                        </ul>
                                                                        <?php } } ?>
                                                                        
                                                                    </ul>
												<li style="list-style-type: none; padding-bottom: 15px;"></li>
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
					<button type="button" class="btn btn-default pull-right"
						data-dismiss="modal" id="add-appointment-close">Cancel</button>
					<button type="submit" class="btn btn-primary pull-right"
						style="margin-right: 10px;" id="submit_btn">Submit</button>
				</div>
			</form>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>

<div class="modal fade" id="error-modal" tabindex="-1" role="dialog"
	aria-labelledby="mySmallModalLabel">
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
					<button type="button" class="btn btn-default pull-right"
						data-dismiss="modal" id="add-appointment-close">Close</button>
				</div>
			</form>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>

<script type="text/javascript"
	src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript"
	src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script src="<?php echo url('hummingbird/hummingbird-treeview.js'); ?>"></script>
<script>
    <?php

if (! empty($courses)) {
        foreach ($courses as $course) {
            ?>
    $("#treeview-products-<?php echo $course['course']->id; ?>").hummingbird();
    <?php } } ?>
    
    window.days='<?php echo $days_i; ?>';
    
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
    
    $(document).ready(function(){
        $('.select-multiple').select2();
    });
    
    function new_class(id, c_id)
    {
        $(id).append('<tr>\
                                                <td><input type="hidden" name="classes_id[]" value="0">\
                                                    <select type="text" name="days'+window.days+'[]" class="form-control select-multiple" multiple="" required onchange="day_selected(this, \''+c_id+'\');">\
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
                                                    <select class="form-control" name="froms[]" id="class_from" style="padding-left:0px; padding-right:0px;">\
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
                                                    <input type="number" name="ues[]" class="form-control" min="1">\
                                                </td>\
                                                <td>\
                                                <input type="number" name="breaks[]" class="form-control" min="0">\
                                                </td>\
                                                <td>\
                                                    <input type="text" name="notes[]" class="form-control" values="">\
                                                </td>\
                                        <td>\
                                        <a href="javascript:void(0)" onclick="$(this).parent().parent().remove();"><i class="fa fa-minus-circle" style="color:red;"></i></a>\
                                        </td>\
                                                <!--<td id="rooms_column">\
                                                    <select class="form-control" name="rooms[]" style="padding-left:0px; pading-right:0px;" id="rooms_list">\
                                                            <option value=""></option>\
                                                            <?php
                                                            // if(!empty($rooms)) {
                                                            // foreach($rooms as $room) {
                                                            ?>
                                                            <option value="<?php //echo $room['room']->id; ?>" data-name="<?php //echo $room['room']->name.' ('.$room['location'].')'; ?>" data-capacity="<?php //echo $room['room']->capacity; ?>" data-days="<?php //echo $room['days']; ?>" <?php //if($total_students>$room['room']->capacity) echo 'disabled'; ?> ><?php //echo $room['room']->name.' ('.$room['location'].')'; ?></option>\
                                                            <?php //} } ?>
                                                        </select>\
                                                </td>-->\
                                                </tr>');
                                        
                                        $('.select-multiple').select2();
        window.days+=1;
    }
    
    function app_selected(th, id, c_id)
    {
        var old_ids=$("#selected_ids_"+c_id).val();
        if(old_ids!='')
        var idsarr=old_ids.split(',');
        else var idsarr=[];
        
        if($(th).is(':checked'))
            {
                //alert('checked');
                idsarr.push(id);
            }
        else {
                //alert('unchecked');
                idsarr = $.grep(idsarr, function(value) {
                    return value != id;
                });
        }
        
        var new_ids=idsarr.join(',');
        $("#selected_ids_"+c_id).val(new_ids);
        
        if(new_ids!='') $("#accept_selected_btn_"+c_id).attr('disabled', false);
        else $("#accept_selected_btn_"+c_id).attr('disabled', true);
    }
    
    $(".delete_appointment").submit(function(e){
        e.preventDefault();
        $(".alert").hide();
        var id=$(this).attr('data-id');
        $("#app-btn-"+id).attr('disabled', true);
        var formData=new FormData(this);
        var th=$(this);
        
        $.ajax({
                url: "<?php echo url('delete-appointment') ?>",
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
                    } else {
                        // ALL GOOD! just show the success message!
                        $(th).parent().parent().remove();
                    }
                },
                error: function()  {
                    //error
                } 	        
        });
    });
    
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
    
    $('.calendar').daterangepicker({
        singleDatePicker: true,
        startDate: '01-01-1990',
        locale: {
            format: 'DD-MM-YYYY'
        }
    });
    
    $('.select-multiple').select2();
</script>