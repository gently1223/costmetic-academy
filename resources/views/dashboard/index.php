<?php include(app_path().'/common/header.php'); ?>
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
    
    .fc-list-item{
        cursor: pointer;
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
                                        
                                        <div class="row">
                                            <div class="col-md-6">
                                        <div class="card mb-3">
                                            <div class="card-header-tab card-header">
                                                <div class="card-header-title font-size-lg text-capitalize font-weight-normal">
                                                    <i class="header-icon fa fa-calendar mr-3 text-muted opacity-9" style="font-size:22px;"></i> <?php echo trans('dashboard.today_appointments'); ?>
                                                </div>
                                                <div class="btn-actions-pane-right actions-icon-btn">
                                                    
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <div class="card-body">
                                                <div id='calendar2'></div>
                                            </div>
                                            </div>
                                        </div>
                                            </div>
                                        
                                            <div class="col-md-6">
                                        <?php include(app_path().'/common/to_do.php'); ?>
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

<?php include(app_path().'/common/footer.php'); ?>
<button type="button" class="btn mr-2 mb-2 btn-primary" data-toggle="modal" data-target="#subscribe" id="subscribe-btn" style="display:none;"></button>
<button type="button" class="btn mr-2 mb-2 btn-primary" data-toggle="modal" data-target="#view-appointment" id="view-appointment-btn" style="display:none;"></button>
<div class="modal fade" id="view-appointment" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="<?php echo url('admin/create-appointment'); ?>" method="post" id="add-appointment-form">
                    <input type="hidden" name="edit" value="0" id="edit">
                    <?php echo csrf_field(); ?>
              <div class="modal-header">
                  <h5 class="modal-title" id="view-app-modal-title">Appointment</h5>
              </div>
              <div class="modal-body">
                  <div class="row">
                      <div class="col-12">
                          <p class="mb-0" id="app-description"></p>
                          <p class="mb-0" id="app-date"></p>
                          <p class="mb-0" id="app-time"></p>
                          <p id="app-room"></p>
                          
                          <p class="mb-0" id="app-course"></p>
                      </div>
                  </div>
                  
                  <p class="alert alert-success" id="ass-success" style="display:none;"></p>
                  <p class="alert alert-danger" id="app_error" style="display:none;"></p>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-primary pull-right" data-dismiss="modal">Close</button>
              </div>
                  </form>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>

<div class="modal fade" id="subscribe" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
          <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <form action="" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="subscribe" value="1">
                    <?php echo csrf_field(); ?>
              <div class="modal-header">
                  <h4 class="modal-title" id="modal-title-task"><?php echo trans('dashboard.newsletter_subscription'); ?></h4>
              </div>
              <div class="modal-body">
                  <p><?php echo trans('dashboard.newsletter_subscription_text'); ?></p>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default pull-right" data-dismiss="modal"><?php echo trans('dashboard.no_thanks'); ?></button>
                <button type="submit" class="btn btn-primary pull-right" style="margin-right:10px;"><?php echo trans('dashboard.yes_iam_in'); ?></button>
              </div>
                  </form>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>

<?php include(app_path().'/common/to_do_modal.php'); ?>

<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

<script>
    <?php if($user->newsletter=='0' AND $logged_in=='1') { ?>
    $("#subscribe-btn").click();
    <?php } ?>
    
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
                url: "<?php echo url('fetch-appointment') ?>",
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
                        $("#view-appointment-btn").click();
                        //$("#edit").val(app_id);
                        $("#view-app-modal-title").text(data.title);
                        $("#app-description").text(data.description);
                        $("#app-date").html('<b>Date:</b> '+data.date2);
                        $("#app-time").html('<b>Time:</b> '+data.time+' - '+data.time_end);
                        $("#app-room").html(data.room_details);
                        $("#app-course").html(data.course_details);
                        
                        $("#app_error").hide();
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
