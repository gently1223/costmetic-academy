<?php include(app_path().'/common/panel/header.php'); ?>
      <!-- Bootstrap time Picker -->
  <link rel="stylesheet" href="<?php echo url('plugins/timepicker/bootstrap-timepicker.min.css'); ?>">

<input type="hidden" name="appointments" value='[<?php echo $appointments; ?>]' id="appointments">
<link href='<?php echo url('fullcalendar/core/main.css'); ?>' rel='stylesheet' />
    <link href='<?php echo url('fullcalendar/daygrid/main.css'); ?>' rel='stylesheet' />
    <link href='<?php echo url('fullcalendar/timegrid/main.css'); ?>' rel='stylesheet' />
    <link href='<?php echo url('fullcalendar/list/main.css'); ?>' rel='stylesheet' />

    <script src='<?php echo url('fullcalendar/core/main.js'); ?>'></script>
    <script src='<?php echo url('fullcalendar/daygrid/main.js'); ?>'></script>
    <script src='<?php echo url('fullcalendar/timegrid/main.js'); ?>'></script>
    <script src='<?php echo url('fullcalendar/list/main.js'); ?>'></script>
    <script src='<?php echo url('fullcalendar/interaction/main.js'); ?>'></script>
<script src='<?php echo url('fullcalendar/core/locales/de.js'); ?>'></script>

<style>
    .fc-event, .fc-event-dot, .fc-time-grid-event.fc-short .fc-content {
        color: white;
    }
