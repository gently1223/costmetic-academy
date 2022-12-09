<?php include(app_path().'/common/panel/header.php'); ?>
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
                                                <div class="col-md-4">
                                                    <div class="form-control" style="border:0px;">
                                                        <select class="form-control" name="contact" onchange="$('#app-filter').submit();">
                                                            <option value="">All Contacts</option>
                                                            <?php 
                                                            if(!empty($contacts)) {
                                                                foreach($contacts as $staff) {
                                                            ?>
                                                            <option value="<?php echo $staff->id; ?>" <?php if(isset($_GET['contact']) AND $_GET['contact']==$staff->id) echo 'selected'; ?> ><?php echo $staff->name; ?></option>
                                                            <?php } } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-control" style="border:0px;" onchange="$('#app-filter').submit();">
                                                        <select class="form-control" name="user">
                                                            <option value="">All Users</option>
                                                            <?php 
                                                            if(!empty($users)) {
                                                                foreach($users as $staff) {
                                                            ?>
                                                            <option value="<?php echo $staff->id; ?>" <?php if(isset($_GET['user']) AND $_GET['user']==$staff->id) echo 'selected'; ?> ><?php echo $staff->name; ?></option>
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

<button type="button" class="btn mr-2 mb-2 btn-primary" data-toggle="modal" data-target="#exampleModal" id="add-appointment-btn" style="display:none;"></button>
<?php include(app_path().'/common/panel/footer.php'); ?>

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="<?php echo url('admin/create-appointment'); ?>" method="post" id="add-appointment-form">
                    <input type="hidden" name="edit" value="0" id="edit">
                    <?php echo csrf_field(); ?>
              <div class="modal-header">
                  <h4 class="modal-title" id="modal-title">New Appointment</h4>
              </div>
              <div class="modal-body">
                  <div class="row">
                      <div class="col-12 col-lg-6">
                          <div class="form-group">
                            <label for="exampleInputEmail1">Assign to <font style="color:red;">*</font></label>
                              <select name="contact" class="form-control select-multiple2" id="contact" style="width:100%; height:100%;" required>
                                    <option value="" disabled selected>Please Select</option>
                                        <optgroup value="Contacts" label="Users">
                                            <?php
                                                if(!empty($users)) {
                                                    foreach($users as $contact) {
                                            ?>
                                            <option value="<?php echo 'user-'.$contact->id; ?>"><?php echo $contact->name; ?></option>
                                            <?php } } ?>
                                        </optgroup>
                                        <optgroup value="Contacts" label="Contacts">
                                            <?php
                                                if(!empty($contacts)) {
                                                    foreach($contacts as $contact) {
                                            ?>
                                            <option value="<?php echo 'contact-'.$contact->id; ?>"><?php echo $contact->name; ?></option>
                                            <?php } } ?>
                                        </optgroup>
                                </select>
                          </div>
                      </div>
                      <div class="col-12 col-lg-6">
                          <div class="form-group">
                            <label for="exampleInputEmail1">Room <font style="color:red;">*</font></label>
                              <select name="room" id="room" class="form-control" required>
                                  <option value="" disabled selected>Please Select</option>
                                  <?php 
                                  if(!empty($rooms)) {
                                      foreach($rooms as $room) {
                                  ?>
                                  <option value="<?php echo $room['room']->id; ?>"><?php echo $room['room']->name.' ('.$room['location'].')'; ?></option>
                                  <?php } } ?>
                              </select>
                          </div>
                      </div>
                      <div class="col-12 col-lg-12">
                          <div class="form-group">
                            <label for="exampleInputEmail1">Attendees</label>
                              <select name="attendees[]" multiple class="form-control select-multiple2" id="attendees" style="width:100%; height:100%;">
                                        <optgroup value="Contacts" label="Users">
                                            <?php
                                                if(!empty($users)) {
                                                    foreach($users as $contact) {
                                            ?>
                                            <option value="<?php echo 'user-'.$contact->id; ?>"><?php echo $contact->name; ?></option>
                                            <?php } } ?>
                                        </optgroup>
                                        <optgroup value="Contacts" label="Contacts">
                                            <?php
                                                if(!empty($contacts)) {
                                                    foreach($contacts as $contact) {
                                            ?>
                                            <option value="<?php echo 'contact-'.$contact->id; ?>"><?php echo $contact->name; ?></option>
                                            <?php } } ?>
                                        </optgroup>
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
                                  <input type="text" class="form-control calendar" id="date2" placeholder="" required name="date2">
                                  <input type="hidden" class="form-control" id="date" placeholder="" name="date">
                                    <!--<div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>-->
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
                                    <input type="text" class="form-control timepicker" name="time" id="time">
                                    <input type="text" class="form-control timepicker" name="time_end" id="time_end">
                                </div>
                            <!-- /.input group -->
                            </div>
                            <!-- /.form group -->
                        </div>
                      </div>
                  </div>
                  
                  <div class="row mb-2">
                      <div class="col-12 col-lg-12">
                          <label for="exampleInputEmail1">Category</label>
                          <select class="form-control" name="category" required id="category">
                              <option value="0"><?php echo trans('forms.please_select'); ?></option>
                              <?php 
                              if(!empty($calendar_categories)) {
                                  foreach($calendar_categories as $category) {
                              ?>
                              <option value="<?php echo $category->id; ?>"><?php echo $category->name; ?></option>
                              <?php } } ?>
                          </select>
                      </div>
                  </div>
                  
                  <div class="row mb-2">
                      <div class="col-12 col-lg-12">
                          <label for="exampleInputEmail1">Reminder</label>
                          <select class="form-control" name="reminder" required id="reminder">
                              <option value="0">No Reminder</option>
                              <option value="1">1 day before</option>
                              <option value="2">30 mins before</option>
                          </select>
                      </div>
                  </div>
                  
                  <div class="row">
                      <div class="col-12 col-lg-12" id="recurring_box">
                          <label for="exampleInputEmail1">Recurring</label>
                          <select class="form-control" name="recurring" required id="recurring" onchange="show_until(this.value)">
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
                      
                      <div class="col-12 col-lg-12 mt-2" id="until_box" style="display:none;">
                          <label for="exampleInputEmail1">Until Date <font style="color:red;">*</font></label>
                          <input class="form-control today_calendar" name="until" id="until">
                      </div>
                  </div>
                  
                  <br>
                  <a href="javascript:void(0)" data-id='0' class="" id="removeEvent" style="color:red; margin-top:20px; margin-bottom:20px; display:none;" onclick="removeEvent(this)"><i class="fa fa-trash"></i> Remove appointment</a>
                  <p class="alert alert-success" id="ass-success" style="display:none;"></p>
                  <p class="alert alert-danger" id="app_error" style="display:none;"></p>
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
                    h=("0" + h).slice(-2);
                }
                var strTime2 = h + ':' + m2;
              
                $("#edit").val('0');
                $("#title").val('');
                $("#contact").val('');
                $("#room").val('');
                $("#description").val('');
                $("#recurring").val('0');
                $("#reminder").val('0');
                $("#category").val('0');
              
                $("#date2").val(date+'-'+month+'-'+year);
              $('.calendar').daterangepicker({
        singleDatePicker: true,
        startDate: date+'-'+month+'-'+year,
        locale: {
            format: 'DD-MM-YYYY'
        }
    });
                $("#date").val(year+'-'+month+'-'+date);
                $("#time").val(strTime);
                $("#time_end").val(strTime2);
              
                $("#removeEvent").hide();
                $("#modal-title").text('New Appointment');
                $("#app_error").hide();
              
                //$("#add-appointment").modal('show');
                $("#add-appointment-btn").click();
              
                $("#attendees").val('');
                $("#attendees").select2();
              
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
                        $("#category").val(data.category);
                        $("#reminder").val(data.reminder);
                        $("#date").val(data.date);
                        $("#date2").val(data.date2);
                        $('.calendar').daterangepicker({
                            singleDatePicker: true,
                            startDate: data.date2,
                            locale: {
                                format: 'DD-MM-YYYY'
                            }
                        });
                        $("#time").val(data.time);
                        $("#time_end").val(data.time_end);
                        $("#recurring").val(data.recurring);
                        $("#removeEvent").attr('data-id', app_id);
                        $("#modal-title").text('Edit Appointment');
                        $("#removeEvent").show();
                        $("#add-appointment-btn").click();
                        $("#app_error").hide();
                        
                        if(data.parent=='0')
                        {
                            $("#until_box").show();
                            $("#recurring_box").show();
                                
                            $("#until").val(data.until);
                        }
                        else
                        {
                            $("#until_box").hide();
                            $("#recurring_box").hide();
                        }
                        
                        if(data.attendees!='')
                        {
                            var attendees=data.attendees.split(',');
                            $("#attendees").val(attendees);
                            $("#attendees").select2();
                        }
                        else
                        {
                            $("#attendees").val('');
                            $("#attendees").select2();
                        }
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
            dayRender: function (event) {
                //$(this).css("background-color", "red");
                //var dateString = event.date.format("YYYY-MM-DD");
                $(event.view[0]).find(".fc-day[data-date='2020-08-24']").css('background-color', '#FAA732');
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
                    $("#app_error").hide();
                },
                contentType: false,
                processData:false,
                success: function(data) { //alert(data);
                    //success
                    $("#submit_btn").attr('disabled', false);
                    // here we will handle errors and validation messages
                    if ( ! data.success) {
                        $("#app_error").text(data.error);
                        $("#app_error").show();
                    } else {
                        // ALL GOOD! just show the success message!
                        //alert(data.recurring); alert(data.days); alert(data.time2); alert(data.time_end2);
                        if(data.recurring!='0') window.location='';
                        else {
                        add_new_appointment(data);
                        $("#date").val('');
                        $("#time").val('');
                        $("#title").val('');
                        $("#category").val('0');
                        $("#add-appointment-close").click();
                        }
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
                        if(data.parent=='1') window.location='';
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
                            window.location='';
                        window.calendar.addEvent(
                        { // this object will be "parsed" into an Event Object
                            id: data.id,
                            title: data.title, // a property!
                            start: date.date+'T'+data.time+':00', // a property!
                            end: data.date+'T'+data.time_end+':00',
                            daysOfWeek: [0,1,2,3,4,5,6],
                            startTime: data.time2,
                            endTime: data.time_end2,
                            backgroundColor: data.color,
                            borderColor: data.color
                        }
                        );
                        }
                        else if(data.recurring!='0') {
                            window.location='';
                        window.calendar.addEvent(
                        { // this object will be "parsed" into an Event Object
                            id: data.id,
                            title: data.title, // a property!
                            start: data.date+'T'+data.time+':00', // a property!
                            end: data.date+'T'+data.time_end+':00',
                            daysOfWeek: [data.days],
                            startTime: data.time2,
                            endTime: data.time_end2,
                            backgroundColor: data.color,
                            borderColor: data.color
                        }
                        );
                        }
                        else{
                          window.calendar.addEvent(
                        { // this object will be "parsed" into an Event Object
                            id: data.id,
                            title: data.title, // a property!
                            start: data.date+'T'+data.time+':00', // a property!
                            end: data.date+'T'+data.time_end+':00',
                            backgroundColor: data.color,
                            borderColor: data.color
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

    $('.calendar').daterangepicker({
        singleDatePicker: true,
        startDate: new Date(),
        locale: {
            format: 'DD-MM-YYYY'
        }
    });
    </script>
