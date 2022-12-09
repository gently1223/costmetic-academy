<?php
$app_page='active'; //echo $appointments; exit();
include(app_path().'/common/panel/header.php'); ?>
<input type="hidden" name="appointments" id="appointments" value='[]'>
<style>
    #block2{
        display: none;
    }
    
    @media only screen and (max-width:600px)
    {
        #block2{
            display: block;
        }
    }
</style>

<a href="javascript:void(0)" onclick="exit_full_screen();" style="position:absolute; top:0px; right:35px; z-index:900;"><button class="btn btn-primary" style="padding-top:3px; padding-bottom:3px;">Stäng Helskärm</button></a>

    <link href='fullcalendar/core/main.css' rel='stylesheet' />
    <link href='fullcalendar/daygrid/main.css' rel='stylesheet' />
    <link href='fullcalendar/timegrid/main.css' rel='stylesheet' />

    <script src='fullcalendar/core/main.js'></script>
    <script src='fullcalendar/daygrid/main.js'></script>
    <script src='fullcalendar/timegrid/main.js'></script>
    <script src='fullcalendar/interaction/main.js'></script>

  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <?php include(app_path().'/admin/common/left_menu.php'); ?>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-calendar"></i> Möten
          
          <select name="office" class="" required onchange="window.location='?o='+this.value">
                                  <option value="0">Alla Kontor</option>
                                  <?php 
                                  if(!empty($offices)) {
                                      foreach($offices as $office) {
                                  ?>
                                  <option value="<?php echo $office->id; ?>" <?php if(isset($def_office) AND $def_office==$office->id) echo 'selected'; ?> ><?php echo $office->name; ?></option>
                                  <?php } } ?>
                              </select>
          
          <div id="block2"></div><a href="javascript:void(0)" onclick="full_screen();"><button class="btn btn-primary" style="padding-top:6px; padding-bottom:6px;"><i class="fa fa-arrows-alt"></i> Helskärm</button></a>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo url('dashboard'); ?>"><i class="fa fa-dashboard"></i> Hem</a></li>
        <li><a href="<?php echo url('appointments'); ?>">Möten</a></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <!--<div class="box-header">
              <h3 class="box-title"></h3>
            </div>-->
            <!-- /.box-header -->

            <div class="box-body">
                <div id='calendar'></div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

<div class="modal fade" id="add-appointment" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
          <div class="modal-dialog">
            <div class="modal-content">
                <form action="" method="post" id="add-appointment-form">
                    <input type="hidden" name="edit" value="0" id="edit">
                    <?php echo csrf_field(); ?>
              <div class="modal-header">
                  <h3 class="modal-title" id="modal-title">Nytt Möte</h3>
              </div>
              <div class="modal-body">
                  <p class="alert alert-success" id="ass-success" style="display:none;"></p>
                  <div class="row">
                      <div class="col-12 col-lg-6">
                          <div class="form-group">
                            <label for="exampleInputEmail1">Person<font style="color:red;">*</font></label>
                              <select name="title" id="title" class="form-control" required>
                                  <option value="">Vänligen välj</option>
                                  <?php 
                                  if(!empty($staff_users)) {
                                      foreach($staff_users as $staff) {
                                  ?>
                                  <option value="<?php echo $staff['user']->id; ?>"><?php echo $staff['user']->name; ?></option>
                                  <?php } } ?>
                              </select>
                          </div>
                      </div>
                      <div class="col-12 col-lg-6">
                          <div class="form-group">
                            <label for="exampleInputEmail1">Kontor<font style="color:red;">*</font></label>
                              <select name="office" id="office" class="form-control" required>
                                  <option value="">Vänligen välj</option>
                                  <?php 
                                  if(!empty($offices)) {
                                      foreach($offices as $office) {
                                  ?>
                                  <option value="<?php echo $office->id; ?>" <?php if(isset($def_office) AND $def_office==$office->id) echo 'selected'; ?> ><?php echo $office->name; ?></option>
                                  <?php } } ?>
                              </select>
                          </div>
                      </div>
                  </div>
                  
                  <div class="row">
                      <div class="col-12 col-lg-6">
                          <div class="form-group">
                            <label for="exampleInputEmail1">Datum<font style="color:red;">*</font></label>
                            
                              <div class="input-group">
                                    <input type="text" class="form-control" id="date" placeholder="" required name="date" readonly>
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                </div>
                          </div>
                      </div>
                      
                      <div class="col-12 col-lg-6">
                          
                          <div class="bootstrap-timepicker">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Tid<font style="color:red;">*</font></label>
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
                          <label for="exampleInputEmail1">Återkommande Möten<font style="color:red;">*</font></label>
                          <select class="form-control" name="recurring" required id="recurring">
                              <option value="0">Inte återkommande</option>
                              <option value="Everyday">Varje dag</option>
                              <option value="Monday">Varje Måndag</option>
                              <option value="Tuesday">Varje Tisdag</option>
                              <option value="Wednesday">Varje Onsdag</option>
                              <option value="Thursday">Varje Torsdag</option>
                              <option value="Friday">Varje Fredag</option>
                              <option value="Saturday">Varje Lördag</option>
                              <option value="Sunday">Varje Söndag</option>
                          </select>
                      </div>
                  </div>
                  <br>
                  <a href="javascript:void(0)" data-id='0' class="" id="removeEvent" style="color:red; margin-top:20px; margin-bottom:20px; display:none;" onclick="removeEvent(this)"><i class="fa fa-trash"></i> Ta bort Möte</a>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default pull-right" data-dismiss="modal">Stäng</button>
                <button type="submit" class="btn btn-primary pull-right" style="margin-right:10px;" id="submit_btn">Lägg till</button>
              </div>
                  </form>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
