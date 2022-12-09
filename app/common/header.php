<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Language" content="en">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?php if (isset($title)) echo $title . ' | ' . env('APP_NAME'); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no" />
    <meta name="description" content="This is an example dashboard created using build-in elements and components.">
    <link rel="icon" href="/assets/images/logos/favicon.ico">

    <!-- Disable tap highlight on IE -->
    <meta name="msapplication-tap-highlight" content="no">
    
    <link href="<?php echo url('/assets/jqx.base.css'); ?>" rel="stylesheet">
    <link href="<?php echo url('/assets/main.07a59de7b920cd76b874.css'); ?>" rel="stylesheet">
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

    .app-header__logo .logo-src,
    .app-inner-layout .app-inner-layout__wrapper .sidebar-text-light.app-inner-layout__sidebar.card .app-header__logo .logo-src {
        background: none !important;
    }
</style>

<link href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css" rel="stylesheet">

<script>
    function resizeIframe(obj) {
        obj.style.height = obj.contentWindow.document.documentElement.scrollHeight + 'px';
    }
</script>

<style>
    .app-sidebar.sidebar-text-light .app-header__logo .hamburger-inner,
    .app-inner-layout .app-inner-layout__wrapper .sidebar-text-light.app-inner-layout__sidebar.card .app-header__logo .hamburger-inner,
    .app-sidebar.sidebar-text-light .app-header__logo .hamburger-inner::before,
    .app-inner-layout .app-inner-layout__wrapper .sidebar-text-light.app-inner-layout__sidebar.card .app-header__logo .hamburger-inner::before,
    .app-sidebar.sidebar-text-light .app-header__logo .hamburger-inner::after,
    .app-inner-layout .app-inner-layout__wrapper .sidebar-text-light.app-inner-layout__sidebar.card .app-header__logo .hamburger-inner::after {
        background-color: #495057;
    }
</style>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
<style>
    .select2-container--default .select2-selection--multiple .select2-selection__choice {
        color: black;
    }

    .select2-container .select2-selection--single {
        height: 100%;
        min-height: 36px;
        padding-top: 4px;
        z-index: 999;
    }
</style>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
<script src="<?php echo url('hummingbird/hummingbird-treeview.js'); ?>"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>


