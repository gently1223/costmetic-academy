<?php include(app_path().'/common/panel/header.php'); ?>
<link href="https://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">
<link href="<?php echo url('hummingbird/hummingbird-treeview.css'); ?>" rel="stylesheet" type="text/css">
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
                                            <?php if(Session::has('error')) { ?>
                                            <p class="alert alert-danger"><?php echo Session::get('error'); ?></p>
                                            <?php } ?>
                                            <?php if(Session::has('success')) { ?>
                                            <p class="alert alert-success"><?php echo Session::get('success'); ?></p>
                                            <?php } ?>
                                                <div id="form-box">
                                                    <div class="main-card mb-2 card">
                                    <div class="card-body"><h5 class="card-title">Edit Abschlussbericht</h5>
                                        <form class="" action="" method="post" onsubmit="return check_data();" novalidate>
                                            <?php echo csrf_field(); ?>
                                            <div class="form-row">
                                                <div class="col-md-6">
                                                    <div class="position-relative form-group">
                                                        <label for="exampleEmail11" class=""><?php echo trans('forms.date'); ?> <font style="color:red;">*</font></label>
                                                        <input name="date_name" type="text" class="form-control required" readonly id="date_field" value="<?php echo date('d-m-Y') ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="position-relative form-group">
                                                        <label for="exampleEmail12" class=""><?php echo trans('forms.participant-customer'); ?> <font style="color:red;">*</font></label>
                                                        <input name="participant_customer_name" type="text" class="form-control required" id="participant_customer_field" value="">
                                                    </div>
                                                </div>
                                                <div class="col-md-6" id="begin_date">
                                                    <div class="position-relative form-group">
                                                        <label for="begin_date_field" class=""><?php echo trans('forms.begin_date'); ?></label>
                                                        <input name="beginning" id="begin_date_field" type="text" class="form-control today_calendar" value="<?php if(isset($course->beginning)) echo $course->beginning; ?>"></div>
                                                </div>
                                                <div class="col-md-6" id="end_date">
                                                    <div class="position-relative form-group">
                                                        <label for="end_date_field" class=""><?php echo trans('forms.end_date'); ?></label>
                                                        <input name="end" id="end_date_field" type="text" class="form-control today_calendar" value="<?php if(isset($course->end)) echo $course->end; ?>"></div>
                                                </div>
                                                <div class="col-md-6" id="company_name" style="display:none;">
                                                    <div class="position-relative form-group">
                                                        <label for="examplePassword11" class=""><?php echo trans('forms.company_name'); ?> <font style="color:red;">*</font></label>
                                                        <input name="company_name" type="text" class="form-control required" id="company_name_field"></div>
                                                </div>
                                            </div>
                                            
                                            
                                            <input type="checkbox" name="courses[]" value="1" style="display:none;" checked>
                                            
                                            <p class="alert alert-danger" id="error" style="display:none;"><?php echo Session::get('error'); ?></p>
                                            <button class="mt-2 btn btn-primary" id="submit_btn_c"><?php echo trans('forms.submit'); ?></button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>
                    </div>
                </div>

<?php include(app_path().'/common/panel/footer.php'); ?>

<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script src="<?php echo url('hummingbird/hummingbird-treeview.js'); ?>"></script>
<script>
$(document).ready(
    $('.calendar').daterangepicker({
        singleDatePicker: true,
        startDate: '<?php if(isset($course->begin))  echo date_format(new DateTime($course->begine),'d-m-Y'); ?>',
        locale: {
            format: 'DD-MM-YYYY'
        }
    })
);
</script>