<?php
include(app_path() . '/common/panel/header.php');
$days_i = 0;
?>
<?php use App\Http\Controllers\admin\coaching_offers; ?>
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
                    <div class="nav-item-header text-primary nav-item">Dashboards
                        Examples</div>
                    <a class="dropdown-item active" href="analytics-dashboard.html">Analytics</a>
                    <a class="dropdown-item" href="management-dashboard.html">Management</a>
                    <a class="dropdown-item" href="advertisement-dashboard.html">Advertisement</a>
                    <a class="dropdown-item" href="index.html">Helpdesk</a> <a class="dropdown-item" href="monitoring-dashboard.html">Monitoring</a>
                    <a class="dropdown-item" href="crypto-dashboard.html">Cryptocurrency</a>
                    <a class="dropdown-item" href="pm-dashboard.html">Project
                        Management</a> <a class="dropdown-item" href="product-dashboard.html">Product</a> <a class="dropdown-item" href="statistics-dashboard.html">Statistics</a>
                </div>
            </div>
        </div>
        <div class="app-inner-layout__content pt-0">
            <div class="tab-content">
                <div class="container-fluid">
                    <div class="card mb-3">
                        <?php if (Session::has('error')) { ?>
                            <p class="alert alert-danger"><?php echo Session::get('error'); ?></p>
                        <?php } ?>
                        <?php if (Session::has('success')) { ?>
                            <p class="alert alert-success"><?php echo Session::get('success'); ?></p>
                        <?php } ?>

                        <div class="card-body">
                            <form class="" method="post" id="app_form">
                                <input type="hidden" name="offer_id" value="{{trim($appointments[0]->offer_id)}}" class="offer_id">
                                <table style="width: 100%;" id="example3" class="table table-hover table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th style="white-space: nowrap;">Start Time</th>
                                            <th style="white-space: nowrap;">BreakTime</th>
                                            <th>Unterrichtsform</th>
                                            <th>Module Name > Module Item</th>
                                            <th>Room</th>
                                            <th>Dozenten</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php

                                        $send = 0;
                                        if (count($appointments) > 0) {
                                            foreach ($appointments as $appointment) { ?>
                                                <tr id="app-<?php echo $appointment->id; ?>">
                                                    <input type="hidden" name="appointment_ids[]" value="{{$appointment->id}}">
                                                    <input type="hidden" name="hours[]" value="{{$appointment->ue}}" id="hour_{{$appointment->id}}">
                                                    <td><input type="date" name="dates[]" value="{{$appointment->date}}" class="form-control date_{{$appointment->id}}" onchange="return change_date_time({{$appointment->id}});" id="select_date_{{$appointment->id}}"></td>

                                                    <td><select class="form-control start_time_{{$appointment->id}}" name="start_time[]" id="start_time_{{$appointment->id}}" style="padding-left:0px; padding-right:0px;" required onchange="return change_date_time({{$appointment->id}}); get_dynamic_rooms({{$appointment->id}});">
                                                    @for($i=0;$i<'23';$i++)
                                                    @if ($i < 10)
                                                        @php $num = '0'.$i; @endphp
                                                    @else
                                                       @php $num = $i; @endphp
                                                    @endif 
                                                    @php 
                                                    $check_num = $num.':00'; 
                                                    $check_num1 = $num.':15';
                                                    $check_num2 = $num.':30';
                                                    $check_num3 = $num.':45';
                                                    @endphp
                                                    @if(trim($appointment->time) == $check_num)
                                                        @php $selecetd = 'selected'; 
                                                             $selecetd1 = ''; 
                                                             $selecetd2 = ''; 
                                                             $selecetd3 = ''; 
                                                        @endphp
                                                    @elseif(trim($appointment->time) == $check_num1)
                                                        @php $selecetd = ''; 
                                                             $selecetd1 = 'selected'; 
                                                             $selecetd2 = ''; 
                                                             $selecetd3 = ''; 
                                                        @endphp
                                                    @elseif(trim($appointment->time) == $check_num2)
                                                        @php $selecetd = ''; 
                                                             $selecetd1 = ''; 
                                                             $selecetd2 = 'selected'; 
                                                             $selecetd3 = ''; 
                                                        @endphp
                                                    @elseif(trim($appointment->time) == $check_num3)
                                                        @php $selecetd = ''; 
                                                             $selecetd1 = ''; 
                                                             $selecetd2 = ''; 
                                                             $selecetd3 = 'selected'; 
                                                        @endphp  
                                                    @else
                                                        @php $selecetd = ''; 
                                                             $selecetd1 = ''; 
                                                             $selecetd2 = ''; 
                                                             $selecetd3 = ''; 
                                                        @endphp   
                                                    @endif     
                                                    <option value='{{$num}}:00' {{$selecetd}}>{{$check_num}}</option>
                                                    <option value='{{$num}}:15' {{$selecetd1}}>{{$num}}:15</option>
                                                    <option value='{{$num}}:30' {{$selecetd2}}>{{$num}}:30</option>
                                                    <option value='{{$num}}:45' {{$selecetd3}}>{{$num}}:45</option> 
                                                    @endfor
                                                    </select>
                                                    </td>
                                                    <td><input type="number" name="breaktime[]" class="form-control " value="{{$appointment->breaktime}}" required id="break_{{$appointment->id}}" onblur="get_dynamic_rooms({{$appointment->id}});"></td>
                                                    <!-- <td><select class="form-control end_time_{{$appointment->id}}" name="end_time[]" id="start_time" style="padding-left:0px; padding-right:0px;" required onchange="return change_date_time({{$appointment->id}});">
                                                    @for($i=0;$i<'23';$i++)
                                                    @if ($i < 10)
                                                        @php $num = '0'.$i; @endphp
                                                    @else
                                                       @php $num = $i; @endphp
                                                    @endif 
                                                    @php 
                                                    $check_num = $num.':00'; 
                                                    $check_num1 = $num.':15';
                                                    $check_num2 = $num.':30';
                                                    $check_num3 = $num.':45';
                                                    @endphp
                                                    @if(trim($appointment->time_end) == $check_num)
                                                        @php $selecetd = 'selected'; 
                                                             $selecetd1 = ''; 
                                                             $selecetd2 = ''; 
                                                             $selecetd3 = ''; 
                                                        @endphp
                                                    @elseif(trim($appointment->time_end) == $check_num1)
                                                        @php $selecetd = ''; 
                                                             $selecetd1 = 'selected'; 
                                                             $selecetd2 = ''; 
                                                             $selecetd3 = ''; 
                                                        @endphp
                                                    @elseif(trim($appointment->time_end) == $check_num2)
                                                        @php $selecetd = ''; 
                                                             $selecetd1 = ''; 
                                                             $selecetd2 = 'selected'; 
                                                             $selecetd3 = ''; 
                                                        @endphp
                                                    @elseif(trim($appointment->time_end) == $check_num3)
                                                        @php $selecetd = ''; 
                                                             $selecetd1 = ''; 
                                                             $selecetd2 = ''; 
                                                             $selecetd3 = 'selected'; 
                                                        @endphp  
                                                    @else
                                                        @php $selecetd = ''; 
                                                             $selecetd1 = ''; 
                                                             $selecetd2 = ''; 
                                                             $selecetd3 = ''; 
                                                        @endphp   
                                                    @endif     
                                                    <option value='{{$num}}:00' {{$selecetd}}>{{$check_num}}</option>
                                                    <option value='{{$num}}:15' {{$selecetd1}}>{{$num}}:15</option>
                                                    <option value='{{$num}}:30' {{$selecetd2}}>{{$num}}:30</option>
                                                    <option value='{{$num}}:45' {{$selecetd3}}>{{$num}}:45</option> 
                                                    @endfor
                                                    </select>
                                                   </td> -->
                                                    <td>
                                                        <select type="text" name="appointment_form[]" class="form-control appointment_form" required style="width: 100%;" id="appointment_form__{{$appointment->id}}">
                                                        <option value="" >Bitte auswählen</option>
                                                        <option value="Presence" @if($appointment->appointment_form == 'Presence')  selected @endif>Präsenzunterricht</option>
                                                        <option value="Digital" @if($appointment->appointment_form == 'Digital')  selected @endif>Digitalunterricht</option>
                                                        <option value="Self-Learning" @if($appointment->appointment_form == 'Self-Learning')  selected @endif>Selbstlernheit</option>
                                                        <option value="Other" @if($appointment->appointment_form == 'Other')  selected @endif>Andere form</option>
                                                        </select>
                                                    </td>
                                                    <td><?php echo $appointment->title; ?></td>
                                                    <td>
                                                        <select type="text" name="rooms[]" class="form-control rooms" required style="width: 100%;" id="rooms_{{$appointment->id}}">
                                                          <?php echo coaching_offers::get_rooms_detail($appointment->date,$appointment->ue,$appointment->breaktime,$appointment->time,$appointment->room); ?>
                                                        </select>
                                                    </td>
                                                    <td><?php echo $appointment->c_name; ?></td>
                                                </tr>
                                        <?php }
                                        } ?>
                                    </tbody>
                                    <tfoot>
                                    </tfoot>
                                </table>
                                <div>
                                    <p class="alert alert-danger" id="course-error" style="display: none;"></p>
                                    <button class="mt-2 btn btn-success update_appointment" type="button"><?php echo trans('forms.update_appointments'); ?></button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<script>
    $(".update_appointment").on("click", function(e) {
        //get the action-url of the form
        var actionurl = "{{route('admin.save-appointment')}}";
        var offer_id = $(".offer_id").val();
        var url = "{{url('admin/view-appointments')}}/"+offer_id;
        $.LoadingOverlay("show");
        //do your own request an handle the results
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            url: actionurl,
            type: 'post',
            data: $("#app_form").serialize(),
            dataType: "json",
            success: function(data) {
                $.LoadingOverlay("hide");
                if (data.success) {
                    alert(data.message);
                    window.location.href = url;
                } else {
                    //console.log("inside data.success else");
                    $("#course-error").text(data.message).css('display', 'block');
                    return false;
                }
            }
        });
        return false;
    });

    $("#checkAll").change(function () {
        $("input:checkbox").prop('checked', $(this).prop("checked"));
    });
    function change_date_time(i) {
        get_dynamic_rooms(i);
        var app_date = $(".date_"+i).val();
        var start_time = $(".start_time_" + i).val();
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            url: "{{route('admin.check-appointment')}}",
            type: 'post',
            data: {app_date : app_date, start_time : start_time, id : i},
            dataType: "json",
            success: function(data) {
                $.LoadingOverlay("hide");
                if (data.success) {
                    $(".update_appointment").attr('disabled',false);
                    $("#course-error").text(data.message).css('display', 'none');
                } else {
                    $(".update_appointment").attr('disabled',true);
                    $("#course-error").text(data.message).css('display', 'block');
                    return false;
                }
            }
        });
        return false;
    }

     //get dynamic rooms detail
     function get_dynamic_rooms(id) {
        var selected_date = $("#select_date_" + id).val();
        var hour = $("#hour_" + id).val();
        var break_time = $("#break_" + id).val();
        var start_time = $("#start_time_" + id).val();
        console.log("selected date" + selected_date);
        console.log("hour" + hour);
        console.log("break_time" + break_time);
        console.log("start_time" + start_time);
        if (selected_date != '' && hour > 0 && break_time >= 0 && start_time != '') {
            //do your own request an handle the results
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                url: "{{route('admin.get-rooms')}}",
                type: 'post',
                data: {
                    selected_date: selected_date,
                    hour: hour,
                    break_time: break_time,
                    start_time: start_time
                },
                dataType: "json",
                success: function(data) {
                    console.log(data);
                    if (data.success) {
                        $("#rooms_" + id).html(data.rooms);
                        $("#course-error").text("").css('display', 'none');
                    } else {
                        $("#course-error").text(data.message).css('display', 'block');
                        return false;
                    }
                }
            });
        }
    }
</script>
<?php include(app_path() . '/common/panel/footer.php'); ?>
<script src="https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@2.1.7/dist/loadingoverlay.min.js"></script>