</style>
<style>
    .scroll-area-sm {
        height: 450px;
    }
    
    .fc-toolbar .fc-right {
    display: none;
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
                            <div class="app-inner-layout__content">
                                <div class="tab-content">
                                    <div class="container-fluid">
                                        
                                        <div class="card no-shadow bg-transparent no-border rm-borders mb-3">
                                            <div class="card">
                                                <div class="no-gutters row">
                                                    <div class="col-md-12 col-lg-4">
                                                        <ul class="list-group list-group-flush">
                                                            <li class="bg-transparent list-group-item">
                                                                <div class="widget-content p-0">
                                                                    <div class="widget-content-outer">
                                                                        <div class="widget-content-wrapper">
                                                                            <div class="widget-content-left">
                                                                                <div class="widget-heading"><?php echo trans('dashboard.total_users'); ?>
                                                                                </div>
                                                                                <div class="widget-subheading">
                                                                                </div>
                                                                            </div>
                                                                            <div class="widget-content-right">
                                                                                <div class="widget-numbers text-success">
                                                                                    <?php echo count($users); ?>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                            <li class="bg-transparent list-group-item">
                                                                <div class="widget-content p-0">
                                                                    <div class="widget-content-outer">
                                                                        <div class="widget-content-wrapper">
                                                                            <div class="widget-content-left">
                                                                                <div class="widget-heading"><?php echo trans('dashboard.total_rooms'); ?></div>
                                                                                <div class="widget-subheading">
                                                                                </div>
                                                                            </div>
                                                                            <div class="widget-content-right">
                                                                                <div class="widget-numbers text-primary">
                                                                                    <?php echo count($rooms); ?>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <div class="col-md-12 col-lg-4">
                                                        <ul class="list-group list-group-flush">
                                                            <li class="bg-transparent list-group-item">
                                                                <div class="widget-content p-0">
                                                                    <div class="widget-content-outer">
                                                                        <div class="widget-content-wrapper">
                                                                            <div class="widget-content-left">
                                                                                <div class="widget-heading"><?php echo trans('dashboard.total_contacts'); ?></div>
                                                                                <div class="widget-subheading">
                                                                                </div>
                                                                            </div>
                                                                            <div class="widget-content-right">
                                                                                <div class="widget-numbers text-danger">
                                                                                    <?php echo count($contacts); ?>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                            <li class="bg-transparent list-group-item">
                                                                <div class="widget-content p-0">
                                                                    <div class="widget-content-outer">
                                                                        <div class="widget-content-wrapper">
                                                                            <div class="widget-content-left">
                                                                                <div class="widget-heading"><?php echo trans('dashboard.product_categories'); ?>
                                                                                </div>
                                                                                <div class="widget-subheading">
                                                                                </div>
                                                                            </div>
                                                                            <div class="widget-content-right">
                                                                                <div class="widget-numbers text-warning">
                                                                                    <?php echo count($product_categories); ?>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <div class="col-md-12 col-lg-4">
                                                        <ul class="list-group list-group-flush">
                                                            <li class="bg-transparent list-group-item">
                                                                <div class="widget-content p-0">
                                                                    <div class="widget-content-outer">
                                                                        <div class="widget-content-wrapper">
                                                                            <div class="widget-content-left">
                                                                                <div class="widget-heading"><?php echo trans('dashboard.total_products'); ?>
                                                                                </div>
                                                                                <div class="widget-subheading">
                                                                                </div>
                                                                            </div>
                                                                            <div class="widget-content-right">
                                                                                <div class="widget-numbers text-success">
                                                                                    <?php echo count($products); ?>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                            <li class="bg-transparent list-group-item">
                                                                <div class="widget-content p-0">
                                                                    <div class="widget-content-outer">
                                                                        <div class="widget-content-wrapper">
                                                                            <div class="widget-content-left">
                                                                                <div class="widget-heading"><?php echo trans('dashboard.room_locations'); ?></div>
                                                                                <div class="widget-subheading">
                                                                                </div>
                                                                            </div>
                                                                            <div class="widget-content-right">
                                                                                <div class="widget-numbers text-primary">
                                                                                    <?php echo count($room_locations); ?>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        
                                        <div class="row">
                                            <div class="col-md-6">
                                        <div class="card mb-3">
                                            <div class="card-header-tab card-header">
                                                <div class="card-header-title font-size-lg text-capitalize font-weight-normal">
                                                    <i class="header-icon fa fa-calendar mr-3 text-muted opacity-9" style="font-size:22px;"></i> <?php echo trans('dashboard.upcoming_appointments'); ?>
                                                </div>
                                                <div class="btn-actions-pane-right actions-icon-btn">
                                                    
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <div class="card-body">
                                                <div id='calendar2'></div>
                                            </div>
                                                <!--<table style="width: 100%;" id="example3"
                                                       class="table table-hover table-striped table-bordered d-none">
                                                    <thead>
                                                    <tr>
                                                        <th><?php echo trans('dashboard.title'); ?></th>
                                                        <th><?php echo trans('dashboard.description'); ?></th>
                                                        <th><?php echo trans('dashboard.contact'); ?></th>
                                                        <th><?php echo trans('dashboard.room'); ?></th>
                                                        <th><?php echo trans('dashboard.time'); ?></th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php 
                                                        if(!empty($today_appointments)) {
                                                            foreach($today_appointments as $app) {
                                                        ?>
                                                    <tr>
                                                        <td><?php echo $app['appointment']->title; ?></td>
                                                        <td><?php echo $app['appointment']->description; ?></td>
                                                        <td><?php if($app['contact']=='NA') echo $app['contact'];
                                                                else echo $app['contact']->name; ?></td>
                                                        <td>
                                                            <?php 
                                                                if($app['room']=='NA') echo $app['room']; 
                                                                else echo $app['room']->name; ?>
                                                            
                                                            <p><?php echo trans('forms.location'); ?>: <?php if($app['room_location']=='NA') echo $app['room_location']; 
                                                            else echo $app['room_location']->name; ?></p>
                                                        </td>
                                                        <td><?php echo $app['appointment']->time.' - '.$app['appointment']->time_end; ?></td>
                                                    </tr>
                                                        <?php } } ?>
                                                    </tbody>
                                                    <tfoot>
                                                    </tfoot>
                                                </table>-->
                                            </div>
                                        </div>
                                            </div>
                                        
                                            <div class="col-md-6">
                                        <?php include(app_path().'/common/panel/to_do.php'); ?>
                                            </div>
                                        </div>
                                        
                                        <div class="row">
                                            <?php if(!empty($courses_app_report)) { ?>
                                            <div class="col-md-6">
                                                <div class="main-card mb-3 card">
                                                    <div class="card-body">
                                                        <h5 class="card-title">Open Courses appointment report</h5>
                                                        <div id="appointments-chart"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php } ?>
                                            
                                            <?php if(!empty($running_courses_app_report)) { ?>
                                            <div class="col-md-6">
                                                <div class="main-card mb-3 card">
                                                    <div class="card-body">
                                                        <h5 class="card-title">Ongoing Courses appointment report</h5>
                                                        <div id="ongoing-appointments-chart"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php } ?>
                                        </div>
                                        
                                        <div class="row d-none">
                                            <div class="col-md-6 col-xl-3">
                                                <div class="card mb-3 widget-chart widget-chart2 text-left card-btm-border card-shadow-success border-success">
                                                    <div class="widget-chat-wrapper-outer">
                                                        <div class="widget-chart-content pt-3 pl-3 pb-1">
                                                            <div class="widget-chart-flex">
                                                                <div class="widget-numbers">
                                                                    <div class="widget-chart-flex">
                                                                        <div class="fsize-4">
                                                                            <small class="opacity-5">$</small>
                                                                            <span>874</span></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <h6 class="widget-subheading mb-0 opacity-5">sales last
                                                                month</h6></div>
                                                        <div class="no-gutters widget-chart-wrapper mt-3 mb-3 pl-2 he-auto row">
                                                            <div class="col-md-9">
                                                                <div id="dashboard-sparklines-1"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-xl-3">
                                                <div class="card mb-3 widget-chart widget-chart2 text-left card-btm-border card-shadow-primary border-primary">
                                                    <div class="widget-chat-wrapper-outer">
                                                        <div class="widget-chart-content pt-3 pl-3 pb-1">
                                                            <div class="widget-chart-flex">
                                                                <div class="widget-numbers">
                                                                    <div class="widget-chart-flex">
                                                                        <div class="fsize-4">
                                                                            <small class="opacity-5">$</small>
                                                                            <span>1283</span></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <h6 class="widget-subheading mb-0 opacity-5">sales Income</h6>
                                                        </div>
                                                        <div class="no-gutters widget-chart-wrapper mt-3 mb-3 pl-2 he-auto row">
                                                            <div class="col-md-9">
                                                                <div id="dashboard-sparklines-2"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-xl-3">
                                                <div class="card mb-3 widget-chart widget-chart2 text-left card-btm-border card-shadow-warning border-warning">
                                                    <div class="widget-chat-wrapper-outer">
                                                        <div class="widget-chart-content pt-3 pl-3 pb-1">
                                                            <div class="widget-chart-flex">
                                                                <div class="widget-numbers">
                                                                    <div class="widget-chart-flex">
                                                                        <div class="fsize-4">
                                                                            <small class="opacity-5">$</small>
                                                                            <span>1286</span></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <h6 class="widget-subheading mb-0 opacity-5">last month
                                                                sales</h6></div>
                                                        <div class="no-gutters widget-chart-wrapper mt-3 mb-3 pl-2 he-auto row">
                                                            <div class="col-md-9">
                                                                <div id="dashboard-sparklines-3"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-xl-3">
                                                <div class="card mb-3 widget-chart widget-chart2 text-left card-btm-border card-shadow-danger border-danger">
                                                    <div class="widget-chat-wrapper-outer">
                                                        <div class="widget-chart-content pt-3 pl-3 pb-1">
                                                            <div class="widget-chart-flex">
                                                                <div class="widget-numbers">
                                                                    <div class="widget-chart-flex">
                                                                        <div class="fsize-4">
                                                                            <small class="opacity-5">$</small>
                                                                            <span>564</span></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <h6 class="widget-subheading mb-0 opacity-5">total revenue</h6>
                                                        </div>
                                                        <div class="no-gutters widget-chart-wrapper mt-3 mb-3 pl-2 he-auto row">
                                                            <div class="col-md-9">
                                                                <div id="dashboard-sparklines-4"></div>
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

<?php include(app_path().'/common/panel/footer.php'); ?>
<?php include(app_path().'/common/panel/to_do_modal.php'); ?>

<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

<script>
    $('.date_range').daterangepicker({
        startDate: new Date(),
        locale: {
            format: 'DD-MM-YYYY'
        }
    });
    
    $('.calendar').daterangepicker({
        singleDatePicker: true,
        startDate: new Date(),
        locale: {
            format: 'DD-MM-YYYY'
        }
    });
    
    $('.reminder').daterangepicker({
        timePicker: true,
        singleDatePicker: true,
        showDropdowns: true,
        startDate: new Date(),
        locale: {
            format: 'DD-MM-YYYY hh:mm A'
        }
    });
</script>

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="" method="post" id="add-appointment-form">
                    <input type="hidden" name="edit" value="0" id="edit">
                    <?php echo csrf_field(); ?>
              <div class="modal-header">
                  <h4 class="modal-title" id="modal-title">New Appointment</h4>
              </div>
              <div class="modal-body">
                  <p class="alert alert-success" id="ass-success" style="display:none;"></p>
                  <div class="row">
                      <div class="col-12 col-lg-6">
                          <div class="form-group">
                            <label for="exampleInputEmail1">Contact <font style="color:red;">*</font></label>
                              <select name="contact" id="contact" class="form-control" required>
                                  <option value="">Please Select</option>
                                  <?php 
                                  if(!empty($contacts_data)) {
                                      foreach($contacts_data as $staff) {
                                  ?>
                                  <option value="<?php echo $staff->id; ?>"><?php echo $staff->name; ?></option>
                                  <?php } } ?>
                              </select>
                          </div>
                      </div>
                      <div class="col-12 col-lg-6">
                          <div class="form-group">
                            <label for="exampleInputEmail1">Room <font style="color:red;">*</font></label>
                              <select name="room" id="room" class="form-control" required>
                                  <option value="">Please Select</option>
                                  <?php 
                                  if(!empty($rooms_data)) {
                                      foreach($rooms_data as $room) {
                                  ?>
                                  <option value="<?php echo $room['room']->id; ?>"><?php echo $room['room']->name.' ('.$room['location'].')'; ?></option>
                                  <?php } } ?>
                              </select>
                          </div>
                      </div>
                      <div class="col-12 col-lg-12">
                          <div class="form-group">
                            <label for="exampleInputEmail1">Title <font style="color:red;">*</font></label>
                              <input type="text" class="form-control" name="title" required id="title">
                          </div>
                      </div>
                  </div>
                  
                  <div class="row">
                      <div class="col-12 col-lg-12">
                          <div class="form-group">
                            <label for="exampleInputEmail1">Description</label>
                              <textarea type="text" class="form-control" name="description" id="description"></textarea>
                          </div>
                      </div>
                  </div>
                  
                  <div class="row">
                      <div class="col-12 col-lg-6">
                          <div class="form-group">
                            <label for="exampleInputEmail1">Date <font style="color:red;">*</font></label>
                            
                              <div class="input-group">
                                    <input type="text" class="form-control" id="date2" placeholder="" required name="date2" readonly>
                                  <input type="hidden" class="form-control" id="date" placeholder="" name="date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                </div>
                          </div>
                      </div>
                      
                      <div class="col-12 col-lg-6">
                          
                          <div class="bootstrap-timepicker">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Time <font style="color:red;">*</font></label>
                                <div class="input-group">
                                    <!--<input type="text" class="form-control timepicker" name="time" id="time">-->
                                    <div class="input-group-addon">
                                        <i class="fa fa-clock-o"></i>
                                    </div>
                                    <input type="text" class="form-control" name="time" id="time" readonly>
                                    <input type="text" class="form-control timepicker" name="time_end" id="time_end">
                                </div>
                            <!-- /.input group -->
                            </div>
                            <!-- /.form group -->
                        </div>
                      </div>
                  </div>
                  
                  <div class="row">
                      <div class="col-12 col-lg-12">
                          <label for="exampleInputEmail1">Recurring</label>
                          <select class="form-control" name="recurring" required id="recurring">
                              <option value="0">No Repeat</option>
                              <option value="Everyday">Everyday</option>
                              <option value="Monday">Every Monday</option>
                              <option value="Tuesday">Every Tuesday</option>
                              <option value="Wednesday">Every Wednesday</option>
                              <option value="Thursday">Every Thursday</option>
                              <option value="Friday">Every Friday</option>
                              <option value="Saturday">Every Saturday</option>
                              <option value="Sunday">Every Sunday</option>
                          </select>
                      </div>
                  </div>
                  <br>
                  <a href="javascript:void(0)" data-id='0' class="" id="removeEvent" style="color:red; margin-top:20px; margin-bottom:20px; display:none;" onclick="removeEvent(this)"><i class="fa fa-trash"></i> Remove appointment</a>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default pull-right" data-dismiss="modal" id="add-appointment-close">Cancel</button>
                <button type="submit" class="btn btn-primary pull-right" style="margin-right:10px;" id="submit_btn">Submit</button>
              </div>
                  </form>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>

<!-- bootstrap time picker -->
<script src="<?php echo url('plugins/timepicker/bootstrap-timepicker.min.js'); ?>"></script>
<script>
    window.calendar;

      document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar2');
          var events=$("#appointments").val(); //alert(events);
          events=$.parseJSON(events);

        window.calendar = new FullCalendar.Calendar(calendarEl, {
          plugins: [ 'interaction', 'dayGrid', 'timeGrid', 'list' ],
          defaultView: 'listWeek',
          allDaySlot: false,
            locales: ['deLocale'],
            locale: 'de',
          firstDay: 1,
            height: 386,
            weekNumbers: true,
            weekLabel: 'W',
          header: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
          },
            slotLabelFormat: [
        {
            hour: '2-digit',
            minute: '2-digit',
            hour12:false
        }
        ],
            datesRender: function(info) { //alert(info.view.type);
                //$("div.fc-left button.fc-today-button").text('Today');
                //$("div.fc-right button.fc-dayGridMonth-button").text('Month');
                //$("div.fc-right button.fc-timeGridWeek-button").text('Week');
                //$("div.fc-right button.fc-timeGridDay-button").text('Day');
                
      if (info.view.type == 'timeGridWeek')
      {
          $("div.fc-center h2").append(" (Woche " + getWeekNumber(info.view.activeStart)+ ")");
      }
   },
            titleFormat: { // will produce something like "Tuesday, September 18, 2018"
    month: 'short',
    year: 'numeric',
    day: 'numeric',
    week: "d[ MMM][ yyyy]{ '-' d MMM yyyy}, week W",
  },
             eventTimeFormat: { // like '14:30:00'
    hour: '2-digit',
    minute: '2-digit',
    hour12: false
  },
          dateClick: function(info) {
                //alert('Clicked on: ' + info.dateStr);
                var aDate = new Date(
                    Date.parse(info.dateStr)
                );
              
                var date = aDate.getDate();
                date=("0" + date).slice(-2);
                var month = parseFloat(aDate.getMonth())+1;
                month=("0" + month).slice(-2);
                var year = aDate.getFullYear(); //alert(date+" / "+month+" / "+year);
                var h = aDate.getHours();
                h=("0" + h).slice(-2);
                var m = aDate.getMinutes(); //alert(h+" : "+m);
                if(m=='0') m='00';
                var s = aDate.getSeconds();
                var m2=parseInt(m)+30;
                
                //var time=h+':'+m;
                /*var ampm = h >= 12 ? 'PM' : 'AM';
                var hours = h % 12;
                hours = hours ? hours : 12; // the hour '0' should be '12'
                var minutes = m < 10 ? m : m;
                var strTime = hours + ':' + minutes + ' ' + ampm;*/
              
                var strTime = h + ':' + m;
              
                if(m2>59) { 
                    m2='00';
                    h=parseInt(h)+1;
                }
                var strTime2 = h + ':' + m2;
              
                $("#edit").val('0');
                $("#title").val('');
                $("#contact").val('');
                $("#room").val('');
                $("#description").val('');
                $("#recurring").val('0');
              
                $("#date2").val(date+'-'+month+'-'+year);
                $("#date").val(year+'-'+month+'-'+date);
                $("#time").val(strTime);
                $("#time_end").val(strTime2);
              
                $("#removeEvent").hide();
                $("#modal-title").text('New Appointment');
              
                //$("#add-appointment").modal('show');
              $("#add-appointment-btn").click();
              
                // change the day's background color just for fun
                //info.dayEl.style.backgroundColor = 'red';
          },
            eventClick: function(object){
				var el = object.el
				var event= object.event;
                //console.log(event);
				var jsEvent = object.jsEvent;
                
                var app_id=event.id;
                
                var formData=new FormData();
                var token='<?php echo csrf_token(); ?>';
                formData.append('_token', token);
                formData.append('id', app_id);
        
        $.ajax({
                url: "<?php echo url('admin/fetch-appointment') ?>",
                type: "POST",
                data:  formData,
                beforeSend: function(){ //alert('sending');
                },
                contentType: false,
                processData:false,
                success: function(data) { //alert(data);
                    //success
                    // here we will handle errors and validation messages
                    if ( ! data.success) {
                    } else {
                        // ALL GOOD! just show the success message!
                        $("#edit").val(app_id);
                        $("#title").val(data.title);
                        $("#description").val(data.description);
                        $("#contact").val(data.contact);
                        $("#room").val(data.room);
                        $("#date").val(data.date);
                        $("#date2").val(data.date2);
                        $("#time").val(data.time);
                        $("#time_end").val(data.time_end);
                        $("#recurring").val(data.recurring);
                        $("#removeEvent").attr('data-id', app_id);
                        $("#modal-title").text('Edit Appointment');
                        $("#removeEvent").show();
                        $("#add-appointment-btn").click();
                    }
                },
                error: function()  {
                    //error
                } 	        
        });
                
            },
            eventRender: function(object){
                var ele = object.el;
                var event = object.event;
                try{
                    $(ele).tooltip({
                    title: event.title,
                    trigger: "hover"
                    })
                }catch (e) {
                    console.log(e)
                }

            },
        });

        window.calendar.render();
        window.calendar.addEventSource(events);
        //var event=window.calendar.getEventById('31');
        //event.remove();
          
      });
    
    //Datemask dd/mm/yyyy
    //$("#date").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
    
    //Timepicker
    $(".timepicker").timepicker({
      showInputs: false,
        minuteStep: 30,
        showMeridian: false,
        format: 'HH:mm',
        use24hours: true
    });
    
    $("#add-appointment-form").submit(function(e){
        e.preventDefault();
        
        var formData=new FormData(this);
        var date=$("#date").val();
        var time=$("#time").val();
        
        $.ajax({
                url: "<?php echo url('admin/create-appointment') ?>",
                type: "POST",
                data:  formData,
                beforeSend: function(){ //alert('sending');
                    $("#submit_btn").attr('disabled', true);
                },
                contentType: false,
                processData:false,
                success: function(data) { //alert(data);
                    //success
                    $("#submit_btn").attr('disabled', false);
                    // here we will handle errors and validation messages
                    if ( ! data.success) {
                    } else {
                        // ALL GOOD! just show the success message!
                        //alert(data.recurring); alert(data.days); alert(data.time2); alert(data.time_end2);
                        add_new_appointment(data);
                        $("#date").val('');
                        $("#time").val('');
                        $("#title").val('');
                        $("#add-appointment-close").click();
                    }
                },
                error: function()  {
                    //error
                } 	        
        });
    });
    
    function removeEvent(th)
    {
        var id=$(th).attr('data-id');
        
        var formData=new FormData();
        var token='<?php echo csrf_token(); ?>';
        formData.append('_token', token);
        formData.append('id', id);
        
        $.ajax({
                url: "<?php echo url('admin/remove-appointment') ?>",
                type: "POST",
                data:  formData,
                beforeSend: function(){ //alert('sending');
                    $(th).attr('disabled', true);
                },
                contentType: false,
                processData:false,
                success: function(data) { //alert(data);
                    //success
                    // here we will handle errors and validation messages
                    if ( ! data.success) {
                    } else {
                        // ALL GOOD! just show the success message!
                        remove_appointment(data);
                    }
                },
                error: function()  {
                    //error
                } 	        
        });
        
    }
    
    
      function add_new_appointment(data)
      {
          //data=data.email;
          //alert(data.edit);
                        if(data.edit!='0') {
                        var event=window.calendar.getEventById(data.id);
                        event.remove();
                        }
                        
                        if(data.recurring=='Everyday') {
                        window.calendar.addEvent(
                        { // this object will be "parsed" into an Event Object
                            id: data.id,
                            title: data.title, // a property!
                            start: date.date+'T'+data.time+':00', // a property!
                            end: data.date+'T'+data.time_end+':00',
                            daysOfWeek: [0,1,2,3,4,5,6],
                            startTime: data.time2,
                            endTime: data.time_end2
                        }
                        );
                        }
                        else if(data.recurring!='0') {
                        window.calendar.addEvent(
                        { // this object will be "parsed" into an Event Object
                            id: data.id,
                            title: data.title, // a property!
                            start: data.date+'T'+data.time+':00', // a property!
                            end: data.date+'T'+data.time_end+':00',
                            daysOfWeek: [data.days],
                            startTime: data.time2,
                            endTime: data.time_end2
                        }
                        );
                        }
                        else{
                          window.calendar.addEvent(
                        { // this object will be "parsed" into an Event Object
                            id: data.id,
                            title: data.title, // a property!
                            start: data.date+'T'+data.time+':00', // a property!
                            end: data.date+'T'+data.time_end+':00'
                        }
                        );  
                        }
      }
    
    function remove_appointment(data)
    {   
        var event=window.calendar.getEventById(data.id);
        event.remove();
        
        $("#add-appointment-close").click();
    }
    
    function getWeekNumber(d) {
  d = new Date(d);
  d.setHours(0, 0, 0);

  d.setDate(d.getDate() + 4 - (d.getDay() || 7));

  const yearStart = new Date(d.getFullYear(), 0, 1);

  const weekNo = Math.ceil(((d - yearStart) / 86400000 + 1) / 7);
  
  return weekNo;
}

    </script>