<body>
    <div class="app-container app-theme-gray app-sidebar-full fixed-sidebar <?php if (isset($close_sidebar)) echo 'header-mobile-open'; ?>">
        <div class="app-main">
            <div class="app-sidebar-wrapper">
                <div class="app-sidebar bg-dark sidebar-text-light">
                    <!--app-sidebar sidebar-shadow -->
                    <div class="app-header__logo" style="background:white;">
                        <img class="img-responsive logo-src" src="<?php echo url('images/logo.png'); ?>" alt="NextLevel Akademie" style="max-width:180px;">
                        <button type="button" class="hamburger hamburger--elastic mobile-toggle-nav">
                            <span class="hamburger-box">
                                <span class="hamburger-inner" style="background-color: #495057;"></span>
                            </span>
                        </button>
                    </div>
                    <div class="scrollbar-sidebar scrollbar-container">
                        <div class="app-sidebar__inner">
                            <ul class="vertical-nav-menu">
                                <li class="app-sidebar__heading"><?php echo trans('header.menu'); ?></li>

                                <li class="<?php if ($title == 'Dashboard') echo 'mm-active'; ?>">
                                    <a href="<?php echo url('dashboard'); ?>">
                                        <i class="metismenu-icon fas fa-tachometer-alt"></i>
                                        <?php echo trans('header.dashboard'); ?>
                                    </a>
                                </li>

                                <li class="<?php if ($title == 'To-Do') echo 'mm-active'; ?>">
                                    <a href="<?php echo url('to-do'); ?>">
                                        <i class="metismenu-icon fa fa-check-square"></i>
                                        <?php echo trans('header.todo'); ?>
                                    </a>
                                </li>

                                <li class="<?php if ($title == 'My Contracts') echo 'mm-active'; ?>">
                                    <a href="<?php echo url('my-contracts'); ?>">
                                        <i class="metismenu-icon fa fa-file"></i>
                                        <?php echo trans('header.my_contracts'); ?>
                                    </a>
                                </li>

                                <li class="<?php if ($title == 'My Appointments') echo 'mm-active'; ?>">
                                    <a href="<?php echo url('my-appointments'); ?>">
                                        <i class="metismenu-icon fa fa-calendar"></i>
                                        <?php echo trans('header.my_appointments'); ?>
                                    </a>
                                </li>

                                <?php if ($user->type != 'Coach') { ?>
                                    <li class="<?php if ($title == trans('header.sick_leaves')) echo 'mm-active'; ?>">
                                        <a href="<?php echo url('sick-leaves'); ?>">
                                            <i class="metismenu-icon fa fa-calendar"></i>
                                            <?php echo trans('header.sick_leaves'); ?>
                                        </a>
                                    </li>
                                <?php } ?>

                                <?php if ($user->type == 'Coach') { ?>
                                    <li class="<?php if ($title == 'Attendance Register') echo 'mm-active'; ?>">
                                        <a href="<?php echo url('attendance-register'); ?>">
                                            <i class="metismenu-icon fa fa-book"></i>
                                            <?php echo trans('header.attendance_register'); ?>
                                        </a>
                                    </li>
                                <?php } else { ?>
                                    <li class="<?php if ($title == 'My Attendance') echo 'mm-active'; ?>">
                                        <a href="<?php echo url('my-attendance'); ?>">
                                            <i class="metismenu-icon fa fa-book"></i>
                                            <?php echo trans('header.my_attendance'); ?>
                                        </a>
                                    </li>
                                <?php } ?>

                                <?php if ($user->type == 'Coach') { ?>
                                    <li class="<?php if ($title == 'Course Offers') echo 'mm-active'; ?>">
                                        <a href="<?php echo url('course-offers'); ?>">
                                            <i class="metismenu-icon fa fa-plus"></i>
                                            <?php echo trans('header.course_offers'); ?>
                                        </a>
                                    </li>
                                    <li class="<?php if ($title == trans('header.offer')) echo 'mm-active'; ?>">
                                    <a href="<?php echo route('contacts.view'); ?>">
                                        <i class="metismenu-icon fa fa-book"></i>
                                        <?php echo trans('header.offer'); ?>
                                    </a>
                                </li>
                                <?php } ?>

                                <?php if ($user->type != 'Coach') { ?>
                                    <li class="<?php if ($title == trans('header.my_cvs')) echo 'mm-active'; ?>">
                                        <a href="<?php echo url('my-cvs'); ?>">
                                            <i class="metismenu-icon fas fa-user"></i>
                                            <?php echo trans('header.my_cvs'); ?>
                                        </a>
                                    </li>
                                <?php } ?>

                                <li class="<?php if ($title == trans('header.my_profile')) echo 'mm-active'; ?>">
                                    <a href="<?php echo url('my-profile'); ?>">
                                        <i class="metismenu-icon fas fa-user"></i>
                                        <?php echo trans('header.my_profile'); ?>
                                    </a>
                                </li>
								<li class="<?php if ($title == trans('header.room_overview')) echo 'mm-active'; ?>">
                                    <a href="<?php echo url('room-overview'); ?>">
                                        <i class="metismenu-icon fas fa-user"></i>
                                        <?php echo trans('header.room_overview'); ?>
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
                            <a href="#" data-toggle="tooltip" data-placement="bottom" title="KeroUI Admin Template" class="logo-src"></a>
                            <button type="button" class="hamburger hamburger--elastic mobile-toggle-sidebar-nav">
                                <span class="hamburger-box">
                                    <span class="hamburger-inner"></span>
                                </span>
                            </button>
                            <div class="app-header__menu">
                                <span>
                                    <button type="button" class="btn-icon btn-icon-only btn btn-primary btn-sm mobile-toggle-header-nav">
                                        <span class="btn-icon-wrapper">
                                            <i class="fa fa-ellipsis-v fa-w-6"></i>
                                        </span>
                                    </button>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="app-header">
                        <div class="page-title-heading" style="height:80px;">
                            <?php if (isset($title)) echo $title; ?>
                            <div class="page-title-subheading">
                                <?php if (isset($sub_title)) echo $sub_title; ?>
                            </div>
                        </div>
                        <div class="app-header-right">
                            <div class="header-btn-lg pr-0">
                                <div class="header-dots">
                                    <div class="dropdown">
                                        <button type="button" aria-haspopup="true" aria-expanded="false" data-toggle="dropdown" class="p-0 btn btn-link">
                                            <i class="typcn typcn-bell"></i>
                                            <span class="badge badge-dot badge-dot-sm badge-danger">Notifications</span>
                                        </button>
                                        <div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu-xl rm-pointers dropdown-menu dropdown-menu-right">
                                            <div class="dropdown-menu-header mb-0">
                                                <div class="dropdown-menu-header-inner bg-night-sky">
                                                    <div class="menu-header-image opacity-5" style="background-image: url('/assets/images/dropdown-header/city2.jpg');"></div>
                                                    <div class="menu-header-content text-light">
                                                        <h5 class="menu-header-title">Notifications</h5>
                                                        <h6 class="menu-header-subtitle">You have <b>21</b> unread messages</h6>
                                                    </div>
                                                </div>
                                            </div>
                                            <ul class="tabs-animated-shadow tabs-animated nav nav-justified tabs-shadow-bordered p-3">
                                                <li class="nav-item">
                                                    <a role="tab" class="nav-link active" data-toggle="tab" href="#tab-messages-header">
                                                        <span>Messages</span>
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a role="tab" class="nav-link" data-toggle="tab" href="#tab-events-header">
                                                        <span>Events</span>
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a role="tab" class="nav-link" data-toggle="tab" href="#tab-errors-header">
                                                        <span>System</span>
                                                    </a>
                                                </li>
                                            </ul>
                                            <div class="tab-content">
                                                <div class="tab-pane active" id="tab-messages-header" role="tabpanel">
                                                    <div class="scroll-area-sm">
                                                        <div class="scrollbar-container">
                                                            <div class="p-3">
                                                                <div class="notifications-box">
                                                                    <div class="vertical-time-simple vertical-without-time vertical-timeline vertical-timeline--one-column">
                                                                        <div class="vertical-timeline-item dot-danger vertical-timeline-element">
                                                                            <div><span class="vertical-timeline-element-icon bounce-in"></span>
                                                                                <div class="vertical-timeline-element-content bounce-in">
                                                                                    <h4 class="timeline-title">All Hands Meeting</h4><span class="vertical-timeline-element-date"></span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="vertical-timeline-item dot-warning vertical-timeline-element">
                                                                            <div><span class="vertical-timeline-element-icon bounce-in"></span>
                                                                                <div class="vertical-timeline-element-content bounce-in">
                                                                                    <p>Yet another one, at <span class="text-success">15:00 PM</span></p><span class="vertical-timeline-element-date"></span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="vertical-timeline-item dot-success vertical-timeline-element">
                                                                            <div><span class="vertical-timeline-element-icon bounce-in"></span>
                                                                                <div class="vertical-timeline-element-content bounce-in">
                                                                                    <h4 class="timeline-title">Build the production release
                                                                                        <span class="badge badge-danger ml-2">NEW</span>
                                                                                    </h4>
                                                                                    <span class="vertical-timeline-element-date"></span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="vertical-timeline-item dot-primary vertical-timeline-element">
                                                                            <div><span class="vertical-timeline-element-icon bounce-in"></span>
                                                                                <div class="vertical-timeline-element-content bounce-in">
                                                                                    <h4 class="timeline-title">Something not important
                                                                                        <div class="avatar-wrapper mt-2 avatar-wrapper-overlap">
                                                                                            <div class="avatar-icon-wrapper avatar-icon-sm">
                                                                                                <div class="avatar-icon"><img src="/assets/images/avatars/1.jpg" alt=""></div>
                                                                                            </div>
                                                                                            <div class="avatar-icon-wrapper avatar-icon-sm">
                                                                                                <div class="avatar-icon"><img src="/assets/images/avatars/2.jpg" alt=""></div>
                                                                                            </div>
                                                                                            <div class="avatar-icon-wrapper avatar-icon-sm">
                                                                                                <div class="avatar-icon"><img src="/assets/images/avatars/3.jpg" alt=""></div>
                                                                                            </div>
                                                                                            <div class="avatar-icon-wrapper avatar-icon-sm">
                                                                                                <div class="avatar-icon"><img src="/assets/images/avatars/4.jpg" alt=""></div>
                                                                                            </div>
                                                                                            <div class="avatar-icon-wrapper avatar-icon-sm">
                                                                                                <div class="avatar-icon"><img src="/assets/images/avatars/5.jpg" alt=""></div>
                                                                                            </div>
                                                                                            <div class="avatar-icon-wrapper avatar-icon-sm">
                                                                                                <div class="avatar-icon"><img src="/assets/images/avatars/9.jpg" alt=""></div>
                                                                                            </div>
                                                                                            <div class="avatar-icon-wrapper avatar-icon-sm">
                                                                                                <div class="avatar-icon"><img src="/assets/images/avatars/7.jpg" alt=""></div>
                                                                                            </div>
                                                                                            <div class="avatar-icon-wrapper avatar-icon-sm">
                                                                                                <div class="avatar-icon"><img src="/assets/images/avatars/8.jpg" alt=""></div>
                                                                                            </div>
                                                                                            <div class="avatar-icon-wrapper avatar-icon-sm avatar-icon-add">
                                                                                                <div class="avatar-icon"><i>+</i></div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </h4>
                                                                                    <span class="vertical-timeline-element-date"></span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="vertical-timeline-item dot-info vertical-timeline-element">
                                                                            <div><span class="vertical-timeline-element-icon bounce-in"></span>
                                                                                <div class="vertical-timeline-element-content bounce-in">
                                                                                    <h4 class="timeline-title">This dot has an info state</h4><span class="vertical-timeline-element-date"></span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="vertical-timeline-item dot-danger vertical-timeline-element">
                                                                            <div><span class="vertical-timeline-element-icon bounce-in"></span>
                                                                                <div class="vertical-timeline-element-content bounce-in">
                                                                                    <h4 class="timeline-title">All Hands Meeting</h4><span class="vertical-timeline-element-date"></span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="vertical-timeline-item dot-warning vertical-timeline-element">
                                                                            <div><span class="vertical-timeline-element-icon bounce-in"></span>
                                                                                <div class="vertical-timeline-element-content bounce-in">
                                                                                    <p>Yet another one, at <span class="text-success">15:00 PM</span></p><span class="vertical-timeline-element-date"></span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="vertical-timeline-item dot-success vertical-timeline-element">
                                                                            <div><span class="vertical-timeline-element-icon bounce-in"></span>
                                                                                <div class="vertical-timeline-element-content bounce-in">
                                                                                    <h4 class="timeline-title">Build the production release
                                                                                        <span class="badge badge-danger ml-2">NEW</span>
                                                                                    </h4>
                                                                                    <span class="vertical-timeline-element-date"></span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="vertical-timeline-item dot-dark vertical-timeline-element">
                                                                            <div><span class="vertical-timeline-element-icon bounce-in"></span>
                                                                                <div class="vertical-timeline-element-content bounce-in">
                                                                                    <h4 class="timeline-title">This dot has a dark state</h4><span class="vertical-timeline-element-date"></span>
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
                                                                <div class="vertical-without-time vertical-timeline vertical-timeline--animate vertical-timeline--one-column">
                                                                    <div class="vertical-timeline-item vertical-timeline-element">
                                                                        <div><span class="vertical-timeline-element-icon bounce-in"><i class="badge badge-dot badge-dot-xl badge-success"> </i></span>
                                                                            <div class="vertical-timeline-element-content bounce-in">
                                                                                <h4 class="timeline-title">All Hands Meeting</h4>
                                                                                <p>Lorem ipsum dolor sic amet, today at <a href="javascript:void(0);">12:00 PM</a></p><span class="vertical-timeline-element-date"></span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="vertical-timeline-item vertical-timeline-element">
                                                                        <div><span class="vertical-timeline-element-icon bounce-in"><i class="badge badge-dot badge-dot-xl badge-warning"> </i></span>
                                                                            <div class="vertical-timeline-element-content bounce-in">
                                                                                <p>Another meeting today, at <b class="text-danger">12:00 PM</b></p>
                                                                                <p>Yet another one, at <span class="text-success">15:00 PM</span></p><span class="vertical-timeline-element-date"></span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="vertical-timeline-item vertical-timeline-element">
                                                                        <div><span class="vertical-timeline-element-icon bounce-in"><i class="badge badge-dot badge-dot-xl badge-danger"> </i></span>
                                                                            <div class="vertical-timeline-element-content bounce-in">
                                                                                <h4 class="timeline-title">Build the production release</h4>
                                                                                <p>Lorem ipsum dolor sit amit,consectetur eiusmdd tempor incididunt ut labore et dolore magna elit enim at minim veniam quis nostrud</p><span class="vertical-timeline-element-date"></span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="vertical-timeline-item vertical-timeline-element">
                                                                        <div><span class="vertical-timeline-element-icon bounce-in"><i class="badge badge-dot badge-dot-xl badge-primary"> </i></span>
                                                                            <div class="vertical-timeline-element-content bounce-in">
                                                                                <h4 class="timeline-title text-success">Something not important</h4>
                                                                                <p>Lorem ipsum dolor sit amit,consectetur elit enim at minim veniam quis nostrud</p><span class="vertical-timeline-element-date"></span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="vertical-timeline-item vertical-timeline-element">
                                                                        <div><span class="vertical-timeline-element-icon bounce-in"><i class="badge badge-dot badge-dot-xl badge-success"> </i></span>
                                                                            <div class="vertical-timeline-element-content bounce-in">
                                                                                <h4 class="timeline-title">All Hands Meeting</h4>
                                                                                <p>Lorem ipsum dolor sic amet, today at <a href="javascript:void(0);">12:00 PM</a></p><span class="vertical-timeline-element-date"></span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="vertical-timeline-item vertical-timeline-element">
                                                                        <div><span class="vertical-timeline-element-icon bounce-in"><i class="badge badge-dot badge-dot-xl badge-warning"> </i></span>
                                                                            <div class="vertical-timeline-element-content bounce-in">
                                                                                <p>Another meeting today, at <b class="text-danger">12:00 PM</b></p>
                                                                                <p>Yet another one, at <span class="text-success">15:00 PM</span></p><span class="vertical-timeline-element-date"></span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="vertical-timeline-item vertical-timeline-element">
                                                                        <div><span class="vertical-timeline-element-icon bounce-in"><i class="badge badge-dot badge-dot-xl badge-danger"> </i></span>
                                                                            <div class="vertical-timeline-element-content bounce-in">
                                                                                <h4 class="timeline-title">Build the production release</h4>
                                                                                <p>Lorem ipsum dolor sit amit,consectetur eiusmdd tempor incididunt ut labore et dolore magna elit enim at minim veniam quis nostrud</p><span class="vertical-timeline-element-date"></span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="vertical-timeline-item vertical-timeline-element">
                                                                        <div><span class="vertical-timeline-element-icon bounce-in"><i class="badge badge-dot badge-dot-xl badge-primary"> </i></span>
                                                                            <div class="vertical-timeline-element-content bounce-in">
                                                                                <h4 class="timeline-title text-success">Something not important</h4>
                                                                                <p>Lorem ipsum dolor sit amit,consectetur elit enim at minim veniam quis nostrud</p><span class="vertical-timeline-element-date"></span>
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
                                                                <div class="swal2-icon swal2-success swal2-animate-success-icon">
                                                                    <div class="swal2-success-circular-line-left" style="background-color: rgb(255, 255, 255);"></div>
                                                                    <span class="swal2-success-line-tip"></span>
                                                                    <span class="swal2-success-line-long"></span>
                                                                    <div class="swal2-success-ring"></div>
                                                                    <div class="swal2-success-fix" style="background-color: rgb(255, 255, 255);"></div>
                                                                    <div class="swal2-success-circular-line-right" style="background-color: rgb(255, 255, 255);"></div>
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
                                                    <button class="btn-shadow btn-wide btn-pill btn btn-focus btn-sm">View Latest Changes</button>
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
                                                <?php if (empty($user->profile_image)) $img = url('images/avatar.jpg');
                                                else $img = url('images/profile/' . $user->profile_image); ?>
                                                <a data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="p-0 btn">
                                                    <img width="42" class="rounded" src="<?php echo $img; ?>" alt="">
                                                    <i class="fa fa-angle-down ml-2 opacity-8"></i>
                                                </a>
                                                <div tabindex="-1" role="menu" aria-hidden="true" class="rm-pointers dropdown-menu-lg dropdown-menu dropdown-menu-right">
                                                    <div class="dropdown-menu-header">
                                                        <div class="dropdown-menu-header-inner bg-info">
                                                            <div class="menu-header-image opacity-2" style="background-image: url('<?php echo url('/assets/images/dropdown-header/city1.jpg'); ?>');"></div>
                                                            <div class="menu-header-content text-left">
                                                                <div class="widget-content p-0">
                                                                    <div class="widget-content-wrapper">
                                                                        <div class="widget-content-left mr-3">
                                                                            <img width="42" class="rounded-circle" src="<?php echo $img; ?>" alt="">
                                                                        </div>
                                                                        <div class="widget-content-left">
                                                                            <div class="widget-heading"><?php echo $user->name; ?>
                                                                            </div>
                                                                        </div>
                                                                        <div class="widget-content-right mr-2">
                                                                            <a href="<?php echo url('logout'); ?>"><button class="btn-pill btn-shadow btn-shine btn btn-focus"><?php echo trans('header.logout'); ?>
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
                                                                <li class="nav-item">
                                                                    <a href="<?php echo url('my-profile'); ?>" class="nav-link"><?php echo trans('header.my_profile'); ?>
                                                                    </a>
                                                                </li>
                                                                <li class="nav-item">
                                                                    <a href="<?php echo url('my-profile#change_password'); ?>" class="nav-link"><?php echo trans('header.change_password'); ?>
                                                                    </a>
                                                                </li>
                                                                <li class="nav-item">
                                                                    <a href="<?php echo url('logout'); ?>" class="nav-link"><?php echo trans('header.logout'); ?>
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <ul class="nav flex-column d-none">
                                                        <li class="nav-item-divider mb-0 nav-item"></li>
                                                    </ul>
                                                    <div class="grid-menu grid-menu-2col d-none">
                                                        <div class="no-gutters row">
                                                            <div class="col-sm-6">
                                                                <button class="btn-icon-vertical btn-transition btn-transition-alt pt-2 pb-2 btn btn-outline-warning">
                                                                    <i class="pe-7s-chat icon-gradient bg-amy-crisp btn-icon-wrapper mb-2"></i>
                                                                    Message Inbox
                                                                </button>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <button class="btn-icon-vertical btn-transition btn-transition-alt pt-2 pb-2 btn btn-outline-danger">
                                                                    <i class="pe-7s-ticket icon-gradient bg-love-kiss btn-icon-wrapper mb-2"></i>
                                                                    <b>Support Tickets</b>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <ul class="nav flex-column d-none">
                                                        <li class="nav-item-divider nav-item">
                                                        </li>
                                                        <li class="nav-item-btn text-center nav-item">
                                                            <button class="btn-wide btn btn-primary btn-sm">
                                                                Open Messages
                                                            </button>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="app-header-overlay d-none animated fadeIn"></div>
                    </div>