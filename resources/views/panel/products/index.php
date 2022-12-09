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
                                                    
                                                    <button type="button" class="btn-shadow btn btn-wide btn-success" onclick="$('#import-box').slideToggle()">
                                                    <span class="btn-icon-wrapper pr-1 opacity-7">
                                                        <i class="fa fa-upload"></i>
                                                    </span>
                                                    Import CSV
                                                    </button>
                                                </div>
                                                
                                            </div>
                                            <?php if(Session::has('error')) { ?>
                                            <p class="alert alert-danger"><?php echo Session::get('error'); ?></p>
                                            <?php } ?>
                                            <?php if(Session::has('success')) { ?>
                                            <p class="alert alert-success"><?php echo Session::get('success'); ?></p>
                                            <?php } ?>
                                            <div id="import-box" style="display:none;">
                                                    <div class="main-card mb-2 card">
                                    <div class="card-body"><h5 class="card-title">Import CSV</h5>
                                        <form class="" action="<?php echo url('admin/import-products') ?>" method="post" enctype="multipart/form-data">
                                            <?php echo csrf_field(); ?>
                                            <div class="form-row">
                                                <div class="col-md-6">
                                                    <div class="position-relative form-group">
                                                        <label for="exampleEmail11" class="">Upload File <font style="color:red;">*</font></label>
                                                        <input name="file" type="file" class="form-control" required>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <button class="mt-2 btn btn-primary"><?php echo trans('forms.submit'); ?></button>
                                        </form>
                                    </div>
                                </div>
                                                </div>
                                            
                                                <div id="form-box" style="display:none;">
                                                    <div class="main-card mb-2 card">
                                    <div class="card-body"><h5 class="card-title"><?php echo trans('forms.add_new_product'); ?></h5>
                                        <form class="" action="" method="post">
                                            <?php echo csrf_field(); ?>
                                            <div class="form-row">
                                                <div class="col-md-6">
                                                    <div class="position-relative form-group">
                                                        <label for="exampleEmail11" class=""><?php echo trans('forms.title'); ?> <font style="color:red;">*</font></label>
                                                        <input name="title" id="exampleEmail11" type="text" class="form-control" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="position-relative form-group">
                                                        <label for="examplePassword11" class="">Measure Number <font style="color:red;">*</font></label>
                                                        <input type="text" class="form-control" name="auth_no" value="" required>
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
                                                            <option value="<?php echo $category->name; ?>"><?php echo $category->name; ?></option>
                                                            <?php } } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            
                                            <div class="form-row">
                                                <div class="col-md-6">
                                                    <div class="position-relative form-group">
                                                        <label for="examplePassword11" class=""><?php echo trans('forms.period_of_funding'); ?> <font style="color:red;">*</font></label>
                                                        <input type="text" class="form-control" name="daterange" value="" required>
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
                                                        <input name="max_hours" id="max_lessons" type="number"class="form-control" required></div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="position-relative form-group">
                                                        <label for="examplePassword11" class=""><?php echo trans('forms.description'); ?> <font style="color:red;">*</font></label>
                                                        <textarea class="form-control" name="description" id="editor"></textarea>
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
                                                            <option value="<?php echo $module['module']->id; ?>" data-title="<?php echo $module['module']->title; ?>" data-lessons="<?php echo $module['lessons']; ?>" data-total-cost="<?php echo $module['total_cost']; ?>"><?php echo $module['module']->title; ?></option>
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
                                                                    <th><?php echo trans('forms.lessons'); ?></th>
                                                                    <th><?php echo trans('forms.total_cost'); ?></th>
                                                                    <th></th>
                                                                </tr>
                                                                </thead>
                                                                <tbody id="modules-data">
                                                                    
                                                                </tbody>
                                                            </table>
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
                                                        <th>Authorised No.</th>
                                                        <th><?php echo trans('dashboard.title'); ?></th>
                                                        <th><?php echo trans('dashboard.category'); ?></th>
                                                        <th><?php echo trans('dashboard.period_of_funding'); ?></th>
                                                        <th><?php echo trans('dashboard.max_hours'); ?></th>
                                                        <th>Assigned Hours</th>
                                                        <th><?php echo trans('dashboard.total_cost'); ?></th>
                                                        <th><?php echo trans('dashboard.actions'); ?></th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php 
                                                        if(!empty($products)) {
                                                            foreach($products as $product) {
                                                        ?>
                                                    <tr>
                                                        <td><?php echo $product['product']->auth_no; ?></td>
                                                        <td><?php echo $product['product']->title; ?></td>
                                                        <td><?php echo $product['product']->category; ?></td>
                                                        <td><?php echo date_format(new DateTime($product['product']->period_start),'d/m/Y').' - '.date_format(new DateTime($product['product']->period_end),'d/m/Y'); ?></td>
                                                        <td><?php echo $product['product']->max_hours; ?></td>
                                                        <td><?php echo $product['total_hours']; ?></td>
                                                        <td>€<?php echo $product['total_cost']; ?></td>
                                                        <!--<td>$<?php echo $product['product']->price*$product['product']->max_hours; ?></td>-->
                                                        <!--<td><?php echo date_format(new DateTime($product['product']->added_on),'m-d-Y'); ?>
                                                            <p><?php echo date_format(new DateTime($product['product']->added_on),'H:i'); ?></p>
                                                        </td>-->
                                                        <td>
                                                        <button class="border-0 btn-transition btn btn-success" data-toggle="modal" data-target="#modules" onclick="fetch_modules('<?php echo $product['product']->id; ?>')">
                                                            <?php echo trans('forms.modules'); ?>
                                                        </button><br>
                                                            
                                                        <a href="<?php echo url('admin/edit-product/'.$product['product']->id); ?>"><button class="border-0 btn-transition btn btn-outline-success">
                                                        <i class="fa fa-edit"></i>
                                                        </button></a>
                                                        
                                                        <form action="" method="post" style="display:inline;">
                                                            <?php echo csrf_field(); ?>
                                                            <input type="hidden" name="delete" value="<?php echo $product['product']->id; ?>">
                                                        <button class="border-0 btn-transition btn btn-outline-danger" onclick="return confirm('Do you really want to delete this product?');">
                                                        <i class="fa fa-trash"></i>
                                                        </button>
                                                        </form>
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

<div class="modal fade" id="modules" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
          <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
              <div class="modal-header">
                  <h4 class="modal-title" id="modal-title2"><?php echo trans('forms.modules'); ?></h4>
              </div>
              <div class="modal-body">
                  <p class="alert alert-success" id="ass-success" style="display:none;"></p>
                    
                  <div id='products' style="overflow-x:auto;">
                      
                  </div>
                  
                <p class="alert alert-danger" id="error2" style="display:none;"></p>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default pull-right" data-dismiss="modal"><?php echo trans('forms.close'); ?></button>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
<script src="<?php echo url('hummingbird/hummingbird-treeview.js'); ?>"></script>
<script>
    $("#treeview-contact-products").hummingbird();
    
    window.lessons=0;
    
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
    
    function fetch_modules(id)
    {
        var formData=new FormData();
        var token='<?php echo csrf_token(); ?>';
        formData.append('_token', token);
        formData.append('id', id);
        
        $.ajax({
                url: "<?php echo url('admin/fetch-modules') ?>",
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
                    }
                },
                error: function()  {
                    //error
                } 	        
        });
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