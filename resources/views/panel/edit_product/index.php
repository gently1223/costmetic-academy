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
                                    <div class="card-body">
                                        <h5 class="card-title"><?php echo trans('forms.edit_product'); ?></h5>
                                        <form class="" action="" method="post">
                                            <?php echo csrf_field(); ?>
                                            <div class="form-row">
                                                <div class="col-md-6">
                                                    <div class="position-relative form-group">
                                                        <label for="exampleEmail11" class=""><?php echo trans('forms.title'); ?> <font style="color:red;">*</font></label>
                                                        <input name="title" id="exampleEmail11" type="text" class="form-control" required value="<?php echo $products[0]['product']->title; ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="position-relative form-group">
                                                        <label for="examplePassword11" class="">Authorised Number <font style="color:red;">*</font></label>
                                                        <input type="text" class="form-control" name="auth_no" required value="<?php echo $products[0]['product']->auth_no; ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="position-relative form-group">
                                                        <label for="examplePassword11" class=""><?php echo trans('forms.category'); ?> <font style="color:red;">*</font></label>
                                                        <select class="form-control" name="category" required>
                                                            <option value=""><?php echo trans('forms.please_select'); ?></option>
                                                            <?php 
                                                            if(!empty($categories)) {
                                                                foreach($categories as $category) {
                                                            ?>
                                                            <option value="<?php echo $category->name; ?>" <?php if($products[0]['product']->category==$category->name) echo 'selected'; ?> ><?php echo $category->name; ?></option>
                                                            <?php } } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            
                                            <div class="form-row">
                                                <div class="col-md-6">
                                                    <div class="position-relative form-group">
                                                        <label for="examplePassword11" class=""><?php echo trans('forms.period_of_funding'); ?> <font style="color:red;">*</font></label>
                                                        <input type="text" class="form-control" name="daterange" required value="<?php echo date_format(new DateTime($products[0]['product']->period_start),'d/m/Y').' - '.date_format(new DateTime($products[0]['product']->period_end),'d/m/Y'); ?>">
                                                    </div>
                                                </div>
                                                <!--<div class="col-md-3">
                                                    <div class="position-relative form-group">
                                                        <label for="exampleEmail11" class="">Price/Hour <font style="color:red;">*</font></label>
                                                        <input name="price" id="exampleEmail11" type="number" class="form-control" required>
                                                    </div>
                                                </div>-->
                                                <div class="col-md-6">
                                                    <div class="position-relative form-group">
                                                        <label for="examplePassword11" class=""><?php echo trans('forms.max_no_lessons'); ?> <font style="color:red;">*</font></label>
                                                        <input name="max_hours" id="max_lessons" type="number"class="form-control" required value="<?php echo $products[0]['product']->max_hours; ?>"></div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="position-relative form-group">
                                                        <label for="examplePassword11" class=""><?php echo trans('forms.description'); ?> <font style="color:red;">*</font></label>
                                                        <textarea class="form-control" name="description" id="editor"><?php echo $products[0]['product']->description; ?></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="form-row">
                                                <div class="col-md-6">
                                                    <div class="position-relative form-group">
                                                        <label for="examplePassword11" class=""><?php echo trans('forms.modules'); ?></label>
                                                        <select class="form-control" name="mod" id="mod">
                                                            <option value=""><?php echo trans('forms.please_select'); ?></option>
                                                            <?php 
                                                            if(!empty($modules)) {
                                                                foreach($modules as $module) {
                                                            ?>
                                                            <option value="<?php echo $module['module']->id; ?>" data-title="<?php echo $module['module']->title; ?>" data-lessons="<?php echo $module['lessons']; ?>" data-total-cost="<?php echo $module['total_cost']; ?>"><?php echo $module['module']->title.' (UE: '.$module['lessons'].')'; ?></option>
                                                            <?php } } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-3">
                                                    <div class="position-relative form-group">
                                                        <label for="examplePassword11" class="">&nbsp </label>
                                                        <button type="button" class="btn-shadow btn btn-wide btn-success" style="display:block;" onclick="add_module()">
                                                    <?php echo trans('forms.add_module'); ?>
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
                                                                    <th><?php echo trans('forms.max_no_lessons'); ?></th>
                                                                    <th><?php echo trans('forms.lessons'); ?></th>
                                                                    <th><?php echo trans('forms.total_cost'); ?></th>
                                                                    <th></th>
                                                                </tr>
                                                                </thead>
                                                                <tbody id="modules-data">
                                                                    <?php 
                                                                    if(!empty($products[0]['modules'])) {
                                                                        foreach($products[0]['modules'] as $m) {
                                                                    ?>
                                                                    <tr>
                                                                    <th scope="row"><input type="hidden" name="modules[]" value="<?php echo $m['module']->id; ?>"><a href="<?php echo url('admin/edit-module/'.$m['module']->id); ?>" target="_blank" style="color:#0056b3;"><?php echo $m['module']->title; ?></a></th>
                                                                    <td><?php echo $m['module']->max_lessons; ?></td>
                                                                    <td><?php echo $m['lessons']; ?></td>
                                                                    <td>€<?php echo $m['total_cost']; ?></td>
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
    window.lessons=<?php echo $products[0]['lessons']; ?>;
    
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
                                                                    <td>€'+total_cost+'</td>\
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
<script src="https://cdn.ckeditor.com/ckeditor5/11.2.0/classic/ckeditor.js"></script>
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
</script>