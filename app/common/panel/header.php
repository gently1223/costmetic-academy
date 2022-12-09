<!doctype html>
<html lang="en">

<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta http-equiv="Content-Language" content="en">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php if (isset($title)) echo $title . ' | ' . env('APP_NAME'); ?></title>
<meta name="viewport"
	content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no" />
<meta name="description"
	content="This is an example dashboard created using build-in elements and components.">
<link rel="icon" href="/assets/images/logos/favicon.ico">

<!-- Disable tap highlight on IE -->
<meta name="msapplication-tap-highlight" content="no">

<link href="<?php echo url('/assets/main.07a59de7b920cd76b874.css'); ?>"
	rel="stylesheet">
</head>

<style>
.vertical-nav-menu i.metismenu-icon {
	width: 18px;
	height: 28px;
}

.app-header__logo .logo-src {
	width: 180px;
	height: 40px;
	background: none;
}
</style>

<link
	href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css"
	rel="stylesheet">
<link
	href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css"
	rel="stylesheet" />
<style>
.select2-container--default .select2-selection--multiple .select2-selection__choice
	{
	color: black;
}

.select2-container .select2-selection--single {
	height: 100%;
	min-height: 36px;
	padding-top: 4px;
	z-index: 999;
}
</style>

<style>
.daterangepicker {
	z-index: 2000 !important;
}
</style>

<script>
    function resizeIframe(obj) {
        obj.style.height = obj.contentWindow.document.documentElement.scrollHeight + 'px';
    }
</script>
<script
	src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
<script src="<?php echo url('hummingbird/hummingbird-treeview.js'); ?>"></script>
<script type="text/javascript"
	src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript"
	src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

