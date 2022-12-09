<?php include(app_path().'/common/panel/header.php'); ?>
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

							<div class="btn-actions-pane-right actions-icon-btn">
                                                    
                                                    <?php
                                                    $as = 0;
                                                    if (isset($_GET['s_k']) and $_GET['s_k'] != '')
                                                        $as += 1;
                                                    if (isset($_GET['s_c']) and $_GET['s_c'] != '')
                                                        $as += 1;
                                                    if (isset($_GET['s_p']) and $_GET['s_p'] != '')
                                                        $as += 1;
                                                    if (isset($_GET['s_m']) and $_GET['s_m'] != '')
                                                        $as += 1;
                                                    if (isset($_GET['s_i']) and $_GET['s_i'] != '')
                                                        $as += 1;
                                                    ?>
													<a href="<?php echo url('admin/new_prospect_page'); ?>" target="_blank" class="btn btn-wide btn-success btn-shadow" id="new_prospect">
														<?php echo trans('forms.add_prospect'); ?>
                                    				</a>
													<button
									type="button" class="btn-shadow btn btn-wide btn-success"
									onclick="$('#form-advance-box').slideToggle()">
									<span class="btn-icon-wrapper pr-1 opacity-7"> <i
										class="fa fa-search"></i>
									</span>
                                                    <?php echo trans('forms.advance_search'); ?> <?php if($as!=0) echo '('.$as.')'; ?>
                                                    </button>

								<button type="button"
									class="btn-shadow btn btn-wide btn-success"
									onclick="$('#form-box').slideToggle()">
									<span class="btn-icon-wrapper pr-1 opacity-7"> <i
										class="fa fa-plus"></i>
									</span>
                                                    <?php echo trans('forms.add_new'); ?>
                                                    </button>
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

											

                                            <div id="form-advance-box"
							style="display: none;">
							<div class="main-card mb-2 card">
								<div class="card-body">
									<h5 class="card-title"><?php echo trans('forms.advance_search'); ?></h5>
									<form class="" action="" method="get">
										<div class="form-row">
											<div class="col-md-6">
												<div class="position-relative form-group">
													<label for="exampleEmail11" class=""><?php echo trans('forms.kg'); ?> <font
														style="color: red;">*</font></label> <select name="s_k"
														type="text" class="form-control">
														<option value=""><?php echo trans('forms.select'); ?></option>
                                                            
                                                        <?php
                                                        if (! empty($courses_kg)) {
                                                            foreach ($courses_kg as $course) {
                                                                ?>
                                                            <option
															value="<?php echo $course->id; ?>"
															<?php if(isset($_GET['s_k']) AND $_GET['s_k']==$course->id) echo 'selected'; ?>><?php echo $course->title; ?></option>
                                                            <?php } } ?>
                                                            
                                                        </select>
												</div>
											</div>

											<div class="col-md-6">
												<div class="position-relative form-group">
													<label for="exampleEmail11" class=""><?php echo trans('forms.coaching'); ?> <font
														style="color: red;">*</font></label> <select name="s_c"
														type="text" class="form-control">
														<option value=""><?php echo trans('forms.select'); ?></option>
                                                        <?php
                                                        if (! empty($courses_coaching)) {
                                                            foreach ($courses_coaching as $course) {
                                                                ?>
                                                            <option
															value="<?php echo $course->id; ?>"
															<?php if(isset($_GET['s_c']) AND $_GET['s_c']==$course->id) echo 'selected'; ?>><?php echo $course->title; ?></option>
                                                            <?php } } ?>
                                                            
                                                        </select>
												</div>
											</div>

											<div class="col-md-6">
												<div class="position-relative form-group">
													<label for="exampleEmail11" class=""><?php echo trans('forms.product'); ?> <font
														style="color: red;">*</font></label> <select name="s_p"
														type="text" class="form-control">
														<option value=""><?php echo trans('forms.select'); ?></option>
                                                            
                                                            <?php
                                                            if (! empty($products)) {
                                                                foreach ($products as $course) {
                                                                    ?>
                                                        <option
															value="<?php echo $course['product']->id; ?>"
															<?php if(isset($_GET['s_p']) AND $_GET['s_p']==$course['product']->id) echo 'selected'; ?>><?php echo $course['product']->title; ?></option>
                                                            <?php } } ?>
                                                            
                                                        </select>
												</div>
											</div>

											<div class="col-md-6">
												<div class="position-relative form-group">
													<label for="exampleEmail11" class=""><?php echo trans('forms.module'); ?> <font
														style="color: red;">*</font></label> <select name="s_m"
														type="text" class="form-control">
														<option value=""><?php echo trans('forms.select'); ?></option>
                                                            
                                                            <?php
                                                            if (! empty($modules)) {
                                                                foreach ($modules as $course) {
                                                                    ?>
                                                        <option
															value="<?php echo $course->id; ?>"
															<?php if(isset($_GET['s_m']) AND $_GET['s_m']==$course->id) echo 'selected'; ?>><?php echo $course->title; ?></option>
                                                            <?php } } ?>
                                                            
                                                        </select>
												</div>
											</div>

											<div class="col-md-6">
												<div class="position-relative form-group">
													<label for="exampleEmail11" class=""><?php echo trans('forms.module_item'); ?> <font
														style="color: red;">*</font></label> <select name="s_i"
														type="text" class="form-control">
														<option value=""><?php echo trans('forms.select'); ?></option>
                                                            
                                                            <?php
                                                            if (! empty($modules_items)) {
                                                                foreach ($modules_items as $course) {
                                                                    ?>
                                                        <option
															value="<?php echo $course->id; ?>"
															<?php if(isset($_GET['s_i']) AND $_GET['s_i']==$course->id) echo 'selected'; ?>><?php echo $course->title; ?></option>
                                                            <?php } } ?>
                                                            
                                                        </select>
												</div>
											</div>

											<div class="col-md-12">
												<button class="mt-2 btn btn-primary"><?php echo trans('forms.submit'); ?></button>
											</div>
										</div>
									</form>
								</div>
							</div>
						</div>

						<div id="form-box" style="display: none;">
							<div class="main-card mb-2 card">
								<div class="card-body">
									<h5 class="card-title"><?php echo trans('forms.add_new_contact'); ?></h5>
									<form class="" action="" method="post"
										onsubmit="return check_data3();" id="form_box">
                                            <?php echo csrf_field(); ?>
                                            <div class="form-row">
											<div class="col-md-6">
												<div class="position-relative form-group">
													<label for="exampleEmail11" class=""><?php echo trans('forms.type'); ?> <font
														style="color: red;">*</font></label> <select name="type"
														id="contact_type" type="text" class="form-control"
														required onchange="show_form(this.value);">
														<option value=""><?php echo trans('forms.please_select'); ?></option>

														<option value="Prospect"><?php echo trans('forms.prospect'); ?></option>

														<option value="Employee"><?php echo trans('forms.employee'); ?></option>

														<option value="Expert Advisor"><?php echo trans('forms.expert_advisor'); ?></option>

														<option value="Coach"><?php echo trans('forms.lecturer'); ?> / <?php echo trans('forms.coach'); ?></option>

														<option value="Student"><?php echo trans('forms.student'); ?> / <?php echo trans('forms.coachee'); ?></option>

														<option value="Internship Company"><?php echo trans('forms.internship_company'); ?></option>

														<option value="Other Contacts"><?php echo trans('forms.other_contacts'); ?></option>
													</select>
												</div>
											</div>
											<div class="col-md-6" id="company_name"
												style="display: none;">
												<div class="position-relative form-group">
													<label for="examplePassword11" class=""><?php echo trans('forms.company_name'); ?> <font
														style="color: red;">*</font></label> <input
														name="company_name" type="text"
														class="form-control required" required
														id="company_name_field">
												</div>
											</div>
											<div class="col-md-6" id="type_checkbox_student"
												style="display: none;">
												<div class="position-relative form-group">
													<label for="exampleEmail11" class=""><?php echo trans('forms.type'); ?> <font
														style="color: red;">*</font></label><br> <input
														name="types[]" type="checkbox" value="Student" checked> <?php echo trans('forms.student'); ?>
                                                        <input
														name="types[]" type="checkbox" value="Coachee"> <?php echo trans('forms.coachee'); ?>
                                                    </div>
											</div>
											<div class="col-md-6" id="type_checkbox_trainer"
												style="display: none;">
												<div class="position-relative form-group">
													<label for="exampleEmail11" class=""><?php echo trans('forms.type'); ?> <font
														style="color: red;">*</font></label><br> <input
														name="types2[]" type="checkbox" value="Coach" checked> <?php echo trans('forms.coach'); ?>
                                                        <input
														name="types2[]" type="checkbox" value="Trainer"> <?php echo trans('forms.lecturer'); ?>
                                                    </div>
											</div>
											<div class="col-md-3" id="first_name">
												<div class="position-relative form-group">
													<label for="exampleEmail11" class=""><?php echo trans('forms.first_name'); ?> <font
														style="color: red;">*</font></label> <input
														name="first_name" type="text"
														class="form-control required" required
														id="first_name_field">
												</div>
											</div>
											<div class="col-md-3" id="last_name">
												<div class="position-relative form-group">
													<label for="exampleEmail11" class=""><?php echo trans('forms.last_name'); ?> <font
														style="color: red;">*</font></label> <input
														name="last_name" id="last_name_field" type="text"
														class="form-control required" required>
												</div>
											</div>


											<div class="col-md-6">
												<div class="position-relative form-group"
													style="position: relative;">
													<label for="examplePassword11" class=""><?php echo trans('forms.email'); ?> <font
														style="color: red;">*</font></label> <input name="email"
														id="email_field" type="email"
														class="form-control required" required
														onchange="check_email(this, '0')">
													<p class="alert alert-danger"
														style="position: absolute; right: 0px; top: 0px; padding-top: 0px; padding-bottom: 0px; display: none;"
														id="email-error"><?php echo trans('forms.email_already_exists'); ?></p>
												</div>
											</div>
											<div class="col-md-6" id="gender">
												<div class="position-relative form-group">
													<label for="exampleEmail11" class=""><?php echo trans('forms.gender'); ?> <font
														style="color: red;">*</font></label> <select name="gender"
														id="gender_field" type="text"
														class="form-control required" required>
														<option value=""><?php echo trans('forms.please_select'); ?></option>

														<option value="Male"><?php echo trans('forms.male'); ?></option>

														<option value="Female"><?php echo trans('forms.female'); ?></option>

														<option value="Neutral"><?php echo trans('forms.neutral'); ?></option>
													</select>
												</div>
											</div>

											<!--<div class="col-12 col-lg-6" id="contract_box" style="display:none;">
                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1"><?php echo trans('forms.contract_type'); ?></label>
                                                        <select name="contract_type" id="contract_field" class="form-control">
                                                            <option value=""><?php echo trans('forms.please_select'); ?></option>
                                                            <option value="Standard Contract for Sachberater">Standard Contract for Sachberater</option>
                                                            <option value="Standard contract for Coach / Trainer">Standard contract for Coach / Trainer</option>
                                                            <option value="Coaching Contract for Coachee">Coaching Contract for Coachee</option>
                                                            <option value="Education Contract for Student">Education Contract for Student</option>
                                                            <option value="Standard Contract for Internship company">Standard Contract for Internship company</option>
                                                            <option value="Contract for student / coachee for Internship">Contract for student / coachee for Internship</option>
                                                            <option value="Retraining Contract for Coachee / Student">Retraining Contract for Coachee / Student</option>
                                                            <option value="Amendments to Retraining Contract">Amendments to Retraining Contract</option>
                                                            <option value="Jobsearch contract for Student / Coachee">Jobsearch contract for Student / Coachee</option>
                                                        </select>
                                                    </div>
                                                </div>-->

											<div id="form-field-box">
                                                <?php include(app_path().'/common/contact_form.php'); ?>
                                            </div>

											<div class="col-md-6">
												<div class="position-relative form-group">
													<textarea class="form-control" name="note" id="note"
														placeholder="<?php echo trans('forms.write_note'); ?>"></textarea>
												</div>
											</div>
											<div class="col-md-6">
												<div class="position-relative form-group">
													<button class="btn btn-primary pt-2 pb-2" type="button"
														onclick="add_note()"><?php echo trans('forms.add_note'); ?></button>
												</div>
											</div>

											<div class="col-md-12">
												<table class="table table-bordered">
													<thead>
														<tr>
															<th><?php echo trans('forms.notes'); ?></th>
															<th></th>
														</tr>
													</thead>
													<tbody id="notes-box">

													</tbody>
												</table>
											</div>
										</div>

										<div id="accordion"
											class="accordion-wrapper mb-3 products_module"
											style="display: none;">
											<div class="">
												<div id="headingOne" class="card-header"
													style="background: #E2E2E0;">
													<button type="button" data-toggle="collapse"
														data-target="#collapseOne1" aria-expanded="false"
														aria-controls="collapseOne"
														class="text-left m-0 p-0 btn btn-link btn-block collapsed">
														<h5 class="m-0 p-0" style="font-size: 18px;"><?php echo trans('forms.select_products_modules'); ?></h5>
													</button>
												</div>
												<div data-parent="#accordion" id="collapseOne1"
													aria-labelledby="headingOne" class="collapse" style="">
													<div class="card-body">

														<input type="hidden" name="products_selected"
															id="selected_products2">

														<div id="treeview_container"
															class="hummingbird-treeview well h-scroll-large">
															<ul id="treeview" class="hummingbird-base">
                                                                    <?php
                                                                    if (! empty($products)) {
                                                                        foreach ($products as $p) {
                                                                            $p_id = $p['product']->id;

                                                                            $total_cost = number_format($p['total_cost'], 2, '.', ',');
                                                                            ?>
                                                                    <input
																	type="hidden"
																	name="modules_selected_<?php echo $p_id; ?>"
																	id="selected_modules2_<?php echo $p_id; ?>"
																	value="<?php if(!empty($contact_modules)) echo implode(',', $contact_modules); ?>">

																<li><i class="fa fa-plus"></i> <label> <input
																		type="checkbox" name="products[]"
																		value="<?php echo $p['product']->id; ?>"
																		onclick="item_selected12('<?php echo $p_id; ?>')"> <?php echo $p['product']->title.' ('.trans('forms.lessons').': '.$p['total_lessons'].' '.trans('forms.total_cost').': €'.$total_cost.')'; ?>
                                                                    </label>

																	<ul>
                                                                        <?php
                                                                            if (! empty($p['modules'])) {
                                                                                foreach ($p['modules'] as $m) {
                                                                                    $m_id = $m['module']->id;

                                                                                    $total_cost = number_format($m['total_cost'], 2, '.', ',');
                                                                                    ?>
                                                                    <li>
																			<i class="fa fa-plus"></i> <label> <input
																				type="checkbox" name="modules<?php echo $p_id; ?>[]"
																				value="<?php echo $m['module']->id; ?>"
																				onclick="item_selected12('<?php echo $p_id; ?>'); item_selected22('<?php echo $p_id; ?>', '<?php echo $m_id; ?>')"> <?php echo $m['module']->title.' ('.trans('forms.lessons').': '.$m['total_lessons'].' '.trans('forms.total_cost').': €'.$total_cost.')'; ?>
                                                                    </label>

																			<ul>
                                                                            <?php
                                                                                    if (! empty($m['items'])) {
                                                                                        foreach ($m['items'] as $item) {
                                                                                            $price = number_format($item['item']->price_lessons, 2, '.', ',');
                                                                                            ?>
                                                                    <li>

																					<label> <input type="checkbox"
																						name="items<?php echo $m['module']->id; ?>[]"
																						value="<?php echo $item['item']->id; ?>"
																						onclick="item_selected12('<?php echo $p_id; ?>'); item_selected22('<?php echo $p_id; ?>', '<?php echo $m_id; ?>')"> <?php echo $item['item']->title; ?>
                                                                    </label>
                                                                        
                                                                    <?php echo ' ('.trans('forms.lessons').': '.$item['item']->lessons.', <input type="hidden" name="lessons'.$item['item']->id.'" value="'.$item['item']->lessons.'" style="max-width:60px; padding-top:0px; padding-bottom:0px;" min="0" max="'.$item['item']->lessons.'" required> '.trans('forms.price_lesson').': €'.$price.')'; ?>
                                                                            
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
												</div>
											</div>
										</div>

										<div id="accordion" class="accordion-wrapper mb-3 d-none">
											<div class="">
												<div id="headingOne" class="card-header"
													style="background: #E2E2E0;">
													<button type="button" data-toggle="collapse"
														data-target="#collapseOne1" aria-expanded="false"
														aria-controls="collapseOne"
														class="text-left m-0 p-0 btn btn-link btn-block collapsed">
														<h5 class="m-0 p-0" style="font-size: 18px;">Select Course</h5>
													</button>
												</div>
												<div data-parent="#accordion" id="collapseOne1"
													aria-labelledby="headingOne" class="collapse" style="">
													<div class="card-body">
														<select name="courses[]" class="form-control">
                                                                    <?php
                                                                    if (! empty($courses)) {
                                                                        foreach ($courses as $course) {
                                                                            $p_id = $course['course']->id;
                                                                            ?>
                                                                    <option
																value="<?php echo $course['course']->id; ?>"><?php echo $course['course']->title; ?></option>
                                                                    <?php } } ?>
                                                                </select>
														<!--<ul>
                                                                    <?php
                                                                    if (! empty($courses)) {
                                                                        foreach ($courses as $course) {
                                                                            $p_id = $course['course']->id;
                                                                            ?>
                                                                    <li><input type="checkbox" class="courses" name="courses[]" value="<?php echo $course['course']->id; ?>" onchange="show_box(this)"> <?php echo $course['course']->title; ?></li>
                                                                    
                                                                    <div style="border:1px solid #ced4da; border-radius:20px; display:none;" class="box-<?php echo $course['course']->id; ?>">
                                                                        <ul>
                                                                            <?php
                                                                            if (! empty($course['products'])) {
                                                                                foreach ($course['products'] as $p) {
                                                                                    $p_id = $p['product']->id;
                                                                                    ?>
                                                                    <li><?php echo $p['product']->title.' ('.trans('forms.lessons').': '.$p['total_lessons'].' '.trans('forms.total_cost').': €'.$p['total_cost'].')'; ?></li>
                                                                    
                                                                    <ul>
                                                                        <?php
                                                                                    if (! empty($p['modules'])) {
                                                                                        foreach ($p['modules'] as $m) {
                                                                                            ?>
                                                                    <li><?php echo $m['module']->title.' ('.trans('forms.lessons').': '.$m['total_lessons'].' '.trans('forms.total_cost').': €'.$m['total_cost'].')'; ?></li>
                                                                        
                                                                        <ul>
                                                                            <?php
                                                                                            if (! empty($m['items'])) {
                                                                                                foreach ($m['items'] as $item) {
                                                                                                    ?>
                                                                    <li><?php echo $item['item']->title.' ('.trans('forms.lessons').': <input type="number" name="lessons'.$item['course_item']->id.'" value="'.$item['item']->lessons.'" style="max-width:60px; padding-top:0px; padding-bottom:0px;" min="0" max="'.$item['item']->lessons.'" required> '.trans('forms.price_lesson').': €'.$item['item']->price_lessons.')'; ?></li>
                                                                        <?php } } ?>
                                                                        </ul>
                                                                        <?php } } ?>
                                                                        
                                                                    </ul>
                                                                    <li style="list-style-type:none; padding-bottom:15px;"></li>
                                                                    <?php } } ?>
                                                                        </ul>
                                                                    </div>
                                                                    <?php } } ?>
                                                                </ul>-->
													</div>
												</div>
											</div>
										</div>

										<p class="alert alert-danger contact_error"
											style="display: none;"></p>
										<button class="mt-2 btn btn-primary" id="submit_btn_c"><?php echo trans('forms.submit'); ?></button>
									</form>
								</div>
							</div>
						</div>
						<div class="card-body">
							<table style="width: 100%;" id="example3"
								class="table table-hover table-striped table-bordered">
								<thead>
									<tr>
										<th><?php echo trans('dashboard.contact'); ?></th>
										<th><?php echo trans('dashboard.type'); ?></th>
										<th><?php echo trans('forms.customer_no'); ?></th>
										<th><?php echo trans('forms.phone_no'); ?></th>
										<th><?php echo trans('dashboard.last_login'); ?></th>
										<th><?php echo trans('dashboard.actions'); ?></th>
									</tr>
								</thead>
								<tbody>
                                                        <?php
                                                        if (! empty($contacts)) {
                                                            foreach ($contacts as $user) {
                                                                ?>
                                                    <tr>
										<td style="<?php if($user['contact']->type=='Student' AND $user['contact']->vouchers=='') echo 'color:#da624a;' ?>" ><?php if($user['contact']->type=='Internship Company') echo $user['contact']->company_name; else echo $user['contact']->name; ?>
                                                        <p
												style="color: #777;"><?php echo $user['contact']->email; ?></p>
                                                        
                                                        <?php if($user['contact']->type=='Student' AND $user['contact']->vouchers=='') echo '<i class="fa fa-info-circle"></i> Bildungsgutschein fehlt!'; ?>    
                                                        </td>
										<td><?php
                                                                if ($user['contact']->type == 'Prospect')
                                                                    echo trans('forms.prospect');
                                                                else if ($user['contact']->type == 'Employee')
                                                                    echo trans('forms.employee');
                                                                else if ($user['contact']->type == 'Expert Advisor')
                                                                    echo trans('forms.expert_advisor');
                                                                else if ($user['contact']->type == 'Coach')
                                                                    echo trans('forms.coach');
                                                                else if ($user['contact']->type == 'Lecturer')
                                                                    echo trans('forms.lecturer');
                                                                else if ($user['contact']->type == 'Student')
                                                                    echo trans('forms.student');
                                                                else if ($user['contact']->type == 'Internship Company')
                                                                    echo trans('forms.internship_company');
                                                                else if ($user['contact']->type == 'Other Contacts')
                                                                    echo trans('forms.other_contacts');
                                                                ?></td>
										<td><?php echo $user['contact']->customer_no; ?></td>
										<td><?php echo $user['contact']->phone_no; ?></td>
										<td>
                                                            <?php if($user['contact']->last_login!='0000-00-00 00:00:00') { ?>
                                                            <?php echo date_format(new DateTime($user['contact']->last_login),'d-m-Y'); ?>
                                                            <p
												style="color: #777;"><?php echo date_format(new DateTime($user['contact']->last_login),'H:i'); ?></p>
                                                            <?php } else echo 'NA'; ?>
                                                        </td>
										<!--<td>
                                                            <?php echo date_format(new DateTime($user['contact']->created_on),'d-m-Y'); ?>
                                                            <p><?php echo date_format(new DateTime($user['contact']->created_on),'H:i'); ?></p>
                                                        </td>-->
										<td><a
											href="<?php echo url('admin/edit-contact/'.$user['contact']->id); ?>"><button
													class="border-0 btn-transition btn btn-outline-success">
													<i class="fa fa-edit"></i>
												</button></a>

											<form action="" method="post" style="display: inline;">
                                                            <?php echo csrf_field(); ?>
                                                            <input
													type="hidden" name="delete"
													value="<?php echo $user['contact']->id; ?>">
												<button
													class="border-0 btn-transition btn btn-outline-danger"
													onclick="return confirm('Do you really want to delete this contact?');">
													<i class="fa fa-trash"></i>
												</button>
											</form> <br>
                                                            <?php if($user['contact']->type=='Prospect') { ?>
                                                            
                                                            <!--<button class="border-0 btn-transition btn btn-success" data-toggle="modal" data-target="#convert2" onclick="$('.c_id').val('<?php echo $user['contact']->id; ?>');">
                                                            Convert
                                                            </button>-->
											<a
											href="<?php echo url('admin/convert/'.$user['contact']->id); ?>"><button
													class="border-0 btn-transition btn btn-success">
                                                            <?php echo trans('dashboard.convert'); ?>
                                                            </button></a>
                                                            
                                                            <?php } ?>
                                                            <button
												class="border-0 btn-transition btn btn-success"
												data-toggle="modal" data-target="#contract"
												onclick="fetch_contracts('<?php echo $user['contact']->id; ?>', '<?php echo $user['contact']->type; ?>'); $('#details_user').text('<?php if($user['contact']->type=='Internship Company') echo $user['contact']->company_name; else echo $user['contact']->name; echo " (".$user['contact']->email.")"; ?>');">
                                                            <?php echo trans('forms.contact_details'); ?>
                                                            </button></td>
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
</div>
<?php include(app_path().'/common/panel/footer.php'); ?>

<div class="modal fade" id="contract" tabindex="-1" role="dialog"
	aria-labelledby="mySmallModalLabel">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="modal-title2">
					<span id="details_user"></span>
					<!--<small> - <?php echo trans('forms.contact_details'); ?></small>-->
				</h5>
			</div>
			<div class="modal-body">
				<p class="alert alert-success" id="ass-success"
					style="display: none;"></p>

				<ul class='nav nav-tabs mb-3' id='profile-form-tab' role='tablist'>
					<li class='nav-item hide-tab'><a aria-controls='products'
						aria-selected='true' class="nav-link active" data-toggle='tab'
						href='#products' id='products-tab' role='tab'><?php echo trans('forms.products'); ?></a>
					</li>
					<li class='nav-item hide-tab'><a aria-controls='contracts'
						aria-selected='true' class="nav-link" data-toggle='tab'
						href='#contracts' id='contracts-tab' role='tab'><?php echo trans('forms.contracts'); ?></a>
					</li>
					<li class='nav-item'><a aria-controls='documents'
						aria-selected='true' class="nav-link" data-toggle='tab'
						href='#documents' id='documents-tab' role='tab'><?php echo trans('forms.documents'); ?></a>
					</li>
					<li class='nav-item hide-tab'><a aria-controls='create-contracts'
						aria-selected='false' class="nav-link" data-toggle='tab'
						href='#create-contracts' id='create-tab' role='tab'><?php echo trans('forms.create_contract'); ?></a>
					</li>

					<li class='nav-item hide-tab'><a aria-controls='create-certificate'
						aria-selected='false' class="nav-link" data-toggle='tab'
						href='#create-certificate' id='certificate-tab' role='tab'><?php echo trans('forms.create_certificate'); ?></a>
					</li>

				</ul>
				<div class='tab-content' id='profile-form-content'>
					<div aria-labelledby='products-tab'
						class="tab-pane fade show active" id='products' role='tabpanel'
						style="overflow-x: auto;"></div>

					<div aria-labelledby='contracts-tab' class="tab-pane fade"
						id='contracts' role='tabpanel' style="overflow-x: auto;">
						<table class="table table-bordered">
							<thead>
								<tr>
									<th><?php echo trans('forms.course'); ?></th>
									<th><?php echo trans('forms.products'); ?></th>
									<th><?php echo trans('forms.contract_type'); ?></th>
									<th><?php echo trans('forms.contract_pdf'); ?></th>
									<th><?php echo trans('forms.created_on'); ?></th>
								</tr>
							</thead>
							<tbody id="user-contracts">

							</tbody>
						</table>
					</div>

					<div aria-labelledby='documents-tab' class="tab-pane fade"
						id='documents' role='tabpanel'>
						<table class="table table-bordered">
							<thead>
								<tr>
									<th><?php echo trans('forms.document_type'); ?></th>
									<th><?php echo trans('forms.document_file'); ?></th>
									<th><?php echo trans('forms.added_on'); ?></th>
								</tr>
							</thead>
							<tbody id="user-documents">

							</tbody>
						</table>
					</div>
					<div aria-labelledby='certificate-tab' class="tab-pane fade"
						id='create-certificate' role='tabpanel'>
						<form action="<?php echo url('create_certificate'); ?>"
							method="post" novalidate>
							<input type="hidden" name="c_id_certificate" value="0"
								id="c_id_certificate">
                    <?php echo csrf_field(); ?>
            <div class="row">
								<div class="col-12 col-lg-6">
									<div class="form-group">
										<label for="exampleInputEmail1"><?php echo trans('forms.select_template'); ?><font
											style="color: red;">*</font></label> <select name="template"
											id="certificate_type" class="form-control" required>
											<option value="" disabled selected><?php echo trans('forms.please_select'); ?></option>
											<option value="1"><?php echo trans('forms.retraining_certificates_of_completion');?></option>
											<option value="6"><?php echo trans('forms.coaching_certificates_of_completion');?></option>

											<option value="2"><?php echo trans('forms.retraining_certificates_for_participation');?></option>
											<option value="7"><?php echo trans('forms.coaching_certificates_for_participation');?></option>

											<option value="3"><?php echo trans('forms.retraining_certificates_for_participation_extra');?></option>
											<option value="8"><?php echo trans('forms.coaching_certificates_for_participation_extra');?></option>

											<option value="4"><?php echo trans('forms.retraining_additional_qualification_certificate');?></option>
											<option value="5"><?php echo trans('forms.coaching_additional_qualification_certificate');?></option>
										</select>
									</div>
								</div>
                      <?php echo csrf_field(); ?>
                      
                      <div class="col-md-6">
									<div class="position-relative form-group">
										<label for="examplePassword11" class=""><?php echo trans('forms.beginning_end');?> <font
											style="color: red;">*</font></label> <input type="text"
											class="form-control date_range required" name="date_from_to"
											required id="date_from_to">
									</div>
								</div>
								<div class="col-md-6 " id="qualifi">
									<div class="position-relative form-group">
										<label for="examplePassword11" class=""><?php echo trans('forms.qualification');?><font
											style="color: red;">*</font></label> <input type="text"
											class="form-control  " name="qualification" required
											id="qualification">
									</div>
								</div>
								<div class="col-md-6" id='sub_q'>
									<div class="position-relative form-group">
										<label for="examplePassword11" class=""><?php echo trans('forms.sub_qualification');?><font
											style="color: red;">*</font></label> <input type="text"
											class="form-control " name="sub_qualification" required
											id="sub_qualification">
									</div>
								</div>
								<div class="col-md-6" id="an_der_div">
									<div class="position-relative form-group">
										<label for="an_der" class=""><?php echo trans('forms.qualification_for');?><font
											style="color: red;">*</font></label> <input type="text"
											class="form-control" name="an_der" required id="an_der">
									</div>
								</div>
								<div class="col-md-6" id="module_name_div">
									<div class="position-relative form-group">
										<label for="examplePassword11" class=""><?php echo trans('forms.module_name');?><font
											style="color: red;">*</font></label> <input type="text"
											class="form-control " name="module_name" required
											id="module_name">
									</div>
								</div>
								<div class="col-md-6" id="module_Item">
									<div class="position-relative form-group">
										<label for="examplePassword11" class=""><?php echo trans('forms.module_items');?><font
											style="color: red;">*</font></label>
										<textarea class="form-control" rows="1" name="module_item"
											required></textarea>
									</div>
								</div>
								<div class="" id="module_items_box"
									style="width: 100%; display: none;">
									<div class="form-row"
										style="margin-left: 15px; margin-right: 15px;">
										<div class="col-md-6" id="module_title">
											<div class="position-relative form-group">
												<label for="examplePassword11" class=""><?php echo trans('forms.module_title');?><font
													style="color: red;">*</font></label>
												<!-- <input type="text" class="form-control required" name="module_item" required id="module_item"> -->
												<input type="text" name="module_title[]"
													class="form-control" value="">
											</div>
										</div>
										<div class="col-md-6" id="module_I">
											<div class="position-relative form-group">
												<label for="examplePassword11" class=""><?php echo trans('forms.module_items');?><font
													style="color: red;">*</font></label>

												<textarea class="form-control" rows="1"
													name="module_items[]" required></textarea>
											</div>
										</div>
									</div>
								</div>
								<div class="col-md-12" id="add_more_module"
									style="display: none;">
									<a href="javascript:void(0)" onclick="add_module_items(this)"><i
										class="fa fa-plus-circle"></i> <?php echo trans('forms.add_more'); ?> </a>
								</div>


							</div>
							<button type="submit" class="btn btn-primary pull-right"
								style="margin-right: 10px;" id="submit_btn"><?php echo trans('forms.submit'); ?></button>
						</form>
					</div>

					<div aria-labelledby='create-tab' class="tab-pane fade"
						id='create-contracts' role='tabpanel' style="overflow: hidden;">
						<form action="<?php echo url('admin/create-contract'); ?>"
							method="post" onsubmit="return check_data2();">
							<input type="hidden" name="c_id" value="0" id="c_id">
                    <?php echo csrf_field(); ?>
        <div class="row">
								<div class="col-12 col-lg-6">
									<div class="form-group">
										<label for="exampleInputEmail1"><?php echo trans('forms.contract'); ?> <font
											style="color: red;">*</font></label> <select
											name="contract_type" id="contract_type" class="form-control"
											required onchange="contract_type2(this)">
											<option value=""><?php echo trans('forms.please_select'); ?></option>
											<option value="Standard contract for Coach / Trainer"><?php echo trans('forms.standard_contract_for_coach_trainer'); ?></option>
											<option value="Coaching Contract for Coachee"><?php echo trans('forms.coaching_contract_for_coachee'); ?></option>
											<option value="Education Contract for Student"><?php echo trans('forms.education_contract_for_student'); ?></option>
											<option value="Extended Education Contract for Student"><?php echo trans('forms.extended_education_contract_for_student'); ?></option>
											<option value="Retraining Contract for Coachee / Student"><?php echo trans('forms.retraining_contract_for_coachee_student'); ?></option>
											<option value="Amendments to Retraining Contract"><?php echo trans('forms.amendments_to_retraining_contract'); ?></option>
											<option value="Contract for Student / Coachee Internship"><?php echo trans('forms.contract_for_student_coachee_internship'); ?></option>
											<option
												value="Private Jobsearch contract for Student / Coachee"><?php echo trans('forms.private_jobsearch_contract_for_student_coachee'); ?></option>
										</select>
									</div>
								</div>
								<div class="col-md-6">
									<div class="position-relative form-group">
										<label for="examplePassword11" class=""><?php echo trans('forms.beginning_end'); ?> <font
											style="color: red;">*</font></label> <input type="text"
											class="form-control date_range required" name="period"
											required id="period_field2">
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-12 col-lg-12" id="product_fields">
									<div class="position-relative form-group">
										<label for="examplePassword11" class=""><?php echo trans('forms.courses'); ?></label>
										<div class="row">
											<div class="col-md-12">
												<select name="course" class="form-control"
													id="assign_course" style="width: 100%; height: 100%;">
													<option value="" disabled selected><?php echo trans('forms.select_course'); ?></option>
													<optgroup value="KG" label="KG">
                                                    <?php
                                                    if (! empty($courses_kg)) {
                                                        foreach ($courses_kg as $course) {
                                                            ?>
                                                    <option
															value="<?php echo $course->id; ?>"><?php echo $course->title; ?></option>
                                                    <?php } } ?>
                                                    </optgroup>

													<optgroup value="Coaching" label="Coaching">
                                                    <?php
                                                    if (! empty($courses_coaching)) {
                                                        foreach ($courses_coaching as $course) {
                                                            ?>
                                                    <option
															value="<?php echo $course->id; ?>"><?php echo $course->title; ?></option>
                                                    <?php } } ?>
                                                    </optgroup>
												</select>
											</div>
										</div>
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-12 col-lg-6 mb-4" id="lehrgang"
									style="display: none;">
									<label for="exampleInputEmail1">Lehrgang</label><br> <input
										type="text" class="form-control" name="lehrgang">
								</div>

								<div class="col-12 col-lg-6" id="qualifications"
									style="display: none;">
									<label for="exampleInputEmail1"><?php echo trans('forms.professional_qualification_for'); ?></label><br>
									<input type="checkbox" name="p_qualifications[]"
										value="Drogist/in"> Drogist/in<br> <input type="checkbox"
										name="p_qualifications[]"
										value="Kaufmann/frau im Einzelhandel"> Kaufmann/frau im
									Einzelhandel<br> <input type="checkbox"
										name="p_qualifications[]" value="Verkäufer/in"> Verkäufer/in<br>
									<br>
								</div>

								<div class="col-12 col-lg-6" id="e_qualifications"
									style="display: none;">
									<label for="exampleInputEmail1"><?php echo trans('forms.elective_qualification'); ?></label><br>
									<input type="checkbox" name="e_qualifications[]"
										value="Beauty &amp; Cosmetic (inkl. Visagistik, Parfüm- &amp; Dufttraining, Dermatologie)">
									Beauty &amp; Cosmetic (inkl. Visagistik, Parfüm- &amp;
									Dufttraining, Dermatologie)<br> <input type="checkbox"
										name="e_qualifications[]"
										value="Fashion &amp; Design (inkl. Stoff- &amp; Schnittkunde, Nähkurs, Workshops)">
									Fashion &amp; Design (inkl. Stoff- &amp; Schnittkunde, Nähkurs,
									Workshops)<br> <input type="checkbox" name="e_qualifications[]"
										value="Drogerie &amp; Gesundheit (inkl. Skin Cosmetics, Freiverkäufliche Arzneimittel)"> Drogerie &amp; Gesundheit (inkl. Skin Cosmetics, Freiverkäufliche Arzneimittel)<br><input type="checkbox" name="e_qualifications[]"
										value="E-Commerce (inkl. Konzeption &amp; Einrichtung Online Shop, Planung &amp; Umsetzung Online Shop, Workshops)"> E-Commerce (inkl. Konzeption &amp; Einrichtung Online Shop, Planung &amp; Umsetzung Online Shop, Workshops)<br>
										<input type="checkbox" name="e_qualifications[]"
										value="Kassensystemdaten und Kundenservice"> Kassensystemdaten
									und Kundenservice<br>
									<br>
								</div>

								<div class="col-12 col-lg-6 mb-4" id="installments"
									style="display: none;">
									<label for="exampleInputEmail1"><?php echo trans('forms.installment_count'); ?></label><br>
									<input type="number" class="form-control" value="1" min="1"
										name="installments">
								</div>

								<div class="col-12 col-lg-6 mb-4" id="consultation"
									style="display: none;">
									<label for="exampleInputEmail1"><?php echo trans('forms.consultation_date'); ?></label><br>
									<input type="text" class="form-control today_calendar" value=""
										name="consultation_date">
								</div>
							</div>

							<div class="row" id="internship_fields" style="display: none;">
								<div class="col-12 col-lg-6 mb-4">
									<label for="exampleInputEmail1"><?php echo trans('forms.job_title'); ?></label><br>
									<input type="text" class="form-control" value=""
										name="job_title" id="job_title_field">
								</div>

								<div class="col-12 col-lg-6 mb-4">
									<label for="exampleInputEmail1"><?php echo trans('forms.student'); ?></label><br>
									<select class="form-control" value="" name="student"
										id="student_field">
										<option value=""><?php echo trans('forms.please_select') ?></option>
                                <?php
                                if (! empty($students)) {
                                    foreach ($students as $student) {
                                        ?>
                                <option
											value="<?php echo $student->id; ?>"><?php echo $student->name; ?></option>
                                <?php } } ?>
                            </select>
								</div>

								<div class="col-12 col-lg-6 mb-4">
									<label for="exampleInputEmail1"><?php echo trans('forms.internship_phase1'); ?></label><br>
									<input type="text" class="form-control date_range"
										name="phase1" id="phase1_field">
								</div>

								<div class="col-12 col-lg-6 mb-4">
									<label for="exampleInputEmail1"><?php echo trans('forms.internship_phase2'); ?></label><br>
									<input type="text" class="form-control date_range"
										name="phase2" id="phase2_field">
								</div>

								<div class="col-12 col-lg-6 mb-4">
									<label for="exampleInputEmail1"><?php echo trans('forms.written_test1'); ?></label><br>
									<input type="text" class="form-control date_range" name="test1"
										id="phase1_field">
								</div>

								<div class="col-12 col-lg-6 mb-4">
									<label for="exampleInputEmail1"><?php echo trans('forms.written_test2'); ?></label><br>
									<input type="text" class="form-control date_range" name="test2"
										id="phase2_field">
								</div>
							</div>

							<div class="row" id="pmmitemplate">
								<div class="col-12 col-lg-12">
									<div class="form-group">
										<label>P/M/MI Template</label> <select class="form-control"
											name="template">
											<option>Please select</option>
                              <?php
                            if (! empty($p_m_mi_templates)) {
                                foreach ($p_m_mi_templates as $template) {
                                    ?>
                              <option
												value="<?php echo $template->id; ?>"><?php echo $template->title; ?></option>
                              <?php } } ?>
                          </select>
									</div>
								</div>
							</div>

							<div class="row" id="pmmiselectblock">
								<div class="col-12 col-lg-12">
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
							</div>

							<button type="submit" class="btn btn-primary pull-right"
								style="margin-right: 10px;" id="submit_btn"><?php echo trans('forms.submit'); ?></button>
						</form>
					</div>

				</div>






				<p class="alert alert-danger" id="error2" style="display: none;"></p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default pull-right"
					data-dismiss="modal" id="add-appointment-close"><?php echo trans('forms.close'); ?></button>
			</div>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<?php //echo $node; //exit(); ?>
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
</script>
<!--<script src="<?php echo url('treejs/tree.min.js'); ?>"></script>-->
<script>
    /*let data = [<?php echo $node; ?>]

    let tree = new Tree('#product-modules-container', {
        data: [{ id: '-1', text: 'Select All', children: data }],
        closeDepth: 3,
        loaded: function () {
            this.values = ['0-0-0', '0-1-1'];
            console.log(this.selectedNodes)
            console.log(this.values)
            //this.disables = ['0-0-0', '0-0-1', '0-0-2']
        },
        onChange: function () {
            console.log(this.values);
        }
    })*/
</script>
<script>
    <?php include(app_path().'/common/panel/show_form.php'); ?>
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
    
    function add_note()
    {
        var notes=$("#note").val();
        if(notes!='')
            {
                notes=notes.replace(/\n/g,"<br>");
                $("#notes-box").prepend("<tr><td><input type='hidden' id='note' name='notes[]' value='"+notes+"'>"+notes+"</td>\
                    <td><center>\
                    <a href='javascript:void(0)' onclick='$(this).parent().parent().parent().remove();' style='color:red;'><i class='fa fa-trash'></i></a>\
                    </center>\
                    </td>\
                </tr>");
                $("#note").val('');
            }
    }
    
    function contract_type2(th)
    {     	
        $("#lehrgang").hide();
        $("#qualifications").hide();
        $("#e_qualifications").hide();
        $("#installments").hide();
        $("#consultation").hide();
        $("#internship_fields").hide();
        $("#pmmitemplate").hide();
        $("#pmmiselectblock").hide();
        $("#product_fields").show();
        
        var contract=$(th).val();
        if(contract=='Education Contract for Student' || contract=='Retraining Contract for Coachee / Student') {
            $("#qualifications").show();
            $("#e_qualifications").show();
            $("#installments").show();
            $("#consultation").show();
            $("#assign_course").attr('required', true);
            $("#pmmitemplate").show();
        }
        else if(contract=='Coaching Contract for Coachee') {
        	$("#assign_course").attr('required', true);
        	$("#pmmiselectblock").show();
        }
        else if(contract=='Contract for Student / Coachee Internship') {
            $("#assign_course").attr('required', false);
            $("#internship_fields").show();
            $("#pmmitemplate").show();
        }
        else if(contract=='Extended Education Contract for Student') {
            $("#lehrgang").show();
            $("#e_qualifications").show();
            $("#pmmitemplate").show();
        }
        else if(contract=='Standard contract for Coach / Trainer') {
        	$("#pmmiselectblock").hide();
        	$("#pmmitemplate").hide();
        	$("#product_fields").hide();
        }
        else {
            $("#assign_course").attr('required', false);
        }
    }
    
    function fetch_contracts(c_id, type)
    {
        $('.nav-link').removeClass('active');
        $('.tab-pane').removeClass('show active');
        
        if(type!='Student' && type!='Coach' && type!='Internship Company') { 
            $(".hide-tab").hide(); 
            $('#documents-tab').addClass('active');
            $('#documents').addClass('show active');
            $('#products-tab').removeClass('active');
            $('#products').removeClass('show active');
        }
        else { 
            $(".hide-tab").show();   
            $('#documents-tab').removeClass('active');
            $('#documents').removeClass('show active');
            $('#products-tab').addClass('active');
            $('#products').addClass('show active');
             }
        
        $('#c_id').val(c_id);
        $('#c_id_certificate').val(c_id);
        
        var formData=new FormData();
        var token='<?php echo csrf_token(); ?>';
        formData.append('_token', token);
        formData.append('c_id', c_id);
        
        
        $.ajax({
                url: "<?php echo url('admin/fetch-contact-products') ?>",
                type: "POST",
                data:  formData,
                beforeSend: function(){ //alert('sending');
                        $("#products").empty();
                },
                contentType: false,
                processData:false,
                success: function(data) { //console.log(data);
                    //success
                    // here we will handle errors and validation messages
                    if ( ! data.success) {
                    } else {
                        // ALL GOOD! just show the success message!
                        $("#products").append(data.products);
                        $("#treeview-contact-products").hummingbird();
                    }
                },
                error: function()  {
                    //error
                } 	        
        });
        
        $.ajax({
                url: "<?php echo url('admin/fetch-contracts') ?>",
                type: "POST",
                data:  formData,
                beforeSend: function(){ //alert('sending');
                        $("#user-contracts").empty();
                },
                contentType: false,
                processData:false,
                success: function(data) { //alert(data);
                    //success
                    // here we will handle errors and validation messages
                    if ( ! data.success) {
                    } else {
                        // ALL GOOD! just show the success message!
                        $("#user-contracts").append(data.contracts);
                    }
                },
                error: function()  {
                    //error
                } 	        
        });
        
        $.ajax({
                url: "<?php echo url('admin/fetch-documents') ?>",
                type: "POST",
                data:  formData,
                beforeSend: function(){ //alert('sending');
                        $("#user-documents").empty();
                },
                contentType: false,
                processData:false,
                success: function(data) { //alert(data);
                    //success
                    // here we will handle errors and validation messages
                    if ( ! data.success) {
                    } else {
                        // ALL GOOD! just show the success message!
                        $("#user-documents").append(data.contracts);
                    }
                },
                error: function()  {
                    //error
                } 	        
        });
    }
    
    function show_box(th)
    {
        var status=0;
        if($(th).is(":checked")) status=1;
        
        var id=$(th).val();
        if(status==1) $(".box-"+id).show();
        else $(".box-"+id).hide();
    }
    
    
    function check_data3()
    {
        $("#error").hide();
        $(".contact_error").hide();
        var atLeastOneIsChecked = $('input[name="courses[]"]:checked').length > 0;
        
        var contact_type=$("#contact_type").val();
        if(contact_type=='Student')
            {
                var dob=$("#dob_field").val();
                var data=dob.split('-');
                
                if(data[2]==(new Date).getFullYear())
                {
                    $("#error").text('<?php echo trans('forms.dob_year_old'); ?>');
                    $("#error").show();
                    $(".contact_error").text('<?php echo trans('forms.dob_year_old'); ?>');
                    $(".contact_error").show();
                    return false;
                }
            }

        if(!$("#period_field").prop('required')){
            
        } else {
            //alert("YES");
        
        var period=$("#period_field").val();
        var dates=period.split(' - ');
        if(dates[0]==dates[1]) 
        {
            $("#error").text('<?php echo trans('forms.beginning_end_same'); ?>');
            $("#error").show();
            $(".contact_error").text('<?php echo trans('forms.beginning_end_same'); ?>');
            $(".contact_error").show();
            return false;
        }
        
        }
        
        if(!atLeastOneIsChecked)
        {
            //$("#error").text('Please select a course first.');
            //$("#error").show();
            //$(".contact_error").text('Please select a course first.');
            //$(".contact_error").show();
            //return false;
        }
        
        return true;
    }
    
    function check_data2()
    {
        $("#error2").hide();
        var contract_type=$("#contract_type").val();
        //alert(contract_type);
        if(contract_type=='Standard contract for Coach / Trainer' || contract_type=='Private Jobsearch contract for Student / Coachee') return true;
        
        if(contract_type=='Contract for Student / Coachee Internship')
        {
            var job_title=$('#job_title_field').val();
            if(job_title=='')
            {
                $("#error2").text('Please enter the job title.');
                $("#error2").show();
                return false;
            }
            
            var student=$('#student_field').val();
            if(student=='')
            {
                $("#error2").text('Please select a student.');
                $("#error2").show();
                return false;
            }
            
            return true;
        }
        
        //var atLeastOneIsChecked = $('input[name="courses[]"]:checked').length > 0;
        var course=$("#assign_course").val();
        
        var period=$("#period_field2").val();
        var dates=period.split(' - ');
        if(dates[0]==dates[1]) 
        {
            $("#error2").text('<?php echo trans('forms.beginning_end_same'); ?>');
            $("#error2").show();
            return false;
        }
        
        if(contract_type=='Private Jobsearch contract for Student / Coachee' || contract_type=='Amendments to Retraining Contract') return true;
        
        if(course=='' || course==null)
        {
            $("#error2").text('<?php echo trans('forms.select_course_first'); ?>');
            $("#error2").show();
            return false;
        }
        
        return true;
    }
    
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
    
    function delete_contract(th, id)
    {
        var rs=confirm('Are you sure you want to delete this?');
        if(rs)
            {
                $(th).parent().parent().remove();
                var formData=new FormData();
                formData.append('_token', '<?php echo csrf_token(); ?>');
                formData.append('id', id);
                $.ajax({
                url: "<?php echo url('admin/delete-contract') ?>",
                type: "POST",
                data:  formData,
                beforeSend: function(){ //alert('sending');
                },
                contentType: false,
                processData:false,
                success: function(data) { //alert(data);
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
    }

    // $(document).ready(function(){
    //     var contract_type = $('#contract_type').val();
    //     hide_show(contract_type);
    // })
    // $('#contract_type').change(function(){
    //     var contract_type = $(this).val();
    //     hide_show(contract_type);
    // })
    /* certificate_type change event */
    $('#certificate_type').change(function(){
   
        var contract_type = $(this).val();
        // if(contract_type == 1){
        //   $('#module_name').hide();
        //   $('#module_I').hide();
        //    $('#qualifi').show();
        //   $('#sub_q').show();


        // }
        
        if(contract_type == 1 || contract_type == 2 || contract_type == 3 || contract_type == 4) {
        
        	$('#an_der_div').show();
        } else {
        $('#an_der_div').hide(); }
        
        if(contract_type == 1 || contract_type == 6){
            $('#module_name_div').hide();
          $('#module_Item').hide();
           $('#qualifi').show();
          $('#sub_q').show();
          $('#add_more_module').hide();
         
           $('#module_items_box').hide();
        }
        
        if(contract_type == 2 || contract_type == 7){
          
            $('#module_name_div').hide();
          $('#module_Item').show();
           $('#qualifi').show();
         $('#add_more_module').hide();
          $('#sub_q').show();
           $('#module_items_box').hide(); 
         
        }
          if(contract_type == 3 || contract_type == 8){
          
           $('#module_name_div').hide();
             $('#module_Item').hide();
          $('#module_items_box').show();
           $('#qualifi').show();
          $('#sub_q').show();
          $('#add_more_module').show();
          
        }
        
        if(contract_type == 4 || contract_type == 5){
            $('#module_name_div').hide();
          $('#module_Item').show();
           $('#qualifi').show();
          $('#sub_q').hide();
          $('#module_items_box').hide();
          $('#add_more_module').hide();
        }
   
    })
</script>
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
	// $(document).ready(function() {
	// 	$('#new_prospect').on('click', function() {

	// 		// var contact_type = $('#contact_type').val();
	// 		// var first_name = $('#first_name_field').val();
	// 		// var last_name = $('#last_name_field').val();
	// 		// var email = $('#email_field').val();
	// 		// var referral_source = $('#referral_source').val();
	// 		// var gender = $('#gender_field').val();
	// 		// var street_name = $('#street_name_field').val();
	// 		// var door_no = $('#door_no_field').val();
	// 		// var additional_address = $('#additional_address_field').val();
	// 		// var zip_code = $('#zip_code_field').val();
	// 		// var city = $('#city_field').val();
	// 		// var dob = $('#dob_field').val();
	// 		// var birth_location = $('#birth_location_field').val();
	// 		// var mobile = $('#mobile_field').val();
	// 		// var marital_status = $('#marital_status_field').val();
	// 		// var org_zeichen = $('#org_zeichen_field').val();
	// 		// var funding_source = $('#funding_source_field').val();
	// 		// var phone_no = $('#phone_no_field').val();
	// 		// var start_working = $('#start_working_field').val();
	// 		// var unlimited_employment = $("input[name='unlimited_employment']:checked").val();
	// 		// var employment_end = $('#employment_end_field').val();
	// 		// var bank_name = $('#bank_name_field').val();
	// 		// var iban = $('#iban_field').val();
	// 		// var bic = $('#bic_field').val();
	// 		// var yearly_salary = $('#yearly_salary_field').val();
	// 		// var working_hours = $('#working_hours_field').val();
	// 		// var probation_period = $('#probation_period_field').val();
	// 		// var position = $('#position_field').val();
	// 		// var price_ue = $('#price_ue_field').val();
	// 		// var customer_no = $('#customer_no_field').val();
	// 		// var child_care = $('#child_care_field').val();
	// 		// var period = $('#period_field').val();
	// 		// var company_name = $('#company_name_field').val();
	// 		// var note = $('#note').val();

	// 		$.ajax({
    //             data: {
	// 				data : serializeData
    //             },
    //             type: "POST",
    //             url: "{{ route('new_prospect_page') }}",

    //             success: function(data) {
    //                 alert("Ajax Success");
    //             },
    //             error: function(error) {
    //                 console.log('error');
    //             }
    //         });

	// 	});
	// });
</script>