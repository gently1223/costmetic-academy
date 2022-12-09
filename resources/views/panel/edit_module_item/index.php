<?php include(app_path().'/common/panel/header.php'); ?>

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
                                                <div id="form-box">
                                                    <div class="main-card mb-2">
                                    <div class="card-body"><h5 class="card-title"><?php echo trans('forms.edit_module_item'); ?></h5>
                                        <form class="" action="" method="post">
                                            <?php echo csrf_field(); ?>
                                            <div class="form-row">
                                                <div class="col-md-12">
                                                    <div class="position-relative form-group">
                                                        <label for="exampleEmail11" class=""><?php echo trans('forms.title'); ?> <font style="color:red;">*</font></label>
                                                        <input name="title" id="exampleEmail11" type="text" class="form-control" required value="<?php echo $modules[0]['module']->title; ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="position-relative form-group">
                                                        <label for="examplePassword11" class=""><?php echo trans('forms.description'); ?> <font style="color:red;">*</font></label>
                                                        <textarea class="form-control" name="description"  id="editor" rows="6"><?php echo $modules[0]['module']->description; ?></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="col-md-6">
                                                    <div class="position-relative form-group">
                                                        <label for="exampleEmail11" class=""><?php echo trans('forms.lessons'); ?> <font style="color:red;">*</font></label>
                                                        <input name="lessons" id="exampleEmail11" type="number" class="form-control" required value="<?php echo $modules[0]['module']->lessons; ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="position-relative form-group">
                                                        <label for="examplePassword11" class=""><?php echo trans('forms.price_lesson'); ?> <font style="color:red;">*</font></label>
                                                        <input type="number" class="form-control" name="price_lesson" required value="<?php echo $modules[0]['module']->price_lessons; ?>" min="0" step="any">
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            
                                            
                                            <div class="form-row">
                                                <div class="col-md-6">
                                                    <div class="position-relative form-group">
                                                        <label for="examplePassword11" class=""><?php echo trans('forms.module_item_services'); ?></label>
                                                        <select class="form-control" name="mod" id="mod">
                                                            <option value=""><?php echo trans('forms.please_select'); ?></option>
                                                            <?php 
                                                            if(!empty($module_item_services)) {
                                                                foreach($module_item_services as $module) {
                                                            ?>
                                                            <option value="<?php echo $module->id; ?>" data-title="<?php echo $module->title; ?>" data-daily_documentation_text="<?php echo $module->daily_documentation_text; ?>" data-endreport_documentation_text="<?php echo $module->endreport_documentation_text; ?>"><?php echo $module->title; ?></option>
                                                            <?php } } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-3">
                                                    <div class="position-relative form-group">
                                                        <label for="examplePassword11" class="">&nbsp </label>
                                                        <button type="button" class="btn-shadow btn btn-wide btn-success" style="display:block;" onclick="add_module_item_service()">
                                                    <?php echo trans('forms.add_new_module_item_service'); ?>
                                                    </button>
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-12">
                                                    <p class="alert alert-danger" id="f_error" style="display:none;"></p>
                                                    <div class="table-responsive">
                                                            <table class="mb-0 table">
                                                                <thead>
                                                                <tr>
                                                                    <th><?php echo trans('forms.title'); ?></th>
                                                                    <th><?php echo trans('forms.daily_documentation_text'); ?></th>
                                                                    <th><?php echo trans('forms.endreport_documentation_text'); ?></th>
                                                                    <th></th>
                                                                </tr>
                                                                </thead>
                                                                <tbody id="modules-data">
                                                                    <?php 
                                                                    if(!empty($modules[0]['module_item_services'])) {
                                                                        foreach($modules[0]['module_item_services'] as $m) {
                                                                    ?>
                                                                    <tr>
                                                                    <th scope="row"><input type="hidden" name="module_items[]" value="<?php echo $m['item']->id; ?>"><a href="<?php echo url('admin/edit-module-item-service/'.$m['item']->id); ?>" target="_blank" style="color:#0056b3;"><?php echo $m['item']->title; ?></a></th>
                                                                    <td><?php echo $m['item']->daily_documentation_text; ?></td>
                                                                    <td><?php echo $m['item']->endreport_documentation_text; ?></td>
                                                                    <td><a href="javascript:void(0)" style="color:red;" onclick="$(this).parent().parent().remove();"><i class="fa fa-minus-circle"></i></a></td>
                                                                </tr>
                                                                    <?php } } ?>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                </div>
                                            </div>
                                            
                                            
                                            
                                            
                                            
                                            <button class="mt-2 btn btn-primary"><?php echo trans('forms.update'); ?></button>
                                        </form>
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
<?php include(app_path().'/common/panel/footer.php'); ?>
<script>
        
    function add_module_item_service()
    {
        $("#f_error").hide();
        var max=$("#max_lessons").val();
        var id=$("#mod").val();
        
        var title=$('option:selected', $("#mod")).attr('data-title');
        var daily_documentation_text=$('option:selected', $("#mod")).attr('data-daily_documentation_text');
        var endreport_documentation_text=$('option:selected', $("#mod")).attr('data-endreport_documentation_text');
        
        if(id!='')
        {
          

        $("#modules-data").append('<tr>\
            <th scope="row"><input type="hidden" name="module_items[]" value="'+id+'">'+title+'</th>\
            <td>'+daily_documentation_text+'</td>\
            <td>'+endreport_documentation_text+'</td>\
            <td><a href="javascript:void(0)" style="color:red;" onclick="$(this).parent().parent().remove();"><i class="fa fa-minus-circle"></i></a></td>\
        </tr>');
           
           
        }
        
        var id=$("#mod").val('');
    }
</script>