<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    /*var options = {
  chart: {
    type: 'line'
  },
  series: [{
    name: 'sales',
    data: [30,40,35,50,49,60,70,91,125]
  }],
  xaxis: {
    categories: [1991,1992,1993,1994,1995,1996,1997, 1998,1999]
  }
}*/
    var options= {
        chart:{height:350,type:"bar"},
        plotOptions:{
            bar:{
                horizontal:!1,endingShape:"rounded",columnWidth:"55%"
            }
        },
        dataLabels:{enabled:!1},
        stroke:{
            show:!0,width:2,colors:["transparent"]
        },
        series:[
            {name:"Appointments",data:[<?php if(!empty($courses_app_report)) { $i=0; foreach($courses_app_report as $report) { if($i++==0) echo $report['appointments']; else echo ', '.$report['appointments']; } } ?>]},
            {name:"Accepted",data:[<?php if(!empty($courses_app_report)) { $i=0; foreach($courses_app_report as $report) { if($i++==0) echo $report['accepted']; else echo ', '.$report['accepted']; } } ?>]},
            {name:"Pending",data:[<?php if(!empty($courses_app_report)) { $i=0; foreach($courses_app_report as $report) { if($i++==0) echo $report['pending']; else echo ', '.$report['pending']; } } ?>]}
        ],
        xaxis:{categories:[<?php if(!empty($courses_app_report)) { $i=0; foreach($courses_app_report as $report) { if($i++==0) echo '"'.$report['name'].'"'; else echo ', "'.$report['name'].'"'; } } ?>]},
        yaxis:{title:{text:" "}},
        fill:{opacity:1},
        tooltip:{y:{formatter:function(t){return" "+t+" "}}}},
            
        v={chart:{height:350,type:"bar",stacked:!0},
               plotOptions:{bar:{horizontal:!0}},
               stroke:{width:1,colors:["#fff"]},
               series:[{name:"Marine Sprite",
                        data:[44,55,41,37,22,43,21]},{
                            name:"Striking Calf",data:[53,32,33,52,13,43,32]},{name:"Tank Picture",data:[12,17,11,9,15,11,20]},
                       {name:"Bucket Slope",data:[9,7,5,8,6,9,4]},{
                           name:"Reborn Kid",data:[25,12,19,32,25,24,10]}],
               title:{text:"Fiction Books Sales"},
               xaxis:{categories:[2008,2009,2010,2011,2012,2013,2014],
                      labels:{formatter:function(t){return t+"K"}}},
               yaxis:{title:{text:void 0}},tooltip:{y:{formatter:function(t){return t+"K"}}},fill:{opacity:1},legend:{position:"top",horizontalAlign:"left",offsetX:40}
              }

