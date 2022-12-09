<?php include(app_path() . '/common/panel/header.php'); ?>
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
                        
                        <div id="form-box">
                            <div class="main-card card">
                                <div class="card-body">
                                    <h5 class="card-title"><b><?php echo trans('forms.offer_detail'); ?></b></h5>
                                    <form>
                                        <div class="form-row">
                                            <div class="col-md-12">
                                                <table class="table table-bordered">
                                                     <tr>
                                                        <th>{{trans('forms.offer_name')}}</th>
                                                        <td>{{$offer_detail->name}}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>{{trans('forms.coaching_name')}}</th>
                                                        <td>{{$offer_detail->title }}</td>
                                                    </tr>
                                                   
                                                    <tr>
                                                        <th>{{trans('forms.begin_date')}}</th>
                                                        <td>{{$offer_detail->begin_date}}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>{{trans('forms.end_date')}}</th>
                                                        <td>{{$offer_detail->end_date}}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>{{trans('forms.valid_till')}}</th>
                                                        <td>{{$offer_detail->valid_until}}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>{{trans('forms.coach')}}</th>
                                                        <td>{{$offer_detail->con_name}}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>{{trans('forms.max_hours')}}</th>
                                                        <td>{{$offer_detail->max_hours}}</td>
                                                    </tr>
                                                </table>
                                            </div>
                                            <div class="col-md-12">
                                                <label for="exampleEmail11" class="">{{trans('forms.select_products_modules')}}</label>
                                                <div id="treeview_container" class="hummingbird-treeview well h-scroll-large">
                                                    <ul id="treeview-products-1" class="hummingbird-base">
                                                        <?php
                                                        if (!empty($products)) {
                                                            foreach ($products as $p) {
                                                                $p_id = $p['product']->id;
                                                        ?>
                                                                <li>
                                                                    <i class="fa fa-plus"></i> <label><?php echo $p['product']->title . ' (' . trans('forms.lessons') . ': ' . $p['total_lessons'] . ' ' . trans('forms.total_cost') . ': €' . $p['total_cost'] . ')'; ?></label>

                                                                    <ul>
                                                                        <?php
                                                                        if (!empty($p['modules'])) {
                                                                            foreach ($p['modules'] as $m) {
                                                                        ?>
                                                                                <li>
                                                                                    <i class="fa fa-plus"></i> <label><?php echo $m['module']->title . ' (' . trans('forms.lessons') . ': ' . $m['total_lessons'] . ' ' . trans('forms.total_cost') . ': €' . $m['total_cost'] . ')'; ?></label>

                                                                                    <ul>
                                                                                        <?php
                                                                                        if (!empty($m['module_items'])) {
                                                                                            foreach ($m['module_items'] as $item) {
                                                                                        ?>
                                                                                                <li>
                                                                                                    <label><?php echo $item['item']->title . ' (' . trans('forms.lessons') . ': ' . $item['item']->lessons . ' ' . trans('forms.total_cost') . ': €' . $item['item']->lessons * $item['item']->price_lessons . ')'; ?></label>
                                                                                                </li>
                                                                                        <?php }
                                                                                        } ?>
                                                                                    </ul>
                                                                                </li>
                                                                        <?php }
                                                                        } ?>

                                                                    </ul>
                                                                </li>
                                                        <?php }
                                                        } ?>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<?php include(app_path() . '/common/panel/footer.php'); ?>
<script>
    $("#treeview-products-1").hummingbird();
</script>