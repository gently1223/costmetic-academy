<?php include(app_path().'/common/panel/header.php'); ?>
<!-- Bootstrap Color Picker -->
  <link rel="stylesheet" href="<?php echo url('assets/plugins/colorpicker/bootstrap-colorpicker.min.css'); ?>">

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
                                                
                                                <div class="btn-actions-pane-right actions-icon-btn">
                                                    <button type="button" class="btn-shadow btn btn-wide btn-success" onclick="$('#form-box').slideToggle()">
                                                    <span class="btn-icon-wrapper pr-1 opacity-7">
                                                        <i class="fa fa-plus"></i>
                                                    </span>
                                                    <?php echo trans('forms.add_new'); ?>
                                                    </button>
                                                </div>
                                                
                                            </div>
                                            <?php if(Session::has('error')) { ?>
                                            <p class="alert alert-danger"><?php echo Session::get('error'); ?></p>
                                            <?php } ?>
                                            <?php if(Session::has('success')) { ?>
                                            <p class="alert alert-success"><?php echo Session::get('success'); ?></p>
                                            <?php } ?>
                                                <div id="form-box" style="display:none;">
                                                    <div class="main-card mb-2 card">
                                    <div class="card-body"><h5 class="card-title"><?php echo trans('forms.add_new_product_category'); ?></h5>
                                        <form class="" action="" method="post">
                                            <?php echo csrf_field(); ?>
                                            <div class="form-row">
                                                <div class="col-md-12">
                                                    <div class="position-relative form-group">
                                                        <label for="exampleEmail11" class=""><?php echo trans('forms.name'); ?> <font style="color:red;">*</font></label>
                                                        <input name="name" id="exampleEmail11" type="text" class="form-control" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="position-relative form-group">
                                                        <label for="exampleEmail11" class=""><?php echo trans('forms.color'); ?> <font style="color:red;">*</font></label>
                                                        <input name="color" id="exampleEmail11" type="text" class="form-control my-colorpicker3" required autocomplete="off">
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <button class="mt-2 btn btn-primary"><?php echo trans('forms.submit'); ?></button>
                                        </form>
                                    </div>
                                </div>
                                                </div>
                                            <div class="card-body">
                                                <table style="width: 100%;" id="example3"
                                                       class="table table-hover table-striped table-bordered">
                                                    <thead>
                                                    <tr>
                                                        <th><?php echo trans('dashboard.name'); ?></th>
                                                        <th><?php echo trans('forms.color'); ?></th>
                                                        <th><?php echo trans('dashboard.actions'); ?></th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php 
                                                        if(!empty($categories)) {
                                                            foreach($categories as $category) {
                                                        ?>
                                                    <tr>
                                                        <td><?php echo $category->name; ?></td>
                                                        <td>
                                                            <?php echo $category->color; ?>
                                                            <div style="background:<?php echo $category->color; ?>; width:20px; height:20px;"></div>
                                                        </td>
                                                        <td>
                                                        <a href="<?php echo url('admin/edit-calendar-category/'.$category->id); ?>"><button class="border-0 btn-transition btn btn-outline-success">
                                                        <i class="fa fa-edit"></i>
                                                        </button></a>
                                                        
                                                        <?php if($category->name!='Coaching' AND $category->name!='Kombigruppe') { ?>
                                                        <form action="" method="post" style="display:inline;">
                                                            <?php echo csrf_field(); ?>
                                                            <input type="hidden" name="delete" value="<?php echo $category->id; ?>">
                                                        <button class="border-0 btn-transition btn btn-outline-danger" onclick="return confirm('Do you really want to delete this category?');">
                                                        <i class="fa fa-trash"></i>
                                                        </button>
                                                        </form>
                                                        <?php } ?>
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
                            </div>
                        </div>
                    </div>
                </div>
<?php include(app_path().'/common/panel/footer.php'); ?>
<!-- bootstrap color picker -->
<script src="<?php echo url('assets/plugins/colorpicker/bootstrap-colorpicker.min.js'); ?>"></script>
<script>
    $(".my-colorpicker3").colorpicker().on('changeColor',
            function(ev) {
            });;
</script>