var chart = new ApexCharts(document.querySelector("#appointments-chart"), options);

chart.render();
</script>

<script>
    /*var options = {
  chart: {
    type: 'line'
  },
  series: [{
    name: 'sales',
    data: [30,40,35,50,49,60,70,91,125]
  }],
  xaxis: {
    categories: [1991,1992,1993,1994,1995,1996,1997, 1998,1999]
  }
}*/
    var options= {
        chart:{height:350,type:"bar"},
        plotOptions:{
            bar:{
                horizontal:!1,endingShape:"rounded",columnWidth:"55%"
            }
        },
        dataLabels:{enabled:!1},
        stroke:{
            show:!0,width:2,colors:["transparent"]
        },
        series:[
            {name:"Appointments",data:[<?php if(!empty($running_courses_app_report)) { $i=0; foreach($running_courses_app_report as $report) { if($i++==0) echo $report['appointments']; else echo ', '.$report['appointments']; } } ?>]},
            {name:"Done",data:[<?php if(!empty($running_courses_app_report)) { $i=0; foreach($running_courses_app_report as $report) { if($i++==0) echo $report['done']; else echo ', '.$report['done']; } } ?>]},
            {name:"Pending",data:[<?php if(!empty($running_courses_app_report)) { $i=0; foreach($running_courses_app_report as $report) { if($i++==0) echo $report['pending']; else echo ', '.$report['pending']; } } ?>]}
        ],
        xaxis:{categories:[<?php if(!empty($running_courses_app_report)) { $i=0; foreach($running_courses_app_report as $report) { if($i++==0) echo '"'.$report['name'].'"'; else echo ', "'.$report['name'].'"'; } } ?>]},
        yaxis:{title:{text:" "}},
        fill:{opacity:1},
        tooltip:{y:{formatter:function(t){return" "+t+" "}}}},
            
        v={chart:{height:350,type:"bar",stacked:!0},
               plotOptions:{bar:{horizontal:!0}},
               stroke:{width:1,colors:["#fff"]},
               series:[{name:"Marine Sprite",
                        data:[44,55,41,37,22,43,21]},{
                            name:"Striking Calf",data:[53,32,33,52,13,43,32]},{name:"Tank Picture",data:[12,17,11,9,15,11,20]},
                       {name:"Bucket Slope",data:[9,7,5,8,6,9,4]},{
                           name:"Reborn Kid",data:[25,12,19,32,25,24,10]}],
               title:{text:"Fiction Books Sales"},
               xaxis:{categories:[2008,2009,2010,2011,2012,2013,2014],
                      labels:{formatter:function(t){return t+"K"}}},
               yaxis:{title:{text:void 0}},tooltip:{y:{formatter:function(t){return t+"K"}}},fill:{opacity:1},legend:{position:"top",horizontalAlign:"left",offsetX:40}
              }

var chart = new ApexCharts(document.querySelector("#ongoing-appointments-chart"), options);

chart.render();
</script>