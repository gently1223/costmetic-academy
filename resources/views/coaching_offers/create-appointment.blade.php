<?php

include(app_path() . '/common/header.php');
$days_i = 0;
?>
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

                        <form class="" action="" method="post" id="app_form">
                            <?php echo csrf_field(); ?>
                            <input type="hidden" name="send" value="0" id="send">
                            <input type="hidden" name="offer_id" value="{{$offer_detail->id}}" id="offer_id">
                            <div id="form-box">
                                <div class="main-card mb-2 card">
                                    <div class="card-body">

                                        <div class="col-12" style="margin-bottom: 25px; padding-left: 0px; padding-right: 0px;">
                                            <div class="position-relative form-group">
                                                <label for="exampleEmail11" class=""><?php echo trans('forms.create_appointments_within') ?>: <b>{{ date('d-m-Y',strtotime($offer_detail->begin_date)) }} - {{ date('d-m-Y',strtotime($offer_detail->end_date)) }}</b></label><br/>
                                                <label for="exampleEmail11" class=""><?php echo trans('forms.min_appt_per_week') ?>: <b>{{ $offer_detail->min_appt_per_week }}</b></label><br/>
                                                <label for="exampleEmail11" class=""><?php echo trans('forms.min_ue_per_week') ?>: <b>{{ $offer_detail->min_ue_per_week }}</b></label><br/<
                                                <label for="exampleEmail11" class=""><?php echo trans('forms.notes') ?>: <b>{{ $offer_detail->notes }}</b></label><br/>

                                            </div>
                                            <!-- <div class="position-relative form-group">
                                                <label for="exampleEmail11" class="">Unterrichtsform</label>
                                                <select type="text" name="appointment_form" class="form-control select" required style="width: 100%;" id="appointment_form">
                                                    <option value="Please Select">Bitte auswählen</option>
                                                    <option value="Presence">Präsenzunterricht</option>
                                                    <option value="Digital">Digitalunterricht</option>
                                                    <option value="Self-Learning">Selbstlernheit</option>
                                                    <option value="Other">Andere form</option>
                                                </select>
                                            </div> -->

                                            <label for="exampleEmail11" class=""><?php echo trans('forms.available_products_modules') ?>:</label>
                                            <div id="treeview_container" class="hummingbird-treeview well h-scroll-large">
                                                <ul id="treeview-products-<?php echo $offer_detail->id; ?>" class="hummingbird-base">
                                                    <?php


                                                    if (!empty($products)) {
                                                        foreach ($products as $p) {
                                                            $p_id = $p['product']->id;
                                                    ?>
                                                            <li>
                                                                <i class="fa fa-plus"></i> <label><?php echo $p['product']->title . ' (' . trans('forms.lessons') . ': ' . $p['total_lessons'] . ')'; ?></label>

                                                                <ul>
                                                                    <?php
                                                                    if (!empty($p['modules'])) {
                                                                        foreach ($p['modules'] as $m) {
                                                                    ?>
                                                                            <li>
                                                                                <i class="fa fa-plus"></i> <label><?php echo $m['module']->title . ' (' . trans('forms.lessons') . ': ' . $m['total_lessons'] . ')'; ?></label>

                                                                                <ul>
                                                                                    <?php
                                                                                    if (!empty($m['module_items'])) {
                                                                                        foreach ($m['module_items'] as $item) {
                                                                                    ?>
                                                                                            <li>
                                                                                                <label>
                                                                                                    <!--<input type="checkbox" name="items<?php echo $p_id; ?>[]" value="<?php echo $item['item']->id; ?>" onchange="mi_selected(this, '<?php echo $offer_detail->id; ?>')">--> <?php echo $item['item']->title . ' (' . trans('forms.lessons') . ': ' . $item['item']->lessons . ')'; ?>
                                                                                                </label>
                                                                                            </li>
                                                                                    <?php }
                                                                                    } ?>
                                                                                </ul>
                                                                            </li>
                                                                    <?php }
                                                                    } ?>

                                                                </ul>
                                                            </li>
                                                    <?php }
                                                    } ?>
                                                </ul>
                                            </div>

                                        </div>
                                        @if($offer_detail->status == 0)
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th style="min-width: 200px;">Date</th>
                                                    <th style="min-width: 85px;">P/M/MI</th>
                                                    <th style="max-width: 40px;">UE</th>
                                                    <th style="max-width: 50px;">Break (minutes)</th>
                                                    <th>Start Time</th>
                                                    <th>Unterrichtsform</th>
                                                    <th>{{trans("forms.rooms")}}</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody id="contract-timetable-<?php echo $offer_detail->id; ?>">

                                            </tbody>
                                        </table>
                                        <!-- <p class="alert alert-warning" id="room-manual-warning">Note:
                                            Manually selected rooms will be booked, even when it is
                                            already booked in other Umschulung or Coaching</p> -->

                                        <a href="javascript:void(0)" class="add_new"><i class="fa fa-plus"></i> Add new</a><br>

                                        <div>
                                            <p class="alert alert-danger" id="course-error" style="display: none;"></p>
                                            <button class="mt-2 btn btn-primary save_app"><?php echo trans('forms.generate_appointments'); ?></button>
                                        </div>
                                        @endif
                                    </div>

                                </div>

                            </div>
                        </form>
                        <div class="card-body">
                        <form class="" method="post" id="edit_app_form">
                            <input type="hidden" name="offer_id" value="@if(count($appointments) > 0) {{$appointments[0]->offer_id}} @endif">
                            <table style="width: 100%;" id="example3" class="table table-hover table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Date</th>
                                        <th>Time</th>
                                        <th>Unterrichtsform</th>
                                        <th>Module Name > Module Item</th>
                                        <th>UE</th>
                                        <th>Raum</th>
                                        <!-- <th>Dozenten</th> -->
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php

                                    $send = 0;
                                    $edit_count = 0;
                                    if (!empty($appointments)) {
                                        $count = 1;
                                        $edit_status = 0;
                                        foreach ($appointments as $appointment) { ?>
                                            @if($appointment->status == 5)
                                               @php $edit_status=1 @endphp
                                                <tr id="app-<?php echo $appointment->id; ?>" style="background: red; color:#ffff;">
                                                <td style="width: 20px;">
                                                    <center>
                                                        @if($appointment->status == 5)
                                                           @php $edit_count++ @endphp
                                                            <input type="hidden" name="appointment_ids[]" value="{{$appointment->id}}">
                                                            <input type="checkbox" name="appointments[<?php echo $appointment->id; ?>]" class="check_appointments">
                                                        @endif
                                                    </center>
                                                </td>
                                                <td><?php echo date('d-m-Y', strtotime($appointment->date)); ?></td>
                                                <td><?php echo $appointment->time . ' - ' . $appointment->time_end; ?></td>
                                                <td><?php if ($appointment->appointment_form == 'Presence') echo 'Präsenz';
                                                    elseif ($appointment->appointment_form == 'Digital') echo 'Digital';
                                                    elseif ($appointment->appointment_form == 'Self-Learning') echo 'Selbstlernheit';
                                                    elseif ($appointment->appointment_form == 'Other') echo 'Andere';
                                                    else echo 'Unbekannt'; ?></td>
                                                <td><?php echo $appointment->title; ?></td>
                                                <td><?php echo $appointment->ue; ?></td>
                                                <td><?php echo $appointment->name; ?></td>
                                                <!-- <td><?php echo $appointment->dozents; ?></td> -->
                                                <td>

                                                    <?php
                                                    /*
                                                        * status = 0 = created
                                                        * status = 1 = accepted
                                                        * status = 2 = sent to admin
                                                        * status = 3 = Cancelled (appointment after acceptance)
                                                        * status = 4 = rejected
                                                        * status = 5 = changed thru admin
                                                    */
                                                    if ($offer_detail->status == 0) {
                                                        echo 'Erstellt'; //Draft/Created
                                                    } else {                                                       
                                                        if ($appointment->status == '1') {
                                                            echo '<span style="color:#3ac47d;"><i class="fa fa-check"></i> Akzeptiert</span>'; //Accepted
                                                        } else if ($appointment->status == '2') {
                                                            echo 'Wird geprüft'; //Sent
                                                        } else if ($appointment->status == '3') {
                                                            echo 'Storniert'; //Cancelled
                                                        } else if ($appointment->status == '4') {
                                                            echo 'Abgelehnt'; //Rejected
                                                        } else if ($appointment->status == '0') {
                                                            echo 'Wird geprüft'; 
                                                        } else if ($appointment->status == '5') {
                                                            echo 'Geändert'; 
                                                        }
                                                    }

                                                    ?>
                                                </td>
                                            </tr>
                                            @endif
                                    <?php $count++;
                                        } 
                                        if($edit_status == 0) {
                                        foreach ($appointments as $appointment) { ?>
                                            @if($appointment->status == 5)
                                                <tr id="app-<?php echo $appointment->id; ?>" style="background: red; color:#ffff;">
                                            @else
                                                <tr id="app-<?php echo $appointment->id; ?>">
                                            @endif    
                                                <td style="width: 20px;">
                                                    <center>
                                                        @if($appointment->status == 5)
                                                           @php $edit_count++ @endphp
                                                            <input type="hidden" name="appointment_ids[]" value="{{$appointment->id}}">
                                                            <input type="checkbox" name="appointments[<?php echo $appointment->id; ?>]" class="check_appointments">
                                                        @endif
                                                    </center>
                                                </td>
                                                <td><?php echo date('d-m-Y', strtotime($appointment->date)); ?></td>
                                                <td><?php echo $appointment->time . ' - ' . $appointment->time_end; ?></td>
                                                <td><?php if ($appointment->appointment_form == 'Presence') echo 'Präsenz';
                                                    elseif ($appointment->appointment_form == 'Digital') echo 'Digital';
                                                    elseif ($appointment->appointment_form == 'Self-Learning') echo 'Selbstlernheit';
                                                    elseif ($appointment->appointment_form == 'Other') echo 'Andere';
                                                    else echo 'Unbekannt'; ?></td>
                                                <td><?php echo $appointment->title; ?></td>
                                                <td><?php echo $appointment->ue; ?></td>
                                                <td><?php echo $appointment->name; ?></td>
                                                <!-- <td><?php echo $appointment->dozents; ?></td> -->
                                                <td>

                                                    <?php
                                                    /*
                                                        * status = 0 = created
                                                        * status = 1 = accepted
                                                        * status = 2 = sent to admin
                                                        * status = 3 = Cancelled (appointment after acceptance)
                                                        * status = 4 = rejected
                                                        * status = 5 = changed thru admin
                                                    */
                                                    if ($offer_detail->status == 0) {
                                                        echo 'Erstellt'; //Draft/Created
                                                        ?>&nbsp;
                                                        <a href="javascript:void(0)" data-id='<?php echo $appointment->id; ?>' class="" id="removeEvent" style="color:red; margin-top:20px; margin-bottom:20px;" onclick="removeEvent(this); $(this).parent().parent().remove();"><i class="fa fa-trash"></i></a>
                                                        <?php 
                                                    } else {                                                       
                                                        if ($appointment->status == '1') {
                                                            echo '<span style="color:#3ac47d;"><i class="fa fa-check"></i> Akzeptiert</span>'; //Accepted
                                                        } else if ($appointment->status == '2') {
                                                            echo 'Wird geprüft'; //Sent
                                                        } else if ($appointment->status == '3') {
                                                            echo 'Storniert'; //Cancelled
                                                        } else if ($appointment->status == '4') {
                                                            echo 'Abgelehnt'; //Rejected
                                                        } else if ($appointment->status == '0') {
                                                            echo 'Wird geprüft'; 
                                                        } else if ($appointment->status == '5') {
                                                            echo 'Geändert'; 
                                                        }
                                                    }

                                                    ?>
                                                   </td>
                                            </tr>
                                    <?php $count++;
                                        } }
                                    } ?>
                                </tbody>
                                <tfoot>
                                </tfoot>
                            </table>
                            @if($offer_detail->status == 0)
                                <p class="alert alert-danger" id="change-offer-error-one" style="display: none;"></p>
                                <button class="mt-2 btn btn-success save_all_appointment" type="button"><?php echo trans('forms.create_appointments'); ?></button>
                            @endif
                            @if($edit_count > 0)
                                <p class="alert alert-danger" id="change-offer-error" style="display: none;"></p>
                                <button class="mt-2 btn btn-success accept_all_appointment" type="button"><?php echo trans('forms.accept_appointments'); ?></button>
                            @endif
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
    $("#treeview-products-<?php echo $offer_detail->id; ?>").hummingbird();


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
                        // remove_appointment(data);
                        if(data.parent=='1') window.location='';
                    }
                },
                error: function()  {
                    //error
                } 	        
        });
        
    }
    
    function day_selected(th) {
        var days = $(th).val();
        var rooms_list = $(th).parent().parent().children('#rooms_column').children('#rooms_list');
        //var rooms_days=$(rooms_list).val();

        $(rooms_list + " option").each(function() {
            alert(this.text + ' ' + this.value);
        });
    }

    function mi_selected(th, c_id) {
        var mi = $(th).val();
        var old_mis = $("#mis-" + c_id).val();
        if (old_mis != '')
            var mis = old_mis.split(';');
        else var mis = [];

        if ($(th).is(':checked')) {
            //alert('mi checked');

            mis.push(mi);
            var new_mis = mis.join(';');
            $("#mis-" + c_id).val(new_mis);
        } else {
            //alert('mi unchecked');
            mis = $.grep(mis, function(value) {
                return value != mi;
            });
            var new_mis = mis.join(';');
            $("#mis-" + c_id).val(new_mis);
        }

    }

    $('.date_range').daterangepicker({
        startDate: new Date(),
        locale: {
            format: 'DD-MM-YYYY'
        }
    });

    function new_class(index) {
        var html_data = '';
        html_data += '<tr>';
        html_data += '<td style="max-width: 200px;"><input type="date" class="form-control today_calendar required" name="dates[]" required id="select_date_' + index + '" onchange="get_dynamic_rooms(' + index + ');" value="<?= $offer_detail->begin_date?>"></td>';
        html_data += '<td style="min-width: 85px;max-width: 250px;"><select name="items[]" class="form-control module_items" required id="module_item_' + index + '" onchange="get_lession_detail(' + index + ');"><option value="" disabled selected></option><?php foreach ($items as $key) { ?><option value="<?php echo $key->id ?>"><?php echo $key->title ?></option><?php } ?></select></td>';
        html_data += '<td style="min-width: 40px;max-width: 100px"><input type="number" class="form-control hours required" name="hours[]" min = "0" required id="hour_' + index + '" onblur="get_ue(' + index + ');get_dynamic_rooms(' + index + ');"></td>';
        html_data += '<td style="min-width: 40px;max-width: 100px"> <input type = "number" name = "breaks[]" class = "form-control break_time" min = "0" value = "0" id="break_' + index + '" onblur="get_dynamic_rooms(' + index + ');"></td>';
        html_data += '<td>' + get_timing(index) + '</td>';
        html_data += '<td>' + get_view_option(index) + '</td>';
        html_data += '<td>' + get_room_html(index) + '</td>';
        html_data += '<td><a href="javascript:void(0)" onclick = "$(this).parent().parent().remove();" > <i class = "fa fa-minus-circle" style = "color:red;" ></i></a ></td>';
        html_data += '</tr>';
        var id = "#contract-timetable-{{$offer_detail->id}}";
        $(id).append(html_data);
    }

    function get_view_option(index) {
        var select_option = '<select type="text" name="appointment_form[]" class="form-control appointment_form" required style="width: 100%;" id="appointment_form_' + index + '"><option value="Please Select">Bitte auswählen</option><option value="Presence">Präsenzunterricht</option><option value="Digital">Digitalunterricht</option><option value="Self-Learning">Selbstlernheit</option><option value="Other">Andere form</option></select>';
        return select_option;
    }

    function get_room_html(index) {
        var select_option = '<select type="text" name="rooms[]" class="form-control rooms" required style="width: 100%;" id="rooms_' + index + '"><option value="">Bitte auswählen</option></select>';
        return select_option;
    }

    function get_timing(index) {
        var drop_down = ' <select class="form-control start_time" name="start_time[]" id="start_time_' + index + '" style="padding-left:0px; padding-right:0px;" required onchange="get_dynamic_rooms(' + index + ');">';
        let num = '';
        for (let i = 0; i < 23; i++) {
            if (i < 10)
                num = '0' + i;
            else
                num = i;

            drop_down += '<option value=' + num + ':00>' + num + ':00</option>';
            drop_down += '<option value=' + num + ':15>' + num + ':15</option>';
            drop_down += '<option value=' + num + ':30>' + num + ':30</option>';
            drop_down += '<option value=' + num + ':45>' + num + ':45</option>';
        }
        drop_down += '</select>';
        return drop_down;
    }

    //date validation 
    $('body').on('change', '.today_calendar', function(e) {
        var select_date = $(this).val();
        select_date = new Date(select_date);
        var begin_date = "{{$offer_detail->begin_date}}";
        begin_date = new Date(begin_date);
        var end_date = "{{$offer_detail->end_date}}";
        end_date = new Date(end_date);
        if (select_date >= begin_date && select_date <= end_date) {
            $("#course-error").text("").css('display', 'none');
            return true;
        } else {
            $("#course-error").text("{{trans('forms.select_wrong_date')}}").css('display', 'block');
            // alert("{{trans('forms.select_wrong_date')}}");
            $(this).val("");
            return false;
        }
    });

    var count = 0;
    $(".add_new").on("click", function(e) {
        count++;
        new_class(count)
    })

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
                url: "{{route('contacts.get-rooms')}}",
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

    function get_lession_detail(id) {
        var item_id = $("#module_item_" + id).val();
        var offer_id = "{{$offer_detail->id}}";
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            url: "{{route('contacts.get-lession')}}",
            type: 'post',
            data: {
                offer_id: offer_id,
                item_id: item_id,

            },
            dataType: "json",
            success: function(data) {
                console.log(data);
                if (data.success) {
                    let count = $(".module_items").length;
                    if (count > 1) {
                        let total_hours = 0;
                        $(".module_item_id_" + item_id).each(function() {
                            let old_item_id = $(this).val();
                            total_hours += parseInt(old_item_id);
                        });
                        let lessions = data.detail.lessons;
                        let diff = parseInt(lessions) - parseInt(total_hours);
                        console.log(total_hours);
                        if (diff > 0) {
                            $("#hour_" + id).attr({
                                'min': 0,
                                "max": diff,
                                'module_item_id': item_id,
                                'disabled': false
                            });
                            $("#hour_" + id).addClass("module_item_id_" + item_id);
                        } else {
                            $("#hour_" + id).attr({
                                'min': 0,
                                "max": 0,
                                'module_item_id': item_id,
                                'disabled': true
                            });
                        }

                    } else {
                        $("#hour_" + id).addClass("module_item_id_" + item_id);
                        $("#hour_" + id).attr({
                            'min': 0,
                            "max": data.detail.lessons,
                            'module_item_id': item_id,
                            'disabled': false
                        });
                    }

                }
            }
        });
    }

    $(".save_app").on("click", function(e) {
        //get the action-url of the form
        var actionurl = "{{route('contacts.manage-appointment')}}";
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
                    location.reload();
                } else {
                    $("#course-error").html(data.message).css('display', 'block');
                    return false;
                }
            }
        });
        return false;
    });
    //check ue
    function get_ue(id) {
        var item_id = $("#module_item_" + id).val();
        var offer_id = "{{$offer_detail->id}}";
        var contact_id = "{{$offer_detail->coach_id}}";
        var max = $("#hour_" + id).attr('max');
        var hour = $("#hour_" + id).val();
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            url: "{{route('contacts.check-ue')}}",
            type: 'post',
            data: {
                item_id: item_id,
                offer_id: offer_id,
                contact_id: contact_id
            },
            dataType: "json",
            success: function(data) {
                if (data.success) {
                    let total_hours = parseInt(data.ue) + parseInt(hour);
                    console.log(max + ' ' + total_hours);
                    if (max < total_hours) {
                        $("#hour_" + id).val(0);
                        $("#course-error").text('<?php echo trans('forms.greater_ue_error'); ?>').css('display', 'block');
                    }
                }
            }
        });
    }
