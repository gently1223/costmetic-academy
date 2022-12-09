<?php include(app_path().'/common/header.php'); ?>
      <!-- Bootstrap time Picker -->
  <link rel="stylesheet" href="<?php echo url('plugins/timepicker/bootstrap-timepicker.min.css'); ?>">

<input type="hidden" name="appointments" value='[<?php echo $appointments; ?>]' id="appointments">
<link href='<?php echo url('fullcalendar/core/main.css'); ?>' rel='stylesheet' />
    <link href='<?php echo url('fullcalendar/daygrid/main.css'); ?>' rel='stylesheet' />
    <link href='<?php echo url('fullcalendar/timegrid/main.css'); ?>' rel='stylesheet' />

    <script src='<?php echo url('fullcalendar/core/main.js'); ?>'></script>
    <script src='<?php echo url('fullcalendar/daygrid/main.js'); ?>'></script>
    <script src='<?php echo url('fullcalendar/timegrid/main.js'); ?>'></script>
    <script src='<?php echo url('fullcalendar/interaction/main.js'); ?>'></script>
<script src='<?php echo url('fullcalendar/core/locales/de.js'); ?>'></script>

<style>
    .fc-event, .fc-event-dot, .fc-time-grid-event.fc-short .fc-content {
        color: white !important;
        cursor: pointer;
    }
    .fc-time-grid .fc-slats td {
  height: 4em;
  border-bottom: 0;
}
    
    <?php if(!empty($holidays)) { foreach($holidays as $holiday) { ?>
    td[data-date="<?php echo $holiday; ?>"] {
  background-color: #DC3D2A;
}
    <?php } } ?>
</style>

                    <div class="app-inner-layout app-inner-layout-page">
                        <div class="app-inner-layout__wrapper">
                            
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
                                             <form action="" method="get" id="app-filter">
                                              <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-control" style="border:0px;">
                                                        <select class="form-control" name="room" onchange="$('#app-filter').submit();">
                                                            <option value="">All Rooms</option>
                                                            <?php 
                                                            if(!empty($rooms)) {
                                                                foreach($rooms as $room) {
                                                            ?>
                                                            <option value="<?php echo $room['room']->id; ?>" <?php if(isset($_GET['room']) AND $_GET['room']==$room['room']->id) echo 'selected'; ?> ><?php echo $room['room']->name.' ('.$room['location'].')'; ?></option>
                                                            <?php } } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                               </div>
                                             </form>
                                            <hr class="mb-0">
                                            
                                            <div style="overflow:hidden;">
                                            <div class="ml-3 mt-2" style="display:inline; float:left;"><i class="fa fa-circle" style="color: #fcf8e3; width:20px; height:20px; border-radius:50%; display:inline; border:1px solid #ddd;"></i> Today</div>
                                            <div class="ml-3 mt-2" style="display:inline; float:left;"><i class="fa fa-circle" style="color: #DC3D2A; width:20px; height:20px; border-radius:50%; display:inline; border:1px solid #ddd;"></i> Holiday</div>
                                            </div>
                                            
                                            <div class="card-body">
                                                
                                                <div id='calendar2'></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

<?php include(app_path().'/common/footer.php'); ?>

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

<!-- bootstrap time picker -->
<script src="<?php echo url('plugins/timepicker/bootstrap-timepicker.min.js'); ?>"></script>
<script>
    window.calendar;
    
    function show_until(repeat)
    {
        if(repeat!='0') $("#until_box").show();
        else $("#until_box").hide();
    }

      document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar2');
          var events=$("#appointments").val(); //alert(events);
          events=$.parseJSON(events);

        window.calendar = new FullCalendar.Calendar(calendarEl, {
          plugins: [ 'interaction', 'dayGrid', 'timeGrid' ],
          defaultView: 'timeGridWeek',
          allDaySlot: false,
            locales: ['deLocale'],
            locale: 'de',
          firstDay: 1,
            height: 850,
            weekNumbers: true,
            weekLabel: 'W',
          header: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
          },
            contentHeight:1000,
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
                        $("#view-app-modal-title").text('Termin ansehen');
                        $("#app-description").text(data.description);
                        $("#app-date").html('<b>Date:</b> '+data.date2);
                        $("#app-time").html('<b>Time:</b> '+data.time+' - '+data.time_end);
                        $("#app-room").html(data.room_details);
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
                    console.log(e);
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
    
    
    function getWeekNumber(d) {
  d = new Date(d);
  d.setHours(0, 0, 0);

  d.setDate(d.getDate() + 4 - (d.getDay() || 7));

  const yearStart = new Date(d.getFullYear(), 0, 1);

  const weekNo = Math.ceil(((d - yearStart) / 86400000 + 1) / 7);
  
  return weekNo;
}

    
    </script>
