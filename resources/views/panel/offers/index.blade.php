<?php include(app_path() . '/common/header.php'); ?>
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
                </div>
            </div>
        </div>
        <div class="app-inner-layout__content pt-0">
            <div class="tab-content">
                <div class="container-fluid">
                    <div class="card mb-3">
                        <div class="card-header-tab card-header">
                            <div class="card-header-title font-size-lg text-capitalize font-weight-normal">
                            </div>
                        </div>
                        <?php if (Session::has('error')) { ?>
                            <p class="alert alert-danger"><?php echo Session::get('error'); ?></p>
                        <?php } ?>
                        <?php if (Session::has('success')) { ?>
                            <p class="alert alert-success"><?php echo Session::get('success'); ?></p>
                        <?php } ?>

                        <div class="card-body">
                            <table style="width: 100%;" id="example3" class="table table-hover table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th><?php echo trans('dashboard.course_name'); ?></th>
                                        <th><?php echo trans('dashboard.offer_name'); ?></th>
                                        <th><?php echo trans('dashboard.begin_date'); ?></th>
                                        <th><?php echo trans('dashboard.end_date'); ?></th>
                                        <th><?php echo trans('dashboard.valid_date'); ?></th>
                                        <th><?php echo trans('forms.max_hours'); ?></th>
                                        <th><?php echo trans('dashboard.actions'); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (!empty($offers)) {
                                        foreach ($offers as $offer) {
                                    ?>
                                            <tr>
                                                <td><?php echo $offer->title; ?></td>
                                                <td><?php echo $offer->name; ?></td>
                                                <td><?php echo date('d-m-Y', strtotime($offer->begin_date)); ?></td>
                                                <td><?php echo date('d-m-Y', strtotime($offer->end_date)); ?></td>
                                                <td><?php echo date('d-m-Y', strtotime($offer->valid_until)); ?></td>
                                                <td><?php echo $offer->max_hours; ?></td>
                                                <td>
                                                    <a href="{{route('contacts.create-appointment', $offer->id)}}" class="btn btn-success btn-sm">{{trans('forms.generate_appointments')}}</a>
                                                </td>
                                            </tr>
                                    <?php }
                                    } ?>
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
<?php include(app_path() . '/common/footer.php'); ?>
<script src="https://cdn.ckeditor.com/ckeditor5/11.2.0/classic/ckeditor.js"></script>
<script src="https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@2.1.7/dist/loadingoverlay.min.js"></script>