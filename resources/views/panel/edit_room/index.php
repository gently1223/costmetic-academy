<?php include(app_path().'/common/panel/header.php'); ?>
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
                                    <div class="card-body"><h5 class="card-title"><?php echo trans('forms.edit_room'); ?></h5>
                                        <form class="" action="" method="post">
                                            <?php echo csrf_field(); ?>
                                            <div class="form-row">
                                                <div class="col-md-6">
                                                    <div class="position-relative form-group">
                                                        <label for="exampleEmail11" class=""><?php echo trans('forms.name'); ?> <font style="color:red;">*</font></label>
                                                        <input name="name" id="exampleEmail11" type="text" class="form-control" required value="<?php echo $rooms[0]['room']->name; ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="position-relative form-group">
                                                        <label for="examplePassword11" class=""><?php echo trans('forms.capacity'); ?> <font style="color:red;">*</font></label>
                                                        <input name="capacity" id="examplePassword11" type="number"class="form-control" required value="<?php echo $rooms[0]['room']->capacity; ?>"></div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="position-relative form-group">
                                                        <label for="exampleEmail11" class=""><?php echo trans('forms.location'); ?> <font style="color:red;">*</font></label>
                                                        <select name="location" id="exampleEmail11" class="form-control" required>
                                                            <option value=""><?php echo trans('forms.please_select'); ?></option>
                                                            <?php 
                                                            if(!empty($locations)) {
                                                                foreach($locations as $location) {
                                                            ?>
                                                            <option value="<?php echo $location->id; ?>"  <?php if($rooms[0]['room']->location==$location->id) echo 'selected'; ?>><?php echo $location->name; ?></option>
                                                            <?php } } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            
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
                                                                    if(!empty($rooms[0]['availability'])) {
                                                                        foreach($rooms[0]['availability'] as $avail) {
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