<body>
	<div
		class="app-container app-theme-gray app-sidebar-full fixed-sidebar <?php if (isset($close_sidebar)) echo 'header-mobile-open'; ?>">
		<div class="app-main">
			<div class="app-sidebar-wrapper">
				<div class="app-sidebar sidebar-shadow">
					<!--app-sidebar sidebar-shadow -->
					<div class="app-header__logo"
						style="padding-top: 15px; padding-bottom: 15px;">
						<img class="img-responsive logo-src"
							src="<?php echo url('images/logo.png'); ?>"
							alt="NextLevel Akademie" style="max-width: 180px;">
						<button type="button"
							class="hamburger hamburger--elastic mobile-toggle-nav is-active">
							<span class="hamburger-box"> <span class="hamburger-inner"></span>
							</span>
						</button>
					</div>
					<div class="scrollbar-sidebar scrollbar-container">
						<div class="app-sidebar__inner">
							<ul class="vertical-nav-menu">
								<li class="app-sidebar__heading"><?php echo trans('header.menu'); ?></li>
								<li
									class="<?php if ($title == trans('header.dashboard')) echo 'mm-active'; ?>">
									<a href="<?php echo url('admin/dashboard'); ?>"> <i
										class="metismenu-icon fas fa-tachometer-alt"></i>
                                        <?php echo trans('header.dashboard'); ?>
                                    </a>
								</li>

								<li
									class="<?php if ($title == trans('header.contacts') or $title == 'Edit Contact') echo 'mm-active'; ?>">
									<a href="<?php echo url('admin/contacts'); ?>"> <i
										class="metismenu-icon fa fa-address-book"></i>
                                        <?php echo trans('header.contacts'); ?>
                                    </a>
								</li>
								<li
									class="<?php if ($title == trans('header.manage_offer')) echo 'mm-active'; ?>">
									<a href="<?php echo url('admin/manage_offer'); ?>"> <i class="metismenu-icon fa fa-book"></i>
                                        <?php echo trans('header.manage_offer'); ?>
                                    </a>
								</li>
								<li
									class="<?php if ($title == trans('header.cvs')) echo 'mm-active'; ?>">
									<a href="<?php echo url('admin/cvs'); ?>"> <i
										class="metismenu-icon fa fa-address-book"></i>
                                        <?php echo trans('header.cvs'); ?>
                                    </a>
								</li>
								<li
									class="<?php if ($title == trans('header.certificates')) echo 'mm-active'; ?>">
									<a href="<?php echo url('admin/certificates'); ?>"> <i
										class="metismenu-icon fa fa-file"></i>
                                        <?php echo trans('header.certificates'); ?>
                                    </a>
								</li>

								<li
									class="<?php if ($title == trans('header.todo')) echo 'mm-active'; ?>">
									<a href="<?php echo url('admin/to-do'); ?>"> <i
										class="metismenu-icon fa fa-check-square"></i>
                                        <?php echo trans('header.todo'); ?>
                                    </a>
								</li>

								<li
									class="<?php if ($title == trans('header.appointments')) echo 'mm-active'; ?>">
									<a href="<?php echo url('admin/appointments'); ?>"> <i
										class="metismenu-icon fa fa-calendar-alt"></i>
                                        <?php echo trans('header.appointments'); ?>
                                    </a>
								</li>

								<li
									class="<?php if ($title == trans('header.sick_leaves')) echo 'mm-active'; ?>">
									<a href="<?php echo url('admin/sick-leaves'); ?>"> <i
										class="metismenu-icon fa fa-stethoscope"></i>
                                        <?php echo trans('header.sick_leaves'); ?>
                                    </a>
								</li>

								<li
									class="<?php if ($title == trans('header.contracts_documents')) echo 'mm-active'; ?>">
									<a href="<?php echo url('admin/contracts-documents'); ?>"> <i
										class="metismenu-icon fa fa-file"></i>
                                        <?php echo trans('header.contracts_documents'); ?>
                                    </a>
								</li>

								<li
									class="<?php if ($title == trans('header.coaching_courses')) echo 'mm-active'; ?>">
									<a href="<?php echo url('admin/coaching-courses'); ?>"> <i
										class="metismenu-icon fa fa-user-shield"></i>
                                        <?php echo trans('header.coaching_courses'); ?>
                                    </a>
								</li>
								<li
									class="<?php if ($title == trans('header.offer')) echo 'mm-active'; ?>">
									<a href="<?php echo url('admin/coaching-offers'); ?>"> <i
										class="metismenu-icon fa fa-book"></i>
                                        <?php echo trans('header.offer'); ?>
                                    </a>
								</li>
								<li
									class="<?php if ($title == trans('header.regular_courses')) echo 'mm-active'; ?>">
									<a href="<?php echo url('admin/regular-courses'); ?>"> <i
										class="metismenu-icon fa fa-graduation-cap"></i>
                                        <?php echo trans('header.regular_courses'); ?>
                                    </a>
								</li>

								<li
									class="<?php if ($title == 'Attendance Register') echo 'mm-active'; ?>">
									<a href="<?php echo url('admin/attendance-register'); ?>"> <i
										class="metismenu-icon fa fa-book"></i>
                                        <?php echo trans('header.attendance_register'); ?>
                                    </a>
								</li>
								

								<li><a href="javascript:void(0);"> <i
										class="metismenu-icon fa fa-list"></i>
                                        <?php echo trans('header.manage_products'); ?>
                                        <i
										class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
								</a>
									<ul>
										<li
											class="<?php if ($title == trans('header.all_products') or $title == 'Edit Product') echo 'mm-active'; ?>">
											<a href="<?php echo url('admin/products'); ?>"> <i
												class="metismenu-icon"></i>
                                                <?php echo trans('header.all_products'); ?>
                                            </a>
										</li>

										<li
											class="<?php if ($title == trans('header.all_modules') or $title == 'Edit Module') echo 'mm-active'; ?>">
											<a href="<?php echo url('admin/modules'); ?>"> <i
												class="metismenu-icon"></i>
                                                <?php echo trans('header.all_modules'); ?>
                                            </a>
										</li>

										<li
											class="<?php if ($title == trans('header.all_module_items') or $title == 'Edit Module Item') echo 'mm-active'; ?>">
											<a href="<?php echo url('admin/module-items'); ?>"> <i
												class="metismenu-icon"></i>
                                                <?php echo trans('header.all_module_items'); ?>
                                            </a>
										</li>
										<li
											class="<?php if ($title == trans('header.all_module_item_services') or $title == 'Edit Module Item Service') echo 'mm-active'; ?>">
											<a href="<?php echo url('admin/module-item-services'); ?>"> <i
												class="metismenu-icon"></i>
                                                <?php echo trans('header.all_module_item_services'); ?>
                                            </a>
										</li>

										<li
											class="<?php if ($title == 'P/M/MI Templates' or $title == 'Edit P/M/MI Template') echo 'mm-active'; ?>">
											<a href="<?php echo url('admin/p-m-mi-templates'); ?>"> <i
												class="metismenu-icon"></i> P/M/MI Templates
										</a>
										</li>
									</ul></li>

								<li><a href="javascript:void(0);"> <i
										class="metismenu-icon fa fa-bullhorn"></i>
                                        <?php echo trans('header.marketing'); ?>
                                        <i
										class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
								</a>
									<ul>
										<li
											class="<?php if ($title == trans('header.subscribers')) echo 'mm-active'; ?>">
											<a href="<?php echo url('admin/subscribers'); ?>"> <i
												class="metismenu-icon"></i>
                                                <?php echo trans('header.subscribers'); ?>
                                            </a>
										</li>
									</ul></li>


                                <?php if ($admin_type == '1' or $admin_type == '2') { ?>
                                    <li
									class="<?php if ($title == trans('header.manage_users') or $title == 'Edit User') echo 'mm-active'; ?>">
									<a href="<?php echo url('admin/manage-users'); ?>"> <i
										class="metismenu-icon fa fa-users"></i>
                                            <?php echo trans('header.manage_users'); ?>
                                        </a>
								</li>
                                <?php } ?>

                                <li
									class="<?php if ($title == 'Rooms' or $title == 'Edit Room') echo 'mm-active'; ?>">
									<a href="<?php echo url('admin/rooms'); ?>"> <i
										class="metismenu-icon fa fa-building"></i>
                                        <?php echo trans('header.manage_rooms'); ?>
                                    </a>
								</li>

								<li><a href="javascript:void(0);"> <i
										class="metismenu-icon fa fa-tags"></i>
                                        <?php echo trans('header.manage_meta_data'); ?>
                                        <i
										class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
								</a>
									<ul>
										<li
											class="<?php if ($title == trans('header.holidays')) echo 'mm-active'; ?>">
											<a href="<?php echo url('admin/holidays'); ?>"> <i
												class="metismenu-icon"></i>
                                                <?php echo trans('header.holidays'); ?>
                                            </a>
										</li>
										<li
											class="<?php if ($title == trans('header.calendar_categories') or $title == 'Edit calendar category') echo 'mm-active'; ?>">
											<a href="<?php echo url('admin/calendar-categories'); ?>"> <i
												class="metismenu-icon"></i>
                                                <?php echo trans('header.calendar_categories'); ?>
                                            </a>
										</li>
										<li
											class="<?php if ($title == trans('header.product_categories')) echo 'mm-active'; ?>">
											<a href="<?php echo url('admin/product-categories'); ?>"> <i
												class="metismenu-icon"></i>
                                                <?php echo trans('header.product_categories'); ?>
                                            </a>
										</li>
										<li
											class="<?php if ($title == trans('header.room_locations') or $title == 'Edit Room Location') echo 'mm-active'; ?>">
											<a href="<?php echo url('admin/room-locations'); ?>"> <i
												class="metismenu-icon"></i>
                                                <?php echo trans('header.room_locations'); ?>
                                            </a>
										</li>
										<li
											class="<?php if ($title == trans('header.funding_sources') or $title == 'Edit Funding Source') echo 'mm-active'; ?>">
											<a href="<?php echo url('admin/funding-sources'); ?>"> <i
												class="metismenu-icon"></i>
                                                <?php echo trans('header.funding_sources'); ?>
                                            </a>
										</li>
										<li
											class="<?php if ($title == 'Document Types' or $title == 'Edit Document Type') echo 'mm-active'; ?>">
											<a href="<?php echo url('admin/documents'); ?>"> <i
												class="metismenu-icon"></i>
                                                <?php echo trans('header.document_types'); ?>
                                            </a>
										</li>
										<li
											class="<?php if ($title == 'Referral Sources' or $title == 'Edit Referral Source') echo 'mm-active'; ?>">
											<a href="<?php echo url('admin/referral-sources'); ?>"> <i
												class="metismenu-icon"></i>
                                                <?php echo trans('header.referral_sources'); ?>
                                            </a>
										</li>
										<li
											class="<?php if ($title == 'Teaching methods' or $title == 'Edit Teaching Method') echo 'mm-active'; ?>">
											<a href="<?php echo url('admin/teaching-methods'); ?>"> <i
												class="metismenu-icon"></i>
                                                <?php echo trans('header.teaching_methods'); ?>
                                            </a>
										</li>
									</ul></li>

								<li
									class="<?php if ($title == trans('header.activities')) echo 'mm-active'; ?>">
									<a href="<?php echo url('admin/activities'); ?>"> <i
										class="metismenu-icon fa fa-history"></i>
                                        <?php echo trans('header.activities'); ?>
                                    </a>
								</li>

							</ul>
						</div>
					</div>
				</div>
			</div>
			<div class="app-sidebar-overlay d-none animated fadeIn"></div>
			<div class="app-main__outer">
				<div class="app-main__inner">
					<div class="header-mobile-wrapper">
						<div class="app-header__logo">
							<a href="#" data-toggle="tooltip" data-placement="bottom"
								title="KeroUI Admin Template" class="logo-src"></a>
							<button type="button"
								class="hamburger hamburger--elastic mobile-toggle-sidebar-nav">
								<span class="hamburger-box"> <span class="hamburger-inner"></span>
								</span>
							</button>
							<div class="app-header__menu">
								<span>
									<button type="button"
										class="btn-icon btn-icon-only btn btn-primary btn-sm mobile-toggle-header-nav">
										<span class="btn-icon-wrapper"> <i
											class="fa fa-ellipsis-v fa-w-6"></i>
										</span>
									</button>
								</span>
							</div>
						</div>
					</div>
					<div class="app-header">
						<div class="page-title-heading" style="height: 80px;">
                            <?php if (isset($title)) echo $title; ?>
                            <div class="page-title-subheading">
                                <?php if (isset($sub_title)) echo $sub_title; ?>
                            </div>
						</div>
						<div class="app-header-right">
							<div class="header-btn-lg pr-0">
								<div class="header-dots">
									<div class="dropdown">
										<button type="button" aria-haspopup="true"
											aria-expanded="false" data-toggle="dropdown"
											class="p-0 btn btn-link">
											<i class="typcn typcn-bell"></i> <span
												class="badge badge-dot badge-dot-sm badge-danger">Notifications</span>
										</button>
										<div tabindex="-1" role="menu" aria-hidden="true"
											class="dropdown-menu-xl rm-pointers dropdown-menu dropdown-menu-right">
											<div class="dropdown-menu-header mb-0">
												<div class="dropdown-menu-header-inner bg-night-sky">
													<div class="menu-header-image opacity-5"
														style="background-image: url('assets/images/dropdown-header/city2.jpg');"></div>
													<div class="menu-header-content text-light">
														<h5 class="menu-header-title">Notifications</h5>
														<h6 class="menu-header-subtitle">
															You have <b>21</b> unread messages
														</h6>
													</div>
												</div>
											</div>
											<ul
												class="tabs-animated-shadow tabs-animated nav nav-justified tabs-shadow-bordered p-3">
												<li class="nav-item"><a role="tab" class="nav-link active"
													data-toggle="tab" href="#tab-messages-header"> <span>Messages</span>
												</a></li>
												<li class="nav-item"><a role="tab" class="nav-link"
													data-toggle="tab" href="#tab-events-header"> <span>Events</span>
												</a></li>
												<li class="nav-item"><a role="tab" class="nav-link"
													data-toggle="tab" href="#tab-errors-header"> <span>System</span>
												</a></li>
											</ul>
											<div class="tab-content">
												<div class="tab-pane active" id="tab-messages-header"
													role="tabpanel">
													<div class="scroll-area-sm">
														<div class="scrollbar-container">
															<div class="p-3">
																<div class="notifications-box">
																	<div
																		class="vertical-time-simple vertical-without-time vertical-timeline vertical-timeline--one-column">
																		<div
																			class="vertical-timeline-item dot-danger vertical-timeline-element">
																			<div>
																				<span
																					class="vertical-timeline-element-icon bounce-in"></span>
																				<div
																					class="vertical-timeline-element-content bounce-in">
																					<h4 class="timeline-title">All Hands Meeting</h4>
																					<span class="vertical-timeline-element-date"></span>
																				</div>
																			</div>
																		</div>
																		<div
																			class="vertical-timeline-item dot-warning vertical-timeline-element">
																			<div>
																				<span
																					class="vertical-timeline-element-icon bounce-in"></span>
																				<div
																					class="vertical-timeline-element-content bounce-in">
																					<p>
																						Yet another one, at <span class="text-success">15:00
																							PM</span>
																					</p>
																					<span class="vertical-timeline-element-date"></span>
																				</div>
																			</div>
																		</div>
																		<div
																			class="vertical-timeline-item dot-success vertical-timeline-element">
																			<div>
																				<span
																					class="vertical-timeline-element-icon bounce-in"></span>
																				<div
																					class="vertical-timeline-element-content bounce-in">
																					<h4 class="timeline-title">
																						Build the production release <span
																							class="badge badge-danger ml-2">NEW</span>
																					</h4>
																					<span class="vertical-timeline-element-date"></span>
																				</div>
																			</div>
																		</div>
																		<div
																			class="vertical-timeline-item dot-primary vertical-timeline-element">
																			<div>
																				<span
																					class="vertical-timeline-element-icon bounce-in"></span>
																				<div
																					class="vertical-timeline-element-content bounce-in">
																					<h4 class="timeline-title">
																						Something not important
																						<div
																							class="avatar-wrapper mt-2 avatar-wrapper-overlap">
																							<div class="avatar-icon-wrapper avatar-icon-sm">
																								<div class="avatar-icon">
																									<!--<img src="assets/images/avatars/1.jpg" alt="">-->
																								</div>
																							</div>
																							<div
																								class="avatar-icon-wrapper avatar-icon-sm avatar-icon-add">
																								<div class="avatar-icon">
																									<i>+</i>
																								</div>
																							</div>
																						</div>
																					</h4>
																					<span class="vertical-timeline-element-date"></span>
																				</div>
																			</div>
																		</div>
																		<div
																			class="vertical-timeline-item dot-info vertical-timeline-element">
																			<div>
																				<span
																					class="vertical-timeline-element-icon bounce-in"></span>
																				<div
																					class="vertical-timeline-element-content bounce-in">
																					<h4 class="timeline-title">This dot has an info
																						state</h4>
																					<span class="vertical-timeline-element-date"></span>
																				</div>
																			</div>
																		</div>
																		<div
																			class="vertical-timeline-item dot-danger vertical-timeline-element">
																			<div>
																				<span
																					class="vertical-timeline-element-icon bounce-in"></span>
																				<div
																					class="vertical-timeline-element-content bounce-in">
																					<h4 class="timeline-title">All Hands Meeting</h4>
																					<span class="vertical-timeline-element-date"></span>
																				</div>
																			</div>
																		</div>
																		<div
																			class="vertical-timeline-item dot-warning vertical-timeline-element">
																			<div>
																				<span
																					class="vertical-timeline-element-icon bounce-in"></span>
																				<div
																					class="vertical-timeline-element-content bounce-in">
																					<p>
																						Yet another one, at <span class="text-success">15:00
																							PM</span>
																					</p>
																					<span class="vertical-timeline-element-date"></span>
																				</div>
																			</div>
																		</div>
																		<div
																			class="vertical-timeline-item dot-success vertical-timeline-element">
																			<div>
																				<span
																					class="vertical-timeline-element-icon bounce-in"></span>
																				<div
																					class="vertical-timeline-element-content bounce-in">
																					<h4 class="timeline-title">
																						Build the production release <span
																							class="badge badge-danger ml-2">NEW</span>
																					</h4>
																					<span class="vertical-timeline-element-date"></span>
																				</div>
																			</div>
																		</div>
																		<div
																			class="vertical-timeline-item dot-dark vertical-timeline-element">
																			<div>
																				<span
																					class="vertical-timeline-element-icon bounce-in"></span>
																				<div
																					class="vertical-timeline-element-content bounce-in">
																					<h4 class="timeline-title">This dot has a dark
																						state</h4>
																					<span class="vertical-timeline-element-date"></span>
																				</div>
																			</div>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>
												<div class="tab-pane" id="tab-events-header" role="tabpanel">
													<div class="scroll-area-sm">
														<div class="scrollbar-container">
															<div class="p-3">
																<div
																	class="vertical-without-time vertical-timeline vertical-timeline--animate vertical-timeline--one-column">
																	<div
																		class="vertical-timeline-item vertical-timeline-element">
																		<div>
																			<span
																				class="vertical-timeline-element-icon bounce-in"><i
																				class="badge badge-dot badge-dot-xl badge-success">
																			</i></span>
																			<div
																				class="vertical-timeline-element-content bounce-in">
																				<h4 class="timeline-title">All Hands Meeting</h4>
																				<p>
																					Lorem ipsum dolor sic amet, today at <a
																						href="javascript:void(0);">12:00 PM</a>
																				</p>
																				<span class="vertical-timeline-element-date"></span>
																			</div>
																		</div>
																	</div>
																	<div
																		class="vertical-timeline-item vertical-timeline-element">
																		<div>
																			<span
																				class="vertical-timeline-element-icon bounce-in"><i
																				class="badge badge-dot badge-dot-xl badge-warning">
																			</i></span>
																			<div
																				class="vertical-timeline-element-content bounce-in">
																				<p>
																					Another meeting today, at <b class="text-danger">12:00
																						PM</b>
																				</p>
																				<p>
																					Yet another one, at <span class="text-success">15:00
																						PM</span>
																				</p>
																				<span class="vertical-timeline-element-date"></span>
																			</div>
																		</div>
																	</div>
																	<div
																		class="vertical-timeline-item vertical-timeline-element">
																		<div>
																			<span
																				class="vertical-timeline-element-icon bounce-in"><i
																				class="badge badge-dot badge-dot-xl badge-danger"> </i></span>
																			<div
																				class="vertical-timeline-element-content bounce-in">
																				<h4 class="timeline-title">Build the production
																					release</h4>
																				<p>Lorem ipsum dolor sit amit,consectetur eiusmdd
																					tempor incididunt ut labore et dolore magna elit
																					enim at minim veniam quis nostrud</p>
																				<span class="vertical-timeline-element-date"></span>
																			</div>
																		</div>
																	</div>
																	<div
																		class="vertical-timeline-item vertical-timeline-element">
																		<div>
																			<span
																				class="vertical-timeline-element-icon bounce-in"><i
																				class="badge badge-dot badge-dot-xl badge-primary">
																			</i></span>
																			<div
																				class="vertical-timeline-element-content bounce-in">
																				<h4 class="timeline-title text-success">Something
																					not important</h4>
																				<p>Lorem ipsum dolor sit amit,consectetur elit enim
																					at minim veniam quis nostrud</p>
																				<span class="vertical-timeline-element-date"></span>
																			</div>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>
												<div class="tab-pane" id="tab-errors-header" role="tabpanel">
													<div class="scroll-area-sm">
														<div class="scrollbar-container">
															<div class="no-results pt-3 pb-0">
																<div
																	class="swal2-icon swal2-success swal2-animate-success-icon">
																	<div class="swal2-success-circular-line-left"
																		style="background-color: rgb(255, 255, 255);"></div>
																	<span class="swal2-success-line-tip"></span> <span
																		class="swal2-success-line-long"></span>
																	<div class="swal2-success-ring"></div>
																	<div class="swal2-success-fix"
																		style="background-color: rgb(255, 255, 255);"></div>
																	<div class="swal2-success-circular-line-right"
																		style="background-color: rgb(255, 255, 255);"></div>
																</div>
																<div class="results-subtitle">All caught up!</div>
																<div class="results-title">There are no system errors!</div>
															</div>
														</div>
													</div>
												</div>
											</div>
											<ul class="nav flex-column">
												<li class="nav-item-divider nav-item"></li>
												<li class="nav-item-btn text-center nav-item">
													<button
														class="btn-shadow btn-wide btn-pill btn btn-focus btn-sm">View
														Latest Changes</button>
												</li>
											</ul>
										</div>
									</div>
								</div>
							</div>
							<div class="header-btn-lg pr-0">
								<div class="widget-content p-0">
									<div class="widget-content-wrapper">
										<div class="widget-content-left">
											<div class="btn-group">
                                                <?php