</script>
<script>
    $(".save_all_appointment").on("click", function() {
        let offer_id = "{{$offer_detail->id}}";
        Swal.fire({
            title: '<?php echo trans('forms.confirm_submit_appointments_title'); ?>',
            text: "<?php echo trans('forms.confirm_submit_appointments'); ?>",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3ac47d',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ja',
            cancelButtonText: 'Nein',
        }).then((result) => {
            if (result.isConfirmed) {
                $.LoadingOverlay("show");
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    url: "{{route('contacts.create-final-appointment')}}",
                    type: 'post',
                    data: {
                        offer_id: offer_id,
                    },
                    dataType: "json",
                    success: function(data) {
                        $.LoadingOverlay("hide");
                        if (data.success) {
                            Swal.fire(
                                '<?php echo trans('forms.appointments_submit_success_title'); ?>',
                                data.message,
                                'success'
                            )
                            setTimeout(function() {
                               location.reload()
                            }, 2000);
                        } else {
                            $("#change-offer-error-one").text(data.message).css('display', 'block');
                            return false;
                        }
                    }
                });

            }
        })
        return false;
    });
    $(".accept_all_appointment").on("click", function() {
        var actionurl = "{{route('contacts.accept-appointments')}}";
        $.LoadingOverlay("show");
        //do your own request an handle the results
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            url: actionurl,
            type: 'post',
            data: $("#edit_app_form").serialize(),
            dataType: "json",
            success: function(data) {
                $.LoadingOverlay("hide");
                if (data.success) {
                    Swal.fire(
                        '<?php echo trans('forms.accept_appointment_message'); ?>',
                        data.message,
                        'success'
                    )
                    setTimeout(function() {
                        location.reload()
                    }, 2000);
                } else {
                    $("#change-offer-error").text(data.message).css('display', 'block');
                    return false;
                }
            }
        });
        return false;
    });
</script>
<script>

</script>
<?php include(app_path() . '/common/footer.php'); ?>
<script src="https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@2.1.7/dist/loadingoverlay.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>