<?php include(app_path().'/common/header.php'); ?>
<style>
                                                div.days
                                                {
                                                    display: inline-block;
                                                    width:100px;
                                                    border:1px solid #3ac47d;
                                                    border-radius: 4px;
                                                    text-align: center;
                                                    cursor: pointer;
                                                    user-select: none;
                                                }
                                                
                                                div.selected
                                                {
                                                    background-color: #3ac47d;
                                                    color: white;
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
                                                    <div class="main-card mb-2">
                                    <div class="card-body">
                                        <form class="" action="" method="post" enctype="multipart/form-data">
                                            <?php echo csrf_field(); ?>
                                            <h5 class="card-title"><?php echo trans('dashboard.basic_information'); ?>:</h5>
                                            <div class="form-row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                  <label><?php echo trans('forms.update_profile_image'); ?></label>
                      <input type="file" class="form-control file" name="image" style="display:none;" accept="image/*">
                              <div class="browse" style="border:1px solid #d2d6de; padding:5px; cursor:pointer;"><i class="fa fa-image"></i> <?php echo trans('forms.choose_file'); ?></div>
                              <img src="" id="current_img" style="max-width:300px; display:block;">
                </div>
                                                </div>
                                                
                                                <div class="col-md-6">
                                                    <div class="position-relative form-group">
                                                        <label for="exampleEmail11" class=""><?php echo trans('forms.name'); ?> <font style="color:red;">*</font></label>
                                                        <input name="name" id="exampleEmail11" type="text" class="form-control" required value="<?php echo $user->name; ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="position-relative form-group">
                                                        <label for="examplePassword11" class=""><?php echo trans('forms.email'); ?> <font style="color:red;">*</font></label>
                                                        <input name="email" id="examplePassword11" type="email" class="form-control" required value="<?php echo $user->email; ?>">
                                                        <?php if($user->new_email!='') echo '<p style="line-height:1.2em;">*We have sent you confirmation email to <b>'.$user->new_email.'</b>.</p>'; ?>
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-12">
                                                    <div class="position-relative form-group">
                                                    <input type="checkbox" name="newsletter" value="1" <?php if($user->newsletter=='1') echo 'checked'; ?> > <?php echo trans('forms.subscribe_newsletter'); ?>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <button class="mt-2 btn btn-primary"><?php echo trans('forms.update'); ?></button>
                                        </form>
                                        
                                        <br><hr><br>
                                        
                                        <h5 class="card-title"><?php echo trans('forms.availability'); ?>:</h5>
                                        
                                        <form class="" action="" method="post">
                                            <?php echo csrf_field(); ?>
                                            
                                            <div class="form-row">
                                                <div class="col-md-12">
                                                    <div class="position-relative form-group">
                                                        <label for="exampleEmail11" class=""><?php echo trans('forms.availability'); ?> <font style="color:red;">*</font></label>
                                                        
                                                        <div>
                                                        <div class="days">Monday</div>
                                                        <div class="days">Tuesday</div>
                                                        <div class="days">Wednesday</div>
                                                        <div class="days">Thursday</div>
                                                        <div class="days">Friday</div>
                                                        <div class="days">Saturday</div>
                                                        <div class="days">Sunday</div>
                                                        </div>
                                                        
                                                        <div class="mt-3">
                                                            <select id="from_time">
                                                                <option value=""><?php echo trans('forms.from_time'); ?></option>
                                                                <?php for($i=0; $i<=23; $i++) {
                                                                    if($i<10) $num='0'.$i;
                                                                    else $num=$i;
                                                                ?>
                                                                <option value="<?php echo $num.':00'; ?>"><?php echo $num.':00'; ?></option>
                                                                <option value="<?php echo $num.':30'; ?>"><?php echo $num.':30'; ?></option>
                                                                <?php } ?>
                                                            </select>
                                                            
                                                            <select class="mr-2" id="to_time">
                                                                <option value=""><?php echo trans('forms.to_time'); ?></option>
                                                                <?php for($i=0; $i<=23; $i++) {
                                                                    if($i<10) $num='0'.$i;
                                                                    else $num=$i;
                                                                ?>
                                                                <option value="<?php echo $num.':00'; ?>"><?php echo $num.':00'; ?></option>
                                                                <option value="<?php echo $num.':30'; ?>"><?php echo $num.':30'; ?></option>
                                                                <?php } ?>
                                                            </select>
                                                            
                                                            <button type="button" class="btn btn-success" style="padding-top:1.5px; padding-bottom:1.5px;" onclick="add_day()">
                                                            <?php echo trans('forms.add'); ?>
                                                            </button>
                                                            
                                                            <p class="alert alert-danger" id="avail_error" style="display:none;"></p>
                                                        </div>
                                                        
                                                        <div class="mt-3">
                                                            <div class="table-responsive">
                                                            <table class="mb-0 table">
                                                                <thead>
                                                                <tr>
                                                                    <th><?php echo trans('forms.day'); ?></th>
                                                                    <th><?php echo trans('forms.hours'); ?></th>
                                                                    <th></th>
                                                                </tr>
                                                                </thead>
                                                                <tbody id="availability">
                                                                    <?php 
                                                                    if(!empty($availability)) {
                                                                        foreach($availability as $avail) {
                                                                    ?>
                                                                    <tr id="<?php echo $avail->day; ?>">
                                                                    <th scope="row"><input type="hidden" name="days[]" value="<?php echo $avail->day; ?>"><?php echo $avail->day; ?></th>
                                                                    <td><input type="hidden" name="from_time[]" value="<?php echo $avail->from_time; ?>"> <input type="hidden" name="to_time[]" value="<?php echo $avail->to_time; ?>"><?php echo date('H:i', strtotime($avail->from_time)).' - '.date('H:i', strtotime($avail->to_time)); ?></td>
                                                                    <td><a href="javascript:void(0)" style="color:red;" onclick="$(this).parent().parent().remove();"><i class="fa fa-minus-circle"></i></a></td>
                                                                </tr>
                                                                    <?php } } ?>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <button class="mt-2 btn btn-primary"><?php echo trans('forms.update'); ?></button>
                                        </form>
                                        
                                        <br><hr><br>
                                        
                                        <form class="" action="" method="post" id="change_password">
                                            <?php echo csrf_field(); ?>
                                            <h5 class="card-title"><?php echo trans('dashboard.change_password'); ?>:</h5>
                                            <div class="form-row">
                                                <div class="col-md-6">
                                                    <div class="position-relative form-group">
                                                        <label for="exampleEmail11" class=""><?php echo trans('forms.new_password'); ?> <font style="color:red;">*</font></label>
                                                        <input name="pass1" id="exampleEmail11" type="password" class="form-control" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="position-relative form-group">
                                                        <label for="examplePassword11" class=""><?php echo trans('forms.repeat_password'); ?> <font style="color:red;">*</font></label>
                                                        <input name="pass2" id="examplePassword11" type="password" class="form-control" required></div>
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
<?php include(app_path().'/common/footer.php'); ?>
<script>
    $(document).on('click', '.browse', function(){
                    var file = $(this).prev();
                    file.trigger('click');
                  });

		  $(document).on('change', '.file', function(e){
                      var o=new FileReader;
                      o.readAsDataURL(e.target.files[0]),o.onloadend=function(o){
                          $("#current_img").attr("src",o.target.result); 
                      }
                    //$(this).prev().text($(this).val().replace(/C:\\fakepath\\/i, ''));
    });
</script>

<script>
    $('.days').on('click', function(){
        $(this).toggleClass('selected');
    });
    
    function add_day()
    {
        $("#avail_error").hide();
        var from_time=$("#from_time").val();
        var to_time=$("#to_time").val();
        
        var days=[];
        $(".days.selected").each(function(){
            days.push($(this).text());
        });
        
        if(from_time=='')
        {
            $("#avail_error").text('Please select From Time.');
            $("#avail_error").show();    
        }
        else if(to_time=='')
        {
            $("#avail_error").text('Please select To Time.');
            $("#avail_error").show();    
        }
        else if(to_time<=from_time)
        {
            $("#avail_error").text('To Time must be greated than From Time.');
            $("#avail_error").show();    
        }
        else if(days.length===0)
        {
            $("#avail_error").text('Please select a day first.');
            $("#avail_error").show();
        }
        else
        {
            days.forEach(function(d){
                $("#"+d).remove();
                $("#availability").append('<tr id="'+d+'">\
                                                                    <th scope="row"><input type="hidden" name="days[]" value="'+d+'">'+d+'</th>\
                                                                    <td><input type="hidden" name="from_time[]" value="'+from_time+'"> <input type="hidden" name="to_time[]" value="'+to_time+'">'+from_time+' - '+to_time+'</td>\
                                                                    <td><a href="javascript:void(0)" style="color:red;" onclick="$(this).parent().parent().remove();"><i class="fa fa-minus-circle"></i></a></td>\
                                                                </tr>');
                $('.days').removeClass('selected');
            });
        }
    }
</script>