if (empty($admin->profile_image))
                                                    $user_img = url('images/avatar.jpg');
                                                else
                                                    $user_img = url('images/profile/' . $admin->profile_image);
                                                ?>
                                                <a
													data-toggle="dropdown" aria-haspopup="true"
													aria-expanded="false" class="p-0 btn"> <img width="42"
													class="rounded" src="<?php echo $user_img; ?>" alt=""> <i
													class="fa fa-angle-down ml-2 opacity-8"></i>
												</a>
												<div tabindex="-1" role="menu" aria-hidden="true"
													class="rm-pointers dropdown-menu-lg dropdown-menu dropdown-menu-right">
													<div class="dropdown-menu-header">
														<div class="dropdown-menu-header-inner bg-info">
															<div class="menu-header-image opacity-2" style="background-image: url('<?php echo url('assets/images/dropdown-header/city1.jpg'); ?>');"></div>
															<div class="menu-header-content text-left">
																<div class="widget-content p-0">
																	<div class="widget-content-wrapper">
																		<div class="widget-content-left mr-3">
																			<img width="42" class="rounded-circle"
																				src="<?php echo $user_img; ?>" alt="">
																		</div>
																		<div class="widget-content-left">
																			<div class="widget-heading"><?php echo $admin->name; ?>
                                                                            </div>
																		</div>
																		<div class="widget-content-right mr-2">
																			<a href="<?php echo url('admin/logout'); ?>"><button
																					class="btn-pill btn-shadow btn-shine btn btn-focus"><?php echo trans('header.logout'); ?>
                                                                                </button></a>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</div>
													<div class="scroll-area-xs" style="height: 150px;">
														<div class="scrollbar-container ps">
															<ul class="nav flex-column">
																<li class="nav-item-header nav-item"><?php echo trans('header.menu'); ?>
                                                                </li>
																<li class="nav-item"><a
																	href="<?php echo url('admin/my-profile'); ?>"
																	class="nav-link"><?php echo trans('header.my_profile'); ?>
                                                                    </a>
																</li>
																<li class="nav-item"><a
																	href="<?php echo url('admin/my-profile#change_password'); ?>"
																	class="nav-link"><?php echo trans('header.change_password'); ?>
                                                                    </a>
																</li>
																<li class="nav-item"><a
																	href="<?php echo url('admin/logout'); ?>"
																	class="nav-link"><?php echo trans('header.logout'); ?>
                                                                    </a>
																</li>
															</ul>
														</div>
													</div>
													<!--<ul class="nav flex-column">
                                                        <li class="nav-item-divider mb-0 nav-item"></li>
                                                    </ul>
                                                    <ul class="nav flex-column">
                                                        <li class="nav-item-divider nav-item">
                                                        </li>
                                                        <li class="nav-item-btn text-center nav-item">
                                                            <button class="btn-wide btn btn-primary btn-sm">
                                                                Open Messages
                                                            </button>
                                                        </li>
                                                    </ul>-->
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="app-header-overlay d-none animated fadeIn"></div>
					</div>