<?php include(app_path().'/common/panel/footer.php');
?>

<script src="https://js.pusher.com/5.0/pusher.min.js"></script>
<script>
    window.calendar;

      document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
          var events=$("#appointments").val(); //alert(events);
          events=$.parseJSON(events);

        window.calendar = new FullCalendar.Calendar(calendarEl, {
          plugins: [ 'interaction', 'dayGrid', 'timeGrid' ],
          defaultView: 'timeGridWeek',
          allDaySlot: false,
            locale: 'sv',
          firstDay: 1,
            height: 850,
            weekNumbers: true,
            weekLabel: 'V',
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
                $("div.fc-left button.fc-today-button").text('Idag');
                $("div.fc-right button.fc-dayGridMonth-button").text('Månad');
                $("div.fc-right button.fc-timeGridWeek-button").text('Vecka');
                $("div.fc-right button.fc-timeGridDay-button").text('Dag');
                
      if (info.view.type == 'timeGridWeek')
      {
          $("div.fc-center h2").append(" (Vecka " + getWeekNumber(info.view.activeStart)+ ")");
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
                $("#office").val('<?php echo $def_office; ?>');
                $("#recurring").val('0');
              
                $("#date").val(year+'-'+month+'-'+date);
                $("#time").val(strTime);
                $("#time_end").val(strTime2);
              
                $("#removeEvent").hide();
                $("#modal-title").text('Nytt Möte');
                $("#add-appointment").modal('show');
              
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
                        $("#edit").val(app_id);
                        $("#title").val(data.title);
                        $("#office").val(data.office);
                        $("#date").val(data.date);
                        $("#time").val(data.time);
                        $("#time_end").val(data.time_end);
                        $("#recurring").val(data.recurring);
                        $("#removeEvent").attr('data-id', app_id);
                        $("#modal-title").text('Redigera Möte');
                        $("#removeEvent").show();
                        $("#add-appointment").modal('show');
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
                url: "<?php echo url('create-appointment') ?>",
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
                        
                        $("#date").val('');
                        $("#time").val('');
                        $("#title").val('');
                        $("#add-appointment").modal('hide');
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
                url: "<?php echo url('remove-appointment') ?>",
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
                        
                    }
                },
                error: function()  {
                    //error
                } 	        
        });
        
    }
    
    
      function add_new_appointment(data)
      {
          data=data.email;
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
        data=data.email;
        
        var event=window.calendar.getEventById(data.id);
        event.remove();
        
        $("#add-appointment").modal('hide');
    }

    // Enable pusher logging - don't include this in production
    Pusher.logToConsole = true;

    var pusher = new Pusher('c63c82af9f645512e01d', {
      cluster: 'ap2',
      forceTLS: true
    });

    var channel = pusher.subscribe('appointment-channel');
    channel.bind('new-appointment', function(data) {
        //alert(JSON.stringify(data));
        //alert('hi');
        add_new_appointment(data);
    });
    
    channel.bind('remove-appointment', function(data) {
        //alert(JSON.stringify(data));
        //alert('hi');
        remove_appointment(data);
    });
      
      channel.bind('pusher:subscription_succeeded', function(members) {
        //alert('successfully subscribed!');
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
